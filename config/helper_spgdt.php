<?php
	// function koneksi_spgdt($method,$url){
	function koneksi_spgdt($method,$url){
		$data = "14";
		$secretKey = "cUhQq5jWLNufDCtGJrEiSQ==";
		
		$curl = curl_init($url);
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HTTPHEADER => array(
			"x-secret-key: ".$secretKey,
			"x-user-id:".$data
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);    
		return $response;
	}
	
	function get_ruang(){
		$url = "http://103.10.60.58/spgdtlocalrest/kamar/TypeRuang";
		$method = "GET";
		$res = koneksi_spgdt($method,$url);
		return $res;
	}
	
	function get_dokter(){
		$url = "http://103.10.60.58/spgdtlocalrest/Dokter";
		$method = "GET";
		$res = koneksi_spgdt($method,$url);
		return $res;
	}
	
	function get_pmi(){
		$url = "http://103.10.60.58/spgdtlocalrest/pmi";
		$method = "GET";
		$res = koneksi_spgdt($method,$url);
		return $res;
	}
	
	function get_ambulance(){
		$url = "http://103.10.60.58/spgdtlocalrest/Ambulance";
		$method = "GET";
		$res = koneksi_spgdt($method,$url);
		return $res;
	}
?>
