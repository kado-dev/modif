<?php
 // proses nya
	include "config/koneksi.php";
	include "config/helper_yankes.php";
	$token_yankes = $_SESSION['token_yankes'];

	$kodeyankes = $_SESSION['KodeYankes'];
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$updated_date = date('Y-m-d H:i:s');
	$jml_kunjungan_rj_laki = $_POST['jml_kunjungan_rj_laki'];
	$kelurahan = $_POST['kelurahan'];
	$jml_kunjungan_rj_perempuan = $_POST['jml_kunjungan_rj_perempuan'];
	$jml_kunjungan_rj_laki_perempuan = $_POST['jml_kunjungan_rj_laki'] + $_POST['jml_kunjungan_rj_perempuan'];
	$jml_kunjungan_ri_laki = $_POST['jml_kunjungan_ri_laki'];
	$jml_kunjungan_ri_perempuan = $_POST['jml_kunjungan_ri_perempuan'];
	$jml_kunjungan_ri_laki_perempuan = $_POST['jml_kunjungan_ri_laki'] + $_POST['jml_kunjungan_ri_perempuan'];
	$kunjungan_gangguan_jiwa_jml_laki = $_POST['kunjungan_gangguan_jiwa_jml_laki'];
	$kunjungan_gangguan_jiwa_jml_perempuan = $_POST['kunjungan_gangguan_jiwa_jml_perempuan'];
	$kunjungan_gangguan_jiwa_jml_laki_perempuan = $_POST['kunjungan_gangguan_jiwa_jml_perempuan'] + $_POST['kunjungan_gangguan_jiwa_jml_laki'];


	$str = "INSERT INTO `eprofil_tb01`(`id_datadasar`,`id_tabel5`, `KODE_PUSKESMAS`, `bulan`, `tahun`, `updated_date`, `jml_kunjungan_rj_laki`, `jml_kunjungan_rj_perempuan`, `jml_kunjungan_rj_laki_perempuan`, `jml_kunjungan_ri_laki`, `jml_kunjungan_ri_perempuan`,`jml_kunjungan_ri_laki_perempuan`,`kunjungan_gangguan_jiwa_jml_laki`,`kunjungan_gangguan_jiwa_jml_perempuan`,`kunjungan_gangguan_jiwa_jml_laki_perempuan`)
	VALUES ('$kelurahan','0','$kodeyankes','$bulan','$tahun','$updated_date','$jml_kunjungan_rj_laki','$jml_kunjungan_rj_perempuan','$jml_kunjungan_rj_laki_perempuan','$jml_kunjungan_ri_laki','$jml_kunjungan_ri_perempuan','$jml_kunjungan_ri_laki_perempuan','$kunjungan_gangguan_jiwa_jml_laki','$kunjungan_gangguan_jiwa_jml_perempuan','$kunjungan_gangguan_jiwa_jml_laki_perempuan')";
	mysqli_query($koneksi,$str);
	$IdEprofilTb01 = mysqli_insert_id($koneksi);


	$dt['id_datadasar'] = $kelurahan;
	$dt['KODE_PUSKESMAS'] = $kodeyankes;
	$dt['bulan'] =  $bulan;
	$dt['tahun'] =  $tahun;
	$dt['updated_date'] =  $updated_date;
	$dt['jml_kunjungan_rj_laki'] =  $jml_kunjungan_rj_laki;
	$dt['jml_kunjungan_rj_perempuan'] =  $jml_kunjungan_rj_perempuan;
	$dt['jml_kunjungan_rj_laki_perempuan'] =  $jml_kunjungan_rj_laki_perempuan;
	$dt['jml_kunjungan_ri_laki'] =  $jml_kunjungan_ri_laki;
	$dt['jml_kunjungan_ri_perempuan'] =  $jml_kunjungan_ri_perempuan;
	$dt['jml_kunjungan_ri_laki_perempuan'] =  $jml_kunjungan_ri_laki_perempuan;
	$dt['kunjungan_gangguan_jiwa_jml_laki'] =  $kunjungan_gangguan_jiwa_jml_laki;
	$dt['kunjungan_gangguan_jiwa_jml_perempuan'] =  $kunjungan_gangguan_jiwa_jml_perempuan;
	$dt['kunjungan_gangguan_jiwa_jml_laki_perempuan'] =  $kunjungan_gangguan_jiwa_jml_laki_perempuan;

	$insert_yankes = insert_kunjuangan($token_yankes,json_encode($dt));
	$dtyankes = json_decode($insert_yankes,true);

	$id_tabel5 = $dtyankes['data'][0]['id_tabel5'];
	if($dtyankes['meta']['message'] == 'Data already exists, please input different value!'){
		edit_kunjuangan($token_yankes,$id_tabel5,json_encode($dt));
	}
	
	mysqli_query($koneksi,"UPDATE `eprofil_tb01` SET `id_tabel5`= '$id_tabel5' WHERE `IdEprofilTb01` = '$IdEprofilTb01'");

	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=eprofil_tabel_01';";
	echo "</script>";
?>