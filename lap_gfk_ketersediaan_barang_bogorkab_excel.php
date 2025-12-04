<?php
	error_reporting(0);
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	
	// get	
	$tanggal_awal =  date('Y-m-d', strtotime($_GET['tanggal_awal']));
	$tanggal_akhir =  date('Y-m-d', strtotime($_GET['tanggal_akhir']));	
	$namaprg = $_GET['namaprg'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Ketersediaan_Barang (".$kota.").xls");
	if(isset($namaprg) and isset($key)){
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
.str{
	mso-number-format:\@; 
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN KETERSEDIAAN BARANG</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($_GET['tanggal_awal']))." s/d ".date('d-m-Y', strtotime($_GET['tanggal_akhir']));?></span>
</div><br/>

<div class="row noprint">
	<div class="col-sm-12">
		<div class="table-responsive noprint">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="3%" rowspan="2">No.</td>
						<th width="15%" rowspan="2">Nama Barang</td>
						<th width="5%" rowspan="2">Satuan</td>
						<th width="10%" rowspan="2">Batch</td>
						<th width="5%" rowspan="2">Harga<br/>Satuan</td>
						<th width="7%" rowspan="2">Expire</td>
						<th width="10%" rowspan="2">Sumber Anggaran</td>
						<th width="3%" rowspan="2">Tahun</td>
						<th width="9%" rowspan="2">Supplier</td>
						<th width="9%" colspan="2">Saldo Awal</td>
						<th width="9%" colspan="2">Penerimaan</td>
						<th width="9%" colspan="2">Pengeluaran</td>
						<th width="9%" colspan="2">Saldo Akhir</td>
					</tr>
					<tr>
						<th>Jumlah</td><!--Saldo Awal-->
						<th>Rupiah</td>
						<th>Jumlah</td><!--Penerimaan-->
						<th>Rupiah</td>
						<th>Jumlah</td><!--Pengeluaran-->
						<th>Rupiah</td>
						<th>Jumlah</td><!--Saldo Akhir-->
						<th>Rupiah</td>
					</tr>
				</thead>
				<?php						
					if($namaprg == "Semua" || $namaprg == ""){
						$program = "";
					}else{
						$program = "AND `NamaProgram`='$namaprg'";
					}
					
					// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
					$str = "SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%') ".$program;
					$str2 = $str." ORDER BY `IdProgram`,`NamaBarang` ASC";
					// echo $str2;	
												
					$query_obat = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query_obat)){
						if($namaprogram != $data['NamaProgram']){
							if($data['NamaProgram'] == "PKD"){
								$prg = "OBAT (PKD)";	
							}else{
								$prg = $data['NamaProgram'];
							}	
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$prg</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						$nobatch = $data['NoBatch'];
						
						// harga satuan, ambil yang terakhir
						$harga_satuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `HargaBeli` != '0'")); //  ORDER BY IdBarang DESC
															
						// Supplier
						$no4 = 0;
						$query_supplier = mysqli_query($koneksi, "SELECT nama_prod_obat FROM `ref_pabrik` WHERE `id`='$data[Produsen]'");
						$dt_supplier= mysqli_fetch_assoc($query_supplier);
																													
						// tahap 2, menentukan stok awal stok / saldo awal
						$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
						// echo $str_stokawal;
						$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
						if ($dt_stokawal_dtl['Stok'] != null){
							$stokawal = $dt_stokawal_dtl['Stok'];
						}else{
							$stokawal = '0';
						}
						
						// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
						$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
						FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NomorPembukuan`='$data[NoFakturTerima]' AND b.TanggalPenerimaan < '$tanggal_awal'";
						$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
						if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
							$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
						}else{
							$penerimaan_lalu = '0';
						}

						// tahap2.2 cek pengeluaran sebelumnya
						$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
						JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran < '$tanggal_awal'";
						$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
						if ($dt_pengeluaran_lalu['Jumlah'] != null){
							$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
						}else{
							$pengeluaran_lalu = '0';
						}	
						
						$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
						$stokawal_rupiah = $stokawal_total * $harga_satuan['HargaBeli'];							
														
						// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
						$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
						JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' 
						AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir' 
						AND a.`NomorPembukuan`='$data[NoFakturTerima]'";																
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
						if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
							$penerimaan = $dtpenerimaan['Jumlah'];
						}else{
							$penerimaan = '0';
						}															
						$penerimaan_rupiah = $penerimaan * $harga_satuan['HargaBeli'];
						
						// tahap4, menentukan pemakaian/pengeluaran
						$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
						JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND 
						b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";								
						$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));								
						if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
							$pengeluaran = $dtpengeluaran['Jumlah'];
						}else{
							$pengeluaran = '0';
						}								
						$pengeluaran_rupiah = $pengeluaran * $harga_satuan['HargaBeli'];
														
						// tahap5, sisaakhir
						// if($stokawal == $pengeluaran){
							// $stokawal = "0";
							// $stokawal_rupiah = "0";
							// $pengeluaran = "0";
							// $pengeluaran_rupiah = "0";
						// }	
						$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran;
						$sisaakhir_rupiah = $sisaakhir * $harga_satuan['HargaBeli'];
						
				?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:left;" class="namabarangcls"><?php echo strtoupper($data['NamaBarang']);?></td>
							<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:left;"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
							<td style="text-align:right;"><?php echo rupiah($harga_satuan['HargaBeli']);?></td>
							<td style="text-align:center;"><?php echo str_replace(",", ", ", $data['Expire']);?></td>
							<td style="text-align:left;"><?php echo str_replace(",", ", ", $data['SumberAnggaran']);?></td>
							<td style="text-align:center;"><?php echo $data['TahunAnggaran'];?></td>
							<td style="text-align:left;"><?php echo str_replace(",", ", ", $dt_supplier['nama_prod_obat']);?></td>
							<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
							<td style="text-align:right;"><?php echo rupiah($stokawal_rupiah);?></td>
							<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
							<td style="text-align:right;"><?php echo rupiah($penerimaan_rupiah);?></td>
							<td style="text-align:right;"><?php echo rupiah($pengeluaran);?></td>
							<td style="text-align:right;"><?php echo rupiah($pengeluaran_rupiah);?></td>
							<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
							<td style="text-align:right;"><?php echo rupiah($sisaakhir_rupiah);?></td>
						</tr>
					<?php
					}
					?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<?php
}
?>