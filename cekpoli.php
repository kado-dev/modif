<?php
	session_start();	
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";	
	// include "config/helper_bpjs_v4.php";
    include "config/helper_bpjs_antrean_v2.php";
 
    // $data_medis = get_data_poli();
	// $dmedis = json_decode($data_medis,True);
	// $list = $dmedis['response']['list'];
	// echo "hasil : ".get_data_poli();
	// die();

    $kodepoli = '001';
    $tanggal = '08-05-2024';
    $data_bpjs = get_data_dokter_antrean_fktp($kodepoli,$tanggal);
    $dtbpjs = json_decode($data_bpjs,True);
    // echo "Hasil : ".$data_bpjs;
?>