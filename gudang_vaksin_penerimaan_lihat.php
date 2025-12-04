<?php
	$id = $_GET['id'];
	include "config/helper_report.php";
	$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_penerimaan` where `NomorPembukuan` = '$id'"));
	
	if($kota == 'KABUPATEN BOGOR'){
		$filelogo = "bogorkab.png";
	}else if($kota == 'KABUPATEN BEKASI'){
		$filelogo = "bekasikab.png";
	}else{
		$filelogo = "bandungkab.png";
	}
?>

<style>
.imglogo{
	width: 85px;
	height: 75px;
	margin-left: 40px;
	margin-bottom: -70px;
	display: none;
}
.table-responsive{
	overflow-x: hidden;
}	
	
@media print{
	.imglogo{
		display:block;
	}
}
</style>

<div class="tableborderdiv noprint">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_vaksin_penerimaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA PENERIMAAN </b><small>Gudang Vaksin</small></h3>
			<div class="table-responsive">
				<?php
					$datapenerimaan=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan`='$id'"));
				?>
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="20%">Tgl.Penerimaan</th>
							<th width="30%">Anggaran</th>
							<th width="30%">No.Pembukuan</th>
							<th width="20%" colspan="2">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo $datapenerimaan['TanggalPenerimaan']?></td>
							<td align="center"><?php echo $datapenerimaan['SumberAnggaran']." - ".$datapenerimaan['TahunAnggaran']?></td>
							<td align="center"><?php echo $datapenerimaan['NomorPembukuan']?></td>
							<td align="center"><a href="?page=gudang_vaksin_penerimaan_edit&id=<?php echo $id;?>" class="btninfo" style="margin-right:5px">EDIT</a></td>
							<td align="center"><a href="javascript:print()" class="btnsimpan" style="margin-right:5px">PRINT</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php 
	// untuk mengambil total
	$totals = 0;
	$str = "SELECT * FROM `tbgfk_vaksin_penerimaandetail` WHERE `NomorPembukuan` = '$id'";
	$query = mysqli_query($koneksi, $str);				
	while($data=mysqli_fetch_assoc($query)){
		$jumlah = $data['Jumlah'] * $data['Harga'];
		$totals = $jumlah + $totals;
	}
	$jmlbrg = mysqli_num_rows(mysqli_query($koneksi, $str));
