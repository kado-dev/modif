<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$key = $_GET['key'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	
	// tbstok
	
?>
<style>
.table-judul-laporan>thead>tr>th {
	padding-top:15px;
	padding-bottom:15px;
	background:#939393;
	color:#fff;
	text-align:center;
	vertical-align:middle;
	border:1px solid #000;
	font-size: 12px;
	font-family: "Poppins", sans-serif;
}
.table-judul-laporan>tbody>tr>td {
	background:#fff;
	padding:5px;			
	border: 1px solid;  
	border-color:#000;
}
</style>

<html lang="en">
<head>
	<title>Kartu Stok</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_gfk_distribusi_barang_bogorkab&kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>'">-->
<body>
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>DETAIL PENGELUARAN BARANG</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tanggal;?></span>
		<br/><br/>
	</div>
	<div class="row">
		<div class="col-sm-12">	
			<a href="lap_gfk_distribusi_barang_bogorkab_detail_excel.php?kd=<?php echo $kodebarang;?>" class="btn btn-sm btn-info pull-right" style="margin-bottom: 5px">Excel</a>	
							
		</div>
	</div>
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th width="5%">Kode</th>
							<th width="25%">Nama Barang</th>
							<th width="15%">Tahun <br>Pengadaan</th>
							<th width="10%">Penerimaan</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
					<?php
					
					// $nobatcharr = explode(",", $nobatch);
					// foreach($nobatcharr as $nbt){
					// 	
					$str = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
					$query = mysqli_query($koneksi,$str);
					$data = mysqli_fetch_assoc($query);	
					$strpenerimaan = mysqli_query($koneksi,"SELECT SUM(Jumlah) as jml FROM tbgfkpenerimaandetail WHERE `KodeBarang` = '$data[KodeBarang]'");	
					if(mysqli_num_rows($strpenerimaan) > 0){
						$dtpen = mysqli_fetch_assoc($strpenerimaan);
						$jmlpenerimaan = $dtpen['jml'];
					}else{
						$jmlpenerimaan = 0;
					}			
					?>
						<tr>
							<td align="center"></td>							
							<td align="center"><?php echo $data['KodeBarang'];?></td>									
							<td align="left"><?php echo $data['NamaBarang'];?></td>									
							<td align="left"><?php echo $data['TahunAnggaran'];?></td>	
							<td align="left"><?php echo $jmlpenerimaan;?></td>	
														
						</tr>
						<tr style="background: #ddd">
							<td align="center"></td>							
							<td colspan="3" align="left"><b>Penerima</b></td>		
							<td colspan="1" align="left"><b>Jumlah</b></td>	
														
						</tr>
					<?php
					$no = 0;
							$str2 = "SELECT b.Penerima, SUM(a.Jumlah) as Jumlah FROM tbgfkpengeluarandetail a Join tbgfkpengeluaran b ON a.IdDistribusi = b.IdDistribusi WHERE a.KodeBarang = '$data[KodeBarang]' group by b.Penerima";
							$query2 = mysqli_query($koneksi,$str2);
							while($data2 = mysqli_fetch_assoc($query2)){	
								$no = $no + 1;
					?>
						
						<tr style="background: aqua">
							<td align="center"><?php echo $no;?></td>							
							<td colspan="3" align="left"><?php echo $data2['Penerima'];?></td>		
							<td colspan="1" align="left"><?php echo $data2['Jumlah'];?></td>	
														
						</tr>
					<?php
						$jmlpenrimas[] = $data2['Jumlah'];
							}
						//}
					//}	
					?>
						<tr style="background: aqua">
							<td align="center"></td>							
							<td colspan="3" align="left">Jumlah</td>		
							<td colspan="1" align="left"><?php echo array_sum($jmlpenrimas);?></td>	
													
						</tr>
						<tr style="background: aqua">
							<td align="center"></td>							
							<td colspan="3" align="left">Sisa</td>		
							<td colspan="1" align="left"><?php echo $jmlpenerimaan - array_sum($jmlpenrimas);?></td>	
													
						</tr>
					</tbody>
				</table>
			</table>
		</div>
	</div>
</body>
</html>