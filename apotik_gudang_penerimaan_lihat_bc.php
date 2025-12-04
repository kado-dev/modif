<?php
	include "config/helper_report.php";
	$id = $_GET['id'];
	$datapenerimaan2=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$id'"));
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=apotik_gudang_penerimaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DETAIL PENERIMAAN </b><small>Gudang Obat Puskesmas</small></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="20%">Tgl.Penerimaan</th>
							<th width="30%">No.Faktur</th>
							<th width="30%">Puskesmas</th>
							<th width="20%">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo $datapenerimaan2['TanggalPengeluaran']?></td>
							<td align="center"><?php echo $datapenerimaan2['NoFaktur']?></td>
							<td align="center"><?php echo $namapuskesmas;?></td>
							<td align="center"><a href="javascript:print()" class="btnsimpan">Print</a></td>
						</tr>
					</tbody>
				</table><br/>
			</div>
		</div>
	</div>
	
	<?php
		$total = 0;
		$jml_brg =mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS jml FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$id'"));
		$str_print ="SELECT * FROM `tbgfkpengeluarandetail` WHERE NoFaktur='$id'";
		// echo $str_print;
		
		$query_print = mysqli_query($koneksi,$str_print);		
		while($data = mysqli_fetch_assoc($query_print)){
			$kdbrg = $data['KodeBarang'];
			$batch = $data['NoBatch'];
						
			// tbgfkstok			
			// $dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
			$Jumlah = $data['Harga'] * $data['Jumlah'];
			$total = $Jumlah + $total;
		}
	?>	
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul"><b><?php echo 'Item Barang '.$jml_brg['jml'].", ";?> Grand Total Rp. <?php echo rupiah($total);?></b></h3>
			<div class="row">
				<form action="index.php?page=apotik_gudang_penerimaan_lihat_proses" method="post">
					<input type="hidden" value="<?php echo $kodepuskesmas;?>" name="kodepuskesmas">
					<input type="hidden" value="<?php echo $id;?>" name="faktur">
					<div class="col-xs-12 col-sm-12">
						<div class="search-area well well-sm">
							<div class="space-6"></div>
							<div class = "row">
								<div class="col-sm-12 table-responsive" style="font-size:12px">
									<table id="datatabless" class="table-judul-form">
										<thead>
											<tr>
												<th width="4%">No.</th>
												<th width="6%">Kode</th>
												<th width="20%">Nama Barang</th>
												<th width="8%">Satuan</th>
												<th width="8%">Batch</th>
												<th width="8%">Expire</th>
												<th width="6%">Harga</th>
												<th width="8%">Jml</th>
												<th width="8%">Validasi</th>
												<th width="6%">Checklist</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$str = "SELECT a.Id, a.IdDistribusi, a.NoFaktur, a.KodeBarang, b.NamaBarang, a.NoBatch, a.NoFakturTerima, b.Satuan, b.Expire, b.SumberAnggaran, b.TahunAnggaran, b.HargaBeli, a.Jumlah, a.StatusValidasi, a.NamaProgram 
												FROM `tbgfkpengeluarandetail` a LEFT JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang 
												WHERE a.NoFaktur = '$id' AND a.NoBatch = b.NoBatch GROUP BY a.Id ORDER BY NamaBarang ";
												$query = mysqli_query($koneksi,$str);
												while($datapenerimaan = mysqli_fetch_assoc($query)){
													$no = $no + 1;
													$nofaktur = $datapenerimaan['NoFaktur'];
													$kodebarang = $datapenerimaan['KodeBarang'];
													$nobatch = $datapenerimaan['NoBatch'];
													$harga = $datapenerimaan['HargaBeli'];
													
													// perlu diperhatikan, ini buat yang jumlah dengan status validasi belum
													$dtjumlah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nofaktur' AND `KodeBarang`='$kodebarang' AND `Nobatch`='$nobatch'  AND `StatusValidasi`='Belum'"));
													
													// tbgfkstok, gak perlu nobatch karena kodebarang sudah sama / seragam menggunakan fornas
													$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
													$dt_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
													
													if(substr($nofaktur,-9) != "IMUNISASI"){
														$namabarang = $dt_gfkstok['NamaBarang'];
														$satuan = $dt_gfkstok['Satuan'];
														$expire = $dt_gfkstok['Expire'];
													}else{
														$namabarang = $dt_vaksin['NamaBarang'];
														$satuan = $dt_vaksin['Satuan'];
														$expire = $dt_vaksin['Expire'];
													}	
											?>
												<tr>
													<td align="center"><?php echo $no;?></td>
													<td align="center"><?php echo $kodebarang;?></td>
													<td align="left"><?php echo $namabarang;?></td>
													<td align="center"><?php echo $satuan;?></td>
													<td align="center"><?php echo str_replace(",", ", ", $nobatch);?></td>
													<td align="center"><?php echo $expire;?></td>
													<td align="right">
														<?php 
															$cx = strpos($harga, ".");
															if($cx > 0){
																echo number_format($harga,2,",",".");
															}else{
																echo rupiah($harga);
															}
														?>
													</td>
													<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($datapenerimaan['Jumlah']);?></td>
													<td align="center"><?php echo $datapenerimaan['StatusValidasi']?></td>
													<td align="center">
														<input type="hidden" name="tglpenerimaan" value="<?php echo date("m_Y",strtotime($datapenerimaan2['TanggalPengeluaran']));?>">
														<input type="hidden" value="<?php echo $kodebarang;?>" name="kodebarangs[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $kodebarang;?>" name="indikator[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $dtjumlah['Jumlah'];?>" name="jumlah[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $namabarang;?>" name="namabarang[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $dt_gfkstok['IdProgram'];?>" name="idprogram[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $dt_gfkstok['NamaProgram'];?>" name="namaprogram[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $expire;?>" name="expire[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $nobatch;?>" name="nobatch[<?php echo $no;?>]">
														<input type="hidden" value="<?php echo $harga;?>" name="hargasatuan[<?php echo $no;?>]">
														<?php
														if($datapenerimaan['StatusValidasi'] != 'Sudah'){
														?>
														<input type="checkbox" name="datas[]" value="<?php echo $no;?>">
														<?php
														}
														?>
													</td>
												</tr>
											<?php
											$arraystatus[] = $datapenerimaan['StatusValidasi'];
											}
											?>
										</tbody>
									</table><br/><br/>
									<?php if(in_array('Belum',$arraystatus)){ ?>
										<input type="submit" value="Approve" onClick="return confirm('Anda yakin data sudah benar dan ingin disimpan...?')" class="btnsimpan">
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		
		
	</div>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
					<p>
						<h5><b>Perhatikan</b></h5> 
						Silahkan cek kembali jumlah per-item obat, apakah jumlahnya sudah sesuai</br>
						Jika sesuai silahkan checklist item obat lalu klik tombol Approve</br>
						Jika tidak sesuai jangan dichecklist, segera hubungi gudang farmasi dinkes.
					</p>
			</div>
		</div>
	</div>
</div>

<!--tabel report-->
<div class="printheader">
	<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br/>
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br/>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat.", Telp.".$telepon.", Fax.".$fax;?></span>
	<hr style="margin:10px 5px 5px 5px; border:1px solid #000">
	<span class="font16" style="margin:50px;"><b>LAPORAN PENERIMAAN BARANG</b></span><br/>
	<span class="font14" style="margin:1px;">No.Pembukuan : <?php echo $_GET['id'];?></span><br/>
</div>		

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo strtoupper($namapuskesmas);?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo strtoupper($kelurahan);?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo strtoupper($kecamatan);?></td>
			</tr>
		</table>
	</div>	
</div>

<div class="printbody font10">
	<table width="100%">
		<thead class="font10">
			<tr style="border:1px solid #000;">
				<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th width="35%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
				<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
				<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NoBatch</th>
				<th width="15%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anggaran</th>
				<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemberian</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th width="8%" style="text-align:center; border:1px solid #000; padding:3px;">Qty</th>
				<th width="10%" style="text-align:center; border:1px solid #000; padding:3px;">Sat</th>
				<th width="10%" style="text-align:center; border:1px solid #000; padding:3px;">Harga</th>
				<th width="10%" style="text-align:center; border:1px solid #000; padding:3px;">Jumlah</th>
			</tr>
		</thead>
		<tbody style="font-size:12,5px;">
			<?php
			$total = 0;
			$no = 0;
			$str_print = "SELECT a.Id, a.IdDistribusi, a.NoFaktur, a.KodeBarang, b.NamaBarang, a.NoBatch, a.NoFakturTerima, b.Satuan, b.Expire, b.SumberAnggaran, b.TahunAnggaran, b.HargaBeli, a.Jumlah, a.StatusValidasi, a.NamaProgram 
						FROM `tbgfkpengeluarandetail` a LEFT JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang 
						WHERE a.NoFaktur = '$id' AND a.NoBatch = b.NoBatch GROUP BY a.Id ORDER BY NamaBarang ";
			// echo $str_print ;
			$query_print = mysqli_query($koneksi,$str_print);			
			while($dataterima = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;
				$kodebarang = $dataterima['KodeBarang'];
				$nobatch = $dataterima['NoBatch'];
				$jumlah = $dataterima['Jumlah'] * $dataterima['HargaBeli'];
				$total = $total + $jumlah;
				
				// tbgfkstok, gak perlu nobartch karena kodebarang sudah sama / seragam menggunakan fornas
				$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
				$dt_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang'"));
				
				if(substr($nofaktur,-9) != "IMUNISASI"){
					$namabarang = $dataterima['NamaBarang'];
					$satuan = $dataterima['Satuan'];
				}else{
					$namabarang = $dt_vaksin['NamaBarang'];
					$satuan = $dt_vaksin['Satuan'];
				}			
														
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no;?></td>
					<td style="text-align:Left; padding:3px;border:1px solid #000;"><?php echo $namabarang;?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dataterima['Expire']?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo str_replace(",", ", ", $dataterima['NoBatch']);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dataterima['SumberAnggaran']." ".$dataterima['TahunAnggaran'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dataterima['Jumlah']);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $satuan;?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dataterima['HargaBeli']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($jumlah);?></td>
				</tr>
			<?php
			}
			?>
				<tr style="border:1px solid #000; padding:3px;">
					<td colspan="8" style="text-align:center; padding:3px; font-weight:bold; font-size:14px; ">TOTAL</td>
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