<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setHeaders(['X-XSS-Protection: 1'])
	           ->get('http://httpbin.org/get');

var_dump($result);


