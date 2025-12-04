<?php
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
	
	
	$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk_penerima` WHERE `Nip` = '$nip'"));
	if($cek > 0){
		echo "<script>";
		echo "alert('maaf, Data sudah diinputkan...');";
		echo "document.location.href='index.php?page=master_penerima_lplpo';";
		echo "</script>";
		die();
	}
	
	//--tbpuskesmas--//
	$str = "INSERT INTO `tb_user_profil_sbbk_penerima`(`StatusPenerima`,`KodePuskesmas`,`NamaPuskesmas`,`NamaPegawai`,`Jabatan`,`Nip`)
	VALUES ('$statuspenerima','$kodepenerima','$namapenerima','$namapegawai','$jabatan','$nip')";

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