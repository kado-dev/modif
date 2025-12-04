<?php
	error_reporting(1);
	session_start();
	$kota = $_SESSION['kota'];
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	$kota = $_COOKIE['kota2'];
	$poli = $_POST['poli'];
	$klaster = $_POST['klaster'];
	$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
	$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;	
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}

	$waktuantrian = date('Y-m-d')." ".date('G:i:s');
	$hariini = date('Y-m-d');
	
	if(isset($poli)){
		$data_antrian = mysqli_query($koneksi, "SELECT MAX(NomorAntrian) as No FROM $tbantrian_pasien WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = '$hariini'");
		if(mysqli_num_rows($data_antrian) == 0){
			$nomor_antrian = 1;
		}else{
			$dta = mysqli_fetch_assoc($data_antrian);
			$nomor_antrian = $dta['No'] + 1;
		}

		$data_antrian_poli = mysqli_query($koneksi, "SELECT MAX(NomorAntrianPoli) as No FROM $tbantrian_pasien WHERE PoliPertama = '$poli' AND KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = '$hariini'");
		if(mysqli_num_rows($data_antrian_poli) == 0){
			$nomor_antrian_poli = 1;
		}else{
			$data_antrian_poli1 = mysqli_query($koneksi, "SELECT COUNT(NomorAntrianPoli) as No FROM $tbantrian_pasien WHERE PoliPertama = '$poli' AND KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = '$hariini'");
			$dta2 = mysqli_fetch_assoc($data_antrian_poli1);
			$nomor_antrian_poli = $dta2['No'] + 1;
		}
		
		// proses insert ket tabel
		$str = "INSERT INTO `$tbantrian_pasien`(`WaktuAntrian`,`KodePuskesmas`, `NomorAntrian`, `NomorAntrianPoli`, `PoliPertama`,`Klaster`,`StatusDaftar`) VALUES ('$waktuantrian','$kodepuskesmas','$nomor_antrian','$nomor_antrian_poli','$poli','$klaster','OFFLINE')";
		// echo $str;
		// die();
		mysqli_query($koneksi,$str);
		$idantrian = mysqli_insert_id($koneksi);		

		// insert ke waktupelayanan
		// $str2 = "INSERT INTO `$tbwaktupelayanan`(`IdAntrian`,`NomorAntrianPoli`, `PoliPertama`, `AmbilAntrian`) VALUES ('$idantrian','$nomor_antrian_poli','$poli',NOW())";
		// mysqli_query($koneksi,$str2);
	}
	
	// kode pelayanan antrian
	$kodeantrian = mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan` = '$poli' AND `KodePuskesmas` ='$kodepuskesmas'"));
	$nomor_antrian_poli2 =  $kodeantrian['KodePelayanan']."-".$nomor_antrian_poli;
	
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` ='$kodepuskesmas'"));
	$pus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat` FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));

	// tbantrian_setting
	$dtantrianset =  mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT `TampilNoAntrian` FROM `tbantrian_setting` WHERE `KodePuskesmas` = '$datapuskesmas[KodePuskesmas]'"));
	

?>
	<link href="https://fonts.googleapis.com/css?family=Big+Shoulders+Text|Ubuntu|Roboto+Condensed|Fjalla+One" rel="stylesheet">
	<style>	
		body{
			background:#f5f5f5;			
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
			margin-bottom:0px;
			padding:10px;
		}
		td, p{
			font-size:16px;
		}
		.btn{
			position:relative;
			top:40px;
		}
		#qrcode > img{
			display: relative;
		}
		@media print{			
			@page{
				size:  80mm 100mm; 
				margin: 0mm;
				position: absolute;
			}
			/*
			html{
				background-color: #FFFFFF; 
				margin: 0px;
			}
			*/
			svg {
			    width: 100%;
			    height: 100%;
			    max-width: 100%;
			    max-height: 100%;
			  }
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
	
	<body onafterprint="document.location = 'https://e-kes.bandungkab.go.id/antrian/index.php'" onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
		<div class="printtiket" onclick="NewPrint(2)">
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:14px; font-weight:bold; margin-top:20px;">DINAS KESEHATAN <?php echo $kota;?></b><br>
			</div>
			<div style="text-align:center; margin-bottom:-5px;">
				<b style="font-size:18px; font-weight:bold; margin-top:20px;"><?php echo "PUSKESMAS " .$datapuskesmas['NamaPuskesmas'];?></b><br>
			</div>
			<div style="text-align:center; margin-top:-10px; border-bottom: 1px solid #000">
				<b style="font-size:10px"><?php echo $pus['Alamat'];?></b>
			</div>
			<p style="text-align: center;margin: 0px;padding: 0px">ANTRIAN PUSKESMAS</p>
			<!-- <div id="qrcode" style="padding:6px 0px; width: 80px; margin:auto"></div> -->
			<div style="text-align:center; margin-top:-5px; border-top:0px solid #000">
				<?php echo date('d-m-Y G:i:s');?>
				<div style="padding:0px 20px"><svg id="barcodes"></svg></div>
				<p style="font-size:20px; font-weight:bold; text-align: center; margin: 0px;padding: 0px"><?php echo strtoupper($klaster);?></p>
				<table border="0" style=" margin-top:0px; margin-left: -20px;" width="100%">
					<tr>
						<td><span style="font-size:20px; font-weight:bold;"><?php echo $poli;?></span></td>
						<td><span style="font-size:20px; font-weight:bold;"><?php echo $nomor_antrian_poli2;?></span></td>
					</tr>
					<h3 style="margin:0px;text-align:center;">
						<?php 
							if($dtantrianset['TampilNoAntrian'] == "Y"){
								echo "No.Pendaftaran : ".$nomor_antrian;
							}
						?>
					</h3>
				</table>
				<!-- <hr style="border-color:#000; margin:0px 0px 10px"/> -->
				<div style="text-align:center; border-top:1px solid #000">	
					<p style="font-size:12px; margin-top:10px;">
						<b>
							<?php 
								$dtsetting = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `motto` FROM `tbantrian_setting` WHERE `KodePuskesmas`='$kodepuskesmas'"));	
								echo strtoupper($dtsetting['motto']);
							?>
						</b>
						<br/>
						JIKA NO.ANTRIAN PENDAFTARAN TERLEWAT 5 ANTRIAN<br>
						MOHON MENGAMBIL ULANG NO.ANTRIAN PENDAFTARAN
					</p>
				</div>
			</div>
		</div>
	</body>	
	<script type="text/javascript">		
		JsBarcode("#barcodes", "<?php echo $nomor_antrian_poli2;?>",{
			lineColor: "#000",
			width: 4,
			height: 40,
			displayValue: false
		});
		
		// var qrcode = new QRCode(document.getElementById("qrcode"), {
			// width : 80,
			// height : 80
		// });
		// var elText = "<?php //echo $nomor_antrian_poli2;?>";
		// qrcode.makeCode(elText);
		
		// var qrcode = new QRCode(document.getElementById("qrcode"), {
		// 	width : 80,
		// 	height : 80
		// });
		// var elText = "<?php //echo $nomor_antrian_poli2;?>";
		// qrcode.makeCode(elText);
 
		// function print_current_page(Copies){
			// var Count = 0;
			// while (Count < Copies){
				// window.print(0);
				// Count++;
			// }
		// }
		window.print();
	
		window.history.forward();
        function noBack()
        {
            window.history.forward();
        }
	</script>
	
