<?php
	session_start();
	include "config/koneksi.php";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
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