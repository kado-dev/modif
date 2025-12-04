<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$id = $_POST['id'];
	$tahun = date('Y');
	$str = "SELECT KodePenerima, Penerima, SUM(GrandTotal)As Jumlah FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran)='$tahun' AND `KodePenerima`='$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modalobatdistribusi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">
					<?php echo "<span style='font-size: 18px; font-weight: bold'>".$data['KodePenerima']." - ".$data['Penerima']."</span><span style='font-size: 16px'>, Rp.".rupiah($data['Jumlah'])."</span>";?>
				</h4>
			</div>
			<div class="modal-body">
				<table class="table-judul" id="datatabless">
					<thead>
						<tr>
							<th width="5%">No.</td>
							<th width="15%">Tgl.Distribusi</td>
							<th width="10%">Jam</td>
							<th width="25%">No.Faktur</td>
							<th width="45%">Grand Total</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbgfkpengeluaran` WHERE `KodePenerima`='$id'";
						$str2 = $str." order by IdDistribusi DESC";
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
						?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['TanggalPengeluaran'];?></td>
							<td align="center"><?php echo $data['JamPengeluaran'];?></td>
							<td align="left"><?php echo $data['NoFaktur'];?></td>
							<td align="right" style="font-weight: bold"><?php echo rupiah($data['GrandTotal']);?></td>
						</tr>
						<?php 
						} 
						?>	
					</tbody>
				</table>
				<br/>
			</div>
		</div>
	</div>
</div>
<script>
$('#datatabless').DataTable();
</script>