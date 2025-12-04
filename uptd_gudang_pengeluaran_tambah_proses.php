<?php
$tahun=date('Y');
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$sql_cek="SELECT max(NoFaktur)as maxno from tbgudanguptdpengeluaran WHERE substring(NoFaktur,13,4)=YEAR(now()) AND substring(NoFaktur,1,11)='$kodepuskesmas'";
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

//--variabel--//
$tanggalpengeluaran = $_POST['tanggalpengeluaran'];	
$tglp = explode("-",$tanggalpengeluaran);
$tanggalpengeluaran1=$tglp[2]."-".$tglp[1]."-".$tglp[0];
$jampengeluaran = date('G:i:s');		
$kdpuskesmas = $_POST['kodepuskesmas'];	
$statuspengeluaran = $_POST['statuspengeluaran'];	
$keterangan = $_POST['keterangan'];	
$namapegawaisimpan = $_SESSION['nama_petugas'];		
	
$str = "INSERT INTO `tbgudanguptdpengeluaran`(`TanggalPengeluaran`,`JamPengeluaran`,`NoFaktur`,`KodePuskesmas`, `Keterangan`, `NamaPegawaiSimpan`)
VALUES ('$tanggalpengeluaran1','$jampengeluaran','$nofaktur','$kdpuskesmas','$keterangan','$namapegawaisimpan')";
$query=mysqli_query($koneksi,$str);

//insert ke tbgudangpkmpenerimaan
$str5 = "INSERT INTO `tbgudangpkmpenerimaan`(`TanggalPenerimaan`, `JamPenerimaan`, `NoFaktur`, `KodePuskesmas`, `TerimaDari`, `StatusValidasi`, `NamaPegawaiSimpan`)
		VALUES ('$tanggalpengeluaran1','$jampengeluaran','$nofaktur','$kdpuskesmas','UPTD','Belum','$namapegawaisimpan')";
$query5 = mysqli_query($koneksi,$str5);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=uptd_gudang_pengeluaran';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=uptd_gudang_pengeluaran_tambah';";
		echo "</script>";
	} 
?>