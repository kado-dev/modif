<?php
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

if(isset($datas)){
	foreach($datas as $kd){
		$kodebarang = $kodebarangs[$kd];
		$month = date_format(date_create($expire[$kd]),"m");
		$year = date_format(date_create($expire[$kd]),"Y");
		
		// tahap1, jika barangnya belum pernah terima maka masuk di ketersediaan (menambahkan item baru)	
		$cek = "SELECT `KodeBarang` FROM `tbgudangpkmstok` WHERE `KodeBarang` = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."' AND KodePuskesmas = '".$kodepuskesmas."'";
		$cek_barang = mysqli_num_rows(mysqli_query($koneksi,$cek));		
		$cek_kodebarang = mysqli_fetch_assoc(mysqli_query($koneksi,$cek));		
		
		if($cek_barang == 0){
			$strgfk = "SELECT * FROM `tbgfkstok` WHERE KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."'";	
			$dtb = mysqli_fetch_assoc(mysqli_query($koneksi,$strgfk));			
			// $namabarang = $dtb['NamaBarang'];
			
			// jika nama barang kososng cari ke tbgfk_vaksin_stok 
			if($namabarang == ""){
				$strvaksin = "SELECT * FROM `tbgfk_vaksin_stok` WHERE KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."'";
				$dtb = mysqli_fetch_assoc(mysqli_query($koneksi,$strvaksin));	
				$namabarang = $dtb['NamaBarang'];				
			}
			$satuan = $dtb['Satuan'];
			$sumberanggaran = $dtb['SumberAnggaran'];
			$tahunanggaran = $dtb['TahunAnggaran'];
			$statuspenerimaan = "";
			$str = "INSERT INTO `$tbgudangpkmstok`(`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`IdProgram`,`NamaProgram`) 
			VALUES ('$kodepuskesmas','$kodebarang','$namabarang[$kd]','$satuan','$nobatch[$kd]','$expire[$kd]','$hargasatuan[$kd]','$sumberanggaran','$tahunanggaran','$jumlah[$kd]','$idprogram[$kd]','$namaprogram[$kd]')";
			// echo $str;
			// die();
			$query = mysqli_query($koneksi,$str);
		}else{
			$stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok, KodeBarang, NoBatch, KodePuskesmas FROM `tbgudangpkmstok` 
			WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."' AND
			MONTH(Expire) = '".$month."' AND YEAR(Expire) = '".$year."'"));
			$stok_baru = $stok_lama['Stok'] + $jumlah[$kd];
			$jml_elog = $jumlah[$kd] + $stok_lama['Stok'];	
			$query = mysqli_query($koneksi,"UPDATE `tbgudangpkmstok` SET `Stok`='$stok_baru' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang` = '".$stok_lama['KodeBarang']."' AND `NoBatch` = '".$stok_lama['NoBatch']."'");
		}
		
		// tahap2, update status validasi tbgudangpkmpenerimaan
		// $str_gdpkm = "UPDATE `tbgudangpkmpenerimaan` SET StatusValidasi = 'Sudah' WHERE `NoFaktur` = '$faktur'";
		// $str_status_gdpkm = mysqli_query($koneksi,$str_gdpkm);
		
		// tahap3, update status validasi tbgudangpkmpenerimaandetail
		// $strsts = "UPDATE `tbgudangpkmpenerimaandetail` SET StatusValidasi = 'Sudah' WHERE `NoFaktur`='$faktur' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch[$kd]'";
		// mysqli_query($koneksi,$strsts);
		
		// tahap4, update status validasi tbgfkpengeluarandetail
		$strstsgfk = "UPDATE `tbgfkpengeluarandetail` SET StatusValidasi = 'Sudah' WHERE `NoFaktur`='$faktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch[$kd]'";
		mysqli_query($koneksi,$strstsgfk);
	}
		
	if($query){
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_penerimaan_lihat&id=$faktur&msg=$msg';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_penerimaan_lihat&id=$faktur&msg=$msg';";
		echo "</script>";
	}	
}
		echo "<script>";
		echo "document.location.href='index.php?page=apotik_gudang_penerimaan_lihat&id=$faktur&msg=$msg';";
		echo "</script>";
?>