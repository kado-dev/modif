<?php
include "config/koneksi.php";
$sts = $_GET['sts'];
if($sts == 'true'){
	$jp = 'KUNJUNGAN SAKIT';
}else{
	$jp = 'KUNJUNGAN SEHAT';
}
		$query = mysqli_query($koneksi,"select * from `tbpelayanankesehatan` where JenisPelayanan = '$jp'");
		while($data = mysqli_fetch_assoc($query))
		{
			echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
		}
?>		