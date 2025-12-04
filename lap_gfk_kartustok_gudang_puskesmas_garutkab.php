<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KARTU STOK </b><small>Gudang Obat Puskesmas</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_kartustok_gudang_puskesmas_garutkab"/>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kode Barang / Barcode" required>
								</div>	
							</div>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_kartustok_gudang_puskesmas_garutkab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-success"><span class="fa fa-print"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<?php
	$tahun = 2021;
	$key = $_GET['key'];
	if(isset($key)){
	?>	
	<div class="table-responsive">
		<table class="table-judul">
			<thead>
				<tr>
					<th width="3%" style="text-align:center; vertical-align:middle; padding:10px;">NO.</th>
					<th width="17%" style="text-align:center; vertical-align:middle; padding:10px;">NAMA BARANG</th>
					<th width="10%" style="text-align:center; vertical-align:middle; padding:10px;">STOK AWAL</th>
					<th width="10%" style="text-align:center; vertical-align:middle; padding:10px;">PENERIMAAN</th>
					<th width="10%" style="text-align:center; vertical-align:middle; padding:10px;">PERSEDIAAN</th>
					<th width="10%" style="text-align:center; vertical-align:middle; padding:10px;">PENGELUARAN</th>
					<th width="10%" style="text-align:center; vertical-align:middle; padding:10px;">SISA STOK</th>
					<th width="5%" style="text-align:center; vertical-align:middle; padding:10px;">HARGA SAT.</th>
					<th width="10%" style="text-align:center; vertical-align:middle; padding:10px;">SALDO</th>
					<!--<th width="5%" style="text-align:center; vertical-align:middle; padding:10px;">Opsi</th>-->
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
			$str = "SELECT * FROM `tbgudangpkmstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%') AND `KodePuskesmas`='$kodepuskesmas'";	
			$str2 = $str." GROUP BY `KodeBarang` ORDER BY `IdBarangGdgPkm` DESC limit $mulai,$jumlah_perpage";	
			// echo $str2;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi, $str2);	
			while($dtobat=mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$nomorpembukuan = $dtobat['NoFakturTerima'];
				$kodebarang = $dtobat['KodeBarang'];
				$namaobat = $dtobat['NamaBarang'];
				$nobatch = $dtobat['NoBatch'];
				$stok = $dtobat['Stok'];
				$harga = $dtobat['HargaSatuan'];
				
				// tahap1, stok awal
				$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_puskesmas` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
				$stokawal = $dtstokawal['Gudang'];
				if(empty($stokawal)){$stokawal = "0";}
				
				$stokawal_total = $stokawal;
				$stokawal_rupiah = $stokawal_total * $harga;
				
				// tahap2, penerimaan
				$strpenerimaan = "SELECT SUM(Jumlah)AS Jumlah FROM `tbgudangpkmpenerimaandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
				$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
				
				// tahap3, persediaan
				$persediaan = $stokawal + $penerimaan['Jumlah'];
				
				// tahap 4, pengeluaran 
				$strpengeluaran = "SELECT SUM(Jumlah)AS Jumlah FROM `tbgudangpkmpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
				$pegeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
				
				// 4. sisastok
				$sisastok = ($stokawal + $penerimaan['Jumlah']) - $pegeluaran['Jumlah'];
				$saldo = $sisastok * $harga;	
				
			?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="left">
						<?php 
						
						// penerimaan
						// $nopembukuan = $dt_penerimaan_dtl['NomorPembukuan'];
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nomorpembukuan'"));
						$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
												
						echo "<b>".$namaobat.", ".$kodebarang."</b><br/>".
						"No.Batch : ".$nobatch."<br/>".
						"Expire : ".date('d-m-Y', strtotime($dtobat['Expire']))."<br/>".
						"Sumber : ".$dtobat['SumberAnggaran']."<br/>".
						"Tgl.Terima : ".$dtpenerimaan['TanggalPenerimaan']."<br/>".
						"Faktur Terima : ".$dtobat['NoFakturTerima']."<br/>".
						"Supplier : ".$dtsupplier['nama_prod_obat'];
						?>
					</td>
					<td align="right"><?php echo rupiah($stokawal);?></td>
					<td align="right"><?php echo rupiah($penerimaan['Jumlah']);?></td>
					<td align="right"><?php echo rupiah($persediaan);?></td>
					<td align="right"><?php echo rupiah($pegeluaran['Jumlah']);?></td>
					<td align="right"><?php echo rupiah($sisastok);?></td>
					<td align="right"><?php echo number_format($harga,2,",",".");?></td>
					<td align="right"><?php echo rupiah($saldo);?></td>
					<!--<td style="text-align:center; vertical-align:middle; padding:5px;"><a href="?page=lap_gfk_kartustok_gudang_puskesmas_garutkab_lihat&nf=<?php echo $nomorpembukuan;?>&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $key;?>" class="btn btn-sm btn-info btn-white">Lihat</a></td>-->
				</tr>
			<?php
				$totalstokawal = $totalstokawal + $stokawal;
				$totalpenerimaan = $totalpenerimaan + $penerimaan;
				$totalpengeluaran = $totalpengeluaran + $pegeluaran_apbd;
				$totalsisastok = $totalsisastok + $sisastok;
			}
			?>		
				<tr>
					<td align="center" colspan="3">TOTAL</td>
					<td align="right"><?php echo rupiah($totalstokawal);?></td>
					<td align="right"><?php echo rupiah($totalpenerimaan);?></td>
					<td align="right"><?php echo rupiah($totalpengeluaran);?></td>
					<td align="right"><?php echo rupiah($totalsisastok);?></td>
					<td align="right"></td>
					<td align="right"></td>
					<!--<td align="right"></td>-->
				</tr>
			</tbody>
		</table>
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
						echo "<li><a href='?page=lap_gfk_kartustok_gudang_puskesmas_garutkab&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php 
	}
	?>
</div>	



