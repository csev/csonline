<?php
require_once("start.php");

if ( ! isset($_SESSION['id']) ) {
    header('Location: login.php');
    return;
}

$subscribe = isset($_POST['subscribe']) ? $_POST['subscribe']+0 : false;
$twitter = isset($_POST['twitter']) ? $_POST['twitter'] : false;
$education = isset($_POST['education']) ? $_POST['education']+0 : false;
$oer = isset($_POST['oer']) ? $_POST['oer']+0 : false;
$avatar = isset($_POST['avatar']) ? $_POST['avatar']+0 : false;
$map = isset($_POST['map']) ? $_POST['map']+0 : false;
$lat = isset($_POST['lat']) ? $_POST['lat']+0.0 : 0.0;
$lng = isset($_POST['lng']) ? $_POST['lng']+0.0 : 0.0;

// If they just cleared the twitter field - don't use the twitter URL
if ( ( $twitter == false || strlen($twitter) < 0 ) && $avatar == 1 ) $avatar = false;

if ( $avatar !== false && isset($_SESSION["urls"]) ) {
    $urls = $_SESSION["urls"];
    unset($_SESSION["urls"]);
    if ( is_array($urls) && isset($urls[$avatar]) ) {
        $avatar = $urls[$avatar];
    } else {
        $avatar = false;
    }
} else { 
    $avatar = false;
}

require_once("db.php");
// We are saving the data..
if ( isset($_SESSION['id']) && $subscribe !== false && $twitter !== false ) {
    $X_subscribe = $subscribe;
    $X_twitter = mysql_real_escape_string($twitter);
    $X_avatar = mysql_real_escape_string($avatar);
    $X_lat = $lat;
    $X_lng = $lng;
    $sql = "UPDATE Users SET subscribe='$X_subscribe', twitter='$X_twitter', ";
    $sql .= $avatar === false ? " avatar=NULL, " : " avatar='$X_avatar', ";
    $sql .= $education == 0 ? " education=NULL, " : " education='$education', ";
    $sql .= $oer == 0 ? " oer=NULL, " : " oer='$oer', ";
    $sql .= $map == 0 ? " map=NULL, " : " map='$map', ";
    $sql .= $X_lat == 0.0 ? " lat=NULL, " : " lat='$X_lat', ";
    $sql .= $X_lng == 0.0 ? " lng=NULL  " : " lng='$X_lng'  ";
    $sql .= " WHERE id='".$_SESSION['id']."'";
    $result = mysql_query($sql);
    if ( $result === false ) {
        error_log('Fail-SQL:'.mysql_error().','.$sql);
        $_SESSION["error"] = "Internal database error, sorry ".$sql;
        header('Location: profile.php');
    } else {
        error_log('Profile-Update:'.$_SESSION['id']);
        $_SESSION["success"] = "Data Updated";
        unset($_SESSION['twitter']);
        unset($_SESSION['avatar']);
        if ( $avatar !== false && strlen($avatar) > 0 ) $_SESSION["avatar"] = $avatar;
        if ( $twitter !== false && strlen($twitter) > 0 ) $_SESSION["twitter"] = $twitter;
        header('Location: profile.php');
    }
    return;
} else if ( isset($_SESSION['id']) ) { 
    $sql = "SELECT subscribe, twitter, avatar, lat, lng, education, oer, map FROM Users ".
        "WHERE id='".$_SESSION['id']."'";
    $result = mysql_query($sql);
    if ( $result === FALSE ) {
        error_log('Fail-SQL:'.mysql_error().','.$sql);
        $_SESSION["error"] = "Unable to retrieve user profile data, sorry";
        header('Location: index.php');
        return;
    }
    $row = mysql_fetch_row($result);
    // print_r($row);
    $subscribe = $row[0];
    $twitter = $row[1];
    $avatar = $row[2];
    $lat = $row[3];
    $lng = $row[4];
    $education = $row[5];
    $oer = $row[6];
    $map = $row[7];
    // See if we are checking a twitter
    $twitter = isset($_GET['twittercheck']) ? $_GET['twittercheck'] : $twitter;
}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); 
$defaultLat = $lat != 0.0 ? $lat : 42.279070216140425;
$defaultLng = $lng != 0.0 ? $lng : -83.73981015789798; 

if ( ! $CFG->OFFLINE ) {
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
var map;

function initialize() {
  var myLatlng = new google.maps.LatLng(<? echo($defaultLat.", ".$defaultLng); ?>);

  var myOptions = {
     zoom: 2,
     center: myLatlng,
     mapTypeId: google.maps.MapTypeId.ROADMAP
     }
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 

  var marker = new google.maps.Marker({
  draggable: true,
  position: myLatlng, 
  map: map,
  title: "Your location"
  });

  google.maps.event.addListener(marker, 'dragend', function (event) {
    document.getElementById("latbox").value = this.getPosition().lat();
    document.getElementById("lngbox").value = this.getPosition().lng();
  });

}
<?php } else { // OFFLINE ?>
<script type="text/javascript">
var map;

function initialize() { }

<?php } ?>

