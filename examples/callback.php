<?php require_once('../src/Curl.php');

$curl = new Curl;
$curl->get('http://httpbin.org/get', ['q'=> 'curl', 'v'=> '1.0'], 'printResult');


function printResult($responseHeader, $responseBody) {
	var_dump($responseHeader);
	var_dump($responseBody);
}