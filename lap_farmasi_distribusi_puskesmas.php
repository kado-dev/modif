<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_distribusi_puskesmas"/>
						<div class="col-sm-1" style="width:150px">
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
						<div class="col-sm-1" style ="width:150px">
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
						<div class="col-sm-1" style ="width:125px">
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
									<option value='JKN'>JKN</option>
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
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_distribusi_puskesmas" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_distribusi_puskesmas_print.php?namaprogram=<?php echo $_GET['namaprg'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&tahunawal=<?php echo $_GET['tahunawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-print"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];		
		$tahun = $_GET['tahun'];
		$namaprg = $_GET['namaprg'];
		
		if(isset($bulanawal) and isset($tahun)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:2000px;">
					<thead>
						<tr>
							<th width="2%" rowspan="2">NO.</th>
							<th width="13%" rowspan="2">NAMA OBAT & BMHP</th>
							<th width="5%" rowspan="2">SATUAN</th>
							<th width="5%" rowspan="2">HARGA<br/>SATUAN</th>
							<th width="5%" rowspan="2">STOK AWAL</th>
							<th width="5%" rowspan="2">PENERIMAAN</th>
							<th width="5%" rowspan="2">PERSEDIAAN</th>
							<th colspan="21">DISTRIBUSI</th>
							<th width="5%" rowspan="2">JUMLAH<br/>PENGELUARAN</th>
							<th width="5%" rowspan="2">SISA STOK</th>
						</tr>
						<tr>
							<th>GUDANG</th>
							<th>DEPOT</th>
							<th>IGD</th>
							<th>RANAP</th>
							<th>PONED</th>
							<th>PUSTU</th>
							<th>PUSLING</th>
							<th>POLI</th>
							<th>LAINNYA</th>
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
							$namaprg = "";
						}else{
							$namaprg = "WHERE NamaProgram = '$namaprg'";
						}
						
						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px solid #000; font-weight: bold;'><td colspan='18'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}						
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							
							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli`,`Expire`,`NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'  ORDER BY IdBarang DESC"));
							$harga = $dtgfk['HargaBeli'];
							if(empty($harga)){$harga = "0";}
							
							// $tbstokopnam
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbstokopnam` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
								
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>											
								<td class="namabarangcls" align="left"><?php echo strtoupper($data['NamaBarang']);?></td>									
								<td align="center"><?php echo $data['Satuan'];?></td>
								<td align="right"><?php echo rupiah($harga);?></td>	
								<td align="right">
								<?php
									$stok_awal_apbd = $dtstokopname['StokAwalApbd'];
									$stok_awal_jkn = $dtstokopname['StokAwalJkn'];
									$stok_awal_total = $stok_awal_apbd + $stok_awal_jkn;
									echo rupiah($stok_awal_total);
								?>
								</td>					
								<td align="right">
								<?php
									$bln['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_01 + PenerimaanJkn_01)  AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_02 + PenerimaanJkn_02) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_03 + PenerimaanJkn_03) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_04 + PenerimaanJkn_04) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_05 + PenerimaanJkn_05) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_06 + PenerimaanJkn_06) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_07 + PenerimaanJkn_07) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_08 + PenerimaanJkn_08) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_09 + PenerimaanJkn_09) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_10 + PenerimaanJkn_10) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_11 + PenerimaanJkn_11) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));
									$bln['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanApbd_12 + PenerimaanJkn_12) AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang'"));											
								
									// penerimaan
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total[$no][] = $bln[$b]['Jumlah'];
									}
									echo rupiah(array_sum($total[$no]));
								?>
								</td>										
								<td align="right">
								<?php
									// persediaan
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total2[$no][] = $bln[$b]['Jumlah'] + $stok_awal_total;
									}
									echo rupiah(array_sum($total2[$no]));	
								?>
								</td>											
								<td align="right">
								<?php
									// pemakaian gudang
									$bln_gudang_apbd['1'] = $dtstokopname['PenerimaanApbd_01'] - $dtstokopname['Sisastok_Gudang_Apbd_01'];
									$bln_gudang_apbd['2'] = $dtstokopname['PenerimaanApbd_02'] - $dtstokopname['Sisastok_Gudang_Apbd_02'];
									$bln_gudang_apbd['3'] = $dtstokopname['PenerimaanApbd_03'] - $dtstokopname['Sisastok_Gudang_Apbd_03'];
									$bln_gudang_apbd['4'] = $dtstokopname['PenerimaanApbd_04'] - $dtstokopname['Sisastok_Gudang_Apbd_04'];
									$bln_gudang_apbd['5'] = $dtstokopname['PenerimaanApbd_05'] - $dtstokopname['Sisastok_Gudang_Apbd_05'];
									$bln_gudang_apbd['6'] = $dtstokopname['PenerimaanApbd_06'] - $dtstokopname['Sisastok_Gudang_Apbd_06'];
									$bln_gudang_apbd['7'] = $dtstokopname['PenerimaanApbd_07'] - $dtstokopname['Sisastok_Gudang_Apbd_07'];
									$bln_gudang_apbd['8'] = $dtstokopname['PenerimaanApbd_08'] - $dtstokopname['Sisastok_Gudang_Apbd_08'];
									$bln_gudang_apbd['9'] = $dtstokopname['PenerimaanApbd_09'] - $dtstokopname['Sisastok_Gudang_Apbd_09'];
									$bln_gudang_apbd['10'] = $dtstokopname['PenerimaanApbd_10'] - $dtstokopname['Sisastok_Gudang_Apbd_10'];
									$bln_gudang_apbd['11'] = $dtstokopname['PenerimaanApbd_11'] - $dtstokopname['Sisastok_Gudang_Apbd_11'];
									$bln_gudang_apbd['12'] = $dtstokopname['PenerimaanApbd_12'] - $dtstokopname['Sisastok_Gudang_Apbd_12'];
									
									$bln_gudang_jkn['1'] = $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'];
									$bln_gudang_jkn['2'] = $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'];
									$bln_gudang_jkn['3'] = $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'];
									$bln_gudang_jkn['4'] = $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'];
									$bln_gudang_jkn['5'] = $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'];
									$bln_gudang_jkn['6'] = $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'];
									$bln_gudang_jkn['7'] = $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'];
									$bln_gudang_jkn['8'] = $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'];
									$bln_gudang_jkn['9'] = $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'];
									$bln_gudang_jkn['10'] = $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'];
									$bln_gudang_jkn['11'] = $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'];
									$bln_gudang_jkn['12'] = $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'];
									
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total_pemakaian[$no][] = $bln_gudang_apbd[$b] + $bln_gudang_jkn[$b];
									}
									echo rupiah(array_sum($total_pemakaian[$no]));
								?>	
								</td>											
								<td align="right">
								<?php
									// pemakaian depot
									$bln_depot_apbd['1'] = $dtstokopname['PenerimaanApbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'];
									$bln_depot_apbd['2'] = $dtstokopname['PenerimaanApbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'];
									$bln_depot_apbd['3'] = $dtstokopname['PenerimaanApbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'];
									$bln_depot_apbd['4'] = $dtstokopname['PenerimaanApbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'];
									$bln_depot_apbd['5'] = $dtstokopname['PenerimaanApbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'];
									$bln_depot_apbd['6'] = $dtstokopname['PenerimaanApbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'];
									$bln_depot_apbd['7'] = $dtstokopname['PenerimaanApbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'];
									$bln_depot_apbd['8'] = $dtstokopname['PenerimaanApbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'];
									$bln_depot_apbd['9'] = $dtstokopname['PenerimaanApbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'];
									$bln_depot_apbd['10'] = $dtstokopname['PenerimaanApbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'];
									$bln_depot_apbd['11'] = $dtstokopname['PenerimaanApbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'];
									$bln_depot_apbd['12'] = $dtstokopname['PenerimaanApbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'];
									
									$bln_depot_jkn['1'] = $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'];
									$bln_depot_jkn['2'] = $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'];
									$bln_depot_jkn['3'] = $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'];
									$bln_depot_jkn['4'] = $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'];
									$bln_depot_jkn['5'] = $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'];
									$bln_depot_jkn['6'] = $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'];
									$bln_depot_jkn['7'] = $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'];
									$bln_depot_jkn['8'] = $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'];
									$bln_depot_jkn['9'] = $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'];
									$bln_depot_jkn['10'] = $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'];
									$bln_depot_jkn['11'] = $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'];
									$bln_depot_jkn['12'] = $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'];
									
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total_pemakaian_depot[$no][] = $bln_depot_apbd[$b] + $bln_depot_jkn[$b];
									}
									echo rupiah(array_sum($total_pemakaian_depot[$no]));
								?>		
								</td>											
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
						echo "<li><a href='?page=lap_farmasi_distribusi_puskesmas&namaprogram=$namaprogram&bulanawal=$bulanawal&tahunawal=$tahunawal&bulanakhir=$bulanakhir&tahunawal=$tahunawal&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php } ?>
</div>