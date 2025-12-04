<?php
	$namapegawai = $_SESSION['username'];
	$idkonsul = $_POST['idkonsul'];
	$waktupertanyaan = date('Y-m-d G:i:s');
	$waktujawaban = date('Y-m-d G:i:s');
	$modulaplikasi = $_POST['modulaplikasi'];
	$pertanyaan = $_POST['pertanyaan'];
	$jawaban = $_POST['jawaban'];
	
	// image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	if($nama_file != null){
		$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
		$tmp[] = $var_file['tmp_name']; // sumber file
		if($ext != ''){
			$imgf = date('Ymdgis').".".$ext;
			$namaimg[] = $imgf; // proses penamaan file foto	
			copy($var_file['tmp_name'],'image/pendampingan/'.$imgf);
			unlink('image/pendampingan/'.$_POST['imglama']);
		}
	}else{
		$namaimg[] = $_POST['imglama'];
	}
	
	// update data
	$namaimgs = json_encode($namaimg);
	$str = "UPDATE `tbadm_konsultasi` SET `WaktuJawaban`='$waktujawaban',`Modul`='$modulaplikasi',`Pertanyaan`='$pertanyaan',`Jawaban`='$jawaban',`Gambar`='$namaimgs',`NamaPegawai`='$namapegawai' WHERE `IdKonsultasi`='$idkonsul'"; 
	$query = mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate');";
		echo "document.location.href='index.php?page=adm_konsultasi';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate');";
		echo "document.location.href='index.php?page=adm_konsultasi';";
		echo "</script>";
	} 	
?>