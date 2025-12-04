<?php
	$kota = $_SESSION['kota'];	
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$id = $_GET['id'];	
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$str = "SELECT * FROM `$tbkk` WHERE NoIndex='$id'";
	$query = mysqli_query($koneksi, $str);
	$data = mysqli_fetch_assoc($query);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=kk_detail&id=<?php echo $id;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>EDIT DATA KK</b></h3>
			<div class="formbg">
				<form class="form-horizontal" action="kk_edit_proses.php" method="post">
					<table class="table-judul">
						<tr>
							<td class="col-sm-2">No.Index</td>
							<td class="col-sm-10"><input type="text" name="noindex" class="form-control inputan" value="<?php echo $data['NoIndex'];?>" readonly></td>
						</tr>
						<?php if($_SESSION['kota'] != 'KOTA TARAKAN'){ ?>		
						<tr>
							<?php 
								if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){	
									$norm = substr($data['NoRM'],-6);
								}elseif($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
									$norm = substr($data['NoRM'],-8);
								}else{
									$norm = substr($data['NoRM'],-11);
								}
							?>
							<td>No.RM</td>
							<td><input type="text" name="norm" class="form-control inputan" value="<?php echo $norm;?>"></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Nama Kepala Keluarga</td>
							<td><input type="text" name="namakk" style="text-transform: uppercase;" class="form-control inputan" value="<?php echo $data['NamaKK'];?>" required></td>
						</tr>
					</table><br/>

					<table class="table-judul"  width="100%">
						<h4><b>ALAMAT LENGKAP</b></h4><hr/>
						<tr>
							<td class="col-sm-2">Alamat Lengkap</td>
							<td class="col-sm-10">
								<div class="row" >
									<div class="col-sm-12"> 
										<input type="text" name="alamat" style="text-transform: uppercase;" class="form-control inputan alamatcls" value="<?php echo $data['Alamat'];?>">
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
										<input type="number" name="rt" class="form-control inputan rtcls" maxlength ="2" value="<?php echo $data['RT'];?>">
											<div class="input-group-append">
												<span class="input-group-text">RT</span>
											</div>
										</div>					
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 12px">
										<div class="input-group">
											<input type="number" name="rw" class="form-control inputan rwcls" maxlength ="2" value="<?php echo $data['RW'];?>" required>
											<div class="input-group-append">
												<span class="input-group-text">RW</span>
											</div>
										</div>
									</div>																				
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="text" name="no" class="form-control inputan nocls" maxlength ="5" value="<?php echo $data['No'];?>" required>
											<div class="input-group-append">
												<span class="input-group-text">NO</span>
											</div>
										</div>								
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Provinsi </td>
							<td>
								<select name="provinsi" class="form-control inputan provinsi" >
									<option value="">--Pilih--</option>
									<?php
										$id_provinsi = 0;
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_provinces` ORDER BY `prov_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['prov_id'] == $data['Provinsi']){
												$id_provinsi = $dtk['prov_id'];
												echo "<option value='$dtk[prov_id]' SELECTED>$dtk[prov_name]</option>";
											}else{
												echo "<option value='$dtk[prov_id]'>$dtk[prov_name]</option>";
											}											
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Kab/Kota</td>
							<td>
								<select name="kota" class="form-control inputan kabupaten" >
									<option value="">--Pilih--</option>
									<?php
										$id_kota = 0;
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_cities` WHERE prov_id = '$id_provinsi' ORDER BY `city_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['city_id'] == $data['Kota']){
												$id_kota = $dtk['city_id'];
												echo "<option value='$dtk[city_id]' SELECTED>$dtk[city_name]</option>";
											}else{
												echo "<option value='$dtk[city_id]'>$dtk[city_name]</option>";
											}											
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Kecamatan </td>
							<td>
								<select name="kecamatan" class="form-control inputan kecamatan" >
									<option value="">--Pilih--</option>
									<?php
										$id_kec = 0;
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_districts` WHERE city_id = '$id_kota' ORDER BY `dis_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['dis_id'] == $data['Kecamatan']){
												$id_kec = $dtk['dis_id'];
												echo "<option value='$dtk[dis_id]' SELECTED>$dtk[dis_name]</option>";
											}else{
												echo "<option value='$dtk[dis_id]'>$dtk[dis_name]</option>";
											}											
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Kelurahan</td>
							<td>
								<select name="kelurahan" class="form-control inputan kelurahan">										
									<option value="">--Pilih--</option>
									<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_subdistricts` WHERE dis_id = '$id_kec' ORDER BY `subdis_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['subdis_id'] == $data['Kelurahan']){
												echo "<option value='$dtk[subdis_id]' SELECTED>$dtk[subdis_name]</option>";
											}else{
												echo "<option value='$dtk[subdis_id]'>$dtk[subdis_name]</option>";
											}											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Kode Pos</td>
							<td><input type="text" name="kodepos" value="<?php echo $data['KodePos'];?>" style="text-transform: uppercase;" class="form-control inputan kodepos" placeholder="Otomatis" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr>
						<tr>
							<td>No Telepon Rumah</td>
							<td><input type="number" name="telepon_rumah" value="<?php echo $data['Telepon'];?>" style="text-transform: uppercase;" value="0" class="form-control inputan" placeholder="Nomor telepon kediaman" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr>
					</table><br/>	

					<table class="table-judul" width="100%">
						<!--Alamat Domisili-->
						<h4><b>ALAMAT DOMISILI</b> </h4><label><input type="checkbox" class="cekalmatdom"> Samakan dengan Alamat Lengkap</label><hr/>
						<tr>
							<td class="col-sm-2">Alamat Domisili</td>
							<td class="col-sm-10">
								<div class="row" >
									<div class="col-sm-12"> 
										<input type="text" name="alamat_domisili" style="text-transform: uppercase;" class="form-control inputan alamatcls_domisili" value="<?php echo $data['Alamat_domisili'];?>" required>
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="number" name="rt_domisili" class="form-control inputan rtcls_domisili" maxlength ="2" value="<?php echo $data['RT_domisili'];?>" required>	
											<div class="input-group-append">
												<span class="input-group-text">RT</span>
											</div>
										</div>					
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 12px">
										<div class="input-group">
											<input type="number" name="rw_domisili" class="form-control inputan rwcls_domisili" maxlength ="2" value="<?php echo $data['RW_domisili'];?>" required>
											<div class="input-group-append">
												<span class="input-group-text">RW</span>
											</div>
										</div>
									</div>																				
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="text" name="no_domisili" class="form-control inputan nocls_domisili" maxlength ="5" value="<?php echo $data['No_domisili'];?>" required>
											<div class="input-group-append">
												<span class="input-group-text">NO</span>
											</div>
										</div>								
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Provinsi </td>
							<td>
								<select name="provinsi_domisili" class="form-control inputan provinsi_domisili" >
									<option value="">--Pilih--</option>
									<?php
										$id_provinsi = 0;
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_provinces` ORDER BY `prov_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['prov_id'] == $data['Provinsi_domisili']){
												$id_provinsi = $dtk['prov_id'];
												echo "<option value='$dtk[prov_id]' SELECTED>$dtk[prov_name]</option>";
											}else{
												echo "<option value='$dtk[prov_id]'>$dtk[prov_name]</option>";
											}											
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Kab/Kota</td>
							<td>
								<select name="kota_domisili" class="form-control inputan kabupaten_domisili" >
									<option value="">--Pilih--</option>
									<?php
										$id_kota = 0;
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_cities` WHERE prov_id = '$id_provinsi' ORDER BY `city_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['city_id'] == $data['Kota_domisili']){
												$id_kota = $dtk['city_id'];
												echo "<option value='$dtk[city_id]' SELECTED>$dtk[city_name]</option>";
											}else{
												echo "<option value='$dtk[city_id]'>$dtk[city_name]</option>";
											}											
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Kecamatan </td>
							<td>
								<select name="kecamatan_domisili" class="form-control inputan kecamatan_domisili" >
									<option value="">--Pilih--</option>
									<?php
										$id_kec = 0;
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_districts` WHERE city_id = '$id_kota' ORDER BY `dis_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['dis_id'] == $data['Kecamatan_domisili']){
												$id_kec = $dtk['dis_id'];
												echo "<option value='$dtk[dis_id]' SELECTED>$dtk[dis_name]</option>";
											}else{
												echo "<option value='$dtk[dis_id]'>$dtk[dis_name]</option>";
											}											
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Kelurahan</td>
							<td>
								<select name="kelurahan_domisili" class="form-control inputan kelurahan_domisili">										
									<option value="">--Pilih--</option>
									<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_subdistricts` WHERE dis_id = '$id_kec' ORDER BY `subdis_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['subdis_id'] == $data['Kelurahan_domisili']){
												echo "<option value='$dtk[subdis_id]' SELECTED>$dtk[subdis_name]</option>";
											}else{
												echo "<option value='$dtk[subdis_id]'>$dtk[subdis_name]</option>";
											}											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Kode Pos</td>
							<td><input type="text" name="kodepos_domisili" style="text-transform: uppercase;" class="form-control inputan kodepos_domisili" value="<?php echo $data['KodePos_domisili'];?>" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr> 
						<tr>
							<td>Wilayah Kerja</td>
							<td>
								<div class="input-group">
									<select name="wilayah" class="form-control inputan wilayah" value="<?php echo $data['Wilayah'];?>" required>
										<option value="">--Pilih--</option>
										<option value="Luar" <?php if($data['Wilayah'] == 'Luar'){echo "SELECTED";}?>>LUAR</option>
										<option value="Dalam" <?php if($data['Wilayah'] == 'Dalam'){echo "SELECTED";}?>>DALAM</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Daerah</td>
							<td>
								<div class="input-group">
									<select name="daerah" class="form-control inputan daerah" value="<?php echo $data['Daerah'];?>" required>
										<option>--Pilih--</option>
										<option value="Luar" <?php if($data['Daerah'] == 'Luar'){echo "SELECTED";}?>>LUAR</option>
										<option value="Dalam" <?php if($data['Daerah'] == 'Dalam'){echo "SELECTED";}?>>DALAM</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
					</table><br/>
					<input type="hidden" name="nik" class="form-control inputan" value="<?php echo $data['Nik'];?>">
					<input type="hidden" name="tanggaldaftar" class="form-control inputan" value="<?php echo $data['TanggalDaftar'];?>">
					<input type="hidden" name="nocm" class="form-control inputan" value = "<?php echo $data['NoCM'];?>" readonly>
					<input type="hidden" name="rfid" class="form-control inputan" placeholder="Scan Kartu RFID" required>
					<button type="submit" class="btn btn-simpan btn-success btnsimpan">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
