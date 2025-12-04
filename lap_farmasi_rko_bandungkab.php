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
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">RKO PUSKESMAS</h3>
			<div class="formbg">
				<?php if($_GET['tahun']){ ?>
				<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_farmasi_rko_bandungkab_import.php">
					<table width="100%" style="margin-bottom: 10px;">	
						<tr>
							<td width="25%">
								Upload data (Excel): 
							</td>
							<td width="65%">
								<input type="hidden" name="link" value="tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>">
								<input name="fileexcel" type="file" required="required"> 
							</td>
							<td width="10%">
								<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>">
								<input type="hidden" name="sumberanggaran" value="<?php echo $_GET['sumberanggaran'];?>">
								<input name="upload" type="submit" value="Upload Data" class="btn btn-sm btn-danger">
							</td>
						</tr>
					</table>
				</form>
				<?php } ?>
			
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_rko_bandungkab"/>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<option value="2021" <?php if($_GET['tahun'] == '2021'){echo "SELECTED";}?>>2021</option>
								<option value="2022" <?php if($_GET['tahun'] == '2022'){echo "SELECTED";}?>>2022</option>
								<option value="2023" <?php if($_GET['tahun'] == '2023'){echo "SELECTED";}?>>2023</option>
								<option value="2024" <?php if($_GET['tahun'] == '2024'){echo "SELECTED";}?>>2024</option>
								<option value="2025" <?php if($_GET['tahun'] == '2025'){echo "SELECTED";}?>>2025</option>
							</select>	
						</div>
						<div class="col-xl-2">
							<select name="sumberanggaran" class="form-control">
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD'){echo "SELECTED";}?>>APBD</option>
								<option value="BLUD" <?php if($_GET['sumberanggaran'] == 'BLUD'){echo "SELECTED";}?>>BLUD</option>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_rko_bandungkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_rko_bandungkab_excel.php?tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-round btn-success">Download Template</a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>
	<?php
	$sumberanggaran = $_GET['sumberanggaran'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;

	if(isset($tahun)){
	?>
	
	<div class="row">
		<form action="lap_farmasi_rko_bandungkab_simpan.php" method="post">
			<input type="hidden" name="bulan" value="<?php echo $_GET['bulan'];?>"/>
			<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>"/>
			<input type="hidden" name="sumberanggaran" value="<?php echo $_GET['sumberanggaran'];?>"/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan" width="100%">
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
							
							// ini buat insert pertama kali saja
							$cekrko = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbrkobandungkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `SumberAnggaran`='$sumberanggaran'"));
							if ($cekrko == 0 || $cekrko == null && $sumberanggaran == 'APBD KAB/KOTA'){			
								$str_trko = "SELECT * FROM `ref_obat_lplpo`";
							}else{
								$str_trko = "SELECT * FROM `$tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran`='BLUD' OR `SumberAnggaran`='JKN')";
							}
							// echo $str_trko;
							// die();

							$query1 = mysqli_query($koneksi, $str_trko);
							while($data1 = mysqli_fetch_assoc($query1)){
								$str1 = "INSERT INTO `tbrkobandungkab`(`KodePuskesmas`,`Tahun`,`KodeBarang`,`SumberAnggaran`) 
								VALUES ('$kodepuskesmas','$tahun','$data1[KodeBarang]','$sumberanggaran')";
								mysqli_query($koneksi, $str1);
							}
							
							if($sumberanggaran == 'APBD KAB/KOTA'){
								// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
								$str = "SELECT * FROM `ref_obat_lplpo`";
								$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` LIMIT $mulai,$jumlah_perpage";
							}elseif($sumberanggaran == 'APBN'){
								$str = "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
								$str2 = $str." ORDER BY NamaBarang LIMIT $mulai,$jumlah_perpage";
							}elseif($sumberanggaran == 'BLUD' OR $sumberanggaran == 'JKN'){
								// ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
								$str = "SELECT * FROM `$tbgudangpkmstok`
								WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN') GROUP BY NamaBarang";
								$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
							}						
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$namaprogram = "";	
							$query = mysqli_query($koneksi, $str2);
							while($data = mysqli_fetch_assoc($query)){
								if ($sumberanggaran == 'APBD KAB/KOTA'){
									if($namaprogram != $data['NamaProgram']){
										echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='11'>$data[NamaProgram]</td></tr>";
										$namaprogram = $data['NamaProgram'];
									}
								}
								$no = $no + 1;								
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								
								// tahap 1, stok awal
								$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal`,`PemakaianRata`,`RencanaPengadaan`,`RealisasiPengadaan` FROM `tbrkobandungkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$tahun'"));
								$jumlah_kebutuhan = $dtrko['PemakaianRata'] * 18;
								$rencana_kebutuhan = $jumlah_kebutuhan - $dtrko['StokAwal'];
							?>
								<tr>
									<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodebarangs"><?php echo $kodebarang;?></td>
									<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $namabarang;?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<input type="hidden" name="kodebarang[]" value="<?php echo $data['KodeBarang'];?>"/>
										<input type="number" class="stokawal_cls" name="stokawal[<?php echo $data['KodeBarang'];?>]" style="width:80px" value="<?php echo $dtrko['StokAwal'];?>"/>
									</td>
									<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<input type="number" name="pemakaianrata[<?php echo $data['KodeBarang'];?>]" style="width:80px" class="pemakaianrata_cls" value="<?php echo $dtrko['PemakaianRata'];?>"/>
									</td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;" class="jmlkebutuhan_cls"><?php echo $jumlah_kebutuhan;?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;" class="rencanankebutuhan_cls"><?php echo $rencana_kebutuhan;?></td>
									<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<input type="number" name="rencanapengadaan[<?php echo $data['KodeBarang'];?>]" style="width:80px" value="<?php echo $dtrko['RencanaPengadaan'];?>"/>
									</td>
									<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;">
										<input type="number" name="realisasipengadaan[<?php echo $data['KodeBarang'];?>]" style="width:80px" value="<?php echo $dtrko['RealisasiPengadaan'];?>"/>
									</td>
									<td style="text-align:center; border:1px sollid #000; padding:3px;">-</td>
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
						echo "<li><a href='?page=lap_farmasi_rko_bandungkab&tahun=$tahun&sumberanggaran=$sumberanggaran&h=$i'>$i</a></li>";
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
	<script src="assets/js/jquery-2.1.4.min.js?10"></script>
	<script type="text/javascript">
		$(".pemakaianrata_cls").focusout(function(){
			var pmk_rata = $(this).val();
			var hasil_c = pmk_rata * 18;
			$(this).parent().parent().find('.jmlkebutuhan_cls').html(hasil_c);
			var stkawal = $(this).parent().parent().find(".stokawal_cls").val();
			var hasil_d = hasil_c - stkawal;
			$(this).parent().parent().find('.rencanankebutuhan_cls').html(hasil_d);
		});

		$(".stokawal_cls").focusout(function(){
			var pmk_rata = $(this).parent().parent().find(".pemakaianrata_cls").val();
			var hasil_c = pmk_rata * 18;
			var stkawal = $(this).val();
			var hasil_d = hasil_c - stkawal;
			$(this).parent().parent().find('.rencanankebutuhan_cls').html(hasil_d);
			$(this).parent().parent().find('.jmlkebutuhan_cls').html(hasil_c);
		});
	</script>
	<?php
		}
	?>
</div>	
