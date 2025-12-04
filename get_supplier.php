<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];

	$query = mysqli_query($koneksi,"SELECT * FROM `tbgfksupplier` WHERE `Supplier` LIKE'%$keyword%'");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['Supplier'],
			'supplier'	=> $data['Supplier'],
			'kodesupplier' => $data['KodeSupplier'],
			'alamat' => $data['Alamat'],
			'telpon' => $data['Telpon']
		);	
	}
	echo json_encode($arr);
?>		