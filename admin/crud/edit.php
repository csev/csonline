<?php
require_once "crudstart.php";

$id = false;
if ( isset($_GET['id']) ) {
    $id = intval($_GET['id']);
} else if ( isset($_POST['id']) ) {
    $id = intval($_POST['id']);
}

if ( $id >= 1 ) {
    // Groovy
} else {
    die("Bad value for id");
}

require_once "../../db.php";
require_once "../../sqlutil.php";

$sql = "SELECT ";
for($i=0; $i < count($fields); $i++ ) {
    $sql.= $fields[$i].', ';
}
$sql .= "id FROM $table WHERE id=$id";
$row = retrieve_one_row($sql);
if ( $row == false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( "Location: index.php?table=$table" ) ;
    return;
}

$allthere = true;
$set = "";
if ( count($_POST) > 0 ) {
    for($i=0; $i < count($fields); $i++ ) {
        if ( !isset($_POST[$fields[$i]]) ) {
            $allthere = false;
            die("Missing POST field: ".$fields[$i]);
        }
        if ( strlen($set) > 0 ) $set .= ', ';
        $set .= $fields[$i]."='".mysql_real_escape_string($_POST[$fields[$i]])."'";
    }
    
    if ( $allthere && isset($_GET['id']) ) {
        $sql = "UPDATE $table SET ".$set." WHERE id=$id";
        $retval = run_mysql_query($sql);
        if ( $retval === true ) {
            $_SESSION['success'] = 'Record updated';
        } else {
            $_SESSION['error'] = 'Update failed';
        }
        header( "Location: index.php?table=$table" ) ;
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("../../head.php"); ?>
</head>
<body style="padding: 0px 10px 0px 10px">
<div class="container">
<div style="border-bottom: 1px grey solid; margin-bottom: 5px;">
<?php require_once("../../title.php"); ?>
</div>
<h3>Edit User</h3>
<form method="post">
<input type="hidden" name="id" value="<?php echo($id); ?>">
<input type="hidden" name="table" value="<?php echo($table); ?>">
<?php
for($i=0; $i < count($fields); $i++ ) {
    echo('<label for="'.$fields[$i].'">'.ucfirst($fields[$i])."<br/>\n");
    $value = $row[$i];
    if ( isset($_POST[$fields[$i]]) ) {
        $value = $_POST[$fields[$i]];
    }
    if ( strlen($value) > 60 ) {
        echo('<textarea rows="10" cols="70" name="'.$fields[$i].'">'.htmlentities($value).'</textarea>'."\n");
    } else {
        echo('<input type="text" size="80" name="'.$fields[$i].'" value="'.htmlentities($value).'">'."\n");
    }
    echo("</label>");
}
?>
<input type="submit" value="Update Data">
<a href="index.php?table=<?php echo($table); ?>">Cancel</a></p>
</form>

