<?php
	include "config/koneksi.php";
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

	$keyword = $segments[3];
	$query = mysqli_query($koneksi,"select * FROM `tb_user_profil_sbbk_penerima` WHERE NamaPegawai LIKE'%$keyword%'");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=>$data['NamaPegawai']
		);	
	}
	echo json_encode($arr);
?>	
