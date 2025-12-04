<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	// filter data
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_DBD (".$hariini.").xls");
	if(isset($bulan) and isset($tahun)){
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>REGISTER HARIAN DBD</b></h4>
	<p style="margin:5px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kelurahan;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kecamatan;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">No.</th>
					<th rowspan="2" width="5%">NoRM</th>
					<th rowspan="2">Nama Pasien</th>
					<th colspan="2" width="8%">Umur</th>
					<th colspan="2" width="15%">Alamat</th>
					<th rowspan="2" width="8%">Puskesmas</th>
					<th rowspan="2" width="6%">Tgl.Sakit</th>
					<th rowspan="2" width="6%">Sumber Data</th>
					<th rowspan="2" width="6%">Dirawat</th>
					<th rowspan="2" width="6%">Diagnosa</th>
					<th colspan="4" width="20%">Tindak Lanjut</th>
					<th rowspan="2">Ket.(%)</th>
				</tr>
				<tr style="border:1px solid #000;">
					<!--tanggal kunjungan-->
					<th>L</th>
					<th>P</th>
					<!--alamat-->
					<th>Alamat Lengkap</th>
					<th>Desa/Kel</th>
					<!--tindak lanjut-->
					<th>PE</th>
					<th>Abatisasi</th>
					<th>Fogging</th>
					<th>Rata2 Abj</th>
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
					<th>16</th>
					<th>17</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php				
				if($kasus == "semua"){
					$qkasus = " ";
				}else{
					$qkasus = " AND `Kasus`='$kasus'";
				}
				
				$str = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND (`KodeDiagnosa`='A90' OR `KodeDiagnosa`='A91')".$qkasus; 
				$str2 = $str;
				// echo $str;
				
				$query_ispa = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query_ispa)){
					$no = $no + 1;
					$nocm = $data['NoCM'];
					$noregistrasi = $data['NoRegistrasi'];
					$tanggaldiagnosa = $data['TanggalDiagnosa'];
					$bulandiagnosa = date('m', strtotime($data['TanggalDiagnosa']));
					
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM` = '$nocm'"));
					$norm = $datapasien['NoRM'];
					$nik = $datapasien['Nik'];
					$namapasien = $datapasien['NamaPasien'];
					$alamat = $datapasien['Alamat'];
					$desa = $datapasien['Kelurahan'];
					
					// tbpasienrj
					$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
					$kunjungan = $datapasienrj['StatusKunjungan'];
					$jeniskelamin = $datapasienrj['JenisKelamin'];
					$umurtahun = $datapasienrj['UmurTahun'];
					$umurbulan= $datapasienrj['UmurBulan'];
					$sumberdata= $datapasienrj['PoliPertama'];
					
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
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
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
						$klinis = "-";
					}	
					
					if($array_data[$no][0] == 'A01.0' || $array_data[$no][0]== 'A01.1'){
						$konfirmasilab = "POSITIF";
					}else{
						$konfirmasilab = "-";
					}							
					
				
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo substr($norm,-8);?></td>
						<td><?php echo $namapasien;?></td>
						<td><?php echo $umur_laki;?></td>
						<td><?php echo $umur_perempuan;?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $desa;?></td>
						<td><?php echo $namapuskesmas;?></td>								
						<td><?php echo $tanggaldiagnosa;?></td>								
						<td><?php echo $sumberdata;?></td>							
						<td></td>								
						<td><?php echo $data_dgs;?></td>								
						<td>Ya</td>
						<td>Ya</td>
						<td>-</td>
						<td>-</td>
						<td></td>
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