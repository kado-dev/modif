<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
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
			<h3 class="judul"><b>REGISTER LANSIA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia_tarakan"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia_tarakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_lansia_tarakan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER LANSIA</b></span><br>
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
			</table>
		</div>
	</div>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<th width="12%" rowspan="2">TGL.PERIKSA</th>
							<th width="15%" rowspan="2">NAMA PASIEN - KK</th>
							<th width="8%" colspan="2">UMUR</th>
							<th width="10%" rowspan="2">ALAMAT</th>
							<th width="5%" rowspan="2">KUNJ.</th>
							<th width="8%" colspan="5">VITAL SIGN</th>
							<th width="10%" rowspan="2">ANAMNESA</th>
							<th width="5%" rowspan="2">DIAGNOSA</th>
							<th width="10%" rowspan="2">THERAPY</th>
							<th width="5%" colspan="2">RUJUK</th>
							<th width="8%" rowspan="2">KET.</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>TD</th>
							<th>BB</th>							
							<th>TB</th>							
							<th>SUHU</th>
							<th>HR/RR</th>
							<th>YA</th>
							<th>TDK</th>
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
						
						$waktu = "date(TanggalPeriksa) BETWEEN '$keydate1' AND '$keydate2'";
						$str = "SELECT * FROM `$tbpolilansia` 
						WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND ".$waktu;
						$str2 = $str."ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC LIMIT $mulai,$jumlah_perpage";
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
							$tensi = $data['Sistole']."/".$data['Diastole'];
							$bb = $data['BeratBadan'];
							$tb = $data['TinggiBadan'];
							$suhu = $data['SuhuTubuh'];
							$hrrr = $data['DetakNadi']."/".$data['RR'];
							$therapy = $data['Terapi'];
							$pemeriksa = $data['NamaPegawaiSimpan'];
							
							// tbpasienrj
							$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
							$querypasienrj = mysqli_query($koneksi, $strpasienrj);
							$datapasienrj = mysqli_fetch_assoc($querypasienrj);
							$kunjungan = $datapasienrj['StatusKunjungan'];
							$asuransi = $datapasienrj['Asuransi'];
							
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
								$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
								$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
							}
							if ($array_data[$no] != ''){
								$data_dgs = implode("<br/>", $array_data[$no]);
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
								$data_trp = implode("<br/>", $array_therapy[$no]);
							}else{
								$data_trp ="";
							}
							
						?>
							<tr style="border:1px solid #000;">
								<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']))." ".date('G:i:s', strtotime($data['TanggalPeriksa']));?></td>
								<td align="left">
									<?php 
										echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
										strtoupper($data_kk['NamaKK'])."<br/>".
										substr($noindex, -10)."<br/>".
										$asuransi);
									?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="left">
									<?php
										if($data_kk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
										}else{
											echo strtoupper($alamat);
										}
									?>
								</td>
								<td align="center"><?php echo strtoupper($kunjungan);?></td>
								<td align="center"><?php echo $tensi;?></td>
								<td align="center"><?php echo $bb;?></td>
								<td align="center"><?php echo $tb;?></td>
								<td align="center"><?php echo $suhu;?></td>
								<td align="center"><?php echo $hrrr;?></td>
								<td align="left"><?php echo $anamnesa;?></td>
								<td align="left"><?php echo strtoupper($data_dgs);?></td>
								<td align="left"><?php echo strtoupper($data_trp);?></td>
								<td align="center"><?php echo $rujuklanjut;?></td>
								<td align="center"><?php echo $berobatjalan;?></td>
								<td align="left"><?php echo strtoupper($pemeriksa);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
	<br/>
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
						echo "<li><a href='?page=lap_registrasi_lansia_tarakan&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>

