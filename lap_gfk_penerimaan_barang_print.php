<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	// get
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahunakhir = $_GET['tahunakhir'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$namaprogram = $_GET['namaprogram'];	
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
	<title>Penerimaan Realisasi</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_gfk_penerimaan_barang&bulanawal=<?php echo  $_GET['bulanawal'];?>&bulanakhir=<?php echo  $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>PENERIMAAN BARANG (REALISASI)</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tanggal;?></span>
		<br/><br/>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-block alert-success fade in">
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						<p>
							<b>PERHATIKAN :</b><br/>
							<?php 	
								$bulanawal = $_GET['bulanawal'];		
								$bulanakhir = $_GET['bulanakhir'];		
								$tahunakhir = $_GET['tahunakhir'];					
								$sumberanggaran = $_GET['sumberanggaran'];				
								$namaprogram = $_GET['namaprogram'];
								
								// menghitung grand total (obat, bmhp, lab)
								$grand_obat = 0;	
								$str_obat = "SELECT b.TanggalPenerimaan, a.SumberAnggaran, a.KodeBarang, a.NoBatch, a.Harga, a.Jumlah, a.SubTotal 
								FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
								WHERE (MONTH(b.TanggalPenerimaan)>='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir') AND (MONTH(b.TanggalPenerimaan)<='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir')
								AND a.`SumberAnggaran`='$sumberanggaran' AND a.`NamaProgram`='PKD' GROUP BY a.SubTotal, a.KodeBarang, a.NoBatch";
								$query_obat = mysqli_query($koneksi,$str_obat);
								while($data = mysqli_fetch_assoc($query_obat)){
									$jumlahobat = $data['SubTotal'];
									$grand_obat = $grand_obat + $jumlahobat;
								}
								
								// bmhp
								$grand_bmhp = 0;
								$str_bmhp = "SELECT b.TanggalPenerimaan, a.SumberAnggaran, a.KodeBarang, a.NoBatch, a.Harga, a.Jumlah, a.SubTotal 
								FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
								WHERE (MONTH(b.TanggalPenerimaan)>='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir') AND (MONTH(b.TanggalPenerimaan)<='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir')
								AND a.`SumberAnggaran`='$sumberanggaran' AND a.`NamaProgram`='BMHP' GROUP BY a.SubTotal, a.KodeBarang, a.NoBatch";
								$query_bmhp = mysqli_query($koneksi,$str_bmhp);
								while($data = mysqli_fetch_assoc($query_bmhp)){
									$jumlahbmhp = $data['SubTotal'];
									$grand_bmhp = $grand_bmhp + $jumlahbmhp;
								}
								
								// laboratorium
								$grand_lab = 0;
								$str_lab = "SELECT b.TanggalPenerimaan, a.SumberAnggaran, a.KodeBarang, a.NoBatch, a.Harga, a.Jumlah, a.SubTotal 
								FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
								WHERE (MONTH(b.TanggalPenerimaan)>='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir') AND (MONTH(b.TanggalPenerimaan)<='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir')
								AND a.`SumberAnggaran`='$sumberanggaran' AND a.`NamaProgram`='LABORATORIUM' GROUP BY a.SubTotal, a.KodeBarang, a.NoBatch";
								$query_lab = mysqli_query($koneksi,$str_lab);
								while($data = mysqli_fetch_assoc($query_lab)){
									$jumlahlab = $data['SubTotal'];
									$grand_lab = $grand_lab + $jumlahlab;
								}
							?>
							<table width="100%">
								<tr>
									<td width="10%">OBAT</td>
									<td width="90%"><b><?php echo ": ".rupiah($grand_obat);?></b></td>
								</tr>
								<tr>
									<td>BMHP</td>
									<td><b><?php echo ": ".rupiah($grand_bmhp);?></b></td>
								</tr>
								<tr>
									<td>LAB</td>
									<td><b><?php echo ": ".rupiah($grand_lab);?></b></td>
								</tr>
								<tr>
									<td>GRAND TOTAL</td>
									<td><b><?php echo ": ".rupiah($grand_obat + $grand_bmhp + $grand_lab);?></b></td>
								</tr>
							</table>
						</p>
					</div>
				</div>
			</div>			
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th width="12%">Tgl.Terima</th>
							<th width="5%">No.Pembukuan</th>
							<th width="5%">Kode</th>
							<th width="18%">Nama Barang</th>
							<th width="5%">Batch</th>
							<th width="12%">Sumber</th>
							<th width="10%">Program</th>
							<th width="10%">Harga</th>
							<th width="10%">Jumlah Terima</th>
							<th width="10%">Total Terima</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
			
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($namaprogram == "semua"){
							$programs = "";
						}else{
							$programs = " AND a.`NamaProgram`='$namaprogram'";
						}	
							
						$str = "SELECT b.TanggalPenerimaan, a.NomorPembukuan, a.KodeBarang, c.NamaBarang, a.NoBatch, a.SumberAnggaran, a.NamaProgram, a.Harga, a.Jumlah 
						FROM `tbgfkpenerimaandetail` a
						JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
						WHERE (MONTH(b.TanggalPenerimaan)>='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir') AND (MONTH(b.TanggalPenerimaan)<='01' AND YEAR(b.TanggalPenerimaan)='$tahunakhir') 
						AND a.`SumberAnggaran`='$sumberanggaran'".$programs;
						$str2 = $str." GROUP BY a.KodeBarang, a.NoBatch ORDER BY c.`NamaBarang` LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);						
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$nomorpembukuan = $data['NomorPembukuan'];
							$nobatch = str_replace(",", ", ", $data['NoBatch']);
							$sumber = $data['SumberAnggaran'];
							$total = $data['Harga'] * $data['Jumlah'];
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPenerimaan'];?></td>
								<td align="center"><?php echo $data['NomorPembukuan'];?></td>
								<td align="center"><?php echo $data['KodeBarang'];?></td>
								<td align="left"><?php echo $data['NamaBarang'];?></td>
								<td align="left"><?php echo $nobatch;?></td>
								<td align="center"><?php echo $sumber;?></td>
								<td align="center"><?php echo $data['NamaProgram'];?></td>
								<td align="right"><?php echo rupiah($data['Harga']);?></td>
								<td align="right"><?php echo rupiah($data['Jumlah']);?></td>	
								<td align="right"><b><?php echo rupiah($total);?></b></td>	
							</tr>
						<?php
						$jumlah = $jumlah + $total;
						$jumlahbarang = mysqli_num_rows(mysqli_query($koneksi, $str2));
						}	
						?>
							<tr>
								<td align="center" colspan="10"><b>TOTAL <?php echo $jumlahbarang;?> ITEM BARANG</b></td>
								<td align="right"><b><?php echo rupiah($jumlah);?></b></td>
							</tr>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</body>
</html>