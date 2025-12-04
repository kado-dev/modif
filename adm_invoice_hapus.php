<?php
if($_SESSION['otoritas'] == 'PROGRAMMER'){
$noinvoice = $_GET['id'];

	$str = "DELETE FROM tbadm_invoice where `NoInvoice` = '$noinvoice'";
	$query=mysqli_query($koneksi,$str);

	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=adm_invoice';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=adm_invoice';";
		echo "</script>";
	} 
}else{
		echo "<script>";
		echo "alert('Maaf anda tidak bisa menghapus data.');";
		echo "document.location.href='?page=adm_invoice';";
		echo "</script>";
}	
?>