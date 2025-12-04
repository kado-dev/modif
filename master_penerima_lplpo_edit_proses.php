<?php
	$id = $_POST['id'];
	$statuspenerima = $_POST['status'];
	$kodepenerima = $_POST['penerima'];
	$namapenerima = $_POST['namapenerima'];
	$puskesmas = $_POST['puskesmas'];
	$namapegawai = $_POST['namapegawai'];
	$jabatan = $_POST['jabatan'];
	$nip = $_POST['nip'];

	if($statuspenerima == 'LAINNYA'){
		$namapenerima = $kodepenerima;
	}
	
	
	//--tbpuskesmas--//
	$str = "UPDATE `tb_user_profil_sbbk_penerima` SET `StatusPenerima`='$statuspenerima',`KodePuskesmas`='$kodepenerima',`NamaPuskesmas`='$namapenerima',`NamaPegawai`='$namapegawai',`Jabatan`='$jabatan',`Nip`='$nip' WHERE `IdPenerima`='$id'";

	$query=mysqli_query($koneksi,$str);
	
	// echo var_dump($str);
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_penerima_lplpo';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_penerima_lplpo';";
		echo "</script>";
	} 	
?>