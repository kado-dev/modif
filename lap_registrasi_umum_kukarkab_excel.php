<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tanggal = date('Y-m-d');
	// filterdata
	$opsiform = $_GET['opsiform'];
	$keydate = $_GET['keydate'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Poli_Umum (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN UMUM</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydate;?></p>
		<?php } ?>
	</p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="6%">TGL.PERIKSA</th>
					<th rowspan="2" width="4%">NO.RM</th>
					<th rowspan="2" width="8%">NAMA PASIEN</th>
					<th rowspan="2" width="8%">ALAMAT</th>
					<th colspan="2" width="6%">UMUR</th>
					<th colspan="7" width="20%">VITAL SIGN</th>
					<th rowspan="2" width="5%">KODE ICD X</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="8%">THERAPY</th>
					<th rowspan="2" width="3%">RUJUK</th>
					<th rowspan="2" width="5%">ASURANSI</th>
					<th rowspan="2" width="5%">KUNJ.</th>
					<th rowspan="2" width="8%">KET.</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TD</th><!--Vitalsign-->
					<th>N</th>
					<th>S</th>
					<th>P</th>
					<th>BB</th>
					<th>TB</th>
					<th>LP</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($opsiform == 'bulan'){
					$str = "SELECT * FROM `$tbpoliumum`
					WHERE  MONTH(TanggalPeriksa) = '$bulan' and YEAR(TanggalPeriksa) = '$tahun' and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'"
					.$status_kunj.$status_umur;
					$str2 = $str." ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC";
				}else{
					$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($keydate));
					$tbpasienperpegawai='tbpasienperpegawai_'.date('m', strtotime($keydate));
					$str = "SELECT * FROM `$tbpoliumum` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
					$str2 = $str." ORDER BY `NoPemeriksaan` DESC, `NamaPasien` ASC";
				}
				// echo ($str2);
				// die();
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$norm = $data['NoRM'];
					$kelamin = $data['JenisKelamin'];
					$td = $data['Sistole']."/".$data['Diastole'];
					$rr = $data['RR'];
					$nadi = $data['DetakNadi'];
					$suhu = $data['SuhuTubuh'];
					$bb = $data['BeratBadan'];
					$tb = $data['TinggiBadan'];
					$lp = $data['LingkarPerut'];
					$asuransi = $data['Asuransi'];
				
					// tbpasienperpegawai
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					// tbpasienrj
					$str_rj = "SELECT `NoRM`, `JenisKelamin`, `UmurTahun`, `PoliPertama`, `StatusPulang`, `Asuransi`, `StatusKunjungan` FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$norm = substr($data_rj['NoRM'],-8);
					$kelamin = $data_rj['JenisKelamin'];
					$umur = $data_rj['UmurTahun']." Th";
					$asuransi = $data_rj['Asuransi'];
					$kunjungan = $data_rj['StatusKunjungan'];
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", DS.".$data_kk['Kelurahan'];
					}else{
						$alamat = "-";
					}				
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT a.`KodeDiagnosa`, b.Diagnosa FROM `$tbdiagnosapasien` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa  WHERE a.`NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);						
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['Diagnosa'];
						$array_data1[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="-";
					}
					
					if ($array_data1[$no] != ''){
						$kode_dgs = implode(",", $array_data1[$no]);
					}else{
						$kode_dgs ="-";
					}				
					
					//cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $umur;
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $umur;
					}
					
					//cek rujukan
					$rujukan = $data_rj['StatusPulang'];
					if ($rujukan == 3){
						$rujuk = 'Tidak';
					}else{
						$rujuk = 'Ya';
					}
					
					// therapy
					$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
						$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode(",", $array_therapy[$no]);
					}else{
						$data_trp ="";
					}
					
				?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalPeriksa'];?></td>
						<td><?php echo substr($norm,-8);?></td>
						<td><?php echo $data['NamaPasien'];?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $umur_l;?></td>
						<td><?php echo $umur_p;?></td>
						<td><?php echo $td;?></td><!--Vitalsign-->
						<td><?php echo $nadi;?></td>
						<td><?php echo $suhu;?></td>
						<td><?php echo $rr;?></td>
						<td><?php echo $bb;?></td>
						<td><?php echo $tb;?></td>
						<td><?php echo $lp;?></td>
						<td><?php echo str_replace(",", ", ", $kode_dgs);?></td>
						<td><?php echo str_replace(",", ", ", $data_dgs);?></td>
						<td><?php echo $data_trp;?></td>
						<td><?php echo $rujuk;?></td>
						<td><?php echo $asuransi;?></td>
						<td><?php echo $kunjungan;?></td>
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