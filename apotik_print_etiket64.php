<?php
session_start();
include "config/koneksi.php";
// include "config/helper_report.php";
include "config/helper_pasienrj.php";
date_default_timezone_set('Asia/Jakarta');
$status = $_GET['status'];
$jenis_pio = $_GET['jenis_pio'];
$idpasienrj = $_GET['idprj'];
$noindex = $_GET['noidx'];

// tbresep
$norsp = $_GET['norsp'];
$pelayanan = $_GET['ply'];
$status_user = $_POST['status_user'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Etiket Print</title>
		<style>
			body{
				background:#f5f5f5;
				font-family:calibri;
			}
			.container{
				width:350px;
				margin:auto;
				background:#fff;
				padding: 0px;
			}
			.tables{
				width:350px;
				// border:1px solid #000;
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
				border:0px;
				padding: 0px;
				width: 100%;
				border-bottom:1px solid #000;
				margin-bottom: 0px;
			}
			@media print{
				.btn{
					display:none;
				}
			}
		</style>
	</head>	
		<body onload="window.print()" onafterprint="document.location='index.php?page=apotik_pelayanan_resep_manual_lihat&idrj=<?php echo $idpasienrj;?>&status=&norsp=<?php echo $norsp;?>&noid=<?php echo $noindex;?>&statusloket=LOKET OBAT'">
		<div class="container" style="margin-left: -10px;">	
			<?php
				// update status tbresep
				if($idpasienrj == ''){
					$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio' where `NoResep`='$norsp'";
				}else{
					$str = "UPDATE `$tbresep` SET `Status`='Sudah', `Pio`='$jenis_pio' where `IdPasienrj`='$idpasienrj'";
				}
				$query=mysqli_query($koneksi,$str);
				
				// tbbresep
				if($idpasienrj == ''){
					$query_resep = mysqli_query($koneksi,"SELECT * FROM `$tbresep` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan'");
				}else{
					$query_resep = mysqli_query($koneksi,"SELECT * FROM `$tbresep` WHERE `IdPasienrj`='$idpasienrj'");
				}
				$data_resep = mysqli_fetch_assoc($query_resep);
				
				// tbkk, buat narik alamat
				$query_kk = mysqli_query($koneksi,"SELECT `Alamat`,`RT`,`RW`,`Kelurahan`,`Kecamatan` FROM `$tbkk` WHERE `NoIndex`='$data_resep[NoIndex]'");
				$data_kk = mysqli_fetch_assoc($query_kk);

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
					$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang`='$kdbrg'"));
				?>
			
			<table class="tables" style="font-family:Trebuchet MS; margin-top:0px; border-style: none;" width="100%">
				<tr>
					<td colspan="2">						
						<table class="tablehead">
							<tr>
								<td width="15%">
									<img src="image/logo_puskesmas.png" width="50px" style="margin-top:-15px;">
								</td>
								<td>
									<p style="font-size:9px; font-family:Trebuchet MS; margin-top:-10px;text-align:center;margin-bottom: 1px;">
										<!--<b>DINAS KESEHATAN <?php //echo $_SESSION['kota'];?></b><br/>-->
										<b><?php echo "PUSKESMAS ".$namapuskesmas;?></b>
									</p>
									<?php
										//sesion gak jalan, jadinya narik dari tbpuskesmas
										$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Apoteker`, `Sipa` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'"))
									?>
									<p style="font-size:8px; margin-top: 0px; text-align: center; margin-bottom: 5px"><?php echo $alamat;?></p>
									<p style="font-size:8px; margin-top: -5px; text-align: center; margin-bottom: 5px"><?php echo "Apoteker : ".$dtpuskesmas['Apoteker'];?></p>
									<p style="font-size:8px; margin-top: -5px; text-align: center; margin-bottom: 5px"><?php echo "SIPA : ".$dtpuskesmas['Sipa'];?></p>
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
					<td colspan="2" style="font-size:14px; text-align:center; font-weight: bold"><br/>
						<span style="font-size:16px; font-weight: bold;"><?php echo $data_resep['NamaPasien']." - ".$data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?></span><br/>
						<span style="font-size:14px; font-weight: normal;"><?php echo $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", Kel/Ds.".$data_kk['Kelurahan'];?></span>
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
					<td style="font-size:14px; text-align:left; padding-left: 20px;">
						<?php echo strtoupper($dtobat['NamaBarang']).", ".$data['jumlahobat'];?>
					</td>
				</tr>
				<!--<tr>
					<td colspan="2">
						 <p style="font-size:10px;text-align: center">
						 	Semoga lekas sembuh
						 </p>
					</td>
				</tr>-->
			</table>
			<?php
				}
			}
				if($idpasienrj == ''){
					$cekracikan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan' AND racikan = 'true' GROUP BY NoResep, KodeBarang"));
				}else{
					$cekracikan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND racikan = 'true' GROUP BY NoResep, KodeBarang"));
				}
				if($cekracikan > 0){
			?>

			<table class="tables" style="font-family:Trebuchet MS; margin-top:0px; border-style: none;">
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
					<td colspan="2" style="font-size:14px; margin-top:-50; margin:2px;text-align:center;font-weight: bold">
						<br/>
						<?php echo $data_resep['NamaPasien'];?> -
						<?php echo $data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?>
					</td>
				</tr>
						<?php
						if($idpasienrj == ''){
							$dtobatnon = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$norsp' AND `Pelayanan`='$pelayanan' AND `racikan`='true' GROUP BY NoResep, KodeBarang");
						}else{
							$dtobatnon = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `racikan`='true' GROUP BY NoResep, KodeBarang");
						}
						while($dtobatnons = mysqli_fetch_assoc($dtobatnon)){
							$kdbrgs = $dtobatnons['KodeBarang'];
							$nobatchs = $dtobatnons['NoBatch'];
							
							//tbgudangpkmstok, jangan dari gfkstok
							$dton = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NamaBarang FROM `tbapotikstok` WHERE `KodeBarang`='$kdbrgs' AND `NoBatch`='$nobatchs'"));
							?>
								<tr>
									<td style="font-size:12px;margin:2px;text-align:left; padding-left: 20px;">
										<?php echo strtoupper($dton['NamaBarang']);?>
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
				<!--<tr>
					<td colspan="2">
						 <p style="font-size:12px;text-align: center">
						 	Semoga lekas sembuh
						 </p>
					</td>
				</tr>-->
			</table>
			<?php
				}
			?>
		</div>
	</body>
</html>