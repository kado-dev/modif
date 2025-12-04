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

	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;

	$datarppergawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$datarj[NoRegistrasi]'"));
	$dtpegawaiTtd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NamaPegawai, Sip FROM tbpegawai WHERE `NamaPegawai`='$datarppergawai[NamaPegawai1]'"));
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
				width:110px;
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
	
	<script src="assets/js/qrcode.min.js?4"></script>
	<body onload="window.print()" onafterprint="document.location = 'index.php?page=rekam_medis_klpcm'">
		<div class="container">
			<table border="1" cellpadding="5px" style="margin-top:5px; font-size:16px;">
				<tr>
					<td width="50%" colspan="4">
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
					<td colspan="3">
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
				<tr><td colspan = "7" align="center" style="font-size: 24px; font-weight: bold">KAJIAN ULANG RAWAT JALAN</td></tr>
				<tr style="text-align:center;font-weight:bold">
					<td width="10%">TGL.REG / JAM</td>
					<td width="15%">S<br>(SUBJECTIVE)</td>
					<td width="15%">O<br>(OBJECTIVE)</td>
					<td width="15%">A<br>(ASSEMENT)</td>
					<td width="15%">P<br>(PLANNING)</td>
					<td width="15%">E<br>(EXECUTION)</td>
					<td width="10%">TTD & NAMA PEMERIKSA</td>
				</tr>
				<?php
					$str = "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idrj' ORDER BY `TanggalRegistrasi`";
					$query = mysqli_query($koneksi, $str);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noindex = $data['NoIndex'];

						// cek anamnesa
						$namapkm = str_replace(' ','',strtoupper($namapuskesmas));
						if ($datarj['PoliPertama'] == "POLI UMUM"){
							$pelayanan = "tb".str_replace(' ','',strtolower($datarj['PoliPertama']))."_$namapkm";	
						}else{
							$pelayanan = "tb".str_replace(' ','',strtolower($datarj['PoliPertama']));
						}

						$stranamnesa = "SELECT * FROM $pelayanan WHERE `NoPemeriksaan`='$data[NoRegistrasi]'";
						$queryanamnesa = mysqli_query($koneksi, $stranamnesa);
						$dtanamnesa = mysqli_fetch_assoc($queryanamnesa);
				?>
				<tr>
					<td align="center"><?php echo $data['TanggalRegistrasi'];?></td>
					<td>
						<b>KELUHAN UTAMA : </b><br/>
						<?php echo $dtanamnesa['Anamnesa'];?>
					</td>
					<td>
						<b>KEADAAN UMUM : </b><br/>
						<?php echo $dtanamnesa['KeadaanUmum'];?><br/><br/>
						<b>KESADARAN : </b><br/>
						<?php 
							if($dtanamnesa['Kesadaran'] == '01'){
								echo "Compos Mentis";
							}else{
								echo "-";
							}
						?><br/><br/>
						<b>TANDA VITAL : </b><br/>
						<?php 
							// vital sign
							$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idrj'";
							$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							$dtsistole = $dtvs['Sistole'];
							$dtdiastole = $dtvs['Diastole'];
							$dtsuhutubuh = $dtvs['SuhuTubuh'];
							$dttinggiBadan = $dtvs['TinggiBadan'];
							$dtberatBadan = $dtvs['BeratBadan'];
							$dtheartRate = $dtvs['HeartRate'];
							$dtrespRate = $dtvs['RespiratoryRate'];
							$dtLingkarPerut = $dtvs['LingkarPerut'];
							$imt = $dtvs['IMT'];
							echo "Sistole : ".$dtsistole."<br/> Diastole : ".$dtdiastole."<br/> BB : ".$dtberatBadan."<br/> TB : ".$dttinggiBadan."<br/> HR : ".$dtheartRate."<br/> RR : ".$dtrespRate."<br/> Suhu Tubuh : ".$dtsuhutubuh;
						?><br/><br/>
						<b>STATUS GIZI : </b><br/>
						<?php echo $dtanamnesa['StatusGizi'];?><br/><br/>
						<b>PEMERIKSAAN FISIK : </b><br/>
						<?php echo "KEPALA : ".$dtanamnesa['Kepala'];?><br/>
						<?php echo "MATA : ".$dtanamnesa['Mata'];?><br/>
						<?php echo "MULUT : ".$dtanamnesa['Mulut'];?><br/>
						<?php echo "LEHER : ".$dtanamnesa['Leher'];?><br/>
						<?php echo "COR PULMO : ".$dtanamnesa['CP'];?>
					</td>
					<td>
						<?php
							// tbdiagnosa
							$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$datarj[IdPasienrj]' GROUP BY `KodeDiagnosa`");
							while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
								$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
								$array_diagnosa[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> - ".$data_diagnosa['Diagnosa'];
							}

							if ($array_diagnosa[$no] != ''){
								$data_dgs = implode("<br/> ", $array_diagnosa[$no]);
								echo $data_dgs;
							}
						?>
					</td>
					<td>
						<?php
							// therapy
							$tbapotikstok = 'tbapotikstok_'.str_replace(' ', '', $namapuskesmas);
							$qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$datarj[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
							while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
								$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
								$array_obat[$no][] = $data_obat['NamaBarang'];
							}

							if ($array_obat[$no] != ''){
								$data_dgs = implode("<br/> ", $array_obat[$no]);
								echo $data_dgs;
							}
						?>
					</td>
					<td>
						-
					</td>
					<td>
						<?php
							if ($datarppergawai['TtePin'] != ""){
						?>
						<div id="qrcode" style="padding:6px 0px; width: 80px;"></div>
						<p><?php echo $dtpegawaiTtd['NamaPegawai'];?></p>
						<?php }	?>
					</td>
				</tr>
				<?php 
					}
				?>
			</table>
			<p style="text-align:center; margin-top: 50px;"><span style="border:1px solid #000; padding: 5px;">FORM-RM-5</span></p>
		</div>
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src='https://code.responsivevoice.org/responsivevoice.js'></script>	
	</body>

	<script>
		var qrcode = new QRCode(document.getElementById("qrcode"), {
			width : 80,
			height : 80
		});
		var elText = <?php echo $datarppergawai['TtePin'];?>;
		qrcode.makeCode(elText);
	</script>
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