<?php
session_start();
include "config/koneksi.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$kota = $_SESSION['kota'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);

$keyword= $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi, "SELECT * FROM `$tbgudangpkmstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND `Stok` > '0' ORDER BY `NamaBarang`");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> "<b>".strtoupper($data['NamaBarang'])."</b><br/>
			<p style='font-size: 13px;'>Program : ".$data['NamaProgram']."<br/>
			Batch : ".$data['NoBatch']."<br/>
			ED : ".$data['Expire']."<br/>
			Sumber : ".$data['SumberAnggaran']." ".$data['TahunAnggaran']."<br/>
			Harga : ".$data['HargaSatuan']."<br/>
			Stok : ".$data['Stok']."</p>",
			
			'idbrggudangpkm' => $data['IdBarangGdgPkm'],
			'kodebarang' => $data['KodeBarang'],
			'namabarang' => $data['NamaBarang'],
			'satuan' => $data['Satuan'],
			'nobatch' => $data['NoBatch'],
			'expire' => $data['Expire'],
			'hargasatuan' => $data['HargaSatuan'],
			'sumberanggaran' => $data['SumberAnggaran'],
			'tahunanggaran' => $data['TahunAnggaran'],
			'stok' => $data['Stok']
		);
	}
	echo json_encode($arr);
}	
?>		