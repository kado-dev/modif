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
	$tahun = $_GET['tahun'];
	// get data
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$namaprogram = $_GET['namaprogram'];
	$penerima = $_GET['penerima'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Distribusi_Unit (".$kota." ".$hariini.").xls");
	if(isset($bulan1) and isset($tahun)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI UNIT</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan1)." s/d ".nama_bulan($bulan2)." ".$tahun;?></p><br/>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="4%">No.</th>
					<th width="8%">Tanggal</th>
					<th width="5%">Jam</th>
					<th width="10%">No.Faktur</th>
					<th width="15%">Penerima</th>
					<th width="15%">Program</th>
					<th width="15%">Keterangan</th>
					<th width="10%">Grand Total (Rp.)</th>
				</tr>
			</thead>
			<tbody >
				<?php
					$no = 0;
					
					if($penerima == 'semua'){
						$penerima1 = '';
					}else{
						$penerima1 = " AND `Penerima` like '%$_GET[penerima]%'";
					}
					
					if($namaprogram == "semua"){
						$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran) = '$tahun' AND MONTH(TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2'".$penerima1;
						$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
								WHERE YEAR(b.TanggalPengeluaran) ='$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2'".$penerima1;
					}else{
						$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran) = '$tahun' AND MONTH(TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND `NamaProgram`='$namaprogram'".$penerima1;
						$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
								WHERE YEAR(b.TanggalPengeluaran) ='$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND a.`NamaProgram`='$namaprogram'".$penerima1;
					}
					$str2 = $str." ORDER BY IdDistribusi DESC";
					$query = mysqli_query($koneksi,$str2);
					while ($dt_brg = mysqli_fetch_assoc($query)){
						$no = $no + 1;
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
						<td align="center"><?php echo $dt_brg['JamPengeluaran'];?></td>
						<td align="center"><?php echo $dt_brg['NoFaktur'];?></td>
						<td align="left"><?php echo $dt_brg['Penerima'];?></td>
						<td align="left"><?php echo $dt_brg['NamaProgram'];?></td>
						<td align="center"><?php echo $dt_brg['Keterangan'];?></td>
						<td align="right"><b><?php echo rupiah($dt_brg['GrandTotal']);?></b></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table><br/>
	</div>
</div>
<?php
}
?>