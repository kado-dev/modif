<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];

		$query = mysqli_query($koneksi,"select * from `tbgudanguptdstok` join `tbgfkstok` on tbgudanguptdstok.kodebarang = tbgfkstok.kodebarang 
		where tbgfkstok.NamaBarang LIKE'%$keyword%' and tbgfkstok.SumberAnggaran = 'BLUD' and tbgudanguptdstok.KodePuskesmas = '$kodepuskesmas'");//group by tbgfkstok.NamaBarang,tbgfkstok.Expire
		
		
		while($data = mysqli_fetch_assoc($query))
		{
		$get_stok = mysqli_fetch_assoc(mysqli_query($koneksi,"select `Stok` from `tbgudanguptdstok` where `KodeBarang` = '$data[KodeBarang]' and `KodePuskesmas` = '$kodepuskesmas'"));
			
			$arr['suggestions'][] = array(
				'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']." | ".$data['Expire']." | ".$data['SumberAnggaran'],
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
				'stok' => round($get_stok['Stok'],0),
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