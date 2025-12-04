<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
	
	$noregistrasi = $_GET['noreg'];
	$tgltindakan = $_GET['tgl'];
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
				border:1px solid #000;
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
				line-height: 25px;
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
			$noreg = $_GET['noreg'];
			$strdetail = "SELECT * FROM `$tbpasienrj` where `NoRegistrasi` = '$noreg'";
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
				function nono($y,$x){
					$no_next = $y + $x;
					if(strlen($no_next)==1){
						$no="00".$no_next;
					}else if(strlen($no_next)==2){
						$no="0".$no_next;
					}else{
						$no=$no_next;
					}
					return $no;
				}	
			$nokwitansi = $hariini."/".nono($no,1);
			?>
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:18px; font-weight:bold; margin-top:20px;"><?php echo "DINAS KESEHATAN " .$_SESSION['kota'];?></b><br>
			</div>
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:18px; font-weight:bold; margin-top:20px;"><?php echo "PUSKESMAS " .$_SESSION['namapuskesmas'];?></b><br>
			</div>
			<div style="text-align:center; padding-bottom:10px;">
				<b style="font-size:11px"><?php echo strtoupper($_SESSION['alamat']);?></b>
			</div>
			
			<p class="textheader">
				
				<b style="font-size:22px; text-decoration: underline;">e - KWITANSI</b><br/>
				<b style="font-size:14px;"><?php echo "No. ".$nokwitansi;?></b><br/><br/>
				<b style="font-size:22px;"><?php echo $datapasien['NamaPasien'];?></b><br/>
				<b style="font-size:16px;"><?php echo "KK. ".$datakk['NamaKK'];?></b><br/>
				<span style="font-size:14px;">
					<?php
						if($data['UmurTahun'] != ''){
							$umur = $data['UmurTahun']." TH";	
						}else{
							$umur = $data['UmurBulan']." BL";	
						}	
						echo " TGL.LAHIR : ".date('d-m-Y', strtotime($datapasien['TanggalLahir']))." (".$umur.")";
					?>
				</span>
			</p>
		
			<table class="textcontent" style="margin-top: -10px;">
				<tr>
					<td width="30%">No.Index</td>
					<td width="70%"><?php echo ": ".substr($data['NoIndex'], -10);?></td>
				</tr>
				<tr>
					<td>Tgl.Registrasi</td>
					<td><?php echo ": ".$data['TanggalRegistrasi'];?></td>
				</tr>
				<tr>
					<td>Cara Bayar</td>
					<td><?php echo ": ".$data['Asuransi'];?></td>
				</tr>
				<tr>
					<td>No.BPJS</td>
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
					<td>Alamat</td>
					<td><?php echo ": ".$datakk['Alamat']." RT.".$datakk['RT'].", ".$datakk['Kelurahan'];?></td>
				</tr>
			</table>
			<table class="table-judul" style="margin-top: -20px; padding-bottom: 60px;">
				<thead>
					<tr>
						<th width="5%">NO.</th>
						<th width="75%">JENIS TINDAKAN</th>
						<th width="20%">TARIF</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					$str = "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi` = '$noreg' GROUP BY `NoRegistrasi`,`PoliAsal`";
					$query = mysqli_query($koneksi,$str);
					while($datatindakan = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$idtindakan = $datatindakan['IdTindakan'];
						
						// tbtindakan
						$dt_tdk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbtindakan` WHERE `IdTindakan`='$idtindakan'"));
						$jenistindakan = $dt_tdk['Tindakan'];
						$tarif = $dt_tdk['Tarif'];
						
					?>	
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="left"><?php echo strtoupper($jenistindakan);?></td>
						<td align="right"><?php echo $tarif;?></td>
					</tr>	
					<?php } ?>
				</tbody>
				
			</table>
			<table class="textcontent" style="margin-top: -20px; padding-bottom: 60px; border: none;">
				<tr>
					<?php 
						$nourut_bpjs = strlen($data['NoUrutBpjs']);
						if($nourut_bpjs >= 4){
					?>	
						<div style="text-align:center; margin-bottom:15px;"><b style="font-size:16px;">BRIDGING PCARE GAGAL<br/>SILAHKAN HAPUS DATA & REGISTRASI ULANG...!</b><br/></div>
						<td><a href="index.php?page=registrasi_data" class="btn3">DATA REGISTRASI</a></td>
					<?php }else{ ?>
						<td><a href="javascript:print();" class="btn1">PRINT</a></td>
						<td><a href="index.php?page=dashboard_puskesmas_kasir&tglreg3=<?php echo $tgltindakan;?>" class="btn2">KEMBALI</a></td>
					<?php } ?>
					
				</tr>
			</table>
		</div>
	</body>
</html>