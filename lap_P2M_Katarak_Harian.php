<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER HARIAN KATARAK</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_Katarak_Harian"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-2">
							<select name="kasus" class="form-control">
								<option value="semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Kasus</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Katarak_Harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Katarak_Harian_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) and isset($keydate2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KATARAK</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
	</div><br/>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="10%">TANGGAL<br/>KUNJUNGAN</th>
							<th rowspan="2">NIK</th>
							<th rowspan="2">NAMA PASIEN</th>
							<th colspan="2" width="8%">UMUR</th>
							<th rowspan="2" width="20%">ALAMAT</th>
							<th colspan="5" width="8%">VITAL SIGN</th>
							<th rowspan="2" width="10%">ANAMNESA</th>
							<th rowspan="2" width="5%">DIAGNOSA</th>
							<th rowspan="2" width="10%">THERAPY</th>
							<th colspan="2">KUNJ.</th>
							<th rowspan="2">KET.</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th>L</th>
							<th>P</th>
							<!--vitalsign-->
							<th>TD</th>
							<th>BB</th>
							<th>TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
							<!--kunjungan-->
							<th>B</th>
							<th>L</th>
						</tr>
						<tr>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
							<th>16</th>
							<th>17</th>
							<th>18</th>
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
						
						$kasus = $_GET['kasus'];
						if($kasus == "semua"){
							$qkasus = " ";
						}else{
							$qkasus = " AND `Kasus`='$kasus'";
						}
						
						// tbdiagnosa_bulan
						$str = "SELECT * FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2' AND (`KodeDiagnosa` like '%H25%' OR `KodeDiagnosa` like '%H26%')".$qkasus; 
						$str2 = $str." GROUP BY `NoRegistrasi`,`KodeDiagnosa` LIMIT $mulai,$jumlah_perpage";
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_ispa = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query_ispa)){
							$no = $no + 1;
							$idpasienrj = $data['IdPasienrj'];
							$nocm = $data['NoCM'];
							$noregistrasi = $data['NoRegistrasi'];
							$tanggaldiagnosa = $data['TanggalDiagnosa'];
							
							// vital sign
							$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
							$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							$tensi = $dtvs['Sistole']."/".$dtvs['Diastole'];
							$bb = $dtvs['BeratBadan'];
							$tb = $dtvs['TinggiBadan'];
							$suhu = $dtvs['SuhuTubuh'];
							$hrrr = $dtvs['HeartRate']."/".$dtvs['RespiratoryRate'];
							
							// tbpasien
							$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
							$nik = $datapasien['Nik'];
							
							// tbpasienrj
							$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
							$noindex = $dt_pasienrj['NoIndex'];
							$kunjungan = $dt_pasienrj['StatusKunjungan'];
							$kelamin = $dt_pasienrj['JenisKelamin'];
							$pelayanan = $dt_pasienrj['PoliPertama'];

							// pelayanan
							if($pelayanan == 'POLI ANAK'){
								$polis = 'tbpolianak';
							}else if($pelayanan == 'POLI BERSALIN'){
								$polis = 'tbpolibersalin';
							}else if($pelayanan == 'POLI GIGI'){
								$polis = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
							}else if($pelayanan == 'POLI GIZI'){
								$polis = 'tbpoligizi';
							}else if($pelayanan == 'POLI HIV'){
								$polis = 'tbpolihiv';	
							}else if($pelayanan == 'POLI IMUNISASI'){
								$polis = 'tbpoliimunisasi';
							}else if($pelayanan == 'POLI ISOLASI'){
								$polis = 'tbpoliisolasi';	
							}else if($pelayanan == 'POLI KB'){
								$polis = 'tbpolikb';
							}else if($pelayanan == 'POLI KIA'){
								$polis = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
							}else if($pelayanan == 'POLI KIR'){
								$polis = 'tbpolikir';
							}else if($pelayanan == 'POLI LANSIA'){
								$polis = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
							}else if($pelayanan == 'POLI MTBS'){
								$polis = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
							}else if($pelayanan == 'POLI PANDU PTM'){
								$polis = 'tbpolipanduptm';
							}else if($pelayanan == 'POLI PROLANIS'){
								$polis = 'tbpoliprolanis';
							}else if($pelayanan == 'POLI INFEKSIUS'){
								$polis = 'tbpoliinfeksius';
							}else if($pelayanan == 'POLI SCREENING'){
								$polis = 'tbpoliscreening';		
							}else if($pelayanan == 'POLI SKD'){
								$polis = 'tbpoliskd';
							}else if($pelayanan == 'POLI TB DOTS'){
								$polis = 'tbpolitb';
							}else if($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
								$polis = 'tbpolitindakan';
							}else if($pelayanan == 'POLI UMUM'){
								$polis = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
							}else if($pelayanan == 'RAWAT INAP'){
								$polis = 'tbpolirawatinap';
							}else if($pelayanan == 'POLI LABORATORIUM'){
								$polis = 'tbpolilaboratorium';
							}else if($pelayanan == 'NURSING CENTER'){
								$polis = 'tbpolinursingcenter';	
							}

							// select tbpoli
							if ($pelayanan == 'POLI KB'){
								$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan` = '$noregistrasi'");
								$polisemua = mysqli_fetch_assoc($querypolisemua);
							}else{
								$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `".$polis."` WHERE `NoPemeriksaan` = '$noregistrasi'");
								$polisemua = mysqli_fetch_assoc($querypolisemua);
							}

							// cek anamnesa
							$anamnesa = $polisemua['Anamnesa'];
							
							// cek umur kelamin
							if ($kelamin == 'L'){
								$umur_l = $dt_pasienrj['UmurTahun']." TH";
								$umur_p = "-";
							}else{
								$umur_l = "-";
								$umur_p = $dt_pasienrj['UmurTahun']." TH";
							}
							
							// tbkk
							$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
							
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

							// kunjungan baru dan lama
							if($kunjungan == 'Baru'){
								$statuskunj_baru = '<span class="fa fa-check"></span>';
							}else{
								$statuskunj_baru = "-";
							}
							
							if($kunjungan == 'Lama'){
								$statuskunj_lama = '<span class="fa fa-check"></span>';
							}else{
								$statuskunj_lama = "-";
							}
														
							// cek diagnosa pasien
							$str = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj'";
							$query = mysqli_query($koneksi,$str);
							
							while($data_diagnosapsn = mysqli_fetch_array($query)){
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
								$data_trp = implode("<br/>", $array_therapy[$no]);
							}else{
								$data_trp = "";
							}			
						
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $tanggaldiagnosa;?></td>
								<td align="center"><?php echo $nik;?></td>
								<td align="left">
									<?php 
										echo "<b>".strtoupper($dt_pasienrj['NamaPasien']."</b><br/>".
										strtoupper($datakk['NamaKK'])."<br/>".
										substr($noindex, -10)."<br/>".
										$dt_pasienrj['Asuransi']."<br/>".
										$dt_pasienrj['PoliPertama']);
									?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="left">
									<?php
										if($datakk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
										}else{
											echo strtoupper($alamat);
										}
									?>
								</td>
								<td align="center"><?php echo $tensi;?></td>
								<td align="center"><?php echo $bb;?></td>
								<td align="center"><?php echo $tb;?></td>
								<td align="center"><?php echo $suhu;?></td>
								<td align="center"><?php echo $hrrr;?></td>
								<td align="left"><?php echo strtoupper($anamnesa);?></td>
								<td align="left"><?php echo strtoupper($data_dgs);?></td>
								<td align="left"><?php echo strtoupper($data_trp);?></td>
								<td align="center"><?php echo $statuskunj_baru;?></td>
								<td align="center"><?php echo $statuskunj_lama;?></td>
								<td align="center"><?php echo $data_dgs;?></td>
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
						echo "<li><a href='?page=lap_P2M_Katarak_Harian&keydate1=$keydate1&keydate2=$keydate2&kasus=$kasus&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<p>
					<b>Kategori Kode Penyakit :</b><br>
					- Katarak Terkait Usia = H25<br/>
					- Katarak Lainnya = H26<br/>
				</p>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
$(document).ready(function(){
	if($(".opsiform").val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>