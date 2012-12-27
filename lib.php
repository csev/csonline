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

