<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Lansia (".$hariini.").xls");
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
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER LANSIA</b></h4>
	<p style="margin:1px; font-size: 16px;">
		<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">NO.</th>
					<th width="12%" rowspan="2">TGL.PERIKSA</th>
					<th width="15%" rowspan="2">NAMA PASIEN - KK</th>
					<th width="8%" colspan="2">UMUR</th>
					<th width="10%" rowspan="2">ALAMAT</th>
					<th width="5%" rowspan="2">KUNJ.</th>
					<th width="8%" colspan="5">VITAL SIGN</th>
					<th width="10%" rowspan="2">ANAMNESA</th>
					<th width="5%" rowspan="2">DIAGNOSA</th>
					<th width="10%" rowspan="2">THERAPY</th>
					<th width="5%" colspan="2">RUJUK</th>
					<th width="8%" rowspan="2">KET.</th>
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
				$str = "SELECT * FROM `$tbpolilansia` 
				WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND ".$waktu;
				$str2 = $str."ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC";
				// echo $str2;
				// die();
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kelamin = $data['JenisKelamin'];
					$tensi = $data['Sistole']."/".$data['Diastole'];
					$bb = $data['BeratBadan'];
					$tb = $data['TinggiBadan'];
					$suhu = $data['SuhuTubuh'];
					$hrrr = $data['DetakNadi']."/".$data['RR'];
					$therapy = $data['Terapi'];
					$pemeriksa = $data['NamaPegawaiSimpan'];
					
					// tbpasienrj
					$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$querypasienrj = mysqli_query($koneksi, $strpasienrj);
					$datapasienrj = mysqli_fetch_assoc($querypasienrj);
					$kunjungan = $datapasienrj['StatusKunjungan'];
					$asuransi = $datapasienrj['Asuransi'];
					
					// pasien
					if (strlen($noindex) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoIndex` = '$noindex'"));
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoAsuransi` = '$noindex'"));
					}
					
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
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
						$data_trp ="";
					}
					
				?>
					<tr style="border:1px solid #000;">
						<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']))." ".date('G:i:s', strtotime($data['TanggalPeriksa']));?></td>
						<td align="left">
							<?php 
								echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
								strtoupper($data_kk['NamaKK'])."<br/>".
								substr($noindex, -10)."<br/>".
								$data['Asuransi']);
							?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="left">
							<?php
								if($data_kk['Alamat'] == ''){
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
						<td align="left"><?php echo strtoupper($pemeriksa);?></td>
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