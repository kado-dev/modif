<?php
	session_start();
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
        // $base_url = 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanfktp_dev/'.$url;
		// $koneksi =	mysqli_connect("localhost","root","","db_smartpuskesmas");
		$base_url = 'https://apijkn.bpjs-kesehatan.go.id/antreanfktp/'.$url;
		$koneksi =	mysqli_connect("103.245.39.167","dblinggarpkmuser","Tomi481216!","dblinggarpkm");
		$kode = $_SESSION['kodepuskesmas'];
		$qr = mysqli_query($koneksi,"SELECT * FROM tbpuskesmasdetail where KodePuskesmas = '$kode'");
		$getuserpass = mysqli_fetch_assoc($qr);
		
		$username = $getuserpass['Username'];
		$password = $getuserpass['Password'];
		$data = $getuserpass['ConsId'];
		$secretKey = $getuserpass['SecretKey'];
		$userkey = $getuserpass['UserKey'];

// $username="tes.katapang";
// $password="Qwerty1!";
// $data = "11764";
// $secretKey ="3vR1E7727B";
// $userkey ="ad9e39dd9eabc8ab6eca0542649f7f17";

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
		//echo $info;
		//die();
		curl_close($curl);   
		$res = json_decode($response,true);
		$key = $data.$secretKey.$tStamp;
		$string = $res['response'];
		$des =  stringDecrypt($key,$string);
		$dec = decompress($des);
		$resp['response'] = json_decode($dec);
		$resp['metadata'] = $res['metadata'];
		$x = json_encode($resp);		
		return $x;
	}

    //antean fktp - ws bpjs

	function get_data_poli_antrean_fktp($tanggal){
		$url = "ref/poli/tanggal/$tanggal";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}


	function get_data_dokter_antrean_fktp($kodepoli,$tanggal){
		$url = "ref/dokter/kodepoli/$kodepoli/tanggal/$tanggal";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}
	
	// function simpan_antrean_fktp($nomorkartu,$nik,$nohp,$kodepoli,$namapoli,$norm,$tanggalperiksa,$kodedokter,$namadokter,$jampraktek,$noantrean,$angkaantrean,$keterangan){
	// 	$datas = array(
	// 		"nomorkartu"	=> $nomorkartu,
	// 		"nik"			=> $nik,
	// 		"nohp"			=> $nohp,
	// 		"kodepoli"		=> $kodepoli,
	// 		"namapoli"		=> $namapoli,
	// 		"norm"				=> $norm,
	// 		"tanggalperiksa"	=> $tanggalperiksa,
	// 		"kodedokter"		=> $kodedokter,
	// 		"namadokter"	=> $namadokter,
	// 		"jampraktek"	=> $jampraktek,
	// 		"nomorantrean"		=> $noantrean,
	// 		"angkaantrean"	=> $angkaantrean,
	// 		"keterangan"	=> $keterangan
	// 	); 

	// 	$param = json_encode($datas,TRUE);		
	// 	$method = "POST";
	// 	$url = "antrean/add";
	// 	$res = koneksi($method,$url,$param);
	// 	// echo $res;
	// 	// echo $param;
	// 	// die();		
	// 	return $res;
	// }

	function update_antrean_fktp($tanggalperiksa,$kodepoli,$nomorkartu,$status,$waktu){
		$datas = array(
			"tanggalperiksa"	=> $tanggalperiksa,
			"kodepoli"		=> $kodepoli,
			"nomorkartu"	=> $nomorkartu,
			"status"	=> $status,
			"waktu"		=> $waktu
		);

		$param = json_encode($datas,TRUE);

		// echo $param;
		//  die();
		$method = "POST";
		$url = "antrean/panggil";
		$res = koneksi($method,$url,$param);
		
		return $res; 
	}

	function batal_antrean_fktp($tanggalperiksa,$kodepoli,$nomorkartu,$alasan){
		$datas = array(
			"tanggalperiksa"	=> $tanggalperiksa,
			"kodepoli"		=> $kodepoli,
			"nomorkartu"	=> $nomorkartu,
			"alasan"	=> $alasan
		);

		$param = json_encode($datas,TRUE);

		// return $param;
		//  die();
		$method = "POST";
		$url = "antrean/batal";
		$res = koneksi($method,$url,$param);
		
		return $res; 
	}

?>