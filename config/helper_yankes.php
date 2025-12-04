<?php
function login_api_yankes($kode_puskesmas,$password){

	$data = array("kode_puskesmas" => "$kode_puskesmas","password"=>"$password");
	$data_string = json_encode($data);

	$ch = curl_init('https://sadata-diskes.jabarprov.go.id/rest/api/login');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
	));
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

	//execute post
	$result = curl_exec($ch);
	$error = curl_error($ch);
	//close connection
	curl_close($ch);
	return $result;
}

function get_data_kunjungan($token,$bulan,$tahun){
	$ch = curl_init('https://sadata-diskes.jabarprov.go.id/rest/api/kunjungan/show/'.$tahun.'/'.$bulan);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"Authorization: Bearer ".$token,
	));
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

	//execute post
	$result = curl_exec($ch);
	$error = curl_error($ch);
	//close connection
	curl_close($ch);
	return $result;
}


function insert_kunjuangan($token,$data_json){

	$ch = curl_init('https://sadata-diskes.jabarprov.go.id/rest/api/kunjungan/store');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"Authorization: Bearer ".$token,
	));
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

	//execute post
	$result = curl_exec($ch);
	$error = curl_error($ch);
	//close connection
	curl_close($ch);
	return $result;
}


function edit_kunjuangan($token,$table_id,$data_json){

	$ch = curl_init('https://sadata-diskes.jabarprov.go.id/rest/api/kunjungan/update/'.$table_id);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"Authorization: Bearer ".$token,
	));
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

	//execute post
	$result = curl_exec($ch);
	$error = curl_error($ch);
	//close connection
	curl_close($ch);
	return $result;
}


// $dt['id_datadasar'] = "2";
// $dt['KODE_PUSKESMAS'] = "1030545";
// $dt['bulan'] =  "09";
// $dt['tahun'] =  "2022";
// $dt['updated_date'] =  "2022-09-24 01:49:00";
// $dt['jml_kunjungan_rj_laki'] =  "3";
// $dt['jml_kunjungan_rj_perempuan'] =  "2";
// $dt['jml_kunjungan_rj_laki_perempuan'] =  "1";
// $dt['jml_kunjungan_ri_laki'] =  "1";
// $dt['jml_kunjungan_ri_perempuan'] =  "1";
// $dt['jml_kunjungan_ri_laki_perempuan'] =  "1";
// $dt['kunjungan_gangguan_jiwa_jml_laki'] =  "1";
// $dt['kunjungan_gangguan_jiwa_jml_perempuan'] =  "1";
// $dt['kunjungan_gangguan_jiwa_jml_laki_perempuan'] =  "1";

// $ts = edit_kunjuangan('10|gWf8XKaEGtnEhTnDRUdUCngkNylYBOgO4u9T58G2','2221',json_encode($dt));

// echo $ts;
?>