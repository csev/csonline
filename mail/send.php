<?php
$to = "csev@umich.edu";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "no-reply@mail.dr-chuck.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>

