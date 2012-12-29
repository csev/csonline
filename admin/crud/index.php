<?php
require_once "crudstart.php";
require_once "../../db.php";
require_once "../../sqlutil.php";
$page_length = 20;
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
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

$search = '';
if ( isset($_GET['search_text']) ) {
    $search = $_GET['search_text'];
    if ( strlen($search) < 1 ) $search = '';
}
$page_start = 0;
if ( isset($_GET['page_start']) ) {
    $page_start = $_GET['page_start'] + 0;
}
if ( $page_start < 0 ) $page_start = 0;

$order_by = '';
if ( isset($_GET['order_by']) ) { 
    $order_by = $_GET['order_by'];
}
?>
<?php
$sql = "SELECT ";
for($i=0; $i < $info[0]; $i++ ) {
    $sql.= $fields[$i].', ';
}
$sql .= "id FROM $table";

if ( strlen($search) > 0 ) {
    $searchtext = '';
    for($i=0; $i < $info[0]; $i++ ) {
        if ( $i > 0 ) $searchtext .= " OR ";
        $searchtext .= $fields[$i]." LIKE '%".mysql_real_escape_string($search)."%'";
    }
    $sql .= " WHERE " . $searchtext;
}

if ( strlen($order_by) > 0 ) {
    $sql .= " ORDER BY ".mysql_real_escape_string($order_by)." ";
}

if ( $page_start <= 0 ) {
    $sql .= " LIMIT ".($page_length+1);
} else {
    $sql .= " LIMIT ".$page_start.", ".($page_length+1);
}

// echo($sql);echo("<hr>");

$count = 0;
$result = run_mysql_query($sql);
$rows = Array();
while ( $row = mysql_fetch_row($result) ) {
    array_push($rows, $row);
    $count = $count + 1;
}

$have_more = false;
if ( $count > $page_length ) {
    $have_more = true;
    $count = $page_length;
}

echo('<div style="float:right">');
if ( $page_start > 0 ) {
    echo('<form style="display: inline">');
    echo('<input type="submit" value="Back">');
    echo('<input type="hidden" name="table" value="'.htmlentities($table).'">');
    echo('<input type="hidden" value="'.$search.'" name="search_text">');
    $page_back = $page_start - $page_length;
    if ( $page_back < 0 ) $page_back = 0;
    echo('<input type="hidden" value="'.$page_back.'" name="page_start">');
    echo("</form>\n");
}
if ( $have_more ) {
    echo('<form style="display: inline">');
    echo('<input type="submit" value="Next"> ');
    echo('<input type="hidden" name="table" value="'.htmlentities($table).'">');
    echo('<input type="hidden" value="'.$search.'" name="search_text">');
    $page_next = $page_start + $page_length;
    echo('<input type="hidden" value="'.$page_next.'" name="page_start">');
    echo("</form>\n");
}
echo("</div>\n");
echo('<form>');
echo('<input type="hidden" name="table" value="'.htmlentities($table).'">');
echo('<input type="text" value="'.htmlentities($search).'" name="search_text">');
echo('<input type="hidden" value="'.$page_start.'" name="page_start">');
echo('<input type="submit" value="Search">');
echo("</form>\n");

echo('<table border="1">');
echo("<tr>\n");

for($i=0; $i < $info[0]; $i++ ) {
    echo("<th>".ucfirst($fields[$i])."</th>\n");
}
echo("<th>Action</th>\n");
echo("</tr>\n"); 

for ($pos=0; $pos<$count; $pos++ ) {
    $row = $rows[$pos];
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

