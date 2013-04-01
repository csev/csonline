<?php

// https://github.com/mozilla/openbadges/wiki/Assertions

require_once "badge-lib.php";

// Array ( [0] => csev@umich.edu [1] => 2013-01-10 13:51:53 [2] => DCO [3] => Successful Enrollment [4] => 6f5148656951514b546c4862784f50546e773d3d )

$row = getBadgeInfo();

$date = substr($row[1],0,10);
$recepient = 'sha256$' . hash('sha256', $row[0] . $CFG->badge_assert_salt);
$code = $row[2];
$title = $row[3];
error_log('Assertion:'.$row[0].' '.$row[2]);

header('Content-Type: application/json');
?>
{
  "recipient": "<?php echo($recepient); ?>",
  "salt": "<?php echo($CFG->assert_salt); ?>",
  "issued_on": "<?php echo($date); ?>",
  "badge": {
    "version": "1.0.0",
    "name": "<?php echo($title); ?>",
    "image": "<?php echo($CFG->wwwroot.'/badges/images/'.$code.'.png'); ?>",
    "description": "Completed <?php echo($code.' - '.$title.' at '.$CFG->badge_organization); ?>",
    "criteria": "<?php echo($CFG->wwwroot);?>",
    "issuer": {
      "origin": "<?php echo($CFG->wwwroot);?>",
      "name": "<?php echo($CFG->badge_organization);?>",
      "org": "<?php echo($CFG->badge_organization);?>"
    }
  }
}

