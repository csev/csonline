<?php

// http://www.onlinebadgemaker.com/

require_once("start.php");
require_once("sqlutil.php");
require_once("db.php");
require_once("crypt/aes.class.php");
require_once("crypt/aesctr.class.php");

if ( ! isset($_SESSION['id']) ) {
    header('Location: login.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://beta.openbadges.org/issuer.js"></script>
<?php require_once("head.php"); ?>
<!-- https://github.com/mozilla/openbadges/wiki/Issuer-API -->
</head>
<body style="padding: 0px 10px 0px 10px" onload="initialize()">
<div class="container">
<?php require_once("nav.php"); ?>
<h2>You have earned the following badges.</h2>
          <div class="row-fluid">
            <ul class="thumbnails">
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
   $decrypted = $_SESSION['id'].':'.$row[0];
   $encrypted = bin2hex(AesCtr::encrypt($decrypted, $CFG->encrypt_password, 256));
?>
              <li class="span4">
                <div class="thumbnail">
<a href="badges/<?php echo($encrypted); ?>.png" target="_blank">
<img align="right" src="badges/<?php echo($encrypted); ?>.png" width="90"></a>
                  <div class="caption">
                    <h3><?php echo(htmlentities($row[1])); ?> - <?php echo(htmlentities($row[2]));?></h3>
                    <p><?php echo($row[3]); ?><p>
<p>
<a href="#" class="btn btn-primary" onclick="OpenBadges.issue(
['https://online.dr-chuck.com/badges/assert.php?id=<?php echo($encrypted); ?>'],
function(errors, successes) { });">Add to Mozilla Backpack</a>
</p>
                  </div>
                </div>
              </li>
<?php
}
$decrypted = $_SESSION['id'].':0';
$encrypted = bin2hex(AesCtr::encrypt($decrypted, $CFG->encrypt_password, 256));
?>
              <li class="span4">
                <div class="thumbnail">
<a href="badges/<?php echo($encrypted); ?>.png" target="_blank">
<img align="right" src="badges/<?php echo($encrypted); ?>.png" width="90"></a>
                  <div class="caption">
                    <h3>Admitted Student</h3>
                    <p>You earn this badge when you join Dr. Chuck Online and set up your profile.</p>
<p>
<a href="#" class="btn btn-primary" onclick="OpenBadges.issue(
['https://online.dr-chuck.com/badges/assert.php?id=<?php echo($encrypted); ?>'],
function(errors, successes) { });">Add to Mozilla Backpack</a>
</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
<p>You earn your first badge by simply joning Dr. Chuck Online and setting up your profile.
It is a good way to experiment with how badges work if you have never used a badge before.
You can also clink on ia badge image and ave it to your computer and display it on your 
web site or maually upload it to your
<a href="http://beta.openbadges.org" target="_blank">Mozilla Badge Backpack</a>.
</p>
</body>
</html>

