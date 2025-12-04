<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahun=date('Y');
$sql_cek="SELECT max(NoFaktur)as maxno FROM `tbasetpengeluaran` WHERE SUBSTRING(NoFaktur,13,4)='$tahun' AND SUBSTRING(NoFaktur,1,11)='$kodepuskesmas'";
$query_cek=mysqli_query($koneksi,$sql_cek);
$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],-3);
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
$nofaktur = $kodepuskesmas."/".$tahun."/".$no;

$tanggalpengeluaran = $_POST['tanggalpengeluaran'];	
$tglp = explode("-",$tanggalpengeluaran);
$tanggalpengeluaran=$tglp[2]."-".$tglp[1]."-".$tglp[0];					
$jampengeluaran = date('G:i:s');		
$statuspengeluaran = $_POST['statuspengeluaran'];							
$penerima = $_POST['penerima'];
$keterangan = $_POST['keterangan'];
$namapegawaisimpan = $_SESSION['nama_petugas'];	

$str = "INSERT INTO `tbasetpengeluaran`(`TanggalPengeluaran`,`JamPengeluaran`,`NoFaktur`,`StatusPengeluaran`,`Penerima`,`Keterangan`,`NamaPegawaiSimpan`)
VALUES ('$tanggalpengeluaran','$jampengeluaran','$nofaktur','$statuspengeluaran','$penerima','$keterangan','$namapegawaisimpan')";
// echo $str;
// die();		
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=aset_pengeluaran';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=aset_pengeluaran_tambah';";
	echo "</script>";
} 
?>