<?php
$tahun=date('Y');
$sql_cek='SELECT max(NomorPembukuan)as maxno FROM tbgfk_vaksin_penerimaan WHERE substring(NomorPembukuan,5,4)=YEAR(now())';
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
$nomorkontrak = $_POST['nomorkontrak'];	
$tanggalkontrak = $_POST['tanggalkontrak'];	
$tgl = explode("-",$tanggalkontrak);
$tanggalkontrak1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
$namapengadaan = $_POST['namapengadaan'];

// image
$var_file = $_FILES['image'];
$nama_file = $var_file['name']; // nama file asli
$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
$type = $var_file['type']; // type file
$size = $var_file['size']; // ukuran file
$tmp = $var_file['tmp_name']; // sumber file
$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto	


if ($kodesupplier == ""){
	echo "<script>";
	echo "alert('Suplier tidak sesuai database, silahkan isi kembali...');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan_tambah';";
	echo "</script>";
}else{
	$str1 = "INSERT INTO `tbgfk_vaksin_penerimaan`(`TanggalPenerimaan`, `JamPenerimaan`, `NomorPembukuan`, `KodeSupplier`, `Gudang`, `SumberAnggaran`, `TahunAnggaran`, `NomorKontrak`, `TanggalKontrak`, `NamaPengadaan`, `ImageDok`, `NamaPegawaiSimpan`)
	VALUES ('$tanggalpenerimaan1','$jampenerimaan','$nomorpembukuan','$kodesupplier','$gudang','$sumberanggaran','$tahunanggaran','$nomorkontrak','$tanggalkontrak1','$namapengadaan','$namaimg','$namapegawaisimpan')";
	$query1=mysqli_query($koneksi,$str1);
}
// echo $str1;
// die();

if($query1){
	if($nama_file != ''){
		copy($tmp,'image/dokumen_penerimaan_vaksin/'.$namaimg);
	}	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan_tambah';";
	echo "</script>";
} 
?>