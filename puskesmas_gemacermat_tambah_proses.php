<?php
$tanggalkegiatan = date('Y-m-d', strtotime($_POST['tanggalkegiatan']));
$penyelenggara = $_POST['penyelenggara'];	
$sumberdana = $_POST['sumberdana'];	
$tempat = $_POST['tempat'];	
$peserta = $_POST['peserta'];
$peserta_apoteker = $_POST['peserta_apoteker'];
$peserta_tenagakesehatan = $_POST['peserta_tenagakesehatan'];
$peserta_kader = $_POST['peserta_kader'];
$peserta_masyarakat = $_POST['peserta_masyarakat'];
$hasilkegiatan = $_POST['hasilkegiatan'];	
$rencana = $_POST['rencana'];	
$namaaoc = $_POST['namaaoc'];
$tahun = date('Y', strtotime($_POST['tanggalkegiatan']));

$sql_cek='SELECT max(NoFakturKegiatan)as maxno FROM `tbgfkgemacermat` WHERE SUBSTRING(NoFaktur,8,4)=YEAR(now())';
$query_cek=mysqli_query($koneksi,$sql_cek);
$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],-5);
	$no_next=$no+1;
		if(strlen($no_next)==1)
		{
			$no="0000".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$no="000".$no_next;
		}
		elseif(strlen($no_next)==3)
		{
			$no="00".$no_next;
		}
		elseif(strlen($no_next)==4)
		{
			$no="0".$no_next;
		}
		else
		{
			$no=$no_next;
		}
$nofaktur="GEMACR/".$tahun."/".$no;

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

$str = "INSERT INTO `tbgfkgemacermat`(`NoFakturKegiatan`,`TanggalKegiatan`,`Penyelenggara`,`SumberDana`,`Tempat`,`Peserta`,`JumlahApoteker`,`JumlahNakesLain`,`JumlahKader`,`JumlahMasyarakat`,`HasilKegiatan`,`RencanaTindakLanjut`,`NamaAocPoc`,`FotoKegiatan1`,`FotoKegiatan2`,`FotoKegiatan3`) 
VALUES ('$nofaktur','$tanggalkegiatan','$penyelenggara','$sumberdana','$tempat','$peserta','$peserta_apoteker','$peserta_tenagakesehatan','$peserta_kader','$peserta_masyarakat','$hasilkegiatan','$rencana','$namaaoc','$namaimg','$namaimg2','$namaimg3')";
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
		echo "document.location.href='index.php?page=gudang_besar_gemacermat_tambah';";
		echo "</script>";
	} 
?>