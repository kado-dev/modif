<?php
if($_SESSION['otoritas'] == 'PROGRAMMER'){
$noinvoice = $_GET['no'];
$namabarang = $_GET['nama'];

//--update grandtotal--//
$query_print = mysqli_query($koneksi,"select * from `tbadm_invoice_detail` where NoInvoice = '$noinvoice'");
$total_lama =  mysqli_fetch_assoc(mysqli_query($koneksi,"select Jumlah from `tbadm_invoice_detail` where NoInvoice = '$noinvoice' and NamaBarang = '$namabarang'"));

$qty = 0;
$total = 0;
$total_baru = 0;
$no = 0;
while($data = mysqli_fetch_assoc($query_print)){
	$no = $no + 1;
	$jumlah = $data['Harga'] * $data['Qty'];
	$total = $jumlah + $total;
	$totalbaru = $total - $total_lama['Jumlah'];
}
$str_update =  mysqli_query($koneksi,"UPDATE `tbadm_invoice` SET JumlahTagihan=$totalbaru WHERE NoInvoice='$noinvoice'");

//--update tbadm_invoice_detail--//
$str = "DELETE FROM tbadm_invoice_detail where `NoInvoice` = '$noinvoice' and `NamaBarang` = '$namabarang'";
$query=mysqli_query($koneksi,$str);
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=adm_invoice_lihat&id=$noinvoice';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=adm_invoice_lihat&id=$noinvoice';";
		echo "</script>";
	} 
}else{
		echo "<script>";
		echo "alert('Maaf anda tidak bisa menghapus data.');";
		echo "document.location.href='?page=adm_invoice_lihat&id=$noinvoice';";
		echo "</script>";
}	
?>