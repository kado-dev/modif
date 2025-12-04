<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PENYAKIT TERBANYAK</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_penyakit_terbanyak_dinkes"/>
						<div class="col-xl-2">
							<select name="bulanawal" class="form-control">
								<option value="01" <?php if($_GET['bulanawal'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanawal'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanawal'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanawal'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanawal'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanawal'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanawal'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanawal'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanawal'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanawal'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanawal'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanawal'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="bulanakhir" class="form-control">
								<option value="01" <?php if($_GET['bulanakhir'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanakhir'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanakhir'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanakhir'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanakhir'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanakhir'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanakhir'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanakhir'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanakhir'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanakhir'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanakhir'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanakhir'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-1">
							<input type="number" class="form-control" style="width:60px" name="limit" value="10">
						</div>
						<div class="col-xl-2">
							<select name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
									echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
								}else{
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
							}
							?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_terbanyak_dinkes" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahun = $_GET['tahun'];
	$limit = $_GET['limit'];
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if($bulanawal != null AND $tahun != null){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENYAKIT TERBANYAK</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d')." ".nama_bulan($bulan)." ".$tahun;?></span>
			<br/>
		</div>
		<div class="row font10" style="margin-bottom: -20px;">
			<div class="col-sm-12">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Kode</th>
							<th width="40%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Nama Penyakit</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Jumlah</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						if(isset($_GET['limit'])){
							$jumlah_perpage = $_GET['limit'];
						}else{
							$jumlah_perpage = 10;
						}
						
						$mulai=0;
						$kasus = $_GET['kasus'];
						
						if($kodepuskesmas == 'semua'){
							$kodepuskesmas = "";
						}else{
							$kodepuskesmas = " AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
						}			
						
						if ($bulanawal == '01' AND $bulanakhir == '02'){
							$str = "SELECT KodeDiagnosa, SUM(Jumlah) AS Jumlah FROM(
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_01`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									UNION
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_02`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									) tbalias";
						}elseif ($bulanawal == '01' AND $bulanakhir == '03'){
							$str = "SELECT KodeDiagnosa, SUM(Jumlah) AS Jumlah FROM(
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_01`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									UNION
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_02`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									UNION
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_03`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									) tbalias";
						}elseif ($bulanawal == '04' AND $bulanakhir == '06'){
							$str = "SELECT KodeDiagnosa, SUM(Jumlah) AS Jumlah FROM(
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_04`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									UNION
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_05`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									UNION
									SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_06`								
									WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0'".$kodepuskesmas."
									GROUP BY KodeDiagnosa
									) tbalias";			
						}	
						$str2 = $str." GROUP BY KodeDiagnosa ORDER BY Jumlah DESC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						// die();
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodediagnosa = $data['KodeDiagnosa'];
							$total = $data['Jumlah'];
							
							// tbdiagnosabpjs`
							$dt_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kodediagnosa'"));
							
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $dt_diagnosa['Diagnosa'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo rupiah($total);?></td>
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
	
	<!--grafik 3D-->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<!--end grafik 3D-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/chartjsorg.js"></script>
	<script>	
	<!--Grafik Penyakit-->
	<?php
		// if($kodepuskesmas == 'semua'){
			// $kodepuskesmas = "";
		// }else{
			// $kodepuskesmas = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas'";
		// }			
			
		if ($bulanawal == '01' AND $bulanakhir == '02'){
			$str = "SELECT KodeDiagnosa, SUM(Jumlah) AS Jumlah FROM(
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_01`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					UNION
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_02`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					) tbalias GROUP BY KodeDiagnosa ";
		}elseif ($bulanawal == '01' AND $bulanakhir == '03'){
			$str = "SELECT KodeDiagnosa, SUM(Jumlah) AS Jumlah FROM(
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_01`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					UNION
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_02`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					UNION
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_03`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					) tbalias GROUP BY KodeDiagnosa ";
		}elseif ($bulanawal == '04' AND $bulanakhir == '06'){
			$str = "SELECT KodeDiagnosa, SUM(Jumlah) AS Jumlah FROM(
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_04`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					UNION
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_05`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					UNION
					SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah FROM `tbdiagnosapasien_06`								
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa <> 'Z00.0' ".$kodepuskesmas."
					GROUP BY KodeDiagnosa
					) tbalias GROUP BY KodeDiagnosa ";			
		}	
		$str_penyakit = $str." ORDER BY Jumlah DESC LIMIT 0,10";	
		// echo $str_penyakit;				
	?>
	var ctx = document.getElementById("Grafik_Penyakit").getContext('2d');
	var Grafik_Penyakit = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [
					<?php
						$query_penyakit= mysqli_query($koneksi,$str_penyakit) or die(mysqli_error());
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
	<?php
	}
	?>
</div>	