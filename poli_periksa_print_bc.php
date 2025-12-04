<?php
	error_reporting(1);
	include "config/helper_pasienrj.php";
	$pelayanan = $_GET['pelayanan'];
	$stsukm = $_POST['stsukm']; // status pelayanan luar gedung
	$idpasienrj = $_POST['idpasienrj'];
	
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
		</div>
		<div class="hasilmodal1"></div>
		<div class="hasilmodal2"></div>		
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
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