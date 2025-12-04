<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	// Safe GET parameters
	$get_keydate1 = isset($_GET['keydate1']) ? $_GET['keydate1'] : '';
	$get_keydate2 = isset($_GET['keydate2']) ? $_GET['keydate2'] : '';
	$get_h = isset($_GET['h']) ? intval($_GET['h']) : 1;
	if($get_h < 1) $get_h = 1;
?>

<style>
.table-judul-laporan { font-family: "Tahoma", sans-serif; font-size: 10px; }
.table-judul-laporan th { font-size: 9px; background: #5a5a5a; color: #fff; }
.table-judul-laporan td { font-size: 9px; }
.font10 { font-size: 10px; font-family: "Tahoma"; }
.font11 { font-size: 11px; font-family: "Tahoma"; }
.font14 { font-size: 14px; font-family: "Tahoma"; }
@media print {
	.noprint { display: none !important; }
	.printheader { display: block !important; }
}
.printheader { display: none; }
</style>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER GIGI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_registrasi_gigi"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo htmlspecialchars($get_keydate1);?>" placeholder="Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo htmlspecialchars($get_keydate2);?>" placeholder="Tanggal Akhir" required>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_gigi" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
							<a href="lap_registrasi_gigi_excel.php?keydate1=<?php echo urlencode($get_keydate1);?>&keydate2=<?php echo urlencode($get_keydate2);?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel-o"></span> Excel</a>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>
	
	<?php
	$keydate1 = mysqli_real_escape_string($koneksi, $get_keydate1);
	$keydate2 = mysqli_real_escape_string($koneksi, $get_keydate2);

	if($keydate1 != '' && $keydate2 != ''){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".strtoupper($kota);?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PELAYANAN GIGI</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo date('d-m-Y', strtotime($keydate1));?> s/d <?php echo date('d-m-Y', strtotime($keydate2));?></span>
		<br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="2%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">NO.</th>
							<th width="6%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">TANGGAL</th>
							<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">NAMA PASIEN</th>
							<th width="6%" colspan="2" style="text-align:center; border:1px solid #000; padding:2px;">UMUR</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">KUNJ.</th>
							<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">ALAMAT</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">BENGKAK</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">SUHU</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">GUSI</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">GOYANG</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">KARIES</th>
							<th width="6%" colspan="2" style="text-align:center; border:1px solid #000; padding:2px;">TINDAK LANJUT</th>
							<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">ULANG</th>
							<th width="8%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">ANAMNESA</th>
							<th width="8%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">DIAGNOSA</th>
							<th width="8%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">THERAPY</th>
							<th width="6%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">TINDAKAN</th>
							<th width="4%" colspan="2" style="text-align:center; border:1px solid #000; padding:2px;">RUJUK</th>
							<th width="6%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">PETUGAS</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:2px;">1</th>
							<th style="text-align:center; border:1px solid #000; padding:2px;">2</th>
							<th style="text-align:center; border:1px solid #000; padding:2px;">YA</th>
							<th style="text-align:center; border:1px solid #000; padding:2px;">TDK</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
						$mulai = ($get_h - 1) * $jumlah_perpage;
						
						// Query utama - HANYA dari tbpoligigi (tanpa JOIN lambat)
						$str_main = "SELECT TanggalPeriksa, NoPemeriksaan, NoIndex, Anamnesa, Bengkak, SuhuKulit, 
							WarnaGusi, Goyang, KariesGigi, TindakLanjut1, TindakLanjut2, Tindakan, KunjunganUlang
						FROM `$tbpoligigi`
						WHERE TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2 23:59:59'
						ORDER BY TanggalPeriksa ASC 
						LIMIT $mulai, ".($jumlah_perpage + 1);
						
						$query_main = mysqli_query($koneksi, $str_main);
						
						// Kumpulkan data untuk batch query
						$rows = [];
						$noindex_list = [];
						$noregistrasi_list = [];
						
						if($query_main){
							while($row = mysqli_fetch_assoc($query_main)){
								$rows[] = $row;
								if($row['NoIndex']) $noindex_list[$row['NoIndex']] = true;
								$noregistrasi_list[$row['NoPemeriksaan']] = true;
							}
						}
						
						// Cek halaman selanjutnya
						$has_more = count($rows) > $jumlah_perpage;
						if($has_more) array_pop($rows);
						
						// Batch query jika ada data
						$kk_data = [];
						$subdistrict_cache = [];
						$district_cache = [];
						$diagnosa_data = [];
						$therapy_data = [];
						$pasienrj_data = [];
						$pegawai_data = [];
						
						if(!empty($rows)){
							$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
							
							// Batch query tbpasienrj
							$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPasien, UmurTahun, JenisKelamin, StatusPulang, Asuransi, StatusKunjungan 
								FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
							if($q_rj){
								while($r = mysqli_fetch_assoc($q_rj)){
									$pasienrj_data[$r['NoRegistrasi']] = $r;
								}
							}
							
							// Batch query tbpasienperpegawai
							$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
							$q_pgw = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPegawai1, NamaPegawai2 
								FROM `$tbpasienperpegawai` WHERE NoRegistrasi IN ($noreg_in)");
							if($q_pgw){
								while($r = mysqli_fetch_assoc($q_pgw)){
									$pegawai_data[$r['NoRegistrasi']] = $r;
								}
							}
							
							// Batch query tbkk
							if(!empty($noindex_list)){
								$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
								$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Kelurahan, Kecamatan FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
								if($q_kk){
									while($r = mysqli_fetch_assoc($q_kk)){
										$kk_data[$r['NoIndex']] = $r;
									}
								}
							}
							
							// Cache ec_subdistricts
							$kel_ids = [];
							$kec_ids = [];
							foreach($kk_data as $kk){
								if($kk['Kelurahan']) $kel_ids[$kk['Kelurahan']] = true;
								if($kk['Kecamatan']) $kec_ids[$kk['Kecamatan']] = true;
							}
							
							if(!empty($kel_ids)){
								$kel_in = "'".implode("','", array_keys($kel_ids))."'";
								$q_sub = mysqli_query($koneksi, "SELECT subdis_id, subdis_name FROM `ec_subdistricts` WHERE subdis_id IN ($kel_in)");
								if($q_sub){
									while($r = mysqli_fetch_assoc($q_sub)){
										$subdistrict_cache[$r['subdis_id']] = $r['subdis_name'];
									}
								}
							}
							
							if(!empty($kec_ids)){
								$kec_in = "'".implode("','", array_keys($kec_ids))."'";
								$q_dis = mysqli_query($koneksi, "SELECT dis_id, dis_name FROM `ec_districts` WHERE dis_id IN ($kec_in)");
								if($q_dis){
									while($r = mysqli_fetch_assoc($q_dis)){
										$district_cache[$r['dis_id']] = $r['dis_name'];
									}
								}
							}
							
							// Batch query diagnosa dengan JOIN
							$q_diag = mysqli_query($koneksi, "SELECT dp.NoRegistrasi, dp.KodeDiagnosa, db.Diagnosa 
								FROM `$tbdiagnosapasien` dp
								LEFT JOIN `tbdiagnosabpjs` db ON dp.KodeDiagnosa = db.KodeDiagnosa
								WHERE dp.NoRegistrasi IN ($noreg_in)
								GROUP BY dp.NoRegistrasi, dp.KodeDiagnosa");
							if($q_diag){
								while($r = mysqli_fetch_assoc($q_diag)){
									if(!isset($diagnosa_data[$r['NoRegistrasi']])) $diagnosa_data[$r['NoRegistrasi']] = [];
									$diagnosa_data[$r['NoRegistrasi']][] = "<b>".$r['KodeDiagnosa']."</b> ".$r['Diagnosa'];
								}
							}
							
							// Batch query therapy dengan subquery
							$q_therapy = mysqli_query($koneksi, "SELECT rd.NoResep, rd.KodeBarang, rd.jumlahobat,
								(SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE KodeBarang = rd.KodeBarang LIMIT 1) as NamaBarang
								FROM `$tbresepdetail` rd
								WHERE rd.NoResep IN ($noreg_in)");
							if($q_therapy){
								while($r = mysqli_fetch_assoc($q_therapy)){
									if(!isset($therapy_data[$r['NoResep']])) $therapy_data[$r['NoResep']] = [];
									if($r['NamaBarang']){
										$therapy_data[$r['NoResep']][] = $r['NamaBarang']." (".$r['jumlahobat'].")";
									}
								}
							}
						}
						
						// Tampilkan data
						$no = $mulai;
						foreach($rows as $data){
							$no++;
							$noregistrasi = $data['NoPemeriksaan'];
							$noindex = $data['NoIndex'];
							
							// Data dari batch pasienrj
							$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
							$kelamin = isset($rj['JenisKelamin']) ? $rj['JenisKelamin'] : '';
							
							// Pemeriksa dari batch
							$pgw = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
							$pemeriksa = isset($pgw['NamaPegawai1']) && $pgw['NamaPegawai1'] != '' ? $pgw['NamaPegawai1'] : (isset($pgw['NamaPegawai2']) ? $pgw['NamaPegawai2'] : '');
							
							// Alamat dari batch
							$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
							$kelurahan = isset($subdistrict_cache[$kk['Kelurahan']]) ? $subdistrict_cache[$kk['Kelurahan']] : (isset($kk['Kelurahan']) ? $kk['Kelurahan'] : '');
							$kecamatan = isset($district_cache[$kk['Kecamatan']]) ? $district_cache[$kk['Kecamatan']] : (isset($kk['Kecamatan']) ? $kk['Kecamatan'] : '');
							
							$alamat_pasien = isset($kk['Alamat']) && $kk['Alamat'] != '' 
								? $kk['Alamat'].", RT.".$kk['RT'].", ".strtoupper($kelurahan)
								: '<span style="color:red;">Belum Terdaftar</span>';
							
							// Diagnosa dari batch
							$data_dgs = isset($diagnosa_data[$noregistrasi]) ? implode("<br/>", $diagnosa_data[$noregistrasi]) : '';
							
							// Therapy dari batch
							$data_trp = isset($therapy_data[$noregistrasi]) ? implode("<br/>", $therapy_data[$noregistrasi]) : '';
							
							// Umur per kelamin (dari batch pasienrj)
							$umur_tahun = isset($rj['UmurTahun']) ? $rj['UmurTahun'] : '';
							$umur_l = $kelamin == 'L' ? $umur_tahun." TH" : "-";
							$umur_p = $kelamin == 'P' ? $umur_tahun." TH" : "-";
							
							// Rujukan (dari batch pasienrj)
							$rujukan = isset($rj['StatusPulang']) ? $rj['StatusPulang'] : '';
							$rujuklanjut = ($rujukan == 4) ? '<span class="fa fa-check"></span>' : '-';
							$berobatjalan = ($rujukan == 3) ? '<span class="fa fa-check"></span>' : '-';
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;">
									<b><?php echo isset($rj['NamaPasien']) ? strtoupper($rj['NamaPasien']) : '';?></b><br/>
									<?php echo isset($kk['NamaKK']) ? strtoupper($kk['NamaKK']) : '';?><br/>
									<?php echo substr($noindex,-10)." - ".(isset($rj['Asuransi']) ? $rj['Asuransi'] : '');?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $umur_l;?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $umur_p;?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo isset($rj['StatusKunjungan']) ? strtoupper($rj['StatusKunjungan']) : '';?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo $alamat_pasien;?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['Bengkak']);?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['SuhuKulit']);?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['WarnaGusi']);?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['Goyang']);?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['KariesGigi']);?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo $data['TindakLanjut1'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo $data['TindakLanjut2'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $data['KunjunganUlang'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['Anamnesa']);?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo $data_dgs;?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo $data_trp;?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo strtoupper($data['Tindakan']);?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $rujuklanjut;?></td>
								<td style="text-align:center; border:1px solid #000; padding:2px;"><?php echo $berobatjalan;?></td>
								<td style="text-align:left; border:1px solid #000; padding:2px;"><?php echo $pemeriksa;?></td>
							</tr>
						<?php
						}
						
						if(count($rows) == 0){
							echo "<tr><td colspan='22' style='text-align:center; padding:20px; border:1px solid #000;'>Tidak ada data</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br/>
	
	<!-- Pagination -->
	<ul class="pagination noprint">
		<?php
		$param_url = "page=lap_registrasi_gigi&keydate1=$keydate1&keydate2=$keydate2";
		
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
