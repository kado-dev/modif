<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
?>

<html lang="en">
<head>
	<title>Register Lansia</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_lansia&bulan=<?php echo $bulan?>&tahun=<?php echo $tahun?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN POLI LANSIA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span>
		<br/>
	</div>
	
	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px dashed #000;">
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Tanggal</th>
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.Reg</th>
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Pasien</th>
						<th colspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kunj.</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Anamnesa</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Diagnosa</th>
						<th colspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Rujuk</th>
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center;width:1%; border:1px dashed #000; padding:3px;">L</th>
						<th style="text-align:center;width:1%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Ya</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Tidak</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php			
					$str = "SELECT * FROM `$tbpolilansia` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi 
					WHERE  MONTH(a.TanggalPeriksa) = '$bulan' and YEAR(a.TanggalPeriksa) = '$tahun' 
					and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str." ORDER BY `TanggalPeriksa` Desc";
					$query = mysqli_query($koneksi,$str2);
					
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kunjungan = $data['StatusKunjungan'];
					$kelamin = $data['JenisKelamin'];
					
					// tbpasienperpegawai
					$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaPegawai1 FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					if(strlen($noindex) == 13){ 
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$noindex' AND SUBSTRING(NoIndex,3,11)='$kodepuskesmas'"));
						$noindex2 = $dt_pasien['NoIndex'];
					}else{
						$noindex2 = $data['NoIndex'];
					}
									
					//tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					//tbpasienrj
					$str_rj = "SELECT JenisKelamin, UmurTahun, PoliPertama, StatusPulang FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$kelamin = $data_rj['JenisKelamin'];
					
					// tbdiagnosapasien
					$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					
					//cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data_rj['UmurTahun']." thn";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data_rj['UmurTahun']." thn";
					}
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
					}else{
						$alamat = "-";
					}
					
					//cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
					?>
						
					<?php
					//cek diagnosa pasien
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
					// echo $data_dgs;
					
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($noregistrasi,19);?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($noindex2,14);?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_p;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $alamat;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $kunjungan;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $anamnesa;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_dgs;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $rujuklanjut;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $berobatjalan;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $pemeriksa;?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>