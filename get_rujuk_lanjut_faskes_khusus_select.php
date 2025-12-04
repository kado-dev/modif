<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	include "config/helper_bpjs_v4.php";	

	
    $kdkhusus = $_POST['kdkhusus'];
    $subspesialis = $_POST['subspesialis'];
    $nokartubpjs = $_POST['nokartubpjs'];
    $tgl = date('d-m-Y',strtotime($_POST['tgl']));
    //if($_SESSION['koneksi_bpjs'] == 'Stabil'){
        $data_faskes = get_data_referensi_faskes_khusus($kdkhusus,$subspesialis,$tgl,$nokartubpjs);
        //echo $data_faskes;
        $dtfaskes = json_decode($data_faskes,True);	
        if($dtfaskes['metaData']['code'] == 500 || $dtfaskes['metaData']['code'] == 428 || $dtfaskes['metaData']['code'] == 401){
            $pesan = $dtfaskes['metaData']['message'];
            echo "<option value=''>".$pesan."</option>";
        }else{
        
            $list = $dtfaskes['response']['list'];
            if($list == ""){
                echo "<option value=''>Tidak ada rumah sakit yang sesuai poli</option>";
            }else{

                foreach($list as $ket){
                    echo "<option value='".$ket['kdppk']."'>".$ket['nmppk']." | ".$ket['kelas']." | ".$ket['jadwal']."</option>";
                    // echo "<tr class='pilihfaskes'>";
                    // echo "<td>".$no."</td>";
                    // echo "<td class='namappk'>".$ket['nmppk']."</td>";
                    // echo "<td>".$ket['kelas']."</td>";
                    // echo "<td>".$ket['nmkc']."</td>";
                    // echo "<td>".$ket['alamatPpk']."</td>";
                    // echo "<td>".$ket['telpPpk']."</td>";
                    // echo "<td>".$ket['distance']."</td>";
                    // echo "<td>".$ket['jmlRujuk']."</td>";
                    // echo "<td>".$ket['jadwal']."</td>";
                    // echo "<td><input type='radio' class='pilihradio' name='faskes' value='".$ket['kdppk']."'></td>";
                    // echo "</tr>";
                }
                
            }
        }
    //}
?>