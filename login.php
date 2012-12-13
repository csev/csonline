<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'lightopenid/openid.php';
try {
    $openid = new LightOpenID('online.dr-chuck.com');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            // $openid->identity = 'http://specs.openid.net/auth/2.0/server';
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            $openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
            header('Location: ' . $openid->authUrl());
        }
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>
</head>
<body style="padding: 0px 10px 0px 10px">
<?php require_once("title.php"); ?>
<p>
We use Google Accounts as our sole login.  You must have a Google account and we will require your
name and email address to login.  We do not need and do not receive your password - only Google
will ask you for your password.  When you press login below, you will be directed to the Google
authentication system where you will be given the option to share your information with this site.
</p>
<p>
We will never share your data and will only sent you E-Mail related to course communication and we will
try to limit that to 1-3 times per week.  Every mail we send will have a mail deactivation link so you 
can opt out of any mail from our system.
</p>
<form action="?login" method="post">
    <button class="btn">Login with Google</button>
    <input class="btn" type="button" onclick="location.href='index.php'; return false;" value="Do Not Log In"/>
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
      $userAttributes = $openid->getAttributes();
         $firstName = $userAttributes['namePerson/first'];
         $lastName = $userAttributes['namePerson/last'];
         $userEmail = $userAttributes['contact/email'];
         echo 'Your name: '.$firstName.' '.$lastName.'<br />';
         echo("Your email address is: ".$userEmail."<br/>");
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}

require_once("footer.php");
?>
</body>
