<?php
require_once("start.php");

header('Content-Type: application/json');

$retval = Array("status" => "failure");

$course_id = isset($_GET['course_id']) ? $_GET['course_id'] + 0 : 0;
if ( $course_id < 1 ) {
    $retval['desc'] = "No course found to map";
    echo(json_encode($retval));
    return;
}

require_once("sqlutil.php");
require_once("db.php");

$courserow = false;

$sql = "SELECT code, title, image, threshold FROM Courses WHERE id='$course_id'";
$courserow = retrieve_one_row($sql);
if ( $courserow == false ) {
    $retval['desc'] = "Unable to retrieve course $course_id";
    echo(json_encode($retval));
    return;
}

$sql = "SELECT count(id) FROM Enrollments WHERE course_id=$course_id";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $retval['status'] = 'success';
    $retval['total'] = 0;
    echo(json_encode($retval));
    return;
}
$retval['total'] = $countrow[0];

$sql = "SELECT Enrollments.grade, 
    Users.first, Users.twitter, Users.lat, Users.lng, Users.map, Users.id,
    Enrollments.cert_at, Users.backpack
    FROM Enrollments JOIN Users
    ON Enrollments.user_id = Users.id
    WHERE 
    Enrollments.course_id = $course_id
    AND lat IS NOT NULL AND lng IS NOT NULL ";
if ( ! isset($_SESSION['admin']) ) {
    $sql .= "AND Users.map > 1 ";
}
$sql .= "ORDER BY grade 
    LIMIT 5000";

// $retval['_sql'] = $sql;
$result = mysql_query($sql);
if ( $result === FALSE ) {
    $retval['desc'] = "Unable to retrieve course data $course_id";
    echo(json_encode($retval));
    return;
}

$markers = Array();
$origin_lat = false;
$origin_lng = false;
while ( $row = mysql_fetch_row($result) ) {
    $level = 0;
    $cert_date = substr($row[7],0,10);
    if ( $row[0] > 0.0 ) $level = 1;
    if ( $row[0] >= 0.5 ) $level = 2;
    if ( $row[0] > 0.799 ) $level = 3;
    if ( $row[0] >= 1.0 ) $level = 4;
    if ( strlen($cert_date) > 1 ) $level = 4;
    // 2=location, 3=name, 4=twitter
    $map = $row[5];
    $first = $map >= 3 || isAdmin() ? $row[1] : '';
    $twitter = $map >= 4  || isAdmin() ? $row[2] : '';
    $backpack = $map >= 4  || isAdmin() ? $row[8] : '';
    $note = '';
    if ( isAdmin() && strlen($row[0]) > 0 ) $note = "Grade: ".$row[0];
    $marker = Array($row[3]+0.0,$row[4]+0.0,$level,htmlencode($first),htmlencode($twitter),
				htmlencode($note), htmlencode($cert_date), htmlencode($backpack));
    if ( (isset($_SESSION["id"]) && $_SESSION["id"] == $row[6]) ||
         (isset($_GET['user_id']) && $_GET['user_id'] == $row[6] ) ) {
       $origin_lat = $row[3]+0.0; 
       $origin_lng = $row[4]+0.0; 
    }
    array_push($markers,$marker);
}

$retval["status"] = "success";
$retval["markers"] = $markers;
if ( $origin_lat !== false ) {
    $retval["origin"] = Array($origin_lat, $origin_lng);
}

echo(json_encode($retval));

