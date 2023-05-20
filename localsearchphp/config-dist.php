<?php

$spider_crawl_max_pages = 5;

// If you know your server start enter it here
$spider_start = "https://online.dr-chuck.com/";

// And comment all this out
$our_server_port = ($_SERVER['SERVER_PORT'] ?? 443 );
$spider_start = ( $_SERVER['REQUEST_SCHEME'] ?? 'https' ) . "://" .
	($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP:HOST'] ?? 'localhost') .
	( ($our_server_port == 80 || $our_server_port == 443) ? '' : ':'.$our_server_port );

