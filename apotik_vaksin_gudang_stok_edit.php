<?php
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kd = $_GET['kd'];
	$pkm = $_GET['pkm'];
	$sts = $_GET['sts'];
	$nobatch = $_GET['nb'];
	if($kota == "KOTA TARAKAN"){
		$tbgudangpkmvaksinstok = "tbgudangpkmvaksinstok_".str_replace(' ', '', $namapuskesmas);
		$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmvaksinstok` WHERE `KodeBarang` = '$kd' AND `NoBatch`='$nobatch'"));
	}else{
		$tbgudangpkmvaksinstok = "tbgudangpkmvaksinstok";
		$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmvaksinstok` WHERE `KodeBarang` = '$kd' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas'"));
	}
	
?>

<div class="row">
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<h3 class="judul"><b>EDIT DATA BARANG <small>Gudang Vaksin Puskesmas</small></b></h3>
			<div class = "formbg row" style="padding: 30px 30px 30px 30px;">
				<div class="tableborder">
					<form action="?page=apotik_vaksin_gudang_stok_edit_proses" method="post">	
						<input type="hidden" name="no" class="form-control" value="<?php echo $data['NoFaktur'];?>">
						<input type="hidden" name="kd" class="form-control" value="<?php echo $data['KodeBarang'];?>">
						<input type="hidden" name="sts" class="form-control" value="<?php echo $sts;?>">
						<input type="hidden" name="pkm" class="form-control" value="<?php echo $pkm;?>">
						<input type="hidden" name="nobatch" class="form-control" value="<?php echo $nobatch;?>">
						<div class="table-responsive">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-2">Kode Barang</td>
									<td class="col-sm-10">
										<input type="text" name="kodebarang" class="form-control kodebarang" value="<?php echo $data['KodeBarang'];?>" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Nama Barang</td>
									<td class="col-sm-10">
										<input type="text" name="namabarang" class="form-control" value="<?php echo $data['NamaBarang'];?>" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Jumlah</td>
									<td class="col-sm-10">
										<input type="number" name="jumlah" class="form-control jumlah" value="<?php echo $data['Stok'];?>" maxlength="10">
									</td>
								</tr>
							</table><hr/>
							<button type="submit" class="btnsimpan">SIMPAN</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>