<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
		include "config/helper_bpjs_v4.php";	

	$key = $_POST['key'];
	$isisub = $_POST['isisub'];
	//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
	$data_spesialis = get_data_referensi_sub_spesialis($key);
	$dtspesialis = json_decode($data_spesialis,True);
		$list = $dtspesialis['response']['list'];
		foreach($list as $ket){
			if($ket['kdSubSpesialis'] == $isisub){
				echo "<option value='$ket[kdSubSpesialis]' SELECTED>".$ket['nmSubSpesialis']."</option>";
			}else{
				echo "<option value='$ket[kdSubSpesialis]'>".$ket['nmSubSpesialis']."</option>";
			}
			

			
		}
	//}		
?>	