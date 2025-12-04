<?php			
$namapegawaiedit = $_SESSION['nama_petugas'];
$idpenerimaan = $_POST['idpenerimaan'];			
$tanggalpenerimaan = $_POST['tanggalpenerimaan'];	
$tglp = explode("-",$tanggalpenerimaan);
$tanggalpenerimaan1=$tglp[2]."-".$tglp[1]."-".$tglp[0];
$tanggalkontrak = $_POST['tanggalkontrak'];	
$tglk = explode("-",$tanggalkontrak);
$tanggalkontrak1=$tglk[2]."-".$tglk[1]."-".$tglk[0];
$nomorkontrak = $_POST['nomorkontrak'];	
$namapengadaan = $_POST['namapengadaan'];
$sumberanggaran = $_POST['sumberanggaran'];						
$tahunanggaran = $_POST['tahunanggaran'];	
$kodesupplier = $_POST['kodesupplier'];	

// update tbgfkpenerimaan
$str = "UPDATE `tbgfk_vaksin_penerimaan` SET `TanggalPenerimaan`='$tanggalpenerimaan1',`KodeSupplier`='$kodesupplier',
`SumberAnggaran`='$sumberanggaran',`TahunAnggaran`='$tahunanggaran',`NomorKontrak`='$nomorkontrak',
`TanggalKontrak`='$tanggalkontrak1',`NamaPengadaan`='$namapengadaan',`NamaPegawaiEdit`='$namapegawaiedit'
WHERE `IdPenerimaan`='$idpenerimaan'";
$query = mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil diedit...');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal diedit...');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan_tambah';";
	echo "</script>";
} 
?>