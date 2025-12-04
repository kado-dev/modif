<?php
	include_once('config/koneksi.php');
	session_start();
	// include "otoritas.php";
	// include "config/helper.php";
	// include "config/helper_report.php";
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kodepuskesmas = $_GET['kd'];	
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	// tbpuskesmas
	$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPuskesmas` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'" ));
	
	header("Content-type: application/vnd-ms-excel");
	if($tahun == $tahunini){
		header("Content-Disposition: attachment; filename=Laporan_Registrasi_Kunjungan_Puskesmas (".$bulanini.'-'.$tahunini.'-'.$dtpuskesmas['NamaPuskesmas'].").xls");
	}else{
		header("Content-Disposition: attachment; filename=Laporan_Registrasi_Kunjungan_Puskesmas (".$bulan.'-'.$tahun.'-'.$dtpuskesmas['NamaPuskesmas'].").xls");
	}
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
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$dtpuskesmas['NamaPuskesmas'];?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KUNJUNGAN PASIEN</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $dtpuskesmas['NamaPuskesmas'];?></h5 ></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kelurahan;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kecamatan;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px dashed #000;">
					<th width="3%" rowspan="2">No.</th>
					<th width="8%" rowspan="2">Tanggal</th>
					<th width="5%" rowspan="2">No.Reg</th>
					<th width="6%" rowspan="2">No.Index</th>
					<th width="6%" rowspan="2">No.RM</th>
					<th width="10%" rowspan="2">Nama Pasien</th>
					<th width="2%" rowspan="2">L/P</th>
					<th width="4%" rowspan="2">Umur</th>
					<th width="10%" rowspan="2">Alamat</th>
					<th width="6%" rowspan="2">Poli</th>
					<th colspan="2">Cara Bayar/Jaminan/Asuransi</th>
					<th width="3%" rowspan="2">Kunj.</th>
					<th width="5%" rowspan="2">Tarif</th>
				</tr>
				<tr>
					<th width="5%">Jaminan</th>
					<th width="5%">No.Jaminan</th>
				</tr>
			</thead>
			<tbody style="font-size:9px;">
				<?php
				if($tahun == $tahunini){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahunini'";
					$tbpasienrj = 'tbpasienrj_'.$bulanini;
				}else{
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
					$tbpasienrj = 'tbpasienrj_'.$bulan.'_bc';
				}		
					
				$str = "SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
				$str2 = $str." order by Tanggalregistrasi, NoRegistrasi";
				// echo $str2;
				// die();
				
				$no = 0;
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
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalRegistrasi'];?></td>
						<td><?php echo substr($data['NoRegistrasi'],19);?></td>
						<td>
							<?php
								if ($noindex == ''){
									echo $noindex = '0';
								}else{
									echo $noindex = substr($noindex,14);
								}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
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
						<td><?php echo $data['NamaPasien'];?></td>
						<td><?php echo $data['JenisKelamin'];?></td>
						<td><?php echo $data['UmurTahun']."Th ".$data['UmurBulan']."Bl ".$data['UmurHari']."Hr"?></td>
						<td>
							<?php 
								if ($noindex == ''){
									echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
								}else{
									echo $alamat;
								}
							?>
						</td>
						<td><?php echo $data['PoliPertama'];?></td>
						<td><?php echo $data['Asuransi'];?></td>
						<td><?php echo $noasuransi;?></td>
						<td><?php echo $data['StatusKunjungan'];?></td>	
						<td><?php echo $data['TarifKarcis'];?></td>		
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