<?php
require_once("startadmin.php");
require_once("../db.php");
require_once("../sqlutil.php");

$sql = "SELECT count(id) FROM Users";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $_SESSION['success'] = "No students enrolled in ".$courserow[0].' - '.$courserow[1];
    header('Location: courses.php');
    return;
}
$usercount = $countrow[0];

echo("<p>Users $usercount</p>\n");

$sql = "SELECT Courses.id, code, title, count(user_id) FROM 
        Courses JOIN Enrollments ON Courses.id = course_id
        GROUP BY user_id,Enrollments.id";

$result = run_mysql_query($sql);
if ( $result !== false ) {
    echo("<p>Enrollments</p><p>\n");
    while ( $row = mysql_fetch_row($result) ) {
        echo($row[1].' - '.$row[2].' ('.$row[3].')'."<br/>\n");
    }
    echo("</p>\n");
}
