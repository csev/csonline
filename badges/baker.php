<?php

require_once("../config.php");
require_once("png-lib.php");
require_once("badge-lib.php");

$row = getBadgeInfo();

// Make the badge
$file = 'images/'.$row[2].'.png';
$png = file_get_contents($file);
if ( $png === false ) die('Bad id');
$png2 = addOrReplaceTextInPng($png,"openbadges",$CFG->wwwroot."/badges/assert.php?id=".$row[4]);

header('Content-Type: image/png');
header('Content-Length: ' . strlen($png2));

echo($png2);
