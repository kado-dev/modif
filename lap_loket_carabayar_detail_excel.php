<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$asuransi = $_GET['asuransi'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan CaraBayar Detail (".$hariini.").xls");
	//if(isset($bulan) and isset($tahun)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}

.str{
	mso-number-format:\@; 
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

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR (<?php echo strtoupper($asuransi);?>)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">KODE PUSKESMAS</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">PUSKESMAS</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">No.</th>
					<th width="7%">Tanggal</th>
					<th width="10%">Nik</th>
					<th width="15%">Nama Pasien</th>
					<th width="3%">L/P</th>
					<th width="7%">Tgl.Lahir</th>
					<th width="5%">Umur (Th)</th>
					<th width="15%">Alamat</th>
					<th width="5%">Pelayanan</th>
					<th width="10%">Cara Bayar</th>
					<th width="5%">Kunj.</th>
					<th width="10%">Diagnosa</th>
					<th width="15%">Therapy</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($asuransi == 'semua'){
					$asr = "";
				}elseif($asuransi == 'semuabpjs'){
					$asr = " AND `Asuransi` like '%BPJS%'";
				}else{
					$asr = " AND `Asuransi`='$asuransi'";
				}
				
				$waktu = " date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2'";
				$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu.$asr;
				$str2 = $str." GROUP BY NoRegistrasi ORDER BY `TanggalRegistrasi`ASC";
				// echo $str2;
								
				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$noindex = $data['NoIndex'];
				$idpasien = $data['IdPasien'];
				$idpasienrj = $data['IdPasienrj'];
				$nocm = $data['NoCM'];
				$nik = $data['Nik'];
										
				// tbkk
				$strkk = "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE NoIndex = '$noindex'";
				$querykk = mysqli_query($koneksi,$strkk);
				$datakk = mysqli_fetch_assoc($querykk);

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

				if($datakk['Alamat'] != ''){
					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota);
				}else{
					$alamat = "Tidak ditemukan";
				}

				// tbpasien
				$strps = "SELECT `TanggalLahir`,`NoAsuransi` FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'";
				$queryps = mysqli_query($koneksi, $strps);
				$dataps = mysqli_fetch_assoc($queryps);
				$nokartu = $dataps['NoAsuransi'];

				if($data['Asuransi'] == 'PKG PEMDA'){
					$nokartu = '0';
				}else{
					$nokartu = $nokartu;
				}

					// diagnosa
				$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj`='$idpasienrj'";
				$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
				while($dt_diagnosa = mysqli_fetch_array($query_diagnosa)){
					$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodeDiagnosa`,`Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$dt_diagnosa[KodeDiagnosa]'"));
					$array_diagnosa[$no][] = $dtdiagnosa['KodeDiagnosa']." - ".$dtdiagnosa['Diagnosa'];
				}
				if ($array_diagnosa[$no] != ''){
					$diagnosaps = implode("<br/>", $array_diagnosa[$no]);
				}else{
					$diagnosaps = "-";
				}

				// therapy
				$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj'";
				$query_therapy = mysqli_query($koneksi, $str_therapy);
				while($dt_therapy = mysqli_fetch_array($query_therapy)){
					$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
					$array_therapy[$no][] = $dtobat['NamaBarang'].", JML:".$dt_therapy['jumlahobat'].", (".$dt_therapy['AnjuranResep'].")";
				}
				if ($array_therapy[$no] != ''){
					$terapi = implode("<br/>", $array_therapy[$no]);
				}else{
					$terapi = "-";
				}
				
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right;"><?php echo $no;?></td>
						<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>
						<td style="text-align:center;" class="str"><?php echo $nik;?></td>
						<td style="text-align:left;">
							<?php 
								echo strtoupper($data['NamaPasien'])."<br/>".
								substr($noindex,-10);
							?>
						</td>
						<td style="text-align:center;"><?php echo $data['JenisKelamin'];?></td>
						<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($dataps['TanggalLahir']));?></td>
						<td style="text-align:center;"><?php echo $data['UmurTahun'];?></td>
						<td style="text-align:left;"><?php echo strtoupper($alamat);?></td>
						<td style="text-align:center;"><?php echo $data['PoliPertama'];?></td>
						<td style="text-align:center;">
							<?php 
								echo $data['Asuransi']."<br/>".
								$nokartu;
							?>
						</td>
						<td style="text-align:center;"><?php echo strtoupper($data['StatusKunjungan']);?></td>
						<td style="text-align:left;"><?php echo $diagnosaps;?></td>		
						<td style="text-align:left;"><?php echo $terapi;?></td>		
					</tr>
				<?php
				}
				?>
					
			</tbody>
		</table>
	</div>
</div>
<?php
//}
?>