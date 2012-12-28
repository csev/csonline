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

$sql = "SELECT ".$fields[0].", id FROM $table WHERE id=$id";
$row = retrieve_one_row($sql);
if ( $row == false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( "Location: index.php?table=$table" ) ;
    return;
}

if ( isset($_POST['delete']) ) {
    $sql = "DELETE FROM $table WHERE id = $id";
    $retval = run_mysql_query($sql);
    if ( $retval === true ) {
        $_SESSION['success'] = 'Record deleted';
    } else {
        $_SESSION['error'] = 'Record not deleted';
    }
    header( "Location: index.php?table=$table" ) ;
    return;
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
<?php
echo "<p>Confirm: Deleting $row[0]</p>\n";

echo('<form method="post"><input type="hidden" ');
echo('name="id" value="'.$row[1].'">'."\n");
echo('<input type="submit" value="Delete" name="delete"> ');
echo('<a href="index.php?table='.$table.'">Cancel</a>');
echo("\n</form>\n");
?>
