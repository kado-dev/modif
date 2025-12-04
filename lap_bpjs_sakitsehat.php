<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	$tanggal = date('Y-m-d');
	
	// Safe GET parameters
	$get_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
	$get_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PESERTA BPJS (SAKIT/SEHAT)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_bpjs_sakitsehat"/>
						<div class="col-xl-2" style="width:150px">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($get_bulan == '01'){echo "selected";}?>>Januari</option>
								<option value="02" <?php if($get_bulan == '02'){echo "selected";}?>>Februari</option>
								<option value="03" <?php if($get_bulan == '03'){echo "selected";}?>>Maret</option>
								<option value="04" <?php if($get_bulan == '04'){echo "selected";}?>>April</option>
								<option value="05" <?php if($get_bulan == '05'){echo "selected";}?>>Mei</option>
								<option value="06" <?php if($get_bulan == '06'){echo "selected";}?>>Juni</option>
								<option value="07" <?php if($get_bulan == '07'){echo "selected";}?>>Juli</option>
								<option value="08" <?php if($get_bulan == '08'){echo "selected";}?>>Agustus</option>
								<option value="09" <?php if($get_bulan == '09'){echo "selected";}?>>September</option>
								<option value="10" <?php if($get_bulan == '10'){echo "selected";}?>>Oktober</option>
								<option value="11" <?php if($get_bulan == '11'){echo "selected";}?>>November</option>
								<option value="12" <?php if($get_bulan == '12'){echo "selected";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2" style="width:125px">
							<select name="tahun" class="form-control">
								<?php
								for($tahun = 2016; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($get_tahun == $tahun){echo "selected";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_bpjs_sakitsehat" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	
	<?php
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : '';
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : '';
	$kodeppk = isset($_SESSION['kodeppk']) ? $_SESSION['kodeppk'] : '';
	
	if($bulan != '' && $tahun != ''){
		// Hitung tanggal awal dan akhir bulan untuk query yang lebih efisien
		$date_start = "$tahun-$bulan-01";
		$date_end = date('Y-m-t', strtotime($date_start)); // Hari terakhir bulan
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".strtoupper($kota);?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".strtoupper($namapuskesmas);?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PESERTA BPJS (SAKIT/SEHAT)</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo nama_bulan($bulan);?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; width:8%; vertical-align:middle; border:1px solid #000; padding:5px;">NO.</th>
							<th style="text-align:center; width:72%; vertical-align:middle; border:1px solid #000; padding:5px;">STATUS KUNJUNGAN</th>
							<th style="text-align:center; width:20%; vertical-align:middle; border:1px solid #000; padding:5px;">JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Query Kunjungan Sakit: harus StatusPelayanan = 'Sudah'
						$str_sakit = "SELECT COUNT(NoRegistrasi) as jumlah 
						FROM `$tbpasienrj` 
						WHERE TanggalRegistrasi BETWEEN '$date_start' AND '$date_end 23:59:59'
						AND Asuransi LIKE '%BPJS%' 
						AND StatusPelayanan = 'Sudah' 
						AND NoUrutBpjs != '' 
						AND NoUrutBpjs IS NOT NULL
						AND StatusPasien = '1'";
						
						$query_sakit = mysqli_query($koneksi, $str_sakit);
						$dt_sakit = 0;
						if($query_sakit){
							$row_sakit = mysqli_fetch_assoc($query_sakit);
							$dt_sakit = intval($row_sakit['jumlah']);
						}
						
						// Query Kunjungan Sehat: tidak perlu StatusPelayanan = 'Sudah'
						// karena Kunjungan Sehat tidak melalui proses pemeriksaan poli
						$str_sehat = "SELECT COUNT(NoRegistrasi) as jumlah 
						FROM `$tbpasienrj` 
						WHERE TanggalRegistrasi BETWEEN '$date_start' AND '$date_end 23:59:59'
						AND Asuransi LIKE '%BPJS%' 
						AND NoUrutBpjs != '' 
						AND NoUrutBpjs IS NOT NULL
						AND StatusPasien = '2'";
						
						$query_sehat = mysqli_query($koneksi, $str_sehat);
						$dt_sehat = 0;
						if($query_sehat){
							$row_sehat = mysqli_fetch_assoc($query_sehat);
							$dt_sehat = intval($row_sehat['jumlah']);
						}
						
						$total = $dt_sakit + $dt_sehat;
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:8px;">1</td>
							<td style="text-align:left; border:1px solid #000; padding:8px; padding-left:15px;">KUNJUNGAN SAKIT</td>
							<td style="text-align:right; border:1px solid #000; padding:8px; padding-right:15px;"><?php echo number_format($dt_sakit, 0, ',', '.');?></td>
						</tr>
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:8px;">2</td>
							<td style="text-align:left; border:1px solid #000; padding:8px; padding-left:15px;">KUNJUNGAN SEHAT</td>
							<td style="text-align:right; border:1px solid #000; padding:8px; padding-right:15px;"><?php echo number_format($dt_sehat, 0, ',', '.');?></td>
						</tr>
						<tr style="border:1px solid #000; background-color:#f5f5f5; font-weight:bold;">
							<td colspan="2" style="text-align:center; border:1px solid #000; padding:8px;">TOTAL</td>
							<td style="text-align:right; border:1px solid #000; padding:8px; padding-right:15px;"><?php echo number_format($total, 0, ',', '.');?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<?php
	}
	?>
</div>
