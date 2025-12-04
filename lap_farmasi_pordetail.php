<?php
	include "config/helper_report.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>INDIKATOR PERESEPAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_pordetail"/>
						<div class="col-xl-2 bulanformcari">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-4">
							<select name="diagnosa" class="form-control">
								<option value="DIARE" <?php if($_GET['diagnosa'] == 'DIARE'){echo "SELECTED";}?>>DIARE (A09)</option>
								<option value="ISPA" <?php if($_GET['diagnosa'] == 'ISPA'){echo "SELECTED";}?>>ISPA (J00)</option>
							</select>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_pordetail" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php		
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$diagnosa = $_GET['diagnosa'];
		if(isset($bulan) and isset($tahun)){
			
			// Set execution time limit to prevent timeout
			set_time_limit(300); // 5 minutes
			
			// Add error handling
			if (!$koneksi) {
				die("Database connection failed: " . mysqli_connect_error());
			}
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="5%" rowspan="2">TANGGAL</th>
							<th width="2%" rowspan="2">NO.</th>
							<th width="5%" rowspan="2">NAMA PASIEN</th>
							<th width="3%" rowspan="2">UMUR (TH)</th>
							<th width="5%" rowspan="2">JUMLAH<br/>ITEM OBAT</th>
							<th width="5%" rowspan="2">ANTRIBIOTIK<br/>(YA/TIDAK)</th>
							<th width="5%" rowspan="2">NAMA OBAT</th>
							<th width="5%" rowspan="2">DOSIS OBAT</th>
							<th width="5%" rowspan="2">LAMA PEMAKAIAN (HARI)</th>
							<th width="5%" rowspan="2">SESUAI PEDOMAN<br/>(YA/TIDAK)</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
					<?php
					// Optimized query with JOIN to reduce N+1 problem
					if($diagnosa == 'DIARE'){
						$str = "SELECT r.*, 
								COUNT(rd.KodeBarang) as item_count,
								GROUP_CONCAT(DISTINCT g.NamaBarang SEPARATOR '<br/>') as nama_obat,
								GROUP_CONCAT(DISTINCT rd.jumlahobat SEPARATOR '<br/>') as dosis_obat
								FROM `$tbresep` r 
								LEFT JOIN `$tbresepdetail` rd ON r.NoResep = rd.NoResep 
								LEFT JOIN `$tbgudangpkmstok` g ON rd.KodeBarang = g.KodeBarang
								WHERE YEAR(r.TanggalResep)='$tahun' 
								AND MONTH(r.TanggalResep)='$bulan' 
								AND SUBSTRING(r.NoResep,1,11)='$kodepuskesmas' 
								AND r.`Diagnosa` LIKE '%A09%'
								GROUP BY r.NoResep
								ORDER BY r.TanggalResep DESC 
								LIMIT 1000";
					}else if($diagnosa == 'ISPA'){
						$str = "SELECT r.*, 
								COUNT(rd.KodeBarang) as item_count,
								GROUP_CONCAT(DISTINCT g.NamaBarang SEPARATOR '<br/>') as nama_obat,
								GROUP_CONCAT(DISTINCT rd.jumlahobat SEPARATOR '<br/>') as dosis_obat
								FROM `$tbresep` r 
								LEFT JOIN `$tbresepdetail` rd ON r.NoResep = rd.NoResep 
								LEFT JOIN `$tbgudangpkmstok` g ON rd.KodeBarang = g.KodeBarang
								WHERE YEAR(r.TanggalResep)='$tahun' 
								AND MONTH(r.TanggalResep)='$bulan' 
								AND SUBSTRING(r.NoResep,1,11)='$kodepuskesmas' 
								AND r.`Diagnosa` LIKE '%J00%'
								GROUP BY r.NoResep
								ORDER BY r.TanggalResep DESC 
								LIMIT 1000";
					}
					
					// echo $str; // Uncomment for debugging
					
					$no = 0;
					$query = mysqli_query($koneksi, $str);
					
					// Check for query errors
					if (!$query) {
						die("Query failed: " . mysqli_error($koneksi));
					}
					
					$total_records = mysqli_num_rows($query);
					
					// If no results, show message
					if ($total_records == 0) {
						echo "<tr><td colspan='10' align='center'>Tidak ada data untuk periode yang dipilih</td></tr>";
					} else {
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
					?>
						<tr>
							<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalResep']));?></td>							
							<td align="center"><?php echo $no;?></td>									
							<td align="left"><?php echo htmlspecialchars($data['NamaPasien']);?></td>									
							<td align="center"><?php echo $data['UmurTahun'];?></td>									
							<td align="center"><?php echo $data['item_count'];?></td>									
							<td align="center">-</td>									
							<td align="left"><?php echo strtoupper($data['nama_obat']);?></td>									
							<td align="center"><?php echo $data['dosis_obat'];?></td>									
							<td align="center">-</td>									
							<td align="center">Ya</td>										
						</tr>
					<?php
						}
					}
					?>
					</tbody>
				</table>
			</div>
			<?php if ($total_records >= 1000): ?>
			<div class="alert alert-warning">
				<strong>Perhatian:</strong> Data dibatasi maksimal 1000 record untuk performa yang lebih baik. 
				Gunakan filter yang lebih spesifik untuk melihat data lengkap.
			</div>
			<?php endif; ?>
		</div>
	</div><hr/>
	<?php
	}
	?>
</div>	