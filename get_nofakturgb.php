<?php
	include "config/koneksi.php";
	$tahunreg=explode("-",$_POST['tgl']);
	
	$tahun=$tahunreg[2];
	$sql_cek="SELECT max(NoFaktur)as maxno from tbgfkpengeluaran WHERE substring(NoFaktur,9,4)='$tahun'";
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
		$no=substr($datareg['maxno'],-5);
		$no_next=$no+1;
			if(strlen($no_next)==1)
			{
				$no="0000".$no_next;
			}
			elseif(strlen($no_next)==2)
			{
				$no="000".$no_next;
			}
			elseif(strlen($no_next)==3)
			{
				$no="00".$no_next;
			}
			elseif(strlen($no_next)==4)
			{
				$no="0".$no_next;
			}
			else
			{
				$no=$no_next;
			}
	$nofaktur="UPTD.GB/".$tahun."/".$no;
	echo $nofaktur;
?>
