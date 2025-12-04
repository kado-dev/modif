<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PEMAKAIAN HARIAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_distribusi_barang_harian"/>
						<div class="col-sm-3">
							<div class="input-group">
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
								<div class="input-group-append">
									<span class="input-group-text">Program</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_distribusi_barang_harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_distribusi_barang_bogorkab_excel.php?namaprogram=<?php echo $_GET['namaprogram'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<!--<a href="lap_gfk_distribusi_barang_harian_print.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&loketobat=<?php echo $_GET['loketobat'];?>" class="btn btn-sm btn-primary" target="_blank"><span class="fa fa-print noprint"></span></a>-->
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$key = $_GET['key'];	
	$namaprogram = $_GET['namaprogram'];

	if($bulan != null AND $tahun != null){
	?>
	<div class="font10">
		<table class="table-judul-laporan-min" width="100%">
			<thead>
				<tr style="border:1px solid #000;">
					<th>NO.</th>
					<th>KODE BARANG</th>
					<th>NAMA BARANG</th>
					<th>SATUAN</th>
					<?php
						$bln = $_GET['bulan'];
						$thn = $_GET['tahun'];
					
						$mulai = 1;
						$selesai = 31;
						for($d = $mulai;$d <= $selesai; $d++){	

					?>
					<th><?php echo $d;?></th>
					<?php
						}
					?>
					<th>JUMLAH</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				$jumlah_perpage = 25;
				
				if($_GET['h']==''){
					$mulai_hal=0;
				}else{
					$mulai_hal= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
			
				if($namaprogram == "semua" || $namaprogram == ""){
					$program = "";
				}else{
					$program = " AND NamaProgram = '$namaprogram'";
				}
				
				if($key !=''){
					$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
				}else{
					$strcari = " ";
				}
				
				if ($namaprogram == "semua" AND $key == ""){
					$str = "SELECT * FROM `ref_obat_lplpo` ".$strcari.$program;
				}else{
					$str = "SELECT * FROM `ref_obat_lplpo` WHERE ".$strcari.$program;
				}
								
				$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai_hal,$jumlah_perpage";
				// echo $str2;
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
				if($namaprogram != $data['NamaProgram']){
					echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='36'>$data[NamaProgram]</td></tr>";
					$namaprogram = $data['NamaProgram'];
				}	
				$no = $no + 1;
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeBarang'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<?php
								$jml2 = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(a.Jumlah) as Jumlah 
								FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.KodeBarang = '$data[KodeBarang]' AND date(b.TanggalPengeluaran) = '$tanggal'";
								// echo $strs;
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['Jumlah'];
							?>	
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml['Jumlah']);?></td>
							<?php
								}
							?>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml2);?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<hr class="noprint">
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
						echo "<li><a href='?page=lap_gfk_distribusi_barang_harian&namaprogram=$namaprogram&bulan=$bulan&tahun=$tahun&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	