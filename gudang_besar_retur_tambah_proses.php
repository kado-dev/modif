<?php
$tanggalretur = date('Y-m-d', strtotime($_POST['tanggalretur']));	
$bulan= date('m', strtotime($_POST['tanggalretur']));
$tahun= date('Y', strtotime($_POST['tanggalretur']));		
$statusretur = $_POST['statusretur'];	
$kodepenerima = strtoupper($_POST['penerima']);	
$keterangan = $_POST['keterangan'];	

// nofaktur
$sql_cek='SELECT max(NoFaktur)as maxno FROM `tbgfkretur` WHERE SUBSTRING(NoFaktur,5,4)=YEAR(now())';
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
$nofaktur="RET/".$tahun."/".$no;

// tbpuskesmas
$qry = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepenerima'");
$dt = mysqli_fetch_assoc($qry);

// rumah sakit
$qry_rs = mysqli_query($koneksi,"SELECT * FROM `ref_rumahsakit` WHERE `IdRs`='$kodepenerima'");
$dt_rs = mysqli_fetch_assoc($qry_rs);

if($statusretur == 'PUSKESMAS'){
	if(mysqli_num_rows($qry) > 0){
		$penerima = $dt['NamaPuskesmas'];						
	}else{
		$penerima = $kodepenerima;	
	}	
}else{
	if(mysqli_num_rows($qry_rs) > 0){
		$penerima = $dt_rs['NamaRs'];						
	}else{
		$penerima = $kodepenerima;	
	}
}

// insert
$str = "INSERT INTO `tbgfkretur`(`TanggalRetur`,`NoFaktur`,`StatusRetur`,`KodePenerima`,`Penerima`,`Keterangan`) 
VALUES ('$tanggalretur','$nofaktur','$statusretur','$kodepenerima','$penerima','$keterangan')";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_retur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_retur_tambah';";
	echo "</script>";
} 
?>