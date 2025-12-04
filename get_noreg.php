<?php
include "config/koneksi.php";
$tahunreg=explode("-",$_POST['tgl']);


$tahunreg2=str_replace('20','',$tahunreg[2])."".$tahunreg[1]."".$tahunreg[0];
$noreg=$_POST['noreg'];
$noreg2=substr($_POST['noreg'],0,11);
//echo $tahunreg;
$sql_cek="SELECT max(NoRegistrasi)as maxno from `$tbpasienrj` WHERE substring(NoRegistrasi,7,8)='$tahunreg2'";
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
echo $noreg2."/".$tahunreg2."/".$no;
?>