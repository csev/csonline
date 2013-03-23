<?php

require_once "../../config.php";
require_once "png-lib.php";
require_once("../../crypt/aes.class.php");
require_once("../../crypt/aesctr.class.php");
require_once("hex2bin.php");
require_once("badge-lib.php");

$row = getBadgeInfo();

// Make the badge
$file = '../'.$row[2].'.png';
$png = file_get_contents($file);
if ( $png === false ) die('Bad id');
$png2 = addOrReplaceTextInPng($png,"openbadges","http://online.dr-chuck.com/badges/assert.php?id=".$encrypted);

header('Content-Type: image/png');
header('Content-Length: ' . strlen($png2));

echo($png2);
