<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbpoliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
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
	display: none;
	
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
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
	display:none;
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

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER ISOLASI</b></h3>
			<div class="formbg">
				<form role="form">	
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_isolasi"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_isolasi" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_isolasi_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>	
	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];

	if(isset($keydate1) and isset($keydate2)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PELAYANAN ISOLASI</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
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
	</div>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TGL.PERIKSA</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.INDEX</th>
							<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PASIEN</th>
							<th colspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">UMUR</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ALAMAT</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KUNJ.</th>
							<th colspan="4" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">VITAL SIGN</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ANAMNESA</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">DIAGNOSA</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">THERAPY</th>
							<th colspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">RUJUK</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KET.</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">TD</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">BB/TB</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">SUHU</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">HR/RR</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">YA</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">TDK</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
						$str = "SELECT a.TanggalPeriksa, b.NamaPasien, a.Anamnesa, a.NoPemeriksaan, a.NoIndex, a.Sistole, a.Diastole, a.BeratBadan, a.TinggiBadan, a.SuhuTubuh, a.DetakNadi, a.RR, b.UmurTahun, b.JenisKelamin, b.StatusPulang, b.StatusKunjungan, b.Asuransi, c.NamaPegawai1, c.NamaPegawai2
						FROM `tbpoliisolasi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi
						WHERE ".$waktu;
						$str2 = $str."ORDER BY `NoPemeriksaan` DESC LIMIT $mulai,$jumlah_perpage";
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
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
								$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
							}
							if ($array_therapy[$no] != ''){
								$data_trp = implode(",", $array_therapy[$no]);
							}else{
								$data_trp ="";
							}
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex,-10);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">
									<?php 
										echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
										strtoupper($data_kk['NamaKK'])."<br/>".
										"CARA BAYAR : ".$data['Asuransi']);
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_l;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_p;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">
									<?php
										if($data_kk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
										}else{
											echo strtoupper($alamat);
										}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo strtoupper($kunjungan);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $tensi;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $bbtb;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $suhu;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $hrrr;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $anamnesa;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data_trp;?></td>
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
	</div>
	<br>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_registrasi_isolasi&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>

