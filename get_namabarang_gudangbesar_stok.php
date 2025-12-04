<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE SumberAnggaran != 'BPJS' AND `NamaBarang` LIKE'%$keyword%' group by `NamaBarang`, `Expire` order by `NamaBarang`");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']." | ".$data['Expire'],
				'namabarang'	=> $data['NamaBarang'],
				'kodebarang' => $data['KodeBarang'],
				'barcode' => $data['Barcode'],
				'kodebaranginn' => $data['KodeBarangInn'],
				'namabaranginn' => $data['NamaBarangInn'],
				'kekuatan' => $data['Kekuatan'],
				'sediaan' => $data['Sediaan'],
				'golongan' => $data['Golongan'],
				'detailkemasan' => $data['DetailKemasan'],
				'kemasan' => $data['Kemasan'],
				'isikemasan' => $data['IsiKemasan'],
				'jenisbarangelog' => $data['JenisBarangElog'],
				'statusapproveelog' => $data['StatusApproveElog'],
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
				'keterangan' => $data['Keterangan'],
				'namalengkap' => $data['NamaBarang']." ".$data['Kekuatan']." ".$data['Sediaan']
			);	
		}
		echo json_encode($arr);
?>		