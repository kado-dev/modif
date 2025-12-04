<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	$key = $_GET['key'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kartu_Stok (".$key.").xls");
	if(isset($key)){
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
.font22{
	font-size:22px;
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KARTU STOK</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $hariini;?></p><br/>
</div>
<br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th>No.</th>
					<th>Kode Obat</th>
					<th>Nama Obat</th>
					<th>Stok Awal</th>
					<th>Penerimaan</th>
					<th>Pengeluaran</th>
					<th>Sisa Stok</th>
					<th>Harga Sat.</th>
					<th>Saldo</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 0;				
			$str = "SELECT * FROM `tbgfkstok` WHERE (`KodeBarang` like '%$key%' OR `NamaBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%') AND `SumberAnggaran` != 'BLUD'";	
			$str2 = $str." ORDER BY `NamaBarang` ASC";	
			// echo $str2;
			
			$query = mysqli_query($koneksi, $str2);	
			while($dtobat=mysqli_fetch_assoc($query)){
				$no = $no+1;
				$kodeobat = $dtobat['KodeBarang'];
				$namaobat = $dtobat['NamaBarang'];
				$nobatch = $dtobat['NoBatch'];
				$stok = $dtobat['Stok'];
				$harga = $dtobat['HargaBeli'];
				
				// tahap1, stok awal, ini ngambil sisa stok yang bulan des 2019
				$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'";
				$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
				if ($dt_stokawal_dtl['Stok'] != null){
					$stokawal = $dt_stokawal_dtl['Stok'];
				}else{
					$stokawal = '0';
				}				
				
				// tahap2, penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
				if($kota == "KABUPATEN BEKASI"){
					$str_penerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodeobat ' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan) > '2019' AND a.NomorPembukuan='$dtobat[NoFakturTerima]'";
				}else{
					$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$dtobat[NoFakturTerima]'";
				}	
				
				$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
				if ($dt_penerimaan_dtl['Jumlah'] != null){
					$penerimaan = $dt_penerimaan_dtl['Jumlah'];
				}else{
					$penerimaan = '0';
				}
				
				// tahap3, pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
				if ($kota == "KABUPATEN BEKASI"){
					$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodeobat' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'";
				}else{
					$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch` = '$nobatch' AND NoFaktur != '' ";
				}	
				// echo $str_pengeluaran;
				
				$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
				if ($dt_pengeluaran_dtl['Jumlah'] != null){
					$pengeluaran = $dt_pengeluaran_dtl['Jumlah'];
				}else{
					$pengeluaran = '0';
				}
				
				// tahap4, karantina
				$str_karantina = "SELECT SUM(a.Jumlah) AS Jumlah , b.TanggalKarantina, b.NoFaktur, b.StatusKarantina FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodeobat' AND a.`NoBatch`='$nobatch'";
				$dt_karantina = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
				if ($dt_karantina['Jumlah'] != null){
					$karantina = $dt_karantina['Jumlah'];
				}else{
					$karantina = '0';
				}
				
				$pengeluarantotal = $pengeluaran + $karantina;
				
				// tahap4, sisastok, jika penerimaan 0, ngambil dari stok awal
				if($penerimaan == 0){
					$sisastok = $stokawal - $pengeluaran - $karantina;
				}else{
					$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina;
				}	
				$saldo = $sisastok * $harga;
			?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="center"><?php echo $kodeobat;?></td>
					<td align="left">
						<?php 
						// stok awal master
						$dtsomaster = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'"));
						if($dt_penerimaan_dtl['NomorPembukuan'] == ""){
							$nopembukuan = "SO ".$dtsomaster['Keterangan'];	
						}else{
							$nopembukuan = $dtobat['NoFakturTerima'];
						}	
						
						// penerimaan
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$nopembukuan'"));
						$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
						if ($dtsupplier['nama_prod_obat'] == ""){
							$dtsupp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfksupplier` WHERE `KodeSupplier`='$dtpenerimaan[KodeSupplier]'"));
							$supplier = $dtsupp['Supplier'];
						}else{
							$supplier = $dtsupplier['nama_prod_obat'];	
						}	
														
							
						// cek tanggal terima
						if ($dtpenerimaan['TanggalPenerimaan'] == ""){
							$tglterima = $dtsomaster['Bulan']."-".$dtsomaster['Tahun'];
						}else{
							$tglterima = date("d-m-Y", strtotime($dtpenerimaan['TanggalPenerimaan']));
						}	
						
						if($kota == "KABUPATEN BANDUNG"){
							$stsanggaran = "Status Anggaran : ".$dtobat['StatusAnggaran'];
						}	
						
						echo "<b>".$namaobat."</b><br/>".
						"No.Batch : ".$nobatch."<br/>".
						"Expire : ".date('d-m-Y', strtotime($dtobat['Expire']))."<br/>".
						"Sumber : ".$dtobat['SumberAnggaran']." - ".$dtobat['TahunAnggaran']."<br/>".
						$stsanggaran.
						"Tgl.Terima : ".$tglterima."<br/>".
						"Supplier : ".$supplier."<br/>".
						"Faktur Terima : ".$nopembukuan."<br/>".
						"Program : ".$dtobat['NamaProgram'];
						?>
					</td>
					<td align="right"><?php echo rupiah($stokawal);?></td>
					<td align="right"><?php echo rupiah($penerimaan);?></td>
					<td align="right"><?php echo rupiah($pengeluarantotal);?></td>
					<td align="right"><?php echo rupiah($sisastok);?></td>
					<td align="right">
						<?php
						$cx = strpos($harga, ".");
						// $cx = strpos($harga, ",");
						if($cx > 0){
							echo number_format($harga,2,",",".");
						}else{
							echo rupiah($harga);
						}
						?>	
					</td>
					<td align="right">
						<?php 
							// echo rupiah($saldo);
							$cx = strpos($saldo, ",");

							if($cx > 0){
								echo number_format($saldo,2,",",".");
							}else{
								echo rupiah($saldo);
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
<?php
}
?>