<div class="tableborderdiv">
	<?php
		$bulan = date('m');
		$tahun = date('Y');	
		$resep_hari = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdResep) As Jml FROM `tbresep` WHERE DATE(TanggalResep) = curdate()"));
		$resep_bulan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdResep) As Jml FROM `tbresep` WHERE MONTH(TanggalResep)='$bulan' AND YEAR(TanggalResep)='$tahun'"));
		$resep_tahun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdResep) As Jml FROM `tbresep` WHERE YEAR(TanggalResep)='$tahun'"));
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

	<div class="row">
		<a href="#" data-toggle="modal" data-target="#modaldistribusifaktur">
			<div class="col-sm-4">
				<div class="kotak_panel">
					<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
					<div class="font30"><?php echo rupiah($resep_hari['Jml']);?></div>
					<div>Kunjungan Resep Hari Ini</div>
				</div>
			</div>
		</a>
		<a href="#" data-toggle="modal" data-target="#modaldistribusi">
			<div class="col-sm-4">
				<div class="kotak_panel">
					<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
					<div class="font30"><?php echo rupiah($resep_bulan['Jml']);?></div>
					<div class="headinglogin">Kunjungan Resep Bulan <?php echo nama_bulan(date('m'));?></div>
				</div>
			</div>
		</a>
		<a href="#" data-toggle="modal" data-target="#modalpenerimaan">
			<div class="col-sm-4">
				<div class="kotak_panel">
					<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
					<div class="font30"><?php echo rupiah($resep_tahun['Jml']);?></div>
					<div class="headinglogin">Kunjungan Resep Tahun <?php echo date('Y');?></div>
				</div>
			</div>
		</a>
	</div>

	<!--GrafikDistribusi PerPuskesmas-->
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="kotakgrafik" style="padding-bottom: 55px;">
				<canvas id="Grafik_KunjunganResep_PerPuskesmas" height="300px"></canvas>
				<button type="button" class="btndetailgrafik_kunjunganresep btn btn-white" style="text-decoration:none; margin:10px -20px 0px; float:right; cursor:pointer">Detail Distribusi</button>
			</div>
		</div>
	</div><br/>
	<div class="hasilmodal"></div>
	<!--Tabel Pemakaian Obat-->
	<div class="detailgrafik_kunjunganresep" style="display:none;clear:both">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width='5%'>No.</td>
						<th width='10%'>Kode</td>
						<th width='63%'>Nama Puskesmas</td>
						<th width='15%'>Kunjungan Resep</td>
						<th width='7%'>Aksi</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					$str_obat = "SELECT TanggalResep, SUBSTRING(NoResep,1,11) AS KodePuskesmas, COUNT(IdResep) AS Jumlah FROM `tbresep` 
									GROUP BY KodePuskesmas, DATE(TanggalResep)
									HAVING DATE(TanggalResep)=curdate()
									ORDER BY Jumlah DESC
									LIMIT 10";
					// echo $str_obat;
					
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$kodepkm = $data['KodePuskesmas'];
						$jumlahs = $data['Jumlah'];
						$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepkm'"));
						?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:center;" class="kodepkm"><?php echo $kodepkm;?></td>
							<td style="text-align:left;"><?php echo $dtpuskesmas['NamaPuskesmas'];?></td>
							<td style="text-align:right;"><?php echo rupiah($jumlahs);?></td>
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

	var ctx = document.getElementById("Grafik_KunjunganResep_PerPuskesmas").getContext('2d');
	var Grafik_KunjunganResep_PerPuskesmas = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [
					<?php
						$str_ds = "SELECT TanggalResep, SUBSTRING(NoResep,1,11) AS KodePuskesmas, COUNT(IdResep) AS Jumlah FROM `tbresep` 
									GROUP BY KodePuskesmas, DATE(TanggalResep)
									HAVING DATE(TanggalResep)=curdate()
									ORDER BY Jumlah DESC
									LIMIT 10";
						$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
						while($ambil = mysqli_fetch_array($query_ds)){
							$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$ambil[KodePuskesmas]'"));
							echo '"'.$dtpuskesmas['NamaPuskesmas'].'", ';
						}
					?>
					],
			datasets: [{
				label: 'Kunjungan Resep Hari Ini (Per-Puskesmas)',
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
				borderWidth: 2
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
</div>	