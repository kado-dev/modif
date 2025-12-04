<?php							
$nofaktur = $_POST['nofaktur'];
$tanggalpengeluaran = date("Y-m-d", Strtotime($_POST['tanggalpengeluaran']));
$statuspengeluaran = $_POST['statuspengeluaran'];		
$penerima = $_POST['penerima'];


if($statuspengeluaran == 'PUSKESMAS'){
	// tbpuskesmas
	$qry = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$penerima'");
	$dt = mysqli_fetch_assoc($qry);
	if(mysqli_num_rows($qry) > 0){
		$nmpenerima = $dt['NamaPuskesmas'];
		$kdpenerima = $penerima;				
	}else{
		$nmpenerima = $kodepenerima;
		$kdpenerima = $penerima;		
	}	
}else if($statuspengeluaran == 'RUMAH SAKIT'){
	// rumah sakit
	$qry_rs = mysqli_query($koneksi,"SELECT * FROM `ref_rumahsakit` WHERE `IdRs`='$penerima'");
	$dt_rs = mysqli_fetch_assoc($qry_rs);
	if(mysqli_num_rows($qry_rs) > 0){
		$nmpenerima = $dt_rs['NamaRs'];		
		$kdpenerima = $penerima;					
	}else{
		$nmpenerima = $kodepenerima;
		$kdpenerima = $penerima;	
	}
}else{
	$nmpenerima = $penerima;
	$kdpenerima = "";
}
	
$petugas = $_POST['petugas'];		
$keterangan = $_POST['keterangan'];	

// edit digudang obat
$str = "UPDATE `tbgfkpengeluaran` SET `TanggalPengeluaran`='$tanggalpengeluaran',`StatusPengeluaran`= '$statuspengeluaran',`KodePenerima`='$kdpenerima',`Penerima`='$nmpenerima',`PetugasPenerima`='$petugas',
`Keterangan`='$keterangan' WHERE `NoFaktur`='$nofaktur'";
$query = mysqli_query($koneksi,$str);

if($query){
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_pengeluaran';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_pengeluaran';";
	echo "</script>";
} 
?>