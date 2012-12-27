<?

function retrieve_one_row($sql, $showerror=true) 
{
    $result = run_mysql_query($sql, $showerror);
    $row = mysql_fetch_row($result);
    return $row;
}

function run_mysql_query($sql, $showerror=true)
{
    global $CFG;
    $result = mysql_query($sql);
    if ( $result === FALSE ) {
        if ( $showerror) error_log('Fail-SQL:'.mysql_error().','.$sql);
        if ( $CFG->DEVELOPER || isCli() || isset($_SESSION['admin']) ) {
            echo("<pre>\nFAIL-SQL:\n$sql\n\n".mysql_error()."\n</pre>\n");
            die();
        }
        return false;
    }
    return $result;
}
