<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Sanitize inputs
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : date('m');
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : date('Y');
	$h = isset($_GET['h']) ? (int)$_GET['h'] : 1;
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER LABORATORIUM</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_laboratorium"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<?php
								$nama_bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
								foreach($nama_bulan as $key => $val):
								?>
								<option value="<?php echo $key;?>" <?php if($bulan == $key) echo "SELECTED";?>><?php echo $val;?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php for($t = 2016; $t <= date('Y'); $t++): ?>
								<option value="<?php echo $t;?>" <?php if($tahun == $t) echo "SELECTED";?>><?php echo $t;?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="col-xl-7">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_laboratorium" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_laboratorium_excel.php?bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>	

	<?php
	if($bulan != '' && $tahun != ''):
		
		// Pagination
		$jumlah_perpage = 50;
		if($h <= 1) {
			$mulai = 0;
			$h = 1;
		} else {
			$mulai = $jumlah_perpage * $h - $jumlah_perpage;
		}
		
		// Date range
		$date_start = "$tahun-$bulan-01";
		$date_end = "$tahun-$bulan-31 23:59:59";
	?>
	
	<div class="printheader" style="display:none;">
		<span class="font14"><b>DINAS KESEHATAN <?php echo strtoupper($kota);?></b></span><br>
		<span class="font14"><b>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10"><?php echo $alamat;?></span>
		<hr style="border:1px solid #000">
		<span class="font14"><b>REGISTER LABORATORIUM</b></span><br>
		<span class="font11">Periode: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
	</div>

	<!--data registrasi-->
	<div class="noprint">
		<div class="table-responsive noprint">
			<table class="table-judul-laporan" style="font-size:10px;">
				<thead>
					<tr style="border:1px solid #000;">
						<th rowspan="2">No.</th>
						<th rowspan="2">Tanggal</th>
						<th rowspan="2">No.Reg</th>
						<th rowspan="2">No.Index</th>
						<th rowspan="2">Nama Pasien</th>
						<th colspan="2">Umur</th>
						<th rowspan="2">Alamat</th>
						<th rowspan="2">Pemeriksaan</th>
						<th rowspan="2">Hasil</th>
						<th colspan="2">Rujuk</th>
						<th rowspan="2">Jaminan</th>
						<th rowspan="2">Ket.</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th>L</th>
						<th>P</th>
						<th>Ya</th>
						<th>Tidak</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// Query utama dengan JOIN ke tbpasienrj
					$str_main = "SELECT a.TanggalPeriksa, a.NoPemeriksaan, a.NoIndex, a.Anamnesa, a.Hasil,
						b.NamaPasien, b.JenisKelamin, b.UmurTahun, b.StatusPulang, b.Asuransi
						FROM `tbpolilaboratorium` a 
						INNER JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi
						WHERE a.TanggalPeriksa BETWEEN '$date_start' AND '$date_end'
						ORDER BY a.TanggalPeriksa ASC 
						LIMIT $mulai, ".($jumlah_perpage + 1);
					
					$query_main = mysqli_query($koneksi, $str_main);
					
					// Kumpulkan data
					$rows = [];
					$noregistrasi_list = [];
					$noindex_list = [];
					
					if($query_main){
						while($row = mysqli_fetch_assoc($query_main)){
							$rows[] = $row;
							$noregistrasi_list[$row['NoPemeriksaan']] = true;
							$noindex_list[$row['NoIndex']] = true;
						}
					}
					
					// Check if there's next page
					$has_next = count($rows) > $jumlah_perpage;
					if($has_next) array_pop($rows);
					
					// Batch queries
					$kk_data = [];
					$pegawai_data = [];
					$tindakan_data = [];
					
					if(!empty($rows)){
						$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
						$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
						
						// Batch query tbkk
						$q_kk = mysqli_query($koneksi, "SELECT NoIndex, Alamat, RT, RW FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
						if($q_kk){
							while($r = mysqli_fetch_assoc($q_kk)){
								$kk_data[$r['NoIndex']] = $r;
							}
						}
						
						// Batch query tbpasienperpegawai
						$q_peg = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPegawai1, NamaPegawai2 
							FROM `$tbpasienperpegawai` WHERE NoRegistrasi IN ($noreg_in)");
						if($q_peg){
							while($r = mysqli_fetch_assoc($q_peg)){
								$pegawai_data[$r['NoRegistrasi']] = $r;
							}
						}
						
						// Batch query tbtindakanpasiendetail
						$q_tdk = mysqli_query($koneksi, "SELECT NoRegistrasi, KodeTindakan 
							FROM `tbtindakanpasiendetail` WHERE NoRegistrasi IN ($noreg_in)");
						if($q_tdk){
							while($r = mysqli_fetch_assoc($q_tdk)){
								if(!isset($tindakan_data[$r['NoRegistrasi']])){
									$tindakan_data[$r['NoRegistrasi']] = [];
								}
								$tindakan_data[$r['NoRegistrasi']][] = $r['KodeTindakan'];
							}
						}
					}
					
					// Tampilkan data
					$no = ($h <= 1) ? 0 : ($jumlah_perpage * $h - $jumlah_perpage);
					
					foreach($rows as $data):
						$no++;
						$noregistrasi = $data['NoPemeriksaan'];
						$noindex = $data['NoIndex'];
						$kelamin = $data['JenisKelamin'];
						
						// Data dari batch
						$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
						$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'] : '-';
						
						$peg = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
						$pemeriksa = !empty($peg['NamaPegawai1']) ? $peg['NamaPegawai1'] : (isset($peg['NamaPegawai2']) ? $peg['NamaPegawai2'] : '');
						
						$tindakan_arr = isset($tindakan_data[$noregistrasi]) ? $tindakan_data[$noregistrasi] : [];
						$data_tdk = implode(", ", array_unique($tindakan_arr));
						
						// Cek umur kelamin
						if($kelamin == 'L'){
							$umur_l = $data['UmurTahun']." th";
							$umur_p = "-";
						} else {
							$umur_l = "-";
							$umur_p = $data['UmurTahun']." th";
						}
						
						// Cek rujukan
						$rujukan = $data['StatusPulang'];
						if($rujukan == 3){
							$berobatjalan = '<span class="fa fa-check"></span>';
							$rujuklanjut = '-';
						} else if($rujukan == 4){
							$rujuklanjut = '<span class="fa fa-check"></span>';
							$berobatjalan = '-';
						} else {
							$berobatjalan = '-';
							$rujuklanjut = '-';
						}
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noregistrasi, -5);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex, -10);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data['NamaPasien']);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_l;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($alamat_pasien);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data_tdk);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data['Hasil']);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $rujuklanjut;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $berobatjalan;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data['Asuransi']);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($pemeriksa);?></td>
						</tr>
					<?php endforeach; 
					
					if(count($rows) == 0):
					?>
						<tr><td colspan="14" align="center">Tidak ada data</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<br>
	<div class="noprint">
		<?php if($h > 1): ?>
			<a href="?page=lap_registrasi_laboratorium&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">&laquo; Prev</span>
		<?php endif; ?>
		
		<span class="btn btn-primary">Halaman <?php echo $h;?></span>
		
		<?php if($has_next): ?>
			<a href="?page=lap_registrasi_laboratorium&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">Next &raquo;</span>
		<?php endif; ?>
	</div>
	
	<?php endif; ?>
</div>