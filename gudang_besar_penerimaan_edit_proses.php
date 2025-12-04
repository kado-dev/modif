<?php			
$namapegawaiedit = $_SESSION['nama_petugas'];
$idpenerimaan = $_POST['idpenerimaan'];			
$tanggalpenerimaan = date('Y-m-d', strtotime($_POST['tanggalpenerimaan']));
$tanggalkontrak = date('Y-m-d', strtotime($_POST['tanggalkontrak']));	
$nomorkontrak = $_POST['nomorkontrak'];	
$namapengadaan = $_POST['namapengadaan'];
$sumberanggaran = $_POST['sumberanggaran'];						
$tahunanggaran = $_POST['tahunanggaran'];							
$statusanggaran = $_POST['statusanggaran'];	
$kodesupplier = $_POST['kodesupplier'];
$tahunpenerimaanawal = date('Y', strtotime($_POST['tanggalpenerimaanawal']));
$tahunpenerimaan = date('Y', strtotime($_POST['tanggalpenerimaan']));

if($tahunpenerimaanawal !=  $tahunpenerimaan){
	echo "<script>";
	echo "alert('Tahun Penerimaan tidak boleh diedit...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan_edit&id=$idpenerimaan';";
	echo "</script>";
}else{
	// update tbgfkpenerimaan
	$str = "UPDATE `tbgfkpenerimaan` SET `TanggalPenerimaan`='$tanggalpenerimaan',`KodeSupplier`='$kodesupplier',
	`SumberAnggaran`='$sumberanggaran',`TahunAnggaran`='$tahunanggaran',`StatusAnggaran`='$statusanggaran',`NomorKontrak`='$nomorkontrak',
	`TanggalKontrak`='$tanggalkontrak',`NamaPengadaan`='$namapengadaan',`NamaPegawaiEdit`='$namapegawaiedit'
	WHERE `IdPenerimaan`='$idpenerimaan'";
	$query = mysqli_query($koneksi,$str);
}

if($query){	
	echo "<script>";
	echo "alert('Data berhasil diedit...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal diedit...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan_tambah';";
	echo "</script>";
} 
?>