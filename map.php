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
var map = null;
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
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        for ( var i = 0; i < data.markers.length; i++ ) { 
            var row = data.markers[i];
            // if ( i < 3 ) { alert(row); }
            var newLatlng = new google.maps.LatLng(row[0], row[1]);
            var iconpath = '<?php echo($CFG->staticroot); ?>/static/img/benkeenmarkers/';
            var icon = 'darkgreen_MarkerA.png';
            if ( row[2] == 1 ) icon = 'pink_MarkerA.png';
            if ( row[2] == 2 ) icon = 'yellow_MarkerA.png';
            if ( row[2] == 3 ) icon = 'red_MarkerA.png';
            if ( row[2] == 4 ) icon = 'blue_MarkerA.png';
            var content = row[5];
            if ( row[4].length > 0 ) {
                content = content + ' <a href="http://www.twitter.com/' + row[4] + '" target="_blank">' + row[4] + '</a>';
            }
            if ( row[6].length > 0 ) {
                content = content + ' (' + row[6] + ')';
            }
            var marker = new google.maps.Marker({
                position: newLatlng,
                map: map,
                icon: iconpath + icon,
                ourHtml : content,
                title: row[3]
            });
            if ( content.length > 0 ) {
                google.maps.event.addListener(marker, 'click', function() {
                    var infowindow = new google.maps.InfoWindow();
                    infowindow.setContent(this.ourHtml);
                    infowindow.open(map, this);
                });
            }
        }
    })
});
</script>
</head>
<body style="padding: 0px 10px 0px 10px">
<div class="container">
<?php require_once("nav.php"); 
echo('<center><h3>');
echo($courserow[0].' - '.$courserow[1]);
echo("($total)");
echo('</h3></center>'."\n");
?>

<p>
Each person enrolled in the class controls whether they show up on 
this or not.  They control how much they show on the map in the 
Profile page.  If you want to appear on the map, go to your profile
and set your location to something other than the default.
A green marker indicates an erollment.  A blue marker indicates someone
has completed the course.  The other colors between green and blue indicate progress.
</p>

<div id="map_canvas" 
style="margin-left:10px; margin-right:10px; width: 100%; height:800px;">
<center><img src="spinner.gif"></div>

<?php require_once("footer.php"); ?>
</div>
</body>
