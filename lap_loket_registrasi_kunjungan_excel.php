<?php
	error_reporting(0);
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

<div class="atastabel font14">
	<div style="float:left; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kelurahan);?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kecamatan);?></h5 ></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th width="3%" rowspan="2">NO.</th>
					<th width="6%" rowspan="2">TANGGAL</th>					
					<th width="5%" rowspan="2">NIK</th>
					<th width="10%" rowspan="2">NAMA PASIEN</th>
					<th width="2%" rowspan="2">L/P</th>
					<th width="4%" rowspan="2">UMUR</th>
					<th width="10%" rowspan="2">ALAMAT</th>
					<th width="6%" rowspan="2">PELAYANAN</th>
					<th colspan="2" >CARA BAYAR</th>
					<th width="3%" rowspan="2">KUNJ.</th>
					<th width="5%" rowspan="2">TARIF</th>
					<th width="5%" rowspan="2">KET.</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th width="5%">CARA BAYAR</th>
					<th width="5%">NOMOR</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";			
					if ($asalpasien == 'semua_pasien'){
						$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu;
					}else{
						$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu." AND AsalPasien='$asalpasien'";
					}	
					// echo $str;
				}else{
					$waktu = "date(`TanggalRegistrasi`) BETWEEN '$keydate1' AND '$keydate2'";
					
					if ($asalpasien == 'semua_pasien'){
						$str = "SELECT * FROM(
						SELECT * FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
						UNION
						SELECT * FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
						) tbalias";
					}else{
						$str = "SELECT * FROM(
						SELECT * FROM `$tbpasienrj`
						WHERE ".$waktu." and AsalPasien='$asalpasien'
						UNION
						SELECT * FROM `$tbpasienrj`
						WHERE ".$waktu." and AsalPasien='$asalpasien'
						) tbalias";
					}
				}
				$str2 = $str." ORDER BY Tanggalregistrasi, NoRegistrasi DESC";
				// echo $str2;
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$idpasien = $data['IdPasien'];
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$asuransi = $data['Asuransi'];
					$nomorasuransi = $data['nokartu'];
					
					// tbpasien
					$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Nik` FROM `$tbpasien` WHERE IdPasien = '$idpasien'"));
																	
					// tbkk
					$strkk = "SELECT `Alamat`, `RT`, `No`, `Kelurahan`, `Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$querykk = mysqli_query($koneksi,$strkk);
					$datakk = mysqli_fetch_assoc($querykk);

					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
					if($dt_subdis['subdis_name'] != ''){
						$kelurahan = $dt_subdis['subdis_name'];
					}else{
						$kelurahan = $datakk['Kelurahan'];
					}

					// ec_districts
					$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
					if($dt_dis['dis_name'] != ''){
						$kecamatan = $dt_dis['dis_name'];
					}else{
						$kecamatan = $datakk['Kecamatan'];
					}

					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan);
					
					if($asuransi == 'BPJS PBI' || $asuransi == 'BPJS NON PBI' || $asuransi == 'KIS'){
						$noasuransi = $nomorasuransi;
					}else{
						$noasuransi = "0";
					}
				?>
					<tr style="border:1px solid #000;">
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y G:i:s', strtotime($data['TanggalRegistrasi']));?></td>
						<td align="left" class="str"><?php echo $dtpasien['Nik'];?></td>
						<td align="left"><?php echo strtoupper($data['NamaPasien']);?></td>
						<td align="center"><?php echo $data['JenisKelamin'];?></td>
						<td align="center">
							<?php 
								if($data['UmurTahun'] != 0 || $data['UmurTahun'] == null){
									echo $data['UmurTahun']." Th";
								}elseif($data['UmurTahun'] == 0 && $data['UmurBulan'] != ""){
									echo $data['UmurBulan']." Bl";
								}else{
									echo $data['UmurHari']." Hr";
								}	
							?>
						</td>
						<td align="left">
							<?php 
								if ($noindex == ''){
									echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
								}else{
									echo strtoupper($alamat);
								}
							?>
						</td>
						<td align="left"><?php echo str_replace('POLI','',$data['PoliPertama']);?></td>
						<td align="left"><?php echo $data['Asuransi'];?></td>
						<td align="center" class="str"><?php echo $noasuransi;?></td>
						<td align="center"><?php echo strtoupper($data['StatusKunjungan']);?></td>	
						<td align="right" class="str"><?php echo rupiah($data['TarifKarcis']);?></td>		
						<td align="center">
							<?php 
								if($data['AsalPasien'] == "1"){
									echo "KELAS BALITA";
								}elseif($data['AsalPasien'] == "2"){
									echo "KELAS IBU";
								}elseif($data['AsalPasien'] == "3"){
									echo "PENYULUHAN KELOMPOK";
								}elseif($data['AsalPasien'] == "4"){
									echo "PENYULUHAN KELUARGA";
								}elseif($data['AsalPasien'] == "5"){
									echo "POLINDES";
								}elseif($data['AsalPasien'] == "6"){
									echo "POSBINDU";
								}elseif($data['AsalPasien'] == "7"){
									echo "POSKESDES";
								}elseif($data['AsalPasien'] == "8"){
									echo "POSYANDU";
								}elseif($data['AsalPasien'] == "9"){
									echo "PUSKEL";
								}elseif($data['AsalPasien'] == "10"){
									echo "PUSKESMAS";
								}elseif($data['AsalPasien'] == "11"){
									echo "PUSTU";
								}elseif($data['AsalPasien'] == "12"){
									echo "STBM";
								}elseif($data['AsalPasien'] == "13"){
									echo "PERKESMAS";
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