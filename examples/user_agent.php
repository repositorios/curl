<?php require_once('../src/Curl/Curl.php');

use Request\Curl;

$curl = new Curl;
$result = $curl->setUserAgent('O mal raramente ataca o cauteloso. Com seus ouvidos escuta e com seus olhos observa. Assim explora todo homem prudente.')
			   ->get('http://httpbin.org/user-agent');

var_dump($result);