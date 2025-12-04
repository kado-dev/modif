<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan CACINGAN (".$namapuskesmas.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>REGISTRASI CACINGAN</b></h4>
	<p style="margin:1px; font-size: 16px;">
		<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kelurahan);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">NO.</th>
					<th width="7%" rowspan="2">TGL.PERIKSA</th>
					<th width="10%" rowspan="2">NAMA PASIEN</th>
					<th width="10%" rowspan="2">KEPALA KELUARGA</th>
					<th width="5%" colspan="2">UMUR<br/>PASIEN</th>
					<th width="15%" rowspan="2">ALAMAT</th>
					<th width="8%" rowspan="2">TELP.</th>
					<th width="10%" rowspan="2">THERAPY</th>
					<th width="15%" colspan="3">PEMERIKSAAN TINJA</th>
					<th width="10%" colspan="2">PENGOBATAN (ALBENDAZOLE)</th>
					<th width="5%" rowspan="2">KET.</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TANGGAL</th>
					<th>HASIL</th>
					<th>JUMLAH</th>
					<th>DOSIS</th>
					<th>JUMLAH</th>
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
					<th>13</th>
					<th>14</th>
					<th>15</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$waktu = " date(TanggalDiagnosa) BETWEEN '$keydate1' AND '$keydate2'";						
				$str = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." AND (`KodeDiagnosa` LIKE '%B83%' OR `KodeDiagnosa` like '%B77%' OR `KodeDiagnosa` = 'B83.0' OR `KodeDiagnosa` = 'T37.4' OR `KodeDiagnosa` LIKE '%B76%' OR `KodeDiagnosa` LIKE '%B80%')"; 
				$str2 = $str;
				// echo $str;
								
				$query_ispa = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query_ispa)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$noregistrasi = $data['NoRegistrasi'];
					$tanggaldiagnosa = $data['TanggalDiagnosa'];
					
					// tbkk
					$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`No`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
					$namakk = $datakk['NamaKK'];
					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", NO.".$datakk['No'].", ".$datakk['Kelurahan'];
					
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
					$nik = $datapasien['Nik'];
					$namapasien = $datapasien['NamaPasien'];
					
					// tbpasienrj
					$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
					$jeniskelamin = $datapasienrj['JenisKelamin'];
					$umurtahun = $datapasienrj['UmurTahun'];
					$umurbulan= $datapasienrj['UmurBulan'];
					
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
					
					if($umurtahun != '0'){
						$umur = $umurtahun."Th";
					}else{
						$umur = $umurbulan."Bl";
					}	
					
					if($jeniskelamin == 'L'){
						$umur_laki = $umur;
					}else{
						$umur_laki = "-";
					}
			
					if($jeniskelamin == 'P'){
						$umur_perempuan = $umur;
					}else{
						$umur_perempuan = "-";
					}			
				
				?>
					<tr style="border:1px solid #000;">
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($tanggaldiagnosa));?></td>
						<td align="left"><?php echo $namapasien;?></td>
						<td align="left"><?php echo $namakk;?></td>
						<td align="center"><?php echo $umur_laki;?></td>
						<td align="center"><?php echo $umur_perempuan;?></td>
						<td align="left"><?php echo $alamat;?></td>											
						<td align="center">
							<?php 
								if($datakk['Telepon'] != ''){
									echo $datakk['Telepon'];
								}else{
									if($datapasien['Telpon'] != ''){
										echo $datapasien['Telpon'];
									}else{
										echo "BELUM DIINPUTKAN";
									}	
								}	
							?>
						</td>							
						<td align="left"><?php echo strtoupper($data_trp);?></td>
						<td align="left"></td>
						<td align="left"></td>
						<td align="left"></td>
						<td align="left"></td>
						<td align="left"></td>
						<td align="left"></td>
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