<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus_param = $_GET['kasus'];
	$kelurahan_param = $_GET['kelurahan'];
	$opsiform = $_GET['opsiform'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Tracking_Diagnosa (".$bulan.'-'.$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}
.str{
	mso-number-format:\@; 
}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING DIAGNOSA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p>
</div>

<div class="atastabel font14">
	<div style="float:left; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kelurahan_param);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
	<table class="table-judul-laporan" width="100%" border="1">
		<thead>
			<tr style="border:1px solid #000;">
				<th rowspan="2"width="3%">NO.</th>
				<th rowspan="2" width="10%">TGL.</th>
				<th rowspan="2" width="10%">NIK</th>
				<th rowspan="2" width="5%">NO.INDEX</th>
				<th rowspan="2" width="22%">NAMA PASIEN</th>
				<th rowspan="2" width="30%">ALAMAT</th>
				<th rowspan="2" width="5%">TGL.LAHIR</th>
				<th colspan="2" width="5%">UMUR</th>
				<th rowspan="2" width="5%">KUNJ</th>
				<th rowspan="2" width="5%">KASUS</th>
				<th rowspan="2" width="10%">LAYANAN</th>
				<th rowspan="2" width="10%">CARA BAYAR</th>
				<th rowspan="2" width="10%">NOMOR</th>
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
			// Kondisi kasus
			if($kasus_param != 'semua'){
				$kasus_cond = "AND Kasus = '".mysqli_real_escape_string($koneksi, $kasus_param)."'";
				$kasus_cond2 = "AND a.Kasus = '".mysqli_real_escape_string($koneksi, $kasus_param)."'";
			}else{
				$kasus_cond = "";
				$kasus_cond2 = "";
			}
			
			// Escape input
			$kodediagnosa_esc = mysqli_real_escape_string($koneksi, $kodediagnosa);
			$kelurahan_esc = mysqli_real_escape_string($koneksi, $kelurahan_param);
			
			// OPTIMASI: Gunakan date range
			if($opsiform == 'bulan'){
				$date_start = "$tahun-$bulan-01";
				$date_end = date('Y-m-t', strtotime($date_start));
				
				if($kelurahan_param == 'semua'){
					$str2 = "SELECT * FROM `$tbdiagnosapasien` 
					WHERE KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond 
					AND TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
					ORDER BY TanggalDiagnosa";
				}else{
					$str2 = "SELECT a.* FROM `$tbdiagnosapasien` a 
					JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
					WHERE a.KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond2 
					AND a.TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
					AND b.Kelurahan = '$kelurahan_esc'
					ORDER BY a.TanggalDiagnosa";
				}
			}else{	
				$date_start = "$tahun-01-01";
				$date_end = "$tahun-12-31";
				
				if($kelurahan_param == 'semua'){
					$str2 = "SELECT * FROM `$tbdiagnosapasien` 
					WHERE KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond 
					AND TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
					ORDER BY TanggalDiagnosa";
				}else{
					$str2 = "SELECT a.* FROM `$tbdiagnosapasien` a 
					JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
					WHERE a.KodeDiagnosa LIKE '%$kodediagnosa_esc%' $kasus_cond2 
					AND a.TanggalDiagnosa BETWEEN '$date_start' AND '$date_end'
					AND b.Kelurahan = '$kelurahan_esc'
					ORDER BY a.TanggalDiagnosa";
				}
			}
			
			// OPTIMASI: Kumpulkan semua data terlebih dahulu
			$query_diagnosa = mysqli_query($koneksi, $str2);
			$diagnosa_data = [];
			$idpasienrj_list = [];
			$noregistrasi_list = [];
			
			while($row = mysqli_fetch_assoc($query_diagnosa)){
				$diagnosa_data[] = $row;
				$idpasienrj_list[] = "'".$row['IdPasienrj']."'";
				$noregistrasi_list[] = "'".$row['NoRegistrasi']."'";
			}
			
			// Batch query
			$pasienrj_data = [];
			$pasien_data = [];
			$kk_data = [];
			$vitalsign_data = [];
			$therapy_data = [];
			
			if(!empty($idpasienrj_list)){
				$idpasienrj_in = implode(',', array_unique($idpasienrj_list));
				$noregistrasi_in = implode(',', array_unique($noregistrasi_list));
				
				// Batch query pasienrj
				$tb_rj = ($tahunini == $tahun) ? $tbpasienrj : $tbpasienrj_retensi;
				$query_rj_batch = mysqli_query($koneksi, "SELECT * FROM `$tb_rj` WHERE IdPasienrj IN ($idpasienrj_in)");
				while($row = mysqli_fetch_assoc($query_rj_batch)){
					$pasienrj_data[$row['IdPasienrj']] = $row;
				}
				
				// Kumpulkan IdPasien dan NoIndex
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
				
				// Batch query therapy (dengan subquery untuk menghindari duplikat)
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
			
			$no = 0;
			foreach($diagnosa_data as $data_diagnosa){
				$no++;
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

				// vital sign dari batch
				$dtvs = isset($vitalsign_data[$idpasienrj]) ? $vitalsign_data[$idpasienrj] : [];
				$dtsistole = isset($dtvs['Sistole']) ? $dtvs['Sistole'] : '';
				$dtdiastole = isset($dtvs['Diastole']) ? $dtvs['Diastole'] : '';
				$dtsuhutubuh = isset($dtvs['SuhuTubuh']) ? $dtvs['SuhuTubuh'] : '';
				$dttinggiBadan = isset($dtvs['TinggiBadan']) ? $dtvs['TinggiBadan'] : '';
				$dtberatBadan = isset($dtvs['BeratBadan']) ? $dtvs['BeratBadan'] : '';
				$dtheartRate = isset($dtvs['HeartRate']) ? $dtvs['HeartRate'] : '';
				$dtrespRate = isset($dtvs['RespiratoryRate']) ? $dtvs['RespiratoryRate'] : '';

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
					<td align="center" style="vertical-align: middle;"><?php echo $no;?></td>
					<td align="center" style="vertical-align: middle;"><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalDiagnosa']));?></td>
					<td align="center" style="vertical-align: middle;" class="str"><?php echo isset($dt_pasien['Nik']) ? $dt_pasien['Nik'] : '';?></td>
					<td align="center" style="vertical-align: middle;"><?php echo substr($noindex,-10);?></td>
					<td align="left" style="vertical-align: middle;"><?php echo strtoupper(isset($data_rj['NamaPasien']) ? $data_rj['NamaPasien'] : '');?></td>
					<td align="left" style="vertical-align: middle;"><?php echo strtoupper($alamat_row);?></td>
					<td align="center" style="vertical-align: middle;"><?php echo isset($dt_pasien['TanggalLahir']) ? date('d-m-Y', strtotime($dt_pasien['TanggalLahir'])) : '-';?></td>
					<td align="center" style="vertical-align: middle;"><?php echo $kelamin_l;?></td>
					<td align="center" style="vertical-align: middle;"><?php echo $kelamin_p;?></td>
					<td align="center" style="vertical-align: middle;"><?php echo strtoupper(isset($data_rj['StatusKunjungan']) ? $data_rj['StatusKunjungan'] : '');?></td>
					<td align="center" style="vertical-align: middle;"><?php echo strtoupper($row_kasus);?></td>
					<td align="center" style="vertical-align: middle;"><?php echo $poli_pertama;?></td>
					<td align="center" style="vertical-align: middle;"><?php echo isset($data_rj['Asuransi']) ? $data_rj['Asuransi'] : '';?></td>
					<td align="center" style="vertical-align: middle;" class="str"><?php echo strtoupper($nokartu);?></td>
					<td align="left" style="vertical-align: middle;">
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
					<td align="center" style="vertical-align: middle;"><?php echo $row_kodediagnosa;?></td>
					<td align="left" style="vertical-align: middle;">
						<?php 
							// therapy dari batch data
							if(isset($therapy_data[$noregistrasi]) && !empty($therapy_data[$noregistrasi])){
								echo implode(", ", $therapy_data[$noregistrasi]);
							}else{
								echo "Kosong";
							}
						?>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table><br/>
	</div>
</div>
<?php
}
?>
