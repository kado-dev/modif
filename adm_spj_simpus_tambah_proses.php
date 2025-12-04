<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	date_default_timezone_set('Asia/Jakarta');

    $namapuskesmas = $_SESSION['namapuskesmas'];
	$namakegiatan = mysqli_real_escape_string($koneksi, $_POST['namakegiatan']);
	$kodrek = $_POST['kodrek'];
	$satuan = $_POST['nik'];
    $nilaipagu = $_POST['nilaipagu'];
    $nipkeuangan = $_POST['nipkeuangan'];
    $namapejabatkeuangan = $_POST['namapejabatkeuangan'];
    $nipbendahara = $_POST['nipbendahara'];
    $namabendahara = $_POST['namabendahara'];

	//cek puskesmas
	// $cekpuskes = mysqli_query($koneksi,"SELECT IdRegWorkshop FROM `tbregistrasi_workshop` WHERE Puskesmas = '$puskesmas'");
	// if(mysqli_num_rows($cekpuskes) > 0){
	// 	$dd = mysqli_fetch_array($cekpuskes);
	// 	alert('gagal','Data registrasi gagal dikirim, Puskesmas Sudah terdaftar!');
	// 	echo "<script>";
	// 	echo "document.location.href='cetakdata.php?id=".md5($dd['IdRegWorkshop'])."';";
	// 	echo "</script>";
	// 	die();
	// }

	// kodrekpdf
	$var_file = $_FILES['kodrekpdf'];
	$nama_file = $var_file['name'];
	if($nama_file != null){
		 // nama file asli
		$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp = $var_file['tmp_name']; // sumber file
		$namaimgkodrekpdf = "KODREK - ".$namapuskesmas." - ".date('ymdhis').".".$ext; 

	  	if($ext != 'jpeg' && $ext != 'jpg' && $ext != 'png' && $ext != 'pdf'){
	  		alert('gagal','Data registrasi gagal dikirim, kodrek pdf tidak valid!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	  	if($size > 20000000 ){ //5mb
	  		alert('gagal','Data registrasi gagal dikirim, kodrek pdf terlalu besar!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	}else{
		$namaimgkodrekpdf = '';
	}

    // if($namaimgkodrekpdf == ''){
	// 	alert('gagal','Data registrasi gagal dikirim, kodrek pdf tidak valid');
	// 	echo "<script>";
	// 	echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
	// 	echo "</script>";
	// 	die();
	// }
	
	// kopsurat
	$var_file = $_FILES['kopsurat'];
	$nama_file2 = $var_file['name'];
	if($nama_file2 != null){
		 // nama file asli
		$ext = pathinfo($nama_file2, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp2 = $var_file['tmp_name']; // sumber file
		$namaimgkopsurat = "KOP SURAT - ".$namapuskesmas." - ".date('ymdhis').".".$ext; 

	  	if($ext != 'jpeg' && $ext != 'jpg' && $ext != 'png' && $ext != 'pdf'){
	  		alert('gagal','Data registrasi gagal dikirim, kop surat tidak valid!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	  	if($size > 20000000 ){ //5mb
	  		alert('gagal','Data registrasi gagal dikirim, kop surat terlalu besar!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	}else{
		$namaimgkopsurat = '';
	}	

	// if($namaimgkopsurat == ''){
	// 	alert('gagal','Data registrasi gagal dikirim, kop surat tidak valid');
	// 	echo "<script>";
	// 	echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
	// 	echo "</script>";
	// 	die();
	// }

    // sirup
	$var_file = $_FILES['sirup'];
	$nama_file3 = $var_file['name'];
	if($nama_file3 != null){
		 // nama file asli
		$ext = pathinfo($nama_file3, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp3 = $var_file['tmp_name']; // sumber file
		$namasirup = "RUP SIRUP - ".$namapuskesmas." - ".date('ymdhis').".".$ext; 

	  	if($ext != 'jpeg' && $ext != 'jpg' && $ext != 'png' && $ext != 'pdf'){
	  		alert('gagal','Data registrasi gagal dikirim, sirup tidak valid!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	  	if($size > 20000000 ){ //5mb
	  		alert('gagal','Data registrasi gagal dikirim, sirup terlalu besar!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	}else{
		$namasirup = '';
	}

    // if($namasirup == ''){
	// 	alert('gagal','Data registrasi gagal dikirim, sirup tidak valid');
	// 	echo "<script>";
	// 	echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
	// 	echo "</script>";
	// 	die();
	// }

    // skppk
	$var_file = $_FILES['skppk'];
	$nama_file4 = $var_file['name'];
	if($nama_file4 != null){
		 // nama file asli
		$ext = pathinfo($nama_file4, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp4 = $var_file['tmp_name']; // sumber file
		$namaimgskppk = "SK PPK - ".$namapuskesmas." - ".date('ymdhis').".".$ext; 

	  	if($ext != 'jpeg' && $ext != 'jpg' && $ext != 'png' && $ext != 'pdf'){
	  		alert('gagal','Data registrasi gagal dikirim, sk ppk tidak valid!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	  	if($size > 20000000 ){ //5mb
	  		alert('gagal','Data registrasi gagal dikirim, sk ppk terlalu besar!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	}else{
		$namaimgskppk = '';
	}

    // if($namaimgskppk == ''){
	// 	alert('gagal','Data registrasi gagal dikirim, sk ppk tidak valid');
	// 	echo "<script>";
	// 	echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
	// 	echo "</script>";
	// 	die();
	// }

    // skppbj
	$var_file = $_FILES['skppbj'];
	$nama_file5 = $var_file['name'];
	if($nama_file5 != null){
		 // nama file asli
		$ext = pathinfo($nama_file5, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp5 = $var_file['tmp_name']; // sumber file
		$namaimgskppbj = "SK PPBJ - ".$namapuskesmas." - ".date('ymdhis').".".$ext; 

	  	if($ext != 'jpeg' && $ext != 'jpg' && $ext != 'png' && $ext != 'pdf'){
	  		alert('gagal','Data registrasi gagal dikirim, sk ppbj tidak valid!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	  	if($size > 20000000 ){ //5mb
	  		alert('gagal','Data registrasi gagal dikirim, sk ppbj terlalu besar!');
			echo "<script>";
			echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
			echo "</script>";
			die();
	  	}
	}else{
		$namaimgskppbj = '';
	}

    // if($namaimgskppbj == ''){
	// 	alert('gagal','Data registrasi gagal dikirim, sk ppbj tidak valid');
	// 	echo "<script>";
	// 	echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
	// 	echo "</script>";
	// 	die();
	// }

	// tbpegawai
	$str = "INSERT INTO `tbadmspj`(`NamaPuskesmas`,`NamaPaketPekerjaan`, `KodeRekening`, `Satuan`, `NilaiPagu`, `NipKeuangan`, `NamaKeuangan`, `NipBendahara`, `NamaBendahara`, `KodeRekPdf`,`KopSurat`, `Sirup`, `SkPpk`, `SkPpbj`,`Status`)
	VALUES ('$namapuskesmas','$namakegiatan','$kodrek','$satuan','$nilaipagu','$nipkeuangan','$namapejabatkeuangan','$nipbendahara','$namabendahara','$namaimgkodrekpdf','$namaimgkopsurat','$namasirup','$namaimgskppk','$namaimgskppbj','Proses')";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		if($nama_file != null){
			//proses copy
			copy($tmp,'spjsimpus/'.$namaimgkodrekpdf);
		}
		if($nama_file2 != null){
			//proses copy
			copy($tmp2,'spjsimpus/'.$namaimgkopsurat);
		}
		if($nama_file3 != null){
			//proses copy
            copy($tmp3,'spjsimpus/'.$namasirup);
		}
		if($nama_file4 != null){
			//proses copy
            copy($tmp4,'spjsimpus/'.$namaimgskppk);
		}
		if($nama_file5 != null){
			//proses copy
            copy($tmp5,'spjsimpus/'.$namaimgskppbj);
		}
		alert('sukses','Data registrasi berhasil dikirim');
		echo "<script>";
		echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
		echo "</script>";
	}else{
		alert('gagal','Data registrasi gagal dikirim');
		echo "<script>";
		echo "document.location.href='index.php?page=adm_spj_simpus_tambah';";
		echo "</script>";
	} 	
?>