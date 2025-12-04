<?php
include "config/koneksi.php";
$klaster = $_POST['klaster'];
$siklus = $_POST['siklushidup'];

$getklaster = mysqli_query($koneksi,"SELECT Nama FROM `ref_siklushidup` WHERE Klaster = '$klaster'");
while($dtklaster = mysqli_fetch_assoc($getklaster)){
    $selected = "";
    if($siklus == $dtklaster['Nama']){
        $selected = "SELECTED";
    }

    echo "<option value='$dtklaster[Nama]' $selected>$dtklaster[Nama]</option>";
}
?>