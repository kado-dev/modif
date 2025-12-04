<?php
//$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * from tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));
if($datasetting['PoliGigi'] == null or $datasetting['WaktuPelayanan'] == null){
	echo "<script>";
	echo "alert('Silahkan isi jumlah antrian poli dan waktu pelayanan');";
	echo "window.location='index.php?page=dashboard';";
	echo "</script>";
}


?>

<div class="antrianshtml">
	<?php
	$jml_antrian_total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbantrian_pasienv2` WHERE date(WaktuAntrian) = CURDATE() AND KodePuskesmas = '$kodepuskesmas'"));
	?>
		<p align="center" style="font-size:16px; font-weight:bold;">Silahkan Pilih Pelayanan Pemeriksaan<br>
		<span style="font-size: 24px; color: green;">Total Antrian Pasien: <?php echo $jml_antrian_total;?><span></p>
		
		<form action="index.php?page=etiket" method="post">
			<div class="col-md-12" style="padding-top:-5px;">
				<div class="row">
				
					<div class="col-sm-offset-3 col-sm-3 menudepan">
						<label class="radio alert alert-info clickpoli" style="padding:25px;font-size:24px">
							<input type="radio" name="carabayar" value="BPJS" class="poliradio" style="display:none;" required>
							<strong>BPJS</strong>
						</label>
					</div>
					<div class="col-sm-3 menudepan">
						<label class="radio alert alert-info clickpoli" style="padding:25px;font-size:24px">
							<input type="radio" name="carabayar" value="UMUM" class="poliradio" style="display:none;" required>
							<strong>UMUM</strong>
						</label>
					</div>		
				</div>
			</div>
			<div style="text-align:right;padding-right:15px;margin-bottom:20px">
				<button class="btn btn-lg btn-success btn-login btnprosess" name="btns" type="button">Print</button>
			</div>
			</form>
			
			
		

		<script src="../assets/js/jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".clickpoli").click(function(){
					if(<?php echo strtotime(date('G:i'));?> >= <?php echo strtotime($datasetting['WaktuPelayanan']);?>){
						alert('Kunjungan puskesmas sudah tutup.');
						return false;
					}
				});
			
				$(".btnprosess").click(function() {
					var poli = $(".poliradio:checked").val();
					if(poli != null){
							$.post( "etiket_v2.php", { poli:poli})
							  .done(function( data ) {
								 $( ".antrianshtml" ).html( data );
								 // alert(data);
								// window.location='index.php';
							});
					}else{
						alert('Silahkan pilih pelayanan kesehatan.');
					}
				});
				
			});
		</script>	
</div>
