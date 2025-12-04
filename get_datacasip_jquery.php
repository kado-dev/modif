<?php
include "config/helper_casip.php";	
$getnik = get_data_casip($_GET['nik']);	
// $getnik = file_get_contents("http://simpus.bandungkab.go.id/helper_casip.php?nik=".$_GET['nik']);
echo $getnik;
?>