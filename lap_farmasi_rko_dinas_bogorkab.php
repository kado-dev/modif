<?php
include "config/koneksi.php";
session_start();
error_reporting(1);
$kodeobat = $_POST['kode']; 
$jumlahisi = $_POST['isi']; 
$tahun = $_POST['tahun'];
$tanggal = date('d-m-Y');
?>
<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css">

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">RENCANA KEBUTUHAN OBAT</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_rko_dinas_bogorkab"/>
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="namaprogram" class="form-control">
								<option value='semua'>Semua</option>
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
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_rko_dinas_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_rko_dinas_bogorkab_excel.php?tahun=<?php echo $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	$namaprogram = $_GET['namaprogram'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$tahun2 = $tahun + 1;	
	if(isset($tahun)){
	?>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%"><!--style="width:1500px"-->
					<thead>
						<tr style="border:1px sollid #000;">
							<th width="2%" rowspan="3">No</th>
							<th width="5%" rowspan="3">Kode</th>
							<th width="20%" rowspan="3">Nama Barang</th>
							<th width="5%" rowspan="3">Satuan</th>
							<th width="5%" rowspan="2">Harga</br>Satuan</th>
							<th width="5%" rowspan="2">Stok Awal <br/> <?php //echo "Januari ".$tahun1?></th>
							<th width="5%" rowspan="2">Penerimaan <br/> <?php //echo $tahun1?></th>
							<th width="5%" rowspan="2">Total <br/>Persediaan
							<th width="5%" rowspan="2">Pemakaian <br/>
							<th width="5%" rowspan="2">Sisa Stok <br/>
							<th width="5%" rowspan="2">Jumlah</br>Bulan Pemakaian <br/> <?php //echo $tahun1?></th>
							<th width="5%" rowspan="2">Pemakaian</br>Rata2 /Bulan</th>
							<th width="5%" rowspan="2">Jumlah</br>Kebutuhan</th>
							<th width="5%" rowspan="2">Rencana</br>Kebutuhan Obat</th>
							<th width="5%" rowspan="2">Total RKO</br>(Rp)</th>
							<th width="5%" rowspan="2">Rencana</br>Pembelian</th>
							<th width="5%" rowspan="2">Total Pembelian</br>(Rp)</th>
						</tr>	
					</thead>
					<tbody style="font-size:12px;">
					<?php
						$jumlah_perpage = 10;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}					
						
						if($namaprogram == "semua"){
							$str = "SELECT * FROM `ref_obat_lplpo` ORDER BY IdLplpo, NamaBarang";
						}else{
							$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram` = '$namaprogram'  GROUP BY KodeBarang, IdBarang ORDER BY NamaBarang";
						}	
							
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						//echo $str2;
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprograms != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$data[NamaProgram]</td></tr>";
								$namaprograms = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							
							// tbgfkstok, harga diambil dari tahun awal / anggaran terakhir
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT HargaBeli FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY TahunAnggaran DESC"));
							
							// stokawal, cukup berdasarkan kodebarang saja karena diambil dari ref_obat_lplpo
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Jumlah FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun1'"));
							if($dtstokawal['Jumlah'] != 0){
								$stokawals = $dtstokawal['Jumlah'];
							}else{
								$stokawals = "0";
							}
							
							// penerimaan
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPenerimaan`)='$tahun'"));
							if($dtpenerimaan['Jumlah'] != 0){
								$penerimaans = $dtpenerimaan['Jumlah'];
							}else{
								$penerimaans = "0";
							}
										
							// total persediaan
							$totalpersediaan = $stokawals + $penerimaans;
							
							// pemakaian
							$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NoFaktur, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun'"));
							if($dtpengeluaran['Jumlah'] != 0){
								$pengeluarans = $dtpengeluaran['Jumlah'];
							}else{
								$pengeluarans = "0";
							}
							
							// sisastok
							$sisastok = $totalpersediaan - $pengeluarans;
							
							// jumlah bulan
							$str_jmlbulan = "SELECT COUNT(b.TanggalPengeluaran) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun' GROUP BY YEAR(b.TanggalPengeluaran), MONTH(b.TanggalPengeluaran)";
							$dt_jumlahbulan = mysqli_num_rows(mysqli_query($koneksi, $str_jmlbulan));
							
							// pemakaian rata-rata
							$pemakaian_rata = $pengeluarans / $dt_jumlahbulan;
							if($pemakaian_rata != 0){
								$pemakaian_ratas = $pemakaian_rata;
							}else{
								$pemakaian_ratas = "0";
							}
							
							// jumlah kebutuhan
							$jumlah_kebutuhan = $pemakaian_ratas * 18;
							
							// rencana kebutuhan
							$rencana_kebutuhan = $jumlah_kebutuhan - $sisastok;
							
							// total_rencana kebutuhan
							$total_rko = $rencana_kebutuhan * $dtgfkstok['HargaBeli'];
							
							?>
							<tr>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $kodebarang;?></td>
								<td style="text-align:left; border:1px sollid #000; padding:3px;" class="namabarangcls"><?php echo strtoupper($namabarang);?></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($dtgfkstok['HargaBeli']);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($stokawals);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($penerimaans);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($totalpersediaan);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($pengeluarans);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($sisastok);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $dt_jumlahbulan;?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($pemakaian_ratas);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($jumlah_kebutuhan);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($rencana_kebutuhan);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($total_rko);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"></td>
							</tr>
					<?php
					}


						$query2 = mysqli_query($koneksi,$str);
						while($data2 = mysqli_fetch_assoc($query2)){
							
							$kodebarang = $data2['KodeBarang'];
							$namabarang = $data2['NamaBarang'];
							
							// tbgfkstok, harga diambil dari tahun awal / anggaran terakhir
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT HargaBeli FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY TahunAnggaran DESC"));
							
							// stokawal, cukup berdasarkan kodebarang saja karena diambil dari ref_obat_lplpo
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Jumlah FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun1'"));
							if($dtstokawal['Jumlah'] != 0){
								$stokawals = $dtstokawal['Jumlah'];
							}else{
								$stokawals = "0";
							}
							
							// penerimaan
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPenerimaan`)='$tahun'"));
							if($dtpenerimaan['Jumlah'] != 0){
								$penerimaans = $dtpenerimaan['Jumlah'];
							}else{
								$penerimaans = "0";
							}
										
							// total persediaan
							$totalpersediaan = $stokawals + $penerimaans;
							
							// pemakaian
							$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NoFaktur, SUM(a.Jumlah)AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun'"));
							if($dtpengeluaran['Jumlah'] != 0){
								$pengeluarans = $dtpengeluaran['Jumlah'];
							}else{
								$pengeluarans = "0";
							}
							
							// sisastok
							$sisastok = $totalpersediaan - $pengeluarans;
							
							// jumlah bulan
							$str_jmlbulan = "SELECT COUNT(b.TanggalPengeluaran) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.`TanggalPengeluaran`)='$tahun' GROUP BY YEAR(b.TanggalPengeluaran), MONTH(b.TanggalPengeluaran)";
							$dt_jumlahbulan = mysqli_num_rows(mysqli_query($koneksi, $str_jmlbulan));
							
							// pemakaian rata-rata
							$pemakaian_rata = $pengeluarans / $dt_jumlahbulan;
							if($pemakaian_rata != 0){
								$pemakaian_ratas = $pemakaian_rata;
							}else{
								$pemakaian_ratas = "0";
							}
							
							// jumlah kebutuhan
							$jumlah_kebutuhan = $pemakaian_ratas * 18;
							
							// rencana kebutuhan
							$rencana_kebutuhan = $jumlah_kebutuhan - $sisastok;
							
							// total_rencana kebutuhan
							$total_rko = $rencana_kebutuhan * $dtgfkstok['HargaBeli'];

							$hargabeli_tot[] = $dtgfkstok['HargaBeli'];
							$stokawals_tot[] = $stokawals;
							$penerimaans_tot[] = $penerimaans;
							$totalpersediaan_tot[] = $totalpersediaan;
							$pengeluarans_tot[] = $pengeluarans;
							$sisastok_tot[] = $sisastok;
							$dt_jumlahbulan_tot[] = $dt_jumlahbulan;
							$pemakaian_ratas_tot[] = $pemakaian_ratas;
							$jumlah_kebutuhan_tot[] = $jumlah_kebutuhan;
							$rencana_kebutuhan_tot[] = $rencana_kebutuhan;
							$total_rko_tot[] = $total_rko;
						}	
					?>
							<tr>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"></td>
								<td style="text-align:left; border:1px sollid #000; padding:3px;" class="namabarangcls">Total</td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($hargabeli_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($stokawals_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($penerimaans_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($totalpersediaan_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($pengeluarans_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($sisastok_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo array_sum($dt_jumlahbulan_tot);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($pemakaian_ratas_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($jumlah_kebutuhan_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($rencana_kebutuhan_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah(array_sum($total_rko_tot));?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"></td>
							</tr>
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
						echo "<li><a href='?page=lap_farmasi_rko_dinas_bogorkab&tahun=$tahun&namaprogram=$namaprogram&key=$key&h=$i'>$i</a></li>";
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
				<p><b>Perhatikan :</b></br>
				- <b>Nama Barang,</b> cukup 1 (akumulasi)</br>
				- <b>Harga,</b> terakhir dari sistem</br>
				- <b>Stok Awal,</b> stok akhir tahun lalu</br>
				- <b>Penerimaan,</b> selama satu tahun berjalan</br>
				- <b>Total Persediaan,</b> Stok awal + Penerimaan</br>
				- <b>Pemakaian,</b> selama satu tahun berjalan</br>
				- <b>Sisa stok,</b> total persediaan - Pemakaian</br>
				- <b>Julmlah bulan pemakaian,</b> jumlah bulan yang ada pemakaiannya</br>
				- <b>Pemakaian rata2 bulan,</b> pemakaian dibagi jumlah bulan pemakaian</br>
				- <b>Jumlah kebutuhan,</b> pemakaian rata2 perbulan dikali 18 bulan</br>
				- <b>Rencana kebutuhan,</b> jumlah kebutuhan dikurangi sisa stok</br>
				- <b>Total Rupiah Kebutuhan,</b> rencana kebutuhan kali harga</br>
				- <b>Rencana Pembelian,</b> kolom kosong yang bisa diisi manual</br>
				- <b>Total Rupiah Rencana Pembelian,</b> rencana Pembelian dikali harga</br>
				</p>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	
</div>	
