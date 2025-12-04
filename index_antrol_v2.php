<?php
	$data = "11764";
	$secretKey = "3vR1E7727B";
	$userkey="ad9e39dd9eabc8ab6eca0542649f7f17";

         // Computes the timestamp

          date_default_timezone_set('UTC');

          $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

           // Computes the signature by hashing the salt with the secret key as the key

   $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);

	// base64 encode…

   $encodedSignature = base64_encode($signature);
   $username="tes.katapang";
   $password="Qwerty1!";
   $kdAplikasi="095";
   $autorized = base64_encode($username.":".$password.":".$kdAplikasi);

   // urlencode…

   // $encodedSignature = urlencode($encodedSignature);

   echo "X-cons-id: " .$data ."<br>";

   echo "X-timestamp:" .$tStamp ."<br>";

   echo "X-signature: " .$encodedSignature . "<br>";
   
   echo "X-Authorization: Basic " .$autorized . "<br>";
   
    echo "user_key:" .$userkey;

?>