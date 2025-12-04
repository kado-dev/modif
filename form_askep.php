<div style="margin-top: 10px;">
	<div class="form-horizontal">
		<div class="form-group">
			<?php 
				$kodeaskep = $_POST['kode'];
				if($kodeaskep == 'D0001'){
			?>
			<div class="col-sm-12">
				<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Latihan Batuk Efektif"> Latihan Batuk Efektif</label><br>	
				<div style="margin-left: 20px;">
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Monitor adanya retensi sputum"> Monitor adanya retensi sputum</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Ajarkan pasien batuk efektif"> Ajarkan pasien batuk efektif</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Edukasi tujuan dan prosedur batuk efektif"> Edukasi tujuan dan prosedur batuk efektif</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Lainnya"> Lainnya </label>
					<input type="text" name="lainnya1"><br>
				</div>
			</div>
			<div class="col-sm-12">
				<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Manajemen Jalan Nafas"> Manajemen Jalan Nafas</label><br>	
				<div style="margin-left: 20px;">
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Monitor pola nafas (frekuensi, kedalaman, usaha nafas)"> Monitor pola nafas (frekuensi, kedalaman, usaha nafas)</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Monitor bunyi nafas tambahan (misalnya : gurgling, mengi, whezing, rinkhi kering)"> Monitor bunyi nafas tambahan (misalnya : gurgling, mengi, whezing, rinkhi kering)</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Anjuran minum air hangat"> Anjuran minum air hangat</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Kolaborasi pemberian bronkodilator, ekspektoran, mukolitik (jika perlu)"> Kolaborasi pemberian bronkodilator, ekspektoran, mukolitik (jika perlu)</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0001'][]" value="Lainnya"> Lainnya</label>
					<input type="text" name="lainnya2"><br>
				</div>
			</div>
			<?php } ?>
			
			<?php if($kodeaskep == 'D0002'){ ?>
			<div class="col-sm-12">
				<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Latihan Batuk Efektif"> Perawatan Integritas Kulit</label><br>	
				<div style="margin-left: 20px;">
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Identifikasi  penyebab gangguan integritas kulit"> Identifikasi  penyebab gangguan integritas kulit</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Anjurkan pasien  gunakan produk berbahan ringan/alami dan hipoalergik pada kulit sensitif"> Anjurkan pasien  gunakan produk berbahan ringan/alami dan hipoalergik pada kulit sensitif</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Anjurkan pasien hindari produk berbahan dasar alkohol pada kulit kering"> Anjurkan pasien hindari produk berbahan dasar alkohol pada kulit kering</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Anjurkan minum air yang cukup"> Anjurkan minum air yang cukup</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Anjurkan meningkatkan asupan nutrisi buah dan sayur"> Anjurkan meningkatkan asupan nutrisi buah dan sayur</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Lainnya"> Lainnya </label>
					<input type="text" name="lainnya1"><br>
				</div>
			</div>
			<div class="col-sm-12">
				<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Manajemen Jalan Nafas"> Perawatan Luka</label><br>	
				<div style="margin-left: 20px;">
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Monitor karakteristik Luka"> Monitor karakteristik Luka</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Monitor tanda-tanda infeksi"> Monitor tanda-tanda infeksi</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Melakukan Perawatan Luka"> Melakukan Perawatan Luka</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Edukasi Tanda dan gejala infeksi"> Edukasi Tanda dan gejala infeksi</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Anjurkan mengkonsumsi makanan tinggi kalori dan protein"> Anjurkan mengkonsumsi makanan tinggi kalori dan protein</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Ajarkan prosedur perawatan luka mandiri"> Ajarkan prosedur perawatan luka mandiri</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Kolaborasi prosedur debridement"> Kolaborasi prosedur debridement</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Kolaborasi pemberian antibiotik"> Kolaborasi pemberian antibiotik</label><br>
					<label><input type="checkbox" name="tindakan_askep['D0002'][]" value="Lainnya"> Lainnya</label>
					<input type="text" name="lainnya2"><br>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
