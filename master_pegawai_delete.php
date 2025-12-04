<?php
$otoritas = explode(',',$_SESSION['otoritas']);
if (in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas)){

	$nip = $_GET['nip'];	
	$str = "DELETE FROM `tbpegawai` Where `Nip` = '$nip'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=master_pegawai';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=master_pegawai';";
		echo "</script>";
	} 
}else{
		echo "<script>";
		echo "alert('Maaf anda tidak bisa menghapus data.');";
		echo "document.location.href='?page=master_pegawai';";
		echo "</script>";
}	
?>