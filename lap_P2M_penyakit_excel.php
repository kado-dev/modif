<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Tracking Diagnosa (".$keydate1.'-'.$keydate2.").xls");
	if(isset($keydate1) and isset($keydate2)){
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
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING DIAGNOSA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2"width="3%">NO.</th>
					<th rowspan="2" width="7%">TGL.PERIKSA</th>
					<th rowspan="2" width="10%">NAMA PASIEN</th>
					<th rowspan="2" width="5%">TGL.LAHIR</th>
					<th colspan="2" width="5%">UMUR</th>
					<th rowspan="2" width="10%">ALAMAT</th>
					<th rowspan="2" width="5%">KUNJ</th>
					<th rowspan="2" width="10%">JAMINAN</th>
					<th rowspan="2" width="5%">LAYANAN</th>
					<th rowspan="2" width="15%">ANAMNESA</th>
					<th colspan="4" width="10%">VITAL SIGN</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="5%">KASUS</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TD</th>
					<th>BB/TB</th>
					<th>SUHU</th>
					<th>HR/RR</th>
				</tr>
			</thead>
			<tbody>
				<?php				
				// tbdiagnosapasien
				if($_GET['kasus'] == 'semua'){
					$kasus = "";
				}else{
					$kasus = "AND `Kasus` = '$_GET[kasus]'";
				}
				
				$waktu = "TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2'";
				$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." AND `KodeDiagnosa` LIKE '%$kodediagnosa%' ".$kasus;
				$str2 = $str_diagnosa." ORDER BY TanggalDiagnosa";
				// echo $str2;	
				
				$query_diagnosa = mysqli_query($koneksi,$str2);
				while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
					$no = $no + 1;
					$idpasienrj = $data_diagnosa['IdPasienrj'];
					$noregistrasi = $data_diagnosa['NoRegistrasi'];
					$kodediagnosa = $data_diagnosa['KodeDiagnosa'];
					$kasus = $data_diagnosa['Kasus'];

					$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
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
				
					// tbpasienrj 
					$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$noindex = $data_rj['NoIndex'];
					$kelamin = $data_rj['JenisKelamin'];
					$poli = $data_rj['PoliPertama'];
					$nokartu = $data_rj['nokartu'];
				
					// tbpasien
					if (strlen($data_rj['NoIndex']) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nik,NoIndex,TanggalLahir FROM `$tbpasien` WHERE `NoIndex`='$data_rj[NoIndex]'"));
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nik,NoIndex,TanggalLahir FROM `$tbpasien` WHERE `NoAsuransi`='$data_rj[NoIndex]'"));
					}
				
					// tbkk
					$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE NoIndex = '$noindex'"));
					
					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$dt_kk[Kelurahan]'"));
										
					// ec_cities
					$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$dt_kk[Kota]'"));
					
					if($dt_kk['Alamat'] != ''){
						$alamat_kk = $dt_kk['Alamat']." RT. ".$dt_kk['RT']." ".$dt_subdis['subdis_name'];
					}else{
						$alamat_kk = "Alamat Belum di Inputkan";
					}
				
					//tbpoliumum
					if ($poli == 'POLI UMUM'){
						if($kota == "KABUPATEN BANDUNG"){
							$poliumum = "tbpoliumum";
						}else{
							$poliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
						}
						$str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_umum = (mysqli_query($koneksi,$str_umum));
						$data_umum = mysqli_fetch_assoc($query_umum);
						$anamnesa = $data_umum['Anamnesa'];
					}else if ($poli == 'POLI GIZI'){
						$str_gizi= "SELECT * FROM `tbpoligizi` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_gizi = (mysqli_query($koneksi,$str_gizi));
						$data_gizi = mysqli_fetch_assoc($query_gizi);
						$anamnesa = $data_gizi['Anamnesa'];
					}else if ($poli == 'POLI LANSIA'){
						$str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_lansia = (mysqli_query($koneksi,$str_lansia));
						$data_lansia = mysqli_fetch_assoc($query_lansia);
						$anamnesa = $data_lansia['Anamnesa'];
					}else if ($poli == 'POLI MTBS'){
						$str_mtbs = "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_mtbs = (mysqli_query($koneksi,$str_mtbs));
						$data_mtbs = mysqli_fetch_assoc($query_mtbs);
						$anamnesa = $data_mtbs['Anamnesa'];
					}else if ($poli == 'POLI UGD'){
						$str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_ugd = (mysqli_query($koneksi,$str_ugd));
						$data_ugd = mysqli_fetch_assoc($query_ugd);
						$anamnesa = $data_ugd['Anamnesa'];
					}		
				
					// kelamin
					if($kelamin == 'L'){
						if($data_rj['UmurTahun'] != '0'){
							$kelamin_l = $data_rj['UmurTahun']."Th";
						}else{
							$kelamin_l = $data_rj['UmurBulan']."Bl";
						}	
						$kelamin_p = '-';
					}else{
						if($data_rj['UmurTahun'] != '0'){
							$kelamin_p = $data_rj['UmurTahun']."Th";
						}else{
							$kelamin_p = $data_rj['UmurBulan']."Bl";
						}	
						$kelamin_l = '-';
					}
				
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalDiagnosa']));?></td>
						<td class="str">
							<?php 
								echo "<b>".$data_rj['NamaPasien']."</b><br/>";
								echo substr($noindex,-10)."<br/>".
								$dt_pasien['Nik'];
							?>
						</td>
						<td><?php echo date('d-m-Y', strtotime($dt_pasien['TanggalLahir']));?></td>
						<td><?php echo $kelamin_l;?></td>
						<td><?php echo $kelamin_p;?></td>
						<td><?php echo strtoupper($alamat_kk);?></td>
						<td><?php echo strtoupper($data_rj['StatusKunjungan']);?></td>
						<td class="str">
							<?php 
								echo $data_rj['Asuransi']."<br/>";
								if (substr($data_rj['Asuransi'],0,4) == "BPJS"){
									echo $nokartu;
								}
							?>
						</td>
						<td><?php echo str_replace('POLI','',$data_rj['PoliPertama']);?></td>
						<td><?php echo $anamnesa;?></td>
						<td><?php echo $dtsistole." / ".$dtdiastole;?></td>
						<td><?php echo $dtberatBadan." / ".$dttinggiBadan;?></td>
						<td><?php echo $dtsuhutubuh;?></td>
						<td><?php echo $dtheartRate." / ".$dtrespRate;?></td>
						<td><?php echo $kodediagnosa;?></td>
						<td><?php echo strtoupper($kasus);?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>