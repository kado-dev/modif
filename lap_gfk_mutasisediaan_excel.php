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
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Mutasi_Sediaan (".$kota." ".$hariini.").xls");	
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN MUTASI SEDIAAN</b></span><br>
	<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo nama_bulan(date('m'))." ".date('Y');?>
	</span>
</div><br/>

<?php
	$key = $_GET['key'];		
	
	if(isset($key)){
?>
<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="3%" rowspan="2">No.</th>
						<th width="5%" rowspan="2">Kode</th>
						<th width="15%" rowspan="2">Nama Barang</th>
						<th width="5%" rowspan="2">Satuan</th>
						<th width="5%" rowspan="2">Harga</th>
						<th width="5%" rowspan="2">Batch</th>
						<th width="6%" colspan="2">Penerimaan</th>
						<th width="8%" colspan="2">Pengeluaran</th>
						<th width="5%" colspan="2">Saldo Akhir</th>
					</tr>
					<tr>
						<th width="3%">Jml</th><!--Penerimaan-->
						<th width="5%">Rupiah</th>
						<th width="3%">Jml</th><!--Pengeluaran-->
						<th width="5%">Rupiah</th>
						<th width="3%">Jml</th><!--Saldo Akhir-->
						<th width="5%">Rupiah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;					
					
					if($key !=''){
						$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%')";
					}else{
						$strcari = " `SumberAnggaran` != 'BLUD'";
					}
						
					$str = "SELECT * FROM `tbgfkstok` WHERE ".$strcari;
					$str2 = $str." ORDER BY NamaBarang ASC";
					// echo $str2;
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;		
						$kodeobat = $data['KodeBarang'];
						$nobatch = $data['NoBatch'];
						$hargasatuan = $data['HargaBeli'];
						
						// penerimaan
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `Nobatch`='$nobatch'"));
						if ($dtpenerimaan['Jumlah'] != null){
							$penerimaan = $dtpenerimaan['Jumlah'];
						}else{
							$penerimaan = '0';
						}
						$penerimaan_rupiah = $penerimaan * $hargasatuan;
						
						// pemakaian / distribusi
						$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `Nobatch`='$nobatch'"));
						if ($dtpengeluaran['Jumlah'] != null){
							$pemakaian = $dtpengeluaran['Jumlah'];
						}else{
							$pemakaian = '0';
						}
						$pemakaian_rupiah = $pemakaian * $hargasatuan;
						
						// saldo akhir / sisa stok
						$saldoakhir = $penerimaan  - $pemakaian;
						$saldoakhir_rupiah = $saldoakhir * $hargasatuan;
					?>
					<tr>
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td class="nama">
							<?php 
								echo $data['NamaBarang']."<br/>";									
								if($data['NamaTambahan'] != "-"){
							?>
								<span style='font-size: 10px; font-style: italic'><?php echo $data['NamaTambahan'];?></span>
							<?php } ?>
						</td>
						<td align="center"><?php echo $data['Satuan'];?></td>
						<td align="right"><?php echo rupiah($hargasatuan);?></td>
						<td align="center"><?php echo $nobatch;?></td>
						<td align="right"><?php echo rupiah($penerimaan);?></td>
						<td align="right"><?php echo rupiah($penerimaan_rupiah);?></td>
						<td align="right"><?php echo rupiah($pemakaian);?></td>
						<td align="right"><?php echo rupiah($pemakaian_rupiah);?></td>
						<td align="right"><?php echo rupiah($saldoakhir);?></td>
						<td align="right"><?php echo rupiah($saldoakhir_rupiah);?></td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
	}
?>