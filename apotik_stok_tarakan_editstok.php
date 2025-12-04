<?php
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kd = $_GET['kd'];
	$batch = $_GET['batch'];
	$sts = $_GET['sts'];
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);	
	$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbapotikstok` 
	WHERE KodeBarang = '$kd' AND NoBatch='$batch' AND `StatusBarang`='$sts'"));
?>

<div class="tableborderdiv">
	<div class="row">	
		<div class="col-xs-12">
			<h3 class="judul"><b>EDIT STOK</b><small> Loket Obat</small></h3>
			<div class="formbg" style="padding;30px;">
				<div class = "row">
					<form action="?page=apotik_stok_editstok_proses" method="post">	
					<input type="hidden" name="no" class="form-control" value="<?php echo $data['NoFaktur'];?>">
					<input type="hidden" name="kd" class="form-control" value="<?php echo $data['KodeBarang'];?>">
					<input type="hidden" name="sts" class="form-control" value="<?php echo $sts;?>">
						<div class="table-responsive">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-2">Kode Barang</td>
									<td class="col-sm-10">
										<input type="text" name="kodebarang" class="form-control" value="<?php echo $data['KodeBarang'];?>" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">NoBatch</td>
									<td class="col-sm-10">
										<input type="text" name="nobatch" class="form-control" value="<?php echo $data['NoBatch'];?>" readonly>
									</td>
								</tr>
								<tr>
									<td>Nama Barang</td>
									<td>
										<input type="text" name="namabarang" class="form-control" value="<?php echo $data['NamaBarang'];?>" readonly>
									</td>
								</tr>
								<tr>
									<td>Jumlah</td>
									<td>
										
										<input type="text" name="jumlah" class="form-control" value="<?php echo $data['Stok'];?>" maxlength="10">
									</td>
								</tr>
							</table><hr/>
							<input type="hidden" name="statusbarang" class="form-control" value="<?php echo $data['StatusBarang'];?>">
							<button type="submit" class="btnsimpan">SIMPAN</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
