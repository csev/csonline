<?php

require_once("../config.php");
require_once("../crypt/aes.class.php");
require_once("../crypt/aesctr.class.php");
require_once("hex2bin.php");

function getBadgeInfo() {
    global $CFG;
    if ( isset($_GET['id']) ) {
        $encrypted = basename($_GET['id'],'.png');
    } else {
        $url = $_SERVER['REQUEST_URI'];
        $pieces = explode('/',$url);
        $encrypted = basename($pieces[count($pieces)-1],'.png');
    }
    
    $decrypted = AesCtr::decrypt(hex2bin($encrypted), $CFG->badge_encrypt_password, 256);
    $pieces = explode(':',$decrypted);
    if ( count($pieces) != 2 ) die("incorrect id");
    if ( !is_numeric($pieces[0]) ) die("incorrect id");
    if ( !is_numeric($pieces[1]) ) die("incorrect id");
    $user_id = $pieces[0];
    $course_id = $pieces[1];
    
    require_once("../sqlutil.php");
    require_once("../db.php");
    
    if ( $course_id == 0 ) {
        $sql = "SELECT email, created_at,'DCO','Online Student' 
                FROM Users WHERE email IS NOT NULL AND 
                id='".$user_id."'";
        $row = retrieve_one_row($sql);
    } else {
        $sql = 'SELECT email, cert_at, code, title
            FROM Users JOIN Courses JOIN Enrollments
            ON Users.id = '.$user_id.'
            AND Courses.id = '.$course_id.'
            AND Enrollments.user_id = Users.id
            WHERE cert_at IS NOT NULL AND email IS NOT NULL';
        $row = retrieve_one_row($sql);
    }
    if ( count($row) == 4 ) $row[4] = $encrypted;
    return $row;
}
