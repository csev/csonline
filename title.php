<?php 
if ( ! isset($_SESSION) ) session_start(); 
$title_avatar = isset($_SESSION["avatar"]) ? $_SESSION["avatar"] : 'http://en.gravatar.com/avatar/2d0a2f518066c5fd09d757a289b54307?s=80';
$title_twitter = "https://twitter.com/" . (isset($_SESSION["twitter"]) ? $_SESSION["twitter"] : 'drchuck');
?>
<h1>
<div id="google_translate_element" style="float: right; vertical-align:middle;"></div>
<span>
<a href="<?php echo($title_twitter); ?>" target="_new"><img src="<?php echo($title_avatar); ?>" height="40" width="40"></a>
<span class="hidden-phone">Dr. Chuck Online </span>
<span class="hidden-phone hidden-tablet" style="color: grey;font-size: 14px; vertical-align: middle">MOOCs, Standards, and OERs</span></span></h1>
