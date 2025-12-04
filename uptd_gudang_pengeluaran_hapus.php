<?php
$id = $_GET['id'];

	//cek klo sudah divalidasi sama gudangpkm maka gak bisa terhapus
	$cek_validasi = mysqli_fetch_assoc(mysqli_query($koneksi,"select StatusValidasi from tbgudangpkmpenerimaan where Nofaktur = '$id'"));
	if ($cek_validasi['StatusValidasi'] == 'Sudah'){
		echo "<script>";
		echo "alert('Data tidak dapat dihapus karena sudah divalidasi');";
		echo "document.location.href='?page=uptd_gudang_pengeluaran';";
		echo "</script>";
	}else{
		$str1 = "DELETE FROM `tbgudanguptdpengeluaran` Where `NoFaktur` = '$id'";
		$str2 = "DELETE FROM `tbgudanguptdpengeluarandetail` Where `NoFaktur` = '$id'";
		$query1=mysqli_query($koneksi,$str1);
		$query2=mysqli_query($koneksi,$str2);
		
		//delete tbgudangpkmpenerimaan dan tbgudangpkmpenerimaandetail
		$str_penerimaan = "DELETE FROM `tbgudangpkmpenerimaan` Where `NoFaktur` = '$id'";
		$str_penerimaandtl = "DELETE FROM `tbgudangpkmpenerimaandetail` Where `NoFaktur` = '$id'";
		$query1=mysqli_query($koneksi,$str_penerimaan);
		$query2=mysqli_query($koneksi,$str_penerimaandtl);
	}
	
	
	if($query1){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=uptd_gudang_pengeluaran';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=uptd_gudang_pengeluaran';";
		echo "</script>";
	} 	
?>