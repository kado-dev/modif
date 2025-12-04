<?php
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	include_once('config/koneksi.php');
	session_start();
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kasus = $_GET['kasus'];
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Tifoid (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI TIFOID</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p><br/>
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
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="10%">TANGGAL<br/>KUNJUNGAN</th>
					<th rowspan="2">NIK</th>
					<th rowspan="2">NAMA PASIEN</th>
					<th colspan="2" width="8%">UMUR</th>
					<th rowspan="2" width="20%">ALAMAT</th>
					<th colspan="2" width="20%">DIAGNOSA</th>
					<th colspan="2">KUNJ.</th>
					<th rowspan="2">KET.</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th>
					<th>P</th>
					<!--diagnosa-->
					<th>TANDA/GEJALA KLINIS</th>
					<th>KONFIRMASI LAB(+)</th>
					<!--kunjungan-->
					<th>B</th>
					<th>L</th>
				</tr>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
					<th>12</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$kasus = $_GET['kasus'];
				if($kasus == "semua"){
					$qkasus = " ";
				}else{
					$qkasus = " AND `Kasus`='$kasus'";
				}
				
				// tbdiagnosa_bulan
				$str = "SELECT * FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2' AND (`KodeDiagnosa`='A01' OR `KodeDiagnosa`='A01.0' OR `KodeDiagnosa`='A01.0')".$qkasus; 
				$str2 = $str."ORDER BY `TanggalDiagnosa`";
				
				$query_ispa = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query_ispa)){
					$no = $no + 1;
					$nocm = $data['NoCM'];
					$noregistrasi = $data['NoRegistrasi'];
					$tanggaldiagnosa = $data['TanggalDiagnosa'];						
					
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
					$norm = $datapasien['NoRM'];
					$nik = $datapasien['Nik'];
					$namapasien = $datapasien['NamaPasien'];
					$desa = $datapasien['Kelurahan'];
					
					// tbpasienrj
					$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
					$noindex = $dt_pasienrj['NoIndex'];
					$kunjungan = $dt_pasienrj['StatusKunjungan'];
					$kelamin = $dt_pasienrj['JenisKelamin'];
					$umurtahun = $dt_pasienrj['UmurTahun'];
					$umurbulan= $dt_pasienrj['UmurBulan'];
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $dt_pasienrj['UmurTahun']." TH";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $dt_pasienrj['UmurTahun']." TH";
					}
					
					// tbkk
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
					$alamat = strtoupper($dtkk['Alamat']).", RT.".$dtkk['RT'].", NO.".$dtkk['No']." ".strtoupper($dtkk['Kelurahan']);
					
					if($kunjungan == 'Baru'){
						$statuskunj_baru = '<span class="fa fa-check"></span>';
					}else{
						$statuskunj_baru = "-";
					}
					
					if($kunjungan == 'Lama'){
						$statuskunj_lama = '<span class="fa fa-check"></span>';
					}else{
						$statuskunj_lama = "-";
					}
												
					// cek diagnosa pasien
					$str = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query = mysqli_query($koneksi,$str);
					
					while($data_diagnosapsn = mysqli_fetch_array($query)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
					
					// konfirmasi lab
					if($data_dgs == 'A01'){
						$klinis = "POSITIF";
					}else{
						$klinis = "NEGATIF";
					}	
					
					if($array_data[$no][0] == 'A01.0' || $array_data[$no][0]== 'A01.1'){
						$konfirmasilab = "POSITIF";
					}else{
						$konfirmasilab = "NEGATIF";
					}							
					
				
				?>
					<tr style="border:1px solid #000;">
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $tanggaldiagnosa;?></td>
						<td align="center"><?php echo $nik;?></td>
						<td align="left">
							<?php 
								echo "<b>".strtoupper($dt_pasienrj['NamaPasien']."</b><br/>".
								strtoupper($dtkk['NamaKK'])."<br/>".
								substr($noindex, -10)."<br/>".
								$dt_pasienrj['Asuransi']."<br/>".
								$dt_pasienrj['PoliPertama']);
							?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="left">
							<?php
								if($dtkk['Alamat'] == ''){
									echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
								}else{
									echo strtoupper($alamat);
								}
							?>
						</td>
						<td align="center"><?php echo $klinis;?></td>
						<td align="center"><?php echo $konfirmasilab;?></td>
						<td align="center"><?php echo $statuskunj_baru;?></td>
						<td align="center"><?php echo $statuskunj_lama;?></td>
						<td align="center"><?php echo $data_dgs;?></td>
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