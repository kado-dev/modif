<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	error_reporting(1);
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$idpasien = $_GET['id'];
	$idrj = $_GET['idrj'];
	$nocm = $_GET['cm'];
	
	// tbpasien
	// echo "SELECT * FROM `$tbpasien` WHERE (`IdPasien`='$idpasien' OR `NoCM`='$nocm')";
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE (`IdPasien`='$idpasien' OR `NoCM`='$nocm')"));
	
	// tbkk
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex`='$datapasien[NoIndex]'"));
	
	// tbpasienrj
	$datarj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idrj'"));

	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;

	$daftarppergawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$datarj[NoRegistrasi]'"));
	// $md5pin = md5($daftarppergawai['TtePin']);
	// $dtpegawaiTtd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NamaPegawai, Sip FROM tbpegawai WHERE `TtePin`='$md5pin'"));
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

	<?php
		// cek anamnesa
		$namapkm = str_replace(' ','',strtoupper($namapuskesmas));
		if ($datarj['PoliPertama'] == "POLI GIGI" OR $datarj['PoliPertama'] == "POLI KIA" OR $datarj['PoliPertama'] == "POLI LANSIA" OR $datarj['PoliPertama'] == "POLI MTBS" OR $datarj['PoliPertama'] == "POLI UMUM"){
			$pelayanan = "tb".str_replace(' ','',strtolower($datarj['PoliPertama']))."_$namapkm";	
		}else{
			$pelayanan = "tb".str_replace(' ','',strtolower($datarj['PoliPertama']));
		}

		$stranamnesa = "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan`='$datarj[NoRegistrasi]'";
		$queryanamnesa = mysqli_query($koneksi, $stranamnesa);
		$dtanamnesa = mysqli_fetch_assoc($queryanamnesa);

		// tbdiagnosa
		$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
		$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$datarj[IdPasienrj]' GROUP BY `KodeDiagnosa`");
		while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
			$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
			$array_diagnosa[$no][] = $data_diagnosa['Diagnosa'];
			$array_kode_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa'];
		}

		// therapy
		$tbapotikstok = 'tbapotikstok_'.str_replace(' ', '', $namapuskesmas);
		$qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$datarj[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
		while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
			$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
			$array_obat[$no][] = $data_obat['NamaBarang'];
		}
	?>
	
	<script src="assets/js/qrcode.min.js?4"></script>
	<body onload="window.print()" onafterprint="document.location = 'index.php?page=rekam_medis_klpcm'">
		<div class="container">
			<table border="1" cellpadding="5px" style="margin-top:5px; font-size:16px;">
				<tr>
					<td width="50%">
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
					<td>
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
					<td colspan = "2" align="center" style="font-size: 24px; font-weight: bold">KAJIAN AWAL RAWAT JALAN</td>
				</tr>	
				<tr>
					<td>
						<table class="" cellpadding="6px" style="font-size: 16px" >
							<tr>
								<td width="30%">TGL.REG / JAM</td>
								<td widht="5%">:</td>
								<td><?php echo $datarj['TanggalRegistrasi'];?></td>
							</tr>
							<tr>
								<td>Pelayanan</td>
								<td>:</td>
								<td><?php echo $datarj['PoliPertama'];?></td>
							</tr>
							<tr>
								<td>Kebiasaan</td>
								<td>:</td>
								<td></td>
							</tr>
							<tr>
								<td>Disabilitas</td>
								<td>:</td>
								<td></td>
							</tr>
						</table>
					</td>
					<td>
						<table width="100%" cellpadding="8px" style="font-size: 16px;height:80px">
							<tr>
								<td colspan="3">Riwayat Alergi :</td>
							</tr>
							<tr>
								<td width="20%">Obat</td>
								<td width="5%">:</td>
								<td><?php echo $dtanamnesa['RiwayatAlergiObat'];?></td>
							</tr>
							<tr>
								<td>Makanan</td>
								<td>:</td>
								<td><?php echo $dtanamnesa['RiwayatAlergiMakanan'];?></td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<table style="font-size:16px" width="100%" cellpadding="5px">
							<tr><td align="left" colspan="3" style="font-size: 16px; font-weight: bold">I. ANAMNESIS (SUBJECTIVE)</td></tr>
							<tr>
								<td width="85%" colspan="3">1. Keluhan Utama</td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" class="kotakpanjang" value="<?php echo $dtanamnesa['Anamnesa'];?>"></td>
							</tr>
							<tr>
								<td colspan="3">2.	Riwayat Penyakit Sekarang (Termasuk kajian Biologis, Psikologis, Sosial, Spiritual)</td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" class="kotakpanjang" value="<?php echo $dtanamnesa['RiwayatPenyakitSekarang'];?>"></td>
							</tr>
							<tr>
								<td colspan="3">3.	Riwayat Penyakit Dahulu / Rawat Inap Rumah Sakit  </td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" class="kotakpanjang" value="<?php echo $dtanamnesa['RiwayatPenyakitDulu'];?>"></td>
							</tr>
							<tr>
								<td colspan="3">4.	Riwayat Penyakit Keluarga </td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" class="kotakpanjang" value="<?php echo $dtanamnesa['RiwayatPenyakitKeluarga'];?>"></td>
							</tr>
							<tr>
								<td colspan="3">5.	Faktor Resiko Lain </td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" class="kotakpanjang" value="<?php echo $dtanamnesa['FaktorResikoLainnya'];?>"></td>
							</tr>
							<tr><td colspan = "3" align="left" style="font-size: 16px; font-weight: bold">II. PEMERIKSAAN FISIK (OBJECTIVE)</td></tr>	
							<tr>
								<td width="17%">Keadan Umum</td>
								<td width="3%">:</td>
								<td><?php echo $dtanamnesa['KeadaanUmum'];?></td>
							</tr>
							<tr>
								<td>Kesadaran</td>
								<td>:</td>
								<td>
									<?php 
										if($dtanamnesa['Kesadaran'] == '01'){
											echo "Compos Mentis";
										}else{
											echo "-";
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Tanda Vital</td>
								<td>:</td>
								<td>
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

										echo "Sistole : ".$dtsistole." Diastole : ".$dtdiastole." BB : ".$dtberatBadan." TB : ".$dttinggiBadan." HR : ".$dtheartRate." RR : ".$dtrespRate." Suhu Tubuh : ".$dtsuhutubuh;
									?>
									 
								</td>
							</tr>
							<tr>
								<td>Status Gizi</td>
								<td>:</td>
								<td><?php echo $dtanamnesa['StatusGizi'];?></td>
							</tr>
							<tr>
								<td>Kepala</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;a. Mata</td>
								<td>:</td>
								<td><?php echo $dtanamnesa['Mata'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;b. Mulut</td>
								<td>:</td>
								<td><?php echo $dtanamnesa['Mulut'];?></td>
							</tr>
							<tr>
								<td>Leher Thorax</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;a. Cor</td>
								<td>:</td>
								<td><?php echo $dtanamnesa['CP'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;b. Pulmo</td>
								<td>:</td>
								<td></td>
							</tr>
							<tr>
								<td>Abdomen</td>
								<td>:</td>
								<td></td>
							</tr>
							<tr>
								<td>Extremitas</td>
								<td>:</td>
								<td><?php echo $dtanamnesa['ExAtas'].", ".$dtanamnesa['ExBawah'];?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						Pemeriksaan Penunjang (Objective)<br/>
						<b><?php echo strtoupper($dtanamnesa['PemeriksaanPenunjang']);?></b>
					</td>
					<td>
						Diagnosis<br/>
						<b>
							<?php
								if ($array_kode_diagnosa[$no] != ''){
									$data_dgs = implode(", ", $array_kode_diagnosa[$no]);
									echo $data_dgs;
								}
							?>
						<b>
					</td>
				</tr>
				<tr>
					<td>
						Rencana Pengelolaan (Planning)<br/>
						<b><?php echo strtoupper($dtanamnesa['RencanaPengelolaan']);?></b>
					</td>
					<td>
						Prognosis<br/>
						<b><?php echo strtoupper($dtanamnesa['Prognosis']);?></b>
					</td>
				</tr>
				<tr>
					<td>
						Terapi (Execution)<br/>
						<b>
							<?php
								if ($array_obat[$no] != ''){
									$data_obt = implode(", ", $array_obat[$no]);
									echo $data_obt;
								}
							?>
						<b>
					</td>
					<td>
						Informasi ESO<br/>
						<b><?php echo strtoupper($dtanamnesa['InformasiEso']);?></b>
					</td>
				</tr>
				<tr>
					<td>
						Edukasi<br/>
						<b><?php echo strtoupper($dtanamnesa['Edukasi']);?></b>
					</td>
					<td>
						Tanda tangan dan Nama Jelas Dokter
						<br/>
						<div id="qrcode" style="padding:6px 0px; width: 80px;"></div>
						<p><?php echo $daftarppergawai['NamaPegawai1'];?></p>
					</td>
				</tr>
			</table>
			<p style="text-align:center; margin-top: 50px;"><span style="border:1px solid #000; padding: 5px;">FORM-RM-4</span></p>
		</div>
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src='https://code.responsivevoice.org/responsivevoice.js'></script>		
	</body>
	
	<script>
		var qrcode = new QRCode(document.getElementById("qrcode"), {
			width : 80,
			height : 80
		});
		var elText = <?php echo $daftarppergawai['TtePin'];?>;
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