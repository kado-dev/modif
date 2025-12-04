<?php		
$nofaktur = $_GET['id'];

//delete tbgudangpkmpengadaan
$str = "DELETE FROM `tbgudangpkmpengadaan` WHERE NoFaktur = '$nofaktur'";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan';";
	echo "</script>";
} 
?>