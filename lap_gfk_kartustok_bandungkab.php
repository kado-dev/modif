<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KARTU STOK</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_kartustok_bandungkab"/>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kode Barang / Barcode" required>
								</div>	
							</div>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></button>
							<a href="?page=lap_gfk_kartustok_bandungkab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<?php
	$key = $_GET['key'];
	if(isset($key)){
	?>	
	<div class="table-responsive">
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; padding:10px;">No.</th>
					<th width="20%" rowspan="2" style="text-align:center; vertical-align:middle; padding:10px;">Nama Barang</th>
					<th width="7%" rowspan="2" style="text-align:center; vertical-align:middle; padding:10px;">Harga<br/> Satuan</th>
					<th width="25%" colspan="3" style="text-align:center; vertical-align:middle; padding:10px;">Gudang Besar</th>
					<th width="25%" colspan="3" style="text-align:center; vertical-align:middle; padding:10px;">Gudang Pelayanan</th>
					<th width="7%" rowspan="2" style="text-align:center; vertical-align:middle; padding:10px;">Totak Sisa Stok</th>
					<th width="8%" rowspan="2" style="text-align:center; vertical-align:middle; padding:10px;">Saldo</th>
					<th width="5%" rowspan="2" style="text-align:center; vertical-align:middle; padding:10px;">Opsi</th>
				</tr>
				<tr>
					<th style="text-align:center; vertical-align:middle; padding:10px;">Penerimaan</th><!--Gudang Besar-->
					<th style="text-align:center; vertical-align:middle; padding:10px;">Pengeluaran</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">Sisa Stok</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">Penerimaan<br/>Dari Gudang Besar</th><!--Gudang Pelayanan-->
					<th style="text-align:center; vertical-align:middle; padding:10px;">Pengeluaran</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">Sisa Stok</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$jumlah_perpage = 10;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$no = 0;				
			$str = "SELECT * FROM `tbgfkstok` WHERE (`KodeBarang` like '%$key%' OR `NamaBarang` like '%$key%' OR `NoBatch` like '%$key%')";	
			$str2 = $str." ORDER BY `IdBarang` DESC LIMIT $mulai,$jumlah_perpage";	
			// echo $str2;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi, $str2);	
			while($dtobat=mysqli_fetch_assoc($query)){
				$no = $no+1;
				$kodeobat = $dtobat['KodeBarang'];
				$namaobat = $dtobat['NamaBarang'];
				$program = $dtobat['NamaProgram'];
				$nobatch = $dtobat['NoBatch'];
				$stok = $dtobat['Stok'];
								
				// tahap1, penerimaan gudang besar
				$dtpenerimaan_gb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND NoBatch = '$nobatch'"));
				if ($dtpenerimaan_gb['Jumlah'] != null){
					$penerimaan_gb = $dtpenerimaan_gb['Jumlah'];
				}else{
					$penerimaan_gb = '0';
				}
								
				// tahap2, pengeluaran/distribusi gudang besar
				$dtpengeluaran_gb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch` = '$nobatch'"));
				if ($dtpengeluaran_gb['Jumlah'] != null){
					$pengeluaran_gb = $dtpengeluaran_gb['Jumlah'];
				}else{
					$pengeluaran_gb = '0';
				}
				
				// tahap3, sisa stok gudang besar
				$sisastok_gb = $penerimaan_gb - $pengeluaran_gb;

				// tahap4, tbgfkstok
				$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodeobat' AND NoBatch = '$nobatch'"));
				$harga = $dtgfk['HargaBeli'];
				$nofakturterima = $dtgfk['NoFakturTerima'];
				
				// tahap5, penerimaan dianggap sebagai pengeluaran gudang besar
				$str_penerimaan = "select SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat'  AND `NoBatch`='$nobatch';";
				$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
				if ($dt_penerimaan_dtl['Jumlah'] != null){
					$penerimaan = $dt_penerimaan_dtl['Jumlah'];
				}else{
					$penerimaan = '0';
				}
				
				// tahap6, pengeluaran detail / pengeluaran gudang pelayanan
				$str_pengeluaran = "SELECT SUM(Jumlah) AS Jml FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch` = '$nobatch'";
				$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
				if ($dt_pengeluaran_dtl['Jml'] != null){
					$pengeluaran = $dt_pengeluaran_dtl['Jml'];
				}else{
					$pengeluaran = '0';
				}
				
				// tahap7, saldo
				$sisastok_gp = $stokawal + $penerimaan - $pengeluaran;
				$sisastok_total = $sisastok_gb + $sisastok_gp;
				$saldo = $sisastok_total * $harga;
			?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="left">
						<?php 
						echo "<b>".$namaobat."</b><br/>".
						"Program : ".$program."<br/>".
						"Kd.Barang : ".$kodeobat."<br/>".
						"No.Batch : ".$nobatch."<br/>".
						"Expire : ".date('d-m-Y', strtotime($dtgfk['Expire']))."<br/>".
						"Sumber : ".$dtgfk['SumberAnggaran']." - ".$dtgfk['TahunAnggaran']."<br/>".
						"No.Faktur Terima: ".$nofakturterima;
						?>
					</td>
					<td align="right"><?php echo rupiah($harga);?></td>
					<td align="right"><?php echo rupiah($penerimaan_gb);?></td><!--Gudang Besar-->
					<td align="right"><?php echo rupiah($pengeluaran_gb);?></td>
					<td align="right"><?php echo rupiah($sisastok_gb);?></td>
					<td align="right"><?php echo rupiah($penerimaan);?></td><!--Gudang Pelayanan-->
					<td align="right"><?php echo rupiah($pengeluaran);?></td>
					<td align="right"><?php echo rupiah($sisastok_gp);?></td>
					<td align="right"><?php echo rupiah($sisastok_total);?></td>
					<td align="right"><?php echo rupiah($saldo);?></td>
					<td style="text-align:center; vertical-align:middle; padding:5px;"><a href="?page=lap_gfk_kartustok_bandungkab_lihat&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $dtobat['NamaBarang'];?>" class="btn btn-sm btn-success">Lihat</a></td>
				</tr>
			<?php
			}
			?>		
			</tbody>
		</table>
	</div>
	<hr class="noprint"><!--css-->
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_gfk_kartustok_bandungkab&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php 
	}
	?>
</div>	



