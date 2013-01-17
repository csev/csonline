<?php

function isAdmin() {
   return isset($_SESSION['admin']);
}

function loggedIn() {
   return isset($_SESSION['id']);
}

function isCli() {
    return "cli" == php_sapi_name();
}

// Fix after PHP 5.4
function htmlencode($string) {
    return htmlentities($string, ENT_COMPAT, 'UTF-8');
}

