<?php
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_report.php";
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$penerima = $_GET['penerima'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=SBBK (".$penerima.").xls");
	// if(isset($bulan) and isset($tahun)){
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>SBBK PUSKESMAS</b></h4>
	<h4 style="margin:15px 5px 5px 5px;"><b><?php echo $nf;?></b></h4>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:12px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="20%">NAMA BARANG</th>
					<th rowspan="2" width="8%">SATUAN</th>
					<th rowspan="2" width="8%">EXPIRE</th>
					<th rowspan="2" width="8%">BATCH</th>
					<th colspan="4" width="30%">PEMBERIAN</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th width="5%">JML</th>
					<th width="5%">TERBILANG</th>
					<th width="8%">HARGA SAT.</th>
					<th width="8%">TOTAL HARGA</th>
				</tr>
			</thead>
			<tbody style="font-size:13px;">
				<?php
				$total = 0;
				$jumlah = 0;
				$no = 0;
				// $str = "SELECT * FROM `tbgfkpengeluarandetail` WHERE `Nofaktur`='$nf'";
				$str = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.NoFaktur = '$nf' GROUP BY a.KodeBarang ORDER BY NamaBarang ";
					$query = mysqli_query($koneksi,$str);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kdbrg = $data['KodeBarang'];
					$batch = $data['NoBatch'];						
					
					// tbgfkstok
					$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
					$jumlah = $data['Harga'] * $data['Jumlah'];
					$total = $jumlah + $total;
				?>
					<tr style="border:1px solid #000;">
						<td align="right"><?php echo $no.".";?></td>
						<td align="left"><?php echo $dt_gfkstok['NamaBarang'];?></td>
						<td align="center"><?php echo $dt_gfkstok['Satuan'];?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($dt_gfkstok['Expire']));?></td>
						<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
						<td align="right"><?php echo rupiah($data['Jumlah']);?></td>
						<td align="right"><?php echo terbilang($data['Jumlah']);?></td>
						<td align="right"><?php echo "Rp. ".rupiah($data['Harga']);?></td>
						<td align="right"><?php echo "Rp. ".rupiah($jumlah);?></td>
					</tr>
				<?php
				}
				?>
				<tr style="font-weight: bold;border:0px solid #000;">
					<td colspan="8" style="text-align:center; border:0px solid #000; padding:3px;background-color:#eee">TOTAL</td>
					<td style="text-align:right; border:0px solid #000; padding:3px;background-color:#f9f9f9"><?php echo "Rp. ".rupiah($total)?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
// }
?>