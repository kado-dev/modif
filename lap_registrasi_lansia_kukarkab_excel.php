<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = 'tbresepdetail_'.str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
	
	// filterdata
	$opsiform = $_GET['opsiform'];
	$keydate = $_GET['keydate'];
	$kunjungan = $_GET['kunjungan'];
	$kelompokumur = $_GET['kelompokumur'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Ruang_Lansia (".$hariini.").xls");
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
.str{
	mso-number-format:\@; 
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI LANSIA</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
		<?php } ?>
	</p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size: 8.5px;">
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="8%">TGL.</th>
					<th rowspan="2" width="8%">NIK</th>
					<th rowspan="2" width="5%">NO.RM</th>
					<th rowspan="2" width="10%">NAMA PASIEN</th>
					<th rowspan="2" width="10%">ALAMAT</th>
					<th rowspan="2">UMUR</th>
					<th colspan="5">DATA OBYEKTIF</th>
					<th colspan="5">P3G</th>
					<th rowspan="2">JAMINAN</th>
					<th colspan="2">TEKANAN</th>
					<th colspan="6">HASIL LABORAORIUM</th>
					<th colspan="2">RUJUK</th>
					<th rowspan="2" width="10%">DIAGNOSA</th>
					<th rowspan="2" width="10%">THERAPY</th>
					<th rowspan="2" width="10%">KET.</th>
				</tr>
				<tr>
					<th>JK</th>
					<th>BB</th>
					<th>TB</th>
					<th>LP</th>
					<th>IMT</th>
					<th>ADL</th>
					<th>R.JATUH</th>
					<th>GDS</th>
					<th>MME</th>
					<th>MNA</th>
					<th>NORMAL</th>
					<th>TINGGI</th>
					<th>GDP</th><!--Hasil Laboratorium-->
					<th>GDS</th>
					<th>KOLES</th>
					<th>AU</th>
					<th>HB</th>
					<th>PROTEIN</th>
					<th>RS</th><!--Rujuk-->
					<th>POLI</th>
				</tr>
			</thead>
			<tbody style="font-size: 10px">
				<?php
				if($kunjungan == 'Baru'){
					$status_kunj = " AND b.StatusKunjungan = 'Baru'";
				}elseif ($kunjungan == 'Lama'){
					$status_kunj = " AND b.StatusKunjungan = 'Lama'";
				}else{
					$status_kunj = " ";
				}
				
				if($kelompokumur == 'Pralansia (45 s/d 59)'){
					$status_umur = " AND b.UmurTahun BETWEEN '45' AND '59'";
				}elseif ($kelompokumur == 'Lansia (>60)'){
					$status_umur = " AND b.UmurTahun BETWEEN '60' AND '100'";
				}else{
					$status_umur = " ";
				}
				
				if($opsiform == 'bulan'){
					$str = "SELECT * FROM `$tbpolilansia`
					WHERE  MONTH(TanggalPeriksa) = '$bulan' and YEAR(TanggalPeriksa) = '$tahun' and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'"
					.$status_kunj.$status_umur;
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC";
				}else{
					$str = "SELECT * FROM `$tbpolilansia` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
					$str2 = $str."ORDER BY `NoPemeriksaan` DESC";
				}
				// echo ($str);
				// die();				
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$anamnesa = $data['Anamnesa'];
					$kunjungan = $data['StatusKunjungan'];
					$sistole = $data['Sistole'];
					$diastole = $data['Diastole'];
					$BB = $data['BeratBadan'];
					$TB = $data['TinggiBadan'];
					$LP = $data['LingkarPerut'];
					$IMT = $data['Imt'];
					$status_td = $data['StatusTekananDarah'];
					$adl = $data['Adl'];
					$resikojatuh = $data['ResikoJatuh'];
					$gds = $data['Gds'];
					$mme = $data['Mme'];
					$mna = $data['Mna'];
					$gdplab = $data['GdpLab'];
					$gdslab = $data['GdsLab'];
					$koleslab = $data['KolesLab'];
					$aulab = $data['AuLab'];
					$hblab = $data['HbLab'];
					$protlab = $data['ProtLab'];
					
					// tbpasienperpegawai
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					// tbpasienrj
					$str_rj = "SELECT NoRM, JenisKelamin, UmurTahun, PoliPertama, StatusPulang, Asuransi, nokartu FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$norm = substr($data_rj['NoRM'],-8);
					$kelamin = $data_rj['JenisKelamin'];
					$umur = $data_rj['UmurTahun']." th";
					$asuransi = $data_rj['Asuransi'];
					$nokartu = $data_rj['nokartu'];
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", DS.".$data_kk['Kelurahan'];
					}else{
						$alamat = "-";
					}
					
					// tbpasien
					$str_pasien = "SELECT `Nik` FROM `$tbpasien` WHERE `NoCM` = '$nocm'";
					$query_pasien = mysqli_query($koneksi,$str_pasien);
					$data_pasien = mysqli_fetch_assoc($query_pasien);
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT a.`KodeDiagnosa`, b.Diagnosa FROM `$tbdiagnosapasien` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa  WHERE a.`NoRegistrasi` = '$noregistrasi'";
					// echo $str_diagnosapsn;
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);						
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['Diagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="-";
					}
					// echo $data_dgs;
					
					// therapy 
					$str_therapy = "SELECT a.`KodeBarang`, b.`NamaBarang` FROM `$tbresepdetail` a 
					JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.`NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi,$str_therapy);
					while($data_therapy = mysqli_fetch_array($query_therapy)){
						$array_data_trp[$no][] = $data_therapy['NamaBarang'];
					}
					if ($array_data_trp[$no] != ''){
						$data_trp = implode(",", $array_data_trp[$no]);
					}else{
						$data_trp ="-";
					}
				?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalPeriksa'];?></td>
						<td class="str"><?php echo $data_pasien['Nik'];?></td>
						<td><?php echo $norm;?></td>
						<td><?php echo $data['NamaPasien'];?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $umur;?></td>
						<td><?php echo $kelamin;?></td>
						<td><?php echo $BB;?></td>
						<td><?php echo $TB;?></td>
						<td><?php echo $LP;?></td>
						<td><?php echo $IMT;?></td>
						<td><?php echo $adl;?></td><!--P3G-->
						<td><?php echo $resikojatuh;?></td>
						<td><?php echo $gds;?></td>
						<td><?php echo $mme;?></td>
						<td><?php echo $mna;?></td>
						<td><?php echo $asuransi."<br/>".$nokartu;?></td>
						<?php
							if($sistole == '' || $diastole == ''){
								$td_normal = '-';
								$td_tinggi = '-';
							}else{
								if($status_td == 'N'){
									$td_normal = $sistole."/".$diastole;
								}else{
									$td_normal = '-';
								}
								
								if($status_td == 'T'){
									$td_tinggi = $sistole."/".$diastole;
								}else{
									$td_tinggi = '-';
								}
							}
						?>
						<td><?php echo $td_normal;?></td><!--Tekanan Darah-->
						<td><?php echo $td_tinggi;?></td>
						<td><?php echo $gdplab;?></td><!--Hasil Laboratorium-->
						<td><?php echo $gdslab;?></td>
						<td><?php echo $koleslab;?></td>
						<td><?php echo $aulab;?></td>
						<td><?php echo $hblab;?></td>
						<td><?php echo $protlab;?></td>
						<td></td><!--Rujuk-->
						<td></td>
						<td><?php echo str_replace(",", ", ", $data_dgs);?></td>
						<td><?php echo $data_trp;?></td><!--Therapy-->
						<td><?php echo $pemeriksa;?></td>
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