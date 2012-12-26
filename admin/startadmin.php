<?php
require_once("../config.php");
session_start();
if ( ! isset($_SESSION["id"]) || ! isset($CFG->adminpw) ) {
    header('HTTP/1.x 404 Not Found'); 
    die();
}

if ( ! isset($_SESSION['admin']) ) {
    header('Location: login.php');
    return;
}
