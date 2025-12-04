<?php

session_start();
include "config/koneksi.php";
$getdata = $_POST['getdata'];
$id = $_POST['id'];

if($getdata == 'kabupaten'){
	echo "<option value=''>--Pilih--</option>";
	$query = mysqli_query($koneksi, "select * FROM `ec_cities` WHERE prov_id = '$id' ORDER BY city_name ASC");
	if(mysqli_num_rows($query) > 0){
		while($data = mysqli_fetch_assoc($query))
		{
			echo "<option value='$data[city_id]'>$data[city_name]</option>";
		}
	}else{
		echo "<option value=''>Tidak ada data</option>";
	}	
}else if($getdata == 'kecamatan'){
	echo "<option value=''>--Pilih--</option>";
	$query = mysqli_query($koneksi, "select * FROM `ec_districts` WHERE city_id = '$id' ORDER BY dis_name ASC");
	if(mysqli_num_rows($query) > 0){
		while($data = mysqli_fetch_assoc($query))
		{
			echo "<option value='$data[dis_id]'>$data[dis_name]</option>";
		}
	}else{
		echo "<option value=''>Tidak ada data</option>";
	}
}else if($getdata == 'kelurahan'){
	echo "<option value=''>--Pilih--</option>";
	$query = mysqli_query($koneksi, "select * FROM `ec_subdistricts` WHERE dis_id = '$id' ORDER BY subdis_name ASC");
	if(mysqli_num_rows($query) > 0){
		while($data = mysqli_fetch_assoc($query))
		{
			echo "<option value='$data[subdis_id]'>$data[subdis_name]</option>";
		}
	}else{
		echo "<option value=''>Tidak ada data</option>";
	}
}else if($getdata == 'kodepos'){
	$query = mysqli_query($koneksi, "select * FROM `ec_postalcodes` WHERE subdis_id = '$id'");
	if(mysqli_num_rows($query) > 0){
		$data = mysqli_fetch_assoc($query);
			echo $data['postal_code'];
	}else{
		echo "Tidak ada data";
	}
}else{
	echo "<option value=''>Tidak ada data</option>";
}
	
?>		