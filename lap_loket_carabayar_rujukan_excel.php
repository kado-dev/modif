<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	// get data
	$tahun = $_GET['tahun'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lap_Kunjungan_&_Rujukan (".$namapuskesmas." ".$sumberanggaran." ".$bulan."-".$tahun.").xls");
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>KUNJUNGAN & RUJUKAN RAWAT JALAN</b></span><br>
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
					<th rowspan="4">No.</th>
					<th rowspan="4">BULAN</th>
					<th colspan="11">KUNJUNGAN PASIEN</th>
					<th colspan="5">RUJUKAN PASIEN</th>
					<th rowspan="4">KUNJUNGAN SEHAT</th>
				</tr>
				<tr>
					<th colspan="4">BPJS</th>
					<th rowspan="2" colspan="2">UMUM</th>
					<th rowspan="2" colspan="2">GRATIS / SKTM</th>
					<th rowspan="2" colspan="2">JUMLAH</th>
					<th rowspan="2">TOTAL</th>
					<th rowspan="3">PBI</th>
					<th rowspan="3">NON PBI</th>
					<th rowspan="3">UMUM</th>
					<th rowspan="3">KTP/SKTM</th>
					<th rowspan="3">JUMLAH</th>
				</tr>
				<tr>
					<th colspan="2">PBI</th>
					<th colspan="2">NON PBI</th>
				</tr>
				<tr>
					<th>BARU</th>
					<th>LAMA</th>
					<th>BARU</th>
					<th>LAMA</th>
					<th>BARU</th>
					<th>LAMA</th>
					<th>BARU</th>
					<th>LAMA</th>
					<th>BARU</th>
					<th>LAMA</th>
				</tr>
			</thead>
			
			<tbody style="font-size:10px;">
				<?php					
				$tahuns = $_GET['tahun'];
				$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
				$no = 1;
				
				foreach($array_bulan as $namebulan => $nobulan ){
					$bpjs_pbi_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Baru'"))['jml'];
					$bpjs_pbi_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Lama'"))['jml'];
					$bpjs_nonpbi_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Baru'"))['jml'];
					$bpjs_nonpbi_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Lama'"))['jml'];
					$umum_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Baru'"))['jml'];
					$umum_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Lama'"))['jml'];
					$ktp_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Baru'"))['jml'];
					$ktp_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Lama'"))['jml'];
					$jumlah_baru = $bpjs_pbi_baru + $bpjs_nonpbi_baru + $umum_baru + $ktp_baru;
					$jumlah_lama = $bpjs_pbi_lama + $bpjs_nonpbi_lama + $umum_lama + $ktp_lama;
					$jumlah_total = $jumlah_baru + $jumlah_lama;
					$rujukan_pbi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND `StatusPulang`='4'"))['jml'];
					$rujukan_nonpbi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND `StatusPulang`='4'"))['jml'];
					$rujukan_umum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND `StatusPulang`='4'"))['jml'];
					$rujukan_ktp = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND `StatusPulang`='4'"))['jml'];
					$rujukan_jumlah = $rujukan_pbi + $rujukan_nonpbi + $rujukan_umum + $rujukan_ktp;
					$kunjungan_sehat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND StatusPasien='2'"))['jml'];
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $namebulan;?></td>
						<td><?php echo $bpjs_pbi_baru;?></td>
						<td><?php echo $bpjs_pbi_lama;?></td>
						<td><?php echo $bpjs_nonpbi_baru;?></td>
						<td><?php echo $bpjs_nonpbi_lama;?></td>
						<td><?php echo $umum_baru;?></td>
						<td><?php echo $umum_lama;?></td>
						<td><?php echo $ktp_baru;?></td>
						<td><?php echo $ktp_lama;?></td>
						<td><?php echo $jumlah_baru;?></td>
						<td><?php echo $jumlah_lama;?></td>
						<td><?php echo $jumlah_total;?></td>
						<td><?php echo $rujukan_pbi;?></td>
						<td><?php echo $rujukan_nonpbi;?></td>
						<td><?php echo $rujukan_umum;?></td>
						<td><?php echo $rujukan_ktp;?></td>
						<td><?php echo $rujukan_jumlah;?></td>
						<td><?php echo $kunjungan_sehat;?></td>
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