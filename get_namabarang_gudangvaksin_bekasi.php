<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$kota = $_SESSION['kota'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];

		$query = mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE `NamaBarang` LIKE'%$keyword%' AND Stok != '0' ORDER BY `NamaBarang`,`Expire`,`Stok`");
		while($data = mysqli_fetch_assoc($query))
			$kodeobat = $data['KodeBarang'];
			$nobatch = $data['NoBatch'];
			
			// tahap1, stok awal ini ngambil sisa stok yang bulan des 2019
			$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat ' AND `NoBatch`='$nobatch'";
			$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
			if ($dt_stokawal_dtl['Stok'] != null){
				$stokawal = $dt_stokawal_dtl['Stok'];
			}else{
				$stokawal = '0';
			}	
			
			// tahap2, panggil tanggal terima
			$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_penerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$nomorpembukuan'";
			$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
			if ($dt_penerimaan_dtl['Jumlah'] != null){
				$penerimaan = $dt_penerimaan_dtl['Jumlah'];
			}else{
				$penerimaan = '0';
			}
			
			// tahap3, pengeluaran detail
			$str_pengeluaran = "SELECT SUM(Jumlah) AS Jml FROM `tbgfk_vaksin_pengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nomorpembukuan'";
			$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
			if ($dt_pengeluaran_dtl['Jml'] != null){
				$pengeluaran = $dt_pengeluaran_dtl['Jml'];
			}else{
				$pengeluaran = '0';
			}
			
			// 4. sisastok
			$sisa = $stokawal + $penerimaan - $pengeluaran;
			$saldo = $sisa * $harga;	
			
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['NamaBarang']." | ".$data['Expire']." | Batch : ".$data['NoBatch']." | Stok : ".$data['Stok'],
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
				'stok' => $sisa,
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