<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setReferer('http://nasa.gov')
			   ->get('http://httpbin.org/headers');

var_dump($result);