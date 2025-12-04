<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Safe GET parameters
	$get_keydate1 = isset($_GET['keydate1']) ? $_GET['keydate1'] : '';
	$get_keydate2 = isset($_GET['keydate2']) ? $_GET['keydate2'] : '';
	$get_namapegawai = isset($_GET['namapegawai']) ? $_GET['namapegawai'] : '';
	$get_h = isset($_GET['h']) ? intval($_GET['h']) : 1;
	if($get_h < 1) $get_h = 1;
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Register Askep</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_askep"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo htmlspecialchars($get_keydate1);?>" placeholder="Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo htmlspecialchars($get_keydate2);?>" placeholder="Tanggal Akhir">
						</div>
						<div class="col-xl-4">
							<select name="namapegawai" class="form-control cari">
								<option value=''>Semua Perawat</option>
								<?php
								$str_pegawai = mysqli_query($koneksi,"SELECT NamaPegawai FROM `tbpegawai` WHERE `Status`='PERAWAT' AND `KodePuskesmas`='$kodepuskesmas' ORDER BY `NamaPegawai`");
								while($dtpegawai = mysqli_fetch_assoc($str_pegawai)){
									$selected = ($dtpegawai['NamaPegawai'] == $get_namapegawai) ? 'selected' : '';
									echo "<option value='".htmlspecialchars($dtpegawai['NamaPegawai'])."' $selected>".htmlspecialchars($dtpegawai['NamaPegawai'])."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_askep" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
							<a href="lap_registrasi_askep_excel.php?keydate1=<?php echo urlencode($get_keydate1);?>&keydate2=<?php echo urlencode($get_keydate2);?>&namapegawai=<?php echo urlencode($get_namapegawai);?>" class="btn btn-round btn-success"><span class="fa fa-file-excel-o"></span> Excel</a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	
	<?php
	$keydate1 = mysqli_real_escape_string($koneksi, $get_keydate1);
	$keydate2 = mysqli_real_escape_string($koneksi, $get_keydate2);
	$namapegawai_filter = mysqli_real_escape_string($koneksi, $get_namapegawai);

	if($keydate1 != '' && $keydate2 != ''){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".strtoupper($kota);?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>REGISTER ASUHAN KEPERAWATAN</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo date('d-m-Y', strtotime($keydate1));?> s/d <?php echo date('d-m-Y', strtotime($keydate2));?></span>
		<br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NIK</th>
							<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PASIEN</th>
							<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L/P</th>
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">UMUR</th>
							<th colspan="5" style="text-align:center; border:1px solid #000; padding:3px;">VITAL SIGN</th>
							<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ANAMNESA</th>
							<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">DIAGNOSA KEPERAWATAN</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TINDAKAN</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PETUGAS</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="3%" style="text-align:center; border:1px solid #000; padding:3px;">TH</th>
							<th width="3%" style="text-align:center; border:1px solid #000; padding:3px;">BL</th>
							<th width="5%" style="text-align:center; border:1px solid #000; padding:3px;">TD</th>
							<th width="3%" style="text-align:center; border:1px solid #000; padding:3px;">BB</th>
							<th width="3%" style="text-align:center; border:1px solid #000; padding:3px;">TB</th>
							<th width="3%" style="text-align:center; border:1px solid #000; padding:3px;">SUHU</th>
							<th width="5%" style="text-align:center; border:1px solid #000; padding:3px;">HR/RR</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
						$mulai = ($get_h - 1) * $jumlah_perpage;
						
						// Filter pegawai (sama dengan original)
						$pegawai = '';
						if($namapegawai_filter != ''){
							$pegawai = " AND (`NamaPerawat1`='$namapegawai_filter' OR `NamaPerawat2`='$namapegawai_filter')"; 
						}
						
						// Query sama dengan original
						$str = "SELECT * FROM `$tbdiagnosaaskep`
						WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2'".$pegawai;
						$str2 = $str." GROUP BY `NoCM` ORDER BY `TanggalDiagnosa` DESC LIMIT $mulai,".($jumlah_perpage + 1);
						
						// Debug - uncomment untuk lihat query
						// echo "<!-- $str2 -->";
						
						$query = mysqli_query($koneksi, $str2);
						
						// Kumpulkan data untuk batch query
						$rows = [];
						$noregistrasi_list = [];
						$nocm_list = [];
						$idpasienrj_list = [];
						
						if($query){
							while($row = mysqli_fetch_assoc($query)){
								$rows[] = $row;
								$noregistrasi_list[$row['NoRegistrasi']] = true;
								$nocm_list[$row['NoCM']] = true;
							}
						}
						
						// Cek halaman selanjutnya
						$has_more = count($rows) > $jumlah_perpage;
						if($has_more){
							array_pop($rows);
						}
						
						// Batch query jika ada data
						$pasienrj_data = [];
						$pasien_data = [];
						$vitalsign_data = [];
						$diagnosa_data = [];
						
						if(!empty($rows)){
							// Batch query tbpasienrj untuk umur dan IdPasienrj
							if(!empty($noregistrasi_list)){
								$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
								$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, IdPasienrj, UmurTahun, UmurBulan FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
								if($q_rj){
									while($r = mysqli_fetch_assoc($q_rj)){
										$pasienrj_data[$r['NoRegistrasi']] = $r;
										$idpasienrj_list[$r['IdPasienrj']] = true;
									}
								}
							}
							
							// Batch query tbpasien untuk NIK
							if(!empty($nocm_list)){
								$nocm_in = "'".implode("','", array_keys($nocm_list))."'";
								$q_pasien = mysqli_query($koneksi, "SELECT NoCM, Nik FROM `$tbpasien` WHERE NoCM IN ($nocm_in)");
								if($q_pasien){
									while($r = mysqli_fetch_assoc($q_pasien)){
										$pasien_data[$r['NoCM']] = $r;
									}
								}
							}
							
							// Batch query tbvitalsign
							if(!empty($idpasienrj_list)){
								$idprj_in = "'".implode("','", array_keys($idpasienrj_list))."'";
								$q_vs = mysqli_query($koneksi, "SELECT IdPasienrj, Sistole, Diastole, SuhuTubuh, TinggiBadan, BeratBadan, HeartRate, RespiratoryRate FROM `$tbvitalsign` WHERE IdPasienrj IN ($idprj_in)");
								if($q_vs){
									while($r = mysqli_fetch_assoc($q_vs)){
										$vitalsign_data[$r['IdPasienrj']] = $r;
									}
								}
							}
							
							// Batch query diagnosa askep dengan JOIN
							if(!empty($noregistrasi_list)){
								$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
								$q_diag = mysqli_query($koneksi, "SELECT da.NoRegistrasi, dk.NamaDiagnosa 
									FROM `$tbdiagnosaaskep` da
									LEFT JOIN `tbdiagnosakeperawatan` dk ON da.KodeDiagnosa = dk.KodeDiagnosa
									WHERE da.NoRegistrasi IN ($noreg_in)");
								if($q_diag){
									while($r = mysqli_fetch_assoc($q_diag)){
										if(!isset($diagnosa_data[$r['NoRegistrasi']])){
											$diagnosa_data[$r['NoRegistrasi']] = [];
										}
										if($r['NamaDiagnosa']){
											$diagnosa_data[$r['NoRegistrasi']][] = $r['NamaDiagnosa'];
										}
									}
								}
							}
						}
						
						// Tampilkan data
						$no = $mulai;
						$hariini = '';
						
						foreach($rows as $data){
							// Separator tanggal
							if($hariini != $data['TanggalDiagnosa']){
								echo "<tr style='border:1px dashed #7a7a7a; background:#f5f5f5;'><td colspan='15' style='padding:5px; font-weight:bold;'>".date('d-m-Y', strtotime($data['TanggalDiagnosa']))."</td></tr>";
								$hariini = $data['TanggalDiagnosa'];
							}
							
							$no++;
							$noregistrasi = $data['NoRegistrasi'];
							$nocm = $data['NoCM'];
							
							// Data dari batch
							$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
							$idpasienrj = isset($rj['IdPasienrj']) ? $rj['IdPasienrj'] : '';
							$umur_th = isset($rj['UmurTahun']) ? $rj['UmurTahun'] : '-';
							$umur_bl = isset($rj['UmurBulan']) ? $rj['UmurBulan'] : '-';
							
							$nik = isset($pasien_data[$nocm]['Nik']) ? $pasien_data[$nocm]['Nik'] : '-';
							
							$vs = isset($vitalsign_data[$idpasienrj]) ? $vitalsign_data[$idpasienrj] : [];
							$sistole = isset($vs['Sistole']) && $vs['Sistole'] != '' ? $vs['Sistole'] : '0';
							$diastole = isset($vs['Diastole']) && $vs['Diastole'] != '' ? $vs['Diastole'] : '0';
							$suhu = isset($vs['SuhuTubuh']) && $vs['SuhuTubuh'] != '' ? $vs['SuhuTubuh'] : '0';
							$tb = isset($vs['TinggiBadan']) && $vs['TinggiBadan'] != '' ? $vs['TinggiBadan'] : '0';
							$bb = isset($vs['BeratBadan']) && $vs['BeratBadan'] != '' ? $vs['BeratBadan'] : '0';
							$hr = isset($vs['HeartRate']) && $vs['HeartRate'] != '' ? $vs['HeartRate'] : '0';
							$rr = isset($vs['RespiratoryRate']) && $vs['RespiratoryRate'] != '' ? $vs['RespiratoryRate'] : '0';
							
							$diagnosa_str = isset($diagnosa_data[$noregistrasi]) ? implode(", ", array_unique($diagnosa_data[$noregistrasi])) : '';
							
							$petugas = $namapegawai_filter != '' ? $namapegawai_filter : trim($data['NamaPerawat1']." / ".$data['NamaPerawat2'], " /");
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px; font-size:9px;"><?php echo $nik;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_th;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_bl;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $sistole."/".$diastole;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bb;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tb;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $suhu;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $hr."/".$rr;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px; font-size:9px;"><?php echo strtoupper($data['Anamnesa']);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px; font-size:9px;"><?php echo strtoupper($diagnosa_str);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px; font-size:9px;"><?php echo $data['TindakanKeperawatan'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px; font-size:9px;"><?php echo $petugas;?></td>
							</tr>
						<?php
						}
						
						if(count($rows) == 0){
							echo "<tr><td colspan='15' style='text-align:center; padding:20px; border:1px solid #000;'>Tidak ada data askep untuk periode ini</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Pagination -->
	<ul class="pagination noprint">
		<?php
		$param_url = "page=lap_registrasi_askep&keydate1=$keydate1&keydate2=$keydate2&namapegawai=".urlencode($namapegawai_filter);
		
		if($get_h > 1){
			echo "<li><a href='?{$param_url}&h=".($get_h-1)."'>&laquo; Prev</a></li>";
		}
		
		echo "<li class='active'><span>Halaman $get_h</span></li>";
		
		if($has_more){
			echo "<li><a href='?{$param_url}&h=".($get_h+1)."'>Next &raquo;</a></li>";
		}
		?>
	</ul>
	<br>
	<?php
	}
	?>
</div>

<style>
.table-judul-laporan {
	font-family: "Tahoma", "Trebuchet MS", sans-serif;
	font-size: 11px;
}
.table-judul-laporan th {
	font-size: 10px;
	background: #5a5a5a;
	color: #fff;
}
.table-judul-laporan td {
	font-size: 10px;
}
.font10 { font-size: 10px; font-family: "Tahoma"; }
.font11 { font-size: 11px; font-family: "Tahoma"; }
.font14 { font-size: 14px; font-family: "Tahoma"; }
@media print {
	.noprint { display: none !important; }
	.printheader { display: block !important; }
}
.printheader { display: none; }
</style>
