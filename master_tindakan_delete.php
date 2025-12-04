<?php
$id = $_GET['id'];
$otoritas = explode(',',$_SESSION['otoritas']);
if (in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
	$str = "DELETE FROM `tbtindakan` Where `IdTindakan` = '$id'";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi, $str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=master_tindakan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=master_tindakan';";
		echo "</script>";
	} 
}else{
		echo "<script>";
		echo "alert('Maaf anda tidak bisa menghapus data...');";
		echo "document.location.href='?page=master_tindakan';";
		echo "</script>";
}	
?>