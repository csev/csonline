<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

if ( ! isset($_SESSION['id']) ) {
        header('Location: login.php');
        return;
}

require_once("data.php");

if ( isset($_GET['context_id']) && isset($COURSE_LIST[$_GET['context_id']]) ) {
    $courseinfo = $COURSE_LIST[$_GET['context_id']];
    $key = $courseinfo['key'];
    $secret = $courseinfo['secret'];
    $endpoint = $courseinfo['endpoint'];
} else {
    echo("Missing context_id");
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
    
  $parms = signParameters($parms, $endpoint, "POST", $key, $secret, 
        "Press to Launch", $tool_consumer_instance_guid, $tool_consumer_instance_description);

  $content = postLaunchHTML($parms, $endpoint, isset($_GET['debug']) );
  print($content);

?>
