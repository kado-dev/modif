<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	error_reporting(0);
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$idpasien = $_GET['id'];
	
	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien`='$idpasien'"));
	
	// tbkk
	$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kecamatan`,`Kota`,`Provinsi`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$datapasien[NoIndex]'";
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

	// ec_subdistricts
	$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
	if($dt_subdis['subdis_name'] !=''){
		$kelurahans = $dt_subdis['subdis_name'];
	}else{
		$kelurahans = $datakk['Kelurahan'];
	}

	// ec_districts
	$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
	if($dt_dis['dis_name'] !=''){
		$kecamatans = $dt_dis['dis_name'];
	}else{
		$kecamatans = $datakk['Kecamatan'];
	}

	// ec_cities
	$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
	if($dt_citi['city_name'] !=''){
		$kotas = $dt_citi['city_name'];
	}else{
		$kotas = $datakk['Kota'];
	}

	// ec_provinces
	$dt_prov = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `prov_name` FROM `ec_provinces` WHERE `prov_id`='$datakk[Provinsi]'"));
	if($dt_prov['prov_name'] !=''){
		$provinsis = $dt_prov['prov_name'];
	}else{
		$provinsis = $datakk['Provinsi'];
	}

	// tbpasienrj
	$datarj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `Noregistrasi`='$noreg'"));
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Blangko Identitas</title>
		<link href="https://fonts.googleapis.com/css?family=Barlow|Big+Shoulders+Text|Muli|Saira+Condensed&display=swap" rel="stylesheet">
		<style>	
			body{
				background: #f5f5f5;
				font-family: 'Barlow', sans-serif;
				font-size : 14px;
			}
			.container{
				width:1050px;
				margin:auto;
				background:#fff;
				padding:10px;
			}
			table{
				width: 100%;
				border-collapse: collapse;
				margin-bottom: 20px;
			}
			.judul{
				font-size : 16px;
				font-family: 'Barlow', sans-serif;
				line-height : 10px; 
			}		
			
			.logopuskesmas{
				filter: grayscale(100%);
				width:75px;
			}
			.logokabupaten{
				filter: grayscale(100%);
				width:110px;
			}
			
			.kotakrm{
				width:25px;
				height:25px;
				margin:0px 4px;
				border:1px solid #000;
			}
			@media print{
				.btn{
					display:none;
				}
			
			}
		</style>	
	</head>

	<?php if($_GET['sts'] == 'registrasi'){ ?>
		<body onload="window.print()" onafterprint="document.location = 'index.php?page=registrasi&idpasien=<?php echo $idpasien;?>'">
	<?php }else{ ?>
		<body onload="window.print()" onafterprint="document.location = 'index.php?page=rekam_medis_klpcm'">
	<?php } ?>
	
		<div class="container">
			<table>
				<tr class="judul">
					<td colspan="2">
						<table width="100%">
							<tr>
								<td width="5%">
									<?php 
										if ($kota == 'KABUPATEN BANDUNG'){
									?>
										<img src="image/bandungkabnew.jpg" class="logokabupaten">
									<?php
										}elseif(($kota == 'KABUPATEN KUTAI KARTANEGARA')){
									?>
										<img src="image/kukarkab.png" class="logokabupaten">
									<?php
										}elseif(($kota == 'KABUPATEN SUKABUMI')){
									?>
										<img src="image/sukabumi.png" class="logokabupaten">
									<?php
										}else{	
									?>
										<img src="image/tarakan.png" class="logokabupaten">
									<?php	
										}
									?>
								</td>
								<td width="90%">
									<h2 style="font-size:24px; font-weight: bold; text-align: center;">DINAS KESEHATAN <?php echo $kota;?></h2>
									<h2 style="font-size:30px; font-weight: bold; text-align: center;">UPT PUSKESMAS <?php echo $namapuskesmas;?></h2>
									<h4 style="font-size:18px; line-height:22px; font-weight: normal; text-align: center;"><?php echo str_replace("KEC.","<br/>KEC.",$alamat);?></h4>
									
								</td>
								<td width="5%">
									<img src="image/logo_puskesmas_noshadow.png" class="logopuskesmas">
								</td>
							</tr>
						</table>
						
					
						<hr style="margin:3px; border:1px solid #000">
					</td>
				</tr>
			</table>
			
			<table class="table-judul" width="100%" cellpadding="2px">
				<tr><td colspan = "3" align="center" style="font-size: 24px; font-weight: bold;text-decoration:underline">IDENTITAS PASIEN</td></tr>	
				<tr><td colspan = "3" align="center" style="font-size: 24px; font-weight: bold;"><?php echo substr($datapasien['NoIndex'],-10);?></td></tr>	
			</table>

			<table class="table-judul" width="100%" cellpadding="10px"style="font-size: 18px;">
				<tr>
					<td width="29%">No Rekam Medis</td>
					<td>:</td>
					<td>
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">
						-
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">
						-
						<input class="kotakrm" type="text">
						<input class="kotakrm" type="text">					
						<br/>
						<span style="font-size:11px">(Kode Desa) - ( No. Index / Family ) - (Kode susunan keluarga)</span>  
					</td>
				</tr>
			</table>
			
			<table class="table-judul" width="100%" cellpadding="10px" style="font-size: 18px;">
				<tr>
					<td ><b>DATA UMUM</b></td>
				</tr>
				<tr>
					<td width="30%">Nama KK</td>
					<td>:</td>
					<td><?php echo strtoupper($datakk['NamaKK']);?></td>
				</tr>
				<tr>
					<td>Nama Pasien</td>
					<td>:</td>
					<td><?php echo strtoupper($datapasien['NamaPasien']);?></td>
				</tr>
				<tr>
					<td>Status Keluarga</td>
					<td>:</td>
					<td><?php echo strtoupper($datapasien['StatusKeluarga']);?></td>
				</tr>
				<tr>
					<td width="30%">NIK</td>
					<td>:</td>
					<td width="70%"><?php echo $datapasien['Nik'];?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td>:</td>
					<td class="tgllahir-hitung-umur">
						<?php echo date("d-m-Y",strtotime($datapasien['TanggalLahir']));?>
					</td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>:</td>
					<td><span class="tgllahir-perkiraan-umur">
						<?php 
							if($datapasien['JenisKelamin'] == "L"){
								echo "Laki-laki";
							}else{
								echo "Perempuan";	
							}	
						?>
					</span></td>
				</tr>
				<tr>
					<td>Agama</td>
					<td>:</td>
					<td><?php echo $datapasien['Agama'];?></td>
				</tr>
				<tr>
					<td>Status Menikah</td>
					<td>:</td>
					<td><?php echo $datapasien['StatusNikah'];?></td>
				</tr>
				<tr>
					<td>Pendidikan</td>
					<td>:</td>
					<td><?php echo $datapasien['Pendidikan'];?></td>
				</tr>
				<tr>
					<td>Pekerjaan</td>
					<td>:</td>
					<td><?php echo $datapasien['Pekerjaan'];?></td>
				</tr>
				<tr>
					<td>Asuransi</td>
					<td>:</td>
					<td><?php echo $datapasien['Asuransi'];?></td>
				</tr>
				<tr>
					<td>NoAsuransi</td>
					<td>:</td>
					<td><?php echo $datapasien['NoAsuransi'];?></td>
				</tr>
				
				<tr>
					<td width="30%"><b>ALAMAT TINGGAL</b></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td>
						<?php
							echo strtoupper($datakk['Alamat']).
							" RT. ".$datakk['RT'].
							" RW. ".$datakk['RW'];
						?>
					</td>
				</tr>
				<tr>
					<td>Kelurahan / Desa</td>
					<td>:</td>
					<td><?php echo strtoupper($kelurahans);?></td>
				</tr>
				<tr>
					<td>Kecamatan</td>
					<td>:</td>
					<td><?php echo strtoupper($kecamatans);?></td>
				</tr>
				<tr>
					<td>Kabupaten / Kota</td>
					<td>:</td>
					<td><?php echo strtoupper($kotas);?></td>
				</tr>
				<tr>
					<td>Provinsi</td>
					<td>:</td>
					<td><?php echo strtoupper($provinsis);?></td>
				</tr>
				<tr>
					<td>No.Handphone</td>
					<td>:</td>
					<td>
						<?php 
							if($datapasien['Telpon'] != ''){
								echo $datapasien['Telpon'];
							}else{
								echo $datakk['Telepon'];
							}
						?>
					</td>
				</tr>
			</table>
			<p style="text-align:center"><span style="border:1px solid #000; padding: 5px;">FORM-RM-3</span></p>
		</div>
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
		
	</body>
</html>
<?php
	function umurs($tanggallahir){
		$tglla=explode("-",$tanggallahir);
		$tgl_lahir=$tglla[0];
		$bln_lahir=$tglla[1];
		$thn_lahir=$tglla[2];
		$tanggal_today = date('d');
		$bulan_today=date('m');
		$tahun_today = date('Y');

		$harilahir=GregorianToJD($bln_lahir, $tgl_lahir, $thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
		$hariini=GregorianToJD($bulan_today, $tanggal_today, $tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

		$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

		$tahun=$umur/365;//menghitung usia tahun
		$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
		$bulan=$sisa/30;//menghitung usia bulan
		$hari=$sisa%30;//menghitung sisa hari	

		$tahun_umur = floor($tahun); // floor pembulatan
		$bulan_umur = floor($bulan);
		$hari_umur = $hari;
		return $tahun_umur." Th ".$bulan_umur." Bl ".$hari_umur." Hr";
	}
?>