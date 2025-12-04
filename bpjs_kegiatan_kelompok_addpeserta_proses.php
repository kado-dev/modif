<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	
	// variabel
	$tanggalinput = date("Y-m-d", strtotime($_POST['tanggalinput']))." ".date('G:i:s');
	$eduid = $_POST['eduid'];
	$noKartu = $_POST['nobpjs'];
	
	// tahap 1, insert ke BPJS
	$add_anggota_kegiatanbpjs = add_kegiatan_kelompok_anggota($eduid,$noKartu);
	$dtke = json_decode($add_anggota_kegiatanbpjs,True);
	$eduid = $dtke['response']['message'];
	// echo $add_anggota_kegiatanbpjs;
	// die();
	
	// tahap 2, insert tbbpjs_kegiatan_kelompok_addanggota
	// 2.1 panggil data peserta
	$data = get_data_peserta_bpjs($noKartu);
	$dtpeserta = json_decode($data,True);
	// echo $data;
	
	// 2.2 variabel
	$eduid = $_POST['eduid'];
	$nama = $dtpeserta['response']['nama'];
	$sex = $dtpeserta['response']['sex'];
	$hubunganKeluarga = $dtpeserta['response']['hubunganKeluarga'];
	$tglLahir = date('Y-m-d', strtotime($dtpeserta['response']['tglLahir']));
	
	// hitung umur
	$tgl_lahir=date('d', strtotime($dtpeserta['response']['tglLahir']));
	$bln_lahir=date('m', strtotime($dtpeserta['response']['tglLahir']));
	$thn_lahir=date('Y', strtotime($dtpeserta['response']['tglLahir']));
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
	$usia = $tahun_umur;
	$StatusDaftar = $_POST['statusdaftar'];
	$Prolanis = $_POST['prolanis'];
	
	// 2.3 insert tbbpjs_kegiatan_kelompok_addanggota
	$str = "INSERT INTO `tbbpjs_kegiatan_kelompok_addanggota`(`TanggalInput`,`eduId`,`noKartu`,`nama`,`sex`,`hubunganKeluarga`,`tglLahir`,`usia`,`StatusDaftar`,`Prolanis`)
	VALUES ('$tanggalinput','$eduid','$noKartu','$nama','$sex','$hubunganKeluarga','$tglLahir','$usia','$StatusDaftar','$Prolanis')";
	$query = mysqli_query($koneksi,$str);
	// echo $str;
	// die();

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=bpjs_kegiatan_kelompok';";
		echo "</script>";
	}else{
		// echo $strpasien();
		// die();
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=bpjs_kegiatan_kelompok';";
		echo "</script>";
	} 	
?>