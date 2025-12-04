<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--judul menu-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Registrasi <small>e-Puskesmas</small>
		</h1>
		<ol class="breadcrumb">
			<li class="active">
				<i class="fa fa-dashboard"></i> Status Login:
				<?php
					echo $_SESSION['kodepuskesmas'].", ".$_SESSION['namapuskesmas'].", ".$_SESSION['kota'];
				  ?>
			</li>
		</ol>
	</div>
</div>

<?php
	$noregistrasi = $_GET['noregistrasi'];
	$str = mysqli_query($koneksi,"SELECT * FROM `tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'");
	$dtreg = mysqli_fetch_assoc($str);
?>


		
<ul class="nav nav-tabs">
	<li class="active"><a href="#registrasi" data-toggle="tab">Registrasi Puskesmas</a></li>
	<?php if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'Nikbpjs'){?>
	<li><a href="#home" data-toggle="tab">Registrasi BPJS</a></li>
	<?php }?>
</ul>
	
<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="registrasi"><br/>
		<div class="panel panel-default">
			<div class="panel-heading">
				Registrasi Puskesmas
			</div>	
			<div class="panel-body">
				<form class="form-horizontal" action="index.php?page=registrasi_edit_proses" method="post" role="form">
				
				<input type="hidden" name="noregistrasi" value="<?php echo $_GET['noregistrasi'];?>">
	
				
					<table class="table">

						<tr>
							<td class="col-sm-3">No.Registrasi</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="noregistrasi" class="form-control" required="required"  value="<?php echo $_GET['noregistrasi'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Nama</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="nama" class="form-control" required="required"  value="<?php echo $dtreg['NamaPasien'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Jenis Kunjungan</td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="jeniskunjungan" class="form-control">
									<option value="-">--Pilih--</option>
									<option value="Rawat Jalan" <?php if($dtreg['JenisKunjungan'] == 'Rawat Jalan'){echo "SELECTED";}?>>RAWAT JALAN</option>
									<option value="Rawat Inap" <?php if($dtreg['JenisKunjungan'] == 'Rawat Inap'){echo "SELECTED";}?>>RAWAT INAP</option>
									<option value="UGD" <?php if($dtreg['JenisKunjungan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Asal Pasien</td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="asalpasien" class="form-control">
									<option value="-">--Pilih--</option>
									<option value="Puskesmas" <?php if($dtreg['AsalPasien'] == 'Puskesmas'){echo "SELECTED";}?>>PUSKESMAS</option>
									<option value="Pusling" <?php if($dtreg['AsalPasien'] == 'Pusling'){echo "SELECTED";}?>>PUSLING</option>
									<option value="Pustu" <?php if($dtreg['AsalPasien'] == 'Pustu'){echo "SELECTED";}?>>PUSTU</option>
									<option value="Polindes" <?php if($dtreg['AsalPasien'] == 'Polindes'){echo "SELECTED";}?>>POLINDES</option>
									<option value="Posyandu" <?php if($dtreg['AsalPasien'] == 'Posyandu'){echo "SELECTED";}?>>POSYANDU</option>
									<option value="Posbindu" <?php if($dtreg['AsalPasien'] == 'Posbindu'){echo "SELECTED";}?>>POSBINDU</option>
									<option value="Poskesdes" <?php if($dtreg['AsalPasien'] == 'Poskesdes'){echo "SELECTED";}?>>POSKESDES</option>
									<option value="Bidan Desa" <?php if($dtreg['AsalPasien'] == 'Bidan Desa'){echo "SELECTED";}?>>BIDAN DESA</option>
									<option value="Lainnya" <?php if($dtreg['AsalPasien'] == 'Lainnya'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Poli Pertama*</span></td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="polipertama" class="form-control polipertama">
									<option value="-">--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` order by `Pelayanan`");
										while($data = mysqli_fetch_assoc($query)){
											if($data['Pelayanan'] == $dtreg['PoliPertama']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
											}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
											}
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Poli Selanjutnya*</td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="poliselanjutnya" class="form-control">
									<option value="-">--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` order by `Pelayanan`");
										while($data = mysqli_fetch_assoc($query)){
											if($data['Pelayanan'] == $dtreg['PoliSelanjutnya']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
											}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
											}
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Asuransi*</td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="asuransi" class="form-control asuransi" required>
									<option value="">--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi`");
										while($data = mysqli_fetch_assoc($query)){
										
										
											if($dtreg['Asuransi'] == $data['Asuransi']){
												echo "<option value='$data[Asuransi]' selected>$data[Asuransi]</option>";
								
											}else{
												echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
											}
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Status Kunjungan</td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="statuskunjungan" class="form-control">
									<option value="-">--Pilih--</option>
									<option value="Baru" <?php if($dtreg['StatusKunjungan'] == 'Baru'){echo "SELECTED";}?>>BARU</option>
									<option value="Lama" <?php if($dtreg['StatusKunjungan'] == 'Lama'){echo "SELECTED";}?>>LAMA</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="col-sm-2">Waktu Kunjungan</td>
							<td>:</td>
							<td class="col-sm-10">
								<select name="waktukunjungan" class="form-control">
									<option value="-">--Pilih--</option>
									<option value="SHIFT 1"  <?php if($dtreg['WaktuKunjungan'] == 'SHIFT 1'){echo "SELECTED";}?>>SHIFT 1</option>
									<option value="SHIFT 2"  <?php if($dtreg['WaktuKunjungan'] == 'SHIFT 2'){echo "SELECTED";}?>>SHIFT 2</option>
									<option value="SHIFT 3"  <?php if($dtreg['WaktuKunjungan'] == 'SHIFT 3'){echo "SELECTED";}?>>SHIFT 3</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Tarif</td>
							<td>:</td>
							<td class="col-sm-10">
								<input type="text" name="tarif" class="form-control tarif" value="<?php echo $dtreg['Tarif'];?>" readonly>
							</td>
						</tr>
						<?php 
							if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'Nikbpjs'){
								//kosong
							}else{
						?>
						<td class="col-sm-2" colspan="3"><button type="submit" class="btn btn-success pull-right">Submit</button></td>
						</form>	
						<?php } ?>
					</table>
				
			</div>
		</div>
	</div>

	<?php 
	if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'Nikbpjs'){
	?>
	<div class="tab-pane" id="home"><br/>
		<div class="panel panel-default">
			<div class="panel-heading">
				Registrasi BPJS
			</div>
			<?php
			//echo date('G:i:s'); 
			?>
						
			<div class="panel-body">
					<table class="table">
						<tr>
							<td class="col-sm-3">Kunjungan</td>
							<td>:</td>
							<td class="col-sm-9">
								<div class="radio">
								  <label>
									<input type="radio" name="kunjungan" class="kunjungan" value="true" checked>Kunjungan Sakit
								  </label>
								</div>
								
								<div class="radio">
								  <label>
									<input type="radio" name="kunjungan" class="kunjungan" value="false">Kunjungan Sehat
								  </label>
								</div>	
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Perawatan</td>
							<td>:</td>
							<td class="col-sm-9">
								<div class="radio">
								  <label>
									<input type="radio" name="perawatan" value="false" checked>Rawat Jalan
								  </label>
								</div>	
								<div class="radio">
								  <label>
									<input type="radio" name="perawatan" value="true">Rawat Inap
								  </label>
								</div>
							</td>
						</tr>
						
						<tr>
							<td>Poli Tujuan</td>
							<td>:</td>
							<td>
								<select name="poli_bpjs" class="form-control poli_bpjs" required>
									<option value="">--Pilih--</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Keluhan</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="keluhan" value="-" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td colspan="3"><b>Pemeriksaan Fisik</b></td>
						</tr>
						<tr>
							<td class="col-sm-3">Tinggi Badan</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="number" name="tinggibadan" value="0" class="form-control" min="0" max="200" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Berat Badan</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="number" name="beratbadan" value="0" class="form-control" min="0" max="100" required>
							</td>
						</tr>
						<tr>
							<td colspan="3"><b>Tekanan Darah</b></td>
						</tr>
						<tr>
							<td class="col-sm-3">Sistole</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="number" name="sistole" value="0" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Diastole</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="number" name="diastole" value="0" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Respiratory Rate</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="number" name="respiratoryrate" value="0" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Heart Rate</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="number" name="heartrate" value="0" class="form-control" required>
							</td>
						</tr>
						<td class="col-sm-3" colspan="3"><button type="submit" class="btn btn-success pull-right">Submit</button></td>
					</form>	
					</table>
				<!--</form>-->
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>