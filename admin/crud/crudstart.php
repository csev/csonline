<?php
ini_set('default_charset', 'utf-8');
ini_set('mbstring.internal_encoding','UTF-8');
require_once "../../config.php";
session_start();
if ( ! isAdmin() ) {
    header("Location: ../../index.php");
    return;
}

if ( ! headers_sent() ) header('Content-Type: text/html; charset=utf-8');

require_once "crud.php";

$table = false;
if ( isset($_GET['table']) ) $table = $_GET['table'];
if ( $table === false && isset($_POST['table']) ) $table = $_POST['table'];

if ( $table === false || ! isset($tables[$table]) || ! isset($tableinfo[$table]) ) {
    die("Valid table parameter required $table");
}

$fields = $tables[$table];
$info = $tableinfo[$table];

