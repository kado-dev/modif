<?php

	$data = "15043";
	$secretKey = "kab_bandung_12345";

// Computes the timestamp
	date_default_timezone_set('UTC');

	$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

// Computes the signature by hashing the salt with the secret key as the key
   $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);

   $encodedSignature = base64_encode($signature);
   
   $username="pkm10020601";
   $password="10020601";
   $kdAplikasi="095";
   $autorized = base64_encode($username.":".$password.":".$kdAplikasi);

	//echo "X-cons-id: " .$data ."<br>";
	//echo "X-timestamp:" .$tStamp ."<br>";
	//echo "X-signature: " .$encodedSignature . "<br>";
	//echo "X-Authorization: Basic " .$autorized;
   
   
$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "http://dvlp.bpjs-kesehatan.go.id:9080/pcare-rest-dev/v1/peserta/0001101972339",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"X-cons-id: ".$data,
		"X-timestamp: ".$tStamp,
		"X-signature: ".$encodedSignature,
		"X-Authorization: Basic ".$autorized
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);   
echo "<br/>";
echo $response;

?>