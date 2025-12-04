<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	
	// get
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$namaprogram = $_GET['namaprogram'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Napza (".$kota." ".$tahun.").xls");	
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>NAPZA</b></span><br>
	<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahun;?>
	</span>
</div><br/>

<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive text-nowrap">
			<table class="table table-condensed" border="1">
				<thead>
					<tr style="border:1px solid #000;">
						<th>No.</th>
						<th>Kode</th>
						<th>Nama Obat</th>
						<th>Satuan</th>
						<th>Saldo Awal</th>
						<th>Penerimaan</th>
						<th>Persediaan</th>
						<th>Pengeluaran</th>
						<th>Sisa Stok</th>
					</tr>
				</thead>
				<tbody>
				<?php
					// gudang besar
					$strnarkotika = "SELECT * FROM `tbgfkstok` WHERE `GolonganFungsi` = 'NARKOTIKA' GROUP BY KodeBarang ORDER BY NamaBarang";
					// echo $strnarkotika;
					
					$query_psk = mysqli_query($koneksi, $strnarkotika);
					while($dt_psk = mysqli_fetch_assoc($query_psk)){
						$no = $no + 1;
						$kodebarang = $dt_psk['KodeBarang'];
						$namabarang = $dt_psk['NamaBarang'];
						$satuan = $dt_psk['Satuan'];
						$harga = $dt_psk['HargaBeli'];
						
						// tbstokbulanandinas
						$stokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokAwalSistem) AS Jumlah FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang'
						AND `Tahun`='$tahun' AND Bulan BETWEEN '$bulanawal' AND '$bulanakhir'"));
						if($stokawal['Jumlah'] != 0){
							$stokawals = $stokawal['Jumlah'];
						}else{
							$stokawals = 0;
						}	
							
						// penerimaan
						$str_trm = "SELECT SUM(b.Jumlah) AS Jumlah FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE YEAR(a.TanggalPenerimaan)='$tahun' AND MONTH(a.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir' AND b.KodeBarang = '$kodebarang'";	
						$query_trm = mysqli_query($koneksi, $str_trm);
						$dt_trm = mysqli_fetch_assoc($query_trm);
						
						if($dt_trm != null){
							$jml_terima = $dt_trm['Jumlah'];
						}else{
							$jml_terima = '0';
						}
						
						// pengeluaran
						$str_prn = "SELECT SUM(b.Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
						WHERE YEAR(a.TanggalPengeluaran)='$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulanawal' AND '$bulanakhir' AND b.KodeBarang = '$kodebarang'";	
						$query_prn = mysqli_query($koneksi, $str_prn);
						$dt_prn= mysqli_fetch_assoc($query_prn);
						
						if($dt_prn != null){
							$jml_pengeluaran = $dt_prn['Jumlah'];
						}else{
							$jml_pengeluaran = '0';
						}
						
						$jml_persediaan = $stokawal['Jumlah'] + $jml_terima;
						$stok_akhir = $stokawal['Jumlah'] + $jml_terima - $jml_pengeluaran;
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $kodebarang;?></td>
						<td><?php echo $namabarang;?></td>
						<td><?php echo $satuan;?></td>
						<td><?php echo rupiah($stokawals);?></td>
						<td><?php echo rupiah($jml_terima);?></td>
						<td><?php echo rupiah($jml_persediaan);?></td>
						<td><?php echo rupiah($jml_pengeluaran);?></td>
						<td><?php echo rupiah($stok_akhir);?></td>	
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>