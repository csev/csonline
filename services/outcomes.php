<?php

$old_error_handler = set_error_handler("myErrorHandler");

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if ( strpos($errstr, 'deprecated') !== false ) return true;
    return false;
}

require_once("../util/lti_util.php");

// For my application, We only allow application/xml
$request_headers = OAuthUtil::get_headers();
$hct = $request_headers['Content-Type'];
if ( ! isset($hct) ) $hct = $request_headers['Content-type'];
if (strpos($hct,'application/xml') === false ) {
   header('Content-Type: text/plain');
   // print_r($request_headers);
   die("Must be content type xml, found ".$hct);
}

header('Content-Type: application/xml; charset=utf-8'); 

// Get skeleton response
$response = getPOXResponse();

$postdata = file_get_contents('php://input');
try {
    $xml = new SimpleXMLElement($postdata);
    $imsx_header = $xml->imsx_POXHeader->children();
    $parms = $imsx_header->children();
    $message_ref = (string) $parms->imsx_messageIdentifier;

    $imsx_body = $xml->imsx_POXBody->children();
    $operation = $imsx_body->getName();
    $parms = $imsx_body->children();
    $sourcedid = (string) $parms->resultRecord->sourcedGUID->sourcedId;
} catch (Exception $e) {
    $retval = sprintf($response,uniqid(),'failure', $e->getMessage());
    echo($retval);
    return;
}

if ( !isset($sourcedid) && strlen($sourcedid) > 0 ) {
   echo(sprintf($response,uniqid(),'failure', "Missing required lis_result_sourcedid",$message_ref,""));
   return;
}

$pieces = explode(':',$sourcedid);
$course_id = count($pieces) == 3 ? $pieces[0]+0 : false;
$enrollment_id = count($pieces) == 3 ? $pieces[1]+0 : false;
$enrollment_token = count($pieces) == 3 ? $pieces[2] : false;
if ( $course_id < 1 ) $course_id = false;
if ( $enrollment_id < 1 ) $enrollment_id = false;

if ( $course_id === false || $enrollment_id === false || $enrollment_token === false ) {
   echo(sprintf($response,uniqid(),'failure', "Bad format for lis_result_sourcedid",$message_ref,""));
   return;
}

require_once("../db.php");
require_once("../sqlutil.php");

$enrollment_token = mysql_real_escape_string($enrollment_token);
$sql = "SELECT token, consumer_key, consumer_secret FROM
    Enrollments JOIN Courses 
    ON Enrollments.course_id = Courses.id
    WHERE Courses.id = $course_id AND Enrollments.id = $enrollment_id
    AND Enrollments.token = '$enrollment_token'";
$row = retrieve_one_row($sql);

if ( $row === false ) {
   echo(sprintf($response,uniqid(),'failure', "Illegal lis_result_sourcedid",$message_ref,""));
   return;
}

$oauth_consumer_key = $row[1];
$oauth_consumer_secret = $row[2];

$header_key = getOAuthKeyFromHeaders();

if ( $header_key != $oauth_consumer_key ) {
   echo(sprintf($response,uniqid(),'failure', "key=$oauth_consumer_key HDR=$header_key",$message_ref,""));
   exit();
}

try {
    $body = handleOAuthBodyPOST($oauth_consumer_key, $oauth_consumer_secret, $postdata);
} catch (Exception $e) {
    global $LastOAuthBodyBaseString;
	global $LastOAuthBodyHashInfo;
    $retval = sprintf($response,uniqid(),'failure', $e->getMessage().
        " key=$oauth_consumer_key HDRkey=$header_key",uniqid(),"") .
        "<!--\n".
        "Base String:\n".$LastOAuthBodyBaseString."\n".
		"Hash Info:\n".$LastOAuthBodyHashInfo."\n-->\n";
    echo($retval);
    return;
}

$top_tag = str_replace("Request","Response",$operation);
$body_tag = "\n<".$top_tag."/>";
if ( $operation == "replaceResultRequest" ) {
    $score =  (string) $parms->resultRecord->result->resultScore->textString;
    $fscore = (float) $score;
    if ( ! is_numeric($score) ) {
        echo(sprintf($response,uniqid(),'failure', "Score must be numeric",$message_ref,$body_tag));
        return;
    }
    $fscore = (float) $score;
    if ( $fscore < 0.0 || $fscore > 1.0 ) {
        echo(sprintf($response,uniqid(),'failure', "Score not between 0.0 and 1.0",$message_ref,$body_tag));
        return;
    }
    $sql = "UPDATE Enrollments SET grade='$score' WHERE id=$enrollment_id";
    $result = run_mysql_query($sql);
    if ( $result == false ) {
        echo(sprintf($response,uniqid(),'failure', "Could not update score ",$message_ref,$body_tag));
        return;
    }
    error_log('Outcome: '.$sql);
    echo(sprintf($response,uniqid(),'success', "Score for $sourcedid is now $score",$message_ref,$body_tag));
} else if ( $operation == "readResultRequest" ) {
    $sql = "SELECT grade from Enrollments WHERE id=$enrollment_id";
    $row = retrieve_one_row($sql);
    if ( $row === false ) {
        echo(sprintf($response,uniqid(),'failure', "Could not retrieve score ",$message_ref,$body_tag));
        return;
    }
    $score =  $row[0];
    $body = '
    <readResultResponse>
      <result>
        <resultScore>
          <language>en</language>
          <textString>%s</textString>
        </resultScore>
      </result>
    </readResultResponse>';
    $body = sprintf($body,$score);
    echo(sprintf($response,uniqid(),'success', "Score read successfully",$message_ref,$body));
} else if ( $operation == "deleteResultRequest" ) {
    $sql = "UPDATE Enrollments SET grade=NULL WHERE id=$enrollment_id";
    $result = run_mysql_query($sql);
    if ( $result == false ) {
        echo(sprintf($response,uniqid(),'failure', "Could not delete score ",$message_ref,$body_tag));
        return;
    }
    echo(sprintf($response,uniqid(),'success', "Score deleted",$message_ref,$body_tag));
} else {
    echo(sprintf($response,uniqid(),'unsupported', "Operation not supported - $operation",$message_ref,""));
}
?>
