<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);

// jangan dipindah keatas, nnti gak jalan waktunya
if($kota == "KOTA TARAKAN"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}
$tgltime = date('Y-m-d G:i:s');

// tbresep
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
$status = $_GET['status'];
$jenis_pio = $_GET['jenis_pio'];
$norsp = $_GET['norsp'];
$noindex = $_GET['noid'];
$pelayanan = $_GET['ply'];
$status_user = $_POST['status_user'];
$tenagafarmasi = $_GET['tenagafarmasi'];
$statusprint = $_GET['statusprint'];
$statusloket = $_GET['statusloket'];
$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
$key = $_GET['key'];
$statusdilayani = $_GET['statusdilayani'];

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
//update waktu farmasi akhir
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
			.container{
				width: 80%;
				// margin:auto;
				// background:#fff;
				// padding:10px;
			}
			table{
				width:390px;
				border:1px solid #000;
				margin-bottom:30px;
				margin-left:-15px;
				padding:10px;
				padding-left:30px;
			}
			td, p{
				font-size:16px;
			}
			.btn{
				position:relative;
				top:40px;
			}
			.tablehead{
				border:0px;padding: 0px;width: 100%;
				border-bottom:1px solid #000;margin-bottom: 5px
			}
			.tablebarang{
				border:0px;padding: 0px;width: 100%;
			}
			@media print{
				.btn{
					display:none;
				}
			}
		</style>
	</head>
	
	<!--<body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep_manual_lihat&status=&norsp=<?php echo $norsp;?>&statusloket=<?php echo $statusloket;?>'">-->
	<body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>&tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>&key=<?php echo $key;?>&statusdilayani=<?php echo $statusdilayani;?>">
		<div class="container">	
			<?php
			// buat kondisi cetak etiket
			if($statusprint == 'Etiket'){
				include "apotik_print_etiket.php";
			}else{	
				// update status tbresep
				$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio', `NamaPegawai`='$tenagafarmasi', `WaktuTiba`='$tgltime' WHERE `NoResep`='$norsp'";
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
			
				$query_resep = mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp' AND `NoIndex`='$noindex' AND `Pelayanan`='$pelayanan'");
				$data_resep = mysqli_fetch_assoc($query_resep);
				
				// tbdiagnosapasien
				$qrdata_kd_diagnosa = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$data_resep[NoResep]'");
				
				// pasien
				if (strlen($data_resep['NoIndex']) == 24){
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdPasien`,`NoIndex` FROM `$tbpasien` WHERE `NoIndex` = '$data_resep[NoIndex]'"));
					$noindex = $dt_pasien['NoIndex'];
				}else{
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdPasien`,`NoIndex` FROM `$tbpasien` WHERE `NoAsuransi` = '$data_resep[NoIndex]'"));
					$noindex = $dt_pasien['NoIndex'];
				}
				
				// tbkk
				$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT` FROM `$tbkk` WHERE `NoIndex` = '$data_resep[NoIndex]'"));
				if($dt_kk['Alamat'] != ''){
					$alamat_kk = $dt_kk['Alamat']." RT.".$dt_kk['RT'];
				}else{
					$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat` FROM `$tbresep` WHERE `NoResep` = '$data_resep[NoResep]'"));
					$alamat_kk = $dtresep['Alamat'];
				}
				
				while($data_kd_diagnosa = mysqli_fetch_assoc($qrdata_kd_diagnosa)){
					$kode_diagnosa[] = $data_kd_diagnosa['KodeDiagnosa'];
					
					// tbdiagnosabpjs
					$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_kd_diagnosa[KodeDiagnosa]'"));
					$nama_diagnosa[] = $data_diagnosa['Diagnosa'];
				}
			?>
			<table style="margin-top:0px;">
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<tr>
								<td width="15%">
									<img src="image/logo_puskesmas.png" width="50px">
								</td>
								<td>
									<p style="font-size:18px; margin-top:2px;text-align:center;margin-bottom: 1px;">
										<b>DINAS KESEHATAN <?php echo $_SESSION['kota'];?></b><br/>
										<b><?php echo "PUSKESMAS ".$namapuskesmas;?></b>
									</p>
									<p style="font-size:16px; margin-top: 0px; text-align: center; margin-bottom: 10px"><?php echo $alamat;?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<b style="font-size:26px;">RESEP OBAT</b><br/>
						<b style="font-size:18px;"><?php echo "No.".substr($data_resep['NoResep'],-10);?></b><br/>
						<!--<b style="font-size:18px;"><?php // echo $data_resep['TanggalResep'];?></b>-->
					</td>
				</tr>
				<tr>
					<td width="100%">
						<p>	
							<?php 
							// tbpasienperpegawai
							$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
							$dtpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$norsp'"));
						
							echo "<span style='font-size: 22px; font-weight: bold;'>".strtoupper($data_resep['NamaPasien'])."</span></br>";
							echo "<span style='font-size: 18px;'>"."(".$data_resep['UmurTahun']." Tahun ".$data_resep['UmurBulan']." Bulan)</span><br/>";
							echo "<span style='font-size: 18px;'>".strtoupper($alamat_kk)."</span></br>";
							echo "<span style='font-size: 18px;'>"."CARA BAYAR, ".$data_resep['StatusBayar']."</span></br>";
							if($dtpegawai['NamaPegawai1'] != ""){ 
								$pemeriksa = "PEMERIKSA, ".$dtpegawai['NamaPegawai1']; 
							}else{ 
								$pemeriksa = "PEMERIKSA, ".$dtpegawai['NamaPegawai2'];
							}
							echo "<span style='font-size: 18px; font-weight: bold;'>".$pemeriksa."</span></br>";
														
							// tbdiagnosa
							$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$norsp' GROUP BY `KodeDiagnosa`");
							while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
								$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
								$array_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa']; // ."-".$data_diagnosa['Diagnosa']
							}
							
							if ($array_diagnosa[$no] != ''){
								$data_dgs = implode(", ", $array_diagnosa[$no]);
							}else{
								$data_dgs ="";
							}
							echo "<span style='font-size: 18px;'>"."DIAGNOSA, ".strtoupper($data_dgs)."</span></br>";

							//vital sign
							$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasien`='$dt_pasien[IdPasien]' ORDER BY IdVitalSign DESC LIMIT 1";
							$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							$dtsistole = $dtvs['Sistole'];
							$dtdiastole = $dtvs['Diastole'];
							$dtsuhutubuh = $dtvs['SuhuTubuh'];
							$dttinggiBadan = $dtvs['TinggiBadan'];
							$dtberatBadan = $dtvs['BeratBadan'];
							$dtheartRate = $dtvs['HeartRate'];
							$dtrespRate = $dtvs['RespiratoryRate'];
							$dtLingkarPerut = $dtvs['LingkarPerut'];
							$imt = $dtvs['IMT'];

							echo "BB: ".($dtberatBadan).", TB: ".($dttinggiBadan)."</br>";
							?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">						
						<table class="tablebarang" style="margin-top: 0px;">
							<tr>
								<th width="10%">RCK</th>
								<th width="65%">NAMA BARANG</th>
								<th width="10%">JML</th>
								<th width="15%">DOSIS</th>
							</tr>
							<?php
							// cek jika resep lebih dari 1 poli (Rujukan)
							$cekrsp = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp'"));
							if($cekrsp > 1){
								$strresep = "SELECT * FROM `$tbresepdetail` WHERE NoResep='$norsp' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang";
							}else{
								$strresep = "SELECT * FROM `$tbresepdetail` WHERE NoResep='$norsp' AND DATE(TanggalResep) IS NOT NULL  AND `Pelayanan`='$pelayanan' GROUP BY NoResep, KodeBarang";
							}
							
							$query = mysqli_query($koneksi,$strresep);
							while($data = mysqli_fetch_assoc($query)){
								$kdbrg = $data['KodeBarang'];
								$nobatch = $data['NoBatch'];
								
								// tbapotikstok, jangan dari gfkstok bedakan dengan kode puskesmas dan jangan dari tbgudangpkmstok
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang`='$kdbrg'"));
							?>
							<tr>
								<td>
									<?php
										if($data['racikan'] == 'true'){
											echo "YA";
										}else{
											echo "TDK";
										}
									?>
								</td>
								<td>
									<?php echo "R/ ".strtoupper($dtobat['NamaBarang']);?><br/>
									<?php
										if($data['racikan'] == 'true'){
											echo $data['KeteranganRacikan'];
										}else{
											if($data['AnjuranResep'] != '-'){
												echo "Anjuran : ".$data['AnjuranResep'];
											}	
										}
									?>
								</td>
								<td valign="top"><?php echo $data['jumlahobat'];?></td>
								<td valign="top" colspan="2" style="margin-right:-10px;">
									<?php 
										if($data['racikan'] == 'true'){
											echo "";
										}else{
											echo $data['signa1']." x ".$data['signa2'];
										}
									?>
								</td>
							</tr>
							<?php
							}
							?>		
						</table>
					</td>
				</tr>
			</table>
			<table class="tables" style="margin-top:-25px;" width="100%">	
				<tr>
					<td colspan="2" align="center">
						<b>PELAYANAN INFORMASI OBAT</b>
					</td>	
				</tr>
				<tr>
					<td class="col-sm-6">
						<?php
							$arrpio = explode(",",$data_resep['Pio']);
						?>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Nama Obat" <?php if(in_array("Nama Obat", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Nama Obat</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Sediaan" <?php if(in_array("Sediaan", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Sediaan</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Dosis" <?php if(in_array("Dosis", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Dosis</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Cara Pakai" <?php if(in_array("Cara Pakai", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Cara Pakai</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Penyimpanan" <?php if(in_array("Penyimpanan", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Penyimpanan</label><br/>
					
					</td>
					<td class="col-sm-6">
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Indikasi" <?php if(in_array("Indikasi", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Indikasi</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Kontraindikasi" <?php if(in_array("Kontraindikasi", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Kontraindikasi</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Stabilitas" <?php if(in_array("Stabilitas", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Stabilitas</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Efek Samping" <?php if(in_array("Efek Samping", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Efek Samping</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Interaksi" <?php if(in_array("Interaksi", $arrpio) || $data_resep['Pio'] == ''){echo "CHECKED";}?>> Interaksi</label><br/>
					</td>
				</tr>
				<tr>
					<td width="40%" style="text-align:center; padding-top:15px;">Pasien,</td>
					<td width="60%" style="text-align:center; padding-top:15px;">Tenaga Farmasi,</td>
				</tr>
				<tr>
					<td width="40%" style="text-align:center; padding-top:50px; font-weight: bold;"><?php echo $data_resep['NamaPasien'];?></td>
					<td width="60%" style="text-align:center; padding-top:50px; font-weight: bold;"><?php echo $_SESSION['nama_petugas'];?></td>
				</tr>
			</table>
			<table class="tables" style="margin-top:-25px;">	
				<tr>
					<td align="center" colspan="2">
						<b>MONITORING WAKTU PELAYANAN</b><br/>
						<?php echo "Resep Tiba, ".$data_resep['WaktuTiba'];?><br/>
						<?php echo "Resep Diserahkan, ";?> <!--.substr($data_resep['WaktuPenyerahan'],-8)-->
					</td>
				</tr>
			</table>
			<?php		
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