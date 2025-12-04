<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER POLI LANSIA</b></h3>
			<div class="formbg">
				<form role="form">
					<?php
					$get_keydate1 = isset($_GET['keydate1']) ? $_GET['keydate1'] : '';
					$get_keydate2 = isset($_GET['keydate2']) ? $_GET['keydate2'] : '';
					$get_kunjungan = isset($_GET['kunjungan']) ? $_GET['kunjungan'] : 'Semua';
					$get_kelompokumur = isset($_GET['kelompokumur']) ? $_GET['kelompokumur'] : 'Semua';
					?>
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $get_keydate1;?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $get_keydate2;?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-2">
							<select name="kunjungan" class="form-control"placeholder="--Kunj--">
								<option value="Semua" <?php if($get_kunjungan == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($get_kunjungan == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($get_kunjungan == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kelompokumur" class="form-control"placeholder="--Kunj--">
								<option value="Semua" <?php if($get_kelompokumur == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Pralansia (45 s/d 59)" <?php if($get_kelompokumur == 'Pralansia (45 s/d 59)'){echo "SELECTED";}?>>Pralansia (45 s/d 59)</option>
								<option value="Lansia (>60)" <?php if($get_kelompokumur == 'Lansia (>60)'){echo "SELECTED";}?>>Lansia (>60)</option>
							</select>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_lansia_excel.php?keydate1=<?php echo $get_keydate1;?>&keydate2=<?php echo $get_keydate2;?>&kunjungan=<?php echo $get_kunjungan;?>&kelompokumur=<?php echo $get_kelompokumur;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>	
	</div>
	<?php
	// Gunakan variable yang sudah di-set di form
	$keydate1 = mysqli_real_escape_string($koneksi, $get_keydate1);
	$keydate2 = mysqli_real_escape_string($koneksi, $get_keydate2);
	$kunjungan_param = $get_kunjungan;
	$kelompokumur = $get_kelompokumur;
		
	if($keydate1 != '' && $keydate2 != ''){
	?>
	<!--data registrasi-->
	<div class="table-responsive noprint">
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="7%">TGL.PERIKSA</th>
					<th rowspan="2" width="15%">NAMA PASIEN</th>
					<th colspan="2" width="8%">UMUR</th>
					<th rowspan="2" width="10%">ALAMAT</th>
					<th rowspan="2" width="5%">KUNJ.</th>
					<th colspan="5" width="8%">VITAL SIGN</th>
					<th rowspan="2" width="10%">ANAMNESA</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="10%">THERAPY</th>
					<th colspan="2" width="5%">RUJUK</th>
					<th rowspan="2" width="8%">KET.</th>
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
				$jumlah_perpage = 20;
				
				$current_h = isset($_GET['h']) && $_GET['h'] != '' ? intval($_GET['h']) : 1;
				if($current_h < 1) $current_h = 1;
				$mulai = ($current_h - 1) * $jumlah_perpage;
				
				// OPTIMASI: Query HANYA dari tbpolilansia dulu (tanpa JOIN yang lambat)
				// Query data utama - TANPA JOIN, ambil +1 untuk cek ada halaman berikutnya
				$fetch_limit = $jumlah_perpage + 1;
				$str2 = "SELECT * FROM `$tbpolilansia` 
				WHERE TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'
				ORDER BY TanggalPeriksa DESC 
				LIMIT $mulai, $fetch_limit";
				
				$no = $mulai;
				$query = mysqli_query($koneksi, $str2);
				
				// Kumpulkan data lansia dan NoRegistrasi untuk batch query
				$lansia_data = [];
				$noregistrasi_list = [];
				
				if($query){
					while($row = mysqli_fetch_assoc($query)){
						$lansia_data[] = $row;
						$noregistrasi_list[] = "'".mysqli_real_escape_string($koneksi, $row['NoPemeriksaan'])."'";
					}
				}
				
				// Batch query untuk data pasienrj
				$pasienrj_data = [];
				$idpasien_list = [];
				$noindex_list = [];
				
				if(!empty($noregistrasi_list)){
					$noregistrasi_in = implode(',', array_unique($noregistrasi_list));
					$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, IdPasien, NoIndex, JenisKelamin, UmurTahun, StatusKunjungan, PoliPertama, StatusPulang, Asuransi 
					FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noregistrasi_in)");
					if($q_rj){
						while($row = mysqli_fetch_assoc($q_rj)){
							$pasienrj_data[$row['NoRegistrasi']] = $row;
							if(!empty($row['IdPasien'])) $idpasien_list[] = "'".$row['IdPasien']."'";
							if(!empty($row['NoIndex'])) $noindex_list[] = "'".$row['NoIndex']."'";
						}
					}
				}
				
				// Filter berdasarkan kunjungan dan umur (setelah data didapat)
				$filtered_data = [];
				foreach($lansia_data as $data){
					$rj = isset($pasienrj_data[$data['NoPemeriksaan']]) ? $pasienrj_data[$data['NoPemeriksaan']] : null;
					if(!$rj) continue;
					
					// Filter kunjungan
					if($kunjungan_param == 'Baru' && $rj['StatusKunjungan'] != 'Baru') continue;
					if($kunjungan_param == 'Lama' && $rj['StatusKunjungan'] != 'Lama') continue;
					
					// Filter umur
					$umur = isset($rj['UmurTahun']) ? intval($rj['UmurTahun']) : 0;
					if($kelompokumur == 'Pralansia (45 s/d 59)' && ($umur < 45 || $umur > 59)) continue;
					if($kelompokumur == 'Lansia (>60)' && $umur < 60) continue;
					
					$filtered_data[] = array_merge($data, $rj);
				}
				
				// Cek apakah ada halaman berikutnya (jika filtered_data > jumlah_perpage)
				$has_more_data = (count($filtered_data) > $jumlah_perpage);
				
				// Potong ke jumlah_perpage untuk display
				$lansia_data = array_slice($filtered_data, 0, $jumlah_perpage);
				
				// Batch query jika ada data
				$pasien_data = [];
				$kk_data = [];
				$pegawai_data = [];
				$diagnosa_data = [];
				$therapy_data = [];
				$subdis_cache = [];
				$dis_cache = [];
				
				if(!empty($noregistrasi_list)){
					$noregistrasi_in = implode(',', array_unique($noregistrasi_list));
					
					// Batch: tbpasienperpegawai
					$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
					$q_pegawai = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPegawai1, NamaPegawai2 FROM `$tbpasienperpegawai` WHERE NoRegistrasi IN ($noregistrasi_in)");
					if($q_pegawai){
						while($row = mysqli_fetch_assoc($q_pegawai)){
							$pegawai_data[$row['NoRegistrasi']] = $row;
						}
					}
					
					// Batch: tbdiagnosapasien dengan nama diagnosa
					$q_diagnosa = mysqli_query($koneksi, "SELECT d.NoRegistrasi, d.KodeDiagnosa, b.Diagnosa 
					FROM `$tbdiagnosapasien` d 
					LEFT JOIN `tbdiagnosabpjs` b ON d.KodeDiagnosa = b.KodeDiagnosa 
					WHERE d.NoRegistrasi IN ($noregistrasi_in) 
					GROUP BY d.NoRegistrasi, d.KodeDiagnosa");
					if($q_diagnosa){
						while($row = mysqli_fetch_assoc($q_diagnosa)){
							$diagnosa_data[$row['NoRegistrasi']][] = "<b>".$row['KodeDiagnosa']."</b> ".$row['Diagnosa'];
						}
					}
					
					// Batch: therapy dengan nama obat (gunakan subquery untuk hindari duplikat)
					$q_therapy = mysqli_query($koneksi, "SELECT rd.NoResep, rd.KodeBarang, rd.jumlahobat,
					(SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE KodeBarang = rd.KodeBarang LIMIT 1) as NamaBarang
					FROM `$tbresepdetail` rd 
					WHERE rd.NoResep IN ($noregistrasi_in)");
					if($q_therapy){
						while($row = mysqli_fetch_assoc($q_therapy)){
							$therapy_data[$row['NoResep']][] = $row['NamaBarang']." (".$row['jumlahobat'].")";
						}
					}
				}
				
				if(!empty($idpasien_list)){
					$idpasien_in = implode(',', array_unique($idpasien_list));
					// Batch: tbpasien
					$q_pasien = mysqli_query($koneksi, "SELECT IdPasien, NoIndex, Nik, NoAsuransi FROM `$tbpasien` WHERE IdPasien IN ($idpasien_in)");
					if($q_pasien){
						while($row = mysqli_fetch_assoc($q_pasien)){
							$pasien_data[$row['IdPasien']] = $row;
						}
					}
				}
				
				if(!empty($noindex_list)){
					$noindex_in = implode(',', array_unique($noindex_list));
					// Batch: tbkk
					$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Kelurahan, Kecamatan FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
					if($q_kk){
						while($row = mysqli_fetch_assoc($q_kk)){
							$kk_data[$row['NoIndex']] = $row;
						}
					}
				}
				
				// Siapkan cache kelurahan & kecamatan agar tidak query berulang
				$kelurahan_ids = [];
				$kecamatan_ids = [];
				foreach($kk_data as $kk){
					if(!empty($kk['Kelurahan'])){
						$kelurahan_ids[$kk['Kelurahan']] = true;
					}
					if(!empty($kk['Kecamatan'])){
						$kecamatan_ids[$kk['Kecamatan']] = true;
					}
				}
				if(!empty($kelurahan_ids)){
					$kel_in = implode(',', array_map(function($id) use ($koneksi){
						return "'".mysqli_real_escape_string($koneksi, $id)."'";
					}, array_keys($kelurahan_ids)));
					$q_kel = mysqli_query($koneksi, "SELECT subdis_id, subdis_name FROM ec_subdistricts WHERE subdis_id IN ($kel_in)");
					if($q_kel){
						while($row = mysqli_fetch_assoc($q_kel)){
							$subdis_cache[$row['subdis_id']] = $row['subdis_name'];
						}
					}
				}
				if(!empty($kecamatan_ids)){
					$kec_in = implode(',', array_map(function($id) use ($koneksi){
						return "'".mysqli_real_escape_string($koneksi, $id)."'";
					}, array_keys($kecamatan_ids)));
					$q_kec = mysqli_query($koneksi, "SELECT dis_id, dis_name FROM ec_districts WHERE dis_id IN ($kec_in)");
					if($q_kec){
						while($row = mysqli_fetch_assoc($q_kec)){
							$dis_cache[$row['dis_id']] = $row['dis_name'];
						}
					}
				}
				
				// Loop untuk display (tanpa query tambahan)
				foreach($lansia_data as $data){
					$no++;
					$idpasien = $data['IdPasien'];
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kunjungan = $data['StatusKunjungan'];
					$tensi = $data['Sistole']."/".$data['Diastole'];
					$bb = $data['BeratBadan'];
					$tb = $data['TinggiBadan'];
					$suhu = $data['SuhuTubuh'];
					$hrrr = $data['DetakNadi']."/".$data['RR'];
					$kelamin = $data['JenisKelamin'];
					
					// Data dari batch
					$dt_pegawai = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
					$pemeriksa = !empty($dt_pegawai['NamaPegawai1']) ? $dt_pegawai['NamaPegawai1'] : (isset($dt_pegawai['NamaPegawai2']) ? $dt_pegawai['NamaPegawai2'] : '');
					
					$dt_pasien = isset($pasien_data[$idpasien]) ? $pasien_data[$idpasien] : [];
					$nik = isset($dt_pasien['Nik']) ? $dt_pasien['Nik'] : '';
					$noasuransi = isset($dt_pasien['NoAsuransi']) ? $dt_pasien['NoAsuransi'] : '';
					
					$datakk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
					
					// ec_subdistricts & districts dari cache batch
					$kelurahan_val = isset($datakk['Kelurahan']) ? $datakk['Kelurahan'] : '';
					if(!empty($datakk['Kelurahan']) && isset($subdis_cache[$datakk['Kelurahan']]) && $subdis_cache[$datakk['Kelurahan']] != ''){
						$kelurahan_val = $subdis_cache[$datakk['Kelurahan']];
					}
					
					$kecamatan_val = isset($datakk['Kecamatan']) ? $datakk['Kecamatan'] : '';
					if(!empty($datakk['Kecamatan']) && isset($dis_cache[$datakk['Kecamatan']]) && $dis_cache[$datakk['Kecamatan']] != ''){
						$kecamatan_val = $dis_cache[$datakk['Kecamatan']];
					}
					
					$alamat = (isset($datakk['Alamat']) ? $datakk['Alamat'] : '').", RT.".(isset($datakk['RT']) ? $datakk['RT'] : '').", RW.".(isset($datakk['RW']) ? $datakk['RW'] : '').", ".strtoupper($kelurahan_val).", ".strtoupper($kecamatan_val);
					
					// Umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data['UmurTahun']." th";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data['UmurTahun']." th";
					}
										
					// Rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}else{
						$berobatjalan = '-';
						$rujuklanjut = '-';
					}
					
					// Diagnosa dari batch
					$data_dgs = isset($diagnosa_data[$noregistrasi]) ? implode("<br/>", $diagnosa_data[$noregistrasi]) : '';
					
					// Therapy dari batch
					$data_trp = isset($therapy_data[$noregistrasi]) ? implode("<br/>", $therapy_data[$noregistrasi]) : '';
				?>
					<tr style="border:1px dashed #000;">
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['TanggalPeriksa'];?></td>
						<td align="left">
							<?php 
							echo "<b>".strtoupper($data['NamaPasien'])."</b><br/>".
							strtoupper(isset($datakk['NamaKK']) ? $datakk['NamaKK'] : '')."<br/>".
							substr($noindex, -10)."<br/>".
							"Nik.".$nik."<br/>".
							$data['Asuransi']."<br/>".
							$noasuransi;
						?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="left"><?php echo strtoupper($alamat);?></td>
						<td align="center"><?php echo $kunjungan;?></td>
						<td align="center"><?php echo $tensi;?></td>
						<td align="center"><?php echo $bb;?></td>
						<td align="center"><?php echo $tb;?></td>
						<td align="center"><?php echo $suhu;?></td>
						<td align="center"><?php echo $hrrr;?></td>
						<td align="left"><?php echo $anamnesa;?></td>
						<td align="left"><?php echo strtoupper($data_dgs);?></td>
						<td align="left"><?php echo strtoupper($data_trp);?></td>
						<td align="center"><?php echo $rujuklanjut;?></td>
						<td align="center"><?php echo $berobatjalan;?></td>
						<td align="left"><?php echo strtoupper($pemeriksa);?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div><br/>
	<ul class="pagination noprint">
		<?php
			// Pagination sederhana dengan Prev/Next
			$has_prev = ($current_h > 1);
			
			if($has_prev){
				$prev_page = $current_h - 1;
				echo "<li><a href='?page=lap_registrasi_lansia&keydate1=$keydate1&keydate2=$keydate2&kunjungan=$kunjungan_param&kelompokumur=$kelompokumur&h=$prev_page'>&laquo; Prev</a></li>";
			}
			
			// Tampilkan halaman saat ini
			echo "<li class='active'><span class='current'>Hal. $current_h</span></li>";
			
			if($has_more_data){
				$next_page = $current_h + 1;
				echo "<li><a href='?page=lap_registrasi_lansia&keydate1=$keydate1&keydate2=$keydate2&kunjungan=$kunjungan_param&kelompokumur=$kelompokumur&h=$next_page'>Next &raquo;</a></li>";
			}
		?>	
	</ul>
	<?php
	}
	mysqli_close($koneksi);
	?>
</div>	
