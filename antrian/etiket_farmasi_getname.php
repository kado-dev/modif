<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
//session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$puskesmas = $_COOKIE['namapuskesmas2'];
$kota = $_COOKIE['kota2'];
$noantrian = $_POST['noantrian'];
$tbantrian_farmasi = "tbantrian_farmasi_".str_replace(' ', '', $puskesmas);
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
	
	
$getpasienrj = mysqli_query($koneksi, "SELECT `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama` FROM $tbpasienrj WHERE NoAntrianPoli = '$noantrian' AND `TanggalRegistrasi` = CURDATE()");
if(mysqli_num_rows($getpasienrj) > 0){
	$dtpsrj = mysqli_fetch_assoc($getpasienrj);
	$NoRegistrasi = $dtpsrj['NoRegistrasi'];
	$NamaPasien = $dtpsrj['NamaPasien'];
	$PoliPertama = $dtpsrj['PoliPertama'];

			
?>
			<table class="table">
				<tr>
					<td><span style="font-size:28px; font-weight:bold;"><?php echo $NoRegistrasi;?></span></td>
				</tr>
				<tr>
					<td><span style="font-size:28px; font-weight:bold;"><?php echo $NamaPasien;?></span></td>
				</tr>
				<tr>
					<td><span style="font-size:28px; font-weight:bold;"><?php echo $PoliPertama;?></span></td>
				</tr>
			</table>
			
<?php
}else{
?>
	<div class="alert alert-danger">
		<h4 align="center">Tidak ada data yang cocok!</h4>
	</div>
<?php
}
?>