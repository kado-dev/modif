<?php
session_start();
include "config/koneksi.php";
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);
$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
$tbresep = 'tbresep_'.str_replace(' ', '', $namapuskesmas);
$tbpoliumum = 'tbpoliumum_'.str_replace(' ', '', $namapuskesmas);
$idpasien = $_POST['idpasien'];
$noindex = $_POST['noindex'];
$nocm = $_POST['nocm'];
$tahun = $_POST['tahun'];
$orderby = $_POST['orderby'];
$key = $_POST['keys'];

// update tbpasien
$strpasien = "UPDATE `$tbpasien` SET `NoIndex`='$noindex' WHERE `IdPasien`='$idpasien'";
mysqli_query($koneksi, $strpasien);

// update tbdiagnosa
$strdiagnosa = "UPDATE `$tbdiagnosapasien` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'"; // harusnya idpasien, krndi ditabel blm ada sementara pakai nocm
mysqli_query($koneksi, $strdiagnosa);

// update tbresep
$strresep = "UPDATE `$tbresep` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'"; // harusnya idpasien, krndi ditabel blm ada sementara pakai nocm
mysqli_query($koneksi, $strresep);

// update tbpoli
$stranak = "UPDATE `tbpolianak` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $stranak);
$strgigi = "UPDATE `tbpoligigi` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strgigi);
$strgizi = "UPDATE `tbpoligizi` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strgizi);
$strimunisasi = "UPDATE `tbpoliimunisasi` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strimunisasi);
$strkb = "UPDATE `tbpolikb` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strkb);
$strkia = "UPDATE `tbpolikia` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strkia);
$strkiacatin = "UPDATE `tbpolikia_catin` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strkiacatin);
$strkianifas = "UPDATE `tbpolikia_nifas` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strkianifas);
$strkiapersalinan = "UPDATE `tbpolikia_persalinancatatan` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strkiapersalinan);
$strkir = "UPDATE `tbpolikir` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strkir);
$strlansia = "UPDATE `tbpolilansia` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strlansia);
$strmtbs = "UPDATE `tbpolimtbs` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strmtbs);
$strskd = "UPDATE `tbpoliskd` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strskd);
$strtb = "UPDATE `tbpolitb` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strtb);
$strtindakan = "UPDATE `tbpolitindakan` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strtindakan);
$strumum = "UPDATE `$tbpoliumum` SET `NoIndex`='$noindex' WHERE `NoCM`='$nocm'";
mysqli_query($koneksi, $strumum);

// update tbpasienrj
$strpasienrj = "UPDATE $tbpasienrj SET `NoIndex`='$noindex' WHERE `IdPasien`='$idpasien'";
$query = mysqli_query($koneksi, $strpasienrj);

if($query){
    echo "<script>";
    echo "alert('Data berhasil disimpan...');";
    echo "document.location.href='index.php?page=rm_bankdata&tahun=$tahun&orderby=$orderby&key=$key';";
    echo "</script>";
}else{
    echo "<script>";
    echo "alert('Data gagal disimpan...');";
    echo "document.location.href='index.php?page=rm_bankdata_detail&id=$idpasien';";
    echo "</script>";
} 	

?>