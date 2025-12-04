<?php
	session_start();
	include "config/helper_report.php";
	$kota = $_SESSION['kota'];
	
	// tbgfkpenerimaan	
	$id = $_GET['id'];
	$datapenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$id'"));
?>

<style>
.imglogo{
	width: 55px;
	height: 65px;
	margin-left: 40px;
	margin-bottom: -90px;
	margin-top: 10px;
	display: none;
}
.imglogo2{
	margin-left: 20px;
	margin-bottom: -120px;
	margin-top: 0px;
	display: none;
}
.imgpenerimaan {
  display: block;
  margin: auto;
  width: 30%;
}
.table-responsive{
	overflow-x: hidden;
}	
	
@media print{
	.imglogo{
		display:block;
	}
	.imglogo2{
		display:block;
	}
	.printheader{
		display:block;
	}
}
</style>

<div class="tableborderdiv noprint">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_penerimaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA PENERIMAAN </b><small>Gudang Besar</small></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="15%">TGL.PENERIMAAN</th>
							<th width="25%">NOMOR PEMBUKUAN</th>
							<th width="25%">SUMBSER ANGGARAN</th>
							<?php if($kota == "KABUPATEN BANDUNG"){ ?>
							<th width="20%">STATUS ANGGARAN</th>
							<?php } ?>							
							<th width="15%" colspan="2">#</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 16px; font-weight: bold;">
							<td align="center"><?php echo $datapenerimaan['TanggalPenerimaan']?></td>
							<td align="center"><?php echo $datapenerimaan['NomorPembukuan']?></td>
							<td align="center"><?php echo $datapenerimaan['SumberAnggaran']." - ".$datapenerimaan['TahunAnggaran']?></td>
							<?php if($kota == "KABUPATEN BANDUNG"){ ?>
							<td align="center"><?php echo $datapenerimaan['StatusAnggaran']?></td>
							<?php } ?>
							<td align="center"><a href="?page=gudang_besar_penerimaan_edit&id=<?php echo $datapenerimaan['IdPenerimaan']?>" class="btninfo" style="margin-right:5px">EDIT</a></td>
							<td align="center"><a href="javascript:print()" class="btnsimpan" style="margin-right:5px">PRINT</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php
		if($_GET['stsvalidasi'] != ''){
			echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
			// die();
		}
	?>
</div>
<?php
	// untuk mengambil total
	$totals = 0;
	$str = "SELECT * FROM `tbgfkpenerimaandetail` WHERE `NomorPembukuan` = '$id'";
	$query = mysqli_query($koneksi, $str);				
	while($data=mysqli_fetch_assoc($query)){
		$jumlah = $data['Jumlah'] * $data['Harga'];
		$totals = $jumlah + $totals;
	}
	$jmlbrg = mysqli_num_rows(mysqli_query($koneksi, $str));
?>	

