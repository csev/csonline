<?php
session_start();

if ( ! isset($_SESSION['id']) ) {
        header('Location: login.php');
        return;
}

$subscribe = isset($_POST['subscribe']) ? $_POST['subscribe']+0 : false;
$twitter = isset($_POST['twitter']) ? $_POST['twitter'] : false;
$avatar = isset($_POST['avatar']) ? $_POST['avatar']+0 : false;
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
    $sql .= $X_lat == 0.0 ? " lat=NULL, " : " lat='$X_lat', ";
    $sql .= $X_lng == 0.0 ? " lng=NULL  " : " lng='$X_lng'  ";
    $sql .= " WHERE id='".$_SESSION['id']."'";
error_log($sql);
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
    $sql = "SELECT subscribe, twitter, avatar, lat, lng FROM Users ".
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
}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); 
$defaultLat = $lat != 0.0 ? $lat : 42.279070216140425;
$defaultLng = $lng != 0.0 ? $lng : -83.73981015789798; 
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
  var map;
  function initialize() {
  var myLatlng = new google.maps.LatLng(<? echo($defaultLat.", ".$defaultLng); ?>);

  var myOptions = {
     zoom: 8,
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
</script>
</head>
<body style="padding: 0px 10px 0px 10px" onload="initialize()">
<?php require_once("nav.php"); ?>
<?php

function get_gravatar_url() 
{
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
    if ( $handle === false ) return false;
    $x =  get_headers("https://api.twitter.com/1/users/profile_image?screen_name=".urlencode($handle)."&size=bigger");
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
?>
<p>
<form method="POST" class="form-horizontal">
  <div class="control-group">
    <div class="controls">
        We are very careful about sending you mail only when you want mail.  When we send
        mail you will always have an option to unsubscribe from our mail from within the message.
        <label class="radio">
             <?php radio('subscribe',0,$subscribe) ?> >
                Do not send me any E-Mail at all
        </label>
        <label class="radio">
             <?php radio('subscribe',1,$subscribe) ?> >
                Send me announcement mail only - usually one to three mail messages per week.
        </label>
        <label class="radio">
             <?php radio('subscribe',2,$subscribe) ?> >
                Send me class-related mail from within the classes I am taking.
        </label>
        <hr>
  <div class="control-group">
    <label class="control-label" for="twitter">Twitter Handle (Optional)</label>
    <div class="controls">
      <input type="text" id="twitter" name="twitter" 
         <?php echo(' value="'.htmlentities($twitter).'" '); ?>
      >
    </div>
  </div>
<hr>
<p>
Choose a profile picture.  We support Twitter profile pictures if you give us your Twitter handle.
We use your e-mail address to find a profile photo on 
<a href="http://www.gravatar.com" target="_new">Gravatar</a> or other services.   
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
        to create one at <a href="http://www.gravatar.com" target="_new">www.gravatar.com</a>.');
}
?>
  <hr>
<p>
  Location is optional - you can leave these fields blank. If you are conncerned about 
  privacy, simply put the 
  location somewhere <i>near</i> where you live.  Perhaps in the same country, state, or city
  instead of your exact location.<br/>
</p>
<p>
  <div id="map_canvas" style="width:400px; height:400px"></div>
</p>

  <div id="latlong" class="control-group">
    <p>Latitude: <input size="30" type="text" id="latbox" name="lat" class="disabled"
    <?php echo(' value="'.htmlentities($lat).'" '); ?>
    ></p>
    <p>Longitude: <input size="30" type="text" id="lngbox" name="lng" class="disabled"
    <?php echo(' value="'.htmlentities($lng).'" '); ?>
    ></p>
  </div>


  <div class="control-group">
      <button type="submit" class="btn">Save Profile Data</button>
    </div>
  </div>

</form>
</p>
<p>
</p>
<p>
<?php require_once("footer.php"); ?>
</body>
