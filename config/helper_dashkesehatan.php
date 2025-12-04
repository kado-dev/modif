<?php

function get_token_dashkesehatan($username,$password){
	$ch = curl_init('https://e-kes.bandungkab.go.id/api/index.php/auth');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
        'x-username:'.$username,
        'x-password:'.$password
	));
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

	//execute post
	$result = curl_exec($ch);
	$error = curl_error($ch);
	//close connection
	curl_close($ch);

	echo $error."<br/><br/>";

    $dt = json_decode($result,true);
	return $dt['response']['token'];
}

function get_data_pengeluaran_obat_dinkes($username,$token,$tahun,$bulan){
    $ch = curl_init('https://e-kes.bandungkab.go.id/api/index.php/ObatPengeluaran/index?tahun='.$tahun.'&bulan='.$bulan);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
        'x-username:'.$username,
        'x-token:'.$token
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

function get_data_pengeluaran_obat_dinkes_detail($username,$token,$nofaktur){
    $ch = curl_init('https://e-kes.bandungkab.go.id/api/index.php/ObatPengeluaran/detail?nofaktur='.$nofaktur);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
        'x-username:'.$username,
        'x-token:'.$token
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

function get_data_pengeluaran_obat_dinkes_update_sts($username,$token,$faktur,$kodebarang,$nobatch){
    $postfields = [
        'faktur'	=> $faktur,
        'kodebarang'	=> $kodebarang,
        'nobatch'	=> $nobatch
    ];

    $ch = curl_init('https://e-kes.bandungkab.go.id/api/index.php/ObatPengeluaran/update_sts_detail');
	
	
	curl_setopt($ch, CURLOPT_POST, true); // Gunakan metode POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
        'x-username:'.$username,
        'x-token:'.$token
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

?>