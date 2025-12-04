<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$asalpasien = $_GET['asalpasien'];
	$hariini = date('d');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Loket_Registrasi_Kunjungan (".$namapuskesmas.' '.$bulan.' '.$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}
.str{
	mso-number-format:\@; 
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KUNJUNGAN PASIEN</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
		<?php } ?>
	</p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2">NO.</th>
					<th rowspan="2">NAMA PASIEN</th>
					<th colspan="2">UMUR</th>
					<th rowspan="2">NO.KARTU</th>
					<th rowspan="2">KUNJG</th>
					<th rowspan="2">ALAMAT RT/RW</th>
					<th colspan="2">BP</th>
					<th colspan="2">KIA</th>
					<th colspan="2">GIGI</th>
					<th colspan="2">MTBS</th>
					<th colspan="2">IMUNISASI</th>
					<th colspan="2">TB</th>
					<th colspan="2">KESWA</th>
					<th colspan="2">IGD</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th>
					<th>P</th>
					<th>UMUM</th><!--bp-->
					<th>BPJS</th>
					<th>UMUM</th><!--kia-->
					<th>BPJS</th>
					<th>UMUM</th><!--gigi-->
					<th>BPJS</th>
					<th>UMUM</th><!--mtbs-->
					<th>BPJS</th>
					<th>UMUM</th><!--imunisasi-->
					<th>BPJS</th>
					<th>UMUM</th><!--tb-->
					<th>BPJS</th>
					<th>UMUM</th><!--keswa-->
					<th>BPJS</th>
					<th>UMUM</th><!--igd-->
					<th>BPJS</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";			
					if ($asalpasien == 'semua_pasien'){
						$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
					}else{
						$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND AsalPasien='$asalpasien'";
					}	
					// echo $str;
				}else{
					$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
					$tbpasienrj2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
					
					if ($asalpasien == 'semua_pasien'){
						$str = "SELECT * FROM(
						SELECT * FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
						UNION
						SELECT * FROM `$tbpasienrj2`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
						) tbalias";
					}else{
						$str = "SELECT * FROM(
						SELECT * FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
						UNION
						SELECT * FROM `$tbpasienrj2`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
						) tbalias";
					}
				}
				$str2 = $str." ORDER BY TanggalRegistrasi DESC, NamaPasien ASC";
				// echo $str2;
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($hariini != $data['TanggalRegistrasi']){
						echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='23'>Tanggal : $data[TanggalRegistrasi]</td></tr>";
						$hariini = $data['TanggalRegistrasi'];
					}	
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$asuransi = $data['Asuransi'];
					$nomorasuransi = $data['nokartu'];
									
					// tbkk
					$strkk = "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$querykk = mysqli_query($koneksi,$strkk);
					$datakk = mysqli_fetch_assoc($querykk);
					$alamat = $datakk['Alamat'];
					
					if($alamat != null){
						$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'];
					}else{
						$alamat = "-";
					}
					
					if($asuransi == 'BPJS PBI' || $asuransi == 'BPJS NON PBI' || $asuransi == 'KIS'){
						$noasuransi = $nomorasuransi;
					}else{
						$noasuransi = "0";
					}
					
					// tbpasien
					$strpasien = "SELECT NoRM FROM `tbpasien` WHERE `NoCM` = '$nocm'";
					$querypasien = mysqli_query($koneksi,$strpasien);
					$datapasien = mysqli_fetch_assoc($querypasien);
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['JenisKelamin'] == "L"){
									if($data['UmurTahun'] != 0 || $data['UmurTahun'] == null){
										echo $data['UmurTahun']." Th";
									}elseif($data['UmurTahun'] == 0 && $data['UmurBulan'] != ""){
										echo $data['UmurBulan']." Bl";
									}else{
										echo $data['UmurHari']." Hr";
									}	
								}else{	
									echo "";
								}
							?>	
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['JenisKelamin'] == "P"){
									if($data['UmurTahun'] != 0 || $data['UmurTahun'] == null){
										echo $data['UmurTahun']." Th";
									}elseif($data['UmurTahun'] == 0 && $data['UmurBulan'] != ""){
										echo $data['UmurBulan']." Bl";
									}else{
										echo $data['UmurHari']." Hr";
									}	
								}else{	
									echo "";
								}
							?>	
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="str"><?php echo substr($datapasien['NoRM'],-6);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['StatusKunjungan']);?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;">
							<?php 
								if ($noindex == ''){
									echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
								}else{
									echo $alamat;
								}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli umum
								if($data['PoliPertama'] == "POLI UMUM" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI UMUM" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli kia
								if(($data['PoliPertama'] == "POLI KIA" OR $data['PoliPertama'] == "POLI KB") AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if(($data['PoliPertama'] == "POLI KIA" OR $data['PoliPertama'] == "POLI KB") AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli gigi
								if($data['PoliPertama'] == "POLI GIGI" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI GIGI" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli mtbs
								if($data['PoliPertama'] == "POLI MTBS" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI MTBS" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli imunisasi
								if($data['PoliPertama'] == "POLI IMUNISASI" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI IMUNISASI" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td><td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli tb
								if($data['PoliPertama'] == "POLI TB" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI TB" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>
						</td><td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli keswa
								if($data['PoliPertama'] == "POLI KESWA" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI KESWA" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td></td><td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								// poli igd
								if($data['PoliPertama'] == "POLI UGD" AND $data['Asuransi'] == "UMUM"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($data['PoliPertama'] == "POLI UGD" AND substr($data['Asuransi'],0,4) == "BPJS"){
									echo 'X';
								}else{
									echo "";
								}	
							?>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>