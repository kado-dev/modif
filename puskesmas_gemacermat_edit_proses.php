<?php
$idkegiatan = $_POST['idkegiatan'];
$tanggalkegiatan = date('Y-m-d', strtotime($_POST['tanggalkegiatan']));
$penyelenggara = $_POST['penyelenggara'];	
$tempat = $_POST['tempat'];	
$peserta = $_POST['peserta'];
$peserta_apoteker = $_POST['peserta_apoteker'];
$peserta_tenagakesehatan = $_POST['peserta_tenagakesehatan'];
$peserta_kader = $_POST['peserta_kader'];
$peserta_masyarakat = $_POST['peserta_masyarakat'];
$hasilkegiatan = $_POST['hasilkegiatan'];	
$rencana = $_POST['rencana'];

//image
$var_file = $_FILES['image1'];
$nama_file = $var_file['name']; // nama file asli
$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
$type = $var_file['type']; // type file
$size = $var_file['size']; // ukuran file
$tmp = $var_file['tmp_name']; // sumber file
$namaimg = date('Ymdgis')."1.".$ext; // proses penamaan file foto

$var_file2 = $_FILES['image2'];
$nama_file2 = $var_file2['name']; // nama file asli
$ext2 = pathinfo($nama_file2, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type2 = $var_file2['type']; // type file
	$size2 = $var_file2['size']; // ukuran file
$tmp2 = $var_file2['tmp_name']; // sumber file
$namaimg2 = date('Ymdgis')."2.".$ext2; // proses penamaan file foto

$var_file3 = $_FILES['image3'];
$nama_file3 = $var_file3['name']; // nama file asli
$ext3 = pathinfo($nama_file3, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type3 = $var_file3['type']; // type file
	$size3 = $var_file3['size']; // ukuran file
$tmp3 = $var_file3['tmp_name']; // sumber file
$namaimg3 = date('Ymdgis')."3.".$ext3; // proses penamaan file foto

$str = "UPDATE `tbgfkgemacermat` SET `TanggalKegiatan`='$tanggalkegiatan',`Penyelenggara`='$penyelenggara',`Tempat`='$tempat',`Peserta`='$peserta',
`JumlahApoteker`='$peserta_apoteker',`JumlahNakesLain`='$peserta_tenagakesehatan',`JumlahKader`='$peserta_kader',`JumlahMasyarakat`='$peserta_masyarakat',
`HasilKegiatan`='$hasilkegiatan',`RencanaTindakLanjut`='$rencana',`FotoKegiatan1`='$namaimg',`FotoKegiatan2`='$namaimg2',`FotoKegiatan3`='$namaimg3' WHERE `IdKegiatan`='$idkegiatan'";
// echo $str;
// die();	

$query1=mysqli_query($koneksi,$str);
	if($query1){	
		if($nama_file != ''){
			copy($tmp,'image/gemacermat/'.$namaimg);
		}
		if($nama_file2 != ''){
			copy($tmp2,'image/gemacermat/'.$namaimg2);
		}
		if($nama_file3 != ''){
			copy($tmp3,'image/gemacermat/'.$namaimg3);
		}
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_gemacermat';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_gemacermat_edit&id=$idkegiatan';";
		echo "</script>";
	} 
?>