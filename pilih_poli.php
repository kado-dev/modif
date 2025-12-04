<?php
$tbantrian_pasien = "tbantrian_pasien_".$_COOKIE['kodepuskesmas2'];
$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));

if($datasetting['versi_antrian'] == 'versi2'){
	include "pilih_poli_v2.php";
}else{
?>

<div class="antrianshtml">
	<?php
		$jml_antrian_total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM $tbantrian_pasien WHERE date(WaktuAntrian) = CURDATE()"));
	?>			
	<div class="row" style="background: #666666;margin:0px;padding:0.5vw 0.9vw;border-radius: 0.4vw;margin-bottom: 0.7vw; color: #fff">
		<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: left;">ANTRIAN PUSKESMAS</div>
		<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: right;">TOTAL ANTRIAN PASIEN = <?php echo $jml_antrian_total;?></div>			
	</div>
	<form action="index.php?page=etiket" method="post">
		<div class="row">
		<div class="col-md-12" style="padding-top:-5px;">
			<div class="row">
			<?php
			$query = mysqli_query($koneksi, "SELECT * FROM `tbantrian_pelayanan` WHERE Jumlah > 0 AND KodePuskesmas = '$kodepuskesmas' ORDER BY `KodePelayanan` ASC");
			while($data = mysqli_fetch_assoc($query)){
			$jml_antrian = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM $tbantrian_pasien WHERE PoliPertama = '$data[Pelayanan]' AND date(WaktuAntrian) = CURDATE() AND KodePuskesmas = '$kodepuskesmas' GROUP BY NomorAntrian, NomorAntrianPoli"));
			
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
				<div class="col-sm-2 menudepan">
					<label class="radio alert clickpoli" style="min-height:14.5vh;padding:0.5vw;border-radius: 0.4vw;margin:1vw 0vw;<?php if($sisaantrian == 0){echo 'background:#fffdd1;';}?>">
						<input type="radio" name="poli" value="<?php echo $data['Pelayanan'];?>" class="poliradio" style="display:none;width: 1px;" required>
						<h4 style="font-size:1.2vw; display: none;"><?php echo $data['KodePelayanan'];?></h4>
						<strong style="font-size:1vw"><?php echo $data['KodePelayanan']." - ".$data['Pelayanan'];?></strong>
						<?php
							if($data['Pelayanan'] == 'MTBS'){
								echo "<span style='font-size:1vw; line-height: 1.2vw;'>(0 s/d 5 th)</span>";
							}else if($data['Pelayanan'] == 'LANSIA'){
								if($_COOKIE['kota2'] == "KOTA TARAKAN"){
									echo "<span style='font-size:1vw; line-height: 1.2vw;'>( >= 45th )</span>";
								}else{
									echo "<span style='font-size:1vw; line-height: 1.2vw;'>( >= 60th )</span>";
								}
							}else if($data['Pelayanan'] == 'ANAK'){
								if($_COOKIE['kota2'] == "KOTA TARAKAN"){
									echo "<span style='font-size:1vw; line-height: 1.2vw;'>(BAYI - < 14 TH)</span>";
								}else{
									echo "<span style='font-size:1vw; line-height: 1.2vw;'>(BAYI - < 5 TH)</span>";
								}	
							}else if($data['Pelayanan'] == 'UMUM'){
								if($_COOKIE['kota2'] == "KOTA TARAKAN"){
									echo "<span style='font-size:1vw; line-height: 1.2vw;'>(14TH - <= 44 TH)</span>";
								}else{
									echo "<span style='font-size:1vw; line-height: 1.2vw;'>(5TH - <= 59 TH)</span>";
								}	
									
							}
						?>
						<br/>
						<span style="font-size:1.7vw"><?php echo $jml_antrian;?></span><br/>
						<h5 style="font-size:1.1vw; display: none;"><?php echo $data['Jumlah'];?></h5>
						<?php 						
						 if(strtotime(date('G:i')) <= strtotime($datasetting['WaktuPelayananTutup'])){?>
						<p class="sisaantrian" data-sisa="<?php echo $sisaantrian;?>" style="font-size:1vw; font-weight: normal; margin-top: -8px;">Sisa : <?php echo $sisaantrian;?></p>
						<?php }?>
					</label>
				</div>
			<?php
				}
			}
			?>	

				<div class="col-sm-2 menudepan">
					<a href="../anjunganpasien/index.php" target="_blank" style="cursor: pointer;">
					<label class="radio alert clickpoli" style="min-height:14.5vh;cursor: pointer;padding:1.4vw;border-radius: 0.4vw;margin:1vw 0vw; background: #f5f5f5">
						<h4 style="font-size:1.2vw; display: none;">Anjungan Daftar Mandiri</h4>
						<strong style="font-size:1vw">ANJUNGAN <br/>DAFTAR MANDIRI</strong>
					</label>
					</a>
				</div>			
			</div>
		</div>
		<div class="col-md-12" style="padding-top: 2.5vw">
			<div class="row">
				<div class="col-sm-6">
					<a href="#" class="btn btn-lg btn-primary btn-block btn-login btnmodalconf" type="button">KEMBALI</a>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-lg btn-success btn-login btn-block btnprosess" name="btns" type="button">PRINT</button> <!--onclick="print_current_page(2)"-->
				</div>
			</div>
		</div>
	</div>
	</form>

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
					alert("MAAF, PELAYANAN SUDAH TUTUP...");
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
			});
		
			$(".btnprosess").click(function() {
				var poli = $(".poliradio:checked").val();
				if(poli != null){
						$.post( "etiket.php", { poli:poli})
						  .done(function( data ) {
							 $( ".antrianshtml" ).html( data );
							 // alert(data);
							// window.location='index.php';
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
				  	console.log(data);
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

<?php
}
?>