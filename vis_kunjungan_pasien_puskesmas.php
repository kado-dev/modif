<?php
	ob_start ("ob_gzhandler");
	include "main_menu.php";
	$kota = $_SESSION['kota'];
	$puskesmas_online = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE Kota = 'KABUPATEN BANDUNG' and TglPs = curdate() and NamaPuskesmas <> 'DINAS KESEHATAN'  and NamaPuskesmas <> 'UPTD FARMASI'"));
	$bulan = date('m');
	$tahun = date('Y');
	$tbpasienrj = 'tbpasienrj_'.date('m');
?>

<div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Grafik Kunjungan <?php echo "(".$puskesmas_online." Pkm Online)"?></h4>
		</div>
		<div class="panel-body">
			<div id="morris-bar-chart"></div>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Puskesmas Offline</h4>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-condensed">
				<tr>
					<td width='5%'>No.</td>
					<td width='10%'>Kode</td>
					<td width='85%'>Puskesmas</td>
				</tr>
				<?php
				$hariini = date('Y-m-d');
				$no = 0;
				$str = mysqli_query($koneksi,"SELECT KodePuskesmas, NamaPuskesmas FROM tbpuskesmas WHERE Kota = 'KABUPATEN BANDUNG' AND TglPs!= '$hariini' AND NamaPuskesmas != 'DINAS KESEHATAN' AND NamaPuskesmas != 'UPTD FARMASI' and KodePuskesmas <> 'P3273141201'");
				
				while($data = mysqli_fetch_assoc($str)){
					$no = $no +1;
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $data['KodePuskesmas'];?></td>
						<td><?php echo $data['NamaPuskesmas'];?></td>
					</tr>
					<?php
					
				}
				?>
			</table>
		</div>
	</div>
</div>

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
			$hariini = date('Y-m-d');
			$str = "SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as kodepuskesmas, COUNT(`NoRegistrasi`) as jml, kdprovider FROM `$tbpasienrj` GROUP BY `TanggalRegistrasi`,`kodepuskesmas` HAVING `TanggalRegistrasi` = '$hariini' and  kdprovider <> '10012004' and kdprovider <> '10011202' and kdprovider <> '10011801' order by jml DESC";
			$query1 = mysqli_query($koneksi,$str);
			while($data1=mysqli_fetch_assoc($query1)){
			$str12 = "SELECT NamaPuskesmas FROM tbpuskesmas WHERE KodePuskesmas = '$data1[kodepuskesmas]'";
			
			$puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,$str12)); 
			?>
			{
				device: '<?php echo $puskesmas['NamaPuskesmas'];?>',
				geekbench: <?php echo $data1['jml'];?>
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