?>	
<div class="tableborderdiv noprint">	
	<div class="row">
		<div class="col-xs-12">
			<?php
				if($_GET['stsvalidasi'] != ''){
					echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
				}
			?>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<div class="table-responsive">
						<form action="?page=gudang_vaksin_penerimaan_lihat_proses" method="post">	
							<input type="hidden" value="<?php echo $datapenerimaan['TanggalPenerimaan']?>" name="tglpenerimaan">
							<div class="table-responsive">
								<table class="table-judul" width="100%">
									<tr>
										<td class="col-sm-2">Nama Barang (LPLPO)</td>
										<td>
											<div class="row">
													<div class="col-sm-10">
													<input type="text" name="namabarang" class="form-control nama_barang_vaksin" placeholder="Ketikan Nama Barang" required>
												</div>
													<div class="col-sm-2">
													<input type="text" name="kodebarang" class="form-control kodevaksin" readonly>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>Isi - Kemasan - Satuan</td>
										<td>
											<div class="row">
												<div class="col-sm-2">
													<input type="text" name="isikemasan" class="form-control" maxlength = "5" value="100" required>
												</div>
												<div class="col-sm-5">
													<select name="kemasan" class="form-control">
														<option value="KOTAK">KOTAK</option>
														<?php
														$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
															while($data = mysqli_fetch_assoc($query)){
																echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
															}
														?>
													</select>
												</div>	
												<div class="col-sm-5">	
													<select name="satuan" class="form-control" required>
														<option value="TABLET">TABLET</option>
														<?php
														$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
															while($data = mysqli_fetch_assoc($query)){
																echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
															}
														?>
													</select>
												</div>
											</div>	
										</td>
									</tr>
									<tr>
										<td>Kelas Therapy</td>
										<td>
											<select name="kelastherapy" class="form-control" required>
												<option value="VAKSIN">VAKSIN</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Golongan Fungsi</td>
										<td>
											<select name="golonganfungsi" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php
												$query = mysqli_query($koneksi,"SELECT * FROM `tbobatkelompok` order by `KelompokObat`");
													while($data = mysqli_fetch_assoc($query)){
														echo "<option value='$data[KelompokObat]'>$data[KelompokObat]</option>";
													}
												?>
											</select>	
										</td>		
									</tr>
									<tr>
										<td>Nama Program</td>
										<td>
											<select name="namaprogram" class="form-control" required>
												<option value="IMUNISASI">IMUNISASI</option>
											</select>
										</td>		
									</tr>
									<tr>
										<td>Ruangan - Rak - Min.Stok</td>
										<td>
											<div class="row">
												<div class="col-sm-4">
													<select name="ruangan" class="form-control" required>
														<option value="GUDANG VAKSIN" SELECTED>GUDANG VAKSIN</option>
													</select>
												</div>
												<div class="col-sm-4">
													<select name="rak" class="form-control" required>
														<option value="-" SELECTED>-</option>
														<option value="RAK 1">RAK 1</option>
														<option value="RAK 2">RAK 2</option>
														<option value="RAK 3">RAK 3</option>
														<option value="RAK 4">RAK 4</option>
														<option value="RAK 5">RAK 5</option>
													</select>
												</div>
												<div class="col-sm-4">
													<input type="text" name="minimalstok" class="form-control" maxlength = "6" value="100" required>
												</div>
											</div>	
										</td>
									</tr>
									<tr>
										<td>Barcode - Batch - Expire</td>
										<td>
											<div class="row">
												<div class="col-sm-4">
													<input type="text" name="barcode" class="form-control" maxlength = "13" placeholder="Barcode" required>
												</div>
												<div class="col-sm-4">
													<input type="text" name="nobatch" class="form-control" maxlength = "30" placeholder="Batch" required>
												</div>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon tesdate">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" name="expire" class="form-control datepicker" placeholder="Pilih Tanggal" required>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>Harga Beli (Rp)</td>
										<td>
											<input type="text" name="hargabeli" class="form-control" maxlength = "10" placeholder="Maks. 10 digit" required>
										</td>
									</tr>
									<tr>
										<td>Jumlah Penerimaan</td>
										<td>
											<input type="number" name="jumlah" class="form-control" maxlength = "10" placeholder="Maks. 10 digit" required>
										</td>
									</tr>									
								</table><hr>
							</div>
							<input type="hidden" class="form-control" name="nomorpembukuan" value="<?php echo $datapenerimaan['NomorPembukuan']?>">
							<input type="hidden" class="form-control" name="sumberanggaran" value="<?php echo $datapenerimaan['SumberAnggaran']?>">
							<input type="hidden" class="form-control" name="tahunanggaran" value="<?php echo $datapenerimaan['TahunAnggaran']?>">
							<input type="hidden" class="form-control" name="totallama" value="<?php echo $totals;?>">
							<input type="hidden" class="form-control" name="id" value="<?php echo $id;?>">
							<button type="submit" class="btnsimpan">Simpan</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b><?php echo $jmlbrg." DATA BARANG, Rp. ".rupiah($totals);?></b></h3>
			<table class="table-judul-laporan">
				<thead>
					<tr class="head-table-gudang-besar-penerimaan">
						<th width="3%">No.</th>
						<th width="5%">Kode</th>
						<th width="25%">Nama Barang</th>
						<th width="5%">Satuan</th>
						<th width="10%">Barcode</th>
						<th width="7%">Batch</th>
						<th width="8%">Expire</th>
						<th width="10%">Sumber</th>
						<th width="7%">Harga Sat.</th>
						<th width="7%">Jml</th>
						<th width="10%">Total</th>
						<th width="5%">Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$str ="SELECT * FROM `tbgfk_vaksin_penerimaandetail` WHERE `NomorPembukuan` = '$id' ORDER BY IdPenerimaan DESC";
					$query = mysqli_query($koneksi,$str);
					while($datapenerimaan = mysqli_fetch_assoc($query)){
						$no = $no + 1;
				?>
					<tr data-kode="<?php echo $datapenerimaan['KodeBarang'];?>" data-batch="<?php echo $datapenerimaan['NoBatch'];?>" data-nofaktur="<?php echo $datapenerimaan['NomorPembukuan'];?>" data-idbarang="<?php echo $datapenerimaan['IdPenerimaan'];?>">
						<?php
							$kodebarang = $datapenerimaan['KodeBarang'];
							$nobatch = $datapenerimaan['NoBatch'];
							$total = $datapenerimaan['Jumlah'] * $datapenerimaan['Harga'];
							
							// tbgfk_vaksin_stok
							$databarang_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
							$databarang_gudangbsr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
							if ($databarang_vaksin['NamaBarang'] != ''){
								$namabarang = $databarang_vaksin['NamaBarang'];
								$satuanbarang = $databarang_vaksin['Satuan'];
								$barcodebarang = $databarang_vaksin['Barcode'];
								$sumberbarang = $databarang_vaksin['SumberAnggaran'];
							}else{
								$namabarang = $databarang_gudangbsr['NamaBarang'];
								$satuanbarang = $databarang_gudangbsr['Satuan'];
								$barcodebarang = $databarang_gudangbsr['Barcode'];
								$sumberbarang = $databarang_gudangbsr['SumberAnggaran'];
							}	
						?>
						<td align="center"><?php echo $no;?></td>
						<td align="center" class="kode-edit"><?php echo $datapenerimaan['KodeBarang'];?></td>
						<td align="left"><?php echo $namabarang;?></td>
						<td align="center"><?php echo $satuanbarang;?></td>
						<td align="center"><?php echo $barcodebarang;?></td>
						<td align="center" class="nobatch-edit"><?php echo $datapenerimaan['NoBatch'];?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($datapenerimaan['Expire']));?></td>
						<td align="center"><?php echo $sumberbarang;?></td>
						<td align="right" class="harga-edit"><?php echo number_format("$datapenerimaan[Harga]",2,",",".");?></td>
						<td align="right" class="stok-edit" style="color:red;font-weight:bold"><?php echo rupiah($datapenerimaan['Jumlah']);?></td>
						<td align="right" class="hargatotals"><?php echo number_format($total,2,",",".");?></td>
						<?php
							// cek jika barang sudah didistribusikan tidak bisa dihapus
							$cekdistribusi = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgfk_vaksin_pengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$datapenerimaan[NomorPembukuan]'"));
							if($cekdistribusi == 0){
						?>
						<td style="text-align:center; vertical-align:middle; padding:5px;"><a href="?page=gudang_vaksin_penerimaan_lihat_hapus&id=<?php echo $datapenerimaan['IdPenerimaan'];?>&ko=<?php echo $datapenerimaan['KodeBarang'];?>&nb=<?php echo $datapenerimaan['NoBatch'];?>&nf=<?php echo $id;?>&ttl=<?php echo $total;?>&grand=<?php echo $totals;?>&jml=<?php echo $datapenerimaan['Jumlah'];?>" class="btn btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin dihapus...?')">Hapus</a></td>
						<?php }else{ ?>
						<td style="text-align:center; vertical-align:middle; padding:5px;">Distribusi</td>
						<?php } ?>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div> 
	</div> 
