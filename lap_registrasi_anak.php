<?php
	include "otoritas.php";
	include "config/helper_report.php";
	
	// Sanitize inputs
	$opsiform = isset($_GET['opsiform']) ? mysqli_real_escape_string($koneksi, $_GET['opsiform']) : 'bulan';
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : date('m');
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : date('Y');
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : '';
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : '';
	$kelompokusia = isset($_GET['kelompokusia']) ? mysqli_real_escape_string($koneksi, $_GET['kelompokusia']) : 'Bayi';
	$h = isset($_GET['h']) ? (int)$_GET['h'] : 1;
?>

<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Register Poli Anak</h1>
		</div>
	</div>
</div>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER ANAK</b></h3>	
			<div class="formbg">
				<form role="form">
					<input type="hidden" name="page" value="lap_registrasi_anak"/>
					<div class="col-xl-2">
						<select name="opsiform" class="form-control opsiform">
							<option value="bulan" <?php if($opsiform == 'bulan') echo "SELECTED";?>>Bulan</option>
						</select>	
					</div>
					<div class="col-xl-3 tanggalformcari" style="display:none">
						<div class="tampilformdate">
							<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo htmlspecialchars($keydate1);?>" placeholder="Tanggal Awal">
							<input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo htmlspecialchars($keydate2);?>" placeholder="Tanggal Akhir">
						</div>
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
							<?php for($t = 2016; $t <= date('Y'); $t++): ?>
							<option value="<?php echo $t;?>" <?php if($tahun == $t) echo "SELECTED";?>><?php echo $t;?></option>
							<?php endfor; ?>
						</select>
					</div>
					<div class="col-xl-2 bulanformcari">
						<select name="kelompokusia" class="form-control">
							<option value="Bayi" <?php if($kelompokusia == 'Bayi') echo "SELECTED";?>>Bayi</option>
							<option value="Balita" <?php if($kelompokusia == 'Balita') echo "SELECTED";?>>Balita</option>
							<option value="Anak" <?php if($kelompokusia == 'Anak') echo "SELECTED";?>>Anak</option>
						</select>
					</div>
					<div class="col-xl-3">
						<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_registrasi_anak" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						<a href="lap_registrasi_anak_excel.php?opsiform=<?php echo urlencode($opsiform);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&kelompokusia=<?php echo urlencode($kelompokusia);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>	

<?php
if($bulan != '' && $tahun != ''):
	
	// Setup table names
	$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai = 'tbpasienperpegawai_'.str_replace(' ', '', $namapuskesmas);
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = 'tbresepdetail_'.str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = 'tbgudangpkmstok_'.str_replace(' ', '', $namapuskesmas);
	
	// Pagination
	$jumlah_perpage = 20;
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
	<span class="font14"><b>REGISTER ANAK</b></span><br>
	<span class="font11">Periode: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
</div>

<!--data registrasi-->
<div class="table-responsive">
	<table class="table table-condensed" style="font-size:10px;">
		<thead>
			<tr style="border:1px solid #000;">
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Reg</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
				<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anamnesa</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Therapy</th>
				<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Rujuk</th>
				<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Ket.</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
				<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
				<th style="text-align:center; border:1px solid #000; padding:3px;">Ya</th>
				<th style="text-align:center; border:1px solid #000; padding:3px;">Tidak</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Query utama - hanya dari tbpolianak
			$str_main = "SELECT TanggalPeriksa, NoPemeriksaan, NoIndex, Anamnesa
				FROM `tbpolianak`
				WHERE TanggalPeriksa BETWEEN '$date_start' AND '$date_end'
				ORDER BY TanggalPeriksa ASC 
				LIMIT $mulai, ".($jumlah_perpage + 1);
			
			$query_main = mysqli_query($koneksi, $str_main);
			
			// Kumpulkan data untuk batch query
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
			
			// Batch queries jika ada data
			$pasienrj_data = [];
			$pasien_data = [];
			$kk_data = [];
			$pegawai_data = [];
			$diagnosa_data = [];
			$therapy_data = [];
			
			if(!empty($rows)){
				$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
				$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
				
				// Batch query tbpasienrj
				$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPasien, JenisKelamin, UmurTahun, StatusPulang 
					FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
				if($q_rj){
					while($r = mysqli_fetch_assoc($q_rj)){
						$pasienrj_data[$r['NoRegistrasi']] = $r;
					}
				}
				
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
				
				// Batch query tbdiagnosapasien
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
				
				// Batch query therapy dengan JOIN
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
			}
			
			// Tampilkan data
			$no = ($h <= 1) ? 0 : ($jumlah_perpage * $h - $jumlah_perpage);
			
			foreach($rows as $data):
				$no++;
				$noregistrasi = $data['NoPemeriksaan'];
				$noindex = $data['NoIndex'];
				
				// Data dari batch
				$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
				$kelamin = isset($rj['JenisKelamin']) ? $rj['JenisKelamin'] : '';
				$umur_tahun = isset($rj['UmurTahun']) ? $rj['UmurTahun'] : '';
				$nama_pasien = isset($rj['NamaPasien']) ? $rj['NamaPasien'] : '';
				$status_pulang = isset($rj['StatusPulang']) ? $rj['StatusPulang'] : '';
				
				$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
				$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'] : '';
				
				$peg = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
				$pemeriksa = !empty($peg['NamaPegawai1']) ? $peg['NamaPegawai1'] : (isset($peg['NamaPegawai2']) ? $peg['NamaPegawai2'] : '');
				
				$diagnosa_arr = isset($diagnosa_data[$noregistrasi]) ? $diagnosa_data[$noregistrasi] : [];
				$data_dgs = implode(", ", array_unique($diagnosa_arr));
				
				$therapy_arr = isset($therapy_data[$noregistrasi]) ? $therapy_data[$noregistrasi] : [];
				$data_trp = implode(", ", $therapy_arr);
				
				// Cek umur kelamin
				if($kelamin == 'L'){
					$umur_l = $umur_tahun." Th";
					$umur_p = "-";
				} else {
					$umur_l = "-";
					$umur_p = $umur_tahun." Th";
				}
				
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
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noregistrasi, -5);?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex, -10);?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($nama_pasien);?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_l;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_p;?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;">
						<?php echo $alamat_pasien != '' ? htmlspecialchars($alamat_pasien) : '<span style="color:red;">Belum Terdaftar</span>';?>
					</td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data['Anamnesa']);?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data_dgs);?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data_trp);?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $rujuklanjut;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $berobatjalan;?></td>
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

<br>
<div class="noprint">
	<?php if($h > 1): ?>
		<a href="?page=lap_registrasi_anak&opsiform=<?php echo urlencode($opsiform);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&kelompokusia=<?php echo urlencode($kelompokusia);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
	<?php else: ?>
		<span class="btn btn-secondary disabled">&laquo; Prev</span>
	<?php endif; ?>
	
	<span class="btn btn-primary">Halaman <?php echo $h;?></span>
	
	<?php if($has_next): ?>
		<a href="?page=lap_registrasi_anak&opsiform=<?php echo urlencode($opsiform);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&kelompokusia=<?php echo urlencode($kelompokusia);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
	<?php else: ?>
		<span class="btn btn-secondary disabled">Next &raquo;</span>
	<?php endif; ?>
</div>

<?php endif; ?>

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