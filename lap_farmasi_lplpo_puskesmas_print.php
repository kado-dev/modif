<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$sumberanggaran = $_GET['sumberanggaran'];
	
	if($bulan == 1){
		$blnsebelumnya= '12';
		$thnsebelumnya = $tahun - 1;
	}else{
		$blnsebelumnya = $bulan - 1;
		if(strlen($blnsebelumnya) == 1){
			$blnsebelumnya = '0'.$blnsebelumnya;
		}
		$thnsebelumnya = $tahun;
	}
	
	$tblplpomanual_bandungkab = "tblplpomanual_bandungkab_".$kodepuskesmas;
?>

<html lang="en">
<head>
	<title>Register Lansia</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_lplpo_puskesmas&kodepuskesmas=<?php echo $kodepuskesmas?>&bulan=<?php echo $bulan?>&tahun=<?php echo $tahun?>&sumberanggaran=<?php echo $sumberanggaran?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN & LEMBAR PERMINTAAN OBAT (LPLPO)</b></span><br>
		<span class="font11" style="margin:1px;">PERIODE LAPORAN : <?php echo strtoupper(nama_bulan($bulan))." ".$tahun;?></span><br/>
	</div>
	
	<div class="atastabel">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:12px;">
				<tr>
					<td style="padding:2px 4px;">KODE PUSKESMAS</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">NAMA PUSKESMAS</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> 
						<?php 
							// data puskesmas
							$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPuskesmas` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'"));
							echo $datapuskesmas['NamaPuskesmas'];
						?>
					</td>
				</tr>
			</table>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table style="font-size:12px;">
				<tr>
					<td style="padding:2px 4px;">PELAPORAN BULAN</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;">
						<?php
							$bulandepan = $bulan + 1;
							echo strtoupper(nama_bulan($bulan));
						?>
					</td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">PEMINTAAN BULAN</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;">
					<?php 
						$bulandepan = $bulan + 1;
						echo strtoupper(nama_bulan($bulandepan));?>
					</td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<table class="table-judul-laporan-min" width="100%" style="font-size:13px;">
				<thead>
					<tr>
						<th width="2%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
						<th width="3%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">KODE</th>
						<th width="30%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
						<th width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">SATUAN</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">STOK AWAL</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PENERIMAAN</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PERSEDIAAN</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PEMAKAIAN</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">SISA AKHIR</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">STOK OPTIMUM</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PERMINTAAN</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PEMBERIAN</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">BATCH</th>
						<th width="6%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">KET.</th>
					</tr>
				</thead>
				<tbody>
					<?php	
					if ($sumberanggaran == 'APBD KAB/KOTA'){
						// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
					}elseif($sumberanggaran == 'APBN'){
						// ini obat blud ngambil dari tbgudangpkmstok
						$str = "SELECT * FROM `tbgudangpkmstok`
						WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
						$str2 = $str." ORDER BY NamaBarang ASC";
					}else{
						// ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
						$str = "SELECT * FROM `tbgudangpkmstok`
						WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'BLUD' GROUP BY NamaBarang";
						$str2 = $str." ORDER BY NamaBarang ASC";
					}						
					// echo $str2;
										
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='14'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}		
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
									
						// tahap1, stok awal ambil dari stok akhir bulan sebelumnya jika 0 ambil hasil import bulan ini
						$sisaakhir = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SisaAkhir` FROM `$tblplpomanual_bandungkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$thnsebelumnya' AND `Bulan`='$blnsebelumnya'"));
						$saldoawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal` FROM `$tblplpomanual_bandungkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
						if($sisaakhir['SisaAkhir'] != 0){
							$stokawal = $sisaakhir['SisaAkhir'];
						}else{
							$stokawal = $saldoawal['StokAwal'];
						}
						
						// tahap2, penerimaan digroup berdasar nama barang agar jika stoknya ada lebih dari 1 batch dia ngejumlahin
						$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
						FROM `tbgudangpkmpenerimaandetail` a
						JOIN tbgudangpkmpenerimaan b on a.NoFaktur = b.NoFaktur
						WHERE MONTH(b.TanggalPenerimaan) = '$bulan' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
						AND a.KodeBarang='$kodebarang'"));
						if($penerimaan['Jumlah'] != ''){
							$terima = $penerimaan['Jumlah'];
						}else{
							$terima = 0;
						}
						
						// pengadaan jkn
						$pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
						FROM `tbgudangpkmpengadaandetail` a
						JOIN `tbgudangpkmpengadaan` b on a.NoFaktur = b.NoFaktur
						WHERE MONTH(b.TanggalPengadaan) = '$bulan' AND YEAR(b.TanggalPengadaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
						AND a.KodeBarang='$kodebarang'"));				
						
						if($pengadaan['Jumlah'] != ''){
							$adaan = $pengadaan['Jumlah'];
						}else{
							$adaan = 0;
						}
						
						if($sumberanggaran != 'JKN'){
							$penerimaancls = $terima;
						}else{
							$penerimaancls = $adaan;
						}
						
						// persediaan
						$persediaan = $stokawal + $penerimaancls;
									
						// pemakaian
						$lplpomanual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tblplpomanual_bandungkab` WHERE `Tahun`='$tahun' AND `Bulan`='$bulan' AND `KodeBarang`='$kodebarang'"));
						$pemakaian = $lplpomanual['Pemakaian'];
						
						// sisa
						$sisa = $persediaan - $pemakaian;
						$stokoptimum = $sisa * 1.6;
										
						// permintaan
						if($lplpomanual['Permintaan'] != ''){
							$permintaans = $lplpomanual['Permintaan'];
						}else{
							$permintaans = 0;
						}		

					?>
						<tr style="border:1px solid #000;">
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td align="center" class="kodecls" style="border:1px solid #000; padding:3px;"><?php echo $data['KodeBarang'];?></td>
							<td align="left" style="border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td align="right" style="border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="stokawalcls"><?php echo rupiah($stokawal);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;" class="penerimaancls"><?php  echo rupiah($penerimaancls);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;" class="persediaancls"><?php echo $persediaan;?></td>
							<td align="right" style="border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="pemakaiancls"><?php echo rupiah($pemakaian);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;" class="sisacls"><?php echo rupiah($sisa);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;" class="stokoptimumcls"><?php echo rupiah($stokoptimum);?></td>
							<td align="right" style="border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="permintaancls"><?php echo rupiah($permintaans);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"></td>
							<td align="right" style="border:1px solid #000; padding:3px;"></td>
							<td align="center" style="border:1px solid #000; padding:3px;">
								<?php 
									if($sumberanggaran == "APBD KAB/KOTA"){
										echo "APBD";
									}else{
										echo $data['SumberAnggaran'];
									}			
										
								?>
							</td>
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