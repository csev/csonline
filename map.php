<?php
require_once("start.php");

$course_id = 0;
$user_id = 0;

if ( isset($_GET['l']) ) {
    try {
        $pieces = explode(":",base64_decode($_GET['l']));
        if ( count($pieces) == 2 ) {
            $course_id = $pieces[0] + 0;
            $user_id = $pieces[1] + 0;
        }
    } catch (Exception $e ) {
        // Ignore
    }
}

$course_id = isset($_GET['course_id']) ? $_GET['course_id'] + 0 : $course_id;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] + 0 : $user_id;

if ( $course_id < 1 ) {
    $_SESSION["error"] = "No course found to map.";
    header('Location: index.php');
    return;
}

require_once("sqlutil.php");
require_once("db.php");

$courserow = false;

$sql = "SELECT code, title, image, threshold FROM Courses WHERE id='$course_id'";
$courserow = retrieve_one_row($sql);
if ( $courserow == false ) {
    $_SESSION['error'] = "Unable to retrieve course $course_id";
    header('Location: index.php');
    return;
}

$sql = "SELECT count(id) FROM Enrollments WHERE course_id=$course_id";
$countrow = retrieve_one_row($sql);
if ( $countrow === false || $countrow[0] < 1 ) {
    $_SESSION['success'] = "No students enrolled in ".$courserow[0].' - '.$courserow[1];
    header('Location: index.php');
    return;
}

$total = $countrow[0];

$uservisible = false;
if ( isset($_SESSION["id"]) ) {
    $sql = "SELECT Users.map 
    FROM Users JOIN Enrollments
    ON Enrollments.user_id = Users.id
    WHERE
    Enrollments.course_id = $course_id
    AND Users.id = ".$_SESSION["id"]."
    AND Users.map > 1 ";

    $uservisible = retrieve_one_row($sql);
    if ( $uservisible !== false ) $uservisible = true;
}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var map = null;
var tot_blue = 0;
var tot_red = 0;
var tot_yellow = 0;
var tot_pink = 0;
$(document).ready( function () {
    $.getJSON('mapjson.php?course_id=<?php echo($course_id); if ( $user_id != 0 ) echo("&user_id=$user_id"); ?>', function(data) {
        origin_lat = 42.279070216140425;
        origin_lng = -83.73981015789798;
        var zoomval = 3;
        if ( "origin" in data ) {
            origin_lat = data.origin[0];
            origin_lng = data.origin[1];
            <?php if ( $user_id != 0 ) echo('zoomval = 11;'); ?>
        }
        var myLatlng = new google.maps.LatLng(origin_lat, origin_lng);
        var mapOptions = {
          zoom: zoomval,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        for ( var i = 0; i < data.markers.length; i++ ) { 
            var row = data.markers[i];
            // if ( i < 3 ) { alert(row); }
            var newLatlng = new google.maps.LatLng(row[0], row[1]);
            var iconpath = '<?php echo($CFG->staticroot); ?>/static/img/icons/';
            var icon = 'green';
            if ( row[2] == 1 ) {
                icon = 'pink';
                tot_pink++;
            }
            if ( row[2] == 2 ) {
                icon = 'yellow';
                tot_yellow++;
            }
            if ( row[2] == 3 ) {
                icon = 'red';
                tot_red++;
            }
            if ( row[2] == 4 ) {
                icon = 'blue';
                tot_blue++;
            }
            var content = row[5];
            var adddot = false;
            if ( row[4].length > 0 ) {
                content = content + ' <a href="http://www.twitter.com/' + row[4] + '" target="_blank">' + row[4] + '</a>';
                adddot = true;
            }
            if ( row[3].length > 0 ) {
                content = content + ' ' + row[3] + ' ';
                adddot = true;
            }
            if ( row[6].length > 0 ) {
                content = content + ' (' + row[6] + ')';
            }
            if ( row[7].length > 0 ) {
                content = content + ' <a href="<?php echo($CFG->badge_display); ?>/' + row[7] + '" target="_blank">My Badges</a>';
            }
            if ( adddot ) icon = icon + '-dot';
            icon = icon + '.png';
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
        if ( tot_blue > 0 ) $("#tot_blue").html("("+tot_blue+")");
        if ( tot_red > 0 ) $("#tot_red").html("("+tot_red+")");
        if ( tot_pink > 0 ) $("#tot_pink").html("("+tot_pink+")");
        if ( tot_yellow > 0 ) $("#tot_yellow").html("("+tot_yellow+")");
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
The icons have a dot when a  person has shared their name or twitter information.
</p>
<p>
The marker colors have the following meaning: green is enrolled, 
pink <span id="tot_pink"></span>
indicates the student completed at least one assignment, 
yellow <span id="tot_yellow"></span>
is half done, 
red <span id="tot_red"></span>
is almost complete, and 
blue <span id="tot_blue"></span>
indicates course completion.
The icon colors
are roughly taken from <a href="http://en.wikipedia.org/wiki/Horse_show#Awards" 
target="_blanks">horse show ribbon</a> colors for the US. 
</p>
<?php
$location = false;
if ( isset($_SESSION['id']) ) {
    $location = base64_encode($course_id.":".$_SESSION['id']);
}

if ( isset($_GET['user_id']) || isset($_GET['l']) ) {
?>
<p>
View map <a href="map.php?course_id=<?php echo($course_id); ?>">zoomed out</a>.
</p>
<?php
} else if ( $uservisible && isset($_SESSION['id']) ) {
?>
<p>
You can use this <a href="map.php?l=<?php echo($location); ?>">link</a> 
to a view the map zoomed in on your location.  
You can also
<a href="http://twitter.com/home?status=I am taking <?php echo($courserow[1]); ?> online at <?php echo($CFG->wwwroot); ?>/map.php?l=<?php echo($location); ?>" target="_blank">tweet your location</a>.
</p>
<?php } ?>
<div id="map_canvas" 
style="margin-left:10px; margin-right:10px; width: 100%; height:800px;">
<center><img src="spinner.gif"></div>

<?php require_once("footer.php"); ?>
</div>
</body>
