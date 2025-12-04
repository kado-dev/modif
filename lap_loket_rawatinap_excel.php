<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	// get data
	$tahun = $_GET['tahun'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lap_Pelayanan_Rawat_Inap (".$namapuskesmas." ".$sumberanggaran." ".$bulan."-".$tahun.").xls");
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>PELAYANAN RAWAT INAP</b></span><br>
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
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">BULAN</th>
					<th colspan="4">JUMLAH KUNJUNGAN</th>
					<th colspan="4">JUMLAH PASIEN DIRUJUK</th>
					<th rowspan="2">JUMLAH HARI PERAWATAN</th>
					<th rowspan="2">BOR</th>
					<th rowspan="2">LOS</th>
					<th rowspan="2">TOI</th>
					<th rowspan="2">BTO</th>
				</tr>
				<tr>
					<th>UMUM</th>
					<th>BPJS</th>
					<th>KTP/SKTM</th>
					<th>JUMLAH</th>
					<th>UMUM</th>
					<th>BPJS</th>
					<th>KTP/SKTM</th>
					<th>JUMLAH</th>
				</tr>
			</thead>
			<tbody>
				<?php					
				$tahuns = $_GET['tahun'];
				$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
				$no = 1;
				
				foreach($array_bulan as $namebulan => $nobulan ){
					$kunjungan_umum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi='UMUM' AND StatusPasien = '2'"))['jml'];
					$kunjungan_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi like '%BPJS%' AND StatusPasien = '2'"))['jml'];
					$kunjungan_sktm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND (Asuransi='SKTM' OR Asuransi='GRATIS') AND StatusPasien = '2'"))['jml'];
					$kunjungan_jumlah = $kunjungan_umum + $kunjungan_bpjs + $kunjungan_sktm;
					$kunjungan_rujuk_umum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi='UMUM' AND StatusPasien = '2' AND `StatusPulang`='4'"))['jml'];
					$kunjungan_rujuk_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi like '%BPJS%' AND StatusPasien = '2' AND `StatusPulang`='4'"))['jml'];
					$kunjungan_rujuk_sktm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND (Asuransi='SKTM' OR Asuransi='GRATIS') AND StatusPasien = '2' AND `StatusPulang`='4'"))['jml'];
					$kunjungan_rujuk_jumlah = $kunjungan_rujuk_umum + $kunjungan_rujuk_bpjs + $kunjungan_rujuk_sktm;
					?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $namebulan;?></td>
						<td><?php echo $kunjungan_umum;?></td>
						<td><?php echo $kunjungan_bpjs;?></td>
						<td><?php echo $kunjungan_sktm;?></td>
						<td><?php echo $kunjungan_jumlah;?></td>
						<td><?php echo $kunjungan_rujuk_umum;?></td>
						<td><?php echo $kunjungan_rujuk_bpjs;?></td>
						<td><?php echo $kunjungan_rujuk_sktm;?></td>
						<td><?php echo $kunjungan_rujuk_jumlah;?></td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
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