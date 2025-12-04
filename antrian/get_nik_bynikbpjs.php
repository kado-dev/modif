<?php
error_reporting(0);
include('../config/helper_bpjs_v4.php');
$nik = $_POST['nik'];
$data = get_data_peserta_bpjs_nik($nik);
//echo $data;

$dbpjs = json_decode($data,true);
echo $dbpjs['response']['noKartu'];
?>