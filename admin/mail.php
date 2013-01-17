<?php
require_once("startadmin.php");
require_once("../db.php");
require_once("../sqlutil.php");

echo("<p>Enrolled Users</p>\n");

if ( isset($_GET['course_id']) ) { 
    $course_id = $_GET['course_id'] + 0;
    if ( $course_id > 0 ) {

        $sql = "SELECT DISTINCT email FROM Users 
            JOIN Enrollments ON Users.id = Enrollments.user_id
            WHERE Enrollments.course_id = $course_id";
        $result = run_mysql_query($sql);
        if ( $result !== false ) {
            echo("<p>\n");
            $i = 0;
            while ( $row = mysql_fetch_row($result) ) {
                if ( $i > 0 ) echo(", ");
                $i = $i + 1;
                echo(htmlencode($row[0]) );
            }
            echo("</p>\n");
        }
        return;
    }
}


$sql = "SELECT DISTINCT email FROM Users 
    JOIN Enrollments ON Users.id = Enrollments.user_id
    LIMIT 5000";

$result = run_mysql_query($sql);
if ( $result !== false ) {
    echo("<p>\n");
    $i = 0;
    while ( $row = mysql_fetch_row($result) ) {
        if ( $i > 0 ) echo(", ");
        $i = $i + 1;
        echo(htmlencode($row[0]) );
    }
    echo("</p>\n");
}

echo("<p>All Users</p>\n");

$sql = "SELECT DISTINCT email FROM Users LIMIT 5000";

$result = run_mysql_query($sql);
if ( $result !== false ) {
    echo("<p>\n");
    $i = 0;
    while ( $row = mysql_fetch_row($result) ) {
        if ( $i > 0 ) echo(", ");
        $i = $i + 1;
        echo(htmlencode($row[0]) );
    }
    echo("</p>\n");
}
