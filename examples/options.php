<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setOptions(['CURLOPT_MAXREDIRS' => 5]) # Define número máximo de redirecionamento para 5
	           ->get('http://httpbin.org/redirect/6');  # URL possui 6 redirecionamentos

if ($result) 
	echo "Nenhum erro aconteceu";
else
	echo "Aconteceu um erro";