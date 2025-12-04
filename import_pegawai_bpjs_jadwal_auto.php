<?php

	include "config/helper_bpjs_antrean_v2.php";

    $arr_kodepoli = array('001','002','003','008','012');

    foreach($arr_kodepoli as $kdpoli){
        //$kdpoli = '001';
        $data_medis = get_data_dokter_antrean_fktp($kdpoli,date('Y-m-d'));
        $dmedis = json_decode($data_medis,True);
        $list = $dmedis['response'];
        // echo "hasil : ".get_data_dokter_antrean_fktp();
        // die();

        if($list != ''){
            if(count($list)){
                foreach($list as $ls){
                    $kdpuskesmas = $_SESSION['kodepuskesmas'];
                    $namadokter = mysqli_real_escape_string($koneksi, $ls['namadokter']);
                    $kddokter = $ls['kodedokter'];
                    $jampraktek = $ls['jampraktek'];
                    $kapasitas = $ls['kapasitas'];

                    $cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpegawaibpjsjadwal` WHERE `kdpuskesmas` = '$kdpuskesmas' AND `kodedokter` = '$kddokter' AND `kodepoli` = '$kdpoli'"));
                    if($cek == 0){
                        $str = "INSERT INTO `tbpegawaibpjsjadwal`(`kdpuskesmas`,`kodepoli`,`namadokter`,`kodedokter`,`jampraktek`,`kapasitas`) VALUES ('$kdpuskesmas','$kdpoli','$namadokter','$kddokter','$jampraktek','$kapasitas')";
                        mysqli_query($koneksi,$str);
                    }else{
                        $str = "UPDATE `tbpegawaibpjsjadwal` SET `jampraktek` = '$jampraktek', `kapasitas` = '$kapasitas' WHERE `kdpuskesmas` = '$kdpuskesmas' AND `kodedokter` = '$kddokter' AND `kodepoli` = '$kdpoli'";
                        mysqli_query($koneksi,$str);
                    }
                    
                }
            }
        }
    }
?>