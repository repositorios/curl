<?php require_once('../src/Curl.php');

$fp = fopen('pytty.exe', 'wb');

$curl = new Curl;
$curl->setFileDownload($fp)->get('http://the.earth.li/~sgtatham/putty/latest/x86/putty.exe');

fclose($fp);

