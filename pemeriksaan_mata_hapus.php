<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper.php";
    include "config/helper_pasienrj.php";

    $idpasienrj  = $_GET['idrj']; 
    $idpsn = $_GET['idpsn'];    
    
    // tbsuratmata
    $query = mysqli_query($koneksi, "DELETE FROM `tbsuratmata` WHERE `IdPasienrj` = '$idpasienrj'");

    if($query){
        alert_swal('sukses','Data berhasil dihapus');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa&newpage=pemeriksaan_mata&idpsn=$idpsn&idrj=$idpasienrj&pelayanan=';";	
        echo "</script>";
    }else{
        alert_swal('gagal','Data gagal dihapus');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa&newpage=pemeriksaan_mata&idpsn=$idpsn&idrj=$idpasienrj&pelayanan=';";
        echo "</script>";
    }
?>