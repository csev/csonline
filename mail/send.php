<?php

require_once("../config.php");
if ( ! isCli() ) die("CLI only");

require_once("maillib.php");

$id = 15;
$token = 'b61a7643c655d3bc66a1609d2110abdad0ec568e';
$to = "csev@umich.edu";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";

$retval = mooc_send($to, $subject, $message, $id, $token);
var_dump($retval);

