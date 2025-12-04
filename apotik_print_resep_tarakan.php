<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
include "config/helper.php";
$kota = $_SESSION['kota'];

// jangan dipindah keatas, nnti gak jalan waktunya
if($kota == "KOTA TARAKAN"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}
$tgltime = date('Y-m-d G:i:s');;

// tbresep
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
$status = $_GET['status'];
$jenis_pio = $_GET['jenis_pio'];
$jenis_telaah = $_GET['jenis_telaah'];
$norsp = $_GET['norsp'];
$noindex = $_GET['noid'];
$pelayanan = $_GET['ply'];
$status_user = $_POST['status_user'];
$tenagafarmasi = $_GET['tenagafarmasi'];
$statusprint = $_GET['statusprint'];
$statuskonseling = $_GET['statuskonseling'];
$statusloket = $_GET['statusloket'];
$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
$key = $_GET['key'];
$statusdilayani = $_GET['statusdilayani'];

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
// update waktu farmasi akhir
mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `FarmasiAkhir`=NOW() WHERE `NoRegistrasi` = '$norsp'");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>e-Resep</title>
		<style>
			body{
				background:#f5f5f5;
				font-family:calibri;
			}
			.page{
				width: 13.1cm;
				padding: 0.6cm;
				margin-top:20px;
				/* border:1px solid #000;
				margin: -20cm auto;
			    border: 1px #D3D3D3 solid;
			    border-radius: 5px;
			    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/
			}
			table{
				margin-top: -20px;
				width: 100%;
			}
			.tablehead{
				border-bottom: 1px solid #000; margin-bottom: 0px;
			}
		</style>
	</head>
	
	<body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>&tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>&key=<?php echo $key;?>&statusdilayani=<?php echo $statusdilayani;?>'">
		<div class="page">
			<?php
			// buat kondisi cetak etiket
			if($statusprint == 'Etiket'){
				include "apotik_print_etiket.php";
			}elseif($statusprint == 'Resep Thermal'){
				// update status tbresep
				$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio', `Telaah`='$jenis_telaah', `StatusKonseling`='$statuskonseling', `NamaPegawai`='$tenagafarmasi' WHERE `NoResep`='$norsp'";
				$query=mysqli_query($koneksi,$str);				
				include "apotik_print_resep_tarakan_thermal.php";
				die();				
			}else{	
				// update status tbresep
				$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio', `Telaah`='$jenis_telaah', `StatusKonseling`='$statuskonseling', `NamaPegawai`='$tenagafarmasi' WHERE `NoResep`='$norsp'";
				$query=mysqli_query($koneksi,$str);
				
				// waktu diserahkan
				$cekwaktu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `WaktuPenyerahan` FROM `$tbresep` WHERE `NoResep`='$norsp'"));
				$updatewaktu = "UPDATE `$tbresep` SET `WaktuPenyerahan`='$tgltime' WHERE `NoResep`='$norsp'";
				mysqli_query($koneksi,$updatewaktu);

				$str_pgw = "UPDATE `$tbpasienperpegawai` SET `Farmasi` = '$tenagafarmasi' WHERE `NoRegistrasi` = '$norsp'";
				mysqli_query($koneksi,$str_pgw);
			
				$query_resep = mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan'");
				$data_resep = mysqli_fetch_assoc($query_resep);
								
				// pasien
				$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdPasien`,`NoIndex`,`TanggalLahir`,`Telpon` FROM `$tbpasien` WHERE `NoCM` = '$data_resep[NoCM]'"));
				$noindex = $dt_pasien['NoIndex'];				
				
				// tbkk
				$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`RW`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex`='$data_resep[NoIndex]'"));
				if($dtkk['Alamat'] != ''){
					$alamat_kk = $dtkk['Alamat']." RT.".$dtkk['RT'].", ".$dtkk['Kelurahan'];
				}else{
					$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat FROM `$tbresep` WHERE NoResep='$data_resep[NoResep]'"));
					$alamat_kk = $dtresep['Alamat'];
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
									<p style="font-size:14px; margin-top: 0px; text-align: center; margin-bottom: 10px"><?php echo $alamat;?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>					
					<td><?php echo "No.Resep : ".substr($data_resep['NoResep'],-10);?></td>
					<td style="text-align: right;">
						<?php 
							
							echo "Waktu Print : ".hari_ini(date('D')).", ".date('d-m-Y g:i:s', strtotime($data_resep['WaktuPenyerahan']));
						?>
					</td>
				</tr>
			</table>
			<table width="100%" style="margin-top: 10px;">
				<tr>
					<td colspan="2">						
						<table>
							<?php
							// cek jika resep lebih dari 1 poli (Rujukan)
							$cekrsp = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp'"));
							$strresep = "SELECT * FROM `$tbresepdetail` WHERE NoResep='$norsp'";
							// echo $strresep;
							
							$query = mysqli_query($koneksi,$strresep);
							while($data = mysqli_fetch_assoc($query)){
								$kdbrg = $data['KodeBarang'];
								$nobatch = $data['NoBatch'];
								
								// tbapotikstok, jangan dari gfkstok bedakan dengan kode puskesmas dan jangan dari tbgudangpkmstok
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang`='$kdbrg'"));
							?>
							<tr>
								<span><b>R/ </b><?php echo $dtobat['NamaBarang'].", No. ".$data['jumlahobat'];?></span><br/>
								<?php 
									if($data['racikan'] == 'true'){
										echo $data['KeteranganRacikan'];
									}else{
								?>
								<span style="margin-left: 20px;"><?php echo $data['signa1']." x ".$data['signa2'].", ".$data['AnjuranResep']?></span><br/>
								<?php 								
									}
								?>
							</tr><hr/>
							<!--<p style="border-bottom:1px solid #000;margin: 5px"></p>-->
							<?php
							}
							?>	
						</table>
					</td>
				</tr>
			</table>	
			<table width="100%" style="margin-top: 10px;">
				<tr>
					<table class="tablehead">
						<!--<td width="25%">
							<p>	<div id="qrcode" style="padding:0px 0px 0px 10px; width: 100px; margin:auto"></div></p>
						</td>-->
							<tr>
								<td width="50%" style="text-align:left; padding-top:15px;">
								<?php 
									if($data_resep['Pelayanan'] == "POLI UMUM" OR $data_resep['Pelayanan'] == "POLI GIGI" OR $data_resep['Pelayanan'] == "POLI KIA" OR $data_resep['Pelayanan'] == "POLI LANSIA" OR $data_resep['Pelayanan'] == "POLI MTBS"){
										// $tbpoli = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
										$tbpoli = "tb".str_replace(' ', '',strtolower($data_resep['Pelayanan']))."_".str_replace(' ', '', $namapuskesmas);
									}else{
										$tbpoli = "tb".str_replace(' ', '',strtolower($data_resep['Pelayanan']));
									}
									
									// pemeriksa
									$dataresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoli` WHERE `NoPemeriksaan` = '$norsp'"));
									if($dataresep['NamaPegawaiSimpan'] != ''){
										$pemeriksa = $dataresep['NamaPegawaiSimpan'];
									}else{
										$pemeriksa =  $dataresep['NamaPegawaiEdit'];
									}	
									
									// tbdiagnosa
									$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$data_resep[NoResep]'");//GROUP BY `KodeDiagnosa`
									while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
										$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
										$array_diagnosa[$no][] = $data_diagnosa['Diagnosa'];
									}
									
									if ($array_diagnosa[$no] != ''){
										$data_dgs = implode(", ", $array_diagnosa[$no]);
									}else{
										$data_dgs ="";
									}
																											
									echo "<span style='font-size: 18px; font-weight: bold;'>".$data_resep['NamaPasien'].", </span>".
									"(".$data_resep['UmurTahun']." Th ".$data_resep['UmurBulan']." Bl) TGL.LAHIR : ".date('d-m-Y', strtotime($dt_pasien['TanggalLahir']))."</br>";
									echo strtoupper($alamat_kk)."</br>";
									if($dtkk['Telepon'] != ''){
										echo "Telp. ".$dtkk['Telepon']."</br>";
									}else{
										if($dt_pasien['Telpon'] != ''){
											echo "Telp. ".$dt_pasien['Telpon']."</br>";
										}else{
											echo "<span style='color:red;font-weight:bold'>Telp : Belum Diinputkan</span><br/>";
										}	
									}	
									if($namapuskesmas != "JUATA"){
									echo "CARA BAYAR, ".$data_resep['StatusBayar']."</br>";
									echo "PELAYANAN, ".$data_resep['Pelayanan']."</br>";
									}
									echo "PEMERIKSA, ".$pemeriksa."</br>";
									echo "DIAGNOSA, ".strtoupper($data_dgs)."</br>";

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
					<td colspan="2" align="left" style="font-size: 18px; font-weight: bold;">TELAAH RESEP</td>	
				</tr>
				<tr>
					<td class="col-sm-6">
						<?php
							$arrtelaah = explode(",",$data_resep['Telaah']);
						?>
						<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Nama Obat" <?php if(in_array("Kejelasan Penulisan Resep", $arrtelaah) || $data_resep['Telaah'] == ''){echo "CHECKED";}?>> Kejelasan Penulisan Resep</label><br/>
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
					<td width="50%" style="text-align:center; padding-top:15px;">Yang menerima obat,</td>
					<td width="50%" style="text-align:center; padding-top:15px;">Yang menyerahkan obat,</td>
				</tr>
				<tr>
					<td width="50%" style="text-align:center; padding-top:40px; font-weight: bold;"><?php echo $data_resep['NamaPasien'];?></td>
					<td width="50%" style="text-align:center; padding-top:40px; font-weight: bold;"><?php echo $_SESSION['nama_petugas'];?></td>
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