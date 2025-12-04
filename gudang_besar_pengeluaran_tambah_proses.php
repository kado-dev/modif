<?php
$kode_puskesmas = $_SESSION['kodepuskesmas'];							
$namapegawaisimpan = $_SESSION['username'];	
$petugaspenerima = $_POST['petugas'];	
$tanggalentry = date('Y-m-d', strtotime($_POST['tanggalentry']));							
$tanggalpengeluaran = date('Y-m-d', strtotime($_POST['tanggalpengeluaran']));							
$jampengeluaran = date('G:i:s');	
$statuspengeluaran = $_POST['statuspengeluaran'];	
$namaprogram = $_POST['namaprogram'];								
$keterangan = strtoupper($_POST['keterangan']);								
$kodepenerima = strtoupper($_POST['penerima']);	
$tahun = date('Y');
$bulan = date('m', strtotime($_POST['tanggalpengeluaran']));
$tahunproses = date('Y', strtotime($_POST['tanggalpengeluaran']));
$bulanini = date('m');

if($kota == 'KABUPATEN BANDUNG' || $kota == 'KOTA BANDUNG' || $kota == 'KABUPATEN BULUNGAN' || $kota == 'KABUPATEN KUTAI KARTANEGARA' || $kota == 'KABUPATEN BEKASI'){
	$sql_cek='SELECT max(NoFaktur)as maxno FROM tbgfkpengeluaran WHERE SUBSTRING(NoFaktur,8,4)=YEAR(now())';
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
	$sql_cek = "SELECT max(NoFaktur)as maxno FROM tbgfkpengeluaran WHERE MONTH(TanggalEntry)=$bulan AND YEAR(TanggalEntry)='$tahunproses' AND `NamaProgram`='$namaprogram'";
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
	$nofaktur = $no."/".$bulan."/".$tahunproses."/".$namaprogram;	
}	

// faktur manual bekasi	
	$sql_cek = "SELECT max(NoFakturManual)as maxno FROM tbgfkpengeluaran WHERE YEAR(TanggalPengeluaran)=YEAR(NOW())";
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
		$no=substr($datareg['maxno'],-26);
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
	$nofakturmanual = "442.2/".$no."/UPTD Farmasi/".date("m")."/".date("Y");	

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
}elseif($statuspengeluaran == 'KLINIK DINAS'){
	$penerima = $dt['NamaPuskesmas'];
}else{
	$penerima = $kodepenerima;
}	

// cek jika entry beda bulan, buat notif
// if ($kota == "KABUPATEN BEKASI"){
	// if (date('m', strtotime($tanggalentry)) != date('m')){
		// echo "<script>";
		// echo "alert('Maaf, data gagal disimpan karena sudah lewat bulan...');";
		// echo "document.location.href='index.php?page=gudang_besar_pengeluaran';";
		// echo "</script>";
		// die();
	// }
// }else{
	// if($namaprogram != "COVID-19"){
		// if (date('m', strtotime($tanggalpengeluaran)) != date('m')){
			// echo "<script>";
			// echo "alert('Maaf, data gagal disimpan karena sudah lewat bulan...');";
			// echo "document.location.href='index.php?page=gudang_besar_pengeluaran';";
			// echo "</script>";
			// die();
		// }
	// }
// }

// cek pengeluaran dalam bulan ini, buat notif	
$cekfaktur = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoFaktur` FROM `tbgfkpengeluaran` WHERE `KodePenerima`='$kodepenerima' AND YEAR(TanggalPengeluaran)='$tahun' AND MONTH(TanggalPengeluaran)='$bulan' AND `NamaProgram`='$namaprogram'"));
if($cekfaktur > 0){
	echo "<script>";
	echo "alert('".$statuspengeluaran." ".$penerima." - PROGRAM ".$namaprogram." sudah diinput dibulan ini, silahkan cek kembali...');";
	echo "document.location.href='index.php?page=gudang_besar_pengeluaran';";
	echo "</script>";
}	

if($kota == "KABUPATEN BEKASI"){
	$str1 = "INSERT INTO `tbgfkpengeluaran`(`TanggalEntry`,`TanggalPengeluaran`,`JamPengeluaran`,`NoFakturManual`,`NoFaktur`,`StatusPengeluaran`,`KodePenerima`,`Penerima`,`PetugasPenerima`,`NamaProgram`,`Keterangan`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggalentry','$tanggalpengeluaran','$jampengeluaran','$nofakturmanual','$nofaktur','$statuspengeluaran','$kodepenerima','$penerima','$petugaspenerima','$namaprogram','$keterangan','$namapegawaisimpan')";
}else{
	// selain bekasi, samakan aja tanggalentry dan tanggalpengeluaran
	$str1 = "INSERT INTO `tbgfkpengeluaran`(`TanggalEntry`,`TanggalPengeluaran`,`JamPengeluaran`,`NoFaktur`,`StatusPengeluaran`,`KodePenerima`,`Penerima`,`PetugasPenerima`,`NamaProgram`,`Keterangan`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggalpengeluaran','$tanggalpengeluaran','$jampengeluaran','$nofaktur','$statuspengeluaran','$kodepenerima','$penerima','$petugaspenerima','$namaprogram','$keterangan','$namapegawaisimpan')";
}
// echo $str1;
// die();

$query1=mysqli_query($koneksi,$str1);
	if($query1){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_tambah';";
		echo "</script>";
	} 
?>