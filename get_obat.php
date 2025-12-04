<?php
include "config/koneksi.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[5];
$sts = $segments[4];
$status = 'LOKET OBAT';
$kodepus = $segments[3];
//echo $keyword;
		// format keluaran di dalam array
		$str = "select tbgfkstok.NamaBarang, tbapotikstok.KodeBarang, tbapotikstok.Stok from `tbapotikstok` join `tbgfkstok` on tbapotikstok.KodeBarang = tbgfkstok.KodeBarang where tbapotikstok.StatusBarang = '$status' AND tbapotikstok.KodePuskesmas = '$kodepus' AND tbgfkstok.NamaBarang LIKE'%$keyword%' OR tbapotikstok.KodeBarang LIKE'%$keyword%'";
		$query = mysqli_query($koneksi,$str);
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'kodebarang'	=> $data['KodeBarang'],
				'namabarang'	=> $data['NamaBarang'],
				'stokbarang'	=> $data['Stok'],
				'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']." | ".$data['Stok']
			);	
		}
		echo json_encode($arr);
?>		