<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$bulan = $_GET['bl'];
	$tahun = $_GET['th'];
	$sumberanggaran = $_GET['sa'];
	$telepon = $_SESSION['telepon'];
	$fax = $_SESSION['fax'];
	
	if($kota == 'KABUPATEN BOGOR'){
		$filelogo = "bogorkab.png";
	}else if($kota == 'KABUPATEN BEKASI'){
		$filelogo = "bekasikab.png";
	}else{
		$filelogo = "bandungkab.png";
	}
?>

<style>
body{
	font-family: "Arial Narrow";
	
}	
.logokab{
	width: 55px;
	height: 65px;
	margin-left: 40px;
	margin-bottom: -70px;
	display: none;
}
.page {
  width: 21cm;
  height: 25cm;
  padding: 0.5cm;
  margin: 1cm auto;
  border: 1px #fff solid;
}
	
@media print{
	.logokab{
		display:block;
	}
}
</style>

<html lang="en">
<head>
	<title>SBBK</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<div class="page">
<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_besar_opnam_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>&bl=<?php echo $bulan;?>&th=<?php echo $tahun;?>&sa=<?php echo $sumberanggaran;?>'">
	<?php
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` where `NoFaktur` = '$nf'"));
	?>
	<img src="image/<?php echo $filelogo;?>" class="logokab">
	<div class="printheader" >
		<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br/>
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br/>
		<span class="font10" style="margin:5px;"><?php echo $alamat.", Telp.".$telepon.", Fax.".$fax;?></span>
		<hr style="margin:10px 5px 5px 5px; border:1px solid #000">
		<span class="font16" style="margin:50px;"><b>LAPORAN STOK OPNAME</b></span><br/>
		<span class="font14" style="margin:1px;">Periode Laporan : <?php echo nama_bulan($bulan)." ".$tahun;?></span><br/>
	</div><br/>
	
	<?php  
		$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
		$tgllaporan = $tgl[1] - 1;
		$tglpermintaan = $tgl[1];
	?>	
		
	<div class="row">
		<div class="table-responsive">
			<table class="table-judul-laporan" width="100%" style="font-size:12px;">
				<thead>
					<tr>
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
						<th rowspan="2" width="21%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Nama Barang</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Satuan</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Batch</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Tahun Anggaran</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Expire</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Harga Satuan</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Sistem</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Fisik</th>
					</tr>
				</thead>
				
				<tbody>
					<?php		
					// yang ada stoknya dan selain BLUD
					if($kota == "KABUPATEN BANDUNG"){
						$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' AND `SumberAnggaran` != 'BLUD'".$strcari;
					}else{
						$str = "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD'".$strcari;
					}	
					$str2 = $str." ORDER BY NamaBarang";
					// echo $str2;
										
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						$namaprogram = $data['NamaProgram'];
						$nobatch = $data['NoBatch'];
						$tahunanggaran = $data['TahunAnggaran'];
						$expire = $data['Expire'];
						$hargasatuan = $data['HargaBeli'];			
																
						// stok sistem, bekasi ngambil dari tbstokawalmaster_gudang_besar, untuk bulan januari (awal) saja selanjutnya ambil dari sisa akhir perbulan
						if($bulan == '01' AND $tahun == '2020'){
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
							// pengeluaran
							$jml_keluar = 0;
							if ($kota = "KABUPATEN BEKASI"){
								$str_keluar = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) = '$bulan'";
							}else{
								$str_keluar = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
							}	
							
							$query_keluar = mysqli_query($koneksi, $str_keluar);
							while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
								$nofaktur = $dt_keluar['NoFaktur'];
								$jml_keluar = $dt_keluar['Jumlah'];			
								$stokkeluar[] = $jml_keluar;
								$ttl_keluar = array_sum($stokkeluar);
							}
							$stoksistem = $dtstokawal['Stok'] - $jml_keluar;
						}else{
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));	
							$stoksistem = $dtstokawal['StokAwalSistem'];	
						}
												
						// sisaakhir tbstokbulanandinas, jangan pakai nomer faktur hilangkan aja
						$dtstokdinkes = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
						$selisih = $stoksistem - $dtstokdinkes['Stok'];
					?>
					
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px; display: none;" class="nofakturcls"><?php echo $nf;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px; display: none;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo str_replace(",", ", ", $nobatch);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px; display:none;" class="batchcls"><?php echo $nobatch;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tahunanggaran;?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $expire;?></td>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $hargasatuan;?></td>							
							<td style="text-align:right; border:1px solid #000; padding:3px; color:red;font-weight:bold" class="StokAwalSistem" data-isi="<?php echo $stoksistem;?>"><b><?php echo rupiah($stoksistem);?></b></td><!--stok sistem-->
							<td style="text-align:right; border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="sisaakhir">
								<?php 
									if($dtstokdinkes['Stok'] != 0){
										echo rupiah($dtstokdinkes['Stok']);
									}else{
										echo "-";												
									}
								?>
							</td><!--stok fisik-->
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</div>
</html>