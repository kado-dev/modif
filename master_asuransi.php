<?php
	$kota = $_SESSION['kota'];
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA ASURANSI</b></h3>
			<table class="table-judul">
				<thead>
					<tr>
						<th class="col-sm-2">NAMA ASURANSI</th>
						<?php
							if($_SESSION['otoritas'] == 'ADMINISTRATOR'){
						?>
						<th class="col-sm-2">Aksi</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = mysqli_query($koneksi,"select * from `tbasuransi` where `kota`='$kota'");
					while($data = mysqli_fetch_assoc($query)){
					?>
						<tr>
							<td class="nama"><?php echo $data['Asuransi'];?></td>
							<?php
							if($_SESSION['otoritas'] == 'ADMINISTRATOR'){
							?>
							<td>
								<a href="?page=master_asuransi_edit&id=<?php echo $data['KodeAsuransi'];?>" class="btn btn-xs btn-info">EDIT</a>
								<a href="?page=master_asuransi_delete&id=<?php echo $data['KodeAsuransi'];?>" class="btn btn-xs btn-danger btnhapus">HAPUS</a>
							</td>
							<?php }?>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
	if($_SESSION['otoritas'] == 'ADMINISTRATOR'){
?>

<!--Kolom Entry-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bars"></i> Entry Asuransi</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" action="index.php?page=master_asuransi_proses" method="post" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-2">Asuransi</td>
							<td>:</td>
							<td class="col-sm-10">
								<input type="text" name="asuransi" style="text-transform: uppercase;" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td>
							<td></td>
							<td><button type="submit" class="btn btn-md btn-success">Submit</button></td>
							</td>
						</tr>	
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<?php 
}
?>
