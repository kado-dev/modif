<select name="penerima" class="form-control penerimacls">
<option value=''>--Pilih--</option>
<?php
include "config/koneksi.php";
session_start();
$kota = $_SESSION['kota'];
$query = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` ORDER BY `NamaPuskesmas` ASC");
while($data = mysqli_fetch_assoc($query)){
	echo "<option value='$data[KodePuskesmas]'>$data[NamaPuskesmas]</option>";
}
?>
</select>