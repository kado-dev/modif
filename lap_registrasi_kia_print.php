<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
?>

<html lang="en">
<head>
	<title>Register KIA</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_kia&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_kia'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KIA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span><br>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
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
			<table class="table table-condensed" width="100%">
				<thead style="font-size:8px;">
					<tr style="border:1px solid #000;">
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Reg</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anamnesa</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">G/P/A</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">HPHT</th>
						<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Hasil Pemeriksaan</th>
						<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemberian</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Faktor Resti</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
						<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Rujuk</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Ket.</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th style="text-align:center; border:1px solid #000; padding:3px;">BB</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">TB</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">TD</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">LILA</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">TT</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">FE</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Ya</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Tidak</th>
					</tr>
				</thead>
				<tbody style="font-size:8px;">
					<?php
					$str = "SELECT * FROM `$tbpolikia` WHERE MONTH(TanggalPeriksa) = '$bulan' and YEAR(TanggalPeriksa) = '$tahun' and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str."ORDER BY `TanggalPeriksa` Desc";
					$query = mysqli_query($koneksi,$str2);
					
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noregistrasi = $data['NoRegistrasi'];
						$noindex = $data['NoIndex'];
						
						// tbpasienperpegawai
						$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
						$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
						if($dt_pegawai['NamaPegawai1']!=''){
							$pemeriksa = $dt_pegawai['NamaPegawai1'];
						}else{
							$pemeriksa = $dt_pegawai['NamaPegawai2'];
						}
						
						//tbpasienrj
						$str_rj = "SELECT JenisKelamin,UmurTahun,UmurBulan,PoliPertama,StatusPulang 
						FROM `$tbpasienrj` 
						WHERE `NoRegistrasi` = '$noregistrasi'";
						$query_rj = mysqli_query($koneksi,$str_rj);
						$data_rj = mysqli_fetch_assoc($query_rj);
						$kelamin = $data_rj['JenisKelamin'];
						
						//tbkk
						$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
						// echo $str_kk;
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						
						//tbdiagnosapasien
						$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
						$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
						
						// cek umur kelamin
						$umur = $data_rj['UmurTahun']."th ".$data_rj['UmurBulan']."Bl";
						
						if($alamat != null){
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
						}else{
							$alamat = "-";
						}
						
						//cek rujukan
						$rujukan = $data_rj['StatusPulang'];
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
							$array_data[$data['NoRegistrasi']][] = $data_diagnosapsn['KodeDiagnosa'];
						}
						if ($array_data[$data['NoRegistrasi']] != ''){
							$data_dgs = implode(",", $array_data[$data['NoRegistrasi']]);
						}else{
							$data_dgs ="";
						}
						// echo $data_dgs;
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoRegistrasi'],19);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoIndex'],14);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Anamnesa'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Gravida'];?>/<?php echo $data['Partus'];?>/<?php echo $data['Abortus'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Hpht'];?></td><!--hpht-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['BeratBadan'];?></td><!--bb-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td><!--tb-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Sistole']."/".$data['Diastole'];?></td><!--td-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Lila'];?></td><!--lila-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TT'];?></td><!--pemberian tt-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['FE'];?></td><!--pemberian fe-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['FaktorResiko'];?></td><!--faktor resti-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td><!--diagnosa-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $rujuklanjut;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $berobatjalan;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $pemeriksa;?></td><!--ket-->
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