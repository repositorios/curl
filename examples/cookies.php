<?php require_once('../src/Curl/Curl.php');

use Request\Curl;

$curl = new Curl;
$result = $curl->setCookieFile()
               ->sendCookieData(['chave'=> 'valor'])
               ->get('http://httpbin.org/cookies');

var_dump($result);