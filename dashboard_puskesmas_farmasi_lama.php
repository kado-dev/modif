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
	
	// ketersediaan obat
	$gudang = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Stok` > 0"));
	$depot = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbapotikstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `StatusBarang`='LOKET OBAT' AND `Stok` > '0'"));
	$igd = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='IGD' AND `Stok` > '0'"));
	$ranap = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='RAWAT INAP' AND `Stok` > '0'"));
	$poned = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='PONED' AND `Stok` > '0'"));
	$pustu = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='PUSTU' AND `Stok` > '0'"));
	$pusling = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='PUSLING' AND `Stok` > '0'"));
	$poli_anak = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI ANAK' AND `Stok` > '0'"));
	$poli_gigi = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI GIGI' AND `Stok` > '0'"));
	$poli_jiwa = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI JIWA' AND `Stok` > '0'"));
	$poli_kia = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI KIA' AND `Stok` > '0'"));
	$poli_kusta = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI KUSTA' AND `Stok` > '0'"));
	$poli_lansia = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI LANSIA' AND `Stok` > '0'"));
	$poli_tb = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI TB' AND `Stok` > '0'"));
	$poli_umum = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='POLI UMUM' AND `Stok` > '0'"));
	$laboratorium = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM tbapotikstok WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusBarang`='LABORATORIUM' AND `Stok` > '0'"));
					
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

<h3 class="judul"><b>Ketersediaan </b></h3>
<div class="row" style="margin-top:0px;">
	<div class="col-sm-8">
		<div class="kotakgrafik" style="margin-top: 0px;">
			<canvas id="Grafik_KunjunganResep_PerPoli" height="300px"></canvas>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li class="active"><a data-toggle="tab" href="#satu" aria-expanded="true">Hal 1</a></li>
				<li class=""><a data-toggle="tab" href="#dua" aria-expanded="false">Hal 2</a></li>
				<li class=""><a data-toggle="tab" href="#tiga" aria-expanded="false">Hal 3</a></li>
			</ul>
			<div class="tab-content">
				<div id="satu" class="tab-pane active">
					<ul id="tasks" class="item-list">
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Gudang Obat</label>
							<div class="pull-right action-buttons">
								<a style="font-size: 12px; color: #a0a0a0;"><span class="label label-danger arrowed arrowed-right"><?php echo $gudang;?> item</span></a>
								<a href="?page=apotik_gudang_stok" class="btn btn-xs btn-info btn-white" style="margin-top:2px;">Lihat</a>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Depot</label>
							<div class="pull-right action-buttons">
								<a style="font-size: 12px; color: #a0a0a0;"><span class="label label-danger arrowed arrowed-right"><?php echo $depot;?> item</span></a>
								<a href="?page=apotik_stok&status=<?php echo "LOKET OBAT"?>" class="btn btn-xs btn-info btn-white" style="margin-top:2px;">Lihat</a>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">IGD</label>
							<div class="pull-right action-buttons">
								<a style="font-size: 12px; color: #a0a0a0;"><span class="label label-danger arrowed arrowed-right"><?php echo $igd;?> item</span></a>
								<a href="?page=apotik_stok&status=<?php echo "IGD"?>" class="btn btn-xs btn-info btn-white" style="margin-top:2px;">Lihat</a>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Rawat Inap</label>
							<div class="pull-right action-buttons">
								<a style="font-size: 12px; color: #a0a0a0;"><span class="label label-danger arrowed arrowed-right"><?php echo $ranap;?> item</span></a>
								<a href="?page=apotik_stok&status=<?php echo "RAWAT INAP"?>" class="btn btn-xs btn-info btn-white" style="margin-top:2px;">Lihat</a>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poned</label>
							<div class="pull-right action-buttons">
								<a style="font-size: 12px; color: #a0a0a0;"><span class="label label-danger arrowed arrowed-right"><?php echo $poned;?> item</span></a>
								<a href="?page=apotik_stok&status=<?php echo "PONED"?>" class="btn btn-xs btn-info btn-white" style="margin-top:2px;">Lihat</a>
							</div>
						</li>
						<li>
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Pustu</label>
							<div class="pull-right action-buttons">
								<a style="font-size: 12px; color: #a0a0a0;"><span class="label label-danger arrowed arrowed-right"><?php echo $pustu;?> item</span></a>
								<a href="?page=apotik_stok&status=<?php echo "PUSTU"?>" class="btn btn-xs btn-info btn-white" style="margin-top:2px;">Lihat</a>
							</div>
						</li>
					</ul>
				</div>
				<div id="dua" class="tab-pane">
					<ul id="tasks" class="item-list">
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Pusling</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $pusling;?>">
								<span class="percent"><?php echo $pusling;?></span>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli Anak</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_anak;?>">
								<span class="percent"><?php echo $poli_anak;?></span>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli Gigi</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_gigi;?>">
								<span class="percent"><?php echo $poli_gigi;?></span>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli Jiwa</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_jiwa;?>">
								<span class="percent"><?php echo $poli_jiwa;?></span>
							</div>
						</li>
						<li>
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli KIA</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_kia;?>">
								<span class="percent"><?php echo $poli_kia;?></span>
							</div>
						</li>
					</ul>
				</div>
				<div id="tiga" class="tab-pane">
					<ul id="tasks" class="item-list">
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli Kusta</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_kusta;?>">
								<span class="percent"><?php echo $poli_kusta;?></span>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli Lansia</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_lansia;?>">
								<span class="percent"><?php echo $poli_lansia;?></span>
							</div>
						</li>
						<li class="clearfix" style="border-bottom: 1.5px solid #cfd1cf;">
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli TB</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_tb;?>">
								<span class="percent"><?php echo $poli_tb;?></span>
							</div>
						</li>
						<li>
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Poli Umum</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $poli_umum;?>">
								<span class="percent"><?php echo $poli_umum;?></span>
							</div>
						</li>
						<li>
							<label style="font-size: 14px; font-weight: bold; padding-right: 20px;">Laburatorium</label>
							<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#e82200" data-percent="<?php echo $laboratorium;?>">
								<span class="percent"><?php echo $laboratorium;?></span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
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
					$str_ds = "SELECT KodeBarang, Stok FROM tbgudangpkmstok WHERE `KodePuskesmas`= '$kodepuskesmas' AND Stok > '0' ORDER BY Stok DESC LIMIT 10";
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['KodeBarang'].'", ';
					}
				?>
				],
		datasets: [{
			label: 'Kunjungan Resep <?php echo tgl_lengkap(date("Y-m-d"))?> (Per-Pelayanan / Poli)',
			data:[
				<?php
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['Stok'].'", ';
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
