<?php


function simpan_satusehat($token,$url,$data_json){

	$base_url = "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
	$ch = curl_init($base_url."/".$url);
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


function edit_satusehat($token,$url,$data_json,$id){

	$base_url = "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
	$ch = curl_init($base_url."/".$url."/".$id);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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

function get_satusehat($token,$url){

	$base_url = "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
	$ch = curl_init($base_url."/".$url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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


function get_obat_kfa($token,$key){

	$base_url = "https://api-satusehat.kemkes.go.id/kfa-v2";
	$ch = curl_init($base_url."/products/all?page=1&size=100&product_type=farmasi&keyword=".$key);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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




// ============================ helper khusus ================================ //

function login_api_satusehat($client_id,$client_secret){

	$auth_url = "https://api-satusehat.kemkes.go.id/oauth2/v1";
	$ch = curl_init($auth_url.'/accesstoken?grant_type=client_credentials');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=".$client_id."&client_secret=".$client_secret);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/x-www-form-urlencoded',
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


function get_Practitioner($token,$nikdokter){
	$url 		= 'Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|'.$nikdokter; 
	$base_url 	= "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
	$ch = curl_init($base_url."/".$url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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
	// echo $result;
	// die();

	
	$dtaparse 		= json_decode($result,true);
	$hsl['IdPractitioner']		= $dtaparse['entry'][0]['resource']['id'];
	$hsl['ResourceType'] 		= $dtaparse['entry'][0]['resource']['resourceType'];
	$hsl['NamePractitioner'] 	= $dtaparse['entry'][0]['resource']['name'][0]['text'];

	return $hsl;
}


function get_Patient($token,$nikpasien){
	$url 		= 'Patient?identifier=https://fhir.kemkes.go.id/id/nik|'.$nikpasien; 
	$base_url 	= "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
	$ch = curl_init($base_url."/".$url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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
	

	
	$dtaparse 		= json_decode($result,true);
	$hsl['IdPatient']		= $dtaparse['entry'][0]['resource']['id'];
	$hsl['ResourceType'] 	= $dtaparse['entry'][0]['resource']['resourceType'];
	$hsl['NamePatient'] 	= $dtaparse['entry'][0]['resource']['name'][0]['text'];

	return $hsl;
}




?>