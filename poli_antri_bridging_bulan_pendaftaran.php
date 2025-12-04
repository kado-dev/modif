<?php
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	$tanggal = date('Y-m-d');
	
	// Safe GET parameters
	$get_pelayanan = isset($_GET['pelayanan']) ? $_GET['pelayanan'] : '';
	$get_keydate1 = isset($_GET['keydate1']) ? $_GET['keydate1'] : '';
	$get_keydate2 = isset($_GET['keydate2']) ? $_GET['keydate2'] : '';
	$get_nama = isset($_GET['nama']) ? $_GET['nama'] : '';
	$get_statuspasien = isset($_GET['statuspasien']) ? $_GET['statuspasien'] : 'semua';
	$get_h = isset($_GET['h']) ? intval($_GET['h']) : 1;
	if($get_h < 1) $get_h = 1;
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PASIEN GAGAL BRIDGING PENDAFTARAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="poli_antri_bridging_bulan_pendaftaran"/>
						<input type="hidden" name="pelayanan" value="<?php echo htmlspecialchars($get_pelayanan);?>"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo htmlspecialchars($get_keydate1);?>" placeholder="Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo htmlspecialchars($get_keydate2);?>" placeholder="Tanggal Akhir" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($get_nama);?>" placeholder="Nama Pasien">
						</div>
						<div class="col-xl-2">
							<select name="statuspasien" class="form-control">
								<option value="semua" <?php if($get_statuspasien == 'semua'){echo "selected";}?>>Semua Kunjungan</option>
								<option value="1" <?php if($get_statuspasien == '1'){echo "selected";}?>>Kunjungan Sakit</option>
								<option value="2" <?php if($get_statuspasien == '2'){echo "selected";}?>>Kunjungan Sehat</option>
							</select>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=poli_antri_bridging_bulan_pendaftaran" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
							<a href="poli_antri_bridging_bulan_pendaftaran_excel.php?keydate1=<?php echo urlencode($get_keydate1);?>&keydate2=<?php echo urlencode($get_keydate2);?>&nama=<?php echo urlencode($get_nama);?>&statuspasien=<?php echo urlencode($get_statuspasien);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel-o"></span> Excel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<?php
	$keydate1 = mysqli_real_escape_string($koneksi, $get_keydate1);
	$keydate2 = mysqli_real_escape_string($koneksi, $get_keydate2);
	$nama = mysqli_real_escape_string($koneksi, $get_nama);
	$pelayanan_filter = mysqli_real_escape_string($koneksi, $get_pelayanan);
	$statuspasien = mysqli_real_escape_string($koneksi, $get_statuspasien);
	
	if($keydate1 != '' && $keydate2 != ''){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".strtoupper($kota);?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PASIEN GAGAL BRIDGING PENDAFTARAN BPJS</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo date('d-m-Y', strtotime($keydate1));?> s/d <?php echo date('d-m-Y', strtotime($keydate2));?></span>
		<br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">NO.</th>
							<th width="9%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">TANGGAL</th>
							<th width="9%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">NO.INDEX</th>
							<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">NAMA PASIEN</th>
							<th width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">L/P</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">PELAYANAN</th>
							<th width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">NO.JAMINAN</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">KETERANGAN</th>
							<th width="6%" class="noprint" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:5px;">OPSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 100;
						$mulai = ($get_h - 1) * $jumlah_perpage;
						
						// Build WHERE conditions
						$where_conditions = [
							"Asuransi LIKE 'BPJS%'",
							"TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2 23:59:59'",
							"(NoUrutBpjs = '' OR NoUrutBpjs IS NULL)" // Gagal bridging = tidak punya NoUrutBpjs
						];
						
						// Filter nama
						if($nama != ''){
							$where_conditions[] = "NamaPasien LIKE '%$nama%'";
						}
						
						// Filter pelayanan
						if($pelayanan_filter != ''){
							$where_conditions[] = "PoliPertama LIKE '%$pelayanan_filter%'";
						}
						
						// Filter status pasien dengan logic yang benar
						// Kunjungan Sakit = harus StatusPelayanan='Sudah'
						// Kunjungan Sehat = tidak perlu StatusPelayanan='Sudah'
						if($statuspasien == 'semua'){
							$where_conditions[] = "((StatusPasien = '1' AND StatusPelayanan = 'Sudah') OR StatusPasien = '2')";
						} elseif($statuspasien == '1'){
							$where_conditions[] = "StatusPasien = '1' AND StatusPelayanan = 'Sudah'";
						} else {
							$where_conditions[] = "StatusPasien = '2'";
						}
						
						$where_clause = implode(' AND ', $where_conditions);
						
						// Query utama dengan LIMIT untuk pagination
						$str_main = "SELECT NoRegistrasi, NoIndex, NamaPasien, JenisKelamin, TanggalRegistrasi, 
							PoliPertama, nokartu, KeteranganBridging, StatusPelayanan, StatusPasien
						FROM `$tbpasienrj` 
						WHERE $where_clause
						ORDER BY TanggalRegistrasi DESC, NamaPasien 
						LIMIT $mulai, ".($jumlah_perpage + 1);
						
						$query_main = mysqli_query($koneksi, $str_main);
						
						// Kumpulkan data
						$rows = [];
						if($query_main){
							while($row = mysqli_fetch_assoc($query_main)){
								$rows[] = $row;
							}
						}
						
						// Cek apakah ada halaman selanjutnya
						$has_more = count($rows) > $jumlah_perpage;
						if($has_more){
							array_pop($rows); // Hapus row extra
						}
						
						// Tampilkan data
						$no = $mulai;
						foreach($rows as $data){
							$no++;
							$noindex = $data['NoIndex'];
							$noindex2 = (strlen($noindex) == 24) ? substr($noindex, 14) : $noindex;
							$status_text = ($data['StatusPasien'] == '1') ? 'Sakit' : 'Sehat';
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:5px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:5px;"><?php echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>
								<td style="text-align:center; border:1px solid #000; padding:5px;"><?php echo $noindex2;?></td>
								<td style="text-align:left; border:1px solid #000; padding:5px;"><?php echo strtoupper($data['NamaPasien']);?></td>
								<td style="text-align:center; border:1px solid #000; padding:5px;"><?php echo $data['JenisKelamin'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:5px;"><?php echo $data['PoliPertama'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:5px; font-size:10px;"><?php echo $data['nokartu'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:5px; font-size:10px;"><?php echo $data['KeteranganBridging'];?></td>
								<td class="noprint" style="text-align:center; border:1px solid #000; padding:5px;">
								<?php if($data['StatusPelayanan'] == 'Sudah'){ ?>
									<a href="?page=poli_periksa_edit&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo urlencode($data['PoliPertama']);?>" class="btn btn-xs btn-info" target="_blank">EDIT</a>
								<?php } ?>
								</td>
							</tr>
						<?php
						}
						
						if(count($rows) == 0){
							echo "<tr><td colspan='9' style='text-align:center; padding:20px; border:1px solid #000;'>Tidak ada data pasien gagal bridging</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Pagination Prev/Next -->
	<ul class="pagination noprint">
		<?php
		$param_url = "page=poli_antri_bridging_bulan_pendaftaran&pelayanan=".urlencode($get_pelayanan)."&keydate1=$keydate1&keydate2=$keydate2&nama=".urlencode($nama)."&statuspasien=$statuspasien";
		
		if($get_h > 1){
			echo "<li><a href='?{$param_url}&h=".($get_h-1)."'>&laquo; Prev</a></li>";
		}
		
		echo "<li class='active'><span>Halaman $get_h</span></li>";
		
		if($has_more){
			echo "<li><a href='?{$param_url}&h=".($get_h+1)."'>Next &raquo;</a></li>";
		}
		?>
	</ul>
	<br>
	<?php
	}
	?>
</div>

<style>
@media print {
	.noprint { display: none !important; }
	.printheader { display: block !important; }
}
.printheader { display: none; }
</style>
