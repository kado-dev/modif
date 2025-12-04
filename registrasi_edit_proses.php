<?php
	error_reporting(1);
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";

	$idpasienrj = $_POST['idpasienrj'];	
	$noregistrasi = $_POST['noregistrasi'];
	$jeniskunjungan = $_POST['jeniskunjungan'];
	$asalpasien = $_SESSION['layanan_dipilih'];
	$polipertama = $_POST['polipertama'];
	$poliselanjutnya = '-';
	$asuransi = $_POST['asuransi'];
	$statuspemeriksaan = $_POST['statuspemeriksaan'];

	$namapegawai1 = mysqli_real_escape_string($koneksi, $_SESSION['username']);
	$namapegawai = strtoupper($namapegawai1);
	$tanggalsimpan = date('Y-m-d');
	$klaster = $_POST['klaster'];
	$siklushidup = $_POST['siklushidup'];

	if ($_POST['kir'] != null){
		$kir = implode(",", $_POST['kir']);	
	}else{
		$kir = '';
	}
	
	// poli yang dituju
	$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `kdPoli` FROM `tbpelayanankesehatan` WHERE `Pelayanan`='$polipertama'"));
	$kodepoli_dituju = $dt_poli['kdPoli'];
	
	//variable bpjs
	$tanggalregistrasi1 = date('d-m-Y', strtotime($_POST['tglregbpjs']));
	$nourutlama = $_POST['nourutlama'];
	$kdprovider = $_POST['kodeprovider'];
	$nokartu = $_POST['nokartubpjs'];
	$kdpoli = $_POST['kdpoli'];
	$keluhan= '-';
	$kunjungan = $_POST['kunjungan'];
	$sistole = 0;
	$diastole = 0;
	$beratbadan = 0;
	$tinggibadan = 0;
	$resprate = 0;
	$heartrate = 0;
	$rujukbalik = 0;
	$rawatinap = $_POST['perawatan'];

	$kunjungan = $_POST['kunjungan'];
	if($kunjungan == 'true'){
		$kunjunganlokal = '1';//Kunjungan Sakit
	}else{
		$kunjunganlokal = '2';//Kunjungan Sehat
	}
	
	if($_POST['perawatan'] == 'false'){
		$jeniskunjungan = '1';//Rawat Jalan
	}else{
		$jeniskunjungan = '2';//Rawat Inap
	}
	
	/*if(substr($asuransi,0,4) == 'BPJS'){
		// include "config/helper_bpjs.php";
		//delete data di bpjs
		$kdtkp = 10;
		$hasil_delete = delete_registrasi_bpjs($nokartu,$tanggalregistrasi1,$nourutlama,$kdpoli);	
		$json_hasil_simpan_bpjs = json_decode($hasil_delete,True);
		
		$hasil_simpan_bpjs = simpan_pasien_rj_v3($tanggalregistrasi1,$kdprovider,$nokartu,$kodepoli_dituju,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,$rujukbalik,$kdtkp);	
		$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
		$status = $json_hasil_simpan_bpjs['response'];
		$nourut = $json_hasil_simpan_bpjs['response']['message'];	
	}else{
		$nourut = '';
	}*/
	
	$str = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut', `JenisKunjungan`='$jeniskunjungan', `AsalPasien`='$asalpasien',
	`StatusPasien`='$kunjunganlokal', `PoliPertama`='$polipertama', `Asuransi`='$asuransi', 
	`StatusPelayanan`='$statuspemeriksaan',`NamaPegawaiEdit`='$namapegawai', `TanggalEdit`='$tanggalsimpan', `Kir`='$kir', `kdpoli`='$kodepoli_dituju',
	`Klaster`='$klaster',`SiklusHidup`='$siklushidup'
	WHERE IdPasienrj = '$idpasienrj'";
	$query = mysqli_query($koneksi,$str);

	// untuk retensi, menyimpan semuanya
	$str = "UPDATE `$tbpasienrj_retensi` SET `NoUrutBpjs`= '$nourut', `JenisKunjungan`='$jeniskunjungan', `AsalPasien`='$asalpasien',
	`StatusPasien`='$kunjunganlokal', `PoliPertama`='$polipertama', `Asuransi`='$asuransi',
	`StatusPelayanan`='$statuspemeriksaan',`NamaPegawaiEdit`='$namapegawai', `TanggalEdit`='$tanggalsimpan', `Kir`='$kir', `kdpoli`='$kodepoli_dituju'
	WHERE IdPasienrj = '$idpasienrj'";
	mysqli_query($koneksi,$str);

	if($query){
		// alert('sukses','Data berhasil disimpan');
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	}else{
		// alert('gagal','Data gagal disimpan');
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=registrasi_edit&noregistrasi=$noregistrasi';";
		echo "</script>";
	} 	
?>