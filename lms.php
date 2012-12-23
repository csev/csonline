<?php
header('Content-Type: text/html; charset=utf-8');
require_once("start.php");
require_once("sqlutil.php");
require_once("db.php");

if ( isset($_SESSION['id']) === false || isset($_GET['id']) === false ) {
    header('Location: login.php');
    return;
}

$course_id = $_GET['id'] + 0;

$sql = 'SELECT Courses.id, code, title, description, 
    image, start_at, close_at, duration,
    bypass, endpoint, consumer_key, consumer_secret, 
    Enrollments.id, role, grade, fame, fame_at, token
    FROM Courses JOIN Enrollments 
    ON Courses.id = course_id 
    WHERE Enrollments.user_id = '.$_SESSION['id'].'
    AND Courses.id = '.$course_id;

$row = retrieve_one_row($sql);
if ( $row === FALSE ) {
    echo("Unable to retrieve course info ...");
    return;
}

$start_at = false;
if ( strlen($row[5]) > 8 ) $start_at = strtotime($row[5]);

if ( $start_at !== false && start_time() < $start_at ) {
    echo("This course has not yet started...");
    return;
}

if ( $row[12] < 1 || $row[13] < 1 ) {
    echo("You are not enrolled in this course...");
    return;
}

?>
<html>
<head>
  <title>Launching to Moodle....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="font-family:sans-serif;">
<?php

require_once("util/lti_util.php");

    $cur_url = curPageURL();

    $lmsdata = array(
      "resource_link_id" => $row[0],
      "resource_link_title" => $row[1],
      "resource_link_description" => $row[2],
      "user_id" => $_SESSION['id'],
      "roles" => $row[13] > '1' ? "Instructor" : "Learner",
      "lis_person_name_given" => $_SESSION['first'] ,
      "lis_person_name_family" => $_SESSION['last'],
      "lis_person_contact_email_primary" => $_SESSION['email'],
      "context_id" => $row[0],
      "context_label" => $row[1],
      "context_title" => $row[2],
      "tool_consumer_info_product_family_code" => "online.dr-chuck.com",
      "tool_consumer_info_version" => "1.1",
      "tool_consumer_instance_guid" => "online.dr-chuck.com",
      "tool_consumer_instance_description" => "Dr. Chuck Online (LMSng)"
      // 'launch_presentation_return_url' => $cur_url
      );

  if ( isset($row[17]) && strlen($row[17]) > 1 ) {
    $token = $row[17];
  } else {
    $bytes = openssl_random_pseudo_bytes(50, $cstrong);
    $token   = bin2hex($bytes);
    $sql = "UPDATE Enrollments SET token='$token' WHERE id=".$row[12];
    // Will log an error
    $result = run_mysql_query($sql);
  }

  $lmsdata["lis_result_sourcedid"] = $row[0] . ':' . $row[12] . ':' . $token;
  $lmsdata["lis_outcome_service_url"] = $CFG->wwwroot . '/services/outcomes.php';

  if ( isset($_SESSION['avatar']) ) $lmsdata['user_image'] = $_SESSION["avatar"];

  $tool_consumer_instance_guid = $row[10];
  $tool_consumer_instance_description = $row[10];

  $parms = $lmsdata;
  // Cleanup parms before we sign
  foreach( $parms as $k => $val ) {
    if (strlen(trim($parms[$k]) ) < 1 ) {
       unset($parms[$k]);
    }
  }

  // Add oauth_callback to be compliant with the 1.0A spec
  $parms["oauth_callback"] = "about:blank";
    
  $parms = signParameters($parms, $row[9], "POST", $row[10], $row[11], 
        "Press to Launch", $tool_consumer_instance_guid, $tool_consumer_instance_description);

  $content = postLaunchHTML($parms, $row[9], isset($_GET['debug']) );
  print($content);

?>
