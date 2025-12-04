<?php	

	// setcookie("kodepuskesmas2", "", time() - 3600);
	// setcookie("namapuskesmas2", "", time() - 3600);
	// setcookie("kota2", "", time() - 3600);
	// setcookie("alamat2", "", time() - 3600);
	
	setcookie("kodepuskesmas2", "", time()+(3600 * 24 * 30), "/");
	setcookie("namapuskesmas2", "", time()+(3600 * 24 * 30), "/");
	setcookie("kota2", "", time()+(3600 * 24 * 30), "/");
	setcookie("alamat2", "", time()+(3600 * 24 * 30), "/");

	echo "<script>";
	echo "window.location='loginpage.php';";
	echo "</script>";
		
?>