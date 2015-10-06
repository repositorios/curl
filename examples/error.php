<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->get('http://httpbin.'); # Força um erro

if ($result) 
	echo "Nenhum erro aconteceu";
else
	echo "Aconteceu um erro";