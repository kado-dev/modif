<?php
	error_reporting(0);
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_bpjs_v4.php";
	include "config/helper_pasienrj.php";	

	$idpasienrj = $_GET['idprj'];
	$datapasienjr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `TanggalRegistrasi`,`IdPasienrj`,`NoUrutBpjs`,`nokartu`,`kdpoli` FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));
	$nokartu = $datapasienjr['nokartu'];
	$nourut = $datapasienjr['NoUrutBpjs'];
	$kdpoli = $datapasienjr['kdpoli'];
	$tgl = date('Y-m-d', strtotime($datapasienjr['TanggalRegistrasi']));	
	$tanggal = explode("-",$tgl);
	$tglbpjs = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];	
		
	// delete bpjs
	if($nourut != ''){
		// echo " noka : ".$nokartu."<br.>";
		// echo " tgl : ".$tglbpjs."<br.>";
		// echo " nourut : ".$nourut."<br.>";
		// echo " kp : ".$kdpoli;
		// die();
		$hapus = delete_registrasi_bpjs($nokartu,$tglbpjs,$nourut,$kdpoli);
	}
	
	$str = "DELETE FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'";
	$query = mysqli_query($koneksi,$str);

	// untuk retensi, menyimpan semuanya
	$str = "DELETE FROM `$tbpasienrj_retensi` WHERE `IdPasienrj` = '$idpasienrj'";
	$query = mysqli_query($koneksi,$str);

	// tbtagihan dan detail
	$dttagihan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbtagihan` WHERE `IdPasienrj` = '$idpasienrj'"));
	mysqli_query($koneksi, "DELETE FROM `tbtagihan` WHERE `IdPasienrj` = '$idpasienrj'");	
	mysqli_query($koneksi, "DELETE FROM `tbtagihan_detail` WHERE `IdTagihan` = '$dttagihan[IdTagihan]'");
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	} 	
?>