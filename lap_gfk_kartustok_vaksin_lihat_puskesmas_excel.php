<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$nopembukuan = $_GET['nf'];	
	$key = $_GET['key'];	
	$orderby = $_GET['orderby'];	
	$sort = $_GET['sort'];	
	
	// tbstok
	$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kartu_Stok_Vaksin (".$hariini.").xls");
	if(isset($bulan) and isset($tahun)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}
.font22{
	font-size:22px;
	font-family: "Tahoma";
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

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KARTU STOK VAKSIN</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $hariini;?></p><br/>
</div>
<br/>


<div class="alert alert-success" role="alert">
	<table width="100%">
		<tr>
			<td width="10%">Kode Barang</td>
			<td width="88%"><?php echo ": ".$kodebarang;?></td>
		</tr>
		<tr>
			<td>Nama Barang</td>
			<td colspan="3"><?php echo ": ".$dtbrg['NamaBarang'];?></td>
		</tr>
		<tr>
			<td>No.Batch</td>
			<td><?php echo ": ".$nobatch;?></td>
		</tr>
		<tr>
			<td>Expire</td>
			<td><?php echo ": ".$dtbrg['Expire'];?></td>
		</tr>
		<tr>
			<td>Sumber</td>
			<td><?php echo ": ".$dtbrg['SumberAnggaran'];?></td>
		</tr>
		<tr>
			<td>Program</td>
			<td><?php echo ": ".$dtbrg['NamaProgram'];?></td>
		</tr>
	</table>	
</div><br/>	
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1" width="100%">
			<thead>
				<tr>
					<th width="4%">No.</th>
					<th width="10%">Tanggal</th>
					<th width="20%">No.Faktur</th>
					<th width="30%">Keterangan</th>
					<th>Penerimaan</th>
					<th>Pengeluaran</th>
					<th>Sisa</th>
				</tr>
			</thead>
			<tbody>
				<?php	
					$no = 0;
					$bulan = $_GET['bulan'];
					$tahun = $_GET['tahun'];
					$penerimabrg = $_GET['penerimabrg'];
					
					// penerimaan
					$str_terima = "SELECT * FROM `tbgfk_vaksin_penerimaandetail` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$nopembukuan'";
					$query_terima = mysqli_query($koneksi, $str_terima);
					while($dt_terima = mysqli_fetch_assoc($query_terima)){
						$no = $no + 1;
						$faktur_terima = $dt_terima['NomorPembukuan'];
						$jml_terima = $dt_terima['Jumlah'];
						$stokterima[] = $jml_terima;
						$ttl_terima = array_sum($stokterima);
						
						// detail penerimaan
						$dt_penerimaan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan`='$faktur_terima'"));
						$tanggal_keluar  = $dt_penerimaan['TanggalPenerimaan'];
						$keterangan_terima = $dt_penerimaan['KodeSupplier'];
						
						// ref_pabrik
						$dtpabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dt_penerimaan[KodeSupplier]'"));
						$semua_jml_terima = $semua_jml_terima + $jml_terima;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $tanggal_keluar;?></td>
							<td align="center"><?php echo $faktur_terima;?></td>
							<td align="left"><?php echo $dtpabrik['nama_prod_obat'];?></td>
							<td align="right"><?php echo number_format($jml_terima, 0, ".", ".");?></td>
							<td align="center"></td>
							<td align="right"><?php echo number_format($semua_jml_terima, 0, ".", ".");?></td>
						</tr>	
						
					<?php
						}
						
					// detail pengeluaran
					$no = 0;
					
					if($_GET['orderby'] == '' or $_GET['sort'] == ''){
						$orderbys = "ORDER BY `NoFaktur` ASC";
					}else{
						$orderbys = "ORDER BY ".$_GET['orderby']." ".$_GET['sort'];
					}	
					
					$str_keluar = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nopembukuan'";
					$str_keluar2 = $str_keluar." ".$orderbys;
					// echo $str_keluar2;
					$sisa_stoks = $semua_jml_terima + $jml_stokawal;			
					$query_keluar = mysqli_query($koneksi, $str_keluar2);
					while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
						$no = $no + 1;
						$nofaktur = $dt_keluar['NoFaktur'];
						$jml_keluar = $dt_keluar['Jumlah'];			
						$stokkeluar[] = $jml_keluar;
						$ttl_keluar = array_sum($stokkeluar);
						$sisa_stoks = $sisa_stoks - $jml_keluar;
						
						// pengeluaran
						$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nofaktur'"));
						$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];
						$faktur_keluar  = $dt_distribusi['NoFaktur'];
						$keterangan_keluar = $dt_distribusi['Penerima'];
						
						// pengeluaran gudang besar, ini untuk kabupaten bandung karena dulu gudang vaksin masih menyatu dengan gudang besar
						$dtgudangbesar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur'"));
						$tanggal_keluar  = $dtgudangbesar['TanggalPengeluaran'];
						$keterangan_keluar = $dtgudangbesar['Penerima'];
						
						if ($faktur_keluar != ''){
							$faktur_keluar  = $dt_distribusi['NoFaktur'];
							$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];
							$keterangan_keluar = $dt_distribusi['Penerima'];
						}else{
							$faktur_keluar = $dt_keluar['NoFaktur'];
							$tanggal_keluar  = $dtgudangbesar['TanggalPengeluaran'];
							$keterangan_keluar = $dtgudangbesar['Penerima'];
						}		
					?>	
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $tanggal_keluar;?></td>
							<td align="center"><?php echo $faktur_keluar;?></td>
							<td align="left"><?php echo $keterangan_keluar;?></td>
							<td align="center"></td>
							<td align="right"><?php echo number_format($jml_keluar, 0, ".", ".");?></td>
							<td align="right"><?php echo number_format($sisa_stoks, 0, ".", ".");?></td>
						</tr>
					<?php
						}
						$sisastok = $ttl_terima - $ttl_keluar;
					?>
			</tbody>
		</table><br/><br/>
		<table class="table table-judul-form"  width="100%">
		<tbody>
			<tr style="background: #fff4b7; font-weight: bold;">
				<td colspan="6">Jumlah Pengeluaran</td>
				<td align="right"><?php echo number_format($ttl_keluar, 0, ".", ".");?></td>
			</tr>
			<tr style="background: #ffce8e; font-weight: bold;">
				<td colspan="6"> Sisa Stok</td>
				<td align="right"><?php  echo number_format($sisastok, 0, ".", ".");?></td>
			</tr>
		</tbody>
	</table><hr/>
	</div>
</div>
<?php
}
?>