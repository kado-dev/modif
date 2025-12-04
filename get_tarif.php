<?php
include "config/koneksi.php";
$jenis = $_POST['jenis'];
if($jenis){
    $query = mysqli_query($koneksi, "SELECT * FROM `tbpelayanankesehatan` where `Pelayanan`='$jenis'");
    if(mysqli_num_rows($query) > 0){       
        $data = mysqli_fetch_assoc($query);
        echo $data['Tarif'];
    }else{
        echo "0";
    }
}else{
    echo "0";
}
?>