<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$key = $_POST['kode'];
	$data_prolanis = get_club_prolanis($key);
	$dtspesialis = json_decode($data_prolanis,True);
	
	$list = $dtspesialis['response']['list'];
	foreach($list as $ket){
		echo "<option value='$ket[clubId]'>".$ket['nama']." (".$ket['jnsKelompok']['nmProgram'].")"."</option>";
	}
?>	