function twittercheck() {
    text = document.getElementById('twitter').value;
    $('#check').hide();
    $('#spinner').show();
    location.href='profile.php?twittercheck=' + text;
}

</script>
</head>
<body style="padding: 0px 10px 0px 10px" onload="initialize()">
<div class="container">
<?php require_once("nav.php"); ?>
<?php

function get_gravatar_url() 
{
    global $CFG;
    if ( $CFG->OFFLINE ) return false;
    if ( isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $gravatarurl = 'http://www.gravatar.com/avatar/';
        $gravatarurl .= md5( strtolower( trim( $email ) ) );
        $url = $gravatarurl . '?d=404';
        $x =  get_headers($url);
        if ( is_array($x) && strpos($x[0]," 200 ") > 0 ) {
            $_SESSION["gravatarurl"] = $gravatarurl;
            return $gravatarurl;
        }
    }
    return false;
}

function get_twitter_url($handle)
{
    global $CFG;
    if ( $CFG->OFFLINE ) return false;
    if ( $handle === false ) return false;
    $x =  get_headers("https://api.twitter.com/1/users/profile_image?screen_name=".urlencode($handle)."&size=bigger");
    $retval = false;
    foreach ( $x as $header ) {
        if ( strpos($header,"Location:") === 0 ) {
            $pieces = explode(" ",$header);
            $retval = $pieces[1];
            break;
        }
    }
    if ( $retval !== false && strpos($retval,"http") === 0 ) {
        return $retval;
    }
    return false;
}

function get_avatar_url()
{
    global $CFG;
    if ( $CFG->OFFLINE ) return false;
    if ( isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $url = "http://avatars.io/auto/".$email;
        $x =  get_headers($url);
        foreach ( $x as $header ) {
            if ( strpos($header,"Location:") === 0 ) {
                $pieces = explode(" ",$header);
                $avatarurl = $pieces[1];
                break;
            }
        }
        if ( $avatarurl !== false && strpos($avatarurl,"http") === 0 ) {
            return $avatarurl;
        }
    }
    return false;
}

function radio($var, $num, $val) {
    $ret =  '<input type="radio" name="'.$var.'" id="'.$var.$num.'" value="'.$num.'" ';
    if ( $num == $val ) $ret .= ' checked ';
    echo($ret);
}

function option($num, $val) {
    echo(' value="'.$num.'" ');
    if ( $num == $val ) echo(' selected ');
}

function checkbox($val) {
    echo(' value="1" ');
    if ( $val == 1 ) echo(' checked ');
}

echo("<h4>");echo($_SESSION["first"]);echo(" "); echo($_SESSION["last"]);
echo(" (".$_SESSION["email"].")</h4>\n");
?>

<p>
<form method="POST" class="form-rorizontal">
  <div class="control-group pull-right" style="margin-top: 20px">
    <button type="submit" class="btn btn-primary hidden-phone">Save Profile Data</button>
    <button type="submit" class="btn btn-primary visible-phone">Save</button>
  </div>
  <div class="control-group">
    <div class="controls">
        During the Beta - we may need to send you email from time to time - things happen.
        And we might find that Moodle or Piazza sends E-Mail too.  As the code progresses
        we will increasingly make the E-Mail behave.  We will do our best to do your wishes
        here.
<!--
        We are very careful about sending you mail only when you want mail.  When we send
        mail you will always have an option to unsubscribe from our mail from within the message.
-->
        <label class="radio">
             <?php radio('subscribe',0,$subscribe) ?> >
                Keep the mail level as low as possible.   Preferably never.
        </label>
        <label class="radio">
             <?php radio('subscribe',1,$subscribe) ?> >
                Send me announcement mail - usually one to three mail messages per week.
        </label>
        <label class="radio">
             <?php radio('subscribe',2,$subscribe) ?> >
                Send me announcements class-related mail from within the classes I am taking.
        </label>
      </div>
  </div>
<hr class="hidden-phone"/>
  <div class="control-group">
    <label class="control-label" for="twitter">Twitter Name (i.e. drchuck) (Optional)</label>
    <div class="controls">
      <input type="text" id="twitter" name="twitter" onchange="twittercheck(); return false;"
         <?php echo(' value="'.htmlentities($twitter).'" '); ?>
      >
      <button type="button" id="check" style="vertical-align: top;" class="btn btn-primary" onclick="twittercheck(); return false;">Check</button>
      <span id="spinner" style="display:none; vertical-align: top">
      <img id="spinner" height="20" width="20" src="spinner.gif"/>
      <span class="hidden-phone">Retrieving new Twitter profile picture</span>
      </span>
    </div>
  </div>
