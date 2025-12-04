<?php
	error_reporting(0);
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	// get
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$namaprogram = $_GET['namaprogram'];
?>
<style>
.table-judul-laporan>thead>tr>th {
	padding-top:15px;
	padding-bottom:15px;
	background:#939393;
	color:#fff;
	text-align:center;
	vertical-align:middle;
	border:1px solid #000;
	font-size: 12px;
	font-family: "Poppins", sans-serif;
}
.table-judul-laporan>tbody>tr>td {
	background:#fff;
	padding:5px;			
	border: 1px solid;  
	border-color:#000;
}
</style>

<html lang="en">
<head>
	<title>Rencana Kebutuhan Obat</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_rko_dinas_bogorkab&tahun=<?php echo  $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>RENCANA KEBUTUHAN OBAT</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tahun;?></span>
		<br/><br/>
	</div>
	
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px sollid #000;">
							<th width="2%" rowspan="3">No</th>
							<th width="5%" rowspan="3">Kode</th>
							<th width="20%" rowspan="3">Nama Barang</th>
							<th width="5%" rowspan="3">Satuan</th>
							<th width="5%" rowspan="2">Harga</br>Satuan</th>
							<th width="5%" rowspan="2">Stok Awal <br/> <?php //echo "Januari ".$tahun1?></th>
							<th width="5%" rowspan="2">Penerimaan <br/> <?php //echo $tahun1?></th>
							<th width="5%" rowspan="2">Total <br/>Persediaan
							<th width="5%" rowspan="2">Pemakaian <br/>
							<th width="5%" rowspan="2">Sisa Stok <br/>
							<th width="5%" rowspan="2">Jumlah</br>Bulan Pemakaian <br/> <?php //echo $tahun1?></th>
							<th width="5%" rowspan="2">Pemakaian</br>Rata2 /Bulan</th>
							<th width="5%" rowspan="2">Jumlah</br>Kebutuhan</th>
							<th width="5%" rowspan="2">Rencana</br>Kebutuhan Obat</th>
							<th width="5%" rowspan="2">Total RKO</br>(Rp)</th>
							<th width="5%" rowspan="2">Rencana</br>Pembelian</th>
							<th width="5%" rowspan="2">Total Pembelian</br>(Rp)</th>
						</tr>	
					</thead>
					<tbody style="font-size:12px;">
					<?php
						if($namaprogram == "semua"){
							$str = "SELECT * FROM `ref_obat_lplpo` ORDER BY IdLplpo, NamaBarang";
						}else{
							$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram` = '$namaprogram'  GROUP BY KodeBarang, IdBarang ORDER BY NamaBarang";
						}	
							
						$str2 = $str;
													
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprograms != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$data[NamaProgram]</td></tr>";
								$namaprograms = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							
							// tbgfkstok, harga diambil dari tahun awal / anggaran terakhir
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT HargaBeli FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY TahunAnggaran DESC"));
							
							// stokawal, cukup berdasarkan kodebarang saja karena diambil dari ref_obat_lplpo
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Jumlah FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun1'"));
							if($dtstokawal['Jumlah'] != 0){
								$stokawals = $dtstokawal['Jumlah'];
							}else{
								$stokawals = "0";
							}
							
							// penerimaan
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPenerimaan`)='$tahun'"));
							if($dtpenerimaan['Jumlah'] != 0){
								$penerimaans = $dtpenerimaan['Jumlah'];
							}else{
								$penerimaans = "0";
							}
										
							// total persediaan
							$totalpersediaan = $stokawals + $penerimaans;
							
							// pemakaian
							$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NoFaktur, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun'"));
							if($dtpengeluaran['Jumlah'] != 0){
								$pengeluarans = $dtpengeluaran['Jumlah'];
							}else{
								$pengeluarans = "0";
							}
							
							// sisastok
							$sisastok = $totalpersediaan - $pengeluarans;
							
							// jumlah bulan
							$str_jmlbulan = "SELECT COUNT(b.TanggalPengeluaran) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun' GROUP BY YEAR(b.TanggalPengeluaran), MONTH(b.TanggalPengeluaran)";
							$dt_jumlahbulan = mysqli_num_rows(mysqli_query($koneksi, $str_jmlbulan));
							
							// pemakaian rata-rata
							$pemakaian_rata = $pengeluarans / $dt_jumlahbulan;
							if($pemakaian_rata != 0){
								$pemakaian_ratas = $pemakaian_rata;
							}else{
								$pemakaian_ratas = "0";
							}
							
							// jumlah kebutuhan
							$jumlah_kebutuhan = $pemakaian_ratas * 18;
							
							// rencana kebutuhan
							$rencana_kebutuhan = $jumlah_kebutuhan - $sisastok;
							
							// total_rencana kebutuhan
							$total_rko = $rencana_kebutuhan * $dtgfkstok['HargaBeli'];
							
							?>
							<tr>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $kodebarang;?></td>
								<td style="text-align:left; border:1px sollid #000; padding:3px;" class="namabarangcls"><?php echo strtoupper($namabarang);?></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($dtgfkstok['HargaBeli']);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($stokawals);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($penerimaans);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($totalpersediaan);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($pengeluarans);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($sisastok);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $dt_jumlahbulan;?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($pemakaian_ratas);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($jumlah_kebutuhan);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($rencana_kebutuhan);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($total_rko);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"></td>
							</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</body>
</html>