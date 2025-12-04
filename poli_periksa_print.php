<?php
	error_reporting(1);
	include "config/helper_pasienrj.php";
	include "config/helper_bpjs_v4.php";	
	$pelayanan = $_GET['pelayanan'];
	$stsukm = $_POST['stsukm']; // status pelayanan luar gedung
	
	// get pasienrj
	$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbpasienrj WHERE `IdPasienrj` = '$idpasienrj'"));
?>
	<script src="../assets/js/qrcode.min.js?4"></script>
	<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<?php if($stsukm == ""){ ?>
				<a href="?page=poli&pelayanan=<?php echo $pelayanan;?>&status=Antri" class="backform" style="margin-top:0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<?php }else{ ?>
				<a href="?page=jejaring&pelayanan=<?php echo $pelayanan;?>&status=Antri" class="backform" style="margin-top:0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<?php }?>
			<h3 class="judul mt-2"><b>REKAM MEDIS & RESEP ELEKTRONIK</b></h3>
			<div class = "row">
				<?php				
					$idrj = $_GET['idrj'];
					$noregistrasi = $_GET['noreg'];
					$pelayanan = $_GET['pelayanan'];
					$query2 = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idrj'");
					$data_pasien_rj = mysqli_fetch_assoc($query2);
					
					// tahap1, tbdiagnosapasien
					$qrdata_kd_diagnosa = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'");			
					
					// tahap2, tbkk
					$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE NoIndex='$data_pasien_rj[NoIndex]'"));
					if($dt_kk['Alamat'] != ''){
						$alamat_kk = $dt_kk['Alamat']." RT.".$dt_kk['RT']." RW.".$dt_kk['RW']."<br/>Desa/Kel.".$dt_kk['Kelurahan'];
					}else{
						$alamat_kk = "Alamat belum diinputkan";
					}

					$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
					$datapaspergawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$noregistrasi'"));
					
				?>
				<div class="col-lg-12">
					<div class="formbg">
						<div class="row">
							<div class="col-sm-8">
								<h4 class="judul">
								<i class="icon-user"></i>
									<?php echo $data_pasien_rj['NamaPasien'];?>
								</h4>
								<table width="100%">
									<tr>	
										<td width="12%">Tgl.Pemeriksaan</td>
										<td width="2%">:</td>
										<td width="84%"><?php echo $data_pasien_rj['TanggalRegistrasi'];?></td>
									</tr>	
									<tr>	
										<td>No.Index</td>
										<td>:</td>
										<td><?php echo substr($data_pasien_rj['NoIndex'], -10);?></td>
									</tr>	
									<tr>	
										<td>No.RM</td>
										<td>:</td>
										<td>
											<?php 
												if($data_pasien_rj['NoRM'] == "" OR $data_pasien_rj['NoRM'] == 0){
													echo "Belum terdaftar";
												}else{	
													echo $data_pasien_rj['NoRM'];
												}
											?>
										</td>
									</tr>
									<tr>	
										<td>Umur</td>
										<td>:</td>
										<td><?php echo $data_pasien_rj['UmurTahun']." thn ".$data_pasien_rj['UmurBulan']." Bln";?></td>
									</tr>
									<tr>	
										<td style="vertical-align: text-top;">Alamat</td>
										<td style="vertical-align: text-top;">:</td>
										<td><?php echo $alamat_kk;?></td>
									</tr>
									<tr>	
										<td>Poli</td>
										<td>:</td>
										<td><?php echo $data_pasien_rj['PoliPertama'];?></td>
									</tr>
									<tr>	
										<td>Jaminan</td>
										<td>:</td>
										<td><?php echo $data_pasien_rj['Asuransi'];?></td>
									</tr>
									<?php if(substr($data_pasien_rj['Asuransi'],0,4) == 'BPJS'){?>
									<tr>	
										<td>No.BPJS</td>
										<td>:</td>
										<td><?php echo $data_pasien_rj['nokartu'];?></td>
									</tr>
									<tr>	
										<td>No.Urut</td>
										<td>:</td>
										<td><?php echo $data_pasien_rj['NoUrutBpjs'];?></td>
									</tr>
									<tr>	
										<td>No.Kunjungan</td>
										<td>:</td>
										<td>
											<?php 
											if(strlen($data_pasien_rj['NoKunjunganBpjs']) == 19){
											?>
												<span class="badge badge-success" style='padding: 8px;'><?php echo $data_pasien_rj['NoKunjunganBpjs'];?></span>
											<?php }else{ ?>
												<span class="badge badge-danger" style='padding: 8px;'>Bridging Gagal</span>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</table>
							</div>
							
							<div class="col-sm-4">	
								<h4 class="judul">
									<i class="icon-note"></i>
									Tanda Tangan Elektronik
								</h4>
								<h5 style="margin-top: 18px">Jaga kerahasian PIN anda terkait dengan sistem Rekam Medis Elektonik</h5>
								<?php if($datapaspergawai['TtePin'] == ''){ ?>
									<table width="100%">
										<div class="alertpin"></div>
										<form method="post">
											<div class="row">
												<div class="col-sm-8 formkey">
													<input type="text" name="tte" class="form-control pincls" placeholder="MASUKAN PIN" maxlength="10">
												</div>
												<div class="col-sm-4 formkey">
													<button type="button" class="btn btn-warning btn-round btnsubmitpin">Simpan</button>
												</div>
											</div>
											<div id="qrcode" style="padding:6px 0px; width: 80px;"></div>
											<p class="qrnamapegawai" style="line-height:18px"></p>
										</form>
									</table>
								<?php 
								}else{
									$md5pin = md5($datapaspergawai['TtePin']);
									$dtpegawaiTtd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NamaPegawai, Sip FROM tbpegawai WHERE `TtePin`='$md5pin' AND SUBSTRING(KodePuskesmas,1,11) = '$kodepuskesmas'"));
								?>
									<div id="qrcode2" style="padding:6px 0px; width: 80px;"></div>
									<p style="line-height:18px"><?php echo $dtpegawaiTtd['NamaPegawai'];?><br/><?php echo $dtpegawaiTtd['Sip'];?></p>
									<script>
										var qrcode = new QRCode(document.getElementById("qrcode2"), {
											width : 80,
											height : 80
										});
										var elText = <?php echo $datapaspergawai['TtePin'];?>;
										qrcode.makeCode(elText);
									</script>
								<?php } ?>
							</div>

							

						</div>
						<hr/>
						<!--tahap3, cek resep-->
						<?php
							$cekresep = mysqli_num_rows(mysqli_query($koneksi, "SELECT NoResep FROM `$tbresep` WHERE `NoResep` = '$noregistrasi'"));
							if ($cekresep > 0){
						?>
						<a href="#" class="btn btn-round btn-info btnmodalobat" data-norg="<?php echo $noregistrasi;?>" data-pelayanan="<?php echo $pelayanan;?>">Resep Obat</a>
						<?php } ?>
						<!--<a href="#" class="btn btn-round btn-info btnmodalriwayat" data-norg="<?php echo $noregistrasi;?>" data-pelayanan="<?php echo $pelayanan;?>">Rekam Medis</a>-->
						<a href="?page=poli&pelayanan=<?php echo $pelayanan;?>&status=Antri" class="btn btn-round btn-success btnkembali" <?php if($datapaspergawai['TtePin'] == ''){echo 'style="display:none"';}?>>Kembali ke Pemeriksaan</a>
						</div>
					</div>
				</div>	
				
			</div>
			<?php
				$getdtrujukbpjs = mysqli_query($koneksi,"SELECT * FROM tbrujukanbpjs WHERE IdPasienrj = '$idrj'");
				if(mysqli_num_rows($getdtrujukbpjs) > 0){
					$dtrujukbpjs = mysqli_fetch_array($getdtrujukbpjs);

					$getSpesialis = $dtrujukbpjs['Spesialis'];
					$getSubSpesialis = $dtrujukbpjs['SubSpesialis'];
					$getTglEstRujuk = date('d-m-Y',strtotime($dtrujukbpjs['TglEstRujuk']));
					$getPPK = $dtrujukbpjs['PPK'];
				}else{
					$getSpesialis = '';
					$getSubSpesialis = '';
					$getTglEstRujuk = date('d-m-Y');
					$getPPK = '';
				}
			?>
			<div class="col-lg-12">
				<div class="formbg">
					<div class="btn-group mb-4" role="group" aria-label="Basic example">
						<button type="button" class="btn btn-info btntabforms" data-ket="spesialis">Spesialis</button>
						<button type="button" class="btn btn-outline-secondary btntabforms" data-ket="khusus">Khusus</button>
					</div>

					<div class="tmp_form_spesialis">
						<h4 class="judul">Form Spesialis</h4>
						<form action="rujukan_spesialis_bpjs.php" method="post">
							<input type="hidden" name="idrj" value="<?php echo $idrj;?>">
							<table class="table-judul" width="100%">
								<tr>
									<td class="col-sm-2">Spesialis</td>
									<td class="col-sm-10">
									<?php
										//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
											$data_spesialis = get_data_referensi_spesialis();
											$dtspesialis = json_decode($data_spesialis,True);
										//}		
									?>
									<select name="spesialis" class="form-control spesialis kdpolis">
										<option value="">Spesialis</option>
										<?php
											$list = $dtspesialis['response']['list'];
											if(count($list) > 0){
												foreach($list as $ket){
													if($getSpesialis == $ket['kdSpesialis']){
														echo "<option value='$ket[kdSpesialis]' SELECTED>".$ket['nmSpesialis']."</option>";
													}else{
														echo "<option value='$ket[kdSpesialis]'>".$ket['nmSpesialis']."</option>";
													}													
												}
											}					
										?>				
									</select>
									</td>
								</tr>
								<tr>
									<td>SubSpesialis</td>
									<td>
										<select name="sub-spesialis" class="form-control sub-spesialis">
											<option value="">Sub Spesialis</option>
											
										</select>
									</td>
								</tr>
								<tr>
									<td>Sarana</td>
									<td>
										<select name="sarana" class="form-control sarana">
											<option value="0">Sarana</option>
											<?php
												//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
													$data_sarana = get_data_referensi_sarana();
													$dtsarana = json_decode($data_sarana,True);
												//}		
											
													$list = $dtsarana['response']['list'];
													foreach($list as $ket){
														echo "<option value='$ket[kdSarana]'>".$ket['nmSarana']."</option>";
													}
												
											?>	
										</select>
									</td>
								</tr>
								<tr>
									<td>Tanggal Est. Rujuk</td>
									<td>
										<input type="text" name="tglrujuk" value="<?php echo $getTglEstRujuk;?>" class="datepicker tglfaskes_spesialis form-control">
									</td>
								</tr>
								<tr>
									<td>PPK</td>
									<td>
										<select name="ppk" class="form-control ppkfaskes_spesialis">
											<option value="0">Pilih Faskes Rujukan</option>

										</select>
									</td>
								</tr>
							</table><hr/>
							<button type="submit" class="btn btn-round btn-success">SIMPAN</button>
							<a href="index.php?page=cetak_rujukan_bpjs&idrj=<?php echo $idrj?>" class="btn btn-round btn-primary">CETAK RUJUKAN</a>
						</form>
					</div>
					
					<div class="tmp_form_khusus" style="display:none">
						<h4 class="judul">Form Khusus</h4>
						<form action="rujukan_spesialis_khusus.php" method="post">
						<input type="hidden" name="idrj" value="<?php echo $idrj;?>">
							<table class="table-judul" width="100%">
								<tr>
									<td class="col-sm-2">Kategori</td>
									<td class="col-sm-10">
										<?php
											//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
												$data_khusus = get_data_referensi_khusus();
												$dtkhusus = json_decode($data_khusus,True);
											//}		
										?>
										<select name="kategori-kondisi" class="form-control kondisi-khusus kdpolis">
											<option value="">Kategori</option>
											<?php
												$list = $dtkhusus['response']['list'];
												foreach($list as $ket){
													echo "<option value='$ket[kdKhusus]'>".$ket['nmKhusus']."</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>SubSpesialis</td>
									<td>
										<select name="kategori-kondisi-sub" class="form-control khusus_subspesialis"> <!--style="display:none"-->
											<option value="-">-Pilih-</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Catatan</td>
									<td>
									<textarea name="catatan-kondisi" class="form-control" placeholder="Catatan"></textarea>
									</td>
								</tr>
								<tr>
									<td>Tanggal Est. Rujuk</td>
									<td>
										<input type="text" value="<?php echo date('d-m-Y');?>" name="tglrujuk" class="datepicker tglfaskes_khusus form-control">
									</td>
								</tr>
								<tr>
									<td>PPK</td>
									<td>
										<select name="ppk" class="form-control ppkfaskes_khusus">
											<option value="0">Pilih Faskes Rujukan</option>

										</select>
									</td>
								</tr>
								
							</table>
							<button type="submit" class="btn btn-round btn-success">SIMPAN</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="hasilmodal1"></div>
		<div class="hasilmodal2"></div>		
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script>

			var isi_spesialis = $(".spesialis").val();
			if(isi_spesialis != ''){
				$.post( "get_rujuk_lanjut_subspesialis.php", { key: isi_spesialis, isisub: '<?php echo $getSubSpesialis;?>'})
				.done(function( data ) {
					$( ".sub-spesialis" ).html( data );
				});
			}

			var subspesialis = '<?php echo $getSubSpesialis;?>';
			var sarana = $('.sarana').val();
			var tgl = $('.tglfaskes_spesialis').val();
			if(tgl != '' && subspesialis != ''){
				$.post( "get_rujuk_lanjut_faskes_spesialis_select.php", { kdsubspesialis: subspesialis,kdsarana: sarana,tgl:tgl,isippk: '<?php echo $getPPK;?>'})
				.done(function( data ) {
					$( ".ppkfaskes_spesialis" ).html( data );
				});
			}	
			

		$('.btntabforms').click(function(){
			var ket = $(this).data("ket");
			if(ket == 'spesialis'){
				$(".tmp_form_spesialis").show();
				$(".tmp_form_khusus").hide();
			}else{
				$(".tmp_form_spesialis").hide();
				$(".tmp_form_khusus").show();
			}
		});

		$(".spesialis").change(function(){
			var isi = $(this).val();
			$.post( "get_rujuk_lanjut_subspesialis.php", { key: isi, isisub: '<?php echo $getSubSpesialis;?>'})
				.done(function( data ) {
					//alert(data);
					$( ".sub-spesialis" ).html( data );
				});
		});

		$(".kondisi-khusus").change(function(){
			var isi = $(this).val();
			if(isi == 'THA' || isi == 'HEM'){
				$(".khusus_subspesialis").html('<option value="8">HEMATOLOGI - ONKOLOGI MEDIK</option><option value="30">ANAK HEMATOLOGI ONKOLOGI</option>');
			}else{
				$(".khusus_subspesialis").html("<option value=''>Tidak ada data</option>");
			}
		});


		// $(".tglfaskes_khusus").focusout(function(){
		$('.tglfaskes_khusus').on('click change', function(e) {
			var tgl = $('.tglfaskes_khusus').val();
			var kdkhusus = $('.kondisi-khusus').val();
			var subspesialis = $('.khusus_subspesialis').val();
			var nokartubpjs = $("input[name='nokartubpjs']").val();
			if(tgl == ''){
				alert('Tolong isikan tanggal');
			}else if(kdkhusus == ''){
				alert('Tolong isikan kategori khusus');
			}else{
				$.post( "get_rujuk_lanjut_faskes_khusus_select.php", { kdkhusus: kdkhusus, subspesialis:subspesialis, tgl:tgl, nokartubpjs:nokartubpjs})
				.done(function( data ) {
					$( ".ppkfaskes_khusus" ).html( data );
				});
			}	
		}); 
		
		// $(".tglfaskes_spesialis").focusout(function(){
		$('.tglfaskes_spesialis').on('click change', function(e) {
			var subspesialis = $('.sub-spesialis').val();
			var sarana = $('.sarana').val();
			var tgl = $('.tglfaskes_spesialis').val();
			if(tgl == ''){
				alert('Tolong isikan tanggal');
			}else if(subspesialis == ''){
				alert('Tolong isikan Subspesialis');
			// }else if(sarana == ''){
				// alert('Tolong isikan sarana');
			}else{
				$.post( "get_rujuk_lanjut_faskes_spesialis_select.php", { kdsubspesialis: subspesialis,kdsarana: sarana,tgl:tgl,isippk: '<?php echo $getPPK;?>'})
				.done(function( data ) {
					$( ".ppkfaskes_spesialis" ).html( data );
				});
			}	
		});

		$('.btnmodalriwayat').click(function(){
			var noregistrasi = $(this).data("norg");
			var pelayanan = $(this).data('pelayanan');
			$(this).html("Loading...");
			$.post( "get_modal_riwayat.php", { no: noregistrasi, pel: pelayanan})
			  .done(function( data ) {
					$('.btnmodalriwayat').html('Rekam Medis');
					$( ".hasilmodal1" ).html( data );
					$('#ModalRiwayat').modal('show');
			});
		});
		
		$('.btnmodalobat').click(function(){
			var noresep = $(this).data("norg");
			var pelayanan = $(this).data('pelayanan');
			$(this).html("Loading...");
			$.post( "get_modal_apotik_dokter.php", { no: noresep, ply: pelayanan})
			  .done(function( data ) {
					$('.btnmodalobat').html('Resep Obat');
					$( ".hasilmodal2" ).html( data );
					$('#Modalobat').modal('show');
			});
		});

		$(".btnsubmitpin").click(function(){
			var noreg = '<?php echo $noregistrasi;?>';
			var pin = $(".pincls").val();
			$.post( "set_pin_tbpaseinperpegawai.php", { noreg: noreg, pin: pin})
			  .done(function( data ) {
			  	if(data == 'sukses'){
			  		$(".pincls").val('');
			  		$(".alertpin").html("<div class='alert alert-info'>Pin berhasil disimpan</div>");
			  		$(".btnkembali").show();

			  		var qrcode = new QRCode(document.getElementById("qrcode"), {
						width : 80,
						height : 80
					});
					var elText = pin;
					qrcode.makeCode(elText);

					$(".qrnamapegawai").html('<?php echo $_SESSION['nama_petugas']."<br/>".$_SESSION['sipsession'];?>');
			  	}else{
			  		$(".alertpin").html("<div class='alert alert-danger'>"+data+"</div>");
			  		$(".btnkembali").hide();
			  	}
			});
		});

		
</script>