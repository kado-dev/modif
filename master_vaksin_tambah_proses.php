<?php
	$sql_cek='SELECT max(KodeBarang)as maxno from `ref_vaksin` WHERE substring(KodeBarang,4,4)';
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$data=mysqli_fetch_array($query_cek);
	$no=substr($data['maxno'],-3);
	$no_next=$no+1;

		if(strlen($no_next)==1)
		{
			$no="00".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$no="0".$no_next;
		}
		else
		{
			$no=$no_next;
		}
	$kodebarang="VAC".$no;	
	
	
	$namabarang = $_POST['namabarang'];
	$satuan = $_POST['satuan'];
	$namaprogram = $_POST['namaprogram'];
	
	// insert, obat program vaksin = 13
	$str = "INSERT INTO `ref_vaksin`(`KodeBarang`,`IdLplpo`,`NamaBarang`,`Satuan`,`NamaProgram`)
	VALUES('$kodebarang','13','$namabarang','$satuan','$namaprogram')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_vaksin'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_vaksin_tambah';";
		echo "</script>";
	} 	
?>