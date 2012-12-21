<?php
session_start();
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'lightopenid/openid.php';
require_once "config.php";

$ipaddress = $_SERVER['REMOTE_ADDR'];
$errormsg = false;
$success = false;

$doLogin = false;
$identity = false;
$firstName = false;
$lastName = false;
$userEmail = false;

if ( $CFG->OFFLINE ) {
    $identity = 'http://notgoogle.com/1234567';
    $firstName = 'Fake';
    $lastName = 'Person';
    $userEmail = 'fake_person@notgoogle.com';
    $doLogin = true;
} else {
    try {
        // $openid = new LightOpenID('online.dr-chuck.com');
        $openid = new LightOpenID($CFG->wwwroot);
        if(!$openid->mode) {
            if(isset($_GET['login'])) {
                $openid->identity = 'https://www.google.com/accounts/o8/id';
                $openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
                $openid->optional = array('namePerson/friendly');
                header('Location: ' . $openid->authUrl());
                return;
            }
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
                $doLogin = true;
            }
        }
    } catch(ErrorException $e) {
        $errormsg = $e->getMessage();
    }
}

if ( $doLogin ) {
    if ( $firstName === false || $lastName === false || $userEmail === false ) {
        error_log('Google-Missing:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress);
        $_SESSION["error"] = "You do not have a first name, last name, and email in Google or you did not share it with us.";
        header('Location: index.php');
        return;
    } else {
        require_once("db.php");
        $X_identity = mysql_real_escape_string($identity);
        $X_firstName = mysql_real_escape_string($firstName);
        $X_lastName = mysql_real_escape_string($lastName);
        $X_userEmail = mysql_real_escape_string($userEmail);
        $sql = "SELECT id, email, first, last, avatar, twitter FROM Users WHERE identity='$X_identity'";
        $result = mysql_query($sql);
        if ( $result === FALSE ) {
            error_log('Fail-SQL:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress.','.mysql_error().','.$sql);
            $_SESSION["error"] = "Internal database error, sorry";
            header('Location: index.php');
            return;
        }
        $row = mysql_fetch_row($result);
        $theid = false;
        $avatar = false;
        $twitter = false;
        $didinsert = false;
        if ( $row !== FALSE ) { // Lets update!
            $theid = $row[0];
            $avatar = $row[4];
            $twitter = $row[5];
            if ( $row[1] != $userEmail || $row[2] != $firstName || $row[3] != $lastName ) {
                $sql = "UPDATE Users SET email='$X_userEmail', first='$X_firstName', ".
                        "last='$X_lastName', emailsha=SHA1('$X_userEmail'), ".
                        "modified_at=NOW(), login_at=NOW() WHERE id='$theid'";
            } else { 
                $sql = "UPDATE Users SET login_at=NOW() WHERE id='$theid'";
            }
             $result = mysql_query($sql);
            if ( $result === FALSE ) {
                error_log('Fail-SQL:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress.','.mysql_error().','.$sql);
                $_SESSION["error"] = "Internal database error, sorry";
                header('Location: index.php');
                return;
            } else {
                error_log('User-Update:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress);
            }
        } else { // Lets Insert!
            $sql = "INSERT INTO Users (identity, email, first, last, identitysha, emailsha, created_at, modified_at, login_at) ".
                    "VALUES ('$X_identity', '$X_userEmail', '$X_firstName', '$X_lastName', ".
                    "SHA1('$X_identity'), SHA1('$X_userEmail'), NOW(), NOW(), NOW() )";
            $result = mysql_query($sql);
            if ( $result === FALSE ) {
                error_log('Fail-SQL:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress.','.mysql_error().','.$sql);
                $_SESSION["error"] = "Internal database error, sorry";
                header('Location: index.php');
                return;
            } else {
                $theid = mysql_insert_id();
                error_log('User-Insert:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$ipaddress.','.$theid);
                $didinsert = true;
            }
        }

        $welcome = "Welcome ";
        if ( ! $didInsert ) $welcome .= "back ";
        $_SESSION["success"] = $welcome.htmlentities($firstName)." ".
                htmlentities($lastName)." (".htmlentities($userEmail).")";
        $_SESSION["id"] = $theid;
        $_SESSION["email"] = $userEmail;
        $_SESSION["first"] = $firstName;
        $_SESSION["last"] = $lastName;
        if ( $avatar !== false && strlen($avatar) > 0 ) $_SESSION["avatar"] = $avatar;
        if ( $twitter !== false && strlen($twitter) > 0 ) $_SESSION["twitter"] = $twitter;
        if ( $didinsert ) {
            header('Location: profile.php');
        } else {
            header('Location: index.php');
        }
        return;
    }
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
if ( $success !== false ) {
    echo('<div style="margin-top: 10px;" class="alert alert-success">');
    echo($success);
    echo("</div>\n");
}
if ( $CFG->DEVELOPER ) {
    echo '<div class="alert alert-danger" style="margin-top: 10px;">'.
        'Note: Currently this server is running in developer mode.'.
        "\n</div>\n";
}
?>
<p>
We here at Dr. Chuck Online use Google Accounts as our sole login.  
We do this because we want real people participating
in the class with real identities.  
We do not want to spend a lot of time verifying identity 
so we let Google to that hard work.  :)
</p>
<p>
<form action="?login" method="post">
    <button class="btn">Login with Google</button>
    <input class="btn" type="button" onclick="location.href='index.php'; return false;" value="Cancel"/>
</form>
</p>
<p>
So you must have a Google account and we will require your
name and email address to login.  We do not need and do not receive your password - only Google
will ask you for your password.  When you press login below, you will be directed to the Google
authentication system where you will be given the option to share your information with Dr. Chuck Online.
</p>
<p>
We will never share your data and will only send you E-Mail related to course 
communication and we will try to limit that to 1-3 times per week.  
Every mail we send will have a mail deactivation link so you can opt out 
of any mail from our system.  If you think this site abuses your identity or E-Mail information
let me know - this is just one profession named Chuck - it is not 
a big company. It even sounds weird to say "we".
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
