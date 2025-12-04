<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);	

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmvaksinstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND (NamaBarang LIKE'%$keyword%' OR KodeBarang LIKE'%$keyword%' OR NoBatch LIKE'%$keyword%') AND Stok > '0' ORDER BY NamaBarang");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> "<b>".$data['NamaBarang']."</b><br/>
				<p style='font-size: 13px;'>Sumber : ".$data['SumberAnggaran']." <br/>
				Batch : ".$data['NoBatch']." | ED : ".$data['Expire']." <br/>
				Stok : ".$data['Stok']."</p>",
				
				'idbrggudangpkm' => $data['IdBarangGdgPkm'],
				'kodebarang' => $data['KodeBarang'],
				'namabarang' => $data['NamaBarang'],
				'satuan' => $data['Satuan'],
				'expire' => $data['Expire'],
				'hargasatuan' => $data['HargaSatuan'],
				'sumberanggaran' => $data['SumberAnggaran'],
				'tahunanggaran' => $data['TahunAnggaran'],
				'nobatch' => $data['NoBatch'],
				'stok' => $data['Stok']
			);	
		}
		echo json_encode($arr);
	}
?>			