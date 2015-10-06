<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setBasicAuth('renato', '123')->get('http://httpbin.org/basic-auth/renato/123');

var_dump($result); 