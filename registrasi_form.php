<?php
error_reporting(0);
$kota = $_SESSION['kota'];
$statuspustu = json_decode($_SESSION['statuspustu'],true);
$tbpasienonline = "tbpasienonline_".$kodepuskesmas;
$otoritas = explode(',',$_SESSION['otoritas']);
?>
<?php
	if($_GET['stsetiket'] == 'etiket'){
?>
	<script>
		setInterval(function () {
			document.location.href='etiket_pendaftaran.php?idprj=<?php echo $_GET['idprj']?>';
		}, 3000);
	</script>
<?php
	}
?>
<!--janga dihapus, buat jalanin hidden saat pencarian nama pasien-->
<link rel="stylesheet" href="assets/css/bootstrap.min.css?14"/>
<style>
.form-reg-cari{
	/* width:100%; */
	padding:15px 10px;
}
.border-left{
	border-left:1px solid #ddd;
}
.pilihan-reg-cari{
	background:#e0e0e0;
	padding:6px 15px 6px 0px;color:#444;border-radius:5px;margin-right:5px;
}
.pilihan-reg-cari:hover{
	background:#444;color:#fff !important;cursor:pointer
}
.pilihan-reg-cari.active{
	background:#444;color:#fff !important
}
.rad-reg-cari{
	visibility:hidden;
}
.alertdiv{
	padding:1px 3px;color:red;font-size:12px;
}
</style>

