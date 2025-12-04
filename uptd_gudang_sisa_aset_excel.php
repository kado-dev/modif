<?php
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$tahun = $_GET['tahun'];
	// $namaprogram = $_GET['namaprogram'];
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Sisa Aset (".$namapuskesmas.").xls");
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
	<h4 style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN SISA ASET</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $tahun;?></p>
</div><br/>

<div class="row">
	<div class="table-responsive">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr>
					<th width='3%' rowspan="3">No.</td>
					<th width='15%' rowspan="3">Nama Barang</td>
					<th width='5%' rowspan="3">Satuan</td>
					<th width='40%' colspan="8">Sisa Stok</td>
					<th width='15%' colspan="2">Saldo Akhir</td>
				</tr>
				<tr>
					<th colspan="2">2016</td>
					<th colspan="2">2017</td>
					<th colspan="2">2018</td>
					<th colspan="2">2019</td>
					<th rowspan="2">Jumlah</td>
					<th rowspan="2">Harga</td>
				</tr>
				<tr>
					<th>Jumlah</td><!--2016-->
					<th>Harga</td>
					<th>Jumlah</td><!--2017-->
					<th>Harga</td>
					<th>Jumlah</td><!--2018-->
					<th>Harga</td>
					<th>Jumlah</td><!--2019-->
					<th>Harga</td>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
					$no = 0;
					$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' GROUP BY KodeBarangGroup";
					$str_obat = $str." order by NamaBarang";
					// echo $str_obat;
					
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$kodebarang = $data['KodeBarang'];
						$kodebaranggroup = $data['KodeBarangGroup'];
						$namabarang = $data['NamaBarang'];
						
						$dt_2016= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `KodeBarangGroup`='$kodebaranggroup' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2016'"));
						$dt_2017= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `KodeBarangGroup`='$kodebaranggroup' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2017'"));
						$dt_2018= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `KodeBarangGroup`='$kodebaranggroup' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2018'"));
						$dt_2019= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `KodeBarangGroup`='$kodebaranggroup' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2019'"));
						$jml_akhir = $dt_2016['Stok'] + $dt_2017['Stok'] + $dt_2018['Stok'] + $dt_2019['Stok'];			
						$saldo_akhir = ($dt_2016['Stok'] * $dt_2016['HargaBeli']) + ($dt_2017['Stok'] * $dt_2017['HargaBeli']) + ($dt_2018['Stok'] * $dt_2018['HargaBeli']) + ($dt_2019['Stok'] * $dt_2019['HargaBeli']);			
				?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:left;">
								<?php 
									echo $namabarang;
								?>
							</td>
							<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:right;"><!--2016-->
								<?php 
									if($dt_2016['Stok'] !=0){
										echo rupiah($dt_2016['Stok']);
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;">
								<?php 
									if($dt_2016['HargaBeli'] !=0){
										echo number_format("$dt_2016[HargaBeli]",2,",",".");
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;"><!--2017-->
								<?php 
									if($dt_2017['Stok'] !=0){
										echo rupiah($dt_2017['Stok']);
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;">
								<?php 
									if($dt_2017['HargaBeli'] !=0){
										echo number_format("$dt_2017[HargaBeli]",2,",",".");
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;"><!--2018-->
								<?php 
									if($dt_2018['Stok'] !=0){
										echo rupiah($dt_2018['Stok']);
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;">
								<?php 
									if($dt_2018['HargaBeli'] !=0){
										echo number_format("$dt_2018[HargaBeli]",2,",",".");
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;"><!--2019-->
								<?php 
									if($dt_2019['Stok'] !=0){
										echo rupiah($dt_2019['Stok']);
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;">
								<?php 
									if($dt_2019['HargaBeli'] !=0){
										echo number_format("$dt_2019[HargaBeli]",2,",",".");
									}else{
										echo "-";
									}	
								?>
							</td>
							<td style="text-align:right;"><!--Jumlah Akhir-->
								<?php
									echo rupiah($jml_akhir);
								?>
							</td>
							<td style="text-align:right;"><!--Saldo Akhir-->
								<?php
									echo number_format("$saldo_akhir",2,",",".");
								?>
							</td>
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