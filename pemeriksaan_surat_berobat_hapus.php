<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper.php";
    include "config/helper_pasienrj.php";
    $idpasienrj  = $_GET['idrj']; 
    $idsurat = $_GET['idsurat'];      
    
    // tbsuratsakit
    $query = mysqli_query($koneksi, "DELETE FROM `$tbsuratberobat` WHERE `IdSuratBerobat` = '$idsurat'");

    if($query){
        alert_swal('sukses','Data berhasil dihapus');
        echo "<script>";
        echo "document.location.href='index.php?page=pemeriksaan_surat_berobat&idrj=$idpasienrj';";	
        echo "</script>";
    }else{
        alert_swal('gagal','Data gagal dihapus');
        echo "<script>";
        echo "document.location.href='index.php?page=pemeriksaan_surat_berobat&idrj=$idpasienrj';";
        echo "</script>";
    }
?>