<?php
require_once("start.php");
require_once("sqlutil.php");
require_once("db.php");

$courserow = false;
$enrollmentrow = false;
if ( isset($_SESSION['id']) && isset($_POST['id']) ) {
    $id = mysql_real_escape_string($_POST['id']);
    $sql = "SELECT id FROM Courses WHERE id='$id'";
    $courserow = retrieve_one_row($sql);
    if ( is_string($courserow) ) {
        $_SESSION['error'] = "Unable to retrieve course";
        header('Location: index.php');
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
            header('Location: index.php');
            return;
        }
        $_SESSION['success'] = "Erollment created";
    } else {
        $sql = "UPDATE Enrollments SET role=1, modified_at=NOW() 
            WHERE course_id='$id' AND USER_ID=".$_SESSION['id'];
        $result = run_mysql_query($sql);
        if ( $result == false || mysql_affected_rows() < 1 ) {
            $_SESSION['error'] = "Unable to change enrollment";
            header('Location: index.php');
            return;
        }
        $_SESSION['success'] = "Erollment updated";
    }
    header('Location: index.php');
    return;
}

if ( $courserow !== false && $enrollmentrow !== false 
    && isset($_POST['action']) && $_POST['action'] == "unenroll" ) {
    $sql = "UPDATE Enrollments SET role=0, modified_at=NOW() 
        WHERE course_id='$id' AND USER_ID=".$_SESSION['id'];
    $result = run_mysql_query($sql);
    if ( $result == false || mysql_affected_rows() < 1 ) {
        $_SESSION['error'] = "Unable to change enrollment";
        header('Location: index.php');
        return;
    }
    $_SESSION['success'] = "Erollment updated";
    header('Location: index.php');
    return;
}

if ( isset($_SESSION['id']) ) {
    $sql = 'SELECT Courses.id, code, title, description, 
        image, start_at, close_at, duration,
        bypass, endpoint, consumer_key, consumer_secret, 
        Enrollments.id, role, grade, fame, cert_at, focus
        FROM Courses LEFT OUTER JOIN Enrollments 
        ON Courses.id = course_id 
        AND Enrollments.user_id = '.$_SESSION['id'].'
        ORDER BY focus DESC';
} else {
    $sql = 'SELECT Courses.id, code, title, description, 
        image, start_at, close_at, duration,
        NULL, NULL, NULL, NULL, 
        NULL, NULL, NULL, NULL, NULL, focus
        FROM Courses ORDER BY focus DESC';
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
<img src="MOOCMap-8.jpg" 
alt="logo" cite="Image from Caitlin Holman"
align="right" class="img-rounded box-shadow hidden-phone" style="max-width: 30%; margin: 10px"/>
<p>
<?php
    if ( isset($_SESSION['id']) ) {
?>
This is the list of the courses in this system. 
Some of the courses are open enrollment 
which means you can enroll and launch these courses at any time
and others only allow enrollment during a particular period.   
Make sure to enable popups
from these domains as some of the functionality opens in a popup window.  Grades / progress 
take about 15 minutes to be sent from Moodle back to this page.
<?php } ?>
</p>
<?php
$result = mysql_query($sql);
if ( $result === FALSE ) {
    echo('Fail-SQL:'.mysql_error().','.$sql);
    echo("Unable to retrieve courses...");
    return;
}

while ( $row = mysql_fetch_row($result) ) {
    $focus = $row[17];
    $start_at = strtotime($row[5]);

    // Because of our weird time zone, we need to pad start 
    // times by 24 hours so they make sense in local time zones 
    // around the world
    $started = start_time() >= $start_at;

    $close_at = false;
    if ( strlen($row[6]) > 10 && substr($row[6],0,10) != '0000-00-00') $close_at = strtotime($row[6]);
    $enrolled = $row[12] > 0 && $row[13] > 0;

    // Only show old, closed classes to students enrolled in those classes
    if ( ! $enrolled && $close_at !== false && time() > $close_at ) {
        continue;
    }

    $launch = false;
    if ( $enrolled && $started ) {
        $launch = 'lms.php?id='.urlencode($row[0]);
    }
    echo('<h3>');
    if ( $launch ) echo('<a href="'.$launch.'" target="_blank">');
    echo($row[1].' - '.$row[2]);
    if ( $launch ) echo('</a>');
    echo(' (<a href="map.php?course_id='.urlencode($row[0]).'">Map</a>) ');
    echo('</h3>');
    echo("\n<p>\n");
    // Not escaped - be careful
    // echo(htmlencode($row[3]));
    echo($row[3]);
    $openenrollment = true;
    if ( ! $started ) {
        echo("<br/><b>Course Starts:</b> ".htmlencode(substr($row[5],0,10)));
        $openenrollment = false;
    }
    if ( $close_at !== false ) {
        echo("<br/><b>Registration Closes:</b> ".htmlencode(substr($row[6],0,10))." ");
        $openenrollment = false;
    }
    if ( $openenrollment ) {
        echo("<br/><b>This course is Open Enrollment.</b> ");
    }
    if ( $row[14] > 0.0 ) {
        echo("<br/><b>Current Grade:</b> ".htmlencode($row[14])." ");
        echo('<div class="progress progress-success" style="width:60%">
            <div class="bar" style="width: '.intval(100*$row[14]).'%"></div>
            </div>');

    }
    echo("</p>\n");

    // You are or have enrolled and your role is > 0
    if ( $enrolled ) {
        echo('<form method="post" action="index.php">'."\n");
        if ( $started ) {
            echo('<button type="button" class="btn btn-primary" 
                onclick="window.open('."'".$launch."', '_blank'); return false;".'">Launch</button>'."\n");
            echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
            echo('<a href="'.$launch.'&debug=11" target="_blank" style="color:white">Launch with LTI Debug</a>');
        }
        echo('<input type="hidden" name="id" value="'.htmlencode($row[0]).'">
            <input type="hidden" name="action" value="unenroll">
            <button type="submit" class="btn btn-warning btn-small');
        if ( $started ) echo(' pull-right');
        echo('" onclick="return confirm_unenroll();">Un-Enroll</button>
            </form>');
    } else if ( $close_at === false || time() <= $close_at ) {
        if ( isset($_SESSION['id']) ) {
            echo('<form method="post" action="index.php">
                <input type="hidden" name="id" value="'.htmlencode($row[0]).'">
                <input type="hidden" name="action" value="enroll">');
            echo('<button type="submit" class="btn btn-primary">Join Class</button>');
            echo('</form>');
        }
    } else {
        echo("<p><b>Enrollment is closed for this class.</b></p>\n");
    }
    echo("<hr/>\n");
}
if ( isset($_SESSION['id']) ) {
?>
<p>
This server is configured to be in the 
<a href="http://en.wikipedia.org/wiki/UTC-12:00" target="_blank">UTC-12</a> 
time zone when working with dates to deal with students from around the world.  
This time zone is in the middle of the Pacific ocean 
just <em>before</em> the international date line.
It means that published deadlines 
(i.e. must complete an assignment by midnight on 01-February-2013) work in any 
time zone and most time zones have a bit of extra time.
</p>
<?php } else { ?>
<p>
<input class="btn btn-success" type="button" onclick="location.href='login.php'; return false;" value="Join Class"/>
</p>
<?php } ?>
<?php require_once("footer.php"); ?>
</div>
</body>
