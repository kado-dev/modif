<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Sanitize inputs
	$opsiform = isset($_GET['opsiform']) ? mysqli_real_escape_string($koneksi, $_GET['opsiform']) : 'bulan';
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : date('m');
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : date('Y');
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : '';
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : '';
	$h = isset($_GET['h']) ? (int)$_GET['h'] : 1;
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER KIA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_kia"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($opsiform == 'bulan') echo "SELECTED";?>>Bulan</option>
								<option value="tanggal" <?php if($opsiform == 'tanggal') echo "SELECTED";?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
							<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo htmlspecialchars($keydate1);?>" placeholder="Tanggal Awal">
							<input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;" value="<?php echo htmlspecialchars($keydate2);?>" placeholder="Tanggal Akhir">
						</div>
						<div class="col-xl-2 bulanformcari">
							<select name="bulan" class="form-control">
								<?php
								$nama_bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
								foreach($nama_bulan as $key => $val):
								?>
								<option value="<?php echo $key;?>" <?php if($bulan == $key) echo "SELECTED";?>><?php echo $val;?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php for($t = 2021; $t <= date('Y'); $t++): ?>
								<option value="<?php echo $t;?>" <?php if($tahun == $t) echo "SELECTED";?>><?php echo $t;?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_kia" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_kia_excel.php?opsiform=<?php echo urlencode($opsiform);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&kd=<?php echo urlencode($kodepuskesmas);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		$jumlah_perpage = 20;
		if($h <= 1) {
			$mulai = 0;
			$h = 1;
		} else {
			$mulai = $jumlah_perpage * $h - $jumlah_perpage;
		}
		
		// Date range based on opsiform
		if($opsiform == 'bulan'){
			$date_start = "$tahun-$bulan-01";
			$date_end = "$tahun-$bulan-31 23:59:59";
		} else {
			$date_start = $keydate1;
			$date_end = $keydate2." 23:59:59";
		}
	?>

	<div class="printheader" style="display:none;">
		<span class="font14"><b>DINAS KESEHATAN <?php echo strtoupper($kota);?></b></span><br>
		<span class="font14"><b>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10"><?php echo $alamat;?></span>
		<hr style="border:1px solid #000">
		<span class="font14"><b>REGISTER KIA</b></span><br>
		<span class="font11">Periode: <?php echo $opsiform == 'bulan' ? nama_bulan($bulan)." ".$tahun : date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></span>
	</div>

	<!--data registrasi-->
	<div class="noprint">
		<div class="table-responsive noprint">
			<table class="table-judul-laporan" width="100%" style="font-size:9px;">
				<thead>
					<tr style="border:1px solid #000;">
						<th rowspan="2">NO.</th>
						<th rowspan="2">TGL.PERIKSA</th>
						<th rowspan="2">NO.INDEX</th>
						<th rowspan="2">NAMA PASIEN</th>
						<th rowspan="2">UMUR</th>
						<th rowspan="2">ALAMAT</th>
						<th rowspan="2">G/P/A</th>
						<th rowspan="2">HPHT</th>
						<th colspan="4">HASIL PEMERIKSAAN</th>
						<th colspan="2">PEMBERIAN</th>
						<th rowspan="2">RESTI</th>
						<th rowspan="2">ANAMNESA</th>
						<th rowspan="2">DIAGNOSA</th>
						<th rowspan="2">THERAPY</th>
						<th colspan="2">RUJUK</th>
						<th rowspan="2">KET.</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th>BB</th>
						<th>TB</th>
						<th>TD</th>
						<th>LILA</th>
						<th>TT</th>
						<th>FE</th>
						<th>Ya</th>
						<th>Tidak</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// Query utama
					$str_main = "SELECT TanggalPeriksa, NoRegistrasi, NoCM, NoIndex, NamaPasien, 
						Gravida, Partus, Abortus, Hpht, BeratBadan, TinggiBadan, Sistole, Diastole, 
						Lila, TT, FE, FaktorResiko, Anamnesa
						FROM `$tbpolikia`
						WHERE TanggalPeriksa BETWEEN '$date_start' AND '$date_end'
						ORDER BY TanggalPeriksa ASC 
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
							$noregistrasi_list[$row['NoRegistrasi']] = true;
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
					$diagnosa_data = [];
					$therapy_data = [];
					$subdistricts_cache = [];
					$districts_cache = [];
					
					if(!empty($rows)){
						$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
						$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
						$nocm_in = "'".implode("','", array_keys($nocm_list))."'";
						
						// Batch query tbpasienrj
						$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, JenisKelamin, UmurTahun, StatusPulang 
							FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
						if($q_rj){
							while($r = mysqli_fetch_assoc($q_rj)){
								$pasienrj_data[$r['NoRegistrasi']] = $r;
							}
						}
						
						// Batch query tbpasien
						$q_pasien = mysqli_query($koneksi, "SELECT NoCM, Nik FROM `$tbpasien` WHERE NoCM IN ($nocm_in)");
						if($q_pasien){
							while($r = mysqli_fetch_assoc($q_pasien)){
								$pasien_data[$r['NoCM']] = $r;
							}
						}
						
						// Batch query tbkk
						$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Kelurahan, Kecamatan 
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
						
						// Batch query diagnosa
						$q_diag = mysqli_query($koneksi, "SELECT NoRegistrasi, KodeDiagnosa 
							FROM `$tbdiagnosapasien` WHERE NoRegistrasi IN ($noreg_in)");
						if($q_diag){
							while($r = mysqli_fetch_assoc($q_diag)){
								if(!isset($diagnosa_data[$r['NoRegistrasi']])){
									$diagnosa_data[$r['NoRegistrasi']] = [];
								}
								$diagnosa_data[$r['NoRegistrasi']][] = $r['KodeDiagnosa'];
							}
						}
						
						// Batch query therapy
						$q_therapy = mysqli_query($koneksi, "SELECT rd.NoResep, 
							(SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE KodeBarang = rd.KodeBarang LIMIT 1) as NamaBarang, 
							rd.jumlahobat
							FROM `$tbresepdetail` rd WHERE rd.NoResep IN ($noreg_in)");
						if($q_therapy){
							while($r = mysqli_fetch_assoc($q_therapy)){
								if(!isset($therapy_data[$r['NoResep']])){
									$therapy_data[$r['NoResep']] = [];
								}
								if($r['NamaBarang']){
									$therapy_data[$r['NoResep']][] = $r['NamaBarang']." (".$r['jumlahobat'].")";
								}
							}
						}
						
						// Cache subdistricts dan districts
						$q_subdis = mysqli_query($koneksi, "SELECT subdis_id, subdis_name FROM `ec_subdistricts`");
						if($q_subdis){
							while($r = mysqli_fetch_assoc($q_subdis)){
								$subdistricts_cache[$r['subdis_id']] = $r['subdis_name'];
							}
						}
						$q_dis = mysqli_query($koneksi, "SELECT dis_id, dis_name FROM `ec_districts`");
						if($q_dis){
							while($r = mysqli_fetch_assoc($q_dis)){
								$districts_cache[$r['dis_id']] = $r['dis_name'];
							}
						}
					}
					
					// Tampilkan data
					$no = ($h <= 1) ? 0 : ($jumlah_perpage * $h - $jumlah_perpage);
					
					foreach($rows as $data):
						$no++;
						$noregistrasi = $data['NoRegistrasi'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						
						// Data dari batch
						$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
						$umur = isset($rj['UmurTahun']) ? $rj['UmurTahun']."th" : '';
						$status_pulang = isset($rj['StatusPulang']) ? $rj['StatusPulang'] : '';
						
						$pasien = isset($pasien_data[$nocm]) ? $pasien_data[$nocm] : [];
						$nik = isset($pasien['Nik']) ? $pasien['Nik'] : '';
						
						$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
						$kelurahan = isset($subdistricts_cache[$kk['Kelurahan']]) ? $subdistricts_cache[$kk['Kelurahan']] : (isset($kk['Kelurahan']) ? $kk['Kelurahan'] : '');
						$kecamatan = isset($districts_cache[$kk['Kecamatan']]) ? $districts_cache[$kk['Kecamatan']] : (isset($kk['Kecamatan']) ? $kk['Kecamatan'] : '');
						$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'].", ".strtoupper($kelurahan).", ".strtoupper($kecamatan) : '';
						
						$peg = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
						$pemeriksa = !empty($peg['NamaPegawai1']) ? $peg['NamaPegawai1'] : (isset($peg['NamaPegawai2']) ? $peg['NamaPegawai2'] : '');
						
						$diagnosa_arr = isset($diagnosa_data[$noregistrasi]) ? $diagnosa_data[$noregistrasi] : [];
						$data_dgs = implode(", ", array_unique($diagnosa_arr));
						
						$therapy_arr = isset($therapy_data[$noregistrasi]) ? $therapy_data[$noregistrasi] : [];
						$data_trp = implode("<br/>", $therapy_arr);
						
						// Cek rujukan
						if($status_pulang == 3){
							$berobatjalan = '<span class="fa fa-check"></span>';
							$rujuklanjut = '-';
						} else if($status_pulang == 4){
							$rujuklanjut = '<span class="fa fa-check"></span>';
							$berobatjalan = '-';
						} else {
							$berobatjalan = '-';
							$rujuklanjut = '-';
						}
					?>
						<tr style="border:1px solid #000;">
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
							<td align="center"><?php echo substr($data['NoIndex'], -10);?></td>
							<td align="left"><?php echo htmlspecialchars($data['NamaPasien']);?><br/><small>NIK.<?php echo $nik;?></small></td>
							<td><?php echo $umur;?></td>
							<td align="left"><?php echo $alamat_pasien != '' ? htmlspecialchars($alamat_pasien) : '<span style="color:red;">Belum Terdaftar</span>';?></td>
							<td><?php echo $data['Gravida']."/".$data['Partus']."/".$data['Abortus'];?></td>
							<td><?php echo $data['Hpht'];?></td>
							<td><?php echo $data['BeratBadan'];?></td>
							<td><?php echo $data['TinggiBadan'];?></td>
							<td><?php echo $data['Sistole']."/".$data['Diastole'];?></td>
							<td><?php echo $data['Lila'];?></td>
							<td><?php echo $data['TT'];?></td>
							<td><?php echo $data['FE'];?></td>
							<td><?php echo htmlspecialchars($data['FaktorResiko']);?></td>
							<td align="left"><?php echo htmlspecialchars($data['Anamnesa']);?></td>
							<td align="left"><?php echo $data_dgs;?></td>
							<td align="left"><?php echo $data_trp;?></td>
							<td align="center"><?php echo $rujuklanjut;?></td>
							<td align="center"><?php echo $berobatjalan;?></td>
							<td align="center"><?php echo htmlspecialchars($pemeriksa);?></td>
						</tr>
					<?php endforeach; 
					
					if(count($rows) == 0):
					?>
						<tr><td colspan="21" align="center">Tidak ada data</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<br>
	<div class="noprint">
		<?php if($h > 1): ?>
			<a href="?page=lap_registrasi_kia&opsiform=<?php echo urlencode($opsiform);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">&laquo; Prev</span>
		<?php endif; ?>
		
		<span class="btn btn-primary">Halaman <?php echo $h;?></span>
		
		<?php if($has_next): ?>
			<a href="?page=lap_registrasi_kia&opsiform=<?php echo urlencode($opsiform);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">Next &raquo;</span>
		<?php endif; ?>
	</div>
	
	<?php endif; ?>
</div>	

<script>
$(document).ready(function(){
	$('.opsiform').change(function(){
		if($(this).val() == 'bulan'){
			$(".bulanformcari").show();
			$(".tanggalformcari").hide();
		} else {	
			$(".bulanformcari").hide();
			$(".tanggalformcari").show();
		}
	});
	if($(".opsiform").val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}
});
</script>