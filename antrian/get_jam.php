<?php
// session_start();
// $kota = $_SESSION['kota'];
// if($kota == "KOTA TARAKAN"){
	
// }else{
	// date_default_timezone_set('Asia/Jakarta');
// }

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
	date_default_timezone_set('Asia/Ujung_Pandang');
	echo "data:".date('G:i:s')."\n\n";
	flush();	
?>