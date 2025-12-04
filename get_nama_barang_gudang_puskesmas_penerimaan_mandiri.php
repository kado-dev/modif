<?php
session_start();
include "config/koneksi.php";
$namapuskesmas = $_SESSION['namapuskesmas'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);
$keyword= $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi,"SELECT * FROM `$ref_obat_lplpo` WHERE (NamaBarang LIKE'%$keyword%' OR KodeBarang LIKE'%$keyword%') ORDER BY NamaBarang");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['NamaBarang'],
			'namabarang' => $data['NamaBarang'],
			'kodebarang' => $data['KodeBarang'],
			'satuan' => $data['Satuan']
		);	
	}
	echo json_encode($arr);
}
?>		