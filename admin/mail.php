<?php
require_once("startadmin.php");
require_once("../db.php");
require_once("../sqlutil.php");

$sql = "SELECT DISTINCT email FROM Users LIMIT 5000";

$result = run_mysql_query($sql);
if ( $result !== false ) {
    echo("<p>\n");
    $i = 0;
    while ( $row = mysql_fetch_row($result) ) {
        if ( $i > 0 ) echo(", ");
        $i = $i + 1;
        echo(htmlentities($row[0]) );
    }
    echo("</p>\n");
}
