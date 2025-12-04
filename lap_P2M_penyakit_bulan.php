<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>TRACKING DIAGNOSA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_penyakit_bulan"/>
						<div class="col-xl-1">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tahun" <?php if($_GET['opsiform'] == 'tahun'){echo "SELECTED";}?>>Tahun</option>
							</select>	
						</div>
						<div class="col-xl-2 bulanformcari">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-1 tahunformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<td class="col-sm-7">
								<input type="text" class="form-control diagnosabpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" name="kodebpjs" class="form-control kodebpjs">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
							</td>
						</div>
						<div class="col-xl-2">
							<select name="kasus" class="form-control">
								<option value="semua">semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select type="text" name="kelurahan" class="form-control cari">
								<option value='semua'>Semua</option>
								<?php
								$qkel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE (`KodePuskesmas`='$kodepuskesmas' OR `KodePuskesmas`='*')  ORDER BY `Kelurahan`");
								while($dtkel = mysqli_fetch_assoc($qkel)){
									if($dtkel['Kelurahan'] == $_GET['kelurahan']){
									echo "<option value='$dtkel[Kelurahan]' SELECTED>$dtkel[Kelurahan]</option>";
									}else{
									echo "<option value='$dtkel[Kelurahan]'>$dtkel[Kelurahan]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-xl-2">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<!--<a href="?page=lap_P2M_penyakit_bulan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>-->
							<!--<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>-->
							<a href="lap_P2M_penyakit_bulan_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kodebpjs=<?php echo $_GET['kodebpjs'];?>&kasus=<?php echo $_GET['kasus'];?>&kelurahan=<?php echo $_GET['kelurahan'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<?php
	$opsiform = $_GET['opsiform'];
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	$kelurahan = $_GET['kelurahan'];
	
	// Simpan parameter untuk pagination (FIX: variabel tidak ter-overwrite di loop)
	$param_kodediagnosa = $kodediagnosa;
	$param_kasus = $kasus;
	$param_kelurahan = $kelurahan;

	if(isset($bulan) AND isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b><?php echo "REGISTER TRACKING DIAGNOSA (".$kodediagnosa.")";?></b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan:
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table>
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
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2"width="3%">NO.</th>
							<th rowspan="2" width="10%">TGL.</th>
							<th rowspan="2" width="17%">NAMA PASIEN</th>
							<th colspan="2" width="5%">UMUR</th>
							<th rowspan="2" width="5%">KUNJ</th>
							<th rowspan="2" width="5%">KASUS</th>
							<th rowspan="2" width="10%">JAMINAN</th>
							<th rowspan="2" width="10%">LAYANAN</th>
							<th rowspan="2" width="15%">ANAMNESA</th>
							<th rowspan="2" width="5%">DIAGNOSA</th>
							<th rowspan="2" width="15%">THERAPY</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th>L</th>
							<th>P</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// tbdiagnosapasien - kondisi kasus
						if($_GET['kasus'] != 'semua'){
							$kasus_cond = "AND Kasus = '".mysqli_real_escape_string($koneksi, $_GET['kasus'])."'";
							$kasus_cond2 = "AND a.Kasus = '".mysqli_real_escape_string($koneksi, $_GET['kasus'])."'";
						}else{
							$kasus_cond = "";
							$kasus_cond2 = "";
						}
						
						// Escape input untuk keamanan
						$kodediagnosa_esc = mysqli_real_escape_string($koneksi, $kodediagnosa);
						$kelurahan_esc = mysqli_real_escape_string($koneksi, $kelurahan);
						
						// OPTIMASI: Gunakan SQL_CALC_FOUND_ROWS untuk menghitung total tanpa query terpisah
						// dan gunakan date range yang lebih efisien
						if($opsiform == 'bulan'){
							$date_start = "$tahun-$bulan-01";
							$date_end = date('Y-m-t', strtotime($date_start));
							
							if($kelurahan == 'semua'){
								$str_diagnosa_count = "SELECT COUNT(*) as total FROM `$tbdiagnosapasien` 
								WHERE KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond 
								AND TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'";
								
								$str2 = "SELECT * FROM `$tbdiagnosapasien` 
								WHERE KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond 
								AND TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
								ORDER BY TanggalDiagnosa LIMIT $mulai, $jumlah_perpage";
							}else{
								$str_diagnosa_count = "SELECT COUNT(*) as total FROM `$tbdiagnosapasien` a 
								JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
								WHERE a.KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond2 
								AND a.TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
								AND b.Kelurahan = '$kelurahan_esc'";
								
								$str2 = "SELECT a.* FROM `$tbdiagnosapasien` a 
								JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
								WHERE a.KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond2 
								AND a.TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
								AND b.Kelurahan = '$kelurahan_esc'
								ORDER BY a.TanggalDiagnosa LIMIT $mulai, $jumlah_perpage";
							}
						}else{	
							$date_start = "$tahun-01-01";
							$date_end = "$tahun-12-31";
							
							if($kelurahan == 'semua'){
								$str_diagnosa_count = "SELECT COUNT(*) as total FROM `$tbdiagnosapasien` 
								WHERE KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond 
								AND TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'";
								
								$str2 = "SELECT * FROM `$tbdiagnosapasien` 
								WHERE KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond 
								AND TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
								ORDER BY TanggalDiagnosa LIMIT $mulai, $jumlah_perpage";
							}else{
								$str_diagnosa_count = "SELECT COUNT(*) as total FROM `$tbdiagnosapasien` a 
								JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
								WHERE a.KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond2 
								AND a.TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
								AND b.Kelurahan = '$kelurahan_esc'";
								
								$str2 = "SELECT a.* FROM `$tbdiagnosapasien` a 
								JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
								WHERE a.KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond2 
								AND a.TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
								AND b.Kelurahan = '$kelurahan_esc'
								ORDER BY a.TanggalDiagnosa LIMIT $mulai, $jumlah_perpage";
							}
						}
						
						// Hitung total untuk pagination (lebih efisien dengan COUNT)
						$count_result = mysqli_query($koneksi, $str_diagnosa_count);
						$count_row = mysqli_fetch_assoc($count_result);
						$jumlah_query = $count_row['total'];
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// OPTIMASI: Kumpulkan semua IdPasienrj terlebih dahulu
						$query_diagnosa = mysqli_query($koneksi, $str2);
						$diagnosa_data = [];
						$idpasienrj_list = [];
						$noregistrasi_list = [];
						
						while($row = mysqli_fetch_assoc($query_diagnosa)){
							$diagnosa_data[] = $row;
							$idpasienrj_list[] = "'".$row['IdPasienrj']."'";
							$noregistrasi_list[] = "'".$row['NoRegistrasi']."'";
						}
						
						// OPTIMASI: Batch query untuk data pasienrj
						$pasienrj_data = [];
						$pasien_data = [];
						$kk_data = [];
						$vitalsign_data = [];
						
						if(!empty($idpasienrj_list)){
							$idpasienrj_in = implode(',', array_unique($idpasienrj_list));
							$noregistrasi_in = implode(',', array_unique($noregistrasi_list));
							
							// Batch query pasienrj
							$tb_rj = ($tahunini == $tahun) ? $tbpasienrj : $tbpasienrj_retensi;
							$query_rj_batch = mysqli_query($koneksi, "SELECT * FROM `$tb_rj` WHERE IdPasienrj IN ($idpasienrj_in)");
							while($row = mysqli_fetch_assoc($query_rj_batch)){
								$pasienrj_data[$row['IdPasienrj']] = $row;
							}
							
							// Kumpulkan IdPasien dan NoIndex untuk batch query berikutnya
							$idpasien_list = [];
							$noindex_list = [];
							foreach($pasienrj_data as $rj){
								if(!empty($rj['IdPasien'])) $idpasien_list[] = "'".$rj['IdPasien']."'";
								if(!empty($rj['NoIndex'])) $noindex_list[] = "'".$rj['NoIndex']."'";
							}
							
							// Batch query pasien
							if(!empty($idpasien_list)){
								$idpasien_in = implode(',', array_unique($idpasien_list));
								$query_pasien_batch = mysqli_query($koneksi, "SELECT IdPasien, Nik, NoIndex, TanggalLahir FROM `$tbpasien` WHERE IdPasien IN ($idpasien_in)");
								while($row = mysqli_fetch_assoc($query_pasien_batch)){
									$pasien_data[$row['IdPasien']] = $row;
								}
							}
							
							// Batch query kk
							if(!empty($noindex_list)){
								$noindex_in = implode(',', array_unique($noindex_list));
								$query_kk_batch = mysqli_query($koneksi, "SELECT NoIndex, Alamat, RT, RW, Kelurahan, Kecamatan, Kota FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
								while($row = mysqli_fetch_assoc($query_kk_batch)){
									$kk_data[$row['NoIndex']] = $row;
								}
							}
							
							// Batch query vitalsign
							$query_vs_batch = mysqli_query($koneksi, "SELECT * FROM `$tbvitalsign` WHERE IdPasienrj IN ($idpasienrj_in)");
							while($row = mysqli_fetch_assoc($query_vs_batch)){
								$vitalsign_data[$row['IdPasienrj']] = $row;
							}
							
							// Batch query therapy (resep detail dengan nama obat)
							// Gunakan subquery untuk menghindari duplikat dari tbgudangpkmstok
							$therapy_data = [];
							$query_therapy_batch = mysqli_query($koneksi, "SELECT rd.NoResep, rd.KodeBarang, rd.jumlahobat, 
								(SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE KodeBarang = rd.KodeBarang LIMIT 1) as NamaBarang 
								FROM `$tbresepdetail` rd 
								WHERE rd.NoResep IN ($noregistrasi_in)");
							while($row = mysqli_fetch_assoc($query_therapy_batch)){
								$therapy_data[$row['NoResep']][] = $row['NamaBarang']." (".$row['jumlahobat'].")";
							}
						}
						
						// Cache untuk ec_subdistricts, ec_districts, ec_cities
						$subdis_cache = [];
						$dis_cache = [];
						$city_cache = [];
						
						foreach($diagnosa_data as $data_diagnosa){
							$no = $no + 1;
							$idpasienrj = $data_diagnosa['IdPasienrj'];
							$noregistrasi = $data_diagnosa['NoRegistrasi'];
							$nocm = $data_diagnosa['NoCM'];
							$row_kodediagnosa = $data_diagnosa['KodeDiagnosa'];
							$row_kasus = $data_diagnosa['Kasus'];
						
							// Ambil dari batch data
							$data_rj = isset($pasienrj_data[$idpasienrj]) ? $pasienrj_data[$idpasienrj] : [];
							$noindex = isset($data_rj['NoIndex']) ? $data_rj['NoIndex'] : '';
							$kelamin = isset($data_rj['JenisKelamin']) ? $data_rj['JenisKelamin'] : '';
							$nokartu = isset($data_rj['nokartu']) ? $data_rj['nokartu'] : '';
						
							// tbpasien dari batch
							$dt_pasien = isset($pasien_data[$data_rj['IdPasien']]) ? $pasien_data[$data_rj['IdPasien']] : [];
						
							// tbkk dari batch
							$datakk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
							
							// ec_subdistricts dengan cache
							$kelurahann = isset($datakk['Kelurahan']) ? $datakk['Kelurahan'] : '';
							if(!empty($datakk['Kelurahan']) && !isset($subdis_cache[$datakk['Kelurahan']])){
								$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT subdis_name FROM ec_subdistricts WHERE subdis_id='".mysqli_real_escape_string($koneksi, $datakk['Kelurahan'])."'"));
								$subdis_cache[$datakk['Kelurahan']] = $dt_subdis ? $dt_subdis['subdis_name'] : '';
							}
							if(!empty($subdis_cache[$datakk['Kelurahan']])){
								$kelurahann = $subdis_cache[$datakk['Kelurahan']];
							}

							// ec_districts dengan cache
							$kecamatan_val = isset($datakk['Kecamatan']) ? $datakk['Kecamatan'] : '';
							if(!empty($datakk['Kecamatan']) && !isset($dis_cache[$datakk['Kecamatan']])){
								$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT dis_name FROM ec_districts WHERE dis_name='".mysqli_real_escape_string($koneksi, $datakk['Kecamatan'])."'"));
								$dis_cache[$datakk['Kecamatan']] = $dt_dis ? $dt_dis['dis_name'] : '';
							}
							if(!empty($dis_cache[$datakk['Kecamatan']])){
								$kecamatan_val = $dis_cache[$datakk['Kecamatan']];
							}

							// ec_cities dengan cache
							$kota_val = isset($datakk['Kota']) ? $datakk['Kota'] : '';
							if(!empty($datakk['Kota']) && !isset($city_cache[$datakk['Kota']])){
								$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT city_name FROM ec_cities WHERE city_id='".mysqli_real_escape_string($koneksi, $datakk['Kota'])."'"));
								$city_cache[$datakk['Kota']] = $dt_citi ? $dt_citi['city_name'] : '';
							}
							if(!empty($city_cache[$datakk['Kota']])){
								$kota_val = $city_cache[$datakk['Kota']];
							}
							
							if(!empty($datakk['Alamat'])){
								$alamat_row = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
									strtoupper($kelurahann).", ".strtoupper($kecamatan_val).", ".strtoupper($kota_val);
							}else{
								$alamat_row = "Alamat Belum di Inputkan";
							}

							// Tentukan tabel poli
							$poli_pertama = isset($data_rj['PoliPertama']) ? $data_rj['PoliPertama'] : '';
							if ($poli_pertama == 'POLI UMUM'){
								$tbpoli = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
							}elseif($poli_pertama == 'POLI ANAK'){
								$tbpoli = 'tbpolianak';
							}elseif($poli_pertama == 'POLI GIGI'){
								$tbpoli = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
							}elseif($poli_pertama == 'POLI GIZI'){
								$tbpoli = 'tbpoligizi';
							}elseif($poli_pertama == 'POLI BERSALIN'){
								$tbpoli = 'tbpolibersalin';
							}elseif($poli_pertama == 'POLI ISOLASI'){
								$tbpoli = 'tbpoliisolasi';	
							}elseif($poli_pertama == 'POLI KB'){
								$tbpoli = 'tbpolikb';
							}elseif($poli_pertama == 'POLI KIA'){
								$tbpoli = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
							}elseif($poli_pertama == 'POLI LANSIA'){
								$tbpoli = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
							}elseif($poli_pertama == 'POLI MTBM'){
								$tbpoli = 'tbpolimtbm';
							}elseif($poli_pertama == 'POLI MTBS'){
								$tbpoli = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
							}elseif($poli_pertama == 'POLI PANDU PTM'){
								$tbpoli = 'tbpolipanduptm';	
							}elseif($poli_pertama == 'POLI INFEKSIUS'){
								$tbpoli = 'tbpoliinfeksius';	
							}elseif($poli_pertama == 'POLI SCREENING'){
								$tbpoli = 'tbpoliscreening';	
							}elseif($poli_pertama == 'POLI SKD'){
								$tbpoli = 'tbpoliskd';
							}elseif($poli_pertama == 'POLI TB DOTS' || $poli_pertama == 'POLI TB'){
								$tbpoli = 'tbpolitbdots';
							}elseif($poli_pertama == 'POLI UGD' || $poli_pertama == 'POLI TINDAKAN'){
								$tbpoli = 'tbpolitindakan';
							}elseif($poli_pertama == 'NURSING CENTER'){
								$tbpoli = 'tbpolinursingcenter';
							}else{
								$tbpoli = '';
							}

							// poli - masih perlu query individual karena tabel berbeda-beda
							$poli_data = [];
							if(!empty($tbpoli)){
								$poli_query = mysqli_query($koneksi, "SELECT Anamnesa FROM `$tbpoli` WHERE NoPemeriksaan = '".mysqli_real_escape_string($koneksi, $noregistrasi)."' AND NoCM='".mysqli_real_escape_string($koneksi, $nocm)."'");
								if($poli_query){
									$poli_data = mysqli_fetch_assoc($poli_query);
								}
							}
							
							// vital sign dari batch
							$dtvs = isset($vitalsign_data[$idpasienrj]) ? $vitalsign_data[$idpasienrj] : [];
							$dtsistole = isset($dtvs['Sistole']) ? $dtvs['Sistole'] : '';
							$dtdiastole = isset($dtvs['Diastole']) ? $dtvs['Diastole'] : '';
							$dtsuhutubuh = isset($dtvs['SuhuTubuh']) ? $dtvs['SuhuTubuh'] : '';
							$dttinggiBadan = isset($dtvs['TinggiBadan']) ? $dtvs['TinggiBadan'] : '';
							$dtberatBadan = isset($dtvs['BeratBadan']) ? $dtvs['BeratBadan'] : '';
							$dtheartRate = isset($dtvs['HeartRate']) ? $dtvs['HeartRate'] : '';
							$dtrespRate = isset($dtvs['RespiratoryRate']) ? $dtvs['RespiratoryRate'] : '';

							// kelamin
							if($kelamin == 'L'){
								if(isset($data_rj['UmurTahun']) && $data_rj['UmurTahun'] != '0'){
									$kelamin_l = $data_rj['UmurTahun']."Th";
								}else{
									$kelamin_l = (isset($data_rj['UmurBulan']) ? $data_rj['UmurBulan'] : '')."Bl";
								}	
								$kelamin_p = '-';
							}else{
								if(isset($data_rj['UmurTahun']) && $data_rj['UmurTahun'] != '0'){
									$kelamin_p = $data_rj['UmurTahun']."Th";
								}else{
									$kelamin_p = (isset($data_rj['UmurBulan']) ? $data_rj['UmurBulan'] : '')."Bl";
								}	
								$kelamin_l = '-';
							}
						
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalDiagnosa']));?></td>
								<td align="left">
									<b><?php echo strtoupper(isset($data_rj['NamaPasien']) ? $data_rj['NamaPasien'] : '');?></b>
									<?php 
										echo "<br/>Tgl.Lahir : ".(isset($dt_pasien['TanggalLahir']) ? date('d-m-Y', strtotime($dt_pasien['TanggalLahir'])) : '-')."<br/>".
										"No.BPJS : ".strtoupper($nokartu)."<br/>".
										'<i class="icon-user"></i>&nbsp'.strtoupper(isset($dt_pasien['Nik']) ? $dt_pasien['Nik'] : '')."<br/>".
										'<i class="icon-credit-card"></i>&nbsp'.substr($noindex,-10)."<br/>".
										'<i class="icon-location-pin"></i>&nbsp'.strtoupper($alamat_row);
									?>
								</td>
								<td align="center"><?php echo $kelamin_l;?></td>
								<td align="center"><?php echo $kelamin_p;?></td>
								<td align="center"><?php echo strtoupper(isset($data_rj['StatusKunjungan']) ? $data_rj['StatusKunjungan'] : '');?></td>
								<td align="center"><?php echo strtoupper($row_kasus);?></td>
								<td align="center"><?php echo isset($data_rj['Asuransi']) ? $data_rj['Asuransi'] : '';?></td>
								<td align="center"><?php echo $poli_pertama;?></td>
								<td align="left">
									<?php
										echo "<b>Anamnesa : </b><br/>".
										(isset($poli_data['Anamnesa']) ? $poli_data['Anamnesa'] : '')."<br/>".
										"<b>Vitalsign : </b><br/>".
										"TD : ".$dtsistole." / ".$dtdiastole."<br/>".
										"BB/TB : ".$dtberatBadan." / ".$dttinggiBadan."<br/>".
										"SUHU : ".$dtsuhutubuh."<br/>".
										"HR/RR : ".$dtheartRate." / ".$dtrespRate;
									?>
								</td>
								<td align="center"><?php echo $row_kodediagnosa;?></td>
								<td align="center">
									<?php 
										// therapy dari batch data
										if(isset($therapy_data[$noregistrasi]) && !empty($therapy_data[$noregistrasi])){
											echo implode("<br/>", $therapy_data[$noregistrasi]);
										}else{
									?>		
											<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
									<?php } ?>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/>
				
				<?php
					if(!empty($noregistrasi)){
						if($param_kodediagnosa == 'A03.0' OR $param_kodediagnosa == 'A06.0' OR $param_kodediagnosa == 'A09'){
				?>
				<a href="lap_P2M_penyakit_bulan_export.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kodedgs=<?php echo $_GET['kodebpjs'];?>&kdpkm=<?php echo $kodepuskesmas;?>" class="btn btn-sm btn-info">Export > Diare</a>
				<?php
						}
					}
				?>
			</div>
		</div>
	</div>
	<br>
	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = intval($jumlah_query / $jumlah_perpage) + 1;
			}else{
				$jumlah = intval($jumlah_query / $jumlah_perpage);
			}
			
			$current_page = isset($_GET['h']) && $_GET['h'] != '' ? intval($_GET['h']) : 1;
			
			for ($i=1; $i<=$jumlah; $i++){
				$max = $current_page + 5;
				$min = $current_page - 4;
			
				if($i <= $max && $i >= $min){
					if($current_page == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						// FIX: Gunakan parameter yang disimpan, bukan variabel yang ter-overwrite
						echo "<li><a href='?page=lap_P2M_penyakit_bulan&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&kodebpjs=$param_kodediagnosa&kasus=$param_kasus&kelurahan=$param_kelurahan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
	}else if($(this).val() == 'tahun'){	
		$(".bulanformcari").hide();
		$(".tahunformcari").show();	
	}else{	
		$(".bulanformcari").hide();
	}
});	
$(document).ready(function(){
	if($('.opsiform').val() == 'bulan'){
		$(".bulanformcari").show();
	}else{	
		$(".bulanformcari").hide();
	}
});	
</script>