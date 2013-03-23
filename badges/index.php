<?php

// http://www.onlinebadgemaker.com/

require_once("../start.php");
require_once("../sqlutil.php");
require_once("../db.php");
require_once("../crypt/aes.class.php");
require_once("../crypt/aesctr.class.php");

if ( ! isset($_SESSION['id']) ) {
    header('Location: ../login.php');
    return;
}
?>
<html>
<head>
<title>The World's Easiest Mozilla Open Badge Maker (Beta)</title>
<!-- https://github.com/mozilla/openbadges/wiki/Issuer-API -->
<script src="http://beta.openbadges.org/issuer.js"></script>
</head>
<body style="font-family:sans-serif;">
<h2>Your Badges...</h2>
<?php
if ( ! isset($_SESSION['email']) ) return;

$decrypted = $_SESSION['id'].':0';

$encrypted = bin2hex(AesCtr::encrypt($decrypted, $CFG->encrypt_password, 256));
?>
<p>Here is the badge baked especially for for <?php echo(htmlspecialchars($_SESSION['email'])); ?> <br/>
<a href="images/baker.php?id=<?php echo($encrypted); ?>.png" target="_blank">
<img src="images/baker.php?id=<?php echo($encrypted); ?>.png"></a>
<p>
<a href="#" onclick="OpenBadges.issue(
['https://online.dr-chuck.com/badges/assert.php?id=<?php echo($encrypted); ?>'],
function(errors, successes) { });">Add this Badge to my Mozilla Badge Backpack</a>
</p>
<p>You can also download the baked badge image to your computer and display it on your 
web site or maually upload it to your
<a href="http://beta.openbadges.org" target="_blank">Mozilla Badge Backpack</a>.
</p>
<?php

$sql = 'SELECT Courses.id, code, title, description,
        Enrollments.id, cert_at
        FROM Courses LEFT OUTER JOIN Enrollments
        ON Courses.id = course_id
        AND Enrollments.user_id = '.$_SESSION['id'].'
        WHERE cert_at IS NOT NULL
        ORDER BY cert_at DESC';

$result = mysql_query($sql);
if ( $result === FALSE ) {
    echo('Fail-SQL:'.mysql_error().','.$sql);
    echo("Unable to retrieve courses...");
    return;
}

while ( $row = mysql_fetch_row($result) ) {
   print_r($row);
}
