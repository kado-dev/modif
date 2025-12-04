<?php
	error_reporting(1);
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";	
	include "config/helper_satusehat.php";
	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapegawai1 = mysqli_real_escape_string($koneksi, $_SESSION['nama_petugas']);
	$namapegawai = strtoupper($namapegawai1);

	$tbpasienonline = "tbpasienonline_".$kodepuskesmas;	
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}

	// helper	
	$namapasien = str_replace("'","",$_POST['namapasien']);
	$noasuransi = $_POST['nokartubpjs'];
	$asuransi = $_POST['asuransi'];
	$jenispeserta = $_POST['jenispeserta'];	
	$idpasien = $_POST['idpasien'];
	
	if(empty($idpasien)){$idpasien = "0";}
	$nocm = $_POST['nocm'];
	$noindex = $_POST['noindex'];
	$NoAntrianPoli = $_POST['noantrian'];
	$tanggalregistrasi1 = $_POST['tanggalregistrasi'];
	$curdate = date('Y-m-d', strtotime($tanggalregistrasi1));

	// if($NoAntrianPoli == ''){
	// 	alert_swal('gagal','No antrian masih kosong, silahkan diisi...');
	// 	echo "<script>";
	// 	echo "document.location.href='index.php?page=registrasi&idpasien=".$idpasien."';";
	// 	echo "</script>";				
	// 	die();
	// }
	
	// notifikasi tgl jika lebih besar
	if(strtotime(date('Y-m-d')) < strtotime($tanggalregistrasi1)){
		alert_swal('gagal','Belum waktunya mengisi registrasi pasien, tanggal yang dipilih lebih besar dari tanggal sekarang...');
		echo "<script>";
		echo "document.location.href='index.php?page=registrasi&idpasien=".$idpasien."';";
		echo "</script>";				
		die();
		// setcookie("alert","<div class='alert alert-danger'>Belum waktunya mengisi registrasi pasien, tanggal yang dipilih lebih besar dari tanggal sekarang...</div>",time()+5);
		// header('location:index.php?page=registrasi&nocm='.$nocm);
		// die();
	}

	if($_POST['polipertama'] == ''){
		alert_swal('gagal','Siliahkan pilih poli terlebih dahulu!');
		echo "<script>";
		echo "document.location.href='index.php?page=registrasi&idpasien=".$idpasien."';";
		echo "</script>";				
		die();
	}

	if($_POST['dokterbpjs'] == ''){
		alert_swal('gagal','Siliahkan pilih dokter terlebih dahulu!');
		echo "<script>";
		echo "document.location.href='index.php?page=registrasi&idpasien=".$idpasien."';";
		echo "</script>";				
		die();
	}

	// split kir
	if ($_POST['kir'] != null){
		$kir = implode(",", $_POST['kir']);	
	}else{
		$kir = "";
	}	
	
	
	// get nik untuk satusehat, jangan pakai ini berat (23-07-2024)
	$nikpasien = $_POST['nikps'];

	// if($kota != 'KABUPATEN BANDUNG' OR $kota != 'KABUPATEN SUKABUMI'){
		// get dok
		$idpegawai_dokter = $_SESSION['idpegawai_dokter'];
		$getnikDokter = mysqli_query($koneksi, "SELECT `Nik` FROM `tbpegawai` WHERE IdPegawai = '$idpegawai_dokter'");
		
		if(mysqli_num_rows($getnikDokter) > 0){
			$dtdokters = mysqli_fetch_assoc($getnikDokter);
			$nikdokter = $dtdokters['Nik'];
			
			// --------------- satu sehat --------------- //
			$stsehat_access_token = $_SESSION['stsehat_access_token'];

			$getDTpatient	= get_Patient($stsehat_access_token,$nikpasien);//get nik
			$IdPatient 		= $getDTpatient['IdPatient'];
			$ResourceType 	= $getDTpatient['ResourceType'];
			$NamePatient 	= $getDTpatient['NamePatient'];

			$getDTPractitioner 	= get_Practitioner($stsehat_access_token,$nikdokter);
			$IdPractitioner		= $getDTPractitioner['IdPractitioner'];
			$ResourceType 		= $getDTPractitioner['ResourceType'];
			$NamePractitioner 	= $getDTPractitioner['NamePractitioner'];

			$datetime = new DateTime();
			$tanggal_start = $datetime->format(DateTime::ATOM);

			$pstsehat['resourceType'] = 'Encounter';
			$pstsehat['status'] = 'arrived';//penting
			$pstsehat['class']['system'] = 'http://terminology.hl7.org/CodeSystem/v3-ActCode';
			$pstsehat['class']['code'] = 'AMB';
			$pstsehat['class']['display'] = 'ambulatory';//menunjukan rawat jalan
			$pstsehat['subject']['reference'] = 'Patient/'.$IdPatient;//penting ihs number
			$pstsehat['subject']['display'] = $NamePatient;//penting
			$pstsehat['participant'][0]['type'][0]['coding'][0]['system'] = "http://terminology.hl7.org/CodeSystem/v3-ParticipationType";
			$pstsehat['participant'][0]['type'][0]['coding'][0]['code'] = 'ATND';
			$pstsehat['participant'][0]['type'][0]['coding'][0]['display'] = 'attender';
			$pstsehat['participant'][0]['individual']['reference']= 'Practitioner/'.$IdPractitioner;//dokter kode
			$pstsehat['participant'][0]['individual']['display']= $NamePractitioner;
			$pstsehat['period']['start'] = $tanggal_start;//'2024-03-01T07:00:00+07:00';//penting, karna baru pendaftaran diisi start saja

			$Satusehat_IdLocation = '';
			$Satusehat_NameLocation = '';
			$getSidLo = mysqli_query($koneksi, "SELECT * FROM satusehat_location WHERE KodePelayanan = '27'");//27 kodeplayanan pendaftaran
			if(mysqli_num_rows($getSidLo) > 0){
				$dtloks = mysqli_fetch_assoc($getSidLo);
				$Satusehat_IdLocation = $dtloks['Satusehat_IdLocation'];
				$Satusehat_NameLocation = $dtloks['NamaLokasi'].", ".$dtloks['description'];
			}

			$pstsehat['location'][0]['location']['reference'] = "Location/".$Satusehat_IdLocation;//penting
			$pstsehat['location'][0]['location']['display'] = $Satusehat_NameLocation;//penting
			$pstsehat['statusHistory'][0]['status'] = 'arrived';//penting
			$pstsehat['statusHistory'][0]['period']['start'] = $tanggal_start;//'2024-03-01T07:00:00+07:00';//penting
			$pstsehat['serviceProvider']['reference'] = 'Organization/'.$_SESSION['stsehat_orgid'];//penting
			$pstsehat['identifier'][0]['system'] = 'http://sys-ids.kemkes.go.id/encounter/'.$_SESSION['stsehat_orgid'];
			$pstsehat['identifier'][0]['value'] = $_SESSION['stsehat_orgid'];//penting

			$data_json 		= json_encode($pstsehat,true);
			$post_encounter	= simpan_satusehat($stsehat_access_token,'Encounter',$data_json);

			$dtaparse 		= json_decode($post_encounter,true);
			$id_kunjungan_satusehat	= $dtaparse['id'];

			// echo $data_json."<br/>";
			// echo $id_kunjungan_satusehat."<br/>";
			// echo $NamePractitioner."<br/>";
			// echo $NamePatient."<br/>";
			// echo $post_encounter."<br/>";
			// die();
			// --------------- satu sehat ----------------- //
		}
	// }
	
	// echo "SELECT `NoRegistrasi` FROM $tbpasienrj WHERE `IdPasien` = '$idpasien' AND date(TanggalRegistrasi) = '$curdate' AND `WaktuKunjungan`='$waktukunjungan'";
	// die();
	// $cek_registrasi = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM $tbpasienrj WHERE `IdPasien` = '$idpasien' AND date(TanggalRegistrasi) = '$curdate' AND `WaktuKunjungan`='$waktukunjungan'"));
	// if($cek_registrasi > 0){
	// 	echo "<script>";
	// 	echo "alert('Pasien sudah diinputkan di hari yang sama...');";
	// 	echo "document.location.href='index.php?page=registrasi&nocm=$nocm';";
	// 	echo "</script>";
	// 	die();
	// }
	
		// noregistrasi
	$tahunreg=date('ymd', strtotime($tanggalregistrasi1));
	$sql_cek="SELECT max(NoRegistrasi)as maxno FROM `$tbpasienrj` WHERE substring(NoRegistrasi,13,6) = '$tahunreg'";
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
	if($datareg['maxno'] != null){
		$no=substr($datareg['maxno'],-3);
	}else{
		$no = 0;
	}
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
	$noregistrasi = $kodepuskesmas."/".$tahunreg."/".nono($no,1);
	
	// variabel
	$sts = 1;
	$tanggalregistrasi = date('Y-m-d', strtotime($_POST['tanggalregistrasi']))." ".date('G:i:s');
	$jam = date('G:i:s');
	$nocm = $_POST['nocm'];
	$norm = $_POST['norm'];
	$jeniskelamin = $_POST['jeniskelamin'];	
	if(empty($jeniskelamin)){$jeniskelamin = "L";}
	$tanggallahir = $_POST['tanggallahir'];
	$pekerjaan = $_POST['pekerjaan'];
	
	// umur
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
	$asalpasien = $_SESSION['layanan_dipilih'];
	$polipertama = $_POST['polipertama'];
	$polipcare = $_POST['polipcare'];
	$poliselanjutnya = $_POST['poliselanjutnya'];
	$statuskunjungan = $_POST['statuskunjungan'];

	$statuspulang = '3'; //berobat jalan
	$tanggalsimpan = date('Y-m-d');
	$klaster = $_POST['klaster'];
	$siklushidup = $_POST['siklushidup'];
	
	$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `kdPoli`,`KodePelayanan` FROM `tbpelayanankesehatan` WHERE Pelayanan = '$polipertama'"));
	$kodepoli_antrean = $dt_poli['KodePelayanan'];
	$kodepoli = $dt_poli['kdPoli'];
	
	// variable bpjs	
	$nokartu = $_POST['nokartubpjs'];
	$kdpoli= $kodepoli;
	$keluhan= null;
	$kunjungan = $_POST['kunjungan'] === 'true'? true : false;
	$sistole = 0;
	$diastole = 0;
	$beratbadan = 50;
	$tinggibadan = 150;
	$resprate = 20;
	$lingkarPerut = 80;
	$heartrate = 70;
	$rujukbalik = 0;
	$kdtkp = "10";			
	
	if($kunjungan == true){
		$kunjunganlokal = '1';// Kunjungan Sakit
	}else{
		$kunjunganlokal = '2';// Kunjungan Sehat
	}
	
	if($_POST['perawatan'] == 'false'){
		$jeniskunjungan = '1';// Rawat Jalan
	}else{
		$jeniskunjungan = '2';// Rawat Inap
	}
	

	//tahap 1, cek status peserta bpjs (aktif/nonaktif)
	if(substr($asuransi,0,4) == 'BPJS'){
		include "config/helper_bpjs_v4.php";			
		// tahap 1, cek status aktif			
		$data_bpjs = get_data_peserta_bpjs($noasuransi);
		$dbpjs = json_decode($data_bpjs,true);
		$ketaktif = $dbpjs['response']['ketAktif'];
		$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];
		if($ketaktif != 'AKTIF'){
			alert_swal('gagal','Status kepesertaan tidak aktif, rubah Asuransi');
			echo "<script>";
			echo "document.location.href='index.php?page=registrasi&kategori_pencarian=BPJS&key=$noasuransi';";
			echo "</script>";				
			die();
		}

		// cek lebih dari 3 kali berkunjung luar faskes
		if($noindex == $noasuransi){
			if($_POST['kunjungan'] == 'true'){
				$strss = "SELECT `NoCM` FROM `$tbpasienrj` WHERE `nokartu` = '$noasuransi' AND `kdprovider` != '$kdprovider'";
				$cekterdaftar = mysqli_num_rows(mysqli_query($koneksi,$strss));
				if($cekterdaftar > 3){
					setcookie("alert","<div class='alert alert-danger'>Maaf No.BPJS ini sudah diregistrasikan 3 kali (Luar Faskes), Silahkan daftar cara bayar umum...</div>",time()+5);
					header('location:index.php?page=registrasi_form');
					die();
				}
			}
		}
		
		// tahap 2, simpan antrian
		$nohp = '0';
		$tanggalperiksa = date('Y-m-d', strtotime($_POST['tanggalregistrasi']));
		$get_dokterbpjs = $_POST['dokterbpjs'];	
		$ex_postdokterbpjs = explode("/",$get_dokterbpjs);
		$kodedokter = (int)$ex_postdokterbpjs[0];
		$nama_dokterbpjs = $ex_postdokterbpjs[1];
		$jampraktek = $ex_postdokterbpjs[2];		
		$noantrean = $NoAntrianPoli;
		$angkaantrean = (int)substr($NoAntrianPoli,1);		
		$keterangan = '';
	
		$simpan_antrean_fktp = simpan_antrean_fktp($noasuransi,$nikpasien,$nohp,$kodepoli,$polipertama,$norm,$tanggalperiksa,$kodedokter,$nama_dokterbpjs,$jampraktek,$noantrean,$angkaantrean,$keterangan);
		// echo $simpan_antrean_fktp;
		// die();

		// tahap 3, update status antrian
		$status = 1; //1, ---> Status 1 = Hadir; Status 2 = Tidak Hadir
		$time_in_ms = round(microtime(true) * 1000); 
		$waktu = $time_in_ms ; //1616559330000 ---> Waktu dalam bentuk timestamp milisecond

		$pgl = update_antrean_fktp($tanggalperiksa,$kodepoli,$noasuransi,$status,$waktu);

		// jika waktu tidak valid, maka gunakan 1757473295000 (10 September 2025)
		$json_hasil_simpan_antrean = json_decode($pgl,True);
		$metacode = $json_hasil_simpan_antrean['metadata']['code'];
		
		if($metacode == '201'){
			$pgl = update_antrean_fktp($tanggalperiksa,$kodepoli,$noasuransi,$status,1757473295000);
		}
		// echo $pgl;
		// die();

		// ini $id dari mana?
		mysqli_query($koneksi,"UPDATE `$tbantrianpasien` SET `responseBpjs`='$pgl' WHERE `IdAntrian` = '$id'");

		// tahap 4, simpan pcare
		if($polipcare == '002'){
			$kdpoli = $polipcare;
		}			
		$hasil_simpan_bpjs = simpan_pasien_rj($tanggalregistrasi1,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$lingkarPerut,$heartrate,$rujukbalik,$kdtkp);	
		//echo "<br/>----<br/>".$hasil_simpan_bpjs;
		$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
		$metacode = $json_hasil_simpan_bpjs['metaData']['code'];
		$metamessage = $json_hasil_simpan_bpjs['metaData']['message'];		
		$nourut = $json_hasil_simpan_bpjs['response']['message'];
		// echo $hasil_simpan_bpjs;
		// die();

		// sementara handle screening bpjs
		// if($metacode == '401'){
		if($metamessage == 'Anda belum melakukan skrining kesehatan. Mohon untuk melakukan skrining kesehatan terlebih dahulu pada menu Skrining Kesehatan.'){
			echo "<script>";
			echo "alert('Anda belum melakukan skrining kesehatan. Mohon untuk melakukan skrining kesehatan terlebih dahulu pada menu Skrining Kesehatan.');";			
			echo "window.open('https://webskrining.bpjs-kesehatan.go.id/skrining', '_blank');";
			echo "document.location.href='index.php?page=registrasi&key=$nokartu&thnlahir=&alamat=&kategori_pencarian=BPJS';";
			echo "</script>";
			$sts = 0;
		}
			
		if($metacode == '401'){
			echo "<script>";
			echo "alert('".$metamessage."');";
			echo "document.location.href='index.php?page=registrasi_form';";
			echo "</script>";
			$sts = 0;
		}
	}
	
	// tahap 2, insert ke tbpasienrj
	if($sts == 1){
		$kdprovider = $_POST['kodeprovider'];
		$get_dokterbpjs = $_POST['dokterbpjs'];	
		$ex_postdokterbpjs = explode("/",$get_dokterbpjs);
		$nama_dokterbpjs = $ex_postdokterbpjs[1];
		$str = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`, `IdPasien`, `Nik`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `TanggalLahir`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `JenisPeserta`, `StatusKunjungan`, `StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`, `NoUrutBpjs`, `kdprovider`, `nokartu`, `kdpoli`, `Kir`, `NoAntrianPoli`, `ResBpjs`, `Pekerjaan`, `IdKunjunganSatuSehat`, `dokterBpjs`,`Klaster`,`SiklusHidup`) 
		VALUES ('$tanggalregistrasi','$idpasien','$nikpasien','$noregistrasi','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$tanggallahir','$tahun_umur', '$bulan_umur', '$hari_umur', '$jeniskunjungan', '$asalpasien', '$kunjunganlokal', '$polipertama','$asuransi','$jenispeserta','$statuskunjungan','Antri','$statuspulang','$namapegawai','$nourut','$kdprovider','$nokartu','$kdpoli','$kir','$NoAntrianPoli','$hasil_simpan_bpjs','$pekerjaan','$id_kunjungan_satusehat','$nama_dokterbpjs','$klaster','$siklushidup')";
		// echo $str;
		// die();
		$query = mysqli_query($koneksi, $str);
		$idprj = mysqli_insert_id($koneksi);

		// tbtagihan
		$strtagihan = "INSERT INTO `tbtagihan`(`IdPasienrj`,`TanggalTagihan`,`IdPasien`,`NamaPasien`,`Poliklinik`,`Asuransi`,`NamaPegawaiSimpan`) VALUES ('$idprj','$tanggalregistrasi','$idpasien','$namapasien','$polipertama','$asuransi','$namapegawai')";
		mysqli_query($koneksi, $strtagihan);
		$idtagihan = mysqli_insert_id($koneksi);

		$status_bayar = '1';//karna puskesmas
		$tarifKarcis = '0';
		if($asuransi == 'UMUM'){
			$status_bayar = '0';
			$gettarif = mysqli_query($koneksi, "SELECT * FROM `tbpelayanankesehatan` where `Pelayanan`='$polipertama'");
			if(mysqli_num_rows($gettarif) > 0){       
				$dttar = mysqli_fetch_assoc($gettarif);
				$tarifKarcis = $dttar['Tarif'];
			}
		}

		$strtagihan_detail = "INSERT INTO `tbtagihan_detail`(`IdTagihan`,`Waktu`,`IdTindakan`,`IdResepDetail`,`Tarif`,`Jumlah`,`Diskon`,`SubTotal`, `Keterangan`, `StatusBayar`, `Medis`, `Paramedis`) VALUES ('$idtagihan','$tanggalregistrasi','0','0','$tarifKarcis','1','0','$tarifKarcis','Tarif Karcis','$status_bayar','','')";
		mysqli_query($koneksi, $strtagihan_detail);

		if($_POST['administrasi'] == 'Ya'){
			$strtagihan_detail2 = "INSERT INTO `tbtagihan_detail`(`IdTagihan`,`Waktu`,`IdTindakan`,`IdResepDetail`,`Tarif`,`Jumlah`,`Diskon`,`SubTotal`, `Keterangan`, `StatusBayar`, `Medis`, `Paramedis`) VALUES ('$idtagihan','$tanggalregistrasi','0','0','5000','1','0','5000','Tarif Administrasi','$status_bayar','','')";
			mysqli_query($koneksi, $strtagihan_detail2);
		}

		if ($_POST['kir'] != null){
			$kirarr = $_POST['kir'];
			foreach($kirarr as $jniskir){
				$gettarif_kir = mysqli_query($koneksi, "SELECT * FROM `tbkir` where `JenisKir`='$jniskir'");
				if(mysqli_num_rows($gettarif_kir) > 0){       
					$dttarkir = mysqli_fetch_assoc($gettarif_kir);
					$tarif_kir = $dttarkir['Tarif'];

					$strtagihan_detail3 = "INSERT INTO `tbtagihan_detail`(`IdTagihan`,`Waktu`,`IdTindakan`,`IdResepDetail`,`Tarif`,`Jumlah`,`Diskon`,`SubTotal`, `Keterangan`, `StatusBayar`, `Medis`, `Paramedis`) VALUES ('$idtagihan','$tanggalregistrasi','0','0','$tarif_kir','1','0','$tarif_kir','Tarif Kir: $jniskir','$status_bayar','','')";
					mysqli_query($koneksi, $strtagihan_detail3);
				}
			}
		}

		// insert log api
		mysqli_query($koneksi,"INSERT INTO `tblogs_api`(`IdPasienrj`, `NomorPeserta`, `TanggalDaftar`, `LogAntrian`, `LogPcareRegister`, `LogPcarePemeriksaan`,`Puskesmas`) VALUES ('$idprj','$noasuransi','$tanggalregistrasi','$simpan_antrean_fktp','$hasil_simpan_bpjs','','$namapuskesmas')");


		// insert tbpasienperpegawai
		$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
		if($kunjunganlokal == '1'){//kunjuangan sakit
			$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`)
			VALUES ('$tanggalregistrasi','$noregistrasi','$namapegawai')";
		}else{
			$namapegawai1 = mysqli_real_escape_string($koneksi, $_POST['namapegawai1']);
			$namapegawai2 = mysqli_real_escape_string($koneksi, $_POST['namapegawai2']);
			$namapegawai3 = mysqli_real_escape_string($koneksi, $_POST['namapegawai3']);
			$namapegawai4 = mysqli_real_escape_string($koneksi, $_POST['namapegawai4']);
			$namapegawai5 = mysqli_real_escape_string($koneksi, $_POST['namapegawai5']);
			$farmasi = $_POST['farmasi'];
			$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`,`NamaPegawai4`,`NamaPegawai5`,`Farmasi`)
			VALUES ('$tanggalregistrasi','$noregistrasi','$namapegawai','$namapegawai1','$namapegawai2','$namapegawai3','$namapegawai4','$namapegawai5','$farmasi')";	
		}
		$query1 = mysqli_query($koneksi, $str_pgw);
		
		// insert tbwaktupelayanan
		$polis = str_replace("POLI ","", strtoupper($polipertama));
		$nomorantrianpoli = preg_replace("/[^0-9]/", "", $NoAntrianPoli);
		$waktuantrian = date('Y-m-d', strtotime($_POST['tanggalregistrasi']));
		$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbantrianpasien` WHERE date(`WaktuAntrian`)='$waktuantrian' AND `NomorAntrianPoli`='$nomorantrianpoli' AND `PoliPertama`='$polis'"));
		$idantrian = $dtantrian['IdAntrian'];
		$ambilantrian = $dtantrian['WaktuAntrian'];
		$panggilantrian = $dtantrian['PanggilAntrian'];

		$str2 = "INSERT INTO `$tbwaktupelayanan`(`IdAntrian`,`NoRM`,`NoRegistrasi`,`NamaPasien`,`NomorAntrianPoli`,`PoliPertama`,`AmbilAntrian`,`PanggilAntrian`,`SelesaiPendaftaran`) 
		VALUES ('$idantrian','$norm','$noregistrasi','$namapasien','$nomorantrianpoli','$polis','$ambilantrian','$panggilantrian',NOW())";
		mysqli_query($koneksi,$str2);

		if($_POST['stsregonline'] == 'ya'){
			$idpasienonline = $_POST['idpasienonline'];
			$strapp = "UPDATE `$tbpasienonline` SET `Approve`='Y' WHERE `IdPasienOnline`='$idpasienonline'";
			mysqli_query($koneksi,$strapp);
		}
		
		// unset session antrian
		$_SESSION['nomorantrian'] = null;
		$_SESSION['poliantrian'] = null;
		$_SESSION['ses_NomorAntrianPoli'] = null;
		$_SESSION['ses_PoliPertama'] = null;
		$_SESSION['ses_IdAntrian'] = null;
		
		if($query){	
			if($kdprovider != null){
				$nourut = $json_hasil_simpan_bpjs['response']['message'];
				$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut' WHERE `IdPasienrj` = '$idprj'";
				mysqli_query($koneksi,$strupdatenokunjungan);		
			}
			alert_notify('sukses','Data berhasil disimpan');
			echo "<script>";
			
			// menentukan etiket
			$nourut_bpjs = strlen($nourut);
			if($nourut_bpjs >= 4){
				echo "document.location.href='index.php?page=registrasi_data';";
			}else{
				// Jika kunjungan sehat etiket gak usah tampil
				if($kunjunganlokal == '1'){
					// echo "document.location.href='index.php?page=registrasi_form&stsetiket=etiket&idprj=$idprj';";
					echo "document.location.href='index.php?page=registrasi_form';";
				}else{
					echo "document.location.href='index.php?page=registrasi_data';";	
				}
			}	
			
			echo "</script>";
		}else{
		// echo var_dump($str);
		// die();
			alert_swal('gagal','Data gagal disimpan');
			echo "<script>";
			echo "document.location.href='index.php?page=registrasi&idpasien=".$idpasien."';";
			echo "</script>";
		} 	
	} 
?>