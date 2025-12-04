<?php

$tgl_lahir='05';
$bln_lahir='02';
$thn_lahir='1993';

$tanggal_today = date('d');
$bulan_today=date('m');
$tahun_today = date('Y');

$harilahir=gregoriantojd($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
$hariini=gregoriantojd($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

$tahun=$umur/365;//menghitung usia tahun
$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
$bulan=$sisa/30;//menghitung usia bulan
$hari=$sisa%30;//menghitung sisa hari

$lahir= "$tgl_lahir-$bln_lahir-$thn_lahir";
$today= "$tanggal_today-$bulan_today-$tahun_today";

echo"Tgl Lahir $lahir<br/>";
echo"Tgl Skrg $today<br/>";

echo"Umur Anda Adalah ".floor($tahun)." tahun ".floor($bulan)." bulan $hari hari";


?>
