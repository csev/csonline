<?php
   require_once("start.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>
</head>
<body style="padding: 0px 10px 0px 10px">
<div class="container">
<?php require_once("nav.php"); ?>
<?php if ( ! $CFG->OFFLINE ) { ?>
<div class="hidden-phone hidden-tablet" style="width: 560; float: right; margin:10px;">
<iframe width="450" height="253" src="http://www.youtube.com/embed/hRNFBhEykcY" frameborder="0" allowfullscreen></iframe>
</div>
<? } ?>
<p>
This is very much my own experiment in quickly building a MOOC infrastructure out
of open source pieces glued together with IMS LTI.  This is very much <b>Beta</b>
software.  Don't expect it to be as polished as 
<a href="http://www.coursera.org/" target="_new">Coursera</a> - the goal here is to explore
more of the dimensions of <a href="about.php">what it means to be a MOOC</a>.
</p>
<?php if ( ! $CFG->OFFLINE ) { ?>
<div class="hidden-phone visible-tablet" style="width: 560; margin:10px;">
<center>
<iframe width="450" height="253" src="http://www.youtube.com/embed/hRNFBhEykcY" frameborder="0" allowfullscreen></iframe>
</center>
</div>
<? } ?>
<p>
For now we are only testing and playing (and I am recording lectures) - the real 
course will start January 14, 2013.   You can enroll for it now, but not launch it.
Once the actual <b>Python for Informatics</b> course opens, you will be able to launch it.
I would suggest you enroll right away because enrollment will only be
open for a few weeks.
</p>
<p>
<b>Test Plan:</b> If you want to help, login using your Google Account, set 
up your profile and then launch into the 
Playground course and see if you can get all 300 points from the Auto-Grader!
Show off your Mad Python  Skillz and/or find bugs in my code.   You won't be able to launch 
into Moodle until you log in.
Most of my testing is on Chrome, so if you have a problem with a browser, note
it and try another browser.  
If you have any technical problems, let me know in the discussion
forum in Moodle (provided by <a href="http://piazza.com" target="_new">Piazza</a>).
Be patient, or submit a bug fix - the code is <a href="https://github.com/csev" target="_new">here</a>.
</p>
<p>
If you want an extra special challenge, figure out how to <i>game</i> the autograder and
write a program that matches the final output but does not meet the specs.   Warning, 
I have clever code in the autograder to catch you if your output matches but 
you don't meet the specs.  Good luck trying to defeat my sanity checker.
</p>
<p>
And just for fun resize your browser and watch Twitter Bootstrap's response design in action.
</p>
<p>
Comments welcome.
</p>
<p>
Dr. Chuck - 
Fri Dec 21 02:14:00 EST 2012
<?php require_once("footer.php"); ?>
</div>
</body>
