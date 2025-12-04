<?php
	include "config/helper_pasienrj.php";
	$tahun =date('Y');
	$bulan =date('m');
	
	if($_GET['tgl'] == ''){
		$hariini = date('Y-m-d');
		$puskesmas_online = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where Kota = '$kota' and TglPs = curdate() and NamaPuskesmas <> 'DINAS KESEHATAN'  and NamaPuskesmas <> 'UPTD FARMASI'"));
	}else{
		$hariini = $_GET['tgl'];
		$puskesmas_online = mysqli_num_rows(mysqli_query($koneksi,"SELECT DISTINCT(substring(NoRegistrasi,1,11)) FROM `$tbpasienrj` where TanggalRegistrasi = '$hariini' and substring(NoRegistrasi,1,1) <> '/' and kdprovider <> '10012004'"));
	}
?>

<div class="col-lg-12 col-md-12">
	<div class="widget-box transparent">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title blue smaller">
				<i class="ace-icon fa fa-rss orange"></i>
				Visualisasi Kunjungan Pasien
			</h4>
		</div>
		<div class="widget-body">
			<div class="infobox-container">
				<div id="morris-bar-chart" style="min-width: 200px; height: 350px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="box-title">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="fa fa-search"></i> Cari Berdasar Tanggal</h4>
				</div>
				<div class="box-body">
					<!--<div id="morris-bar-chart"></div>-->
					<div class="text-right">
						<div class="row">
							<form class="form">
								<input type="hidden" name="page" value="grafik_kunjungan_pasien"/>
								<div class=" col-sm-10">
									<input type="text" name="tgl" class="form-control datepicker2"/>
								</div>
								<div class="col-sm-2">
									<input type="submit" class="btn btn-sm btn-primary">
									<a class="btn btn-sm btn-success" href="?page=grafik_kunjungan_pasien">Refresh</a>
								</div>
							</form>
						</div>
					</div>
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
<script src="assets/js/plugins/morris/raphael.min.js"></script>
<script src="assets/js/plugins/morris/morris.min.js"></script>
<script>

$(function() {
	// Bar Chart
	Morris.Bar({
		element: 'morris-bar-chart',
		data: [
		<?php
		$str = "SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as KodePuskesmas, COUNT(`NoRegistrasi`) as jml, kdprovider FROM `$tbpasienrj` GROUP BY `TanggalRegistrasi`,`kodepuskesmas` HAVING `TanggalRegistrasi` = '$hariini' and  kdprovider <> '10012004' order by jml DESC";
		$query = mysqli_query($koneksi,$str);
		while($data = mysqli_fetch_assoc($query)){
			$str_pkm = "SELECT NamaPuskesmas from tbpuskesmas where KodePuskesmas = '$data[KodePuskesmas]'";
			$puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pkm)); 
			?>
			{
				device: '<?php echo $puskesmas['NamaPuskesmas'];?>',
				geekbench: <?php echo $data['jml'];?>
			},
		<?php
			}
		?>
		],
		xkey: 'device',
		ykeys: ['geekbench'],
		labels: ['Jumlah'],
		barRatio: 0.4,
		xLabelAngle: 90,
		hideHover: 'auto',
		resize: true,
	});
});
</script>

<?php
	if($kodepuskesmas == '-'){
		$semua ="";
	}else{
		$semua = "(KodePuskesmas = '$kodepuskesmas') AND";
	}
?>

<div class="row grafikdetail hidden">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Data Kunjungan Pasien (Puskesmas)</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive noprint">
					<table class="table table-condensed noprint">
						<thead style="font-size:10px;">
							<tr>
								<th class="col-sm-1">No.</th>
								<th class="col-sm-1">Kode</th>
								<th class="col-sm-8">Nama Puskesmas</th>
								<th class="col-sm-1">Jumlah</th>
								<th class="col-sm-1">Opsi</th>
							</tr>
						</thead>
						<tbody style="font-size:11px;">
							<?php
								$no = 0;
								$query = mysqli_query($koneksi, "SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as KodePuskesmas, COUNT(`NoRegistrasi`) as jml, kdprovider FROM `$tbpasienrj` GROUP BY `TanggalRegistrasi`,`kodepuskesmas` HAVING `TanggalRegistrasi` = '$hariini' and  kdprovider <> '10012004' order by jml DESC");
								while($data = mysqli_fetch_assoc($query)){
									$str_pkm = "SELECT NamaPuskesmas from tbpuskesmas where KodePuskesmas = '$data[KodePuskesmas]'";
									$puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pkm)); 
									$no = $no + 1;
							?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $data['KodePuskesmas'];?></td>
									<td><?php echo $puskesmas['NamaPuskesmas'];?></td>
									<td><?php echo $data['jml'];?></td>
									<td><a href="?page=registrasi_data_dinkes&tgl=<?php echo $hariini;?>&pkm=<?php echo $kodepuskesmas;?>" class="btn btn-xs btn-success">Lihat</a></td>
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
