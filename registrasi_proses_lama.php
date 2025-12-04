<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";	
	$namapegawai1 = mysqli_real_escape_string($koneksi, $_SESSION['nama_petugas']);
	$namapegawai = strtoupper($namapegawai1);
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}

	// helper	
	$namapasien = str_replace("'","",$_POST['namapasien']);
	$noasuransi = $_POST['nokartubpjs'];
	$asuransi = $_POST['asuransi'];
	$idpasien = $_POST['idpasien'];
	$nocm = $_POST['nocm'];
	$noindex = $_POST['noindex'];
	$NoAntrianPoli = $_POST['noantrian'];
	$tanggalregistrasi1 = $_POST['tanggalregistrasi'];
	$curdate = date('Y-m-d', strtotime($tanggalregistrasi1));
	$waktukunjungan = $_POST['waktukunjungan'];
	
	// notifikasi tgl jika lebih besar
	if(strtotime(date('Y-m-d')) < strtotime($tanggalregistrasi1)){
		setcookie("alert","<div class='alert alert-danger'>Belum waktunya mengisi registrasi pasien, tanggal yang dipilih lebih besar dari tanggal sekarang...</div>",time()+5);
		header('location:index.php?page=registrasi&nocm='.$nocm);
		die();
	}

	// split kir
	if ($_POST['kir'] != null){
		$kir = implode(",", $_POST['kir']);	
	}else{
		$kir = "";
	}
	
	// cek duplikasi data
	// echo "SELECT `NoRegistrasi` FROM $tbpasienrj WHERE NoCM = '$nocm' AND date(TanggalRegistrasi) = '$curdate' AND `WaktuKunjungan`='$waktukunjungan'";
	// die();
	
	// $cek_registrasi = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM $tbpasienrj WHERE NoCM = '$nocm' AND date(TanggalRegistrasi) = '$curdate' AND `WaktuKunjungan`='$waktukunjungan'"));
	// if($cek_registrasi > 0){
		// echo "<script>";
		// echo "alert('Pasien sudah diinputkan di hari yang sama...');";
		// echo "document.location.href='index.php?page=registrasi&nocm=$nocm';";
		// echo "</script>";
		// die();
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
	$nocm = $_POST['nocm'];
	$norm = $_POST['norm'];
	$jeniskelamin = $_POST['jeniskelamin'];	
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
	
	$asalpasien = $_POST['asalpasien'];
	$polipertama = $_POST['polipertama'];
	$polipcare = $_POST['polipcare'];
	$poliselanjutnya = $_POST['poliselanjutnya'];
	$statuskunjungan = $_POST['statuskunjungan'];
	$tarifkarcis = $_POST['tarifkarcis'];
	$tarifkir = $_POST['tarifkir'];
	$tariftotal = $_POST['tarif'];
	$statuspulang = '3'; //berobat jalan
	$tanggalsimpan = date('Y-m-d');
	
	$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `kdPoli` FROM `tbpelayanankesehatan` WHERE Pelayanan = '$polipertama'"));
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
			
	// tahap 1, cek status peserta bpjs (aktif/nonaktif)
	if(substr($asuransi,0,4) == 'BPJS'){
		// if($kodepuskesmas == 'P3202280201' OR $kodepuskesmas == 'P3202180201'){
			// cek status aktif
			include "config/helper_bpjs_v4.php";
			$data_bpjs = get_data_peserta_bpjs($noasuransi);
			$dbpjs = json_decode($data_bpjs,true);
			$ketaktif = $dbpjs['response']['ketAktif'];
			$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];

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

			// cek aktif
			// if($ketaktif != 'AKTIF'){
				// echo "<script>";
				// echo "alert('Data gagal disimpan, status kepesertaan tidak aktif silahkan gunakan carabayar Umum / Gratis (KTP)');";
				// echo "document.location.href='index.php?page=registrasi&kategori_pencarian=BPJS&key=$noasuransi';";
				// echo "</script>";				
				// die();
			// }

			// tahap 3, insert ke BPJS menentukan kodepoli yg disimpan di bpjs
			if($polipcare == '002'){
				$kdpoli = $polipcare;
			}
			
			$hasil_simpan_bpjs = simpan_pasien_rj($tanggalregistrasi1,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$lingkarPerut,$heartrate,$rujukbalik,$kdtkp);	
			$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
			$metacode = $json_hasil_simpan_bpjs['metaData']['code'];
			$metamessage = $json_hasil_simpan_bpjs['metaData']['message'];		
			$nourut = $json_hasil_simpan_bpjs['response']['message'];
			// echo $hasil_simpan_bpjs;
			// die();
				
			if($metacode == '401'){
				echo "<script>";
				echo "alert('".$metamessage."');";
				echo "document.location.href='index.php?page=registrasi_form';";
				echo "</script>";
				$sts = 0;
			}
		// }
	}
	
	// tahap 2, insert ke tbpasienrj
	if($sts == 1){
		$kdprovider = $_POST['kodeprovider'];
		$str = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`, `IdPasien`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `WaktuKunjungan`, `TarifKarcis`,`TarifKir`,`TotalTarif`, `StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`, `NoUrutBpjs`, `kdprovider`, `nokartu`, `kdpoli`, `Kir`, `NoAntrianPoli`, `Pekerjaan`) 
				VALUES ('$tanggalregistrasi','$jam','$idpasien','$noregistrasi','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$tahun_umur', '$bulan_umur', '$hari_umur', '$jeniskunjungan', '$asalpasien', '$kunjunganlokal', '$polipertama','$asuransi','$statuskunjungan','$waktukunjungan','$tarifkarcis','$tarifkir','$tariftotal','Antri','$statuspulang','$namapegawai','$nourut','$kdprovider','$nokartu','$kdpoli','$kir','$NoAntrianPoli','$pekerjaan')";
		$query = mysqli_query($koneksi, $str);
		$idprj = mysqli_insert_id($koneksi);

		// untuk ke API Dashkesehatan
		$strpasienrj = "INSERT INTO `tbpasienrj`(`TanggalRegistrasi`, `IdPasien`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `WaktuKunjungan`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`TarifKarcis`,`TarifKir`,`TotalTarif`,`StatusPelayanan`,`Kir`)
		VALUES ('$tanggalregistrasi','$idpasien','$noregistrasi','$noindex','$nocm','$norm','$namapasien','$jeniskelamin','$tahun_umur','$bulan_umur','$hari_umur','$waktukunjungan','$polipertama','$asuransi','$statuskunjungan','$tarifkarcis','$tarifkir','$tariftotal','Antri','$kir')";
		mysqli_query($koneksi, $strpasienrj);

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
			alert('sukses','Data berhasil disimpan');
			echo "<script>";
			//echo "alert('Data berhasil disimpan...');";
			
			// menentukan etiket
			$nourut_bpjs = strlen($nourut);
			if($nourut_bpjs >= 4){
				echo "document.location.href='index.php?page=registrasi_data';";
			}else{
				// Jika kunjungan sehat etiket gak usah tampil
				if($kunjunganlokal == '1'){
					echo "document.location.href='index.php?page=registrasi_form&stsetiket=etiket&idprj=$idprj';";
				}else{
					echo "document.location.href='index.php?page=registrasi_data';";	
				}
			}	
			
			echo "</script>";
		}else{
		// echo var_dump($str);
		// die();
			alert('gagal','Data gagal disimpan');
			echo "<script>";
			//echo "alert('Data gagal disimpan...');";
			echo "document.location.href='index.php?page=registrasi_form';";
			echo "</script>";
		} 	
	} 
?>