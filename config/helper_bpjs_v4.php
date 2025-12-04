<?php
	//error_reporting(1);
	//session_start();
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
		// $base_url = 'https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev/'.$url;
		// $koneksi =	mysqli_connect("localhost","root","","db_smartpuskesmas");
		$base_url = 'https://apijkn.bpjs-kesehatan.go.id/pcare-rest/'.$url;			
      	$koneksi =	mysqli_connect("103.245.39.167","dblinggarpkmuser","Tomi481216!","dblinggarpkm");	
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


	function get_data_peserta_bpjs($idbpjs){
		$url = "peserta/".$idbpjs;
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	// echo get_data_peserta_bpjs('0002081962337');
	// die();

	function get_data_peserta_bpjs_nik($idbpjs){
		$url = "peserta/nik/".$idbpjs;
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_poli(){
		$url = "poli/fktp/0/100";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}

	function simpan_pasien_rj($tgldaftar,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$lingkarPerut,$heartrate,$rujukbalik,$kdtkp){
		$data_daftar = array(
			"kdProviderPeserta"=> $kdprovider,
			"tglDaftar"		=> $tgldaftar,
			"noKartu"		=> $nokartu,
			"kdPoli"		=> $kdpoli,
			"keluhan"		=> $keluhan,
			"kunjSakit"		=> $kunjungan,
			"sistole"		=> $sistole,
			"diastole"		=> $diastole,
			"beratBadan"	=> $beratbadan,
			"tinggiBadan"	=> $tinggibadan,
			"respRate"		=> $resprate,
			"lingkarPerut"	=> $lingkarPerut,
			"heartRate"		=> $heartrate,
			"rujukBalik"	=> $rujukbalik,
			"kdTkp"		=> $kdtkp
		);

		$param = json_encode($data_daftar,TRUE);
		$method = "POST";
		$url = "pendaftaran";
		$res = koneksi($method,$url,$param);
		// echo $res;
		// echo $param;
		// die();
		return $res; 
	}

	function delete_registrasi_bpjs($nokartu,$tgl,$no,$kdpoli){
		$url = "pendaftaran/peserta/".$nokartu."/tglDaftar/".$tgl."/noUrut/".$no."/kdPoli/".$kdpoli;
		$method = "DELETE";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function delete_kegiatan_kelompok($eduid){
		$url = "kelompok/kegiatan/".$eduid;
		$method = "DELETE";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}
	
	function delete_kegiatan_kelompok_peserta($eduid,$nokartu){
		$url = "kelompok/peserta/".$eduid."/".$nokartu;
		$method = "DELETE";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}

	function simpan_pemeriksaan_khusus($nokartu,$tanggalregistrasi,$keluhan,$kdSadar,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,
	$lingkarperut,$terapi,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdkhusus,$kdsubspesialis,$catatan,$faktor,$alasan,$anamnesa,$alergiMakan,$alergiUdara,$alergiObat,$kdPrognosa,$suhutubuh){
		$data_pemeriksaan_rujuk = array(
			"noKunjungan"=> null,
			"noKartu"		=> $nokartu,
			"tglDaftar"		=> $tanggalregistrasi,
			"kdPoli"		=> $kdpoli,
			"keluhan"		=> $keluhan,
			"kdSadar"		=> $kdSadar,
			"sistole"		=> $sistole,
			"diastole"		=> $diastole,
			"beratBadan"	=> $beratbadan,
			"tinggiBadan"	=> $tinggibadan,
			"respRate"		=> $resprate,
			"heartRate"		=> $heartrate,
			"lingkarPerut"	=> $lingkarperut,
			"terapi"		=> $terapi,
			"kdStatusPulang"			=> $kdStatusPulang,
			"tglPulang"		=> $tglPulang,
			"kdDokter"		=> $kdDokter,
			"kdDiag1"		=> $kdDiag1,
			"kdDiag2"		=> $kdDiag2,
			"kdDiag3"		=> $kdDiag3,
			"kdPoliRujukInternal"		=> $null,
			"rujukLanjut"	=> array(
				"tglEstRujuk" => $tglEstRujuk,
				"kdppk" => $kdppk,
				"subSpesialis" => null,
				"khusus" => array(
					"kdKhusus" => $kdkhusus,
					"kdSubSpesialis" => $kdsubspesialis,
					"catatan" => $catatan
				)
			),
			"kdTacc"		=> (int)$faktor,
			"alasanTacc"	=> ($alasan == 'null') ? null : htmlspecialchars($alasan),
			"anamnesa"	=> $anamnesa,
			"alergiMakan"	=> $alergiMakan,
			"alergiUdara"	=> $alergiUdara,
			"alergiObat"	=> $alergiObat,
			"kdPrognosa"	=> $kdPrognosa,
			"suhu"	=> $suhutubuh
		);
			
		$param = json_encode($data_pemeriksaan_rujuk,TRUE);
		// echo $param;
		// die();
		$method = "POST";
		$url = "kunjungan/v1";
		$res = koneksi($method,$url,$param);
		return $res; 			
	}

	function simpan_pemeriksaan_spesialis($nokartu,$tanggalregistrasi,$kdpoli,$keluhan,$kdSadar,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,
	$lingkarperut,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis1,$kdsarana,$faktor,$alasan,$anamnesa,$alergiMakan,$alergiUdara,$alergiObat,$kdPrognosa,$terapiObat,$terapiNonObat,$bmhp,$suhutubuh){

		$data_pemeriksaan = array(
			"noKunjungan"=> null,
			"noKartu"		=> $nokartu,
			"tglDaftar"		=> $tanggalregistrasi,
			"kdPoli"		=> $kdpoli,
			"keluhan"		=> $keluhan,
			"kdSadar"		=> $kdSadar,
			"sistole"		=> $sistole,//$sistole,
			"diastole"		=> $diastole,//$diastole,
			"beratBadan"	=> $beratbadan,//$beratbadan,
			"tinggiBadan"	=> $tinggibadan,//$tinggibadan,
			"respRate"		=> $resprate,//$resprate,
			"heartRate"		=> $heartrate,//$heartrate,
			"lingkarPerut"	=> $lingkarperut,			
			"kdStatusPulang"			=> $kdStatusPulang,
			"tglPulang"		=> $tglPulang,
			"kdDokter"		=> $kdDokter,
			"kdDiag1"		=> $kdDiag1,
			"kdDiag2"		=> $kdDiag2,
			"kdDiag3"		=> $kdDiag3,
			"kdPoliRujukInternal"		=> null,//$kdPoliRujukInternal,
			"rujukLanjut"	=> array(
				"kdppk" => $kdppk,
				"tglEstRujuk" => $tglEstRujuk,				
				"subSpesialis" => array(
					"kdSubSpesialis1" => $kdsubspesialis1,
					"kdSarana" => $kdsarana
				),
				"khusus"=>null
			),
			"kdTacc"		=> (int)$faktor,
			// "alasanTacc"	=> ($alasan == 'null') ? null : htmlspecialchars($alasan)
			"alasanTacc"	=> null,
			"anamnesa"	=> $anamnesa,
			"alergiMakan"	=> $alergiMakan,
			"alergiUdara"	=> $alergiUdara,
			"alergiObat"	=> $alergiObat,
			"kdPrognosa"	=> $kdPrognosa,
			"terapiObat"	=> $terapiObat,
			"terapiNonObat"	=> $terapiNonObat,
			"bmhp"	=> $bmhp,
			"suhu"	=> $suhutubuh
		);
		
		$param = json_encode($data_pemeriksaan,TRUE);
    	// echo "Param: ".$param;
		// die();
		$method = "POST";
		$url = "kunjungan/v1";
		$res = koneksi($method,$url,$param);
		return $res; 	
	}

	function edit_pemeriksaan($nokunjungan,$nokartu,$keluhan,$kdSadar,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,
	$lingkarperut,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis1,$kdsarana,$faktor,$alasan,$anamnesa,$alergiMakan,$alergiUdara,$alergiObat,$kdPrognosa,$suhutubuh){

		$data_pemeriksaan = array(
			"noKunjungan"	=> $nokunjungan,
			"noKartu"		=> $nokartu,
			"keluhan"		=> $keluhan,
			"kdSadar"		=> $kdSadar,			
			"sistole"		=> $sistole,//$sistole,
			"diastole"		=> $diastole,//$diastole,
			"beratBadan"	=> $beratbadan,//$beratbadan,
			"tinggiBadan"	=> $tinggibadan,//$tinggibadan,
			"respRate"		=> $resprate,//$resprate,
			"heartRate"		=> $heartrate,//$heartrate,
			"lingkarPerut"	=> $lingkarperut,
			"kdStatusPulang"=> $kdStatusPulang,
			"tglPulang"		=> $tglPulang,
			"kdDokter"		=> $kdDokter,
			"kdDiag1"		=> $kdDiag1,
			"kdDiag2"		=> $kdDiag2,
			"kdDiag3"		=> $kdDiag3,
			"kdPoliRujukInternal"		=> null,//$kdPoliRujukInternal,
			"rujukLanjut"	=> array(
				"tglEstRujuk" => $tglEstRujuk,
				"kdppk" => $kdppk,	
				"subSpesialis"=>null,							
				"khusus" => array(
					"kdKhusus" => 'HDL',
					"kdSubSpesialis" => $kdsubspesialis1,
					"catatan" => "peserta sudah biasa hemodialisa"
				),
				
			),
			"kdTacc"		=> (int)$faktor,
			"alasanTacc"	=> ($alasan == 'null') ? null : htmlspecialchars($alasan),
			"anamnesa"	=> $anamnesa,
			"alergiMakan"	=> $alergiMakan,
			"alergiUdara"	=> $alergiUdara,
			"alergiObat"	=> $alergiObat,
			"kdPrognosa"	=> $kdPrognosa,
			"suhu"	=> $suhutubuh
		);
		
		$param = json_encode($data_pemeriksaan,TRUE);
		// echo "Param: ".$param;
		// die();
		$method = "PUT";
		$url = "kunjungan/v1";
		$res = koneksi($method,$url,$param);
		return $res; 	
	}
	
	function get_data_riwayat($idbpjs){
		$url = "kunjungan/peserta/".$idbpjs;
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	function delete_kunjungan_bpjs($nokunjungan){
		$url = "kunjungan/".$nokunjungan;
		
		$method = "DELETE";
		$res = koneksi($method,$url);
		return $res;
	}

	function get_data_tenagamedis(){
		$url = "dokter/0/50";
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	function get_tindakan_edit($key){
		$url = "tindakan/kunjungan/".$key;
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	function get_kunjungan_edit($key){
		$url = "peserta/".$key;
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_diagnosa_master(){
		$url = "diagnosa/A/0/16000";
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_kesadaran(){
		$url = "kesadaran";
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_therapy(){
		$url = "obat/dpho/1301/0/1500";		
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_provider(){
		$url = "provider/0/50";
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_statuspulang(){
		$url = "statuspulang/rawatInap/true";
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_data_tindakan(){
		$url = "tindakan/kdTkp/10/0/1000";
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	function get_club_prolanis($key){
		$url = "kelompok/club/".$key;
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}
	
	// echo get_data_statuspulang(false);
	// die();
	
	function simpan_terapi_bpjs($kdobatsk,$nokunjungan,$racikan,$kdracikan,$obatdpho,$kdobat,$signa1,$signa2,$jmlobat,$jmlpermintaan,$nmobatnondpho){
		$data_daftar = array(
				"kdObatSK"		=> $kdobatsk,
				"noKunjungan"	=> $nokunjungan,
				"racikan"		=> $racikan === 'true' ? true : false,
				"kdRacikan"		=> $kdracikan,
				"obatDPHO"		=> $obatdpho,
				"kdObat"		=> $kdobat,
				"signa1"		=> (int)$signa1,
				"signa2"		=> (int)$signa2,
				"jmlObat"	=> (int)$jmlobat,
				"jmlPermintaan"	=> (int)$jmlpermintaan,
				"nmObatNonDPHO"		=> $nmobatnondpho
			);
		$param = json_encode($data_daftar,TRUE);
		// echo "Param: ".$param;
		// die();
		$method = "POST";
		$url = "obat/kunjungan";
		$res = koneksi($method,$url,$param);
		return $res; 	
	}

	function get_rujukan_bpjs($idbpjs){
	   $url = "kunjungan/rujukan/".$idbpjs;
	   $method = "GET";
	   $res = koneksi($method,$url);
	   return $res;	
   	}
	// echo get_rujukan_bpjs('100206010722Y000014');
	// die();

	//get referensi_khusus
	function get_data_referensi_khusus(){
		$url = "spesialis/khusus";
		
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	//get referensi spesialis
	function get_data_referensi_spesialis(){
		$url = "spesialis";
		
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	//get referensi spesialis
	function get_data_referensi_sub_spesialis($key){
		$url = "spesialis/".$key."/subspesialis";
		
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	//get referensi spesialis
	function get_data_referensi_sarana(){
		$url = "spesialis/sarana";
		
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	//get referensi spesialis
	function get_data_referensi_faskes_spesialis($kdsubspesialis,$kdsarana,$tgl){
		$url = "spesialis/rujuk/subspesialis/".$kdsubspesialis."/sarana/".$kdsarana."/tglEstRujuk/".$tgl;
		
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	// get referensi spesialis
	function get_data_referensi_faskes_khusus($kdkhusus,$subspesialis,$tgl,$nokartu){
		if($subspesialis != null){
			$url = "spesialis/rujuk/khusus/".$kdkhusus;
		}else{
			$url = "spesialis/rujuk/khusus/".$kdkhusus."/noKartu/".$nokartu."/tglEstRujuk/".$tgl;
		} 
		$method = "GET";
		$res = koneksi($method,$url);
		return $res;
	}

	function add_kegiatan_kelompok($clubid,$tgl,$jeniskegiatan,$jeniskelompok,$materi,$pembicara,$lokasi,$keterangan,$totalbiaya){
		$data_kegiatan = array(
				"eduId"		=> null,
				"clubId"	=> (int)$clubid,
				"tglPelayanan"		=> $tgl,
				"kdKegiatan"		=> $jeniskegiatan,
				"kdKelompok"		=> $jeniskelompok,
				"materi"		=> $materi,
				"pembicara"		=> $pembicara,
				"lokasi"		=> $lokasi,
				"keterangan"	=> $keterangan,
				"biaya"	=> (int)$totalbiaya
			);
		$param = json_encode($data_kegiatan,TRUE);
		// echo "Param: ".$param;
		// die();
		$method = "POST";
		$url = "kelompok/kegiatan";
		$res = koneksi($method,$url,$param);
		return $res; 	
	}
	
	function add_kegiatan_kelompok_anggota($eduid,$nokartu){
		$data_anggota_kegiatan = array(
				"eduId"		=> $eduid,
				"noKartu"	=> $nokartu
			);
		$param = json_encode($data_anggota_kegiatan,TRUE);
		// echo "Param: ".$param;
		// die();
		$method = "POST";
		$url = "kelompok/peserta";
		$res = koneksi($method,$url,$param);
		return $res; 	
	}

	function get_alergi_makan(){
		$url = "alergi/jenis/01";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}

	function get_alergi_udara(){
		$url = "alergi/jenis/02";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}

	function get_alergi_obat(){
		$url = "alergi/jenis/03";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}

	function get_prognosa(){
		$url = "prognosa";
		$method = "GET";
		$res = koneksi($method,$url);
		// echo $res;
		// die();
		return $res;
	}


	//======================================== antrean fktp ====================================================//
	function koneksi_antrean($method,$url,$param=""){
        // $base_url = 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanfktp_dev/'.$url;
		$base_url = 'https://apijkn.bpjs-kesehatan.go.id/antreanfktp/'.$url;
      	$koneksi =	mysqli_connect("103.245.39.167","dblinggarpkmuser","Tomi481216!","dblinggarpkm");
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

    //antean fktp - ws bpjs

	function get_data_poli_antrean_fktp($tanggal){
		$url = "ref/poli/tanggal/$tanggal";
		$method = "GET";
		$res = koneksi_antrean($method,$url);
		// echo $res;
		// die();
		return $res;
	}


	function get_data_dokter_antrean_fktp($kodepoli,$tanggal){
		$url = "ref/dokter/kodepoli/$kodepoli/tanggal/$tanggal";
		$method = "GET";
		$res = koneksi_antrean($method,$url);
		// echo $res;
		// die();
		return $res;
	}
	
	function simpan_antrean_fktp($nomorkartu,$nik,$nohp,$kodepoli,$namapoli,$norm,$tanggalperiksa,$kodedokter,$namadokter,$jampraktek,$noantrean,$angkaantrean,$keterangan){
		$datas = array(
			"nomorkartu"	=> $nomorkartu,
			"nik"			=> $nik,
			"nohp"			=> $nohp,
			"kodepoli"		=> $kodepoli,
			"namapoli"		=> $namapoli,
			"norm"				=> $norm,
			"tanggalperiksa"	=> $tanggalperiksa,
			"kodedokter"		=> $kodedokter,
			"namadokter"	=> $namadokter,
			"jampraktek"	=> $jampraktek,
			"nomorantrean"		=> $noantrean,
			"angkaantrean"	=> $angkaantrean,
			"keterangan"	=> $keterangan
		); 

		$param = json_encode($datas,TRUE);
		//echo $param."<br/><br/>";
		//die();
		$method = "POST";
		$url = "antrean/add";
		$res = koneksi_antrean($method,$url,$param);
		
		return $res; 
	}


	function update_antrean_fktp($tanggalperiksa,$kodepoli,$nomorkartu,$status,$waktu){
		$datas = array(
			"tanggalperiksa"	=> $tanggalperiksa,
			"kodepoli"		=> $kodepoli,
			"nomorkartu"	=> $nomorkartu,
			"status"	=> $status,
			"waktu"		=> $waktu
		);

		$param = json_encode($datas,TRUE);

		//echo $param;
		//die();
		$method = "POST";
		$url = "antrean/panggil";
		$res = koneksi_antrean($method,$url,$param);
		
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
		$res = koneksi_antrean($method,$url,$param);
		
		return $res; 
	}
	
?>
