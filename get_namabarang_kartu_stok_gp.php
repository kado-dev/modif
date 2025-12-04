<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
$filter = $_GET['filter'];
$keyword = $segments[2];

if($filter == 'u'){
	$str_group = "";
}else{
	$str_group = " Group by NamaBarang";
}
	
	$str = "SELECT * FROM `tbgfkstok` WHERE `NamaBarang` LIKE '%$keyword%' OR `KodeBarang` LIKE '%$keyword%' OR `Barcode` LIKE '%$keyword%'".$str_group;
	$query = mysqli_query($koneksi,$str);
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
			'supplier' => $data['KodeSupplier'],
			'keterangan' => $data['Keterangan']
		);	
	}
	echo json_encode($arr);
?>		