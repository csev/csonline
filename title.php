<?php 
require_once "config.php";
if ( ! isset($_SESSION) && ! headers_sent() ) session_start(); 
$title_avatar = isset($_SESSION["avatar"]) ? $_SESSION["avatar"] : $CFG->default_avatar;
$title_avatar_link = $CFG->default_avatar_link;
if ( isset($_SESSION["twitter"]) ) {
    $title_avatar_link = "https://twitter.com/" . $_SESSION["twitter"];
}
?>
<h1>
<div id="google_translate_element" style="float: right; vertical-align:middle;"></div>
<span>
<a href="<?php echo($title_avatar_link); ?>" target="_blank"><img src="<?php echo($title_avatar); ?>" height="40" width="40"></a>
<span class="hidden-phone"><?php echo($CFG->site_title); ?></span>
<span class="visible-phone"><small><?php echo($CFG->site_title_phone); ?></small></span>
<span class="hidden-phone hidden-tablet" style="color: grey;font-size: 14px; vertical-align: middle"><?php echo($CFG->site_title_subtext); ?></span></span></h1>
