<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	$tanggal = date('Y-m-d');
	
	// Safe GET parameters
	$get_keydate1 = isset($_GET['keydate1']) ? $_GET['keydate1'] : '';
	$get_keydate2 = isset($_GET['keydate2']) ? $_GET['keydate2'] : '';
	$get_sts_bpjs = isset($_GET['sts_bpjs']) ? $_GET['sts_bpjs'] : 'semua';
	$get_statuspasien = isset($_GET['statuspasien']) ? $_GET['statuspasien'] : 'semua';
	$get_h = isset($_GET['h']) ? intval($_GET['h']) : 1;
	if($get_h < 1) $get_h = 1;
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PESERTA BPJS DETAIL</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_bpjs_sakitsehat_detail"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $get_keydate1;?>" placeholder="Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $get_keydate2;?>" placeholder="Tanggal Akhir" required>
						</div>
						<div class="col-xl-2">
							<select name="sts_bpjs" class="form-control">
								<option value="semua" <?php if($get_sts_bpjs == 'semua'){echo "selected";}?>>Semua BPJS</option>
								<option value="BPJS PBI" <?php if($get_sts_bpjs == 'BPJS PBI'){echo "selected";}?>>BPJS PBI</option>
								<option value="BPJS NON PBI" <?php if($get_sts_bpjs == 'BPJS NON PBI'){echo "selected";}?>>BPJS NON PBI</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="statuspasien" class="form-control">
								<option value="semua" <?php if($get_statuspasien == 'semua'){echo "selected";}?>>Semua Kunjungan</option>
								<option value="1" <?php if($get_statuspasien == '1'){echo "selected";}?>>Kunjungan Sakit</option>
								<option value="2" <?php if($get_statuspasien == '2'){echo "selected";}?>>Kunjungan Sehat</option>
							</select>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_bpjs_sakitsehat_detail" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_bpjs_sakitsehat_detail_excel.php?keydate1=<?php echo $get_keydate1;?>&keydate2=<?php echo $get_keydate2;?>&sts_bpjs=<?php echo $get_sts_bpjs;?>&statuspasien=<?php echo $get_statuspasien;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel-o"></span> Excel</a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<?php
	$keydate1 = mysqli_real_escape_string($koneksi, $get_keydate1);
	$keydate2 = mysqli_real_escape_string($koneksi, $get_keydate2);
	$sts_bpjs = mysqli_real_escape_string($koneksi, $get_sts_bpjs);
	$statuspasien = mysqli_real_escape_string($koneksi, $get_statuspasien);
	
	if($keydate1 != '' && $keydate2 != ''){
		$bulan = date('m', strtotime($keydate1));
		$tahun = date('Y', strtotime($keydate1));
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".strtoupper($kota);?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PESERTA BPJS DETAIL</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo date('d-m-Y', strtotime($keydate1));?> s/d <?php echo date('d-m-Y', strtotime($keydate2));?></span>
		<br/>
	</div>

	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-condensed table-judul-laporan" width="100%">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="9%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TANGGAL</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.INDEX</th>
							<th width="14%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PASIEN</th>
							<th width="18%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ALAMAT</th>
							<th width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">UMUR</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">DIAGNOSA</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PELAYANAN</th>
							<th width="9%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ASURANSI</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.KARTU</th>
							<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">STATUS</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 100;
						$mulai = ($get_h - 1) * $jumlah_perpage;
						
						// Build WHERE clause
						$where_asuransi = ($sts_bpjs == 'semua') 
							? "Asuransi LIKE '%BPJS%'" 
							: "Asuransi = '$sts_bpjs'";
						
						// Filter StatusPasien dengan logic yang benar
						// Kunjungan Sakit (1) = harus StatusPelayanan='Sudah'
						// Kunjungan Sehat (2) = tidak perlu StatusPelayanan='Sudah'
						if($statuspasien == 'semua'){
							$where_status = "((StatusPasien = '1' AND StatusPelayanan = 'Sudah') OR StatusPasien = '2')";
						} elseif($statuspasien == '1'){
							$where_status = "StatusPasien = '1' AND StatusPelayanan = 'Sudah'";
						} else {
							$where_status = "StatusPasien = '2'";
						}
						
						// Query utama dengan LIMIT untuk pagination
						$str_main = "SELECT NoRegistrasi, NoIndex, NoCM, NamaPasien, TanggalRegistrasi, 
							UmurTahun, PoliPertama, Asuransi, nokartu, StatusKunjungan, StatusPasien
						FROM `$tbpasienrj` 
						WHERE $where_asuransi 
						AND TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2 23:59:59'
						AND NoUrutBpjs != '' AND NoUrutBpjs IS NOT NULL
						AND $where_status
						ORDER BY TanggalRegistrasi, NamaPasien 
						LIMIT $mulai, ".($jumlah_perpage + 1);
						
						$query_main = mysqli_query($koneksi, $str_main);
						
						// Kumpulkan data untuk batch query
						$rows = [];
						$noindex_list = [];
						$noregistrasi_list = [];
						
						if($query_main){
							while($row = mysqli_fetch_assoc($query_main)){
								$rows[] = $row;
								$noindex_list[$row['NoIndex']] = true;
								$noregistrasi_list[$row['NoRegistrasi']] = true;
							}
						}
						
						// Cek apakah ada halaman selanjutnya
						$has_more = count($rows) > $jumlah_perpage;
						if($has_more){
							array_pop($rows); // Hapus row extra
						}
						
						// Batch query untuk alamat (tbkk)
						$kk_data = [];
						if(!empty($noindex_list)){
							$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
							$q_kk = mysqli_query($koneksi, "SELECT NoIndex, Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
							if($q_kk){
								while($r = mysqli_fetch_assoc($q_kk)){
									$kk_data[$r['NoIndex']] = $r;
								}
							}
						}
						
						// Batch query untuk diagnosa
						$diagnosa_data = [];
						if(!empty($noregistrasi_list)){
							$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
							$q_diag = mysqli_query($koneksi, "SELECT NoRegistrasi, KodeDiagnosa FROM `$tbdiagnosapasien` WHERE NoRegistrasi IN ($noreg_in)");
							if($q_diag){
								while($r = mysqli_fetch_assoc($q_diag)){
									if(!isset($diagnosa_data[$r['NoRegistrasi']])){
										$diagnosa_data[$r['NoRegistrasi']] = [];
									}
									$diagnosa_data[$r['NoRegistrasi']][] = $r['KodeDiagnosa'];
								}
							}
						}
						
						// Tampilkan data
						$no = $mulai;
						foreach($rows as $data){
							$no++;
							$noindex = $data['NoIndex'];
							$noregistrasi = $data['NoRegistrasi'];
							
							// Alamat dari batch
							$alamat_pasien = "-";
							if(isset($kk_data[$noindex]) && $kk_data[$noindex]['Alamat'] != ""){
								$kk = $kk_data[$noindex];
								$alamat_pasien = $kk['Alamat'].", RT.".$kk['RT']." Kel.".$kk['Kelurahan'];
							}
							
							// Diagnosa dari batch
							$diagnosa_str = "";
							if(isset($diagnosa_data[$noregistrasi])){
								$diagnosa_str = implode(", ", $diagnosa_data[$noregistrasi]);
							}
							
							// Status Kunjungan text
							$status_text = ($data['StatusPasien'] == '1') ? 'SAKIT' : 'SEHAT';
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex, -10);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px; font-size:9px;"><?php echo strtoupper($alamat_pasien);?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UmurTahun'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $diagnosa_str;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px; font-size:9px;"><?php echo $data['nokartu'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $status_text;?></td>
							</tr>
						<?php
						}
						
						if(count($rows) == 0){
							echo "<tr><td colspan='11' style='text-align:center; padding:20px;'>Tidak ada data</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Pagination Prev/Next -->
	<ul class="pagination noprint">
		<?php
		if($get_h > 1){
			echo "<li><a href='?page=lap_bpjs_sakitsehat_detail&keydate1=$keydate1&keydate2=$keydate2&sts_bpjs=$sts_bpjs&statuspasien=$statuspasien&h=".($get_h-1)."'>&laquo; Prev</a></li>";
		}
		
		echo "<li class='active'><span>Halaman $get_h</span></li>";
		
		if($has_more){
			echo "<li><a href='?page=lap_bpjs_sakitsehat_detail&keydate1=$keydate1&keydate2=$keydate2&sts_bpjs=$sts_bpjs&statuspasien=$statuspasien&h=".($get_h+1)."'>Next &raquo;</a></li>";
		}
		?>
	</ul>
	<br>
<?php
	}
?>
</div>
