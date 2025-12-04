<?php
	error_reporting(0);
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
	// get data
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$statuspengeluaran = $_GET['statuspengeluaran'];
	$penerima = $_GET['penerima'];
	$kodebarang = $_GET['kodebarang'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Vaksin_Distribusi_Unit (".$kota." ".$hariini.").xls");
	// if(isset($bulanawal) and isset($tahunakhir)){
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>DETAIL DISTRIBUSI BARANG (PER-UNIT)</b></span><br>
	<!--<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?>
	</span>-->
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">No.</th>
					<th width="5%">Tgl.Pengeluaran</th>
					<th width="52%">Nama Barang</th>
					<th width="10%">Nama Program</th>
					<th width="10%">Harga Satuan</th>
					<th width="10%">Jumlah</th>
					<th width="10%">Sub Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($statuspengeluaran == "SEMUA"){
						$status = " ";
					}else{
						$status = "AND a.`StatusPengeluaran`='$statuspengeluaran'";
					}
											
					$str = "SELECT * FROM tbgfk_vaksin_pengeluaran a JOIN tbgfk_vaksin_pengeluarandetail b ON a.NoFaktur=b.NoFaktur 
					WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' 
					AND a.Penerima LIKE '%$penerima%' AND b.KodeBarang = '$kodebarang' ".$status;
					$str2 = $str;
					// echo $str2;	
										
					$query = mysqli_query($koneksi,$str2);
					while ($dt_brg = mysqli_fetch_assoc($query)){
						if($nomorfaktur != $dt_brg['NoFaktur']){
							$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
							FROM tbgfk_vaksin_pengeluarandetail a JOIN tbgfk_vaksin_pengeluaran b ON a.NoFaktur = b.NoFaktur
							WHERE a.NoFaktur = '$dt_brg[NoFaktur]'";
							$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
							$harga = rupiah($dtgt['Jumlah']);
							echo "<tr style='border:1px solid #000; font-weight: bold; background: #adabab;'>
									<td colspan='7'>$dt_brg[NoFaktur], $dt_brg[Penerima], Rp.$harga</td>
								 </tr>";
							$nomorfaktur = $dt_brg['NoFaktur'];
							$no = 0;
						}
						$no = $no + 1;								
						
						// tbgfk_vaksin_stok
						$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`NoBatch` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
						$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
				?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $dt_brg['TanggalPengeluaran'];?></td>
						<td><?php echo $dtgfkstok['NamaBarang'].", Batch : ".$dt_brg['NoBatch'];?></td>
						<td><?php echo $dt_brg['NamaProgram'];?></td>
						<td><?php echo rupiah($dt_brg['Harga']);?></td>
						<td><?php echo $dt_brg['Jumlah'];?></td>
						<td><?php echo rupiah($subtotal);?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table><br/>
	</div>
</div>