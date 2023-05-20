<?php

if(is_file("config.php")) { include "config.php"; } else { include "config-dist.php"; }

require_once "MySpider.php";

header('Content-Type: application/json; charset=utf-8');

$spider = new MySpider($spider_start);
$results = $spider->crawl($spider_crawl_max_pages);
echo(json_encode($results, JSON_PRETTY_PRINT));



