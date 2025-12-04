<?php
session_start();
include "config/koneksi.php";
$kota = $_SESSION['kota'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$keyword= $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok > '0' ORDER BY `NamaBarang`,`Expire`,`Stok` ASC");
	while($data = mysqli_fetch_assoc($query)){
		$kodeobat = $data['KodeBarang'];
		$nobatch = $data['NoBatch'];
		$nofakturterima = $data['NoFakturTerima'];
		$stok = $data['Stok'];
		
							
		// if ($stok > 0){					
			$arr['suggestions'][] = array(
				'value'	=> "<b>".$data['NamaBarang']."</b><br/>
				<p style='font-size: 13px;'>Program : ".$data['NamaProgram']."<br/>
				Batch : ".$data['NoBatch']." | ED : ".$data['Expire']."<br/>
				Sumber : ".$data['SumberAnggaran']." ".$data['TahunAnggaran']."<br/>
				Harga : ".$data['HargaBeli']."<br/>
				Stok : ".$stok."</p>",
				
				'namabarang' => $data['NamaBarang'],
				'kodebarang' => $data['KodeBarang'],
				'barcode' => $data['Barcode'],
				'kemasan' => $data['Kemasan'],
				'isikemasan' => $data['IsiKemasan'],
				'satuan' => $data['Satuan'],
				'golonganfungsi' => $data['GolonganFungsi'],
				'program' => $data['NamaProgram'],
				'jenisbarang' => $data['JenisBarang'],
				'ruangan' => $data['Ruangan'],
				'rak' => $data['Rak'],
				'stok' => $stok,
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
		// }	
	}
	echo json_encode($arr);
}
?>		