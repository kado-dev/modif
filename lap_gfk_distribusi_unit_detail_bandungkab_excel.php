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
	$tahun = $_GET['tahun'];
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$penerima = $_GET['penerima'];
	$namaprg = $_GET['namaprg'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Distribusi_Unit_Per-NamaProgram (".$kota." ".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI UNIT (PER-NAMA PROGRAM)</b></h4>
	<!--<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php //echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?></p><br/>-->
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<tbody width="100%">
				<?php
					/* buat menghitung total dalam periode yang dipilih*/
					$strttl = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
					FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND b.Penerima like '%$penerima%' ".$program;
					$dtttl = mysqli_fetch_assoc(mysqli_query($koneksi, $strttl));
				?>
				<tr>
					<td style="text-align:center;width:75%;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL KESELURUHAN</td>
					<td style="text-align:center;width:25%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($dtttl['Jumlah']);?></td>
				</tr>
			</tbody>
		</table><br/>
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="5%">TGL.PENGELUARAN</th>
					<th width="25%">NAMA BARANG</th>
					<th width="10%">NAMA PROGRAM</th>
					<th width="10%">HARGA SATUAN</th>
					<th width="10%">JUMLAH</th>
					<th width="10%">SUB TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($namaprg == "Semua" || $namaprg == ""){
						$program = "";
					}else{
						$program = "AND b.`NamaProgram`='$namaprg'";
					}
				
					$str = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur=b.NoFaktur 
					WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' 
					AND a.Penerima LIKE '%$penerima%'".$program;
					
					$query = mysqli_query($koneksi,$str);
					while ($dt_brg = mysqli_fetch_assoc($query)){
						if($nomorfaktur != $dt_brg['NoFaktur']){
							echo "<tr style='border:1px solid #000; font-weight: bold; background: #adabab;'><td colspan='7'>$dt_brg[NoFaktur] ($dt_brg[Penerima])</td></tr>";
							$nomorfaktur = $dt_brg['NoFaktur'];
						}
						
						$no = $no + 1;
						
						// tbgfkstok
						$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
						$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
						<td align="left"><?php echo $dtgfkstok['NamaBarang'];?></td>
						<td align="center"><?php echo $dt_brg['NamaProgram'];?></td>
						<td align="right"><?php echo rupiah($dt_brg['Harga']);?></td>
						<td align="right"><?php echo $dt_brg['Jumlah'];?></td>
						<td align="right"><?php echo rupiah($subtotal);?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table><br/>
	</div>
</div>