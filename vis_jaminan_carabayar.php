<?php
	include "main_menu.php";
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$tahun =date('Y');
	$bulan =date('m');
?>

<div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Grafik Cara Bayar</h4>
		</div>
		<div class="panel-body">
			<div id="container" style="min-width: 200px; height: 420px; margin: 0 auto"></div>
			<div class="text-right">
				<a href="#" class="btngrafikdetail">View Details <i class="fa fa-arrow-circle-right"></i></a>
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
		text: 'Grafik Cara Bayar'
	},
	subtitle: {
		text: '(Jaminan/Asuransi)'
	},
	xAxis: {
		categories: ['Cara Bayar']
	 },
	yAxis: {
		title: {
		   text: 'Jumlah Kunjungan'
		}
	 },
	plotOptions: {
		column: {
			depth: 25
		}
	},
	series: [
		<?php
			$hari = date('Y-m-d');
			$sql = "SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` 
				WHERE `TanggalRegistrasi` = '$hari'
				GROUP BY Asuransi";
			$query = mysqli_query($koneksi,$sql) or die(mysqli_error()); 
			while($ambil = mysqli_fetch_array($query)){
		?>
		{
			name: '<?php echo $ambil['Asuransi'];?>',
			data: [<?php echo $ambil['Jumlah'];?>]
		},
		<?php 
		} 
		?>
	]
});
</script>