<?php
	if($kota == "KABUPATEN BULUNGAN" || "KABUPATEN TENGGARONG"){
		date_default_timezone_set('Asia/Balikpapan');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
	
	$status = 'i';
	$stsbuku = $_GET['stsbuku'];
	if($stsbuku == ""){
		$stb = "semua";	
	}else{
		$stb = $_GET['stsbuku'];
	}	
	
	$key = $_GET['key'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
	$tgl = date('Y-m-d');
	$jam = date('H:m:s');
	$tgljam = $tgl." ".$jam;	
	
	
	$noregs = $_POST['noregs'];
	$datas = $_POST['datas'];
	if(isset($datas)){
		foreach($datas as $kd){
			$noreg = $noregs[$kd];
			
			// tbpasienrj
			$str1 = "UPDATE `tbpasienrj` SET `StatusBuku`= '$status' WHERE `NoRegistrasi` = '$noreg'";
			mysqli_query($koneksi,$str1);
			
			// tbpasienrj
			$str2 = "UPDATE `$tbpasienrj` SET `StatusBuku`= '$status', `JamKembaliRM`='$tgljam' WHERE `NoRegistrasi` = '$noreg'";
			mysqli_query($koneksi,$str2);
		}
	}		
	
	echo "<script>";
	echo "alert('Data berhasil diupdate...');";
	echo "document.location.href='index.php?tgl=$tgl&key=$key&stsbuku=$stb&page=rekam_medis';";
	echo "</script>";
?>