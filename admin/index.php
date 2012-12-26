<?php
require_once("startadmin.php");
require_once("../db.php");
require_once("../sqlutil.php");

echo('<a href="mail.php" target="_blank">Mail</a>'."\n");
$sql = "SELECT count(id) FROM Users";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $usercount = 0;
} else {
    $usercount = $countrow[0];
}

echo("<p>Users $usercount</p>\n");

$sql = "SELECT count(id) FROM Courses";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $coursecount = 0;
} else {
    $coursecount = $countrow[0];
}

echo("<p>Courses $coursecount</p>\n");

$sql = "SELECT count(id) FROM Enrollments";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $enrollcount = 0;
} else {
    $enrollcount = $countrow[0];
}

echo("<p>Enrollments $enrollcount</p>\n");

$sql = "SELECT Courses.id, code, title, count(Enrollments.id) FROM 
        Courses JOIN Enrollments ON Courses.id = Enrollments.course_id
        GROUP BY Courses.id";

$result = run_mysql_query($sql);
if ( $result !== false ) {
    echo("<p>Enrollments by class</p><p>\n");
    while ( $row = mysql_fetch_row($result) ) {
        echo($row[1].' - '.$row[2].' ('.$row[3].')');
        echo(' (<a href="../map.php?course_id='.$row[0].'" target="_blank">Map</a>,');
        echo(' <a href="mail.php?course_id='.$row[0].'" target="_blank">Enrolled Users</a>)');
        echo("<br/>\n");
    }
    echo("</p>\n");
}
