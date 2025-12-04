<?php
	session_start();
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";	
	$nf = $_GET['id'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$tanggal = date('Y-m-d');
	$tbgudangpkmpenerimaan = "tbgudangpkmpenerimaan_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmpenerimaandetail = "tbgudangpkmpenerimaandetail_".str_replace(' ', '', $namapuskesmas);
	$ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);	
	
	$datapengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmpenerimaan` WHERE `NoFaktur`='$nf'"));
?>

<div class="tableborderdiv noprint">
	<div class="row noprint">
		<div class="col-xs-12">
			<a href="index.php?page=apotik_gudang_penerimaan_mandiri_tarakan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>PENERIMAAN BARANG</b></h3>
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr class="head-table-gudang-besar-penerimaan">
							<th>TGL.PENERIMAAN</th>
							<th>NO.FAKTUR</th>
							<th>KETERANGAN</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center"><?php echo $datapengadaan['TanggalPenerimaan'];?></td>
							<td align="center"><?php echo $datapengadaan['NoFaktur'];?></td>
							<td align="center"><?php echo $datapengadaan['Keterangan'];?></td>
							<td align="center">
								<a href="javascript:print()" class="btn btn-sm btn-info">PRINT</a>
							</td>					
						</tr>
					</tbody>
				</table>
			</div>	
		</div>
	</div><br/>

	<div class="row noprint">
		<div class="col-lg-12">
			<div class="formbg">
				<div class="table-responsive">
					<form action="?page=apotik_gudang_penerimaan_mandiri_lihat_tarakan_proses" method="post">
						<table class="table-judul" width="100%">
							<tr>
								<td width="20%">Nama Barang</td>
								<td width="80%">
									<input type="text" name="namabarang" class="form-control nama_barang_gudang_puskesmas_penerimaan_mandiri" placeholder="Ketikan Nama Barang" required>
									<input type="hidden" name="satuan" class="form-control satuan">
									<input type="hidden" name="kodebarang" class="form-control kodebarang">
									<input type="hidden" class="form-control namabarang">
									<input type="hidden" name="sumberanggaran" class="form-control"
									<input type="hidden" name="tahunanggaran" class="form-control">
								</td>
							</tr>
							<tr>	
								<td>Jumlah Penerimaan</td>
								<td><input type="number" name="jumlah" class="form-control jumlah" placeholder="Jumlah" maxlength="10" required></td>
							</tr>
							<tr>
								<td>Expire</td>
								<td>
									<div class="input-group">
										<span class="input-group-addon tesdate">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" name="expire" class="form-control datepicker">
									</div>
								</td>
							</tr>
							<tr>
								<td>Sumber Anggaran</td>
								<td>
									<select name="sumberanggaran" class="form-control sumberanggaran" required>
										<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
										<option value="APBD PROV">APBD PROV</option>
										<option value="APBN">APBN</option>
										<option value="BLUD">BLUD</option>
										<option value="DAK KAB/KOTA">DAK KAB/KOTA</option>
										<option value="DONASI">DONASI</option>
										<option value="HIBAH">HIBAH</option>
										<option value="LAINNYA">LAINNYA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Tahun Anggaran</td>
								<td>
									<input type="text" name="tahunanggaran" class="form-control" placeholder="Misal : 2022">
								</td>
							</tr>
							<tr>
								<td>Batch</td>
								<td><input type="text" name="nobatch" class="form-control" style="text-transform: uppercase;" placeholder="Batch" required> </td>
							</tr>
							<tr>
								<td>Harga Satuan</td>
								<td><input type="text" name="hargasatuan" class="form-control" placeholder="Harga" required></td>
							</tr>
						</table><br/>
						<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
						<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengadaan['NoFaktur']?>">
						<input type="hidden" value="<?php echo $datapengadaan['TanggalPenerimaan']?>" name="tglpenerimaan">
						<td colspan="2"><input type="submit" value="SIMPAN" class="btnsimpan"></td>
						<?php }?>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr class="head-table-gudang-besar-penerimaan">
							<th width="4%">NO.</th>
							<th width="6%">KODE</th>
							<th width="25%">NAMA BARANG</th>
							<th width="8%">SATUAN</th>
							<th width="8%">BATCH</th>
							<th width="8%">EXPIRE</th>
							<th width="8%">HARGA</th>
							<th width="8%">JML</th>
							<th width="10%">NILAI PENERIMAAN</th>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<th width="5%">#</th>
							<?php }?>
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
						
						$str ="SELECT * FROM `$tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$nf'";
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
							
						$query = mysqli_query($koneksi,$str2);
						while($datapenerimaan = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							
							// ref_obat_lplpo
							$dtlplpo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`Satuan` FROM `$ref_obat_lplpo` WHERE `KodeBarang`='$datapenerimaan[KodeBarang]'"));
						
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $datapenerimaan['KodeBarang'];?></td>
								<td align="left" class="nama"><?php echo strtoupper($dtlplpo['NamaBarang']);?></td>
								<td align="center"><?php echo strtoupper($dtlplpo['Satuan']);?></td>
								<td align="center"><?php echo $datapenerimaan['NoBatch'];?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($datapenerimaan['Expire']));?></td>
								<td align="right"><?php echo rupiah($datapenerimaan['HargaBeli']);?></td>
								<td align="right"><?php echo rupiah($datapenerimaan['JumlahPenerimaan']);?></td>
								<td align="right"><?php echo rupiah($datapenerimaan['HargaBeli'] * $datapenerimaan['JumlahPenerimaan']);?></td>
								<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
								<td align="center">
									<a href="?page=apotik_gudang_penerimaan_mandiri_lihat_hapus&kd=<?php echo $datapenerimaan['KodeBarang']?>&no=<?php echo $nf;?>&bat=<?php echo $datapenerimaan['NoBatch'];?>" class="btn btn-xs btn-danger btnhapus">HAPUS</a>
								</td>
								<?php }?>							
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
								echo "<li><a href='?page=apotik_gudang_pengadaan_lihat&id=$nf&h=$i'>$i</a></li>";
							}
						}
					}
				?>	
			</ul> 
		</div>
	</div>
