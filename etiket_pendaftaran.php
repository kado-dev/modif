<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>e-Tiket</title>
		<style>	
			body{
				background:#f5f5f5;
				font-family:calibri;
			}
			.container{
				width: 95mm;
				height: 130mm;
				margin:auto;
				background:#fff;
				padding:10px;
			}
			table{
				width: 95mm;
				border:1px solid #000;
				margin-bottom:30px;
				padding:5px;
				line-height: 12px;
			}
			td, p{
				font-size:16px;
			}
			.btn1{
				position:relative;
				display: block;
				width: 50%;
				background-color: #08c999;
				border: none;
				color: #fff;
				padding: 15px 30px;
				cursor: pointer;
				font-size: 18px;
				font-family: "Poppins", sans-serif;
				border-radius: 5px;
				transition: all 0.2s;
				text-align: center;
				margin-top: 10px;
			}
			.btn2{
				position:relative;
				display: block;
				width: 75%;
				background-color: #006f8e;
				border: none;
				color: #fff;
				padding: 15px 30px;
				cursor: pointer;
				font-size: 18px;
				font-family: "Poppins", sans-serif;
				border-radius: 5px;
				transition: all 0.2s;
				text-align: center;
				margin-top: 10px;
				
			}
			.btn3{
				position:relative;
				display: block;
				width: 85%;
				background-color: #d60000;
				border: none;
				color: #fff;
				padding: 15px 30px;
				cursor: pointer;
				font-size: 18px;
				font-family: "Poppins", sans-serif;
				border-radius: 5px;
				transition: all 0.2s;
				text-align: center;
				margin-top: 10px;
			}
			.textheader{
				text-align: center;
				margin-top: -20px;
				line-height: 18px;
			}
			.textheader_tarif{
				text-align: center;
				margin-top: -28px;
				line-height: 16px;
				border:1px solid #000;
				padding: 5px;
			}
			.textcontent td{
				font-size: 14px;
			}
			@media print{
				.btn1, .btn2{
					display:none;
				}
			}
		</style>	
	</head>
	<body onafterprint="myfunction()">
		<div class="container">
			<?php
			$idprj = $_GET['idprj'];

			// tbpasienrj
			$strdetail = "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idprj'";
			// echo $strdetail;
			$data = mysqli_fetch_assoc(mysqli_query($koneksi, $strdetail));
			$noindex = $data['NoIndex'];
			$idpasien = $data['IdPasien']; 
			$noreg = $data['NoRegistrasi'];
			
			// tbkk
			$strkk = "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
			$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

			// ec_subdistrict
			$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
			if($dt_subdis['subdis_name'] != ''){
				$kelurahan = $dt_subdis['subdis_name'];
			}else{
				$kelurahan = $datakk['Kelurahan'];
			}
			
			// tbpasien
			$strpasien = "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'";
			// echo $strpasien;
			$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, $strpasien));
			
			// rank nomer sesuai poli		
			//$strnoantrian = "select * From (SELECT NoRegistrasi, @curRank := @curRank + 1 AS Rank FROM `$tbpasienrj` p, (SELECT @curRank := 0) r  WHERE date(`TanggalRegistrasi`) = '".date('Y-m-d', strtotime($data['TanggalRegistrasi']))."' and `PoliPertama` = '".$data['PoliPertama']."' ORDER BY `NoRegistrasi`) tb where `NoRegistrasi` = '$noreg'";
			$strnoantrian = "SELECT * FROM ( SELECT NoRegistrasi, ROW_NUMBER() OVER (ORDER BY NoRegistrasi) AS Ranks FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '".date('Y-m-d', strtotime($data['TanggalRegistrasi']))."' AND `PoliPertama` = '".$data['PoliPertama']."') tb WHERE `NoRegistrasi` = '".$noreg."'";
			// echo $strnoantrian;
			$datanoantrian = mysqli_fetch_array(mysqli_query($koneksi, $strnoantrian));
			?>
			<table class="table" width="100%" style="line-height: 15px; border:none; border-bottom: 1px solid #000; padding: 0px;">
				<tr>
					<?php if($kota == "KOTA TARAKAN"){ ?>
					<td width="10%"><img src="image/tarakan.png" width="50px" style="margin-top: 0px;"></td>
					<?php }elseif($kota == "KABUPATEN SUKABUMI"){ ?>
					<td width="10%"><img src="image/sukabumi.png" width="70px" style="margin-top: 0px;"></td>	
					<?php }else{ ?>
					<td width="10%"><img src="image/bandungkabnew.jpg" width="50px" style="margin-top: 0px;"></td>	
					<?php } ?>
					<td width="90%">
						<div style="text-align:center; margin-top:10px;">
							<b style="font-size:16px; font-weight:bold; margin-top:20px;"><?php echo "DINAS KESEHATAN " .$_SESSION['kota'];?></b><br>
						</div>
						<div style="text-align:center; margin-bottom:-5px;">
							<b style="font-size:16px; font-weight:bold; margin-top:20px;"><?php echo "PUSKESMAS " .$_SESSION['namapuskesmas'];?></b><br>
						</div>
						<div style="text-align:center; padding-bottom:10px;">
							<span style="font-size:10px"><?php echo strtoupper($_SESSION['alamat']);?></span>
						</div>
					</td>
				</tr>
			</table>
			
			<p class="textheader">
				<?php 
					if($data['PoliPertama'] == 'POLI UMUM'){
						$ruang = str_replace('POLI','RUANG',$data['PoliPertama']."/DEWASA");
					}else{
						$ruang = str_replace('POLI','RUANG',$data['PoliPertama']);
					}	
				?>
				<b style="font-size:22px;"><?php echo $datanoantrian['Ranks']." - ".$ruang;?></b><br/>
				<b style="font-size:22px;"><?php echo strtoupper($data['Klaster'])." - ".strtoupper($data['SiklusHidup']);?></b><br/>
				<b style="font-size:16px;"><?php echo $data['NamaPasien']." (".$data['JenisKelamin'].")";?></b><br/>
				<span style="font-size:14px;">
					<?php
						if($data['UmurTahun'] != ''){
							$umur = $data['UmurTahun']." TH ".$data['UmurBulan']." BL ".$data['UmurHari']." HR";	
						}else{
							$umur = $data['UmurBulan']." BL ".$data['UmurHari']." HR";	
						}	
						echo " TGL.LAHIR : ".date('d-m-Y', strtotime($datapasien['TanggalLahir']))." (".$umur.")";
					?>
				</span><br/>
				<b style="font-size:16px;"><?php echo "KK. ".$datakk['NamaKK'];?></b><br/>
				<span style="font-size:12px;"><?php echo "ALAMAT : ".$datakk['Alamat']." RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".$kelurahan;?></span><br/>
			</p>
		
			<table class="textcontent">
				<tr>
					<td width="35%">TGL.REGISTRASI</td>
					<td width="65%"><?php echo ": ".$data['TanggalRegistrasi'];?></td>
				</tr>
				<?php if($kota == "KABUPATEN BANDUNG" OR $kota == "KABUPATEN GARUT" OR $kota == "KABUPATEN KUTAI KARTANEGARA"){?>
				<tr>
					<td  width="35%">NO.RM</td>
					<td  width="65%">
					<?php 
						if($datakk['NoRM'] != ''){
							echo ": ".substr($datakk['NoRM'],-6);
						}else{
							echo " : -";
						}
						
					?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td>NO.INDEX - KUNJ.</td>
					<td><?php echo ": ".substr($data['NoIndex'], -10).", ".strtoupper($data['StatusKunjungan']);?></td>
				</tr>
				<tr>
					<td>CARA BAYAR</td>
					<td><?php echo ": ".$data['Asuransi'];?></td>
				</tr>
				<tr>
					<td>NO.BPJS</td>
					<td>
					<?php 
						if($data['nokartu'] != ""){
							echo ": ".$data['nokartu'];
						}else{
							echo ": ".$datapasien['NoAsuransi'];
						}	
					?>
					</td>
				</tr>
				<tr>
					<td>NIK</td>
					<td>
						<?php 
						if($data['Nik']!=''){
							echo ": ".$data['Nik'];
						}else{
							echo ": ".$datapasien['Nik'];
						}
						?>
					</td>
				</tr>
				<tr>
					<td>TELP.</td>
					<td>
						<?php 
							// if($datakk['Telepon'] != ''){
							// 	echo ": ".$datakk['Telepon'];
							// }else{
								// if($datapasien['Telpon'] != ''){
									echo ": ".$datapasien['Telpon'];
								// }else{
								// 	echo ": 0";
								// }	
							// }
						?>
					</td>
				</tr>
				<tr>
					<td>PETUGAS</td>
					<td><?php echo ": ".$data['NamaPegawaiSimpan'];?></td>
				</tr>
			</table>
			
			<?php if($data['Asuransi'] == "UMUM" OR $data['Asuransi'] == "KIR"){ ?>
			<p class="textheader_tarif">
				<b style="font-size:14px;">RETRIBUSI PELAYANAN KESEHATAN</b><br/>
				<b style="font-size:14px;">PELAYANAN RAWAT JALAN</b><br/>
				<b style="font-size:24px;">
				<?php 
					// tbpelayanankesehatan, dibuat ambil total dari retribusi next dikembangkan secara terpisah
					$hariini = date('Y-m-d');
					$str_tagihan = "SELECT SUM(b.SubTotal) as TotalTagihan 
					FROM `tbtagihan` a JOIN `tbtagihan_detail` b on a.IdTagihan = b.IdTagihan 
					WHERE a.`IdPasienrj` = '$idprj' AND (b.Keterangan = 'Tarif Karcis' OR b.Keterangan like '%Tarif Kir%') 
					AND date(a.TanggalTagihan)='$hariini'";
					$gettagihan = mysqli_query($koneksi, $str_tagihan); //  OR b.Keterangan = 'Tarif Administrasi'
					if(mysqli_num_rows($gettagihan) > 0){
						$dttagihan = mysqli_fetch_assoc($gettagihan);
						$totaltarif = $dttagihan['TotalTagihan'];
					}else{
						$totaltarif = 0;
					}

					//$totaltarif = $data['TarifKarcis'] + $data['TarifAdministrasi'];
					echo "Rp. ".rupiah($totaltarif);
					
				?>
				</b><br/>
				<?php if($kota == 'KABUPATEN SUKABUMI'){?>
				<span style="font-size:16px;">Perda No.2 Tahun 2025</span><br/>
				<?php }elseif($kota == 'KABUPATEN BANDUNG'){ ?>
				<span style="font-size:16px;">Perda No.9 Tahun 2025</span><br/>
				<?php } ?>
				
			</p>
			<?php } ?>
			
			<?php if($data['PoliPertama'] != "POLI KIA"){ ?>	
			<table class="textcontent" style="margin-top: -10px; padding-bottom: 60px;">
				<tr>
					<td>Catatan :</td>
					<td></td>
				</tr>
			</table>
			<?php }else{ ?>
			<table class="textcontent" style="margin-top: -20px;">
				<tr><td colspan="2">PEKERJAAN : <?php echo $datapasien['Pekerjaan']?></td></tr>
				<tr><td>PENDIDIKAN : <?php echo $datapasien['Pendidikan']?></td><td>TB/LILA :</td></tr>
				<tr><td>TTL KAB :</td><td>BB/TD :</td></tr>
				<tr><td>HPHT/HPL :</td><td>TFU/DJJ :</td></tr>
				<tr><td>GPA/UK :</td><td>NO.KOHORT :</td></tr>
				<tr><td>JAT/TT :</td><td>RESIKO :</td></tr>
				<tr><td>KUNJ/USG :</td><td>LAB/GOLDAR :</td></tr>
			</table>
			<?php } ?>	
			
			<table class="textcontent" style="border: none; margin-top: -20px;">
				<tr>
					<?php 
						$nourut_bpjs = strlen($data['NoUrutBpjs']);
						if(substr($data['Asuransi'],0,4) == 'BPJS' AND ($nourutbpjs >= 5 OR $data['NoUrutBpjs'] == '' OR $data['NoUrutBpjs'] == '0' OR $data['NoUrutBpjs'] == 'P')){
					?>	
						<div style="text-align:center; margin-bottom:15px;"><b style="font-size:16px;">BRIDGING PCARE GAGAL<br/>SILAHKAN HAPUS DATA & REGISTRASI ULANG...!</b><br/></div>
						
						<td><a href="javascript:print();" class="btn1">PRINT</a></td>
						<td><a href="index.php?page=registrasi_data" class="btn3 noprint">DATA REGISTRASI</a></td>
					<?php }else{ ?>
						<td><a href="javascript:print();" class="btn1">PRINT</a></td>
						<td><a href="index.php?page=registrasi_form" class="btn2">PENDAFTARAN</a></td>
					<?php } ?>
				</tr>
			</table>
		</div>
		<script>
			function myfunction(){
				return document.location.href='index.php?page=registrasi_form';
			}
		</script>
	</body>
</html>
