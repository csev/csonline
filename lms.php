<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

if ( ! isset($_SESSION['id']) ) {
        header('Location: login.php');
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
      "resource_link_id" => "120988f929-274612",
      "resource_link_title" => "Weekly Blog",
      "resource_link_description" => "A weekly blog.",
      "user_id" => $_SESSION['id'],
      "roles" => "Learner",  // or Learner
      "lis_person_name_given" => $_SESSION['first'] ,
      "lis_person_name_family" => $_SESSION['last'],
      "lis_person_contact_email_primary" => $_SESSION['email'],
      "context_id" => "456434513",
      "context_title" => "Python Playground",
      "context_label" => "DCO142",
      "tool_consumer_info_product_family_code" => "dr-chuck.com",
      "tool_consumer_info_version" => "1.1",
      "tool_consumer_instance_guid" => "online.dr-chuck.com",
      "tool_consumer_instance_description" => "Dr. Chuck Online (LMSng)",
      // 'launch_presentation_return_url' => $cur_url
      );

  if ( isset($_SESSION['avatar']) ) $lmsdata['user_image'] = $_SESSION["avatar"];

  foreach ($lmsdata as $k => $val ) {
      if ( $_POST[$k] && strlen($_POST[$k]) > 0 ) {
          $lmsdata[$k] = $_POST[$k];
      }
  }

  $key = "online.dr-chuck.com";
  $secret = "19869a2f92b8e1f965deadc32850742d";
  $endpoint = "http://moodle.dr-chuck.com/moodle/local/ltiprovider/tool.php?id=3";

  $b64 = base64_encode($key.":::".$secret);
  $outcomes = trim($_REQUEST["outcomes"]);
  if ( ! $outcomes ) {
      $outcomes = str_replace("lms.php","common/tool_consumer_outcome.php",$cur_url);
      $outcomes .= "?b64=" . htmlentities($b64);
  }

  $tool_consumer_instance_guid = $lmsdata['tool_consumer_instance_guid'];
  $tool_consumer_instance_description = $lmsdata['tool_consumer_instance_description'];

  $parms = $lmsdata;
  // Cleanup parms before we sign
  foreach( $parms as $k => $val ) {
    if (strlen(trim($parms[$k]) ) < 1 ) {
       unset($parms[$k]);
    }
  }

  // Add oauth_callback to be compliant with the 1.0A spec
  $parms["oauth_callback"] = "about:blank";
  if ( $outcomes ) {
    $parms["lis_outcome_service_url"] = $outcomes;
    $parms["lis_result_sourcedid"] = "feb-123-456-2929::28883";
  }
    
  $parms = signParameters($parms, $endpoint, "POST", $key, $secret, 
"Press to Launch", $tool_consumer_instance_guid, $tool_consumer_instance_description);

  $content = postLaunchHTML($parms, $endpoint, isset($_GET['debug']) );
  print($content);

?>
