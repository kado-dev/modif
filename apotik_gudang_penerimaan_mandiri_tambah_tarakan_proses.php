<?php
$tahun=date('Y');
$jam = date('G:i:s');	
$namapuskesmas = $_SESSION['namapuskesmas'];
$namapegawaisimpan = $_SESSION['nama_petugas'];
$tanggalpenerimaan = date('Y-m-d', strtotime($_POST['tanggalpenerimaan']))." ".date('G:i:s');	
$nosbbk = strtoupper($_POST['nosbbk']);		
$keterangan = strtoupper($_POST['keterangan']);		
$tbgudangpkmpenerimaan = "tbgudangpkmpenerimaan_".str_replace(' ', '', $namapuskesmas);
	
$str = "INSERT INTO `$tbgudangpkmpenerimaan`(`TanggalPenerimaan`,`NoFaktur`,`StatusValidasi`,`Keterangan`,`NamaPegawaiSimpan`)
VALUES ('$tanggalpenerimaan','$nosbbk','Belum','$keterangan','$namapegawaisimpan')";
// echo $str;
// die();
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_lihat_tarakan&id=$nosbbk';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_penerimaan_mandiri_tambah_tarakan';";
	echo "</script>";
} 
?>