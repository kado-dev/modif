<?php
    session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
    $idbarang = $_POST['id'];
	$namabarang = $_POST['namabarang'];
	$satuan = $_POST['satuan'];
	$namaprogram = $_POST['namaprogram'];
	$jenisbarang = $_POST['jenisbarang'];	
	$kodekfa = $_POST['kodekfa'];	
	$namekfa = $_POST['namekfa'];	
	$dosiscodekfa = $_POST['dosiscodekfa'];	
	$dosisnamekfa = $_POST['dosisnamekfa'];	
			
	
	// insert
	$str = "UPDATE `ref_obat_lplpo` SET `IdKfa`='$kodekfa',`namekfa`='$namekfa',`dosiscodekfa`='$dosiscodekfa',`dosisnamekfa`='$dosisnamekfa',`NamaBarang`='$namabarang',`Satuan`='$satuan',`NamaProgram`='$namaprogram',`JenisBarang`='$jenisbarang' WHERE `IdBarang`='$idbarang'";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_obat'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_obat_edit&id=".$idbarang."';";
		echo "</script>";
	} 	
?>