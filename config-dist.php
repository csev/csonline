<?php // Configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// No trailing slash
$CFG->wwwroot = 'http://localhost/~csev/csonline';
$CFG->analytics = 'UA-999999-15';

$CFG->DEVELOPER = true;
$CFG->OFFLINE = true;   // Loads stuff locally - good for airplanes

$CFG->database  = 'csonline';
$CFG->dbhost    = '127.0.0.1';
$CFG->dbuser    = 'csonline';
$CFG->dbpass    = 'MoocsRock';

$CFG->cookiesecret = 'Awesomely cool secret';
$CFG->cookiename = 'chuckonline';
$CFG->cookiepad = 'Something even trickier';

$CFG->site_title    = 'Dr. Chuck Online';
$CFG->site_title_phone    = 'DCO';
$CFG->site_title_subtext    = 'MOOCs, Standards, and OERs';
$CFG->default_avatar = 'http://en.gravatar.com/avatar/2d0a2f518066c5fd09d757a289b54307?s=80';
$CFG->default_avatar_link = "https://twitter.com/drchuck";

// We use UTC-12 so a deadline works in all time zones
date_default_timezone_set('Etc/GMT-12');

// We fudge starting times forward by 24 hours so that
// start times we publish make sense in all time zones
function start_time() {
    return time() + 24 * 60 * 60;
}

// No trailing tag to avoid white space

