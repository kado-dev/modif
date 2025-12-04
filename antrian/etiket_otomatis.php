<?php
	error_reporting(0);
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	$kota = $_COOKIE['kota2'];
	$poli = $_POST['poli'];
	$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
	
	if(isset($poli)){
		$data_antrian = mysqli_query($koneksi, "SELECT MAX(NomorAntrian) as No FROM $tbantrian_pasien WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = CURDATE()");
		if(mysqli_num_rows($data_antrian) == 0){
			$nomor_antrian = 1;
		}else{
			$dta = mysqli_fetch_assoc($data_antrian);
			$nomor_antrian = $dta['No'] + 1;
		}
		$data_antrian_poli = mysqli_query($koneksi, "SELECT MAX(NomorAntrianPoli) as No FROM $tbantrian_pasien WHERE PoliPertama = '$poli' AND KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = CURDATE()");
		if(mysqli_num_rows($data_antrian_poli) == 0){
			$nomor_antrian_poli = 1;
		}else{
			$dta2 = mysqli_fetch_assoc($data_antrian_poli);
			$nomor_antrian_poli = $dta2['No'] + 1;
		}
		//proses insert ket tabel
		$str = "INSERT INTO $tbantrian_pasien(`KodePuskesmas`, `NomorAntrian`, `NomorAntrianPoli`, `PoliPertama`) 
		VALUES ('$kodepuskesmas','$nomor_antrian','$nomor_antrian_poli','$poli')";
		mysqli_query($koneksi,$str);
	}
	
	//kode pelayanan antrian
	$kodeantrian = mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT * FROM `tbantrian_pelayanan` where Pelayanan = '$poli'"));
	$nomor_antrian_poli2 =  $kodeantrian['KodePelayanan'].' - '.$nomor_antrian_poli;
	/* contoh text */  
	$nama_dinkes = "DINAS KESEHATAN";
	$dt_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` ='$kodepuskesmas'"));
	$nama_puskesmas = "PUSKESMAS ".$dt_puskesmas['NamaPuskesmas'];
	$alamat = $dt_puskesmas['Alamat']; 
	
	$handle = printer_open("EPSON TM-T82 Receipt");
	// printer_set_option($handle, PRINTER_MODE, "raw"); 
	// printer_set_option($handle, PRINTER_TEXT_ALIGN, PRINTER_TA_CENTER);
	printer_start_doc($handle, "My Document");
	printer_start_page($handle);
	printer_draw_line($handle, 1, 60, 1000, 60);
	$center  = 560 - (strlen($nama_dinkes) * 11);
	printer_draw_text($handle, $nama_dinkes, $center/2, 10);//800
	$center2  = 560 - (strlen($nama_puskesmas) * 11);
	printer_draw_text($handle, $nama_puskesmas, $center2/2, 30);
	
	printer_draw_text($handle, $alamat, 0, 50);//panjang alamat 66 -18
	//printer_draw_text($handle, "------------------------------------------------", 10, 60);
	$center3  = 560 - (strlen('ANTRIAN PASIEN') * 11);
	printer_draw_text($handle, "ANTRIAN PASIEN", $center3/2, 100);
	$center4  = 560 - (strlen($poli) * 11);
	printer_draw_text($handle, $poli, $center4/2, 120);
	$font = printer_create_font("Verdana", 40, 48, 400, false, false, false, false);
	printer_select_font($handle, $font);
	$center5  = 560 - (strlen($nomor_antrian_poli2) * 45);
	printer_draw_text($handle, $nomor_antrian_poli2, $center5/2, 180);
	//printer_draw_text($handle, $alamat, 0, 200);
	//printer_delete_font($font);
	
	$font = printer_create_font("Verdana", 40, 9, 400, false, false, false, false);
	printer_select_font($handle, $font);
	$center6  = 560 - (19 * 9);
	printer_draw_text($handle, date('d-m-Y G:i:s'), $center6/2, 280);	
//	printer_draw_line($handle, 1, 340, 1000, 340);
	$center7  = 560 - (34 * 9);
	printer_draw_text($handle,  "Terima kasih, semoga lekas sembuh.", $center7/2, 320);
	$center8  = 560 - (2 * 9);
	printer_draw_text($handle,  "**", $center8/2, 370);
	printer_end_page($handle);
	printer_end_doc($handle);
	printer_close($handle);
	
		
	
	
	
	
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
				.btn{
					display:none;
				}
				.printtiket{
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
				<table border="1" align="center">
					<tr>
						<td>
							<b><?php echo $poli;?></b><br/>
							<span style="font-size:35px;font-weight:bold"><?php echo $nomor_antrian_poli;?></span>
						</td>
					</tr>
				</table>
				<p style="margin-bottom:1px;"><?php echo $poli;?></p>
				<p><?php echo date('d-m-Y G:i:s');?></p>
				
				<p>
					<a class="btn btn-primary" href="javascript:print();" class="btn">Print</a>
					<a class="btn btn-info" href="index.php" class="btn">Selesai</a>
				</p>
				
			</div>
	
	</div>
