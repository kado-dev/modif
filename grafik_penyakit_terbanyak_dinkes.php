<?php
	include "config/helper_pasienrj.php";
	$tahuns = $_GET['tahun'];
	$bln = $_GET['bulan'];
	
	if($tahuns == null){
		$tahuns = date('Y');
	}
	
	if($bln == null){
		$bln = date('m');
		if(strlen($bln) == 1){
			$bln = "0".$bln;
		}
	}	
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PENYAKIT TERBANYAK</b></h3>
			<div class="formbg">
				<div class="row">
					<form role="form" class="submit">
						<input type="hidden" name="page" value="grafik_penyakit_terbanyak_dinkes"/>
						<div class=" col-sm-4">
							<select name="bulan" class="form-control">
								<option value="semua" <?php if($bln == 'semua'){echo "SELECTED";}?>>Semua</option>
								<option value="01" <?php if($bln == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($bln == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($bln == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($bln == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($bln == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($bln == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($bln == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($bln == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($bln == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($bln == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($bln == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($bln == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($tahuns == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` ORDER BY `NamaPuskesmas`");
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
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=grafik_penyakit_terbanyak_dinkes&bulan=<?php echo $bln;?>&tahun=<?php echo $tahuns;?>" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<div class ="row">
		<div class="col-sm-12" style="margin-top:-20px">
			<div class="kotakgrafik">
				<canvas id="Grafik_Penyakit" height="300px"></canvas>
			</div>
			<button type="button" class="btndetailgrafik btn btn-white" style="text-decoration:none;margin:8px 0px 5px; float:right;cursor:pointer">Detail Diagnosa</button>
		</div>
		<div class="detailgrafik col-lg-12" style="display:none;clear:both">
			<div class="sidebars">
				<div class="table-responsive">
					<table class=" table-judul" width="100%">
						<thead>
							<tr>
								<th width='5%'>No.</td>
								<th width='10%'>Kode ICD X</td>
								<th>Nama Diagnosa</td>
								<th width='10%'>Jumlah</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$kodepuskesmas = $_GET['kodepuskesmas'];
								if($kodepuskesmas == 'semua'){
									$puskesmas = " ";	
								}else{
									$puskesmas = " AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
								}	
							
								if($_GET['bulan'] == 'semua'){
									for($i = 1; $i<=12; $i++){
										if(strlen($i) == 2){
											$nn = $i;
										}else{
											$nn = "0".$i;
										}
										$tbdiagnosapasiens = 'tbdiagnosapasien_'.$nn;
										$strarr[] = "(SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as `Jumlahs` 
												FROM `$tbdiagnosapasiens` 
												WHERE YEAR(`TanggalDiagnosa`)='$tahuns' AND `KodeDiagnosa` <> 'Z00.0'".$puskesmas."
												GROUP BY KodeDiagnosa)";
									}		
									$str_penyakit = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, SUM(`Jumlahs`) as Jumlah FROM(".implode(" union all ",$strarr).") t_unions GROUP BY KodeDiagnosa ORDER BY Jumlah DESC limit 0,10";
								}else{
									$tbdiagnosapasiens = 'tbdiagnosapasien_'.$bln;
									$str_penyakit = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as Jumlah 
												FROM `$tbdiagnosapasiens` 
												WHERE YEAR(`TanggalDiagnosa`)='$tahuns' AND `KodeDiagnosa` <> 'Z00.0'".$puskesmas."
												GROUP BY KodeDiagnosa 
												ORDER BY Jumlah DESC 
												limit 0,10";	
								}	
								// echo $str_penyakit;
								$query_penyakit = mysqli_query($koneksi,$str_penyakit);
								while($dtpenyakit = mysqli_fetch_assoc($query_penyakit)){
									$no = $no +1;
									$kodediagnosa = $dtpenyakit['KodeDiagnosa'];
									$tbpenyakit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Diagnosa, KodeDiagnosa
									FROM `tbdiagnosabpjs`
									WHERE `KodeDiagnosa`='$kodediagnosa'"));
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
$(".btndetailgrafik").click(function(){
	if ( $( ".detailgrafik" ).is( ":hidden" ) ) {
		$(".detailgrafik").slideDown();
	}else{
		$(".detailgrafik").slideUp();
	}
});

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
			label: '10 Penyakit Terbanyak Bulan <?php echo nama_bulan($bln);?>',
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