</div>

<!--tabel report-->
<div class="printheader">
	<span class="font16" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font11" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:10px 5px 10px 5px; border:1px solid #000">
	<span class="font14"><b>LAPORAN PENERIMAAN BARANG GUDANG OBAT PUSKESMAS</b></span><br>
	<br/>
</div>
<div class="atastabel">
	<div style="width:100%; margin-bottom:10px;">	
		<table>
			<tr>
				<td width="45%">No.Faktur</td>
				<td width="5%"> : </td>
				<td width="50%"><?php echo $nf;?></td>
			</tr>
			<tr>
				<td>Tgl.Penerimaan</td>
				<td> : </td>
				<td><?php echo $datapengadaan['TanggalPenerimaan'];?></td>
			</tr>
		</table>
	</div>	
</div>

<div class="printbody">
	<table>
		<thead>
			<tr style="border:1px solid #000;">
				<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th rowspan="2" style="text-align:center;width:38%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
				<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
				<th rowspan="2" style="text-align:center;width:8%;vertical-align:middle; border:1px solid #000; padding:3px;">NoBatch</th>
				<th rowspan="2" style="text-align:center;width:18%;vertical-align:middle; border:1px solid #000; padding:3px;">Sumber Anggaran</th>
				<th colspan="4" style="text-align:center;border:1px solid #000; padding:3px;">Pemberian</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">Qty</th>
				<th style="text-align:center;width:6%; border:1px solid #000; padding:3px;">Satuan</th>
				<th style="text-align:center;width:6%; border:1px solid #000; padding:3px;">Harga</th>
				<th style="text-align:center;width:12%; border:1px solid #000; padding:3px;">Total (Rp)</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			$str2_print ="SELECT * FROM `$tbgudangpkmpenerimaandetail` WHERE `NoFaktur` = '$nf'";
			$query_print = mysqli_query($koneksi,$str2_print);
			
			$total = 0;
			$no = 0;
			while($data = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;			
				$kodebarang = $data['KodeBarang'];
				$data_gop=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$kodebarang'"));
				$jumlah = $data_gop['HargaSatuan'] * $data['Jumlah'];
				$total = $jumlah + $total;
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no.".";?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data_gop['NamaBarang'];?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo tgl_singkat($data_gop['Expire']);?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data['NoBatch'];?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data_gop['SumberAnggaran']." ".$data_gop['TahunAnggaran'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($data['Jumlah']);?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data_gop['Satuan'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($data_gop['HargaSatuan']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($data_gop['HargaSatuan'] * $data['Jumlah']);?></td>
				</tr>
			<?php
			}
			?>
				<tr style="border:1px solid #000; padding:3px;">
					<td colspan="8" style="text-align:center; padding:3px; font-weight:bold; font-size:14px;">Total Keseluruhan (Rp)</td>
					<td style="text-align:right; padding:3px; font-weight:bold; font-size:14px;"><?php echo rupiah($total);?></td>
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
			(..............................)
			</td>
			
			
			<td width="10%"></td>
			<td style="text-align:center;">
			Diserahkan Oleh
			<br>
			<br>
			<br>
			(..............................)
			</td>
		</tr>
	</table>
</div>

<div class="row noprint">
	<div class="col-lg-12">
		<div class="alert alert-block alert-success fade in">
			<p><b>Perhatikan :</b><br/>
			- Jika barang sudah pernah di Distribusikan maka barang tidak dapat dihapus<br/>
			- Jika barang dihapus, maka data Barang pada <b>Stok Gudang Puskesmas</b> akan ikut terhapus.</p>	
		</div>
	</div>
</div>