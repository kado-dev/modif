<?php
	date_default_timezone_set('Asia/Jakarta');
	error_reporting(0);
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";

    

    $idpasien = $_POST['idpasien'];
	$ttd = $_POST['ttd'];
	$poin_ref = $_POST['poin_ref'];
	$nm_png = $_POST['nm_png'];
	$nik_png = $_POST['nik_png'];
    

    $cek_table = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbtte` WHERE IdPasien = '$idpasien'"));
	
	if($cek_table == 0){
        $x = mysqli_query($koneksi,"INSERT INTO `$tbtte`(`IdTbtte`, `IdPasien`, `Tte`) VALUES (null,'$idpasien','$ttd')");

        //simpan general konsen per puskesmas
        mysqli_query($koneksi,"INSERT INTO `$tbgeneralkonsen`(`IdGenkonsen`, `IdPasien`, `nama_penanggungjawab`, `nik_penanggungjawab`) VALUES (null,'$idpasien','$nm_png','$nik_png')");
        $idgenkonsen = mysqli_insert_id($koneksi);

        //get general konsen ref
        // $getGkref = mysqli_query($koneksi,"SELECT * FROM `ref_general_konsen` ORDER BY IdgeneralkonsenRef ASC");

        // while($n = mysqli_fetch_array($getGkref)){
        //     $idgenkonsenref = $n['IdgeneralkonsenRef'];
        foreach($poin_ref as $idgenkonsenref){    
            mysqli_query($koneksi,"INSERT INTO `$tbgeneralkonsen_detail`(`IdGenkonsen`, `IdgeneralkonsenRef`, `status_persetujuan`) VALUES ('$idgenkonsen','$idgenkonsenref','ya')");
        }
    }else{
        $x =  mysqli_query($koneksi,"UPDATE `$tbtte` SET `Tte` = '$ttd' WHERE IdPasien = '$idpasien'");
    }

    if($x){
        echo "sukses";
    }else{
        echo "gagal";
    }
?>