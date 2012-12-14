<?php 
if ( ! isset($_SESSION) ) session_start(); 
$avatar = isset($_SESSION["avatar"]) ? $_SESSION["avatar"] : 'http://en.gravatar.com/avatar/2d0a2f518066c5fd09d757a289b54307?s=80';
$avatarlink = isset($_SESSION["avatarlink"]) ? $_SESSION["avatarlink"] : 'https://twitter.com/drchuck';
?>
<h1>
<div id="google_translate_element" style="float: right; vertical-align:middle;"></div>
<span>
<a href="<?php echo($avatarlink); ?>" target="_new"><img src="<?php echo($avatar); ?>" height="40" width="60"></a>
Dr. Chuck Online 
<span style="color: grey;font-size: 14px; vertical-align: middle">MOOCs, Standards, and Open Educational Resources (Beta)</span></span></h1>
