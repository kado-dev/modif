<?php
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
?>

<div class="col-lg-12 col-md-12">
	<div class="widget-box transparent">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title blue smaller">
				<i class="ace-icon fa fa-rss orange"></i>
				Visualisasi Cara Bayar
			</h4>
		</div>
		<div class="widget-body">
			<div class="infobox-container">
				<div id="container" style="min-width: 200px; height: 350px; margin: 0 auto"></div>
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
		text: 'Tanggal, <?php echo $hariini;?>'
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
			if($_SESSION['kodepuskesmas'] == '-'){
				$sql = "SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` 
					WHERE `TanggalRegistrasi` = '$hari'
					GROUP BY Asuransi";
			}else{
				$sql = "SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` 
					WHERE `TanggalRegistrasi` = '$hari' AND substring(`NoRegistrasi`,1,11) = '$kodepuskesmas'
					GROUP BY Asuransi";
			}
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
