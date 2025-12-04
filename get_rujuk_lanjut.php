<?php
	if(substr($_POST['jaminan'],0,4) != 'BPJS'){
?>
<tr>
	<td class="col-sm-3">Tgl.Rencana Berkunjung</td>
	<td class="col-sm-9">
		<input type="text" class="tglfaskes">
		<input type="hidden" class="namapolis" name="namapolis"/>
		<input type="text" class="namars" name="namars" readonly />
	</td>
</tr>	
<tr>
	<td class="col-sm-3">Poli</td>
	<td class="col-sm-9">
		<select name="kategori-kondisi" class="form-control kdpolis">
				<option value="">--Pilih--</option>
				<?php
				include "config/koneksi.php";
				$q = mysqli_query($koneksi,"SELECT * from tbpolispesialis");	
				while($dtq = mysqli_fetch_assoc($q)){
					echo "<option value='".$dtq['IdPoli']."'>".$dtq['Poli']."</option>";
				}	

				$q1 = mysqli_query($koneksi,"SELECT * from tbpolispesialiskhusus");	
				while($dtq1 = mysqli_fetch_assoc($q1)){
					echo "<option value='".$dtq1['IdPoli']."'>".$dtq1['Poli']."</option>";
				}					
				?>
		</select>
	</td>
</tr>
<tr>
	<td class="col-sm-3">Rumah Sakit</td>
	<td class="col-sm-9">
		<select name="faskes" class="form-control faskes">
				<option value="">--Pilih--</option>
				<?php
				$q = mysqli_query($koneksi,"SELECT * from tbrumahsakit");	
				while($dtq = mysqli_fetch_assoc($q)){
					echo "<option value='".$dtq['KodeRumahSakit']."'>".$dtq['RumahSakit']."</option>";
				}				
				?>
		</select>
	</td>
</tr>

<script>
	$(".kdpolis").change(function(){
		$(".namapolis").val($(".kdpolis option:selected").text());
	});
	$(".faskes").change(function(){
		$(".namars").val($(".faskes option:selected").text());
	});
	
	$('.tglfaskes').datepicker({
		format: 'dd-mm-yyyy',
		startDate: '0d',
		endDate: '+6d'
	});
</script>	
<?php
}else{
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	include "config/helper_bpjs_v4.php";	

//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
	$nokunjunganbpjs = $_POST['nokunjunganbpjs'];
	// $data_rujukan_bpjs = get_rujukan_bpjs($nokunjunganbpjs);
	// $dtrujukanbpjs = json_decode($data_rujukan_bpjs,true);
	// echo "NoKunjungan : ".$nokunjunganbpjs;
	// echo $data_rujukan_bpjs;
	// echo $dtrujukanbpjs;
	// $tanggalkunjungan = $dtrujukanbpjs['response']['tglKunjungan'];
	$tanggalkunjungan = date('d-m-Y');
//}

?>
<table class="table-judul" width="100%">
<tr>
	<td class="col-sm-3">Tgl.Rencana Berkunjung</td>
	<td class="col-sm-9">
		<input type="text" name="tglfaskes" class="tglfaskes" value="<?php echo date('d-m-Y',strtotime($tanggalkunjungan))?>">
		<input type="hidden" class="namapolis" name="namapolis"/>
		<input type="hidden" class="namars form-control" name="namars" readonly />
	</td>
</tr><br/>
	
<tr>
	<td class="col-sm-3">Kondisi</td>
	<td class="col-sm-9">
		<label><input type="radio" name="kondisi" value="kondisi khusus" class="kondisi_khusus"/> Kondisi Khusus</label><br/>
		<div class="k-kusus" style="border:2px solid #ddd; padding:10px;display:none">
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
			<br/>
			<select name="kategori-kondisi-sub" class="form-control khusus_subspesialis"> <!--style="display:none"-->
				<option value="-">-Pilih-</option>
			</select>
			<br/>
			<textarea name="catatan-kondisi" class="form-control" placeholder="Catatan"></textarea>
			<br/>
			<button type="button" class="btn btn-info carifaskes1">Cari Faskes</button>
		</div>
		<label><input type="radio" name="kondisi" value="kondisi spesialis" class="kondisi_spesialis"/> Spesialis</label><br/>
		<div class="k-spesialis" style="border:2px solid #ddd; padding:10px;display:none">
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
							echo "<option value='$ket[kdSpesialis]'>".$ket['nmSpesialis']."</option>";
						}
					}					
				?>				
			</select>
			<br/>
			<select name="sub-spesialis" class="form-control sub-spesialis">
				<option value="">Sub Spesialis</option>
				
			</select>
			<br/>
			<label><input type="Checkbox" class="sarana_check"/> Sarana</label>	
			<br/>
			<?php
				//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
					$data_sarana = get_data_referensi_sarana();
					$dtsarana = json_decode($data_sarana,True);
				//}		
			?>
			<select name="sarana" class="form-control sarana" style="display:none">
				<option value="0">Sarana</option>
				<?php
				
						$list = $dtsarana['response']['list'];
						foreach($list as $ket){
							echo "<option value='$ket[kdSarana]'>".$ket['nmSarana']."</option>";
						}
					
				?>	
			</select>
			<br/>
			<button type="button" class="btn btn-info carifaskes2">CARI FASKES</button>
		</div>
	</td>
</tr>
<tr>
	<td colspan="2" class="view-faskes"></td>
