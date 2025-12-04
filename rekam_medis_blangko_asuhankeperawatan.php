<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	error_reporting(0);
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$idpasien = $_GET['id'];
	$idrj = $_GET['idrj'];
	
	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien`='$idpasien'"));
	
	// tbkk
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `datapasien`='$datapasien[NoIndex]'"));
	
	// tbpasienrj
	$datarj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idrj'"));
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
				margin:0px;
				padding:0px;
			}
			.judul{
				font-size : 16px;
				font-family: 'Barlow', sans-serif;
				line-height : 10px; 
			}		
			
			.logopuskesmas{
				filter: grayscale(100%);
				width:70px;
			}
			.logokabupaten{
				filter: grayscale(100%);
				width:90px;
			}
			
			.kotakpanjang{
				width:98%;
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
	
	<body onload="window.print()" onafterprint="document.location = 'index.php?page=rekam_medis_klpcm'">
		<div class="container">
			<table border="1" cellpadding="5px" style="margin-top:5px;font-size:14px">
				<tr>
					<td colspan='3'>
						<table width="100%">
							<tr>
								<td width="25%" style="padding-left:20px">
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
								<td width="80%">
									<h2 style="font-size:20px; line-height:5px; font-weight: bold; text-align: center;">DINAS KESEHATAN <?php echo $kota;?></h2>
									<h2 style="font-size:20px; line-height:5px;font-weight: bold; text-align: center;">UPT PUSKESMAS <?php echo $namapuskesmas;?></h2>
									<h4 style="font-size:16px; line-height:20px; font-weight: normal; text-align: center;"><?php echo str_replace("KEC.","<br/>KEC.",$alamat);?></h4>
								</td>
							</tr>
						</table>
					</td>
					<td colspan='2'>
						<table width="100%" cellpadding="6px">
							<tr>
								<td width="30%">No.RM</td>
								<td width="5%">:</td>
								<td><?php echo substr($datapasien['NoRM'],-10);?></td>
							</tr>
							<tr>
								<td width="30%">Nama Pasien</td>
								<td width="5%">:</td>
								<td><b><?php echo $datapasien['NamaPasien'];?></b></td>
							</tr>
							<tr>
								<td width="30%">Tanggal Lahir</td>
								<td width="5%">:</td>
								<td><?php echo date('d-m-Y', strtotime($datapasien['TanggalLahir']));?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan = "5" align="center" style="font-size: 24px; font-weight: bold">
						ASUHAN KEPERAWATAN INDIVIDU<br/>PELAYANAN RAWAT JALAN DAN GAWAT DARURAT
					</td>
				</tr>
				<tr style="text-align:center;font-weight:bold">
					<td  width="10%">TGL.REG / JAM</td>
					<td  width="30%">DIAGNOSIS KEPERAWATAN & DATA PENUNJANG</td>
					<td  width="20%">RENCANA INTERVENSI & IMPLEMENTASI</td>
					<td width="20%">EVALUASI</td>
					<td width="20%">NAMA JELAS & TANDA TANGAN</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<table style="font-size:12px" width="100%" cellpadding="5px">
							<tr>
								<td width="85%" colspan="3">Keluhan Utama</td>
							</tr>
							<tr>
								<td><input type="text" class="kotakpanjang"></td>
							</tr>
							<tr>
								<td width="85%" colspan="3">Data Subjective</td>
							</tr>
							<tr>
								<td><input type="text" class="kotakpanjang"></td>
							</tr>
							<tr>
								<td width="85%" colspan="3">Data Objective</td>
							</tr>
							<tr>
								<td><input type="text" class="kotakpanjang"></td>
							</tr>
							<tr>
								<td width="85%" colspan="3">Data Penunjang</td>
							</tr>
							<tr>
								<td><input type="text" class="kotakpanjang"></td>
							</tr>
						</table>
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>

			
			<p style="text-align:center; margin-top: 50px;"><span style="border:1px solid #000; padding: 5px;">FORM-RM-6</span></p>
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