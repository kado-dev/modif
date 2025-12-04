<?php
	include "config/helper_pasienrj.php";
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Pelayanan Isolasi (".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI PASIEN ISOLASI</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p><br/>
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
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="5%">TGL.PERIKSA</th>
					<th rowspan="2" width="5%">NO.INDEX</th>
					<th rowspan="2" width="15%">NAMA PASIEN</th>
					<th colspan="2" width="8%">UMUR</th>
					<th rowspan="2" width="10%">ALAMAT</th>
					<th rowspan="2" width="5%">KUNJ.</th>
					<th colspan="4" width="8%">VITAL SIGN</th>
					<th rowspan="2" width="10%">ANAMNESA</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="10%">THERAPY</th>
					<th colspan="2" width="5%">RUJUK</th>
					<th rowspan="2" width="8%">KET.</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TD</th>
					<th>BB/TB</th>
					<th>SUHU</th>
					<th>HR/RR</th>
					<th>YA</th>
					<th>TDK</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
				$str = "SELECT a.TanggalPeriksa, b.NamaPasien, a.Anamnesa, a.NoPemeriksaan, a.NoIndex, a.Sistole, a.Diastole, a.BeratBadan, a.TinggiBadan, a.SuhuTubuh, a.DetakNadi, a.RR, b.UmurTahun, b.JenisKelamin, b.StatusPulang, b.StatusKunjungan, b.Asuransi, c.NamaPegawai1, c.NamaPegawai2
				FROM `tbpoliisolasi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi
				WHERE ".$waktu;
				$str2 = $str."ORDER BY `NoPemeriksaan` DESC";
				// echo $str2;
				// die();
				
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
					if($data['NamaPegawai1']!=''){
						$pemeriksa = $data['NamaPegawai1'];
					}else{
						$pemeriksa = $data['NamaPegawai2'];
					}
					
					// pasien
					if (strlen($noindex) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoIndex` = '$noindex'"));
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoAsuransi` = '$noindex'"));
					}
					
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data['UmurTahun']." Th";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data['UmurTahun']." Th";
					}
					
					// cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
					
					// cek diagnosa pasien
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
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
						<td><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
						<td><?php echo substr($noindex,-10);?></td>
						<td>
							<?php 
								echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
								strtoupper($data_kk['NamaKK'])."<br/>".
								"CARA BAYAR : ".$data['Asuransi']);
							?>
						</td>
						<td><?php echo $umur_l;?></td>
						<td><?php echo $umur_p;?></td>
						<td>
							<?php
								if($data_kk['Alamat'] == ''){
									echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
								}else{
									echo strtoupper($alamat);
								}
							?>
						</td>
						<td><?php echo strtoupper($kunjungan);?></td>
						<td><?php echo $tensi;?></td>
						<td><?php echo $bbtb;?></td>
						<td><?php echo $suhu;?></td>
						<td><?php echo $hrrr;?></td>
						<td><?php echo $anamnesa;?></td>
						<td><?php echo $data_dgs;?></td>
						<td><?php echo $data_trp;?></td>
						<td><?php echo $rujuklanjut;?></td>
						<td><?php echo $berobatjalan;?></td>
						<td><?php echo strtoupper($pemeriksa);?></td>
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