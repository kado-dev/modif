<?php
	include "hepler.php";
	$kota = $_SESSION['kota'];
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$key = $_GET['key'];
	$bulan = date('m');
	$bulanlalu = $bulan -1;
	$tahun = date('Y');
	$nofakturterima = $_GET['nofakturterima'];
	// tbstok
	$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<a href="index.php?page=lap_gfk_kartustok_group&key=<?php echo $key;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DETAIL KARTU STOK (GROUP)</b></h3>
			<div class="alert alert-success" role="alert">
				<table width="100%">
					<tr>
						<td width="10%">Kode Barang</td>
						<td width="2%">:</td>
						<td width="88%"><?php echo $kodebarang;?></td>
					</tr>
					<tr>
						<td>Nama Barang</td>
						<td>:</td>
						<td><b><?php echo $dtbrg['NamaBarang'];?></b></td>
					</tr>
					<tr>
						<td>No.Batch</td>
						<td>:</td>
						<td><b><?php echo $nobatch;?></b></td>
					</tr>
					<tr>
						<td>Expire</td>
						<td>:</td>
						<td><?php echo $dtbrg['Expire'];?></td>
					</tr>
					<tr>
						<td>Sumber</td>
						<td>:</td>
						<td><?php echo $dtbrg['SumberAnggaran'];?></td>
					</tr>
					<tr>
						<td>Program</td>
						<td>:</td>
						<td><?php echo $dtbrg['NamaProgram'];?></td>
					</tr>
				</table>	
			</div>			
			<div class="formbg" style="padding: 10px;">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_kartustok_lihat"/>
						<input type="hidden" name="kd" class="form-control key" value="<?php echo $kodebarang;?>">
						<input type="hidden" name="batch" class="form-control key" value="<?php echo $nobatch;?>">
						<input type="hidden" name="key" class="form-control key" value="<?php echo $key;?>">
						<div class="col-sm-2 bulanformcari">
							<select name="bulan" class="form-control">
								<option value="" <?php if($_GET['bulan'] == ''){echo "SELECTED";}?>>Semua</option>
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
									<option value="" <?php if($_GET['tahun'] == ''){echo "SELECTED";}?>>Semua</option>
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<input type="text" name="penerimabrg" class="form-control" value="<?php echo $_GET['penerimabrg'];?>">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_kartustok_lihat&kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<div class="search-area well well-sm">
						<div class="space-6"></div>
						<div class = "row">
							<div class="col-sm-12 table-responsive">
								<table class="table table-judul-form">
									<thead>
										<tr>
											<th width="4%">No.</th>
											<th width="10%">Tanggal</th>
											<th width="20%">No.Faktur</th>
											<th width="30%">Keterangan</th>
											<th>StokAwal</th>
											<th>Penerimaan</th>
											<th>Pengeluaran</th>
											<th>Sisa</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										$no = 0;
										$bulan = $_GET['bulan'];
										$tahun = $_GET['tahun'];
										$penerimabrg = $_GET['penerimabrg'];
										
										// stok awal, ini ngambil sisa stok yang bulan des 2019
										if($bulan != ''){
											$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch' AND Bulan = '$bulan' AND Tahun = '$tahun'";
										}else{
											$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
										}
										
										$query_stokawal = mysqli_query($koneksi, $str_stokawal);
										while($dt_stokawal = mysqli_fetch_assoc($query_stokawal)){
											$no = $no + 1;
											$faktur_terima = $dt_stokawal['NomorPembukuan'];
											$jml_stokawal = $dt_stokawal['Stok'];
											$tanggal_stokawal = $dt_stokawal['Bulan']." ".$dt_stokawal['Tahun'];
											$semua_jml_terima = 0;
											$sisa = $jml_stokawal;	
										?>
											<tr>
												<td align="center"><?php echo $no;?></td>
												<td align="center"><?php echo $tanggal_stokawal;?></td>
												<td align="center">-</td>
												<td align="left"><?php echo "SO BULAN ".$tanggal_stokawal;?></td>
												<td align="right"><?php echo number_format($jml_stokawal, 0, ".", ".");?></td>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center"><?php echo number_format($sisa, 0, ".", ".");?></td>
											</tr>	
										<?php
											}
										
										// penerimaan
										$str_terima = "SELECT * FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodebarang ' AND SUBSTRING(NomorPembukuan,5,4)='$dtbrg[TahunAnggaran]'";
										
										$query_terima = mysqli_query($koneksi, $str_terima);
										while($dt_terima = mysqli_fetch_assoc($query_terima)){
											$no = $no + 1;
											$faktur_terima = $dt_terima['NomorPembukuan'];
											$jml_terima = $dt_terima['Jumlah'];
											$nobatch_terima = $dt_terima['NoBatch'];
											$stokterima[] = $jml_terima;
											$ttl_terima = array_sum($stokterima);
											
											// detail penerimaan
											$dt_penerimaan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$faktur_terima'"));
											$tanggal_terima  = $dt_penerimaan['TanggalPenerimaan'];
											$keterangan_terima = $dt_penerimaan['KodeSupplier'];
											$sisa = $sisa + $jml_terima;
											
											// ref_pabrik
											$dtpabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `nama_prod_obat` FROM `ref_pabrik` WHERE `id`='$dt_penerimaan[KodeSupplier]'"));
											if($dtpabrik['nama_prod_obat'] != ""){
												$pabrik = $dtpabrik['nama_prod_obat'];												
											}else{
												$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Supplier` FROM `tbgfksupplier` WHERE `KodeSupplier`='$dt_penerimaan[KodeSupplier]'"));
												$pabrik = $dtsupplier['Supplier'];												
											}
											
											$semua_jml_terima = $semua_jml_terima + $jml_terima;
										?>
											<tr>
												<td align="center"><?php echo $no;?></td>
												<td align="center"><?php echo $tanggal_terima;?></td>
												<td align="center"><?php echo $faktur_terima;?></td>
												<td align="left"><?php echo $pabrik.", BATCH : ".$nobatch_terima;?></td>
												<td align="center"></td>
												<td align="right"><?php echo number_format($jml_terima, 0, ".", ".");?></td>
												<td align="center"></td>
												<td align="right"><?php echo number_format($sisa, 0, ".", ".");?></td>
											</tr>	
										<?php
											
											
										// pengeluaran
										$no = 0;										
										$str_keluar = "SELECT * FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch_terima' AND `NoFakturTerima`='$faktur_terima'";
										
										$query_keluar = mysqli_query($koneksi, $str_keluar);
										while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
											$no = $no + 1;
											$nofaktur = $dt_keluar['NoFaktur'];											
											
											// pengeluaran
											if($penerimabrg != ""){
												$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur' AND `Penerima` LIKE '%$penerimabrg%'"));
											}else{
												$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur'"));
											}											
											
											
											$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];													
											$faktur_keluar  = $dt_distribusi['NoFaktur'];
											$keterangan_keluar = $dt_distribusi['Penerima'];
											$faktur_keluar = $dt_distribusi['NoFaktur'];											

											if($tanggal_keluar != '' or $faktur_keluar != ''){
												$jml_keluar = $dt_keluar['Jumlah'];			
												$stokkeluar[] = $jml_keluar;
												$ttl_keluar = array_sum($stokkeluar);
												$sisa = $sisa - $jml_keluar;
										?>	
											<tr>
												<td align="center"><?php echo $no;?></td>
												<td align="center"><?php echo $tanggal_keluar;?></td>
												<td align="center"><?php echo $faktur_keluar;?></td>
												<td align="left"><?php echo $keterangan_keluar;?></td>
												<td align="center"></td>
												<td align="center"></td>
												<td align="right"><?php echo number_format($jml_keluar, 0, ".", ".");?></td>
												<td align="right"><?php echo number_format($sisa, 0, ".", ".");?></td>
											</tr>
										<?php
												}
											}
										}
										?>
									</tbody>
								</table><br/><br/>
								<table class="table table-judul-form"  width="100%">
									<tbody>
										<tr style="background: #fff4b7; font-weight: bold;">
											<td colspan="6">Jumlah Pengeluaran <?php echo nama_bulan($bulan);?></td>
											<td align="right"><?php echo number_format($ttl_keluar, 0, ".", ".");?></td>
										</tr>
										
										<!--<tr style="background: #f7e58c; font-weight: bold;">
											<td colspan="5">Jumlah Pengeluaran Selain <?php echo nama_bulan($bulan);?></td>
											<td align="right">
												<?php 
													// $str_keluar = "SELECT SUM(Jumlah) AS Jml FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'";
													// $dtkeluar = mysqli_fetch_assoc(mysqli_query($koneksi, $str_keluar));	
													// $jmlkeluar = $dtkeluar['Jml'] - $ttl_keluar;
													// echo number_format($jmlkeluar, 0, ".", ".");
												?>
											</td>
										</tr>-->
										
										<tr style="background: #ffce8e; font-weight: bold;">
											<td colspan="6"> Sisa Stok</td>
											<td align="right">
												<?php  
													$sisastok = ($jml_stokawal + $ttl_terima) - $ttl_keluar;
													echo number_format($sisastok, 0, ".", ".");
												?>
											</td>
										</tr>
									</tbody>
								</table><hr/>
								<div class="row">
									<div class="col-sm-6">
										<a href="lap_gfk_kartustok_lihat_print.php?kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>" class="btnsimpan">Print</a>
									</div>
									<div class="col-sm-6">
										<a href="lap_gfk_kartustok_lihat_excel.php?kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>" class="btnsimpan" style="background: #5abdd6;">Excel</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



