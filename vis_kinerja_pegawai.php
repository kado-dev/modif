<?php
	include "main_menu.php";
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$tahun =date('Y');
	$bulan =date('m');
?>

<div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Grafik Kinerja Pegawai <?php echo "(".$puskesmas_online." Pkm Online)"?></h4>
		</div>
		<div class="panel-body">
			<div id="morris-bar-chart"></div>
		</div>
	</div>		
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Kinerja Pegawai</h4>
		</div>
		<div class="box-body">
			<div class="table-responsive noprint">
				<table class="table table-condensed noprint">
					<thead style="font-size:10px;">
						<tr>
							<th style="font-size:12px;">No.</th>
							<th style="font-size:12px;">Nama Pegawai</th>
							<th style="font-size:12px;">Status</th>
							<th style="font-size:12px;">Puskesmas</th>
							<th style="font-size:12px;">Jumlah</th>
						</tr>
					</thead>
					<tbody style="font-size:11px;">
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