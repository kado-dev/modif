<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		if($kota == "KABUPATEN BEKASI"){
			$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok > '0' ORDER BY `NamaBarang`,`Expire`,`Stok` ASC");
		}elseif($kota == "KABUPATEN BANDUNG"){
			$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok > '0' AND `SumberAnggaran`!= 'BLUD' GROUP BY `KodeBarang`, `NoBatch` ORDER BY `NamaBarang`,`Expire` ASC");
		}	
		
		while($data = mysqli_fetch_assoc($query)){
			$kodeobat = $data['KodeBarang'];
			$nobatch = $data['NoBatch'];
			$nofakturterima = $data['NoFakturTerima'];
			$stok = $data['Stok'];
			
			// ini untuk menambahkan keterangan nama obat tambahan (jika ada)
			if($data['NamaTambahan'] == "-" OR $data['NamaTambahan'] == ""){
				$tes = $data['NamaBarang'];
			}else{
				$tes = $data['NamaBarang']." (".$data['NamaTambahan'].")";
			}
						
			// if ($stok > 0){					
				$arr['suggestions'][] = array(
					'value'	=> "<b>".$tes."</b><br/>
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
}else{
	session_start();
	include "config/koneksi.php";
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
	$keyword = $segments[3];
	
	$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok != '0' AND `Expire` > curdate() AND (`NamaProgram`='PKD' OR `NamaProgram`='BMHP')
	ORDER BY `Expire`,`Stok` ASC");
	while($data = mysqli_fetch_assoc($query)){
		$kodeobat = $data['KodeBarang'];
		$nobatch = $data['NoBatch'];
		$nofakturterima = $data['NoFakturTerima'];
		
		$arr['suggestions'][] = array(
			'value'	=> "<b>".$data['NamaBarang']."</b><br/>
			<p style='font-size: 13px;'>Program : ".$data['NamaProgram']."<br/>
			Batch : ".$data['NoBatch']."<br/>
			ED : ".$data['Expire']."<br/>
			Sumber : ".$data['SumberAnggaran']." ".$data['TahunAnggaran']."<br/>
			Harga : ".$data['HargaBeli']."</p>",
			
			'namabarang' => $data['NamaBarang'],
			'kodebarang' => $data['KodeBarang'],
			'namaprogram' => $data['NamaProgram'],
			'expire' => $data['Expire'],
			'nobatch' => $data['NoBatch'],
			'nofakturterima' => $data['NoFakturTerima']
		);	
	}
	echo json_encode($arr);
	
}
?>		