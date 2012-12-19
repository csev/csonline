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
<a href="lms.php?context_id=playground" target="_new">
<img src="MOOCMap-8.jpg" 
alt="logo" cite="Image from Caitlin Holman"
align="right" class="img-rounded box-shadow hidden-phone" style="max-width: 30%; margin: 10px"/>
</a>
<h3>DCO142 - Python for Informatics</h3>
<p>
The MOOC starts January 14, 2013.  Registration should begin about December 18, 2012 
when I get this software working.
I expect the course will take 10 weeks and should take 1-4 hours per week.
</p>
<!--
<p>
Here are your first assignments that you can start right now:
<ul>
<li><a href="http://www.py4inf.com/book.php" target="_new">Get the Free Book</a></li>
<li><a href="http://www.py4inf.com/install.php" target="_new">Install Python 2.7 and a Programmer Text Editor</a></li>
</ul>
<hr/>
-->
<p>
The Playgound will let you play with and help me test the software.   I still need to record
new lecture videos - but the autograder is usable.  See if you can get all 300 points!
<p>
<b>Playground:</b> <a href="lms.php?context_id=playground" target="_new">Launch Python Playground Course</a>
(<a href="lms.php?context_id=playground&debug=11" target="_new">Launch with LTI Debug</a>)
</p>
<p>
These assignments may seem a little weird - but I really want you to be able to use Python to do real data analysis afterwards
so I avoid over simplified or overly automated programming environments.  I want you to really learn how your 
computer works and see the real steps so you 
will be be able to edit Python code and
run it in the command line interface of your operating system.
I want you to have real and useful data analysis skills after you finish this class.
</p>
<?php require_once("footer.php"); ?>
</div>
</body>
