<?php
	$id = $_GET['id'];
	$query = mysqli_query($koneksi,"select * from `tbasuransi` where `KodeAsuransi` = '$id'");
	$data = mysqli_fetch_assoc($query);
	if($_SESSION['otoritas'] == 'ADMINISTRATOR1'){
?>

<!--data asuransi-->
<h3><b><span class="glyphicon glyphicon-list-alt"></span> Entry Asuransi</b></h3><hr>
<div class="panel panel-default">
	<div class="panel-heading">
		<span class="glyphicon glyphicon-pencil"></span> Entry Asuransi
	</div>
	
	<div class="panel-body">
		<form class="form-horizontal" action="index.php?page=master_asuransi_edit_proses" method="post" role="form">
			<table class="table">
				<tr>
					<td class="col-sm-3">Kode</td>
					<td>:</td>
					<td class="col-sm-9">
						<input type="text" name="kodeasuransi" class="form-control" value="<?php echo $data['KodeAsuransi'];?>">
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">Asuransi</td>
					<td>:</td>
					<td class="col-sm-9">
						<input type="text" name="asuransi" class="form-control" value="<?php echo $data['Asuransi'];?>">
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">Kab/Kota</td>
					<td>:</td>
					<td class="col-sm-9">
						<input type="text" name="kota" class="form-control" value="<?php echo $data['Kota'];?>">
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">
					<td></td>
					<td class="col-sm-10"><button type="submit" class="btn btn-success">Submit</button></td>
					</td>
				</tr>	
			</table>
		</form>
	</div>
</div>
<?php
	}
?>