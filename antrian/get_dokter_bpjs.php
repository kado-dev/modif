<?php
include('../config/helper_bpjs_antrean_v2.php');
$kodepoli = $_POST['kodepoli'];
$tanggal = date('Y-m-d');
$get = get_data_dokter_antrean_fktp($kodepoli,$tanggal);
$dtarray = json_decode($get,true);
$dt = $dtarray['response'];
echo "<option value=''>--Pilih--</option>";
foreach($dt as $dok){
    echo "<option value='".$dok['kodedokter']."' data-namadokter='".$dok['namadokter']."' data-jampraktek='".$dok['jampraktek']."'>".$dok['namadokter']."</option>";
};
?>