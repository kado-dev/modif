<?php
	session_start();
	include "config/koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rekam Medis Print</title>
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
			.btn{
				position:relative;
				top:40px;
			}
			.textheader{
				text-align: center;
				margin-top: 0px;
				line-height: 25px;
			}
			.textcontent td{
				font-size: 17px;
			}
			@media print{
				.btn{
					display:none;
				}
			}
		</style>	
	</head>
	<body>
			<div class="container">
			<?php
			$noreg = $_GET['noreg'];
			$nocm = $_GET['nocm'];
			$strdetail = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noreg'";
			$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,$strdetail));	
			if($dt_pasienrj['NoAntrianPoli'] == ""){
				$noantrianpoli = 0;
			}else{
				$noantrianpoli = $dt_pasienrj['NoAntrianPoli'];
			}		
			?>
			<!--tracer 1-->
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:16px; font-weight:bold; margin-top:20px;"><?php echo "DINAS KESEHATAN " .$_SESSION['kota'];?></b><br>
			</div>
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:16px; font-weight:bold; margin-top:20px;"><?php echo "PUSKESMAS " .$_SESSION['namapuskesmas'];?></b><br>
			</div>
			<div style="text-align:center; padding-bottom:10px;">
				<b style="font-size:11px"><?php echo $_SESSION['alamat'];?></b>
			</div>
			
			<p class="textheader">
				<span style="font-size:18px;">TRACER</span><br/>
				<b style="font-size:36px;"><?php echo substr($noreg,-3)." | ".$noantrianpoli;?></b><br/>
				<b style="font-size:24px;"><?php echo $dt_pasienrj['NamaPasien'];?></b><br/>
				<span style="font-size:16px;"></span>
			</p>
			
			<table class="textcontent">
				<tr>
					<td>No.RM</td>
					<td>:</td>
					<td><?php echo $dt_pasienrj['NoRM'];?></td>
				</tr>
				<tr>
					<td>No.Index</td>
					<td>:</td>
					<td><?php echo substr($dt_pasienrj['NoIndex'],-10);?></td>
				</tr>
				<tr>
					<td>Tgl.Registrasi</td>
					<td>:</td>
					<td><?php echo $dt_pasienrj['TanggalRegistrasi'];?></td>
				</tr>
				<tr>
					<td>Cara Bayar</td>
					<td>:</td>
					<td><?php echo $dt_pasienrj['Asuransi'];?></td>
				</tr>
				<tr>
					<td>Pelayanan</td>
					<td>:</td>
					<td><?php echo $dt_pasienrj['PoliPertama'];?></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><a href="javascript:print();" class="btn">Print</a></td>
				</tr>
			</table>
		</div>
	</body>
</html>