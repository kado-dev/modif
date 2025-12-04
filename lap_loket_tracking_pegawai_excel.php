<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	
	$hariini = date('d-m-Y');
	$bulan = isset($_GET['bulan']) && $_GET['bulan'] != '' ? $_GET['bulan'] : date('m');
	$tahun = isset($_GET['tahun']) && $_GET['tahun'] != '' ? $_GET['tahun'] : date('Y');
	$kategori = isset($_GET['kategori']) && $_GET['kategori'] != '' ? $_GET['kategori'] : 'Semua';
	
	// Tabel tbpasienperpegawai berdasarkan kodepuskesmas
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kinerja_Pegawai_".nama_bulan($bulan)."_".$tahun."_".$kategori.".xls");
	
	// Build query berdasarkan kategori - OPTIMIZED
	$where_periode = "MONTH(TanggalRegistrasi) = '$bulan' AND YEAR(TanggalRegistrasi) = '$tahun'";
	$queries = array();
	
	if($kategori == 'Pendaftaran' || $kategori == 'Semua'){
		$queries[] = "SELECT Pendaftaran AS NamaPegawai, DAY(TanggalRegistrasi) AS Hari, COUNT(*) AS Jumlah 
			FROM `$tbpasienperpegawai` 
			WHERE $where_periode AND Pendaftaran IS NOT NULL AND Pendaftaran != '' AND Pendaftaran != '-'
			GROUP BY Pendaftaran, DAY(TanggalRegistrasi)";
	}
	
	if($kategori == 'Pemeriksaan' || $kategori == 'Semua'){
		for($i = 1; $i <= 5; $i++){
			$queries[] = "SELECT NamaPegawai$i AS NamaPegawai, DAY(TanggalRegistrasi) AS Hari, COUNT(*) AS Jumlah 
				FROM `$tbpasienperpegawai` 
				WHERE $where_periode AND NamaPegawai$i IS NOT NULL AND NamaPegawai$i != '' AND NamaPegawai$i != '-' AND NamaPegawai$i != '--Pilih--'
				GROUP BY NamaPegawai$i, DAY(TanggalRegistrasi)";
		}
	}
	
	if($kategori == 'Lab' || $kategori == 'Semua'){
		$queries[] = "SELECT Lab AS NamaPegawai, DAY(TanggalRegistrasi) AS Hari, COUNT(*) AS Jumlah 
			FROM `$tbpasienperpegawai` 
			WHERE $where_periode AND Lab IS NOT NULL AND Lab != '' AND Lab != '-' AND Lab != '--Pilih--'
			GROUP BY Lab, DAY(TanggalRegistrasi)";
	}
	
	if($kategori == 'Farmasi' || $kategori == 'Semua'){
		$queries[] = "SELECT Farmasi AS NamaPegawai, DAY(TanggalRegistrasi) AS Hari, COUNT(*) AS Jumlah 
			FROM `$tbpasienperpegawai` 
			WHERE $where_periode AND Farmasi IS NOT NULL AND Farmasi != '' AND Farmasi != '-' AND Farmasi != '--Pilih--'
			GROUP BY Farmasi, DAY(TanggalRegistrasi)";
	}
	
	$union_sql = implode(" UNION ALL ", $queries);
	
	// Ambil semua data sekaligus dan simpan ke array
	$data_pegawai = array();
	$total_per_hari = array();
	$daftar_pegawai = array();
	
	$sql_final = "SELECT NamaPegawai, Hari, SUM(Jumlah) AS Total FROM ($union_sql) AS combined GROUP BY NamaPegawai, Hari ORDER BY NamaPegawai, Hari";
	$result = mysqli_query($koneksi, $sql_final);
	
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$nama = strtoupper($row['NamaPegawai']);
			$hari = (int)$row['Hari'];
			$total = (int)$row['Total'];
			
			if(!isset($data_pegawai[$nama])){
				$data_pegawai[$nama] = array();
				$daftar_pegawai[] = $nama;
			}
			
			if(!isset($data_pegawai[$nama][$hari])){
				$data_pegawai[$nama][$hari] = 0;
			}
			$data_pegawai[$nama][$hari] += $total;
			
			if(!isset($total_per_hari[$hari])){
				$total_per_hari[$hari] = 0;
			}
			$total_per_hari[$hari] += $total;
		}
	}
	
	sort($daftar_pegawai);
