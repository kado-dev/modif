<?php
	include "config/koneksi.php";
	include "config/helper_report.php";
	
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$kodediagnosa = $_GET['kodedgs'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	$kodepuskesmas = $_GET['kdpkm'];

	if(isset($bulan) AND isset($tahun)){
	
	// tbdiagnosapasien
	if($tahun == $tahunini){
		$tbpasienrj = 'tbpasienrj_'.$bulan;
	}else{
		$tbpasienrj = 'tbpasienrj_'.$bulan.'_bc';
	}
	
	$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` 
	WHERE KodeDiagnosa = '$kodediagnosa' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalDiagnosa) = '$tahun'";
	// echo $str_diagnosa;	
	// die();
	
	$query_diagnosa = mysqli_query($koneksi,$str_diagnosa);
	while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
		$no = $no + 1;
		$tanggaldiagnosa = $data_diagnosa['TanggalDiagnosa'];
		$noregistrasi = $data_diagnosa['NoRegistrasi'];
		$kodediagnosa = $data_diagnosa['KodeDiagnosa'];
		$kasus = $data_diagnosa['Kasus'];
	
		// tbpasienrj
		$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
		$query_rj = mysqli_query($koneksi,$str_rj);
		$data_rj = mysqli_fetch_assoc($query_rj);
		$namapasien = $data_rj['NamaPasien'];
		$noindex = $data_rj['NoIndex'];
		$kelamin = $data_rj['JenisKelamin'];
		$umurtahun = $data_rj['UmurTahun'];
		$poli = $data_rj['PoliPertama'];
		$statuskunjungan = $data_rj['StatusKunjungan'];
		
		// tbkk
		$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Kelurahan` FROM `$tbkk` WHERE NoIndex = '$noindex'"));
		$kelurahan = $dt_kk['Kelurahan'];
	
		// tbpoliumum
		if ($poli == 'POLI UMUM'){
			$poliumum = 'tbpoliumum_'.$bulan;
			$str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
			$query_umum = (mysqli_query($koneksi,$str_umum));
			$data_umum = mysqli_fetch_assoc($query_umum);
			$anamnesa = $data_umum['Anamnesa'];
			$sistole = $data_umum['Sistole'];
			if ($anamnesa != null){$anamnesa = $data_umum['Anamnesa'];}else{$anamnesa = "-";}
			if ($sistole != null){$sistole = $data_umum['Sistole']."/".$data_umum['Diastole'];}else{$sistole = "-";}
			$beratbdn = $data_umum['BeratBadan'];
			$suhubdn = $data_umum['SuhuTubuh'];
		}else if ($poli == 'POLI UGD'){
			$str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
			$query_ugd = (mysqli_query($koneksi,$str_ugd));
			$data_ugd = mysqli_fetch_assoc($query_ugd);
			$anamnesa = $data_ugd['Anamnesa'];
			$sistole = $data_ugd['Sistole'];
			if ($anamnesa != null){$anamnesa = $data_ugd['Anamnesa'];}else{$anamnesa = "-";}
			if ($sistole != null){$sistole = $data_ugd['Sistole']."/".$data_ugd['Diastole'];}else{$sistole = "-";}
			$beratbdn = $data_ugd['BeratBadan'];
			$suhubdn = $data_ugd['SuhuTubuh'];
		}else if ($poli == 'POLI LANSIA'){
			$str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
			$query_lansia = (mysqli_query($koneksi,$str_lansia));
			$data_lansia = mysqli_fetch_assoc($query_lansia);
			$anamnesa = $data_lansia['Anamnesa'];
			$sistole = $data_lansia['Sistole'];
			if ($anamnesa != null){$anamnesa = $data_lansia['Anamnesa'];}else{$anamnesa = "-";}
			if ($sistole != null){$sistole = $data_lansia['Sistole']."/".$data_lansia['Diastole'];}else{$sistole = "-";}
			$beratbdn = $data_lansia['BeratBadan'];
			$suhubdn = $data_lansia['SuhuTubuh'];
		}		
	
		// proses insert tbdiagnosadiare
		mysqli_query($koneksi,"DELETE FROM `tbdiagnosadiare` WHERE `NoRegistrasi` = '$noregistrasi'");
		$strdgs = "INSERT INTO `tbdiagnosadiare`(`TanggalRegistrasi`, `NoRegistrasi`, `NamaPasien`, `Kelamin`, `UmurTahun`, `Kelurahan`, `BeratBadan`,
		`SuhuBadan`, `Kunjungan`, `TandaBahaya`, `LamaDiare`, `Klasifikasi`, `Rujuk`, `Oralit`, `Infus`, `Zinc`, `Antibiotik`,
		`ObatLain`, `Keterangan`, `Nakes`)
		VALUES ('$tanggaldiagnosa','$noregistrasi','$namapasien','$kelamin','$umurtahun','$kelurahan','$beratbdn','$suhubdn',
		'$statuskunjungan','Tidak ada','2','Tanpa Dehidrasi','Tidak','5','0','5','Tidak','-','-','Sarana Kesehatan')";
		// echo $strdgs;
		// die();
		$query = mysqli_query($koneksi,$strdgs);
	}
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=lap_P2M_penyakit&bulan=$bulan&tahun=$tahun&kodebpjs=$kodediagnosa&kasus=&kelurahan=semua';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=lap_P2M_penyakit';";
		echo "</script>";
	}	

	}
	?>