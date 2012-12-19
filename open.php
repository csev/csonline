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
<p>
If you are a teacher and interested in reusing my materials, this is my plan:
<ul>
<li>My textbook is Creative Commmons Share Alike - so it is free in PDF form - I need to get it into HTML and EPUB3 form ASAP</li>
<li>All my lecture slides will be Creative Commons - they are in Apple's Keynote as their native format - but I export them to PowerPoint
and make that available - they are not as pretty but with a little cleanup they work.</li>
<li>All of my recorded videos will be up on YouTube and you can use them any way you like.   If you want to track the 
videos like I do, I have an IMS Learning Tools Interoperability tool that wraps the videos in an iframe and does tracking.  This
tool is written in PHP and is open source.  Depending on performance, I may be able to give you a key and let you 
use my instance of the YouTube tracker.   With a key, you could set up your own videos to be tracked and have the tracking results sent back to your LMS 
via IMS LTI 1.1.</li>
<li>My autograder is also an IMS Learning Tools Interoperability tool - it is also PHP 
and open source so you could easily install it yourself.
Again for small/medium clases, I can give you a key so you can use my UMich-hosted instance of the autograder for free.
You can use the autograder directly without a key - but if you want it to pass grades to your LMS automatically, 
we need to set up a key.
</li>
<li>I should be able to get this into an IMS Common Cartridge format as well and once I did that, the course could be imported 
into D2L, Sakai, Balckboard Learn, Canvas, etc.</li>
<li>I am doing this in Moodle and I will provide you with a Moodle Backup of the Course and instructions on how to drop it into your Moodle.</li>
<li>I may even let folks use my Moodle instance to host their own classes using my dr-chuck online system and its associated Moodle.  
Maybe I will make a one-click way to whip up a new instance of a course for a roster of your choosing.
Heck - who knows where I go with this.
</ul>
<p>
So give me a little time and stay in touch if you are a teacher interested in reusing this content, software, or technology.  I should 
probably start a Google Community or something about this... Hmmm.  For now I need to write code.
</p>
<p>
Charles Severance - 
Thu Dec 13 18:54:33 EST 2012
</p>
<?php require_once("footer.php"); ?>
</div>
</body>
