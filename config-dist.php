<?php // Configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// No trailing slash
$CFG->wwwroot = 'http://localhost/~csev/csonline';

$CFG->DEVELOPER = true;
$CFG->database  = 'csonline';
$CFG->dbhost    = '127.0.0.1';
$CFG->dbuser    = 'csonline';
$CFG->dbpass    = 'MoocsRock';

$CFG->site_title    = 'Dr. Chuck Online';
$CFG->site_title_phone    = 'DCO';
$CFG->site_title_subtext    = 'MOOCs, Standards, and OERs';
$CFG->default_avatar = 'http://en.gravatar.com/avatar/2d0a2f518066c5fd09d757a289b54307?s=80';
$CFG->default_avatar_link = "https://twitter.com/drchuck";

// No trailing tag to avoid white space
