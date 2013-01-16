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
<iframe width="450" height="253" src="https://www.youtube.com/embed/hRNFBhEykcY" frameborder="0" allowfullscreen></iframe>
</div>
<? } ?>
<p>
This is very much my own experiment in quickly building a MOOC infrastructure out
of open source pieces glued together with IMS LTI.  This is very much <b>Beta</b>
software.  Don't expect it to be as polished as 
<a href="http://www.coursera.org/" target="_blank">Coursera</a> - the goal here is to explore
more of the dimensions of <a href="about.php">what it means to be a MOOC</a>.
</p>
<?php if ( ! $CFG->OFFLINE ) { ?>
<div class="hidden-phone visible-tablet" style="width: 560; margin:10px;">
<center>
<iframe width="450" height="253" src="https://www.youtube.com/embed/hRNFBhEykcY" frameborder="0" allowfullscreen></iframe>
</center>
</div>
<? } ?>
<p>
If you want to report a significant bug - let me know on Twitter
<a href="https://twitter.com/drchuck" target="_blank">@drchuck</a>.
If you have non-critical bugs or problems, let me know in the discussion
forum in Moodle (provided by <a href="http://piazza.com" target="_blank">Piazza</a>).
Be patient, or submit a bug fix - the code is <a href="https://github.com/csev" target="_blank">here</a>.
</p>
<p>
If you want an extra special challenge, figure out how to <i>game</i> the 
Python autograder and
write a program that matches the final output but does not meet the specs.   Warning, 
I have clever code in the autograder to catch you if your output matches but 
you don't meet the specs.  Good luck trying to defeat my sanity checker.
</p>
<p>
Comments welcome.
</p>
<p>
Dr. Chuck - 
Tue Jan 15 20:05:13 EST 2013
<?php require_once("footer.php"); ?>
</div>
</body>
