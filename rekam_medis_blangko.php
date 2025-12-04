<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$noreg = $_GET['noreg'];
	$nocm = $_GET['nocm'];
	$noindex = $_GET['noidx'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);

	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM`='$nocm'"));
	
	// tbkk
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex`='$noindex'"));

	// ec_subdistricts
	$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
	if($dt_subdis['subdis_name'] != ''){
		$kelurahan = $dt_subdis['subdis_name'];
	}else{
		$kelurahan = $datakk['Kelurahan'];
	}

	// ec_districts
	$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
	if($dt_dis['dis_name'] != ''){
		$kecamatan = $dt_dis['dis_name'];
	}else{
		$kecamatan = $datakk['Kecamatan'];
	}

	// ec_cities
	$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
	if($dt_citi['city_name'] != ''){
		$kota = $dt_citi['city_name'];
	}else{
		$kota = $datakk['Kota'];
	}

	$alamat_pasien = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
	strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota);
	
	// tbpasienrj
	$datarj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `Noregistrasi`='$noreg'"));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rekam Medis Print</title>
		<link href="https://fonts.googleapis.com/css?family=Barlow|Big+Shoulders+Text|Muli|Saira+Condensed&display=swap" rel="stylesheet">
		<style>	
			body{
				background: #f5f5f5;
				font-family: 'Barlow', sans-serif;
				font-size : 14px;
			}
			.container{
				width:1250px;
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
				position:relative;
				top:0px;
				right:-950px;
				width:90px;
			}
			.logokabbandung{
				position:relative;
				top:-10px;
				left:125px;
				width:94px;
			}
			.logokabkukar{
				position:relative;
				top:0px;
				left:150px;
				width:65px;
			}

			@media print{
				.btn{
					display:none;
				}
				.logopuskesmas{
					right:-1000px;
				}
				.logokabbandung{
					left:55px;
				}
				.logokabkukar{
					left:80px;
				}
			}
		</style>	
	</head>
	<body onload="window.print()" onafterprint="document.location = 'index.php?page=registrasi_data'">
		<div class="container">
			<table border="1">
				<tr class="judul">
					<td colspan="2">
						<?php if ($kota == 'KABUPATEN BANDUNG'){ ?>
						<img src="image/bandungkab.png" class="logokabbandung">
					<?php }elseif($kota == 'KABUPATEN KUTAI KARTANEGARA'){ ?>
						<img src="image/kukarkab.png" class="logokabkukar">
					<?php
						}
					?>
					<img src="image/logo_puskesmas.png" class="logopuskesmas">
						<h2 align="center" style="margin-top: -60px">DINAS KESEHATAN <?php echo $kota;?></h2>
						<h2 align="center">UPT PUSKESMAS <?php echo $namapuskesmas;?></h2>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<table class="table" width="100%" style="margin-left: 20px;" cellpadding="2px">
							<tr>
								<td colspan = "3" align="center" style="font-size: 24px; font-weight: bold;">
									<?php 
										if($kota == 'KABUPATEN BULUNGAN' OR $kota == 'KABUPATEN KUTAI KARTANEGARA'){
											echo substr($datarj['NoRM'],11,2)." - ".substr($datarj['NoRM'],-6); 
										}else{
											echo substr($datarj['NoIndex'],-10); 
										}										
									?>
								</td>
							</tr>
							<tr>
								<td width="30%">NIK</td>
								<td>:</td>
								<td width="70%"><?php echo $datapasien['Nik'];?></td>
							</tr>
							<tr>
								<td>Nama KK</td>
								<td>:</td>
								<td><?php echo strtoupper($datakk['NamaKK']);?></td>
							</tr>
							<tr>
								<td>Nama Pasien</td>
								<td>:</td>
								<td><?php echo strtoupper($datapasien['NamaPasien']);?></td>
							</tr>
							<tr>
								<td>Tanggal Lahir</td>
								<td>:</td>
								<td class="tgllahir-hitung-umur">
									<?php echo date("d-m-Y",strtotime($datapasien['TanggalLahir']));?>
								</td>
							</tr>
							<tr>
								<td>Pekerjaan - Pendidikan</td>
								<td>:</td>
								<td><?php echo $datapasien['Pekerjaan']." - ".$datapasien['Pendidikan'];?></td>
							</tr>
							<tr>
								<td>Alamat - Telp.</td>
								<td>:</td>
								<td>
									<?php
										echo strtoupper($alamat_pasien).", TELP.".$datakk['Telepon'];
									?>
								</td>
							</tr>
							<tr>
								<td>Umur</td>
								<td>:</td>
								<td><span class="tgllahir-perkiraan-umur">
									<?php echo umurs(date("d-m-Y",strtotime($datapasien['TanggalLahir'])));?>
								</span></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td><span class="tgllahir-perkiraan-umur">
									<?php 
										if($datarj['JenisKelamin'] == "L"){
											echo "Laki-laki";
										}else{
											echo "Perempuan";	
										}	
									?>
								</span></td>
							</tr>
						</table>
					</td>
					<td valign="top" style="padding-left:20px; padding-top: 0px; padding-right: 20px">
						<table cellpadding="2px">
							<tr>
								<td colspan = "2" align="center" style="font-size: 24px; font-weight: bold;"><?php echo $datarj['Asuransi'];?></td>
							</tr>
							<tr>
								<td width="40%">Nomor Jaminan</td>
								<td width="60%"><?php echo $datarj['nokartu'];?></td>
							</tr>
							<tr>
								<td>Ruang Pemeriksaan</td>
								<td><?php echo $datarj['PoliPertama'];?></td>
							</tr>
							<tr>
								<td>Catatan :</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"><hr/></td>
							</tr>
							<tr>
								<td colspan="2"><hr/></td>
							</tr>
							<tr>
								<td colspan="2"><hr/></td>
							</tr>
							<tr>
								<td colspan="2"><hr/></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table border="1" style="font-size : 12px;">
				<tr>
					<td colspan="6" align="center"><p style="font-size:14px; font-weight: bold";>Hari : <?php echo hari_ini().", Tanggal: ".date('d-m-Y', strtotime($datarj['TanggalRegistrasi']))?> &nbsp &nbsp &nbsp &nbsp &nbsp REKAM MEDIS DOKTER</p></td>
					<td colspan="3" align="center"><p style="font-size:14px; font-weight: bold";>ASUHAN KEPERAWATAN / KEBIDANAN</p></td>
				</tr>
				<tr>
					<th width="12%">SUBYEKTIF</th>
					<th colspan="2">OBYEKTIF<br/>(VITAL SIGN, PEM.FISIK, LAB, PENUNJANG)</th>
					<th width="8%">ASSESTMENT<br/>(DIAGNOSA, DD)</th>
					<th width="15%">PLAN<br/>(TERAPI,TINDAKAN,<br/>EDUKASI,KONTROL,RUJUKAN)</th>
					<th width="3%">PARAF DOKTER</th>
					<th width="10%">DIAGNOSA KEPERAWATAN / KEBIDANAN</th>
					<th width="12%">RENCANA KEPERAWATAN / KEBIDANAN</th>
					<th width="5%">PARAF PERAWAT / BIDAN</th>
				</tr>
				<tr>
					<td valign="top">
						<p style="padding-left: 10px;">
							Keluhan Utama : <br/><br/><br/><br/><br/><br/><br/>
							Riwayat Penyakit : <br/><br/><br/><br/><br/><br/><br/>
							Apakah merokok +/-<br/>
							Riwayat alergi obat +/-<br/>
							Riwayat ASMA +/-<br/><br/>
							Makan sayur & buah +/-<br/><br/>
							Minum alkohol +/-<br/>
							Aktifitas fisik +/-<br/>
							(Olah raga / dll)<br/><br/>
							S :<br/><br/><br/><br/>
						</p>
					</td>
					<td width="12%" valign="top" style="padding-left: 10px; padding-top: 0px; padding-right: 10px">
						<table>
							<tr>
								<td>
									<p style="line-height: 16px;">
										TD :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp MM/HG<br/>
										Nadi :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp X/Menit<br/>
										Reg/Irreg/Lemah/Dbn :&nbsp &nbsp &nbsp &nbsp &nbsp <br/>
										TB/BB :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Cm/Kg<br/>
										T :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp C<br/>
										RR :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp X/Menit<br/>
										SO2 :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp %<br/>
										LP :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Cm<br/>
										GDS :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Mg/dl<br/>
										GDP :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Mg/dl<br/>
										Kel.Total :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Mg/dl<br/>
										Asam Urat :&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Mg/dl<br/>
										Trigliserida :&nbsp &nbsp &nbsp Mg/dl<br/>
										HB :         <br/>
										BTA :         <br/>
										Urin :         <br/><br/>
										Penunjang Lainnya :         <br/><br/>
										EKG :         <br/><br/>
										ABI :         <br/>
									</p>
								</td>
							</tr>
						</table>
					</td>
					<td width="20%" valign="top" style="padding-left: 10px; padding-top: 0px; padding-right: 10px;">
						<table cellpadding="3px">
							<tr>
								<td>
									<p style="line-height: 17px;">
									KU : CM/Apratis/Somnolen/Stupor/Koma<br/>
									KEPALA : Normosefal/Mesosefal<br/>
									MATA : Konj.Dbn/Anemi<br/>Sklera Putih/Ikterik/Merah/Lensa Keruh<br/>
									TELINGA : Dbn/Cairan/Darah/Serumen<br/>
									MT : Intak/Perforasi<br/>
									HIDUNG : Dbn/Dev.Sept/Darah/Lendir<br/>
									BIBIR : Dbn/Pucat/Sariawan<br/>
									MULUT : Lidah Kotor/Fissura/Dbn<br/>
									FARING : Dbn/Hipermis/Membran Abu2/<br/>T..../T...., Leher : Dev.Trachea -/+ Tiroid -/+<br/>
									KGB -/+ &nbsp &nbsp &nbsp &nbsp &nbsp Retraksi -/+<br/>
									PARU : Vesikuler/Ronchi/Wheezing<br/>
									JANTUNG : SJ Murni/Murmur/Galloop<br/>
									ADOMEN : Dbn/NT ulu hati (-)/(+), massa/<br/>
									Venektasi/def.Muse/Hipertimpani/BU +/-<br/>
									EKSTREMITAS : Sup/Inf:Dbn/Edema/Akral <br/> 
									Dingin/Ulkus/Gangren/Gggn Kulit<br/>
									STATUS LOKALIS/PEM.FISIK LAINNYA :
									</p>
								</td>
							</tr>
						</table>
					</td>
					<td></td><!--diagnosa-->
					<td></td><!--terapi-->
					<td></td><!--paraf dokter-->
					<td></td><!--diagnosa perawat-->
					<td></td><!--rencana keperawatan-->
					<td></td><!--paraf perawat / bidan-->
				</tr>	
			</table>
		</div>
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
		<script type="text/javascript">
			window.print();
		</script>
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