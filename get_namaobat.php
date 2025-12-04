<?php
include "config/koneksi.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
//echo $keyword;
		// format keluaran di dalam array
		$query = mysqli_query($koneksi,"select * from `tbgfkstok` where NamaBarang LIKE'%$keyword%'");

		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'idbarang'	=> $data['KodeBarang'],
				'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']
			);	
		}
		echo json_encode($arr);
?>		