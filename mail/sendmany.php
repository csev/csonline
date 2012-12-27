<?php

require_once("../config.php");
if ( ! isCli() ) die("CLI only");

require_once("maillib.php");
require_once("../db.php");
require_once("../sqlutil.php");

// Get the message text form the file above
require_once("../message.php");

if ( $course_id < 1 || strlen($subject) < 1 || strlen($message) < 1 ) {
    die("Missing message information.");
}

$sql = "SELECT DISTINCT Users.id,email,identity FROM Users
    JOIN Enrollments ON Users.id = Enrollments.user_id
    WHERE Enrollments.course_id = $course_id
        AND Users.subscribe >= 0";
$result = run_mysql_query($sql);
if ( $result === false ) {
    die($sql." ".mysql_error());
}

$i = 0;
while ( $row = mysql_fetch_row($result) ) {
    $id = $row[0];
    $to = $row[1];
    $token = compute_mail_check($row[2]);
    echo("$id,$to,$token");
    if ( strlen($id) < 1 || strlen($to) < 1 || strlen($token) < 1 ) {
        echo("  **** MISSING DATA\n");
        continue;
    }
    if ( $only !== false && $only != $to ) {
        echo(" Skipped.\n");
        continue;
    }
    $retval = false;
    $retval = mooc_send($to, $subject, $message, $id, $token);
    if ( $retval === true ) {
        echo(" Sent.\n");
    } else {
        echo("  *** ERROR in sending\n");
    }
    sleep($CFG->maildelay);
}

