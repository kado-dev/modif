<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$nofakturterima = $_GET['nf'];
	$key = $_GET['key'];	
	
	// tbstok
	$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kartu_Stok (".$kodebarang.").xls");
	if(isset($bulan) and isset($tahun)){
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


<div class="alert alert-success" role="alert">
	<table width="100%">
		<tr>
			<td width="10%">Kode Barang</td>
			<td width="88%"><?php echo ": ".$kodebarang;?></td>
		</tr>
		<tr>
			<td>Nama Barang</td>
			<td><?php echo ": ".$dtbrg['NamaBarang'];?></td>
		</tr>
		<tr>
			<td>No.Batch</td>
			<td><?php echo ": ".$nobatch;?></td>
		</tr>
		<tr>
			<td>Expire</td>
			<td><?php echo ": ".$dtbrg['Expire'];?></td>
		</tr>
		<tr>
			<td>Sumber</td>
			<td><?php echo ": ".$dtbrg['SumberAnggaran'];?></td>
		</tr>
		<tr>
			<td>Program</td>
			<td><?php echo ": ".$dtbrg['NamaProgram'];?></td>
		</tr>
	</table>	
</div><br/>	
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="4%">No.</th>
					<th width="10%">Tanggal</th>
					<th width="20%">No.Faktur</th>
					<th width="30%">Keterangan</th>
					<th>StokAwal</th>
					<th>Penerimaan</th>
					<th>Pengeluaran</th>
					<th>Sisa</th>
				</tr>
			</thead>
			<tbody>
				<?php	
					$no = 0;
					$bulan = $_GET['bulan'];
					$tahun = $_GET['tahun'];
					$penerimabrg = $_GET['penerimabrg'];
					
					// stok awal
					// ini ngambil sisa stok yang bulan des 2019
					if($bulan != ''){
						$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch' AND Bulan = '$bulan' AND Tahun = '$tahun'";
					}else{
						$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
					}
					
					$query_stokawal = mysqli_query($koneksi, $str_stokawal);
					while($dt_stokawal = mysqli_fetch_assoc($query_stokawal)){
						$no = $no + 1;
						$faktur_terima = $dt_stokawal['NomorPembukuan'];
						$jml_stokawal = $dt_stokawal['Stok'];
						$tanggal_stokawal = $dt_stokawal['Bulan']." ".$dt_stokawal['Tahun'];
						$semua_jml_terima = 0;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $tanggal_stokawal;?></td>
							<td align="center">-</td>
							<td align="left"><?php echo "SO BULAN ".$tanggal_stokawal;?></td>
							<td align="right"><?php echo number_format($jml_stokawal, 0, ".", ".");?></td>
							<td align="center"></td>
							<td align="center"></td>
							<td align="center"></td>
						</tr>	
					<?php
						}
					
					// penerimaan
					// jika bekasi ngambil dari penerimaan yang tahunnya > 2019
					if ($kota == "KABUPATEN BEKASI"){
						$str_terima = "SELECT * FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang ' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan) > '2019'";
					}else if($kota == "KABUPATEN BOGOR"){
						if($bulan != ''){
							$str_terima = "SELECT * FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan WHERE a.KodeBarang='$kodebarang ' AND a.NoBatch='$nobatch' AMD YEAR(b.TanggalPenerimaan) = '$tahun' AND MONTH(b.TanggalPenerimaan) = '$bulan' AND a.NomorPembukuan='$nofakturterima'";
						}else{
							$str_terima = "SELECT * FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch' AND NomorPembukuan='$nofakturterima'";
						}											
					}else{
						$str_terima = "SELECT * FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch' AND NomorPembukuan='$nofakturterima'";
					}	
					


					$query_terima = mysqli_query($koneksi, $str_terima);
					while($dt_terima = mysqli_fetch_assoc($query_terima)){
						$no = $no + 1;
						$faktur_terima = $dt_terima['NomorPembukuan'];
						$jml_terima = $dt_terima['Jumlah'];
						$stokterima[] = $jml_terima;
						$ttl_terima = array_sum($stokterima);
						
						// detail penerimaan
						$dt_penerimaan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$faktur_terima'"));
						$tanggal_terima  = $dt_penerimaan['TanggalPenerimaan'];
						$keterangan_terima = $dt_penerimaan['KodeSupplier'];
						
						// ref_pabrik
						$dtpabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dt_penerimaan[KodeSupplier]'"));
						$semua_jml_terima = $semua_jml_terima + $jml_terima;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $tanggal_terima;?></td>
							<td align="center"><?php echo $faktur_terima;?></td>
							<td align="left"><?php echo $dtpabrik['nama_prod_obat'];?></td>
							<td align="center"></td>
							<td align="right"><?php echo number_format($jml_terima, 0, ".", ".");?></td>
							<td align="center"></td>
							<td align="right"><?php echo number_format($semua_jml_terima, 0, ".", ".");?></td>
						</tr>	
					<?php
						}
						
					// detail pengeluaran
					// jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
					$no = 0;
					if ($kota == "KABUPATEN BEKASI"){
						if($bulan != ""){
							$waktu = " AND YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) = '$bulan'";
							$str_keluar = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'".$waktu." ORDER BY b.TanggalPengeluaran";
						}else{
							$str_keluar = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019' ORDER BY b.TanggalPengeluaran";
						}	
					}else if($kota == "KABUPATEN BOGOR"){
						if($bulan != ""){
							$waktu = " AND YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) = '$bulan'";
						}else{
							$waktu = "";
						}	
						$str_keluar = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.KodeBarang ='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NoFakturTerima`='$nofakturterima'".$waktu." ORDER BY b.TanggalPengeluaran";
					}else{
						$str_keluar = "SELECT * FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
					}	
					// echo $str_keluar;
					$sisa_stoks = $semua_jml_terima + $jml_stokawal;

					$query_keluar = mysqli_query($koneksi, $str_keluar);
					while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
						$no = $no + 1;
						$nofaktur = $dt_keluar['NoFaktur'];
						
						
						// pengeluaran
						if($penerimabrg != ""){
							$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur' AND `Penerima` LIKE '%$penerimabrg%'"));
						}else{
							$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur'"));
						}											
						
						if($kota == "KABUPATEN BEKASI"){
							$tanggal_keluar  = $dt_distribusi['TanggalEntry'];
						}else{
							$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];	
						}	
						$faktur_keluar  = $dt_distribusi['NoFaktur'];
						$keterangan_keluar = $dt_distribusi['Penerima'];
						
						if($kota == "KABUPATEN BEKASI"){
							$faktur_keluar = $dt_distribusi['NoFakturManual'];
						}else{
							$faktur_keluar = $dt_distribusi['NoFaktur'];
						}	

						if($tanggal_keluar != '' or $faktur_keluar != ''){
						$jml_keluar = $dt_keluar['Jumlah'];			
						$stokkeluar[] = $jml_keluar;
						$ttl_keluar = array_sum($stokkeluar);
						$sisa_stoks = $sisa_stoks - $jml_keluar;
					?>	
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $tanggal_keluar;?></td>
							<td align="center"><?php echo $faktur_keluar;?></td>
							<td align="left"><?php echo $keterangan_keluar;?></td>
							<td align="center"></td>
							<td align="center"></td>
							<td align="right"><?php echo number_format($jml_keluar, 0, ".", ".");?></td>
							<td align="right"><?php echo number_format($sisa_stoks, 0, ".", ".");?></td>
						</tr>
					<?php
						}
						}
						
					// karantina
						$no = 0;
						$str_karantina = "SELECT SUM(a.`Jumlah`) AS Jumlah , b.TanggalKarantina, b.NoFaktur, b.StatusKarantina FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'";
						$query_karantina = mysqli_query($koneksi, $str_karantina);
						while($dt_karantina = mysqli_fetch_assoc($query_karantina)){
							$no = $no + 1;
							$tanggal_karantina = $dt_karantina['TanggalKarantina'];	
							$faktur_karantina = $dt_karantina['NoFaktur'];	
							$keterangan_karantina = "GUDANG KARANTINA - ".strtoupper($dt_karantina['StatusKarantina']);	
							$jml_karantina = $dt_karantina['Jumlah'];	
							$stokkarantina[] = $jml_karantina;
							$ttl_karantina = array_sum($stokkarantina);
							$sisa_stoks = $sisa_stoks - $jml_karantina;
							
							if($dt_karantina['Jumlah'] != 0){
						?>	
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $tanggal_karantina;?></td>
								<td align="center"><?php echo $faktur_karantina;?></td>
								<td align="left"><?php echo $keterangan_karantina;?></td>
								<td align="center"></td>
								<td align="center"></td>
								<td align="right"><?php echo number_format($jml_karantina, 0, ".", ".");?></td>
								<td align="right"><?php echo number_format($sisa_stoks, 0, ".", ".");?></td>
							</tr>
						<?php
							}
							}
						?>	
			</tbody>
		</table><br/><br/>
		<table class="table table-judul-form"  width="100%">
		<tbody>
			<tr style="background: #fff4b7; font-weight: bold;">
				<td colspan="7">Jumlah Pengeluaran <?php echo nama_bulan($bulan);?></td>
				<td align="right"><?php echo number_format($ttl_keluar + $ttl_karantina, 0, ".", ".");?></td>
			</tr>
			<tr style="background: #ffce8e; font-weight: bold;">
				<td colspan="7"> Sisa Stok</td>
				<td align="right">
					<?php  
						$sisastok =  $jml_stokawal + $ttl_terima - $ttl_keluar - $ttl_karantina;
						echo number_format($sisastok, 0, ".", ".");
					?>
				</td>
			</tr>
		</tbody>
	</table><hr/>
	</div>
</div>
<?php
}
?>