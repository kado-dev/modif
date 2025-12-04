<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahun=date('Y');
$sql_cek="SELECT max(NoFaktur)as maxno FROM `tbgudangpkmpengadaan` WHERE SUBSTRING(NoFaktur,13,4)='$tahun' AND SUBSTRING(NoFaktur,1,11)='$kodepuskesmas'";
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
$nopembukuan=$kodepuskesmas."/".$tahun."/".$no;

$tanggalpenerimaan = $_POST['tanggalpenerimaan'];	
$tglp = explode("-",$tanggalpenerimaan);
$tanggalpengadaan=$tglp[2]."-".$tglp[1]."-".$tglp[0];					
$jampenerimaan = date('G:i:s');		
$sumberanggaran = $_POST['sumberanggaran'];							
$tahunanggaran = $_POST['tahunanggaran'];
$kodesupplier = $_POST['kodesupplier'];
$keterangan = $_POST['keterangan'];
$namapegawaisimpan = $_SESSION['nama_petugas'];	

$str = "INSERT INTO `tbgudangpkmpengadaan`(`TanggalPengadaan`,`JamPengadaan`,`NoFaktur`,`SumberAnggaran`,`TahunAnggaran`,`KodeSupplier`,`Keterangan`,`NamaPegawaiSimpan`)
		VALUES ('$tanggalpengadaan','$jampenerimaan','$nopembukuan','$sumberanggaran','$tahunanggaran','$kodesupplier','$keterangan','$namapegawaisimpan')";
// echo $str;
// die();		
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_tambah';";
	echo "</script>";
} 
?>