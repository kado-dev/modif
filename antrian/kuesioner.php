<?php
	session_start();
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
?>
<style>
.header,.footer{
	display:none;
}
.item{
	height:315px;
}
.item .tmpbtn{
	position:absolute;
	bottom:0px;
	right:0px;
	left:0px;
}
.item .tmpbtn a, .item .tmpbtn button{
	width: 49%;
}
.item>p{
	font-size: 20px; 
	font-weight: normal;
	height:55px;
}	
.item>p>label{
	font-size: 16px; 
	font-weight: normal;
	background:#fff;
	border:2px solid #ddd;
	padding:8px;
	border-radius:5px;
	display:block;
}	
.item>p>label:hover{
	border:2px solid #7093ea;cursor:pointer;
}
.modalku{
	width: 800px;
	height: 300px;
	position: fixed;
	left: 50%;
	margin-top: 50%;
	transform: translate(-50%, -50%);
}
.tr, th{
	text-align:center;
}	
.judul{
	font-family: "Roboto Condensed", Arial, sans-serif;text-align:center;
}


/*kolom search*/
.formnik{
	display: flex;justify-content: space-between;
}
.formnik input{
	border-radius: 10px;width:37vw !important;
	box-shadow: 0px 0px 12px #ccc;font-size: 1.2vw;height:3.3vw;
}
.formnik button{
	width:6vw;font-size: 1.2vw;padding:0.3vw;
}
.btns{
	font-size: 1.5vw;font-weight: 400;padding:0.8vw;
}
.kolomkonten2{
	width: 45vw;margin:auto; margin-top: 4vw;;
}
.clickpoli{
	padding:1.5vw;text-transform: uppercase;
}
</style>