?>
<html>
<head>
<style>
	body { font-family: Arial, sans-serif; font-size: 10px; }
	.header { text-align: center; margin-bottom: 10px; }
	.header h3 { margin: 2px; font-size: 14px; }
	.header p { margin: 2px; font-size: 11px; }
	table { border-collapse: collapse; width: 100%; }
	th, td { border: 1px solid #000; padding: 3px; text-align: center; }
	th { background-color: #4472C4; color: white; font-weight: bold; }
	.nama { text-align: left; }
	.total-row { background-color: #D9E2F3; font-weight: bold; }
	.jumlah { font-weight: bold; background-color: #FFF2CC; }
</style>
</head>
<body>

<div class="header">
	<h3>PEMERINTAH <?php echo $kota;?></h3>
	<h3>DINAS KESEHATAN</h3>
	<h3>PUSKESMAS <?php echo $namapuskesmas;?></h3>
	<p><?php echo $alamat;?></p>
	<hr>
	<h3>LAPORAN KINERJA PEGAWAI</h3>
	<p>Periode: <?php echo nama_bulan($bulan);?> <?php echo $tahun;?> | Kategori: <?php echo $kategori;?></p>
</div>

<table>
	<tr>
		<td colspan="2"><strong>Kode Puskesmas:</strong> <?php echo $kodepuskesmas;?></td>
		<td colspan="16"><strong>Kelurahan:</strong> <?php echo $kelurahan;?></td>
		<td colspan="16"><strong>Kecamatan:</strong> <?php echo $kecamatan;?></td>
	</tr>
	<tr>
		<td colspan="2"><strong>Sumber Data:</strong></td>
		<td colspan="32"><?php echo $tbpasienperpegawai;?></td>
	</tr>
</table>
<br>

<table>
	<thead>
		<tr>
			<th width="3%">No</th>
			<th width="15%">Nama Pegawai</th>
			<?php for($d = 1; $d <= 31; $d++){ ?>
			<th width="2%"><?php echo $d;?></th>
			<?php } ?>
			<th width="4%">Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($daftar_pegawai) == 0){
			echo "<tr><td colspan='34' style='text-align:center; padding:20px;'>Tidak ada data untuk periode ini</td></tr>";
		}
		
		$no = 0;
		foreach($daftar_pegawai as $nama){
			$no++;
			$jml_total = 0;
		?>
		<tr>
			<td><?php echo $no;?></td>
			<td class="nama"><?php echo $nama;?></td>
			<?php 
			for($d = 1; $d <= 31; $d++){
				$jml = isset($data_pegawai[$nama][$d]) ? $data_pegawai[$nama][$d] : 0;
				$jml_total += $jml;
			?>
			<td><?php echo ($jml > 0) ? $jml : '';?></td>
			<?php } ?>
			<td class="jumlah"><?php echo $jml_total;?></td>
		</tr>
		<?php } ?>
		
		<!-- Row Total -->
		<tr class="total-row">
			<td>#</td>
			<td class="nama">Total</td>
			<?php 
			$grand_total = 0;
			for($d = 1; $d <= 31; $d++){
				$jml = isset($total_per_hari[$d]) ? $total_per_hari[$d] : 0;
				$grand_total += $jml;
			?>
			<td><?php echo ($jml > 0) ? $jml : '';?></td>
			<?php } ?>
			<td class="jumlah"><?php echo $grand_total;?></td>
		</tr>
	</tbody>
</table>

<br>
<table>
	<tr>
		<td colspan="34">
			<strong>Keterangan Field yang Dihitung:</strong><br>
			- Pendaftaran: Petugas pendaftaran pasien<br>
			- Pemeriksaan (1-5): NamaPegawai1 s/d NamaPegawai5 (Tenaga Medis & Paramedis)<br>
			- Lab: Petugas Laboratorium<br>
			- Farmasi: Petugas Farmasi
		</td>
	</tr>
	<tr>
		<td colspan="34">
			<em>Diekspor pada: <?php echo date('d-m-Y H:i:s');?></em>
		</td>
	</tr>
</table>

</body>
</html>
