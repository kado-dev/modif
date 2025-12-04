<?php
	
function getUserPass(){
	$koneksi =	mysqli_connect("localhost","puskesma_baru","sandi2016","puskesma_baru");
	// $koneksi =	mysqli_connect("localhost","root","","dbsmartpuskesmas");
	
	$kode = $_SESSION['kodepuskesmas'];
	$qr = mysqli_query($koneksi,"SELECT * FROM tbpuskesmasdetail where KodePuskesmas = '$kode'");
	$data = mysqli_fetch_assoc($qr);
	$x['username'] = 'pkm10020602';
	$x['password'] = 'Cangkuang12345@';
	$x['consid'] = '31975';
	$x['secretkey'] = '5eJ8E1A533';
	return $x;
}

// helper bpjs
function koneksi($method,$url){
	$getuserpass = getUserPass();
	$username=$getuserpass['username'];
	$password=$getuserpass['password'];
	$data = $getuserpass['consid'];//"26025";
	$secretKey = $getuserpass['secretkey'];//"6hXCF2B2D8";

// Computes the timestamp
	date_default_timezone_set('UTC');
	$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

// Computes the signature by hashing the salt with the secret key as the key
	$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
	$encodedSignature = base64_encode($signature);
   
	$kdAplikasi="095";
	$autorized = base64_encode($username.":".$password.":".$kdAplikasi);
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 20,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => $method,
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
	return $response;
}


$key2='0000000000055';
function get_data_peserta_bpjs($key2){
	$url = "http://api.bpjs-kesehatan.go.id/pcare-rest/v2/peserta/".$key2;
	$method = "GET";
	$res = koneksi($method,$url);
	return $res;
}
	
	$data_bpjs = get_data_peserta_bpjs($key2);
	$dbpjs = json_decode($data_bpjs,TRUE);
	$dbpjs_v1 = json_decode($data_bpjs_v1,TRUE);
	$nokartubpjs = $dbpjs['response']['noKartu'];
	
	
	// echo $data_bpjs;

function get_data_poli(){
	$url = "http://api.bpjs-kesehatan.go.id/pcare-rest/v1/poli/fktp/0/50";
	$method = "GET";
	$res = koneksi($method,$url);
	return $res;
}

	$data_poli = get_data_poli($key2);
	$dbpjs = json_decode($data_bpjs,TRUE);
	$dbpjs_v1 = json_decode($data_bpjs_v1,TRUE);
	$nokartubpjs = $dbpjs['response']['noKartu'];
	
	echo $data_bpjs;
	echo $data_poli;
	
	// die();
?>