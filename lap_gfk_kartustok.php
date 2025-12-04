<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KARTU STOK (BATCH)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_kartustok"/>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang/Batch/Program" required>
								</div>	
							</div>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_kartustok" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
							<a href="lap_gfk_kartustok_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>KARTU STOK (PER-JENIS BARANG)</b></span><br>
		<br/>
	</div>
	
	<div class="table-responsive">
		<table class="table-judul">
			<thead>
				<tr>
					<th style="text-align:center; vertical-align:middle; padding:10px;">NO.</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">KODE OBAT</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">NAMA OBAT</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">STOK AWAL</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">PENERIMAAN</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">PENGELUARAN</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">SISA STOK</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">HARGA SATUAN</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;">SALDO</th>
					<th style="text-align:center; vertical-align:middle; padding:10px;" class="noprint">#</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$jumlah_perpage = 100;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$no = 0;				
			$str = "SELECT * FROM `tbgfkstok` WHERE (`KodeBarang` like '%$key%' OR `NamaBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%') AND `SumberAnggaran` != 'BLUD'";	
			$str2 = $str." ORDER BY `NamaBarang` ASC limit $mulai,$jumlah_perpage";	
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
				$nobatch = $dtobat['NoBatch'];
				$stok = $dtobat['Stok'];
				$harga = $dtobat['HargaBeli'];
				$nofakturterima = $dtobat['NoFakturTerima'];
				
				// tahap1, stok awal, ini ngambil sisa stok yang bulan des 2019
				$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'";
				$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
				if ($dt_stokawal_dtl['Stok'] != null){
					$stokawal = $dt_stokawal_dtl['Stok'];
				}else{
					$stokawal = '0';
				}				
				
				// tahap2, penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
				if($kota == "KABUPATEN BEKASI"){
					$str_penerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodeobat ' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan) > '2019' AND a.NomorPembukuan='$dtobat[NoFakturTerima]'";
				}else{
					$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$dtobat[NoFakturTerima]'";
				}	
				// echo $str_penerimaan;

				$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
				if ($dt_penerimaan_dtl['Jumlah'] != null){
					$penerimaan = $dt_penerimaan_dtl['Jumlah'];
				}else{
					$penerimaan = '0';
				}
				
				// tahap3, pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
				if ($kota == "KABUPATEN BEKASI"){
					$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a LEFT JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodeobat' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'";
				}else{
					$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch` = '$nobatch' AND `NoFakturTerima`='$nofakturterima' AND NoFaktur != ''";
				}	
				// echo $str_pengeluaran;
				
				$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
				if ($dt_pengeluaran_dtl['Jumlah'] != null){
					$pengeluaran = $dt_pengeluaran_dtl['Jumlah'];
				}else{
					$pengeluaran = '0';
				}
				
				// tahap4, karantina
				$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'";
				$dt_karantina = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
				if ($dt_karantina['Jumlah'] != null){
					$karantina = $dt_karantina['Jumlah'];
				}else{
					$karantina = '0';
				}
				// echo $str_karantina;

				// tahap5, pemusnahan
				$str_pemusnahan = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_pemusnahandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'";
				$dt_pemusnahan = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pemusnahan));
				if ($dt_pemusnahan['Jumlah'] != null){
					$pemusnahan = $dt_pemusnahan['Jumlah'];
				}else{
					$pemusnahan = '0';
				}
				// echo $str_pemusnahan;
				
				$pengeluarantotal = $pengeluaran + $karantina + $pemusnahan;
				
				// tahap6, sisastok, jika penerimaan 0, ngambil dari stok awal
				if($penerimaan == 0){
					$sisastok = $stokawal - $pengeluaran - $karantina - $pemusnahan;
				}else{
					$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina - $pemusnahan;
				}	
				$saldo = $sisastok * $harga;
			?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="center"><?php echo $kodeobat;?></td>
					<td align="left">
						<?php 
						// stok awal master
						$dtsomaster = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'"));
						if($dtsomaster['IdBarang'] != ""){
							$nopembukuan = "SO ".$dtsomaster['Keterangan'];	
						}else{
							$nopembukuan = $nofakturterima;
						}	
						
						// penerimaan
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkpenerimaan` WHERE `NomorPembukuan`='$nopembukuan'"));
						$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
						if ($dtsupplier['nama_prod_obat'] == ""){
							$dtsupp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfksupplier` WHERE `KodeSupplier`='$dtpenerimaan[KodeSupplier]'"));
							$supplier = $dtsupp['Supplier'];
						}else{
							$supplier = $dtsupplier['nama_prod_obat'];	
						}															
							
						// cek tanggal terima
						if ($dtpenerimaan['TanggalPenerimaan'] == ""){
							$tglterima = $dtsomaster['Bulan']."-".$dtsomaster['Tahun'];
						}else{
							$tglterima = date("d-m-Y", strtotime($dtpenerimaan['TanggalPenerimaan']));
						}	
						
						if($kota == "KABUPATEN BANDUNG"){
							$stsanggaran = "Status Anggaran : ".$dtobat['StatusAnggaran'];
						}	
						
						echo "<b>".$namaobat."</b><br/>".
						"No.Batch : ".$nobatch."<br/>".
						"Expire : ".date('d-m-Y', strtotime($dtobat['Expire']))."<br/>".
						"Sumber : ".$dtobat['SumberAnggaran']." - ".$dtobat['TahunAnggaran']."<br/>".
						$stsanggaran.
						"Tgl.Terima : ".$tglterima."<br/>".
						"Faktur Terima : ".$nopembukuan."<br/>".
						"Supplier : ".$supplier."<br/>".
						"Program : ".$dtobat['NamaProgram'];
						?>
					</td>
					<td align="right"><?php echo rupiah($stokawal);?></td>
					<td align="right"><?php echo rupiah($penerimaan);?></td>
					<td align="right"><?php echo rupiah($pengeluarantotal);?></td>
					<td align="right"><?php echo rupiah($sisastok);?></td>
					<td align="right">
						<?php
						$cx = strpos($harga, ".");
						// $cx = strpos($harga, ",");
						if($cx > 0){
							echo number_format($harga,2,",",".");
						}else{
							echo rupiah($harga);
						}
						?>	
					</td>
					<td align="right">
						<?php 
							// echo rupiah($saldo);
							$cx = strpos($saldo, ",");

							if($cx > 0){
								echo number_format($saldo,2,",",".");
							}else{
								echo rupiah($saldo);
							}
						?>
					</td>
					<td style="text-align:center; vertical-align:middle; padding:5px;" class="noprint"><a href="?page=lap_gfk_kartustok_lihat&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $dtobat['NamaBarang'];?>&nofakturterima=<?php echo $dtobat['NoFakturTerima'];?>" class="btn btn-sm btn-info btn-white">Lihat</a></td>
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
	<ul class="pagination noprint">
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
						echo "<li><a href='?page=lap_gfk_kartustok&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php 
	}
	?>
</div>	

<div class="bawahtabel" style="margin-left:30px;">
	<table width="100%">
		<?php  $dt_sbbk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk`")); ?>
		<tr style="font-size: 12px;">
			<td style="text-align:center;">
			<p>Mengetahui,<br/>
			<?php if($kota == "KABUPATEN BOGOR"){?>
				Kasie Kefarmasian
			<?php }else{?>
				Kepala UPTD Farmasi
			<?php } ?>
			<br>
			<br>
			<br>
			<br>
			<b><u><?php echo $dt_sbbk['nama_kasie'];?></u></b><br/>
			<?php echo "NIP. ".$dt_sbbk['nip_kasie'];?></p>
			</td>
			<td width="10%"></td>
			<td style="text-align:center;">
			<p><?php echo $kota.", ".date('d-m-Y');?><br/>
			Pengelola Barang
			<br>
			<br>
			<br>
			<br>
			<b><u><?php echo $dt_sbbk['nama_pemberi'];?></u></b><br/>
			<?php echo "NIP. ".$dt_sbbk['nip_pemberi'];?></p>
			</td>
		</tr>
	</table>
</div>	


