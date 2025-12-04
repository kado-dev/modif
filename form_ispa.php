<?php
	session_start();
	$kota = $_SESSION['kota'];
?>

<div id="formispahidden">
	<input type="hidden" class="ket_formispahidden" name="ket_form_diagnosa" value="ispa">
	<div class="row">
		<div class="col-xl-12">
			<div class="card-body">
				<h4 class="judul">FORM ISPA</h4>
				<div class="form-horizontal">
					<?php
					if($noregistrasi == ''){
						$noregistrasi = $_POST['noreg'];
						include "config/koneksi.php";	
					}
					$strispa ="SELECT * FROM `tbdiagnosaispa` where NoRegistrasi = '$noregistrasi'";
					//echo $strispa;
					$dataispa = mysqli_fetch_assoc(mysqli_query($koneksi,$strispa));
					?>
					<div class="form-group">
						<label>Klasifikasi</label>
						<select name="klasifikasi_ispa" class="form-control">
							<option value="Bukan Pneumonia" <?php if($dataispa['Klasifikasi']=='Bukan Pneumonia'){echo "SELECTED";}?>>Bukan Pneumonia</option>
							<option value="Pneumonia" <?php if($dataispa['Klasifikasi']=='Pneumonia'){echo "SELECTED";}?>>Pneumonia</option>
							<option value="Pneumonia Berat" <?php if($dataispa['Klasifikasi']=='Pneumonia Berat'){echo "SELECTED";}?>>Pneumonia Berat</option>
						</select>
					</div>					
					<div class="form-group">
						<label>Tindak Lanjut</label>
						<select name="tindaklanjut_ispa" class="form-control">
							<option value="Rawat Jalan" <?php if($dataispa['TindakLanjut']=='Rawat Jalan'){echo "SELECTED";}?>>Rawat Jalan</option>
							<option value="Rujuk" <?php if($dataispa['TindakLanjut']=='Rujuk'){echo "SELECTED";}?>>Rujuk</option>
						</select>
					</div>
					<div class="form-group">
						<label>Antibiotik</label>
						<select name="antibiotik_ispa" class="form-control">
							<option value="Tidak" <?php if($dataispa['AntiBiotik']=='Tidak'){echo "SELECTED";}?>>Tidak</option>
							<option value="Ya" <?php if($dataispa['AntiBiotik']=='Ya'){echo "SELECTED";}?>>Ya</option>
						</select>
					</div>
					<div class="form-group">
						<label>Kondisi Saat Kunjungan Ulang</label>
						<select name="kondisi_kunjungang_ulang_ispa" class="form-control">
							<option value="Membaik" <?php if($dataispa['KondisiKujunganUlang']=='Membaik'){echo "SELECTED";}?>>Membaik</option>
							<option value="Tetap" <?php if($dataispa['KondisiKujunganUlang']=='Tetap'){echo "SELECTED";}?>>Tetap</option>
							<option value="Memburuk" <?php if($dataispa['KondisiKujunganUlang']=='Memburuk'){echo "SELECTED";}?>>Memburuk</option>
						</select>
					</div>
					<div class="form-group">
						<label>Keterangan Meninggal</label>
						<textarea name="keteranganmeninggal_ispa" class="form-control"><?php echo $dataispa['KeteranganMeninggal'];?></textarea>
					</div>
					<div class="form-group">
						<label>Ispa > 5 thn</label>
						<select name="Ispalebih5thn_ispa" class="form-control">
							<option value="Bukan Pneumonia" <?php if($dataispa['Ispa5tahun']=='Bukan Pneumonia'){echo "SELECTED";}?>>Bukan Pneumonia</option>
							<option value="Pneumonia" <?php if($dataispa['Ispa5tahun']=='Pneumonia'){echo "SELECTED";}?>>Pneumonia</option>
						</select>
					</div>
				</div>	
			</div>
		</div>
	</div>	
</div>