<?php
//tbresep
$statusloket = $_POST['statusloket'];
$tanggalresep = $_POST['tanggalresep'];
$noresep = $_POST['noresep'];
$noindex = $_POST['noindex'];
$nocm = $_POST['nocm'];
$namapasien = $_POST['namapasien'];
$umurtahun = $_POST['umurtahun'];
$umurbulan = $_POST['umurbulan'];
$asuransi = $_POST['asuransi'];
$pelayanan = $_POST['pelayanan'];
$namapegawai = $_SESSION['username'];
$kodepuskesmas= $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	
// tbresepdetail
$kodebarang = $_POST['kodebarang'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
$dosis = $_POST['dosis'];
$puyer = $_POST['puyer'];

//--noregitrasi--//
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tahunreg=date('ymd');
$sql_cek="SELECT max(NoRegistrasi)as maxno from tbresep WHERE substring(NoRegistrasi,13,6) = DATE(now()) AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'";
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
$noregistrasi=$kodepuskesmas."/".$tahunreg."/".$no;

$str_resep = "INSERT INTO `$tbresep`(`TanggalResep`, `NoResep`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NamaPasien`, `UmurTahun`, `UmurBulan`,
`StatusBayar`, `Pelayanan`, `Status`, `StatusLoket`, `NamaPegawai`)
VALUES('$tanggalresep','$noregistrasi','$noregistrasi','0','0','$namapasien','$umurtahun','$umurbulan','$asuransi','$pelayanan','Belum',
'$statusloket','$namapegawai')";
$query=mysqli_query($koneksi,$str_resep);

echo var_dump($str_resep);
die();

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=apotik&status=$statusloket';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=apotik_resep&status=$statusloket';";
	echo "</script>";
} 
?>