<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	include "config/helper_bpjs_v4.php";
	include "config/helper_satusehat.php";
	$kota = $_SESSION['kota'];	
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}

	$id = $_GET['id'];

	// get data lngkp
	$dtregonline = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbpasienonline WHERE IdPasienOnline = '$id'"));
	$poliaja = str_replace("POLI ", "", $dtregonline['PoliPertama']);
	
	// tahap 1, get noantrianpolirj buat no antrian poli untuk tbpasienrj, tbkodepuskesmas jangan dihapus krna gak mau lewat helperpasienrj
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodepel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE `KodePuskesmas` = '$kodepuskesmas' AND Pelayanan = '$poliaja'"));
	$dtantrianpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbantrianpasien WHERE IdPasienOnline = '$id'"));
	$noantrianpolirj = $kodepel['KodePelayanan']."".$dtantrianpasien['NomorAntrianPoli'];
	// echo $noantrianpolirj;
	// die();

	// tahap 2
	// noregistrasi
	$tahunreg=date('ymd');
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
	$tanggalregistrasi = date('Y-m-d', strtotime($dtregonline['WaktuDaftar']));
	$tanggal_time = $dtregonline['WaktuDaftar'];
	$jam = date('G:i:s');
	
	// tbpasien
	$cek_pasien_qry = mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$dtregonline[IdPasien]'");
	if(mysqli_num_rows($cek_pasien_qry) > 0){
		$dtpasien = mysqli_fetch_assoc($cek_pasien_qry); 
		$idpasien = $dtpasien['IdPasien'];
		$nocm = $dtpasien['NoCM'];
		$norm = $dtpasien['NoRM'];
		$noindex = $dtpasien['NoIndex'];
		$tanggallahir = $dtpasien['TanggalLahir'];
		$pekerjaan = $dtpasien['Pekerjaan'];
	}else{
		$idpasien = 0;//null;
		$nocm = null;
		$norm = null;
		$noindex = null;
		$tanggallahir = $dtregonline['TanggalLahir'];
		$pekerjaan = null;
	}	

	$jeniskelamin = $dtregonline['JenisKelamin'];
	$namapasien = str_replace("'","",$dtregonline['NamaPasien']);
	
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
	$hari_umur = 0;
	$jeniskunjungan = '1'; // Rawat Jalan
	
	$asalpasien = '10';//puskesmas
	$polipertama = $dtregonline['PoliPertama'];
	$asuransi = $dtregonline['Asuransi'];
	//cek status kunjungan baru/lama
	$tahunini = date('y');
	$str_kunj = "SELECT NoRegistrasi FROM `$tbpasienrj` WHERE `NoCM`='$nocm'";
	$cek_kunj = mysqli_num_rows(mysqli_query($koneksi, $str_kunj));
	if($cek_kunj == 0){
		$stskunj = 'Baru';
	}else{
		$stskunj = 'Lama';
	}
	$statuskunjungan = $stskunj;
	$kunjunganlokal = '1';//sakit
	$waktukunjungan = '1';//Shif 1
	$tarifkarcis = '7000';
	$tarifkir = '0';
	$tariftotal = '7000';
	$statuspelayanan = 'Antri';
	$statuspulang = '3';//berobat jalan
	$namapegawai = $_SESSION['nama_petugas'];
	$nokartu = $dtregonline['NoAsuransi'];;
	$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"select kdPoli FROM tbpelayanankesehatan where Pelayanan = '$polipertama'"));
	$kdpoli = $dt_poli['kdPoli'];
	$kir = "";

	// insert ke BPJS
	if(substr($asuransi,0,4) == 'BPJS'){	
		$data_bpjs = get_data_peserta_bpjs($nokartu);
		$dbpjs = json_decode($data_bpjs,true);
		$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];
		$tanggalregistrasi1 = date('d-m-Y', strtotime($dtregonline['WaktuDaftar']));		
		$keluhan = $dtregonline['Keluhan'];
		$kunjungan = true;//kunjungan sakit
		$sistole = 0;
		$diastole = 0;
		$beratbadan = 50;
		$tinggibadan = 150;
		$resprate = 20;
		$lingkarPerut = 80;
		$heartrate = 70;
		$rujukbalik = 0;
		$kdtkp = "10";
		$hasil_simpan_bpjs = simpan_pasien_rj($tanggalregistrasi1,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$lingkarPerut,$heartrate,$rujukbalik,$kdtkp);	
		$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
		$status = $json_hasil_simpan_bpjs['response'];
		$pesan = $json_hasil_simpan_bpjs['response'][0]['message'];
		$nourut = $json_hasil_simpan_bpjs['response']['message'];
		// echo $hasil_simpan_bpjs;
		// die();	
		
		if($status == 'Peserta sudah di-entri pada hari yang sama'){
			echo "<script>";
			echo "alert('Peserta sudah di-entri pada hari yang sama');";
			echo "document.location.href='index.php?page=registrasi_form';";
			echo "</script>";
			$sts = 0;
		}	
	}

	$nikpasien = $dtregonline['Nik'];

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
	
	if ($polipertama == 'POLI KIA KB'){
		$polipertamas = "POLI KIA";
	}else{
		$polipertamas = $polipertama ;
	}
	
	$strpasienrj = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`, `IdPasien`, `Nik`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `TanggalLahir`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `WaktuKunjungan`, `TarifKarcis`,`TarifKir`,`TotalTarif`, `StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NoUrutBpjs`,`kdprovider`, `nokartu`, `kdpoli`, `Kir`, `NoAntrianPoli`, `Pekerjaan`, `IdKunjunganSatuSehat`) 
	VALUES ('$tanggal_time','$idpasien','$nikpasien','$noregistrasi','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$tanggallahir','$tahun_umur', '$bulan_umur', '$hari_umur', '$jeniskunjungan', '$asalpasien', '$kunjunganlokal', '$polipertamas','$asuransi','$statuskunjungan','$waktukunjungan','$tarifkarcis','$tarifkir','$tariftotal','$statuspelayanan','$statuspulang','$namapegawai','$nourut','$kdprovider','$nokartu','$kdpoli','$kir','$noantrianpolirj','$pekerjaan','$id_kunjungan_satusehat')";
	mysqli_query($koneksi,$strpasienrj);	

	// tahap 3
	$str = "UPDATE `$tbpasienonline` SET `Approve`='Y' WHERE `IdPasienOnline`='$id'";
	$query = mysqli_query($koneksi,$str);

	// tahap 4
	$str = "UPDATE `$tbantrianpasien` SET `StatusBpjs`='Selesai' WHERE `IdPasienOnline`='$id'";
	$query = mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diverifikasi...');";
		echo "document.location.href='index.php?page=registrasi_online';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diverifikasi...');";
		echo "document.location.href='index.php?page=registrasi_online';";
		echo "</script>";
	} 
?>