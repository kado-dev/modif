<?php

	require_once 'vendor/autoload.php';
    
	// function decrypt
	function stringDecrypt($key, $string){
		$encrypt_method = 'AES-256-CBC';
		// hash
		$key_hash = hex2bin(hash('sha256', $key));
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
		return $output;
	}

	// function lzstring decompress 
	// download libraries lzstring : https://github.com/nullpunkt/lz-string-php
	function decompress($string){
		return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
	}
	
	function koneksi($method,$url,$param=""){
		
        //$koneksi =	mysqli_connect("10.200.57.2","apps","Arkana2016***","simpus2024new");
		$koneksi =	mysqli_connect("202.52.147.127","tarakansehat_simpusu","sandi2017","tarakansehat_simpus");
		$base_url = 'https://apijkn.bpjs-kesehatan.go.id/wsIHS/'.$url;
		
		$kode = $_SESSION['kodepuskesmas'];
		$qr = mysqli_query($koneksi,"SELECT * FROM tbpuskesmasdetail where KodePuskesmas = '$kode'");
		$getuserpass = mysqli_fetch_assoc($qr);
		
		$username=$getuserpass['Username'];
		$password=$getuserpass['Password'];
		$data = $getuserpass['ConsId'];
		$secretKey = $getuserpass['SecretKey'];
		$userkey = $getuserpass['UserKey'];
		

	// Computes the timestamp
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

	// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
		$encodedSignature = base64_encode($signature);
        
            
		$kdAplikasi="095";
		$autorized = base64_encode($username.":".$password.":".$kdAplikasi);
		$curl = curl_init();

		$cur_post = 0;
		if($method == 'POST'){
			$cur_post = 1;
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $base_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_USERAGENT => "pkm",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_POST => $cur_post,
			CURLOPT_POSTFIELDS => $param,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HTTPHEADER => array(
				"Content-type: text/plain",
				"X-cons-id: ".$data,
				"X-timestamp: ".$tStamp,
				"X-signature: ".$encodedSignature,
				"X-Authorization: Basic ".$autorized,
                "user_key: ".$userkey
			),
		));

		$response = curl_exec($curl);
		// echo $response;
		// die();
		$err = curl_error($curl);
		$info = curl_getinfo($curl);
		// echo $info;
		curl_close($curl);   
		$res = json_decode($response,true);
		$key = $data.$secretKey.$tStamp;
		
		if($res['metaData']['message'] == 'PRECONDITION_FAILED'){
			$x = $response;
		}else{
			$string = $res['response'];
			$des =  stringDecrypt($key,$string);
			$dec = decompress($des);
			$resp['response'] = json_decode($dec);
			$resp['metaData'] = $res['metaData'];
			$x = json_encode($resp);
		}
	
		return $x;
	}	


	function get_riwayat($nik,$kodedokter){
		$url = "api/pcare/validate";
		$method = "POST";

        $bd['param'] = $nik;
        $bd['kodedokter'] = $kodedokter;
        $param = json_encode($bd,TRUE);

		$res = koneksi($method,$url,$param);
		return $res;
	}

?>