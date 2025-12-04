<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : '';
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : '';
	$kunjungan_param = isset($_GET['kunjungan']) ? $_GET['kunjungan'] : 'Semua';
	$kelompokumur = isset($_GET['kelompokumur']) ? $_GET['kelompokumur'] : 'Semua';
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Lansia (".$namapuskesmas." ".$keydate1." ".$keydate2.").xls");
	if($keydate1 != '' && $keydate2 != ''){
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
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI LANSIA</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $keydate1."/".$keydate2;?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="4%" rowspan="2">NO.</th>
					<th width="8%" rowspan="2">TANGGAL</th>
					<th width="5%" rowspan="2">NO.REG</th>
					<th width="8%" rowspan="2">NO.INDEX</th>
					<th width="10%" rowspan="2">NIK</th>
					<th width="12%" rowspan="2">NAMA PASIEN</th>
					<th width="10%" colspan="2">UMUM</th>
					<th width="12%" rowspan="2">ALAMAT</th>
					<th width="5%" rowspan="2">KUNJ.</th>
					<th width="8%" colspan="5">VITAL SIGN</th>
					<th width="10%" rowspan="2">ANAMNESA</th>
					<th width="10%" rowspan="2">DIAGNOSA</th>
					<th width="10%" rowspan="2">THERAPY</th>
					<th width="5%" colspan="2">RUJUK</th>
					<th width="10%" rowspan="2">KET.</th>
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
					<th>TIDAK</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// OPTIMASI: Query HANYA dari tbpolilansia dulu (tanpa JOIN yang lambat)
				$str2 = "SELECT * FROM `$tbpolilansia` 
				WHERE TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'
				ORDER BY TanggalPeriksa DESC";
				
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
				
				// Filter berdasarkan kunjungan dan umur
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
				$lansia_data = $filtered_data;
				
				// Batch query untuk data lainnya
				$pasien_data = [];
				$kk_data = [];
				$pegawai_data = [];
				$diagnosa_data = [];
				$therapy_data = [];
				$subdis_cache = [];
				$dis_cache = [];
				
				// Rebuild noregistrasi_list dari filtered data
				$noregistrasi_list = [];
				foreach($lansia_data as $data){
					$noregistrasi_list[] = "'".mysqli_real_escape_string($koneksi, $data['NoPemeriksaan'])."'";
				}
				
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
					
					// Batch: therapy dengan nama obat
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
					$q_pasien = mysqli_query($koneksi, "SELECT IdPasien, NoIndex, Nik, NoAsuransi FROM `$tbpasien` WHERE IdPasien IN ($idpasien_in)");
					if($q_pasien){
						while($row = mysqli_fetch_assoc($q_pasien)){
							$pasien_data[$row['IdPasien']] = $row;
						}
					}
				}
				
				if(!empty($noindex_list)){
					$noindex_in = implode(',', array_unique($noindex_list));
					$q_kk = mysqli_query($koneksi, "SELECT NoIndex, NamaKK, Alamat, RT, RW, Kelurahan, Kecamatan FROM `$tbkk` WHERE NoIndex IN ($noindex_in)");
					if($q_kk){
						while($row = mysqli_fetch_assoc($q_kk)){
							$kk_data[$row['NoIndex']] = $row;
						}
					}
					
					// Batch kelurahan & kecamatan
					$kelurahan_ids = [];
					$kecamatan_ids = [];
					foreach($kk_data as $kk){
						if(!empty($kk['Kelurahan'])) $kelurahan_ids[$kk['Kelurahan']] = true;
						if(!empty($kk['Kecamatan'])) $kecamatan_ids[$kk['Kecamatan']] = true;
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
				}
				
				// Loop untuk display (tanpa query tambahan)
				$no = 0;
				foreach($lansia_data as $data){
					$no++;
					$noregistrasi = $data['NoPemeriksaan'];
					$idpasien = isset($data['IdPasien']) ? $data['IdPasien'] : '';
					$noindex = isset($data['NoIndex']) ? $data['NoIndex'] : '';
					$anamnesa = $data['Anamnesa'];
					$kunjungan = isset($data['StatusKunjungan']) ? $data['StatusKunjungan'] : '';
					$tensi = $data['Sistole']."/".$data['Diastole'];
					$bb = $data['BeratBadan'];
					$tb = $data['TinggiBadan'];
					$suhu = $data['SuhuTubuh'];
					$hrrr = $data['DetakNadi']."/".$data['RR'];
					$kelamin = isset($data['JenisKelamin']) ? $data['JenisKelamin'] : '';
					
					// Data dari batch
					$dt_pegawai = isset($pegawai_data[$noregistrasi]) ? $pegawai_data[$noregistrasi] : [];
					$pemeriksa = !empty($dt_pegawai['NamaPegawai1']) ? $dt_pegawai['NamaPegawai1'] : (isset($dt_pegawai['NamaPegawai2']) ? $dt_pegawai['NamaPegawai2'] : '');
					
					$dt_pasien = isset($pasien_data[$idpasien]) ? $pasien_data[$idpasien] : [];
					$nik = isset($dt_pasien['Nik']) ? $dt_pasien['Nik'] : '';
					
					$datakk = isset($kk_data[$noindex]) ? $kk_data[$noindex] : [];
					
					// Kelurahan & kecamatan dari cache
					$kelurahan_val = isset($datakk['Kelurahan']) ? $datakk['Kelurahan'] : '';
					if(!empty($datakk['Kelurahan']) && isset($subdis_cache[$datakk['Kelurahan']])){
						$kelurahan_val = $subdis_cache[$datakk['Kelurahan']];
					}
					
					$kecamatan_val = isset($datakk['Kecamatan']) ? $datakk['Kecamatan'] : '';
					if(!empty($datakk['Kecamatan']) && isset($dis_cache[$datakk['Kecamatan']])){
						$kecamatan_val = $dis_cache[$datakk['Kecamatan']];
					}
					
					$alamat_row = (isset($datakk['Alamat']) ? $datakk['Alamat'] : '').", RT.".(isset($datakk['RT']) ? $datakk['RT'] : '').", RW.".(isset($datakk['RW']) ? $datakk['RW'] : '').", ".strtoupper($kelurahan_val).", ".strtoupper($kecamatan_val);
					
					// Umur kelamin
					$umur_tahun = isset($data['UmurTahun']) ? $data['UmurTahun'] : '';
					if ($kelamin == 'L'){
						$umur_l = $umur_tahun." th";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $umur_tahun." th";
					}
					
					// Rujukan
					$rujukan = isset($data['StatusPulang']) ? $data['StatusPulang'] : '';
					if ($rujukan == 3){
						$berobatjalan = 'V';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = 'V';
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
						<td align="center"><?php echo substr($noregistrasi,19);?></td>
						<td align="center"><?php echo substr($noindex,14);?></td>
						<td align="left" class="str"><?php echo $nik;?></td>
						<td align="left"><?php echo $data['NamaPasien'];?></td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="left"><?php echo strtoupper($alamat_row);?></td>
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
	</div>
</div>
<?php
}
?>
