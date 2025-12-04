<?php
$userid = "1495202006226dinkes_3204";
$password = "DINKES_3204_BDG";
$ip = "10.87.0.16";
$id = $_GET['nik'];
$data = array("nik" => "$id", "user_id" => "$userid","password"=>"DINKES_3204_BDG", "ip_user" => "$ip");
$data_string = json_encode($data);

$ch = curl_init('http://172.16.160.43:8080/dukcapil/get_json/32-04/dinkes/dinkes');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

//execute post
$result = curl_exec($ch);
//close connection
curl_close($ch);
echo $result;


/*
$password = "DINKES_3204_BDG";
	$ip = "10.87.0.16";
	$id = $key;
	$data = array("nik" => "$id", "user_id" => "$userid","password"=>"DINKES_3204_BDG", "ip_user" => "$ip");
	$data_string = json_encode($data);

	$ch = curl_init('http://172.16.160.43:8080/dukcapil/get_json/32-04/dinkes/dinkes');
*/

?>