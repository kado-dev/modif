<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
$kodeobat = $_POST['kode']; 
$jml = $_POST['isi']; 
$tahun = $_POST['tahun'];
?>
<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css">

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">RKO PUSKESMAS</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_rko_dinkes"/>
						<div class="col-sm-3">
							<select name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$kota = $_SESSION['kota'];
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
									echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
								}else{
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
							}
							?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<option value="2021" <?php if($_GET['tahun'] == '2021'){echo "SELECTED";}?>>2021</option>
								<option value="2022" <?php if($_GET['tahun'] == '2022'){echo "SELECTED";}?>>2022</option>
								<option value="2023" <?php if($_GET['tahun'] == '2023'){echo "SELECTED";}?>>2023</option>
								<option value="2024" <?php if($_GET['tahun'] == '2024'){echo "SELECTED";}?>>2024</option>
								<option value="2025" <?php if($_GET['tahun'] == '2025'){echo "SELECTED";}?>>2025</option>
							</select>	
						</div>
						<div class="col-sm-2">
							<select name="sumberanggaran" class="form-control">
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD'){echo "SELECTED";}?>>APBD</option>
								<option value="BLUD" <?php if($_GET['sumberanggaran'] == 'BLUD'){echo "SELECTED";}?>>BLUD</option>
							</select>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_rko_dinkes" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_rko_dinkes_excel.php?kodepuskesmas=<?php echo $_GET['kodepuskesmas'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-round btn-info">Excel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;

	if(isset($tahun)){
	?>
	
	<div class="row">
		<form action="lap_farmasi_rko_dinkes_simpan.php" method="post">
			<input type="hidden" name="bulan" value="<?php echo $_GET['bulan'];?>"/>
			<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>"/>
			<input type="hidden" name="sumberanggaran" value="<?php echo $_GET['sumberanggaran'];?>"/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan-min" width="100%">
						<thead>
							<tr style="border:1px sollid #000;">
								<th width="3%" rowspan="2">No</th>
								<th width="7%" rowspan="2">Kode</th>
								<th width="20%" rowspan="2">Nama Barang</th>
								<th width="5%" rowspan="2">Satuan</th>
								<th width="10%">Sisa Stok per 31 Desember <?php echo $tahun1?></th>
								<th width="10%">Pemakaian Rata2 Per Bulan Tahun <?php echo $tahun1?></th>
								<th width="10%">Jumlah Kebutuhan Tahun <?php echo $tahun?></th>
								<th width="10%">Rencana Kebutuhan Tahun <?php echo $tahun?></th>
								<th width="10%" rowspan="2">Rencana Pengadaan Tahun <?php echo $tahun?></th>
								<th width="10%" rowspan="2">Realisasi Pengadaan Tahun <?php echo $tahun1?></th>
								<th width="5%" rowspan="2">Keterangan</th>
							</tr>
							<tr style="border:1px sollid #000;">
								<th>(a)</th>
								<th style="text-align:center;width:0.4%;vertical-align:middle; border:1px sollid #000; padding:3px;">(b)</th>
								<th>(c) = (b) x 18</th>
								<th>(d) = (c) - (a)</th>
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
													
							if($sumberanggaran == 'APBD KAB/KOTA'){
								// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
								$str = "SELECT * FROM `ref_obat_lplpo`";
								$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` LIMIT $mulai,$jumlah_perpage";
							}elseif($sumberanggaran == 'APBN'){
								// $str = "SELECT * FROM `tbgudangpkmstok`
								// WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
								$str = "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
								$str2 = $str." ORDER BY NamaBarang LIMIT $mulai,$jumlah_perpage";
							}elseif($sumberanggaran == 'BLUD' OR $sumberanggaran == 'JKN'){
								// ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
								$str = "SELECT * FROM `tbgudangpkmstok`
								WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN') GROUP BY NamaBarang";
								$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
							}						
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
									
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								if ($sumberanggaran != 'APBN'){
									if($namaprogram != $data['NamaProgram']){
										echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='11'>$data[NamaProgram]</td></tr>";
										$namaprogram = $data['NamaProgram'];
									}
								}
								$no = $no + 1;								
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$kdpuskesmas = $_GET['kodepuskesmas'];
								
								// tahap 1, stok awal
								if($kdpuskesmas == "semua"){
									$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`StokAwal`) AS StokAwal, SUM(`PemakaianRata`) AS PemakaianRata, SUM(`RencanaPengadaan`) AS RencanaPengadaan, SUM(`RealisasiPengadaan`) AS RealisasiPengadaan  FROM `tbrkobandungkab` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun'"));
									$stokawal = $dtrko['StokAwal'];
									$pemakaianrata = $dtrko['PemakaianRata'];
									$rencanapengadaan = $dtrko['RencanaPengadaan'];
									$realisasipengadaan = $dtrko['RealisasiPengadaan'];
								}else{
									$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal`,`PemakaianRata`,`RencanaPengadaan`,`RealisasiPengadaan` FROM `tbrkobandungkab` WHERE `KodePuskesmas`='$kdpuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$tahun'"));
									$stokawal = $dtrko['StokAwal'];
									$pemakaianrata = $dtrko['PemakaianRata'];
									$rencanapengadaan = $dtrko['RencanaPengadaan'];
									$realisasipengadaan = $dtrko['RealisasiPengadaan'];
								}	
								$jumlah_kebutuhan = $dtrko['PemakaianRata'] * 18;
								$rencana_kebutuhan = $jumlah_kebutuhan - $dtrko['StokAwal'];
							?>
								<tr>
									<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodebarangs"><?php echo $kodebarang;?></td>
									<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $namabarang;?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<input type="hidden" name="kodebarang[]" value="<?php echo $data['KodeBarang'];?>"/>
										<?php echo rupiah($stokawal);?>
									</td>
									<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<?php echo rupiah($pemakaianrata);?>
									</td>
									<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($jumlah_kebutuhan);?></td>
									<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($rencana_kebutuhan);?></td>
									<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<?php echo rupiah($rencanapengadaan);?>
									</td>
									<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<?php echo rupiah($realisasipengadaan);?>
									</td>
									<td style="text-align:right; border:1px sollid #000; padding:3px;">-</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table><br/>
					<input type="submit" class="btnsimpan" style="padding: 10px" value="Simpan">
				</div>	
			</div>
		</form>	
	</div>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
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
						echo "<li><a href='?page=lap_farmasi_rko_dinkes&kodepuskesmas=$kodepuskesmas&tahun=$tahun&sumberanggaran=$sumberanggaran&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b> Setelah input data RKO jangan lupa export data Excel</p>
			</div>
		</div>
	</div>
	<?php
		}
	?>
</div>	
