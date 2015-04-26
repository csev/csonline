<?php

session_start();

require_once "config.php";
require_once "cookie.php";
require_once('lib/vendor/DrChuck/Google/GoogleLogin.php');
require_once('lib/vendor/DrChuck/Google/JWT.php');

$errormsg = false;
$success = false;

$doLogin = false;
$identity = false;
$firstName = false;
$lastName = false;
$userEmail = false;
$userAvatar = false;
$userHomePage = false;

// Google Login Object
$glog = new \DrChuck\Google\GoogleLogin($CFG->google_client_id,$CFG->google_client_secret,
      $CFG->wwwroot.'/log.php',$CFG->wwwroot);

if ( $CFG->OFFLINE ) {
    $identity = 'http://notgoogle.com/1234567';
    $firstName = 'Fake';
    $lastName = 'Person';
    $userEmail = 'fake_person@notgoogle.com';
    $doLogin = true;
    $_SESSION["keeplogin"] = "on";
} else {

    if ( isset($_GET['code']) ) {
        if ( isset($_SESSION['GOOGLE_STATE']) && isset($_GET['state']) ) {
            if ( $_SESSION['GOOGLE_STATE'] != $_GET['state'] ) {
                $errormsg = "Missing important session data - could not log you in.  Sorry.";
                error_log("Google Login state mismatch");
                unset($_SESSION['GOOGLE_STATE']);
            }
        } else {
            $errormsg = "Missing important session data info- could not log you in.  Sorry.";
            error_log("Error missing state");
            unset($_SESSION['GOOGLE_STATE']);
        }

        $google_code = $_GET['code'];
        $authObj = $glog->getAccessToken($google_code);
        $user = $glog->getUserInfo();
        // echo("<pre>\nUser\n");print_r($user);echo("</pre>\n");
        $identity = isset($user->openid_id) ? $user->openid_id : 
            ( isset($user->id) ? $user->id : false );
        $firstName = isset($user->given_name) ? $user->given_name : false;
        $lastName = isset($user->family_name) ? $user->family_name : false;
        $userEmail = isset($user->email) ? $user->email : false;
        $userAvatar = isset($user->picture) ? $user->picture : false;
        $userHomePage = isset($user->link) ? $user->link : false;
        // echo("i=$identity f=$firstName l=$lastName e=$userEmail a=$userAvatar h=$userHomePage\n");
        $doLogin = true;
    }
}

