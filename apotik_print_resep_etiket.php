<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
date_default_timezone_set('Asia/Jakarta');

//jangan dipindah keatas, nnti gak jalan waktunya
date_default_timezone_set('Asia/Jakarta');
$tgltime = date('Y-m-d G:i:s');;
$statusloket = $_GET['statusloket'];

// tbresep
$idpasienrj = $_GET['idprj'];
$status = $_GET['status'];
$jenis_pio = $_GET['jenis_pio'];
$jenis_telaah = $_GET['jenis_telaah'];
$norsp = $_GET['norsp'];
$noindex = $_GET['noidx'];
$pelayanan = $_GET['ply'];
$tenagafarmasi = $_GET['tenagafarmasi'];
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
				width:350px;
				margin:auto;
				background:#fff;
				padding:10px;
			}
			table{
				width:350px;
				border:1px solid #000;
				margin-bottom:30px;
				margin-left:-2px;
				padding:10px;
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
			@media print{
				.btn{
					display:none;
				}
			}
		</style>
	</head>
	
	<script src="assets/js/qrcode.min.js?4"></script>
	<!-- <body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>'"> -->
	<body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep&statusloket=LOKET OBAT'">
		<div class="container" style="margin-left: -10px;">	
			<?php
				// update status tbresep
				$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio', `Telaah`='$jenis_telaah', `NamaPegawai`='$tenagafarmasi' WHERE `NoResep`='$norsp'";
				$query=mysqli_query($koneksi,$str);
				
				// waktu diserahkan
				$cekwaktu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `WaktuPenyerahan` FROM `$tbresep` WHERE `NoResep`='$norsp'"));
				if($cekwaktu['WaktuPenyerahan'] == '0000-00-00 00:00:00'){
					$updatewaktu = "UPDATE `$tbresep` SET `WaktuPenyerahan`='$tgltime' WHERE `NoResep`='$norsp'";
					mysqli_query($koneksi,$updatewaktu);
				}	

			
			
				$query_resep = mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp' AND `NoIndex`='$noindex' AND `Pelayanan`='$pelayanan'");
				$data_resep = mysqli_fetch_assoc($query_resep);
				
				// pasienrj
				$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT JenisKelamin FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$data_resep[NoResep]'"));
				
				// tbkk
				$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kecamatan`,`Kota`,`Telepon` FROM `$tbkk` WHERE NoIndex='$data_resep[NoIndex]'"));
				
				// ec_subdistricts
				$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
				if($dt_subdis['subdis_name'] != ''){
					$kelurahan = $dt_subdis['subdis_name'];
				}else{
					$kelurahan = $datakk['Kelurahan'];
				}

				// ec_districts
				$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
				if($dt_dis['dis_name'] != ''){
					$kecamatan = $dt_dis['dis_name'];
				}else{
					$kecamatan = $datakk['Kecamatan'];
				}

				// ec_cities
				$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
				if($dt_citi['city_name'] != ''){
					$kota = $dt_citi['city_name'];
				}else{
					$kota = $datakk['Kota'];
				}

				if($datakk['Alamat'] != ''){
					$alamat_pasien = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota);
				}else{
					$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat FROM `$tbresep` WHERE NoResep='$data_resep[NoResep]'"));
					$alamat_pasien = $dtresep['Alamat'];
				}
			
				// tbdiagnosapasien
				$qrdata_kd_diagnosa = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$data_resep[IdPasienrj]'");
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
									<p style="font-size:14px; margin-top:2px;text-align:center;margin-bottom: 1px;">
										<b>DINAS KESEHATAN <?php echo $_SESSION['kota'];?></b><br/>
										<b><?php echo "PUSKESMAS ".$namapuskesmas;?></b>
									</p>
									<p style="font-size:10px; margin-top: 0px; text-align: center; margin-bottom: 10px"><?php echo $alamat;?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<b style="font-size:26px;">RESEP OBAT</b><br/>
						<b style="font-size:18px;"><?php echo "No.".substr($data_resep['NoResep'],-10);?></b><br/>
						<span style="font-size:18px;"><?php echo $data_resep['TanggalResep'];?></span>
					</td>
				</tr>
				<tr>	
					<td width="100%">
						<p>	
							<?php 
							echo "<span style='font-size: 18px; font-weight: bold;'>".$data_resep['NamaPasien'].", (".$dt_pasienrj['JenisKelamin'].")</span></br>";
							echo "(".$data_resep['UmurTahun']." Tahun ".$data_resep['UmurBulan']." Bulan)<br/>";
							echo $alamat_pasien."</br>";
							echo "Pelayanan, ".$data_resep['Pelayanan']."</br>";
							echo "Jaminan, ".$data_resep['StatusBayar']."</br>";
							// if($kodepuskesmas == "P3204270201" OR $kodepuskesmas == "P3204020201"){
								if($kode_diagnosa != null){
									echo "Diagnosa, ".implode(", ",$kode_diagnosa);
								}else{
									// jika tidak ditemukan maka cari di tbresep
									$koddgs = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `$tbresep` WHERE `NoResep`='$norsp'"));
									echo $koddgs['Diagnosa'];	
								}
							// }
							?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<tr>
								<th width="10%">RCK</th>
								<th width="65%">NAMA BARANG</th>
								<th width="10%">JML</th>
								<th width="15%">DOSIS</th>
							</tr>
							<?php
							// cek jika resep lebih dari 1 poli (Rujukan)
							if($idpasienrj == ''){
								$strresep = "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan' GROUP BY NoResep, KodeBarang";
							}else{
								$strresep = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' GROUP BY NoResep, KodeBarang";
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
									<?php echo strtoupper($dtobat['NamaBarang']);?><br/>
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
								<td valign="top" colspan="2" style="margin-right:-10px;"><?php echo $data['signa1'];?> x <?php echo $data['signa2'];?></td>
							</tr>
							<?php
							}
							?>		
							<tr>
								<td style="text-align:center; padding-top:15px; font-size: 13px;" colspan="4">Pemeriksa,</td>
							</tr>
							<tr>
								<?php 
									// tbpasienperpegawai
									$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
									
									$dtpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1` FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$norsp'"));
									$dtsip = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Sip` FROM `tbpegawai` WHERE `NamaPegawai`='$dtpegawai[NamaPegawai1]'"));
								?>
								<td style="text-align:center; padding-top:50px; font-weight: bold; font-size: 13px;" colspan="4">
								<div id="qrcode" style="padding:2px 0px; width: 60px;"></div>
								<?php 
									echo "<u>".$dtpegawai['NamaPegawai1']."</u><br/>".
									"SIP.".$dtsip['Sip'];
								?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table class="tables" style="margin-top:-25px; width:100%;">	
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
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Nama Obat" <?php if(in_array("Nama Obat", $arrpio)){echo "CHECKED";}?>> Nama Obat</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Sediaan" <?php if(in_array("Sediaan", $arrpio)){echo "CHECKED";}?>> Sediaan</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Dosis" <?php if(in_array("Dosis", $arrpio)){echo "CHECKED";}?>> Dosis</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Cara Pemakaian" <?php if(in_array("Cara Pemakaian", $arrpio)){echo "CHECKED";}?>> Cara Pemakaian</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Penyimpanan" <?php if(in_array("Penyimpanan", $arrpio)){echo "CHECKED";}?>> Penyimpanan</label><br/>
						</td>
					<td class="col-sm-6">
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Indikasi" <?php if(in_array("Indikasi", $arrpio)){echo "CHECKED";}?>> Indikasi</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Kontra Indikasi" <?php if(in_array("Kontra Indikasi", $arrpio)){echo "CHECKED";}?>> Kontra Indikasi</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Stabilitas" <?php if(in_array("Stabilitas", $arrpio)){echo "CHECKED";}?>> Stabilitas</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Efek Samping" <?php if(in_array("Efek Samping", $arrpio)){echo "CHECKED";}?>> Efek Samping</label><br/>
						<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Interaksi Obat" <?php if(in_array("Interaksi Obat", $arrpio)){echo "CHECKED";}?>> Interaksi Obat</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<b>TELAAH RESEP</b>
					</td>
				</tr>
				<tr>
					<td class="col-sm-6">
						<?php
							$arrtelaah = explode(",",$data_resep['Telaah']);
						?>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Nama Obat" <?php if(in_array("Kejelasan Penulisan Resep", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Jelas Penulisan Rsp</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Sediaan" <?php if(in_array("Tepat Obat", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Tepat Obat</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Dosis" <?php if(in_array("Tepat Dosis", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Tepat Dosis</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Cara Pakai" <?php if(in_array("Tepat Rute", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Tepat Rute</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Penyimpanan" <?php if(in_array("Tepat Waktu", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Tepat Waktu</label><br/>
					
					</td>
					<td class="col-sm-6">
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Indikasi" <?php if(in_array("Duplikasi", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Duplikasi</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Kontraindikasi" <?php if(in_array("Alergi", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Alergi</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Stabilitas" <?php if(in_array("Interaksi Obat", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Interaksi Obat</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Efek Samping" <?php if(in_array("Berat Badan (Anak)", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Berat Badan (Anak)</label><br/>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Interaksi" <?php if(in_array("KI Lainnya", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> KI Lainnya</label><br/>
					</td>
				</tr>
				<tr>
					<td width="50%" style="text-align:center; padding-top:15px;">Pasien,</td>
					<td width="50%" style="text-align:center; padding-top:15px;">Tenaga Farmasi,</td>
				</tr>
				<tr>
					<td width="50%" style="text-align:center; padding-top:50px; font-weight: bold;"><?php echo $data_resep['NamaPasien'];?></td>
					<td width="50%" style="text-align:center; padding-top:50px; font-weight: bold;"><?php echo $data_resep['NamaPegawai'];?></td>
				</tr>
			</table>
			<table class="tables" style="margin-top:-25px; width:100%;">	
				<tr>
					<td align="center" colspan="2">
						<b>MONITORING WAKTU PELAYANAN</b><br/>
						<?php echo "Resep Tiba, ".substr($data_resep['TanggalResep'],-8);?><br/>
						<?php echo "Resep Diserahkan, ".substr($data_resep['WaktuPenyerahan'],-8);?>
					</td>
				</tr>
			</table>
			<div style="margin-top:-20px; text-align:center; width:100%; font-style:italic; font-weight:bold;">"SEMOGA LEKAS SEMBUH"</div>
			
			<!--Etiket-->
			<?php
			if($idpasienrj == ''){
				$strresep = "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan' AND racikan = 'false' GROUP BY NoResep, KodeBarang";
			}else{
				$strresep = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND racikan = 'false' GROUP BY NoResep, KodeBarang";
			}
			$query = mysqli_query($koneksi,$strresep);
			while($data = mysqli_fetch_assoc($query)){
				$kdbrg = $data['KodeBarang'];
				$nobatch = $data['NoBatch'];
				
				// tbgudangpkmstok, jangan dari gfkstok
				$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`Expire` FROM `$tbapotikstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));
			?>
			<div style="border:0px;padding: 0px;width: 100%; border-bottom:2px dashed #000; margin: 15px 0px 15px 0px"></div>
			<table class="tables" style="font-family:Trebuchet MS; margin-top:0px;">
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<tr>
								<td width="15%">
									<img src="image/logo_puskesmas.png" width="50px">
								</td>
								<td>
									<p style="font-size:12px; font-family:Trebuchet MS; margin-top:2px;text-align:center;margin-bottom: 1px;">
										<b>DINAS KESEHATAN <?php echo $_SESSION['kota'];?></b><br/>
										<b><?php echo "PUSKESMAS ".$namapuskesmas;?></b>
									</p>
									<?php
										//sesion gak jalan, jadinya narik dari tbpuskesmas
										$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Apoteker`, `Sipa` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'"))
									?>
									<p style="font-size:10px; margin-top: 0px; text-align: center; margin-bottom: 10px"><?php echo $alamat;?></p>
									<p style="font-size:10px; margin-top: -10px; text-align: center; margin-bottom: 10px"><?php echo "Apoteker : ".$dtpuskesmas['Apoteker'];?></p>
									<p style="font-size:10px; margin-top: -10px; text-align: center; margin-bottom: 10px"><?php echo "SIPA : ".$dtpuskesmas['Sipa'];?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>					
					<td style="font-size:12px;">
						<?php echo $data_resep['TanggalResep'];?>
					</td>
					<td style="font-size:12px;text-align: right">
						<?php echo substr($data_resep['NoResep'],-10);?>
					</td>
				</tr>
				<tr>	
					<td colspan="2" style="font-size:14px;margin:2px;text-align:center;font-weight: bold"><br/>
						<?php echo $data_resep['NamaPasien'];?> -
						<?php echo $data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?><br/>
						<span style="font-size:14px; font-weight: normal;"><?php echo $alamat_pasien;?></span>
					</td>
				</tr>
					<?php 
						 if($data['racikan'] == 'false'){
					?>
					<tr>					
						<td colspan="2" style="font-size:16px;margin:2px;text-align:center;font-weight: bold">
							<?php echo "SEHARI ". $data['signa1'];?> x <?php echo $data['signa2'];?><br/>
							<?php echo strtoupper($data['AnjuranResep']);?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;margin:2px;text-align:left;">
							<?php echo $dtobat['NamaBarang'].", Jml : ".$data['jumlahobat']."<br/> ED : ".date('d-m-Y', strtotime($dtobat['Expire']));?>
						</td>
						</td>
					</tr>
				<tr>
					<td colspan="2">
						 <p style="font-size:12px;text-align: center">
						 	Semoga lekas sembuh
						 </p>
					</td>
				</tr>
			</table>
			<?php
				}
			}	
			
				if($idpasienrj == ''){
					$cekracikan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan' AND racikan = 'true' GROUP BY NoResep, KodeBarang"));
				}else{
					$cekracikan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$pelayanan' AND racikan = 'true' GROUP BY NoResep, KodeBarang"));
				}
				
				if($cekracikan > 0){
			?>
			<table class="tables" style="font-family:Trebuchet MS; margin-top:0px;">
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<tr>
								<td width="15%">
									<img src="image/logo_puskesmas.png" class="logopuskesmas" width="50px">
								</td>
								<td>
								<p style="font-size:10px; font-family:Trebuchet MS; margin-top:2px;text-align:center;margin-bottom: 1px;">
									<b>DINAS KESEHATAN <?php echo $_SESSION['kota'];?></b><br/>
									<b><?php echo "PUSKESMAS ".$namapuskesmas;?></b>
								</p>
								<p style="font-size:8px; font-family:Trebuchet MS; margin-top:0px;text-align:center;margin-bottom: 10px"><?php echo $alamat;?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>					
					<td style="font-size:12px;">
						<?php echo $data_resep['TanggalResep'];?>
					</td>
					<td style="font-size:12px;text-align: right">
						<?php echo substr($data_resep['NoResep'],-10);?>
					</td>
				</tr>
				<tr>	
					<td colspan="2" style="font-size:14px;margin:2px;text-align:center;font-weight: bold">
						<br/>
						<?php echo $data_resep['NamaPasien'];?> -
						<?php echo $data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?>
					</td>
				</tr>
						<?php
						if($idpasienrj == ''){
							$dtobatnon = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan' AND `racikan`='true' GROUP BY NoResep, KodeBarang");
						}else{
							$dtobatnon = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$pelayanan' AND `racikan`='true' GROUP BY NoResep, KodeBarang");
						}
						while($dtobatnons = mysqli_fetch_assoc($dtobatnon)){
							$kdbrgs = $dtobatnons['KodeBarang'];
							$nobatchs = $dtobatnons['NoBatch'];
							
							//tbgudangpkmstok, jangan dari gfkstok
							$dton = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NamaBarang FROM `$tbapotikstok` WHERE `KodeBarang`='$kdbrgs'"));
							?>
								<tr>
									<td style="font-size:12px;margin:2px;text-align:left;">
										<?php echo $dton['NamaBarang'];?>
									</td>
									<td style="font-size:12px;margin:2px;text-align:center;">
										-
									</td>
								</tr>
								<tr>					
									<td colspan="2" style="font-size:14px;margin:2px;text-align:center;font-weight: bold">
										<?php echo $dtobatnons['KeteranganRacikan'];?>
									</td>
								</tr>
							<?php
						}				 
					 ?>
				<tr>
					<td colspan="2">
						 <p style="font-size:12px;text-align: center">
							Semoga lekas sembuh
						 </p>
					</td>
				</tr>
			</table>
			<?php
				}
			?>			
		</div>	
	</body>

	<script src="assets/js/jquery-2.1.4.min.js"></script>
	<script src='https://code.responsivevoice.org/responsivevoice.js'></script>	
	<script>
		var qrcode = new QRCode(document.getElementById("qrcode"), {
			width : 60,
			height : 60
		});
		var elText = <?php echo $datarppergawai['TtePin'];?>;
		qrcode.makeCode(elText);
	</script>
</html>