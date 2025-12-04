<?php
	$tahun=date('Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$sql_cek="SELECT max(NoFaktur)as maxno FROM tbgudangpkmvaksinpengeluaran WHERE substring(NoFaktur,13,4)=YEAR(now()) AND substring(NoFaktur,1,11)='$kodepuskesmas'";
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],-5);
	$no_next=$no+1;
		if(strlen($no_next)==1)
		{
			$no="0000".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$no="000".$no_next;
		}
		elseif(strlen($no_next)==3)
		{
			$no="00".$no_next;
		}
		elseif(strlen($no_next)==4)
		{
			$no="0".$no_next;
		}
		else
		{
			$no=$no_next;
		}
	$nofaktur = $kodepuskesmas."/".$tahun."/".$no;

	// variabel tbgfkpenerimaan
	$tanggalpengeluaran = date('Y-m-d', strtotime($_POST['tanggalpengeluaran']))." ".date('G:i:s');	
	$penerima = $_POST['penerima'];				
	$namapegawaisimpan = $_SESSION['nama_petugas'];		
	
	$str = "INSERT INTO `tbgudangpkmvaksinpengeluaran`(`TanggalPengeluaran`,`NoFaktur`,`KodePuskesmas`,`Penerima`,`NamaPegawaiSimpan`)
	VALUES ('$tanggalpengeluaran','$nofaktur','$kodepuskesmas','$penerima','$namapegawaisimpan')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=apotik_vaksin_gudang_pengeluaran_lihat&nf=$nofaktur';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_vaksin_gudang_pengeluaran_tambah';";
		echo "</script>";
	} 
?>