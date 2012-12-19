<?php
   session_start();
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>
</head>
<body style="padding: 0px 10px 0px 10px">
<div class="container">
<?php require_once("nav.php"); ?>
<img src="MOOCMap-8.jpg"
alt="logo" cite="Image from Caitlin Holman"
align="right" class="img-rounded box-shadow hidden-phone" style="max-width: 30%; margin: 10px"/>
<p>
This is very much my own experiment in quickly building a MOOC infrastructure out
of open source pieces glued together with IMS LTI.
</p>
<p>
Login using your Google Account, set up your profile and then launch into the 
Playground course and see if you can get all 300 points from the Auto-Grader!
Show off your Mad Python  Skillz and/or find bugs in my code.   You won't be able to launch 
into Moodle until you log in.
</p>
<p>
If you want an extra special challenge, figure out how to <i>game</i> the autograder and
write a program that matches the final output but does not meet the specs.   Warning, 
I have code in the autograder to catch you if you don't meet the specs.  Good luck trying to
defeat my sanity checker.
</p>
<p>
Comments welcome.
</p>
<p>
Dr. Chuck - 
Mon Dec 17 19:05:14 EST 2012
<?php require_once("footer.php"); ?>
</div>
</body>
