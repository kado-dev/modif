<?php
	include "config/helper_pasienrj.php";
	$tgl = $_GET['tgl'];
	$nama = $_GET['nama'];	
	$asalpasien = $_SESSION['layanan_dipilih'];
	$jaminan = $_GET['asuransi'];
?>

<div class="page-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h2 class="judul">Data Registrasi</h2>
					<form  class="submit">
						<div class="row">
							<div class="col-xl-2">
								<input type="text" name="tgl" class="form-control inputan datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
							</div>
							<div class="col-xl-3">
								<input type="text" name="nama" class="form-control inputan" value="<?php echo $_GET['nama'];?>" placeholder = "Ketikan Nama Pasien">
							</div>
							<div class="col-xl-2">
								<select name="asalpasien" class="form-control inputan asuransi">
									<option value='semua_pasien'>SEMUA</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` order by `AsalPasien` ASC");
										while($data = mysqli_fetch_assoc($query)){
											if($_GET['asalpasien'] == $data['Id']){
												echo "<option value='$data[Id]' selected>$data[AsalPasien]</option>";
											}else{
												echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
											}
										}
									?>
								</select>
							</div>
							<div class="col-xl-2">
								<select name="asuransi" class="form-control inputan asuransi" required>
									<option value='semua' <?php if($_GET['asuransi'] == 'semua'){echo "SELECTED";}?>>SEMUA</option>
									<option value='semuabpjs' <?php if($_GET['asuransi'] == 'semuabpjs'){echo "SELECTED";}?>>SEMUA BPJS</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` ORDER BY `Asuransi` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asuransi'] == $data['Asuransi']){
										echo "<option value='$data[Asuransi]' SELECTED>$data[Asuransi]</option>";
										}else{
										echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="col-xl-3">
								<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
								<a href="?page=registrasi_data" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
								<a href="?page=registrasi_form" class="btn btn-success btn-round"><span class="fa fa-plus"></span> Registrasi</a>
							</div>
							<input type="hidden" name="page" value="registrasi_data"/>
						</div>	
					</form>
				</div>

				<!--data registrasi-->
				<?php
					$jumlah_perpage = 10;
						
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
								
					if($tgl != null){
						$tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d',strtotime($tgl))."' ";
					}else{
						$tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d')."' ";
					}
					
					if($nama != null){
						$nama_str = " AND (`NamaPasien` LIKE '%$nama%' OR `NoUrutBpjs` = '$nama' OR `NoRegistrasi` = '$nama')";
					}else{
						$nama_str = " ";
					}	
					
					if($asalpasien != "semua_pasien"){
						$asalpasien = " AND `Asalpasien` LIKE '%$asalpasien%'";
					}else{
						$asalpasien = " ";
					}

					if($jaminan == "semua"){
						$jaminan = "";
					}elseif($jaminan == "semuabpjs"){
						$jaminan = " AND (SUBSTRING(Asuransi,1,4) = 'BPJS')";
					}else{
						$jaminan = " AND `Asuransi` LIKE '%$jaminan%'";
					}		
					
					$str = "SELECT * FROM `$tbpasienrj` WHERE ".$tgl_str.$nama_str.$asalpasien.$jaminan;		
					$str2 = $str." ORDER BY `NoRegistrasi` DESC LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
								
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi, $str2);
					if(mysqli_num_rows($query) > 0){
				?>

				<div class="panel-default hasilmodal"></div>
			
				<div class="page-inner mt--4">
					<div class="row">
						<div class="table-responsive">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="3%">NO.</th>
										<th width="15%">Tanggal Registrasi</th>
										<th width="20%">Nama Pasien</th>
										<th width="18%">Pelayanan</th>
										<th width="8%">Kunjungan</th>
										<th width="8%">Status<br/>Pelayanan</th>
										<th width="10%">Cara Bayar</th>
										<th width="10%">Id Encounter<br/>Satusehat</th>
										<th width="15%">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									while($data = mysqli_fetch_assoc($query)){
										$no = $no + 1;
										$idpasien = $data['IdPasien'];
										$nikps = $data['Nik'];
										$noindex = $data['NoIndex'];
										$nocm = $data['NoCM'];
										$noregistrasi = $data['NoRegistrasi'];
										$kunjungan = $data['StatusKunjungan'];
										$nourutbpjs = strlen($data['NoUrutBpjs']);
										$nobpjs = $data['nokartu'];
										// echo "No.".$nourutbpjs;
										
										if(substr($data['Asuransi'],0,4) == 'BPJS' AND ($nourutbpjs >= 5 OR $data['NoUrutBpjs'] == "" OR $data['NoUrutBpjs'] == "0" OR $data['NoUrutBpjs'] == "P")){
											$statusbridging = "gagal";
										}else{
											$statusbridging = $data['NoUrutBpjs'];
										}	
										
										if($kunjungan == 'Baru'){
											if(substr($data['Asuransi'],0,4) == 'BPJS' AND ($nourutbpjs >= 5 OR $data['NoUrutBpjs'] == "" OR $data['NoUrutBpjs'] == "0" OR $data['NoUrutBpjs'] == 'P')){
												$stylewarna = "style='background:#ffbcbc'";
											}else{
												$stylewarna = "style='background:#b3ecfd'";
											}
										}else{
											if(substr($data['Asuransi'],0,4) == 'BPJS' AND ($nourutbpjs >= 5 OR $data['NoUrutBpjs'] == "" OR $data['NoUrutBpjs'] == "0" OR $data['NoUrutBpjs'] == 'P')){
												$stylewarna = "style='background:#ffbcbc'";
											}else{
												$stylewarna = "";
											}
										}

										// nik pasien
										if($nikps == '1' OR $nikps == '0' OR $nikps == ''){
											$nikpasien = '9999999999999999';
										}else{
											$nikpasien = $nikps;	
										}

										// nobpjs pasien
										if($nobpjs == '' OR $nobpjs == '-' OR $nobpjs == '0'){
											$nomorbpjs = '0';
										}else{
											$nomorbpjs = $nobpjs;	
										}

										// jenis kelamin
										if($data['JenisKelamin'] == 'L'){
											$jeniskelamin = "LAKI-LAKI";
										}else{
											$jeniskelamin = "PEREMPUAN";
										}

										// tbkk
										$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kecamatan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$noindex'";
										$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

										// ec_subdistricts
										$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
										if($dt_subdis['subdis_name'] != ''){
											$kelurahan = $dt_subdis['subdis_name'];
										}else{
											$kelurahan = $datakk['Kelurahan'];
										}

										// ec_districts
										$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
										if($dt_dis['dis_name'] != ''){
											$kecamatan = $dt_dis['dis_name'];
										}else{
											$kecamatan = $datakk['Kecamatan'];
										}

										// ec_cities
										$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
										if($dt_citi['city_name'] != ''){
											$kota = $dt_citi['city_name'];
										}else{
											$kota = $datakk['Kota'];
										}

										if($datakk['Alamat'] != ''){
											$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", <b>".
											strtoupper($kelurahan)."</b>, ".strtoupper($kecamatan).", ".strtoupper($kota);
										}else{
											$alamat = "Tidak ditemukan";
										}

										?>
										<tr <?php echo $stylewarna;?>>
											<td align="center"><?php echo $no;?></td>
											<td align="center">
												<?php 
													echo $data['TanggalRegistrasi']."<br/>".
													'<b>Id.Reg</b> : &nbsp'.$data['IdPasienrj']."<br/>";
												?>
											</td>
											<?php 
												if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
													$norms = substr($data['NoRM'],-6);
												}elseif($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
													$norms = substr($data['NoRM'],-8);
												}elseif($_SESSION['kota'] == 'KABUPATEN GARUT'){
													$norms = substr($data['NoRM'],1,6);	
												}else{
													if(strlen($data['NoRM']) == 22){
														$norms = substr($data['NoRM'],-11);
													}elseif(strlen($data['NoRM']) == 20){
														$norms = substr($data['NoRM'],-9);
													}elseif(strlen($data['NoRM']) == 17){
														$norms = substr($data['NoRM'],-6);
													}elseif(strlen($data['NoRM']) == 11 and $data['NoRM'] <> $kodepuskesmas){
														$norms = substr($data['NoRM'],-11);
													}else{
														$norms = '0';
													}
												}
											?>
											<td align="left">
												<?php echo "<b>".strtoupper($data['NamaPasien'])."</b><br/>";?>
												<?php 
													// asal pasien
													$asal_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `AsalPasien` FROM `tbasalpasien` WHERE `Id`='$data[AsalPasien]'"));
													
													if($data['UmurTahun'] != '0'){
														$umur = $data['UmurTahun']." Th";
													}else{
														$umur = $data['UmurBulan']." Bl";
													}	

													echo "<b> NIK</b> : ".$nikpasien."<br/>".
													'<b>No.BPJS</b> : &nbsp'.$nomorbpjs."<br/>".
													'<b>No.Index</b> : &nbsp'.substr($data['NoIndex'],-10)."<br/>".
													'<b>No.RM</b> : &nbsp'.$norms."<br/>".
													'<b>Tgl.Lahir</b> : &nbsp'.date('d-m-Y', strtotime($data['TanggalLahir']))." (".$umur.")<br/>".
													'<b>Jns.Kelamin</b> : &nbsp'.$jeniskelamin."<br/>".
													'<b>Alamat</b> : &nbsp'.$alamat."<br/>".
													'<i class="icon-user"></i>&nbsp<b>'.strtoupper($data['NamaPegawaiSimpan'])."</b><br/>".
													'<i class="icon-home"></i>&nbsp<b>'.strtoupper($asal_pasien['AsalPasien'])."</b>";
												?>
											</td>
											<td align="left">
												<?php if($data['Kir'] != ""){ ?>
													<button class="btn btn-sm btn-primary mb-1">
														<span class="btn-label">
															<i class="fa fa-bookmark"></i>
														</span>
														<?php echo $data['Kir'];?>
													</button>
												<?php } ?>
												<br/>									
												<?php if($data['StatusPelayanan'] == "Sudah"){ ?>
														<a href='index.php?page=poli_periksa_edit&id=<?php echo $data['IdPasienrj'];?>&idpr=&idps=<?php echo $idpasien;?>&pelayanan=<?php echo $data['PoliPertama'];?>&cb=<?php echo $data['Asuransi'];?>'><button class="btn btn-sm btn-success"><span class="btn-label"><i class="fas fa-code-branch"></i></span> <?php echo $data['Klaster']." - ".$data['SiklusHidup'];?></button></a><br/>
												<?php }else{ ?>
														<a href='index.php?page=poli_periksa&id=<?php echo $data['IdPasienrj'];?>&idps=<?php echo $idpasien;?>&pelayanan=<?php echo $data['PoliPertama'];?>&tptgl=&cb=<?php echo $data['Asuransi'];?>'><button class="btn btn-sm btn-success"><span class="btn-label"><i class="fas fa-code-branch"></i></span> <?php echo $data['Klaster']." - ".$data['SiklusHidup'];?></button></a><br/>
												<?php } ?>

												<?php
													echo '<b> Pelayanan</b> : '.str_replace('POLI','',$data['PoliPertama'])."<br/>".
													'<b>No.Antrian</b> : '.$data['NoAntrianPoli']."<br/>".
													'<b>Medis</b> : &nbsp'.$data['dokterBpjs'];
												?>
												<!-- <a href="index.php?page=poli&pelayanan=<?php echo $data['PoliPertama']?>&tgl=<?php echo $_GET['tgl']?>&nama=<?php echo $_GET['nama']?>&status=<?php echo $data['StatusPelayanan']?>" target="_blank" style="color:#000"></a> -->
											</td>
											<td align="center"><?php echo $data['StatusKunjungan'];?></td>
											<td align="center">
											<?php if($data['StatusPelayanan'] == 'Online'){ ?>
												<a onClick="return confirm('Data ingin diupdate...?')" href="registrasi_data_update.php?noreg=<?php echo $data['NoRegistrasi'];?>"><?php echo $data['StatusPelayanan'];?></a>
											<?php
												}else{
													echo $data['StatusPelayanan'];
												}
											?>
											</td>
											<td align="center">
												<?php 
													if($data['Asuransi'] == 'UMUM'){
														echo "UMUM";
													}elseif($data['Asuransi'] == 'PROGRAM'){
														echo "PROGRAM";
													}elseif($data['Asuransi'] == 'GRATIS'){
														echo "GRATIS";	
													}elseif($data['Asuransi'] == 'SKTM'){
														echo "SKTM";	
													}elseif($data['Asuransi'] == 'KIR'){
														echo "KIR";
													}else{
												?>
													<img src='image/logo_bpjs_bulet.png' width='70px' id='hide-option' style='padding: 10px;'/><br/>
													<?php if($statusbridging !='gagal'){ ?>
														<a href="#" class="btn btn-sm btn-round btn-success"><?php echo "NoUrut : ".$statusbridging;?></a>
													<?php }else{ ?>
														<a href="#" class="btn btn-sm btn-round btn-danger"><?php echo "Gagal Bridging";?></a>
														<a href="kirim_registrasi_bpjs.php?idrj=<?php echo $data['IdPasienrj'];?>&hal=<?php echo $_GET['h'];?>&tgl=<?php echo $_GET['tgl'];?>" class="btn btn-sm btn-round btn-info mt-2">Kirim Ulang</a>
													<?php } ?>
												<?php } ?> 
												
												<?php
													if($statusbridging == "gagal"){
														echo "<span style='font-size:10px'><b>".$data['ResBpjs']."</b></span>";
													}										
												?> 
											</td>
											<td align="center">
												<img src='image/satusehat_encounter.png' width='70px' id='hide-option' style='padding: 10px;'/>
												<?php if($data['IdKunjunganSatuSehat'] !=''){ ?>
													<a href="#" class="btnmodalencounter btn btn-sm btn-round btn-success" data-idpasienrj="<?php echo $data['IdPasienrj'];?>" data-idencounter="<?php echo $data['IdKunjunganSatuSehat'];?>"><?php echo substr($data['IdKunjunganSatuSehat'],0,8)."xxx";?></a>
												<?php }else{ ?>
													<a href="kirim_reg_encounter.php?idrj=<?php echo $data['IdPasienrj'];?>&nikps=<?php echo $data['Nik'];?>&hal=<?php echo $_GET['h'];?>&tgl=<?php echo $_GET['tgl'];?>" class="btn btn-sm btn-round btn-info mt-2">Kirim Encounter</a>
												<?php } ?>
											</td>
											<td align="center">
												<a href="etiket_pendaftaran.php?idprj=<?php echo $data['IdPasienrj'];?>" target="_blank" class="btn btn-info">Etiket</a><br/>
												<div class="btn-group mt-2">
													<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="true">OPSI<span class="ace-icon icon-on-right"></span></button>
													<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(303px, 43px, 0px); top: 0px; left: 0px; will-change: transform;">
														<a class="dropdown-item" href="?page=registrasi_edit&id=<?php echo $data['IdPasienrj'];?>">EDIT</a></li>
														<?php if($data['StatusPelayanan'] == 'Antri'){?>
															<li><a class="dropdown-item" onClick="return confirm('Data ingin dihapus...?')" href="registrasi_delete.php?idprj=<?php echo $data['IdPasienrj'];?>">DELETE</a></li>
														<?php }?>
														<li>
															<a href="#" class="dropdown-item modal_pasienrj" type="button">
																<input type="hidden" class="idpsrj" value="<?php echo $data['IdPasienrj'];?>">
																DETAIL
															</a>
														</li>
														<li><a class="dropdown-item" href="rekam_medis_blangko.php?noreg=<?php echo $data['NoRegistrasi'];?>&nocm=<?php echo $data['NoCM'];?>&noidx=<?php echo $data['NoIndex'];?>">BLANGKO RME</a></li>
														<?php if($statusbridging == 'gagal'){ ?>	
															<li>
																<a href="kirim_registrasi_bpjs.php?idrj=<?php echo $data['IdPasienrj'];?>&hal=<?php echo $_GET['h'];?>&tgl=<?php echo $_GET['tgl'];?>" class="dropdown-item">Kirim Ulang Bpjs</a>
															</li>
														<?php } ?>
													</div>
												</div><br/>
												<?php 
													// $cek_gen =  mysqli_query($koneksi,"SELECT * FROM `$tbgeneralkonsen` WHERE IdPasien = '$data[IdPasien]'");
													// if(mysqli_num_rows($cek_gen) > 0){ 
												?>	
													<!-- <a href="#" class="btn btn-round btn-success">General Konsen</a> -->
												<?php //}else{ ?>
													<!-- <a href="#" class="btn btn-round btn-danger btnmdlttd" data-idpasien="<?php echo $data['IdPasien'];?>" data-nama="<?php echo $data['NamaPasien'];?>" data-nik="<?php echo $nikpasien;?>">General Konsen</a> -->
												<?php //} ?>
											</td>			
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<hr/>
							<ul class="pagination mt-4 noprint">
								<?php
									$query2 = mysqli_query($koneksi,$str);
									$jumlah_query = mysqli_num_rows($query2);
									
									if(($jumlah_query % $jumlah_perpage) > 0){
										$jumlah = ($jumlah_query / $jumlah_perpage)+1;
									}else{
										$jumlah = $jumlah_query / $jumlah_perpage;
									}
									for ($i=1;$i<=$jumlah;$i++){
									$max = $_GET['h'] + 5;
									$min = $_GET['h'] - 4;
										if($i <= $max && $i >= $min){
											if($_GET['h'] == $i){
												echo "<li class='active'><span class='current'>$i</span></li>";
											}else{
												echo "<li><a href='?page=registrasi_data&tgl=$tgl&nama=$key&asalpasien=$_GET[asalpasien]&asuransi=$_GET[asuransi]&h=$i'>$i</a></li>";
											}
										}
									}
								?>	
							</ul>

							<div class="card">
								<div class="card-body">
									<p><b>Perhatikan :</b><br/>
									Garis Biru, menandakan pasien baru<br/>
									Garis Pink, menandakan peserta bpjs yang belum mendapatkan nomor urut (Gagal Bridging)<br/>
									Jika terjadi kendala koneksi, silahkan klik menu <a href="registrasi_export.php?key=<?php echo $tgl;?>&nama=<?php echo $nama;?>" style='color:#005184;font-weight:bold'>"Export Data BPJS"</a> untuk mengirim kembali data kunjungan pasien BPJS ke Aplikasi PCare.<br/>
									Jika terjadi kendala koneksi, silahkan klik menu <a href="index.php?page=satusehat_encounter_export" style='color:#005184;font-weight:bold'>"Export Data Satusehat"</a> untuk mengirim kembali data kunjungan pasien ke Satusehat PCare.</p>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end data registrasi-->
			</div>
		</div>
	</div>
</div>

<div class="modal modal_ttd" tabindex="-1">
  	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Formulir Pesetujuan</h5>
		</div>
		<div class="modal-body">
			<input type="hidden" class="idpasien_ttd">
			<table class="table table-condesed">
				<tbody>
					
					
					<tr>
						<td width="20%">Penanggung Jawab</td>
						<td>
							<div class="radio">
								<label>
									<input type="radio" name="tanggunjawab" class="tanggunjawab" value="pasien" checked="true"> Pasien
								</label>&nbsp; &nbsp;
								<label>
									<input type="radio" name="tanggunjawab" class="tanggunjawab" value="Penanggung Jawab"> Penanggung Jawab
								</label>
							</div>
						</td>
					</tr>

					<tr>
						<td width="20%">Nama</td>
						<td width="80%">
							<div class="row">
								<input type="text" name="nama_penanggungjawab" class="form-control inputan nama_penanggungjawab">
							</div>
						</td>
					</tr>

					<tr>
						<td width="20%">Nik</td>
						<td width="80%">
							<div class="row">
								<input type="text" name="nik_penanggungjawab" class="form-control inputan nik_penanggungjawab">
							</div>
						</td>
					</tr>
					
				</tbody>
			</table>
		
			<table class="table-bordered table-judul" width="100%">
				<tr>
					<th>No</th>
					<th>#</th>
					<th class="col-sm-2">Kelompok</th>
					<th class="col-sm-9">Penjelasan</th>
				</tr>
			<?php
				$getGkref = mysqli_query($koneksi,"SELECT * FROM `ref_general_konsen` ORDER BY IdgeneralkonsenRef ASC");
					$no = 0;
				while($n = mysqli_fetch_array($getGkref)){
					$no++;
			?>
				<tr>
					<td><?php echo $no;?></td>
					<td><input type='checkbox' class='poin_ref' value='<?php echo $n['IdgeneralkonsenRef'];?>'></td>
					<td ><?php echo strtoupper($n['kelompok']);?></td>
					<td ><?php echo strtoupper($n['poin']);?></td>
				</tr>
			<?php
				}
			?>
			</table>
		
						<br/>
						Dengan mendatangani form dibawah anda menyetujui yang sudah dijelaskan pada formulir persetujuan.
						<br />
						<br />
			<canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
			<br />
			<input type="hidden" class="urlprint">
			<input type="hidden" class="tandatangandigital">
			<button type="button" class="btn btn-primary" id="get-signature">Lanjut</button>
			<button type="button" class="btn btn-warning" id="clear-signature">Hapus Ttd</button>
			<br />
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary btnclosemodal" data-dismiss="modal">TUTUP</button>
		</div>
		</div>
  	</div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$('.modal_pasienrj').click(function(){
		var idpsrj = $(this).parent().find(".idpsrj").val();		
		$.post( "get_modal_pasienrj.php", { id: idpsrj })
			.done(function( data ) {
				$( ".hasilmodal" ).html( data );
				$('#modalkartupasien').modal('show');
		});	
	});

	$('.btnmodalencounter').click(function(){
		var idpsrj = $(this).data(".idpasienrj");
		var idencounter = $(this).data('idencounter');
	
		$.post( "get_modal_encounter.php", { id: idpsrj, idencounter: idencounter })
			.done(function( data ) {
				$( ".hasilmodal" ).html( data );
				$('#modalencounter').modal('show');
		});	
	});

	$('body').on("click",".btnmdlttd", function(event) { 
		event.preventDefault();
		var namapasiendipilih = $(this).data('nama');
		var nikpasiendipilih = $(this).data('nik');
		$(".nama_penanggungjawab").val($(this).data('nama'));
		$(".nik_penanggungjawab").val($(this).data('nik'));
		$(".idpasien_ttd").val($(this).data('idpasien'));
		$(".modal_ttd").modal('show');

		$('.tanggunjawab').on('click', function() {
			var isitg = $(".tanggunjawab:checked").val();
			if(isitg == 'Penanggung Jawab'){
				$(".nama_penanggungjawab").val('');
				$(".nik_penanggungjawab").val('');
			}else{
				$(".nama_penanggungjawab").val(namapasiendipilih);
				$(".nik_penanggungjawab").val(nikpasiendipilih);
				
			}
		});
	});
</script>
<script src="assets/js/signaturePad.js"></script>
<script>


jQuery(document).ready(function($) {

	

    var canvas = document.getElementById("signature");
    var signaturePad = new SignaturePad(canvas);

    $('#clear-signature').on('click', function() {
        signaturePad.clear();
        signaturePad.on()
    });


    $('#get-signature').on('click', function() {
        if (signaturePad.isEmpty()) {
        	alert('Belum ada tanda tangan...');
        }else{
        	signaturePad.off()
        	//$(".tandatangandigital").val(signaturePad.toDataURL());
	        //$(".imgttd").attr('src',signaturePad.toDataURL());
			
			var poin_ref_val = [];
			$(".poin_ref:checked").each(function() {
				poin_ref_val.push($(this).val());
			});

			var idpasien = $(".idpasien_ttd").val();
			var nm_png = $(".nama_penanggungjawab").val();
			var nik_png = $(".nik_penanggungjawab").val();
			console.log(idpasien);

			$.post( "simpan_ttd_pasien.php", { idpasien:idpasien, ttd: signaturePad.toDataURL(), 'poin_ref[]': poin_ref_val, nm_png: nm_png, nik_png: nik_png})
				.done(function( data ) {
					console.log(data);
					if(data == 'sukses'){
						alert('sukses!!');
						location.reload();
					}else{
						alert('terjadi kesalahan!!');
					}
					
			});

			
        }        
    });
});
</script>
<?php } ?>
			