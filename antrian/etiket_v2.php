<?php
	date_default_timezone_set('Asia/Jakarta');
	error_reporting(0);
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	$kota = $_COOKIE['kota2'];
	$carabayar = $_POST['poli'];
	
	if(isset($carabayar)){
		$data_antrian = mysqli_query($koneksi, "SELECT MAX(NomorAntrian) as No from tbantrian_pasienv2 WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = CURDATE()");
		if(mysqli_num_rows($data_antrian) == 0){
			$nomor_antrian = 1;
		}else{
			$dta = mysqli_fetch_assoc($data_antrian);
			$nomor_antrian = $dta['No'] + 1;
		}
		
		//proses insert ket tabel
		$str = "INSERT INTO `tbantrian_pasienv2`(`KodePuskesmas`, `NomorAntrian`, `CaraBayar`) 
		VALUES ('$kodepuskesmas','$nomor_antrian','$carabayar')";
		mysqli_query($koneksi,$str);
	}
	
	//kode pelayanan antrian
	$nomor_antrian_poli2 =  $carabayar.' - '.$nomor_antrian;
	
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * from tbpuskesmas WHERE KodePuskesmas ='$kodepuskesmas'"));
	$pus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat from tbpuskesmas WHERE KodePuskesmas = '$kodepuskesmas'"));
			
?>
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
			width:100%;
			/*border:1px solid #000;*/
			margin-bottom:10px;
			padding:10px;
		}
		td, p{
			font-size:16px;
		}
		.btn{
			position:relative;
			top:40px;
		}
		@media print{
			/*
			@page{
				size:  portrait; 
				margin: 0mm;  
			}
			html{
				background-color: #FFFFFF; 
				margin: 0px;
			}
			*/
			.noprint{
				display:none;
			}
			.btn{
				display:none;
			}
			.printtiket{
				/*margin-top:15px;*/
				margin-top:-15px;
			}
			body{
				padding-top:0px;
			}
		}
	</style>
	
	<div class="printtiket">
		<div style="text-align:center; margin-bottom:-5px;">
			<b style="font-size:18px; font-weight:bold; margin-top:20px;">DINAS KESEHATAN</b><br>
		</div>
		<div style="text-align:center; margin-bottom:-5px;">
			<b style="font-size:18px; font-weight:bold; margin-top:20px;"><?php echo "PUSKESMAS " .$datapuskesmas['NamaPuskesmas'];?></b><br>
		</div>
		<div style="text-align:center; padding-bottom:1px;">
			<b style="font-size:11px"><?php echo $pus['Alamat'];?></b>
		</div>
		<div style="text-align:center">
			<h3 style="font-size:18px; font-weight:bold;">Antrian Pasien</h3>
			<div style="border:1px solid #111;padding-bottom:20px">
				<b><?php echo $poli;?></b>
				<br/>
				<span style="font-size:35px;font-weight:bold;margin-bottom:20px"><?php echo $nomor_antrian_poli2;?></span>
			</div>		
			<p><?php echo date('d-m-Y G:i:s');?></p>
			<!--
			<p>
				<a class="btn btn-primary" href="javascript:print();" class="btn">Print</a>
				<a class="btn btn-info" href="index.php" class="btn">Selesai</a>
			</p>-->
		</div>
	</div>
	<script>
		window.print(); 
	</script>
