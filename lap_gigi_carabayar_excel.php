<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	include_once('config/helper_report.php');
	
	$kota = isset($_SESSION['kota']) ? $_SESSION['kota'] : '';
	$kelurahan = isset($_SESSION['kelurahan']) ? $_SESSION['kelurahan'] : '';
	$kecamatan = isset($_SESSION['kecamatan']) ? $_SESSION['kecamatan'] : '';
	$alamat = isset($_SESSION['alamat']) ? $_SESSION['alamat'] : '';
	
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : date('m');
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : date('Y');
					
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Gigi_CaraBayar_".$namapuskesmas."_".$bulan."-".$tahun.".xls");
	
	if($bulan != '' && $tahun != ''):
?>
<html>
<head>
<style>
table { border-collapse: collapse; font-family: Tahoma; font-size: 10px; }
th { background: #5a5a5a; color: #fff; font-size: 9px; }
td, th { border: 1px solid #000; padding: 3px; }
.header { text-align: center; margin-bottom: 10px; }
</style>
</head>
<body>

<div class="header">
	<b>PEMERINTAH <?php echo strtoupper($kota);?></b><br>
	<b>DINAS KESEHATAN</b><br>
	<b>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></b><br>
	<?php echo $alamat;?>
	<hr>
	<b>LAPORAN CARA BAYAR PELAYANAN GIGI</b><br>
	Periode: <?php echo nama_bulan($bulan);?> <?php echo $tahun;?>
</div>

<table style="font-size:10px; margin-bottom:10px;">
	<tr><td>Kode Puskesmas</td><td>:</td><td><?php echo $kodepuskesmas;?></td></tr>
	<tr><td>Puskesmas</td><td>:</td><td><?php echo $namapuskesmas;?></td></tr>
</table>

<?php
// ============ OPTIMASI: Fetch semua data dalam 1 query ============
$date_start = "$tahun-$bulan-01";
$date_end = "$tahun-$bulan-31 23:59:59";

// Query 1: Ambil daftar asuransi
$asuransi_list = [];
$q_asuransi = mysqli_query($koneksi, "SELECT Asuransi FROM `tbasuransi` ORDER BY Asuransi ASC");
if($q_asuransi){
	while($r = mysqli_fetch_assoc($q_asuransi)){
		$asuransi_list[] = $r['Asuransi'];
	}
}

// Query 2: Ambil SEMUA data sekaligus dengan GROUP BY
$data_gigi = [];
$total_per_hari = [];

$str_all = "SELECT Asuransi, DAY(TanggalRegistrasi) as Hari, COUNT(NoRegistrasi) as Jml 
	FROM `$tbpasienrj` 
	WHERE TanggalRegistrasi BETWEEN '$date_start' AND '$date_end'
	AND PoliPertama = 'POLI GIGI'
	GROUP BY Asuransi, DAY(TanggalRegistrasi)";

$q_all = mysqli_query($koneksi, $str_all);
if($q_all){
	while($r = mysqli_fetch_assoc($q_all)){
		$asuransi = $r['Asuransi'];
		$hari = $r['Hari'];
		$jml = $r['Jml'];
		
		if(!isset($data_gigi[$asuransi])){
			$data_gigi[$asuransi] = [];
		}
		$data_gigi[$asuransi][$hari] = $jml;
		
		if(!isset($total_per_hari[$hari])){
			$total_per_hari[$hari] = 0;
		}
		$total_per_hari[$hari] += $jml;
	}
}
// ============ END OPTIMASI ============
?>

<table width="100%">
	<thead>
		<tr>
			<th>NO.</th>
			<th>CARA BAYAR</th>
			<?php for($d = 1; $d <= 31; $d++): ?>
			<th><?php echo $d;?></th>
			<?php endfor; ?>
			<th>JUMLAH</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 0;
		$grand_total = 0;
		
		foreach($asuransi_list as $asuransi):
			$no++;
			$jml_row = 0;
		?>
		<tr>
			<td align="right"><?php echo $no;?></td>
			<td><?php echo htmlspecialchars($asuransi);?></td>
			<?php 
			for($d = 1; $d <= 31; $d++):
				$count = isset($data_gigi[$asuransi][$d]) ? $data_gigi[$asuransi][$d] : 0;
				$jml_row += $count;
			?>
			<td align="right"><?php echo $count > 0 ? $count : '-';?></td>
			<?php endfor; ?>
			<td align="right" style="font-weight:bold;"><?php echo $jml_row;?></td>
		</tr>
		<?php 
			$grand_total += $jml_row;
		endforeach; 
		?>
		<tr style="background:#f0f0f0; font-weight:bold;">
			<td align="right">#</td>
			<td align="right">TOTAL</td>
			<?php 
			for($d = 1; $d <= 31; $d++):
				$count = isset($total_per_hari[$d]) ? $total_per_hari[$d] : 0;
			?>
			<td align="right"><?php echo $count > 0 ? $count : '-';?></td>
			<?php endfor; ?>
			<td align="right"><?php echo number_format($grand_total);?></td>
		</tr>
	</tbody>
</table>

</body>
</html>
<?php
	endif;
?>