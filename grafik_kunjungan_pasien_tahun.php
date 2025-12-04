<?php
	include "config/helper_pasienrj.php";
	$tahun = '2018';
?>

<style>
.tr, th{
	text-align:center;
}
.tabel_judul th{
	background: #80ba8b;
	border-collapse: separate;
	font-size: 12px;
	line-height: 20px;
	text-align:center;
	padding: 5px 10px;
	color:#fff;
}

.headinglogin{
	background:#3BAC9B;
	padding:10px 10px;
	color:#fff;
	text-align:center;
	border-radius:4px 4px 0px 0px;
	margin-top:-9px;
	margin-left:-9px;
	margin-right:-9px;
	margin-bottom:15px;
	font-family: Malgun Gothic;
	font-weight: bold;
	font-size: 14px;
}
.heading_grafik{
	background:#F5F5F5;
	padding:10px 10px;
	color:#888;
	text-align:center;
	border-radius:4px 4px 0px 0px;
	margin-top:-9px;
	margin-left:-9px;
	margin-right:-9px;
	margin-bottom:15px;
	font-family: Malgun Gothic;
	font-weight: bold;
	font-size: 14px;
}

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

.kotak_retribusi{
   	background: #c6efe8;
    padding: 10px 15px;	
    margin: 5px 0px;
	font-family: Sans-Serif;
	text-align:center;
	color:#3BAC9B;
	border-radius:5px;
}

.kotakgrafik{
	margin-top:20px;
	background:#fff;
	padding:15px 10px;
	border:1px solid #ccc;
	border-radius:5px 5px 0px 0px;
}
.kotakgrafik h2{
	font-size:14px;
	background:#f9f9f9;
	padding:20px 10px 15px;
	border-bottom:1px solid #ccc;
	border-radius:5px 5px 0px 0px;
	margin:-15px -10px 10px -10px;
}
.font14{
	font-size: 14px;
}

.font32_bold{
	font-family: Sans-Serif;
	font-size: 32px;
	font-weight: bold;
	text-align: center;
	color:#3BAC9B;
}

@media screen and (max-width: 992px) {
	.kotak_retribusi{
		width: 100%;
		margin-bottom:15px;
	}
	.sidebars{
		margin-bottom:20px;
	}
}
</style>

<div class="row">
	<div class="col-sm-12">
		<div class="sidebars">
			<div class="heading_grafik">Grafik Kunjungan Pasien Bulanan</div>
			<div><canvas id="Grafik_Kunjungan" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas></div>
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
			labels: [
					<?php
						$array_bln = array(
							"Jan"=>"01",
							"Feb"=>"02",
							"Mar"=>"03",
							"Apr"=>"04",
							"Mei"=>"05",
							"Jun"=>"06",
							"Jul"=>"07",
							"Ags"=>"08",
							"Sep"=>"09",
							"Okt"=>"10",
							"Nov"=>"11",
							"Des"=>"12"
							);
						foreach($array_bln as $key => $val){
							echo '"'.$key.'", ';
						}
					?>
					],
			datasets: [{
				label: 'Jumlah Kunjungan',
				data:[
					<?php
						
						foreach($array_bln as $key => $val){
							// $tbpasienrj = "tbpasienrj_".$val;
							$str_kunjungan = "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE MONTH(`TanggalRegistrasi`) = '$val' AND YEAR(TanggalRegistrasi)='$tahun'";
							$query_kunjungan = mysqli_query($koneksi, $str_kunjungan);
							$jml = mysqli_num_rows($query_kunjungan);
							echo '"'.$jml.'", ';
						}		
					?>
					],
					backgroundColor: [
					<?php
					for($i =0; $i < count($array_bln); $i++){
					?>
						'rgba(175, 238, 247, 0.3)',
					<?php
					}
					?>	
					],
				borderColor: [
				<?php
				for($i =0; $i < count($array_bln); $i++){
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
			},tooltips: {
			mode: 'label',
			label: 'mylabel',
				callbacks: {
					label: function(tooltipItem, data) {
						return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); 
					}, 
				},
			}
		}
	});
</script>
