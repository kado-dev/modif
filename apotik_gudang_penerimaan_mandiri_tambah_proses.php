<?php
$tahun=date('Y');
$jam = date('G:i:s');	
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapegawaisimpan = $_SESSION['nama_petugas'];
$tanggalpenerimaan = date('Y-m-d', strtotime($_POST['tanggalpenerimaan']))." ".date('G:i:s');	
$sumberanggaran = $_POST['sumberanggaran'];		
$tahunanggaran = $_POST['tahunanggaran'];		
$nosbbk = $_POST['nosbbk'];		
$keterangan = $_POST['keterangan'];		
	
$str = "INSERT INTO `tbgudangpkmpenerimaan`(`TanggalPenerimaan`,`NoFaktur`,`KodePuskesmas`,`TerimaDari`,`StatusValidasi`,`SumberAnggaran`,`TahunAnggaran`,`Keterangan`,`NamaPegawaiSimpan`)
VALUES ('$tanggalpenerimaan','$nosbbk','$kodepuskesmas','GUDANG BESAR','Belum','$sumberanggaran','$tahunanggaran','$keterangan','$namapegawaisimpan')";
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