<?php
	include "otoritas.php";
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
			<h3 class="judul"><b>REGISTER PROLANIS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_prolanis"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate1);?>" placeholder="Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo htmlspecialchars($keydate2);?>" placeholder="Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_prolanis" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_prolanis_excel.php?kd=<?php echo urlencode($kodepuskesmas);?>&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font14"><b>REGISTER PELAYANAN PROLANIS</b></span><br>
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
							<th rowspan="2">TGL.PERIKSA</th>
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
						
						// Query utama dengan JOINs
						$str_main = "SELECT a.TanggalPeriksa, b.NamaPasien, a.Anamnesa, a.NoPemeriksaan, a.NoIndex, 
							a.Sistole, a.Diastole, a.BeratBadan, a.TinggiBadan, a.SuhuTubuh, a.DetakNadi, a.RR, 
							b.UmurTahun, b.JenisKelamin, b.StatusPulang, b.Asuransi, b.StatusKunjungan, 
							c.NamaPegawai1, c.NamaPegawai2
							FROM `tbpoliprolanis` a 
							INNER JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi 
							INNER JOIN `$tbpasienperpegawai` c ON a.NoPemeriksaan = c.NoRegistrasi
							WHERE a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2 23:59:59'
							ORDER BY a.TanggalPeriksa ASC, b.NamaPasien ASC 
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
						$diagnosa_data = [];
						$therapy_data = [];
						$subdistricts_cache = [];
						$districts_cache = [];
						
						if(!empty($rows)){
							$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
							$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
							
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
							$noregistrasi = $data['NoPemeriksaan'];
							$noindex = $data['NoIndex'];
							$kelamin = $data['JenisKelamin'];
							
							// Data dari batch
							$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
							$nama_kk = isset($kk['NamaKK']) ? $kk['NamaKK'] : '';
							$kelurahan = isset($subdistricts_cache[$kk['Kelurahan']]) ? $subdistricts_cache[$kk['Kelurahan']] : (isset($kk['Kelurahan']) ? $kk['Kelurahan'] : '');
							$kecamatan = isset($districts_cache[$kk['Kecamatan']]) ? $districts_cache[$kk['Kecamatan']] : (isset($kk['Kecamatan']) ? $kk['Kecamatan'] : '');
							$alamat_pasien = isset($kk['Alamat']) ? $kk['Alamat'].", RT.".$kk['RT'].", RW.".$kk['RW'].", ".strtoupper($kelurahan).", ".strtoupper($kecamatan) : '';
							
							$pemeriksa = !empty($data['NamaPegawai1']) ? $data['NamaPegawai1'] : $data['NamaPegawai2'];
							
							$diagnosa_arr = isset($diagnosa_data[$noregistrasi]) ? $diagnosa_data[$noregistrasi] : [];
							$data_dgs = implode("<br/>", array_unique($diagnosa_arr));
							
							$therapy_arr = isset($therapy_data[$noregistrasi]) ? $therapy_data[$noregistrasi] : [];
							$data_trp = implode("<br/>", $therapy_arr);
							
							// Cek umur kelamin
							if($kelamin == 'L'){
								$umur_l = $data['UmurTahun']." Th";
								$umur_p = "-";
							} else {
								$umur_l = "-";
								$umur_p = $data['UmurTahun']." Th";
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
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
								<td align="left">
									<b><?php echo strtoupper($data['NamaPasien']);?></b><br/>
									<?php echo strtoupper($nama_kk);?><br/>
									<?php echo substr($noindex, -10);?><br/>
									<?php echo $data['Asuransi'];?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="left">
									<?php echo $alamat_pasien != '' ? strtoupper(htmlspecialchars($alamat_pasien)) : '<span style="color:red;">BELUM TERDAFTAR</span>';?>
								</td>
								<td align="center"><?php echo strtoupper($data['StatusKunjungan']);?></td>
								<td align="center"><?php echo $data['Sistole']."/".$data['Diastole'];?></td>
								<td align="center"><?php echo $data['BeratBadan'];?></td>
								<td align="center"><?php echo $data['TinggiBadan'];?></td>
								<td align="center"><?php echo $data['SuhuTubuh'];?></td>
								<td align="center"><?php echo $data['DetakNadi']."/".$data['RR'];?></td>
								<td align="left"><?php echo htmlspecialchars($data['Anamnesa']);?></td>
								<td align="left"><?php echo strtoupper($data_dgs);?></td>
								<td align="left"><?php echo strtoupper($data_trp);?></td>
								<td align="center"><?php echo $rujuklanjut;?></td>
								<td align="center"><?php echo $berobatjalan;?></td>
								<td align="center"><?php echo strtoupper(htmlspecialchars($pemeriksa));?></td>
							</tr>
						<?php endforeach; 
						
						if(count($rows) == 0):
						?>
							<tr><td colspan="18" align="center">Tidak ada data</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
	
	<br/>
	<div class="noprint">
		<?php if($h > 1): ?>
			<a href="?page=lap_registrasi_prolanis&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&h=<?php echo ($h-1);?>" class="btn btn-info">&laquo; Prev</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">&laquo; Prev</span>
		<?php endif; ?>
		
		<span class="btn btn-primary">Halaman <?php echo $h;?></span>
		
		<?php if($has_next): ?>
			<a href="?page=lap_registrasi_prolanis&keydate1=<?php echo urlencode($keydate1);?>&keydate2=<?php echo urlencode($keydate2);?>&h=<?php echo ($h+1);?>" class="btn btn-info">Next &raquo;</a>
		<?php else: ?>
			<span class="btn btn-secondary disabled">Next &raquo;</span>
		<?php endif; ?>
	</div>
	
	<?php endif; ?>
</div>