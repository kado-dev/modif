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
		echo "document.location.href='index.php?page=lap_farmasi_distribusi_puskesmas';";
		echo "</script>";
		die();
	}	
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

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_distribusi_puskesmas&namaprogram=<?php echo $_GET['namaprogram'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&tahunawal=<?php echo $_GET['tahunawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI BARANG</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo $bulanawal." - ".$tahunawal." s/d ".$bulanakhir." - ".$tahunakhir?></span>
	</div><br/>
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table-judul-laporan-min">
				<thead style="font-size: 12px;">
					<tr>
						<th width="2%" rowspan="2">No.</th>
						<th width="4%" rowspan="2">Kode</th>
						<th width="10%" rowspan="2">Nama Obat & BMHP</th>
						<th width="4%" rowspan="2">Satuan</th>
						<th width="4%" rowspan="2">StokAwal</th>
						<th width="4%" rowspan="2">Penerimaan</th>
						<th width="4%" rowspan="2">Persediaan</th>
						<th colspan="6">Distribusi</th>
						<th width="6%" rowspan="2">Jumlah<br/>Distribusi</th>
						<th width="6%" rowspan="2">Sisa Stok</th>
					</tr>
					<tr>
						<th width="4%">Depot</th>
						<th width="4%">Poli</th>
						<th width="4%">IGD</th>
						<th width="4%">Ranap</th>
						<th width="4%">Poned</th>
						<th width="4%">Pustu</th>
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
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17' style='text-align: left;'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}							
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$kodebarangjkn = $data['KodeBarangJkn'];
						$harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaSatuan` FROM `tbgudangpkmstok` WHERE `KodeBarang` = '$kodebarang'"));
						
						// stokawal
						$stokawal_gudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokGudang) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal_depot= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokDepot) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPoli) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal_igd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokIgd) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal_ranap= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokRanap) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal_poned = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPoned) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal_pustu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPustu) AS Jumlah 
								FROM tbstokopnam_puskesmas_detail 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
						$stokawal = $stokawal_gudang['Jumlah'] + $stokawal_depot['Jumlah'] + $stokawal_poli['Jumlah'] + $stokawal_igd['Jumlah'] +
									$stokawal_ranap['Jumlah'] + $stokawal_poned['Jumlah'] + $stokawal_pustu['Jumlah'];
						
						// penerimaan dinkes dan pengadaan jkn
						$gfkpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah 
								FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran)>='$bulanawal' AND YEAR(a.TanggalPengeluaran)='$tahunawal') AND (MONTH(a.TanggalPengeluaran)<='$bulanakhir' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`KodePenerima`='$kodepuskesmas'"));
						$gudangpengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengadaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah 
								FROM tbgudangpkmpengadaan a JOIN tbgudangpkmpengadaandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengadaan)>='$bulanawal' AND YEAR(a.TanggalPengadaan)='$tahunawal') AND (MONTH(a.TanggalPengadaan)<='$bulanakhir' AND YEAR(a.TanggalPengadaan)='$tahunakhir') AND b.KodeBarang = '$kodebarangjkn' AND SUBSTRING(a.`NoFaktur`,1,11)='$kodepuskesmas'"));
						$penerimaan = $gfkpengeluaran['Jumlah'] + $gudangpengadaan['Jumlah'];
						
						// persediaan
						$persediaan = $stokawal + $penerimaan; 
						
						// distribusi
						$depot = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal') AND (MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir') AND b.KodeBarang = '$kodebarangjkn' AND a.`Penerima`='LOKET OBAT' AND a.KodePuskesmas = '$kodepuskesmas'"));
						$poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal') AND (MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima` like '%POLI%' AND a.KodePuskesmas = '$kodepuskesmas'"));
						$pustu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal') AND (MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='PUSTU' AND a.KodePuskesmas = '$kodepuskesmas'"));
						$poned = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal') AND (MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='PONED' AND a.KodePuskesmas = '$kodepuskesmas'"));
						$rawatinap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal') AND (MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='RAWAT INAP' AND a.KodePuskesmas = '$kodepuskesmas'"));
						$igd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal') AND (MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir') AND b.KodeBarang = '$kodebarang'  AND a.`Penerima`='IGD' AND a.KodePuskesmas = '$kodepuskesmas'"));
						$jumlahdistribusi = $depot['Jumlah'] + $poli['Jumlah'] + $pustu['Jumlah'] + $poned['Jumlah'] + $rawatinap['Jumlah'] + $igd['Jumlah'];
						$sisastok = $persediaan - $jumlahdistribusi;
					?>
						<tr>
							<td style="text-align: center;"><?php echo $no;?></td>							
							<td style="text-align: center;" style="display: none;"><?php echo $data['KodeBarang'];?></td>									
							<td style="text-align: left;" class="namabarangcls" align="left"><?php echo $data['NamaBarang'];?></td>									
							<td style="text-align: center;"><?php echo $data['Satuan'];?></td>							
							<td style="text-align: right;">
								<?php 
									if($stokawal == ""){
										echo "0";
									}else{
										echo rupiah($stokawal);
									}
								?>
							</td>					
							<td style="text-align: right;">
								<?php 
									if($penerimaan == ""){
										echo "0";
									}else{
										echo rupiah($penerimaan);
									}
								?>
							</td>										
							<td style="text-align: right;"><?php echo rupiah($persediaan);?></td>										
							<td style="text-align: right;">
								<?php 
									if($depot['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($depot['Jumlah']);
									}
								?>
							</td>										
							<td style="text-align: right;">
								<?php 
									if($poli['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($poli['Jumlah']);
									}
								?>
							</td>		
							<td style="text-align: right;">
								<?php 
									if($igd['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($igd['Jumlah']);
									}
								?>
							</td>	
							<td style="text-align: right;">
								<?php 
									if($rawatinap['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($rawatinap['Jumlah']);
									}
								?>
							</td>	
							<td style="text-align: right;">
								<?php 
									if($poned['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($poned['Jumlah']);
									}
								?>
							</td>									
							<td style="text-align: right;">
								<?php 
									if($pustu['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($pustu['Jumlah']);
									}
								?>
							</td>
							<td style="text-align: right;"><?php echo rupiah($jumlahdistribusi);?></td>										
							<td style="text-align: right;"><?php echo rupiah($sisastok);?></td>											
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