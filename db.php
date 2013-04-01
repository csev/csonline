<?php
require_once("config.php");
$mysqlhost = $CFG->dbhost;
if ( strlen($CFG->dbport) > 0 ) $mysqlhost .= ':' . $CFG->dbport;
$db = mysql_connect($mysqlhost, $CFG->dbuser, $CFG->dbpass)
     or die('Database connection unavailable');
mysql_select_db($CFG->database) 
     or die('Database connection unavailable');

// No trailing tag to avoid white space
