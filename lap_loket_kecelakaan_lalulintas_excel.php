<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	// get data
	$opsiform = $_GET['opsiform'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kd = $_GET['kd'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$asalpasien = $_GET['asalpasien'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lap_Kecelakaan_Lalulintas (".$namapuskesmas." ".$bulan."-".$tahun.").xls");
	if(isset($tahun)){
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
</style>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN KECELAKAAN LALU LINTAS</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tahun." ".$tahun;?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan/Desa</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
			</tr>
		</table>
	</div>	
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2">No.</th>
					<th rowspan="2">Hari</th>
					<th rowspan="2">Tanggal</th>
					<th colspan="2">Jam</th>
					<th rowspan="2">Jenis Kendaraan<br> Yang Terlibat</th>
					<th rowspan="2">No.Polisi</th>
					<th rowspan="2">Lokasi Kejadian</th>
					<th colspan="5">Identitas Pasien</th>
					<th rowspan="2">Diagnosis</th>
					<th rowspan="2">Therapy</th>
					<th colspan="3">Kondisi Akhir</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>Kecelakaan</th>
					<th>Berobat</th>
					<th>Nama</th>
					<th>Umur</th>
					<th>JK</th>
					<th>Alamat</th>
					<th>Telp.</th>
					<th>Pulang</th>
					<th>Rujuk</th>
					<th>Meninggal</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";			
					if ($asalpasien == 'semua_pasien'){
						$str = "SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
					}else{
						$str = "SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND AsalPasien='$asalpasien'";
					}	
				}else{
					$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
					$tbpasienrj2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
					
					if ($asalpasien == 'semua_pasien'){
						$str = "SELECT * FROM(
						SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
						FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
						UNION
						SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
						FROM `$tbpasienrj2`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
						) tbalias";
					}else{
						$str = "SELECT * FROM(
						SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu
						FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
						UNION
						SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu
						FROM `$tbpasienrj2`
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
						) tbalias";
					}
				}
				$str2 = $str." ORDER BY Tanggalregistrasi, NoRegistrasi DESC";
				// echo $str2;
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$asuransi = $data['Asuransi'];
					$nomorasuransi = $data['nokartu'];
				
					if(strlen($nocm) == 23){
						$thn = substr($data['NoCM'],12,4);
						$tbpasien='tbpasien_'.$thn;
						$dt_nojaminan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoAsuransi FROM `$tbpasien` WHERE NoCM = '$nocm'"));
						$nocm = $dt_nojaminan['NoAsuransi'];
					}else{
						$nocm = $data['NoCM'];
					}
									
					// tbkk
					$strkk = "SELECT Alamat, RT, RW FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
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
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalRegistrasi'];?></td>
						<td><?php echo substr($data['NoRegistrasi'],19);?></td>
						<?php if($kota != 'KABUPATEN KUTAI KARTANEGARA'){ ?>
						<td>
							<?php
								if ($noindex == ''){
									echo $noindex = '0';
								}else{
									echo $noindex = substr($noindex,14);
								}
							?>
						</td>
						<?php } ?>
						<td>
							<?php 
								if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
									$norms = substr($data['NoRM'],-6);
								}elseif ($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
									$norms = substr($data['NoRM'],-6);
								}elseif ($_SESSION['kota'] == 'KABUPATEN BANDUNG'){
									$norms = substr($data['NoRM'],-6);
								}elseif ($_SESSION['kota'] == 'KOTA BANDUNG'){
									$norms = substr($data['NoRM'],-6);	
								}else{
									if(strlen($data['NoRM']) == 22){
										$norms = substr($data['NoRM'],-11);
									}elseif(strlen($data['NoRM']) == 20){
										$norms = substr($data['NoRM'],-9);
									}elseif(strlen($data['NoRM']) == 17){
										$norms = substr($data['NoRM'],-6);
									}elseif(strlen($data['NoRM']) == 19){
										$norms = substr($data['NoRM'],-8);
									}
								}
								echo $norms;
							?>
						</td>
						<td><?php echo strtoupper($data['NamaPasien']);?></td>
						<td><?php echo $data['JenisKelamin'];?></td>
						<td><?php echo $data['UmurTahun']."Th";?><!--, <?php echo $data['UmurBulan'];?> Bl,  <?php echo $data['UmurHari'];?> Hr--></td>
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