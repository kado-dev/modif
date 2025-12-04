<?php
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$nofakturterima = $_GET['faktur'];
	$statusgudang = $_GET['stsgudang'];
	$key = $_GET['key'];
	$jmltersedia = $_GET['jmltersedia'];
	$str = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	$hariini = date("d-m-Y");
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>Karantina Barang</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form class="form-horizontal" action="index.php?page=gudang_besar_karantina_proses" method="post" role="form">
						<table class="table">
                            <h3 class="judul"><b><?php echo $data['NamaBarang'];?></b></h3>
							<tr>
								<td class="col-sm-2">No.Faktur Terima</td>
								<td class="col-sm-10">
									<label><?php echo $data['NoFakturTerima'];?></label>
								</td>
							</tr>
							<tr>
								<td>Kode Barang</td>
								<td class="col-sm-10">
                                    <label><?php echo $data['KodeBarang'];?></label>
								</td>
							</tr>
							<tr>
								<td>Batch</td>
								<td>
                                 <label><?php echo $data['NoBatch'];?></label>
								</td>
							</tr>
							<tr>
								<td>Expire</td>
								<td>
                                 <label><?php echo date('d-m-Y', strtotime($data['Expire']));?></label>
								</td>
							</tr>
                            <tr>
								<td>Satuan</td>
								<td>
                                 <label><?php echo $data['Satuan'];?></label>
								</td>
							</tr>
                            <tr>
								<td>Nama Program</td>
								<td>
                                 <label><?php echo $data['NamaProgram'];?></label>
								</td>
							</tr>
							<tr>
								<td>Harga Beli (Rp)</td>
								<td>
                                    <label><?php echo $data['HargaBeli'];?></label>
								</td>
							</tr>
							<tr>
								<td>Stok</td>
								<td>
                                    <label><?php echo $data['Stok'];?></label>
								</td>
							</tr>
							<tr>
								<td>Stok Awal</td>
								<td>
                                    <label>
										<?php 
											// 1. stok awal, ini ngambil sisa stok yang bulan des 2019
											$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
											$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
											if ($dt_stokawal_dtl['Stok'] != null){
												$stokawal = $dt_stokawal_dtl['Stok'];
											}else{
												$stokawal = '0';
											}
											echo $stokawal."</br>";	
										?>
									</label>
								</td>
							</tr>
							<tr>
								<td>Penerimaan</td>
								<td>
                                    <label>
										<?php 
											if($kota == "KABUPATEN BEKASI"){
												$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
												FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
												WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' 
												AND YEAR(b.TanggalPenerimaan) > '2019'"));
											}else{
												$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
												FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
												WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'"));
											}
											
											if ($dtpenerimaandtl['Jumlah'] != null){
												$penerimaan = $dtpenerimaandtl['Jumlah'];
											}else{
												$penerimaan = '0';
											}
											echo $penerimaan."</br>";
										?>
									</label>
								</td>
							</tr>
							<tr>
								<td>Pengeluaran</td>
								<td>
                                    <label>
										<?php 
											// 3. pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
											if($kota == "KABUPATEN BEKASI"){
												$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
												FROM `tbgfkpengeluarandetail` a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur 
												WHERE a.`KodeBarang` = '$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'"));
											}else{
												$stokawalmaster = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
												$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
												FROM `tbgfkpengeluarandetail` a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur 
												WHERE a.`KodeBarang` = '$kodebarang' AND a.`NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
											}	
											
											if ($dtpengeluarandtl['Jumlah'] != null){
												$pengeluaran = $dtpengeluarandtl['Jumlah'];
											}else{
												$pengeluaran = '0';
											}
											echo $pengeluaran."</br>";
										?>
									</label>
								</td>
							</tr>
							<tr>
								<td>Karantina</td>
								<td>
                                    <label>
										<?php 
											$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail`
											WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
											$dt_karantina_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
											if ($dt_karantina_dtl['Jumlah'] != null){
												$karantina = $dt_karantina_dtl['Jumlah'];
											}else{
												$karantina = '0';
											}
											echo $karantina."</br>";
										?>
									</label>
								</td>
							</tr>
							<tr>
								<td>Pemusnahan</td>
								<td>
                                    <label>
										<?php 
											$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_pemusnahandetail`
											WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
											$dt_pemusnahan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
											if ($dt_pemusnahan_dtl['Jumlah'] != null){
												$pemusnahan = $dt_pemusnahan_dtl['Jumlah'];
											}else{
												$pemusnahan = '0';
											}
											echo $pemusnahan."</br>";
										?>
									</label>
								</td>
							</tr>
							<tr>
								<td>Sisa Stok</td>
								<td>
                                    <label>
										<?php 
											// 6. sisastok, jika penerimaan 0, ngambil dari stok awal
											if($penerimaan == 0){
												$sisastok = $stokawal - $pengeluaran - $karantina - $pemusnahan;
												// echo "1";
											}else{
												$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina - $pemusnahan;
												// echo "2";
											}
											echo rupiah($sisastok);
										?>
									</label>
								</td>
							</tr>
						</table>
                        <table class="table">
                            <h3 class="judul">Karantina Barang</h3>
							<tr>
								<td class="col-sm-2">Tgl.Karantina</td>
								<td class="col-sm-10">
									<input type="text" name="tanggalkarantina" class="form-control datepicker" value="<?php echo $hariini;?>" autofocus>
								</td>
							</tr>		
                            <tr>
								<td>Status Karantina</td>
								<td>
                                    <select name="statuskarantina" class="form-control">
                                        <option value="BERMASALAH" <?php if($data['SumberAnggaran'] == 'BERMASALAH'){echo "SELECTED";}?>>BERMASALAH</option>
                                        <option value="EXPIRE" <?php if($data['SumberAnggaran'] == 'EXPIRE'){echo "SELECTED";}?>>EXPIRE</option>
                                        <option value="LAINNYA" <?php if($data['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
                                    </select>
								</td>
							</tr>
                            <tr>
								<td>Jika Lainnya, jelaskan</td>
								<td>
                                    <textarea name="statuskarantinalainnya" class="form-control"></textarea>
								</td>
							</tr>  
							<tr>
								<td>Jumlah Karantina</td>
								<td>
                                    <input type="text" name="jumlahkarantina" value="" class="form-control" maxlength="10" required>
								</td>
							</tr>                 
                        </table>
						<input type="hidden" name="idbarang" class="form-control" value="<?php echo $data['IdBarang'];?>">
						<input type="hidden" name="nofakturterima" class="form-control" value="<?php echo $data['NoFakturTerima'];?>">
						<input type="hidden" name="statusgudang" class="form-control" value="<?php echo $statusgudang;?>">
						<input type="hidden" name="key" class="form-control" value="<?php echo $key;?>">
						<input type="hidden" name="jmltersedia" class="form-control" value="<?php echo $jmltersedia;?>">
						<input type="hidden" name="kodebarang" class="form-control" value="<?php echo $data['KodeBarang'];?>">
						<input type="hidden" name="namabarang" class="form-control" value="<?php echo $data['NamaBarang'];?>">
						<input type="hidden" name="nobatch" class="form-control" value="<?php echo $data['NoBatch'];?>">
						<input type="hidden" name="stok" class="form-control" value="<?php echo $data['Stok'];?>">
						<input type="hidden" name="hargabeli" class="form-control" value="<?php echo $data['HargaBeli'];?>">
						<input type="hidden" name="expire" class="form-control" value="<?php echo $data['Expire'];?>">
						<input type="hidden" name="sisastok" class="form-control" value="<?php echo $data['Stok'] - $cekstok['Jumlah'];?>">
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>