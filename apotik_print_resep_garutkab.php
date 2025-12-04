<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
date_default_timezone_set('Asia/Jakarta');

//jangan dipindah keatas, nnti gak jalan waktunya
date_default_timezone_set('Asia/Jakarta');
$tgltime = date('Y-m-d G:i:s');;

// tbresep
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
$status = $_GET['status'];
$jenis_pio = $_GET['jenis_pio'];
$norsp = $_GET['norsp'];
$pelayanan = $_GET['ply'];
$status_user = $_POST['status_user'];
$tenagafarmasi = $_GET['tenagafarmasi'];
$statusprint = $_GET['statusprint'];
$statuskonseling = $_GET['statuskonseling'];
$statusloket = $_GET['statusloket'];

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
// update waktu farmasi akhir
mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `FarmasiAkhir`=NOW() WHERE `NoRegistrasi` = '$norsp'");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Resep Obat</title>
		<style>
			body{
				background:#f5f5f5;
				font-family:calibri;
			}
			.page{
				width: 13.1cm;
				padding: 0.6cm;
				margin-top:20px;
				// border:1px solid #000;
				// margin: -20cm auto;
			    // border: 1px #D3D3D3 solid;
			    // border-radius: 5px;
			    // box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			}
			table{
				margin-top: -20px;
				width: 100%;
			}
			.tablehead{
				border: 0px; padding: 0px; width: 100%;
				border-bottom: 1px solid #000; margin-bottom: 0px;
			}
		</style>
	</head>
	
	<body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&norsp=<?php echo $norsp;?>&statusloket=<?php echo $statusloket;?>'">
		<div class="page">
			<?php
			// buat kondisi cetak etiket
			if($statusprint == 'Etiket'){
				include "apotik_print_etiket.php";
			}elseif($statusprint == 'Resep dan Etiket'){
				include "apotik_print_resep_etiket.php";
				die();				
			}else{	
				// update status tbresep
				$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio', `StatusKonseling`='$statuskonseling', `NamaPegawai`='$tenagafarmasi' WHERE `NoResep`='$norsp'";
				$query=mysqli_query($koneksi,$str);
				
				// waktu diserahkan
				$cekwaktu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `WaktuPenyerahan` FROM `$tbresep` WHERE `NoResep`='$norsp'"));
				if($cekwaktu['WaktuPenyerahan'] == '0000-00-00 00:00:00'){
					$updatewaktu = "UPDATE `$tbresep` SET `WaktuPenyerahan`='$tgltime' WHERE `NoResep`='$norsp'";
					mysqli_query($koneksi,$updatewaktu);
				}	

				$tbpasienperpegawai = 'tbpasienperpegawai_'.substr($norsp,14,2);
				$str_pgw = "UPDATE `$tbpasienperpegawai` SET `Farmasi` = '$tenagafarmasi' WHERE `NoRegistrasi` = '$norsp'";
				mysqli_query($koneksi,$str_pgw);
			
				$query_resep = mysqli_query($koneksi,"SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan'");
				$data_resep = mysqli_fetch_assoc($query_resep);
				
				// tbdiagnosapasien
				$qrdata_kd_diagnosa = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$data_resep[NoResep]'");
				
				// pasien
				if (strlen($data_resep['NoIndex']) == 24){
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoIndex` = '$data_resep[NoIndex]'"));
					$noindex = $dt_pasien['NoIndex'];
				}else{
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$data_resep[NoIndex]'"));
					$noindex = $dt_pasien['NoIndex'];
				}
				
				// tbkk
				$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE NoIndex='$noindex'"));
				if($dt_kk['Alamat'] != ''){
					$alamat_kk = $dt_kk['Alamat']." RT.".$dt_kk['RT'].", DS/KEL.".$dt_kk['Kelurahan'];
				}else{
					$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat FROM `$tbresep` WHERE NoResep='$data_resep[NoResep]'"));
					$alamat_kk = $dtresep['Alamat'];
				}
				
				// tbdiagnosabpjs
				while($data_kd_diagnosa = mysqli_fetch_assoc($qrdata_kd_diagnosa)){
					$kode_diagnosa[] = $data_kd_diagnosa['KodeDiagnosa'];
					$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_kd_diagnosa[KodeDiagnosa]'"));
					$nama_diagnosa[] = $data_diagnosa['Diagnosa'];
				}
			?>
			<table width="100%">
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<tr>
								<td width="15%">
									<img src="image/logo_puskesmas_noshadow.png" width="55px" style="margin-top: 20px;">
								</td>
								<td>
									<p style="font-size: 18px; text-align: center; margin-bottom: 1px;">
										<b>DINAS KESEHATAN <?php echo $_SESSION['kota'];?></b><br/>
										<b><?php echo "PUSKESMAS ".$namapuskesmas;?></b>
									</p>
									<p style="font-size:12px; margin-top: 0px; text-align: center; margin-bottom: 10px"><?php echo $alamat;?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>					
					<td><?php echo "No.".substr($data_resep['NoResep'],-10);?></td>
					<td style="text-align: right;"><?php echo $data_resep['TanggalResep'];?></td>
				</tr>
			</table>
			<table width="100%" style="margin-top: 10px;">
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<?php
							// cek jika resep lebih dari 1 poli (Rujukan)
							$cekrsp = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp'"));
							if($cekrsp > 1){
								$strresep = "SELECT * FROM `$tbresepdetail` WHERE NoResep='$norsp' GROUP BY NoResep, KodeBarang";
							}else{
								$strresep = "SELECT * FROM `$tbresepdetail` WHERE NoResep='$norsp' AND `Pelayanan`='$pelayanan' GROUP BY NoResep, KodeBarang";
							}
							
							$query = mysqli_query($koneksi,$strresep);
							while($data = mysqli_fetch_assoc($query)){
								$kdbrg = $data['KodeBarang'];
								$nobatch = $data['NoBatch'];
								
								// tbapotikstok, jangan dari gfkstok bedakan dengan kode puskesmas dan jangan dari tbgudangpkmstok
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbapotikstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas'"));
							?>
							<tr>
								<span><b>R/ </b><?php echo $dtobat['NamaBarang'].", No. ".$data['jumlahobat'];?></span><br/>
								<span style="margin-left: 20px;"><?php echo $data['signa1']." x ".$data['signa2'].", ".$data['AnjuranResep']?></span><br/>
							</tr>
							<p style="border-bottom:1px solid #000;margin: 5px"></p>
							<?php
							}
							?>	
							<tr>
								<td width="50%" style="text-align:center; padding-top:15px;"></td>
								<td width="50%" style="text-align:center; padding-top:15px;">Dokter yang membuat resep,</td>
							</tr>
							<tr>
								<td width="50%" style="text-align:center; padding-top:50px; font-weight: bold;"></td>
								<td width="50%" style="text-align:center; padding-top:50px; font-weight: bold;">
								<?php 
									// tbpasienperpegawai
									$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
									$dtpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1` FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$norsp'"));
									echo $dtpegawai['NamaPegawai1'];
								?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>	
			<table width="100%" style="margin-top: 0px;">
				<tr>
					<table class="tablehead">
						<!--<td width="25%">
							<p>	<div id="qrcode" style="padding:0px 0px 0px 10px; width: 100px; margin:auto"></div></p>
						</td>-->
							<tr>
								<td width="50%" style="text-align:left; padding-top:15px;">
								<?php 
									echo "<span style='font-size: 18px; font-weight: bold;'>".$data_resep['NamaPasien'].", </span>"."(".$data_resep['UmurTahun']." Th ".$data_resep['UmurBulan']." Bl), ".$data_resep['Pelayanan']."</br>";
									echo $alamat_kk."</br>";
									echo "ASURANSI : ".$data_resep['StatusBayar']."</br>";
									
								?>
								</td>
							</tr>
					</table>
				</tr>
			</table>
			<table  style="margin-top: 0px;">	
				<tr>
					<td colspan="2" align="left" style="font-size: 18px; font-weight: bold;">INFORMASI PENGGUNAAN OBAT</td>	
				</tr>
				<tr>
					<td class="col-sm-6">
						<?php
							$arrpio = explode(",",$data_resep['Pio']);
						?>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Jenis dan Kegunaan Obat" <?php if(in_array("Jenis dan Kegunaan Obat", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Jenis dan Kegunaan Obat</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Cara Penggunaan Obat" <?php if(in_array("Cara Penggunaan Obat", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Cara Penggunaan Obat</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Frekuensi Penggunaan Obat" <?php if(in_array("Frekuensi Penggunaan Obat", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Frekuensi Penggunaan Obat</label><br/>
						</td>
					<td class="col-sm-6">
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Waktu Penggunaan Obat" <?php if(in_array("Waktu Penggunaan Obat", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Waktu Penggunaan Obat</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Efek Samping Penggunaan Obat" <?php if(in_array("Efek Samping Penggunaan Obat", $arrpio) ){echo "CHECKED";}?>> Efek Samping Penggunaan Obat</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Cara Penyimpanan Obat diRumah" <?php if(in_array("Cara Penyimpanan Obat diRumah", $arrpio) ){echo "CHECKED";}?>> Cara Penyimpanan Obat diRumah</label><br/>
					</td>
				</tr>
				<tr>
					<td width="50%" style="text-align:center; padding-top:15px;">Yang menerima obat,</td>
					<td width="50%" style="text-align:center; padding-top:15px;">Yang menyerahkan obat,</td>
				</tr>
				<tr>
					<td width="50%" style="text-align:center; padding-top:40px; font-weight: bold;"><?php echo $data_resep['NamaPasien'];?></td>
					<td width="50%" style="text-align:center; padding-top:40px; font-weight: bold;"><?php echo $data_resep['NamaPegawai'];?></td>
				</tr>
			</table><?php		
			}	
			?>
		</div>	
	</body>
	<script src="assets/js/qrcode.min.js"></script>
	<script type="text/javascript">   
		var qrcode = new QRCode(document.getElementById("qrcode"), {
		  width : 80,
		  height : 80
		});
		var elText = "<?php echo $data_resep['NoResep'];?>";
		qrcode.makeCode(elText);
		window.print();
    </script>
</html>