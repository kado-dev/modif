<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Pelayanan Umum (".$hariini.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>
<style>
.tr, th{
	text-align:center;
}
td {
	vertical-align: middle;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printheader p{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Poppins", sans-serif;
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
	font-family: "Poppins", sans-serif;
}
.font11{
	font-size:11px;
	font-family: "Poppins", sans-serif;
}
.font14{
	font-size:14px;
	font-family: "Poppins", sans-serif;
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI PASIEN PELAYANAN UMUM</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="7%">TGL.PERIKSA</th>
					<th rowspan="2" width="10%">NIK</th>
					<th rowspan="2" width="15%">NAMA PASIEN</th>
					<th colspan="2" width="8%">UMUR</th>
					<th rowspan="2" width="10%">ALAMAT</th>
					<th rowspan="2" width="5%">KUNJ.</th>
					<th colspan="5" width="8%">VITAL SIGN</th>
					<th rowspan="2" width="10%">ANAMNESA</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="10%">THERAPY</th>
					<th colspan="2" width="5%">RUJUK</th>
					<th rowspan="2" width="8%">KET.</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TD</th>
					<th>BB</th>
					<th>TB</th>
					<th>SUHU</th>
					<th>HR/RR</th>
					<th>YA</th>
					<th>TDK</th>
				</tr>
			</thead>
			<tbody>
				<?php				
				$waktu = "date(TanggalPeriksa) BETWEEN '$keydate1' AND '$keydate2'";
				$str = "SELECT TanggalPeriksa, IdPasienrj, NamaPasien, Anamnesa, NoPemeriksaan, NoIndex, NamaPegawaiSimpan
				FROM `$tbpoliumum` 
				WHERE ".$waktu;
				$str2 = $str."ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC";
				// echo $str2;
				// die();
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$idpasienrj = $data['IdPasienrj'];
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$therapy = $data['Terapi'];
					$pemeriksa = $data['NamaPegawaiSimpan'];

					// vital sign
					$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
					$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
					$tensi = $dtvs['Sistole']."/".$dtvs['Diastole'];
					$bb = $dtvs['BeratBadan'];
					$tb = $dtvs['TinggiBadan'];
					$suhu = $dtvs['SuhuTubuh'];
					$hrrr = $dtvs['HeartRate']."/".$dtvs['RespiratoryRate'];
					
					// tbpasienrj
					$str_prj = "SELECT `JenisKelamin`,`UmurTahun`,`StatusKunjungan`,`StatusPulang` FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'";
					$query_prj = mysqli_query($koneksi, $str_prj);
					$dataprj = mysqli_fetch_assoc($query_prj);
					$kelamin = $dataprj['JenisKelamin'];
					$kunjungan = $dataprj['StatusKunjungan'];
					
					// tbpasien
					if (strlen($noindex) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex`, `Nik` FROM `$tbpasien` WHERE `NoIndex` = '$noindex'"));
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex`, `Nik` FROM `$tbpasien` WHERE `NoAsuransi` = '$noindex'"));
					}
					$nik = $dt_pasien['Nik'];						
					
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan`, `Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi, $str_kk);
					$datakk = mysqli_fetch_assoc($query_kk);
					
					// ec_districts
					$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
					if($dt_dis['dis_name'] != ''){
						$kecamatan = $dt_dis['dis_name'];
					}else{
						$kecamatan = $datakk['Kecamatan'];
					}

					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
					if($dt_subdis['subdis_name'] != ''){
						$kelurahan = $dt_subdis['subdis_name'];
					}else{
						$kelurahan = $datakk['Kelurahan'];
					}							

					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan);
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $dataprj['UmurTahun']." Th";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $dataprj['UmurTahun']." Th";
					}
					
					// cek rujukan
					$rujukan = $dataprj['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = 'Y';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = 'Y';
						$berobatjalan = '-';
					}
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi' GROUP BY `KodeDiagnosa`";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
						$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode("<br/>", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
					
					// therapy
					$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
						$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode("<br/>", $array_therapy[$no]);
					}else{
						$data_trp = "-";
					}
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
						<td align="center"><?php echo $nik;?></td>
						<td align="left" >
							<?php 
								echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
								strtoupper($datakk['NamaKK'])."<br/>".
								substr($noindex, -10)."<br/>".
								$data['Asuransi']);
							?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="left" >
							<?php
								if($datakk['Alamat'] == ''){
									echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
								}else{
									echo strtoupper($alamat);
								}
							?>
						</td>
						<td align="center"><?php echo strtoupper($kunjungan);?></td>
						<td align="center"><?php echo $tensi;?></td>
						<td align="center"><?php echo $bb;?></td>
						<td align="center"><?php echo $tb;?></td>
						<td align="center"><?php echo $suhu;?></td>
						<td align="center"><?php echo $hrrr;?></td>
						<td align="left"><?php echo $anamnesa;?></td>
						<td align="left"><?php echo strtoupper($data_dgs);?></td>
						<td align="left"><?php echo strtoupper($data_trp);?></td>
						<td align="center"><?php echo $rujuklanjut;?></td>
						<td align="center"><?php echo $berobatjalan;?></td>
						<td align="center"><?php echo strtoupper($pemeriksa);?></td>
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