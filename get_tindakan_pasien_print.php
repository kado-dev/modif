<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$idpasienrj = $_GET['idprj'];
	$sts = $_GET['sts'];

	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>e-Kwitansi</title>
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
				/* border:1px solid #000; */
				margin-bottom:30px;
				padding:10px;
			}
			td, p{
				font-size:16px;
			}
			.btn1{
				position:relative;
				display: block;
				width: 50%;
				background-color: #08c999;
				border: none;
				color: #fff;
				padding: 12px 30px;
				cursor: pointer;
				font-size: 18px;
				font-family: "Poppins", sans-serif;
				border-radius: 5px;
				transition: all 0.2s;
				text-align: center;
			}
			.btn2{
				position:relative;
				display: block;
				width: 60%;
				background-color: #006f8e;
				border: none;
				color: #fff;
				padding: 12px 30px;
				cursor: pointer;
				font-size: 18px;
				font-family: "Poppins", sans-serif;
				border-radius: 5px;
				transition: all 0.2s;
				text-align: center;
				margin-left: 20px;
				
			}
			.btn3{
				position:relative;
				display: block;
				width: 60%;
				background-color: #d60000;
				border: none;
				color: #fff;
				padding: 12px 30px;
				cursor: pointer;
				font-size: 18px;
				font-family: "Poppins", sans-serif;
				border-radius: 5px;
				transition: all 0.2s;
				text-align: center;
				margin-left: 35px;
				
			}
			.textheader{
				text-align: center;
				margin-top: 0px;
				line-height: 20px;
			}
			.textcontent td{
				font-size: 14px;
			}
			@media print{
				.btn1, .btn2{
					display:none;
				}
			}
		</style>	
	</head>
	<body>
		<div class="container">
			<?php
			$strdetail = "SELECT * FROM `$tbpasienrj` where `IdPasienrj` = '$idpasienrj'";
			$data = mysqli_fetch_assoc(mysqli_query($koneksi,$strdetail));
			$nocm = $data['NoCM'];
			if(strlen($nocm) == 13){
				$strtbpasien = "SELECT * FROM `$tbpasien` where `NoAsuransi` = '$nocm'";
				$data2 = mysqli_fetch_assoc(mysqli_query($koneksi,$strtbpasien));
				$noindex = $data2['NoIndex'];
			}else{
				$noindex =$data['NoIndex'];
			}
			
			// tbkk
			$strkk = "SELECT `NamaKK`,`NoRM`,`Alamat`,`RT`,`Kelurahan` FROM `$tbkk` where `NoIndex` = '$noindex'";
			$datakk = mysqli_fetch_assoc(mysqli_query($koneksi,$strkk));
			
			// tbpasien
			$strpasien = "SELECT * FROM `$tbpasien` where `NoCM` = '$nocm'";
			$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi,$strpasien));
			
			// tbtindakanpasien
			$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
			$hariini = date('dmY');
			$sql_cek = "SELECT max(NoRegistrasi)as maxno FROM `$tbtindakanpasien` WHERE date(TanggalTindakan) = curdate()";
			$query_cek=mysqli_query($koneksi,$sql_cek);
			$datareg=mysqli_fetch_array($query_cek);
			$no=substr($datareg['maxno'],-3);
			$nonext = (int)$no + 1;
			$nonexts = str_pad($nonext, 4, "0", STR_PAD_LEFT);
				
			$nokwitansi = $hariini."/".$nonexts;
			
			?>
			
			<!-- <div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:18px; font-weight:bold; margin-top:20px;"><?php //echo "DINAS KESEHATAN " .$_SESSION['kota'];?></b><br>
			</div>
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:18px; font-weight:bold; margin-top:20px;"><?php //echo "PUSKESMAS " .$_SESSION['namapuskesmas'];?></b><br>
			</div>
			<div style="text-align:center; padding-bottom:10px;">
				<b style="font-size:11px"><?php //echo strtoupper($_SESSION['alamat']);?></b>
			</div> -->
			
			<?php include "kop_surat_kecil.php";?>

			<p class="textheader">
				<b style="font-size:22px; text-decoration: underline;">KWITANSI</b><br/>
				<b style="font-size:14px;"><?php echo "NOMOR : ".$nokwitansi;?></b><br/><br/>
				<b style="font-size:18px;"><?php echo $datapasien['NamaPasien'];?></b><br/>
				<span style="font-size:14px;">
					<?php
						if($data['UmurTahun'] != ''){
							$umur = $data['UmurTahun']." TH";	
						}else{
							$umur = $data['UmurBulan']." BL";	
						}	
						echo " TGL.LAHIR : ".date('d-m-Y', strtotime($datapasien['TanggalLahir']))." (".$umur.")";
					?>
				</span><br/>
				<b style="font-size:18px;"><?php echo "KK. ".$datakk['NamaKK'];?></b><br/>
				<span style="font-size:14px;"><?php echo "ALAMAT : ".$datakk['Alamat']." RT.".$datakk['RT'].", ".$datakk['Kelurahan'];?></span><br/>
			</p>
		
			<table class="textcontent" style="margin-top: -10px;">
				<tr>
					<td>TGL.REGISTRASI</td>
					<td><?php echo ": ".$data['TanggalRegistrasi'];?></td>
				</tr>
				<tr>
					<td width="30%">NO.INDEX</td>
					<td width="70%"><?php echo ": ".substr($data['NoIndex'], -10);?></td>
				</tr>
				<tr>
					<td>CARA BAYAR</td>
					<td><?php echo ": ".$data['Asuransi'];?></td>
				</tr>
				<tr>
					<td>NO.BPJS</td>
					<td>
					<?php 
						if($data['nokartu'] != ""){
							echo ": ".$data['nokartu'];
						}else{
							echo ": ".$datapasien['NoAsuransi'];
						}	
					?>
					</td>
				</tr>
				<tr>
					<td>NIK</td>
					<td><?php echo ": ".$datapasien['Nik'];?></td>
				</tr>
				<tr>
					<td>TELP.</td>
					<td>
						<?php 
							if($datakk['Telepon'] != ''){
								echo ": ".$datakk['Telepon'];
							}else{
								if($datapasien['Telpon'] != ''){
									echo ": ".$datapasien['Telpon'];
								}else{
									echo ": 0";
								}	
							}
						?>
					</td>
				</tr>
				<tr>
					<td>PETUGAS</td>
					<td><?php echo ": ".$_SESSION['username'];?></td>
				</tr>
			</table>
			<table class="table-judul" style="margin-top: -20px; padding-bottom: 20px; border:1px solid #000;">
				<thead>
					<tr>
						<th width="75%">Jenis Retribusi</th>
						<th width="20%">Tarif</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// $str = "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'";					
					// $query = mysqli_query($koneksi,$str);
					// while($data_tarif = mysqli_fetch_assoc($query)){
					// 	$no = $no + 1;
					// 	$tarif_karcis = $data_tarif['TarifKarcis'];
					// 	$tarif_kir = $data_tarif['TarifKir'];
					// 	$tarif_tindakan = $data_tarif['TarifTindakan'];
						
					// }
					
					//get tarif karcis
					$getTarifKarcis = mysqli_query($koneksi,"SELECT b.SubTotal as tarifKarcis FROM tbtagihan a JOIN tbtagihan_detail b ON a.IdTagihan = b.IdTagihan WHERE a.IdPasienrj = '$idpasienrj'AND b.Keterangan = 'Tarif Karcis'");					
					$tarif_karcis = '0';
					if(mysqli_num_rows($getTarifKarcis) > 0){
						$dttars = mysqli_fetch_assoc($getTarifKarcis);

						$tarif_karcis = $dttars['tarifKarcis'];
					}

					//get tarif kir
					$getTarifKir = mysqli_query($koneksi,"SELECT b.Keterangan, b.SubTotal as tarifKir FROM tbtagihan a JOIN tbtagihan_detail b ON a.IdTagihan = b.IdTagihan WHERE a.IdPasienrj = '$idpasienrj'AND b.Keterangan LIKE 'Tarif Kir%'");					
					$tarif_kir = '0';
					if(mysqli_num_rows($getTarifKir) > 0){
						$dttars2 = mysqli_fetch_assoc($getTarifKir);

						$tarif_kir = $dttars2['tarifKir'];
						$keterangan_kir = str_replace("Tarif ","",$dttars2['Keterangan']);
					}

					//get total tarif
					$getTarifStat = mysqli_query($koneksi,"SELECT b.StatusBayar, SUM(b.SubTotal) as totaltarif FROM tbtagihan a JOIN tbtagihan_detail b ON a.IdTagihan = b.IdTagihan WHERE a.IdPasienrj = '$idpasienrj'");
					
					$tarif_total = '0';
					if(mysqli_num_rows($getTarifStat) > 0){
						$dttars = mysqli_fetch_assoc($getTarifStat);

						$tarif_total = $dttars['totaltarif'];
					}
					?>	
					
					<tr>
						<td align="left">Retribusi Pendaftaran</td>
						<td align="right"><?php echo rupiah($tarif_karcis);?></td>
					</tr>
					
					<?php if($tarif_kir != '0'){ ?>
					<tr>
						<td>Retribusi <?php echo strtoupper($keterangan_kir);?></td>
						<td align="right"><?php echo rupiah($tarif_kir);?></td>
					</tr>
					<?php } ?>
					
					<?php
						// tbtindakanpasien
						$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
						$querytindakan = mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj'");
						while($data_tindakan = mysqli_fetch_assoc($querytindakan)){
							// tbtindakan
							$tindakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbtindakan` WHERE `IdTindakan`='$data_tindakan[IdTindakan]'"));
					?>
					<tr>
						<td><?php echo strtoupper($tindakan['Tindakan']);?></td>
						<td align="right"><?php echo rupiah($data_tindakan['Tarif']);?></td>
					</tr>
					<?php 
						$total = $total + $data_tindakan['Tarif'];
						} 
					?>
					<tr>
						<td align="center"><b>Total</b></td>
						<td align="right"><b><?php echo rupiah($tarif_karcis + $tarif_kir + $total);?></b></td>
					</tr>
				</tbody>
			</table>
			<table class="textcontent" style="margin-top: -20px; padding-bottom: 20px; border: none;">
				<tr>
					<td><a href="javascript:print();" class="btn1">Print</a></td>
					<td>
						<?php if($sts == 'dskasir'){ ?>
							<a href="index.php?page=dashboard_puskesmas_kasir" class="btn2">Kasir</a>
						<?php }else{ ?>
							<a href="index.php?page=kasir_pembayaran" class="btn2">Kasir</a>
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
<?php
	mysqli_close($koneksi);
?>