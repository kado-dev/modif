<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	
	$keydate1 = isset($_GET['keydate1']) ? mysqli_real_escape_string($koneksi, $_GET['keydate1']) : '';
	$keydate2 = isset($_GET['keydate2']) ? mysqli_real_escape_string($koneksi, $_GET['keydate2']) : '';
	$namapegawai = isset($_GET['namapegawai']) ? mysqli_real_escape_string($koneksi, $_GET['namapegawai']) : '';
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Register_Askep_".date('Y-m-d').".xls");
	
	if($keydate1 != '' && $keydate2 != ''){
?>
<html>
<head>
<style>
.str { mso-number-format:\@; }
table { border-collapse: collapse; font-family: Tahoma; font-size: 10px; }
th { background: #5a5a5a; color: #fff; font-size: 9px; }
td, th { border: 1px solid #000; padding: 3px; }
</style>
</head>
<body>

<div style="text-align:center; margin-bottom:10px;">
	<b>DINAS KESEHATAN <?php echo strtoupper($kota);?></b><br>
	<b>PUSKESMAS <?php echo strtoupper($namapuskesmas);?></b><br>
	<?php echo $alamat;?>
	<hr>
	<b>REGISTER ASKEP</b><br>
	<?php if($namapegawai != '') echo "<b>".strtoupper($namapegawai)."</b><br>";?>
	Periode: <?php echo date('d-m-Y', strtotime($keydate1));?> s/d <?php echo date('d-m-Y', strtotime($keydate2));?>
</div>

<table width="100%">
	<thead>
		<tr>
			<th rowspan="2">NO.</th>
			<th rowspan="2">NIK</th>
			<th rowspan="2">NAMA PASIEN</th>
			<th rowspan="2">L/P</th>
			<th colspan="2">UMUR</th>
			<th colspan="5">VITAL SIGN</th>
			<th rowspan="2">ANAMNESA</th>
			<th rowspan="2">DIAGNOSA KEPERAWATAN</th>
			<th rowspan="2">TINDAKAN KEPERAWATAN</th>
			<th rowspan="2">NAMA PETUGAS</th>
		</tr>
		<tr>
			<th>TH</th>
			<th>BL</th>
			<th>TD</th>
			<th>BB</th>
			<th>TB</th>
			<th>SUHU</th>
			<th>HR/RR</th>
		</tr>
	</thead>
	<tbody>
		<?php
		// Filter pegawai
		$pegawai_filter = '';
		if($namapegawai != ''){
			$pegawai_filter = " AND (`NamaPerawat1`='$namapegawai' OR `NamaPerawat2`='$namapegawai')"; 
		}
		
		// Query utama - ambil semua data
		$str_main = "SELECT * FROM `$tbdiagnosaaskep`
		WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2 23:59:59' $pegawai_filter
		GROUP BY NoCM 
		ORDER BY TanggalDiagnosa ASC";
		
		$query_main = mysqli_query($koneksi, $str_main);
		
		// Kumpulkan data untuk batch query
		$rows = [];
		$noregistrasi_list = [];
		$nocm_list = [];
		
		if($query_main){
			while($row = mysqli_fetch_assoc($query_main)){
				$rows[] = $row;
				$noregistrasi_list[$row['NoRegistrasi']] = true;
				$nocm_list[$row['NoCM']] = true;
			}
		}
		
		// Batch queries jika ada data
		$pasienrj_data = [];
		$pasien_data = [];
		$vitalsign_data = [];
		$diagnosa_data = [];
		$idpasienrj_list = [];
		
		if(!empty($rows)){
			$noreg_in = "'".implode("','", array_keys($noregistrasi_list))."'";
			$nocm_in = "'".implode("','", array_keys($nocm_list))."'";
			
			// Batch query tbpasienrj
			$q_rj = mysqli_query($koneksi, "SELECT NoRegistrasi, IdPasienrj, UmurTahun, UmurBulan FROM `$tbpasienrj` WHERE NoRegistrasi IN ($noreg_in)");
			if($q_rj){
				while($r = mysqli_fetch_assoc($q_rj)){
					$pasienrj_data[$r['NoRegistrasi']] = $r;
					$idpasienrj_list[$r['IdPasienrj']] = true;
				}
			}
			
			// Batch query tbpasien untuk NIK
			$q_pasien = mysqli_query($koneksi, "SELECT NoCM, Nik FROM `$tbpasien` WHERE NoCM IN ($nocm_in)");
			if($q_pasien){
				while($r = mysqli_fetch_assoc($q_pasien)){
					$pasien_data[$r['NoCM']] = $r;
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
		
		// Tampilkan data
		$no = 0;
		$hariini = '';
		
		foreach($rows as $data){
			// Separator tanggal
			if($hariini != $data['TanggalDiagnosa']){
				echo "<tr style='background:#f0f0f0; font-weight:bold;'><td colspan='15'>".date('d-m-Y', strtotime($data['TanggalDiagnosa']))."</td></tr>";
				$hariini = $data['TanggalDiagnosa'];
			}
			
			$no++;
			$noregistrasi = $data['NoRegistrasi'];
			$nocm = $data['NoCM'];
			
			// Data dari batch
			$rj = isset($pasienrj_data[$noregistrasi]) ? $pasienrj_data[$noregistrasi] : [];
			$idpasienrj = isset($rj['IdPasienrj']) ? $rj['IdPasienrj'] : '';
			$umur_th = isset($rj['UmurTahun']) ? $rj['UmurTahun'] : '';
			$umur_bl = isset($rj['UmurBulan']) ? $rj['UmurBulan'] : '';
			
			$nik = isset($pasien_data[$nocm]['Nik']) ? $pasien_data[$nocm]['Nik'] : '';
			
			$vs = isset($vitalsign_data[$idpasienrj]) ? $vitalsign_data[$idpasienrj] : [];
			$sistole = isset($vs['Sistole']) ? $vs['Sistole'] : '';
			$diastole = isset($vs['Diastole']) ? $vs['Diastole'] : '';
			$suhu = isset($vs['SuhuTubuh']) ? $vs['SuhuTubuh'] : '';
			$tb = isset($vs['TinggiBadan']) ? $vs['TinggiBadan'] : '';
			$bb = isset($vs['BeratBadan']) ? $vs['BeratBadan'] : '';
			$hr = isset($vs['HeartRate']) ? $vs['HeartRate'] : '';
			$rr = isset($vs['RespiratoryRate']) ? $vs['RespiratoryRate'] : '';
			
			$diagnosa_str = isset($diagnosa_data[$noregistrasi]) ? implode(", ", array_unique($diagnosa_data[$noregistrasi])) : '';
			
			$petugas = $namapegawai != '' ? $namapegawai : trim($data['NamaPerawat1']." / ".$data['NamaPerawat2'], " /");
		?>
			<tr>
				<td align="center"><?php echo $no;?></td>
				<td align="center" class="str"><?php echo $nik;?></td>
				<td><?php echo $data['NamaPasien'];?></td>
				<td align="center"><?php echo $data['JenisKelamin'];?></td>
				<td align="center"><?php echo $umur_th;?></td>
				<td align="center"><?php echo $umur_bl;?></td>
				<td align="center"><?php echo $sistole."/".$diastole;?></td>
				<td align="center"><?php echo $bb;?></td>
				<td align="center"><?php echo $tb;?></td>
				<td align="center"><?php echo $suhu;?></td>
				<td align="center"><?php echo $hr."/".$rr;?></td>
				<td><?php echo strtoupper($data['Anamnesa']);?></td>
				<td><?php echo strtoupper($diagnosa_str);?></td>
				<td><?php echo $data['TindakanKeperawatan'];?></td>
				<td><?php echo $petugas;?></td>
			</tr>
		<?php
		}
		
		if(count($rows) == 0){
			echo "<tr><td colspan='15' align='center'>Tidak ada data</td></tr>";
		}
		?>
	</tbody>
</table>

</body>
</html>
<?php
	}
?>