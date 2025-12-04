<?php
	include "config/helper_report.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PEMAKAIAN HARIAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_apotik_pemakaian_obat_harian_tarakan"/>
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="loketobat" class="form-control">
								<option value="semua" <?php if($_GET['loketobat'] == "semua"){echo "SELECTED";}?>>Semua</option>
								<option value="LOKET OBAT" <?php if($_GET['loketobat'] == "LOKET OBAT"){echo "SELECTED";}?>>LOKET OBAT</option>
								<option value="LOKET LANSIA" <?php if($_GET['loketobat'] == "LOKET LANSIA"){echo "SELECTED";}?>>LOKET LANSIA</option>
							</select> 
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_apotik_pemakaian_obat_harian_tarakan" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="lap_farmasi_apotik_pemakaian_obat_harian_tarakan_print.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&loketobat=<?php echo $_GET['loketobat'];?>" class="btn btn-sm btn-primary" target="_blank"><span class="fa fa-print noprint"></span></a>-->
							<a href="lap_farmasi_apotik_pemakaian_obat_harian_tarakan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&loketobat=<?php echo $_GET['loketobat'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$loketobat = $_GET['loketobat'];

	if($bulan != null AND $tahun != null){
	?>
	<div>
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="5%">KODE</th>
					<th width="15%">NAMA BARANG</th>
					<th width="3%">SATUAN</th>
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
					<th width="5%">JUMLAH</th>
				</tr>
			</thead>
			<tbody style="font-size: 12px;">
				<?php				
				$str = "SELECT * FROM `$ref_obat_lplpo`";
				$str2 = $str." ORDER BY `NamaBarang` ASC";
				// echo $str2;
								
				if($loketobat == 'semua'){
					$loketobats = "";
				}elseif($loketobat == 'LOKET LANSIA'){
					$loketobats = " AND Depot = 'LOKET LANSIA'";
				}elseif($loketobat == 'LOKET OBAT'){
					$loketobats = " AND Depot = 'LOKET OBAT'";
				}
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td align="left"><?php echo strtoupper($data['NamaBarang']);?></td>
						<td align="center"><?php echo strtoupper($data['Satuan']);?></td>
						<?php
							$jml2 = 0;	
							for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(jumlahobat) as jumlah FROM `$tbresepdetail`
								WHERE `KodeBarang` = '$data[KodeBarang]' AND date(TanggalResep) = '$tanggal'".$loketobats;
								// echo $strs;
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['jumlah'];
						?>	
							<td align="right"><a href="?page=lap_farmasi_apotik_pemakaian_obat_harian_tarakan_detail&tgl=<?php echo $tanggal;?>&kdbrg=<?php echo $data['KodeBarang'];?>&sts=<?php echo $loketobat;?>" style="color: black" target="_blank"><?php echo number_format($jml['jumlah']);?></a></td>
						<?php
							}
						?>
						<td align="right"><?php echo number_format($jml2);?></td>
					</tr>
				<?php
				}
				?>
					<tr>
						<td>#</td>
						<td colspan="2">Total</td>
					<?php
						$jmls = 0;
						for($d3= $mulai;$d3 <= $selesai; $d3++){	
							$tanggal = $thn."-".$bln."-".$d3;
							$strs2 = "SELECT SUM(jumlahobat) as jumlah FROM `$tbresepdetail` WHERE date(TanggalResep) = '$tanggal'".$loketobats." GROUP BY `NoResep`,`Pelayanan`";
							$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
							$jmls = $jmls + $countall['jumlah'];
					?>	
						<td align="right"><?php echo number_format($countall['jumlah']);?></td>
					<?php
						}
					?>	
						<td align="right"><?php echo number_format($jmls);?></td>
					</tr>
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
						echo "<li><a href='?page=lap_farmasi_apotik_pemakaian_obat_harian_tarakan&bulan=$bulan&tahun=$tahun&loketobat=$loketobat&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>