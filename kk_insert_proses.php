<?php
	error_reporting(1);
	include "config/koneksi.php";
	include "config/helper.php";
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kotasession = $_SESSION['kota'];
	$tbpasien_tahun = 'tbpasien_'.date('Y');
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	// echo $tbkk;
	// die();
	
	$status = $_SESSION['status'];
	if($status == "BPK"){
		//echo "<div class='notifbpjs' style='background: #59bd60!important;'>Maaf, silahkan hubungin Perekam Medis untuk dapat menyimpan data pasien baru...</div>";
		$resp['status'] = 'gagal';
		$resp['keterangan'] = 'Maaf, silahkan hubungin Perekam Medis untuk dapat menyimpan data pasien baru...';
		echo json_encode($resp,true);
		die();
	}		

	// NoIndex
	$tahun=date('Y');
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$sql_noindex="SELECT max(NoIndex)as maxno FROM `$tbkk`";
	$query_noindex=mysqli_query($koneksi,$sql_noindex);
	$data_noindex=mysqli_fetch_array($query_noindex);
	$no1=substr($data_noindex['maxno'],-5);
	
	$no_next1=$no1+1;
		if(strlen($no_next1)==1)
		{
			$no2="0000".$no_next1;
		}
		elseif(strlen($no_next1)==2)
		{
			$no2="000".$no_next1;
		}
		elseif(strlen($no_next1)==3)
		{
			$no2="00".$no_next1;
		}
		elseif(strlen($no_next1)==4)
		{
			$no2="0".$no_next1;
		}
		else
		{
			$no2=$no_next1;
		}
	$noindex = "ID".$kodepuskesmas."/".$tahun."/".$no2;

	// NoCM
	$sql_nocm = "SELECT max(NoCM)as maxno FROM `$tbpasien` WHERE substring(NoCM,13,4) = '$tahun'";
	$query_nocm=mysqli_query($koneksi,$sql_nocm);
	$data_nocm=mysqli_fetch_array($query_nocm);
	$no=substr($data_nocm['maxno'],-6);
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
	
	// variabel tbkk
	$tanggaldaftar = date('Y-m-d');
	$nokk = "0";
	$namakk1 = mysqli_real_escape_string($koneksi, $_POST['namakk']);
	$namakk = strtoupper($namakk1);
	$daerah = $_POST['daerah'];
	$wilayah = $_POST['wilayah'];
	$alamat = strtoupper($_POST['alamat']);
	$rt = ltrim($_POST['rt'], '0');
	if(strlen($rt) == 1){
		$rt2 = "0".$rt;
	}else{
		$rt2 = $rt;
	}
	$rw = $_POST['rw'];
	$no = $_POST['no'];
	$provinsi = $_POST['provinsi'];
	$kodepos = $_POST['kodepos'];
	$kota = $_POST['kota'];
	$kecamatan = $_POST['kecamatan'];
	$kelurahan = $_POST['kelurahan'];

