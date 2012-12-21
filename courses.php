<?php
require_once("config.php");
require_once("sqlutil.php");
require_once("db.php");

    session_start();

$courserow = false;
$enrollmentrow = false;
if ( isset($_SESSION['id']) && isset($_POST['id']) ) {
    $id = mysql_real_escape_string($_POST['id']);
    $sql = "SELECT id FROM Courses WHERE id='$id'";
    $courserow = retrieve_one_row($sql);
    if ( is_string($courserow) ) {
        $_SESSION['error'] = "Unable to retrieve course";
        header('Location: courses.php');
        return;
    }
    $sql = "SELECT id FROM Enrollments WHERE course_id='$id' 
        AND user_id=".$_SESSION['id'];
    $enrollmentrow = retrieve_one_row($sql,false);
}


if ( $courserow !== false && isset($_POST['action']) && $_POST['action'] == "enroll" ) {
    if ( $enrollmentrow == false ) {
        $sql = "INSERT INTO Enrollments 
            (course_id, user_id, role, created_at, modified_at) VALUES
            ('$id', '".$_SESSION['id']."', 1, NOW(), NOW())";
        $result = run_mysql_query($sql);
        if ( $result == false || mysql_affected_rows() < 1 ) {
            $_SESSION['error'] = "Unable to create enrollment";
            header('Location: courses.php');
            return;
        }
        $_SESSION['success'] = "Erollment created";
    } else {
        $sql = "UPDATE Enrollments SET role=1, modified_at=NOW() 
            WHERE course_id='$id' AND USER_ID=".$_SESSION['id'];
        $result = run_mysql_query($sql);
        if ( $result == false || mysql_affected_rows() < 1 ) {
            $_SESSION['error'] = "Unable to change enrollment";
            header('Location: courses.php');
            return;
        }
        $_SESSION['success'] = "Erollment updated";
    }
    header('Location: courses.php');
    return;
}

if ( $courserow !== false && $enrollmentrow !== false 
    && isset($_POST['action']) && $_POST['action'] == "unenroll" ) {
    $sql = "UPDATE Enrollments SET role=0, modified_at=NOW() 
        WHERE course_id='$id' AND USER_ID=".$_SESSION['id'];
    $result = run_mysql_query($sql);
    if ( $result == false || mysql_affected_rows() < 1 ) {
        $_SESSION['error'] = "Unable to change enrollment";
        header('Location: courses.php');
        return;
    }
    $_SESSION['success'] = "Erollment updated";
    header('Location: courses.php');
    return;
}

    $sql = 'SELECT Courses.id, code, title, description, 
        image, start_at, close_at, duration,
        bypass, endpoint, consumer_key, consumer_secret, 
        Enrollments.id, role, grade, fame, fame_at
        FROM Courses LEFT OUTER JOIN Enrollments 
        ON Courses.id = course_id ';

    if ( isset($_SESSION['id']) ) {
        $sql .= ' AND Enrollments.user_id = '.$_SESSION['id'];
    }
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>

<script type="text/javascript">
function confirm_unenroll() {
    return(window.confirm('Are you sure you want to unenroll? '+
    'If the registration period is passed, you will not be able to re-enroll.\n\n'+
    'Press OK to un-enroll and Cancel to stay in the class.'));
}
</script>
</head>
<body style="padding: 0px 10px 0px 10px">
<div class="container">
<?php require_once("nav.php"); ?>
<a href="lms.php?context_id=playground" target="_new">
<img src="MOOCMap-8.jpg" 
alt="logo" cite="Image from Caitlin Holman"
align="right" class="img-rounded box-shadow hidden-phone" style="max-width: 30%; margin: 10px"/>
</a>
<p>
This is the list of the courses in this system.  Some of the courses are open enrollment 
which means you can enroll and launch these courses at any time
and others only allow enrollment during a particular period.   
</p>
<?php
$result = mysql_query($sql);
if ( $result === FALSE ) {
    error_log('Fail-SQL:'.mysql_error().','.$sql);
    echo("Unable to retrieve courses...");
    return;
}

while ( $row = mysql_fetch_row($result) ) {
    $start_at = strtotime($row[5]);

    // Because of our weird time zone, we need to pad start 
    // times by 24 hours so they make sense in local time zones 
    // around the world
    $started = start_time() >= $start_at;

    $close_at = false;
    if ( strlen($row[6]) > 10 ) $close_at = strtotime($row[6]);
    $enrolled = $row[12] > 0 && $row[13] > 0;

    $launch = false;
    if ( $enrolled && $started ) {
        $launch = 'lms.php?id='.htmlentities($row[0]);
    }
    echo('<h3>');
    if ( $launch ) echo('<a href="'.$launch.'" target="_new">');
    echo($row[1].' - '.$row[2]);
    if ( $launch ) echo('</a>');
    echo('</h3>');
    echo("\n<p>\n");
    echo(htmlentities($row[3]));
    $openenrollment = true;
    if ( ! $started ) {
        echo("<br/><b>Course Starts:</b> ".htmlentities(substr($row[5],0,10)));
        $openenrollment = false;
    }
    if ( $close_at !== false ) {
        echo("<br/><b>Registration Closes:</b> ".htmlentities(substr($row[6],0,10))." ");
        $openenrollment = false;
    }
    if ( $openenrollment ) {
        echo("<br/><b>This course is Open Enrollment.</b> ");
    }
    echo("</p>\n");

    // You are or have enrolled and your role is > 0
    if ( $enrolled ) {
        echo('<form method="post" action="courses.php">'."\n");
        if ( $started ) {
            echo('<button type="button" class="btn btn-primary" 
                onclick="window.open('."'".$launch."', '_blank'); return false;".'">Launch</button>'."\n");
            echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
            echo('<a href="'.$launch.'&debug=11" target="_new" style="color:white">Launch with LTI Debug</a>');
        }
        echo('<input type="hidden" name="id" value="'.htmlentities($row[0]).'">
            <input type="hidden" name="action" value="unenroll">
            <button type="submit" class="btn btn-warning btn-small');
        if ( $started ) echo(' pull-right');
        echo('" onclick="return confirm_unenroll();">Un-Enroll</button>
            </form>');
    } else if ( $close_at === false || time() <= $close_at ) {
        echo('<form method="post" action="courses.php">
            <input type="hidden" name="id" value="'.htmlentities($row[0]).'">
            <input type="hidden" name="action" value="enroll">');
        echo('<button type="submit" class="btn btn-primary">Enroll</button>');
        echo('</form>');
    } else {
        echo("<p><b>Enrollment is closed for this class.</b></p>\n");
    }
}
?>
<p>
This server is configured to be in the 
<a href="http://en.wikipedia.org/wiki/UTC-12:00" target="_new">UTC-12</a> 
time zone when working with dates to deal with students from around the world.  
This time zone is in the middle of the Pacific ocean 
just <em>before</em> the international date line.
It means that published deadlines 
(i.e. must complete an assignment by midnight on 01-February-2013) work in any 
time zone and most time zones have a bit of extra time.
</p>
<?php require_once("footer.php"); ?>
</div>
</body>
