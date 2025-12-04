<style>
	.kertas {
		text-align:center;
		background: white;
	}
	
	.print{
		display:none;
		margin:auto; 
		background:white;
	}
	#barcode{
		width:100%;
		height:90px;
		margin:0px;
		margin-top:0px;
		float:center;
	}
	.tbrowbarcode td{
		text-align:center;
		font-size:8px;
	}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.print{
		display:block;
	}
}
</style>
<script>
	function printWindow(){
	   bV = parseInt(navigator.appVersion)
	   if (bV >= 4) window.print()
	}
</script>

<?php
$kodebarang = $_GET['id'];
$nobatch = $_GET['batch'];
$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'";
// echo $str;
// die();
$query = mysqli_query($koneksi,$str);
$data = mysqli_fetch_array($query);
?>

<div class="print">
	<div class="barcodeprint">
		<p style="text-align:center;padding-top:20px">
			<?php echo $data['NamaBarang'];?><br/>
			<img id="barcode" style="width:10%;"/>
		</p>								
	</div>
	<div class="qrcodeprint" style="display:none;">
		<table>
			<tr>
				<td><div id="qrcode" style="text-align:center;padding-top:10px;width:75px;"></div></td>
				<td style="text-align:left">
				<?php echo $data['NamaBarang'];?><br/>
				<?php echo $data['NoBatch'];?>
				</td>
			</tr>
		</table>
	</div>
	<script type="text/javascript">
		JsBarcode("#barcode", "<?php echo $data['Barcode'];?>");
	
		var qrcode = new QRCode(document.getElementById("qrcode"), {
			width : 70,
			height : 70
		});
		var elText = <?php echo $data['Barcode'];?>;
		qrcode.makeCode(elText);
	</script>
