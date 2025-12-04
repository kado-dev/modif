<?php
$hariini = date('Y-m-d');
$tbantrian_pasien = "tbantrian_pasien_".$_COOKIE['kodepuskesmas2'];
$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));
	
if($datasetting['versi_antrian'] == 'versi1'){
	include "pilih_poli_v1.php";
}else if($datasetting['versi_antrian'] == 'versi2'){
    include "pilih_poli_v2.php";
}else{
    include "pilih_poli_v3.php";//klaster
}
?>