<?php
/* update tanggal 01 agustus 2021 */
$faktur = $_POST['faktur'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kodebarangs = $_POST['kodebarangs'];
$datas = $_POST['datas'];
$nobatch = $_POST['nobatch'];
$namabarang = $_POST['namabarang'];
$idprogram = $_POST['idprogram'];
$namaprogram = $_POST['namaprogram'];
$expire = $_POST['expire'];
$hargasatuan = $_POST['hargasatuan'];
$jumlah = $_POST['jumlah'];
$indikator = $_POST['indikator'];
$tglpenerimaan = $_POST['tglpenerimaan'];
$key = $_POST['key'];
$statusgudang = $_POST['statusgudang'];
$tahun = $_POST['tahun'];

if(isset($datas)){
	foreach($datas as $kd){
		$kodebarang = $kodebarangs[$kd];
		$month = date_format(date_create($expire[$kd]),"m");
		$year = date_format(date_create($expire[$kd]),"Y");
		
		// tahap 1, jika barangnya belum pernah terima maka masuk di ketersediaan (menambahkan item baru)	
		$cek = "SELECT `KodeBarang` FROM `tbgudangpkmvaksinstok` WHERE `KodeBarang` = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."' AND KodePuskesmas = '".$kodepuskesmas."'";
		$cek_barang = mysqli_num_rows(mysqli_query($koneksi,$cek));		
		$cek_kodebarang = mysqli_fetch_assoc(mysqli_query($koneksi,$cek));		
		
		if($cek_barang == 0){
			// tahap 2, cek apakah obat atau vaksin
			$strgfk = "SELECT * FROM `tbgfk_vaksin_stok` WHERE KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."'";	
			$dtb = mysqli_fetch_assoc(mysqli_query($koneksi,$strgfk));
			$satuan = $dtb['Satuan'];
			$sumberanggaran = $dtb['SumberAnggaran'];
			$tahunanggaran = $dtb['TahunAnggaran'];
			
			$str = "INSERT INTO `tbgudangpkmvaksinstok`(`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`IdProgram`,`NamaProgram`) 
			VALUES ('$kodepuskesmas','$kodebarang','$namabarang[$kd]','$satuan','$nobatch[$kd]','$expire[$kd]','$hargasatuan[$kd]','$sumberanggaran','$tahunanggaran','$jumlah[$kd]','$idprogram[$kd]','$namaprogram[$kd]')";
			$query = mysqli_query($koneksi,$str);
		}else{
			$stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok, KodeBarang, NoBatch, KodePuskesmas FROM `tbgudangpkmvaksinstok` 
			WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."' AND
			MONTH(Expire) = '".$month."' AND YEAR(Expire) = '".$year."'"));
			$stok_baru = $stok_lama['Stok'] + $jumlah[$kd];
			$query = mysqli_query($koneksi,"UPDATE `tbgudangpkmvaksinstok` SET `Stok`='$stok_baru' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang` = '".$stok_lama['KodeBarang']."' AND `NoBatch` = '".$stok_lama['NoBatch']."'");
		}
		
		// tahap 3, update status validasi tbgfkpengeluarandetail
		$strstsgfk = "UPDATE `tbgfk_vaksin_pengeluarandetail` SET StatusValidasi = 'Sudah' WHERE `NoFaktur`='$faktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch[$kd]'";
		mysqli_query($koneksi,$strstsgfk);
	}
		
	if($query){
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=apotik_vaksin_gudang_penerimaan_lihat&id=$faktur&key=$key&statusgudang=$statusgudang&tahun=$tahun';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_vaksin_gudang_penerimaan_lihat&id=$faktur&key=$key&statusgudang=$statusgudang&tahun=$tahun';";
		echo "</script>";
	}	
}
	echo "<script>";
	echo "document.location.href='index.php?page=apotik_vaksin_gudang_penerimaan_lihat&id=$faktur&msg=$msg';";
	echo "</script>";
?>