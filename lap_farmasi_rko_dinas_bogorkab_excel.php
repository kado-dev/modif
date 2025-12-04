<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	
	// get
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$namaprogram = $_GET['namaprogram'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Rencana_Kebutuhan_Obat (".$kota." ".$tahun.").xls");	
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>RENCANA KEBUTUHAN OBAT</b></span><br>
	<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo $tahun;?>
	</span>
</div><br/>

<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="2%">No</th>
						<th width="5%">Kode</th>
						<th width="20%">Nama Barang</th>
						<th width="5%">Satuan</th>
						<th width="5%">Harga</br>Satuan</th>
						<th width="5%">Stok Awal <br/> <?php //echo "Januari ".$tahun1?></th>
						<th width="5%">Penerimaan <br/> <?php //echo $tahun1?></th>
						<th width="5%">Total <br/>Persediaan
						<th width="5%">Pemakaian <br/>
						<th width="5%">Sisa Stok <br/>
						<th width="5%">Jumlah</br>Bulan Pemakaian <br/> <?php //echo $tahun1?></th>
						<th width="5%">Pemakaian</br>Rata2 /Bulan</th>
						<th width="5%">Jumlah</br>Kebutuhan</th>
						<th width="5%">Rencana</br>Kebutuhan Obat</th>
						<th width="5%">Total RKO</br>(Rp)</th>
						<th width="5%">Rencana</br>Pembelian</th>
						<th width="5%">Total Pembelian</br>(Rp)</th>
					</tr>	
				</thead>
				<tbody>
					<?php		
					if($namaprogram == "semua"){
						$str = "SELECT * FROM `ref_obat_lplpo` ORDER BY IdLplpo, NamaBarang";
					}else{
						$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram` = '$namaprogram'  GROUP BY KodeBarang, IdBarang ORDER BY NamaBarang";
					}
					//$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprogram'";
					//$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
					//echo $str;
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprograms != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>&nbsp $data[NamaProgram]</td></tr>";
							$namaprograms = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						
						// tbgfkstok, harga diambil dari tahun awal / anggaran terakhir
						$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT HargaBeli FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY TahunAnggaran DESC"));
						
						// stokawal, cukup berdasarkan kodebarang saja karena diambil dari ref_obat_lplpo
						$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Jumlah FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun1'"));
						if($dtstokawal['Jumlah'] != 0){
							$stokawals = $dtstokawal['Jumlah'];
						}else{
							$stokawals = "0";
						}
						
						// penerimaan
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPenerimaan`)='$tahun'"));
						if($dtpenerimaan['Jumlah'] != 0){
							$penerimaans = $dtpenerimaan['Jumlah'];
						}else{
							$penerimaans = "0";
						}
									
						// total persediaan
						$totalpersediaan = $stokawals + $penerimaans;
						
						// pemakaian
						$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NoFaktur, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun'"));
						if($dtpengeluaran['Jumlah'] != 0){
							$pengeluarans = $dtpengeluaran['Jumlah'];
						}else{
							$pengeluarans = "0";
						}
						
						// sisastok
						$sisastok = $totalpersediaan - $pengeluarans;
						
						// jumlah bulan
						$str_jmlbulan = "SELECT COUNT(b.TanggalPengeluaran) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun' GROUP BY YEAR(b.TanggalPengeluaran), MONTH(b.TanggalPengeluaran)";
						$dt_jumlahbulan = mysqli_num_rows(mysqli_query($koneksi, $str_jmlbulan));
						
						// pemakaian rata-rata
						$pemakaian_rata = $pengeluarans / $dt_jumlahbulan;
						if($pemakaian_rata != 0){
							$pemakaian_ratas = $pemakaian_rata;
						}else{
							$pemakaian_ratas = "0";
						}
						
						// jumlah kebutuhan
						$jumlah_kebutuhan = $pemakaian_ratas * 18;
						
						// rencana kebutuhan
						$rencana_kebutuhan = $jumlah_kebutuhan - $sisastok;
						
						// total_rencana kebutuhan
						$total_rko = $rencana_kebutuhan * $dtgfkstok['HargaBeli'];							
					?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $kodebarang;?></td>
							<td style="text-align:left;" class="namabarangcls"><?php echo strtoupper($namabarang);?></td>
							<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:right;"><?php echo rupiah($dtgfkstok['HargaBeli']);?></td>
							<td style="text-align:right;"><?php echo rupiah($stokawals);?></td>
							<td style="text-align:right;"><?php echo rupiah($penerimaans);?></td>
							<td style="text-align:right;"><?php echo rupiah($totalpersediaan);?></td>
							<td style="text-align:right;"><?php echo rupiah($pengeluarans);?></td>
							<td style="text-align:right;"><?php echo rupiah($sisastok);?></td>
							<td style="text-align:right;"><?php echo $dt_jumlahbulan;?></td>
							<td style="text-align:right;"><?php echo rupiah($pemakaian_ratas);?></td>
							<td style="text-align:right;"><?php echo rupiah($jumlah_kebutuhan);?></td>
							<td style="text-align:right;"><?php echo rupiah($rencana_kebutuhan);?></td>
							<td style="text-align:right;"><?php echo rupiah($total_rko);?></td>
							<td style="text-align:right;"></td>
							<td style="text-align:right;"></td>
						</tr>
					<?php
						}
					?>
					</tbody>
			</table>
		</div>
	</div>
</div>