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
<?php if ( isset( $_SESSION["LOGIN_EMAIL"]) ) { ?>
      <li <?php active("courses.php"); ?>><a href="courses.php">My Courses</a></li>
      <li <?php active("profile.php"); ?>><a href="profile.php">My Profile</a></li>
<? } ?>
      <li <?php active("why.php"); ?>><a href="about.php">About</a></li>
    </ul>
    <span class="pull-right">
    <a class="btn btn-primary" href="http://www.coursera.org/">Go to Coursera</a>
    <a class="btn btn-primary disabled" href="#">Login (Coming Soon)</a>
    </span>
  </div>
</div>
