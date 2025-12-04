<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">NARKOTIKA/PSIKOTROPIKA</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_psikotropika"/>
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
										for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
										?>
										<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
									<?php }?>
								</select>
							</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_psikotropika" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	if($bulan != null AND $tahun != null){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENGGUNAAN NARKOTIKA / PSIKOTROPIKA</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
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
			<div style="float:right; width:35%; margin-bottom:10px;">	
				<table>
					<tr>
						<td style="padding:2px 4px;">Kelurahan/Desa</td>
						<td style="padding:2px 4px;">:</td>
						<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
					</tr>
					<tr>
						<td style="padding:2px 4px;">Kecamatan</td>
						<td style="padding:2px 4px;">:</td>
						<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
					</tr>
				</table>
			</div>	
		</div>

		<div class="row font10">
			<div class="col-sm-12">
				<table class="table-judul-laporan">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th rowspan="2" style="text-align:center;width:0.2%;vertical-align:middle; border:1px solid #000; padding:3px;">No</th>
							<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="2" style="text-align:center;width:3.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Obat</th>
							<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
							<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Stok Awal</th>
							<th colspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Penerimaan</th>
							<th colspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Pengeluaran</th>
							<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Stok Akhir</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px solid #000; padding:3px;">Dari</th>
							<th style="text-align:center;width:0.4%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px solid #000; padding:3px;">Untuk</th>
							<th style="text-align:center;width:0.4%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
					<?php
						// gudang besar
						$str_psk = "SELECT * FROM `tbgudangpkmstok` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
						WHERE b.GolonganFungsi like '%PSIKOTROPIKA%' AND `KodePuskesmas`='$kodepuskesmas' order by NamaBarang";
						// echo $str_psk;
						$query_psk = mysqli_query($koneksi, $str_psk);
						while($dt_psk = mysqli_fetch_assoc($query_psk)){
							$no = $no + 1;
							$kodebarang = $dt_psk['KodeBarang'];
							$namabarang = $dt_psk['NamaBarang'];
							$satuan = $dt_psk['Satuan'];
							$stok_awal = $dt_psk['Stok'];
							
							// penerimaan
							$str_trm = "SELECT * FROM `tbgudangpkmpenerimaan` a JOIN `tbgudangpkmpenerimaandetail` b ON a.NoFaktur = b.NoFaktur
							WHERE MONTH(a.TanggalPenerimaan) = '$bulan' AND YEAR(a.TanggalPenerimaan) = '$tahun' AND
							b.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang = '$kodebarang'";	
							$query_trm = mysqli_query($koneksi, $str_trm);
							$dt_trm = mysqli_fetch_assoc($query_trm);
							
							if($dt_trm != null){
								$terima_dari = $dt_trm['TerimaDari'];
								$jml_trm = $dt_trm['Jumlah'];
							}else{
								$terima_dari = '-';
								$jml_trm = '0';
							}
							
							// pengeluaran
							$str_prn = "SELECT * FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
							WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND
							SUBSTRING(b.NoFaktur,1,11) = '$kodepuskesmas' AND b.KodeBarang = '$kodebarang'";	
							// echo $str_prn;
							$query_prn = mysqli_query($koneksi, $str_prn);
							$dt_prn= mysqli_fetch_assoc($query_prn);
							
							if($dt_prn != null){
								$tujuan = $dt_prn['KodePuskesmas'];
								$jml_prn = $dt_prn['Jumlah'];
							}else{
								$tujuan = '-';
								$jml_prn = '0';
							}
							
							$stok_akhir = $stok_awal + $jml_trm - $jml_prn;
										
						?>
						<tr>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kodebarang;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namabarang;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $satuan;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $stok_awal;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $terima_dari;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_trm;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tujuan;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_prn;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $stok_akhir;?></td>				
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
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