</div>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-8">
			<h3 class="judul"><b>DETAIL DATA BARANG</b></h3>
			<div class="formbg">
				<div class = "row">
					<div class="box-body">
						<form class="form-horizontal" action="index.php?page=gudang_vaksin_updatestok" method="post" enctype="multipart/form-data" role="form">
							<table class="table table-striped">
								<tr>
									<td width="20%">Kode Barang</td>
									<td width="80%"><b><?php echo $data['KodeBarang'];?></b></td>
								</tr>
								<tr>
									<td>Nama Barang</td>
									<td><b><?php echo $data['NamaBarang'];?></b></td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td><?php echo $data['Satuan'];?></td>
								</tr>
								<tr>
									<td>No.Batch</td>
									<td><?php echo $data['NoBatch'];?></td>
								</tr>
								<tr>
									<td>Expire</td>
									<td><?php echo $data['Expire'];?></td>
								</tr>
								<tr>
									<td>Stok</td>
									<td><?php echo $data['Stok'];?></td>
								</tr>
								<tr>
									<td>Tgl.Update Stok</td>
									<td><?php echo $data['TanggalUpdateStok'];?></td>
								</tr>
								<?php 
									// history
									if($kota == "KABUPATEN BEKASI"){
										$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
										FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
										WHERE a.`KodeBarang`='$data[KodeBarang] ' AND a.`NoBatch`='$data[NoBatch]' 
										AND YEAR(b.TanggalPenerimaan) > '2019'"));
									}else{
										$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
										FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
										WHERE a.`KodeBarang`='$data[KodeBarang] ' AND a.`NoBatch`='$data[NoBatch]'"));
									}
									$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan` = '$dtpenerimaandtl[NomorPembukuan]'"));
									$dtkarantinadtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail` WHERE `KodeBarang` = '$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'"));
									if($kota == "KABUPATEN BEKASI"){
										$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
										FROM `tbgfk_vaksin_pengeluarandetail` a JOIN tbgfk_vaksin_pengeluaran b ON a.NoFaktur = b.NoFaktur 
										WHERE a.`KodeBarang` = '$data[KodeBarang]' AND a.`NoBatch`='$data[NoBatch]' AND YEAR(b.TanggalPengeluaran) > '2019'"));
									}else{
										$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
										FROM `tbgfk_vaksin_pengeluarandetail` a JOIN tbgfk_vaksin_pengeluaran b ON a.NoFaktur = b.NoFaktur 
										WHERE a.`KodeBarang` = '$data[KodeBarang]' AND a.`NoBatch`='$data[NoBatch]'"));
									}	
									$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id` = '$dtpenerimaan[KodeSupplier]'"));
									$stokawalmaster = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang` = '$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'"));
									
								?>
								<tr>
									<td>Tgl.Terima</td>
									<td>
										<?php 
											if($dtpenerimaan['TanggalPenerimaan'] != ""){
												echo date("d-m-Y", strtotime($dtpenerimaan['TanggalPenerimaan']));
											}else{
												echo $stokawalmaster['Bulan']." ".$stokawalmaster['Tahun'];
											}	
										?>
									</td>
								</tr>
								<tr>
									<td>No.Pembukuan</td>
									<td>
									<?php 
										if($dtpenerimaan['NomorPembukuan'] != ""){
											echo $dtpenerimaan['NomorPembukuan'];
										}else{
											echo $stokawalmaster['Keterangan'];
										}		
									?>
									</td>
								</tr>
								<tr>
									<td>Program</td>
									<td>
									<?php 
										if($dtpenerimaan['NamaProgram'] != ""){
											echo $dtpenerimaandtl['NamaProgram'];
										}else{
											echo $stokawalmaster['NamaProgram'];
										}	
									?>
									</td>
								</tr>
								<tr>
									<td>Supplier</td>
									<td>
									<?php 
										if($dtpenerimaan['nama_prod_obat'] != ""){
											echo $dtsupplier['nama_prod_obat'];
										}else{
											echo "-";
										}	
									?>
									</td>
								</tr>
								<tr>
									<td>Jumlah Terima</td>
									<td>
									<?php 
										if($dtpenerimaan['IdPenerimaan'] != ""){
											echo $dtpenerimaandtl['Jumlah'];
										}else{
											echo $stokawalmaster['Stok'];
										}	
									?>
									</td>
								</tr>
								<tr>
									<td>Jumlah Keluar</td>
									<td><?php echo $dtpengeluarandtl['Jumlah'];?></td>
								</tr>
								<tr>
									<td>Jumlah Karantina</td>
									<td><?php echo $dtkarantinadtl['Jumlah'];?></td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>
										<?php 
											// 1. stok awal, ini ngambil sisa stok yang bulan des 2019
											$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'";
											$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
											if ($dt_stokawal_dtl['Stok'] != null){
												$stokawal = $dt_stokawal_dtl['Stok'];
											}else{
												$stokawal = '0';
											}
											// echo "Stok Awal : ".$stokawal."</br>";											
																				
											// 2. penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
											if ($dtpenerimaandtl['Jumlah'] != null){
												$penerimaan = $dtpenerimaandtl['Jumlah'];
											}else{
												$penerimaan = '0';
											}											
											// echo "Penerimaan : ".$penerimaan."</br>";
											
											// 3. pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
											if ($dtpengeluarandtl['Jumlah'] != null){
												$pengeluaran = $dtpengeluarandtl['Jumlah'];
											}else{
												$pengeluaran = '0';
											}
											// echo "Pengeluaran : ".$pengeluaran."</br>";
											
											// 4. karantina detail
											$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$data[KodeBarang]' AND a.`NoBatch`='$data[NoBatch]'";
											$dt_karantina_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
											if ($dt_karantina_dtl['Jumlah'] != null){
												$karantina = $dt_karantina_dtl['Jumlah'];
											}else{
												$karantina = '0';
											}
											// echo "karantina : ".$karantina."</br>";
											
											// 5. sisastok, jika penerimaan 0, ngambil dari stok awal
											if($penerimaan == 0){
												$sisastok = $stokawal - $pengeluaran - $karantina;
												// echo "1";
											}else{
												$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina;
												// echo "2";
											}
											echo $sisastok;?>
									</td>
								</tr>
							</table>
							<input type="hidden" name="kodebarang" value="<?php echo $data['IdBarang'];?>"/>
							<input type="hidden" name="kodebarang" value="<?php echo $data['KodeBarang'];?>"/>
							<input type="hidden" name="nobatch" value="<?php echo $data['NoBatch'];?>"/>
							<input type="hidden" name="nofakturterima" value="<?php echo $data['NoFakturTerima'];?>"/>
							<input type="hidden" name="sisastok" value="<?php echo $sisastok;?>"/>
							<input type="hidden" name="namaprogram" value="<?php echo $data['NamaProgram'];?>"/>
							<button type="submit" class="btnsimpan">Update Data</button>
						</form>
					</div>
				</div>	
			</div>
		</div>	
		<div class="col-xs-4">
			<a href="index.php?page=gudang_vaksin_stok" class="backform" style="margin-top: 0px"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>PRINT</b></h3>
			<div class="formbg">
				<div class = "row">
					<div class="box-body">
						<select class="form-control opsicode">
							<option>Barcode</option>
							<option>Qrcode</option>
						</select>
						<div style="text-align: center;">
							<div class="barcodeprint">
								<p style="text-align:center;padding-top:20px">
									<?php echo $data['NamaBarang'];?><br/>
									<img id="barcode1" style="width:35%;"/>
								</p>								
							</div>
							<div class="qrcodeprint" style="display:none;">
								<table>
									<tr>
										<td><div id="qrcode1" style="text-align:center;padding-top:10px;width:75px;"></div></td>
										<td style="text-align:left">
										<?php echo $data['NamaBarang'];?><br/>
										<?php echo $data['NoBatch'];?>
										</td>
									</tr>
								</table>
							</div>							
							<script>JsBarcode("#barcode1", "<?php echo $data['Barcode'];?>");</script><br/>
							<a href="javascript:print()" class="btn btn-sm btn-primary"> Print</a>
							<a href="index.php?page=gudang_besar_stok" class="btn btn-sm btn-info"> Kembali</a>
						</div>
						
						<script type="text/javascript">
							var qrcode = new QRCode(document.getElementById("qrcode1"), {
								width : 70,
								height : 70
							});
							var elText = <?php echo $data['Barcode'];?>;
							qrcode.makeCode(elText);
						</script>
					</div>
				</div>	
			</div>
		</div>	
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script>
$(".opsicode").change(function(){
	if($(this).val() == 'Qrcode'){
		$(".barcodeprint").hide();
		$(".qrcodeprint").show();
	}else{
		$(".barcodeprint").show();
		$(".qrcodeprint").hide();
	}
});
</script>
