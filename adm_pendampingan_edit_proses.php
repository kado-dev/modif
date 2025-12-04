<?php
	$nofaktur = $_POST['nofaktur'];
	$bersedia = $_POST['bersedia'];
	$sdm = $_POST['sdm'];
	$komputer = $_POST['komputer'];
	$printer = $_POST['printer'];
	$internet = $_POST['internet'];
	$keterangan = $_POST['keterangan'];
	
	//image
	$var_file = $_FILES['image1'];
	$nama_file = $var_file['name']; // nama file asli
	if($nama_file != null){
		$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
		$tmp[] = $var_file['tmp_name']; // sumber file
		if($ext != ''){
			$imgf = date('Ymdgis').".".$ext;
			$namaimg[] = $imgf; // proses penamaan file foto	
			copy($var_file['tmp_name'],'image/pendampingan/'.$imgf);
			unlink('image/pendampingan/'.$_POST['imglama1']);
		}
	}else{
		$namaimg[] = $_POST['imglama1'];
	}
	
	$var_file2 = $_FILES['image2'];
	$nama_file2 = $var_file2['name']; // nama file asli
	if($nama_file2 != null){
		$ext2 = pathinfo($nama_file2, PATHINFO_EXTENSION); // proses mengambil extensi file
		$tmp[] = $var_file2['tmp_name']; // sumber file
		if($ext2 != ''){
			$imgf2 = date('Ymdgis')."2.".$ext2;
			$namaimg[] = $imgf2; // proses penamaan file foto	
			copy($var_file2['tmp_name'],'image/pendampingan/'.$imgf2);
			unlink('image/pendampingan/'.$_POST['imglama2']);
		}
	}else{
		$namaimg[] = $_POST['imglama2'];
	}
		
	$tanggal = $_POST['tanggal'];
	// update data
	$namaimgs = json_encode($namaimg);
	$str = "UPDATE `tbadm_pendampingan` SET `Tanggal` = '$tanggal',`Bersedia`='$bersedia',`Sdm`='$sdm',`Komputer`='$komputer',`Printer`='$printer',`Internet`='$internet',`Keterangan`='$keterangan',`Foto`='$namaimgs' WHERE `NoFaktur`='$nofaktur'"; 
	$query=mysqli_query($koneksi,$str);
	
	if($query){			
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=adm_pendampingan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=adm_pendampingan_tambah&faktur=$nofaktur';";
		echo "</script>";
	} 	
?>