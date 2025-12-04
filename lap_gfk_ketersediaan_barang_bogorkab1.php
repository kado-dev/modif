<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KETERSEDIAAN </b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_ketersediaan_barang_bogorkab1"/>
						<div class="col-sm-2">
							<select name="bulanawal" class="form-control">
								<option value="01" <?php if($_GET['bulanawal'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanawal'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanawal'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanawal'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanawal'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanawal'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanawal'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanawal'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanawal'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanawal'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanawal'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanawal'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="bulanakhir" class="form-control">
								<option value="01" <?php if($_GET['bulanakhir'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanakhir'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanakhir'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanakhir'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanakhir'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanakhir'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanakhir'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanakhir'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanakhir'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanakhir'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanakhir'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanakhir'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprg" class="form-control">
									<option value='Semua'>Semua</option>
									<?php
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprg'] == $data3['nama_program']){
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
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_ketersediaan_barang_bogorkab1" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_ketersediaan_barang_bogorkab1_excel.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>&namaprg=<?php echo $_GET['namaprg'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];	
		$tahun = $_GET['tahun'];
		$namaprg = $_GET['namaprg'];
		$key = $_GET['key'];
		if(isset($_GET['namaprg'])){
	?>	
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive text_nowrap">
				<table class="table-judul-laporan"  style="width:1500px;">
					<thead>
						<tr>
							<th width="3%" rowspan="2">No.</td>
							<th width="5%" rowspan="2">Kode</td>
							<th width="18%" rowspan="2">Nama Barang</td>
							<th width="5%" rowspan="2">Satuan</td>
							<th width="10%" rowspan="2">Batch</td>
							<th width="5%" rowspan="2">Harga<br/>Satuan</td>
							<th width="7%" rowspan="2">Expire</td>
							<th width="12%" rowspan="2">Sumber Anggaran</td>
							<th width="20%" rowspan="2">Supplier</td>
							<th width="10%" colspan="2">Saldo Awal</td>
							<th width="10%" colspan="2">Penerimaan</td>
							<th width="10%" colspan="2">Pengeluaran</td>
							<th width="10%" colspan="2">Saldo Akhir</td>
						</tr>
						<tr>
							<th>Jumlah</td><!--Saldo Awal-->
							<th>Rupiah</td>
							<th>Jumlah</td><!--Penerimaan-->
							<th>Rupiah</td>
							<th>Jumlah</td><!--Pengeluaran-->
							<th>Rupiah</td>
							<th>Jumlah</td><!--Saldo Akhir-->
							<th>Rupiah</td>
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
							
							if($namaprg == "Semua" || $namaprg == ""){
								$program = "";
							}else{
								$program = "AND `NamaProgram`='$namaprg'";
							}
							
							// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
							$str = "SELECT * FROM `tbgfkstok` WHERE `NamaBarang` like '%$key%' ".$program;
							$str2 = $str." ORDER BY `IdProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;	

							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
														
							$query_obat = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query_obat)){
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
								
								// harga satuan, ambil yang terakhir
								$harga_satuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `HargaBeli` != '0' ORDER BY IdBarang DESC"));
																	
								// Supplier
								$no4 = 0;
								$query_supplier = mysqli_query($koneksi, "SELECT b.nama_prod_obat FROM `tbgfkstok` a
								JOIN `ref_pabrik` b ON a.Produsen = b.id
								WHERE a.`KodeBarang`='$kodebarang'");
								$dt_supplier= mysqli_fetch_assoc($query_supplier);
																															
								// tahap2, menentukan stok awal stok / saldo awal
								$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
								$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
								if ($dt_stokawal_dtl['Stok'] != null){
									$stokawal = $dt_stokawal_dtl['Stok'];
								}else{
									$stokawal = '0';
								}
								
								// cek jika 0, hitung jumlah penerimaan bulan sebelumnya
								if($stokawal == '0'){
									$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
									JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan) < '$bulanawal'";
									$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));
									
									if ($dt_terima_lalu['Jumlah'] != null){
										$stokawal = $dt_terima_lalu['Jumlah'];
									}else{
										$stokawal = '0';
									}
								}	
								$stokawal_rupiah = 	$stokawal * $harga_satuan['HargaBeli'];							
																
								// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
								$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir' AND a.`NomorPembukuan`='$data[NoFakturTerima]'";
								
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								$penerimaan = $dtpenerimaan['Jumlah'];
								$penerimaan_rupiah = $penerimaan * $harga_satuan['HargaBeli'];
								
								// tahap4, menentukan pemakaian/pengeluaran
								if($kota == "KABUPATEN BANDUNG"){
									$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND SUBSTRING(b.NoFaktur,10,4)='$tahun'";
								}else{
									$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
									JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran)='$tahun' AND 
									MONTH(b.TanggalPengeluaran) BETWEEN '$bulanawal' AND '$bulanakhir'";
								}
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
								if ($dtpengeluaran['Jumlah'] != null){
									$pengeluaran = $dtpengeluaran['Jumlah'];
								}else{
									$pengeluaran = '0';
								}
								
								// cek jika 0, hitung jumlah pengeluaran bulan sebelumnya
								if($pengeluaran == '0'){
									$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
									JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran)='$tahun' AND 
									MONTH(b.TanggalPengeluaran) < '$bulanawal'";
									$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));
									
									if ($dt_pengeluaran_lalu['Jumlah'] != null){
										$pengeluaran = $dt_pengeluaran_lalu['Jumlah'];
									}else{
										$pengeluaran = '0';
									}
								}									
								$pengeluaran_rupiah = $pengeluaran * $harga_satuan['HargaBeli'];
																
								// tahap5, sisaakhir
								if($stokawal == $pengeluaran){
									$stokawal = "0";
									$stokawal_rupiah = "0";
									$pengeluaran = "0";
									$pengeluaran_rupiah = "0";
								}	
								$sisaakhir = $stokawal + $penerimaan - $pengeluaran;
								$sisaakhir_rupiah = $sisaakhir * $harga_satuan['HargaBeli'];
								
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:center;"><?php echo $kodebarang;?></td>
									<td style="text-align:left;" class="namabarangcls"><?php echo $data['NamaBarang'];?></td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
									<td style="text-align:right;"><?php echo rupiah($harga_satuan['HargaBeli']);?></td>
									<td style="text-align:center;"><?php echo str_replace(",", ", ", $data['Expire']);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $data['SumberAnggaran']);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $dt_supplier['nama_prod_obat']);?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal);?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir_rupiah);?></td>
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
						echo "<li><a href='?page=lap_gfk_ketersediaan_barang_bogorkab1&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php }?>
</div>	