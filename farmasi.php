<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Indikator Kunj.Resep</h1>
		</div>
	</div>
</div>

<!--grafik kunjungan resep-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Kunjungan Resep (per-Bulan)</h4>
			</div>
			<div class="box-body">
				<div id="grafik_kunj_resep"></div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
	<script src="assets/js/plugins/morris/raphael.min.js"></script>
    <script src="assets/js/plugins/morris/morris.min.js"></script>
	<script>
	$(function() {
		Morris.Bar({
			element: 'grafik_kunj_resep',
			data: [
			<?php
			$bulan = date('m');
			$tahun = date('Y');
			$query_ap = mysqli_query($koneksi,"SELECT * from `tbasuransi` order by `Asuransi`");
			while ($data_ap = mysqli_fetch_assoc($query_ap)){
				$str_as = "SELECT * FROM `tbresep` WHERE `StatusBayar` = '$data_ap[Asuransi]' AND MONTH(TanggalResep) = '$bulan' AND YEAR(TanggalResep) = '$tahun' AND substring(NoResep,1,11) = '".$kodepuskesmas."'";
				$jmlasalpasien = mysqli_num_rows(mysqli_query($koneksi,$str_as));
			?>
			{
				device: '<?php echo $data_ap['Asuransi'];?>',
				geekbench: <?php echo $jmlasalpasien;?>
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