<div class="antrianshtml">
	<?php
		error_reporting(0);
		if(isset($_GET['key'])){
			// cari NoIndex tbpasienrj
			if(strlen($_GET['key']) == '10'){
				$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				$strpasien = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoIndex,-10) = '".$_GET['key']."' AND `TanggalRegistrasi` = curdate()";
				$querypasien = mysqli_query($koneksi,$strpasien);
				$ceklist = mysqli_num_rows(mysqli_query($koneksi,$strpasien));
			if ($ceklist > 0){ 
	?>
		<div class="modal" tabindex="-1" role="dialog" id="mdllist">
			<div class="modal-dialog" role="document">
				<div class="modal-content modalku">
					<div class="modal-body">
						<table class="table-judul table-striped" width="100%">
							<thead>
								<tr>
									<th width="15%">Tgl.Registrasi</th>
									<th width="30%">Nama Pasien</th>
									<th width="5%">L/P</th>
									<th width="10%">Umur</th>
									<th width="15%">Pelayanan</th>
									<th width="10%" align="center">Aksi</th>
								</tr>
							</thead>
							<tbody>
							<?php
								while($dtpasien = mysqli_fetch_assoc($querypasien)){
								$nocm = $dtpasien['NoCM'];
							
								
							?>
							<tr>
								<td align="center"><?php echo $dtpasien['TanggalRegistrasi'];?></td>
								<td align="left"><?php echo $dtpasien['NamaPasien'];?></td>
								<td align="center"><?php echo $dtpasien['JenisKelamin'];?></td>
								<td align="center"><?php echo $dtpasien['UmurTahun']." Th ".$dtpasien['UmurBulan']." Bl";?></td>
								<td align="center"><?php echo $dtpasien['PoliPertama'];?></td>
								<td align="center"><a href="?page=kuesioner&key=<?php echo $dtpasien['NoCM'];?>" class="btn btn-sm btn-info btn_smal">PILIH</a></td>
							</tr>
							<?php 
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php
				}
			
			}else{
				$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				$strpasien = "SELECT * FROM `$tbpasienrj` WHERE NoCM = '".$_GET['key']."'";
				
				$querypasien = mysqli_query($koneksi,$strpasien);
				$ceks = mysqli_num_rows(mysqli_query($koneksi,$strpasien));//cek berdasar nocm
			}
	
		}	
	?>


		<?php
			if($ceks == 0){
		?>				
			<div class="kolomkonten2">
				<form method="get" class="formnik">
					<input type="hidden" name="page" value="kuesioner">
					<input type="text" name="key" class="form-control input-lg nama" placeholder="Scan / ketikan nomer kartu pasien..."/>
					<button type="submit" class="btn btn-primary btns">Cari</button>
					<?php if (isset($_GET['key']) && $ceklist == 0){ ?>
						<div class="col-sm-12" ><br/>
							<div class="alert alert-danger" style="font-weight: normal;"><i class="ace-icon fa fa-times"></i>Data tidak ditemukan! Silahkan ulangi pencarian...</div>
						</div>
					<?php } ?>
				</form>
			</div>	
		<?php
			}	
			if($ceks > 0){
				
			$dt_psn = mysqli_fetch_assoc($querypasien);		
			$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM`='$dt_psn[NoCM]'"));
			$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex`='$dt_psn[NoIndex]'"));	
		?>
		<div class="row" style="background: #707070;margin:0px;padding:0.5vw 0.9vw;border-radius: 0.4vw;margin-bottom: 0.7vw; color: #fff">
			<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: left;"><?php echo strtoupper($dt_psn['NamaPasien']);?></div>		
		</div>
		
		<div class="row">	
			<div class="col-sm-12">
				<?php
					$polipelayanan = $_GET['poli'];
					if($polipelayanan == ''){
						?>
						<h4 class="judul" style="margin-top: 20px;"><b>SILAHKAN PILIH PELAYANAN</b></h4>
						<div class="row">
							<?php									
								$tbpelayanan = mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas` = '$kodepuskesmas'");
								while($dtpel = mysqli_fetch_array($tbpelayanan)) {									
									$pel_arr[] = $dtpel['Pelayanan'];
								}

								$pelayanan_arr = array('Pendaftaran','Farmasi');
								$tbantrian_kuisioner = "tbantrian_kuisioner_".$kodepuskesmas;
								$pelayanan_arrs = array_merge($pelayanan_arr, $pel_arr);

								foreach($pelayanan_arrs as $pel){	
								$cek_nocm = mysqli_num_rows(mysqli_query($koneksi,"SELECT id FROM $tbantrian_kuisioner where nocm='$dt_psn[NoCM]' and pelayanan = '$pel' AND Date(`waktu`) = curdate()"));								
							?>
							<div class="col-sm-3 menudepan" style="padding-bottom: 10px">
								<?php
									if($cek_nocm == 0){
								?>
								<a href="?page=kuesioner&key=<?php echo $_GET['key'];?>&poli=<?php echo $pel;?>">
								<?php }else{
									echo "<a href='#'>";
								} ?>
								<label class="radio alert clickpoli">
								<?php echo $pel;?>
								</label>	
								</a>	
							</div>		
							<?php } ?>
						</div>
						<?php
					}else{
				?>
				<!--Pertanyaan-->
				<h4 class="judul" style="margin-top: 0px;"><b>Pertanyaan</b></h4>
				
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				  
					<div class="item active" >
						<p>1. Bagaimana Pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?</p>
						<p>
							<label><input type="radio" name="no1" value="1"> Tidak Sesuai</label>
							<label><input type="radio" name="no1" value="2"> Kurang Sesuai</label>
							<label><input type="radio" name="no1" value="3"> Sesuai</label>
							<label><input type="radio" name="no1" value="4"> Sangat Sesuai</label>
						</p>
						<span class="tmpbtn">						
						<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
							
							<span>Next</span>
						</a>
						<a href="?page=kuesioner&key=<?php echo $_GET['key'];?>"class="btn btn-info pull-left">
							
							<span>Back</span>
						</a>
						</span>
					</div>
					<div class="item">
						<p>
							2. Bagaimana pemahaman saudara tentang kemudahan prosedure pelayanan di unit ini?
						</p>
						<p>
							<label><input type="radio" name="no2" value="1"> Tidak Mudah</label>
							<label><input type="radio" name="no2" value="2"> Kurang Mudah</label>
							<label><input type="radio" name="no2" value="3"> Mudah</label>
							<label><input type="radio" name="no2" value="4"> Sangat Mudah</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev">
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							3. Bagaimana pendapat saudara tentang kecepatan waktu dalam memberikan pelayanan?
						</p>
						<p>
							<label><input type="radio" name="no3" value="1"> Tidak Cepat</label>
							<label><input type="radio" name="no3" value="2"> Kurang Cepat</label>
							<label><input type="radio" name="no3" value="3"> Cepat</label>
							<label><input type="radio" name="no3" value="4"> Sangat Cepat</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev">
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							4. Bagaimana pendapat saudara tentang kewajaran biaya/tarif dalam pelayanan?
						</p>
						<p>
							<label><input type="radio" name="no4" value="1"> Sangat Mahal</label>
							<label><input type="radio" name="no4" value="2"> Cukup Mahal</label>
							<label><input type="radio" name="no4" value="3"> Murah</label>
							<label><input type="radio" name="no4" value="4"> Gratis</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev" >
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							5. Bagaimana pendapat saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standart pelayanan dengan hasil yang diberikan?
						</p>
						<p>
							<label><input type="radio" name="no5" value="1"> Tidak Sesuai</label>
							<label><input type="radio" name="no5" value="2"> Kurang Sesuai</label>
							<label><input type="radio" name="no5" value="3"> Sesuai</label>
							<label><input type="radio" name="no5" value="4"> Sangat Sesuai</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev" >
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							6. Bagaimana pendapat saudara tentang kompetensi/kemampuan petugas dalam pelayanan?
						</p>
						<p>
							<label><input type="radio" name="no6" value="1"> Tidak Kompeten</label>
							<label><input type="radio" name="no6" value="2"> Kurang Kompeten</label>
							<label><input type="radio" name="no6" value="3"> Kompeten</label>
							<label><input type="radio" name="no6" value="4"> Sangat Kompeten</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev" >
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							7. Bagaimana pendapat saudara perilaku petugas dalam pelayanana terkait kesopanan dan keramahan?
						</p>
						<p>
							<label><input type="radio" name="no7" value="1"> Tidak Sopan dan Ramah</label>
							<label><input type="radio" name="no7" value="2"> Kurang Sopan dan Ramah</label>
							<label><input type="radio" name="no7" value="3"> Sopan dan Ramah</label>
							<label><input type="radio" name="no7" value="4"> Sangat Sopan dan Ramah</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev">
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							8. Bagaimana pendapat saudara tentang penanganan pengaduan, saran dan masukan pada pelayanan ini?
						</p>
						<p>
							<label><input type="radio" name="no8" value="1"> Tidak Ada</label>
							<label><input type="radio" name="no8" value="2"> Ada Tetapi Tidak Diterapkan</label>
							<label><input type="radio" name="no8" value="3"> Diterapkan Tetapi Kurang Maksimal</label>
							<label><input type="radio" name="no8" value="4"> Diterapkan Sepenuhnya</label>	
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev">
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p>
							9. Bagaimana pendapat saudara tentang sarana dan prasarana pelayanan ?
						</p>
						<p>
							<label><input type="radio" name="no9" value="1"> Tidak Ada</label>
							<label><input type="radio" name="no9" value="2"> Ada Tetapi Tidak Berfungsi</label>
							<label><input type="radio" name="no9" value="3"> Berfungsi Kurang Maksimal</label>
							<label><input type="radio" name="no9" value="4"> Dikelola Dengan Baik</label>
						</p>
						<span class="tmpbtn">
							<a class="btn btn-info pull-right" href="#carousel-example-generic" role="button" data-slide="next">
								
								<span>Next</span>
							</a>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev" >
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					<div class="item">
						<p style="font-size:25px">
							10. Saran dan masukan
						</p>
						<p>
							<textarea name="saran" class="form-control saran" rows="7" placeholder="Silahkan ketik saran dan masukan disini..."></textarea>
						</p>
						<span class="tmpbtn">
							<button type="button" class="btn btn-info btn-block pull-right simpanquiz">Simpan</button>
							<a class="btn btn-info pull-left" href="#carousel-example-generic" role="button" data-slide="prev">
								
								<span>Previous</span>
							</a>
						</span>
					</div>
					 </div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		<?php
			}
		?>
	<br/>
	<p style="text-align: center;color: white;font-weight: normal; text-transform: uppercase"><?php echo date('Y');?> | Dinas Kesehatan <?php echo $_COOKIE['kota2'];?></p>

	
	<script src="../assets/js/jquery.js"></script>
	<script type="text/javascript">
	//window.onbeforeunload = function() { return "Your work will be lost."; };

		$(document).ready(function() {
/**
			  if (window.history && window.history.pushState) {
			    $(window).on('popstate', function() {
			      var hashLocation = location.hash;
			      var hashSplit = hashLocation.split("#!/");
			      var hashName = hashSplit[1];

			      if (hashName !== '') {
			        var hash = window.location.hash;
			        if (hash === '') {
			          window.location.href='index.php?page=logout';
			        }
			      }
			    });

			    window.history.pushState('forward', null, './index.php');
			  }
**/
			$('#mdllist').modal('show');
		
			$("a").click(function(e){
				var dtslide = $(this).data('slide');
				if(dtslide == 'next'){
					
					var nums = $(this).parent().parent().find("input[type=radio]:checked").length;
					if(nums == 0){
						alert('Silahkan pilih jawaban');
						return false;
					}
				}
			});

			$("input[type='radio']").click(function(e){
				$(this).parent().parent().find("label").css("background","white");
				$(this).parent().css("background","yellow");
			});
		
			$('.carousel').carousel({
			  interval: 3600000
			});
		
			$(".simpanquiz").click(function(){
				var nocm = $(".nocm").val();
				var nama = $(".namas").val();
				var alamat = $(".alamat").val();
				var pekerjaan = $(".pekerjaan").val();
				var pendidikan = $(".pendidikan").val();
				var umur = $(".umur").val();
				var jk = $(".jk").val();
				var pelayanan = "<?php echo $_GET['poli'];?>";
				
				var no1 = $("input[name=no1]:checked").val();
				var no2 = $("input[name=no2]:checked").val();
				var no3 = $("input[name=no3]:checked").val();
				var no4 = $("input[name=no4]:checked").val();
				var no5 = $("input[name=no5]:checked").val();
				var no6 = $("input[name=no6]:checked").val();
				var no7 = $("input[name=no7]:checked").val();
				var no8 = $("input[name=no8]:checked").val();
				var no9 = $("input[name=no9]:checked").val();
				var saran = $(".saran").val();
				
				if(umur != '' && jk != '' && nocm != '' && saran != '' && pendidikan != '' && pekerjaan != '' && nama != '' && alamat != '' && no1 != '' && no2 != '' && no3 != '' && no4 != '' && no5 != '' && no6 != '' && no7 != '' && no8 != '' && no9 != ''){
					$.post( "simpan_kuisioner.php", { pelayanan:pelayanan,umur:umur,jk:jk, nocm:nocm,saran:saran, pendidikan:pendidikan, pekerjaan:pekerjaan, nama:nama, alamat:alamat, no1:no1, no2:no2, no3:no3, no4:no4, no5:no5, no6:no6, no7:no7, no8:no8, no9:no9})
						.done(function( data ) {
							if (data == 'table tidak ada'){
								alert("gagal:Tabel belum dibuat");
							}else{
								//$( ".alertskuis" ).html("<div class='alert alert-success'>Kuisoner berhasil disimpan...</div>");
								$('#mdl').modal('show');
								setInterval(function(){ window.location.href='index.php?page=kuesioner'; }, 3000);
								$('#mdl').on('hidden.bs.modal', function (e) {
								  // do something...
								  window.location.href='index.php?page=kuesioner';
								})
							}
						});
				}else{
					alert('Silahkan isi semua jawaban dan data diri anda...');
				}
			});
		});
	</script>	
</div>
<div class="modal" tabindex="-1" role="dialog" id="mdl">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body" style="text-align:center">
				<span class="glyphicon glyphicon-ok" style="width:90px"></span><br/>
				<h3>Kuisoner berhasil disimpan...</h3>
				<br/>
				Terimakasih atas waktu anda
				<br/>
				Halaman akan dialihkan dalam 3 detik
			</div>
		</div>
	</div>
</div>