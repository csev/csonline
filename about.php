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
The purpose of me building my own MOOC infrastructure is too explore some of the areas of teaching and learning 
that I feel are missing from the mainstream MOOC platforms and efforts.  I think that these platforms will eventually address
the issues near and dear to my heart but not quickly enough for me.
</p>
<p>
Don't get me wrong.  I <em>love</em> Coursera and love teaching
on Coursera and love seeing how others teach and learn with Coursera.   I am really looking forward to teaching my 
<a href="https://www.coursera.org/course/insidetheinternet">Internet History, Technology, and Security</a> course on 
Coursera starting March 1, 2013.  
I also am taking pedagogy and technical inspiration from the excellent Coursera 
<a href="https://www.coursera.org/course/interactivepython" target="_blank">Interactive Programming in Python</a> 
course taught by Joe Warren, Scott Rixner, John Greiner, and Stephen Wong of Rice University. I would suggest that after 
students complete my course, if they are interested in more programming, that they would take the Rice course.
The technology I use here will never be as slick as Coursera because I am one person
putting this all together with no financial support or an army of grad students - I am lashing open source stuff 
together to make my own MOOC.  
</p>
<p>
I would also love to use the open source <a href="http://class.stanford.edu">Stanford Class2Go</a> but it is not quite ready for
use outside of Stanford.  My technical approach is very much influenced by Stanford's "don't build it if you don't have to" approach - 
but I am going to take it even further than they have taken it.  I am going to 
<a href="http://www.youtube.com/watch?v=F7IZZXQ89Oc" target="_blank">turn it up to 11</a> - at least in my use of 
standards and open content.  
</p>
<p>
My goal once I gain experience with this approach and my prototype pieces work successfully is to make it so that this 
class can be a MOOC in any MOOC or LMS platform including 
Coursera, 
Class2Go, 
CourseSites, 
Sakai, 
Moodle, 
Blackboard, 
GradeCraft,
Joule, or 
Canvas.  I picked Moodle first because it has the best 
<a href="https://moodle.org/plugins/view.php?plugin=local_ltiprovider&moodle_version=10" target="_blank">IMS LTI Provider</a> support thanks to 
<a href="https://twitter.com/jleyvadelgado" target="_blank">Juan Levya</a>.
All the software I write will be open source and all the content I build will be Creative Commons Attribution.
I want this all to be used as examples and remixed.
</p>
<p>
The technology I am using includes
<a href="http://www.moodle.org" target="_blank">Moodle</a>, 
<a href="http://www.piazza.com" target="_blank">Piazza</a>, 
<a href="http://www.youtube.com" target="_blank">YouTube</a>, 
<a href="http://translate.google.com/manager/website/suggestions" target="_blank">Google WebSite Translation</a>,
<a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a>,
and 
<a href="http://www.sakaiproject.org/" target="_blank">Sakai</a>, 
as well as using
<a href="http://developers.imsglobal.org" target="_blank">IMS Learning Tools Interoperability</a> to implement my 
service-oriented mashup of functionality.
</p>
<p>
My first course is based on my free/open book titled <a href="http://www.pythonlearn.com" target="_blank">Python 
for Informatics: Exploring Data</a>.  I keep most of my cool stuff in 
<a href="https://github.com/csev" target="_blank">GitHub</a> - and even this site is 
<a href="https://github.com/csev/csonline" target="_blank">on GitHub</a>.
</p>
<p>
If you are a teacher and interested in reusing my materials, this is my plan:
<ul>
<li>My textbook is Creative Commmons Share Alike - so it is free in PDF form - I need to get it into HTML and EPUB3 form ASAP</li>
<li>All my lecture slides will be Creative Commons - they are in Apple's Keynote as their native format - but I export them to PowerPoint
and make that available for you to download - 
they are not as pretty as Keynote but with a little cleanup they work.</li>
<li>All of my recorded videos will be up on YouTube and you can use them any way you like.   
</li>
<li>My autograder is an IMS Learning Tools Interoperability tool - it is also PHP 
and open source so you could easily install it yourself.
Again for small/medium clases, I can give you a key so you can use my UMich-hosted 
instance of the autograder for free.
You can use the autograder directly without a key - but if you want it to pass 
grades to your LMS automatically, 
we need to set up a key.
</li>
<li>I should be able to get this into an IMS Common Cartridge format as well and once I did that, the course could be imported 
into D2L, Sakai, Blackboard Learn, Canvas, etc.</li>
<li>I am doing this in Moodle and I will provide you with a Moodle backup of the course and instructions on how to drop it into your Moodle.</li>
<li>I may even let folks use my Moodle instance to host their own classes using my dr-chuck online system and its associated Moodle.  
Maybe I will make a one-click way to whip up a new instance of a course for a roster of your choosing.
Heck - who knows where I go with this.
</ul>
<p>
So give me a little time and stay in touch if you are a teacher interested in reusing this content, software, or technology.  I should 
probably start a Google Community or something about this... Hmmm.  For now I need to write code.
</p>
<p>
This experiment is hosted on servers provided to me at no charge by the 
<a href="http://www.si.umich.edu/" target="_blank">University of Michigan School of Information</a>
and I am very thankful for that. 
</p>
<p>
Charles Severance - 
Tue Jan 15 20:09:55 EST 2013
</p>
<?php require_once("footer.php"); ?>
</div>
</body>
