<?php
	include "otoritas.php";
	include "config/helper_report.php";
	
	// Default ke bulan dan tahun saat ini jika tidak ada parameter
	$bulan = isset($_GET['bulan']) && $_GET['bulan'] != '' ? $_GET['bulan'] : date('m');
	$tahun = isset($_GET['tahun']) && $_GET['tahun'] != '' ? $_GET['tahun'] : date('Y');
	$kategori = isset($_GET['kategori']) && $_GET['kategori'] != '' ? $_GET['kategori'] : 'Semua';
	
	// Tabel tbpasienperpegawai berdasarkan kodepuskesmas
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
?>
<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css">

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Kinerja Pegawai</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_tracking_pegawai"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($bulan == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($bulan == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($bulan == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($bulan == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($bulan == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($bulan == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($bulan == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($bulan == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($bulan == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($bulan == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($bulan == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($bulan == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($thn = 2021 ; $thn <= date('Y'); $thn++){
									?>
									<option value="<?php echo $thn;?>" <?php if($tahun == $thn){echo "SELECTED";}?>><?php echo $thn;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kategori" class="form-control">
								<option value="Semua" <?php if($kategori == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Pendaftaran" <?php if($kategori == 'Pendaftaran'){echo "SELECTED";}?>>Pendaftaran</option>
								<option value="Pemeriksaan" <?php if($kategori == 'Pemeriksaan'){echo "SELECTED";}?>>Pemeriksaan (1-5)</option>
								<option value="Lab" <?php if($kategori == 'Lab'){echo "SELECTED";}?>>Lab</option>
								<option value="Farmasi" <?php if($kategori == 'Farmasi'){echo "SELECTED";}?>>Farmasi</option>
							</select>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_tracking_pegawai" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_tracking_pegawai_excel.php?bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>&kategori=<?php echo $kategori;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	if($bulan != null AND $tahun != null){
	
	$where_periode = "MONTH(TanggalRegistrasi) = '$bulan' AND YEAR(TanggalRegistrasi) = '$tahun'";
	$filter_valid = "IS NOT NULL AND %s != '' AND %s != '-' AND %s != '--Pilih--'";
	
	// Build query berdasarkan kategori - OPTIMIZED: Langsung GROUP BY
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
	$data_pegawai = array(); // [nama_pegawai][hari] = jumlah
	$total_per_hari = array(); // [hari] = jumlah
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

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KINERJA PEGAWAI</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo nama_bulan($bulan);?> <?php echo $tahun;?> | Kategori: <?php echo $kategori;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Sumber Data</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $tbpasienperpegawai;?></td>
				</tr>
			</table>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table style="font-size:10px; width:300px;">
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
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pegawai</th>
						<?php for($d = 1; $d <= 31; $d++){ ?>
							<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
						<?php } ?>
							<th width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
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
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $no;?></td>
								<td style="border:1px solid #000; padding:2px; font-size:10px;"><?php echo $nama;?></td>
								<?php 
								for($d = 1; $d <= 31; $d++){
									$jml = isset($data_pegawai[$nama][$d]) ? $data_pegawai[$nama][$d] : 0;
									$jml_total += $jml;
								?>
								<td style="text-align:center; border:1px solid #000; padding:2px; font-size:10px;"><?php echo ($jml > 0) ? $jml : '';?></td>
								<?php } ?>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><b><?php echo $jml_total;?></b></td>
							</tr>
						<?php } ?>
						
						<!-- Row Total -->
						<tr style="background:#f0f0f0; border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:2px;"><b>#</b></td>
							<td style="border:1px solid #000; padding:2px;"><b>Total</b></td>
							<?php 
							$grand_total = 0;
							for($d = 1; $d <= 31; $d++){
								$jml = isset($total_per_hari[$d]) ? $total_per_hari[$d] : 0;
								$grand_total += $jml;
							?>
							<td style="text-align:center; border:1px solid #000; padding:2px;"><b><?php echo ($jml > 0) ? $jml : '';?></b></td>
							<?php } ?>
							<td style="text-align:center; border:1px solid #000; padding:2px;"><b><?php echo $grand_total;?></b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Keterangan -->
	<div class="row noprint" style="margin-top:20px;">
		<div class="col-sm-12">
			<div class="alert alert-info">
				<b>Keterangan Field:</b>
				<ul style="margin-bottom:0;">
					<li><b>Pendaftaran</b> - Petugas pendaftaran pasien</li>
					<li><b>Pemeriksaan (1-5)</b> - NamaPegawai1 s/d NamaPegawai5 (Tenaga Medis & Paramedis)</li>
					<li><b>Lab</b> - Petugas Laboratorium</li>
					<li><b>Farmasi</b> - Petugas Farmasi</li>
				</ul>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>
