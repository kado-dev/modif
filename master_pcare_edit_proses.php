<?php
	$kodepuskesmas = $_POST['kodepuskesmas'];
	$password = $_POST['password'];
	
	//--tbpuskesmas--//
	$str = "UPDATE `tbpuskesmasdetail` SET `Password`='$password' WHERE `KodePuskesmas`='$kodepuskesmas'";
	$query=mysqli_query($koneksi,$str);
	
	// echo var_dump($str);
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate');";
		echo "document.location.href='index.php?page=master_pcare';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate');";
		echo "document.location.href='index.php?page=master_pcare';";
		echo "</script>";
	} 	
?>