</tr>
</table>
<script>
	$('.tglfaskes').datepicker({
		format: 'dd-mm-yyyy',
		startDate: '0d',
		endDate: '+6d'
	});
	$(".kdpolis").change(function(){
		$(".namapolis").val($("option:selected",this).text());
	});

	$(".sarana_check").click(function(){
		var cek = this.checked;
		if(cek == true){
			$(".sarana").show();
		}else{
			$(".sarana").hide();
		}
	});
	$(".kondisi_khusus").click(function(){
		$(".k-kusus").show();
		$(".k-spesialis").hide();
	});
	$(".kondisi_spesialis").click(function(){
		$(".k-kusus").hide();
		$(".k-spesialis").show();
	});
	
	$(".spesialis").change(function(){
		var isi = $(this).val();
		$.get( "get_rujuk_lanjut_subspesialis.php", { key: isi})
			  .done(function( data ) {
				 $( ".sub-spesialis" ).html( data );
			});
	});
	
	$(".carifaskes1").click(function(){
		var tgl = $('.tglfaskes').val();
		var kdkhusus = $('.kondisi-khusus').val();
		var subspesialis = $('.khusus_subspesialis').val();
		var nokartubpjs = $("input[name='nokartubpjs']").val();
		if(tgl == ''){
			alert('Tolong isikan tanggal');
		}else if(kdkhusus == ''){
			alert('Tolong isikan kategori khusus');
		}else{
			$.post( "get_rujuk_lanjut_faskes_khusus.php", { kdkhusus: kdkhusus, subspesialis:subspesialis, tgl:tgl, nokartubpjs:nokartubpjs})
			.done(function( data ) {
				 $( ".view-faskes" ).html( data );
			});
		}	
	}); 
	
	$(".carifaskes2").click(function(){
		var subspesialis = $('.sub-spesialis').val();
		var sarana = $('.sarana').val();
		var tgl = $('.tglfaskes').val();
		if(tgl == ''){
			alert('Tolong isikan tanggal');
		}else if(subspesialis == ''){
			alert('Tolong isikan Subspesialis');
		// }else if(sarana == ''){
			// alert('Tolong isikan sarana');
		}else{
			$.post( "get_rujuk_lanjut_faskes_spesialis.php", { kdsubspesialis: subspesialis,kdsarana: sarana,tgl:tgl})
			.done(function( data ) {
				 $( ".view-faskes" ).html( data );
			});
		}	
	});
	
	
	$(".kondisi-khusus").change(function(){
		var isi = $(this).val();
		if(isi == 'THA' || isi == 'HEM'){
			$(".khusus_subspesialis").html('<option value="8">HEMATOLOGI - ONKOLOGI MEDIK</option><option value="30">ANAK HEMATOLOGI ONKOLOGI</option>');
		}else{
			$(".khusus_subspesialis").html("<option value=''>Tidak ada data</option>");
		}
	});

</script>


	<?php
	if($_POST['sts'] == 'true'){
	?>

	<tr>
		<td class="col-sm-3">Faktor Rujuk(TACC)</td>
		<td class="col-sm-9">
			<select name="kodetacc" class="form-control kodetacc" required>
				<option value="-1">Tanpa TACC</option>
				<option value="1">Time (WAKTU)</option>
				<option value="2">Age (UMUR)</option>
				<option value="3">Complication (KOMPLIKASI)</option>
				<option value="4">Comorbidity (PEMBERAT)</option>
			</select>
		</td>
	</tr>	
	<tr>
		<td class="col-sm-3">Alasan</td>
		<td class="col-sm-9 alasantacc">
			<select name='alasantacc' class='form-control alasantacc'>
				<option value="null">--Pilih--</option>
			</select>
		</td>
	</tr>	
	
	<script>
		
		$(".kodetacc").change(function(){
			var isi = $(this).val();
			if(isi == 1){
				var alasan = "<select name='alasan' class='form-control'><option value='< 3 Hari'>< 3 Hari</option><option value='>= 3 - 7 Hari'>>= 3 - 7 Hari</option><option value='>= 7 Hari'>>= 7 Hari</option></select>";
				$(".alasantacc").html(alasan);
			}else if(isi == 2){
				var alasan = "<select name='alasan' class='form-control'><option>< 1 Bulan</option><option>>= 1 Bulan s/d < 12 Bulan</option><option>>= 1 Tahun s/d < 5 Tahun</option><option>>= 5 Tahun s/d < 12 Tahun</option><option>>= 12 Tahun s/d < 55 Tahun</option><option>>= 55 Tahun</option></select>";
				$(".alasantacc").html(alasan);
			}else if(isi == 3){
				$(".alasantacc").html("<input type='text' name='alasan' class='form-control diagnosabpjstacc'>");
				//diagnosa bpjs alasan tacc
					$('.diagnosabpjstacc').autocomplete({
						serviceUrl: 'get_diagnosa_bpjs.php',
						onSelect: function (suggestion) {
							$(this).val(suggestion.kode + " - " + suggestion.diagnosa);
						}
					});
			}else if(isi == 4){
				$(".alasantacc").html("<select name='alasan' class='form-control'><option>< 3 Hari</option><option>>= 3 - 7 Hari</option><option>>= 7 Hari</option></select>");
				
			}
			
		});
	</script>
	<?php
	}else{
	?>	
	<input type="hidden" name="kodetacc" value="-1">
	<input type="hidden" name="alasantacc" value="null">
	<?php
	}

}
?>




