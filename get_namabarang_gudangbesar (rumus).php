<?php
session_start();
include "config/koneksi.php";
$kota = $_SESSION['kota'];
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$keyword= $_GET['keyword'];
if($keyword != ''){
	if($kota == "KABUPATEN BOGOR"){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok > '0' AND `Expire` > curdate() AND (`NamaProgram`='OBAT-OBATAN' OR `NamaProgram`='BMHP') ORDER BY `Expire`,`Stok` ASC");
	}elseif($kota == "KABUPATEN BEKASI"){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok > '0' ORDER BY `NamaBarang`,`Expire`,`Stok` ASC");
	}elseif($kota == "KABUPATEN BANDUNG"){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` LIKE'%$keyword%' OR `KodeBarang` LIKE'%$keyword%' OR `NoBatch` LIKE'%$keyword%') AND Stok > '0' AND `SumberAnggaran`!= 'BLUD' GROUP BY `KodeBarang`, `NoBatch` ORDER BY `NamaBarang`,`Expire` ASC");
	}
	
	while($data = mysqli_fetch_assoc($query)){
		$kodebarang = $data['KodeBarang'];
		$nobatch = $data['NoBatch'];
		$nofakturterima = $data['NoFakturTerima'];
		$stok = $data['Stok'];		
		
		// 1. stok awal, ini ngambil sisa stok yang bulan des 2019
		$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS JumlahStokAwal
		FROM `tbstokawalmaster_gudang_besar` 
		WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'"));
		if ($dt_stokawal_dtl['JumlahStokAwal'] != null){
			$stokawal = $dt_stokawal_dtl['JumlahStokAwal'];
		}else{
			$stokawal = '0';
		}
								
		// 2. penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
		if($kota == "KABUPATEN BEKASI"){
			$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS JumlahPenerimaan 
			FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
			WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' 
			AND YEAR(b.TanggalPenerimaan) > '2019'"));
		}else{
			$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NomorPembukuan, SUM(Jumlah)AS JumlahPenerimaan 
			FROM `tbgfkpenerimaandetail` 
			WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'")); // AND `NomorPembukuan`='$nofakturterima'
		}
		
		if ($dtpenerimaandtl['JumlahPenerimaan'] != null){
			$penerimaan = $dtpenerimaandtl['JumlahPenerimaan'];
		}else{
			$penerimaan = '0';
		}
		
		// 3. pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
		if($kota == "KABUPATEN BEKASI"){			
			$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jumlah 
			FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b. NoFaktur 
			WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'"));
			
		}else{
			$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
			FROM `tbgfkpengeluarandetail` a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur 
			WHERE a.`KodeBarang` = '$kodebarang' AND a.`NoBatch`='$nobatch'"));
		}	
		
		if ($dtpengeluarandtl['Jumlah'] != null){
			$pengeluaran = $dtpengeluarandtl['Jumlah'];
		}else{
			$pengeluaran = '0';
		}
		
		// 4. karantina detail
		// $str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail`  
		// WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
		// $dt_karantina_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
		// if ($dt_karantina_dtl['Jumlah'] != null){
		// 	$karantina = $dt_karantina_dtl['Jumlah'];
		// }else{
		// 	$karantina = '0';
		// }
		
		// 5. sisastok, jika penerimaan 0, ngambil dari stok awal
		if($penerimaan == 0){
			$sisastok = $stokawal - $pengeluaran - $karantina;
		}else{
			$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina;
		}
		
		// ini untuk menambahkan keterangan nama obat tambahan (jika ada)
		if($data['NamaTambahan'] == "-" OR $data['NamaTambahan'] == ""){
			$tes = $data['NamaBarang'];
		}else{
			$tes = $data['NamaBarang']." (".$data['NamaTambahan'].")";
		}
					
		if ($sisastok > 0){					
			$arr['suggestions'][] = array(
				'value'	=> "<b>".$tes."</b><br/>
				<p style='font-size: 13px;'>Program : ".$data['NamaProgram']."<br/>
				Batch : ".$data['NoBatch']." | ED : ".$data['Expire']."<br/>
				Sumber : ".$data['SumberAnggaran']." ".$data['TahunAnggaran']."<br/>
				Harga : ".$data['HargaBeli']."<br/>
				stok awal : ".$stokawal."<br/>
				penerimaan : ".$penerimaan."<br/>
				pengeluaran : ".$pengeluaran."<br/>
				karantina : ".$karantina."<br/>
				<b>Stok : ".$sisastok."</b></p>",
				
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
				'stok' => $sisastok,
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
	}
	echo json_encode($arr);
}
?>		