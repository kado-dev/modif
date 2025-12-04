<?php
	$kota = $_SESSION['kota'];
 ?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>MUTASI SEDIAAN</h3>
			<!--<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_gfk_mutasisediaan_import.php">
				Pilih File: 	
				<input type="hidden" name="tahun" value="<?php //echo $_GET['tahun']?>">
				<input type="hidden" name="namaprogram" value="<?php //echo $_GET['namaprogram']?>"
				<input name="fileexcel" type="file" required="required"> 
				<input name="upload" type="submit" value="Import">
			</form>-->
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_mutasisediaan"/>
						<div class="col-sm-5">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang/Batch/Program">
						</div>
						<div class="col-sm-7">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_mutasisediaan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_mutasisediaan_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-round btn-success">Download Excel</a>
							<!--<a href="?page=lap_gfk_mutasisediaan_tambah" class="btn btn-round btn-info">Tambah Data</a>-->
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php	
		$jumlah_perpage = 20;
		
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$key = $_GET['key'];		
		
		if($key !=''){
			$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%')";
		}else{
			$strcari = " `SumberAnggaran` != 'BLUD'";
		}
			
		$str = "SELECT * FROM `tbgfkstok` WHERE".$stoks.$strcari;
		$str2 = $str." order by NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		if(isset($key)){
	?>			
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
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
	<ul class="pagination">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_gfk_mutasisediaan&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
<?php
}
?>