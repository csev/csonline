<?php

// https://github.com/mozilla/openbadges/wiki/Assertions

require_once "config.php";

if ( !isset($_GET['id']) ) die("Missing id parameter");

$encrypted = $_GET['id'];
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($PASSWORD), hex2bin($encrypted), MCRYPT_MODE_CBC, md5(md5($PASSWORD))), "\0");

$recepient = 'sha256$' . hash('sha256', $decrypted . $ASSERT_SALT);

// header('Content-Type: application/json');
?>
{
  "recipient": "<?php echo($recepient); ?>",
  "salt": "<?php echo($ASSERT_SALT); ?>",
  "issued_on": "2013-19-03",
  "badge": {
    "version": "1.0.0",
    "name": "Dr. Chuck's Easy-Bake Badge Baker",
    "image": "https:\/\/online.dr-chuck.com\/badges\/badge-baker.png",
    "description": "A person was clever enough to find the easiest badge to earn in the world..",
    "criteria": "https:\/\/online.dr-chuck.com\/",
    "issuer": {
      "origin": "https:\/\/online.dr-chuck.com",
      "name": "Easy Badge Baker",
      "org": "Dr. Chuck"
    }
  }
}

