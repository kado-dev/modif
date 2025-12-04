<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$statuspasien = $_GET['statuspasien'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kunjungan_CaraBayar (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN BARU/LAMA (CARA BAYAR)</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $_GET['tahun'];?></p><br/>
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
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kelurahan);?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kecamatan);?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2">NO.</th>
					<th rowspan="2">BULAN</th>
					<th colspan="2">BPJS PBI</th>
					<th colspan="2">BPJS NON PBI</th>
					<th colspan="2">UMUM</th>
					<th colspan="2">GRATIS / SKTM</th>
					<th colspan="2">JUMLAH</th>
				</tr>
				<tr>
					<th>B</th>
					<th>L</th>
					<th>B</th>
					<th>L</th>
					<th>B</th>
					<th>L</th>
					<th>B</th>
					<th>L</th>
					<th>B</th>
					<th>L</th>
				</tr>
			</thead>
			<tbody>
				<?php					
				$tahuns = $_GET['tahun'];
				$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
				$no = 1;
										
				foreach($array_bulan as $namebulan => $nobulan ){
					$pbi_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Baru'"))['jml'];
					$pbi_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Lama'"))['jml'];
					$nonpbi_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Baru'"))['jml'];
					$nonpbi_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND  MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Lama'"))['jml'];
					$umum_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Baru'"))['jml'];
					$umum_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Lama'"))['jml'];
					$gratis_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Baru'"))['jml'];
					$gratis_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Lama'"))['jml'];
					$jml_b = $pbi_b + $nonpbi_b + $umum_b + $gratis_b;
					$jml_l = $pbi_l + $nonpbi_l + $umum_l + $gratis_l;
				?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $namebulan;?></td>
						<td><?php echo $pbi_b;?></td>
						<td><?php echo $pbi_l;?></td>
						<td><?php echo $nonpbi_b;?></td>
						<td><?php echo $nonpbi_l;?></td>
						<td><?php echo $umum_b;?></td>
						<td><?php echo $umum_l;?></td>
						<td><?php echo $gratis_b;?></td>
						<td><?php echo $gratis_l;?></td>
						<td><?php echo $jml_b;?></td>
						<td><?php echo $jml_l;?></td>
					</tr>
				<?php
				$no = $no + 1;	
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>