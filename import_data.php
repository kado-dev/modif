<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
$kota = $_SESSION['kota'];
$alamat = $_SESSION['alamat'];
$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LPLPO MANUAL</b></h3>
			<div class="formbg">
				<?php if($_GET['tahun']){ ?>
				<form class="form-inline" method="post" enctype="multipart/form-data" action="import_data_proses.php">
					<table width="100%" style="margin-bottom: 10px;">	
						<tr>
							<td width="25%">
								Upload data (Excel): 
							</td>
							<td width="65%">
								<input type="hidden" name="link" value="bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>">
								<input name="fileexcel" type="file" required="required"> 
							</td>
							<td width="10%">
								<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>">
								<input name="upload" type="submit" value="Upload Data" class="btn btn-sm btn-danger">
							</td>
						</tr>
					</table>
				</form>
				<?php } ?>
			
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="import_data"/>
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2020 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-5">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=import_data&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&h=<?php echo $_GET['h'];?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	if(isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ";?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN & LEMBAR PERMINTAAN OBAT (LPLPO)</b></span><br/>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>	
	
	<div class="row">
		<form action="lap_farmasi_lplpo_manual_simpan.php" method="post">
			<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>"/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan-min" width="100%">
						<thead>
							<tr>
								<th width="3%" style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">NO.</th>
								<th width="5%" style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">TANGGAL DAFTAR</th>
								<th width="20%" style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">NIK</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$jumlah_perpage = 150;	

							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}				
							
							$str = "SELECT * FROM `ref_obat_lplpo`";
							$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` LIMIT $mulai,$jumlah_perpage";
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
										echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='13'>$data[NamaProgram]</td></tr>";
										$namaprogram = $data['NamaProgram'];
									}
								}
								$no = $no + 1;								
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$namaprogram = $data['NamaProgram'];
								
								// tbgfkstok
								$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SumberAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
								$dtgfkstokvaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SumberAnggaran` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang'"));
								if($dtgfkstok['SumberAnggaran'] != ""){
									$sumberanggaran = $dtgfkstok['SumberAnggaran'];
								}elseif($dtgfkstokvaksin['SumberAnggaran'] != ""){
									$sumberanggaran = $dtgfkstokvaksin['SumberAnggaran'];
								}else{
									$sumberanggaran = "-";		
								}	
								
									
							?>
								<tr style="solid:1px dashed #000;">
									<td style="text-align:right; solid:1px dashed #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px; display: none;" class="batchcls"><?php echo $data['NoBatch'];?></td>
									
								</tr>
							<?php
								}
							?>
						</tbody>
					</table><br/>
				</div>
			</div>
		</form>	
	</div>
	
	<hr class="noprint"><!--css-->
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
						echo "<li><a href='?page=import_data&bulan=$bulan&tahun=$tahun&sumberanggaran=$_GET[sumberanggaran]&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	
	?>
</div>	
