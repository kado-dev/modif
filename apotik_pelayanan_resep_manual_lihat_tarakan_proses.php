<?php
	$tanggalresep = $_POST['tanggalresep'];
	$noindex = $_POST['noindex'];
	$noresep = $_POST['noresep'];
	$pelayanan = $_POST['poli'];
	$racikan = $_POST['status_racikan'];
	$kdRacikan = '';
	$obatdpho = '';
	$kodebarang = $_POST['kodebarang'];
	$nobatch = $_POST['nobatch'];
	$signa1 = $_POST['signa1'];
	$signa2 = $_POST['signa2'];
	$jumlah = $_POST['jumlah'];
	$jmlpermintaan = '';
	$namaobatnondpho = '';
	$kdobatsk2 = '';
	$anjuran = $_POST['anjuran'];
	$anjuranterapilain = $_POST['anjuranterapilain'];
	$ket_racikan = $_POST['ket_racikan'];
	$statusloket = $_POST['statusloket'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);

	$i = 0;
	foreach($kodebarang as $kode){
		if($kode != ""){
			// cek jika obat sudah ada dalam 1 resep
			$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeBarang)AS Jml FROM `$tbresepdetail` WHERE `NoResep`='$noresep' AND `KodeBarang`='$kodebarang[$i]'"));
			if($cek['Jml'] != 0){
				echo "<script>";
				echo "alert('Data obat sudah diinputkan...');";
				echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat&status=&norsp=$noresep';";
				echo "</script>";
				die();
			}		

			if($anjuran[$i] == 'Lainnya'){
				$anjuran_s = $anjuranterapilain[$i];
			}else{
				$anjuran_s = $anjuran[$i];
			}
					
			// insert tbresepdetail
			$strrsp = "INSERT INTO `$tbresepdetail`(`TanggalResep`,`NoResep`,`racikan`,`kdRacikan`,`obatDPHO`,`KodeBarang`,`NoBatch`,`signa1`,`signa2`,`jumlahobat`,`jmlPermintaan`,`nmObatNonDPHO`,`KdObatSk`,`Pelayanan`,`AnjuranResep`,`KeteranganRacikan`,`Depot`) VALUES ('$tanggalresep','$noresep','$racikan[$i]','$kdRacikan','$obatdphao','$kodebarang[$i]','$nobatch[$i]','$signa1[$i]','$signa2[$i]','$jumlah[$i]','$jmlpermintaan','$namaobatnondpho','$kdobatsk2','$pelayanan','$anjuran_s','$ket_racikan[$i]','$statusloket')";
			$queryrsp=mysqli_query($koneksi,$strrsp);
			
			// update stok tbapotikstok
			$get_stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `$tbapotikstok` WHERE `KodeBarang`='$kodebarang[$i]' AND `NoBatch`='$nobatch[$i]'"));
			$stok_baru = $get_stok_lama['Stok'] - $jumlah[$i];			
			$str_obat_update = "UPDATE `$tbapotikstok` SET `Stok`='$stok_baru' WHERE `KodeBarang`='$kodebarang[$i]' AND `NoBatch`='$nobatch[$i]'";
			// echo $str_obat_update;
			// die();
			mysqli_query($koneksi,$str_obat_update);
		}

	$i = $i + 1;
	}	
	
	if($queryrsp){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=&norsp=$noresep&noid=$noindex&statusloket=$statusloket';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=&norsp=$noresep&noid=$noindex&statusloket=$statusloket';";
		echo "</script>";
	}

?>