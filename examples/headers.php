<?php require_once('../src/Curl/Curl.php');

use Request\Curl;

$curl = new Curl;
$result = $curl->setHeaders(['X-XSS-Protection: 1'])
	           ->get('http://httpbin.org/get');

var_dump($result);


