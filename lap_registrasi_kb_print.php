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
	<title>Register KB</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_kb&opsiform=<?php echo $opsiform;?>&keydate1=<?php echo $keydate1;?>&keydate2=<?php echo $keydate2;?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>&h=1'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KB</b></span><br>
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
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table style="font-size:12px;">
				<tr>
					<td width="15%">Kelurahan/Desa</td>
					<td width="2%">:</td>
					<td width="33%"><?php echo $kelurahan;?></td>
				</tr>
				<tr>
					<td>Kecamatan</td>
					<td>:</td>
					<td><?php echo $kecamatan;?></td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:12px;">
					<tr style="border:1px solid #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Reg</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
						<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anamnesa</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
						<th colspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Rujuk</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Ket.</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th style="text-align:center; border:1px solid #000; padding:3px;">Ya</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Tidak</th>
					</tr>
				</thead>
				<tbody style="font-size:12px;">
					<?php
					if($opsiform == 'bulan'){
						$waktu = "YEAR(TanggalPeriksa) = '$tahun'";
						// $tbpasienrj = 'tbpasienrj_'.$bulan;
						$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
						
						// $str = "SELECT * FROM `tbpolikb` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi 
						// WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";
						
						$str = "SELECT * FROM `tbpolikb` WHERE ".$waktu." and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";
						$str2 = $str."ORDER BY `TanggalPeriksa` DESC";
					}else{
						$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
						// $tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate1));
						// $tbpasienrj2 = 'tbpasienrj_'.date('m', strtotime($keydate2));
						$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
						$tbpasienrj2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
						$tbpasienperpegawai='tbpasienperpegawai_'.date('m', strtotime($keydate1));
						$tbpasienperpegawai2='tbpasienperpegawai_'.date('m', strtotime($keydate2));
						$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($keydate1));
						$tbdiagnosapasien2 = 'tbdiagnosapasien_'.date('m', strtotime($keydate2));
						
						$str = "SELECT * FROM(
								SELECT a.TanggalPeriksa as TanggalPeriksa ,b.NamaPasien as NamaPasien, a.NoPemeriksaan as NoPemeriksaan, a.NoIndex as NoIndex, b.UmurTahun as UmurTahun, b.UmurBulan as UmurBulan, b.JenisKelamin as JenisKelamin, b.StatusPulang as StatusPulang, c.NamaPegawai1 as NamaPegawai1, c.NamaPegawai2 as NamaPegawai2
								FROM `tbpolikb` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi
								WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'
								UNION 
								SELECT a.TanggalPeriksa as TanggalPeriksa ,b.NamaPasien as NamaPasien, a.NoPemeriksaan as NoPemeriksaan, a.NoIndex as NoIndex, b.UmurTahun as UmurTahun, b.UmurBulan as UmurBulan, b.JenisKelamin as JenisKelamin, b.StatusPulang as StatusPulang, c.NamaPegawai1 as NamaPegawai1, c.NamaPegawai2 as NamaPegawai2
								FROM `tbpolikb` a join `$tbpasienrj2` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai2 c on a.NoPemeriksaan = c.NoRegistrasi
								WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'
								) a ";
						$str2 = $str."ORDER BY `NoPemeriksaan` DESC";
					}
					// echo $str2;
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noregistrasi = $data['NoPemeriksaan'];
						$noindex = $data['NoIndex'];
						$kelamin = $data['JenisKelamin'];
						
						// tbpolikb kunjunganulang
						$dt_kbku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa` FROM `tbpolikb_kunjunganulang` WHERE NoPemeriksaan = '$noregistrasi'"));
						$anamnesa = $dt_kbku['Anamnesa'];
												
						// pasienrj
						$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi`='$noregistrasi'"));
						$kelamin = 	$dt_pasienrj['JenisKelamin'];
						$umur = 	$dt_pasienrj['UmurTahun']. " Th";
						
						// pasien
						if (strlen($noindex) == 24){
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoIndex` = '$noindex'"));
							$noindex2 = $dt_pasien['NoIndex'];
						}else{
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$noindex'"));
							if ($dt_pasien['NoIndex'] != ''){
								$noindex2 = $dt_pasien['NoIndex'];
							}else{
								$noindex2 = $noindex;
							}
						}
						
						// tbkk
						$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex2'";
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
						
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
						
						//cek rujukan
						$rujukan = $data['StatusPulang'];
						if ($rujukan == 3){
							$berobatjalan = '<span class="fa fa-check"></span>';
							$rujuklanjut = '-';
						}else if($rujukan == 4){
							$rujuklanjut = '<span class="fa fa-check"></span>';
							$berobatjalan = '-';
						}
					
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
						
						// tbpasienperpegawai
						$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
						$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE NoRegistrasi='$noregistrasi'"));
						if($dt_pegawai['NamaPegawai1']!=''){
							$pemeriksa = $dt_pegawai['NamaPegawai1'];
						}else{
							$pemeriksa = $data['NamaPegawaiSimpan'];
						}
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noregistrasi,19);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex2,14);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;">
								<?php
									if($data_kk['Alamat'] == ''){
										echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
									}else{
										echo $alamat;
									}
								?>
							</td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $anamnesa;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $rujuklanjut;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $berobatjalan;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($pemeriksa);?></td>
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