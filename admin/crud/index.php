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

function do_form($values, $override=Array()) {
    foreach (array_merge($values,$override) as $key => $value) {
        if ( $value === false ) continue;
        if ( is_string($value) && strlen($value) < 1 ) continue;
        if ( is_int($value) && $value === 0 ) continue;
        echo('<input type="hidden" name="'.htmlentities($key).
             '" value="'.htmlentities($value).'">'."\n");
    }
}

function do_url($values, $override=Array()) {
    $retval = '';
    foreach (array_merge($values,$override) as $key => $value) {
        if ( $value === false ) continue;
        if ( is_string($value) && strlen($value) < 1 ) continue;
        if ( is_int($value) && $value === 0 ) continue;
        if ( strlen($retval) > 0 ) $retval .= '&';
        $retval .= urlencode($key) . "=" . urlencode($value);
    }
    return $retval;
}
$values = Array();
if ( isset($_GET['search_text']) ) {
    $search = $_GET['search_text'];
    if ( strlen($search) < 1 ) $search = '';
    $values['search_text'] = $search;
}

$page_start = 0;
if ( isset($_GET['page_start']) ) {
    $page_start = $_GET['page_start'] + 0;
    if ( $page_start < 0 ) $page_start = 0;
    if ( $page_start != 0 ) $values['page_start'] = $page_start;
}

$order_by = '';
if ( isset($_GET['order_by']) ) { 
    $order_by = $_GET['order_by'];
    if ( strlen($order_by) < 1 ) $order_by = '';
    $values['order_by'] = $order_by;
}

$desc = '';
if ( isset($_GET['desc']) ) { 
    $desc = $_GET['desc']+0;
    $values['desc'] = $desc;
}

$values['table'] = $table;

?>
<?php
$sql = "SELECT ";
for($i=0; $i < $info[0]; $i++ ) {
    $sql.= $fields[$i].', ';
}
$sql .= "id FROM $table";

if ( isset($values['search_text']) ) {
    $searchtext = '';
    for($i=0; $i < $info[0]; $i++ ) {
        if ( $i > 0 ) $searchtext .= " OR ";
        $searchtext .= $fields[$i]." LIKE '%".mysql_real_escape_string($values['search_text'])."%'";
    }
    $sql .= " WHERE " . $searchtext;
}

if ( isset($values['order_by']) ) {
    $sql .= " ORDER BY ".mysql_real_escape_string($values['order_by'])." ";
    if ( $desc == 1 ) {
        $sql .= "DESC ";
    }
}

if ( $page_start < 1 ) {
    $sql .= " LIMIT ".($page_length+1);
} else {
    $sql .= " LIMIT ".$page_start.", ".($page_length+1);
}

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
    $page_back = $page_start - $page_length;
    if ( $page_back < 0 ) $page_back = 0;
    do_form($values,Array('page_start' => $page_back));
    echo("</form>\n");
}
if ( $have_more ) {
    echo('<form style="display: inline">');
    echo('<input type="submit" value="Next"> ');
    $page_next = $page_start + $page_length;
    do_form($values,Array('page_start' => $page_next));
    echo("</form>\n");
}
echo("</div>\n");
echo('<form>');
echo('<input type="text" value="'.htmlentities($search).'" name="search_text">');
do_form($values,Array('search_text' => false, 'page_start' => false));
echo('<input type="submit" value="Search">');
echo("</form>\n");

echo('<table border="1">');
echo("<tr>\n");

for($i=0; $i < $info[0]; $i++ ) {
    $field = $fields[$i];
    $override = Array('order_by' => $field, 'desc' => 0, 'page_start' => false);
    $d = $desc;
    $color = "black";
    if ( $field == $order_by || $order_by == '' && $field == 'id' ) {
        $d = ($desc + 1) % 2;
        $override['desc'] = $d;
        $color = $d == 1 ?  'green' : 'red';
    }
    $stuff = do_url($values,$override);
    echo('<th>');
    echo(' <a href="index.php');
    if ( strlen($stuff) > 0 ) {
        echo("?");
        echo($stuff);
    }
    echo('" style="color: '.$color.'">');
    echo(ucfirst($field));
    echo("</a></th>\n");
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

<div style="height:300px"></div>
<pre>
<?php echo($sql); ?>
</pre>
