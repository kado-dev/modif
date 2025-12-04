<?php
//--variabel tbgfkpenerimaan--//						
$namapegawaisimpan = $_SESSION['nama_petugas'];							
$jampengeluaran = date('G:i:s');					
$tanggalpengeluaran = $_POST['tanggalpengeluaran'];	
$kodepenerima = $_POST['kodepenerima'];	

$noinvoice = $_POST['noinvoice'];	
$namabarang = strtoupper($_POST['namabarang']);		
$satuan = strtoupper($_POST['satuan']);	
$qty = $_POST['qty'];	
$harga = $_POST['harga'];	
$jumlah = $harga * $qty;	

//--tbadm_invoice_detail--//
$str = "INSERT INTO `tbadm_invoice_detail`(`NoInvoice`,`NamaBarang`,`Satuan`,`Qty`,`Harga`,`Jumlah`) VALUES ('$noinvoice','$namabarang','$satuan','$qty','$harga','$jumlah')";
$query = mysqli_query($koneksi, $str);

//--update grandtotal--//
$query_print = mysqli_query($koneksi,"select * from `tbadm_invoice_detail` where NoInvoice = '$noinvoice'");
					
$qty = 0;
$total = 0;
$no = 0;
while($data = mysqli_fetch_assoc($query_print)){
	$no = $no + 1;
	$jumlah = $data['Harga'] * $data['Qty'];
	$total = $jumlah + $total;
}
$str_update =  mysqli_query($koneksi,"UPDATE `tbadm_invoice` SET JumlahTagihan=$total WHERE NoInvoice='$noinvoice'");

if($query){
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=adm_invoice_lihat&id=$noinvoice';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=adm_invoice_lihat&id=$noinvoice';";
	echo "</script>";
} 
?>