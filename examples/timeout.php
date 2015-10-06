<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setTimeout(5, 10)
			   ->get('http://httpbin.org/delay/10');

var_dump($result);