<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	// get
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$namaprogram = $_GET['namaprogram'];
	$penerima = $_GET['penerima'];
	
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
	<title>Ketersediaan Barang</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_gfk_distribusi_unit_bogorkab&bulan1=<?php echo $_GET['bulan1'];?>&bulan2=<?php echo $_GET['bulan2'];?>&tahun=<?php echo $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&penerima=<?php echo $_GET['penerima'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>DISTRIBUSI UNIT</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan1)." s/d ".nama_bulan($bulan2)." ".$tahun;?></span>
		<br/><br/>
	</div>
	
	<?php
		$no = 0;
		
		if($penerima == 'semua'){
			$penerima1 = '';
		}else{
			$penerima1 = " AND `Penerima` like '%$_GET[penerima]%'";
		}
		
		if($namaprogram == "semua"){
			$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran) = '$tahun' AND MONTH(TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2'".$penerima1;
			$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
					FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran) ='$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2'".$penerima1;
		}else{
			$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran) = '$tahun' AND MONTH(TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND `NamaProgram`='$namaprogram'".$penerima1;
			$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
					FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran) ='$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND a.`NamaProgram`='$namaprogram'".$penerima1;
		}
	?>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="4%">NO.</th>
							<th width="8%">TANGGAL</th>
							<th width="5%">JAM</th>
							<th width="10%">NO.FAKTUR</th>
							<th width="15%">PENERIMA</th>
							<th width="15%">PROGRAM</th>
							<th width="15%">KETERANGAN</th>
							<th width="10%">GRAND TOTAL (Rp.)</th>
						</tr>
					</thead>
					<tbody >
						<?php
							$str2 = $str." ORDER BY IdDistribusi DESC";
							$query = mysqli_query($koneksi,$str2);
							while ($dt_brg = mysqli_fetch_assoc($query)){
								$no = $no + 1;
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
								<td align="center"><?php echo $dt_brg['JamPengeluaran'];?></td>
								<td align="center"><?php echo $dt_brg['NoFaktur'];?></td>
								<td align="left"><?php echo $dt_brg['Penerima'];?></td>
								<td align="center"><?php echo $dt_brg['NamaProgram'];?></td>
								<td align="center"><?php echo $dt_brg['Keterangan'];?></td>
								<td align="right"><b><?php echo rupiah($dt_brg['GrandTotal']);?></b></td>
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