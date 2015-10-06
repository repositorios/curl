<?php require_once('../src/Curl.php');

$curl = new Curl;
$result = $curl->setProxy('117.136.234.8', 80) # Define um IP de proxy obtido no http://proxylist.hidemyass.com/
               ->get('http://httpbin.org/ip');

var_dump($result);
