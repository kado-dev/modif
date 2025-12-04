<?php
//session_start();
include "config/koneksi.php";
// include "config/helper_bpjs.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
//echo $keyword;

	$str = "SELECT tbgudangpkmstok.stok, tbgudangpkmstok.KodeBarang, tbgfkstok.NamaBarang, tbgfkstok.SumberAnggaran  FROM `tbgudangpkmstok` join tbgfkstok on tbgudangpkmstok.KodeBarang = tbgfkstok.KodeBarang Where tbgfkstok.NamaBarang Like'%$keyword%'";
	$query = mysqli_query($koneksi,$str);
	while($data=mysqli_fetch_assoc($query)){
		$arr['suggestions'][] = array(
			'kodeobatbpjs'	=> $data['KodeBarang'],
			'namaobatbpjs'	=> $data['NamaBarang'],
			'sediaobatbpjs'	=> $data['stok'],
			'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']." | ".$data['stok']." | ".$data['SumberAnggaran']
		);
	}
	echo json_encode($arr);
	
// /**	
// $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

// $keyword = $segments[3];
// //echo $keyword;
// 	$data_therapy = get_data_therapy($keyword);
// 	$dtherapy = json_decode($data_therapy,True);
// 	$data = $dtherapy['response']['list'];
	
// 	for($i = 0 ; $i < count($data); $i++){
// 		$arr['suggestions'][] = array(
// 			'kodeobatbpjs'	=> $dtherapy['response']['list'][$i]['kdObat'],
// 			'namaobatbpjs'	=> $dtherapy['response']['list'][$i]['nmObat'],
// 			'sediaobatbpjs'	=> $dtherapy['response']['list'][$i]['sedia'],
// 			'value'	=> $dtherapy['response']['list'][$i]['kdObat']." | ".$dtherapy['response']['list'][$i]['nmObat']." | ".$dtherapy['response']['list'][$i]['sedia']
// 		);	
// 	}
// 	echo json_encode($arr);	
// **/	
?>		