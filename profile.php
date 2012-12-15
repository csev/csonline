<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); 
$defaultLat = isset($_REQUEST["lat"]) ? $_REQUEST["lat"] : 42.279070216140425;
$defaultLng = isset($_REQUEST["lng"]) ? $_REQUEST["lng"] : -83.73981015789798; 
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
    $gravatarurl = isset($_SESSION["gravatarurl"]) ? $_SESSION["gravatarurl"] : false;
    if ( $gravatarurl !== false ) return $gravatarurl;
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

function get_twitter_url()
{
    if ( ! isset($_REQUEST["twitterHandle"]) ) return false;
    $handle = $_REQUEST["twitterHandle"];
    $x =  get_headers("https://api.twitter.com/1/users/profile_image?screen_name=".urlencode($handle)."&size=bigger");
    foreach ( $x as $header ) {
        if ( strpos($header,"Location:") === 0 ) {
            $pieces = explode(" ",$header);
            $twitterurl = $pieces[1];
            break;
        }
    }
    if ( $twitterurl !== false && strpos($twitterurl,"http") === 0 ) {
        return $twitterurl;
    }
    return false;
}

function get_avatar_url()
{
    $avatarurl = isset($_SESSION["avatar_io_url"]) ? $_SESSION["avatar_io_url"] : false;
    if ( $avatarurl !== false ) return $avatarurl;
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

function radio($var, $num) {
    $ret =  '<input type="radio" name="'.$var.'" id="'.$var.$num.'" value="'.$num.'" ';
    if ( isset($_REQUEST[$var] ) ) {
        if ( $num == $_REQUEST[$var] ) $ret .= ' checked ';
    } else { 
        if ( $num == 0 ) $ret .= ' checked ';
    }
    echo($ret);
}
?>
<h3>Save is not yet implemented...  This is just a demo. Save is coming soon.</h3>
<p>
<form class="form-horizontal">
  <div class="control-group">
    <div class="controls">
        We are very careful about sending you mail only when you want mail.  When we send
        mail you will always have an option to unsubscribe from our mail from within the message.
        <label class="radio">
             <?php radio('subscribe',0) ?> >
                Do not send me any E-Mail at all
        </label>
        <label class="radio">
             <?php radio('subscribe',1) ?> >
                Send me announcement mail only - usually one to three mail messages per week.
        </label>
        <label class="radio">
             <?php radio('subscribe',2) ?> >
                Send me class-related mail from within the classes I am taking.
        </label>
        <hr>
  <div class="control-group">
    <label class="control-label" for="twitterHandle">Twitter Handle (Optional)</label>
    <div class="controls">
      <input type="text" id="twitterHandle" name="twitterHandle" 
<?php if ( isset($_REQUEST["twitterHandle"]) ) echo(' value="'.htmlentities($_REQUEST["twitterHandle"]).'" '); ?>
      >
    </div>
  </div>
<hr>
<p>
Choose a profile picture.  We support Twitter profile pictures if you give us your Twitter handle.
We use your e-mail address to find a profile photo on 
<a href="http://www.gravatar.com" target="_new">Gravatar</a> or other services.   
</p>
        <label class="radio">
            Do not use a profile picture
             <?php radio('avatar',0) ?> >
        </label>
<?php

$twitterurl = get_twitter_url();
if ( $twitterurl !== false ) {
    echo('<label class="radio">');
    radio('avatar',1);echo('  style="height: 60px">');
    echo('Use my Twitter profile picture ');
    echo('<img src="'.htmlentities($twitterurl).'" height="60" width="60"/></label>'."\n");
}

$gravatarurl = get_gravatar_url();
if ( $gravatarurl !== false ) {
    echo('<label class="radio">');
    radio('avatar',2);echo('  style="height: 60px">');
    echo('Use my Gravatar profile picture ');
    echo('<img src="'.htmlentities($gravatarurl).'" height="60" width="60"/></label>'."\n");
}

$avatarurl = get_avatar_url();
if ( $gravatarurl !== false && strpos($avatarurl,"gravatar.com") > 0 ) $avatarurl = false;
if ( $twitterurl !== false && strpos($avatarurl,"twitter.com") > 0 ) $avatarurl = false;
if ( $avatarurl !== false ) {
    echo('<label class="radio">');
    radio('avatar',3);echo('  style="height: 60px">');
    echo('Use this profile picture ');
    echo('<img src="'.htmlentities($avatarurl).'" height="60" width="60"/>'."\n");
}

if ( $twitterurl === false && $gravatarurl === false && $avatarurl === false) {
    echo('You seem to have no online profile photo that we can find, you may want 
        to create one at <a href="http://www.gravatar.com" target="_new">www.gravatar.com</a>.');
}
?>
  <hr>
<p>
  Please enter your location.  If you are conncerned about privacy, simply put the 
  location somewhere <i>near</i> where you live.  Perhaps in the same country, state, or city
  instead of your exact location.<br/>
</p>
<p>
  <div id="map_canvas" style="width:400px; height:400px"></div>
</p>

  <div id="latlong" class="control-group">
    <p>Latitude: <input size="30" type="text" id="latbox" name="lat" class="disabled"
    <?php echo(' value="'.htmlentities($defaultLat).'" '); ?>
    ></p>
    <p>Longitude: <input size="30" type="text" id="lngbox" name="lng" class="disabled"
    <?php echo(' value="'.htmlentities($defaultLng).'" '); ?>
    ></p>
  </div>


  <div class="control-group">
      <button type="submit" class="btn">Save (Not Implemented Yet)</button>
    </div>
  </div>

</form>
</p>
<p>
</p>
<p>
<?php require_once("footer.php"); ?>
</body>
