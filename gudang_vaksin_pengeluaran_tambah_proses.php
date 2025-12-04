<?php
$kode_puskesmas = $_SESSION['kodepuskesmas'];							
$namapegawaisimpan = $_SESSION['username'];	
$petugaspenerima = $_POST['petugas'];	
$tanggalpengeluaran = date('Y-m-d', strtotime($_POST['tanggalpengeluaran']));							
$jampengeluaran = date('G:i:s');	
$statuspengeluaran = $_POST['statuspengeluaran'];	
$namaprogram = $_POST['namaprogram'];								
$keterangan = strtoupper($_POST['keterangan']);								
$kodepenerima = strtoupper($_POST['penerima']);	
$tahun = date('Y');
$bulan = date('m', strtotime($_POST['tanggalpengeluaran']));	

if($_SEESION['kota']=='KABUPATEN BANDUNG' || $_SEESION['kota']=='KOTA BANDUNG' || $_SEESION['kota']=='KABUPATEN BULUNGAN' || $_SEESION['kota']=='KABUPATEN KUTAI KARTANEGARA'){
	$sql_cek='SELECT max(NoFaktur)as maxno FROM tbgfk_vaksin_pengeluaran WHERE SUBSTRING(NoFaktur,8,4)=YEAR(now())';
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
	$nofaktur="UPT.GB/".$tahun."/".$no;
}else{
	// kabupaten bogor	
	$sql_cek = 'SELECT max(NoFaktur)as maxno FROM tbgfk_vaksin_pengeluaran WHERE SUBSTRING(NoFaktur,10,4)=YEAR(now())';
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],0,5);
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
	$nofaktur = $no."/".$bulan."/".$tahun."/".$namaprogram;	
}	

// image
$var_file = $_FILES['image'];
$nama_file = $var_file['name']; // nama file asli
$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
$type = $var_file['type']; // type file
$size = $var_file['size']; // ukuran file
$tmp = $var_file['tmp_name']; // sumber file
$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto		

// tbpuskesmas
$qry = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepenerima'");
$dt = mysqli_fetch_assoc($qry);

// rumah sakit
$qry_rs = mysqli_query($koneksi,"SELECT * FROM `ref_rumahsakit` WHERE `IdRs`='$kodepenerima'");
$dt_rs = mysqli_fetch_assoc($qry_rs);

if($statuspengeluaran == 'PUSKESMAS'){
	if(mysqli_num_rows($qry) > 0){
		$penerima = $dt['NamaPuskesmas'];						
	}else{
		$penerima = $kodepenerima;	
	}	
}elseif($statuspengeluaran == 'RUMAH SAKIT'){
	if(mysqli_num_rows($qry_rs) > 0){
		$penerima = $dt_rs['NamaRs'];						
	}else{
		$penerima = $kodepenerima;	
	}
}elseif($statuspengeluaran == 'SENTRA VAKSINASI'){
	$penerima = 'SENTRA VAKSINASI';
}else{
	$penerima = $kodepenerima;
}	

// insert tbgfk_vaksin_pengeluaran
$str1 = "INSERT INTO `tbgfk_vaksin_pengeluaran`(`TanggalPengeluaran`,`JamPengeluaran`,`NoFaktur`,`StatusPengeluaran`,`KodePenerima`,`Penerima`,`PetugasPenerima`,`NamaProgram`,`Keterangan`,`ImageDok`,`NamaPegawaiSimpan`) 
VALUES ('$tanggalpengeluaran','$jampengeluaran','$nofaktur','$statuspengeluaran','$kodepenerima','$penerima','$petugaspenerima','$namaprogram','$keterangan','$namaimg','$namapegawaisimpan')";

// insert ke tbgudangpkmpenerimaan--> gak diluping karena header
if($statuspengeluaran == 'PUSKESMAS'){
	$str5 = "INSERT INTO `tbgudangpkmpenerimaan`(`TanggalPenerimaan`, `JamPenerimaan`, `NoFaktur`, `KodePuskesmas`, `TerimaDari`, `StatusValidasi`, `NamaPegawaiSimpan`)
	VALUES ('$tanggalpengeluaran','$jampengeluaran','$nofaktur','$kodepenerima','GUDANG BESAR','Belum','$namapegawaisimpan')";
	$query5 = mysqli_query($koneksi,$str5);
}

$query1=mysqli_query($koneksi,$str1);
	if($query1){	
		if($nama_file != ''){
			copy($tmp,'image/dokumen_pengeluaran_vaksin/'.$namaimg);
		}
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_new';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_pengeluaran_tambah';";
		echo "</script>";
	} 
?>