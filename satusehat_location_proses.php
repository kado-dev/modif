<?php
    session_start();
	error_reporting(1);
    include "config/koneksi.php";
    include "config/helper.php";
    include "config/helper_satusehat.php";
    $kodepuskesmas = $_SESSION['kodepuskesmas'];
    $namapuskesmas = $_SESSION['namapuskesmas'];

    $kodepelayanan = $_POST['idpelayanan'];
	$name = $_POST['pelayanan'];
    $description = strtoupper($_POST['description']);
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $city = $_POST['city'];
    $postalCode = $_POST['postalCode'];
    $country = $_POST['country'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $village = $_POST['village'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];	
    
    // --------------- satu sehat --------------- //
    $stsehat_access_token = $_SESSION['stsehat_access_token'];

    $pstsehat['resourceType'] = 'Location';
    $pstsehat['identifier'][0]['system'] = "http://sys-ids.kemkes.go.id/location/".$_SESSION['stsehat_orgid'];
    $pstsehat['identifier'][0]['value'] = $namapuskesmas;
    $pstsehat['status'] = 'active';
    $pstsehat['name'] = $name;
    $pstsehat['description'] = $description;
    $pstsehat['mode'] = 'instance';
    $pstsehat['telecom'][0]['system'] = 'phone';
    $pstsehat['telecom'][0]['value'] = $phone;
    $pstsehat['telecom'][0]['use'] = 'work';
    $pstsehat['telecom'][0]['system'] = 'fax';
    $pstsehat['telecom'][0]['value'] = $fax;
    $pstsehat['telecom'][0]['use'] = 'work';
    $pstsehat['telecom'][0]['system'] = 'email';
    $pstsehat['telecom'][0]['value'] = $email;
    $pstsehat['telecom'][0]['system'] = 'url';
    $pstsehat['telecom'][0]['value'] = "https://tarakansehat.id/";
    $pstsehat['telecom'][0]['use'] = 'work';
    $pstsehat['address']['use'] = 'work';
    $pstsehat['address']['line'][0] = $alamat;
    $pstsehat['address']['city'] = $city;
    $pstsehat['address']['postalCode'] = $postalCode;
    $pstsehat['address']['country'] = $country;
    $pstsehat['address']['extension'][0]['url'] = "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode";
    $pstsehat['address']['extension'][0]['extension'][0]['url'] = 'province';
    $pstsehat['address']['extension'][0]['extension'][0]['valueCode'] = $province;
    $pstsehat['address']['extension'][0]['extension'][1]['url'] = 'city';
    $pstsehat['address']['extension'][0]['extension'][1]['valueCode'] = $city;
    $pstsehat['address']['extension'][0]['extension'][2]['url'] = 'district';
    $pstsehat['address']['extension'][0]['extension'][2]['valueCode'] = $district;
    $pstsehat['address']['extension'][0]['extension'][3]['url'] = 'village';
    $pstsehat['address']['extension'][0]['extension'][3]['valueCode'] = $village;
    $pstsehat['address']['extension'][0]['extension'][4]['url'] = 'rt';
    $pstsehat['address']['extension'][0]['extension'][4]['valueCode'] = $rt;
    $pstsehat['address']['extension'][0]['extension'][5]['url'] = 'rw';
    $pstsehat['address']['extension'][0]['extension'][5]['valueCode'] = $rw;
    $pstsehat['physicalType']['coding'][0]['system'] = "http://terminology.hl7.org/CodeSystem/location-physical-type";
    $pstsehat['physicalType']['coding'][0]['code'] = 'ro';
    $pstsehat['physicalType']['coding'][0]['display'] = 'Room';
    $pstsehat['position']['longitude'] = (float)$longitude;
    $pstsehat['position']['latitude'] = (float)$latitude;
    $pstsehat['position']['altitude'] = 0;
    $pstsehat['managingOrganization']['reference'] = 'Organization/'.$_SESSION['stsehat_orgid'];

    $data_json 		= json_encode($pstsehat,true);
    $post_location	= simpan_satusehat($stsehat_access_token,'Location',$data_json);

    $dtaparse 		= json_decode($post_location,true);
    $id_kunjungan_satusehat	= $dtaparse['id'];

    // echo $data_json."<br/>";
    // echo $post_location."<br/>";
    // echo $id_kunjungan_satusehat."<br/>";
    // die();
    // --------------- satu sehat ----------------- //
    $str = "INSERT INTO `satusehat_location`(`KodePuskesmas`, `KodePelayanan`, `NamaLokasi`, `Satusehat_IdLocation`, `description`, `phone`, `fax`, `email`, `alamat`, `postalCode`, `country`, `province`, `city`, `district`, `village`, `rt`, `rw`, `longitude`, `latitude`) VALUES ('$kodepuskesmas','$kodepelayanan','$name','$id_kunjungan_satusehat','$description','$phone','$fax','$email','$alamat','$postalCode','$country','$province','$city','$district','$village','$rt','$rw','$longitude','$latitude')";
    $query = mysqli_query($koneksi,$str);

    if($query){	
        alert_swal('sukses','Data berhasil disimpan');
        echo "<script>";
        echo "document.location.href='index.php?page=satusehat_location';";
        echo "</script>";
    }else{
        alert_swal('gagal','Data gagal disimpan');
        echo "<script>";
        echo "document.location.href='index.php?page=satusehat_location';";
        echo "</script>";
    } 	
?>