<?php
	include "config/koneksi.php";
	include "config/helper.php";
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$bulan = date('m');
	$tahun = date('Y');	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$kodepuskesmas;
	$hariini = date('Y-m-d');
	
	$kunj_hari = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` WHERE TanggalRegistrasi = '$hariini'"));
	$kunj_bulan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'"));
	$kunj_tahun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'"));
	$dilayani = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND (Asuransi like '%BPJS%') AND `StatusPelayanan` = 'Sudah' GROUP BY NoCM"));

	// hitung kontak rate
	$dt_kr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`JumlahPeserta`) AS JumlahPeserta FROM `tbpuskesmasdetail`"));
	$jml_peserta = $dt_kr['JumlahPeserta'];
	$persentase = ($dilayani * 100)/$jml_peserta;
	
?>

<style>
.sidebars{
	background:#fff;
	border:1px solid #ddd;
	border-radius:5px;
	box-shadow:0px 0px 10px #bbb;
	padding:9px;
	display:block;
	color:#111;
	text-align:left;
	margin: 15px 0px;
}

@media screen and (max-width: 992px) {
	.sidebars{
		margin-bottom:20px;
	}
}
</style>
	<div class="container">
		<div class="row">
			<div class="col-md-12 mainmenu">
				<div class="row">
					<div class="col-md-3">
						<div class="kotaks">
							Kunjungan Hari Ini
							<br/>
							<span><?php echo rupiah($kunj_hari['Jumlah']);?></span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="kotaks">
							Kunjungan Bulan <?php echo nama_bulan(date('m'));?>
							<br/>
							<span><?php echo rupiah($kunj_bulan['Jumlah']);?></span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="kotaks">
							Kunjungan Tahun <?php echo date('Y');?>
							<br/>
							<span><?php echo rupiah($kunj_tahun['Jumlah']);?></span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="kotaks">
							Kontak Rate BPJS
							<br/>
							<span><?php echo rupiah($dilayani)." (".substr($persentase,0,4)." %)";?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="kotakgrafik">
						<h2>Grafik Kunjungan Pasien Hari Ini</h2>
						<canvas id="Grafik_Kunjungan" ></canvas>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="kotakgrafik">
						<h2>Grafik Penyakit Terbanyak Bulan <?php echo nama_bulan(date('m'));?></h2>
						<canvas id="Grafik_Penyakit" ></canvas>
					</div>
					<button type="button" onClick="showDetail()" class="btn btn-link" style="margin:8px 0px 5px; float:right;cursor:pointer">Detail Diagnosa</button>
				</div>
				<div class="detailgrafik col-lg-12" style="clear:both <?php if($_GET['stsdetail']=='false'){echo ";display:block";}else{echo ";display:none";}?>">
					<div class="sidebars">
						<div class="table-responsive">
							<table class=" table-striped table-condensed table-bordered" width="100%">
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
				</div>	
			</div>
		</div>
	</div>
	
<!--Grafik-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>


var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
var Grafik_Kunjungan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [<?php
			$hariini = date('Y-m-d');
			$str = "SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as kodepuskesmas, 
			COUNT(`NoRegistrasi`) as jml, kdprovider FROM `$tbpasienrj` 
			GROUP BY `TanggalRegistrasi`,`kodepuskesmas` 
			HAVING `TanggalRegistrasi` = '$hariini' order by jml DESC";
			$query1 = mysqli_query($koneksi,$str);
			while($data1=mysqli_fetch_assoc($query1)){
			$str12 = "SELECT NamaPuskesmas FROM tbpuskesmas WHERE KodePuskesmas = '$data1[kodepuskesmas]'";
			$puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,$str12)); 
				echo '"'.$puskesmas['NamaPuskesmas'].'", ';
				
			}
			?>],
		datasets: [{
			label: 'Kunjungan Puskesmas Hari Ini',
			data: [<?php
			$hariini = date('Y-m-d');
			$str2 = "SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as kodepuskesmas, COUNT(`NoRegistrasi`) as jml, kdprovider FROM `$tbpasienrj` GROUP BY `TanggalRegistrasi`,`kodepuskesmas` HAVING `TanggalRegistrasi` = '$hariini' order by jml DESC";
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