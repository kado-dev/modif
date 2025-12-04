<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_report.php";
	$nopemeriksaan = $_GET['id'];
	$nocm = $_GET['nocm'];
	$noindex= $_GET['noindex'];
	// echo $nocm;
?>

<style type="text/css">

body{
	font-size: 11px;
}
tr, td{
	border: 1px solid #000;
	padding: 0px 5px 0px 5px;
}
.middlecol {
	width: 100%;
}
.middlecol table {
	max-width:100% !important;
}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<body>
	<div class="middlecol">
		<center>
			<table width="100%" style="line-height: 12px;">
				<tr>
					<td rowspan="4" align="center"><img src="image/bulungan.png" width="40px"></td>
					<td rowspan="2" align="center"  width="40%" style="font-size: 14px;"><strong><?php echo "UPT PUSKESMAS ".$namapuskesmas;?></strong></td>
					<td>No.Dokumen</td>
					<td>DOK/INT/PKM-TS/005/14</td>
				</tr>
				<tr>
					<td>Revisi</td>
					<td>00</td>
				</tr>
				<tr>
					<td align="center">DAFTAR INDUK DOKUMEN INTERNAL</td>
					<td>Tgl.Dokumen</td>
					<td>11 November 2014</td>
				</tr>
				<tr>
					<td align="center">TAHUN 2015</td>
					<td>Halaman</td>
					<td>1</td>
				</tr>
			</table><br/>
			<p style="font-size:14px; font-weight:bold; margin-top: -15px;"><u>BLANGKO PEMERIKSAAN KESEHATAN</u><p>
			<table width="100%" style="margin-top: 5px; line-height: 16px;">
				<?php
					$tbpasien = 'tbpasien_'.substr($nocm,12,4);
					$strpasien = "SELECT * 
					FROM `$tbpasien`
					WHERE `NoCM`='$nocm'";
					$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, $strpasien));
										
					// tbkk
					$strkk = "SELECT `Alamat` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));
					
					// tbpoliskd
					$strpoliskd = "SELECT * FROM `tbpoliskd` WHERE `NoPemeriksaan` = '$nopemeriksaan'";
					$dtpoliskd = mysqli_fetch_assoc(mysqli_query($koneksi, $strpoliskd));
				?>
				
				<tr style="border: none">
					<td width="20%" style="border: none">Nama</td>
					<td width="2%" style="border: none">:</td>
					<td width="75%" style="border: none; font-weight: bold;"><?php echo $dtpasien['NamaPasien'];?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Tempat / Tgl.Lahir</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php echo $dtpasien['JenisKelamin'].", ".$dtpasien['TanggalLahir'];?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Pekerjaan</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php echo $dtpasien['Pekerjaan'];?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Agama</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php echo $dtpasien['Agama'];?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Alamat</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php echo $dtkk['Alamat'];?></td>
				</tr>
				<tr style="border: none">
					<td width="20%" style="border: none">Atas Permintaan</td>
					<td width="2%" style="border: none">:</td>
					<td width="75%" style="border: none">Sendiri</td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Dengan Surat</td>
					<td style="border: none">:</td>
					<td style="border: none"></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Tujuan Untuk</td>
					<td style="border: none">:</td>
					<td style="border: none">
						<?php 
							if($dtpoliskd['TujuanKir'] == '1'){
								$tujuankir = "Perpanjang Kontrak Kerja";
							}elseif($dtpoliskd['TujuanKir'] == '2'){
								$tujuankir = "Melamar Pekerjaan";
							}elseif($dtpoliskd['TujuanKir'] == '3'){
								$tujuankir = "Mengikuti Tes TNI/POLRI";
							}elseif($dtpoliskd['TujuanKir'] == '4'){
								$tujuankir = "Membuat/Perpanjang SIM";
							}elseif($dtpoliskd['TujuanKir'] == '5'){
								$tujuankir = "Keterangan Catin";
							}elseif($dtpoliskd['TujuanKir'] == '6'){
								$tujuankir = "Melanjutkan Pendidikan";
							}elseif($dtpoliskd['TujuanKir'] == '7'){
								$tujuankir = "Mengikuti Lomba";
							}elseif($dtpoliskd['TujuanKir'] == '8'){
								$tujuankir = "Surat Tanda Registrasi";
							}elseif($dtpoliskd['TujuanKir'] == '9'){
								$tujuankir = "Surat Ijin Usaha";
							}elseif($dtpoliskd['TujuanKir'] == '10'){
								$tujuankir = "Lainnya";
							}
							echo $tujuankir;
						?>
					</td>
				</tr>
			</table><br/>
			<!--<p align="left">Pemeriksaan Meliputi :</p>-->
			<table width="100%" style="line-height: 16px;">
				<tr style="text-align: center; font-weight: bold;">
					<td>Tanda Vital</td>
					<td>Organ Utama</td>
					<td>Laboratorium</td>
					<td width="10%">Pemeriksaan Lain</td>
					<td>Ket</td>
				</tr>
				<tr>
					<td valign="top">
					- TD = <?php echo $dtpoliskd['Sistole']." / ".$dtpoliskd['Diastole'];?><br/>
					- TB = <?php echo $dtpoliskd['TinggiBadan']." Cm";?><br/>
					- BB = <?php echo $dtpoliskd['BeratBadan']." Kg";?><br/>
					- Nadi = <?php echo $dtpoliskd['DetakNadi']." x/i";?><br/>
					- Suhu = <?php echo $dtpoliskd['SuhuTubuh']." x/i";?><br/>
					- Resp = <?php echo $dtpoliskd['RR']." x/i";?><br/>
					</td>
					<td valign="top">
					- Jantung = <?php echo $dtpoliskd['Jantung'];?><br/>
					- Lympa = <?php echo $dtpoliskd['Lympa'];?><br/>
					- Hati = <?php echo $dtpoliskd['Hati'];?><br/>
					- Paru = <?php echo $dtpoliskd['Paru'];?><br/>
					- Sara = <?php echo $dtpoliskd['Saraf'];?><br/>
					- Kejiwaan = <?php echo $dtpoliskd['Kejiwaan'];?><br/>
					- Visus Mata = <?php echo $dtpoliskd['VisusMata'];?><br/>
					<td valign="top"><?php echo $dtpoliskd['PemeriksaanLab'];?></td>
					<td valign="top"><?php echo $dtpoliskd['PemeriksaanLainnya'];?></td>
					<td valign="top"></td>
				</tr>
			</table>
			<p align="left"> Meninyimpulkan bahwa pasien tersebut kami nyatakan :</p><br/>
			<table width="100%" style="text-align: center; margin-top: -30px;">
				<tr style="border: none">
					<td width="30%" style="border: none"></td>
					<td width="30%" style="border: none"></td>
					<td width="40%" style="border: none">
					<?php 
						if($kota = "KABUPATEN BULUNGAN"){
							echo "Tanjung Selor, ".date('d-m-Y', strtotime($dtpoliskd['TanggalPeriksa']));					
						}elseif(($kota = "KABUPATEN BANDUNG")){
							echo "Soreang, ".date('d-m-Y', strtotime($dtpoliskd['TanggalPeriksa']));	
						}elseif(($kota = "KOTA BANDUNG")){
							echo "Bandung, ".date('d-m-Y', strtotime($dtpoliskd['TanggalPeriksa']));	
						}
					?>
					</td>
				</tr>
				<tr style="border: none">
					<td style="border: none"></td>
					<td style="border: none"></td>
					<td style="border: none">Dokter Penguji</td>
				</tr>
				<tr style="border: none">
					<td style="border: none"></td>
					<td style="border: none"></td>
					<td style="border: none">
						<p style="padding-top:60px;"><?php echo "(__________________________)";?></p>
					</td>
				</tr>
			</table>
		</center>
	</div><br/>
	<a href="javascript:print()" class="btn btn-lg btn-success noprint"style="position: absolute; right: 0px; margin-top: -20px;">Print</a><br/><br/>
<body>