</div> 

<!--tabel report-->
<img src="image/<?php echo $filelogo;?>" class="imglogo">
<div class="printheader">
	<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN BARANG</b></span><br>
	<span class="font12" style="margin:1px;">No.Pembukuan: <?php echo $_GET['id'];?><br/>
	</span>
	<br/>
</div>

<div class="atastabel">
	<div style="float:left; width:75%; margin-bottom:10px;">
		<table style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">Kode Supplier </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $penerimaan['KodeSupplier'];?></td>
			</tr>
			<tr>
				<?php
					$idsupplier = $penerimaan['KodeSupplier'];
					$datasupplier = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `ref_pabrik` WHERE `id`='$idsupplier'"));
				?>
				<td style="padding:2px 4px;">Supplier </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datasupplier['nama_prod_obat'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Sumber Anggaran </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $penerimaan['SumberAnggaran']." - ".$penerimaan['TahunAnggaran'];?></td>
			</tr>
		</table>
	</div>
</div>

<div class="printbody">
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed" width="100%">
				<thead style="font-size:10px;">
					<tr style="border:1px solid #000;">
						<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th width="25%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NoBatch</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga Sat.</th>
						<th width="20%" rowspan="2" style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">Total Harga</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$total = 0;
					$no = 0;
					$str2 = "SELECT * FROM `tbgfk_vaksin_penerimaandetail` WHERE `NomorPembukuan` = '$id' ORDER BY IdPenerimaan DESC";
					$query2 = mysqli_query($koneksi,$str2);
					while($datapenerimaan2 = mysqli_fetch_assoc($query2)){
						$no = $no + 1;						
						$kodebarang = $datapenerimaan2['KodeBarang'];
						$nobatch = $datapenerimaan2['NoBatch'];
						$databarang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
						$jumlah = $datapenerimaan2['Harga'] * $datapenerimaan2['Jumlah'];
						$total = $jumlah + $total;
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no.".";?></td>
							<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $databarang['NamaBarang'];?></td>
							<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $databarang['Satuan'];?></td>
							<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo tgl_singkat($datapenerimaan2['Expire']);?></td>
							<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $datapenerimaan2['NoBatch'];?></td>
							<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($datapenerimaan2['Jumlah']);?></td>
							<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo "Rp. ".rupiah($datapenerimaan2['Harga']);?></td>
							<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo "Rp. ".rupiah($jumlah);?></td>
						</tr>
					<?php
					}
					?>
						<tr style="border:1px solid #000; padding:3px; font-weight: bold;">
							<td colspan="7" style="text-align:center; padding:3px; border:1px solid #000;">TOTAL</td>
							<td style="text-align:right; padding:3px; border:1px solid #000;"><?php echo "Rp. ".rupiah($total);?></td>
						</tr>
				</tbody>
			</table>
		</div>	
		<div class="font10">
			<?php 
				$dt_penerima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk`"));
			?>
			<table width="100%">
				<tr style="font-size: 12px;">
					<td style="text-align:center;">
					<p style="margin-top:15px;">Yang Menerima
					<br>
					<br>
					<br>
					<br>
					(..............................)</p>
					</td>	
					<td width="10%"></td>
					<td style="text-align:center;">
					<p>Mengetahui,<br/>
					<?php if($kota == "KABUPATEN BEKASI" || $kota == "KABUPATEN BANDUNG"){?>
						Ka. UPTD Farmasi, 
					<?php }else{ ?>
						Kasie Kefarmasian,
					<?php } ?>
					<br>
					<br>
					<br>
					<br>
					<b><u><?php echo $dt_penerima['nama_kasie'];?></u></b><br/>
					<?php echo "NIP. ".$dt_penerima['nip_kasie'];?></p>
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
					<p><?php echo $kota.", ".date('d-m-Y', strtotime($penerimaan['TanggalPenerimaan']));?><br/>
					Yang Menyerahkan
					<br>
					<br>
					<br>
					<br>
					<b><u><?php echo $dt_penerima['nama_pemberi'];?></u></b><br/>
					<?php echo "NIP. ".$dt_penerima['nip_pemberi'];?></p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
$(".harga-edit").dblclick(function(){
	var isi = $(this).html();
	var kode = $(this).parent().data('kode');
	var batch = $(this).parent().data('batch');
	var nofaktur = $(this).parent().data('nofaktur');
	var idbarang = $(this).parent().data('idbarang');
	var stok = $(this).parent().find('.stok-edit').html();
	var stoknilai = stok.replace(/[.]/g, "");
	var hargaisi = isi.replace(/[.]/g, "");
	$(this).html("<input type='text' value='"+hargaisi+"' class='harga-input inputedit'>");
	var lokasi = $(this).parent();
	$(".harga-input").focusout(function(){
		
		var isibaru = $(this).val();
		var totals = stoknilai * isibaru;
		$(this).parent().html(addCommas(isibaru));
		lokasi.find(".hargatotals").html(addCommas(Math.round(totals)));
		$.post( "gudang_vaksin_penerimaan_edit_jquery.php", {
		kode: kode,
		batch: batch,
		nofaktur: nofaktur,
		idbarang: idbarang,
		type: 'Harga',//nama kolom table
		value: isibaru //isinya
		}).done(function( data ) {
			alert('Data berhasil diedit..');
			getHitungGrand();
		});
	});
});	

function getHitungGrand(){
	var grandtotal = 0;
	$(".hargatotals").each(function () {
		var total = $(this).text().replace(/[.]/g, "");
		grandtotal = parseInt(grandtotal) + parseInt(total);
	});
		$.post( "gudang_vaksin_penerimaan_edit_updategrandtotal_jquery.php", {
		id: <?php echo $id;?>,
		grand: grandtotal //isinya
		}).done(function( data ) {
			$(".grandtotalcls").html(addCommas(grandtotal));
		});
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}
</script>