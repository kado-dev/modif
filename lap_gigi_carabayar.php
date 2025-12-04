<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	
	$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : date('m');
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : date('Y');
?>

<style>
.tr, th { text-align:center; }
.printheader {
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printheader h4, .printheader p {
	font-size:18px;
	font-family: "Trebuchet MS";
}
.printbody { margin-left:0px; margin-right:0px; }
.table-responsive {
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel { display:none; margin-top:10px; }
.bawahtabel {
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10 { font-size:10px; font-family: "Tahoma"; }
.font11 { font-size:11px; font-family: "Tahoma"; }
.font14 { font-size:14px; font-family: "Tahoma"; }

@media print {
	body { padding:0px; }
	.noprint { display:none; }
	.printheader { display:block; }
	.printbody { display:block; }
	.atastabel { display:block; }
	.bawahtabel { display:block; }
}
</style>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LAPORAN KESEHATAN GIGI CARA BAYAR</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_gigi_carabayar"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($bulan == '01') echo "SELECTED";?>>Januari</option>
								<option value="02" <?php if($bulan == '02') echo "SELECTED";?>>Februari</option>
								<option value="03" <?php if($bulan == '03') echo "SELECTED";?>>Maret</option>
								<option value="04" <?php if($bulan == '04') echo "SELECTED";?>>April</option>
								<option value="05" <?php if($bulan == '05') echo "SELECTED";?>>Mei</option>
								<option value="06" <?php if($bulan == '06') echo "SELECTED";?>>Juni</option>
								<option value="07" <?php if($bulan == '07') echo "SELECTED";?>>Juli</option>
								<option value="08" <?php if($bulan == '08') echo "SELECTED";?>>Agustus</option>
								<option value="09" <?php if($bulan == '09') echo "SELECTED";?>>September</option>
								<option value="10" <?php if($bulan == '10') echo "SELECTED";?>>Oktober</option>
								<option value="11" <?php if($bulan == '11') echo "SELECTED";?>>November</option>
								<option value="12" <?php if($bulan == '12') echo "SELECTED";?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php for($t = 2016; $t <= date('Y'); $t++): ?>
								<option value="<?php echo $t;?>" <?php if($tahun == $t) echo "SELECTED";?>><?php echo $t;?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gigi_carabayar" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_gigi_carabayar_excel.php?bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php if($bulan != '' && $tahun != ''): ?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN KESEHATAN GIGI BERDASAR CARA BAYAR</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
	</div>

	<?php
	// ============ OPTIMASI: Fetch semua data dalam 1 query ============
	$date_start = "$tahun-$bulan-01";
	$date_end = "$tahun-$bulan-31 23:59:59";
	
	// Query 1: Ambil daftar asuransi
	$asuransi_list = [];
	$q_asuransi = mysqli_query($koneksi, "SELECT Asuransi FROM `tbasuransi` ORDER BY Asuransi ASC");
	if($q_asuransi){
		while($r = mysqli_fetch_assoc($q_asuransi)){
			$asuransi_list[] = $r['Asuransi'];
		}
	}
	
	// Query 2: Ambil SEMUA data sekaligus dengan GROUP BY
	$data_gigi = [];
	$total_per_hari = [];
	
	$str_all = "SELECT Asuransi, DAY(TanggalRegistrasi) as Hari, COUNT(NoRegistrasi) as Jml 
		FROM `$tbpasienrj` 
		WHERE TanggalRegistrasi BETWEEN '$date_start' AND '$date_end'
		AND PoliPertama = 'POLI GIGI'
		GROUP BY Asuransi, DAY(TanggalRegistrasi)";
	
	$q_all = mysqli_query($koneksi, $str_all);
	if($q_all){
		while($r = mysqli_fetch_assoc($q_all)){
			$asuransi = $r['Asuransi'];
			$hari = $r['Hari'];
			$jml = $r['Jml'];
			
			// Simpan per asuransi per hari
			if(!isset($data_gigi[$asuransi])){
				$data_gigi[$asuransi] = [];
			}
			$data_gigi[$asuransi][$hari] = $jml;
			
			// Akumulasi total per hari
			if(!isset($total_per_hari[$hari])){
				$total_per_hari[$hari] = 0;
			}
			$total_per_hari[$hari] += $jml;
		}
	}
	// ============ END OPTIMASI ============
	?>

	<!--tabel view-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">CARA BAYAR</th>
							<?php for($d = 1; $d <= 31; $d++): ?>
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
							<?php endfor; ?>
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$grand_total = 0;
						
						foreach($asuransi_list as $asuransi):
							$no++;
							$jml_row = 0;
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo htmlspecialchars($asuransi);?></td>
							<?php 
							for($d = 1; $d <= 31; $d++):
								// Ambil dari array, bukan query
								$count = isset($data_gigi[$asuransi][$d]) ? $data_gigi[$asuransi][$d] : 0;
								$jml_row += $count;
							?>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count > 0 ? $count : '-';?></td>
							<?php endfor; ?>
							<td style="text-align:right; border:1px solid #000; padding:3px; font-weight:bold;"><?php echo $jml_row;?></td>
						</tr>
						<?php 
							$grand_total += $jml_row;
						endforeach; 
						?>
						<tr style="border:1px solid #000; background:#f0f0f0; font-weight:bold;">
							<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">TOTAL</td>
							<?php 
							$total_check = 0;
							for($d = 1; $d <= 31; $d++):
								// Ambil dari array total
								$count = isset($total_per_hari[$d]) ? $total_per_hari[$d] : 0;
								$total_check += $count;
							?>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count > 0 ? $count : '-';?></td>
							<?php endfor; ?>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo number_format($grand_total);?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php endif; ?>
</div>