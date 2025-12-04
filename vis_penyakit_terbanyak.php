<?php
	include "main_menu.php";
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$tahun =date('Y');
	$bulan =date('m');
?>

<div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Grafik Penyakit Terbanyak</h4>
		</div>
		<div class="panel-body">
			<div id="container" style="min-width: 200px; height: 420px; margin: 0 auto"></div>
			<div class="text-right">
				<a href="#" class="btngrafikdetail">View Details <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>

<?php
	$str = "SELECT a.KodeDiagnosa AS Kode, b.NamaDiagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
			FROM tbdiagnosapasien a INNER JOIN tbdiagnosa b ON a.KodeDiagnosa = b.KodeDiagnosaBpjs 
			where MONTH(a.TanggalDiagnosa) = '$bulan' AND YEAR(a.TanggalDiagnosa) = '$tahun' 
			GROUP BY Kode 
			ORDER BY Jumlah DESC 
			limit 0, 10";
	// echo $str;
	// die();
?>
	<!--grafik 3D-->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<!--end grafik 3D-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/plugins/morris/raphael.min.js"></script>
    <script src="assets/js/plugins/morris/morris.min.js"></script>
	<script>
	
	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'column',
			options3d: {
				enabled: true,
				alpha: 15,
				beta: 15,
				depth: 50,
				viewDistance: 25
			}
		},
		title: {
			text: 'Grafik Penyakit Terbanyak'
		},
		subtitle: {
			text: '(10 Besar Penyakit)'
		},
		xAxis: {
			categories: ['Penyakit']
		 },
		yAxis: {
			title: {
			   text: 'Jumlah'
			}
		 },
		plotOptions: {
			column: {
				depth: 25
			}
		},
		series: [
			<?php			
				$query = mysqli_query($koneksi,$str);
				while($ambil = mysqli_fetch_array($query)){
			?>
			{
				name: '<?php echo $ambil['NamaDiagnosa'];?>',
				data: [<?php echo $ambil['Jumlah'];?>]
			},
			<?php 
			} 
			?>
		]
	});
	</script>

<div class="row grafikdetail hidden">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Data Penyakit Terbanyak</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive" style="font-size:12px">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th style="font-size:12px;">Kode</th>
								<th style="font-size:12px;">Nama Penyakit</th>
								<th style="font-size:12px;">Jumlah</th>
								
							</tr>
						</thead>
						<!--tbpasienrj-->
						<tbody font="8">
							<!--paging-->
							<?php
							$query = mysqli_query($koneksi,$str);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;

							?>
								<tr>
									<td><?php echo $data['Kode'];?></td>
									<td><?php echo $data['NamaDiagnosa'];?></td>
									<td><?php echo $data['Jumlah'];?></td>
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
