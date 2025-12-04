<?php
	$tahun=date('Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$sql_cek="SELECT max(NoFaktur)as maxno from tbgudanguptdpengadaan WHERE substring(NoFaktur,1,11)='$kodepuskesmas' and substring(NoFaktur,13,4)= '$tahun'";
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
?>

<?php
//--variabel tbgfkpenerimaan--//			
$namapegawaisimpan = $_SESSION['nama_petugas'];							
$jampenerimaan = date('G:i:s');			
$tanggalpenerimaan = $_POST['tanggalpenerimaan'];	
$tglp = explode("-",$tanggalpenerimaan);
$tanggalpenerimaan1=$tglp[2]."-".$tglp[1]."-".$tglp[0];
$gudang = $_POST['gudang'];
$sumberanggaran = $_POST['sumberanggaran'];							
$tahunanggaran = $_POST['tahunanggaran'];							
$nomorkontrak = $_POST['nomorkontrak'];	
$tanggalkontrak = $_POST['tanggalkontrak'];	
$tgl = explode("-",$tanggalkontrak);
$tanggalkontrak1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
$namapengadaan = $_POST['namapengadaan'];	

$str1 = "INSERT INTO `tbgudanguptdpengadaan`(`TanggalPengadaan`,`JamPengadaan`,`NoFaktur`,`KodePuskesmas`,`SumberAnggaran`,`TahunAnggaran`,`NamaPegawaiSimpan`)
		VALUES ('$tanggalpenerimaan1','$jampenerimaan','$nopembukuan','$kodepuskesmas','$sumberanggaran','$tahunanggaran','$namapegawaisimpan')";
$query1=mysqli_query($koneksi,$str1);
// echo $str1;
// die();

if($query1){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan_tambah';";
	echo "</script>";
} 
?>