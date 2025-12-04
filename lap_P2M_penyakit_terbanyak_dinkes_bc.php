<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PENYAKIT TERBANYAK</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_penyakit_terbanyak_dinkes"/>
						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:100px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:100px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
						<div class="col-sm-2 bulanformcari">
							<select name="bulan" class="form-control">
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
						<div class="col-sm-1 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="polipertama" class="form-control" required>
								<option value="Semua">--Semua--</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
									while($data = mysqli_fetch_assoc($query)){
										if($data['Pelayanan'] == $_GET['polipertama']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
										}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-sm-1">
							<input type="number" class="form-control" style="width:60px" name="limit" value="10">
						</div>
						<div class="col-sm-3">
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
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_terbanyak_dinkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$limit = $_GET['limit'];
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$polipertama = $_GET['polipertama'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if($bulan != null AND $tahun != null){
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
							<th width="30%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Nama Penyakit</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">L</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">P</th>
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
						
						if($polipertama == 'Semua'){
							$polipertamas = "";
						}else{
							$polipertamas = " AND `PoliPertama` = '$polipertama'";
						}	

						if($kodepuskesmas = 'semua'){
							$kodepuskesmas = "";
						}else{
							$kodepuskesmas = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas'";
						}			
						
						$str = "SELECT a.KodeDiagnosa, b.Diagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
								FROM `$tbdiagnosapasien` a 
								LEFT JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa 
								LEFT JOIN `$tbpasienrj` c ON a.NoRegistrasi = c.NoRegistrasi
								WHERE YEAR(a.TanggalDiagnosa) = '$tahun' AND a.KodeDiagnosa <> 'Z00.0'".$polipertamas.$kodepuskesmas."
								GROUP BY KodeDiagnosa 
								ORDER BY Jumlah DESC
								limit $mulai,$jumlah_perpage";
						// echo $str;
						// die();
						
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodediagnosa = $data['KodeDiagnosa'];
							$diagnosa = $data['Diagnosa'];
							if($_SESSION['kodepuskesmas'] == '-'){
								$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
										FROM `$tbdiagnosapasien` a 
										LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
										WHERE ".$kodepuskesmas." YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
										and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'L'"));
								$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
										FROM `$tbdiagnosapasien` a 
										LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
										WHERE ".$kodepuskesmas." YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
										and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'P'"));
							}else{
								$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
										FROM `$tbdiagnosapasien` a 
										LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
										WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
										and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'L'")); 
								$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
										FROM `$tbdiagnosapasien` a 
										LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
										WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
										and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'P'"));
							}
							$total = $jml_laki['Jumlah'] + $jml_perempuan['Jumlah'];
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $diagnosa;?></td>
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
		if($polipertama == 'Semua'){
			$polipertamas = "";
		}else{
			$polipertamas = " AND `PoliPertama` = '$polipertama'";
		}	

		if($kodepuskesmas = 'semua'){
			$kodepuskesmas = "";
		}else{
			$kodepuskesmas = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas'";
		}			
		
		$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		$tbpasienrj = 'tbpasienrj_'.$bulan;
		$str_penyakit = "SELECT a.KodeDiagnosa, b.Diagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
				FROM `$tbdiagnosapasien` a 
				LEFT JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa 
				LEFT JOIN `$tbpasienrj` c ON a.NoRegistrasi = c.NoRegistrasi
				WHERE YEAR(a.TanggalDiagnosa) = '$tahun' AND a.KodeDiagnosa <> 'Z00.0'".$polipertamas.$kodepuskesmas."
				GROUP BY KodeDiagnosa 
				ORDER BY Jumlah DESC
				LIMIT 0,10";
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