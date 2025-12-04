<?php
include "config/koneksi.php";
session_start();
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kodeobat = $_POST['kode']; 
$jumlahisi = $_POST['isi']; 
$tahun = $_POST['tahun'];
$tanggal = date('d-m-Y');
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul">RENCANA KEBUTUHAN OBAT</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_rko_bogorkab_dinkes"/>
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									// for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									for($tahun = 2021 ; $tahun <= 2025; $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprogram" class="form-control">
									<option value='Semua'>Semua</option>
									<?php
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprogram'] == $data3['nama_program']){
											echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
										}else{
											echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Program</span>
							</div>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_rko_bogorkab_dinkes" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="lap_farmasi_rko_bogorkab_dinkes_print.php?tahun=<?php echo $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>" class="btn btn-primary btn-white"><span class="fa fa-print"></span></a>-->
							<a href="lap_farmasi_rko_bogorkab_dinkes_excel.php?tahun=<?php echo $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$namaprogram = $_GET['namaprogram'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$tahun2 = $tahun - 2;
	$tahun3 = $tahun - 3;	
	if(isset($tahun)){
	?>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="font-size:12px;">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="27%">Nama Barang</th>
							<th width="5%">Satuan</th>
							<th width="5%">Harga Satuan</th>
							<th width="5%">Stok Akhir <?php echo "Desember ".$tahun2?></th>
							<th width="5%"><?php echo "Penerimaan ".$tahun2?></th>
							<th width="5%">Total Persediaan</th>
							<th width="5%"><?php echo "Pemakaian ".$tahun2?></th>
							<th width="5%">Sisa Stok</th>
							<th width="5%">Jumlah Bulan Pemakaian</th>
							<th width="5%">Pemakaian Rata2 Per-Bulan</th>
							<th width="5%">Jumlah Kebutuhan</th>
							<th width="5%">Rencana Kebutuhan <br/> Obat</th>
							<th width="5%">Total Rupiah RKO</th>
							<th width="5%">Rencana Pembelian</th>
							<th width="5%">Total Rupiah Pembelian</th>
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
						
						if($namaprogram == "Semua" || $namaprogram == ""){
							$program = "";
						}else{
							$program = "AND `NamaProgram`='$namaprogram'";
						}
							
						// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
						$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%') ".$program;
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
							
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								if($data['NamaProgram'] == "PKD"){
									$prg = "OBAT (PKD)";	
								}else{
									$prg = $data['NamaProgram'];
								}	
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$prg</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$nobatch = $data['NoBatch'];
							
							// hargabeli
							$hargabeli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY `IdBarang` DESC"));
							
							// stokawal
							$strstokmaster = "SELECT SUM(Stok) AS Jumlah FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
							// echo $strstokmaster;
							$dtstokmaster = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokmaster));
							$jumlahmaster = $dtstokmaster['Jumlah'];
							
							$strpenerimaanlalu = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE YEAR(a.`TanggalPenerimaan`)<'$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
							// echo $strpenerimaanlalu;
							$dtpenerimaanlalu = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaanlalu));
							$jumlahterimalalu = $dtpenerimaanlalu['Jumlah'];
							
							$strpengeluaranlalu = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
							WHERE YEAR(a.`TanggalPengeluaran`)<'$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
							// echo $strpengeluaranlalu;
							$dtpengeluaranlalu = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaranlalu));
							$jumlahkeluarlalu = $dtpengeluaranlalu['Jumlah'];
							
							$stokawal = $jumlahmaster + $jumlahterimalalu - $jumlahkeluarlalu;		
							
							// penerimaan
							$strpenerimaan = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpenerimaan` a JOIN `tbgfkpenerimaandetail` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE YEAR(a.`TanggalPenerimaan`)='$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
							$jumlahterima = $dtpenerimaan['Jumlah'];
							
							// pemakaian
							$strpengeluaran = "SELECT SUM(b.`Jumlah`) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
							WHERE YEAR(a.`TanggalPengeluaran`)='$tahun2' AND b.`KodeBarang`='$kodebarang' AND b.`NamaProgram` = '$data[NamaProgram]'";
							$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
							$jumlahkeluar = $dtpengeluaran['Jumlah'];	
							
							// persediaan
							$persediaan = $stokawal + $jumlahterima;
							
							// sisa stok
							$sisastok = $persediaan - $jumlahkeluar;
							
							// bulan pemakaian
							$bulanpemakaian = mysqli_num_rows(mysqli_query($koneksi, "SELECT b.TanggalPengeluaran FROM `tbgfkpengeluarandetail` a
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
							WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran)='$tahun2'
							GROUP BY MONTH(TanggalPengeluaran)"));
							
							// pemakaian rata-rata
							$pemakaianrata = $jumlahkeluar / $bulanpemakaian;
							
							// jumlah kebutuhan
							$jumlahkebutuhan = $pemakaianrata * 18;
							
							// rencana kebutuhan
							if($jumlahkebutuhan == 0){
								$rencanakebutuhan = $sisastok;
							}else{	
								$rencanakebutuhan = $jumlahkebutuhan - $sisastok;
							}
							
							// total rupiah rko
							$totalrupiahrko = $rencanakebutuhan * $hargabeli['HargaBeli'];
							
							?>
							<tr>
								<td style="text-align:right;"><?php echo $no;?></td>
								<td style="text-align:left;" class="namabarangcls">
								<?php 
									echo strtoupper($namabarang)."<br/>";
									// echo $data['KodeBarang']."<br/>";
									// echo "<b>Keterangan :</b><br/>";
									// echo "Stok Master = ".$jumlahmaster."<br/>";
									// echo "Penerimaan Lalu = ".$jumlahterimalalu."<br/>";
									// echo "Pengeluaran Lalu = ".$jumlahkeluarlalu."<br/>";
									// echo "Saldo Awal = ".$stokawal;
								?>
								</td>
								<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right;"><?php echo rupiah($hargabeli['HargaBeli']);?></td>
								<td style="text-align:right;"><?php echo rupiah($stokawal);?></td><!--Stokawal-->
								<td style="text-align:right;"><?php echo rupiah($jumlahterima);?></td><!--Penerimaan-->
								<td style="text-align:right;"><?php echo rupiah($persediaan);?></td><!--Total Persediaan-->
								<td style="text-align:right;"><?php echo rupiah($jumlahkeluar);?></td><!--Pemakaian-->
								<td style="text-align:right;"><?php echo rupiah($sisastok);?></td><!--Sisa Stok-->
								<td style="text-align:right;"><?php echo $bulanpemakaian;?></td><!--Jumlah Bulan Pemakaian-->
								<td style="text-align:right;"><?php echo rupiah(ceil($pemakaianrata));?></td><!--Pemakaian Rata2 PerBulan-->
								<td style="text-align:right;"><?php echo rupiah(ceil($jumlahkebutuhan));?></td><!--Jumlah Kebutuhan-->
								<td style="text-align:right;"><?php echo rupiah(ceil($rencanakebutuhan));?></td><!--Rencana Kebutuhan Obat-->
								<td style="text-align:right;"><?php echo rupiah($totalrupiahrko);?></td><!--Total Rupiah RKO-->
								<td style="text-align:center;">-</td><!--Rencana Pembelian-->
								<td style="text-align:center;">-</td><!--Total Rupiah Pembelian-->
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_rko_bogorkab_dinkes&tahun=$tahun&namaprogram=$namaprogram&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<br/>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b><br>
				- Nama Barang, group tampilkan 1 barang saja<br/>
				- Harga Satuan, harga terakhir yang ada di Sistem<br/>
				- Stok Akhir, misal rko 2021 stok awal adalah stok akhir desember 2019<br/>
				- Penerimaan, misal rko 2021 maka penerimaan selama 2019<br/>
				- Persediaan, stok awal ditambah penerimaan<br/>
				- Pemakaian, misal rko 2021 maka pemakaian selama 2019<br/>
				- Sisa Stok, persediaan dikurang pemakaian<br/>
				- Bulan Pemakaian, jumlah bulan yang ada pemakaian<br/>
				- Pemakaian Rata-rata, pemakaian dibagi jumlah bulan pemakaian<br/>
				- Jumlah Kebutuhan, pemakaian rata-rata perbulan dikali 18 bulan<br/>
				- Rencana Kebutuhan, jumlah kebutuhan dikurang sisa stok<br/>
				- Total Rupiah RKO, rencana kebutuhan dikali harga satuan<br/>
				- Rencana Pembelian dan Total Rupiah Pembelian, diisi manual<br/>
				</p>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	
