<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];

	$query = mysqli_query($koneksi,"SELECT * 
	FROM `tbgfkstok` 
	WHERE (SumberAnggaran <> 'BPJS' AND `NamaBarang` LIKE '%$keyword%' OR `KodeBarang` LIKE '%$keyword%' OR `Barcode` LIKE '%$keyword%')");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['KodeBarang']." - ".$data['Barcode']." - ".$data['NamaBarang']." - ".$data['SumberAnggaran']." ".$data['TahunAnggaran'],
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