<div class="page-inner py-3">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row mb-2">
						<div class="col-xl-6">
							<h3 class="text-black fw-bold">Pendaftaran Pasien</h3>
						</div>
						<div class="ml-md-auto py-2 py-md-0">
							<!-- <button type="submit" class="btn btn-warning btn-round btnsubmit"><span class="fa fa-search"></span></button> -->
							<?php
							// antrian pasien
							$dtsetantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_setting` WHERE KodePuskesmas = '$kodepuskesmas'"));
							if($dtsetantrian['versi_antrian'] == 'versi2'){
								$tbantrian_pasien = "tbantrian_pasienv2";
							}else{
								$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
							}
							
							$qry = mysqli_query($koneksi, "SELECT * FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = curdate() AND `StatusAntrian` != 'Selesai' order by NomorAntrian Limit 1"); 
							// if(mysqli_num_rows($qry) > 0){ 
							?>
							<a href="#" class="btn btn-primary btn-round panggilantrian">Panggil</a>
							<?php 
							// }
							?>
							<a href="?page=kk_insert" class="btn btn-success btn-round"><span class="fa fa-plus"></span> Pasien Baru</a>
							<a href="?page=registrasi_data" class="btn btn-info btn-round">Data Registrasi</a>	
							<a href="?page=registrasi_online" class="btn btn-primary btn-round">Daftar Online</a>							
						</div>
					</div>

					<form method="get">
						<input type="hidden" name="page" value="registrasi">
						<div class="row">
							
							<div class="col-xl-12 formkey">
								<input type="text" name="key" class="form-control inputkey form-reg-cari" value="<?php echo $_GET['key'];?>" placeholder="Kata kunci" minlenght="2">
							</div>
							<div class="col-xl-3 formtgllahir hidden">
								<input type="text" name="thnlahir" class="form-control form-reg-cari " value="<?php echo $_GET['thnlahir'];?>" placeholder="Tahun Lahir" minlenght="4" maxlength="4"/>
							</div>
							<div class="col-xl-3 formalamat hidden">
								<select type="text" name="alamat" class="form-control form-reg-cari ">
									<option value=''>Semua</option>
									<?php
									$qkel = mysqli_query($koneksi,"SELECT * from `tbkelurahan` where Kota = '$kota' ORDER BY `Kelurahan`");
									while($dtkel = mysqli_fetch_assoc($qkel)){
										if($dtkel['Kelurahan'] == $_GET['alamat']){
										echo "<option value='$dtkel[Kelurahan]' SELECTED>$dtkel[Kelurahan]</option>";
										}else{
										echo "<option value='$dtkel[Kelurahan]'>$dtkel[Kelurahan]</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="col-xl-12 mt-2">
								<div class="alertdiv"></div>
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="NoIndex" <?php if($_GET['kategori_pencarian'] == 'NoIndex'){echo "checked";}?>><i class="fa fa-search"></i> INDEX</label>
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="BPJS" <?php if($_GET['kategori_pencarian'] == 'BPJS'){echo "checked";}?>><i class="fa fa-search"></i> BPJS</label>	
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="NIK" <?php if($_GET['kategori_pencarian'] == 'NIK'){echo "checked";}?>><i class="fa fa-search"></i> NIK</label>
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="NoRM" <?php if($_GET['kategori_pencarian'] == 'NoRM'){echo "checked";}?>><i class="fa fa-search"></i> RM</label>
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="NamaPasien" <?php if($_GET['kategori_pencarian'] == 'NamaPasien'){echo "checked";}?>><i class="fa fa-search"></i> NAMA PASIEN</label>
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="TanggalLahir" <?php if($_GET['kategori_pencarian'] == 'TanggalLahir'){echo "checked";}?>><i class="fa fa-search"></i> PASIEN - THN.LAHIR</label>
								<label class="pilihan-reg-cari"><input type="radio" class="rad-reg-cari" name="kategori_pencarian" value="NamaKK" <?php if($_GET['kategori_pencarian'] == 'NamaKK'){echo "checked";}?>><i class="fa fa-search"></i> KEPALA KELUARGA</label>
							</div>
							
						</div>
					</form>

					
				</div>
			</div>
		</div>

		
		
	</div>
</div>

<?php
	$jumlah_perpage = 10;
		
	if($_GET['h']==''){
		$mulai=0;
	}else{
		$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
	}
	
	$asalpasien = $_SESSION['layanan_dipilih'];
	$str = "SELECT * FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '".date('Y-m-d')."' AND `AsalPasien` = '$asalpasien'";		
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

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">No.</th>
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
									<?php echo "<b>".strtoupper($data['NamaPasien'])."</b>";?>
									<?php 
										// asal pasien
										$asal_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `AsalPasien` FROM `tbasalpasien` WHERE `Id`='$data[AsalPasien]'"));
										
										if($data['UmurTahun'] != '0'){
											$umur = $data['UmurTahun']." Th";
										}else{
											$umur = $data['UmurBulan']." Bl";
										}	

										echo "<li><b> NIK</b> : ".$nikpasien."<br/></i>".
										'<li><b>No.BPJS</b> : &nbsp'.$nomorbpjs."<br/></i>".
										'<li><b>No.Index</b> : &nbsp'.substr($data['NoIndex'],-10)."<br/></i>".
										'<li><b>No.RM</b> : &nbsp'.$norms."<br/></i>".
										'<li><b>Tgl.Lahir</b> : &nbsp'.date('d-m-Y', strtotime($data['TanggalLahir']))." (".$umur.")<br/></i>".
										'<li><b>Jns.Kelamin</b> : &nbsp'.$jeniskelamin."<br/></i>".
										'<i class="icon-user"></i>&nbsp<b>'.strtoupper($data['NamaPegawaiSimpan'])."</b><br/>".
										'<i class="icon-home"></i>&nbsp<b>'.strtoupper($asal_pasien['AsalPasien'])."</b>";
									?>
								</td>
								<td align="left">
									<button class="btn btn-success btn-xs"><?php echo $data['Klaster']." - ".$data['SiklusHidup'];?></button><br/>
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
						Garis Biru, menandakan status kunjungan pasien baru<br/>
						Garis Pink, menandakan peserta bpjs yang belum mendapatkan nomor urut (Gagal Bridging)<br/>
						Jika terjadi kendala koneksi, silahkan klik menu <a href="registrasi_export.php?key=<?php echo $tgl;?>&nama=<?php echo $nama;?>" style='color:#005184;font-weight:bold'>"Export Data BPJS"</a> untuk mengirim kembali data kunjungan pasien BPJS ke Aplikasi PCare.<br/>
						Jika terjadi kendala koneksi, silahkan klik menu <a href="index.php?page=satusehat_encounter_export" style='color:#005184;font-weight:bold'>"Export Data Satusehat"</a> untuk mengirim kembali data kunjungan pasien ke Satusehat PCare.</p>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>

<script src="assets_atlantis/js/core/jquery.3.2.1.min.js"></script>
<script>
	
	$('input[name="kategori_pencarian"]:checked').parent().addClass('active');
	$(document).on("click",".rad-reg-cari",function() {
		$(".pilihan-reg-cari").removeClass('active');
		$(this).parent().addClass('active');

		if($(".inputkey").val() == ''){
			$(".alertdiv").text('Silahkan isi key terlebih dahulu');
		}else{
			$(this).closest("form").submit();
		}
	});

	$(".rad-reg-cari").click(function(){
		var thisval = $('input[name="kategori_pencarian"]:checked').val();
		if(thisval == 'NamaPasien' || thisval == 'NamaKK' || thisval == 'TanggalLahir'){
			if($(this).val() == 'TanggalLahir'){
				$('.formtgllahir').removeClass('hidden');
				$('.formalamat').addClass('hidden');
				//var ket = "Tahun";
				//$('.formtgllahir').find('.cari').attr('placeholder',ket);
			}else{
				$('.formalamat').removeClass('hidden');
				$('.formtgllahir').addClass('hidden');
				// var ket = "Kelurahan / Desa";
				// $('.formalamat').find('.cari').attr('placeholder',ket);
			}
			$('.formkey').removeClass('col-xl-12');
			$('.formkey').addClass('col-xl-6');
			
			/*$('.formalamat').find('.cari').prop('required',true);*/
		}else{
			$('.formkey').removeClass('col-xl-6');
			$('.formkey').addClass('col-xl-12');
			$('.formalamat').addClass('hidden');
			$('.formtgllahir').addClass('hidden');
			/*$('.formalamat').find('.cari').prop('required',false);*/
		}
	});
	
	$(document).ready(function(){
		if($('.kat_pencarian').val() == 'NamaPasien' || $('.kat_pencarian').val() == 'NamaKK' || $(".kat_pencarian").val() == 'TanggalLahir'){
			if($(".kat_pencarian").val() == 'TanggalLahir'){
				$('.formtgllahir').removeClass('hidden');
				$('.formalamat').addClass('hidden');
				//var ket = "Tahun";
				//$('.formtgllahir').find('.cari').attr('placeholder',ket);
			}else{
				$('.formalamat').removeClass('hidden');
				$('.formtgllahir').addClass('hidden');
				// var ket = "Kelurahan / Desa";
				// $('.formalamat').find('.cari').attr('placeholder',ket);
			}
			$('.formkey').removeClass('col-sm-4');
			$('.formkey').addClass('col-sm-2');
		}else{
			$('.formkey').removeClass('col-sm-2');
			$('.formkey').addClass('col-sm-4');
			$('.formalamat').addClass('hidden');
		}
	});
	
	$(".panggilantrian").click(function(){
		//responsiveVoice.speak("Antrian pasien Nomor <?php echo $dataantrian['NomorAntrian'];?>","Indonesian Female", {rate: 0.8});
		$.get( "get_modal_panggil_antrian.php").done(function( data ) {
			$(".modaltampil").html(data);
			$('#Modalantrian').modal('show');
		});
	});	

	$.get( "get_modal_panggil_antrian.php?sts=cekdata").done(function( data ) {
		if(data == 0){
			setInterval(function(){
				$.get( "get_modal_panggil_antrian.php?sts=cekdata").done(function( data ) {
					if(data == 1){
						//alert(data);
						window.location.reload(true);
					}
				});
			}, 3000);
		}
	});
</script>


<div class="modaltampil"></div>