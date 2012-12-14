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
      <li <?php active("open.php"); ?>><a href="open.php">Open Content</a></li>
      <li <?php active("about.php"); ?>><a href="about.php">About</a></li>
      <li class="divider-vertical"></li>
      <li class="divider-vertical"></li>
      <li><a href="http://www.coursera.org/">Go to Coursera</a></a>
      <li><a href="http://class.stanford.edu/">Stanford Online</a></a>
    </ul>
    <span class="pull-right">
    <a class="btn btn-primary" href="login.php">Login</a>
    </span>
  </div>
</div>
