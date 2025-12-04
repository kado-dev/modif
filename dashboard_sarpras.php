<!doctype html>
<html lang="en">
<body>

<?php
	$bulan = date('m');
	$tahun = date('Y');	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$resep_hari = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdResep) As Jml FROM `tbresep` WHERE DATE(TanggalResep) = curdate() AND SUBSTRING(NoResep,1,11)='$kodepuskesmas'"));
	$resep_bulan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdResep) As Jml FROM `tbresep` WHERE MONTH(TanggalResep)='$bulan' AND YEAR(TanggalResep)='$tahun' AND SUBSTRING(NoResep,1,11)='$kodepuskesmas'"));
	$resep_tahun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdResep) As Jml FROM `tbresep` WHERE YEAR(TanggalResep)='$tahun' AND SUBSTRING(NoResep,1,11)='$kodepuskesmas'"));
?>

<style>
	.modalku{
		width: 1000px;
		height: 500px;
		position: fixed;
		left: 50%;
		margin-top: 30%;
		transform: translate(-50%, -50%);
	}	
</style>

<div class="row" style="margin-top:0px;">
	<a href="#" data-toggle="modal" data-target="#modaldistribusifaktur">
		<div class="col-sm-4">
			<div class="kotak_panel">
				<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
				<div class="font30"><?php echo rupiah($resep_hari['Jml']);?></div>
				<div>Data Apotek</div>
			</div>
		</div>
	</a>
	<a href="#" data-toggle="modal" data-target="#modaldistribusi">
		<div class="col-sm-4">
			<div class="kotak_panel">
				<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
				<div class="font30"><?php echo rupiah($resep_hari['Jml']);?></div>
				<div>Data Pirt</div>
			</div>
		</div>
	</a>
	<a href="#" data-toggle="modal" data-target="#modalpenerimaan">
		<div class="col-sm-4">
			<div class="kotak_panel">
				<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
				<div class="font30"><?php echo rupiah($resep_hari['Jml']);?></div>
				<div>Data Toko Obat</div>
			</div>
		</div>
	</a>

	<!--GrafikDistribusi Per-Poli-->
	<div class="col-lg-12 col-md-12">
		<div class="kotakgrafik" style="padding-bottom: 55px;">
			<canvas id="Grafik_KunjunganResep_PerPoli" height="300px"></canvas>
			<button type="button" class="btndetailgrafik_kunjunganresep btn btn-white" style="text-decoration:none; margin:10px -20px 0px; float:right; cursor:pointer">Detail Kunjungan</button>
		</div>
	
		<div class="hasilmodal"></div>

		<!--Tabel Pemakaian Obat-->
		<div class="detailgrafik_kunjunganresep" style="display: none; clear:both; padding-top:20px">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width='5%'>No.</td>
							<th width='15%'>Tanggal</td>
							<th width='40%'>Nama Pasien</td>
							<th width='15%'>Pelayanan</td>
							<th width='15%'>Jaminan</td>
							<th width='7%'>Aksi</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$str_obat = "SELECT TanggalResep, NamaPasien, Pelayanan, StatusBayar  FROM `tbresep` 
										GROUP BY NamaPasien, DATE(TanggalResep)
										HAVING DATE(TanggalResep)=curdate()
										ORDER BY IdResep DESC
										LIMIT 10";
						// echo $str_obat;
						
						$query_obat = mysqli_query($koneksi,$str_obat);
						while($data = mysqli_fetch_assoc($query_obat)){
							$no = $no +1;
							
							?>
							<tr>
								<td style="text-align:center;"><?php echo $no;?></td>
								<td style="text-align:center;"><?php echo $data['TanggalResep'];?></td>
								<td style="text-align:left;"><?php echo $data['NamaPasien'];?></td>
								<td style="text-align:center;"><?php echo $data['Pelayanan'];?></td>
								<td style="text-align:center;"><?php echo $data['StatusBayar'];?></td>
								<td style="text-align:center;">
									<button href="#" class="btnmodalkunjunganresep" class="btn btn-white">Lihat</button>
								</td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>	
	
	<!--GrafikDistribusi Per-Jaminan-->
	<div class="col-lg-12 col-md-12">
		<div class="kotakgrafik" style="padding-bottom: 55px;">
			<canvas id="Grafik_KunjunganResep_PerJaminan" height="300px"></canvas>
		</div>
	</div><br/>	
</div>
</body>
</html>	

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

$(".btndetailgrafik_kunjunganresep").click(function(){
	if ( $( ".detailgrafik_kunjunganresep" ).is( ":hidden" ) ) {
		$(".detailgrafik_kunjunganresep").slideDown();
	}else{
		$(".detailgrafik_kunjunganresep").slideUp();
	}
});

var ctx = document.getElementById("Grafik_KunjunganResep_PerPoli").getContext('2d');
var Grafik_KunjunganResep_PerPoli = new Chart(ctx, {
	type: 'line',
	data: {
		labels: [
				<?php
					$str_ds = "SELECT TanggalResep, SUBSTRING(NoResep,1,11) AS KodePuskesmas, Pelayanan, COUNT(IdResep) AS Jumlah FROM `tbresep` 
								GROUP BY KodePuskesmas, DATE(TanggalResep), Pelayanan
								HAVING DATE(TanggalResep)=curdate() AND SUBSTRING(KodePuskesmas,1,11)='$kodepuskesmas'
								ORDER BY Jumlah DESC
								LIMIT 10";
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['Pelayanan'].'", ';
					}
				?>
				],
		datasets: [{
			label: 'Kunjungan Resep <?php echo tgl_lengkap(date("Y-m-d"))?> (Per-Pelayanan / Poli)',
			data:[
				<?php
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['Jumlah'].'", ';
					}			
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_obat); $i++){
				?>
					'rgba(211, 255, 222, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_obat); $i++){
			?>
				'rgba(98, 201, 124, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2.5
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		tooltips: {
		   mode: 'label',
		   label: 'mylabel',
		   callbacks: {
			   label: function(tooltipItem, data) {
				   return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

var ctx = document.getElementById("Grafik_KunjunganResep_PerJaminan").getContext('2d');
var Grafik_KunjunganResep_PerJaminan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$str_ds = "SELECT TanggalResep, SUBSTRING(NoResep,1,11) AS KodePuskesmas, StatusBayar, COUNT(IdResep) AS Jumlah FROM `tbresep` 
								GROUP BY KodePuskesmas, DATE(TanggalResep), StatusBayar
								HAVING DATE(TanggalResep)=curdate() AND SUBSTRING(KodePuskesmas,1,11)='$kodepuskesmas'
								ORDER BY Jumlah DESC
								LIMIT 10";
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['StatusBayar'].'", ';
					}
				?>
				],
		datasets: [{
			label: 'Kunjungan Resep <?php echo tgl_lengkap(date("Y-m-d"))?> (Per-Jaminan)',
			data:[
				<?php
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['Jumlah'].'", ';
					}			
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_obat); $i++){
				?>
					'rgba(204, 236, 255, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_obat); $i++){
			?>
				'rgba(83, 159, 204, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2.5
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		tooltips: {
		   mode: 'label',
		   label: 'mylabel',
		   callbacks: {
			   label: function(tooltipItem, data) {
				   return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
		},
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