$(document).ready(function() {
	$(".cekalmatdom").click(function(){
		if ($(this).is(':checked')){
			$(".alamatcls_domisili").val($(".alamatcls").val());
			$(".rtcls_domisili").val($(".rtcls").val());
			$(".rwcls_domisili").val($(".rwcls").val());
			$(".nocls_domisili").val($(".nocls").val());
			$(".provinsi_domisili").val($(".provinsi").val());
			$(".kabupaten_domisili").html($(".kabupaten").html());
			$(".kabupaten_domisili").val($(".kabupaten").val());
			$(".kecamatan_domisili").html($(".kecamatan").html());
			$(".kecamatan_domisili").val($(".kecamatan").val());
			$(".kelurahan_domisili").html($(".kelurahan").html());
			$(".kelurahan_domisili").val($(".kelurahan").val());
			$(".kodepos_domisili").val($(".kodepos").val());
		}else{
			$(".alamatcls_domisili").val('');
			$(".rtcls_domisili").val('');
			$(".rwcls_domisili").val('');
			$(".nocls_domisili").val('');
			$(".provinsi_domisili").val('');
			$(".kabupaten_domisili").val('');
			$(".kecamatan_domisili").val('');
			$(".kelurahan_domisili").val('');
			$(".kodepos_domisili").val('');
		}
	});

	$(".provinsi").change(function(){
		var idprovinsi = $(this).val();
		$.post( "get_data_wilayah.php",{getdata:'kabupaten',id:idprovinsi}).done(function( data ) {
			$(".kabupaten").html(data);
			$('.kabupaten').trigger("chosen:updated");
		});
	});

	$(".kabupaten").change(function(){
		var idkabupaten = $(this).val();
		$.post( "get_data_wilayah.php",{getdata:'kecamatan',id:idkabupaten}).done(function( data ) {
			$(".kecamatan").html(data);
			$('.kecamatan').trigger("chosen:updated");
		});
	});

	$(".kecamatan").change(function(){
		var idkecamatan = $(this).val();
		$.post( "get_data_wilayah.php",{getdata:'kelurahan',id:idkecamatan}).done(function( data ) {
			$(".kelurahan").html(data);
			$('.kelurahan').trigger("chosen:updated");
		});
	});

	$(".kelurahan").change(function(){
		var idkelurahan = $(this).val();
		$.post( "get_data_wilayah.php",{getdata:'kodepos',id:idkelurahan}).done(function( data ) {
			$(".kodepos").val(data);
		});
		$.post( "get_status_wilayah.php", { 
		kelurahan: idkelurahan
		}).done(function( data ) {
			var obj = JSON.parse(data);
			
			if(obj.statuswilayah == 'Dalam'){
				$(".wilayah").val('Dalam');
			}else{
				$(".wilayah").val('Luar');
			}
			$(".koderm").val(obj.koderm);
		});
	});
});
</script>