<hr class="hidden-phone"/>
<p>
Choose a profile picture.  We support Twitter profile pictures if you give us your Twitter handle.
We use your e-mail address to find a profile photo on 
<a href="http://www.gravatar.com" target="_blank">Gravatar</a> or other services.   Moodle will use
your Gravatar image based on your e-mail address.  You can also edit your profile in Moodle
as well.
</p>
<?php
$avatarpos = 0;
$twitterurl = get_twitter_url($twitter);
$gravatarurl = get_gravatar_url();
$avatarurl = get_avatar_url();
if ( $gravatarurl !== false && strpos($avatarurl,"gravatar.com") > 0 ) $avatarurl = false;
if ( $twitterurl !== false && strpos($avatarurl,"twitter.com") > 0 ) $avatarurl = false;

if ( $twitterurl != false && $twitterurl == $avatar ) $avatarpos = 1;
if ( $gravatarurl != false && $gravatarurl == $avatar ) $avatarpos = 2;
if ( $avatarurl != false && $avatarurl == $avatar ) $avatarpos = 3;

?>
        <label class="radio">
            Do not use a profile picture
             <?php radio('avatar',0,$avatarpos) ?> >
        </label>
<?php

$urls = Array();
if ( $twitterurl !== false ) {
    echo('<label class="radio">');
    radio('avatar',1,$avatarpos);echo('  style="height: 60px">');
    $urls[1] = $twitterurl;
    echo('Use my Twitter profile picture ');
    echo('<img src="'.htmlentities($twitterurl).'" height="60" width="60"/></label>'."\n");
}

if ( $gravatarurl !== false ) {
    echo('<label class="radio">');
    radio('avatar',2,$avatarpos);echo('  style="height: 60px">');
    $urls[2] = $gravatarurl;
    echo('Use my Gravatar profile picture ');
    echo('<img src="'.htmlentities($gravatarurl).'" height="60" width="60"/></label>'."\n");
}

if ( $avatarurl !== false ) {
    echo('<label class="radio">');
    radio('avatar',3,$avatarpos);echo('  style="height: 60px">');
    $urls[3] = $avatarurl;
    echo('Use this profile picture ');
    echo('<img src="'.htmlentities($avatarurl).'" height="60" width="60"/>'."\n");
}

// Store the most recent list of presented URLs in session
$_SESSION["urls"] = $urls;

if ( $twitterurl === false && $gravatarurl === false && $avatarurl === false) {
    echo('You seem to have no online profile photo that we can find, you may want 
        to create one at <a href="http://www.gravatar.com" target="_blank">www.gravatar.com</a>.');
}
?>
  <hr class="hidden-phone"/>
What is your current or highest education level?<br/>
<select name="education">
  <option value="0">--- Please Select ---</option>
  <option <?php option(1,$education); ?>>Pre-High School</option>
  <option <?php option(2,$education); ?>>High School</option>
  <option <?php option(3,$education); ?>>Community College</option>
  <option <?php option(4,$education); ?>>Four-Year</option>
  <option <?php option(5,$education); ?>>Graduate/Professional</option>
  <option <?php option(6,$education); ?>>Doctorate/MD</option>
</select>
  <hr class="hidden-phone"/>
How would you like to be shown in maps of student achievements.<br/>
<select name="map">
  <option value="0">--- Please Select ---</option>
  <option <?php option(1,$map); ?>>Don't show me at all</option>
  <option <?php option(2,$map); ?>>Show only my location with no identifying information</option>
  <option <?php option(3,$map); ?>>Show my first name (<?php echo($_SESSION["first"]); ?>)</option>
  <option <?php option(4,$map); ?>>Show my first name and Twitter informaiton</option>
</select>
  <hr class="hidden-phone"/>
<label class="checkbox">
  <input type="checkbox" name="oer" <?php checkbox($oer); ?> >
  I am a teacher or otherwise interested in Open Educational Resources.
</label>
<?php if ( ! $CFG->OFFLINE ) { ?>
  <hr class="hidden-phone"/>
<p>
  Move the pointer on the map below until it is at the correct location.
  If you are concerned about 
  privacy, simply put the 
  location somewhere <i>near</i> where you live.  Perhaps in the same country, state, or city
  instead of your exact location.  
<br/>
</p>
  <div class="control-group pull-right hidden-phone">
      <button type="submit" style="margin-top: 40px" class="btn btn-primary">Save Profile Data</button>
    </div>
  </div>

<p>
  <div id="map_canvas" style="width:400px; max-width: 100%; height:400px"></div>
</p>

  <div id="latlong" style="display:none" class="control-group">
    <p>Latitude: <input size="30" type="text" id="latbox" name="lat" class="disabled"
    <?php echo(' value="'.htmlentities($lat).'" '); ?>
    ></p>
    <p>Longitude: <input size="30" type="text" id="lngbox" name="lng" class="disabled"
    <?php echo(' value="'.htmlentities($lng).'" '); ?>
    ></p>
  </div>

<p>
If you don't even want to reveal your country, put yourself
  in Greenland in the middle of a glacier. :)
</p>
<?php } ?>
</form>
</p>
<p>
</p>
<p>
<?php require_once("footer.php"); ?>
</div>
</body>
