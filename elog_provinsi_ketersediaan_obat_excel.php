<?php
	error_reporting(0);
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	
	// get	
	$keydate1 =  $_GET['keydate1'];
	$keydate2 =  $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Ketersediaan_Obat_Esensial (".$kota.").xls");
	if(isset($keydate1)){
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN KETERSEDIAAN OBAT ESENSIAL</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></span>
</div><br/>

<div class="row noprint">
	<div class="col-sm-12">
		<div class="table-responsive noprint">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="3%">No.</td>
						<th width="7%">Kode</td>
						<th width="40%">Nama Barang</td>
						<th width="10%">Satuan</td>
						<th width="10%">Saldo Awal</td>
						<th width="10%">Penerimaan</td>
						<th width="10%">Pengeluaran</td>
						<th width="10%">Saldo Akhir</td>
					</tr>
				</thead>
				<tbody>
					<?php						
						// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
						$str = "SELECT * FROM `ref_obatindikator`";
						$str2 = $str." ORDER BY `nama_indikator` ASC";
						// echo $str2;	
													
						$query_obat = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query_obat)){
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['nama_indikator'];
							$satuan = $data['satuan'];
							
							// tahap2, menentukan stok awal stok / saldo awal
							$nbct = implode(",", $nobats[$no]);
							$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang'";
							// echo $str_stokawal;
							$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
							if ($dt_stokawal_dtl['Stok'] != ''){
								$stokawal = $dt_stokawal_dtl['Stok'];
							}else{
								$stokawal = '0';
							}
															
							// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
							$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
							FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPenerimaan < '$keydate1'";
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
							WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPengeluaran < '$keydate1'";	
							// echo $str_pengeluaran_lalu;
							$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
							if ($dt_pengeluaran_lalu['Jumlah'] != null){
								$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
							}else{
								$pengeluaran_lalu = '0';
							}	
							
							$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
							// echo "Stok Awal : ".$stokawal."<br/>";
							// echo "Terima : ".$penerimaan_lalu."<br/>";
							// echo "Keluar : ".$pengeluaran_lalu."<br/>";

							// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
							$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
							JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'";
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
							if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
								$penerimaan = $dtpenerimaan['Jumlah'];
							}else{
								$penerimaan = '0';
							}		
							
							// tahap4, menentukan pemakaian/pengeluaran
							$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2'";
							// echo $strpengeluaran;
							$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));								
							if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
								$pengeluaran = $dtpengeluaran['Jumlah'];
							}else{
								$pengeluaran = '0';
							}	
							
							// tahap4.1, hitung jumlah pengeluaran bulan sebelumnya
							$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPengeluaran < '$keydate1'";
							// echo $str_pengeluaran_lalu;
							$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
							if ($dt_pengeluaran_lalu['Jumlah'] != null){
								$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
							}else{
								$pengeluaran_lalu = '0';
							}								
							$pengeluaran_total = $pengeluaran; // + $pengeluaran_lalu
															
							// tahap5, sisaakhir
							$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran_total;
							
					?>
							<tr>
								<td style="text-align:center;"><?php echo $no;?></td>
								<td style="text-align:center;"><?php echo $data['KodeBarang'];?></td>
								<td style="text-align:left;" class="namabarangcls">
									<?php 
										echo $namabarang;
										// echo "<b>Keterangan :</b><br/>";
										// echo "Stok Master = ".$stokawal."<br/>";
										// echo "Penerimaan Lalu = ".$penerimaan_lalu."<br/>";
										// echo "Pengeluaran Lalu = ".$pengeluaran_lalu."<br/>";
										// echo "Saldo Awal = ".$stokawal_total;
									?>
								</td>
								<td style="text-align:center;"><?php echo $satuan;?></td>
								<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
								<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
								<td style="text-align:right;"><?php echo rupiah($pengeluaran_total);?></td>
								<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
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