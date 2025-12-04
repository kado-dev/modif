<?php
session_start();
include "config/koneksi.php";
include "config/helper_pasienrj.php";
include "config/helper_bpjs_v4.php";

$tgl = $_GET['key'];
$nama = $_GET['nama'];

if($tgl != ''){
	$tgl =  date('Y-m-d', strtotime($tgl));
}else{
	$tgl = date('Y-m-d');
}

// NoUrutBpjs = '' mencari yang belum dapat no.urut bpjs itu yg dikirim ulang
$str = "SELECT * FROM `$tbpasienrj` WHERE Asuransi like '%BPJS%' AND date(TanggalRegistrasi) = '$tgl' AND NoUrutBpjs = ''";

$query = mysqli_query($koneksi,$str);
while($data = mysqli_fetch_assoc($query)){
	$noregistrasi = $data['NoRegistrasi'];
	$tanggalregistrasi = date("d-m-Y", strtotime($data['TanggalRegistrasi']));
	// $kdprovider = $data['kdprovider'];
	$idpasienrj = $data['IdPasienrj'];
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
	$lingkarPerut =  0;
	$heartrate =  0;
	$rujukbalik = 0;
	$kdtkp =  10;
	
	// cek kode provider / ppk
	$data_bpjs = get_data_peserta_bpjs($nokartu);
	$dbpjs = json_decode($data_bpjs,TRUE);
	$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];

	// echo "kodeprovider : ".$kdprovider;
	// die();
			
	// mysqli_query($koneksi, "UPDATE `$tbpasienrj` SET NoUrutBpjs='' WHERE `NoRegistrasi`='$noregistrasi' AND `StatusPelayanan`='Antri'");
	if($kdprovider != ''){		
		$hasil_simpan_bpjs = simpan_pasien_rj($tanggalregistrasi,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$lingkarPerut,$heartrate,$rujukbalik,$kdtkp);	
		$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
		
		// echo $tanggalregistrasi."</br>".
		// $kdprovider."</br>".
		// $nokartu."</br>".
		// $kdpoli."</br>".
		// $keluhan."</br>".
		// $kunjungan."</br>".
		// $sistole."</br>".
		// $diastole."</br>".
		// $beratbadan."</br>".
		// $tinggibadan."</br>".
		// $resprate."</br>".
		// $lingkarPerut."</br>".
		// $heartrate."</br>".
		// $rujukbalik."</br>".
		// $kdtkp."</br>";		
		// echo $hasil_simpan_bpjs;
		// die();
		
		// if($json_hasil_simpan_bpjs['metaData']['code'] == 428){
		// 	echo "<script>";
		// 	echo "alert('Peserta sudah di-entri di poli yang sama pada hari yang sama...');";
		// 	echo "document.location.href='index.php?page=registrasi_data';";
		// 	echo "</script>";
		// }else{
			$status = $json_hasil_simpan_bpjs['response'];
			$nourut = $json_hasil_simpan_bpjs['response']['message'];
			// echo "Nourut : ".$nourut;
			// die();

			// if($nourut != ''){
				$str2 = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut', `kdprovider`='$kdprovider' WHERE `IdPasienrj`='$idpasienrj'";
				// echo $str2;
				// die();
				$query2 = mysqli_query($koneksi,$str2);
			// }
		// }
	}
}	

if($query2 != ''){
	echo "<script>";
	echo "alert('Data berhasil di export...');";
	echo "document.location.href='index.php?page=registrasi_data';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal di export...');";
	echo "document.location.href='index.php?page=registrasi_data';";
	echo "</script>";
}		
?>	