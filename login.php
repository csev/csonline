<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'lightopenid/openid.php';
$ipaddress = $_SERVER['REMOTE_ADDR'];
$errormsg = false;
try {
    $openid = new LightOpenID('online.dr-chuck.com');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            // $openid->identity = 'http://specs.openid.net/auth/2.0/server';
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            $openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
            $openid->optional = array('namePerson/friendly');
            header('Location: ' . $openid->authUrl());
        }
?>
<?php
    } else {
	if($openid->mode == 'cancel') {
            $errormsg = "You have canceled authentication. That's OK but we cannot log you in.  Sorry.";
            error_log('Google-Cancel:'.$ipaddress);
	} else if ( ! $openid->validate() ) {
            $errormsg = 'You were not logged in by Google.  It may be due to a technical problem.';
            error_log('Google-Fail:'.$ipaddress);
    	} else {
         	$identity = $openid->identity;
      	 	$userAttributes = $openid->getAttributes();
		// echo("\n<pre>\n");print_r($userAttributes);echo("\n</pre>\n");
		$firstName = isset($userAttributes['namePerson/first']) ? $userAttributes['namePerson/first'] : false;
		$lastName = isset($userAttributes['namePerson/last']) ? $userAttributes['namePerson/last'] : false;
		$userEmail = isset($userAttributes['contact/email']) ? $userAttributes['contact/email'] : false;
		if ( $firstName === false || $lastName === false || $userEmail === false ) {
         	    error_log('Google-Missing:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress);
                    $errormsg = "You do not have a first name, last name, and email in Google or you did not share it with us.";
		} else {
         	    error_log('Google-Success:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress);
		}
	}
    }
} catch(ErrorException $e) {
    $errormsg = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>
</head>
<body style="padding: 0px 10px 0px 10px">
<div style="border-bottom: 1px grey solid; margin-bottom: 5px;">
<?php require_once("title.php"); ?>
</div>
<?php
if ( $errormsg !== false ) {
    echo('<div style="margin-top: 10px;" class="alert alert-error">');
    echo($errormsg);
    echo("</div>\n");
}
?>
<p>
We here at Dr. Chuck Online use Google Accounts as our sole login.  
We do this because we want real people participating
in the class with real identities.  And when we give badges to people, we want to do our best to 
give the badges to real human beings.   We do not want to spend a lot of time verifying identity 
so we let Google to that hard work.  :)
</p>
<p>
So you must have a Google account and we will require your
name and email address to login.  We do not need and do not receive your password - only Google
will ask you for your password.  When you press login below, you will be directed to the Google
authentication system where you will be given the option to share your information with Dr. Chuck Online.
</p>
<p>
We will never share your data and will only send you E-Mail related to course communication and we will
try to limit that to 1-3 times per week.  Every mail we send will have a mail deactivation link so you 
can opt out of any mail from our system.  If you think this site abuses your identity or E-Mail information
let me know - this is just one profession named Chuck - it is not a big company. It even sounds weird to 
say "we".
</p>
<p>
<form action="?login" method="post">
    <button class="btn">Login with Google</button>
    <input class="btn" type="button" onclick="location.href='index.php'; return false;" value="Cancel"/>
</form>
</p>
<p>
If you are still worried about this software and its interaction with Google, you 
or someone else can take a look at the source code to this online registration system 
<a href="https://github.com/csev/csonline" target="_new">on Github</a> to see what 
we are doing.
</p>
<?php
require_once("footer.php");
?>
</body>
