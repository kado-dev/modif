<?php
	$id = $_GET['id'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<style>
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}

.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:50px;
	margin-bottom:10px;
	margin-left:0px;
	display:none;
}
.logo{
	position: absolute;
	top:-5px;
	left:10px;
	width:200px;
}
.teks12{
	margin-top:20px;
	font-size:14px;
	text-align:right;
}
.teks10{
	font-size:10px;
	font-style:italic;
	text-align:right;
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
			<h1>Detail Invoice</h1>
		</div>
	</div>
</div>

<!--menu header-->
<div class="row">	
	<div class="col-lg-12 noprint" style="padding-bottom:10px">
	<a href="?page=adm_invoice" class="btn btn-sm btn-success pull-right"> Kembali</a>
	<a href="javascript:print()" class="btn btn-sm btn-danger pull-right" style="margin-right:5px"> Print</a>
	</div>
</div>

<!--detail faktur-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bars"></i> Invoice</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive" style="font-size:12px">
					<table class="table table-striped table-condensed">
						<tbody>
							<?php
								$data_inv = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `tbadm_invoice` where `NoInvoice`='$id'"));
							?>
							<tr>
								<td class="col-sm-2">Tgl.Invoice</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo $data_inv['TanggalInvoice'];?>
								</td>
								<td class="col-sm-2">Ditujukan</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo $data_inv['Tujuan'];?>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">No.Invoice</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo $data_inv['NoInvoice'];?>
								</td>
								<td class="col-sm-2">Jumlah Tagihan</td>
								<td>:</td>
								<td class="col-sm-4">
									<?php echo rupiah($data_inv['JumlahTagihan']);?>
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
				<h3 class="panel-title"><i class="fa fa-bars"></i> Entry Barang</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive" style="font-size:12px">
					<form action="?page=adm_invoice_lihat_proses" method="post">	
						<table class="table table-striped table-condensed">
							<tbody>
								<tr>
									<td class="col-sm-2">Nama Barang</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="namabarang" style="text-transform: uppercase;" class="form-control" placeholder="Ketikan Nama Barang">
										<input type="hidden" class="form-control namabarang">
										<input type="hidden" class="form-control stok">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Satuan</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="satuan" style="text-transform: uppercase;" class="form-control" maxlength = "20">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Qty</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="qty" class="form-control" maxlength="30">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Harga</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="harga" class="form-control expire" maxlength="10">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2"></td>
									<td></td>
									<td class="col-sm-10"><input type="submit" value="Simpan" class="btn btn-info"></td>
									<input type="hidden" class="form-control" name="noinvoice" value="<?php echo $data_inv['NoInvoice']?>">
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
				<h3 class="panel-title"><i class="fa fa-bars"></i> Data Barang</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive" style="font-size:12px">
					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th width="5%">No.</th>
								<th width="50%">Nama Barang</th>
								<th width="10%">Satuan</th>
								<th width="5%">Qty</th>
								<th width="10%">Harga</th>
								<th width="10%">Jumlah</th>
								<th width="10%">Aksi</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
							
							$str = "select * from `tbadm_invoice_detail` where NoInvoice = '$id'";
							//echo var_dump($str);
							//die();
							
							$no = 0;
							$query = mysqli_query($koneksi,$str);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $data['NamaBarang'];?></td>
									<td><?php echo $data['Satuan'];?></td>
									<td><?php echo $data['Qty'];?></td>
									<td><?php echo rupiah($data['Harga']);?></td>
									<td><?php echo rupiah($data['Jumlah']);?></td>
									<td>
										<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){ ?>
										<a href="?page=gudang_pelayanan_pengeluaran_edit&no=<?php echo $data['NoInvoice'];?>" class="btn btn-xs btn-info">Edit</a>
										<a href="?page=adm_invoice_lihat_hapus&no=<?php echo $data['NoInvoice'];?>&nama=<?php echo $data['NamaBarang'];?>" class="btn btn-xs btn-danger">Hapus</a>
										<?php } ?>
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

<!--tabel report-->
	<div class="printheader">
		<img src="image/logometro.png" class="logo"/>
		<?php
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbadm_invoice` where `NoInvoice` = '$id'"));
		?>
		<div class="teks12">PT. METRO SMART TECHNOLOGY</div>
		<div class="teks10">Ruko Metro Indah Mall/MTC Blok H-53 Soekarno Hatta Bandung</div>
		<hr style="margin-top:10px; border:1.5px solid #000">
		<h4 style="margin:30px">INVOICE</h4>
	</div>

	<?php  
	$tgl = explode("-",$pengeluaran['TanggalInvoice']);
	$tgllaporan = $tgl[1] - 1;
	$tglpermintaan = $tgl[1];
	?>
	
	<div class="atastabel">
		<div style="float:left; width:60%; margin-bottom:10px;">
			<table>
				<tr>
					<td style="padding:2px 4px;">Tanggal Invoice </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['TanggalInvoice'];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">No. Invoice </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['NoInvoice'];?></td>
				</tr>
				
			</table>
		</div>
		<div style="float:right; width:40%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Ditujukan </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['Tujuan'];?></td>
				</tr>
			</table>
		</div>	
	</div>	
	
	<div class="printbody">
		<table width="100%">
			<thead style="font-size:14px;">
				<tr>
					<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
					<th rowspan="2" style="text-align:center;width:50%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Barang</th>
					<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px dashed #000; padding:3px;">Satuan</th>
					<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Qty</th>
					<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px dashed #000; padding:3px;">Harga</th>
					<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
				</tr>
			</thead>
			
			<tbody style="font-size:12px;">
				<?php
					$str_print = "select * from `tbadm_invoice_detail` where NoInvoice = '$id'";
					$query_print = mysqli_query($koneksi,$str_print);
					
					$qty = 0;
					$total = 0;
					$no = 0;
					while($data = mysqli_fetch_assoc($query_print)){
						$no = $no + 1;
						$jumlah = $data['Harga'] * $data['Qty'];
						$total = $jumlah + $total;
				?>
					<tr>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo $no.".";?></td>
						<td style="text-align:left; padding:3px;border:1px dashed #000;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:center; padding:3px;border:1px dashed #000;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo $data['Qty'];?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo rupiah($data['Harga']);?></td>
						<td style="text-align:right; padding:3px;border:1px dashed #000;"><?php echo rupiah($data['Jumlah']);?></td>
					</tr>
				<?php
				}
				?>
					<tr style="border:1px dashed #000; padding:3px;">
						<td colspan="5" style="text-align:center;width:100%;padding:3px;">TOTAL</td>
						<td style="text-align:right; padding:3px;"><?php echo rupiah($total)?></td>
					</tr>
			</tbody>
		</table><br>
		<?php
			echo "Ket : ".$pengeluaran['Keterangan'];
		?>
	</div>
		
	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td style="text-align:center;">
				PENYEDIA JASA,
				<br>
				<br>
				<br>
				<br>
				<br>
				TOMMY NATALIANTO. JH, ST
				</td>
				<td width="10%"></td>
				
				<td width="10%"></td>
				<td style="text-align:center;">
				BENDAHARA PENGELUARAN BLUD<br>
				<?php echo $pengeluaran['Tujuan'];?>
				<br>
				<br>
				<br>
				<br>
				<br>
				<u>(DINI NUR OKTAVIANI)</u><br>
				NIP. 19921013 201503 2 004
				</td>
			</tr>
		</table>
	</div> 
