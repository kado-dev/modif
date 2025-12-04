<?php
	// variabel tbgfkpenerimaan
	$tahun=date('Y');
	$tgl = date('Y-m-d', strtotime($_POST['tanggalretur']));
	$jam = date('H:i:s');
	$tanggalretur = $tgl." ".$jam;	
	$namapegawaisimpan = $_SESSION['nama_petugas'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$nomorfaktur = $_POST['nomorfaktur'];	
	
	// tbgfkpengeluaran
	$strpengeluaran = "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nomorfaktur'";
	$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
	
	$str = "INSERT INTO `tbgudangpkmretur`(`TanggalRetur`,`NoFaktur`,`StatusPengeluaran`,`KodePenerima`,`Penerima`,`NamaPegawaiSimpan`)
	VALUES ('$tanggalretur','$nomorfaktur','$dtpengeluaran[StatusPengeluaran]','$dtpengeluaran[KodePenerima]','$dtpengeluaran[Penerima]','$namapegawaisimpan')";
	$query=mysqli_query($koneksi,$str);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_retur';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_retur_tambah';";
		echo "</script>";
	} 
?>