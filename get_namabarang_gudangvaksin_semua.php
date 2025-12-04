<?php
session_start();
include "config/koneksi.php";
$kota = $_SESSION['kota'];

if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE `NamaBarang` LIKE'%$keyword%' ORDER BY `NamaBarang`,`Expire`,`Stok`");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['NamaBarang'],
				'namabarang'	=> $data['NamaBarang'],
				'kodebarang' => $data['KodeBarang'],
				'barcode' => $data['Barcode'],
				'kemasan' => $data['Kemasan'],
				'isikemasan' => $data['IsiKemasan'],
				'satuan' => $data['Satuan'],
				'kelastherapy' => $data['KelasTherapy'],
				'golonganfungsi' => $data['GolonganFungsi'],
				'program' => $data['NamaProgram'],
				'jenisbarang' => $data['JenisBarang'],
				'ruangan' => $data['Ruangan'],
				'rak' => $data['Rak'],
				'stok' => $data['Stok'],
				'minimalstok' => $data['MinimalStok'],
				'hargabeli' => $data['HargaBeli'],
				'expire' => $data['Expire'],
				'nobatch' => $data['NoBatch'],
				'sumberanggaran' => $data['SumberAnggaran'],
				'tahunanggaran' => $data['TahunAnggaran'],
				'supplier' => $data['Produsen'],
				'keterangan' => $data['Keterangan'],
				'nofakturterima' => $data['NoFakturTerima']
			);		
		}
		echo json_encode($arr);
	}
}else{
	session_start();
	include "config/koneksi.php";
	$kota = $_SESSION['kota'];	
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
	$keyword = $segments[3];
	
	$query = mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE `NamaBarang` LIKE'%$keyword%' ORDER BY `IdBarang` DESC");				
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['NamaBarang']." | ".$data['NoFakturTerima']." (".$data['NoBatch'].")",
			'namabarang'	=> $data['NamaBarang'],
			'kodebarang' => $data['KodeBarang'],
			'barcode' => $data['Barcode'],
			'kemasan' => $data['Kemasan'],
			'isikemasan' => $data['IsiKemasan'],
			'satuan' => $data['Satuan'],
			'kelastherapy' => $data['KelasTherapy'],
			'golonganfungsi' => $data['GolonganFungsi'],
			'program' => $data['NamaProgram'],
			'jenisbarang' => $data['JenisBarang'],
			'ruangan' => $data['Ruangan'],
			'rak' => $data['Rak'],
			'stok' => $data['Stok'],
			'minimalstok' => $data['MinimalStok'],
			'hargabeli' => $data['HargaBeli'],
			'expire' => $data['Expire'],
			'nobatch' => $data['NoBatch'],
			'sumberanggaran' => $data['SumberAnggaran'],
			'tahunanggaran' => $data['TahunAnggaran'],
			'supplier' => $data['Produsen'],
			'keterangan' => $data['Keterangan'],
			'nofakturterima' => $data['NoFakturTerima']
		);	
	}
	echo json_encode($arr);
}	


?>		