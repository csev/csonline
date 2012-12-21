<?

function retrieve_one_row($sql, $showerror=true) 
{
    $result = run_mysql_query($sql, $showerror);
    $row = mysql_fetch_row($result);
    return $row;
}

function run_mysql_query($sql, $showerror=true)
{
    $result = mysql_query($sql);
    if ( $result === FALSE ) {
        if ( $showerror) error_log('Fail-SQL:'.mysql_error().','.$sql);
        return false;
    }
    return $result;
}
