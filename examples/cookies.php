<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setCookieFile()
               ->sendCookieData(['chave'=> 'valor'])
               ->get('http://httpbin.org/cookies');

var_dump($result);