<?php
// nomor pembukuan
$tahun=date('Y');
$sql_cek='SELECT max(NomorPembukuan)as maxno from tbgfkpenerimaan WHERE substring(NomorPembukuan,5,4)=YEAR(now())';
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
$nomorpembukuan="PMB/".$tahun."/".$no;

// variabel
$kode_puskesmas = $_SESSION['kodepuskesmas'];							
$namapegawaisimpan = $_SESSION['nama_petugas'];							
$jampenerimaan = date('G:i:s');			
$tanggalpenerimaan = $_POST['tanggalpenerimaan'];	
$tglp = explode("-",$tanggalpenerimaan);
$tanggalpenerimaan1=$tglp[2]."-".$tglp[1]."-".$tglp[0];
$kodesupplier = $_POST['kodesupplier'];	
$gudang = $_POST['gudang'];
$sumberanggaran = $_POST['sumberanggaran'];							
$tahunanggaran = $_POST['tahunanggaran'];							
$statusanggaran = $_POST['statusanggaran'];							
$nomorkontrak = $_POST['nomorkontrak'];	
$tanggalkontrak = $_POST['tanggalkontrak'];	
$tgl = explode("-",$tanggalkontrak);
$tanggalkontrak1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
$namapengadaan = $_POST['namapengadaan'];	

// insert tbgfkpenerimaan
$str = "INSERT INTO `tbgfkpenerimaan`(`TanggalPenerimaan`,`JamPenerimaan`,`NomorPembukuan`,`KodeSupplier`,`Gudang`,`SumberAnggaran`,`TahunAnggaran`,`StatusAnggaran`,`NomorKontrak`,`TanggalKontrak`,`NamaPengadaan`,`NamaPegawaiSimpan`)
		VALUES ('$tanggalpenerimaan1','$jampenerimaan','$nomorpembukuan','$kodesupplier','$gudang','$sumberanggaran','$tahunanggaran','$statusanggaran','$nomorkontrak','$tanggalkontrak1','$namapengadaan','$namapegawaisimpan')";
$query = mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan_tambah';";
	echo "</script>";
} 
?>