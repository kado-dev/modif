<?php
if($_SESSION['otoritas'] == 'PROGRAMMER'){
$faktur = $_GET['faktur'];

	$str = "DELETE FROM tbadm_pendampingan Where `NoFaktur` = '$faktur'";
	$query=mysqli_query($koneksi,$str);

	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=adm_pendampingan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=adm_pendampingan';";
		echo "</script>";
	} 
}else{
		echo "<script>";
		echo "alert('Maaf anda tidak bisa menghapus data.');";
		echo "document.location.href='?page=adm_pendampingan';";
		echo "</script>";
}	
?>