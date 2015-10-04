<?php require_once('../src/Curl/Curl.php');

use Request\Curl;

$curl = new Curl;
$curl->get('http://httpbin.org/get');

$info = $curl->getinfo();

var_dump($info);