<?php
class Model_default extends CI_Model{


	function simpan($tabel,$data){
		return $this->db->insert($tabel,$data);
	}

	function login_pegawai($username,$pass){
		$cek = $this->db->query("SELECT * FROM `tbapikey` WHERE `Username` = '$username' AND `Password` = '$pass' AND `Approve` = 'Y'");
		// echo "SELECT * FROM `tbapikey` WHERE `Username` = '$username' AND `Password` = '$pass' AND `Approve` = 'Y'";
		if($cek->num_rows() > 0){
			$datauser = $cek->row();
			//set session
			$this->session->set_userdata("username", $datauser->Username);
			$this->session->set_userdata("password", $datauser->Password); 
			$this->session->set_userdata("key", $datauser->keys); 
			$this->session->set_userdata("approve", $datauser->Approve); 
			$this->session->set_userdata("level", $datauser->level); 
			return true;
		}else{
			return false;
		}
	}
	
	function ceklogin(){
		if($this->session->userdata("username") == null){
			redirect('login');
		}
	}

	function getDataCasip($key){
		$userid = "1495202006226dinkes_3204";
		$password = "DINKES_3204_BDG";
		$ip = "10.87.0.16";
		$id = $key;
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
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

		//execute post
		$result = curl_exec($ch);
		$error = curl_error($ch);
		//close connection
		curl_close($ch);
		return $result;
	}
	
	function getDataBpjs($key,$kode){
		$dtpuskesmas = $this->db->query("SELECT `KodePuskesmas`, `Username`, `Password`, `ConsId`, `SecretKey`, `UserKey` FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kode'")->row();

		$username 	= $dtpuskesmas->Username;
		$password 	= $dtpuskesmas->Password;
		$data 		= $dtpuskesmas->ConsId;
		$secretKey 	= $dtpuskesmas->SecretKey;
		$userkey 	= $dtpuskesmas->UserKey;
		
		// $url = "https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev/peserta/".$key;
		$url = "https://apijkn.bpjs-kesehatan.go.id/pcare-rest/peserta/".$key;

		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
		$encodedSignature = base64_encode($signature);
		$kdAplikasi="095";
		$autorized = base64_encode($username.":".$password.":".$kdAplikasi);
		
		$options = array( 
			CURLOPT_RETURNTRANSFER => true,         // return web page 
			CURLOPT_HEADER         => false,        // don't return headers 
			CURLOPT_FOLLOWLOCATION => true,         // follow redirects 
			CURLOPT_ENCODING       => "",           // handle all encodings 
			CURLOPT_USERAGENT      => "pkm",     // who am i 
			CURLOPT_AUTOREFERER    => true,         // set referer on redirect 
			CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect 
			CURLOPT_TIMEOUT        => 10,          // timeout on response 
			CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects 
			CURLOPT_POST           => 1,            // i am sending post data 
			//CURLOPT_POSTFIELDS  => ,    // this are my post vars 
			CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl 
			CURLOPT_SSL_VERIFYPEER => false,        // 
			CURLOPT_VERBOSE        => 1  ,            // 
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"X-cons-id: ".$data,
				"X-timestamp: ".$tStamp,
				"X-signature: ".$encodedSignature,
				"X-Authorization: Basic ".$autorized,
				"user_key: ".$userkey
			),
		); 

		$ch      = curl_init($url); 
		curl_setopt_array($ch,$options); 
		$content = curl_exec($ch); 
		$err     = curl_errno($ch); 
		$errmsg  = curl_error($ch) ; 
		$header  = curl_getinfo($ch); 
		curl_close($ch); 

		$res = json_decode($content,true);

		$key = $data.$secretKey.$tStamp;
		$string = $res['response'];
		$des =  stringDecrypt($key,$string);
		$dec = decompress($des);
		$resp['response'] = json_decode($dec);
		$resp['metaData'] = $res['metaData'];
		$x = json_encode($resp);	

		return $x; 
	}


	function get_jadwal_dokter_antrean($kodepoli,$tanggal){
		$url = "ref/dokter/kodepoli/$kodepoli/tanggal/$tanggal";
		$method = "GET";
        // $base_url = 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanfktp_dev/'.$url;
		$base_url = 'https://apijkn.bpjs-kesehatan.go.id/antranfktp/'.$url;
        // $koneksi =	mysqli_connect("localhost","root","","db_smartpuskesmas");
		$koneksi =	mysqli_connect("202.52.147.127","tarakansehat_simpusu","sandi2017","tarakansehat_simpus");
		// $koneksi =	mysqli_connect("10.90.174.132","eker","Arkana2016***","simpus2024");
		$kode = $_SESSION['kodepuskesmas'];
		$qr = mysqli_query($koneksi,"SELECT * FROM tbpuskesmasdetail where KodePuskesmas = '$kode'");
		$getuserpass = mysqli_fetch_assoc($qr);
		
		$username=$getuserpass['Username'];
		$password=$getuserpass['Password'];
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
	
}	