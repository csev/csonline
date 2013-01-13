<?php

require_once("../config.php");
if ( ! isCli() ) die("CLI only");

require_once("maillib.php");
require_once("../db.php");
require_once("../sqlutil.php");

// Get the message text form the file above
require_once("../message.php");

if ( strlen($subject) < 1 || 
    strlen($message) < 1 || $message_id < 1 ) {
    die("Missing message information.");
}

if ( $course_id == -1 ) {
    $sql = "SELECT DISTINCT Users.id,Users.email,identity FROM Users
        WHERE Users.subscribe >= 0";
} else {
    $sql = "SELECT DISTINCT Users.id,Users.email,identity FROM Users
        JOIN Enrollments ON Users.id = Enrollments.user_id 
        WHERE Enrollments.course_id = $course_id
            AND Users.subscribe >= 0";
}

// echo($sql);echo("\n");
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

    // Don't double send
    $sql = "SELECT success FROM Delivery 
                WHERE user_id=$id AND message_id=$message_id AND 
                email = '".mysql_real_escape_string($to)."'";
    $successrow = retrieve_one_row($sql);
    if ( $successrow !== false && $successrow[0] > 0 ) {
        echo("  **** Already Sent\n");
        continue;
    }

    // Actually send
    $retval = false;
    $retval = mooc_send($to, $subject, $message, $id, $token);
    if ( $retval === true ) {
        echo(" Sent.\n");
    } else {
        echo("  *** ERROR in sending\n");
    }

    // Lets remember this
    $success = $retval+0;
    $sql = "INSERT INTO Delivery (message_id,email,user_id,success,send_at)
        VALUES ( $message_id,'$to',$id,$success,NOW() )";
    $x = run_mysql_query($sql);
    if ( $x === false ) {
        die($sql." ".mysql_error());
    }

    sleep($CFG->maildelay);
}

