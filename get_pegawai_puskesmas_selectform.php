<?php
session_start();
include "config/koneksi.php";
$kdpuskesmas = $_POST['kdpuskesmas'];
	$query = mysqli_query($koneksi,"SELECT * FROM `tb_user_profil_sbbk_penerima` where KodePuskesmas = '$kdpuskesmas'");
	echo "<option value='"."-"."'>"."-"."</option>";
	while($data = mysqli_fetch_assoc($query))
	{		
		echo "<option value='".$data['NamaPegawai']."'>".$data['NamaPegawai']."</option>";	
	}
?>		