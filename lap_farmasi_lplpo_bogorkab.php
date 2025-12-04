<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_report.php";
?>

<style>
	thead, tr th{
		padding: 15px;
	}
	tbody tr td{
		padding: 5px!important;
	}		
</style>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">LAPORAN PEMAKAIAN & LEMBAR PERMINTAAN OBAT (LPLPO)</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_lplpo_bogorkab"/>
						<div class="col-sm-2 bulanformcari">
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<div class="input-group">
								<select name="kodepuskesmas" class="form-control">
									<option value='semua'>Semua</option>
									<?php
									$kota = $_SESSION['kota'];
									$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
											echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
										}else{
											echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Puskesmas</span>
							</div>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_farmasi_lplpo_bogorkab" class="btn btn-success btn-white">Refresh</a>
							<a href="javascript:print()" class="btn btn-primary btn-white">Print</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$bulanlalu = "0".$bulan - 1;
	$tahun = $_GET['tahun'];	
	$kodepuskesmas = $_GET['kodepuskesmas'];	
	
	if(strlen($bulanlalu) == 1){		
		$bulanlalu = '0'.$bulanlalu;
		if($bulanlalu == "00"){
			$bulanlalu = '12';
		}	
	}	
	if(isset($bulan) and isset($tahun)){
	
	?>
	
	<!--tabel view-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive text-nowrap">
				<table class="table-judul-laporan-min table-fixed">
					<thead>
						<tr>
							<th rowspan="2">No.</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2">Nama Barang</th>
							<th rowspan="2">Satuan</th>
							<th rowspan="2">Harga<br/>Satuan</th>
							<th colspan="2">Stok Awal</th>
							<th colspan="2">Penerimaan</th>
							<th colspan="2">Persediaan</th>
							<th colspan="2">Pemakaian</th>
							<th colspan="2">Stok Akhir</th>
							<th colspan="2">Permintaan</th>
							<th colspan="2">Pemberian</th>
						</tr>
						<tr>
							<th>APBD</th><!--Stok Awal-->
							<th>JKN</th>
							<th>APBD</th><!--Penerimaan-->
							<th>JKN</th>
							<th>APBD</th><!--Persediaan-->
							<th>JKN</th>
							<th>APBD</th><!--Pemakaian-->
							<th>JKN</th>
							<th>APBD</th><!--Stok Akhir-->
							<th>JKN</th>
							<th>APBD</th><!--Permintaan-->
							<th>JKN</th>
							<th>APBD</th><!--Pemberian-->
							<th>JKN</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 15;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='19'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}	
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
						
							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY IdBarang DESC"));
							
							// tbstokopnam_puskesmas_detail
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_detail` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							
							// tbgudangpkmlplpomanual
							$dtlplpomanual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmlplpomanual` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulanlalu'"));
														
							// stokawal
							if($bulan == "01"){
								$stokawal_apbd = $dtstokopname['StokAwalApbd'];
								$stokawal_jkn = $dtstokopname['StokAwalJkn'];
							}else{
								$stokawal_apbd = $dtlplpomanual['SisaAkhirApbd'];
								$stokawal_jkn = $dtlplpomanual['SisaAkhirJkn'];
							}	
							
							// penerimaan
							$penerimaan_apbd = $dtstokopname['PenerimaanApbd_'.$bulan];
							$penerimaan_jkn= $dtstokopname['PenerimaanJkn_'.$bulan];
							
							// persediaan
							$persediaan_apbd = $stokawal_apbd + $penerimaan_apbd;
							$persediaan_jkn= $stokawal_jkn + $penerimaan_jkn;
							
							// pemakaian
							$total_gudang_apbd = $dtstokopname['Pemakaian_Gudang_Apbd_'.$bulan];
							$total_gudang_jkn = $dtstokopname['Pemakaian_Gudang_Jkn_'.$bulan];
							$total_depot_apbd = $dtstokopname['Pemakaian_Depot_Apbd_'.$bulan];
							$total_depot_jkn = $dtstokopname['Pemakaian_Depot_Jkn_'.$bulan];
							$total_igd_apbd = $dtstokopname['Pemakaian_Igd_Apbd_'.$bulan];
							$total_igd_jkn = $dtstokopname['Pemakaian_Igd_Jkn_'.$bulan];
							$total_ranap_apbd = $dtstokopname['Pemakaian_Ranap_Apbd_'.$bulan];
							$total_ranap_jkn = $dtstokopname['Pemakaian_Ranap_Jkn_'.$bulan];
							$total_poned_apbd = $dtstokopname['Pemakaian_Poned_Apbd_'.$bulan];
							$total_poned_jkn = $dtstokopname['Pemakaian_Poned_Jkn_'.$bulan];
							$total_pustu_apbd = $dtstokopname['Pemakaian_Pustu_Apbd_'.$bulan];
							$total_pustu_jkn = $dtstokopname['Pemakaian_Pustu_Jkn_'.$bulan];
							$total_pusling_apbd = $dtstokopname['Pemakaian_Pusling_Apbd_'.$bulan];
							$total_pusling_jkn = $dtstokopname['Pemakaian_Pusling_Jkn_'.$bulan];
							$total_poli_apbd = $dtstokopname['Pemakaian_Poli_Apbd_'.$bulan];
							$total_poli_jkn = $dtstokopname['Pemakaian_Poli_Jkn_'.$bulan];
							$total_lainnya_apbd = $dtstokopname['Pemakaian_Lainnya_Apbd_'.$bulan];
							$total_lainnya_jkn = $dtstokopname['Pemakaian_Lainnya_Jkn_'.$bulan];
							$pemakaian_apbd = $total_gudang_apbd + $total_depot_apbd + $total_igd_apbd + $total_ranap_apbd + $total_poned_apbd + $total_pustu_apbd + $total_pusling_apbd + $total_poli_apbd + $total_lainnya_apbd;
							$pemakaian_jkn = $total_gudang_jkn + $total_depot_jkn + $total_igd_jkn + $total_ranap_jkn + $total_poned_jkn + $total_pustu_jkn + $total_pusling_jkn + $total_poli_jkn + $total_lainnya_jkn;
							
							// stok akhir
							$stokakhir_apbd = $persediaan_apbd - $pemakaian_apbd;
							$stokakhir_jkn= $persediaan_jkn - $pemakaian_jkn;
							
							// permintaan
							$permintaan_apbd_persen = $pemakaian_apbd * 30 / 100;
							$permintaan_apbd = $pemakaian_apbd + $permintaan_apbd_persen;
							$permintaan_jkn_persen = $pemakaian_jkn * 30 / 100;
							$permintaan_jkn = $pemakaian_jkn + $permintaan_jkn_persen;
							
						?>
							<tr style="border:1px sollid #000;">
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
								<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
								<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php  echo rupiah($dtgfk['HargaBeli']);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($stokawal_apbd);?></td><!--Stok Awal-->								
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($stokawal_jkn);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($penerimaan_apbd);?></td><!--Penerimaan-->
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($penerimaan_jkn);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($persediaan_apbd);?></td><!--Persediaan-->
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($persediaan_jkn);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($pemakaian_apbd);?></td><!--Pemakaian-->
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($pemakaian_jkn);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($stokakhir_apbd);?></td><!--Stok AKhir-->
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($stokakhir_jkn);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($permintaan_apbd);?></td><!--Permintaan-->
								<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo rupiah($permintaan_jkn);?></td>
								<td style="text-align:right; border:1px sollid #000; padding:3px;">-</td><!--Pemberian-->
								<td style="text-align:right; border:1px sollid #000; padding:3px;">-</td>
							</tr>
						<?php
							}
						?>		
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="bawahtabel font10">
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td style="text-align:center;">
				Diterima Oleh
				<br>
				<br>
				<br>
				(..............................)
				</td>
				
				
				<td width="10%"></td>
				<td style="text-align:center;">
				Diserahkan Oleh
				<br>
				<br>
				<br>
				(..............................)
				</td>
			</tr>
		</table>
	</div>
	<br/>

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
						echo "<li><a href='?page=lap_farmasi_lplpo_bogorkab&bulan=$bulan&tahun=$tahun&kodepuskesmas=$kodepuskesmas&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	
