<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$namaprogram = $_GET['namaprogram'];
	$bulanawal = $_GET['bulanawal'];
	$tahunawal = $_GET['tahunawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahunakhir = $_GET['tahunakhir'];
	
	if($bulanawal == ""){
		echo "<script>";
		echo "alert('Silahkan pilih bulan...');";
		echo "document.location.href='index.php?page=lap_farmasi_penerimaan_puskesmas';";
		echo "</script>";
		die();
	}	
	
	$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
?>

<html lang="en">
<head>
	<title>Distribusi</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
	
	<style>
		thead,th, td{
			text-align:center;border:1px solid #000; padding:3px;
		}
	</style>
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_penerimaan_puskesmas&namaprogram=<?php echo $_GET['namaprogram'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&tahunawal=<?php echo $_GET['tahunawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN BARANG</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo $bulanawal." - ".$tahunawal." s/d ".$bulanakhir." - ".$tahunakhir?></span>
	</div><br/>
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table-judul-laporan-min">
				<thead style="font-size: 12px;">
						<tr>
							<th width="2%" rowspan="2">No.</th>
							<th width="3%" rowspan="2" style="display: none;">Kode</th>
							<th width="15%" rowspan="2">Nama Obat & BMHP</th>
							<th width="5%" rowspan="2">Satuan</th>
							<th width="5%" rowspan="2">Harga<br/>Satuan</th>
							<th width="5%" rowspan="2">Expire</th>
							<th width="6%" rowspan="2">No.Batch</th>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th width='4%'>".$array_bln[$b]."</th>";
								}
							?>
							<th width="5%" rowspan="2">Total Penerimaan</th>
							<th width="5%" rowspan="2">Total Harga</th>
						</tr>
					</thead>
				<tbody style="font-size: 12px;">
					<?php
					$no = 0;
					
					if($namaprogram == "semua" || $namaprogram == ""){
						$program = "";
					}else{
						$program = "WHERE NamaProgram = '$namaprogram'";
					}
					
					$str = "SELECT * FROM `ref_obat_lplpo`".$program;
					$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
					// echo $str2;
											
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='20' style='text-align: left;'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}		
					
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						$satuan = $data['Satuan'];
						$kodebarangjkn = $data['KodeBarangJkn'];
						
						// tbgfkstok
						$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli`,`Expire`,`NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
						$harga = $dtgfk['HargaBeli'];
						$expire = $dtgfk['Expire'];
						$nobatch = $dtgfk['NoBatch'];
						if(empty($harga)){$harga = "0";}							
						if(empty($expire)){$expire = "-";}							
						if(empty($nobatch)){$nobatch = "-";}	
						
						// penerimaan bulan (APBD)
						$bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='01' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='01' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='02' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='02' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='03' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='03' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='04' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='04' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='05' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='05' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='06' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='06' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='07' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='07' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='08' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='08' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='09' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='09' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='10' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='10' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='11' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='11' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						$bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='12' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='12' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.KodePenerima = '$kodepuskesmas'"));
						
					?>
						<tr>
							<td style="text-align: center;"><?php echo $no;?></td>							
							<td style="text-align: center; display: none;"><?php echo $kodebarang;?></td>	
							<td style="text-align: left;" class="namabarangcls"><?php echo $namabarang;?></td>								
							<td style="text-align: center;"><?php echo $satuan;?></td>
							<td style="text-align: right;"><?php echo rupiah($harga);?></td>
							<td style="text-align: center;"><?php echo $expire;?></td>
							<td style="text-align: left;"><?php echo str_replace(",", ", ", $nobatch);?></td>
							<?php
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalapbd[$no][] = $bln_apbd[$b]['Jumlah'];
							?>	
							<td style="text-align: right;">
								<?php 
									if($bln_apbd[$b]['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($bln_apbd[$b]['Jumlah']);
									}
								?>
							</td>	
							<?php
								}
								$total_apbd = array_sum($totalapbd[$no]);
								$total = $total_apbd * $harga;
							?>							
							<td style="text-align: right;"><?php echo rupiah($total_apbd);?></td><!--Total APBD-->				
							<td style="text-align: right;"><?php echo rupiah($total);?></td><!--Total Keseluruhan-->				
						</tr>
					<?php	
					}	
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>