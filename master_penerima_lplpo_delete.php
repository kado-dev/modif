<?php
$id = $_GET['id'];

$str = "DELETE FROM `tb_user_profil_sbbk_penerima` WHERE `IdPenerima` = '$id'";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='?page=master_penerima_lplpo';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='?page=master_penerima_lplpo';";
	echo "</script>";
} 
?>