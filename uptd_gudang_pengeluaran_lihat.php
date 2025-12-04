<?php
	$id = $_GET['id'];
	$kodepuskesmas = $_SESSION['kodepuskesmas']
?>

<style>
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
	
}
.printheader h4{
	font-size:13px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Data Pengeluaran <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<!--menu header-->
<div class="row">	
	<div class="col-lg-12 noprint" style="padding-bottom:10px;">
	<a href="?page=uptd_gudang_pengeluaran" class="btn btn-purple pull-right"><span class="fa fa-arrow-circle-left"></span></a>
	<a href="javascript:print()" class="btn btn-success pull-right" style="margin-right:5px"><span class="fa fa-print noprint"></span> Print</a>
	</div>
</div>

<!--detail faktur-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Faktur</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive" style="font-size:12px">
					<table class="table table-striped table-condensed">
						<tbody>
							<?php
								$datapengeluaran=mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `tbgudanguptdpengeluaran` where `NoFaktur`='$id'"));
							?>
							<tr>
								<td class="col-sm-2">Tgl.Pengeluaran</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo $datapengeluaran['TanggalPengeluaran']?>
								</td>
								<td class="col-sm-2">Kode</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo $datapengeluaran['KodePuskesmas']?>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">No.Faktur</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo $datapengeluaran['NoFaktur']?>
								</td>
								<td class="col-sm-2">Puskesmas</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php
										$str_pkm = "SELECT * from tbpuskesmas where KodePuskesmas = '$datapengeluaran[KodePuskesmas]'";
										$query_pkm = mysqli_query($koneksi,$str_pkm);
										$data_pkm = mysqli_fetch_assoc($query_pkm);
									?>
									<?php echo $data_pkm['NamaPuskesmas']?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row noprint">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-pencil"></i> Entry Barang</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive" style="font-size:12px">
					<form action="?page=uptd_gudang_pengeluaran_lihat_proses" method="post">	
						<table class="table table-hover table-condensed">
							<tbody>
								<tr>
									<td class="col-sm-2">Nama Barang</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="namabarang" class="form-control nama_barang_gudang_uptd_pengadaan" placeholder="Ketikan Nama Barang">
										<input type="hidden" class="form-control namabarang">
										<input type="hidden" class="form-control stok">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Kode Barang</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="kodebarang" class="form-control kodebarang" maxlength = "20" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Barcode</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="barcode" class="form-control barcode" maxlength = "13" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Satuan</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="satuan" class="form-control satuan" maxlength = "10" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Batch</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="nobatch" class="form-control nobatch" maxlength="30" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Expire</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="expire" class="form-control expire" maxlength="10" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Stok</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="number" name="stok" class="form-control stok" maxlength="10" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Jumlah</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="number" name="jumlah" class="form-control jumlah" maxlength="10" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2"></td>
									<td></td>
									<td class="col-sm-10"><input type="submit" value="Simpan" class="btn btn-md btn-success"></td>
									<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
									<input type="hidden" class="form-control" name="kodepuskesmas" value="<?php echo $datapengeluaran['KodePuskesmas']?>">
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	
<!--tabel view-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Data Barang</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive" style="font-size:12px">
					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>No.</th>
								<th>Barcode</th>
								<th>Kode</th>
								<th class="col-sm-4">Nama Barang</th>
								<th>Satuan</th>
								<th>Batch</th>
								<th>Expire</th>
								<th>Harga</th>
								<th>Jml</th>
								<th>Opsi</th>
							</tr>
						</thead>
						
						<tbody>
							<!--paging-->
							<?php
							$jumlah_perpage = 20;
							
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$kategori = $_GET['kategori'];		
							$key = $_GET['key'];	
							
							if($kategori !='' && $key !=''){
								$strcari = " where tbgudanguptdpengeluarandetail.NoFaktur = '$id' AND".$kategori." Like '%$key%'";
							}else{
								$strcari = " where tbgudanguptdpengeluarandetail.NoFaktur = '$id'";
							}
							
							$str = "select tbgfkstok.Barcode,tbgudanguptdpengeluarandetail.KodeBarang,tbgudanguptdpengeluarandetail.NoFaktur,tbgfkstok.NamaBarang,tbgfkstok.Satuan,tbgfkstok.NoBatch,tbgfkstok.Expire,tbgfkstok.HargaBeli,tbgudanguptdpengeluarandetail.Jumlah from tbgudanguptdpengeluarandetail join tbgfkstok on tbgudanguptdpengeluarandetail.KodeBarang = tbgfkstok.KodeBarang ".$strcari;
							$str2 = $str." order by tbgfkstok.NamaBarang Asc limit $mulai,$jumlah_perpage";
							// echo var_dump($str2);
							// die();
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $data['Barcode'];?></td>
									<td><?php echo $data['KodeBarang'];?></td>
									<td class="nama"><?php echo $data['NamaBarang'];?></td>
									<td><?php echo $data['Satuan'];?></td>
									<td><?php echo $data['NoBatch'];?></td>
									<td><?php echo $data['Expire'];?></td>
									<td><?php echo $data['HargaBeli'];?></td>
									<td><?php echo $data['Jumlah'];?></td>
									<td>
										<a href="?page=uptd_gudang_pengeluaran_lihat_hapus&no=<?php echo $data['NoFaktur'];?>&kd=<?php echo $data['KodeBarang'];?>" class="btn btn-xs btn-danger">Hapus</a>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
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
					echo "<li><a href='?page=gudang_besar_pengeluaran_lihat&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul> 

<!--tabel report-->
	<div class="printheader">
		<?php
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` where `NoFaktur` = '$id'"));
		$kota = $datapuskesmas['Kota'];
		$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota'"));
		?>
			<h4 style="margin:5px;">PEMERINTAH <?php echo $datapuskesmas['Kota']?></h4>
			<h4 style="margin:5px;"><?php echo $datadinas['NamaDinkes']?></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
			<hr style="margin:3px; border:1.5px solid #000">
			<h4 style="margin:15px 5px 5px 5px;">SURAT INSTRUKSI PENGELUARAN BARANG (GUDANG BESAR - DINKES)</h4>
			<p style="margin:1px;">No Faktur: <?php echo $_GET['id'];?></p>
			<p style="margin:1px;">Tanggal Entry: <?php echo tgl_slas($pengeluaran['TanggalPengeluaran']);?></p>
	</div>

	<?php  
	$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
	$tgllaporan = $tgl[1] - 1;
	$tglpermintaan = $tgl[1];
	?>
	<div class="atastabel">
		<div style="float:left; width:75%; margin-bottom:10px;">
			<table><!--style="margin-top:20px;"-->
				<tr>
					<td style="padding:2px 4px;">Penerima </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $pengeluaran['Penerima'];?></td>
				</tr>
				<tr>
					<?php
					$penerima = $pengeluaran['Penerima'];
					$datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `namapuskesmas` = '$penerima'"));
					?>
					<td style="padding:2px 4px;">Kecamatan </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $datakecamatan['Kecamatan'];?></td>
				</tr>
				
			</table>
		</div>
		<div style="float:right; width:25%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Pelaporan Bulan </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo nama_bulan($tgllaporan)." ".$tgllaporan[0];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Permintaan Bulan </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo nama_bulan($tglpermintaan)." ".$tgllaporan[0];?></td>
				</tr>
			</table>
		</div>	
	</div>

	<div class="printbody">
		<table><!--table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
			<thead style="font-size:12,5px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
					<th rowspan="2" style="text-align:center;width:45%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Barang</th>
					<th rowspan="2" style="text-align:center;width:8%;vertical-align:middle; border:1px dashed #000; padding:3px;">Expire</th>
					<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px dashed #000; padding:3px;">NoBatch</th>
					<th rowspan="2" style="text-align:center;width:12%;vertical-align:middle; border:1px dashed #000; padding:3px;">Anggaran</th>
					<th colspan="6" style="text-align:center;border:1px dashed #000; padding:3px;">Pemberian</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th style="text-align:center;width:5%; border:1px dashed #000; padding:3px;">Qty</th>
					<th style="text-align:center;width:6%; border:1px dashed #000; padding:3px;">Sat</th>
					<th style="text-align:center;width:5%; border:1px dashed #000; padding:3px;">Qty</th>
					<th style="text-align:center;width:6%; border:1px dashed #000; padding:3px;">Kem</th>
					<th style="text-align:center;width:5%; border:1px dashed #000; padding:3px;">Harga</th>
					<th style="text-align:center;width:8%; border:1px dashed #000; padding:3px;">Jumlah</th>
				</tr>
			</thead>
			
			<tbody style="font-size:12,5px;">
				<!--paging-->
				<?php
				$str2_print = "select tbgfkstok.Barcode,tbgfkpengeluarandetail.KodeBarang,tbgfkstok.IsiKemasan,tbgfkstok.NamaBarang,tbgfkstok.SumberAnggaran,tbgfkstok.Kemasan,tbgfkstok.TahunAnggaran,tbgfkstok.Satuan,tbgfkstok.NoBatch,tbgfkstok.Expire,tbgfkstok.HargaBeli,tbgfkpengeluarandetail.Jumlah from `tbgfkpengeluarandetail` join `tbgfkstok` on tbgfkpengeluarandetail.KodeBarang = tbgfkstok.KodeBarang where tbgfkpengeluarandetail.NoFaktur = '$id' order by `NamaBarang` ASC";
				$query_print = mysqli_query($koneksi,$str2_print);
				
				$qty = 0;
				$total = 0;
				$no = 0;
				while($data = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;
				$jumlah = $data['HargaBeli'] * $data['Jumlah'];
				$total = $jumlah + $total;
				if($data['IsiKemasan'] != 0){
					$qty = $data['Jumlah'] / $data['IsiKemasan'];
				}else{
					$qty = "-";
				}
				//$qty2 = number_format($qty, 3, '.', '');
				?>
					<tr style="border:1px dashed #000;">
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo $no.".";?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo tgl_singkat($data['Expire']);?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo $data['NoBatch'];?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo $data['SumberAnggaran']." ".$data['TahunAnggaran'];?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo rupiah($data['Jumlah']);?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo $qty;?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo $data['Kemasan'];?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo rupiah($data['HargaBeli']);?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo rupiah($data['HargaBeli'] * $data['Jumlah']);?></td>
					</tr>
				<?php
				}
				?>
					<tr style="border:1px dashed #000; padding:3px;">
						<td colspan="10" style="text-align:center; padding:3px;">TOTAL</td>
						<td style="text-align:right; padding:3px;"><?php echo $total?></td>
					</tr>
			</tbody>
		</table>
	</div>	
	
	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td style="text-align:center;">
				Kepala Puskesmas
				<br>
				<br>
				<br>
				(..............................)
				</td>
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
	
