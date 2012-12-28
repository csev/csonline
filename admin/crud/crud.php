<?php

$tables = Array(

"Users" => Array('email', 'first','last','twitter','privacy','subscribe', 'map', 
'lat', 'lng', 'role', 'oer', 'created_at', 'modified_at', 'login_at', 'login_ip',
'identity'),

"Courses" => Array('code', 'title', 'description', 'start_at', 'close_at', 'duration', 
'threshold', 'bypass', 'endpoint', 'consumer_key', 'consumer_secret'),

"Enrollments" => Array('course_id', 'user_id', 'role', 'grade', 'cert_at', 'token' )
);

// First element of array is how many fields to show in the list view
$tableinfo = Array(
"Users" => Array(7),
"Courses" => Array(6),
"Enrollments" => Array(5)
);
