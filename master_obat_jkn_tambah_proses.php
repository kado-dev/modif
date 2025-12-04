<?php
	$sql_cek='SELECT max(KodeObatJkn)as maxno from `ref_obat_jkn` WHERE substring(KodeObatJkn,4,4)';
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$data=mysqli_fetch_array($query_cek);
	$no=substr($data['maxno'],-4);
	$no_next=$no+1;

		if(strlen($no_next)==1)
		{
			$no="000".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$no="00".$no_next;
		}
		elseif(strlen($no_next)==3)
		{
			$no="0".$no_next;
		}
		else
		{
			$no=$no_next;
		}
	$kodebarang="JKN".$no;	
	
	$namabarang = $_POST['namabarang'];
	
	// cek nama obat jkn, jika ada tampil warning message
	$cek_nm_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_pornas` WHERE `NamaObat` = '$namabarang'"));
	if($cek_nm_barang == 0){
		echo "<script>";
		echo "document.location.href='?page=master_obat_jkn_tambah&stsvalidasi=Data gagal tersimpan, Nama Barang tidak terdaftar di Database...';";
		echo "</script>";
		die();
	}	
		
	$str = "INSERT INTO `ref_obat_jkn`(`KodeObatJkn`,`NamaObatJkn`) VALUES('$kodebarang','$namabarang')";
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_obat_jkn_tambah'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_obat_jkn_tambah';";
		echo "</script>";
	} 	
?>