<body>
<div class="tableborderdiv noprint">	
	<div class="row">
		<div class="col-sm-12">
			<div class="formbg" style="margin-top: -20px;">
				<div class="table-responsive">
					<form action="?page=gudang_besar_penerimaan_lihat_proses" method="post">	
						<input type="hidden" value="<?php echo $datapenerimaan['TanggalPenerimaan']?>" name="tglpenerimaan">
						<div class="table-responsive">
							<table class="table-judul">
								<tr>
									<td class="col-sm-2">Nama Barang (LPLPO)</td>
									<td>
										<div class="row">
											<div class="col-sm-12">
												<input type="text" name="namabarang" class="form-control nama_barang_lplpo" placeholder="Ketikan Nama Barang" required>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Kode - Satuan</td>
									<td>
										<div class="row">
											<div class="col-sm-6">
												<input type="text" name="kodebarang" class="form-control kodeobat" readonly>
											</div>
											<div class="col-sm-6">
												<input type="text" name="satuan" class="form-control satuanobat" readonly>
											</div>
										</div>
									</td>
								</tr>
								<?php if($kota == "KABUPATEN BANDUNG"){ ?>
								<tr>
									<td class="col-sm-2">Nama Tambahan</td>
									<td>
										<div class="row">
											<div class="col-sm-12">
												<input type="text" name="namatambahan" class="form-control" placeholder="-" required>
											</div>
										</div>
									</td>
								</tr>
								<?php
									}
								?>
								<tr>
									<td>Program</td>
									<td>
										<!--<div class="row">
											<div class="col-sm-12">
												<select name="namaprogram" class="form-control namaprogramobat" required>
													<?php
														// $query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` ORDER BY `nama_program`");
														// while($data = mysqli_fetch_assoc($query)){
															// echo "<option value='$data[nama_program]'>$data[nama_program]</option>";
														// }
													?>
												</select>
											</div>
										<div>-->
										<input type="text" name="namaprogram" class="form-control namaprogramobat" readonly>
									</td>
								</tr>
								<tr>
									<td>Batch - Barcode - Expire</td>
									<td>
										<div class="row">
											<div class="col-sm-6">
												<input type="text" name="nobatch" class="form-control jarak" maxlength = "200" placeholder="Batch" required>
											</div>
											<div class="col-sm-3">
												<input type="text" name="barcode" class="form-control jarak" maxlength = "200" placeholder="Barcode" required>
											</div>
											<div class="col-sm-3">
												<div class="input-group jarak">
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
										<input type="text" name="hargabeli" class="form-control hargabeli" maxlength = "10" placeholder="Maks. 10 digit" required>
									</td>
								</tr>
								<tr>
									<td>Jumlah Penerimaan</td>
									<td>
										<input type="text" name="jumlah" class="form-control" maxlength = "10" placeholder="Maks. 10 digit" required>
									</td>
								</tr>									
							</table><hr>
						</div>
						<input type="hidden" class="form-control" name="nomorpembukuan" value="<?php echo $datapenerimaan['NomorPembukuan']?>">
						<input type="hidden" class="form-control" name="sumberanggaran" value="<?php echo $datapenerimaan['SumberAnggaran']?>">
						<input type="hidden" class="form-control" name="tahunanggaran" value="<?php echo $datapenerimaan['TahunAnggaran']?>">
						<input type="hidden" class="form-control" name="statusanggaran" value="<?php echo $datapenerimaan['StatusAnggaran']?>">
						<input type="hidden" class="form-control" name="totallama" value="<?php echo $totals;?>">
						<!--variabel input-->
						<input type="hidden" name="idindikator" class="form-control idindikatorobat" readonly>
						<input type="hidden" name="idketersediaan" class="form-control idketersediaanobat" readonly>
						<input type="hidden" name="produsen" value="<?php echo $datapenerimaan['KodeSupplier']?>" readonly>
						<input type="hidden" name="isikemasan" class="form-control isikemasanobat" readonly>
						<input type="hidden" name="kemasan" class="form-control kemasanobat" readonly>
						<input type="hidden" name="golonganfungsi" class="form-control golonganfungsiobat" readonly>
						<input type="hidden" name="jenisbarang" class="form-control jenisbarangobat" readonly>
						<input type="hidden" name="minimalstok" class="form-control minimalstokobat" readonly>	
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b><?php echo $jmlbrg." DATA BARANG, Rp. ".number_format($totals,2,",",".");?></b></h3>
			<table class="table-judul-laporan">
				<thead>
					<tr class="head-table-gudang-besar-penerimaan">
						<th width="3%">NO.</th>
						<th width="5%">KODE</th>
						<th width="25%">NAMA BARANG</th>
						<th width="5%">SATUAN</th>
						<th width="7%">BATCH</th>
						<th width="8%">EXPIRE</th>
						<th width="10%">SUMBER</th>
						<th width="7%">HARGA SAT</th>
						<th width="7%">JML</th>
						<th width="10%">TOTAL</th>
						<th width="5%">AKSI</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$str ="SELECT * FROM `tbgfkpenerimaandetail` WHERE `NomorPembukuan` = '$id' ORDER BY IdPenerimaan DESC";
					$query = mysqli_query($koneksi,$str);
					while($datapenerimaan = mysqli_fetch_assoc($query)){
						$no = $no + 1;
				?>
					<tr data-kode="<?php echo $datapenerimaan['KodeBarang'];?>" data-batch="<?php echo $datapenerimaan['NoBatch'];?>" data-nofaktur="<?php echo $datapenerimaan['NomorPembukuan'];?>" data-idbarang="<?php echo $datapenerimaan['IdPenerimaan'];?>">
						<?php
						$kodebarang = $datapenerimaan['KodeBarang'];
						$nobatch = $datapenerimaan['NoBatch'];
						$databarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang'"));
						$total = $datapenerimaan['Jumlah'] * $datapenerimaan['Harga'];
						?>
						<td align="center"><?php echo $no;?></td>
						<td align="center" class="kode-edit"><?php echo $datapenerimaan['KodeBarang'];?></td>
						<td align="left">
							<?php 
								echo strtoupper($databarang['NamaBarang'])."<br/>";								
								if($databarang['NamaTambahan'] != "-"){
							?>
								<span style='font-size: 10px; font-style: italic'><?php echo $databarang['NamaTambahan'];?></span>
							<?php } ?>
						</td>
						<td align="center"><?php echo $databarang['Satuan'];?></td>
						<td align="center" class="nobatch-edit"><?php echo $datapenerimaan['NoBatch'];?></td>
						<td align="center"><?php echo $datapenerimaan['Expire'];?></td>
						<td align="center"><?php echo $datapenerimaan['SumberAnggaran'];?></td>
						<td align="right" class="harga-edit"><?php echo number_format("$datapenerimaan[Harga]",8,",",".");?></td>
						<td align="right" class="stok-edit"><?php echo rupiah($datapenerimaan['Jumlah']);?></td>
						<td align="right" class="hargatotals" style="color:red;font-weight:bold"><?php echo number_format($total,2,",",".");?></td>
						<?php
							// cek jika barang sudah didistribusikan tidak bisa dihapus
							$cekdistribusi = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$databarang[NoFakturTerima]'"));
							if($cekdistribusi == 0){
						?>
						<td style="text-align:center; vertical-align:middle; padding:5px;"><a href="?page=gudang_besar_penerimaan_lihat_hapus&id=<?php echo $datapenerimaan['IdPenerimaan'];?>&ko=<?php echo $datapenerimaan['KodeBarang'];?>&nb=<?php echo $datapenerimaan['NoBatch'];?>&nf=<?php echo $id;?>&ttl=<?php echo $total;?>&grand=<?php echo $totals;?>" class="btn btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin dihapus...?')">Hapus</a></td>
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
</body>

<!--tabel report-->
<?php
	$dtterima = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$id'"));
?>


<?php if($kota == "KABUPATEN BOGOR"){ ?>	
	<img src="image/bogorkab.png" class="imglogo">
<?php }elseif($kota == "KABUPATEN BEKASI"){ ?>	
	<img src="image/bekasikab.png" class="imglogo2" style="width: 100px; height: 100px;">
<?php }else{ ?>
	<img src="image/bandungkab.png" class="imglogo" style="width: 100px; height: 100px;">
<?php } ?>

<?php if($kota == "KABUPATEN BEKASI"){ ?>	
	<div class="printheader">
		<span style="font-size: 18px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>		
		<span style="font-size: 24px;"><b>UPTD FARMASI</b></span><br/>
		<p style="font-size: 12px; margin:1px;">
			<?php echo substr($alamat,0,62);?><br/>
			Kabupaten Bekasi, 17510 Jawa Barat<br/>
			<b>e-mail : laporangudangtambun@gmail.com Telp.</b><?php echo $telepon?>
		</p>
		<hr style="margin:3px; border:1px solid #000">
		<p class="font16" style="margin:10px 5px 5px 5px; font-family: Poppins;"><b>LAPORAN PENERIMAAN BARANG</b></p><br>
	</div>
<?php }else{ ?>
	<div class="printheader">
		<span style="font-size: 18px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>
		<span style="font-size: 24px;"><b>GUDANG FARMASI KABUPATEN</b></span><br/>
		<p style="font-size: 12px; margin:1px; font-family: 'Poppins', sans-serif;"><?php echo $alamat;?><br/>
			<b>https://siokebogorkab.id/</b>
		</p>
		<hr style="margin:3px; border:1px solid #000">
		<p class="font16" style="margin:10px 5px 5px 5px; font-family: Poppins;"><b>LAPORAN PENERIMAAN BARANG</b></p><br>
	</div>
<?php } ?>

<div class="atastabel" style="margin-top: -20px;">
	<div style="float:left; width:75%;">
		<table style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">No.Pembukuan </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $_GET['id'];?></td>
			</tr>
			<tr>
				<?php
					$idsupplier = $dtterima['KodeSupplier'];
					$datasupplier = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `ref_pabrik` WHERE `id`='$idsupplier'"));
				?>
				<td style="padding:2px 4px;">Supplier </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datasupplier['nama_prod_obat'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Sumber Anggaran </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $dtterima['SumberAnggaran']." - ".$dtterima['TahunAnggaran'];?></td>
			</tr>
		</table>
	</div>
</div>

<div class="printbody">
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed" style="margin-top: 10px;" width="100%">
				<thead style="font-size:10px;">
					<tr style="border:1px solid #000;">
						<th width="4%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th width="25%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NoBatch</th>
						<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jml</th>
						<th width="13%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga Sat.</th>
						<th width="17%" rowspan="2" style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">Total Harga</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$total = 0;
					$no = 0;
					$str2 = "SELECT * FROM `tbgfkpenerimaandetail` WHERE `NomorPembukuan` = '$id' ORDER BY IdPenerimaan DESC";
					$query2 = mysqli_query($koneksi,$str2);
					while($datapenerimaan2 = mysqli_fetch_assoc($query2)){
						$no = $no + 1;						
						$kodebarang = $datapenerimaan2['KodeBarang'];
						$nobatch = $datapenerimaan2['NoBatch'];
						$databarang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
						$jumlah = $datapenerimaan2['Harga'] * $datapenerimaan2['Jumlah'];
						$total = $jumlah + $total;
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; padding:3px; border:1px solid #000;"><?php echo $no.".";?></td>
							<td style="text-align:left; padding:3px; border:1px solid #000;"><?php echo $databarang['NamaBarang'];?></td>
							<td style="text-align:center; padding:3px; border:1px solid #000;"><?php echo $databarang['Satuan'];?></td>
							<td style="text-align:center; padding:3px; border:1px solid #000;"><?php echo tgl_singkat($datapenerimaan2['Expire']);?></td>
							<td style="text-align:center; padding:3px; border:1px solid #000;"><?php echo $datapenerimaan2['NoBatch'];?></td>
							<td style="text-align:right; padding:3px; border:1px solid #000;"><?php echo rupiah($datapenerimaan2['Jumlah']);?></td>
							<td style="text-align:right; padding:3px; border:1px solid #000;"><?php echo "Rp. ".number_format($datapenerimaan2['Harga'],2,",",".");?></td>
							<td style="text-align:right; padding:3px; border:1px solid #000;"><?php echo "Rp. ".number_format($jumlah,2,",",".");?></td>
						</tr>
					<?php
					}
					?>
						<tr style="border:1px solid #000; padding:3px; font-weight: bold;">
							<td colspan="7" style="text-align:center; padding:3px; border:1px solid #000;">TOTAL</td>
							<td style="text-align:right; padding:3px; border:1px solid #000;"><?php echo "Rp. ".number_format($total,2,",",".");?></td>
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
					<td width="10%"></td>
					<td style="text-align:center;">
					<p>Mengetahui,<br/>
					<?php
						if($kota == "KABUPATEN BOGOR"){
					?>	
						Sub. Koor,
					<?php
						}else{
					?>
						Ka. UPTD Farmasi,
					<?php
						}
					?>					
					<br>
					<br>
					<br>
					<br>
					<b><u><?php echo $dt_penerima['nama_kasie'];?></u></b><br/>
					<?php echo "NIP. ".$dt_penerima['nip_kasie'];?></p>
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
						<p>
						<?php 
							echo $kota.", ".date('d-m-Y', strtotime($dtterima['TanggalPenerimaan']));?><br/>
							Yang Menerima,
							<br>
							<br>
							<br>
							<br>
							<b><u><?php echo $dt_penerima['nama_pemberi'];?></u></b><br/>
						<?php echo "NIP. ".$dt_penerima['nip_pemberi'];?>
						</p>
					</td>
				</tr>
			</table>
			<?php				
				$datapenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$id'"));
				if($datapenerimaan['ImageDok'] != ""){
			?>
				<p style="margin-top: 20px;font-size: 15px; text-align:center;">Dokumentasi Penerimaan Barang</p>
				<img src="image/dokumen_penerimaan_gudangbesar/<?php echo $datapenerimaan['ImageDok'];?>" class="imgpenerimaan">
				
			<?php 
				}
			?>
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
		$.post( "gudang_besar_penerimaan_edit_jquery.php", {
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

$(".stok-edit").dblclick(function(){
	var isi = $(this).html();
	var kode = $(this).parent().data('kode');
	var batch = $(this).parent().data('batch');
	var nofaktur = $(this).parent().data('nofaktur');
	var idbarang = $(this).parent().data('idbarang');
	var stokisi = isi.replace(/[.]/g, "");
	var harga = $(this).parent().find('.harga-edit').html();
	var harganilai = harga.replace(/[.]/g, "");
	
	$(this).html("<input type='text' value='"+stokisi+"' class='stok-input inputedit'>");
	var lokasi = $(this).parent();
	$(".stok-input").focusout(function(){
		var isibaru = $(this).val();
		$(this).parent().html(addCommas(isibaru));
		
		var totals = parseInt(harganilai) * parseInt(isibaru);
		lokasi.find(".hargatotals").html(addCommas(Math.round(totals)));
		$.post( "gudang_besar_penerimaan_edit_jumlah_jquery.php", {
		kode: kode,
		batch: batch,
		nofaktur: nofaktur,
		idbarang: idbarang,
		type: 'Jumlah',//nama kolom table
		value: isibaru //isinya
		}).done(function( data ) {
			alert('Data berhasil diedit..');
			//alert(data);
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
		$.post( "gudang_besar_penerimaan_edit_updategrandtotal_jquery.php", {
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
