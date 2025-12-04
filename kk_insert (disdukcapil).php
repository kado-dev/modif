<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$profinsi = $_SESSION['profinsi'];
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
<div class="row">	
	<div class="col-lg-12">
		<?php 
			echo $_COOKIE['alert'];
		?>	
		<div class="tableborderdiv">
			<a href="index.php?page=registrasi_form" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>PASIEN BARU</b></h3>
			<div class = "formbg" style="padding: 50px 50px 50px 50px;">
				<div class="tableborder">
					<?php if ($_SESSION['kota'] == "KABUPATEN BANDUNG"){?>
					<form> 
						<div class="row">
							<div class="col-sm-10">
								<input type="hidden" name="page" value="kk_insert"/>
								<input type="text" value="<?php echo $_GET['key'];?>" name="key" class="form-control" style="display: inline; padding: 25px;" placeholder="Ketikan 16 Digit NIK..." maxlength="16"/>
							</div>
							<div class="col-sm-2">
								<input type="submit" class="btnsimpan" value="Cari"/>
							</div>
						</div>
					</form>
					<?php
					$namakepalakeluarga = "";
					$nik = "";
					$stsnikah = "";
					$kelurahannik = "";
					$kabnik = $kota;
					$daerahnik = '';
					$wilayahnik = '';
					$noasuransi = '0';
					$notelp = '0';

						if($_GET['key'] != null){
							if(strlen($_GET['key']) == 13){//bpjs
								include "config/helper_bpjs.php";
								$data_bpjs = get_data_peserta_bpjs($_GET['key']);								
								$dtbpjs = json_decode($data_bpjs,true);
								// echo $data_bpjs;
								if($dbpjs['response']['jnsPeserta']['nama'] == 'PBI (APBN)' || $dbpjs['response']['jnsPeserta']['nama'] == 'PBI (APBD)'){
									$data_asuransi = 'BPJS PBI';
								}else{
									$data_asuransi = 'BPJS NON PBI';
								}
								$noasuransi = $_GET['key'];
								$noktp = $dtbpjs['response']['noKTP'];
								$notelp = $dtbpjs['response']['noHP'];

								$getnik = file_get_contents("https://simpus.bandungkab.go.id/helper_casip.php?nik=".$noktp);
								$dtjson = json_decode($getnik,true);
								$statustarik = $dtjson['content'][0]['RESPONSE_CODE'];

								$namalengkap = $dtjson['content'][0]['NAMA_LGKP'];
								$tempatlahir = $dtjson['content'][0]['TMPT_LHR'];
								$tgllahir = $dtjson['content'][0]['TGL_LHR'];
								$jeniskelamin = $dtjson['content'][0]['JENIS_KLMIN'];
								$alamat = $dtjson['content'][0]['ALAMAT'].", RT. ".$dtjson['content'][0]['NO_RT'].", RW.".$dtjson['content'][0]['NO_RW']." 
									<br/>KEL/DESA. ".$dtjson['content'][0]['KEL_NAME'].", KEC. ".$dtjson['content'][0]['KEC_NAME'];
								$kabupaten = $dtjson['content'][0]['KAB_NAME'];	
								$agama = $dtjson['content'][0]['AGAMA'];
								$sts_kawin = $dtjson['content'][0]['STATUS_KAWIN'];
								$pekerjaan = $dtjson['content'][0]['JENIS_PKRJN'];
								$pendidikan = $dtjson['content'][0]['PDDK_AKH'];
								$namaayah = $dtjson['content'][0]['NAMA_LGKP_AYAH'];
								$namaibu = $dtjson['content'][0]['NAMA_LGKP_IBU'];

								if($dtjson['content'][0]['STAT_HBKEL'] == 'KEPALA KELUARGA'){
									$namakepalakeluarga = $dtjson['content'][0]['NAMA_LGKP'];
								}
								if($dtjson['content'][0]['STATUS_KAWIN'] == 'KAWIN'){
									$stsnikah = "MENIKAH";
								}else if($dtjson['content'][0]['STATUS_KAWIN'] == 'BELUM KAWIN'){
									$stsnikah = "BELUM MENIKAH";
									$namakepalakeluarga = $dtjson['content'][0]['NAMA_LGKP_AYAH'];	
								}else{
									$stsnikah = $dtjson['content'][0]['STATUS_KAWIN'];
								}
								if($dtjson['content'][0]['NIK'] != null){
									$nik = $noktp;
								}

								$kelurahannik = $dtjson['content'][0]['KEL_NAME'];
								if($dtjson['content'][0]['KAB_NAME'] == 'BANDUNG'){
									$kabnik = 'KABUPATEN '.$dtjson['content'][0]['KAB_NAME'];
								}else{
									$kabnik = $dtjson['content'][0]['KAB_NAME'];
								}

								if($kota == $kabnik){
									$daerahnik = 'Dalam';
									
									$cekwil = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbkelurahan WHERE KodePuskesmas = '$kodepuskesmas' AND Kelurahan = '$kelurahannik'"));
									if($cekwil == 0){
										$wilayahnik = 'Luar';
									}else{
										$wilayahnik = 'Dalam';
									}
								}else{
									$daerahnik = 'Luar';
									$wilayahnik = 'Luar';
								}
								
							}else{			
								include "config/helper_casip.php";		
								// $getnik = file_get_contents("http://simpus.bandungkab.go.id/helper_casip.php?key=".$_GET['key']);
								$getnik = get_data_casip($_GET['key']);								
								$dtjson = json_decode($getnik,true);
								// echo "hasil : ".$getnik;
								$statustarik = $dtjson['content'][0]['RESPONSE_CODE'];
								$namalengkap = $dtjson['content'][0]['NAMA_LGKP'];
								$tempatlahir = $dtjson['content'][0]['TMPT_LHR'];
								$tgllahir = $dtjson['content'][0]['TGL_LHR'];
								$jeniskelamin = $dtjson['content'][0]['JENIS_KLMIN'];
								$alamat = $dtjson['content'][0]['ALAMAT'].", RT. ".$dtjson['content'][0]['NO_RT'].", RW.".$dtjson['content'][0]['NO_RW']." 
									<br/>KEL/DESA. ".$dtjson['content'][0]['KEL_NAME'].", KEC. ".$dtjson['content'][0]['KEC_NAME'];
								$kabupaten = $dtjson['content'][0]['KAB_NAME'];	
								$agama = $dtjson['content'][0]['AGAMA'];
								$sts_kawin = $dtjson['content'][0]['STATUS_KAWIN'];
								$pekerjaan = $dtjson['content'][0]['JENIS_PKRJN'];
								$pendidikan = $dtjson['content'][0]['PDDK_AKH'];
								$namaayah = $dtjson['content'][0]['NAMA_LGKP_AYAH'];
								$namaibu = $dtjson['content'][0]['NAMA_LGKP_IBU'];

								if($dtjson['content'][0]['STAT_HBKEL'] == 'KEPALA KELUARGA'){
									$namakepalakeluarga = $dtjson['content'][0]['NAMA_LGKP'];
								}
								if($dtjson['content'][0]['STATUS_KAWIN'] == 'KAWIN'){
									$stsnikah = "MENIKAH";
								}else if($dtjson['content'][0]['STATUS_KAWIN'] == 'BELUM KAWIN'){
									$stsnikah = "BELUM MENIKAH";
									$namakepalakeluarga = $dtjson['content'][0]['NAMA_LGKP_AYAH'];	
								}else{
									$stsnikah = $dtjson['content'][0]['STATUS_KAWIN'];
								}
								if($dtjson['content'][0]['NIK'] != null){
									$nik = $_GET['key'];
								}

								$kelurahannik = $dtjson['content'][0]['KEL_NAME'];
								if($dtjson['content'][0]['KAB_NAME'] == 'BANDUNG'){
									$kabnik = 'KABUPATEN '.$dtjson['content'][0]['KAB_NAME'];
								}else{
									$kabnik = $dtjson['content'][0]['KAB_NAME'];
								}

								if($kota == $kabnik){
									$daerahnik = 'Dalam';
									
									$cekwil = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbkelurahan WHERE KodePuskesmas = '$kodepuskesmas' AND Kelurahan = '$kelurahannik'"));
									if($cekwil == 0){
										$wilayahnik = 'Luar';
									}else{
										$wilayahnik = 'Dalam';
									}
								}else{
									$daerahnik = 'Luar';
									$wilayahnik = 'Luar';
								}

								if(substr($kodepuskesmas, 1,4) == substr($nik, 0,4)){
									$data_asuransi = 'GRATIS';
								}else{
									$data_asuransi = 'UMUM';
								}
								
							}
							
					?>
					<div class="tbdetailform">
						<?php
							if($statustarik == '02'){
								echo "Data tidak ditemukan";
							}else{
						?>
						
						<table width="100%" class="tbdetail">							
							<tr>
								<td width="150px">NIK</td>
								<td width="20px">:</td>
								<td><?php echo $nik;?></td>
							</tr>
							<tr>
								<td>Nama Lengkap</td>
								<td>:</td>
								<td><?php echo $namalengkap;?></td>
							</tr>
							<tr>
								<td>Tempat/Tgl.Lahir</td>
								<td>:</td>
								<td><?php echo $tempatlahir;?> / <?php echo $tgllahir;?></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td><?php echo $jeniskelamin;?></td>
							</tr>
							<tr>
								<td style="vertical-align:top;">Alamat</td>
								<td style="vertical-align:top;">:</td>
								<td>
									<?php 
									echo $alamat;
									?>
								</td>
							</tr>
							<tr>
								<td>Kab/Kota</td>
								<td>:</td>
								<td><?php echo $kabupaten;?></td>
							</tr>
							<tr>
								<td>Agama</td>
								<td>:</td>
								<td><?php echo $agama;?></td>
							</tr>
							<tr>
								<td>Status Perkawinan</td>
								<td>:</td>
								<td><?php echo $sts_kawin;?></td>
							</tr>
							<tr>
								<td>Pekerjaan</td>
								<td>:</td>
								<td><?php echo $pekerjaan;?></td>
							</tr>
							<tr>
								<td>Pendidikan</td>
								<td>:</td>
								<td><?php echo $pendidikan;?></td>
							</tr>
							<tr>
								<td>Nama Ayah</td>
								<td>:</td>
								<td><?php echo $namaayah;?></td>
							</tr>
							<tr>
								<td>Nama Ibu</td>
								<td>:</td>
								<td><?php echo $namaibu;?></td>
							</tr>
							<tr>
								<td colspan="3"><button class="btninfo btndaftarpasiennik" style="margin-top:20px;">Daftar Sebagai Pasien</button></td>
							</tr>
						</table>
							<?php
								}
							?>
					</div>
					<br/>
					<?php		
						}
					}
					?>
					
					<form class="form-horizontal" action="kk_insert_proses.php" method="post" role="form">
						<table class="table table-condensed" width="100%">							
							<?php if($kota == "KABUPATEN BULUNGAN"){?>
							<tr>
								<td width="20%">No.RM</td>
								<td width="80%" class="row">
									<div class="form-group">
										<div class="col-md-3">
											<select name="norm1" class="form-control poli">
												<option value="01" selected>01 - Umum</option> 
												<option value="02">02 - Lansia</option> 
											</select>
										</div>
										<div class="col-md-4">
											<div class="input-group">
												<select name="norm2" class="form-control wilayah-value">
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
											<input type="text" name="norm3" value="" class="form-control norm6digit" size="4" maxlength="6" required="">
										</div>
										<a href="#" class="btn btn-sm btn-default btnmodalrm" style="border-radius:20px; text-decoration: none;">Bank RM</a>
									</div>
								</td>
							</tr>
							<?php }elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){ ?>
							<tr>
								<td width="20%">No.RM</td>
								<td width="80%">
									<input type="text" name="norm" class="form-control" maxlength="8" placeholder="Ketik Manual">
								</td>
							</tr>								
							<?php } ?>
							
							
							<!--Data Kepala Keluarga-->
							<h4><b>DATA KEPALA KELUARGA</b></h4><hr/>
							</tr>
							<tr>
								<td width="20%">Nama Kepala Keluarga</td>
								<td width="80%"><input type="text" name="namakk" style="text-transform: uppercase;" class="form-control namakk" placeholder="Nama KK sesuai KTP" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>
									<div class="row" >
										<div class="col-sm-12"> 
											<input type="text" name="alamat" style="text-transform: uppercase;" class="form-control alamatcls" placeholder = "Sesuai KTP" required>
										</div>
										<div class="col-sm-2" style="padding:10px 15px 0px 15px">
											<div class="input-group">
												<input type="number" name="rt" class="form-control rtcls" maxlength ="2" placeholder = "RT" required>	
												<span class="input-group-addon">RT</span>
											</div>					
										</div>
										<div class="col-sm-2" style="padding:10px 15px 0px 12px">
											<div class="input-group">
												<input type="number" name="rw" class="form-control rwcls" maxlength ="2" placeholder = "RW" required>
												<span class="input-group-addon">RW</span>
											</div>
										</div>																				
										<div class="col-sm-2" style="padding:10px 15px 0px 15px">
											<div class="input-group">
												<input type="text" name="no" class="form-control" maxlength ="5" placeholder = "No" required>
												<span class="input-group-addon">NO</span>
											</div>								
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Kelurahan</td>
								<td>
									<!--
									<input type="text" name="kelurahan" class="form-control nama_kelurahankk kelurahancls" required>-->
									<select name="kelurahan" class="form-control nama_kelurahankk kelurahancls">
										<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' ORDER by Kelurahan");
										?>
										<option value="">--Pilih--</option>
										<?php
											while($dtk = mysqli_fetch_assoc($query)){
												echo "<option value='$dtk[Kelurahan]' data-koderm='$dtk[KodeRM]' data-kode='$dtk[Kode]'>$dtk[Kelurahan]</option>";
											}
										?>
										<option data-koderm="09" data-kode="" value="Luar Wilayah">Luar Wilayah</option>
										<option data-koderm="99" data-kode="" value="Luar Daerah">Luar Daerah</option>
									</select>
								</td>
							</tr>
							<!--<tr>
								<td>Kecamatan</td>
								<td>
									<div class="input-group">
										<select type="text" name="kecamatan" class="form-control nama_kecamatan chosenselect" required>
											<?php
												// $qry_kec = mysqli_query($koneksi,"SELECT * FROM `ref_kecamatan`");
												// while($dtkec = mysqli_fetch_assoc($qry_kec)){
													// echo "<option value='$dtkec[KECDESC]'>$dtkec[KECDESC]</option>";
												// }
											?>
										</select>
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>
							</tr>-->
							<tr>
								<td>Kecamatan</td>
								<td><input type="text" name="kecamatan" class="form-control nama_kecamatan kecamatancls" value="<?php echo strtoupper($kecamatan);?>"></td>
							</tr>
							<tr>
								<td>Kota</td>
								<td><input type="text" name="kota" class="form-control nama_kotakk kabupatencls" value="<?php echo $kota;?>"></td>
							</tr>
							<tr>
								<td>Provinsi</td>
								<td><input type="text" name="provinsi" class="form-control nama_provinsi provinsicls" value="<?php echo $profinsi;?>"></td>
							</tr>
							<tr>
								<td>Wilayah Kerja</td>
								<td>
									<select name="wilayah" class="form-control wilayah" required>
										<option value="">--Pilih--</option>
										<option value="Luar">LUAR</option>
										<option value="Dalam" selected="true">DALAM</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Daerah</td>
								<td class="col-sm-9">
									<select name="daerah" class="form-control daerah" required>
										<option value="">--Pilih--</option>
										<option value="Luar">LUAR</option>
										<option value="Dalam" selected="true">DALAM</option>
									</select>
								</td>
							</tr>
							
						</table>	
						

						<!--Data Pasien-->						
						<table class="table table-condensed" width="100%">								
							<h4><b>DATA PASIEN</b></h4><hr/>
							<?php
								if($kota == "KABUPATEN BANDUNG"){
							?>
							<tr>
								<td width="20%">New No.RM</td>
								<td width="80%" class="row">
									<div class="form-group">
										<div class="col-md-3">
											<div class="input-group">
												<input type="text" name="koderm" class="form-control koderm" readonly>
												<span class="input-group-addon">Kd.Desa</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-group">
												<select name="statuskeluarga" class="form-control kepalakeluargacls" required>
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
												<span class="input-group-addon">Pilih</span>
											</div>
										</div>
										<a href="#" class="btn btn-sm btn-default btnmodalrm_bandungkab" style="border-radius:20px; text-decoration: none;">Bank RM</a>
									</div>
								</td>
							</tr>
							<?php 
								}
								if($kota != "KABUPATEN BANDUNG"){
							?>							
							<tr>
								<td width="20%">Status Keluarga</td>
								<td width="80%">
									<div class="input-group">
										<!--<select name="statuskeluarga" class="form-control statuskeluargapilih" required>-->
										<select name="statuskeluarga" class="form-control kepalakeluargacls" required>
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
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>
							</tr>
							<?php 
								}
							?>	
							<tr class="nikkkinsert">
								<td width="20%">NIK Pasien</td>
								<td width="80%">
									<input type="text" name="nik" class="form-control nikcls" placeholder="SESUAI KTP" required>
								</td>
							</tr>
							<!--<tr class="namapasienkkinsert">-->
							<tr>
								<td>Nama Pasien</td>
								<td>
									<input type="text" name="namapasien" style="text-transform: uppercase;" class="form-control namapasiencls" placeholder="SESUAI KTP">
								</td>
							</tr>
							<tr>
								<td>Tgl.Lahir & Perkiraan Umur</td>
								<td>
									<div class="row ">
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon tesdate">
													<span class="fa fa-calendar"></span>
												</span>
												<?php
													$tgl = explode("-",date ('1970-m-d'));											
												?>
												<input type="text" name="tanggallahir" class="form-control datepicker tgllahir_kkinsert" value="<?php echo $tgl[2]."-".$tgl[1]."-".$tgl[0];?>" >
											</div>
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control umur_kkinsert" readonly>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								
								<td>
									<div class="radio">
										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="L">
										Laki-laki
										</label>
									
										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="P">
										Perempuan
										</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Agama</td>
								<td>
									<div class="input-group">
										<select name="agama" class="form-control agamacls" required>
											<option value="">--Pilih--</option>
											<option value="BUDHA">BUDHA</option>
											<option value="HINDU">HINDU</option>
											<option value="ISLAM">ISLAM</option>
											<option value="KATHOLIK">KATHOLIK</option>
											<option value="KONGHUCU">KONGHUCU</option>
											<option value="KRISTEN">KRISTEN</option>
										</select>
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>
							</tr>
							<tr>
								<td>Status Nikah</td>
								<td>
									<div class="input-group">
										<select name="statusnikah" class="form-control stsnikahcls" required>
											<option value="">--Pilih--</option>
											<option value="BELUM MENIKAH">BELUM MENIKAH</option>
											<option value="MENIKAH">MENIKAH</option>
											<option value="JANDA">JANDA</option>
											<option value="DUDA">DUDA</option>
										</select>
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>
							</tr>
							<tr>
								<td>Pendidikan</td>
								<td>
									<div class="input-group pendidikanclsinputhidden" style="display: none;">
										<input name="pendidikan" class="form-control pendidikanclsinput" readonly="true" />
										<span class="input-group-addon editpendidikan">Edit</span>
									</div>
									<div class="input-group pendidikancls">
										<select name="pendidikan" class="form-control pendidikancls" >
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
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>
							</tr>
							<tr>
								<td>Pekerjaan</td>
								<td>
									<div class="input-group pekerjaanclsinputhidden" style="display: none;">
										<input name="pekerjaan" class="form-control pekerjaanclsinput" readonly="true" />
										<span class="input-group-addon editpekerjaan">Edit</span>
									</div>
									<div class="input-group pekerjaancls">
										
										<select name="pekerjaan" class="form-control" >
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
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>	
							</tr>
							<tr>
								<td>Asuransi</td>
								<td>
									<div class="input-group">
										<select name="asuransi" class="form-control asuransikkinsert" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` WHERE Kota = '$kota' order by `Asuransi`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
												}
											?>
										</select>
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>	
							</tr>
							<tr>
								<td>Status Asuransi</td>
								<td>
									<div class="input-group">
										<select name="statusasuransi" class="form-control stsasuransukkinsert" required>
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
										<span class="input-group-addon">Pilih</span>
									</div>	
								</td>	
							</tr>
							<tr>
								<td>No.Asuransi</td>
								<td><input type="text" name="noasuransi" value="" class="form-control noasuransikkinsert" placeholder = "JIKA UMUM / GRATIS ISI 0" required></td>
							</tr>
							<tr>
								<td>Telepon</td>
								<td><input type="number" name="telepon" class="form-control notelp" value="0" required></td>
							</tr>
						</table><hr>
						<button type="submit" class="btnsimpan">Simpan</button>
					</form>
				</div>
			</div>		
		</div>
	</div>
</div>
<div class="hasilmodal">

</div>
<script src="assets/js/jquery.js"></script>
<script>
$(document).ready(function() {
	var tgllahir = $(".tgllahir_kkinsert").val();
	$.post( "get_umur.php", { 
		tgllahir: tgllahir
	}).done(function( data ) {
		$(".umur_kkinsert").val(data);
	});

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

	$('.nama_kelurahankk').change(function(){
			var isi = $(this).val();
			$(".kode").val($(this).find(':selected').data('kode'));
			$(".koderm").val($(this).find(':selected').data('koderm'));
			$(".kelurahan").val(isi);

			$.post( "get_status_wilayah.php", { 
			kelurahan: isi
			}).done(function( data ) {
				if(data == 'Dalam'){
					$(".wilayah").val('Dalam');
				}else{
					$(".wilayah").val('Luar');
				}
			});
			if(isi == 'Luar Daerah'){
				$(".daerah").val('Luar');
			}else{
				$(".daerah").val('Dalam');
			}
	});	

	
	$('.nama_kotakk').autocomplete({
		serviceUrl: 'get_kota.php?keyword=',
		onSelect: function (suggestion){
			$(this).val(suggestion.value);
			if(suggestion.value != '<?php echo $kota ?>'){
				$(".daerah").val('Luar');
			}else{
				$(".daerah").val('Dalam');
			}
		}
	});	
	
	
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

	$(".kelurahancls").focusout(function(){
		var kelurahancls = $(this).val();
		//alert(kelurahancls);
		$.post( "cek_wilayah.php", { 
		kelurahan: kelurahancls
		}).done(function( data ) {
			if(data == 0){
				$(".wilayah").val('Luar');
			}else{
				$(".wilayah").val('Dalam');
			}
		});
	});
	
	$(".nama_kotakk").focusout(function(){
		var kota = $(this).val();
		var kotases = '<?php echo $kota;?>';
		var kelurahan = $(".kelurahancls").val();
		if(kota == kotases){
			$.post( "cek_wilayah.php", { 
			kelurahan: kelurahan
			}).done(function( data ) {
				if(data == 0){
					$(".wilayah").val('Luar');
				}else{
					$(".wilayah").val('Dalam');
				}
			});

			$(".daerah").val('Dalam');
		}else{
			$(".wilayah").val('Luar');
			$(".daerah").val('Luar');
		}
	});
	
});
</script>