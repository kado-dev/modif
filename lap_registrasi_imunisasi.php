<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Sanitize inputs
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : date('Y-m-01');
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : date('Y-m-d');
	$key = isset($_GET['key']) ? mysqli_real_escape_string($koneksi, $_GET['key']) : '';
	$h = isset($_GET['h']) ? (int)$_GET['h'] : 1;
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER IMUNISASI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_imunisasi"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate1);?>" placeholder="Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate2);?>" placeholder="Tanggal Akhir" required>
						</div>
						<div class="col-xl-3">
							<input type="text" name="key" class="form-control" value="<?php echo htmlspecialchars($key);?>" placeholder="Ketikan Nama Pasien">
						</div>
						<div class="col-xl-5">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_imunisasi" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_imunisasi_excel.php?kd=<?php echo urlencode($kodepuskesmas);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&key=<?php echo urlencode($key);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
	
	<?php if($keydate1 != '' && $keydate2 != ''): ?>
	
	<div class="printheader" style="display:none;">
		<span class="font14"><b>DINAS KESEHATAN <?php echo strtoupper($kota);?></b></span><br>
		<span class="font14"><b>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10"><?php echo $alamat;?></span>
		<hr style="border:1px solid #000">
		<span class="font14"><b>REGISTER PELAYANAN IMUNISASI</b></span><br>
		<span class="font11">Periode: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></span>
	</div>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%" style="font-size:9px;">
					<thead>
						<tr>
							<th rowspan="2">NO.</th>
							<th rowspan="2">TANGGAL</th>
							<th rowspan="2">NAMA PASIEN</th>
							<th colspan="2">UMUR</th>
							<th colspan="4">VITAL SIGN</th>
							<th rowspan="2">KIPI</th>
							<th rowspan="2">HB0</th>
							<th rowspan="2">BCG</th>
							<th colspan="3">DPT HB HIB</th>
							<th colspan="4">POLIO</th>
							<th colspan="3">PCV</th>
							<th rowspan="2">IPV</th>
							<th rowspan="2">MR</th>
							<th rowspan="2">DPT<br/>HIB<br/>LNJT</th>
							<th rowspan="2">MR<br/>LNJT</th>
							<th rowspan="2">RUJUK</th>
							<th colspan="3">ADS</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>TD</th>
							<th>BB/TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
							<th>1</th><th>2</th><th>3</th>
							<th>1</th><th>2</th><th>3</th><th>4</th>
							<th>1</th><th>2</th><th>3</th>
							<th>0.05</th><th>0.5</th><th>5</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Pagination
						$jumlah_perpage = 30;
						if($h <= 1) {
							$mulai = 0;
							$h = 1;
						} else {
							$mulai = $jumlah_perpage * $h - $jumlah_perpage;
						}
						
						// Filter nama
						$nama_filter = $key != '' ? " AND NamaPasien LIKE '%$key%'" : "";
						
						// Query utama
						$str_main = "SELECT TanggalPeriksa, NoPemeriksaan, NoIndex, NoCM, NamaPasien, JenisKelamin,
							UmurTahun, UmurBulan, UmurHari, Sistole, Diastole, BeratBadan, TinggiBadan, SuhuTubuh, 
							DetakNadi, RR, Kipi, RujukInternal, Ads005, Ads05, Ads5, RiwayatImunisasi, ImunisasiSekarang
						FROM `tbpoliimunisasi` 
						WHERE TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2 23:59:59' $nama_filter
						GROUP BY NoCM 
						ORDER BY TanggalPeriksa ASC, NamaPasien ASC 
						LIMIT $mulai, ".($jumlah_perpage + 1);
						
						$query_main = mysqli_query($koneksi, $str_main);
						
						// Kumpulkan data
						$rows = [];
						$noregistrasi_list = [];
						$noindex_list = [];
						$nocm_list = [];
						
						if($query_main){
							while($row = mysqli_fetch_assoc($query_main)){
								$rows[] = $row;
								$noregistrasi_list[$row['NoPemeriksaan']] = true;
								$noindex_list[$row['NoIndex']] = true;
								$nocm_list[$row['NoCM']] = true;
							}
						}
						
						// Check if there's next page
						$has_next = count($rows) > $jumlah_perpage;
						if($has_next) array_pop($rows);
						
						// Batch queries
						$pasienrj_data = [];
						$pasien_data = [];
						$kk_data = [];
						$pegawai_data = [];
						$imunisasi_history = [];
						
						if(!empty($rows)){
							$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
							$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
							$nocm_in = "'".implode("','", array_keys($nocm_list))."'";
							
							// Batch query tbpasienrj
							$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, JenisKelamin, Asuransi 
								FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
							if($q_rj){
								while($r = mysqli_fetch_assoc($q_rj)){
									$pasienrj_data[$r['NoRegistrasi']] = $r;
								}
							}
							
							// Batch query tbpasien
							$q_pasien = mysqli_query($koneksi, "SELECT NoCM, TanggalLahir, Telpon FROM `$tbpasien` WHERE NoCM IN ($nocm_in)");
							if($q_pasien){
								while($r = mysqli_fetch_assoc($q_pasien)){
									$pasien_data[$r['NoCM']] = $r;
								}
							}
							
							// Batch query tbkk
							$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Kelurahan, Telepon 
								FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
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
							
							// Batch query riwayat imunisasi (semua untuk NoCM)
							$q_imun = mysqli_query($koneksi, "SELECT NoCM, RiwayatImunisasi, ImunisasiSekarang 
								FROM `tbpoliimunisasi` WHERE NoCM IN ($nocm_in)");
							if($q_imun){
								while($r = mysqli_fetch_assoc($q_imun)){
									if(!isset($imunisasi_history[$r['NoCM']])){
										$imunisasi_history[$r['NoCM']] = [];
									}
									if($r['RiwayatImunisasi']) $imunisasi_history[$r['NoCM']][] = $r['RiwayatImunisasi'];
									if($r['ImunisasiSekarang']) $imunisasi_history[$r['NoCM']][] = $r['ImunisasiSekarang'];
								}
							}
						}
						
						// Tampilkan data
						$no = ($h <= 1) ? 0 : ($jumlah_perpage * $h - $jumlah_perpage);
						
						foreach($rows as $data):
							$no++;
							$noregistrasi = $data['NoPemeriksaan'];
							$noindex = $data['NoIndex'];
							$nocm = $data['NoCM'];
							
							// Data dari batch
							$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
							$kelamin = isset($rj['JenisKelamin']) ? $rj['JenisKelamin'] : $data['JenisKelamin'];
							$asuransi = isset($rj['Asuransi']) ? $rj['Asuransi'] : '';
							
							$pasien = isset($pasien_data[$nocm]) ? $pasien_data[$nocm] : [];
							$tgl_lahir = isset($pasien['TanggalLahir']) ? date('d-m-Y', strtotime($pasien['TanggalLahir'])) : '';
							$telpon = isset($pasien['Telpon']) ? $pasien['Telpon'] : '';
							
							$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
							$nama_kk = isset($kk['NamaKK']) ? $kk['NamaKK'] : '';
							$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'].", ".$kk['Kelurahan'] : '';
							$telepon_kk = isset($kk['Telepon']) ? $kk['Telepon'] : $telpon;
							
							$peg = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
							$pemeriksa = !empty($peg['NamaPegawai1']) ? $peg['NamaPegawai1'] : (isset($peg['NamaPegawai2']) ? $peg['NamaPegawai2'] : '');
							
							// Gabung imunisasi
							$all_imun = isset($imunisasi_history[$nocm]) ? implode(",", $imunisasi_history[$nocm]) : '';
							$imun_arr = explode(",", $all_imun);
							
							// Cek umur kelamin
							if($kelamin == 'L'){
								if($data['UmurTahun'] == '0'){
									$umur_l = $data['UmurBulan'] == '0' ? $data['UmurHari']." Hr" : $data['UmurBulan']." Bl";
								} else {
									$umur_l = $data['UmurTahun']." Th";
								}
								$umur_p = "-";
							} else {
								if($data['UmurTahun'] == '0'){
									$umur_p = $data['UmurBulan'] == '0' ? $data['UmurHari']." Hr" : $data['UmurBulan']." Bl";
								} else {
									$umur_p = $data['UmurTahun']." Th";
								}
								$umur_l = "-";
							}
							
							// Vital sign
							$tensi = $data['Sistole']."/".$data['Diastole'];
							$bbtb = $data['BeratBadan']."/".$data['TinggiBadan'];
							$hrrr = $data['DetakNadi']."/".$data['RR'];
							
							// Function to check imunisasi
							$check = function($arr, $name) {
								return in_array($name, $arr) ? '<span class="fa fa-check"></span>' : '-';
							};
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
								<td align="left" style="font-size:8px;">
									<b><?php echo strtoupper($data['NamaPasien']);?></b><br/>
									<?php echo strtoupper($nama_kk);?><br/>
									<?php echo substr($noindex, -10)." ".$asuransi;?><br/>
									TTL.<?php echo $tgl_lahir;?><br/>
									<?php echo $alamat_pasien != '' ? strtoupper($alamat_pasien) : '<span style="color:red;">BELUM TERDAFTAR</span>';?><br/>
									Telp.<?php echo $telepon_kk ?: '0';?><br/>
									<?php echo $pemeriksa;?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="center"><?php echo $tensi;?></td>
								<td align="center"><?php echo $bbtb;?></td>
								<td align="center"><?php echo $data['SuhuTubuh'];?></td>
								<td align="center"><?php echo $hrrr;?></td>
								<td align="left"><?php echo strtoupper($data['Kipi']);?></td>
								<td align="center"><?php echo $check($imun_arr, 'HBO');?></td>
								<td align="center"><?php echo $check($imun_arr, 'BCG');?></td>
								<td align="center"><?php echo $check($imun_arr, 'DPT HB HiB 1');?></td>
								<td align="center"><?php echo $check($imun_arr, 'DPT HB HiB 2');?></td>
								<td align="center"><?php echo $check($imun_arr, 'DPT HB HiB 3');?></td>
								<td align="center"><?php echo $check($imun_arr, 'Polio 1');?></td>
								<td align="center"><?php echo $check($imun_arr, 'Polio 2');?></td>
								<td align="center"><?php echo $check($imun_arr, 'Polio 3');?></td>
								<td align="center"><?php echo $check($imun_arr, 'Polio 4');?></td>
								<td align="center"><?php echo $check($imun_arr, 'PCV 1');?></td>
								<td align="center"><?php echo $check($imun_arr, 'PCV 2');?></td>
								<td align="center"><?php echo $check($imun_arr, 'PCV 3');?></td>
								<td align="center"><?php echo $check($imun_arr, 'IPV');?></td>
								<td align="center"><?php echo $check($imun_arr, 'CAMPAK RUBELLA');?></td>
								<td align="center"><?php echo $check($imun_arr, 'BOOSTER DPT HB HiB');?></td>
								<td align="center"><?php echo $check($imun_arr, 'BOOSTER CAMPAK RUBELLA');?></td>
								<td align="center"><?php echo $data['RujukInternal'];?></td>
								<td align="center"><?php echo $data['Ads005'];?></td>
								<td align="center"><?php echo $data['Ads05'];?></td>
								<td align="center"><?php echo $data['Ads5'];?></td>
							</tr>
						<?php endforeach; 
						
						if(count($rows) == 0):
						?>
							<tr><td colspan="30" align="center">Tidak ada data</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<br/>
	<div class="noprint">
		<?php if($h > 1): ?>
			<a href="?page=lap_registrasi_imunisasi&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&key=<?php echo urlencode($key);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">&laquo; Prev</span>
		<?php endif; ?>
		
		<span class="btn btn-primary">Halaman <?php echo $h;?></span>
		
		<?php if($has_next): ?>
			<a href="?page=lap_registrasi_imunisasi&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&key=<?php echo urlencode($key);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">Next &raquo;</span>
		<?php endif; ?>
	</div>
	
	<?php endif; ?>
</div>