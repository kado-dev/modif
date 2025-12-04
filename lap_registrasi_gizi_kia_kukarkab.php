<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Sanitize inputs
	$opsiform = isset($_GET['opsiform']) ? mysqli_real_escape_string($koneksi, $_GET['opsiform']) : 'bulan';
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : date('m');
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : date('Y');
	$keydate = isset($_GET['keydate']) ? mysqli_real_escape_string($koneksi, $_GET['keydate']) : '';
	$h = isset($_GET['h']) ? (int)$_GET['h'] : 1;
?>

<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Register Poli Gizi (KIA)</h1>
		</div>
	</div>
</div>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER GIZI (KIA)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_gizi_kia_kukarkab"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($opsiform == 'bulan') echo "SELECTED";?>>Bulan</option>
								<option value="tanggal" <?php if($opsiform == 'tanggal') echo "SELECTED";?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-2 tanggalformcari" style="display:none">
							<input type="text" name="keydate" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate);?>" placeholder="Tanggal">
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
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_gizi_kia_kukarkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_gizi_kia_kukarkab_excel.php?opsiform=<?php echo urlencode($opsiform);?>&keydate=<?php echo urlencode($keydate);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		$date_start = $keydate;
		$date_end = $keydate." 23:59:59";
	}
?>

<div class="printheader" style="display:none;">
	<span class="font14"><b>DINAS KESEHATAN <?php echo strtoupper($kota);?></b></span><br>
	<span class="font14"><b>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></b></span><br>
	<span class="font10"><?php echo $alamat;?></span>
	<hr style="border:1px solid #000">
	<span class="font14"><b>REGISTER GIZI (KIA)</b></span><br>
	<span class="font11">Periode: <?php echo $opsiform == 'bulan' ? nama_bulan($bulan)." ".$tahun : date('d-m-Y', strtotime($keydate));?></span>
</div>

<!--data registrasi-->
<div class="table-responsive">
	<table class="table table-condensed" style="font-size:10px;">
		<thead>
			<tr style="border:1px solid #000;">
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Ibu</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Suami</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Lahir</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">GPA</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Usia Kehamilan</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kunj. ke</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BB</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TB</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">LILA</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TD</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">HB</th>
				<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemeriksa</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Query utama
			$str_main = "SELECT TanggalPeriksa, NoPemeriksaan, NoIndex, NoCM, NamaPasien, 
				Gravida, Partus, Abortus, UsiaKehamilan, KunjunganKehamilan,
				BeratBadan, TinggiBadan, Lila, Sistole, Diastole, K1Hb, K4Hb
				FROM `$tbpolikia`
				WHERE TanggalPeriksa BETWEEN '$date_start' AND '$date_end'
				ORDER BY TanggalPeriksa ASC 
				LIMIT $mulai, ".($jumlah_perpage + 1);
			
			$query_main = mysqli_query($koneksi, $str_main);
			
			// Kumpulkan data untuk batch query
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
			
			// Batch queries jika ada data
			$pasienrj_data = [];
			$pasien_data = [];
			$kk_data = [];
			$pegawai_data = [];
			
			if(!empty($rows)){
				$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
				$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
				$nocm_in = "'".implode("','", array_keys($nocm_list))."'";
				
				// Batch query tbpasienrj
				$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, NoRM FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
				if($q_rj){
					while($r = mysqli_fetch_assoc($q_rj)){
						$pasienrj_data[$r['NoRegistrasi']] = $r;
					}
				}
				
				// Batch query tbpasien untuk tanggal lahir
				$q_pasien = mysqli_query($koneksi, "SELECT NoCM, TanggalLahir FROM `$tbpasien` WHERE NoCM IN ($nocm_in)");
				if($q_pasien){
					while($r = mysqli_fetch_assoc($q_pasien)){
						$pasien_data[$r['NoCM']] = $r;
					}
				}
				
				// Batch query tbkk
				$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Telepon FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
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
				$no_rm = isset($rj['NoRM']) ? substr($rj['NoRM'], -6) : '';
				
				$pasien = isset($pasien_data[$nocm]) ? $pasien_data[$nocm] : [];
				$tgl_lahir = isset($pasien['TanggalLahir']) ? date('d-m-Y', strtotime($pasien['TanggalLahir'])) : '';
				
				$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
				$nama_suami = isset($kk['NamaKK']) ? $kk['NamaKK'] : '';
				$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'] : '';
				$telepon = isset($kk['Telepon']) ? $kk['Telepon'] : '';
				
				$peg = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
				$pemeriksa = !empty($peg['NamaPegawai1']) ? $peg['NamaPegawai1'] : (isset($peg['NamaPegawai2']) ? $peg['NamaPegawai2'] : '');
				
				// GPA
				$gpa = "G:".$data['Gravida']." P:".$data['Partus']." A:".$data['Abortus'];
				
				// HB
				$hb = ($data['K1Hb'] != '' || $data['K4Hb'] != '') ? "K1:".$data['K1Hb'].", K4:".$data['K4Hb'] : "-";
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no_rm;?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($data['NamaPasien']);?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($nama_suami);?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tgl_lahir;?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;">
						<?php echo $alamat_pasien != '' ? htmlspecialchars($alamat_pasien.($telepon ? ", Telp.".$telepon : '')) : '<span style="color:red;">Belum Terdaftar</span>';?>
					</td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gpa;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UsiaKehamilan'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KunjunganKehamilan'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['BeratBadan'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Lila'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Sistole']."/".$data['Diastole'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $hb;?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($pemeriksa);?></td>
				</tr>
			<?php endforeach; 
			
			if(count($rows) == 0):
			?>
				<tr><td colspan="16" align="center">Tidak ada data</td></tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<br>
<div class="noprint">
	<?php if($h > 1): ?>
		<a href="?page=lap_registrasi_gizi_kia_kukarkab&opsiform=<?php echo urlencode($opsiform);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&keydate=<?php echo urlencode($keydate);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
	<?php else: ?>
		<span class="btn btn-secondary disabled">&laquo; Prev</span>
	<?php endif; ?>
	
	<span class="btn btn-primary">Halaman <?php echo $h;?></span>
	
	<?php if($has_next): ?>
		<a href="?page=lap_registrasi_gizi_kia_kukarkab&opsiform=<?php echo urlencode($opsiform);?>&bulan=<?php echo urlencode($bulan);?>&tahun=<?php echo urlencode($tahun);?>&keydate=<?php echo urlencode($keydate);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
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