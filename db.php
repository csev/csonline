<?php
require_once("config.php");
$db = mysql_connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass)
     or die('Database connection unavailable');
mysql_select_db($CFG->database) 
     or die('Database connection unavailable');

// No trailing tag to avoid white space
