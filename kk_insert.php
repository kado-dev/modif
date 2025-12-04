<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$provinsi = $_SESSION['provinsi'];
	$kecamatan = $_SESSION['kecamatan'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$noasuransi = $_GET['noasuransi'];

?>
<style type="text/css">
	.tbdetailform{
		background: #dbf7ff;
		border-radius: 8px;
		margin-top: 15px;
		padding:15px 20px;
	}
	.tbdetail tr td{
		padding: 0px 5px;
	}
	.hed{
		background-color: #69D0EA;padding:8px;margin:-15px -20px 5px;text-align: center;
		border-radius: 8px 8px 0px 0px;
	}
	.hed h2{
		margin:0px;font-size: 26px;
	}
	.hed p{
		margin:0px;font-size: 14px;
	}
</style>

<div class="tableborderdiv">

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PENDAFTARAN PASIEN BARU</b></h3>
			<div class = "row noprint">
				<div class="col-sm-12 table-responsive">
					<div class="formbg">
						<p>
							<b>Perhatikan :</b><br/>
							- Form ini sudah menerapkan Pedoman Variabel dan Meta Data Pada Penyelenggaraan Rekam Medis Elektronik <br/>
							- Nomor HK.01.07/MENKES/1423/2022<br/>
							- <a href="dok/pedoman variabel dan meta data 2022.pdf" target="_blank" style="color: #000;"><b>Download Pedoman</b></a>
						</p>
					</div>
				</div>
			</div>
			<div class="formbg">
				<form class="form-horizontal" action="kk_insert_proses.php" method="post" role="form">
					<table class="table-judul" width="100%">					
						<?php if($kota == "KABUPATEN BULUNGAN"){?>
						<tr>
							<td>No.RM</td>
							<td class="row">
								<div class="form-group">
									<div class="col-md-3">
										<select name="norm1" class="form-control inputan poli">
											<option value="01" selected>01 - Umum</option> 
											<option value="02">02 - Lansia</option> 
										</select>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<select name="norm2" class="form-control inputan wilayah-value">
												<option value="01">01 - Tanjung Selor Hulu</option>
												<option value="02">02 - Tanjung Selor Hilir</option>
												<option value="03">03 - Tanjung Selor Timur</option>
												<option value="04">04 - Jelarai</option>
												<option value="05">05 - Tengkapak</option>
												<option value="06">06 - Gn.Seriang / Baratan</option>
												<option value="10">10 - Luar Wilayah</option>		
												<option value="11">11 - SDN</option>		
												<option value="12">12 - SMPN/MTSN</option>		
												<option value="13">13 - SMAN/MAN</option>		
												<option value="14">14 - SMKN</option>		
												<option value="15">15 - KIR KESEHATAN</option>		
												<option value="16">16 - Abjad</option>		
											</select>
											<span class="input-group-addon">Pilih</span>
										</div>
									</div>
									<div class="col-md-2">
										<input type="text" name="norm3" value="" class="form-control inputan norm6digit" size="4" maxlength="6">
									</div>
									<a href="#" class="btn btn-sm btn-default btnmodalrm" style="border-radius:20px; text-decoration: none;">Bank RM</a>
								</div>
							</td>
						</tr>
						<?php }elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){ ?>
						<tr>
							<td>No.RM</td>
							<td>
								<input type="text" name="norm" class="form-control inputan" maxlength="8" placeholder="Ketik Manual">
							</td>
						</tr>								
						<?php } ?>
						
						
						<!--Data Kepala Keluarga-->
						<h4><b>DATA KEPALA KELUARGA</b></h4><hr/>
						<tr>
							<td width="20%">Nama Kepala Keluarga</td>
							<td width="80%"><input type="text" name="namakk" style="text-transform: uppercase;" class="form-control inputan namakk" placeholder="Sesuai Identitas" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr>
					</table><br/>

					<table class="table-judul" width="100%">
						<h4><b>ALAMAT LENGKAP</b></h4><hr/>
						<tr>
							<td width="20%">Alamat Lengkap</td>
							<td width="80%">
								<div class="row" >
									<div class="col-sm-12"> 
										<input type="text" name="alamat" style="text-transform: uppercase;" class="form-control inputan alamatcls" placeholder = "Alamat pasien sesuai identitas" required>
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="number" name="rt" class="form-control inputan rtcls" maxlength ="2" placeholder = "RT" required>	
											<div class="input-group-append">
												<span class="input-group-text">RT</span>
											</div>
										</div>					
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 12px">
										<div class="input-group">
											<input type="number" name="rw" class="form-control inputan rwcls" maxlength ="2" placeholder = "RW" required>
											<div class="input-group-append">
												<span class="input-group-text">RW</span>
											</div>
										</div>
									</div>																				
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="text" name="no" class="form-control inputan nocls" maxlength ="5" placeholder = "No" required>
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
											if($dtk['prov_name'] == $provinsi){
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
										$kotakey = str_replace("KOTA ","", $kota);
										$query = mysqli_query($koneksi, "SELECT * FROM `ec_cities` WHERE prov_id = '$id_provinsi' ORDER BY `city_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['city_name'] == $kotakey){
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
											if($dtk['dis_name'] == $kecamatan){
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
											if($dtk['dis_name'] == $kecamatan){
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
							<td><input type="text" name="kodepos" style="text-transform: uppercase;" class="form-control inputan kodepos" placeholder="Otomatis" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr>
					</table><br/>

					<table class="table-judul" width="100%">
						<!--Alamat Domisili-->
						<h4><b>ALAMAT DOMISILI</b> </h4><label><input type="checkbox" class="cekalmatdom"> Samakan dengan Alamat Lengkap</label><hr/>
						<tr>
							<td width="20%">Alamat Domisili</td>
							<td width="80%">
								<div class="row" >
									<div class="col-sm-12"> 
										<input type="text" name="alamat_domisili" style="text-transform: uppercase;" class="form-control inputan alamatcls_domisili" placeholder = "Alamat dimana pasien berdomisili saat ini" required>
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="number" name="rt_domisili" class="form-control inputan rtcls_domisili" maxlength ="2" placeholder = "RT" required>	
											<div class="input-group-append">
												<span class="input-group-text">RT</span>
											</div>
										</div>					
									</div>
									<div class="col-sm-2" style="padding:10px 15px 0px 12px">
										<div class="input-group">
											<input type="number" name="rw_domisili" class="form-control inputan rwcls_domisili" maxlength ="2" placeholder = "RW" required>
											<div class="input-group-append">
												<span class="input-group-text">RW</span>
											</div>
										</div>
									</div>																				
									<div class="col-sm-2" style="padding:10px 15px 0px 15px">
										<div class="input-group">
											<input type="text" name="no_domisili" class="form-control inputan nocls_domisili" maxlength ="5" placeholder = "No" required>
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
											if($dtk['prov_name'] == $provinsi){
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
										$kotakey = str_replace("KOTA ","",$kota);
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_cities` WHERE prov_id = '$id_provinsi' ORDER BY `city_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['city_name'] == $kotakey){
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
								<select name="kecamatan_domisili" class="form-control inputan kecamatan kecamatan_domisili" >
									<option value="">--Pilih--</option>
									<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ec_districts` WHERE city_id = '$id_kota' ORDER BY `dis_name`");
										while($dtk = mysqli_fetch_assoc($query)){
											if($dtk['dis_name'] == $kecamatan){
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
								<select name="kelurahan_domisili" class="form-control inputan kelurahan kelurahan_domisili">										
									<option value="">--Pilih--</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Kode Pos</td>
							<td><input type="text" name="kodepos_domisili" style="text-transform: uppercase;" class="form-control inputan kodepos_domisili" placeholder="Otomatis" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr> 
						<tr>
							<td>Wilayah Kerja</td>
							<td>
								<div class="input-group">
									<select name="wilayah" class="form-control inputan wilayah" required>
										<option value="">--Pilih--</option>
										<option value="Luar">LUAR</option>
										<option value="Dalam" selected="true">DALAM</option>
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
									<select name="daerah" class="form-control inputan daerah" required>
										<option value="">--Pilih--</option>
										<option value="Luar">LUAR</option>
										<option value="Dalam" selected="true">DALAM</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
					</table><br/>

					<!--Data Pasien-->		
					<table class="table-judul" width="100%">							
						<h4><b>DATA PASIEN</b></h4><hr/>
						<tr>
							<td width="20%">Nama Lengkap</td>
							<td width="80%">
								<input type="text" name="namapasien" style="text-transform: uppercase;" class="form-control inputan namapasiencls" placeholder="SESUAI KTP">
							</td>
						</tr>
						<?php if($kota == "KABUPATEN BANDUNG"){ ?>
						<tr>
							<td width="20%">Nomor Rekam Medis</td>
							<td width="80%" class="row">
									<div class="col-md-3">
										<input type="text" name="koderm" class="form-control inputan koderm" readonly>
									</div>
									<div class="col-md-5">
										<div class="input-group">
											<select name="statuskeluarga" class="form-control inputan kepalakeluargacls" required>
												<option value="">--Status Keluarga--</option>
												<option value="KEPALA KELUARGA">KEPALA KELUARGA</option>
												<option value="ISTRI">ISTRI</option>
												<option value="ANAK 1">ANAK 1</option>
												<option value="ANAK 2">ANAK 2</option>
												<option value="ANAK 3">ANAK 3</option>
												<option value="ANAK 4">ANAK 4</option>
												<option value="ANAK 5">ANAK 5</option>
												<option value="ANAK 6">ANAK 6</option>
												<option value="ANAK 7">ANAK 7</option>
												<option value="ANAK 8">ANAK 8</option>
												<option value="ANAK 9">ANAK 9</option>
												<option value="ANAK 10">ANAK 10</option>
												<option value="ANAK 11">ANAK 11</option>
												<option value="ANAK 12">ANAK 12</option>
												<option value="ANAK 13">ANAK 13</option>
												<option value="ANAK 14">ANAK 14</option>
												<option value="ANAK 15">ANAK 15</option>
												<option value="ANAK 16">ANAK 16</option>
												<option value="ANAK 17">ANAK 17</option>
												<option value="ANAK 18">ANAK 18</option>
												<option value="ANAK 19">ANAK 19</option>
												<option value="BAPAK">BAPAK</option>
												<option value="IBU">IBU</option>
												<option value="KAKEK">KAKEK</option>
												<option value="NENEK">NENEK</option>
												<option value="CUCU">CUCU</option>	
												<option value="MENANTU">MENANTU</option>
												<option value="MERTUA">MERTUA</option>
												<option value="SAUDARA KANDUNG">SAUDARA KANDUNG</option>
												<option value="KEPONAKAN">KEPONAKAN</option>
												<option value="PONDOK PESANTREN">PONDOK PESANTREN</option>
												<option value="ANAK SEKOLAH">ANAK SEKOLAH</option>
											</select>
											<div class="input-group-append"><span class="input-group-text">Pilih</span></div>
										</div>
									</div>
									<a href="#" class="btn btn-round btn-info btnmodalrm_bandungkab" style="text-decoration: none;">Bank RM</a>
							</td>
						</tr>
						<?php } ?>
						<tr class="nikkkinsert">
							<td>NIK</td>
							<td>
								<div class="input-group">
									<input type="text" name="nik" class="form-control inputan nikcls" placeholder="Nomor Induk Kependudukan" required>
									<div class="input-group-append">
										<span class="input-group-text"><input type="checkbox" class="checknik"></span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Nomor Identitas Lain</td>
							<td>
								<input type="text" name="noidentitas" class="form-control inputan" placeholder="Khusus WNA (Paspor/Kitas)" required>
							</td>
						</tr>
						<tr>
							<td>Nama Ibu Kandung</td>
							<td>
								<input type="text" name="namaibukandung" class="form-control inputan" placeholder="Sesuai Identitas" required>
							</td>
						</tr>
						<tr>
							<td>Tempat Lahir</td>
							<td>
								<input type="text" name="tempatlahir" class="form-control inputan" placeholder="Sesuai Identitas" required>
							</td>
						</tr>
						<?php if($kota != "KABUPATEN BANDUNG"){ ?>							
						<tr>
							<td width="20%">Status Keluarga</td>
							<td width="80%">
								<div class="input-group">
									<!--<select name="statuskeluarga" class="form-control inputan statuskeluargapilih" required>-->
									<select name="statuskeluarga" class="form-control inputan kepalakeluargacls" required>
										<option value="">--Pilih--</option>
										<option value="KEPALA KELUARGA">KEPALA KELUARGA</option>
										<option value="ISTRI">ISTRI</option>
										<option value="ANAK 1">ANAK 1</option>
										<option value="ANAK 2">ANAK 2</option>
										<option value="ANAK 3">ANAK 3</option>
										<option value="ANAK 4">ANAK 4</option>
										<option value="ANAK 5">ANAK 5</option>
										<option value="ANAK 6">ANAK 6</option>
										<option value="ANAK 7">ANAK 7</option>
										<option value="ANAK 8">ANAK 8</option>
										<option value="ANAK 9">ANAK 9</option>
										<option value="ANAK 10">ANAK 10</option>
										<option value="ANAK 11">ANAK 11</option>
										<option value="ANAK 12">ANAK 12</option>
										<option value="ANAK 13">ANAK 13</option>
										<option value="ANAK 14">ANAK 14</option>
										<option value="ANAK 15">ANAK 15</option>
										<option value="ANAK 16">ANAK 16</option>
										<option value="ANAK 17">ANAK 17</option>
										<option value="ANAK 18">ANAK 18</option>
										<option value="ANAK 19">ANAK 19</option>
										<option value="BAPAK">BAPAK</option>
										<option value="IBU">IBU</option>
										<option value="KAKEK">KAKEK</option>
										<option value="NENEK">NENEK</option>
										<option value="CUCU">CUCU</option>	
										<option value="MENANTU">MENANTU</option>
										<option value="MERTUA">MERTUA</option>
										<option value="SAUDARA KANDUNG">SAUDARA KANDUNG</option>
										<option value="KEPONAKAN">KEPONAKAN</option>
										<option value="PONDOK PESANTREN">PONDOK PESANTREN</option>
										<option value="ANAK SEKOLAH">ANAK SEKOLAH</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
						<?php 
							}
						?>	
						<tr>
							<td>Tgl.Lahir & Perkiraan Umur</td>
							<td>
								<div class="row ">
									<div class="col-sm-6">
										<?php
											$tgl = explode("-",date ('1970-m-d'));											
										?>
										<input type="text" name="tanggallahir" class="form-control inputan datepicker tgllahir_kkinsert" value="<?php echo $tgl[2]."-".$tgl[1]."-".$tgl[0];?>" >
									</div>
									<div class="col-sm-6">
										<input type="text" class="form-control inputan umur_kkinsert" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>
								<div class="radio">
									<label>
									<input type="radio" name="jeniskelamin" class="jkcls" value="0" checked>
									Tidak Diketahui
									</label>&nbsp&nbsp

									<label>
									<input type="radio" name="jeniskelamin" class="jkcls" value="L" checked>
									Laki-laki
									</label>&nbsp&nbsp
								
									<label>
									<input type="radio" name="jeniskelamin" class="jkcls" value="P">
									Perempuan
									</label>&nbsp&nbsp

									<label>
									<input type="radio" name="jeniskelamin" class="jkcls" value="3">
									Tidak Dapat Ditentukan
									</label>&nbsp&nbsp

									<label>
									<input type="radio" name="jeniskelamin" class="jkcls" value="4">
									Tidak Mengisi
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Agama</td>
							<td>
								<div class="input-group">
									<select name="agama" class="form-control inputan agamacls" required>
										<option value="">--Pilih--</option>
										<option value="ISLAM">ISLAM</option>
										<option value="KRISTEN">KRISTEN</option>
										<option value="KATOLIK">KATOLIK</option>
										<option value="HINDU">HINDU</option>
										<option value="BUDHA">BUDHA</option>
										<option value="KONGHUCU">KONGHUCU</option>
										<option value="PENGHAYAT">PENGHAYAT</option>
										<option value="LAINNYA">LAINNYA</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Suku/Bangsa</td>
							<td>
								<input type="text" name="suku" style="text-transform: uppercase;" class="form-control inputan" placeholder="Suku Pasien" required>
							</td>
						</tr>
						<tr>
							<td>Bahasa Yang Dikuasai</td>
							<td>
								<input type="text" name="bahasa" style="text-transform: uppercase;" class="form-control inputan" placeholder="Bahasa Komunikasi" required>
							</td>
						</tr>
						<tr>
							<td>Pendidikan</td>
							<td>
								<div class="input-group pendidikanclsinputhidden" style="display: none;">
									<input name="pendidikan" class="form-control inputan pendidikanclsinput" readonly="true" />
									<span class="input-group-addon editpendidikan">Edit</span>
								</div>
								<div class="input-group pendidikancls">
									<select name="pendidikan" class="form-control inputan pendidikancls" >
										<option value="">--Pilih--</option>
										<option value="BELUM SEKOLAH">BELUM SEKOLAH</option>
										<option value="TK">TK</option>
										<option value="SD">SD</option>
										<option value="SLTP">SLTP</option>
										<option value="SLTA">SLTA</option>
										<option value="D1">D1</option>
										<option value="D2">D2</option>
										<option value="D3">D3</option>
										<option value="S1">S1</option>
										<option value="S2">S2</option>
										<option value="S3">S3</option>
										<option value="TIDAK SEKOLAH">TIDAK SEKOLAH</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Pekerjaan</td>
							<td>
								<div class="input-group pekerjaanclsinputhidden" style="display: none;">
									<input name="pekerjaan" class="form-control inputan pekerjaanclsinput" readonly="true" />
									<span class="input-group-addon editpekerjaan">Edit</span>
								</div>
								<div class="input-group pekerjaancls">
									<select name="pekerjaan" class="form-control inputan" >
										<option value="">--Pilih--</option>
										<option value="BELUM BEKERJA">BELUM BEKERJA</option>
										<option value="BURUH">BURUH</option>
										<option value="GURU">GURU</option>
										<option value="HONORER">HONORER</option>
										<option value="IRT">IRT</option>
										<option value="MAHASISWA">MAHASISWA</option>
										<option value="NELAYAN">NELAYAN</option>
										<option value="PEGAWAI SWASTA">PEGAWAI SWASTA</option>
										<option value="PELAJAR">PELAJAR</option>
										<option value="PENSIUN">PENSIUN</option>
										<option value="PETANI">PETANI</option>
										<option value="PNS">PNS</option>
										<option value="POLRI">POLRI</option>
										<option value="TNI">TNI</option>
										<option value="TKI">TKI</option>
										<option value="WIRASWASTA">WIRASWASTA</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>	
						</tr>
						<tr>
							<td>Status Nikah</td>
							<td>
								<div class="input-group">
									<select name="statusnikah" class="form-control inputan stsnikahcls" required>
										<option value="">--Pilih--</option>
										<option value="BELUM KAWIN">BELUM KAWIN</option>
										<option value="KAWIN">KAWIN</option>
										<option value="CERAI HIDUP">CERAI HIDUP</option>
										<option value="CERAI MATI">CERAI MATI</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Asuransi</td>
							<td>
								<div class="input-group">
									<select name="asuransi" class="form-control inputan asuransikkinsert" required>
										<option value="">--Pilih--</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` WHERE Kota = '$kota' order by `Asuransi`");
											while($data = mysqli_fetch_assoc($query)){
												echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
											}
										?>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>	
						</tr>
						<tr>
							<td>Status Asuransi</td>
							<td>
								<div class="input-group">
									<select name="statusasuransi" class="form-control inputan stsasuransukkinsert" required>
										<option value="">--Pilih--</option>
										<option value="PESERTA">PESERTA</option>
										<option value="ISTRI">ISTRI</option>
										<option value="SUAMI">SUAMI</option>
										<option value="ANAK 1">ANAK 1</option>
										<option value="ANAK 2">ANAK 2</option>
										<option value="ANAK 3">ANAK 3</option>
										<option value="ANAK 4">ANAK 4</option>
										<option value="ANAK >5">ANAK >5</option>
									</select>
									<div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	
							</td>	
						</tr>
						<tr>
							<td>No.Asuransi</td>
							<td><input type="text" name="noasuransi" value="" class="form-control inputan noasuransikkinsert" placeholder = "JIKA UMUM / GRATIS ISI 0" required></td>
						</tr>
						<tr>
							<td>No Telepon Rumah</td>
							<td><input type="number" name="telepon_rumah" style="text-transform: uppercase;" value="0" class="form-control inputan" placeholder="Nomor telepon kediaman" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr>
						<tr>
							<td>No Telepon Selular (HP)</td>
							<td><input type="number" name="telepon" class="form-control inputan notelp" value="0" placeholder="Nomor kontak pribadi yang dapat dihubungi" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
						</tr>
					</table><hr>
					<div class="tmpdatalama"></div>
					<input type="hidden" name="forcesimpan" class="forcesimpan" value="0">
					<button type="submit" class="btn btn-round btn-success btn-block btnsimpan">SIMPAN</button>
					<button type="button" class="btn btn-danger btn-block btnbatal" style="display:none">BATAL</button>
				</form>
			</div>	
		</div>
	</div>
</div>

<div class="hasilmodal"></div>

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
			// alert(data);
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

	var tgllahir = $(".tgllahir_kkinsert").val();
	$.post( "get_umur.php", { 
		tgllahir: tgllahir
	}).done(function( data ) {
		$(".umur_kkinsert").val(data);
	});

	$(".checknik").click(function(){
		if ($(".checknik").is(':checked')){
			$(".nikcls").val('9999999999999999');
        	$(".nikcls").attr('readonly',true);
        }else{
           $(".nikcls").attr('readonly',false);
           $(".nikcls").val('');
        }
	});
	
	$('body').on("submit","form", function(event) {
		event.preventDefault();

		var urlaction = $(this).attr('action');
		var datak = $(this).serializeArray();
		var fd = new FormData();
		$.each(datak,function(key,input){
			fd.append(input.name,input.value);
		});

		$.ajax({
			type:"POST", 
			url:urlaction,
			cache: false,
			contentType: false,
			processData: false,
			data: fd,
			success: function(data){
			// console.log(data);
				var obj = JSON.parse(data);
				if(obj.keterangan == 'Kepala Keluarga Sudah Pernah Terdaftar di Puskesmas.'){
					$(".btnsimpan").text("Lanjut Simpan");
					$(".btnbatal").show();
					$(".forcesimpan").val('1');

					$.post( "get_dtpasien_detail.php", { 
						id: obj.id
					}).done(function( data ) {
						$(".tmpdatalama").html(data);
					});
				}

				var typealert = 'danger';
				if(obj.status == 'sukses'){
					typealert = 'success';
				}
				$.notify({
					icon: 'flaticon-chat',
					title: obj.status,
					message: obj.keterangan
				},{
					type: typealert,
				});

				if(obj.status == 'sukses'){
					setTimeout(function(){ 
						document.location.href='index.php?page=registrasi&idpasien='+obj.idpasien; 
					}, 1500);
				}
			}
		});
	});

	$(".btnbatal").click(function(){
		$("form")[0].reset();
		$(this).hide();
	})


	$(".btndaftarpasiennik").click(function(){		
		if("<?php echo $dtjson['content'][0]['JENIS_KLMIN'];?>" == 'Laki-Laki'){
			$(".jkcls[value='L']").prop('checked',true);
		}else{
			$(".jkcls[value='P']").prop('checked',true);
		}

		$.post( "get_umur.php", { 
			tgllahir: "<?php echo date('d-m-Y',strtotime($dtjson['content'][0]['TGL_LHR']));?>"
		}).done(function( data ) {
			$(".umur_kkinsert").val(data);
		});

		$(".namakk").val("<?php echo $namakepalakeluarga;?>");
		$(".nikcls").val("<?php echo $nik;?>");
		$(".namapasiencls").val("<?php echo $dtjson['content'][0]['NAMA_LGKP'];?>");
		$(".kepalakeluargacls").val("<?php echo $dtjson['content'][0]['STAT_HBKEL'];?>");
		$(".tgllahir_kkinsert").val("<?php echo date('d-m-Y',strtotime($dtjson['content'][0]['TGL_LHR']));?>");
		$(".agamacls").val("<?php echo $dtjson['content'][0]['AGAMA'];?>");		
		$(".stsnikahcls").val("<?php echo $stsnikah;?>");
		$(".asuransikkinsert").val("<?php echo $data_asuransi;?>");
		$(".noasuransikkinsert").val("<?php echo $noasuransi;?>");
		$(".notelp").val("<?php echo $notelp;?>");

		$(".pekerjaanclsinput").val("<?php echo $dtjson['content'][0]['JENIS_PKRJN'];?>");
		$(".pekerjaanclsinputhidden").show();
		$(".pekerjaancls").hide();
		$(".pendidikanclsinput").val("<?php echo $dtjson['content'][0]['PDDK_AKH'];?>");
		$(".pendidikanclsinputhidden").show();
		$(".pendidikancls").hide();

		$(".alamatcls").val("<?php echo $dtjson['content'][0]['ALAMAT'];?>");
		$(".rwcls").val("<?php echo $dtjson['content'][0]['NO_RW'];?>");
		$(".rtcls").val("<?php echo $dtjson['content'][0]['NO_RT'];?>");
		$(".kelurahancls").val("<?php echo $dtjson['content'][0]['KEL_NAME'];?>");
		$(".kecamatancls").val("<?php echo $dtjson['content'][0]['KEC_NAME'];?>");
		$(".kabupatencls").val("<?php echo $dtjson['content'][0]['KAB_NAME'];?>");
		$(".provinsicls").val("<?php echo $dtjson['content'][0]['PROP_NAME'];?>");
		$(".daerah").val("<?php echo $daerahnik;?>");
		$(".wilayah").val("<?php echo $wilayahnik;?>");
	});

	$(".editpendidikan").click(function(){
		$(".pendidikanclsinputhidden").hide();
		$(".pendidikancls").show();
	});
	$(".editpekerjaan").click(function(){
		$(".pekerjaanclsinputhidden").hide();
		$(".pekerjaancls").show();
	});

	
	$(".wilayah-value").change(function(){
		var isi = $('.wilayah-value :selected').text();
		$(".nama_kelurahankk").val(isi.substring(5));
	});
	
	$(".tgllahir_kkinsert").change(function(){
		var tgllahir = $(this).val();
		//alert(tgllahir);
		$.post( "get_umur.php", { 
			tgllahir: tgllahir
		}).done(function( data ) {
			$(".umur_kkinsert").val(data);
		});
	});	
	
	// $('.nama_kelurahankk').autocomplete({
	// 	serviceUrl: 'get_kelurahan.php?keyword=',
	// 	onSelect: function (suggestion){
	// 		$(this).val(suggestion.value);
	// 		$(".kode").val(suggestion.kode);
	// 		$(".koderm").val(suggestion.koderm);
	// 		$(".kelurahan").val(suggestion.kelurahan);	
	// 		$.post( "get_status_wilayah.php", { 
	// 		kelurahan: suggestion.value
	// 		}).done(function( data ) {
	// 			if(data == 'Dalam'){
	// 				$(".wilayah").val('Dalam');
	// 			}else{
	// 				$(".wilayah").val('Luar');
	// 			}
	// 		});
	// 	}
	// });	

	// $('.nama_kelurahankk').change(function(){
	// 	var isi = $(this).val();
	// 	$(".kode").val($(this).find(':selected').data('kode'));
	// 	$(".koderm").val($(this).find(':selected').data('koderm'));
	// 	$(".kelurahan").val(isi);

	// 	$.post( "get_status_wilayah.php", { 
	// 	kelurahan: isi
	// 	}).done(function( data ) {
	// 		if(data == 'Dalam'){
	// 			$(".wilayah").val('Dalam');
	// 		}else{
	// 			$(".wilayah").val('Luar');
	// 		}
	// 	});
	// 	if(isi == 'Luar Daerah'){
	// 		$(".daerah").val('Luar');
	// 	}else{
	// 		$(".daerah").val('Dalam');
	// 	}
	// });	

	
	// $('.nama_kotakk').autocomplete({
	// 	serviceUrl: 'get_kota.php?keyword=',
	// 	onSelect: function (suggestion){
	// 		$(this).val(suggestion.value);
	// 		if(suggestion.value != '<?php echo $kota ?>'){
	// 			$(".daerah").val('Luar');
	// 		}else{
	// 			$(".daerah").val('Dalam');
	// 		}
	// 	}
	// });	
	
	
	$(".namakk").click(function(){
		var poli = $(".poli").val();
		var wilayah = $(".wilayah-value").val();
		var norm6digit = $(".norm6digit").val();
		var norm = poli+wilayah+norm6digit;
		//alert(norm);
		$.post( "cek_norm.php", { 
			norm: norm
		}).done(function( data ) {
			if(data == 'false'){
				alert('Norm sudah digunakan..');
				$(".norm6digit").val('');
			}
		});
	});

	// $(".kelurahancls").focusout(function(){
	// 	var kelurahancls = $(this).val();
	// 	//alert(kelurahancls);
	// 	$.post( "cek_wilayah.php", { 
	// 	kelurahan: kelurahancls
	// 	}).done(function( data ) {
	// 		if(data == 0){
	// 			$(".wilayah").val('Luar');
	// 		}else{
	// 			$(".wilayah").val('Dalam');
	// 		}
	// 	});
	// });
	
	// $(".nama_kotakk").focusout(function(){
	// 	var kota = $(this).val();
	// 	var kotases = '<?php echo $kota;?>';
	// 	var kelurahan = $(".kelurahancls").val();
	// 	if(kota == kotases){
	// 		$.post( "cek_wilayah.php", { 
	// 		kelurahan: kelurahan
	// 		}).done(function( data ) {
	// 			if(data == 0){
	// 				$(".wilayah").val('Luar');
	// 			}else{
	// 				$(".wilayah").val('Dalam');
	// 			}
	// 		});

	// 		$(".daerah").val('Dalam');
	// 	}else{
	// 		$(".wilayah").val('Luar');
	// 		$(".daerah").val('Luar');
	// 	}
	// });
	
});
</script>