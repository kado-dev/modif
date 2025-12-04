<?php
session_start();
error_reporting(1);
/* update tanggal 01 agustus 2021 */
include "config/koneksi.php";
include "config/helper_pasienrj.php";
$faktur = $_POST['faktur'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kodebarangs = $_POST['kodebarangs'];
$datas = $_POST['datas'];
$nobatch = $_POST['nobatch'];
$namabarang = $_POST['namabarang'];
$idprogram = $_POST['idprogram'];
$namaprogram = $_POST['namaprogram'];
$expire = $_POST['expire'];
$hargasatuan = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$indikator = $_POST['indikator'];
$tglpenerimaan = $_POST['tglpenerimaan'];
$key = $_POST['key'];
$tahun = $_POST['tahun'];
// echo $kota;
// die();

//get apikey 
$qryapikey = mysqli_query($koneksi,"select Username, Password FROM tbapikey WHERE Kodepuskesmas = '$kodepuskesmas'");
$dtapikey = mysqli_fetch_assoc($qryapikey);

$usernameapi = $dtapikey['Username'];
$passwordapi = $dtapikey['Password'];

$token_dashkesehatan = null;

include "config/helper_dashkesehatan.php";

if($token_dashkesehatan == null){
$get_token_dashkesehatan = get_token_dashkesehatan($usernameapi,$passwordapi);

$token_dashkesehatan = $get_token_dashkesehatan;
}

if(isset($datas)){
	foreach($datas as $kd){
		$kodebarang = $kodebarangs[$kd];
		$month = date_format(date_create($expire[$kd]),"m");
		$year = date_format(date_create($expire[$kd]),"Y");
		
		// tahap 1, jika barangnya belum pernah terima maka masuk di ketersediaan (menambahkan item baru)	
		$cek = "SELECT `KodeBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."' AND KodePuskesmas = '".$kodepuskesmas."'";
		// echo $cek;
		// die();
		$cek_barang = mysqli_num_rows(mysqli_query($koneksi,$cek));		
		$cek_kodebarang = mysqli_fetch_assoc(mysqli_query($koneksi,$cek));		
		
		if($cek_barang == 0){
			// tahap 2, cek obat
			$strgfk = "SELECT * FROM `tbgfkstok` WHERE KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."'";
			$dtb = mysqli_fetch_assoc(mysqli_query($koneksi,$strgfk));
			$satuan = $dtb['Satuan'];
			$sumberanggaran = $dtb['SumberAnggaran'];
			$tahunanggaran = $dtb['TahunAnggaran'];
			
			$str = "INSERT INTO `$tbgudangpkmstok`(`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`IdProgram`,`NamaProgram`) 
			VALUES ('$kodepuskesmas','$kodebarang','$namabarang[$kd]','$satuan','$nobatch[$kd]','$expire[$kd]','$hargasatuan[$kd]','$sumberanggaran','$tahunanggaran','$jumlah[$kd]','$idprogram[$kd]','$namaprogram[$kd]')";
			// echo $str;
			// die();
			$query = mysqli_query($koneksi,$str);
		}else{
			$stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok, KodeBarang, NoBatch, KodePuskesmas FROM `$tbgudangpkmstok` 
			WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '".$kodebarang."' AND NoBatch = '".$nobatch[$kd]."' AND
			MONTH(Expire) = '".$month."' AND YEAR(Expire) = '".$year."'"));
			$stok_baru = $stok_lama['Stok'] + $jumlah[$kd];
			$query = mysqli_query($koneksi,"UPDATE `$tbgudangpkmstok` SET `Stok`='$stok_baru' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang` = '".$stok_lama['KodeBarang']."' AND `NoBatch` = '".$stok_lama['NoBatch']."'");
		}
		
		// tahap 3, update status validasi tbgfkpengeluarandetail
		// if(SUBSTR($faktur, -6) == 'VAKSIN' || SUBSTR($faktur, -9) == 'IMUNISASI'){
		// 	$strstsgfk = "UPDATE `tbgfk_vaksin_pengeluarandetail` SET StatusValidasi = 'Sudah' WHERE `NoFaktur`='$faktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch[$kd]'";
		// }else{
		// 	$strstsgfk = "UPDATE `tbgfkpengeluarandetail` SET StatusValidasi = 'Sudah' WHERE `NoFaktur`='$faktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch[$kd]'";
		// }	
		// mysqli_query($koneksi,$strstsgfk);
		
		if($query){
		$stsupapi = get_data_pengeluaran_obat_dinkes_update_sts($usernameapi,$token_dashkesehatan,$faktur,$kodebarang,$nobatch[$kd]);
		}
		// echo $stsupapi."<br/><br/>";
		

	}
		
	if($query){
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_penerimaan_lihat&id=$faktur&key=$key&tahun=$tahun';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_penerimaan_lihat&id=$faktur&key=$key&tahun=$tahun';";
		echo "</script>";
	}	
}
	echo "<script>";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_lihat&id=$faktur&msg=$msg';";
	echo "</script>";
?>