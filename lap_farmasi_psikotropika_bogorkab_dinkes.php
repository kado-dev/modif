<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">NAPZA</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_psikotropika_bogorkab_dinkes"/>
						<div class="col-sm-2">
							<select name="bulanawal" class="form-control">
								<option value="01" <?php if($_GET['bulanawal'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanawal'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanawal'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanawal'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanawal'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanawal'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanawal'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanawal'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanawal'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanawal'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanawal'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanawal'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="bulanakhir" class="form-control">
								<option value="01" <?php if($_GET['bulanakhir'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanakhir'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanakhir'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanakhir'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanakhir'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanakhir'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanakhir'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanakhir'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanakhir'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanakhir'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanakhir'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanakhir'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_psikotropika_bogorkab_dinkes" class="btn btn-primary btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_psikotropika_bogorkab_dinkes_excel.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-success btn-white"><span class="fa fa-print"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahun = $_GET['tahun'];
	if($bulanawal != null AND $bulanakhir != null){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN NAPZA</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulanawal'])." s/d ".nama_bulan($_GET['bulanakhir'])." ".$_GET['tahun'];?></span>
			<br/><br/>
		</div>
		<div class="table-responsive text-nowrap">
			<table class="table-judul-laporan" width="100%">
				<thead>
					<tr style="border:1px solid #000;">
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Obat</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Saldo Awal</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penerimaan</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Persediaan</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pengeluaran</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sisa Stok</th>
					</tr>
				</thead>
				<tbody>
				<?php
					// gudang besar
					$strnarkotika = "SELECT * FROM `tbgfkstok` WHERE `GolonganFungsi` = 'NARKOTIKA' GROUP BY KodeBarang ORDER BY NamaBarang";
					// echo $strnarkotika;
					
					$query_psk = mysqli_query($koneksi, $strnarkotika);
					while($dt_psk = mysqli_fetch_assoc($query_psk)){
						$no = $no + 1;
						$kodebarang = $dt_psk['KodeBarang'];
						$namabarang = $dt_psk['NamaBarang'];
						$satuan = $dt_psk['Satuan'];
						$harga = $dt_psk['HargaBeli'];
						
						// tbstokbulanandinas
						$stokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokAwalSistem) AS Jumlah FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang'
						AND `Tahun`='$tahun' AND Bulan BETWEEN '$bulanawal' AND '$bulanakhir'"));
						if($stokawal['Jumlah'] != 0){
							$stokawals = $stokawal['Jumlah'];
						}else{
							$stokawals = 0;
						}	
							
						// penerimaan
						$str_trm = "SELECT SUM(b.Jumlah) AS Jumlah FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE YEAR(a.TanggalPenerimaan)='$tahun' AND MONTH(a.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir' AND b.KodeBarang = '$kodebarang'";	
						$query_trm = mysqli_query($koneksi, $str_trm);
						$dt_trm = mysqli_fetch_assoc($query_trm);
						
						if($dt_trm != null){
							$jml_terima = $dt_trm['Jumlah'];
						}else{
							$jml_terima = '0';
						}
						
						// pengeluaran
						$str_prn = "SELECT SUM(b.Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
						WHERE YEAR(a.TanggalPengeluaran)='$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulanawal' AND '$bulanakhir' AND b.KodeBarang = '$kodebarang'";	
						$query_prn = mysqli_query($koneksi, $str_prn);
						$dt_prn= mysqli_fetch_assoc($query_prn);
						
						if($dt_prn != null){
							$jml_pengeluaran = $dt_prn['Jumlah'];
						}else{
							$jml_pengeluaran = '0';
						}
						
						$jml_persediaan = $stokawal['Jumlah'] + $jml_terima;
						$stok_akhir = $stokawal['Jumlah'] + $jml_terima - $jml_pengeluaran;
					?>
					<tr>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kodebarang;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namabarang;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $satuan;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stokawals);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml_terima);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml_persediaan);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml_pengeluaran);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_akhir);?></td>	
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>

		<div class="row bawahtabel font10">
			<table class="table table-condensed">
				<tr>
					<td style="text-align:center;" width="50%">
					Mengetahui :<br>
					KEPALA PUSKESMAS <?php echo $namapuskesmas;?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
					
					
					<td style="text-align:center;" width="50%">
					Yang Melaporkan :<br>
					APOTEKER UPT YANKES <?php echo strtoupper($kecamatan);?>
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
