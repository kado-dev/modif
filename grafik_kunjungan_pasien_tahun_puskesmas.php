<?php
	include "config/helper_pasienrj.php";
	$tahun = date('Y');
	$tahunlalu = date('Y') - 1;
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN BULANAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<div><canvas id="Grafik_Kunjungan" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas></div>
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
				label: 'Jumlah Kunjungan <?php echo nama_bulan(date('m'));?>',
				data:[
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
							$query_kunjungan = mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbpasienrj` WHERE MONTH(`TanggalRegistrasi`) = '$val' AND YEAR(TanggalRegistrasi)='$tahunlalu' AND SUBSTRING(`NoRegistrasi`,1,11)='$kodepuskesmas'");
							$jml = mysqli_num_rows($query_kunjungan);
							echo '"'.$jml.'", ';
						}		
					?>
					],
					backgroundColor: [
					<?php
					for($i =0; $i < mysqli_num_rows($query_kunjungan); $i++){
					?>
						'rgba(175, 238, 247, 0.3)',
					<?php
					}
					?>	
					],
				borderColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_kunjungan); $i++){
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
