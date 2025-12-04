<?php
	$tanggallahir = $_POST['tgllahir'];
	if($tanggallahir != ''){
		$tglla=explode("-",$tanggallahir);
		$tgl_lahir=$tglla[0];
		$bln_lahir=$tglla[1];
		$thn_lahir=$tglla[2];
		$tanggal_today = date('d');
		$bulan_today=date('m');
		$tahun_today = date('Y');

		$harilahir=GregorianToJD($bln_lahir, $tgl_lahir, $thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
		$hariini=GregorianToJD($bulan_today, $tanggal_today, $tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

		$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

		$tahun=$umur/365;//menghitung usia tahun
		$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
		$bulan=$sisa/30;//menghitung usia bulan
		$hari=$sisa%30;//menghitung sisa hari	

		$tahun_umur = floor($tahun); // floor pembulatan
		$bulan_umur = floor($bulan);
		$hari_umur = $hari;
		echo $tahun_umur." Th ".$bulan_umur." Bl ".$hari_umur." Hr";
	}
?>