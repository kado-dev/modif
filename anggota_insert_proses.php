<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";

	$status = $_SESSION['status'];
	if($status == "BPK"){
		alert('gagal','Maaf, silahkan hubungin Perekam Medis untuk dapat menyimpan data pasien baru...');
		echo "<script>";
		//echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=anggota_insert&noindex=$noindex';";
		echo "</script>";
		//echo "<div class='notifbpjs' style='background: #59bd60!important;'>Maaf, silahkan hubungin Perekam Medis untuk dapat menyimpan data pasien baru...</div>";
		die();
	}
	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kodeppk = $_SESSION['kodeppk'];
	$kota = $_SESSION['kota'];
	$tahun=date('Y');
	$tgl = date('Y-m-d');
	$noindex = $_POST['noindex'];
	$nik = $_POST['nik'];
	$namakk = $_POST['namakk'];
	$alamatkk = $_POST['alamatkk'];
	$kelurahankk = $_POST['kelurahankk'];
	$statuskeluarga = $_POST['statuskeluarga'];
	
	$array_stskeluarga = array(
		'KEPALA KELUARGA'=>'00',
		'ISTRI'=>'01',
		'ANAK 1'=>'02',
		'ANAK 2'=>'03',
		'ANAK 3'=>'04',
		'ANAK 4'=>'05',
		'ANAK 5'=>'06',
		'ANAK 6'=>'07',
		'ANAK 7'=>'08',
		'ANAK 8'=>'09',
		'ANAK 9'=>'10',
		'ANAK 10'=>'11',
		'ANAK 11'=>'12',
		'ANAK 12'=>'13',
		'ANAK 13'=>'14',
		'ANAK 14'=>'15',
		'ANAK 15'=>'16',
		'ANAK 16'=>'17',
		'ANAK 17'=>'18',
		'ANAK 18'=>'19',
		'ANAK 19'=>'20',
		'BAPAK'=>'90',
		'IBU'=>'91',
		'KAKEK'=>'92',
		'NENEK'=>'93',
		'CUCU'=>'94',
		'MENANTU'=>'95',
		'MERTUA'=>'96',
		'SAUDARA KANDUNG'=>'97',
		'KEPONAKAN'=>'98'
	);
	if($kota == 'KABUPATEN BULUNGAN'){
		$norm1 = $_POST['norm1']."".$_POST['norm2']."".$_POST['norm3'];
		$norm = $kodepuskesmas.$norm1;
	}elseif($kota == 'KABUPATEN KUTAI KARTANEGARA'){
		$norm1 = $_POST['norm'];
		$norm = $kodepuskesmas.$norm1;
	}else{
		$norm1 = $array_stskeluarga[$statuskeluarga].substr($noindex,-5).$tahun;
		$norm = $kodepuskesmas.$norm1;
	}
		
	$nama1 = mysqli_real_escape_string($koneksi, $_POST['nama']);
	$nama = strtoupper($nama1);
	$tanggallahir = $_POST['tanggallahir'];
	$tglla=explode("-",$tanggallahir);
	$tgllahir=$tglla[2]."-".$tglla[1]."-".$tglla[0];
	$jeniskelamin = $_POST['jeniskelamin'];
	$agama = $_POST['agama'];
	$statusnikah = $_POST['statusnikah'];
	$pendidikan = $_POST['pendidikan'];
	$pekerjaan = $_POST['pekerjaan'];
	$asuransi = $_POST['asuransi'];
	$statusasuransi = $_POST['statusasuransi'];
	$noasuransi = $_POST['noasuransi'];
	$kdprovider = $kodeppk;
	$telpon = $_POST['telpon'];
	
	// $tbpasien = 'tbpasien_'.date('Y');
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	// nocm
	$sql_cek="SELECT max(NoCM)as maxno FROM `$tbpasien` WHERE substring(NoCM,13,4) = '$tahun'";
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],-6);
	$no_next=$no+1;
		if(strlen($no_next)==1)
			{
				$no="00000".$no_next;
			}
		elseif(strlen($no_next)==2)
			{
				$no="0000".$no_next;
			}
		elseif(strlen($no_next)==3)
			{
				$no="000".$no_next;
			}
		elseif(strlen($no_next)==4)
			{
				$no="00".$no_next;
			}
		elseif(strlen($no_next)==5)
			{
				$no="0".$no_next;
			}
		else
			{
				$no=$no_next;
			}
	$nocm = $kodepuskesmas."/".$tahun."/".$no;

	// tahap 1, cek nik sama (19-08-2023)	
	$cek_pasien = mysqli_num_rows(mysqli_query($koneksi, "SELECT `Nik` FROM `$tbpasien` WHERE `Nik` = '$$nik' AND `StatusRetensi`='N'"));
	if ($cek_pasien >= 1){
		echo "<script>";
		echo "alert('Nik sudah pernah terdaftar di Puskesmas...');";
		echo "document.location.href='index.php?page=anggota_insert&noindex=$noindex';";
		echo "</script>";
		die();
	}
	
	// tahap 2, cek nama dan tanggal lahir sama (19-08-2023)
	$cek_pasien = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NamaPasien` FROM `$tbpasien` WHERE `NamaPasien` = '$nama' AND `TanggalLahir` = '$tgllahir' AND `StatusRetensi`='N'"));
	if ($cek_pasien >= 1){
		echo "<script>";
		echo "alert('Pasien sudah pernah terdaftar di Puskesmas...');";
		echo "document.location.href='index.php?page=anggota_insert&noindex=$noindex';";
		echo "</script>";
		die();
	}
		
	// tbpasien
	$str = "INSERT INTO `$tbpasien`(`TanggalDaftar`, `NoIndex`, `NoCM`, `Nik`, `NoRM`, `NamaPasien`, `StatusKeluarga`, `TanggalLahir`, `JenisKelamin`, `Agama`, `StatusNikah`, `Pendidikan`, `Pekerjaan`, `Asuransi`, `StatusAsuransi`, `NoAsuransi`,`kdprovider`,`Telpon`) 
	VALUES ('$tgl','$noindex','$nocm','$nik','$norm','$nama','$statuskeluarga','$tgllahir','$jeniskelamin','$agama','$statusnikah','$pendidikan','$pekerjaan','$asuransi','$statusasuransi','$noasuransi','$kdprovider','$telpon')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi, $str);
	
	if($query){	
		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=kk_detail&id=$noindex';";
		echo "</script>";
	}else{
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=anggota_insert&noindex=$noindex';";
		echo "</script>";
	} 	
?>