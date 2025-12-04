<?php
include "config/koneksi.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
if($keyword != ''){
	$query = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE NamaPuskesmas LIKE'%$keyword%'");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'kodepuskesmas'	=> $data['KodePuskesmas'],
			'puskesmas'	=> $data['NamaPuskesmas'],
			'value'	=> $data['NamaPuskesmas']
		);	
	}
	echo json_encode($arr);
}
?>		