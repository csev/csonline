<?php
require_once "crudstart.php";
require_once "../../db.php";
require_once "../../sqlutil.php";

$allthere = true;
$fieldlist = "";
$values = "";
if ( count($_POST) > 0 ) {
    for($i=0; $i < count($fields); $i++ ) {
        if ( !isset($_POST[$fields[$i]]) ) {
            $allthere = false;
            die("Missing POST field: ".$fields[$i]);
        }
        if ( strlen($fieldlist) > 0 ) $fieldlist .= ', ';
        if ( strlen($values) > 0 ) $values .= ', ';
        $fieldlist .= $fields[$i];
        $values .= "'".mysql_real_escape_string($_POST[$fields[$i]])."'";
    }
    
    if ( $allthere ) {
        $sql = "INSERT INTO $table ( $fieldlist ) VALUES ( $values )";
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
<h3>Add <?php echo($table); ?></h3>
<form method="post">
<input type="hidden" name="table" value="<?php echo($table); ?>">
<?php
for($i=0; $i < count($fields); $i++ ) {
    echo('<label for="'.$fields[$i].'">'.ucfirst($fields[$i])."<br/>\n");
    $value = $row[$i];
    if ( isset($_POST[$field[$i]]) ) {
        $value = $_POST[$field[$i]];
    }
    if ( strlen($value) > 60 ) {
        echo('<textarea rows="10" cols="70" name="'.$fields[$i].'">'.htmlentities($value).'</textarea>'."\n");
    } else {
        echo('<input type="text" size="80" name="'.$fields[$i].'" value="'.htmlentities($value).'">'."\n");
    }
    echo("</label>");
}
?>
<input type="submit" value="Add">
<a href="index.php?table=<?php echo($table); ?>">Cancel</a></p>
</form>

