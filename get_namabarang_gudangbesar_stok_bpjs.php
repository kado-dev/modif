<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
		$query = mysqli_query($koneksi,"select * from `tbgfkstok` where SumberAnggaran = 'BPJS' AND `NamaBarang` LIKE'%$keyword%' group by `NamaBarang`, `Expire` order by `NamaBarang`");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['NamaBarang'],
				'kodebarang' => $data['KodeBarang']
			);	
		}
		echo json_encode($arr);
?>		