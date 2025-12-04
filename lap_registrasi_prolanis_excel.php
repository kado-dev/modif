<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Pelayanan Prolanis (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI PASIEN PELAYANAN PROLANIS</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="7%">TGL.PERIKSA</th>
					<th rowspan="2" width="5%">NO.INDEX</th>
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
				$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
				$str = "SELECT a.TanggalPeriksa, b.NamaPasien, a.Anamnesa, a.NoPemeriksaan, a.NoIndex, a.Sistole, a.Diastole, a.BeratBadan, a.TinggiBadan, a.SuhuTubuh, a.DetakNadi, a.RR, b.UmurTahun, b.JenisKelamin, b.StatusPulang, b.Asuransi, b.StatusKunjungan, c.NamaPegawai1, c.NamaPegawai2
				FROM `tbpoliprolanis` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi
				WHERE ".$waktu;
				$str2 = $str."ORDER BY a.`TanggalPeriksa` DESC, a.`NamaPasien` ASC";
				// echo $str2;
				// die();
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kelamin = $data['JenisKelamin'];
					$kunjungan = $data['StatusKunjungan'];
					$tensi = $data['Sistole']."/".$data['Diastole'];
					$bb = $data['BeratBadan'];
					$tb = $data['TinggiBadan'];
					$suhu = $data['SuhuTubuh'];
					$hrrr = $data['DetakNadi']."/".$data['RR'];
					$therapy = $data['Terapi'];
					
					// tbpasienperpegawai
					if($data['NamaPegawai1']!=''){
						$pemeriksa = $data['NamaPegawai1'];
					}else{
						$pemeriksa = $data['NamaPegawai2'];
					}
					
					// pasien
					if (strlen($noindex) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoIndex` = '$noindex'"));
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoAsuransi` = '$noindex'"));
					}
					
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan`, `Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$datakk = mysqli_fetch_assoc($query_kk);
					
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

					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan);
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi' GROUP BY `KodeDiagnosa`";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data['UmurTahun']." Th";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data['UmurTahun']." Th";
					}
					
					// cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
					
					// cek diagnosa pasien
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
						if($kota == "KOTA TARAKAN"){
							$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
						}else{
							$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa'];
						}
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
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
						$data_trp = "";
					}
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
						<td align="center"><?php echo substr($noindex, -10);?></td>
						<td align="left"><?php echo $data['NamaPasien'];?></td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="left">
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