<?php
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$nf = $_GET['id'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$datapengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmpengadaan` WHERE `NoFaktur`='$nf'"));
	$dtprodusen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$datapengadaan[KodeSupplier]'"));
?>

<div class="tableborderdiv noprint">
	<div class="row noprint">
		<div class="col-lg-12">
			<a href="index.php?page=apotik_gudang_pengadaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul mt-2"><b>DETAIL PENGADAAN</b></h3>
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr class="head-table-gudang-besar-penerimaan">
							<th width="15%">TGL.PENGADAAN</th>
							<th width="15%">NO.FAKTUR</th>
							<th width="15%">SUMBER ANGGARAN</th>
							<th width="5%">TAHUN</th>
							<th width="30%">PRODUSEN</th>
							<th>AKSI</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center"><?php echo $datapengadaan['TanggalPengadaan'];?></td>
							<td align="center"><?php echo $datapengadaan['NoFaktur'];?></td>
							<td align="center"><?php echo $datapengadaan['SumberAnggaran'];?></td>
							<td align="center"><?php echo $datapengadaan['TahunAnggaran'];?></td>
							<td align="center"><?php echo $dtprodusen['nama_prod_obat'];?></td>
							<td align="center">
								<a href="javascript:print()" class="btn btn-round btn-info" style="font-size: 16px;">PRINT FAKTUR</a>
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
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Maaf, Nama Obat tidak terdaftar di Database...</div>
	<?php
	}elseif ($_GET['sts'] == 2){
	?>
	<div class="alert alert-danger"><i class="ace-icon fa fa-exclamation"></i> Data gagal disimpan, Nama Obat sudah diinputkan pada faktur ini...</div>
	<?php
	}
	?>

<div class="row noprint">
	<div class="col-lg-12">
		<div class="formbg">
			<div class="table-responsive">
				<form action="?page=apotik_gudang_pengadaan_lihat_proses" method="post">
					<table class="table-judul" width="100%">
						<tr>
							<td width="20%">Nama Barang</td>
							<td width="80%">
								<div class="row">
									<div class="col-sm-9">
										<input type="text" name="namabarang" class="form-control nama_barang_gudang_puskesmas_pengadaan" placeholder="Ketikan Nama Barang, jika tidak ada hubungi petugas IFK Dinkes" required>
									</div>
									<div class="col-sm-3">
										<input type="text" name="kodebarang" class="form-control kodebarang" readonly>
									</div>
								</div>
								<input type="hidden" class="form-control namabarang">
							</td>
						</tr>
						<tr>
							<td>Satuan</td>
							<td>
								<input type="text" name="satuanbrg" class="form-control satuan">
								<!--<select name="satuanbrg" class="form-control chosenselect">
									<option value="KOTAK">KOTAK</option>
									<?php
									// $query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
										// while($data = mysqli_fetch_assoc($query)){
											// echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
										// }
									?>
								</select>-->
							</td>
						</tr>
						<tr>
							<td>Nomor Batch</td>
							<td>
								<input type="text" name="nobatch" class="form-control" placeholder="Batch" required>
							</td>
						</tr>
						<tr>
							<td>Expire</td>
							<td>
								<div class="input-group">
									<span class="input-group-addon tesdate">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" name="expire" class="form-control datepicker" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Harga Satuan</td>
							<td>
								<input type="text" name="hargasatuan" class="form-control" placeholder="Harga" required>
							</td>
						</tr>
						<tr>
							<td>Jumlah</td>
							<td>
								<input type="number" name="jumlah" class="form-control jumlah" placeholder="Jumlah" maxlength="10" required>
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengadaan['NoFaktur']?>">
					<input type="hidden" value="<?php echo $datapengadaan['TanggalPenerimaan']?>" name="tglpenerimaan">
					<input type="hidden" name="sumberanggaran" class="form-control" value="<?php echo $datapengadaan['SumberAnggaran'];?>">
					<input type="hidden" name="tahunanggaran" class="form-control" value="<?php echo $datapengadaan['TahunAnggaran'];?>">
					<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>						
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
					<?php }?>
				</form>				
			</div>
		</div>
	</div>
</div>

<div class = "row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table-judul-laporan" width="100%">
				<thead>
					<tr class="head-table-gudang-besar-penerimaan">
						<th width="4%">NO.</th>
						<th width="6%">KODE</th>
						<th width="25%">NAMA BARANG</th>
						<th width="15%">BATCH</th>
						<th width="10%">EXPIRE</th>
						<th width="10%">HARGA</th>
						<th width="10%">JML</th>
						<th width="10%">NILAI PEROLEHAN</th>
						<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
						<th width="10%">#</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 50;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					// if($kota == "KABUPATEN GARUT"){
						// $str ="SELECT * FROM `tbgudangpkmpengadaandetail` a
						// JOIN `ref_obat_lplpo` b ON a.KodeBarang = b.KodeBarang
						// WHERE a.`NoFaktur`='$nf'";
						// $str2 = $str." ORDER BY `NamaBarang` LIMIT $mulai,$jumlah_perpage";
					// }else{
						$str ="SELECT * FROM `tbgudangpkmpengadaandetail` a
						JOIN `ref_obat_jkn` b ON a.KodeBarang = b.KodeObatJkn
						WHERE a.`NoFaktur`='$nf'";
						// echo $str;
						$str2 = $str." ORDER BY `NamaObatJkn` LIMIT $mulai,$jumlah_perpage";
					// }	
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
						
					$query = mysqli_query($koneksi,$str2);
					while($datapengadaan = mysqli_fetch_assoc($query)){
						$no = $no + 1;
														
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $datapengadaan['KodeBarang'];?></td>
							<td class="nama">
							<?php
								// if($kota == "KABUPATEN GARUT"){
									// echo strtoupper($datapengadaan['NamaBarang']);
								// }else{
									echo strtoupper($datapengadaan['NamaObatJkn']);
								// }			
							?>
							</td>
							<td align="center"><?php echo $datapengadaan['NoBatch'];?></td>
							<td align="center"><?php echo $datapengadaan['Expire'];?></td>
							<td align="right"><?php echo number_format($datapengadaan['HargaBeli'],3,",",".");?></td>
							<td align="right"><?php echo rupiah($datapengadaan['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($datapengadaan['Jumlah'] * $datapengadaan['HargaBeli']);?></td>
							<?php 
							// cek jika barang sudah pernah dikeluarkan
							$cekfaktur = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoFaktur` FROM `tbgudangpkmpengeluarandetail` WHERE `KodeBarang`='$datapengadaan[KodeBarang]' AND `NoBatch`='$datapengadaan[NoBatch]' AND SUBSTRING(NoFaktur,1,11) = '$kodepuskesmas' ORDER BY Id DESC"));
							$cekbrg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmpengeluarandetail` WHERE `KodeBarang`='$datapengadaan[KodeBarang]' AND `NoBatch`='$datapengadaan[NoBatch]' AND SUBSTRING(NoFaktur,1,11) = '$kodepuskesmas'"));
							if($cekbrg > 0){
							?>
								<td align="center">
									<?php echo substr($cekfaktur['NoFaktur'], -10);?>
								</td>
							<?php  }else{ ?>	
								<td align="center">
									<a href="?page=apotik_gudang_pengadaan_lihat_delete&kodebarang=<?php echo $datapengadaan['KodeBarang']?>&nobatch=<?php echo $datapengadaan['NoBatch']?>&nofaktur=<?php echo $nf;?>&exp=<?php echo $data_gop['Expire'];?>" class="btn btn-xs btn-danger" onClick="return confirm('Anda yakin data ingin dihapus...?')">HAPUS</a>
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
		</div><hr/>
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
							echo "<li><a href='?page=apotik_gudang_pengadaan_lihat&id=$nf&h=$i'>$i</a></li>";
						}
					}
				}
			?>	
		</ul> 
	</div>
</div>

<div class="row noprint">
	<div class="col-lg-12">
		<div class="alert alert-block alert-success fade in">
			<p><b>Perhatikan :</b><br/>
			Jika pencarian nama barang tidak ditemukan silahkan hubungi admin Instalasi Farmasi untuk menambahkan data<br/>
			Jika barang sudah dikeluarkan dari gudang obat puskesmas, maka barang tidak dapat di Hapus</p>	
		</div>
	</div>
</div>

<!--tabel report-->
<div class="printheader">
	<span class="font14" style="margin:5px; font-weight:bold;"><?php echo "DINAS KESEHATAN ".$kota;?></span><br>
	<span class="font14" style="margin:5px; font-weight:bold;"><?php echo "PUSKESMAS ".$namapuskesmas;?></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat?></span><br>
	<hr style="margin:3px; border:1.5px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px; font-weight:bold;">LAPORAN PENGADAAN BARANG</span><br>
	<span class="font11" style="margin:1px;">No Faktur: <?php echo $nf;?></span><br>
</div>

<?php  
	$datapengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmpengadaan` WHERE `NoFaktur`='$nf'"));
?>
<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Supplier</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $dtprodusen['SuplierName'];?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Sumber Anggaran </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datapengadaan['SumberAnggaran'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Tahun Anggaran </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datapengadaan['TahunAnggaran'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Tgl.Pengadaan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo date('d-m-Y', strtotime($datapengadaan['TanggalPengadaan']));?></td>
			</tr>
		</table>
	</div>	
</div>

<div class="printbody">
	<table class="table-judul-laporan" width="100%">
		<thead>
			<tr style="border:1px solid #000;">
				<th width="5%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
				<th width="45%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
				<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">EXPIRE</th>
				<th width="20%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.BATCH</th>
				<th width="20%" colspan="3" style="text-align:center;border:1px solid #000; padding:3px;">PENGADAAN</th>
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
			
			// if($kota == "KABUPATEN GARUT"){
				// $str_print ="SELECT * FROM `tbgudangpkmpengadaandetail` a
				// JOIN `ref_obat_lplpo` b ON a.KodeBarang = b.KodeBarang
				// WHERE a.`NoFaktur`='$nf'";
			// }else{
				$str_print ="SELECT * FROM `tbgudangpkmpengadaandetail` a
				JOIN `ref_obat_jkn` b ON a.KodeBarang = b.KodeObatJkn
				WHERE a.`NoFaktur`='$nf'";
			// }
			// echo $str_print;
			$str2_print = $str_print." ORDER BY `NamaObatJkn`";
			$query_print = mysqli_query($koneksi,$str2_print);			
			
			while($datapengadaan_print = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;
				$kodebarang = $datapengadaan_print['KodeBarang'];
				$total = $datapengadaan_print['Jumlah'] * $datapengadaan_print['HargaBeli'];
				$total_keseluruhan = $total_keseluruhan + $total;
				
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no.".";?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $datapengadaan_print['NamaObatJkn'];?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo tgl_singkat($datapengadaan_print['Expire']);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $datapengadaan_print['NoBatch'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($datapengadaan_print['Jumlah']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($datapengadaan_print['HargaBeli']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($total);?></td>
				</tr>
			<?php
			}
			?>
				<tr style="border:1px solid #000; padding:3px;">
					<td colspan="6" style="text-align:center; padding:3px; font-weight:bold; font-size:14px;">Total Keseluruhan (Rp)</td>
					<td style="text-align:right; padding:3px; font-weight:bold; font-size:14px;"><?php echo rupiah($total_keseluruhan);?></td>
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