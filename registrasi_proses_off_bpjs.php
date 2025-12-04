<?php
	//ini_set('max_execution_time',600);
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	// include "config/helper_bpjs.php";
	date_default_timezone_set('Asia/Jakarta');
	$kodeppk = $_SESSION['kodeppk'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$namapasien = str_replace("'","",$_POST['namapasien']);
	$noasuransi = $_POST['nokartubpjs'];
	$asuransi = $_POST['asuransi'];
	$kelurahan = $_POST['kelurahan'];
	$nocm = $_POST['nocm'];
	$noindex = $_POST['noindex'];
	$NoAntrianPoli = $_POST['noantrian'];

	if ($_POST['kir'] != null){
		$kir = implode(",", $_POST['kir']);		
	}else{
		$kir = "";
	}
	$tanggalregistrasi1 = $_POST['tanggalregistrasi'];
	$curdate = date('Y-m-d', strtotime($tanggalregistrasi1));
	
	if(strtotime(date('Y-m-d')) < strtotime($tanggalregistrasi1)){
		setcookie("alert","<div class='alert alert-danger'>Belum waktunya mengisi registrasi pasien, tanggal yang dipilih lebih besar dari tanggal sekarang...</div>",time()+5);
		header('location:index.php?page=registrasi&nocm='.$nocm);
		die();
	}
	
	//$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($tanggalregistrasi1));
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;

	// ngecek duplikasi data
	if(strlen($nocm) == 13){
		$cek_registrasi = mysqli_num_rows(mysqli_query($koneksi,"SELECT `nokartu` FROM $tbpasienrj WHERE nokartu = '$nocm' AND TanggalRegistrasi = '$curdate'"));
	}else{ //ini analisa lg relasinya untuk apa?
		$cek_registrasi1 = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoCM` FROM $tbpasienrj WHERE NoCM = '$nocm' AND TanggalRegistrasi = '$curdate'"));
		$cek_registrasi2 = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoCM` FROM $tbpasienrj WHERE nokartu = '$nocm' AND TanggalRegistrasi = '$curdate'"));
		$cek_registrasi = $cek_registrasi1 + $cek_registrasi2;
	}
	
	if($cek_registrasi > 0){
		echo "<script>";
		echo "alert('Pasien sudah diinputkan di hari yang sama...');";
		echo "document.location.href='index.php?page=registrasi_form';";
		echo "</script>";
		die();
	}
	
	if($_POST['asalpasien'] == 10){ // asalpasien -> puskesmas
		if($noindex == $noasuransi){
			if($_POST['kunjungan'] == 'true'){
				$strss = "SELECT `NoCM` FROM `tbpasienrj` WHERE `NoCM` = '$noasuransi' and SUBSTRING(`NoRegistrasi`,1,11)='$kodepuskesmas'";
				$cekterdaftar = mysqli_num_rows(mysqli_query($koneksi,$strss));
				if($cekterdaftar > 2){
					setcookie("alert","<div class='alert alert-danger'>Pasien sudah berkunjung 3 kali dan belum terdaftar, Silahkan daftarkan sebagai pasien baru...</div>",time()+5);
					header('location:index.php?page=kk_insert');
					die();
				}
			}
		}
	}
	
	// if(substr($asuransi,0,4) == 'BPJS'){
		// validasi kunjungan lebih dari 3
		// if($kodeppk != $_POST['kodeprovider']){
			// if(strlen($noindex) == 13){
				// $cekregistrasibpjs = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE NoCM='$noasuransi'"));
			// }
			// if($cekregistrasibpjs >= 3){
				// echo "<script>";
				// echo "document.location.href='index.php?page=registrasi_form&alerts=Maaf No.BPJS ini sudah diregistrasikan 3 kali (Luar Faskes)';";
				// echo "</script>";
				// die();
			// }
		// }
	// }

	// noregistrasi
	$tahunreg=date('ymd', strtotime($tanggalregistrasi1));
	$sql_cek="SELECT max(NoRegistrasi)as maxno FROM $tbpasienrj WHERE substring(NoRegistrasi,13,6) = '$tahunreg' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'";
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],-3);
		function nono($y,$x){
			$no_next = $y + $x;
			if(strlen($no_next)==1){
				$no="00".$no_next;
			}else if(strlen($no_next)==2){
				$no="0".$no_next;
			}else{
				$no=$no_next;
			}
			return $no;
		}	
	$noregistrasi=$kodepuskesmas."/".$tahunreg."/".nono($no,1);
	$noregistrasi2=$kodepuskesmas."/".$tahunreg."/".nono($no,2);
	
	// variabel
	$sts = 1;
	$tanggalregistrasi = date("Y-m-d", strtotime($_POST['tanggalregistrasi']));
	$tanggal_time = date('Y-m-d', strtotime($tanggalregistrasi))." ".date('G:i:s');
	$nocm = $_POST['nocm'];
	$norm = $_POST['norm'];
	$jeniskelamin = $_POST['jeniskelamin'];	
	$tanggallahir = $_POST['tanggallahir'];
	
	//umur 
	$tglla=explode("-",$tanggallahir);
	$tgl_lahir=$tglla[2];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[0];
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
	
	$asalpasien = $_POST['asalpasien'];
	$polipertama = $_POST['polipertama'];
	$poliselanjutnya = $_POST['poliselanjutnya'];
	$statuskunjungan = $_POST['statuskunjungan'];
	$waktukunjungan = $_POST['waktukunjungan'];
	$tarifkarcis = $_POST['tarifkarcis'];
	$tarifkir = $_POST['tarifkir'];
	$tariftotal = $_POST['tarif'];
	$statuspelayanan = $_POST['statuspelayanan'];
	$statuspulang = '3';//berobat jalan
	$namapegawai = $_SESSION['username'];
	$tanggalsimpan = date('Y-m-d');
	
	$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"select kdPoli from tbpelayanankesehatan where Pelayanan = '$polipertama'"));
	$kodepoli = $dt_poli['kdPoli'];
	
	$dt_poli2 = mysqli_fetch_assoc(mysqli_query($koneksi,"select kdPoli from tbpelayanankesehatan where Pelayanan = '$poliselanjutnya'"));
	$kdpoli2 = $dt_poli2['kdPoli'];

	// variable bpjs
	$kdprovider = $_POST['kodeprovider'];
	$nokartu = $_POST['nokartubpjs'];
	$kdpoli= $kodepoli;
	$keluhan= '-';
	$kunjungan = $_POST['kunjungan'];
	$sistole = 0;
	$diastole = 0;
	$beratbadan = 0;
	$tinggibadan = 0;
	$resprate = 0;
	$heartrate = 0;
	$rujukbalik = 0;
	//$rawatinap = $_POST['perawatan'];	
	$kdtkp = 10;	
	
	if($kunjungan == 'true'){
		$kunjunganlokal = '1';// Kunjungan Sakit
	}else{
		$kunjunganlokal = '2';// Kunjungan Sehat
	}
	
	if($_POST['perawatan'] == 'false'){
		$jeniskunjungan = '1';// Rawat Jalan
	}else{
		$jeniskunjungan = '2';// Rawat Inap
	}
	
	if($kunjungan == 'false'){
		$statusantri = 'Sudah';
	}else{
		$statusantri = 'Antri';
	}
	
	if ($kdprovider == '0'){
		$kodeprovider = $kodeppk; // dari session
	}else{
		$kodeprovider = $kdprovider; // dari database
	}		
	
	// cek status peserta bpjs (aktif/nonaktif)
	// if(substr($asuransi,0,4) == 'BPJS'){
		// if($_SESSION['koneksi_bpjs']== 'Stabil'){
			// if($_POST['ketaktif'] == 'null'){
				// $data_bpjs = get_data_peserta_bpjs($noasuransi);
				// $dbpjs = json_decode($data_bpjs,true);
				// $ketaktif = $dbpjs['response']['ketAktif'];

				// if($ketaktif != 'AKTIF'){
					// echo "<script>";
					// echo "document.location.href='index.php?page=registrasi_form&alerts=Data gagal disimpan, status kepesertaan tidak aktif silahkan gunakan carabayar Umum / Gratis (KTP)';";
					// echo "</script>";				
					// die();
				// }
			// }else{
				// if($_POST['ketaktif'] != 'AKTIF'){
					// echo "<script>";
					// echo "document.location.href='index.php?page=registrasi_form&alerts=Data gagal disimpan, status kepesertaan tidak aktif silahkan gunakan carabayar Umum / Gratis (KTP)';";
					// echo "</script>";				
					// die();
				// }
			// }	
		// }	
	// }	
	
	$strpasienrj = "INSERT INTO `tbpasienrj`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,`WaktuKunjungan`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`TarifKarcis`,`TarifKir`,`TotalTarif`,`Kir`)
			VALUES ('$tanggalregistrasi','$noregistrasi','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$waktukunjungan','$polipertama','$asuransi','$statuskunjungan','$tarifkarcis','$tarifkir','$tariftotal','$kir')";
	$str = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `WaktuKunjungan`, `TarifKarcis`,`TarifKir`,`TotalTarif`, `StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`, `kdprovider`, `nokartu`, `kdpoli`, `Kir`, `NoAntrianPoli`) 
			VALUES ('$tanggalregistrasi','$noregistrasi','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$tahun_umur', '$bulan_umur', '$hari_umur', '$jeniskunjungan', '$asalpasien', '$kunjunganlokal', '$polipertama','$asuransi','$statuskunjungan','$waktukunjungan','$tarifkarcis','$tarifkir','$tariftotal','$statusantri','$statuspulang','$namapegawai','$kodeprovider','$nokartu','$kodepoli','$kir','$NoAntrianPoli')";

	if($poliselanjutnya != ''){
		$strpasienrj2 = "INSERT INTO `tbpasienrj`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,`WaktuKunjungan`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`TarifKarcis`,`TarifKir`,`TotalTarif`,`Kir`) 
		VALUES ('$tanggal_time','$noregistrasi2','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$waktukunjungan','$polipertama','$asuransi','$statuskunjungan','$tarifkarcis','$tarifkir','$tariftotal','$kir')";	
		$str2 = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `WaktuKunjungan`,`TarifKarcis`,`TarifKir`,`TotalTarif`, `StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`, `kdprovider`, `nokartu`, `kdpoli`, `Kir`, `NoAntrianPoli`) 
		VALUES ('$tanggal_time','$noregistrasi2','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$tahun_umur', '$bulan_umur', '$hari_umur', '$jeniskunjungan', '$asalpasien', '$kunjunganlokal', '$poliselanjutnya','$asuransi','$statuskunjungan','$waktukunjungan','$tarifkarcis','$tarifkir','$tariftotal','$statusantri','$statuspulang','$namapegawai','$kodeprovider','$nokartu','$kdpoli2','$kir','$NoAntrianPoli')";
	}
	
	// insert tbpasienperpegawai
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	if($kunjunganlokal == '1'){//kunjuangan sakit
		$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`)
		VALUES ('$tanggalregistrasi','$noregistrasi','$namapegawai')";
	}else{
		$namapegawai1 = $_POST['namapegawai1'];
		$namapegawai2 = $_POST['namapegawai2'];
		$namapegawai3 = $_POST['namapegawai3'];
		$namapegawai4 = $_POST['namapegawai4'];
		$namapegawai5 = $_POST['namapegawai5'];
		$farmasi = $_POST['farmasi'];
		$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`,`NamaPegawai4`,`NamaPegawai5`,`Farmasi`)
		VALUES ('$tanggalregistrasi','$noregistrasi','$namapegawai','$namapegawai1','$namapegawai2','$namapegawai3','$namapegawai4','$namapegawai5','$farmasi')";	
	}
	$query1 = mysqli_query($koneksi,$str_pgw);
	
	// insert ke tindakan laboratorium
	$idtindakan = $_POST['idtindakanbpjs'];
	$namatindakanbpjs = $_POST['namatindakanbpjs'];
	$kelompoktindakanbpjs = $_POST['kelompoktindakanbpjs'];
	$biaya =  $_POST['tariftindakanbpjs'];
	$tanggaltindakan_time = $tanggalregistrasi." ".date('G:i:s');
	$y = -1;
	
	foreach($idtindakan as $idtin){
		if($idtin != null){
			$y= $y + 1;	
			mysqli_query($koneksi,"INSERT INTO `tbtindakanpasiendetail`(`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`,`PoliAsal`,`PoliRujukan`,`IdTindakan`,`KelompokTindakan`,`JenisTindakan`,`Tarif`,`NamaPegawaiSimpan`) 
			VALUES ('$tanggaltindakan_time','$noregistrasi','$noindex','$nocm','$namapasien','$tahun_umur','$bulan_umur','$hari_umur','$jeniskelamin','PENDAFTARAN','$polipertama','$idtin','$kelompoktindakanbpjs[$y]','$namatindakanbpjs[$y]','$biaya[$y]','$namapegawai')");
		}
	}	
	
	// insert ke BPJS
	// if(substr($asuransi,0,4) == 'BPJS'){
		// $hasil_simpan_bpjs = simpan_pasien_rj_v3($tanggalregistrasi1,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,$rujukbalik,$kdtkp);	
			// $json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
			// $status = $json_hasil_simpan_bpjs['response'];
			
			// if($poliselanjutnya != ''){
				// $hasil_simpan_bpjs2 = simpan_pasien_rj_v3($tanggalregistrasi1,$kdprovider,$nokartu,$kdpoli2,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$heartrate,$rujukbalik,$kdtkp);	
				// $json_hasil_simpan_bpjs2 = json_decode($hasil_simpan_bpjs2,True);
			// }
		
			// if($status == 'Peserta sudah di-entri pada hari yang sama'){
				// echo "<script>";
				// echo "alert('Peserta sudah di-entri pada hari yang sama');";
				// echo "document.location.href='index.php?page=registrasi_form';";
				// echo "</script>";
				// $sts = 0;
			// }	
	// }
	
	//update waktu SelesaiPendaftaran dan nama pasien
	mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `SelesaiPendaftaran`=NOW(), NamaPasien = '$namapasien', NoRM = '$norm', NoRegistrasi = '$noregistrasi' WHERE `NomorAntrianPoli` = '$_SESSION[ses_NomorAntrianPoli]' AND PoliPertama = '$_SESSION[ses_PoliPertama]'");

	if($sts == 1){
		// unset session antrian
		$_SESSION['nomorantrian'] = null;
		$_SESSION['poliantrian'] = null;
		$_SESSION['ses_NomorAntrianPoli'] = null;
		$_SESSION['ses_PoliPertama'] = null;

		mysqli_query($koneksi,$strpasienrj);
		$query = mysqli_query($koneksi,$str);
		
		if($poliselanjutnya != ''){
			mysqli_query($koneksi,$strpasienrj2);
			$qry2 = mysqli_query($koneksi,$str2);
			
			if($qry2){
				$nourut2 = $json_hasil_simpan_bpjs2['response']['message'];
				$strupdatenokunjungan2 = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut2' WHERE `NoRegistrasi` = '$noregistrasi2' AND PoliPertama = '$poliselanjutnya'";
				mysqli_query($koneksi,$strupdatenokunjungan2);
			}
		}
		if($query){	
			if($kdprovider != null){
				$nourut = $json_hasil_simpan_bpjs['response']['message'];
				$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut' WHERE `NoRegistrasi` = '$noregistrasi' AND PoliPertama = '$polipertama'";
				mysqli_query($koneksi,$strupdatenokunjungan);		
			}
			echo "<script>";
			echo "alert('Data berhasil disimpan');";
			// die();
			echo "document.location.href='index.php?page=registrasi_form';";
			echo "</script>";
		}else{
		// echo var_dump($str);
		// die();
			echo "<script>";
			echo "alert('Data gagal disimpan');";
			echo "document.location.href='index.php?page=registrasi_form';";
			echo "</script>";
		} 	
	} 
?>