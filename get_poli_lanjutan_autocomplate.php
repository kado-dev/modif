<?php
	session_start();
	include "config/helper_bpjs.php";
	
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

	$keyword = $segments[3];	

	$data_polirs = get_data_polirs();
	$dpolirs = json_decode($data_polirs,True);
		$list = $dpolirs['response']['list'];
		
		foreach($list as $ket){
			$arr['query']=$keyword;
		
				$arr['suggestions'][] = array(
					'kode'	=> $ket['kdPoli'],
					'value'	=> $ket['nmPoli']
				);
			
		}
		echo json_encode($arr);		
?>		