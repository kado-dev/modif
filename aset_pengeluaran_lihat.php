<?php
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$iddistribusi = $_GET['id'];
	$datapengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbasetpengeluaran` WHERE `IdDistribusi`='$iddistribusi'"));
?>

<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css?=3">

<div class="tableborderdiv noprint">
	<div class="row noprint">
		<div class="col-lg-12">
			<a href="index.php?page=aset_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DETAIL PENGELUARAN</b> <small>(Aset)</small></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr class="head-table-gudang-besar-penerimaan">
							<th width="25%">TGL.PENGELUARAN</th>
							<th width="25%">NO.FAKTUR</th>
							<th width="35%">PENERIMA</th>
							<th width="15%">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center"><?php echo $datapengeluaran['TanggalPengeluaran'];?></td>
							<td align="center"><?php echo $datapengeluaran['NoFaktur'];?></td>
							<td align="center"><?php echo $datapengeluaran['Penerima'];?></td>
							<td align="center">
								<a href="javascript:print()" class="btn btn-info" style="font-size: 16px;">PRINT FAKTUR</a>
							</td>	
						</tr>
					</tbody>
				</table>
			</div>	
		</div>
	</div><br/>
	
	<!--notifikasi-->
	<?php
	if ($_GET['sts'] == 1){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Maaf, Nama Barang tidak terdaftar di Database...</div>
	<?php
	}elseif ($_GET['sts'] == 2){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Data gagal disimpan, Nama Barang sudah diinputkan pada faktur ini...</div>
	<?php
	}
	?>
		<div class="formbg" style="padding: 30px 30px 30px 30px;">
			<div class = "row">
				<div class="col-xs-12">
					<form action="?page=aset_pengeluaran_lihat_proses" method="post">	
						<table class="table-judul" width="100%">
							<tr>
								<td width="20%">Nama Barang</td>
								<td width="80%">
									<div class="row">
										<div class="col-sm-12">
											<input type="text" name="namabarang" class="form-control nama_barang_distribusi_aset" placeholder="Ketikan Nama Barang" required>
										</div>
									</div>
									<input type="hidden" class="form-control namabarang">
									<input type="hidden" name="idbarang" class="form-control idbarang">
								</td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td>
									<input type="text" name="satuan" class="form-control satuan" readonly>
								</td>
							</tr>
							<tr>
								<td>Stok</td>
								<td>
									<input type="text" name="stok" class="form-control stok" readonly>
								</td>
							</tr>
							<tr>
								<td>Jumlah Pengeluaran</td>
								<td>
									<input type="number" name="jumlah" class="form-control jumlah" placeholder="Jumlah" maxlength="10" required>
								</td>
							</tr>
						</table><hr/>
						<input type="hidden" class="form-control" name="id" value="<?php echo $datapengeluaran['IdDistribusi']?>">
						<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
						<input type="hidden" value="<?php echo $datapengeluaran['TanggalPengeluaran']?>" name="tglpenerimaan">					
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>
				</div>
			</div>
		</div>

		<div class = "row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table-judul-laporan" width="100%">
						<thead>
							<tr class="head-table-gudang-besar-penerimaan">
								<th width="3%">NO.</th>
								<th width="52%">NAMA BARANG</th>
								<th width="10%">HARGA</th>
								<th width="10%">JML</th>
								<th width="15%">TOTAL</th>
								<th width="10%">AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$jumlah_perpage = 20;
							
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$str = "SELECT * FROM `tbasetpengeluarandetail` WHERE `NoFaktur`='$datapengeluaran[NoFaktur]'";
							$str2 = $str." ORDER BY `IdDistribusiDetail` DESC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
								
							$query = mysqli_query($koneksi,$str2);
							while($datapengeluaran = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								
								// tbasetstok	
								$dtbarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbasetstok` WHERE `IdBarang`='$datapengeluaran[IdBarang]'"));		
							?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td class="nama"><?php echo strtoupper($dtbarang['NamaBarang']);?></td>
									<td align="right"><?php echo rupiah($dtbarang['HargaSatuan']);?></td>
									<td align="right"><?php echo rupiah($datapengeluaran['Jumlah']);?></td>
									<td align="right"><?php echo rupiah($datapengeluaran['Jumlah'] * $dtbarang['HargaSatuan']);?></td>
									<?php 
									$dtdistribusi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbasetpengadaandetail` WHERE substring(NoFaktur,1,11)='$kodepuskesmas' AND `KodeBarang`='$datapengeluaran[KodeBarang]' AND `NoBatch`='$datapengeluaran[NoBatch]'"));
									if($dtdistribusi == 0){
									?>
										<td align="center">
											<a href="?page=aset_pengeluaran_lihat_delete&id=<?php echo $datapengeluaran['IdDistribusiDetail']?>&idbrg=<?php echo $datapengeluaran['IdBarang']?>&jml=<?php echo $datapengeluaran['Jumlah']?>" class="btn btn-xs btn-danger" onClick="return confirm('Anda yakin data ingin dihapus...?')">Hapus</a>
										</td>
									<?php 
									}else{
									?>	
										<td align="center">
											<?php echo "Distribusi";?>
										</td>
									<?php
										
									}	
									?>							
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<ul class="pagination noprint">
					<?php
						$query2 = mysqli_query($koneksi,$str);
						$jumlah_query = mysqli_num_rows($query2);
						
						if(($jumlah_query % $jumlah_perpage) > 0){
							$jumlah = ($jumlah_query / $jumlah_perpage)+1;
						}else{
							$jumlah = $jumlah_query / $jumlah_perpage;
						}
						for ($i=1;$i<=$jumlah;$i++){
						$max = $_GET['h'] + 5;
						$min = $_GET['h'] - 4;
							if($i <= $max && $i >= $min){
								if($_GET['h'] == $i){
									echo "<li class='active'><span class='current'>$i</span></li>";
								}else{
									echo "<li><a href='?page=aset_pengeluaran_lihat_lihat&id=$iddistribusi&h=$i'>$i</a></li>";
								}
							}
						}
					?>	
				</ul> 
			</div>
		</div>
	</div>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Perhatikan :</b><br/>
				Jika pencarian nama barang tidak ditemukan silahkan hubungi admin Simpus untuk menambahkan master data barang
				</p>	
			</div>
		</div>
	</div>
</div>

<!--tabel report-->
<style>
	.logokab{
		width: 90px;
		height: 70px;
		margin: 20px 50px 0px 50px;
		filter: grayscale(100%);
	}
</style>
<?php
	$datapengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbasetpengeluaran` WHERE `IdDistribusi`='$iddistribusi'"));
