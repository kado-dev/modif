<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KARTU STOK (GROUP)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_kartustok_group_bogorkab"/>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang/Batch/Program" required>
								</div>	
							</div>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_kartustok_group_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-success btn-white"><span class="fa fa-print"></span></a>
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
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>KARTU STOK (PER-JENIS BARANG)</b></span><br>
		<br/>
	</div>
	
	<div class="table-responsive">
		<table class="table-judul-laporan">
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
					<th width="5%" style="text-align:center; vertical-align:middle; padding:10px;" class="noprint">Opsi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$jumlah_perpage = 20;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$no = 0;				
			$str = "SELECT * FROM `tbgfkstok` WHERE (`KodeBarang` like '%$key%' OR `NamaBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%') AND `SumberAnggaran` != 'BLUD'";	
			$str2 = $str." GROUP BY `KodeBarang`,`Expire`, `Produsen` ORDER BY `NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";	
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
				$tahunanggaran = $dtobat['TahunAnggaran'];
				
				// tahap1, stok awal, ini ngambil sisa stok yang bulan des 2019
				$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat ' AND `NoBatch`='$nobatch'";
				$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
				if ($dt_stokawal_dtl['Stok'] != null){
					$stokawal = $dt_stokawal_dtl['Stok'];
				}else{
					$stokawal = '0';
				}				
				
				// tahap2, penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
				$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND SUBSTRING(NomorPembukuan,5,4)='$tahunanggaran'";
								
				$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
				if ($dt_penerimaan_dtl['Jumlah'] != null){
					$penerimaan = $dt_penerimaan_dtl['Jumlah'];
				}else{
					$penerimaan = '0';
				}
				
				// tahap3, pengeluaran detail
				$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND SUBSTRING(NoFakturTerima,5,4)='$tahunanggaran'";
				
				$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
				if ($dt_pengeluaran_dtl['Jumlah'] != null){
					$pengeluaran = $dt_pengeluaran_dtl['Jumlah'];
				}else{
					$pengeluaran = '0';
				}
				
				// tahap4, sisastok, jika penerimaan 0, ngambil dari stok awal
				if($penerimaan == 0){
					$sisastok = $stokawal - $pengeluaran;
				}else{
					$sisastok = $stokawal + $penerimaan - $pengeluaran;
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
							
						if($dt_penerimaan_dtl['NomorPembukuan'] == ""){
							$nopembukuan = "SO ".$dtsomaster['Keterangan'];	
						}else{
							$nopembukuan = $dtobat['NoFakturTerima'];
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
						
						echo "<b>".$namaobat."</b><br/>".
						"No.Batch : ".$nobatch."<br/>".
						"Expire : ".date('d-m-Y', strtotime($dtobat['Expire']))."<br/>".
						"Sumber : ".$dtobat['SumberAnggaran']." - ".$dtobat['TahunAnggaran']."<br/>".
						"No.Faktur : ".$nopembukuan."<br/>".
						"Suppliyer : ".$supplier."<br/>".
						"Tgl.Terima : ".$tglterima."<br/>".
						"Program : ".$dtobat['NamaProgram'];
						?>
					</td>
					<td align="right"><?php echo rupiah($stokawal);?></td>
					<td align="right"><?php echo rupiah($penerimaan);?></td>
					<td align="right"><?php echo rupiah($pengeluaran);?></td>
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
					<td style="text-align:center; vertical-align:middle; padding:5px;" class="noprint"><a href="?page=lap_gfk_kartustok_group_bogorkab_lihat&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $dtobat['NamaBarang'];?>&nofakturterima=<?php echo $dtobat['NoFakturTerima'];?>" class="btn btn-sm btn-danger">Lihat</a></td>
				</tr>
			<?php
			}
			?>		
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
						echo "<li><a href='?page=lap_gfk_kartustok_group_bogorkab&key=$key&h=$i'>$i</a></li>";
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


