<?php
	include "config/helper_bpjs.php";
	include "config/helper_pasienrj.php";
	$tahun = date('Y');
	$bulan = date('m');
	$kota = $_SESSION['kota'];
?>
<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Grafik Kinerja Pegawai</h1>
		</div>
	</div>
</div>

<div class="col-lg-12 col-md-12">
	<div class="widget-box transparent">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title blue smaller">
				<i class="ace-icon fa fa-rss orange"></i>
				Visualisasi Kinerja Pegawai
			</h4>
		</div>
		<div class="box-body">
			<div id="morris-bar-chart"></div>
			<div class="text-right">
				<a href="#" class="btngrafikdetail">View Details <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>

<?php
	$str = "select * from `tbpasienperpegawaitracking` where Bulan = '$bulan' AND Tahun = '$tahun'
			group by NamaPegawai order by Jumlah DESC LIMIT 20";
	$query = mysqli_query($koneksi,$str);
	// echo $str;
?>

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
		while($data=mysqli_fetch_assoc($query)){
		?>
		{
			device: '<?php echo $data['NamaPegawai'];?>',
			geekbench: '<?php echo $data['Jumlah'];?>'
		},
		<?php
		}
		?>
		],
		xkey: 'device',
		ykeys: ['geekbench'],
		labels: ['Jumlah'],
		barRatio: 0.3,
		xLabelAngle: 90,
		hideHover: 'auto',
		resize: true
	});
});
</script>

<div class="row grafikdetail hidden">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Data Kinerja Pegawai</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive noprint">
					
						<table class="table table-striped table-condensed noprint">
							<thead>
								<tr>
									<th style="font-size:12px;">No.</th>
									<th style="font-size:12px;">Nama Pegawai</th>
									<th style="font-size:12px;">Status</th>
									<th style="font-size:12px;">Puskesmas</th>
									<th style="font-size:12px;">Jumlah</th>
								</tr>
							</thead>
							<!--tbpasienrj-->
							<tbody font="8">
								<!--paging-->
								<?php
								$str2 = "select * from `tbpasienperpegawaitracking` where Bulan = '$bulan' AND Tahun = '$tahun'
										group by NamaPegawai order by Jumlah DESC LIMIT 20";
								$query2 = mysqli_query($koneksi,$str2);
								while($data2=mysqli_fetch_assoc($query2)){
								$no = $no + 1;
								
								//tbpuskesmas
								$data_pkm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * from `tbpuskesmas` where `KodePuskesmas` = '$data2[KodePuskesmas]'"));
								
								//tbpegawai
								$str_pegawai = "SELECT * from tbpegawai where `NamaPegawai` = '$data2[NamaPegawai]'";
								$query_pegawai = mysqli_query($koneksi,$str_pegawai);
								$data_pegawai = mysqli_fetch_assoc($query_pegawai);
								
								?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $data2['NamaPegawai'];?></td>
										<td><?php echo $data_pegawai['Status'];?></td>
										<td><?php echo $data_pkm['NamaPuskesmas'];?></td>
										<td><?php echo $data2['Jumlah'];?></td>
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
