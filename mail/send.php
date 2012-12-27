<?php
$to = "csev@umich.edu";
$subject = "Test mail";
$message = "Hello! This is a simple email message.

You can manage your mail preferences at http://online.dr-chuck.com/profile.php";
$from = "no-reply@mail.dr-chuck.com";
// $headers = "From:" . $from;
$headers = 'From: '.$from."\n" .
    'Reply-To: ' . $from . "\n" .
    'List-Unsubscribe: <http://online.dr-chuck.com/unsubscribe.php?id=15&token=b61a7643c655d3bc66a1609d2110abdad0ec568e>' . "\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to,$subject,$message,$headers);
echo "Mail Sent.";
echo $headers;
?>

