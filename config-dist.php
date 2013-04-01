<?php // Configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// No trailing slash on these urls
$CFG->wwwroot = 'http://localhost:8888/csonline';
$CFG->staticroot = 'http://localhost:8888/csonline';
$CFG->analytics = false; // 'UA-423997-15';

// Strings in the header and footer
$CFG->site_owner = 'Charles R. Severance';
$CFG->site_owner_page = 'http://www.dr-chuck.com/';
$CFG->site_title  = 'Dr. Chuck Online';
$CFG->site_title_phone = 'D.C.O.';
$CFG->site_title_subtext = 'MOOCs, Standards, and OERs';
$CFG->default_avatar = 'http://en.gravatar.com/avatar/2d0a2f518066c5fd09d757a289b54307?s=80';
$CFG->default_avatar_link = "https://twitter.com/drchuck";

// Set to false if you don't want Mozilla Badge Backpacks in the profile and map
$CFG->badge_display = false; // "https://backpack.openbadges.org/share";
// Badge generation settings - once you start issuing badges - don't change these 
$CFG->badge_organization = 'Dr. Chuck Online';
$CFG->badge_encrypt_password = false; // "somethinglongwithhex387438758974987";
$CFG->badge_assert_salt = false; // "mediumlengthhexstring";

// DEVELOPER = true changes the UI so you avoid doing the wrong thing on your production site
$CFG->DEVELOPER = true;
// OFFLINE = true allows for on-plane development without long timeouts
$CFG->OFFLINE = false;

// This is the gateway into the /admin area - be protective
$CFG->adminpw = 'changeme';

// Database setup
$CFG->database  = 'csonline';
$CFG->dbhost    = '127.0.0.1';
$CFG->dbport    = '8889';
$CFG->dbuser    = 'csonline';
$CFG->dbpass    = 'moocsRus';

// Where the bulk mail comes from - should be a real address with a wildcard box you check
$CFG->maildomain = 'mail.example.com';
// Encodes the URL for the one-click unsubscribe that Google likes (see mail/maillib.php)
$CFG->mailsecret = false; // '2f518066longstring329890348';
$CFG->maildelay = 1;   // Number of seconds to delay between messages sent
$CFG->maileol = "\n";  // Depends on your mailer - may need to be \r\n

// This is the POP infor the the wildcard box
$CFG->pophost = "pop.example.com";
$CFG->poplogin = "*@mail.example.com";
$CFG->poppw = "super-sweet-pop-password";

// This supports the auto-login via long-term cookie (keep me logged in)
$CFG->cookiesecret = '2f518066blahblahlongstring5fd09d757a289b543';
$CFG->cookiename = 'autochuckonline';
$CFG->cookiepad = '390b246ea9';

// Leave this off unless you edit the footer.php code to make it your OLARK
$CFG->OLARK_EXPERIMENTAL = false;

// We use UTC-12 so a deadline works in all time zones
date_default_timezone_set('Etc/GMT-12');

// We fudge starting times forward by 24 hours so that
// start times we publish make sense in all time zones
function start_time() {
    return time() + 24 * 60 * 60;
}

require_once("lib.php");

// No trailing tag to avoid white space
