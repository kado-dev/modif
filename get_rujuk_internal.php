<?php
	session_start();
	include "config/koneksi.php";
	$idpsnrj = $_POST['idpsnrj'];
?>

<div class="table-responsive mt-4">
	<table class="table-judul" width="100%">
		<h3 class="judul"><b>Rujuk Internal</b></h3>
		<tr>
			<td class="col-sm-3">Rujuk Internal 1</td>
			<td class="col-sm-9">
				<select name="poliinternal" class="form-control inputan poliinternal" required>
					<option value="-">--Pilih--</option>
					<?php

						$get_rujukinternal = mysqli_query($koneksi, "SELECT * FROM `tbrujukinternal` WHERE `IdPasienrj`='$idpsnrj'");
						if(mysqli_num_rows($get_rujukinternal) == 0){
							$dtreg['PoliRujukan'] = '';
							$dtreg['PoliRujukan2'] = '';
							$dtreg['PoliRujukan3'] = '';
							$dtreg['PoliRujukan4'] = '';
							$dtreg['PoliRujukan5'] = '';
						}else{
							$dtreg = mysqli_fetch_assoc($get_rujukinternal);
						}
						$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
						while($data = mysqli_fetch_assoc($query)){
							if($data['Pelayanan'] == $dtreg['PoliRujukan']){
								echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";	
							}else{
								echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
							}	
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Rujuk Internal 2</td>
			<td>
				<select name="poliinternal2" class="form-control inputan poliinternal2" required>
					<option value="-">--Pilih--</option>
					<?php
						$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` where JenisPelayanan = 'KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
						while($data = mysqli_fetch_assoc($query)){
							if($data['Pelayanan'] == $dtreg['PoliRujukan2']){
								echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";	
							}else{
								echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Rujuk Internal 3</td>
			<td>
				<select name="poliinternal3" class="form-control inputan poliinternal3" required>
					<option value="-">--Pilih--</option>
					<?php
						$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` where JenisPelayanan = 'KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
						while($data = mysqli_fetch_assoc($query)){
							if($data['Pelayanan'] == $dtreg['PoliRujukan3']){
								echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";	
							}else{
								echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Rujuk Internal 4</td>
			<td>
				<select name="poliinternal4" class="form-control inputan poliinternal4" required>
					<option value="-">--Pilih--</option>
					<?php
						$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` where JenisPelayanan = 'KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
						while($data = mysqli_fetch_assoc($query)){
							if($data['Pelayanan'] == $dtreg['PoliRujukan4']){
								echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";	
							}else{
								echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Rujuk Internal 5</td>
			<td>
				<select name="poliinternal5" class="form-control inputan poliinternal5" required>
					<option value="-">--Pilih--</option>
					<?php
						$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` where JenisPelayanan = 'KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
						while($data = mysqli_fetch_assoc($query)){
							if($data['Pelayanan'] == $dtreg['PoliRujukan5']){
								echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";	
							}else{
								echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
							}
						}
					?>
				</select>
			</td>
		</tr>
	</table>
</div><br/>
<div class="formpemeriksaanlab"></div>
<script src="assets/js/jquery.js"></script>
<script>
	$(document).ready(function() {	
	cek_pemeriksaan_lab();

	$(".poliinternal, .poliinternal2, .poliinternal3, .poliinternal4, .poliinternal5").change(function(){
		cek_pemeriksaan_lab();
	});

	function cek_pemeriksaan_lab(){
		//alert('tes');
		
		var pelayanan = '<?php echo $_POST['pelayanan'];?>';
		var poliinternal = $(".poliinternal").val();
		var poliinternal2 = $(".poliinternal2").val();
		var poliinternal3 = $(".poliinternal3").val();
		var poliinternal4 = $(".poliinternal4").val();
		var poliinternal5 = $(".poliinternal5").val();
		
		if(poliinternal == 'POLI LABORATORIUM' || poliinternal2 == 'POLI LABORATORIUM' || poliinternal3 == 'POLI LABORATORIUM' || poliinternal4 == 'POLI LABORATORIUM' || poliinternal5 == 'POLI LABORATORIUM'){
			var idpsnrj = '<?php echo $idpsnrj;?>';
			$.post( "get_pemeriksaan_lab.php", { idpsnrj: idpsnrj, pelayanan: pelayanan}) 
			  .done(function( data ) {
				$(".formpemeriksaanlab").html(data);
			});	
		}else{
			$(".formpemeriksaanlab").html('');
		}
	}
});
</script>