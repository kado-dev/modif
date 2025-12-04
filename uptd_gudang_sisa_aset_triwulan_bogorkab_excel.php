<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	// get
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];	
	$namaprg = $_GET['namaprg'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Sisa_Aset_Triwulan (".$kota." ".$keydate1." sd ".$keydate2.").xls");	
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN SISA ASET TRIWULAN</b></span><br>
	<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?>
	</span>
</div><br/>

<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th rowspan="2">No.</th>
						<th rowspan="2">Kode</th>
						<th rowspan="2" width="15%">Nama Barang</th>
						<th rowspan="2">Satuan</th>
						<th rowspan="2">Batch</th>
						<th rowspan="2">Harga<br/>Satuan</th>
						<th rowspan="2">Sumber</th>
						<th rowspan="2">Tahun</th>
						<th colspan="2">Saldo Awal</th>
						<th colspan="2">Penerimaan</th>
						<th colspan="2">Persediaan</th>
						<th colspan="2">Pengeluaran</th>
						<th colspan="2">Sisa Akhir</th>
					</tr>
					<tr>
						<th>Jml</th><!--Saldo Awal-->
						<th>Saldo</th>
						<th>Jml</th><!--Penerimaan-->
						<th>Saldo</th>
						<th>Jml</th><!--Persediaan-->
						<th>Saldo</th>
						<th>Jml</th><!--Pengeluaran-->
						<th>Saldo</th>
						<th>Jml</th><!--Sisa Akhir-->
						<th>Saldo</th>
					</tr>
				</thead>
				<tbody>
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
							if($namaprg != $data['NamaProgram']){
								if($data['NamaProgram'] == "PKD"){
									$prg = "OBAT (PKD)";	
								}
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='18'>$prg</td></tr>";
								$namaprg = $data['NamaProgram'];
							}
							$no = $no +1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$satuan = $data['Satuan'];
							$harga = $data['HargaBeli'];
							$nobatch = $data['NoBatch'];
							$sumberanggaran = $data['SumberAnggaran'];
							$tahunanggaran = $data['TahunAnggaran'];
							
							// tahap2, stokawal
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
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPenerimaan < '$keydate1'";
							// echo $str_terima_lalu;
							$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
							if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
								$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
							}else{
								$penerimaan_lalu = '0';
							}

							// tahap2.2 cek pengeluaran sebelumnya
							$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran < '$keydate1'";	
							// echo $str_pengeluaran_lalu;
							$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
							if ($dt_pengeluaran_lalu['Jumlah'] != null){
								$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
							}else{
								$pengeluaran_lalu = '0';
							}	
							
							$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
							$stokawal_rupiah = $stokawal_total * $harga;
							
							// penerimaan berdasar sumber anggaran
							$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfkpenerimaandetail` a 
							JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'"));
							if ($penerimaan['Jumlah'] != null || $penerimaan['Jumlah'] != 0){
								$penerimaan = $penerimaan['Jumlah'];
							}else{
								$penerimaan = '0';
							}
							$penerimaan_rupiah = $penerimaan * $harga;
							
							// totalpersediaan
							$persediaan = $stokawal_total + $penerimaan;
							$persediaan_rupiah = $persediaan * $harga;
							
							// totalrupiah
							$totalrupiah = $saldo_akhir + $totalpenerimaan;
							
							// pengeluaran
							$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2'"));
							$pengeluaran_rupiah = $pengeluaran['Jumlah'] * $harga;
							
							// saldo akhir
							$saldoakhir = $stokawal_total + $penerimaan - $pengeluaran['Jumlah'];
							$saldoakhir_rupiah = $saldoakhir * $harga;
					?>
							<tr>
								<td style="text-align:center;"><?php echo $no;?></td>
								<td style="text-align:center;"><?php echo $kodebarang;?></td>
								<td class="namabarangcls" style="text-align:left;"><?php echo $namabarang;?></td>
								<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:center;"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
								<td style="text-align:right;"><?php echo rupiah($data['HargaBeli']);?></td>
								<td style="text-align:center;"><?php echo $sumberanggaran;?></td>
								<td style="text-align:center;"><?php echo $tahunanggaran;?></td>
								<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
								<td style="text-align:right;"><?php echo rupiah($stokawal_rupiah);?></td>
								<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
								<td style="text-align:right;"><?php echo rupiah($penerimaan_rupiah);?></td>
								<td style="text-align:right;"><?php echo rupiah($persediaan);?></td>
								<td style="text-align:right;"><?php echo rupiah($persediaan_rupiah);?></td>
								<td style="text-align:right;"><?php echo rupiah($pengeluaran['Jumlah']);?></td>
								<td style="text-align:right;"><?php echo rupiah($pengeluaran_rupiah);?></td>
								<td style="text-align:right;"><?php echo rupiah($saldoakhir);?></td>
								<td style="text-align:right;"><?php echo rupiah($saldoakhir_rupiah);?></td>
								
							</tr>
						<?php
						}
						?>
				</tbody>
			</table>
		</div>
	</div>
</div>