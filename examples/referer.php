<?php require_once('../src/Curl/Curl.php');

use Request\Curl;

$curl = new Curl;
$result = $curl->setReferer('http://nasa.gov')
			   ->get('http://httpbin.org/headers');

var_dump($result);