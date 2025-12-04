<?php
	session_start();
	include "config/koneksi.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$noindex = $_POST['noindex'];
	$nik = $_POST['nik'];
	$noasuransi = $_POST['nobpjs'];
	$nocm = $_POST['nocm'];
	$noregistrasi = $_POST['noreg'];
	$pelayanan = $_POST['pel'];
	$namapasien = $_POST['namapasien'];
	$jeniskelamin = $_POST['jeniskelamin'];
	$pekerjaan = $_POST['pekerjaan'];
	$alamat = $_POST['alamat'];
	$kelurahan = $_POST['kelurahan'];
	$kecamatan = $_POST['kecamatan'];
	$telepon = $_POST['telepon'];			
	$tanggallahir = date("Y-m-d",strtotime($_POST['tanggallahir']));
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);

	//umur 
	$tgl_lahir=date("d",strtotime($_POST['tanggallahir']));
	$bln_lahir=date("m",strtotime($_POST['tanggallahir']));
	$thn_lahir=date("Y",strtotime($_POST['tanggallahir']));
	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');

	$harilahir=GregorianToJD($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=GregorianToJD($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi
	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir
	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	
	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;
	
	// tbpasien tahun
	$str = "UPDATE `$tbpasien` SET `NamaPasien`='$namapasien',`TanggalLahir`='$tanggallahir',`JenisKelamin`='$jeniskelamin',`Pekerjaan`='$pekerjaan',`Nik`='$nik',`NoAsuransi`='$noasuransi' WHERE `NoCM`='$nocm'";
	$query=mysqli_query($koneksi,$str);	
		
	// tbkk
	$str_kk = "UPDATE `$tbkk` SET `Alamat`='$alamat',`Kelurahan`='$kelurahan',`Kecamatan`='$kecamatan',`Telepon`='$telepon' WHERE `NoIndex`='$noindex'";
	mysqli_query($koneksi,$str_kk);
	
	// tbpasienrj
	$str_prj = "UPDATE `$tbpasienrj` SET `NamaPasien`='$namapasien',`UmurTahun`='$tahun_umur',`UmurBulan`='$bulan_umur',`UmurHari`='$hari_umur' WHERE `NoRegistrasi`='$noregistrasi'";
	mysqli_query($koneksi,$str_prj);
	
	// echo $str;
	// die();	
	if($query){	
		echo "sukses";
	}else{
		echo "gagal";
	} 	
?>