<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KARTU STOK </b><small>Gudang Vaksin</small></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_kartustok_vaksin"/>
						<div class="col-xl-8">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kode Barang / Barcode" required>
								</div>	
							</div>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_kartustok_vaksin" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn  btn-round btn-success"><span class="fa fa-print"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$key = $_GET['key'];
	if(isset($key)){
	?>	
	<div class="table-responsive">
		<table class="table-judul">
			<thead>
				<tr>
					<th width="3%" style="text-align:center; vertical-align:middle; padding:10px;">No.</th>
					<th width="6%" style="text-align:center; vertical-align:middle; padding:10px;">Kode Obat</th>
					<th width="25%" style="text-align:center; vertical-align:middle; padding:10px;">Nama Obat</th>
					<th width="8%" style="text-align:center; vertical-align:middle; padding:10px;">Stok Awal</th>
					<th width="8%" style="text-align:center; vertical-align:middle; padding:10px;">Penerimaan</th>
					<th width="8%" style="text-align:center; vertical-align:middle; padding:10px;">Pengeluaran</th>
					<th width="8%" style="text-align:center; vertical-align:middle; padding:10px;">Sisa Stok</th>
					<th width="8%" style="text-align:center; vertical-align:middle; padding:10px;">Harga Sat.</th>
					<th width="12%" style="text-align:center; vertical-align:middle; padding:10px;">Saldo</th>
					<th width="5%" style="text-align:center; vertical-align:middle; padding:10px;">Opsi</th>
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
			$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%')";	
			$str2 = $str." ORDER BY `NoFakturTerima` DESC limit $mulai,$jumlah_perpage";	
			// echo $str2;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi, $str2);	
			while($dtobat=mysqli_fetch_assoc($query)){
				$no = $no+1;
				$nomorpembukuan = $dtobat['NoFakturTerima'];
				$kodeobat = $dtobat['KodeBarang'];
				$namaobat = $dtobat['NamaBarang'];
				$nobatch = $dtobat['NoBatch'];
				$stok = $dtobat['Stok'];
				$harga = $dtobat['HargaBeli'];
				
				// tahap1, stok awal ini ngambil sisa stok yang bulan des 2019
				$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat ' AND `NoBatch`='$nobatch'";
				$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
				if ($dt_stokawal_dtl['Stok'] != null){
					$stokawal = $dt_stokawal_dtl['Stok'];
				}else{
					$stokawal = '0';
				}	
				
				// tahap2, panggil tanggal terima
				$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_penerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$nomorpembukuan'";
				$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
				if ($dt_penerimaan_dtl['Jumlah'] != null){
					$penerimaan = $dt_penerimaan_dtl['Jumlah'];
				}else{
					$penerimaan = '0';
				}
				
				// tahap3, pengeluaran detail
				$strpengeluaran = "SELECT SUM(Jumlah) AS Jml FROM `tbgfk_vaksin_pengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nomorpembukuan'";
				$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
				if ($dt_pengeluaran_dtl['Jml'] != null){
					$pengeluaran = $dt_pengeluaran_dtl['Jml'];
				}else{
					$pengeluaran = '0';
				}
				
				// tahap5, karantina
				$str_karantina = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodeobat' AND a.`NoBatch`='$nobatch'";
				$dt_karantina = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
				if ($dt_karantina['Jumlah'] != null){
					$karantina = $dt_karantina['Jumlah'];
				}else{
					$karantina = '0';
				}
				$pengeluarantotal = $pengeluaran + $karantina;
				
				// 6. sisastok
				if($penerimaan == 0){
					$sisastok = $stokawal - $pengeluaran - $karantina;
				}else{
					$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina;
				}	
				$saldo = $sisastok * $harga;	
				
			?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="center"><?php echo $kodeobat;?></td>
					<td align="left">
						<?php 
						
						// penerimaan
						// $nopembukuan = $dt_penerimaan_dtl['NomorPembukuan'];
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan`='$nomorpembukuan'"));
						$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
												
						echo "<b>".$namaobat."</b><br/>".
						"No.Batch : ".$nobatch."<br/>".
						"Expire : ".date('d-m-Y', strtotime($dtobat['Expire']))."<br/>".
						"Sumber : ".$dtobat['SumberAnggaran']."<br/>".
						"Tgl.Terima : ".$dtpenerimaan['TanggalPenerimaan']."<br/>".
						"Faktur Terima : ".$dtobat['NoFakturTerima']."<br/>".
						"Supplier : ".$dtsupplier['nama_prod_obat'];
						?>
					</td>
					<td align="right"><?php echo rupiah($stokawal);?></td>
					<td align="right"><?php echo rupiah($penerimaan);?></td>
					<td align="right"><?php echo rupiah($pengeluarantotal);?></td>
					<td align="right"><?php echo rupiah($sisastok);?></td>
					<td align="right"><?php echo number_format($harga,2,",",".");?></td>
					<td align="right"><?php echo rupiah($saldo);?></td>
					<td style="text-align:center; vertical-align:middle; padding:5px;"><a href="?page=lap_gfk_kartustok_vaksin_lihat&nf=<?php echo $nomorpembukuan;?>&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $key;?>" class="btn btn-sm btn-info btn-white">Lihat</a></td>
				</tr>
			<?php
				$totalstokawal = $totalstokawal + $stokawal;
				$totalpenerimaan = $totalpenerimaan + $penerimaan;
				$totalpengeluaran = $totalpengeluaran + $pengeluarantotal;
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
					<td align="right"></td>
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
						echo "<li><a href='?page=lap_gfk_kartustok_vaksin&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php 
	}
	?>
</div>	



