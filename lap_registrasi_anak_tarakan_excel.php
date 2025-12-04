<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Anak (".$hariini.").xls");
	if(isset($keydate1) and isset($keydate2)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER ANAK</b></h4>
	<p style="margin:1px; font-size: 16px;">
		<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
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
					<th width="7%" rowspan="2">TANGGAL</th>
					<th width="20%" rowspan="2">NAMA PASIEN - KK</th>
					<th width="3%" rowspan="2">L/P</th>
					<th width="15%" rowspan="2">ALAMAT</th>
					<th width="6%" colspan="2">UMUR THN</th>
					<th width="10%" colspan="4">VITAL SIGN</th>
					<th width="15%" rowspan="2">ANAMNESA</th>
					<th width="15%" rowspan="2">DIAGNOSA</th>
					<th width="15%" rowspan="2">THERAPY</th>
					<th width="5%" colspan="2">RUJUK</th>
					<th width="10%" rowspan="2">KET.</th>
				</tr>
				<tr>
					<th>0-4</th>
					<th>5-14</th>
					<th>TD</th>
					<th>BB/TB</th>
					<th>SUHU</th>
					<th>HR/RR</th>
					<th>YA</th>
					<th>TDK</th>
				</tr>
			</thead>
			<tbody style="font-size: 12px;">
				<?php				
				$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2' AND substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";					
				$str = "SELECT * FROM `tbpolianak` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi
				WHERE ".$waktu;
				$str2 = $str." ORDER BY a.`TanggalPeriksa` DESC, a.`NamaPasien` ASC";
				// echo ($str);
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kelamin = $data['JenisKelamin'];
					$kunjungan = $data['StatusKunjungan'];
					$tensi = $data['Sistole']."/".$data['Diastole'];
					$bbtb = $data['BeratBadan']."/".$data['TinggiBadan'];
					$suhu = $data['SuhuTubuh'];
					$hrrr = $data['DetakNadi']."/".$data['RR'];
					$therapy = $data['Terapi'];
					
					// tbpasienperpegawai
					$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
												
					// tbpasienrj
					$str_rj = "SELECT JenisKelamin, UmurTahun, PoliPertama, StatusPulang, Asuransi FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$kelamin = $data_rj['JenisKelamin'];
					
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `No` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					// tbdiagnosapasien
					$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					// resep
					$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
					$str_resep = "SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_resepdetail = mysqli_query($koneksi,$str_resep);
					
					// cek umur kelamin
					if($data_rj['UmurTahun'] < 5){
						$umur1 = $data_rj['UmurTahun']." TH";
					}else{
						$umur1 = "-";
					}	
					
					if($data_rj['UmurTahun'] >= 5){
						$umur2 = $data_rj['UmurTahun']." TH";
					}else{
						$umur2 = "-";
					}
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'];
					}else{
						$alamat = "-";
					}
					
					// cek rujukan
					$rujukan = $data_rj['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
					
					// cek diagnosa pasien
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
						$array_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa']."-".$data_diagnosa['Diagnosa'];
					}
					if ($array_diagnosa[$no] != ''){
						$data_dgs = implode(",", $array_diagnosa[$no]);
					}else{
						$data_dgs ="";
					}
					
					// cek resep
					$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
					while($data_resep = mysqli_fetch_array($query_resepdetail)){
						$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$data_resep[KodeBarang]'"));
						$array_resep[$no][] = $data_obat['NamaBarang'];
					}
					if ($array_resep[$no] != ''){
						$data_rsp = implode(",", $array_resep[$no]);
					}else{
						$data_rsp ="";
					}
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
						<td align="left">
							<?php 
								echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
								strtoupper($data_kk['NamaKK'])."<br/>".
								substr($noindex, -10)." - ".$data_rj['Asuransi']);
							?>
						</td>
						<td align="center"><?php echo $kelamin;?></td>
						<td align="left"><?php echo $alamat;?></td>
						<td align="left"><?php echo $umur1;?></td>
						<td align="left"><?php echo $umur2;?></td>
						<td align="center"><?php echo $tensi;?></td>
						<td align="center"><?php echo $bbtb;?></td>
						<td align="center"><?php echo $suhu;?></td>
						<td align="center"><?php echo $hrrr;?></td>
						<td align="left"><?php echo strtoupper($anamnesa);?></td>
						<td align="left"><?php echo strtoupper($data_dgs);?></td>
						<td align="left"><?php echo strtoupper($data_rsp);?></td>
						<td align="center"><?php echo $rujuklanjut;?></td>
						<td align="center"><?php echo $berobatjalan;?></td>
						<td align="left"><?php echo $pemeriksa;?></td>
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