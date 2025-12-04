<?php
	session_start();
	include "../config/koneksi.php";
	include "../config/helper_bpjs.php";
	$nik = $_POST['nik'];
	$kodepuskesmas = $_POST['kodepuskesmas'];
	$sts = 1;
	$tanggalregistrasi=date('Y-m-d');
	$jam = date('G:i:s');
	// $tbpasienrj = 'tbpasienrj_'.date('m', strtotime($tanggalregistrasi));
	$tbpasienrj = 'tbpasienrj_'.date('m');
	
	// noregistrasi
	$tahunreg=date('ymd', strtotime($tanggalregistrasi));
	$sql_cek="SELECT max(NoRegistrasi)as maxno from `$tbpasienrj` WHERE substring(NoRegistrasi,13,6) = DATE(now()) AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'";
	$query_cek=mysqli_query($koneksi, $sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
		$no=substr($datareg['maxno'],-3);
		$no_next=$no+1;
			if(strlen($no_next)==1)
			{
				$no="00".$no_next;
			}
			elseif(strlen($no_next)==2)
			{
				$no="0".$no_next;
			}
			else
			{
				$no=$no_next;
			}
	$noregistrasi=$kodepuskesmas."/".$tahunreg."/".$no;	
	
	if($_POST['status'] == 'bpjs'){
		$namapasien = $_POST['namapasienbpjs'];
		$jeniskelamin = $_POST['jeniskelaminbpjs'];
	}else{
		$namapasien = $_POST['namapasien'];
		$jeniskelamin = $_POST['jeniskelamin'];
	}
	
	$nocm = $_POST['nocm'];
	$noindex = $_POST['noindex'];
	$tanggallahir = $_POST['tanggallahir'];
	
	//umur 
	$tglla=explode("-",$tanggallahir);
	$tgl_lahir=$tglla[2];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[0];
	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');
	$harilahir=gregoriantojd($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=gregoriantojd($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi
	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir
	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	
	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;
	
	if($_POST['status'] == 'bpjs'){
		$asuransi = 'BPJS PBI';
	}else{
		$asuransi = 'UMUM';
	}
	
	$polipertama = $_POST['poli'];
	if($polipertama == 'POLI UMUM'){
		$kodepoli = '001';
	}else if($polipertama == 'POLI GIGI'){
		$kodepoli = '002';
	}else if($polipertama == 'POLI KIA'){
		$kodepoli = '003';
	}else if($polipertama == 'POLI LAB'){
		$kodepoli = '004';
	}else if($polipertama == 'POLI KB'){
		$kodepoli = '008';
	}else{
		$kodepoli = '001';
	}

	$tarif = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Tarif FROM `tbpelayanankesehatan` WHERE `Pelayanan` = '$polipertama'"));
	$jeniskunjungan = $jenis_kunjungan;
	$asalpasien = '10';
	$kunjunganlokal = '1';//kunjungan sakit
	$jeniskunjungan = '1';//Rawat Jalan
	$poliselanjutnya = '-';
	$asuransi = $asuransi;
	$statuskunjungan = 'BARU';
	$waktukunjungan = '1';
	$tarif =$tarif['Tarif'];
	$statuspelayanan = 'APM';
	$statuspulang = '3';//berobat jalan
	$namapegawai = '-';
	$tanggalsimpan = date('Y-m-d');
	$kdprovider = $_POST['kodeprovider'];
	$nokartu = $_POST['nokartubpjs'];
	
	// insert tbpasienrj
	// $strpasienrj = "INSERT INTO `tbpasienrj`(`TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NamaPasien`, `WaktuKunjungan`,`StatusBuku`) 
	// VALUES ('$tanggalregistrasi','$noregistrasi','$noindex','$nocm','$namapasien','$waktukunjungan','c')";
	
	$str = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, 
	`UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `WaktuKunjungan`, `Tarif`, `StatusPelayanan`,`StatusPulang`,
	`NamaPegawaiSimpan`, `kdprovider`, `nokartu`, `kdpoli`) 
	VALUES ('$tanggalregistrasi','$noregistrasi','$noindex','$nocm','$namapasien','$jeniskelamin','$tahun_umur', '$bulan_umur', '$hari_umur', 
	'$jeniskunjungan', '$asalpasien', '$kunjunganlokal', '$polipertama','$asuransi','$statuskunjungan','$waktukunjungan','$tarif','$statuspelayanan','$statuspulang',
	'$namapegawai','$kodeprovider','$nokartu','$kodepoli')";
	// echo var_dump($str);
	// die();

	//variabel bpjs
	if($_POST['status'] == 'bpjs'){
		$kdpoli= $kodepoli;
		$keluhan= null;
		$kunjungan = true;
		$sistole = 0;
		$diastole = 0;
		$beratbadan = 0;
		$tinggibadan = 0;
		$resprate = 0;
		$heartrate = 0;
		$rujukbalik = 0;
		$rawatinap = false;
		
		$tgldaftar = date('d-m-Y');
		
		if($kdprovider != null){
			$hasil_simpan_bpjs = simpan_pasien_rj($tgldaftar,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,$rujukbalik,$rawatinap);
			
			$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
			$status = $json_hasil_simpan_bpjs['response'];

			if($status == 'Peserta sudah di-entri pada hari yang sama'){
				echo "<script>";
				echo "alert('Peserta sudah di-entri pada hari yang sama');";
				echo "document.location.href='index.php';";
				echo "</script>";
				$sts = 0;
			}	
		}	
		// echo var_dump($hasil_simpan_bpjs);
		// die();
	}
	if($sts == 1){
		mysqli_query($koneksi,$strpasienrj);
		$query = mysqli_query($koneksi,$str);
		if($query){	
			// echo var_dump($str);
			// die();
			$nourut = $json_hasil_simpan_bpjs['response']['message'];
			$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut' where `NoRegistrasi` = '$noregistrasi'";
			mysqli_query($koneksi, $strupdatenokunjungan);	
			echo "<script>";
			echo "alert('Data berhasil disimpan');";
			echo "document.location.href='index.php?page=etiket&id=$noregistrasi&kodepuskesmas=$kodepuskesmas';";
			echo "</script>";
		}else{
			echo "<script>";
			echo "alert('Data gagal disimpan');";
			echo "document.location.href='index.php';";
			echo "</script>";
		} 	
	}
?>