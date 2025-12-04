<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	// get
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$tahun2 = $tahun - 2;
	$tahun3 = $tahun + 1;
	$namaprogram = $_GET['namaprogram'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=RKO UPTD FARMASI (".$tahun.").xls");
	if(isset($tahun)){
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
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>RKO UPTD FARMASI</b></span><br>
	<span class="font12" style="margin:15px 5px 5px 5px;">Periode Laporan: <?php echo $tahun;?></span><br>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table id="" class="table-judul-form" border="1">
        <thead>
			<tr>
				<th width="3%">No</th>
				<th width="27%">Nama Barang</th>
				<th width="5%">Satuan</th>
				<th width="5%">Harga Satuan</th>
				<th width="5%">Stok Akhir <?php echo "Desember ".$tahun2?></th>
				<th width="5%"><?php echo "Penerimaan ".$tahun2?></th>
				<th width="5%">Total Persediaan</th>
				<th width="5%"><?php echo "Pemakaian ".$tahun2?></th>
				<th width="5%">Sisa Stok</th>
				<th width="5%">Jumlah Bulan Pemakaian</th>
				<th width="5%">Pemakaian Rata2 Per-Bulan</th>
				<th width="5%">Jumlah Kebutuhan</th>
				<th width="5%">Rencana Kebutuhan <br/> Obat</th>
				<th width="5%">Total Rupiah RKO</th>
				<th width="5%">Rencana Pembelian</th>
				<th width="5%">Total Rupiah Pembelian</th>
			</tr>
		</thead>								
        <tbody>
		<?php
			if($namaprogram == "Semua" || $namaprogram == ""){
				$program = "";
			}else{
				$program = "AND `NamaProgram`='$namaprogram'";
			}
				
			// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
			$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%') ".$program;
			$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
			// echo $str2;
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				if($namaprogram != $data['NamaProgram']){
					if($data['NamaProgram'] == "PKD"){
						$prg = "OBAT (PKD)";	
					}else{
						$prg = $data['NamaProgram'];
					}	
					echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$prg</td></tr>";
					$namaprogram = $data['NamaProgram'];
				}
				
				$no = $no + 1;
				$kodebarang = $data['KodeBarang'];
				$namabarang = $data['NamaBarang'];
				$nobatch = $data['NoBatch'];
				
				// hargabeli
				$hargabeli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY `IdBarang` DESC"));
				
				// stokawal
				$strstokmaster = "SELECT SUM(Stok) AS Jumlah FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
				// echo $strstokmaster;
				$dtstokmaster = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokmaster));
				$jumlahmaster = $dtstokmaster['Jumlah'];
				
				$strpenerimaanlalu = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan = b.NomorPembukuan
				WHERE YEAR(a.`TanggalPenerimaan`)<'$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
				// echo $strpenerimaanlalu;
				$dtpenerimaanlalu = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaanlalu));
				$jumlahterimalalu = $dtpenerimaanlalu['Jumlah'];
				
				$strpengeluaranlalu = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
				WHERE YEAR(a.`TanggalPengeluaran`)<'$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
				// echo $strpengeluaranlalu;
				$dtpengeluaranlalu = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaranlalu));
				$jumlahkeluarlalu = $dtpengeluaranlalu['Jumlah'];
				
				$stokawal = $jumlahmaster + $jumlahterimalalu - $jumlahkeluarlalu;		
				
				// penerimaan
				$strpenerimaan = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan = b.NomorPembukuan
				WHERE YEAR(a.`TanggalPenerimaan`)='$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
				$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
				$jumlahterima = $dtpenerimaan['Jumlah'];
				
				// pemakaian
				$strpengeluaran = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
				WHERE YEAR(a.`TanggalPengeluaran`)='$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
				$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
				$jumlahkeluar = $dtpengeluaran['Jumlah'];	
				
				// persediaan
				$persediaan = $stokawal + $jumlahterima;
				
				// sisa stok
				$sisastok = $persediaan - $jumlahkeluar;
				
				// bulan pemakaian
				$bulanpemakaian = mysqli_num_rows(mysqli_query($koneksi, "SELECT b.TanggalPengeluaran FROM `tbgfkpengeluarandetail` a
				JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
				WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran)='$tahun2'
				GROUP BY MONTH(TanggalPengeluaran)"));
				
				// pemakaian rata-rata
				$pemakaianrata = $jumlahkeluar / $bulanpemakaian;
				
				// jumlah kebutuhan
				$jumlahkebutuhan = $pemakaianrata * 18;
				
				// rencana kebutuhan
				if($jumlahkebutuhan == 0){
					$rencanakebutuhan = $sisastok;
				}else{	
					$rencanakebutuhan = $jumlahkebutuhan - $sisastok;
				}
				
				// total rupiah rko
				$totalrupiahrko = $rencanakebutuhan * $hargabeli['HargaBeli'];
				
				?>
				<tr>
					<td style="text-align:right;"><?php echo $no;?></td>
					<td style="text-align:left;" class="namabarangcls">
					<?php 
						echo strtoupper($namabarang)."<br/>";
						// echo $data['KodeBarang']."<br/>";
						// echo "<b>Keterangan :</b><br/>";
						// echo "Stok Master = ".$jumlahmaster."<br/>";
						// echo "Penerimaan Lalu = ".$jumlahterimalalu."<br/>";
						// echo "Pengeluaran Lalu = ".$jumlahkeluarlalu."<br/>";
						// echo "Saldo Awal = ".$stokawal;
					?>
					</td>
					<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
					<td style="text-align:right;"><?php echo rupiah($hargabeli['HargaBeli']);?></td>
					<td style="text-align:right;"><?php echo rupiah($stokawal);?></td><!--Stokawal-->
					<td style="text-align:right;"><?php echo rupiah($jumlahterima);?></td><!--Penerimaan-->
					<td style="text-align:right;"><?php echo rupiah($persediaan);?></td><!--Total Persediaan-->
					<td style="text-align:right;"><?php echo rupiah($jumlahkeluar);?></td><!--Pemakaian-->
					<td style="text-align:right;"><?php echo rupiah($sisastok);?></td><!--Sisa Stok-->
					<td style="text-align:right;"><?php echo $bulanpemakaian;?></td><!--Jumlah Bulan Pemakaian-->
					<td style="text-align:right;"><?php echo rupiah(ceil($pemakaianrata));?></td><!--Pemakaian Rata2 PerBulan-->
					<td style="text-align:right;"><?php echo rupiah(ceil($jumlahkebutuhan));?></td><!--Jumlah Kebutuhan-->
					<td style="text-align:right;"><?php echo rupiah(ceil($rencanakebutuhan));?></td><!--Rencana Kebutuhan Obat-->
					<td style="text-align:right;"><?php echo rupiah($totalrupiahrko);?></td><!--Total Rupiah RKO-->
					<td style="text-align:center;">-</td><!--Rencana Pembelian-->
					<td style="text-align:center;">-</td><!--Total Rupiah Pembelian-->
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