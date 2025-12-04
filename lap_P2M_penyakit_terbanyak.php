<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Penyakit Terbanyak</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_penyakit_terbanyak"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-4 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
							</div>
						</div>	
						<div class="col-xl-2 bulanformcari">
							<select name="bulan" class="form-control">
								<option value="semua" <?php if($_GET['bulan'] == 'semua'){echo "SELECTED";}?>>Semua</option>
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<!--<div class="col-xl-3">
							<select name="polipertama" class="form-control" required>
								<option value="Semua">--Semua--</option>
								<?php
								// $query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
								// 	while($data = mysqli_fetch_assoc($query)){
								// 		if($data['Pelayanan'] == $_GET['polipertama']){
								// 			echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
								// 		}else{
								// 			echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
								// 		}
								// 	}
								?>
							</select>
						</div>-->
						<div class="col-xl-1">
							<input type="number" class="form-control" name="limit" value="10">
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_terbanyak" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_penyakit_terbanyak_excel.php?opsiform=<?php echo $_GET['opsiform'];?>bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$limit = $_GET['limit'];
	$polipertama = $_GET['polipertama'];

	if($bulan != null AND $tahun != null){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENYAKIT TERBANYAK</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d')." ".nama_bulan($bulan)." ".$tahun;?></span>
			<br/>
		</div>

		<div class = "row">
			<div class="col-sm-12 table-responsive">
				<table class="table-judul">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="5%">NO.</th>
							<th width="10%">KODE</th>
							<th width="30%">NAMA PENYAKIT</th>
							<th width="10%">L</th>
							<th width="10%">P</th>
							<th width="10%">JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(isset($_GET['limit'])){
							$jumlah_perpage = $_GET['limit'];
						}else{
							$jumlah_perpage = 10;
						}
						
						$mulai=0;
						$kasus = $_GET['kasus'];
						
						if($opsiform == 'bulan'){
							if($_GET['bulan'] == 'semua'){
								$str = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
									FROM `$tbdiagnosapasien` 
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'
									GROUP BY KodeDiagnosa 
									ORDER BY Jumlah DESC
									LIMIT $mulai,$jumlah_perpage";
							}else{
								$str = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
									FROM `$tbdiagnosapasien` 
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa <> 'Z00.0'
									GROUP BY KodeDiagnosa 
									ORDER BY Jumlah DESC
									LIMIT $mulai,$jumlah_perpage";			
							}
						}else{
							$waktu = "date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'";
							$str = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
									FROM `$tbdiagnosapasien` 
									WHERE ".$waktu." AND KodeDiagnosa <> 'Z00.0'
									GROUP BY KodeDiagnosa 
									ORDER BY Jumlah DESC
									LIMIT $mulai,$jumlah_perpage";
						}							
						// echo $str;
						// die();
						
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodediagnosa = $data['KodeDiagnosa'];
							
							// diagnosa
							$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kodediagnosa'"));
							
							if($opsiform == 'bulan'){
								if($_GET['bulan'] == 'semua'){
									$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
											FROM `$tbdiagnosapasien` 
											WHERE YEAR(TanggalDiagnosa)='$tahun'
											and KodeDiagnosa = '$kodediagnosa' and JenisKelamin = 'L'")); 
									$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
											FROM `$tbdiagnosapasien`
											WHERE YEAR(TanggalDiagnosa)='$tahun'
											and KodeDiagnosa = '$kodediagnosa' and JenisKelamin = 'P'"));
								}else{	
									$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
											FROM `$tbdiagnosapasien` 
											WHERE YEAR(TanggalDiagnosa)='$tahun' and MONTH(TanggalDiagnosa)='$bulan'
											and `KodeDiagnosa` = '$kodediagnosa' and `JenisKelamin` = 'L'")); 
									$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
											FROM `$tbdiagnosapasien` 
											WHERE YEAR(TanggalDiagnosa)='$tahun' and MONTH(TanggalDiagnosa)='$bulan'
											and `KodeDiagnosa` = '$kodediagnosa' and `JenisKelamin` = 'P'"));
								}
							}else{
								$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
										FROM `$tbdiagnosapasien` 
										WHERE date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'
										and KodeDiagnosa = '$kodediagnosa' and JenisKelamin = 'L'")); 
								$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
										FROM `$tbdiagnosapasien`
										WHERE date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'
										and KodeDiagnosa = '$kodediagnosa' and JenisKelamin = 'P'"));
							}
							$total = $jml_laki['Jumlah'] + $jml_perempuan['Jumlah'];
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo strtoupper($dtdiagnosa['Diagnosa']);?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jml_laki['Jumlah'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jml_perempuan['Jumlah'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/>
			</div>
		</div>
		
		<div class="kotakgrafik">
			<div class="au-card-inner">
				<canvas id="Grafik_Penyakit" height="270px"></canvas>
			</div>
		</div>
	</div>

	<?php
	}
	?>
</div>	

	<!--grafik 3D-->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<!--end grafik 3D-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/chartjsorg.js"></script>
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
	
	// Grafik Penyakit
	<?php
		
		if($opsiform == 'bulan'){
			if($_GET['bulan'] == 'semua'){
				$str_penyakit = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
				FROM `$tbdiagnosapasien` 
				WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'
				GROUP BY KodeDiagnosa 
				ORDER BY Jumlah DESC
				LIMIT 0,10";	
			}else{
				$str_penyakit = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
				FROM `$tbdiagnosapasien`
				WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa <> 'Z00.0'
				GROUP BY KodeDiagnosa 
				ORDER BY Jumlah DESC
				LIMIT 0, 10";			
			}
		}else{
			$waktu = "date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'";
			$str_penyakit = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
					FROM `$tbdiagnosapasien` 
					WHERE ".$waktu." AND KodeDiagnosa <> 'Z00.0'
					GROUP BY KodeDiagnosa 
					ORDER BY Jumlah DESC
					LIMIT 0, 10";
		}
	?>

	var ctx = document.getElementById("Grafik_Penyakit").getContext('2d');
	var Grafik_Penyakit = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [
					<?php
						$query_penyakit= mysqli_query($koneksi, $str_penyakit) or die(mysqli_error());
						while($ambil = mysqli_fetch_array($query_penyakit)){
							$kodediagnosa = $ambil['KodeDiagnosa'];
							$str_diagnosa = "SELECT `KodeDiagnosa`,`Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$kodediagnosa'";
							$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
							$dt_diagnosa = mysqli_fetch_assoc($query_diagnosa);
							echo '"'.$dt_diagnosa['KodeDiagnosa'].'", ';
						}
					?>
					],
			datasets: [{
				label: '10 Penyakit Terbanyak Bulan <?php echo nama_bulan(date('m'));?>',
				data:[
					<?php
						$query_penyakit= mysqli_query($koneksi,$str_penyakit) or die(mysqli_error());
						while($ambil = mysqli_fetch_array($query_penyakit)){
							$kodediagnosa = $ambil['KodeDiagnosa'];
							$str_diagnosa = "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$kodediagnosa'";
							$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
							$dt_diagnosa = mysqli_fetch_assoc($query_diagnosa);
							echo '"'.$ambil['Jumlah'].'", ';
						}			
					?>
					],
					backgroundColor: [
					<?php
					for($i =0; $i < mysqli_num_rows($query_penyakit); $i++){
					?>
						'rgba(175, 238, 247, 0.3)',
					<?php
					}
					?>	
					],
				borderColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_penyakit); $i++){
				?>
					'rgba(114, 211, 224, 1)',
				<?php
				}
				?>
				],
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
	</script>
	