<?php
	session_start();
	include "config/helper_pasienrj.php";
	include_once('config/koneksi.php');
	// get data
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Rujukan (".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI RUJUKAN</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
		<?php } ?>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:35%; margin-bottom:10px;">	
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
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">NO.</th>
					<th width="10%" rowspan="2">TANGGAL</th>
					<th width="4%" rowspan="2">NO REG</th>
					<?php if($kota != 'KABUPATEN KUTAI KARTANEGARA'){?>
					<th width="6%" rowspan="2">NO.INDEX</th>
					<?php } ?>
					<th width="5%" rowspan="2">NO.RM</th>
					<th width="12%" rowspan="2">NAMA PASIEN</th>
					<th width="2%" rowspan="2">L/P</th>
					<th width="4%" rowspan="2">UMUR</th>
					<th width="12%" rowspan="2">ALAMAT</th>
					<th width="6%" rowspan="2">POLI</th>
					<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">CARA BAYAR / JAMINAN / ASURANSI</th>
					<th width="3%" rowspan="2">KUNJ.</th>
					<th width="5%" rowspan="2">KET</th>
				</tr>
				<tr>
					<th width="5%">JAMINAN</th>
					<th width="5%">NO.JAMINAN</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";	
					$str = "SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NoRegistrasi, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
					FROM `$tbpasienrj` WHERE ".$waktu." AND `StatusPulang`='4'";
					// echo $str;
				}else{
					$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
					$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
					$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($keydate1));
					$tbdiagnosapasien2 = 'tbdiagnosapasien_'.date('m', strtotime($keydate2));
					
					$str = "SELECT * FROM(
					SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
					FROM `$tbpasienrj`
					WHERE `StatusPulang`='4' AND ".$waktu."
					UNION
					SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
					FROM `$tbpasienrj2`
					WHERE `StatusPulang`='4' AND ".$waktu."
					) tbalias";
				}
				$str2 = $str." ORDER BY Tanggalregistrasi DESC";
				// echo $str2;
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$noregistrasi = $data['NoRegistrasi'];
					$nocm = $data['NoCM'];
					$asuransi = $data['Asuransi'];
					$nomorasuransi = $data['nokartu'];
				
					if(strlen($nocm) == 23){
						$thn = substr($data['NoCM'],12,4);
						$dt_nojaminan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoAsuransi FROM `$tbpasien` WHERE NoCM = '$nocm'"));
						$nocm = $dt_nojaminan['NoAsuransi'];
					}else{
						$nocm = $data['NoCM'];
					}
									
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan`, `Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi, $str_kk);
					$datakk = mysqli_fetch_assoc($query_kk);
					
					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
					if($dt_subdis['subdis_name'] != ''){
						$kelurahan = $dt_subdis['subdis_name'];
					}else{
						$kelurahan = $datakk['Kelurahan'];
					}

					// ec_districts
					$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
					if($dt_dis['dis_name'] != ''){
						$kecamatan = $dt_dis['dis_name'];
					}else{
						$kecamatan = $datakk['Kecamatan'];
					}

					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan);
					
					if($asuransi == 'BPJS PBI' || $asuransi == 'BPJS NON PBI' || $asuransi == 'KIS'){
						$noasuransi = $nomorasuransi;
					}else{
						$noasuransi = "0";
					}
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi' GROUP BY `KodeDiagnosa`";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
						$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode("<br/>", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoRegistrasi'],19);?></td>
						<?php if($kota != 'KABUPATEN KUTAI KARTANEGARA'){ ?>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if ($noindex == ''){
									echo $noindex = '0';
								}else{
									echo $noindex = substr($noindex,14);
								}
							?>
						</td>
						<?php } ?>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
									$norms = substr($data['NoRM'],-6);
								}elseif ($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
									$norms = substr($data['NoRM'],-6);
								}elseif ($_SESSION['kota'] == 'KABUPATEN BANDUNG'){
									$norms = substr($data['NoRM'],-6);
								}elseif ($_SESSION['kota'] == 'KOTA BANDUNG'){
									$norms = substr($data['NoRM'],-6);	
								}else{
									if(strlen($data['NoRM']) == 22){
										$norms = substr($data['NoRM'],-11);
									}elseif(strlen($data['NoRM']) == 20){
										$norms = substr($data['NoRM'],-9);
									}elseif(strlen($data['NoRM']) == 17){
										$norms = substr($data['NoRM'],-6);
									}elseif(strlen($data['NoRM']) == 19){
										$norms = substr($data['NoRM'],-8);
									}
								}
								echo $norms;
							?>
						</td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UmurTahun']."Th";?><!--, <?php echo $data['UmurBulan'];?> Bl,  <?php echo $data['UmurHari'];?> Hr--></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;">
							<?php 
								if ($noindex == ''){
									echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
								}else{
									echo $alamat;
								}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $noasuransi;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['StatusKunjungan'];?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>		
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