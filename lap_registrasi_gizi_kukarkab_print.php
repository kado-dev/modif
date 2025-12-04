<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate = $_GET['keydate'];
	$opsiform = $_GET['opsiform'];
?>

<html lang="en">
<head>
	<title>Register Umum</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_umum&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_gizi_kukarkab'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN POLI GIZI</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate));
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
					<td style="padding:2px 4px;"><?php echo strtoupper($kelurahan);?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper($kecamatan);?></td>
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
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.RM</th>
						<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Anak</th>
						<th colspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tgl.Lahir</th>
						<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Ortu</th>
						<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tindakan</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">BB</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">TB</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Temp</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">NTOB</th>
						<th colspan="3" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Status Gizi</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">ASI</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/U</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/TB</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">TB/U</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					if ($opsiform == 'bulan'){
						$tbpasienperpegawai = 'tbpasienperpegawai_'.$bulan;
						$tbpasienrj = 'tbpasienrj_'.$bulan;
						$tahun = $_GET['tahun'];
					}else{
						$tbpasienperpegawai = 'tbpasienperpegawai_'.date('m', strtotime($keydate));
						$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate));
						$tahun = date('Y', strtotime($keydate));
					}
					
					// insert ke tbpasienperpegawai_bulan
					$strpasienperpegawai = "SELECT * FROM `$tbpasienperpegawai` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
					$querypasienperpegawai = mysqli_query($koneksi, $strpasienperpegawai);
					mysqli_query($koneksi, "DELETE FROM `tbpasienperpegawai_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
					while($datapspg = mysqli_fetch_assoc($querypasienperpegawai)){
						$strpasienperpegawaibulan = "INSERT INTO `tbpasienperpegawai_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`,`NamaPegawai4`,`NamaPegawai5`,`Lab`,`Farmasi`) VALUES 
						('$datapspg[TanggalRegistrasi]','$datapspg[NoRegistrasi]','$datapspg[Pendaftaran]','$datapspg[NamaPegawai1]','$datapspg[NamaPegawai2]','$datapspg[NamaPegawai3]','$datapspg[NamaPegawai4]','$datapspg[NamaPegawai5]','$datapspg[Lab]','$datapspg[Farmasi]')";
						mysqli_query($koneksi, $strpasienperpegawaibulan);
					}
					
					// insert ke tbpasienrj_bulan
					$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
					$querypasienrj = mysqli_query($koneksi, $strpasienrj);
					mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
					while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
						$strpasienrjbulan = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
						`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
						`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
						`nokartu`,`kdpoli`,`Kir`) VALUES 
						('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NamaPasien]',
						'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
						'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$datapsrj[StatusKunjungan]','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
						'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
						,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
						'$datapsrj[Kir]')";
						mysqli_query($koneksi, $strpasienrjbulan);
					}
					
					if ($opsiform == 'bulan'){
						$str = "SELECT *
						FROM `tbpoligizi` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND MONTH(TanggalPeriksa) = '$bulan' AND
						YEAR(TanggalPeriksa) = '$tahun'";
					}else{
						$str = "SELECT * FROM `tbpoligizi` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND TanggalPeriksa = '$keydate'";
					}
					$str2 = $str." ORDER BY `TanggalPeriksa` DESC";
					// echo ($str2);
					// die();
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noregistrasi = $data['NoPemeriksaan'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						$anamnesa = $data['Anamnesa'];
						$tindakan = $data['TindakanGizi'];
						
						// tbpasienrj
						$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `UmurTahun`,`UmurBulan`,`NoRM`
						FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
						if($dt_pasienrj['UmurTahun'] != '0'){
							$umur = $dt_pasienrj['UmurTahun']."Th";
						}else{
							$umur = $dt_pasienrj['UmurBulan']."Bl";
						}
						
						if ($dt_pasienrj['JenisKelamin'] == 'L'){
							$umur_l = $umur;
							$umur_p = "-";
						}else{
							$umur_l = "-";
							$umur_p = $umur;
						}
						
						// tbpasien, tanggal lahir
						$tbpasien = 'tbpasien_'.substr($noindex,14,4);
						$str_tlahir = "SELECT * FROM `$tbpasien` WHERE `NoCM`='$nocm'";
						$query_tlahir = mysqli_query($koneksi,$str_tlahir);
						$data_tlahir = mysqli_fetch_assoc($query_tlahir);
										
						// tbkk
						$str_kk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
						$telepon = $data_kk['Telepon'];
						
						// tbpasienperpegawai
						$dt_pasien_prpg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1`,`NamaPegawai2`
						FROM `tbpasienperpegawai_bulan` WHERE `NoRegistrasi` = '$noregistrasi'"));				
						if($dt_pasien_prpg['NamaPegawai1']!=''){
							$pemeriksa = $dt_pasien_prpg['NamaPegawai1'];
						}else{
							$pemeriksa = $dt_pasien_prpg['NamaPegawai2'];
						}
						
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($dt_pasienrj['NoRM'],-6);?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_p;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_tlahir['TanggalLahir'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['NamaKK'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", Telp.".$data_kk['Telepon'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $tindakan;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['BeratBadan'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['SuhuTubuh'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Ntob'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Bbu'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Bbtb'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Tbu'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Asi'];?></td>
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