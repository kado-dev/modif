<?php
	$kota = $_SESSION['kota'];
	$puskesmas_online = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE Kota = '$kota' and TglPs = curdate() and NamaPuskesmas <> 'DINAS KESEHATAN'  and NamaPuskesmas <> 'UPTD FARMASI'"));
	$bulan = date('m');
	$tahun = date('Y');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	
	$kunj_hari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE date(TanggalRegistrasi)=curdate()"));
	$kunj_bulan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'"));
	$kunj_tahun = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'"));
?>

<style>
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-top: 15px;
		margin-bottom: 15px;
	}
	.bg{
		background: linear-gradient(0deg, rgba(178, 212, 255, 0.7), rgba(255, 255, 255, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.greens{
		background: linear-gradient(0deg, rgba(28, 126, 255, 0.9), rgba(0, 87, 201, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.fontpanel{
		font-size: 30px;
		color: #fff;
		font-weight: bold;
	}
	.fontpanel-min{
		font-size: 16px;
		color: #fff;
	}
</style>

<div class="tableborderdiv">
	<div class="row noprint" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
				<div class="row noprint">
					<div class="col-sm-4">
						<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_karcis">
							<div class="kotak_panel greens">
								<div class="fontpanel"><?php echo rupiah($kunj_hari['Jumlah']);?></div>
								<div class="fontpanel-min">Hari Ini</div>
								<div class="fontpanel-min">* Jumlah kunjungan pasien</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4">
						<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_kir">
							<div class="kotak_panel greens">				
								<div class="fontpanel"><?php echo rupiah($kunj_bulan['Jumlah']);?></div>
								<div class="fontpanel-min">Bulan <?php echo nama_bulan(date('m'));?></div>
								<div class="fontpanel-min">* Jumlah kunjungan pasien</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4">
						<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_tindakan">
							<div class="kotak_panel greens">	
							<div class="fontpanel"><?php echo rupiah($kunj_tahun['Jumlah']);?></div>
								<div class="fontpanel-min">Tahun <?php echo date('Y');?></div>
								<div class="fontpanel-min">* Jumlah kunjungan pasien</div>
							</div>	
						</a>	
					</div>
				</div>

				<!--Gragik kunjungan per-puskesmas-->
				<div class="au-card m-b-30">
					<div class="kotakgrafik">
						<div class="judul">Grafik Kunjungan Harian Pasien per-Puskesmas</div>
						<div><canvas id="Grafik_Kunjungan" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas></div>
					</div>
				</div>

				<!--Gragik penyakit terbanyak-->
				<div class="au-card m-b-30">
					<div class="kotakgrafik">
						<div class="judul">Grafik Penyakit Terbanyak Bulan <?php echo nama_bulan(date('m'));?></div>
						<div><canvas id="Grafik_Penyakit" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas></div>
					</div>	
					<button type="button" class="btndetailgrafik btn btn-round" style="margin:8px 0px 5px; float:right;cursor:pointer">Detail Diagnosa</button>
				</div>

				<div class="detailgrafik" style="display:none;clear:both">
					<div class="kotakgrafik">
						<div class="table-responsive">
							<table class="table-striped table-condensed table-bordered" width="100%">
								<thead>
									<tr>
										<th width='5%'>No.</td>
										<th width='10%'>Kode</td>
										<th>Nama Diagnosa</td>
										<th width='10%'>Jumlah</td>
									</tr>
								</thead>
								<tbody>
									<?php
									$str_penyakit = "SELECT TanggalDiagnosa, KodeDiagnosa, COUNT(KodeDiagnosa) as Jumlah 
										FROM `$tbdiagnosapasien` 
										WHERE YEAR(TanggalDiagnosa)='$tahun' 
										GROUP BY KodeDiagnosa 
										ORDER BY Jumlah DESC 
										limit 0,10";
									$query_penyakit = mysqli_query($koneksi,$str_penyakit);
									$no = 0 ;
									while($dtpenyakit = mysqli_fetch_assoc($query_penyakit)){
										$no = $no +1;
										$kodediagnosa = $dtpenyakit['KodeDiagnosa'];
										$tbpenyakit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Diagnosa, KodeDiagnosa from tbdiagnosabpjs where KodeDiagnosa = '$kodediagnosa'"));
										?>
										<tr>
											<td style="text-align:right;"><?php echo $no;?></td>
											<td style="text-align:center;"><?php echo $dtpenyakit['KodeDiagnosa'];?></td>
											<td><?php echo $tbpenyakit['Diagnosa'];?></td>
											<td style="text-align:right;"><?php echo rupiah($dtpenyakit['Jumlah']);?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>	
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>

<!--Grafik-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>
	$(".btndetailgrafik").click(function(){
		if ( $( ".detailgrafik" ).is( ":hidden" ) ) {
			$(".detailgrafik").slideDown();
		}else{
			$(".detailgrafik").slideUp();
		}
	});
	
	var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
	var Grafik_Kunjungan = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [
				<?php
				$hariini = date('Y-m-d');
				$str1 = "SELECT date(`TanggalRegistrasi`) as tglregis, SUBSTRING(NoRegistrasi, 1, 11) as kodepuskesmas, COUNT(`IdPasienrj`) as jml FROM `tbpasienrj` GROUP BY `tglregis`,`kodepuskesmas` HAVING `tglregis` = '$hariini' order by jml DESC";
				$query1 = mysqli_query($koneksi,$str1);
				while($data=mysqli_fetch_assoc($query1)){
				$str12 = "SELECT `NamaPuskesmas` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$data[kodepuskesmas]'";
				$puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,$str12)); 
					echo '"'.$puskesmas['NamaPuskesmas'].'", ';					
				}
				?>
				],
			datasets: [{
				label: 'Kunjungan Puskesmas Hari Ini',
				data: [<?php
				$hariini = date('Y-m-d');
				$str2 = "SELECT date(`TanggalRegistrasi`) as tglregis, SUBSTRING(NoRegistrasi, 1, 11) as kodepuskesmas, COUNT(`IdPasienrj`) as jml FROM `tbpasienrj` GROUP BY `tglregis`,`kodepuskesmas` HAVING `tglregis` = '$hariini' order by jml DESC";
				$query2 = mysqli_query($koneksi,$str2);
				while($data1=mysqli_fetch_assoc($query2)){
					echo $data1['jml'].', ';
				}
				?>],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query2); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
				borderColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query2); $i++){
				?>
					'rgba(114, 211, 224, 1)',
				<?php
				}
				?>
				],
				borderWidth: 2
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
	
	<!--Grafik Penyakit-->
	<?php
		$str_penyakit = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as Jumlah 
		FROM `$tbdiagnosapasien` 
		WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND `KodeDiagnosa` <> 'Z00.0'
		GROUP BY KodeDiagnosa 
		ORDER BY Jumlah DESC 
		limit 0,10";
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
				label: 'Penyakit Terbanyak Bulan <?php echo nama_bulan(date('m'));?>',
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
				borderWidth: 2
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

 