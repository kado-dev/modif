<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KETERSEDIAAN OBAT ESENSIAL</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="elog_provinsi_ketersediaan_obat_bekasikab"/>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon tesdate">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="keydate1" class="form-control datepicker" value="<?php echo $_GET['keydate1'];?>" placeholder="Tanggal Awal" autofocus required>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon tesdate">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="keydate2" class="form-control datepicker" value="<?php echo $_GET['keydate2'];?>" placeholder="Tanggal Akhir" required>
							</div>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=elog_provinsi_ketersediaan_obat_bekasikab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="elog_provinsi_ketersediaan_obat_bekasikab_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
		$keydate1 = date('Y-m-d', strtotime($_GET['keydate1']));
		$keydate2 = date('Y-m-d', strtotime($_GET['keydate2']));
		if(isset($_GET['keydate1'])){
	?>	
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $_GET['keydate1']." s/d ".$_GET['keydate2'];?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</td>
							<th width="7%">KODE</td>
							<th width="40%">NAMA BARANG</td>
							<th width="10%">SATUAN</td>
							<th width="10%">SALDO AWAL</td>
							<th width="10%">PENERIMAAN</td>
							<th width="10%">PENGELUARAN</td>
							<th width="10%">SALDO AKHIR</td>
						</tr>
					</thead>
					<tbody>
						<?php						
							// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
							$str = "SELECT * FROM `ref_obatindikator`";
							$str2 = $str." ORDER BY `nama_indikator` ASC";
							// echo $str2;	
														
							$query_obat = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query_obat)){
								$no = $no + 1;
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['nama_indikator'];
								
								// ref_obat_lplpo
								$dtlplpo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Satuan` FROM `ref_obat_lplpo` WHERE `KodeBarang`='$kodebarang' LIMIT 1"));
								$satuan = $dtlplpo['Satuan'];
								
								// tahap2, menentukan stok awal stok / saldo awal
								$nbct = implode(",", $nobats[$no]);
								$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang'";
								// echo $str_stokawal;
								$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
								if ($dt_stokawal_dtl['Stok'] != ''){
									$stokawal = $dt_stokawal_dtl['Stok'];
								}else{
									$stokawal = '0';
								}
																
								// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
								$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
								FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPenerimaan < '$keydate1' AND YEAR(b.TanggalPenerimaan) != 2019";
								// echo $str_terima_lalu;
								$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
								if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
									$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
								}else{
									$penerimaan_lalu = '0';
								}

								// tahap2.2 cek pengeluaran sebelumnya
								if(substr($namabarang,0,6) == "VAKSIN" || substr($namabarang,0,7) == "PELARUT"){
									$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
									JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPengeluaran < '$keydate1'";	
								}else{
									$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
									JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPengeluaran < '$keydate1'";	
								}
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}		
								
								// tahap2.3 cek pengeluaran sebelumnya
								$str_pengeluaran_lalu_2019 = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran) = '2019'";	
								// echo $str_pengeluaran_lalu_2019;
								$dt_pengeluaran_lalu_2019 = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu_2019));									
								if ($dt_pengeluaran_lalu_2019['Jumlah'] != null){
									$pengeluaran_lalu_2019 = $dt_pengeluaran_lalu_2019['Jumlah'];
								}else{
									$pengeluaran_lalu_2019 = '0';
								}	
								
								$pengeluaran_lalu_jumlah = $pengeluaran_lalu - $pengeluaran_lalu_2019;
								if ($pengeluaran_lalu_jumlah < 0){
									$pengeluaran_lalu_jumlah1 = 0;
								}else{
									$pengeluaran_lalu_jumlah1 = $pengeluaran_lalu_jumlah;
								}	
								
								// tahap 2.4 cek karantina lalu
								$str_karantina_lalu = "SELECT SUM(a.`Jumlah`) AS Jumlah , b.TanggalKarantina, b.NoFaktur, b.StatusKarantina 
								FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalKarantina < '$keydate1'";
								$dt_karantina_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina_lalu));
								$karantina_lalu = $dt_karantina_lalu['Jumlah'];
										
								$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu_jumlah1 - $karantina_lalu;
								// echo "Stok Awal : ".$stokawal."<br/>";
								// echo "Terima : ".$penerimaan_lalu."<br/>";
								// echo "Keluar : ".$pengeluaran_lalu."<br/>";

								// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
								$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
									$penerimaan = $dtpenerimaan['Jumlah'];
								}else{
									$penerimaan = '0';
								}		
								
								// tahap4, menentukan pemakaian/pengeluaran
								$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								LEFT JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND b.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2'";
								// echo $strpengeluaran;
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));								
								if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
									$pengeluaran = $dtpengeluaran['Jumlah'];
								}else{
									$pengeluaran = '0';
								}	
														
								$pengeluaran_total = $pengeluaran;
																
								// tahap5, sisaakhir
								$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran_total;
								
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:center;"><?php echo $data['KodeBarang'];?></td>
									<td style="text-align:left;" class="namabarangcls">
										<?php 
											echo strtoupper($namabarang);
											// echo "<b>Keterangan :</b><br/>";
											// echo "Stok Master = ".$stokawal."<br/>";
											// echo "Penerimaan Lalu = ".$penerimaan_lalu."<br/>";
											// echo "Pengeluaran Lalu = ".$pengeluaran."<br/>";
											// echo "Saldo Awal = ".$stokawal_total;
										?>
									</td>
									<td style="text-align:center;"><?php echo $satuan;?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran_total);?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
								</tr>
							<?php
							}
							?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<ul class="pagination noprint">
		<?php			
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=elog_provinsi_ketersediaan_obat_bekasikab&keydate1=$keydate1&keydate2=$keydate2&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php }?>
</div>	