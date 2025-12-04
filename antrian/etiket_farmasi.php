<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
//session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$puskesmas = $_COOKIE['namapuskesmas2'];
$kota = $_COOKIE['kota2'];
$noantrian = $_POST['noantrian'];
$tbantrian_farmasi = "tbantrian_farmasi_".str_replace(' ', '', $puskesmas);
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
	
	
if($noantrian == ''){
	$NamaPasien = '';
}else{
	$getpasienrj = mysqli_query($koneksi, "SELECT `NoRegistrasi`, `NoIndex`, `NoCM`, `NoRM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama` FROM $tbpasienrj WHERE NoAntrianPoli = '$noantrian' AND `TanggalRegistrasi` = CURDATE()");
	if(mysqli_num_rows($getpasienrj) > 0){
		$dtpsrj = mysqli_fetch_assoc($getpasienrj);
		$NamaPasien = $dtpsrj['NamaPasien'];
	}else{
		$NamaPasien = '';
	}
}

		$data_antrian = mysqli_query($koneksi, "SELECT MAX(NomorAntrian) as No FROM $tbantrian_farmasi WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = CURDATE()");
		if(mysqli_num_rows($data_antrian) == 0){
			$nomor_antrian = 1;
		}else{
			$dta = mysqli_fetch_assoc($data_antrian);
			$nomor_antrian = $dta['No'] + 1;
		}

		//proses insert ket tabel
		$str = "INSERT INTO `$tbantrian_farmasi`(`KodePuskesmas`, `NomorAntrian`) VALUES ('$kodepuskesmas','$nomor_antrian')";
		mysqli_query($koneksi,$str);

		//insert ke waktupelayanan
		// $str2 = "INSERT INTO `$tbwaktupelayanan`(`NomorAntrianPoli`, `PoliPertama`, `AmbilAntrian`) VALUES ('$nomor_antrian_poli','$poli',NOW())";
		// mysqli_query($koneksi,$str2);
	
	
	//kode pelayanan antrian
	// $kodeantrian = mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan` = '$poli' AND `KodePuskesmas` ='$kodepuskesmas'"));
	$nomor_antrian_poli2 = $nomor_antrian;
	
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` ='$kodepuskesmas'"));
	$pus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat` FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
			
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
		<p style="text-align: center;margin: 0px;padding: 0px">ANTRIAN FARMASI PUSKESMAS</p>
		<!-- <div id="qrcode" style="padding:6px 0px; width: 80px; margin:auto"></div> -->
		<div style="text-align:center; margin-top:-5px; border-top:1px solid #000">
			<?php echo date('d-m-Y G:i:s');?>
			<table border="0" align="center" style=" margin-top:-5px;">
				<tr>
					<td><span style="font-size:88px; font-weight:bold;"><?php echo $nomor_antrian_poli2;?></span></td>
				</tr>
				<?php if($NamaPasien != ''){?>
				<tr>
					<td><span style="font-size:28px; font-weight:bold;"><?php echo $NamaPasien;?></span></td>
				</tr>	
				<?php };?>			
			</table>
			<!-- <hr style="border-color:#000; margin:0px 0px 10px" />	 -->
			<!-- <div style="padding:0px 40px"><svg id="barcodes"></svg></div> -->
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
	<script type="text/javascript">		
		// JsBarcode("#barcodes", "<?php //echo $nomor_antrian_poli2;?>",{
		// 	lineColor: "#000",
		// 	width: 4,
		// 	height: 40,
		// 	displayValue: false
		// });
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
	
		
	</script>
<?php
// }else{
// 	echo "tidak ditemukan";
// }
?>