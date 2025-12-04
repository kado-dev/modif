<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>REGISTER ISPA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Ispa_Harian_Kukarkab"/>
						<div class="col-sm-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-sm-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-sm-2">
							<select name="kasus" class="form-control">
								<option value="semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Kasus</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Ispa_Harian" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Ispa_Harian_Kukarkab_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
	<?php
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kasus = $_GET['kasus'];
	if(isset($keydate1) and isset($keydate2)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER ISPA</b></span><br>
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
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="5%">TGL.PERIKSA</th>
							<th rowspan="2" width="5%">NO.INDEX</th>
							<th rowspan="2">NAMA PASIEN</th>
							<th rowspan="2">ALAMAT</th>
							<th colspan="2">KUNJUNGAN</th>
							<th colspan="2">UMUR</th>
							<th rowspan="2">FREKUENSI NAFAS</th>
							<th colspan="3">KLASIFIKASI</th>
							<th colspan="2">TINDAK LANJUT</th>
							<th colspan="2">ANTIBIOTIK</th>
							<th colspan="3">KONDISI SAAT KUNJ.ULANG</th>
							<th rowspan="2">KET.MENINGGAL</th>
							<th colspan="2">ISPA(>5 TH)</th>
							<th rowspan="2">KET.</th>
						</tr>
						<tr>
							<th>B</th>
							<th>L</th>
							<!--kelamin-->
							<th>L</th>
							<th>P</th>
							<!--Klasifikasi-->
							<th>BBP</th>
							<th>P</th>
							<th>PB</th>
							<!--Tindak Lanjut-->
							<th>RJ</th>
							<th>RUJUK</th>
							<!--Antibiotik-->
							<th>YA</th>
							<th>TDK</th>
							<!--Kondisi Saat Kunj.Ulang-->
							<th>MEMBAIK</th>
							<th>TETAP</th>
							<th>MEMBURUK</th>
							<!--Kondisi Saat Kunj.Ulang--> 
							<th>BKN.PNEUMONIA</th>
							<th>PNEUMONIA</th>
						</tr>
						<tr>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th colspan="2">6</th>
							<th colspan="2">7</th>
							<th>8</th>
							<th colspan="3">9</th>
							<th colspan="2">10</th>
							<th colspan="2">11</th>
							<th colspan="3">12</th>
							<th>13</th>
							<th colspan="2">14</th>
							<th>15</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 100;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($kasus == "semua"){
							$qkasus = " ";
						}else{
							$qkasus = " AND `Kasus`='$kasus'";
						}
						
						$str = "SELECT * FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2' AND 
						(`KodeDiagnosa` like '%J10%' OR 
						`KodeDiagnosa` like '%J11%' OR 
						`KodeDiagnosa` = 'J12.2' OR 
						`KodeDiagnosa` = 'J12.8' OR 
						`KodeDiagnosa` = ' J12.9' OR 
						`KodeDiagnosa` = 'J15.8' OR 
						`KodeDiagnosa` = 'J15.9' OR 
						`KodeDiagnosa` = 'J18.0' OR 
						`KodeDiagnosa` = 'J18.8' OR 
						`KodeDiagnosa` = 'J18.9' OR 
						`KodeDiagnosa` = 'J39.9' OR 
						`KodeDiagnosa` like '%J00%' OR
						`KodeDiagnosa` like '%J02%' OR
						`KodeDiagnosa` = 'J03.9' OR
						`KodeDiagnosa` like '%J04%' OR
						`KodeDiagnosa` like '%J06%' OR
						`KodeDiagnosa` = 'J15.9' OR
						`KodeDiagnosa` = 'J20.9' OR
						`KodeDiagnosa` like '%J00%')".$qkasus; 
												
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						// echo $str;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_ispa = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query_ispa)){
							$no = $no + 1;
							$nocm = $data['NoCM'];
							$noindex = $data['NoIndex'];
							$noregistrasi = $data['NoRegistrasi'];
							$tanggaldiagnosa = $data['TanggalDiagnosa'];
							
							// tbkk
							$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`
							FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
							$alamat = strtoupper($dtkk['Alamat']).", RT.".$dtkk['RT'].", NO.".$dtkk['No']." ".strtoupper($dtkk['Kelurahan']);
							
							// tbpasienrj
							$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
							$namapasien = $datapasienrj['NamaPasien'];
							$kunjungan = $datapasienrj['StatusKunjungan'];
							$jeniskelamin = $datapasienrj['JenisKelamin'];
							$umurtahun = $datapasienrj['UmurTahun'];
							$umurbulan= $datapasienrj['UmurBulan'];
													
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
							
							// kelamin
							if($jeniskelamin == 'L'){
								if($datapasienrj['UmurTahun'] != '0'){
									$kelamin_l = $datapasienrj['UmurTahun']."Th";
								}else{
									$kelamin_l = $datapasienrj['UmurBulan']."Bl";
								}	
								$kelamin_p = '-';
							}else{
								if($datapasienrj['UmurTahun'] != '0'){
									$kelamin_p = $datapasienrj['UmurTahun']."Th";
								}else{
									$kelamin_p = $datapasienrj['UmurBulan']."Bl";
								}	
								$kelamin_l = '-';
							}
							
							// tbdiagnosaispa
							$data_ispa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosaispa` WHERE `NoRegistrasi` = '$noregistrasi'"));
							$klasifikasi = $data_ispa['Klasifikasi'];
							$ispa = $data_ispa['Ispa5tahun'];
							$frekuensinapas = $data_ispa['FrekuensiNafas'];						
							if ($frekuensinapas == ""){
								$frekuensinapas = '0';
							}else{
								$frekuensinapas = $frekuensinapas;
							}
							
							$klasifikasi = $data_ispa['Klasifikasi'];
							if ($klasifikasi == "Bukan Pneumonia"){
								$klasifikasi_bp = '<span class="fa fa-check"></span>';
							}elseif($klasifikasi == "Pneumonia"){
								$klasifikasi_p = '<span class="fa fa-check"></span>';
							}elseif($klasifikasi == "Pneumonia Berat"){
								$klasifikasi_pb = '<span class="fa fa-check"></span>';
							}else{
								$klasifikasi_bp = '-';
								$klasifikasi_p = '-';
								$klasifikasi_pb = '-';
							}
							
							$tindaklanjut = $data_ispa['TindakLanjut'];
							if ($tindaklanjut == "Rawat Jalan"){
								$rawat_jalan = '<span class="fa fa-check"></span>';
							}elseif($klasifikasi == "Rujuk"){
								$rujuk = '<span class="fa fa-check"></span>';
							}else{
								$rawat_jalan = '-';
								$rujuk = '-';
							}
							
							// jika tarakan antibiotik dibuat tidak
							$antibiotik = $data_ispa['AntiBiotik'];
							if($antibiotik == 'Ya'){
								$antibiotik_ya = '<span class="glyphicon glyphicon-ok"></span>';
							}elseif($antibiotik == 'Tidak'){
								$antibiotik_tidak = '<span class="glyphicon glyphicon-ok"></span>';
							}else{
								$antibiotik_ya = "-";
								$antibiotik_tidak = "-";
							}
							
							$kondisi = $data_ispa['KondisiKujunganUlang'];
							if($kondisi == 'Membaik'){
								$membaik = '<span class="glyphicon glyphicon-ok"></span>';
							}elseif($kondisi == 'Tetap'){
								$tetap = '<span class="glyphicon glyphicon-ok"></span>';
							}elseif($kondisi == 'Memburuk'){
								$memburuk = '<span class="glyphicon glyphicon-ok"></span>';
							}else{
								$membaik = "-";
								$tetap = "-";
								$memburuk = "-";
							}
							
							$ketmeninggal = $data_ispa['KeteranganMeninggal'];
							if($ketmeninggal == ''){
								$ketmeninggal = "-";
							}else{
								$ketmeninggal = $data_ispa['KeteranganMeninggal'];
							}
							
							//cek diagnosa pasien
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
							
							if($data_dgs == 'J39.9' OR $data_dgs == 'J00' OR $data_dgs == 'J11' OR $data_dgs == 'J02.9' OR $data_dgs == 'J03.9' OR $data_dgs == ' J15.9' OR $data_dgs == 'J06' OR $data_dgs == 'J04' OR $data_dgs == 'J20.9'){
								$bukanpneumoni = $data_dgs;
							}else{
								$bukanpneumoni = "-";
							}
							
							if($data_dgs == 'J18.9'){
								$pneumoni = $data_dgs;
							}else{
								$pneumoni = "-";
							}
							
							
						
						?>
							<tr style="border:1px solid #000;">
								<td><?php echo $no;?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $tanggaldiagnosa;?></td>
								<td><?php echo substr($noindex,-10);?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $namapasien;?></td>
								<td style="border:1px solid #000; padding:3px;">
									<?php
										if($dtkk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
										}else{
											echo strtoupper($alamat);
										}
									?>
								</td>
								<td><?php echo $statuskunj_baru;?></td>
								<td><?php echo $statuskunj_lama;?></td>
								<td><?php echo $kelamin_l;?></td>
								<td><?php echo $kelamin_p;?></td>
								<td><?php echo $frekuensinapas?></td>
								<td><?php echo $klasifikasi_bp;?></td>
								<td><?php echo $klasifikasi_p;?></td>
								<td><?php echo $klasifikasi_pb;?></td>
								<td><?php echo $rawat_jalan;?></td>
								<td><?php echo $rujuk;?></td>
								<td><?php echo $antibiotik_ya;?></td>
								<td><?php echo $antibiotik_tidak;?></td>
								<td><?php echo $membaik;?></td>
								<td><?php echo $tetap;?></td>
								<td><?php echo $memburuk;?></td>
								<td><?php echo $ketmeninggal;?></td>
								<td><?php echo $bukanpneumoni;?></td>
								<td><?php echo $pneumoni;?></td>
								<td><?php echo $data_dgs;?></td>
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
						echo "<li><a href='?page=lap_P2M_Ispa_Harian_Kukarkab&keydate1=$keydate1&keydate2=$keydate2&kasus=$kasus&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b><br>
				- Pneumonia (J10, J11, J12.2, J12.9, J12.8, J15.8, J15.9, J18.0, J18.8, J18.9, J39.8)<br/>
				- Bukan Pneumonia > 5Th(J00, J02.9, J03.9, J04, J06, J11, J15.9, J20.9, J39.9)<br/>
				- Pneumonia > 5Th (J18.9)<br/>
				
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