<?php
	session_start();
	include "config/koneksi.php";
	$id = $_POST['id'];
	// ref_obatindikator
	$str = "SELECT * FROM `ref_obatindikator` WHERE `id_indikator` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	
	// ref_obat_lplpo
	$dtlplpo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Satuan` FROM `ref_obat_lplpo` WHERE `KodeBarang`='$data[KodeBarang]' LIMIT 1"));
	$satuan = $dtlplpo['Satuan'];	
	error_reporting(0);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditindikator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">EDIT DATA OBAT INDIKATOR</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_obat_indikator_edit_proses" method="post" enctype="multipart/form-data" role="form">
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Kode Barang</td>
							<td class="col-sm-9">
								<input type="text" name="kodebarang" class="form-control" value="<?php echo $data['KodeBarang'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Nama Barang</td>
							<td class="col-sm-9">
								<input type="text" name="namabarang" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['nama_indikator'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Satuan</td>
							<td class="col-sm-9">
								<select name="satuan" class="form-control">
									<?php
									$query_sat = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` ORDER BY `satuan_obat`");
										while($dtsatuan = mysqli_fetch_assoc($query_sat)){
											if($dtsatuan['satuan_obat'] == $satuan){
												echo "<option value='$dtsatuan[satuan_obat]' SELECTED>$dtsatuan[satuan_obat]</option>";
											}else{
												echo "<option value='$dtsatuan[satuan_obat]'>$dtsatuan[satuan_obat]</option>";
											}
										}
									?>
								</select>
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" name="idindikator" class="form-control" value="<?php echo $data['id_indikator'];?>">
					<button type="submit" class="btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>