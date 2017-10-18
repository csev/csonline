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
<?php } ?>
<p>
The purpose of me building my own MOOC infrastructure is too explore some of the areas of teaching and learning 
that I feel are missing from the mainstream MOOC platforms and efforts.  I think that these platforms will eventually address
the issues near and dear to my heart but not quickly enough for me.
</p>
<p>
Don't get me wrong.  I <em>love</em> Coursera and love teaching
on Coursera and love seeing how others teach and learn with Coursera.   I really enjoy teaching my 
<a href="https://www.coursera.org/course/insidetheinternet" target="_blank">Internet History, Technology, and Security</a>,
<a href="https://www.coursera.org/specializations/python" target="_blank">Python for Everybody</a>,
and
<a href="https://www.coursera.org/specializations/web-applications" target="_blank">Web 
Applications for Everybody</a>
Coursera.  
</p>
<p>
Charles Severance - 
Wed Oct 18 18:56:33 EDT 2017
</p>
<?php require_once("footer.php"); ?>
</div>
</body>
