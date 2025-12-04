<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";

	// variabel
	$idpasien = $_POST['idpasien'];
	$norm1 = $_POST['norm'];
	$norm = $kodepuskesmas.$norm1;
	$noindex = $_POST['noindex'];
	$nik = $_POST['nik'];
	$nama1 = mysqli_real_escape_string($koneksi, $_POST['nama']);
	$nama = strtoupper($nama1);
	$statuskeluarga = $_POST['statuskeluarga'];
	$tanggallahir = date('Y-m-d',strtotime($_POST['tanggallahir']));
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
	$tahun=date('Y');
	
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
	
	// tahap 1, update tbpasien (07 Agustus 2023)
	$str = "UPDATE `$tbpasien` SET `Nik`='$nik',`NoRM`='$norm',`NamaPasien`='$nama',`StatusKeluarga`='$statuskeluarga',
	`TanggalLahir`='$tanggallahir',`JenisKelamin`='$jeniskelamin',`Agama`='$agama',`StatusNikah`='$statusnikah',`Pendidikan`='$pendidikan',`Pekerjaan`='$pekerjaan',`Asuransi`='$asuransi',
	`StatusAsuransi`='$statusasuransi',`NoAsuransi`='$noasuransi',`kdprovider`='$kdprovider',`Telpon`='$telpon' WHERE `IdPasien`='$idpasien'";
	$query = mysqli_query($koneksi, $str);
	
	// tahap 2, update $tbpasienrj
	$strpasienrj = "UPDATE $tbpasienrj SET `NamaPasien`='$nama', `JenisKelamin`='$jeniskelamin' WHERE `IdPasien`='$idpasien'";
	mysqli_query($koneksi, $strpasienrj);
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=kk_detail&id=$noindex';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=anggota_edit';";
		echo "</script>";
	} 	
?>