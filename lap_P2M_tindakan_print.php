<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>
<html>
<head>
	<title>Laporan Tindkan Pasien</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
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
</head>
<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$thn = substr($tahun,2,2);
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	$tbpasienperpegawai = 'tbpasienperpegawai_'.$bulan;
?>
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_P2M_tindakan&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">
<?php
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
?>
<!--tabel report-->
<div class="printheader">
	<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN RETRIBUSI TINDAKAN PASIEN</b></span><br>
	<span class="font10" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$_GET['tahun'];?></span>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-top:0px;">
		<table style="font-size:12px; width:300px;">
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
	<div style="float:right; width:35%; margin-top:0px;">	
		<table style="font-size:12px; width:300px;">
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
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tgl.</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Pasien</th>
					<th colspan="2" style="text-align:center; border:1px dashed #000; padding:3px;">Kelamin</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Kunjungan</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Jaminan</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Pelayanan</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Anamnesa</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Diagnosa</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tindakan</th>
					<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tarif</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Keterangan</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th width="4%" style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
					<th width="4%" style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				$str_tindakan = "SELECT * FROM `tbtindakanpasiendetail` 
				WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND SUBSTRING(NoRegistrasi,15,2) = '$bulan'
				AND SUBSTRING(NoRegistrasi,13,2) = '$thn'
				GROUP BY NoRegistrasi";
				
				$query_tindakan = mysqli_query($koneksi,$str_tindakan);
				while($data_tindakan = mysqli_fetch_assoc($query_tindakan)){
					$no = $no + 1;
					$noregistrasi = $data_tindakan['NoRegistrasi'];
					$kodediagnosa = $data_tindakan['KodeDiagnosa'];
					$tgl_tindakan = substr($data_tindakan['NoRegistrasi'],16,2)."/".
					substr($data_tindakan['NoRegistrasi'],14,2)."/".
					substr($data_tindakan['NoRegistrasi'],12,2);
											
					// tbpasienrj
					$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$noindex = $data_rj['NoIndex'];
					$kelamin = $data_rj['JenisKelamin'];
					$poli = $data_rj['PoliPertama'];
					
					$pemeriksa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NamaPegawai1, NamaPegawai2 FROM
					`$tbpasienperpegawai` WHERE NoRegistrasi = '$noregistrasi'"));
											
					// pasien
					if (strlen($data_rj['NoIndex']) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoIndex` = '$data_rj[NoIndex]'"));
						$noindex2 = $dt_pasien['NoIndex'];
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$data_rj[NoIndex]'"));
						$noindex2 = $dt_pasien['NoIndex'];
					}
					
					// tbkk
					$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex2'"));
					if($dt_kk['Alamat'] != ''){
						$alamat_kk = $dt_kk['Alamat']." RT.".$dt_kk['RT']." RW.".$dt_kk['RW']." KEL.".strtoupper($dt_kk['Kelurahan']);
					}else{
						$alamat_kk = "Alamat Belum di Inputkan";
					}
					
					//tbpoliumum
					if ($poli == 'POLI UMUM'){
						$poliumum = 'tbpoliumum_'.$bulan;
						$str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_umum = (mysqli_query($koneksi, $str_umum));
						$data_umum = mysqli_fetch_assoc($query_umum);
						$anamnesa = $data_umum['Anamnesa'];
						if ($anamnesa != null){$anamnesa = $data_umum['Anamnesa'];}else{$anamnesa = "-";}
					}else if ($poli == 'POLI GIGI'){
						$str_gigi = "SELECT * FROM `tbpoligigi` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_gigi = (mysqli_query($koneksi, $str_gigi));
						$data_gigi = mysqli_fetch_assoc($query_gigi);
						$anamnesa = $data_gigi['Anamnesa'];
						if ($anamnesa != null){$anamnesa = $data_gigi['Anamnesa'];}else{$anamnesa = "-";}
					}else if ($poli == 'POLI KB'){
						$str_kb = "SELECT * FROM `tbpolikb` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_kb = (mysqli_query($koneksi, $str_kb));
						$data_kb = mysqli_fetch_assoc($query_kb);
						$anamnesa = $data_kb['Anamnesa'];
						if ($anamnesa != null){$anamnesa = $data_kb['Anamnesa'];}else{$anamnesa = "-";}
					}else if ($poli == 'POLI KIA'){
						$str_kia = "SELECT * FROM `tbpolikia` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_kia = (mysqli_query($koneksi, $str_kia));
						$data_kia = mysqli_fetch_assoc($query_kia);
						$anamnesa = $data_kia['Anamnesa'];
						if ($anamnesa != null){$anamnesa = $data_kia['Anamnesa'];}else{$anamnesa = "-";}
					}else if ($poli == 'POLI UGD'){
						$str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_ugd = (mysqli_query($koneksi, $str_ugd));
						$data_ugd = mysqli_fetch_assoc($query_ugd);
						$anamnesa = $data_ugd['Anamnesa'];
						if ($anamnesa != null){$anamnesa = $data_ugd['Anamnesa'];}else{$anamnesa = "-";}
					}else if ($poli == 'POLI LANSIA'){
						$str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
						$query_lansia = (mysqli_query($koneksi, $str_lansia));
						$data_lansia = mysqli_fetch_assoc($query_lansia);
						$anamnesa = $data_lansia['Anamnesa'];
						if ($anamnesa != null){$anamnesa = $data_lansia['Anamnesa'];}else{$anamnesa = "-";}
					}		
					
					// kelamin
					if($kelamin == 'L'){
						$kelamin_l = $data_rj['UmurTahun']." Th";
						$kelamin_p = '-';
					}else{
						$kelamin_p = $data_rj['UmurTahun']." Th";
						$kelamin_l = '-';
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
					
					// tbtindakanpasiendetail
					$str_tindakan_dtl = "SELECT a.NoRegistrasi, b.Tindakan FROM `tbtindakanpasiendetail` a 
					JOIN `tbtindakan` b ON a.KodeTindakan = b.KodeTindakan
					WHERE a.`NoRegistrasi` = '$noregistrasi'";
					$query_tindakan_dtl = mysqli_query($koneksi,$str_tindakan_dtl);
					while($data_tindakan_dtl = mysqli_fetch_array($query_tindakan_dtl)){
						$array_data_tindakan[$no][] = $data_tindakan_dtl['Tindakan'];
						$array_data_tarif[$no][] = $data_tindakan_dtl['Tarif'];
					}
					if ($array_data_tindakan[$no] != ''){
						$kodetindakan = implode(",", $array_data_tindakan[$no]);
					}else{
						$kodetindakan ="";
					}
					
					// mengambil jumlah tarif
					$str_tarif= "SELECT SUM(b.Tarif)AS Tarif FROM `tbtindakanpasiendetail` a JOIN `tbtindakan` b ON a.KodeTindakan = b.KodeTindakan
					WHERE a.`NoRegistrasi` = '$noregistrasi'";
					$query_tarif = mysqli_query($koneksi,$str_tarif);
					while($dttarif = mysqli_fetch_array($query_tarif)){
						$array_dttarif[$no][] = $dttarif['Tarif'];
					}
										
					if(substr($data_rj['Asuransi'],0,4) == 'BPJS'){
						$tarif = '0';
					}else{
						if ($array_dttarif[$no] != ''){
							$tarif = implode(",", $array_dttarif[$no]);
						}else{
							$tarif ="";
						}
					}	
					
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center;border:1px dashed #000; padding:3px;"><?php echo $tgl_tindakan;?></td>
							<td style="text-align:center;border:1px dashed #000; padding:3px;"><?php echo substr($noindex2,14);?></td>
							<td style="text-align:left;border:1px dashed #000; padding:3px;"><?php echo $data_rj['NamaPasien'];?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $kelamin_l;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $kelamin_p;?></td>
							<td style="text-align:left;border:1px dashed #000; padding:3px;"><?php echo $alamat_kk;?></td>
							<td style="text-align:center;border:1px dashed #000; padding:3px;"><?php echo $data_rj['StatusKunjungan'];?></td>
							<td style="text-align:center;border:1px dashed #000; padding:3px;"><?php echo $data_rj['Asuransi'];?></td>
							<td style="text-align:center;border:1px dashed #000; padding:3px;"><?php echo $data_rj['PoliPertama'];?></td>
							<td style="text-align:left;border:1px dashed #000; padding:3px;"><?php echo $anamnesa;?></td>
							<td style="text-align:center;border:1px dashed #000; padding:3px;"><?php echo $data_dgs;?></td>
							<td style="text-align:left;border:1px dashed #000; padding:3px;"><?php echo $kodetindakan;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo rupiah($tarif);?></td>
							<td style="text-align:left;border:1px dashed #000; padding:3px;">
							<?php 
								if ($pemeriksa['NamaPegawai1'] != null){
									echo $pemeriksa['NamaPegawai1'].", ".$pemeriksa['NamaPegawai2'];
								}else{
									echo $pemeriksa['NamaPegawai2'];
								}
							?>
							</td>
						</tr>
						
				<?php
					}
				?>
				<tr>
					<td colspan = "13" style="font-size:14px; font-weight: bold; text-align:center; border:1px dashed #000; padding:3px;">TOTAL</td>
					<td colspan = "2"style="font-size:14px; font-weight: bold; text-align:right; border:1px dashed #000; padding:3px;">
						<?php
							$total_tdk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Tarif)AS Tarif
							FROM `tbtindakanpasiendetail` a
							JOIN `tbtindakan` b ON a.KodeTindakan = b.KodeTindakan
							JOIN `$tbpasienrj` c ON a.NoRegistrasi = c.NoRegistrasi
							WHERE SUBSTRING(a.`NoRegistrasi`,15,2) = '$bulan' AND 
							SUBSTRING(a.`NoRegistrasi`,13,2) = '$thn' AND 
							SUBSTRING(a.`NoRegistrasi`,1,11)='$kodepuskesmas' AND
							SUBSTRING(c.`Asuransi`,1,4) <> 'BPJS'"));
							$total = $total_tdk['Tarif'];
							echo rupiah($total);
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>