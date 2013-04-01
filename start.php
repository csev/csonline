<?php
session_start();
require_once("config.php");
require_once("cookie.php");

if ( ! headers_sent() ) header('Content-Type: text/html; charset=utf-8');

$pieces = false;
$id = false;

// Only do this if we are not already logged in...
if ( !isset($_SESSION["id"]) && isset($_COOKIE[$CFG->cookiename]) && 
    isset($CFG->cookiepad) && $CFG->cookiepad !== false) {
    $ct = $_COOKIE[$CFG->cookiename];
    // echo("Cookie: $ct \n");
    $pieces = extract_secure_cookie($ct);
    if ( $pieces === false ) {
        error_log('Decrypt fail:'.$ct);
        delete_secure_cookie();
    }
    // Convert to an integer and check valid
    $id = $pieces[0] + 0;
    if ( $id < 1 ) {
        $id = false;
        $pieces = false;
        error_log('Decrypt bad ID:'.$pieces[0].','.$ct);
        delete_secure_cookie();
    }

}

if ( $pieces != false && $id != false) {
    require_once("db.php");
    require_once("sqlutil.php");
    $X_id = mysql_real_escape_string($id);
    $sql = "SELECT identity, email, first, last, avatar, twitter FROM Users WHERE id='$X_id'";
    $row = retrieve_one_row($sql);
    if ( $row === FALSE ) {
        error_log('Decrypt missing:'.$id.','.$ct);
        delete_secure_cookie();
    } else if ( $pieces[1] != MD5($row[0]) ) {
        error_log('Decrypt bad identity:'.$pieces[1].','.$row[0].','.$ct);
        delete_secure_cookie();
    } else {
        $email = $row[1];
        $first = $row[2];
        $last = $row[3];
        $avatar = $row[4];
        $twitter = $row[5];
        if ( strlen($email) < 1 || strlen($first) < 1 || strlen($last) < 1 ) {
            error_log('Decrypt missing required:'.$email.','.$first.','.$last);
            delete_secure_cookie();
        } else {
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;
            $_SESSION["first"] = $first;
            $_SESSION["last"] = $last;
            if ( $avatar !== false && strlen($avatar) > 0 ) $_SESSION["avatar"] = $avatar;
            if ( $twitter !== false && strlen($twitter) > 0 ) $_SESSION["twitter"] = $twitter;
            error_log('Normal autologin:'.$id.','.$email.','.$first.','.$last);
        }
    }
}
