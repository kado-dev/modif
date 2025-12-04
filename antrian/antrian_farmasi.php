<?php
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$cek_tbview_antrianfarmasi = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbantrian_farmasi_view where KodePuskesmas = '$kodepuskesmas'"));
if($cek_tbview_antrianfarmasi == 0){
	echo "<script>";
	echo "alert('Silahkan upgrade ke layanan custom');";
	echo "document.location.href='index.php?page=dashboard';";
	echo "</script>";
	die();
}
$tbantrian_farmasi = "tbantrian_farmasi_".str_replace(' ', '', $puskesmas);
$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));
?>
<style type="text/css">
	.tmpdetail{
		padding: 3vh 1vw;
	}
</style>
<div class="antrianshtml">
	<?php
		$jml_antrian_total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM $tbantrian_farmasi WHERE date(WaktuAntrian) = CURDATE() AND KodePuskesmas = '$kodepuskesmas'"));
	?>			
	<div class="row" style="background: #666666;margin:0px;padding:0.5vw 0.9vw;border-radius: 0.4vw;margin-bottom: 0.7vw; color: #fff">
		<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: left;">ANTRIAN FARMASI PUSKESMAS</div>
		<div class="col-sm-6" style="font-size:1.5vw; font-weight:bold;text-align: right;">TOTAL ANTRIAN = <?php echo $jml_antrian_total;?></div>			
	</div>
	<!-- <form action="index.php?page=etiket" method="post"> -->
	
		<div class="row">
			
			<div class="col-sm-12 tmpdetail">

			</div>
			<div class="col-sm-10">
				<div style="background: #ddd;color:#000;font-size:2.5vw;font-weight:bold;padding:10vh 4vw;border-radius:0.8vh;text-align: center;margin-bottom: 2vw">
					<?php
						if($puskesmas != 'NAGREG'){
							echo "<input type='hidden' class='noantrian2'>";
							echo "<input type='text' class='noantrian' autofocus='autofocus' style='position:absolute;z-index:-1'>";
							echo "<p style='background:#fff;border:5px solid #444444;border-radius:1vw;font-size:2.5vw;padding:2.4vh 1vw'>TEMPEL NOMER ANTRIAN PENDAFTARAN</p>";
						}else{
							echo 'AMBIL ANTRIAN OBAT<br/>(TEKAN TOMBOL MERAH)';
						}
					?>
				</div>
			</div>
			<div class="col-sm-2">
				<button class="btn btn-lg btn-danger btn-login btn-block btnprosess" style="padding:10vh 2vw; margin-bottom: 2vh" name="btns" type="button">TEKAN</button>
			
				<a href="#" class="btn btn-lg btn-primary btn-block btn-login btnmodalconf" type="button">KEMBALI</a>
			</div>
		</div>
				
	<!-- </form> -->

	<div class="modal fade" id="modallogin" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title">Otoritas</h3>
	    
	      </div>
	      <div class="modal-body">
			<form style="display:flex">
				<input type="hidden" class="kdpus" value="<?php echo $kodepuskesmas;?>"/>
				<input type="password" name="pass" id="pass" placeholder="Ketikan password" class="form-control input-lg forminputs"/>
				<button type="button" class="btn btn-info btn-lg btns" id="btnlogs" style="margin-left: 10px">Login</button>
			</form>
			<br/>
			
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="../assets/js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".noantrian").keypress(function(e) {
				var key = e.which;
				if(key == 13){// the enter key code
					var noantrian = $(this).val();
					$(".noantrian2").val(noantrian);
					if(noantrian != ''){
						$.post( "etiket_farmasi_getname.php", { noantrian:noantrian})
						  .done(function( data ) {
							 $( ".tmpdetail" ).html( data );
							 $(".noantrian").val('');
						});
					}
				}
			});
		
			$(".btnprosess").click(function() {
				var noantrian = $(".noantrian2").val();
				//if(noantrian != null){
						$.post( "etiket_farmasi.php", { noantrian:noantrian})
						  .done(function( data ) {
						  	if(data != 'tidak ditemukan'){
							 $( ".antrianshtml" ).html( data );
						  	}
						});
				// }else{
				// 	alert('Silahkan pilih pelayanan kesehatan....');
				// }
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
