<?php
session_start();
include "config/koneksi.php";
include "config/helper_bpjs_v4.php";
$data_poli = get_data_poli();
$dpoli = json_decode($data_poli,True);

$list_poli = $dpoli['response']['list'];
			
	foreach($list_poli as $lp){
	if($lp['poliSakit'] == false){
		if($lp['nmPoli'] == 'Umum'){
		echo "<option value=".$lp['kdPoli']." SELECTED>".$lp['nmPoli']."</option>";
		}else{
		echo "<option value=".$lp['kdPoli'].">".$lp['nmPoli']."</option>";
		}
	}
	}
?>