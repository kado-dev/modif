<?php							
$tanggalinvoice = $_POST['tanggalinvoice'];	
$tglp = explode("-",$tanggalinvoice);
$tanggalinvoice1=$tglp[2]."-".$tglp[1]."-".$tglp[0];					
$ditujukan = strtoupper($_POST['ditujukan']);
$jumlahtagihan = $_POST['jumlahtagihan'];
$keterangan = strtoupper($_POST['keterangan']);

$bulan=date('m');
$tahun=date('Y');
$sql_cek='SELECT max(NoInvoice)as maxno FROM `tbadm_invoice` WHERE substring(NoInvoice,7,4)=YEAR(now())';
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
$noinvoice = "INV/".$bulan.$tahun."/".$no;

$str_inv = "INSERT INTO `tbadm_invoice`(`TanggalInvoice`, `NoInvoice`, `Tujuan`, `JumlahTagihan`, `Keterangan`)
VALUES ('$tanggalinvoice1','$noinvoice','$ditujukan','$jumlahtagihan','$keterangan')";
// echo $str_inv;
// die();
$query=mysqli_query($koneksi,$str_inv);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=adm_invoice';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=adm_invoice';";
		echo "</script>";
	} 
?>