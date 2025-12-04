<?php
session_start();
include "config/koneksi.php";
include "config/helper_bpjs.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tgl = $_GET['key'];
$nama = $_GET['nama'];

if($tgl != ''){
	$tgl =  date('Y-m-d', strtotime($tgl));
	$tbpasienrj = 'tbpasienrj_'.substr($tgl,5,2);
}else{
	$tgl = date('Y-m-d');
	$tbpasienrj = 'tbpasienrj_'.date('m');
}

// NoUrutBpjs = '' mencari yang belum dapat no.urut bpjs itu yg dikirim ulang
$str = "SELECT * FROM `$tbpasienrj` WHERE Asuransi like '%BPJS%' AND TanggalRegistrasi = '$tgl' 
AND SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND NoUrutBpjs = ''"; 

$query = mysqli_query($koneksi,$str);
while($data = mysqli_fetch_assoc($query)){
	$noregistrasi = $data['NoRegistrasi'];
	$tanggalregistrasi = date("d-m-Y", strtotime($data['TanggalRegistrasi']));	
	$nokartu = $data['nokartu'];
	$kdpoli= $data['kdpoli'];
	$nourut= $data['NoUrutBpjs'];
	$keluhan= null;
	if ($data['JenisKunjungan'] == '1'){
		$kunjungan =  true;
	}else{
		$kunjungan =  false;
	}
	$sistole =  0;
	$diastole =  0;
	$beratbadan =  0;
	$tinggibadan =  0;
	$resprate =  0;
	$heartrate =  0;
	$rujukbalik = 0;
	$kdtkp =  10;
	
	// cek kode provider / ppk
	$data_bpjs = get_data_peserta_bpjs($nokartu);
	$dbpjs = json_decode($data_bpjs,TRUE);
	$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];
	
	if($kdprovider != ''){		
		$hasil_simpan_bpjs = simpan_pasien_rj_v3($tanggalregistrasi,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,$rujukbalik,$kdtkp);	
		$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
		$status = $json_hasil_simpan_bpjs['response'];
		$nourut = $json_hasil_simpan_bpjs['response']['message'];

		if($nourut != ''){
			$str2 = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut', `kdprovider`='$kdprovider' WHERE `NoRegistrasi`='$noregistrasi'";
			mysqli_query($koneksi,$str2);
		}
	}
}	

if($nourut != ''){
	echo "<script>";
	echo "alert('Data berhasil di export');";
	echo "document.location.href='index.php?page=registrasi_data';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal di export');";
	echo "document.location.href='index.php?page=registrasi_data';";
	echo "</script>";
}		
?>	