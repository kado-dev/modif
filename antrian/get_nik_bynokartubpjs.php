<?php
error_reporting(0);
include('../config/helper_bpjs_v4.php');
$nokartu = $_POST['nokartu'];
$data = get_data_peserta_bpjs($nokartu);
//echo $data;

$dbpjs = json_decode($data,true);
echo $dbpjs['response']['noKTP'];
?>