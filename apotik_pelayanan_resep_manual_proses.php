<?php
	$namapegawai = strtoupper($_SESSION['username']);
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$kota = $_SESSION['kota'];
	$tanggalresep = date('Y-m-d', strtotime($_POST['tanggalresep']))." ".date('G:i:s');
	if ($kota == 'KABUPATEN BOGOR'){
		// noindex dan nocm sengaja dikosongin karena belum menggunakan simpus
		$noindex = 0;
		$nocm = 0;
	}else{
		$noindex = $_POST['noindex'];
		$nocm = $_POST['nocm'];
	}
	$idpasienrj = $_POST['idpasienrj'];
	$namapasien = strtoupper($_POST['namapasien']);
	$umurtahun = $_POST['umurtahun'];
	$umurbulan = $_POST['umurbulan'];
	$alamat = $_POST['alamat'];
	$asuransi = $_POST['asuransi'];
	$diagnosa = $_POST['diagnosa'];
	$poli = $_POST['poli'];
	$noregistrasi = $_POST['noregistrasi'];
	$sumberdata = $_POST['sumberdata'];
	$statusloket = $_POST['statusloket'];
	
	if($sumberdata == 'offline'){
		// noresep
		$tahun=date('Y');
		$tahunreg=date('ymd', strtotime($tanggalresep));
		$sql_cek  ="SELECT max(NoResep)as maxno FROM `$tbresep` WHERE SUBSTRING(NoResep,13,6) = '$tahunreg'";
		$query_cek=mysqli_query($koneksi,$sql_cek);
		$dataresep=mysqli_fetch_array($query_cek);
		$no=substr($dataresep['maxno'],-3);
		$no_next=$no+1;
		if(strlen($no_next)==1)
		{
			$nr="00".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$nr="0".$no_next;
		}
		else
		{
			$nr=$no_next;
		}
		$noresep = $kodepuskesmas."/".$tahunreg."/m/".$nr;
	}else{
		$noresep = $noregistrasi;
	}
	// insert 	
	$tgltime = date('Y-m-d G:i:s');
	$str = "INSERT INTO `$tbresep`(`TanggalResep`,`NoResep`,`NoIndex`,`NoCM`,`NamaPasien`,`UmurTahun`,`UmurBulan`,`Alamat`,`StatusBayar`,`Pelayanan`,`Status`,`StatusLoket`,`Pio`,`Diagnosa`,`NamaPegawai`,`OpsiResep`)
	VALUES ('$tanggalresep','$noresep','$noindex','$nocm','$namapasien','$umurtahun','$umurbulan','$alamat','$asuransi','$poli','Sudah','LOKET OBAT','-','$diagnosa','$namapegawai','diberikan resep')";
	// echo $str;
	// die();
	$sv_tbresep = mysqli_query($koneksi,$str);

	if($sv_tbresep){
		//$noresep = $_POST['noresep'];
		$pelayanan = $_POST['poli'];

		$racikan = $_POST['status_racikan'];
		$kdRacikan = '';
		$obatdpho = $_POST['namaobatbpjs'];
		$kodebarang = $_POST['kodebarang'];
		$nobatch = $_POST['nobatch'];
		$signa1 = $_POST['signa1'];
		$signa2 = $_POST['signa2'];
		$jumlah = $_POST['jumlah'];
		$jmlpermintaan = '';
		$namaobatnondpho = $_POST['namaobatbpjs'];
		$kdobatsk2 = '';
		$anjuran = $_POST['anjuran'];
		$anjuranterapilain = $_POST['anjuranterapilain'];
		$ket_racikan = $_POST['ket_racikan'];

		$i = 0;
		foreach($kodebarang as $kode){
			if($kode != ""){
				// cek jika obat sudah ada dalam 1 resep
				$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeBarang)AS Jml FROM `$tbresepdetail` WHERE `NoResep`='$noresep' AND `KodeBarang`='$kodebarang[$i]'"));
				if($cek['Jml'] != 0){
					echo "<script>";
					echo "alert('Data obat sudah diinputkan...');";
					echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=&norsp=$noresep';";
					echo "</script>";
					die();
				}

				if($anjuran[$i] == 'Lainnya'){
					$anjuran_s = $anjuranterapilain[$i];
				}else{
					$anjuran_s = $anjuran[$i];
				}				
						
				// insert tbresepdetail 	
				$strrsp = "INSERT INTO `$tbresepdetail`(`TanggalResep`,`NoResep`,`racikan`,`kdRacikan`,`obatDPHO`,`KodeBarang`,`NoBatch`,`signa1`,`signa2`,`jumlahobat`,`jmlPermintaan`,`nmObatNonDPHO`,`KdObatSk`,`Pelayanan`,`AnjuranResep`,`KeteranganRacikan`,`Depot`) 
				VALUES ('$tanggalresep','$noresep','$racikan[$i]','$kdRacikan','$obatdphao[$i]','$kodebarang[$i]','$nobatch[$i]','$signa1[$i]','$signa2[$i]','$jumlah[$i]','$jmlpermintaan','$namaobatnondpho[$i]','$kdobatsk2','$pelayanan','$anjuran_s','$ket_racikan[$i]','$statusloket')";
				// echo $strrsp;
				// die();
				$queryrsp=mysqli_query($koneksi,$strrsp);
				
				// update stok tbapotikstok
				$get_stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$kodebarang[$i]' AND `NoBatch`='$nobatch[$i]' AND `KodePuskesmas`='$kodepuskesmas' AND `StatusBarang`='$statusloket'"));
				$stok_baru = $get_stok_lama['Stok'] - $jumlah[$i];			
				$str_obat_update = "UPDATE `tbapotikstok` SET `Stok`='$stok_baru' WHERE `KodeBarang`='$kodebarang[$i]' AND `NoBatch`='$nobatch[$i]' AND `KodePuskesmas`='$kodepuskesmas' AND `StatusBarang`='$statusloket'";
				mysqli_query($koneksi,$str_obat_update);
			}
		$i = $i + 1;
		}	
			
		if($queryrsp){	
			echo "<script>";
			echo "alert('Data berhasil disimpan...');";
			if($kota == "KABUPATEN GARUT"){
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&idrj=$idpasienrj&norsp=$noresep&statusloket=$statusloket';";
			}elseif($kota == "KOTA TARAKAN"){
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=&idrj=$idpasienrj&norsp=$noresep&statusloket=$statusloket';";
			}else{
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_offline&norsp=$noresep&statusloket=$statusloket';";
			}
			echo "</script>";
		}else{
			echo "<script>";
			echo "alert('Data gagal disimpan...');";
			if($kota == "KABUPATEN GARUT"){
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&idrj=$idpasienrj&norsp=$noresep&statusloket=$statusloket';";
			}elseif($kota == "KOTA TARAKAN"){
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=&idrj=$idpasienrj&norsp=$noresep&statusloket=$statusloket';";	
			}else{
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_offline&norsp=$noresep&statusloket=$statusloket';";
			}
			echo "</script>";
		}

	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		if($kota == "KABUPATEN GARUT"){
			echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&idrj=$idpasienrj&norsp=$noresep&statusloket=$statusloket';";
		}elseif($kota == "KOTA TARAKAN"){
			echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=&idrj=$idpasienrj&norsp=$noresep&statusloket=$statusloket';";	
		}else{
			echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_offline&norsp=$noresep&statusloket=$statusloket';";
		}
		echo "</script>";
	}
?>