<style type="text/css">
	.item{
		height:335px;
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
</style>
<div class="row search-page" id="search-page-1">
	<div class="col-xs-12">
		<div class="tableborderdiv">
			<h3 class="judul"><b>KUISIONER</b></h3>
			<div class="formbg">
				<?php
					$kodepuskesmas = $_SESSION['kodepuskesmas'];
					$idpegawai = $_SESSION['idpegawai'];
					$cekpengisian = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbkuisioner WHERE IdPegawai = '$idpegawai' AND KodePuskesmas = '$kodepuskesmas'"));
					if($cekpengisian > 0){
				?>
					<div class='alert alert-success'>Terimakasih, Anda sudah mengisi Kuisioner</div>
				<?php		
					}else{
				?>

				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				  
						<div class="item active" >
							<p>1. Apakah SIMPUS membantu anda dalam pengolahan data pelaporan Puskesmas?
							</p>
							<p>
								<label><input type="radio" name="no1" value="Sangat Membantu"> Sangat Membantu</label>
								<label><input type="radio" name="no1" value="Membantu"> Membantu</label>
								<label><input type="radio" name="no1" value="Cukup Membantu"> Cukup Membantu</label>
								<label><input type="radio" name="no1" value="Tidak Membantu"> Tidak Membantu</label>
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
								2. Bagaimana pendapat anda mengenai kemudahan proses penginputan SIMPUS dalam pelayanan?
							</p>
							<p>
								<label><input type="radio" name="no2" value="Sangat Mudah"> Sangat Mudah</label>
								<label><input type="radio" name="no2" value="Mudah"> Mudah</label>
								<label><input type="radio" name="no2" value="Cukup Mudah"> Cukup Mudah</label>
								<label><input type="radio" name="no2" value="Tidak Mudah"> Tidak Mudah</label>
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
								3. Bagaimana pendapat anda mengenai fitur menu Simpus saat ini?
							</p>
							<p>
								<label><input type="radio" name="no3" value="Sangat Lengkap"> Sangat Lengkap</label>
								<label><input type="radio" name="no3" value="Lengkap"> Lengkap</label>
								<label><input type="radio" name="no3" value="Cukup Lengkap"> Cukup Lengkap</label>
								<label><input type="radio" name="no3" value="Tidak Lengkap"> Tidak Lengkap</label>
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
								4. Apakah menurut anda perlu ada penambahan menu di SIMPUS untuk pengembangan berikutnya, jika ada sebutkan menu apa yang harus ditambahkan ?
							</p>
							<p>
								<label><input type="radio" name="no4" value="Tidak Perlu"> Tidak Perlu</label>
								<label><input type="radio" name="no4" value="Perlu"> Perlu</label>
								<textarea name="no4uraian" class="form-control no4uraian" style="display: none" rows="5" placeholder=""></textarea>
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
								5. Berikan Kritik dan Saran Terhadap SIMPUS aplikasi Puskesmas Online 
							</p>
							<p>
								<textarea name="saran" class="form-control saran" rows="7" placeholder="Silahkan ketik saran dan masukan disini..."></textarea>
							</p>
							<span class="tmpbtn">
								<button type="button" class="btn btn-info pull-right simpanquiz">Simpan</button>
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
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
		$(document).ready(function() {

			//$('#mdllist').modal('show');
		
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

				if($("input[name=no4]:checked").val() == 'Perlu'){
					$(".no4uraian").show();
				}else{
					$(".no4uraian").hide();
				}
				
			});
		
			$('.carousel').carousel({
			  interval: 3600000
			});
		
			$(".simpanquiz").click(function(){				
				var no1 = $("input[name=no1]:checked").val();
				var no2 = $("input[name=no2]:checked").val();
				var no3 = $("input[name=no3]:checked").val();
				var no4 = $("input[name=no4]:checked").val();
				var no4uraian = $(".no4uraian").val();
				var saran = $(".saran").val();
				
				if(no1 != '' && no2 != '' && no3 != '' && no4 != ''){
					$.post( "simpan_kuisioner.php", { no1:no1, no2:no2, no3:no3, no4:no4, no4uraian:no4uraian, saran:saran})
						.done(function( data ) {
							if (data == 'table tidak ada'){
								alert("Data gagal disimpan");
							}else{
								
								  // do something...
								  window.location.href='index.php?page=kuisioner';
								
							}
						});
				}else{
					alert('Silahkan isi semua jawaban dan data diri anda...');
				}
			});
		});
</script>