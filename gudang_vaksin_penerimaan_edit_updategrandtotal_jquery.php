<?php
	include "config/koneksi.php";
	$id = $_POST['id'];

	$grandtotal = $_POST['grand'];	
	$t = mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_penerimaan` SET `GrandTotal`='$grandtotal' WHERE `NomorPembukuan`='$id'");	
	if($t){
		echo "true";
	}
?>