<?php
include('config/helper_bpjs_antrean_v2.php');

$getdokter = get_data_dokter_antrean_fktp('001','2024-05-30');

echo $getdokter;
?>