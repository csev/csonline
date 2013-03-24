<?php
   require_once("title.php");
   require_once("config.php");
   function active($arg)
   {
        if ( strpos($_SERVER["PHP_SELF"], $arg) !== false )  echo ' class="active" ';
   }

   if ( $CFG->DEVELOPER ) {
        echo('<div class="navbar navbar-inverse">'."\n");
   } else {
        echo('<div class="navbar">'."\n");
   }

    function in_danger() {
        global $CFG;
        if ( $CFG->DEVELOPER ) {
            echo(' btn-danger ');
        }
    }
?>
  <div class="navbar-inner">
    <ul class="nav nav-pills">
      <li <?php active("index.php"); ?>><a href="index.php"><i class="icon-home visible-phone"></i><span class="hidden-phone">Courses</span></a></li>
<!--
      <li <?php active("courses.php"); ?>><a href="courses.php">Courses</a></li>
-->
<?php if ( isset( $_SESSION["id"]) ) { ?>
      <li <?php active("profile.php"); ?>><a href="profile.php">Profile</a></li>
      <li <?php active("badges.php"); ?>><a href="badges.php">Badges</a></li>
<? } ?>
      <li <?php active("about.php"); ?> class="hidden-phone"><a href="about.php">About</a></li>
    </ul>
<?php if ( isset( $_SESSION["id"]) ) { ?>
    <span style="vertical-align: middle" class="pull-right">
    <a class="btn btn-primary hidden-phone <?php in_danger(); ?>" href="logout.php">Logout</a></span>
<?php } else { ?>
    <span class="pull-right">
    <a class="btn btn-primary <?php in_danger(); ?>" href="login.php">Login</a>
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

