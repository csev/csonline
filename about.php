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
<div id="mytweets" class="hidden-tablet hidden-phone" style="margin-left: 10px; float:right; width:35%; height:800px;">
<a class="twitter-timeline" href="https://twitter.com/drchuck" data-widget-id="282172185219567616">Tweets by @drchuck</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
<?php } ?>
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
together to make my own MOOC.  I would love to get some funding either from inside University of Michigan or from outside
but I don't have enough spare time to go begging for funds and writing proposals and waiting.  This is about doing.
I do need some resources - so if you have resources to give - contact me.
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
This experiment is hosted on servers provided to me at no charge by the 
<a href="http://www.si.umich.edu/" target="_blank">University of Michigan School of Information</a>
and I am very thankful for that. 
</p>
<p>
Charles Severance - 
Fri Dec 21 12:49:16 EST 2012
</p>
<?php require_once("footer.php"); ?>
</div>
</body>
