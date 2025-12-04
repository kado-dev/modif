
<style>
	.iconpoli{
		width:85px !important;height:85px !important;float:left;margin-right:20px;
	}
	.keatas{
		width:100px;font-weight:normal;text-align:center;line-height:10px;
		background:green;padding:10px 6px 4px 6px;color:white;border-radius:8px;position: absolute;top:-10px;right:0px
	}
</style>
<div class="antrianshtml">
	<?php
		$jml_antrian_total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM $tbantrian_pasien WHERE date(WaktuAntrian) = CURDATE()"));
	?>			
<!-- 	<div class="row" style="background: #396317;margin:0px;padding:0.5vw 0.9vw;border-radius: 0.4vw;margin-bottom: 0.7vw; color: #fff">
		<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: left;">ANTRIAN PUSKESMAS</div>
		<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: right;">TOTAL ANTRIAN PASIEN = <?php echo $jml_antrian_total;?></div>			
	</div> -->
	<form action="index.php?page=etiket" method="post">
		<div class="row">
			<div class="col-md-12" style="padding-top:-5px;">
				<div class="row">
				<?php
				$strpel = "SELECT * FROM `tbantrian_pelayanan` WHERE Jumlah > 0 AND KodePuskesmas = '$kodepuskesmas' ORDER BY `Klaster` ASC";
				$query = mysqli_query($koneksi, $strpel);
				while($data = mysqli_fetch_assoc($query)){
					// $jml_antrian = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM $tbantrian_pasien WHERE PoliPertama = '$data[Pelayanan]' AND date(WaktuAntrian) = CURDATE() GROUP BY NomorAntrian, NomorAntrianPoli")); 
					$jml_antrian = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM $tbantrian_pasien WHERE PoliPertama = '$data[Pelayanan]' AND date(WaktuAntrian) = CURDATE()")); 
					// ujicoba baru yang prolanis
					if($data['Pelayanan'] == "PROLANIS"){
						$harisekarang = date('w');//5
						$hariprolanis = $datasetting['Prolanis'];//1,4
					
						$arr_hpro = explode(",", $datasetting['Prolanis']);
						if (in_array($harisekarang, $arr_hpro)) {
							$st = 1;
						}else{
							$st = 0;
						}
					}elseif($data['Pelayanan'] == "IMUNISASI"){
						$harisekarang = date('w');				
						$arr_poli = explode(",", $datasetting['Imunisasi']);
						if (in_array($harisekarang, $arr_poli)) {
							$st = 1;
						}else{
							$st = 0;
						}
					}elseif($data['Pelayanan'] == "VAKSIN"){
						$harisekarang = date('w');				
						$arr_poli = explode(",", $datasetting['Vaksin']);
						if (in_array($harisekarang, $arr_poli)) {
							$st = 1;
						}else{
							$st = 0;
						}	
					}else{
						$st = 1;
					}
					if($st == 1){
					$sisaantrian = $data['Jumlah'] - $jml_antrian;
				?>
					<div class="col-md-3 col-sm-4 menudepan">
						<label class="clickpoli" style="<?php if($sisaantrian == 0){echo 'background:#fffdd1;';}?>" data-kodepoli="<?php echo $data['kodepoli'];?>" data-namapoli="<?php echo $data['Pelayanan'];?>">
						<p class='keatas'><label><?php echo $data['Klaster'];?></label></p>	
						<img src="image/poli<?php echo strtolower(str_replace(' ','',$data['Pelayanan']));?>.png" class="iconpoli"/>
							<input type="radio" name="poli" value="<?php echo $data['Pelayanan'];?>" data-klaster="<?php echo $data['Klaster'];?>" class="poliradio" style="display:none;width: 1px;" required>
							<h4 style="font-size:1.2vw; line-height:1vw; display: none;"><?php echo $data['KodePelayanan'];?></h4>
							<strong style="font-size:1.3vw"><?php echo $data['KodePelayanan'].". ".$data['Pelayanan'];?></strong>						
							<br/>
							<span style="font-size:2.2vw;line-height:2.2vw;"><?php echo $jml_antrian;?></span><br/>
							<?php 						
							if(strtotime(date('G:i')) <= strtotime($datasetting['WaktuPelayananTutup'])){?>
							<p class="sisaantrian" data-sisa="<?php echo $sisaantrian;?>" style="font-size:1vw;line-height:1.2vw; font-weight: normal;">Sisa : <?php echo $sisaantrian;?></p>
							<?php }?>
							<?php
							echo "<p class='ketbawah'>".$data['Keterangan']."</p>";
								// if($data['Pelayanan'] == 'MTBS'){
								// 	echo "<p class='ketbawah'>Kurang dari 5 Tahun</p>";
								// }else if($data['Pelayanan'] == 'LANSIA'){
								// 	if($_COOKIE['kota2'] == "KOTA TARAKAN"){
								// 		echo "<p class='ketbawah'>Diatas 45 Tahun</p>";
								// 	}else{
								// 		echo "<p class='ketbawah'>Diatas 60 Tahun</p>";
								// 	}
								// }else if($data['Pelayanan'] == 'ANAK'){
								// 	if($_COOKIE['kota2'] == "KOTA TARAKAN"){
								// 		echo "<p class='ketbawah'>Kurang dari 14 Tahun</p>";
								// 	}else{
								// 		echo "<p class='ketbawah'>Kurang dari 5 Tahun</p>";
								// 	}	
								// }else if($data['Pelayanan'] == 'UMUM'){
								// 	if($_COOKIE['kota2'] == "KOTA TARAKAN"){
								// 		echo "<p class='ketbawah'>14 Tahun sampai dengan 44 Tahun</p>";
								// 	}else{
								// 		echo "<p class='ketbawah'>5 Tahun sampai dengan 59 Tahun</p>";
								// 	}	
								// }
							?>
						</label>
					</div>
				<?php
					}
				}
				?>	

					<div class="col-sm-3 menudepan">
						<!-- <table width="100%">
							<tr>
								<td></td>
								<td>

								</td>
							</tr>
						</table>	
						<a href="../anjunganpasien/index.php" target="_blank" style="cursor: pointer;">
							<label class="clickpoli">
								<img src="image/polianak.png" class="iconpoli"/>
								<h4 style="font-size:1.2vw; display: none;">Anjungan Daftar Mandiri</h4>
								<strong style="font-size:1vw">ANJUNGAN <br/>DAFTAR MANDIRI</strong>
							</label> -->
						</a>				
					</div>			
				</div>
			</div>
			<!-- <div class="col-md-12" style="padding-top: 2.5vw">
				<div class="row">
					<div class="col-sm-6">
						<a href="#" class="btn btn-lg btn-primary btn-block btn-login btnmodalconf" type="button">KEMBALI</a>
					</div>
					<div class="col-sm-6">
						<button class="btn btn-lg btn-success btn-login btn-block btnprosess" name="btns" type="button">PRINT</button>
					</div>
				</div>			
			</div> -->
		</div>
	</form>

	<!-- <div class="modal fade" id="modalpilihjaminan" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title">JAMINAN / ASURANSI</h3>	    
	      </div>
	      <div class="modal-body">
			<h3>Silahkan pilih jaminan atau asuransi berikut:</h3>
	      	<br/>
			<button type="button" class="btn btn-info btnpasien-umum" style="border-radius:3vh;padding:1vh 4vh">PASIEN UMUM</button>
	        <button type="button" class="btn btn-secondary btnpasien-bpjs" style="border-radius:3vh;margin-left: 1.4vh;padding:1vh 4vh">PASIEN BPJS</button>
	        <br/>
	      </div>
	    </div>
	  </div>
	</div> -->

	<!-- <div class="modal fade" id="modalformantrianbpjs" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title">FORM ANTRIAN BPJS</h3>	    
	      </div>
	      <div class="modal-body">
		  	<form>
				<input type="hidden" id="kodepoli"/>
				<input type="hidden" id="namapoli"/>
				<div class="form-group">
					<label for="nokartu" class="form-label">Nomor Kartu</label>
					<input type="text" class="form-control" id="nokartu" placeholder="No Bpjs">
				</div>
				<div class="form-group">
					<label for="nik" class="form-label">NIK</label>
					<input type="text" class="form-control" id="nik" placeholder="NIK">
				</div>
				<div class="form-group">
					<label for="nohp" class="form-label">Nomor HP</label>
					<input type="text" class="form-control" id="nohp" placeholder="Nomor HP">
				</div>
				<div class="form-group">
					<label for="norm" class="form-label">Nomor RM</label>
					<input type="text" class="form-control" id="norm" placeholder="Nomor RM">
				</div>
				<div class="form-group">
					<label for="nik" class="form-label">Dokter</label>
					<SELECT class="form-control dokterbpjs">
						<OPTION value="">--PILIH--</OPTION>
					</SELECT>
				</div>
				<div class="form-group">
					<label for="jampraktek" class="form-label">Jam Praktek</label>
					<input type="text" class="form-control jampraktek" id="jampraktek" readonly>
				</div>
	      		<br/>
			  	<button type="button" class="btn btn-info btnsimpanbpjs-proses" style="border-radius:3vh;padding:1vh 4vh">SIMPAN</button><br/>
			<form>	
		 </div>
	    </div>
	  </div>
	</div> -->

	<div class="modal fade" id="modalconfpilihpoli" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title">KONFIRMASI</h3>	    
	      </div>
	      <div class="modal-body">
			<h3>Anda yakin ingin berobat ke pelayanan <span class="politerpilih"></span>?</h3>
	      	<br/>
			<button type="button" class="btn btn-info btnprosess" style="border-radius:3vh;padding:1vh 4vh">Ya</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal"  style="border-radius:3vh;margin-left: 1.4vh;padding:1vh 4vh">Tidak</button>
	        <br/>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="modallogin" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title">PASSWORD</h3>	    
	      </div>
	      <div class="modal-body">
			<form style="display:flex">
				<input type="hidden" class="kdpus" value="<?php echo $kodepuskesmas;?>"/>
				<input type="password" name="pass" id="pass" placeholder="Ketikan Password" class="form-control input-lg forminputs"/>
			</form>
	      </div>
	      <div class="modal-footer">
			<button type="button" class="btn btn-info btn-lg btns" id="btnlogs" style="margin-left: 10px">Login</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="../assets/js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".clickpoli").click(function(){

				if(<?php echo strtotime(date('G:i'));?> < <?php echo strtotime($datasetting['WaktuPelayananBuka']);?>){
					alert('Kunjungan puskesmas belum buka...');
					return false;
				}

				if(<?php echo strtotime(date('G:i'));?> >= <?php echo strtotime($datasetting['WaktuPelayananTutup']);?>){
					alert('Kunjungan puskesmas sudah tutup...');
					return false;
				}
			
				var kodepoli = $(this).find("h4").text();
				var poli = $(this).find("strong").text();
				//var jmlantrian = $(this).find("h4").text();
				var jmlantrian = <?php echo $jml_antrian;?>;
				var jmllimit = $(this).find("h5").text();
				var sisa = $(this).find(".sisaantrian").data('sisa');
				
				if(sisa <= 0){
					alert("MAAF, KUOTA PELAYANAN SUDAH HABIS/TUTUP...");
					return false;
				}

				if(poli == 'PROLANIS'){
					var vardt = new Date();
  					var daynumber = vardt.getDay();
  					var haridibolehkan = '<?php echo $datasetting['Prolanis'];?>';
  					var ceks = haridibolehkan.indexOf(daynumber);
					if(ceks == '-1'){
						alert("MAAF, PELAYANAN SUDAH TUTUP...");
						return false;
					}
				}else if(poli == 'IMUNISASI'){
					var vardt = new Date();
  					var daynumber = vardt.getDay();
  					var haridibolehkan = '<?php echo $datasetting['Imunisasi'];?>';
  					var ceks = haridibolehkan.indexOf(daynumber);
					if(ceks == '-1'){
						alert("MAAF, PELAYANAN SUDAH TUTUP...");
						return false;
					}
				}

				$(".politerpilih").text(poli);
				$("#modalconfpilihpoli").modal("show");
				// $("#modalpilihjaminan").modal("show");
			});

			// $(document).on("click", ".btnpasien-umum", function() {	
			// 	$("#modalconfpilihpoli").modal("show");
			// });
		
			// $(document).on("click", ".btnpasien-bpjs", function() {	
			// 	var kodepoli = $(".pilihpoli2").data('kodepoli');
			// 	var namapoli = $(".pilihpoli2").data('namapoli');

			// 	$.post( "get_dokter_bpjs.php", { kodepoli:kodepoli})
			// 		.done(function( data ) {
			// 			$( ".dokterbpjs" ).html( data );
			// 	});

			// 	$("#kodepoli").val(kodepoli);
			// 	$("#namapoli").val("POLI "+namapoli);
			// 	$("#modalformantrianbpjs").modal("show");
			// });
			// $(document).on("change", "#nokartu", function() {	
			// 	var nokartu = $(this).val();

			// 	$.post( "get_nik_bynokartubpjs.php", { nokartu:nokartu})
			// 		.done(function( data ) {
			// 			if(data == ''){
			// 				alert('No Kartu tidak valid');
			// 				$( "#nokartu" ).val( '' );
			// 				$( "#nik" ).val( '' );
			// 			}else{
			// 				$( "#nik" ).val( data );
			// 			}
						
			// 	});
			// });

			// $(document).on("change", "#nik", function() {	
			// 	var nik = $(this).val();

			// 	$.post( "get_nik_bynikbpjs.php", { nik:nik})
			// 		.done(function( data ) {
			// 			if(data == ''){
			// 				alert('No NIK tidak valid');
			// 				$( "#nokartu" ).val( '' );
			// 				$( "#nik" ).val( '' );
			// 			}else{
			// 				$( "#nokartu" ).val( data );
			// 			}
						
			// 	});
			// });
			

			// $(document).on("change", ".dokterbpjs", function() {	
			// 	var jampraktek = $(this).find(':selected').data('jampraktek');
				

			// 	$("#jampraktek").val(jampraktek);
			// });

			$(".btnprosess").click(function() {
				var poli = $(".poliradio:checked").val();
				var klaster = $(".poliradio:checked").data('klaster');
				//alert('klaster: '+klaster);
				if(poli != null){
						$.post( "etiket.php", { poli:poli, klaster:klaster})
						  .done(function( data ) {
							 $( ".antrianshtml" ).html( data );
							// alert(data);
							// window.location='index.php';
						});
				}else{
					alert('Silahkan pilih pelayanan kesehatan....');
				}
			});

			$(".btnsimpanbpjs-proses").click(function() {
				var poli = $(".poliradio:checked").val();
				var kodepoli = $("#kodepoli").val();
				var namapoli = $("#namapoli").val();
				var nokartu = $("#nokartu").val();
				var nik = $("#nik").val();
				var nohp = $("#nohp").val();
				var norm = $("#norm").val();
				var kodedokter = $(".dokterbpjs").val();
				var namadokter = $(".dokterbpjs").find(':selected').data('namadokter');
				var jampraktek = $(".dokterbpjs").find(':selected').data('jampraktek');
				if(poli != null){
					$.post( "etiket-bpjs.php", { poli:poli, kodepoli:kodepoli, namapoli:namapoli, nokartu:nokartu, nik:nik, nohp:nohp, norm:norm, kodedokter: kodedokter, namadokter:namadokter, jampraktek:jampraktek})
						.done(function( data ) {
							// console.log(data);
						$( ".antrianshtml" ).html( data );
					});
				}else{
					alert('Silahkan pilih pelayanan kesehatan....');
				}
			});

			$(document).on("click", ".btnmodalconf", function() {	
				$("#modallogin").modal("show");
			});
			
			$(document).on("click", "#btnlogs", function() {
				var pass = $("#pass").val();
				var kd = $(".kdpus").val();
				$.post( "login_proses_jquery.php", { kd:kd, pass:pass})
				  .done(function( data ) {
				  	// console.log(data);
					if(parseInt(data) == 1){
						window.location='index.php?page=dashboard';
					}else{
						alert('Password salah.');
						$("#modallogin").modal("hide");
					}
				});
			});
			
			// function print_current_page(Copies){
				// var Count = 0;
				// while (Count < Copies){
					// window.print(0);
					// Count++;
				// }
			// }
			
		});
	</script>	
	
	<script>
		if(typeof(EventSource) !== "undefined") {
		  var source = new EventSource("cek_setting_antrian.php?waktu=<?php echo $datasetting['Waktu'];?>");
		  source.onmessage = function(event) {
			  if(event.data == 1){
				  window.location.reload(true);
			  }	
			//console.log(event.data);
			
		  };
		} else {
		  alert("Maaf, browser anda tidak suport server-sent events...");
		}
	</script>
	
</div>
