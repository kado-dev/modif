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
						<input type="hidden" name="page" value="lap_gfk_ketersediaan_barang_bogorkab"/>
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
							<a href="?page=lap_gfk_ketersediaan_barang_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_ketersediaan_barang_bogorkab_excel.php?namaprg=<?php echo $_GET['namaprg'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
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
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">No.</td>
							<th width="15%">Nama Barang</td>
							<th width="5%">Satuan</td>
							<th width="10%">Batch</td>
							<th width="8%">Expire</td>
							<th width="10%">Sumber Anggaran</td>
							<th width="18%">Supplier</td>
							<th width="7%">Saldo Awal</td>
							<th width="7%">Penerimaan</td>
							<th width="7%">Pengeluaran</td>
							<th width="7%">Saldo Akhir</td>
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
							
							// tahap1, ref_obat_lplpo
							$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` like '%$key%' ".$program;
							$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;							
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
														
							$query_obat = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query_obat)){
								if($namaprogram != $data['NamaProgram']){
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='12'>$data[NamaProgram]</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								
								$no = $no + 1;
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								
								// Batch
								$no1 = 0;
								$query_batch = mysqli_query($koneksi, "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'");
								
								while($dt_batch = mysqli_fetch_assoc($query_batch)){
									$no1 = $no1 + 1;
									$array_data[$no][] = "(".$no1.") ".$dt_batch['NoBatch'];
								}	
								
								if ($array_data[$no] != ''){
									$nomorbatch = implode("<br/>", $array_data[$no]);
								}else{
									$nomorbatch ="";
								}
								
								// Expire
								$no2 = 0;
								$query_expire = mysqli_query($koneksi, "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'");
								while($dt_expire = mysqli_fetch_assoc($query_expire)){
									$no2 = $no2 + 1;
									$array_data1[$no][] = "(".$no2.") ".$dt_expire['Expire'];
								}	
								if ($array_data1[$no] != ''){
									$exp = implode("<br/>", $array_data1[$no]);
								}else{
									$exp ="";
								}
								
								// Sumber Anggaran
								$no3 = 0;
								$query_sumber_anggaran = mysqli_query($koneksi, "SELECT `SumberAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'");
								while($dt_sumber_anggaran= mysqli_fetch_assoc($query_sumber_anggaran)){
									$no3 = $no3 + 1;
									$array_data2[$no][] = "(".$no3.") ".$dt_sumber_anggaran['SumberAnggaran'];
								}	
								if ($array_data2[$no] != ''){
									$sbag = implode("<br/>", $array_data2[$no]);
								}else{
									$sbag ="";
								}
								
								// Supplier
								$no4 = 0;
								$query_supplier = mysqli_query($koneksi, "SELECT b.nama_prod_obat FROM `tbgfkstok` a
								JOIN `ref_pabrik` b ON a.Produsen = b.id
								WHERE a.`KodeBarang`='$kodebarang'");
								while($dt_supplier= mysqli_fetch_assoc($query_supplier)){
									$no4 = $no4 + 1;
									$array_data3[$no][] = "(".$no4.") ".$dt_supplier['nama_prod_obat'];
								}	
								if ($array_data3[$no] != ''){
									$supp = implode("<br/>", $array_data3[$no]);
								}else{
									$supp ="";
								}
																															
								// tahap2, menentukan stok awal stok / saldo awal
								$strstokawal = "SELECT `Stok` FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang'";
								$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokawal));
								$stokawal = $dtstokawal['Stok'];								
																
								// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
								$strpenerimaan = "SELECT SUM(a.Jumlah) AS Jumlah, a.`Harga`, b.`KodeSupplier`, a.NomorPembukuan FROM `tbgfkpenerimaandetail` a 
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
								WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan)  BETWEEN '$bulanawal' AND '$bulanakhir'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								$penerimaan = $dtpenerimaan['Jumlah'];
								
								// tahap4, menentukan pemakaian/pengeluaran
								if($kota == "KABUPATEN BANDUNG"){
									$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND SUBSTRING(b.NoFaktur,10,4)='$tahun'";
								}else{
									$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
									JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran)='$tahun' AND MONTH(b.TanggalPengeluaran)  BETWEEN '$bulanawal' AND '$bulanakhir'";
								}
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
								$pengeluaran = $dtpengeluaran['Jumlah'];
																
								// tahap5, sisaakhir
								$sisaakhir = $stokawal + $penerimaan - $pengeluaran;
								
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:left;" class="namabarangcls">
										<?php 
											echo "<b>".$data['NamaBarang']."</b><br/>";
											echo $data['KodeBarang'];
										?>
									</td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $nomorbatch);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $exp);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $sbag);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $supp);?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran);?></td>
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
						echo "<li><a href='?page=lap_gfk_ketersediaan_barang_bogorkab&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php }?>
</div>	