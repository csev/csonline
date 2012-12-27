<?php
require_once("config.php");

function compute_mail_check($identity) {
    global $CFG;
    return sha1($CFG->mailsecret . '::' . $identity);
}

