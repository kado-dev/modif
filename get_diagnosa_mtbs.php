<?php
session_start();
include "config/koneksi.php";
$nama = $_POST['nama'];

// pernafasan
if($nama == 'Pneumonia'){
	$kd = 'J18.9';
	$class = 'pernafasan';
}else if($nama == 'Batuk Bukan Pneumonia'){
	$kd = 'J06.0';
	$class = 'pernafasan';
// diare	
}else if($nama == 'Disentri'){
	$kd = 'A03.0';
	$class = 'diare';
}else if($nama == 'Dehidrasi Sedang atau Ringan'){
	$kd = 'A09.0';
	$class = 'diare';
}else if($nama == 'Diare Tanpa Dehidrasi'){
	$kd = 'A09.0';
	$class = 'diare';
// demam
}else if($nama == 'Demam Mungkin Bukan Malaria'){
	$kd = 'J00';
	$class = 'demam';
}else if($nama == 'Demam Bukan Malaria'){
	$kd = 'R50.0';
	$class = 'demam';
// campak
}else if($nama == 'Penyakit Campak Dengan Komplikasi Berat'){
	$kd = 'B08.0';
	$class = 'campak';
}else if($nama == 'Penyakit Campak Komplikasi Pada Mata/Mulut'){
	$kd = 'B09';
	$class = 'campak';
}else if($nama == 'Penyakit Campak'){
	$kd = 'B05.9';
	$class = 'campak';
// dbd
}else if($nama == 'Penyakit Demam Berdarah Dengue (DBD)'){
	$kd = 'A91.9';
	$class = 'dbd';
}else if($nama == 'Penyakit Demam Mungkin DBD'){
	$kd = 'A90.9';
	$class = 'dbd';
}else if($nama == 'Penyakit Demam Mungkin Bukan DBD'){
	$kd = 'A93.9';
	$class = 'dbd';
// telinga
}else if($nama == 'Mastoiditis'){
	$kd = 'A91.9';
	$class = 'telinga';
}else if($nama == 'Infeksi Telinga Akut'){
	$kd = 'A90.9';
	$class = 'telinga';
}else if($nama == 'Infeksi Telinga Kronis'){
	$kd = 'A93.9';
	$class = 'telinga';
}else if($nama == 'Tidak Ada Infeksi Telinga'){
	$kd = 'A93.9';
	$class = 'telinga';
}
$str = "SELECT * FROM `tbdiagnosabpjs` where KodeDiagnosa = '$kd'";
//echo $str;
$qry = mysqli_query($koneksi,$str);
$data = mysqli_fetch_assoc($qry);


if(mysqli_num_rows($qry) > 0){
?>
<tr class="newbaris <?php echo $class;?>">
	<input type="hidden" class="kode-diagnosa-input" name="kodediagnosabpjs[]" value="<?php echo $data['KodeDiagnosa'];?>">
	<input type="hidden" class="nama-diagnosa-input" name="namadiagnosabpjs[]" value="<?php echo $data['Diagnosa'];?>">
	<input type="hidden" class="kasus-diagnosa-input" name="kasusdiagnosabpjs[]" value="Baru">
	<input type="hidden" class="kelompok-diagnosa-input" name="kelompokdiagnosa[]" value="">
	<td class="kode-html"><?php echo $data['KodeDiagnosa'];?></td>
	<td class="diagnosa-html"><?php echo $data['Diagnosa'];?></td>
	<td class="kasus-html">Baru</td>
	<td class="kelompok-html"></td>
	<td>
		<a class="btn btn-xs btn-danger hapus-diagnosa-mtbs">Hapus</a>
	</td>
</tr>
<?php
}
?>