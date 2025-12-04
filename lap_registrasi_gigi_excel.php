<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	
	$hariini = date('d-m-Y');
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : '';
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : '';
	
	if($keydate1 == '' || $keydate2 == ''){
		die("Parameter tanggal tidak valid");
	}
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Gigi_".date('d-m-Y', strtotime($keydate1))."_sd_".date('d-m-Y', strtotime($keydate2)).".xls");
	
	// ============ OPTIMIZED BATCH QUERIES ============
	
	// 1. Query utama dari tbpoligigi
	$str_main = "SELECT TanggalPeriksa, NoPemeriksaan, NoIndex, Anamnesa, Bengkak, SuhuKulit, 
		WarnaGusi, Goyang, KariesGigi, TindakLanjut1, TindakLanjut2, Tindakan, KunjunganUlang
	FROM `$tbpoligigi`
	WHERE TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2 23:59:59'
	ORDER BY TanggalPeriksa ASC";
	
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
	
	// Batch query data pendukung
	$kk_data = [];
	$subdistrict_cache = [];
	$district_cache = [];
	$diagnosa_data = [];
	$therapy_data = [];
	$pasienrj_data = [];
	$pegawai_data = [];
	
	if(!empty($rows)){
		$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
		
		// 2. Batch query tbpasienrj
		$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPasien, UmurTahun, JenisKelamin, StatusPulang, Asuransi, StatusKunjungan 
			FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
		if($q_rj){
			while($r = mysqli_fetch_assoc($q_rj)){
				$pasienrj_data[$r['NoRegistrasi']] = $r;
			}
		}
		
		// 3. Batch query tbpasienperpegawai
		$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
		$q_pgw = mysqli_query($koneksi, "SELECT NoRegistrasi, NamaPegawai1, NamaPegawai2 
			FROM `$tbpasienperpegawai` WHERE NoRegistrasi IN ($noreg_in)");
		if($q_pgw){
			while($r = mysqli_fetch_assoc($q_pgw)){
				$pegawai_data[$r['NoRegistrasi']] = $r;
			}
		}
		
		// 4. Batch query tbkk
		if(!empty($noindex_list)){
			$noindex_in = "'".implode("','", array_keys($noindex_list))."'";
			$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Kelurahan, Kecamatan FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
			if($q_kk){
				while($r = mysqli_fetch_assoc($q_kk)){
					$kk_data[$r['NoIndex']] = $r;
				}
			}
		}
		
		// 5. Cache ec_subdistricts & ec_districts
		$kel_ids = [];
		$kec_ids = [];
		foreach($kk_data as $kk){
			if(isset($kk['Kelurahan']) && $kk['Kelurahan']) $kel_ids[$kk['Kelurahan']] = true;
			if(isset($kk['Kecamatan']) && $kk['Kecamatan']) $kec_ids[$kk['Kecamatan']] = true;
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
		
		// 6. Batch query diagnosa dengan JOIN
		$q_diag = mysqli_query($koneksi, "SELECT dp.NoRegistrasi, dp.KodeDiagnosa, db.Diagnosa 
			FROM `$tbdiagnosapasien` dp
			LEFT JOIN `tbdiagnosabpjs` db ON dp.KodeDiagnosa = db.KodeDiagnosa
			WHERE dp.NoRegistrasi IN ($noreg_in)
			GROUP BY dp.NoRegistrasi, dp.KodeDiagnosa");
		if($q_diag){
			while($r = mysqli_fetch_assoc($q_diag)){
				if(!isset($diagnosa_data[$r['NoRegistrasi']])) $diagnosa_data[$r['NoRegistrasi']] = [];
				$diagnosa_data[$r['NoRegistrasi']][] = $r['KodeDiagnosa']." ".$r['Diagnosa'];
			}
		}
		
		// 7. Batch query therapy
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
?>
<html>
<head>
<style>
	body { font-family: Arial, sans-serif; font-size: 9px; }
	.header { text-align: center; margin-bottom: 10px; }
	.header h3 { margin: 2px; font-size: 12px; }
	.header p { margin: 2px; font-size: 10px; }
	table { border-collapse: collapse; width: 100%; }
	th, td { border: 1px solid #000; padding: 2px; }
	th { background-color: #4472C4; color: white; font-weight: bold; text-align: center; font-size: 8px; }
	td { font-size: 8px; }
	.center { text-align: center; }
	.left { text-align: left; }
</style>
</head>
<body>

<div class="header">
	<h3>PEMERINTAH <?php echo strtoupper($kota);?></h3>
	<h3>DINAS KESEHATAN</h3>
	<h3>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></h3>
	<p><?php echo $alamat;?></p>
	<hr>
	<h3>LAPORAN REGISTER PELAYANAN GIGI</h3>
	<p>Periode: <?php echo date('d-m-Y', strtotime($keydate1));?> s/d <?php echo date('d-m-Y', strtotime($keydate2));?></p>
	<p>Total Data: <?php echo count($rows);?> pasien</p>
</div>

<table>
			<thead>
				<tr>
			<th rowspan="2" width="2%">NO</th>
			<th rowspan="2" width="5%">TANGGAL</th>
			<th rowspan="2" width="12%">NAMA PASIEN</th>
			<th colspan="2" width="4%">UMUR</th>
			<th rowspan="2" width="4%">KUNJ</th>
			<th rowspan="2" width="12%">ALAMAT</th>
			<th rowspan="2" width="4%">BENGKAK</th>
			<th rowspan="2" width="4%">SUHU</th>
			<th rowspan="2" width="4%">GUSI</th>
			<th rowspan="2" width="4%">GOYANG</th>
			<th rowspan="2" width="4%">KARIES</th>
			<th colspan="2" width="8%">TINDAK LANJUT</th>
			<th rowspan="2" width="4%">ULANG</th>
			<th rowspan="2" width="8%">ANAMNESA</th>
			<th rowspan="2" width="10%">DIAGNOSA</th>
			<th rowspan="2" width="10%">THERAPY</th>
			<th rowspan="2" width="6%">TINDAKAN</th>
			<th colspan="2" width="4%">RUJUK</th>
			<th rowspan="2" width="8%">PETUGAS</th>
				</tr>
				<tr>
			<th>L</th>
			<th>P</th>
			<th>1</th>
			<th>2</th>
					<th>YA</th>
					<th>TDK</th>
				</tr>
			</thead>
			<tbody>
				<?php
		$no = 0;
		foreach($rows as $data){
			$no++;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
			
			// Data dari batch pasienrj
			$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
			$kelamin = isset($rj['JenisKelamin']) ? $rj['JenisKelamin'] : '';
			$nama_pasien = isset($rj['NamaPasien']) ? strtoupper($rj['NamaPasien']) : '';
			$umur_tahun = isset($rj['UmurTahun']) ? $rj['UmurTahun'] : '';
			$asuransi = isset($rj['Asuransi']) ? $rj['Asuransi'] : '';
			$status_kunjungan = isset($rj['StatusKunjungan']) ? strtoupper($rj['StatusKunjungan']) : '';
			$status_pulang = isset($rj['StatusPulang']) ? $rj['StatusPulang'] : '';
			
			// Pemeriksa dari batch
			$pgw = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
			$pemeriksa = '';
			if(isset($pgw['NamaPegawai1']) && $pgw['NamaPegawai1'] != '' && $pgw['NamaPegawai1'] != '-'){
				$pemeriksa = $pgw['NamaPegawai1'];
			} elseif(isset($pgw['NamaPegawai2']) && $pgw['NamaPegawai2'] != ''){
				$pemeriksa = $pgw['NamaPegawai2'];
			}
			
			// Alamat dari batch
			$kk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
			$nama_kk = isset($kk['NamaKK']) ? strtoupper($kk['NamaKK']) : '';
			$kelurahan = '';
			$kecamatan = '';
			if(isset($kk['Kelurahan'])){
				$kelurahan = isset($subdistrict_cache[$kk['Kelurahan']]) ? $subdistrict_cache[$kk['Kelurahan']] : $kk['Kelurahan'];
			}
			if(isset($kk['Kecamatan'])){
				$kecamatan = isset($district_cache[$kk['Kecamatan']]) ? $district_cache[$kk['Kecamatan']] : $kk['Kecamatan'];
			}
			
			$alamat_pasien = '';
			if(isset($kk['Alamat']) && $kk['Alamat'] != ''){
				$alamat_pasien = $kk['Alamat'].", RT.".(isset($kk['RT']) ? $kk['RT'] : '').", RW.".(isset($kk['RW']) ? $kk['RW'] : '').", ".strtoupper($kelurahan);
			} else {
				$alamat_pasien = 'Belum Terdaftar';
			}
			
			// Diagnosa dari batch
			$data_dgs = isset($diagnosa_data[$noregistrasi]) ? implode("; ", $diagnosa_data[$noregistrasi]) : '';
			
			// Therapy dari batch
			$data_trp = isset($therapy_data[$noregistrasi]) ? implode("; ", $therapy_data[$noregistrasi]) : '';
			
			// Umur per kelamin
			$umur_l = $kelamin == 'L' ? $umur_tahun." TH" : "-";
			$umur_p = $kelamin == 'P' ? $umur_tahun." TH" : "-";
			
			// Rujukan
			$rujuklanjut = ($status_pulang == 4) ? 'V' : '-';
			$berobatjalan = ($status_pulang == 3) ? 'V' : '-';
				?>
					<tr>
			<td class="center"><?php echo $no;?></td>
			<td class="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
			<td class="left"><?php echo $nama_pasien;?><br/><?php echo $nama_kk;?><br/><?php echo substr($noindex,-10)." - ".$asuransi;?></td>
			<td class="center"><?php echo $umur_l;?></td>
			<td class="center"><?php echo $umur_p;?></td>
			<td class="center"><?php echo $status_kunjungan;?></td>
			<td class="left"><?php echo $alamat_pasien;?></td>
			<td class="center"><?php echo strtoupper($data['Bengkak']);?></td>
			<td class="center"><?php echo strtoupper($data['SuhuKulit']);?></td>
			<td class="center"><?php echo strtoupper($data['WarnaGusi']);?></td>
			<td class="center"><?php echo strtoupper($data['Goyang']);?></td>
			<td class="center"><?php echo strtoupper($data['KariesGigi']);?></td>
			<td class="left"><?php echo $data['TindakLanjut1'];?></td>
			<td class="left"><?php echo $data['TindakLanjut2'];?></td>
			<td class="center"><?php echo $data['KunjunganUlang'];?></td>
			<td class="left"><?php echo strtoupper($data['Anamnesa']);?></td>
			<td class="left"><?php echo $data_dgs;?></td>
			<td class="left"><?php echo $data_trp;?></td>
			<td class="left"><?php echo strtoupper($data['Tindakan']);?></td>
			<td class="center"><?php echo $rujuklanjut;?></td>
			<td class="center"><?php echo $berobatjalan;?></td>
			<td class="left"><?php echo $pemeriksa;?></td>
					</tr>
				<?php
				}
		
		if(count($rows) == 0){
			echo "<tr><td colspan='22' class='center'>Tidak ada data</td></tr>";
		}
				?>
			</tbody>
		</table>

<br>
<table>
	<tr>
		<td>Diekspor pada: <?php echo date('d-m-Y H:i:s');?></td>
	</tr>
</table>

</body>
</html>