//tambahan alamat domisisil
	$alamat_domisili = strtoupper($_POST['alamat_domisili']);
	$rt_domisili = $_POST['rt_domisili'];
	$rw_domisili = $_POST['rw_domisili'];
	$no_domisili = $_POST['no_domisili'];
	$provinsi_domisili = $_POST['provinsi_domisili'];
	$kodepos_domisili = $_POST['kodepos_domisili'];
	$kota_domisili = $_POST['kota_domisili'];
	$kecamatan_domisili = $_POST['kecamatan_domisili'];
	$kelurahan_domisili = $_POST['kelurahan_domisili'];

	$telepon = $_POST['telepon'];
	$namapegawai = strtoupper($_SESSION['username']);
	$statuskeluarga = $_POST['statuskeluarga'];
	
	// variabel tbpasien
	$nik = $_POST['nik'];	
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
		'KEPONAKAN'=>'98',
		'PONDOK PESANTREN'=>'99',
		'ANAK SEKOLAH'=>'100'
	);
	
	// NoRM
	if($kotasession == 'KABUPATEN BULUNGAN'){
		$norm1 = $_POST['norm1']."".$_POST['norm2']."".$_POST['norm3'];
	}elseif($kotasession == 'KABUPATEN KUTAI KARTANEGARA'){
		$norm1 = $_POST['norm'];
	}else{
		// kabupaten bandung
		$norm1 = $array_stskeluarga[$statuskeluarga].substr($noindex,-5).$tahun;
	}	
	$norm = $kodepuskesmas.$norm1;	
	
	// New RM Bandung Kab
	$cekstatusrm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstatusnomerrm`"));
	$koderm = $_POST['koderm'];
	if($cekstatusrm['StatusIndex'] == "Y"){
		$newrm = $koderm."/".substr($noindex, -5)."/".$array_stskeluarga[$statuskeluarga];
	}else{
		// NoIndex
		$tahun=date('Y');
		$kdpuskesmas = $_SESSION['kodepuskesmas'];
		$sql_newrm = "SELECT max(NewNoRM)as maxno FROM `$tbpasien`";
		$query_newrm = mysqli_query($koneksi, $sql_newrm);
		$data_newrm = mysqli_fetch_array($query_newrm);
		$no1=substr($data_newrm['maxno'],-5);
		
		$no_next1=$no1+1;
			if(strlen($no_next1)==1)
			{
				$no2="0000".$no_next1;
			}
			elseif(strlen($no_next1)==2)
			{
				$no2="000".$no_next1;
			}
			elseif(strlen($no_next1)==3)
			{
				$no2="00".$no_next1;
			}
			elseif(strlen($no_next1)==4)
			{
				$no2="0".$no_next1;
			}
			else
			{
				$no2=$no_next1;
			}
		$noindexnewrm = $no2;
		$newrm = $koderm."/".$noindexnewrm."/".$array_stskeluarga[$statuskeluarga];
	}
		
	$nama_pasien1 = mysqli_real_escape_string($koneksi, $_POST['namapasien']);
	$nama_pasien = strtoupper($nama_pasien1);
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
	
	// cek data kk yang sama
	if($_POST['forcesimpan'] == '0'){
		$q_cek = mysqli_query($koneksi, "SELECT `NoIndex`,`Nik`, `NamaPasien`,`StatusRetensi` FROM $tbpasien WHERE `NamaPasien` = '$nama_pasien' AND `Nik` = '$nik' AND `StatusRetensi`='N'");
		$cek_kk = mysqli_num_rows($q_cek);
		if ($cek_kk >= 1){
			$dtcek = mysqli_fetch_assoc($q_cek);

			$resp['status'] = 'gagal';
			$resp['id'] = $dtcek['NoIndex'];
			$resp['keterangan'] = 'Kepala Keluarga Sudah Pernah Terdaftar di Puskesmas.';
			echo json_encode($resp,true);
			die();
		}
	}	
	
	// tbkk
	$str = "INSERT INTO `$tbkk`(`TanggalDaftar`, `NoIndex`, `NoKK`,`NoRM`,`NamaKK`, `Daerah`, `Wilayah`, `Alamat`,`RT`, `RW`, `No`, `Provinsi`, `KodePos`, `Kota`, `Kecamatan`, `Kelurahan`, `Telepon`, `Alamat_domisili`,`RT_domisili`, `RW_domisili`, `No_domisili`, `Provinsi_domisili`, `KodePos_domisili`, `Kota_domisili`, `Kecamatan_domisili`, `Kelurahan_domisili`, `NamaPegawaiSimpan`) 
	VALUES ('$tanggaldaftar','$noindex','$nokk','$norm','$namakk','$daerah','$wilayah','$alamat','$rt','$rw','$no','$provinsi','$kodepos','$kota','$kecamatan','$kelurahan','$telepon','$alamat_domisili','$rt_domisili','$rw_domisili','$no_domisili','$provinsi_domisili','$kodepos_domisili','$kota_domisili','$kecamatan_domisili','$kelurahan_domisili','$namapegawai')";
	// echo $str;
	// die();
	mysqli_query($koneksi,$str);
	
	// tbpasien
 	$str2 = "INSERT INTO `$tbpasien`(`TanggalDaftar`,`NoIndex`,`NoCM`,`Nik`,`NoRM`,`NamaPasien`,`StatusKeluarga`,`TanggalLahir`,`JenisKelamin`,`Agama`,`StatusNikah`,`Pendidikan`,`Pekerjaan`,`Asuransi`,`StatusAsuransi`,`NoAsuransi`,`kdprovider`,`Telpon`) 
	VALUES ('$tanggaldaftar','$noindex','$nocm','$nik','$norm','$nama_pasien','$statuskeluarga','$tgllahir','$jeniskelamin','$agama','$statusnikah','$pendidikan','$pekerjaan','$asuransi','$statusasuransi','$noasuransi','$kodeppk','$telepon')";
	// echo $str2;
	// die();	
	$query = mysqli_query($koneksi, $str2);
	$idpasien = mysqli_insert_id($koneksi);
	
	
	if($query){	
		// echo "<script>";
		// echo "alert('Data berhasil disimpan');";
		// echo "document.location.href='index.php?page=registrasi&idpasien=$idpasien';";
		// echo "</script>";

		// alert('sukses','Data berhasil disimpan');
		// echo "<script>";
		// echo "document.location.href='index.php?page=registrasi&nocm=$nocm';";
		// echo "</script>";
		// $resp['nocm'] = $nocm;

		$resp['idpasien'] = $idpasien;
		$resp['status'] = 'sukses';
		$resp['keterangan'] = 'Data berhasil disimpan';
		echo json_encode($resp,true);
	}else{
		// echo "<script>";
		// echo "alert('Data gagal disimpan');";
		// echo "document.location.href='index.php?page=anggota_kk_insert';";
		// echo "</script>";

		// alert('gagal','Data gagal disimpan');
		// echo "<script>";
		// echo "document.location.href='index.php?page=kk_insert';";
		// echo "</script>";
			
		$resp['status'] = 'gagal';
		$resp['keterangan'] = 'Data gagal disimpan';
		echo json_encode($resp,true);
	} 	
?>