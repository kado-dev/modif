<?php
session_start();
include "config/koneksi.php";

$keyword = $_POST['barcode'];

	$query = mysqli_query($koneksi,"select * from `tbgfkstok` where `Stok` != 0 AND `Barcode` = '$keyword'");
	$data = mysqli_fetch_assoc($query);

		$arr = array(
			'value'	=> $data['Barcode'],
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
	echo json_encode($arr);
?>		