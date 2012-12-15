<?php
   require_once("title.php");
   function active($arg)
   {
        if ( strpos($_SERVER["PHP_SELF"], $arg) !== false )  echo ' class="active" ';
   }
?>
<div class="navbar">
  <div class="navbar-inner">
    <ul class="nav nav-pills">
      <li <?php active("index.php"); ?>><a href="index.php">Home</a></li>
<?php if ( isset( $_SESSION["id"]) ) { ?>
      <li <?php active("courses.php"); ?>><a href="courses.php">My Courses</a></li>
      <li <?php active("profile.php"); ?>><a href="profile.php">My Profile</a></li>
<? } ?>
      <li <?php active("open.php"); ?> class="hidden-phone"><a href="open.php">Open Content</a></li>
      <li <?php active("about.php"); ?> class="hidden-phone"><a href="about.php">About</a></li>
      <li class="divider-vertical" class="hidden-phone hidden-tablet"></li>
      <li class="divider-vertical" class="hidden-phone hidden-tablet"></li>
      <li><a href="http://www.coursera.org/" target="_new" class="hidden-phone hidden-tablet">Go to Coursera</a></a>
      <li><a href="http://class.stanford.edu/" target="_new" class="hidden-phone hidden-tablet">Stanford Online</a></a>
    </ul>
<?php if ( isset( $_SESSION["id"]) ) { ?>
    <span style="vertical-align: middle" class="pull-right">
    <a class="btn btn-primary disabled hidden-phone hidden-tablet" href="profile.php">
<?php echo($_SESSION["first"]." ".$_SESSION["last"]); ?>
    </a></span>
<?php } else { ?>
    <span class="pull-right">
    <a class="btn btn-primary" href="login.php">Login</a>
    </span>
<? } ?>
  </div>
</div>
<?php

if ( isset($_SESSION['error']) ) {
    echo '<div class="alert alert-error" style="margin-top: 10px;">'.$_SESSION['error']."</div>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<div class="alert alert-success" style="margin-top: 10px;">'.$_SESSION['success']."</div>\n";
    unset($_SESSION['success']);
}

