<?php
	error_reporting(0);
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	// get
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahunakhir = $_GET['tahunakhir'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$namaprogram = $_GET['namaprogram'];	
	$key = $_GET['key'];	
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
	<title>Penerimaan Realisasi</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_gfk_penerimaan_barang_bogorkab&bulanawal=<?php echo  $_GET['bulanawal'];?>&bulanakhir=<?php echo  $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&key=<?php echo $_GET['key'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>PENERIMAAN BARANG</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?></span>
		<br/><br/>
	</div>
	
	<?php
		if($key != ""){
			$namabarang = " AND `NamaBarang` like '%$key%'";
		}else{
			$namabarang = "";
		}
		
		if($namaprogram == "semua"){
			$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` like '%$key%'";
		}else{
			$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprogram'".$namabarang;
		}
		$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
		
		if(isset($bulanawal) and isset($tahunakhir)){
		$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
	?>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="2%">NO.</th>
							<th width="5%">KODE</th>
							<th width="15%">NAMA OBAT & BMHP</th>
							<th width="5%">TAHUN<br/>PENGADAAN</th>
							<th width="5%">BATCH</th>
							<th width="7%">ED</th>
							<th width="6%">HARGA<br/>SATUAN</th>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th width='4%'>".$array_bln[$b]."</th>";
								}
							?>
							<th width="6%">TOTAL<br/>TERIMA</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='20'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$nobatch = $data['NoBatch'];
						
						// Penerimaan bulan
						$bln['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='01' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='01' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='02' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='02' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='03' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='03' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='04' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='04' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='05' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='05' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='06' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='06' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='07' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='07' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='08' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='08' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='09' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='09' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='10' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='10' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='11' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='11' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
						$bln['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE (MONTH(a.TanggalPenerimaan)>='12' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='12' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>							
							<td align="center"><?php echo $data['KodeBarang'];?></td>									
							<td align="left"><?php echo $data['NamaBarang'];?></td>									
							<td align="center">
								<?php 
									$noth = 0;
									$str_ta = "SELECT `TahunAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_ta = mysqli_query($koneksi,$str_ta);
									while($datata = mysqli_fetch_assoc($query_ta)){
										$noth = $noth + 1;
										echo str_replace(",", ", ", $noth.": ".$datata['TahunAnggaran'])."<br/>";
									}
								?>
							</td>							
							<td align="center">
								<?php 
									$nobt = 0;
									$str_batch = "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_batch = mysqli_query($koneksi,$str_batch);
									while($databatch = mysqli_fetch_assoc($query_batch)){
										$nobt = $nobt + 1;
										echo str_replace(",", ", ", $nobt.": ".$databatch['NoBatch'])."<br/>";
									}
								?>
							</td>							
							<td align="center">
								<?php 
									$noed = 0;
									$str_ed = "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_ed = mysqli_query($koneksi,$str_ed);
									while($dataed = mysqli_fetch_assoc($query_ed)){
										$noed = $noed + 1;
										echo str_replace(",", ", ", $noed.": ".date("d-m-Y", strtotime($dataed['Expire'])))."<br/>";
									}
								?>
							</td>
							<td align="center">
								<?php 
									$nohb = 0;
									$str_hb = "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_hb = mysqli_query($koneksi,$str_hb);
									while($datahb = mysqli_fetch_assoc($query_hb)){
										$nohb = $nohb + 1;
										echo str_replace(",", ", ", $nohb.": ".rupiah($datahb['HargaBeli']))."<br/>";
									}
								?>
							</td>		
							<?php
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$total[$no][] = $bln[$b]['Jumlah'];
							?>		
							<td align="right">
								<?php 
									if($bln[$b]['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($bln[$b]['Jumlah']);
									}
								?>
							</td>	
							<?php
								}
								$total = array_sum($total[$no]);
							?>							
							<td align="right"><?php echo rupiah($total);?></td>							
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
</body>
</html>