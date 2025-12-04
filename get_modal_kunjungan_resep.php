<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$id = $_POST['id'];
	$tahun = date('Y');
	$str = "SELECT NamaPuskesmas FROM `tbpuskesmas` WHERE `KodePuskesmas`='$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modalkunjunganresep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content modalku">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Data Kunjungan Resep</h4>
			</div>
			<div class="modal-body">
				<div class="row noprint">
					<div class="col-sm-12">
						<div class="alert alert-block alert-success fade in">
							<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
							<p>
								<?php echo $id." - ".$data['NamaPuskesmas'];?>
							</p>
						</div>
					</div>
				</div>
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width='5%'>No.</td>
							<th width='10%'>Tgl.Resep</td>
							<th width='10%'>No.Resep</td>
							<th width='35%'>Nama Pasien</td>
							<th width='10%'>Umur</td>
							<th width='15%'>Jaminan</td>
							<th width='15%'>Pelayanan</td>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$str_resep = "SELECT * FROM `tbresep` WHERE DATE(TanggalResep) = curdate() AND SUBSTRING(NoResep,1,11) = '$id' LIMIT 10";
							$query_resep = mysqli_query($koneksi,$str_resep);
							while($dt_resep = mysqli_fetch_assoc($query_resep)){
								$no = $no + 1;
						?>
						<tr>
							<td align="center"><?php echo $no;?></td> 
							<td align="center"><?php echo date('Y-m-d', strtotime($dt_resep['TanggalResep']));?></td> 
							<td align="center"><?php echo substr($dt_resep['NoResep'], -10);?></td> 
							<td align="left"><?php echo $dt_resep['NamaPasien'];?></td> 
							<td align="left"><?php echo $dt_resep['UmurTahun']." Th ".$dt_resep['UmurBulan']." Bl";?></td> 
							<td align="left"><?php echo $dt_resep['StatusBayar'];?></td> 
							<td align="left"><?php echo $dt_resep['Pelayanan'];?></td> 
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