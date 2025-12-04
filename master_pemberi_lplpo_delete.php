<?php
$nip = $_GET['nip'];

$str = "DELETE FROM `tb_user_profil_sbbk` WHERE `nip_kasie` = '$nip'";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='?page=master_pemberi_lplpo';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='?page=master_pemberi_lplpo';";
	echo "</script>";
} 
?>