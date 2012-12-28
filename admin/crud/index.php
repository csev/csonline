<?php
require_once "crudstart.php";
require_once "../../db.php";
require_once "../../sqlutil.php";
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("../../head.php"); ?>
</head>
<body style="padding: 0px 10px 0px 10px">
<div class="container">
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

$sql = "SELECT ";
echo '<table border="1">'."\n<tr>";
for($i=0; $i < $info[0]; $i++ ) {
    $sql.= $fields[$i].', ';
    echo("<th>".ucfirst($fields[$i])."</th>\n");
}
echo("<th>Action</th>\n");
echo("</tr>\n"); 
$sql .= "id FROM $table";

$result = run_mysql_query($sql);
while ( $row = mysql_fetch_row($result) ) {
    echo("<tr>");
    for($i=0; $i < $info[0]; $i++ ) {
        echo("<td>");
        if ( $i == 0 ) echo('<a href="view.php?id='.htmlentities($row[$info[0]]).'&table='.htmlentities($table).'">');
        echo(htmlentities($row[$i]));
        if ( $i == 0 ) echo("</a>\n");
        echo("</td>\n");
    }
    echo("<td>\n");
    echo('<a href="edit.php?id='.htmlentities($row[$i]).'&table='.htmlentities($table).'">Edit</a> / ');
    echo('<a href="delete.php?id='.htmlentities($row[$i]).'&table='.htmlentities($table).'">Delete</a>');
    echo("</td></tr>\n");
}
?>
</table>
<a href="add.php?table=<?php echo(htmlentities($table)); ?>">Add New</a>

