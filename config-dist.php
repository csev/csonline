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

// No trailing tag to avoid white space
