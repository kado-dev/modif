<?php
error_reporting(0);
session_start();
include "config/koneksi.php";
include "config/helper_pasienrj.php";

if($kota == "KOTA TARAKAN"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}

$status = $_GET['status'];

if ($_POST['jenis_pio'] != null){
	$jenis_pio = implode(",", $_POST['jenis_pio']);	
}else{
	$jenis_pio = "";
}

// tbresep
$no = $_POST['id'];
$pelayanan = $_POST['ply'];
$status_user = $_POST['status_user'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rekam Medis Print</title>
		<style>
			body{
				background:#f5f5f5;
				font-family: "Arial Narrow", "Arial", "sans-serif";
			}
			.container{
				width:350px;
				margin:auto;
				background:#fff;
				padding:10px;
			}
			table{
				width: 350px;
				border: 1px solid #000;
				margin-top:-30px; 
				margin-bottom: 30px;
				margin-left: -2px;
				padding: 10px;
				font-size: 16px;
				font-family: "Arial Narrow", "Arial", "sans-serif";
			}
			.btn{
				position:relative;
				top:40px;
			}
			@media print{
				.btn{
					display:none;
				}
			}
		</style>
	</head>
	<?php
	if($status_user == 'dokter'){
	?>
	<body onload="window.print()" onafterprint="document.location='index.php?page=poli_periksa_print&id=<?php echo $no;?>&pelayanan=<?php echo $pelayanan;?>'">
	<?php
	}else{
	?>
	<body onload="window.print()" onafterprint="document.location='index.php?page=apotik'">
	<?php
	}
	?>	
		<div class="container">	
			<?php
				// tbpuskesmas
				$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio' where `NoResep`='$no'";
				$query=mysqli_query($koneksi,$str);
			
				$query_resep = mysqli_query($koneksi,"SELECT * FROM `$tbresep` WHERE `NoResep`='$no' AND `Pelayanan`='$pelayanan'");
				$data_resep = mysqli_fetch_assoc($query_resep);
				
				// tbdiagnosapasien
				$qrdata_kd_diagnosa = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$data_resep[NoResep]'");
				
				// pasien
				if (strlen($data_resep['NoIndex']) == 24){
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoIndex` = '$data_resep[NoIndex]'"));
					$noindex = $dt_pasien['NoIndex'];
				}else{
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoAsuransi` = '$data_resep[NoIndex]'"));
					$noindex = $dt_pasien['NoIndex'];
				}
				
				// tbkk
				$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE NoIndex='$noindex'"));
				if($dt_kk['Alamat'] != ''){
					$alamat_kk = $dt_kk['Alamat']." RT.".$dt_kk['RT']." RW.".$dt_kk['RW']."<br/> DESA/KEL.".strtoupper($dt_kk['Kelurahan']);
				}else{
					$alamat_kk = "Alamat Belum di Inputkan";
				}
				
				while($data_kd_diagnosa = mysqli_fetch_assoc($qrdata_kd_diagnosa)){
					$kode_diagnosa[] = $data_kd_diagnosa['KodeDiagnosa'];
					$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_kd_diagnosa[KodeDiagnosa]'"));
					$nama_diagnosa[] = $data_diagnosa['Diagnosa'];
				}
			?>
			<div style="text-align:center;padding-bottom:5px">
				<p style="font-size:18px; margin-top:-16px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></p>
				<p style="font-size:18px; margin-top:-16px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></p>
				<p style="font-size:12px; margin-top:-16px;"><?php echo $alamat?></p><hr/>
				<p style="font-size:18px; margin-top:5px;"><b>RESEP OBAT</b></p>
				<br/>
			</div>
			<table class="table" width="100%">
				<tr>	
					<td width="30%">Tanggal</td>
					<td width="5%">:</td>
					<td width="65%" colspan="2"><?php echo $data_resep['TanggalResep'];?></td>
				</tr>
				<tr>	
					<td>No.Resep</td>
					<td>:</td>
					<td><?php echo substr($data_resep['NoResep'],-10);?></td>
				</tr>
				<tr>	
					<td>Nama Pasien</td>
					<td>:</td>
					<td><?php echo $data_resep['NamaPasien'];?></td>
				</tr>
				<tr>	
					<td>Umur</td>
					<td>:</td>
					<td><?php echo $data_resep['UmurTahun']." Th ".$data_resep['UmurBulan']." Bl";?></td>
				</tr>
				<tr>	
					<td style="vertical-align: text-top;">Alamat</td>
					<td style="vertical-align: text-top;">:</td>
					<td style="vertical-align: text-top;"><?php echo $alamat_kk;?></td>
				</tr>
				<tr>
					<td>Poli</td>
					<td>:</td>
					<td><?php echo $data_resep['Pelayanan'];?></td>
				</tr>
				<tr>
					<td>Jaminan</td>
					<td>:</td>
					<td><?php echo $data_resep['StatusBayar'];?></td>
				</tr>
				<tr>	
					<td>Kd.Dgs</td>
					<td>:</td>
					<td><?php if($kode_diagnosa != null){echo implode($kode_diagnosa,", ");}else{echo "-";}?></td>
					
				</tr>
			</table>
			<table class="table" style="margin-top:-25px; width:100%;">
				<tr>
					<th width="75%" style="text-align:center;">Nama Obat</th>
					<th width="10%" style="text-align:center;">Jml</th>
					<th width="15%" style="text-align:center;" colspan="2">Signa</th>
				</tr>
				<?php
					$qresep = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$no'");						
					while($dtresep = mysqli_fetch_assoc($qresep)){
						$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang`='$dtresep[KodeBarang]'"));
						$no = $no + 1;
				?>
				<tr>
					<td style="font-size: 17px;"><?php echo $dtobat['NamaBarang']."<br/>Anjuran: (".$dtresep['AnjuranResep'].")";?></td>
					<td align="center" valign="top"><?php echo $dtresep['jumlahobat'];?></td>
					<td align="center" valign="top" colspan="2" style="margin-right:-10px;"><?php echo $dtresep['signa1'];?> x <?php echo $dtresep['signa2'];?></td>
				</tr>
				<?php } ?>
			</table>
			<table cellpadding="3px" class="table" style="margin-top:-25px; width:100%;">
				<tr>
					<td width="50%" style="text-align:center; padding-bottom: 30px;">Paraf Pasien</td>
					<td width="50%" style="text-align:center; padding-bottom: 30px;">Paraf Dokter</td>
				</tr>
				<tr>
					<td width="50%" style="text-align:center;"><?php echo $data_resep['NamaPasien'];?></td>
					<td width="50%" style="text-align:center;"><?php echo $data_resep['NamaPegawai'];?></td>
				</tr>
			</table>
			<div style="margin-top:-20px; text-align:center; width:100%; font-style:italic; font-weight:bold;">"Semoga Lekas Sembuh"</div>
			<a href="javascript:print()" class="btn btn-info noprint" style="width:100%; margin-top:-20px;">Print Resep</a>
		</div>
	</body>
</html>