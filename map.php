<?php
require_once("start.php");

$course_id = isset($_GET['course_id']) ? $_GET['course_id'] + 0 : 0;
if ( $course_id < 1 ) {
    $_SESSION["error"] = "No course found to map.";
    header('Location: courses.php');
    return;
}

require_once("sqlutil.php");
require_once("db.php");

$courserow = false;

$sql = "SELECT code, title, image, threshold FROM Courses WHERE id='$course_id'";
$courserow = retrieve_one_row($sql);
if ( $courserow == false ) {
    $_SESSION['error'] = "Unable to retrieve course $course_id";
    header('Location: courses.php');
    return;
}

$sql = "SELECT count(id) FROM Enrollments WHERE course_id=$course_id";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $_SESSION['success'] = "No students enrolled in ".$courserow[0].' - '.$courserow[1];
    header('Location: courses.php');
    return;
}

$total = $countrow[0];

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
$(document).ready( function () {
    $.getJSON('mapjson.php?course_id=<?php echo($course_id); ?>', function(data) {

        origin_lat = 42.279070216140425;
        origin_lng = -83.73981015789798;
        if ( "origin" in data ) origin_lat = data.origin[0];
        if ( "origin" in data ) origin_lng = data.origin[1];
        var myLatlng = new google.maps.LatLng(origin_lat, origin_lng);
        var mapOptions = {
          zoom: 3,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        for ( var i = 0; i < data.markers.length; i++ ) { 
            var row = data.markers[i];
            // if ( i < 3 ) { alert(row); }
            var newLatlng = new google.maps.LatLng(row[0], row[1]);
            var marker = new google.maps.Marker({
                position: newLatlng,
                map: map,
                title: row[3]
            });
        }
    })
});
</script>
</head>
<body>
<div class="container">
<?php require_once("nav.php"); 
echo('<center><h3>');
echo($courserow[0].' - '.$courserow[1]);
echo("($total)");
echo('</h3></center>'."\n");
?>

<div id="map_canvas" 
style="margin-left:10px; margin-right:10px; width: 100%; height:800px;">
<center><img src="spinner.gif"></div>


<?php require_once("footer.php"); ?>
</div>
</body>
