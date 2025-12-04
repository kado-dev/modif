<?php
	include "otoritas.php";
	include "config/helper_report.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">Pelayanan Kefarmasian</h3>
			<div class="formbg">
					<form role="form">
						<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_rawatjalan_pio"/>
						<div class="col-xl-2">
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_rawatjalan_pio_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	if(isset($bulan) and isset($tahun)){
	?>
	<div class="table-responsive" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN PELAYANAN KEFARMASIAN</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
			<br/>
		</div>

		<div class="atastabel">
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
		
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="17%">TANGGAL</th>
					<th colspan="3" width="35%">JUMLAH LEMBAR RESEP</th>
					<th rowspan="2" width="15%">KONSELING</th>
					<th rowspan="2" width="15%">INFORMASI OBAT</th>
					<th rowspan="2" width="15%">JML ITEM OBAT</th>
				</tr>
				<tr>
					<th>RAWAT JALAN</th>
					<th>RAWAT INAP</th>
					<th>JUMLAH</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// OPTIMASI: Gunakan date range untuk index
				$bulan_esc = mysqli_real_escape_string($koneksi, $bulan);
				$tahun_esc = mysqli_real_escape_string($koneksi, $tahun);
				$date_start = "$tahun_esc-$bulan_esc-01";
				$date_end = date('Y-m-t', strtotime($date_start));
				
				// Query 1: Rawat Jalan per tanggal (batch)
				$str_rj = "SELECT DATE(TanggalResep) as TglResep, COUNT(IdPasienrj) As Jml 
				FROM `$tbresep`
				WHERE TanggalResep BETWEEN '$date_start' AND '$date_end'
				GROUP BY DATE(TanggalResep)
				ORDER BY DATE(TanggalResep)";
				
				$rj_data = [];
				$query_rj = mysqli_query($koneksi, $str_rj);
				while($row = mysqli_fetch_assoc($query_rj)){
					$rj_data[$row['TglResep']] = $row['Jml'];
				}
				
				// Query 2: PIO per tanggal (batch)
				$str_pio_batch = "SELECT DATE(TanggalResep) as TglResep, COUNT(IdPasienrj) As Jml 
				FROM `$tbresep` 
				WHERE TanggalResep BETWEEN '$date_start' AND '$date_end'
				AND Pio <> ''
				GROUP BY DATE(TanggalResep)";
				
				$pio_data = [];
				$query_pio = mysqli_query($koneksi, $str_pio_batch);
				while($row = mysqli_fetch_assoc($query_pio)){
					$pio_data[$row['TglResep']] = $row['Jml'];
				}
				
				// Query 3: Item Obat per tanggal (batch)
				$str_itemobat_batch = "SELECT DATE(b.TanggalResep) as TglResep, COUNT(b.KodeBarang) As Jml 
				FROM `$tbresep` a
				JOIN `$tbresepdetail` b ON a.NoResep = b.NoResep
				WHERE b.TanggalResep BETWEEN '$date_start' AND '$date_end'
				AND SUBSTRING(a.NoResep,1,11)='$kodepuskesmas'
				GROUP BY DATE(b.TanggalResep)";
				
				$itemobat_data = [];
				$query_itemobat = mysqli_query($koneksi, $str_itemobat_batch);
				while($row = mysqli_fetch_assoc($query_itemobat)){
					$itemobat_data[$row['TglResep']] = $row['Jml'];
				}
				
				// Loop hanya untuk display, tanpa query tambahan
				$no = 0;
				foreach($rj_data as $tglresep => $rawatjalan){
					$no++;
					$rawatinap = 0;
					$jumlah = $rawatjalan + $rawatinap;
					$jml_pio = isset($pio_data[$tglresep]) ? $pio_data[$tglresep] : 0;
					$jml_itemobat = isset($itemobat_data[$tglresep]) ? $itemobat_data[$tglresep] : 0;
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tglresep;?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $rawatjalan;?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;">0</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jumlah;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">0</td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_pio;?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_itemobat;?></td>	
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>

		<div class="bawahtabel">
			<table width="100%">
				<tr>
					<td width="10%"></td>
					<td style="text-align:center;">
					Mengetahui :<br>
					KEPALA PUSKESMAS <?php echo $namapuskesmas;?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
					
					
					<td width="10%"></td>
					<td style="text-align:center;">
					Yang Melaporkan :<br>
					APOTEKER PUSKESMAS <?php echo strtoupper($kecamatan);?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	}
	?>
</div>	