?>
<img src="image/bandungkabnew.jpg" class="logokab">	
<div class="printheader" style="margin-top: -65px;">
	<span class="font14" style="margin:5px; font-weight:bold;"><?php echo "DINAS KESEHATAN ".$kota;?></span><br>
	<span class="font18" style="margin:5px; font-weight:bold;"><?php echo "PUSKESMAS ".$namapuskesmas;?></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat?></span><br>
	<hr style="margin:10px; border:1.5px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px; font-weight:bold;">LAPORAN PENGELUARAN BARANG</span><br>
	<span class="font12" style="margin:1px;">No Faktur: <?php echo $datapengeluaran['NoFaktur'];?></span><br>
</div><br/>

<div class="printbody">
	<table class="table-judul-laporan" width="100%">
		<thead>
			<tr style="border:1px solid #000;">
				<th width="5%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
				<th width="65%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
				<th width="30%" colspan="3" style="text-align:center;border:1px solid #000; padding:3px;">PENGELUARAN</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th style="text-align:center; border:1px solid #000; padding:3px;">JUMLAH</th>
				<th style="text-align:center; border:1px solid #000; padding:3px;">HARGA SATUAN</th>
				<th style="text-align:center; border:1px solid #000; padding:3px;">TOTAL (RP.)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0;
			$no = 0;
			
			$str_print = "SELECT * FROM `tbasetpengeluarandetail` WHERE `NoFaktur`='$datapengeluaran[NoFaktur]'";
			$str_print2 = $str_print." ORDER BY `IdDistribusiDetail` DESC";
			$query_print = mysqli_query($koneksi,$str_print2);
			while($datapengeluaran_print = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;
				
				// tbasetstok
				$dtbarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbasetstok` WHERE `IdBarang`='$datapengeluaran_print[IdBarang]'"));
				$total = $datapengeluaran_print['Jumlah'] * $dtbarang['HargaSatuan'];
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no.".";?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo strtoupper($dtbarang['NamaBarang']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($datapengeluaran_print['Jumlah']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dtbarang['HargaSatuan']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($total);?></td>
				</tr>
			<?php
				$total_keseluruhan = $total_keseluruhan + $total;
			}
			?>
				<tr style="border:1px solid #000; padding:3px;">
					<td colspan="4" style="text-align:center; padding:3px; font-weight:bold;">TOTAL KESELURUHAN</td>
					<td style="text-align:right; padding:3px; font-weight:bold;"><?php echo rupiah($total_keseluruhan);?></td>
				</tr>
		</tbody>
	</table>
</div>	

<div class="bawahtabel">
	<table width="100%">
		<tr>
			<td width="10%"></td>
			<td style="text-align:center;">
			Diterima Oleh
			<br>
			<br>
			<br>
			<br>
			(___________________________)
			</td>
			
			
			<td width="10%"></td>
			<td style="text-align:center;">
			Diserahkan Oleh
			<br>
			<br>
			<br>
			<br>
			(___________________________)
			</td>
		</tr>
	</table>
</div>