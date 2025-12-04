<select name="penerima" class="form-control penerimacls">
<option value=''>--Pilih--</option>
<?php
include "config/koneksi.php";
session_start();
$kota = $_SESSION['kota'];
$query = mysqli_query($koneksi,"SELECT * FROM `ref_rumahsakit` ORDER BY `NamaRs` ASC");
while($data = mysqli_fetch_assoc($query)){
	echo "<option value='$data[IdRs]'>$data[NamaRs]</option>";
}
?>
</select>