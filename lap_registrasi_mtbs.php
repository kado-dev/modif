<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Sanitize inputs
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : date('Y-m-01');
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : date('Y-m-d');
	$h = isset($_GET['h']) ? (int)$_GET['h'] : 1;
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER MTBS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_mtbs"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate1);?>" placeholder="Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate2);?>" placeholder="Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_mtbs" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_mtbs_excel.php?kd=<?php echo urlencode($kodepuskesmas);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
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
		<span class="font14"><b>REGISTER PELAYANAN MTBS</b></span><br>
		<span class="font11">Periode: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></span>
	</div>

	<div class="atastabel font11" style="display:none;">
		<table style="font-size:10px; width:300px;">
			<tr><td>Kode Puskesmas</td><td>:</td><td><?php echo $kodepuskesmas;?></td></tr>
			<tr><td>Puskesmas</td><td>:</td><td><?php echo $namapuskesmas;?></td></tr>
		</table>
	</div>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%" style="font-size:9px;">
					<thead>
						<tr>
							<th rowspan="2">NO.</th>
							<th rowspan="2">TGL.PERIKSA</th>
							<th rowspan="2">NIK</th>
							<th rowspan="2">NAMA PASIEN</th>
							<th colspan="2">UMUR</th>
							<th rowspan="2">ALAMAT</th>
							<th rowspan="2">KUNJ.</th>
							<th colspan="5">VITAL SIGN</th>
							<th rowspan="2">ANAMNESA</th>
							<th rowspan="2">DIAGNOSA</th>
							<th rowspan="2">THERAPY</th>
							<th colspan="2">RUJUK</th>
							<th rowspan="2">KET.</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>TD</th>
							<th>BB</th>
							<th>TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
							<th>YA</th>
							<th>TDK</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Pagination
						$jumlah_perpage = 20;
						if($h <= 1) {
							$mulai = 0;
							$h = 1;
						} else {
							$mulai = $jumlah_perpage * $h - $jumlah_perpage;
						}
						
						// Query utama
						$str_main = "SELECT TanggalPeriksa, IdPasienrj, NoPemeriksaan, NoIndex, NamaPasien, Anamnesa, NamaPegawaiSimpan
							FROM `$tbpolimtbs` 
							WHERE TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2 23:59:59'
							ORDER BY TanggalPeriksa ASC, NamaPasien ASC 
							LIMIT $mulai, ".($jumlah_perpage + 1);
						
						$query_main = mysqli_query($koneksi, $str_main);
						
						// Kumpulkan data
						$rows = [];
						$idpasienrj_list = [];
						$noregistrasi_list = [];
						$noindex_list = [];
						
						if($query_main){
							while($row = mysqli_fetch_assoc($query_main)){
								$rows[] = $row;
								$idpasienrj_list[$row['IdPasienrj']] = true;
								$noregistrasi_list[$row['NoPemeriksaan']] = true;
								$noindex_list[$row['NoIndex']] = true;
							}
						}
						
						// Check if there's next page
						$has_next = count($rows) > $jumlah_perpage;
						if($has_next) array_pop($rows);
						
						// Batch queries
						$vitalsign_data = [];
						$pasienrj_data = [];
						$pasien_data = [];
						$kk_data = [];
						$diagnosa_data = [];
						$therapy_data = [];
						$subdistricts_cache = [];
						$districts_cache = [];
						
						if(!empty($rows)){
							$idprj_in = "'".implode("','", array_keys($idpasienrj_list))."'";
							$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
							$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
							
							// Batch query tbvitalsign
							$q_vs = mysqli_query($koneksi, "SELECT IdPasienrj, Sistole, Diastole, BeratBadan, TinggiBadan, SuhuTubuh, HeartRate, RespiratoryRate 
								FROM `$tbvitalsign` WHERE IdPasienrj IN ($idprj_in)");
							if($q_vs){
								while($r = mysqli_fetch_assoc($q_vs)){
									$vitalsign_data[$r['IdPasienrj']] = $r;
								}
							}
							
							// Batch query tbpasienrj
							$q_rj = mysqli_query($koneksi, "SELECT IdPasienrj, JenisKelamin, UmurTahun, StatusKunjungan, StatusPulang 
								FROM `$tbpasienrj` WHERE IdPasienrj IN ($idprj_in)");
							if($q_rj){
								while($r = mysqli_fetch_assoc($q_rj)){
									$pasienrj_data[$r['IdPasienrj']] = $r;
								}
							}
							
							// Batch query tbpasien
							$q_pasien = mysqli_query($koneksi, "SELECT NoIndex, Nik FROM `$tbpasien` WHERE NoIndex IN ($noindex_in)");
							if($q_pasien){
								while($r = mysqli_fetch_assoc($q_pasien)){
									$pasien_data[$r['NoIndex']] = $r;
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
							
							// Batch query diagnosa
							$q_diag = mysqli_query($koneksi, "SELECT dp.NoRegistrasi, dp.KodeDiagnosa, db.Diagnosa 
								FROM `$tbdiagnosapasien` dp
								LEFT JOIN `tbdiagnosabpjs` db ON dp.KodeDiagnosa = db.KodeDiagnosa
								WHERE dp.NoRegistrasi IN ($noreg_in)
								GROUP BY dp.NoRegistrasi, dp.KodeDiagnosa");
							if($q_diag){
								while($r = mysqli_fetch_assoc($q_diag)){
									if(!isset($diagnosa_data[$r['NoRegistrasi']])){
										$diagnosa_data[$r['NoRegistrasi']] = [];
									}
									$diagnosa_data[$r['NoRegistrasi']][] = "<b>".$r['KodeDiagnosa']."</b> ".$r['Diagnosa'];
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
							$idpasienrj = $data['IdPasienrj'];
							$noregistrasi = $data['NoPemeriksaan'];
							$noindex = $data['NoIndex'];
							
							// Data dari batch
							$vs = isset($vitalsign_data[$idpasienrj]) ? $vitalsign_data[$idpasienrj] : [];
							$tensi = (isset($vs['Sistole']) ? $vs['Sistole'] : '')."/".(isset($vs['Diastole']) ? $vs['Diastole'] : '');
							$bb = isset($vs['BeratBadan']) ? $vs['BeratBadan'] : '';
							$tb = isset($vs['TinggiBadan']) ? $vs['TinggiBadan'] : '';
							$suhu = isset($vs['SuhuTubuh']) ? $vs['SuhuTubuh'] : '';
							$hrrr = (isset($vs['HeartRate']) ? $vs['HeartRate'] : '')."/".(isset($vs['RespiratoryRate']) ? $vs['RespiratoryRate'] : '');
							
							$rj = isset($pasienrj_data[$idpasienrj]) ? $pasienrj_data[$idpasienrj] : [];
							$kelamin = isset($rj['JenisKelamin']) ? $rj['JenisKelamin'] : '';
							$umur_tahun = isset($rj['UmurTahun']) ? $rj['UmurTahun'] : '';
							$kunjungan = isset($rj['StatusKunjungan']) ? $rj['StatusKunjungan'] : '';
							$status_pulang = isset($rj['StatusPulang']) ? $rj['StatusPulang'] : '';
							
							$pasien = isset($pasien_data[$noindex]) ? $pasien_data[$noindex] : [];
							$nik = isset($pasien['Nik']) ? $pasien['Nik'] : '';
							
							$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
							$nama_kk = isset($kk['NamaKK']) ? $kk['NamaKK'] : '';
							$kelurahan = isset($subdistricts_cache[$kk['Kelurahan']]) ? $subdistricts_cache[$kk['Kelurahan']] : (isset($kk['Kelurahan']) ? $kk['Kelurahan'] : '');
							$kecamatan = isset($districts_cache[$kk['Kecamatan']]) ? $districts_cache[$kk['Kecamatan']] : (isset($kk['Kecamatan']) ? $kk['Kecamatan'] : '');
							$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'].", ".strtoupper($kelurahan).", ".strtoupper($kecamatan) : '';
							
							$diagnosa_arr = isset($diagnosa_data[$noregistrasi]) ? $diagnosa_data[$noregistrasi] : [];
							$data_dgs = implode("<br/>", array_unique($diagnosa_arr));
							
							$therapy_arr = isset($therapy_data[$noregistrasi]) ? $therapy_data[$noregistrasi] : [];
							$data_trp = implode("<br/>", $therapy_arr);
							
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
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
								<td align="center"><?php echo $nik;?></td>
								<td align="left">
									<b><?php echo strtoupper($data['NamaPasien']);?></b><br/>
									<?php echo strtoupper($nama_kk);?><br/>
									<?php echo substr($noindex, -10);?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="left">
									<?php echo $alamat_pasien != '' ? strtoupper(htmlspecialchars($alamat_pasien)) : '<span style="color:red;">BELUM TERDAFTAR</span>';?>
								</td>
								<td align="center"><?php echo strtoupper($kunjungan);?></td>
								<td align="center"><?php echo $tensi;?></td>
								<td align="center"><?php echo $bb;?></td>
								<td align="center"><?php echo $tb;?></td>
								<td align="center"><?php echo $suhu;?></td>
								<td align="center"><?php echo $hrrr;?></td>
								<td align="left"><?php echo htmlspecialchars($data['Anamnesa']);?></td>
								<td align="left"><?php echo $data_dgs;?></td>
								<td align="left"><?php echo $data_trp;?></td>
								<td align="center"><?php echo $rujuklanjut;?></td>
								<td align="center"><?php echo $berobatjalan;?></td>
								<td align="center"><?php echo strtoupper(htmlspecialchars($data['NamaPegawaiSimpan']));?></td>
							</tr>
						<?php endforeach; 
						
						if(count($rows) == 0):
						?>
							<tr><td colspan="19" align="center">Tidak ada data</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
	
	<br/>
	<div class="noprint">
		<?php if($h > 1): ?>
			<a href="?page=lap_registrasi_mtbs&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">&laquo; Prev</span>
		<?php endif; ?>
		
		<span class="btn btn-primary">Halaman <?php echo $h;?></span>
		
		<?php if($has_next): ?>
			<a href="?page=lap_registrasi_mtbs&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">Next &raquo;</span>
		<?php endif; ?>
	</div>
	
	<?php endif; ?>
</div>