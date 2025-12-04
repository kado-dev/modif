<?php
	include "config/helper_report.php";	
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$penerima = $_GET['penerima'];
	
	// untuk mengupdate grandtotal
	$str3= "SELECT * FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nf'";
	$query3 = mysqli_query($koneksi,$str3);	
	while($data3 = mysqli_fetch_assoc($query3)){
		$kdbrg = $data3['KodeBarang'];
		$batch = $data3['NoBatch'];
		// tbgfkstok
		$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
		$jumlah = round($dt_gfkstok['HargaBeli'],2) * $data3['Jumlah'];
		$totallama = $jumlah + $totallama;
	}
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<?php  if($kota == "KABUPATEN BOGOR"){ ?>
			<a href="index.php?page=gudang_besar_pengeluaran&kategori=Penerima&key=<?php echo $penerima;?>" class="backform" style="padding-top:0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<?php }elseif($kota == "KABUPATEN BANDUNG" || $kota == "KOTA BANDUNG" || $kota == "KABUPATEN BULUNGAN" || $kota == "KABUPATEN KUTAI KARTANEGARA" || $kota == "KOTA TARAKAN" || $kota == "KABUPATEN BEKASI"){ ?>
			<a href="index.php?page=gudang_besar_pengeluaran" class="backform" style="padding-top:0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<?php } ?>
			<h3 class="judul"><b>DATA PENGELUARAN </b><small>Gudang Besar</small></h3>
			<?php
				$datapengeluaran=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nf'"));
			?>
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width="20%">No.Faktur</th>
						<th width="30%">Penerima</th>
						<?php if($kota == "KABUPATEN BOGOR"){ ?>
						<th width="30%">Program</th>
						<?php } ?>
						<th width="20%" colspan="2">Opsi</th>
					</tr>
				</thead>
				<tbody>
					<tr style="font-size: 18px; font-weight: bold;">
						<?php  if($kota == "KABUPATEN BEKASI"){  ?>
						<td align="center"><?php echo $datapengeluaran['NoFakturManual']?></td>
						<?php }else{ ?>
						<td align="center"><?php echo $datapengeluaran['NoFaktur']?></td>
						<?php } ?>	
						<td align="center"><?php echo $datapengeluaran['Penerima']?></td>
						<?php 
						// nama program
						if($kota == "KABUPATEN BOGOR"){?>
						<td align="center"><?php echo $datapengeluaran['NamaProgram']?></td>
						<?php } ?>
						<?php if($_SESSION['kota']=='KABUPATEN BANDUNG'){?>
						<td align="center"><a href="gudang_besar_pengeluaran_lihat_print.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">PRINT</a></td>
						<?php }elseif($_SESSION['kota']=='KABUPATEN BEKASI'){?>
						<td align="center">
							<a href="gudang_besar_pengeluaran_lihat_print_bekasikab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">SBBK</a>
						</td>
						<?php }elseif($_SESSION['kota']=='KABUPATEN BOGOR' || $_SESSION['kota']=='KOTA TARAKAN'){?>
						<td align="center"><a href="gudang_besar_pengeluaran_lihat_print_bogorkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">PRINT</a></td>
						<?php }?>
						<td align="center">
							<a href="gudang_besar_pengeluaran_lihat_print_bast_bakasikab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">BAST</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><br/>
	<!--<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 20px 50px 0px 50px;">
				<div class = "row">
					<table class="table table-striped table-condensed">
						<tr>
							<td class="col-sm-2">Scan Barcode</td>
							<td class="col-sm-10">
								<input type="text" name="barcode" class="form-control barcode" onmouseover="this.focus();" placeholder="Silahkan scan kode barcode" maxlength = "13">
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>-->
	
	<!--notifikasi-->
	<?php
	if ($_GET['sts'] == 1){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Data gagal disimpan, obat sudah expire...</div>
	<?php
	}elseif ($_GET['sts'] == 2){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Barang sudah diinputkan...</div>
	<?php
	}elseif ($_GET['sts'] == 3){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Stok kurang dari jumlah pengeluaran...</div>
	<?php
	}elseif ($_GET['sts'] == 4){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Tanggal distribusi kurang dari tanggal terima...</div>
	<?php
	}
	?>
	
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<form action="?page=gudang_besar_pengeluaran_lihat_proses" method="post">
					<div class="form-group row">
						<div class="col-sm-2">Nama Barang</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-10">
									<input type="text" class="form-control nama_barang_gudang_besar" placeholder="Ketikan Nama Barang" required>
									<input type="hidden" name="namabarang" class="form-control namabaranghidden">
									<input type="hidden" class="form-control jumlahstokhidden">
								</div>
								<div class="col-sm-2">
									<input type="text" name="kodebarang" class="form-control kodebarang" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Program</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-6">
									<input type="text" name="program" class="form-control program" readonly>
								</div>
								<div class="col-sm-1">
									Satuan
								</div>
								<div class="col-sm-5">
									<input type="text" name="satuan" class="form-control satuan" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Batch</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-6">
									<input type="text" name="nobatch" class="form-control nobatch" readonly>
								</div>
								<div class="col-sm-1">
									Expire
								</div>
								<div class="col-sm-5">
									<input type="text" name="expire" class="form-control expire" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Harga Satuan</div>
						<div class="col-sm-10">	
							<div class="row">
								<div class="col-sm-6">
									<input type="text" name="hargabeli" class="form-control hargabeli" readonly>
								</div>
								<div class="col-sm-1">
									Stok
								</div>
								<div class="col-sm-5">
									<input type="text" name="stok" class="form-control stok" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Jumlah</div>
						<div class="col-sm-10">
							<input type="number" name="jumlah" class="form-control jumlah" maxlength="10">
							
						</div>
					</div><br/>
					<div class="text-center">
						<div class="row">
							<input type="submit" value="Simpan" class="btn btn-round btn-success btnsimpan">
						</div>
					</div>
					<input type="hidden" class="form-control" name="iddistribusi" value="<?php echo $datapengeluaran['IdDistribusi']?>">
					<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
					<input type="hidden" class="form-control" name="tanggalpengeluaran" value="<?php echo $datapengeluaran['TanggalPengeluaran']?>">
					<input type="hidden" class="form-control" name="kodepenerima" value="<?php echo $datapengeluaran['KodePenerima']?>">
					<input type="hidden" class="form-control" name="statuspengeluaran" value="<?php echo $datapengeluaran['StatusPengeluaran']?>">
					<input type="hidden" class="form-control" name="penerima" value="<?php echo $datapengeluaran['Penerima'];?>">
					<input type="hidden" class="form-control sumberanggaran" name="sumberanggaran">
					<input type="hidden" class="form-control nofakturterima" name="nofakturterima">
					<input type="hidden" class="form-control program" name="program">
				</form>
			</div>
		</div>
	</div>
</div>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b><?php echo $jmlbrg." ITEM BARANG,";?> GRAND TOTAL Rp. <?php echo number_format($totallama,2,",",".");?></b></h3>
			<table class="table-judul-laporan-dark" width="100%">
				<thead>
					<tr>
						<th width="4%">NO.</th>
						<th width="7%">KODE</th>
						<th width="25%">NAMA BARANG</th>
						<th width="6%">SATUAN</th>
						<th width="8%">BATCH</th>
						<th width="8%">EXPIRE</th>
						<th width="12%">SUMBER</th>
						<th width="5%">TAHUN</th>
						<th width="6%">HARGA</th>
						<th width="5%">JML</th>
						<th width="10%">TOTAL</th>
						<th width="5%">#</th>
					</tr>
				</thead>
				<tbody>
				<?php			
					$no = 0;	
					$kategori = $_GET['kategori'];		
					$key = $_GET['key'];	
					
					if($kategori !='' && $key !=''){
						$strcari = " WHERE NoFaktur = '$nf' AND".$kategori." Like '%$key%'";
					}else{
						$strcari = " WHERE NoFaktur = '$nf'";
					}
					
					$str = "SELECT * FROM `tbgfkpengeluarandetail` ".$strcari;
					$str2 = $str."ORDER BY Id DESC";
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];
						
						// tbgfkstok
						$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
						$totals = round($dt_gfkstok['HargaBeli'],2) * $data['Jumlah'];
						if($dt_gfkstok['SumberAnggaran']=='APBD KAB/KOTA'){
							$sumber = "APBD";
						}else{
							$sumber = $dt_gfkstok['SumberAnggaran'];
						}	
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeBarang'];?></td>
							<td class="nama"><?php echo $dt_gfkstok['NamaBarang'];?></td>
							<td align="center"><?php echo $dt_gfkstok['Satuan'];?></td>
							<td align="center"><?php echo $data['NoBatch'];?></td>
							<td align="center"><?php echo $dt_gfkstok['Expire'];?></td>
							<td align="center"><?php echo $sumber;?></td>
							<td align="center"><?php echo $dt_gfkstok['TahunAnggaran'];?></td>
							<td align="right"><?php echo round($dt_gfkstok['HargaBeli'],2);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($totals);?></td>
							<td align="center">
								<?php 
									// cek apakah sudah diapprove atau belum, saat penerimaan detail gudang obat puskesmas
									$str_cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StatusValidasi` FROM `tbgfkpengeluarandetail` WHERE `NoFaktur` = '$data[NoFaktur]' AND `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'"));
									if ($str_cek['StatusValidasi'] == 'Belum' || $str_cek['StatusValidasi'] == ''){ 
								?>
								<a href="?page=gudang_besar_pengeluaran_lihat_hapus&id=<?php echo $data['Id'];?>&idds=<?php echo $data['IdDistribusi'];?>&nf=<?php echo $data['NoFaktur'];?>&kd=<?php echo $data['KodeBarang'];?>&bt=<?php echo $data['NoBatch'];?>&nft=<?php echo $data['NoFakturTerima'];?>&jml=<?php echo $data['Jumlah'];?>&penerima=<?php echo $penerima;?>" class="btn btn-round btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin dihapus...?')">HAPUS</a>
								<?php } ?>
							</td>
						</tr>
					<?php
						// $total = round($dt_gfkstok['HargaBeli'],2) * $data['Jumlah'];
						// echo "Hasil : ".$tes = $tes + $total;
						}	
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="alertss"></div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/js/jquery.autocomplete.js"></script>
<script>
$('.nama_barang_gudang_besar').autocomplete({
	serviceUrl: 'get_namabarang_gudangbesar.php?keyword=',
	onSelect: function (suggestion) {
		$(this).val(suggestion.namabarang);
		$(".jumlah").focus();
		$(".kodebarang").val(suggestion.kodebarang);
		$(".namabarang").val(suggestion.namabarang);
		$(".barcode").val(suggestion.barcode);
		$(".kemasan").val(suggestion.kemasan);
		$(".isikemasan").val(suggestion.isikemasan);
		$(".satuan").val(suggestion.satuan);
		$(".kelastherapy").val(suggestion.kelastherapy);
		$(".golonganfungsi").val(suggestion.golonganfungsi);
		$(".program").val(suggestion.program);
		$(".jenisbarang").val(suggestion.jenisbarang);
		$(".ruangan").val(suggestion.ruangan);
		$(".rak").val(suggestion.rak);
		$(".stok").val(suggestion.stok);
		$(".minimalstok").val(suggestion.minimalstok);
		$(".hargabeli").val(suggestion.hargabeli);
		$(".nobatch").val(suggestion.nobatch);
		$(".expire").val(suggestion.expire);
		$(".sumberanggaran").val(suggestion.sumberanggaran);
		$(".tahunanggaran").val(suggestion.tahunanggaran);
		$(".supplier").val(suggestion.supplier);
		$(".keterangan").val(suggestion.keterangan);
		$(".nofakturterima").val(suggestion.nofakturterima);
	}
});
</script>