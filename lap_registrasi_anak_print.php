<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
?>

<html lang="en">
<head>
	<title>Register Anak</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_umum&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_anak&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN POLI ANAK</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span><br/>
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
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px dashed #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tanggal</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Reg</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Pasien</th>
						<th colspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Anamnesa</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Diagnosa</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Therapy</th>
						<th colspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Rujuk</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Ya</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Tidak</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php	
					if($opsiform == 'bulan'){
						$waktu = "YEAR(TanggalPeriksa) = '$tahun'";
						$tbpasienrj = 'tbpasienrj_'.$bulan;
						$tbpasien = 'tbpasien_'.$tahun;
						$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
						
						$str = "SELECT * 
						FROM `tbpolianak` a
						JOIN `$tbpasien` b on a.NoCM = b.NoCM
						JOIN `$tbpasienrj` c on a.NoPemeriksaan = c.NoRegistrasi
						JOIN $tbpasienperpegawai d on a.NoPemeriksaan = d.NoRegistrasi 
						WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";
						$str2 = $str."ORDER BY `TanggalPeriksa` Desc";
					}else{
						$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
						$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate1));
						$tbpasienrj2 = 'tbpasienrj_'.date('m', strtotime($keydate2));
						$tbpoliumum = 'tbpoliumum_'.date('m', strtotime($keydate1));
						$tbpoliumum2 = 'tbpoliumum_'.date('m', strtotime($keydate2));
						$tbpasienperpegawai='tbpasienperpegawai_'.date('m', strtotime($keydate1));
						$tbpasienperpegawai2='tbpasienperpegawai_'.date('m', strtotime($keydate2));
						$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($keydate1));
						$tbdiagnosapasien2 = 'tbdiagnosapasien_'.date('m', strtotime($keydate2));
						
						$str = "SELECT * FROM(
								SELECT a.TanggalPeriksa as TanggalPeriksa ,b.NamaPasien as NamaPasien, a.Anamnesa as Anamnesa, a.NoPemeriksaan as NoPemeriksaan, a.NoIndex as NoIndex, b.UmurTahun as UmurTahun, b.JenisKelamin as JenisKelamin, b.StatusPulang as StatusPulang, c.NamaPegawai1 as NamaPegawai1, c.NamaPegawai2 as NamaPegawai2
								FROM `$tbpoliumum` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi
								WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'
								UNION 
								SELECT a.TanggalPeriksa as TanggalPeriksa ,b.NamaPasien as NamaPasien, a.Anamnesa as Anamnesa, a.NoPemeriksaan as NoPemeriksaan, a.NoIndex as NoIndex, b.UmurTahun as UmurTahun, b.JenisKelamin as JenisKelamin, b.StatusPulang as StatusPulang, c.NamaPegawai1 as NamaPegawai1, c.NamaPegawai2 as NamaPegawai2
								FROM `$tbpoliumum2` a join `$tbpasienrj2` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai2 c on a.NoPemeriksaan = c.NoRegistrasi
								WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'
								) a ";
						
						$str2 = $str."ORDER BY `TanggalPeriksa` Desc";
					}				
					//echo $str2;
					
					$query = mysqli_query($koneksi,$str2);
					
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kelamin = $data['JenisKelamin'];
					
					// tbpasienperpegawai
					if($data['NamaPegawai1']!=''){
						$pemeriksa = $data['NamaPegawai1'];
					}else{
						$pemeriksa = $data['NamaPegawai2'];
					}
					
					if(strlen($noindex) == 13){ 
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$noindex' AND SUBSTRING(NoIndex,3,11)='$kodepuskesmas'"));
						$noindex2 = $dt_pasien['NoIndex'];
					}else{
						$noindex2 = $data['NoIndex'];
					}
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
								
					// tbdiagnosapasien
					if($opsiform == 'bulan'){
						$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					}else{
						$str_diagnosapsn = "SELECT * from(
											SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'
											UNION
											SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien2` WHERE `NoRegistrasi` = '$noregistrasi'
											)a";
					}
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data['UmurTahun']." thn";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data['UmurTahun']." thn";
					}
					
					if($alamat != null){
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
					
					// therapy
					$str_therapy = "SELECT * FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.`NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$array_therapy[$no][] = $dt_therapy['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode(",", $array_therapy[$no]);
					}else{
						$data_trp ="";
					}
					
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
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $anamnesa;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_dgs;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_trp;?></td>
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