if ( $doLogin ) {
    if ( $identity === false ) {
        error_log('Google-Missing identity');
        $_SESSION["error"] = "Something went wrong with the Google log in.";
        header('Location: index.php');
        return;
    } else if ( $firstName === false || $lastName === false || $userEmail === false ) {
        error_log('Google-Missing:'.$identity.','.$firstName.','.$lastName.','.$userEmail);
        $_SESSION["error"] = "You do not have a first name, last name, and email in Google or you did not share it with us.";
        header('Location: index.php');
        return;
    } else {
        require_once("db.php");
        $X_identity = mysql_real_escape_string($identity);
        $X_firstName = mysql_real_escape_string($firstName);
        $X_lastName = mysql_real_escape_string($lastName);
        $X_userEmail = mysql_real_escape_string($userEmail);
        $X_userHomePage = mysql_real_escape_string($userHomePage);
        $sql = "SELECT id, email, first, last, avatar, twitter,homepage
             FROM Users WHERE identity='$X_identity'";
        $result = mysql_query($sql);
        if ( $result === FALSE ) {
            error_log('Fail-SQL:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.mysql_error().','.$sql);
            $_SESSION["error"] = "Internal database error, sorry";
            header('Location: index.php');
            return;
        }
        $row = mysql_fetch_row($result);
        $theid = false;
        $avatar = false;
        $twitter = false;
        $homepage = false;
        $didinsert = false;
        if ( $row !== FALSE ) { // Lets update!
            $theid = $row[0];
            $avatar = $row[4];
            $twitter = $row[5];
            $homepage = $row[6];
            if ( $row[1] != $userEmail || $row[2] != $firstName 
                || $row[3] != $lastName || $row[6] != $userHomePage ) {
                $sql = "UPDATE Users SET email='$X_userEmail', first='$X_firstName', ".
                        "last='$X_lastName', emailsha=SHA1('$X_userEmail'), ".
                        "homepage='$X_userHomePage', ".
                        "modified_at=NOW(), login_at=NOW() WHERE id='$theid'";
            } else { 
                $sql = "UPDATE Users SET login_at=NOW() WHERE id='$theid'";
            }
            $result = mysql_query($sql);
            if ( $result === FALSE ) {
                error_log('Fail-SQL:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.mysql_error().','.$sql);
                $_SESSION["error"] = "Internal database error, sorry";
                header('Location: index.php');
                return;
            } else {
                error_log('User-Update:'.$identity.','.$firstName.','.$lastName.','.$userEmail);
            }
        } else { // Lets Insert!
            $sql = "INSERT INTO Users (identity, email, first, last, identitysha, emailsha, created_at, modified_at, login_at) ".
                    "VALUES ('$X_identity', '$X_userEmail', '$X_firstName', '$X_lastName', ".
                    "SHA1('$X_identity'), SHA1('$X_userEmail'), NOW(), NOW(), NOW() )";
            $result = mysql_query($sql);
            if ( $result === FALSE ) {
                error_log('Fail-SQL:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.mysql_error().','.$sql);
                $_SESSION["error"] = "Internal database error, sorry";
                header('Location: index.php');
                return;
            } else {
                $theid = mysql_insert_id();
                error_log('User-Insert:'.$identity.','.$firstName.','.$lastName.','.$userEmail.','.$theid);
                $didinsert = true;
            }
        }

        $welcome = "Welcome ";
        if ( ! $didinsert ) $welcome .= "back ";
        $_SESSION["success"] = $welcome.htmlencode($firstName)." ".
                htmlencode($lastName)." (".htmlencode($userEmail).")";
        $_SESSION["id"] = $theid;
        $_SESSION["email"] = $userEmail;
        $_SESSION["first"] = $firstName;
        $_SESSION["last"] = $lastName;
        if ( $avatar !== false && strlen($avatar) > 0 ) $_SESSION["avatar"] = $avatar;
        if ( $twitter !== false && strlen($twitter) > 0 ) $_SESSION["twitter"] = $twitter;
        if ( isset($_SESSION["keeplogin"]) && $_SESSION["keeplogin"] == "on" ) {
            $guid = MD5($identity);
            $ct = create_secure_cookie($theid,$guid);
            setcookie($CFG->cookiename,$ct,time() + (86400 * 45)); // 86400 = 1 day
        }
        unset($_SESSION["keeplogin"]);
        if ( $didinsert ) {
            header('Location: profile.php');
        } else {
            header('Location: index.php');
        }
        return;
    }
}

// We need a login URL
$_SESSION['GOOGLE_STATE'] = md5(uniqid(rand(), TRUE));
$loginUrl = $glog->getLoginUrl($_SESSION['GOOGLE_STATE']);
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
<div style="margin: 30px">
<p>
We here at <?php echo($CFG->site_title); ?> use Google Accounts as our sole login.  
We do this because we want real people participating
in the site with real identities.  
We do not want to spend a lot of time verifying identity 
so we let Google to that hard work.  :)
</p>
<form action="?login" method="post">
    <input class="btn btn-warning" type="button" onclick="location.href='index.php'; return false;" value="Cancel"/>
    <input class="btn btn-primary" type="button" onclick="location.href='<?= $loginUrl ?>'; return false;" value="Login with Google" />
    <?php if ( $CFG->cookiesecret !== false ) { ?>
    <input type="checkbox" name="keeplogin"> Keep me logged in
    <?php } ?>
</form>
<p>
So you must have a Google account and we will require your
name and email address to login.  We do not need and do not receive your password - only Google
will ask you for your password.  When you press login below, you will be directed to the Google
authentication system where you will be given the option to share your information with <?php echo($CFG->site_title); ?>.
</p>
<p>
We will never share your data and will only send you E-Mail related to course 
communication and we will try to limit that to 1-3 times per week.  
Every mail we send will have a mail deactivation link so you can opt out 
of any mail from our system.  
</p>
<p>
If you are still worried about this software and its interaction with Google, you 
or someone else can take a look at the source code to this online registration system 
<a href="https://github.com/csev/csonline" target="_blank">on Github</a> to see what 
we are doing.
</p>
</div>
<?php
require_once("footer.php");
?>
</body>

