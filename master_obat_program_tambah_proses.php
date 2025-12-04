<?php
	$namaprogram = strtoupper($_POST['namaprogram']);
	$str = "INSERT INTO `ref_obatprogram`(`nama_program`) VALUES('$namaprogram')";
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_obat_program'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_obat_program_tambah';";
		echo "</script>";
	} 	
?>