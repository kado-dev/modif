<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config/koneksi.php";
// include "config/helper_pasienrj.php";
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);
$keyword= $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi, "select * FROM `$tbpasien` WHERE (`NamaPasien` LIKE'%$keyword%' OR `NoIndex` LIKE'%$keyword%')");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=>$data['NamaPasien']." - ".substr($data['NoIndex'], -10),
            'namapasien' => $data['NamaPasien'],
            'idpasien' => $data['IdPasien'],
            'noindex' => $data['NoIndex'],
            'nik' => $data['Nik'],
			'norm' => $data['NoRM'],
			'noasuransi' => $data['NoAsuransi'],
			'asuransi' => $data['Asuransi'],
			'tanggallahir' => date('d-m-Y', strtotime($data['TanggalLahir'])),
			'statuskeluarga' => $data['StatusKeluarga'],
			'pendidikan' => $data['Pendidikan'],
			'pekerjaan' => $data['Pekerjaan']
		);	
	}
	echo json_encode($arr);
}		
?>		