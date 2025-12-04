<?php
	include "config/helper_report.php";
	$id = $_GET['id'];
	$key = $_GET['key'];
	$tahun = $_GET['tahun'];
	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	include "config/helper_dashkesehatan.php";

	//get apikey 
	$qryapikey = mysqli_query($koneksi,"select Username, Password FROM tbapikey WHERE Kodepuskesmas = '$kodepuskesmas'");
	$dtapikey = mysqli_fetch_assoc($qryapikey);

	$usernameapi = $dtapikey['Username'];
	$passwordapi = $dtapikey['Password'];
	$get_token_dashkesehatan = get_token_dashkesehatan($usernameapi,$passwordapi);
	$get_data_pengeluaran_dinkes_detail = get_data_pengeluaran_obat_dinkes_detail($usernameapi,$get_token_dashkesehatan,$id);

	$getdtjson = json_decode($get_data_pengeluaran_dinkes_detail,true);
	$dtjson = $getdtjson['metadata'];
	$dtjson_list = $dtjson['list']['List'];
	$dtjson_data = $dtjson['data'];
	

?>	

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-lg-12">
			<a href="index.php?page=apotik_gudang_penerimaan&key=<?php echo $key;?>&tahun=<?php echo $tahun;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DETAIL PENERIMAAN </b><small>Gudang Obat Puskesmas</small></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="20%">TANGGAL</th>
							<th width="30%">NOMOR FAKTUR</th>
							<th width="30%">PENERMA</th>
							<th width="20%">OPSI</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo date('d-m-Y', strtotime($dtjson_data['TanggalPengeluaran']))?></td>
							<td align="center"><?php echo $id?></td>
							<td align="center"><?php echo $namapuskesmas;?></td>
							<td align="center"><a href="javascript:print()" class="btn btn-round btn-success btnsimpan">PRINT</a></td>
						</tr>
					</tbody>
				</table><br/>
			</div>
		</div>
	</div>
	


	<div class="formbg">		
		<div class = "row">
			<div class="col-sm-12 table-responsive">
				<form action="apotik_gudang_penerimaan_lihat_proses.php" method="post">
					<h3 class="judul"><b><?php echo 'Item Barang '.$jml_brg['jml'].", ";?> Grand Total Rp. <?php echo rupiah($total);?></b></h3>
					<div class = "row">
						<input type="hidden" value="<?php echo $kodepuskesmas;?>" name="kodepuskesmas">
						<input type="hidden" value="<?php echo $id;?>" name="faktur">
						<table id="datatabless" class="table-judul-form" width="100%">
							<thead>
								<tr>
									<th width="4%">NO.</th>
									<th width="6%">KODE</th>
									<th width="20%">NAMA BARANG</th>
									<th width="8%">SATUAN</th>
									<th width="8%">BARCH</th>
									<th width="8%">EXPIRE</th>
									<th width="6%">HARGA</th>
									<th width="8%">JML</th>
									<th width="8%">VALIDASI</th>
									<th width="6%">CHCECKLIST</th>
								</tr>
							</thead>
							<tbody>
								<?php
									
									foreach($dtjson_list as $datapenerimaan){
										$no = $no + 1;
										$nofaktur = $datapenerimaan['NoFaktur'];
										$kodebarang = $datapenerimaan['KodeBarang'];
										$namabarang = $datapenerimaan['NamaBarang'];
										$nobatch = $datapenerimaan['NoBatch'];
										$harga = $datapenerimaan['HargaBeli'];
										$satuan = $datapenerimaan['Satuan'];
										$expire = $datapenerimaan['Expire'];
										$idprogram = $datapenerimaan['IdProgram'];
										$namaprogram = $datapenerimaan['NamaProgram'];
										$jumlah = $datapenerimaan['Jumlah'];
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
											<input type="hidden" value="<?php echo $jumlah;?>" name="jumlah[<?php echo $no;?>]">
											<input type="hidden" value="<?php echo $namabarang;?>" name="namabarang[<?php echo $no;?>]">
											<input type="hidden" value="<?php echo $idprogram;?>" name="idprogram[<?php echo $no;?>]">
											<input type="hidden" value="<?php echo $namaprogram;?>" name="namaprogram[<?php echo $no;?>]">
											<input type="hidden" value="<?php echo $expire;?>" name="expire[<?php echo $no;?>]">
											<input type="hidden" value="<?php echo $nobatch;?>" name="nobatch[<?php echo $no;?>]">
											<input type="hidden" value="<?php echo $harga;?>" name="harga[<?php echo $no;?>]">
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
							<input type="hidden" value="<?php echo $key;?>" name="key">
							<input type="hidden" value="<?php echo $tahun;?>" name="tahun">
							<input type="submit" value="APPROVE" onClick="return confirm('Anda yakin data ingin diapprove...?')" class="btn btn-round btn-success btnsimpan mt-4">
						<?php } ?>
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
	<?php if($namapuskesmas != "KLINIK DINAS"){ ?>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<?php } ?>
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
			$no = 0;
			$total = 0;
			foreach($dtjson_list as $datapenerimaan2){
				$no = $no + 1;
				$nofaktur = $datapenerimaan2['NoFaktur'];
				$kodebarang = $datapenerimaan2['KodeBarang'];
				$namabarang = $datapenerimaan2['NamaBarang'];
				$nobatch = $datapenerimaan2['NoBatch'];
				$harga = $datapenerimaan2['HargaBeli'];
				$satuan = $datapenerimaan2['Satuan'];
				$expire = $datapenerimaan2['Expire'];
				$idprogram = $datapenerimaan2['IdProgram'];
				$namaprogram = $datapenerimaan2['NamaProgram'];
				$jumlah = $datapenerimaan2['Jumlah'] * $datapenerimaan2['HargaBeli'];
				$total = $total + $jumlah;			
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no;?></td>
					<td style="text-align:Left; padding:3px;border:1px solid #000;"><?php echo $namabarang;?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $expire;?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo str_replace(",", ", ", $nobatch);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $datapenerimaan2['SumberAnggaran']." ".$datapenerimaan2['TahunAnggaran'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($datapenerimaan2['Jumlah']);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $satuan;?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($harga);?></td>
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