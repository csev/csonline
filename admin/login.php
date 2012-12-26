<?php 
require_once("../config.php");
require_once("../cookie.php");

session_start();
if ( ! isset($_SESSION["id"]) ) {
    header('HTTP/1.x 404 Not Found'); 
    die();
}

if ( isset($_POST['passphrase']) ) {
    if ( $_POST['passphrase'] == $CFG->adminpw ) {
        $_SESSION["admin"] = "yes";
        error_log("Admin login successful id=".$_SESSION['id'].' email='.$_SESSION['email']);
        header("Location: index.php");
    } else {
        $fails = 0;
        error_log("Admin login bad PW id=".$_SESSION['id'].' email='.$_SESSION['email']);
        if ( isset($_SESSION['fails']) ) $fails = $_SESSION['fails'];
        $fails = $fails + 1;
        $_SESSION['fails'] = $fails;
        if ( $fails >= 3 ) {
            header("Location: ../logout.php");
            return;
        }
    }
}

?>
<html>
<head>
</head>
<body>
<form method="post">
<label for="passphrase"><br/>
<input type="password" name="passphrase" size="80">
</label>
<input type="submit">
</form>
