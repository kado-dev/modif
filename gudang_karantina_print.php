<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$id = $_GET['id'];
	$periode = $_GET['periode'];
	$dtkarantina=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_karantina` WHERE `NoFaktur`='$id'"));
?>

<html lang="en">
<head>
	<title>Register KB</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
	<link rel="stylesheet" href="assets/css/f_laporan.css" />
</head>
<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_karantina_lihat&id=<?php echo $id;?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font20" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font14" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14">
			<b>LAPORAN GUDANG KARANTINA</b><br/>
			<?php echo "Periode Laporan : ".date('d-m-Y', strtotime($periode));?>
		</span>
		<br/><br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-condensed font12">
				<thead>
					<tr>
						<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
						<th width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sumber</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Batch</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
						<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga Satuan</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jml</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$kategori = $_GET['kategori'];		
						$key = $_GET['key'];	
						
						$str = "SELECT * FROM `tbgfk_karantinadetail`WHERE `NoFaktur`='$id'";
						$str2 = $str." ORDER BY `IdKarantinaDetail` ASC";
						// echo $str2;
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kdbrg = $data['KodeBarang'];
							$nobatch = $data['NoBatch'];
							
							if($dtkarantina['StatusGudang'] == "Gudang Besar"){
								$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`Satuan`,`SumberAnggaran`,`TahunAnggaran`,`HargaBeli`,`Expire` FROM `tbgfkstok` WHERE `KodeBarang` = '$kdbrg' AND `NoBatch`='$nobatch'"));
							}elseif($dtkarantina['StatusGudang'] == "Gudang Vaksin"){
								$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`Satuan`,`SumberAnggaran`,`TahunAnggaran`,`HargaBeli`,`Expire` FROM `tbgfk_vaksin_stok`WHERE KodeBarang='$kdbrg' AND `NoBatch`='$nobatch'"));
							}
							
							// total
							$total = $dtbrg['HargaBeli'] * $data['Jumlah'];
							$totalkeseluruhan = $totalkeseluruhan + $total;
					?>
						<tr>
							<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td align="left" style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtbrg['NamaBarang'];?></td>
							<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtbrg['Satuan'];?></td>
							<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtbrg['SumberAnggaran']." - ".$dtbrg['TahunAnggaran'];?></td>
							<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['NoBatch'];?></td>
							<td align="center" style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtbrg['Expire'];?></td>
							<td align="right" style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtbrg['HargaBeli']);?></td>
							<td align="right" style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right" style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total);?></td>
						</tr>
					<?php
					}
					?>
					<tr style="font-weight: bold;">
						<td align="center" style="text-align:center; border:1px solid #000; padding:3px;" colspan="8"> TOTAL KESELRUHAN</td>
						<td align="right" style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($totalkeseluruhan);?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>