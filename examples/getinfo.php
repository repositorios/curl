<?php require_once('../src/Curl.php');

$curl = new Curl;
$curl->get('http://httpbin.org/get');

$info = $curl->getinfo();

var_dump($info);