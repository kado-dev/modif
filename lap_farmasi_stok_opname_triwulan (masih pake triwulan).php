<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK OPNAME (TRIWULAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stok_opname_triwulan"/>
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
							<select name="triwulan" class="form-control" required>
								<option value="1" <?php if($_GET['triwulan'] == '1'){echo "SELECTED";}?>>TRIWULAN 1</option>
								<option value="2" <?php if($_GET['triwulan'] == '2'){echo "SELECTED";}?>>TRIWULAN 2</option>
								<option value="3" <?php if($_GET['triwulan'] == '3'){echo "SELECTED";}?>>TRIWULAN 3</option>
								<option value="4" <?php if($_GET['triwulan'] == '4'){echo "SELECTED";}?>>TRIWULAN 4</option>
							</select>
						</div>
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_stok_opname_triwulan" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_stok_opname_triwulan_excel.php?namaprg=<?php echo $_GET['namaprg'];?>&triwulan=<?php echo $_GET['triwulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
	<?php
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$triwulan = $_GET['triwulan'];
		$tahun = $_GET['tahun'];
		$tahunlalu = $tahun - 1;
		if(isset($tahun)){
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:1500px;">
					<thead>
						<tr>
							<th width="3%" rowspan="3">NO.</th>
							<th width="17%" rowspan="3">NAMA BARANG</th>
							<th width="5%" rowspan="3">SATUAN</th>
							<th width="5%" colspan="2">HARGA<br/>SATUAN</th>
							<th colspan="2">STOK AWAL <br/>
								<?php
									if($triwulan == "1"){
								?>
									(DESEMBER <?php echo $tahunlalu?>)
								<?php
									}elseif($triwulan == "2"){
								?>
									(APRIL <?php echo $tahun?>)
								<?php
									}elseif($triwulan == "3"){
								?>
									(JULI <?php echo $tahun?>)
								<?php
									}elseif($triwulan == "4"){
								?>
									(OKTOBER <?php echo $tahun?>)
								<?php
									}
								?>
							</th>
							<th colspan="2">PENERIMAAN</th>
							<th colspan="2">PERSEDIAAN</th>
							<th colspan="2">PENGELUARAN</th>
							<th colspan="20">SISA STOK PER 
								<?php
									if($triwulan == "1"){
								?>
									(29 MARET <?php echo $tahun?>)
								<?php
									}elseif($triwulan == "2"){
								?>
									(JUNI <?php echo $tahun?>)
								<?php
									}elseif($triwulan == "3"){
								?>
									(SEPTEMBER <?php echo $tahun?>)
								<?php
									}elseif($triwulan == "4"){
								?>
									(DESEMBER <?php echo $tahun?>)
								<?php
									}
								?>	
							</th>
						</tr>
						<tr>
							<th rowspan="2">APBD</th><!--HargaSatuan-->
							<th rowspan="2">JKN</th>
							<th rowspan="2">APBD</th><!--Stok Awal-->
							<th rowspan="2">JKN</th>
							<th rowspan="2">APBD</th><!--Penerimaan-->
							<th rowspan="2">JKN</th>
							<th rowspan="2">APBD</th><!--Persediaan-->
							<th rowspan="2">JKN</th>
							<th rowspan="2">APBD</th><!--Pengeluaran-->
							<th rowspan="2">JKN</th>
							<th colspan="2">GUDANG</th>
							<th colspan="2">DEPOT</th>
							<th colspan="2">IGD</th>
							<th colspan="2">RANAP</th>
							<th colspan="2">PONED</th>
							<th colspan="2">PUSTU</th>
							<th colspan="2">PUSLING</th>
							<th colspan="2">POLI</th>
							<th colspan="2">LAINNYA</th>
							<th colspan="2">TOTAL SISA STOK</th>
						</tr>		
						<tr>
							<th>APBD</th><!--gudang-->
							<th>JKN</th>
							<th>APBD</th><!--depot-->
							<th>JKN</th>
							<th>APBD</th><!--igd-->
							<th>JKN</th>
							<th>APBD</th><!--ranap-->
							<th>JKN</th>
							<th>APBD</th><!--poned-->
							<th>JKN</th>
							<th>APBD</th><!--pustu-->
							<th>JKN</th>
							<th>APBD</th><!--pusling-->
							<th>JKN</th>
							<th>APBD</th><!--poli-->
							<th>JKN</th>
							<th>APBD</th><!--lainnya-->
							<th>JKN</th>
							<th>APBD</th><!--total sisa stok-->
							<th>JKN</th>
						</tr>			
					</thead>								
					<tbody>
						<?php
						$jumlah_perpage = 25;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$namaprg = $_GET['namaprg'];
						
						if($namaprg == "Semua" OR $namaprg == ""){
							$namaprg = " ";
						}else{
							$namaprg = " AND `NamaProgram` = '$namaprg'";
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
								echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='33'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];		

							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'  ORDER BY IdBarang DESC"));
							$harga_apbd = $dtgfk['HargaBeli'];
							if(empty($harga_apbd)){$harga_apbd = "0";}	
							
							// tahap 1, stok awal
							$strsopkm = "SELECT * FROM `tbstokopnam_puskesmas_bogorkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
							$stokawal_apbd = $dtstokopname['StokAwalApbd'];
							$stokawal_jkn = $dtstokopname['StokAwalJkn'];
							$harga_jkn = $dtstokopname['HargaJkn'];

							// tahap 2, penerimaan
							if($triwulan == "1"){
								$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
								$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
							}elseif($triwulan == "2"){
								$penerimaan_apbd = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
								$penerimaan_jkn = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
							}elseif($triwulan == "3"){
								$penerimaan_apbd = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'];
								$penerimaan_jkn = $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'];
							}elseif($triwulan == "4"){
								$penerimaan_apbd = $dtstokopname['PenerimaanApbd_10'] + $dtstokopname['PenerimaanApbd_11'] + $dtstokopname['PenerimaanApbd_12'];
								$penerimaan_jkn = $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
							}
							
							// tahap 3, persediaan
							$persediaan_apbd = $stokawal_apbd + $penerimaan_apbd;
							$persediaan_jkn = $stokawal_jkn + $penerimaan_jkn;
							
							// total sisastok
							$total_sisastok_apbd_01 = $dtstokopname['Sisastok_Gudang_Apbd_01'] + $dtstokopname['Sisastok_Depot_Apbd_01'] + $dtstokopname['Sisastok_Igd_Apbd_01'] + $dtstokopname['Sisastok_Ranap_Apbd_01'] + $dtstokopname['Sisastok_Poned_Apbd_01'] + $dtstokopname['Sisastok_Pustu_Apbd_01'] + $dtstokopname['Sisastok_Pusling_Apbd_01'] + $dtstokopname['Sisastok_Poli_Apbd_01'] + $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$total_sisastok_apbd_02 = $dtstokopname['Sisastok_Gudang_Apbd_02'] + $dtstokopname['Sisastok_Depot_Apbd_02'] + $dtstokopname['Sisastok_Igd_Apbd_02'] + $dtstokopname['Sisastok_Ranap_Apbd_02'] + $dtstokopname['Sisastok_Poned_Apbd_02'] + $dtstokopname['Sisastok_Pustu_Apbd_02'] + $dtstokopname['Sisastok_Pusling_Apbd_02'] + $dtstokopname['Sisastok_Poli_Apbd_02'] + $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$total_sisastok_apbd_03 = $dtstokopname['Sisastok_Gudang_Apbd_03'] + $dtstokopname['Sisastok_Depot_Apbd_03'] + $dtstokopname['Sisastok_Igd_Apbd_03'] + $dtstokopname['Sisastok_Ranap_Apbd_03'] + $dtstokopname['Sisastok_Poned_Apbd_03'] + $dtstokopname['Sisastok_Pustu_Apbd_03'] + $dtstokopname['Sisastok_Pusling_Apbd_03'] + $dtstokopname['Sisastok_Poli_Apbd_03'] + $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$total_sisastok_apbd_04 = $dtstokopname['Sisastok_Gudang_Apbd_04'] + $dtstokopname['Sisastok_Depot_Apbd_04'] + $dtstokopname['Sisastok_Igd_Apbd_04'] + $dtstokopname['Sisastok_Ranap_Apbd_04'] + $dtstokopname['Sisastok_Poned_Apbd_04'] + $dtstokopname['Sisastok_Pustu_Apbd_04'] + $dtstokopname['Sisastok_Pusling_Apbd_04'] + $dtstokopname['Sisastok_Poli_Apbd_04'] + $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$total_sisastok_apbd_05 = $dtstokopname['Sisastok_Gudang_Apbd_05'] + $dtstokopname['Sisastok_Depot_Apbd_05'] + $dtstokopname['Sisastok_Igd_Apbd_05'] + $dtstokopname['Sisastok_Ranap_Apbd_05'] + $dtstokopname['Sisastok_Poned_Apbd_05'] + $dtstokopname['Sisastok_Pustu_Apbd_05'] + $dtstokopname['Sisastok_Pusling_Apbd_05'] + $dtstokopname['Sisastok_Poli_Apbd_05'] + $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$total_sisastok_apbd_06 = $dtstokopname['Sisastok_Gudang_Apbd_06'] + $dtstokopname['Sisastok_Depot_Apbd_06'] + $dtstokopname['Sisastok_Igd_Apbd_06'] + $dtstokopname['Sisastok_Ranap_Apbd_06'] + $dtstokopname['Sisastok_Poned_Apbd_06'] + $dtstokopname['Sisastok_Pustu_Apbd_06'] + $dtstokopname['Sisastok_Pusling_Apbd_06'] + $dtstokopname['Sisastok_Poli_Apbd_06'] + $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$total_sisastok_apbd_07 = $dtstokopname['Sisastok_Gudang_Apbd_07'] + $dtstokopname['Sisastok_Depot_Apbd_07'] + $dtstokopname['Sisastok_Igd_Apbd_07'] + $dtstokopname['Sisastok_Ranap_Apbd_07'] + $dtstokopname['Sisastok_Poned_Apbd_07'] + $dtstokopname['Sisastok_Pustu_Apbd_07'] + $dtstokopname['Sisastok_Pusling_Apbd_07'] + $dtstokopname['Sisastok_Poli_Apbd_07'] + $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$total_sisastok_apbd_08 = $dtstokopname['Sisastok_Gudang_Apbd_08'] + $dtstokopname['Sisastok_Depot_Apbd_08'] + $dtstokopname['Sisastok_Igd_Apbd_08'] + $dtstokopname['Sisastok_Ranap_Apbd_08'] + $dtstokopname['Sisastok_Poned_Apbd_08'] + $dtstokopname['Sisastok_Pustu_Apbd_08'] + $dtstokopname['Sisastok_Pusling_Apbd_08'] + $dtstokopname['Sisastok_Poli_Apbd_08'] + $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$total_sisastok_apbd_09 = $dtstokopname['Sisastok_Gudang_Apbd_09'] + $dtstokopname['Sisastok_Depot_Apbd_09'] + $dtstokopname['Sisastok_Igd_Apbd_09'] + $dtstokopname['Sisastok_Ranap_Apbd_09'] + $dtstokopname['Sisastok_Poned_Apbd_09'] + $dtstokopname['Sisastok_Pustu_Apbd_09'] + $dtstokopname['Sisastok_Pusling_Apbd_09'] + $dtstokopname['Sisastok_Poli_Apbd_09'] + $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$total_sisastok_apbd_10 = $dtstokopname['Sisastok_Gudang_Apbd_10'] + $dtstokopname['Sisastok_Depot_Apbd_10'] + $dtstokopname['Sisastok_Igd_Apbd_10'] + $dtstokopname['Sisastok_Ranap_Apbd_10'] + $dtstokopname['Sisastok_Poned_Apbd_10'] + $dtstokopname['Sisastok_Pustu_Apbd_10'] + $dtstokopname['Sisastok_Pusling_Apbd_10'] + $dtstokopname['Sisastok_Poli_Apbd_10'] + $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$total_sisastok_apbd_11 = $dtstokopname['Sisastok_Gudang_Apbd_11'] + $dtstokopname['Sisastok_Depot_Apbd_11'] + $dtstokopname['Sisastok_Igd_Apbd_11'] + $dtstokopname['Sisastok_Ranap_Apbd_11'] + $dtstokopname['Sisastok_Poned_Apbd_11'] + $dtstokopname['Sisastok_Pustu_Apbd_11'] + $dtstokopname['Sisastok_Pusling_Apbd_11'] + $dtstokopname['Sisastok_Poli_Apbd_11'] + $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$total_sisastok_apbd_12 = $dtstokopname['Sisastok_Gudang_Apbd_12'] + $dtstokopname['Sisastok_Depot_Apbd_12'] + $dtstokopname['Sisastok_Igd_Apbd_12'] + $dtstokopname['Sisastok_Ranap_Apbd_12'] + $dtstokopname['Sisastok_Poned_Apbd_12'] + $dtstokopname['Sisastok_Pustu_Apbd_12'] + $dtstokopname['Sisastok_Pusling_Apbd_12'] + $dtstokopname['Sisastok_Poli_Apbd_12'] + $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$total_sisastok_jkn_01 = $dtstokopname['Sisastok_Gudang_Jkn_01'] + $dtstokopname['Sisastok_Depot_Jkn_01'] + $dtstokopname['Sisastok_Igd_Jkn_01'] + $dtstokopname['Sisastok_Ranap_Jkn_01'] + $dtstokopname['Sisastok_Poned_Jkn_01'] + $dtstokopname['Sisastok_Pustu_Jkn_01'] + $dtstokopname['Sisastok_Pusling_Jkn_01'] + $dtstokopname['Sisastok_Poli_Jkn_01'] + $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							$total_sisastok_jkn_02 = $dtstokopname['Sisastok_Gudang_Jkn_02'] + $dtstokopname['Sisastok_Depot_Jkn_02'] + $dtstokopname['Sisastok_Igd_Jkn_02'] + $dtstokopname['Sisastok_Ranap_Jkn_02'] + $dtstokopname['Sisastok_Poned_Jkn_02'] + $dtstokopname['Sisastok_Pustu_Jkn_02'] + $dtstokopname['Sisastok_Pusling_Jkn_02'] + $dtstokopname['Sisastok_Poli_Jkn_02'] + $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$total_sisastok_jkn_03 = $dtstokopname['Sisastok_Gudang_Jkn_03'] + $dtstokopname['Sisastok_Depot_Jkn_03'] + $dtstokopname['Sisastok_Igd_Jkn_03'] + $dtstokopname['Sisastok_Ranap_Jkn_03'] + $dtstokopname['Sisastok_Poned_Jkn_03'] + $dtstokopname['Sisastok_Pustu_Jkn_03'] + $dtstokopname['Sisastok_Pusling_Jkn_03'] + $dtstokopname['Sisastok_Poli_Jkn_03'] + $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$total_sisastok_jkn_04 = $dtstokopname['Sisastok_Gudang_Jkn_04'] + $dtstokopname['Sisastok_Depot_Jkn_04'] + $dtstokopname['Sisastok_Igd_Jkn_04'] + $dtstokopname['Sisastok_Ranap_Jkn_04'] + $dtstokopname['Sisastok_Poned_Jkn_04'] + $dtstokopname['Sisastok_Pustu_Jkn_04'] + $dtstokopname['Sisastok_Pusling_Jkn_04'] + $dtstokopname['Sisastok_Poli_Jkn_04'] + $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$total_sisastok_jkn_05 = $dtstokopname['Sisastok_Gudang_Jkn_05'] + $dtstokopname['Sisastok_Depot_Jkn_05'] + $dtstokopname['Sisastok_Igd_Jkn_05'] + $dtstokopname['Sisastok_Ranap_Jkn_05'] + $dtstokopname['Sisastok_Poned_Jkn_05'] + $dtstokopname['Sisastok_Pustu_Jkn_05'] + $dtstokopname['Sisastok_Pusling_Jkn_05'] + $dtstokopname['Sisastok_Poli_Jkn_05'] + $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$total_sisastok_jkn_06 = $dtstokopname['Sisastok_Gudang_Jkn_06'] + $dtstokopname['Sisastok_Depot_Jkn_06'] + $dtstokopname['Sisastok_Igd_Jkn_06'] + $dtstokopname['Sisastok_Ranap_Jkn_06'] + $dtstokopname['Sisastok_Poned_Jkn_06'] + $dtstokopname['Sisastok_Pustu_Jkn_06'] + $dtstokopname['Sisastok_Pusling_Jkn_06'] + $dtstokopname['Sisastok_Poli_Jkn_06'] + $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							$total_sisastok_jkn_07 = $dtstokopname['Sisastok_Gudang_Jkn_07'] + $dtstokopname['Sisastok_Depot_Jkn_07'] + $dtstokopname['Sisastok_Igd_Jkn_07'] + $dtstokopname['Sisastok_Ranap_Jkn_07'] + $dtstokopname['Sisastok_Poned_Jkn_07'] + $dtstokopname['Sisastok_Pustu_Jkn_07'] + $dtstokopname['Sisastok_Pusling_Jkn_07'] + $dtstokopname['Sisastok_Poli_Jkn_07'] + $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$total_sisastok_jkn_08 = $dtstokopname['Sisastok_Gudang_Jkn_08'] + $dtstokopname['Sisastok_Depot_Jkn_08'] + $dtstokopname['Sisastok_Igd_Jkn_08'] + $dtstokopname['Sisastok_Ranap_Jkn_08'] + $dtstokopname['Sisastok_Poned_Jkn_08'] + $dtstokopname['Sisastok_Pustu_Jkn_08'] + $dtstokopname['Sisastok_Pusling_Jkn_08'] + $dtstokopname['Sisastok_Poli_Jkn_08'] + $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$total_sisastok_jkn_09 = $dtstokopname['Sisastok_Gudang_Jkn_09'] + $dtstokopname['Sisastok_Depot_Jkn_09'] + $dtstokopname['Sisastok_Igd_Jkn_09'] + $dtstokopname['Sisastok_Ranap_Jkn_09'] + $dtstokopname['Sisastok_Poned_Jkn_09'] + $dtstokopname['Sisastok_Pustu_Jkn_09'] + $dtstokopname['Sisastok_Pusling_Jkn_09'] + $dtstokopname['Sisastok_Poli_Jkn_09'] + $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$total_sisastok_jkn_10 = $dtstokopname['Sisastok_Gudang_Jkn_10'] + $dtstokopname['Sisastok_Depot_Jkn_10'] + $dtstokopname['Sisastok_Igd_Jkn_10'] + $dtstokopname['Sisastok_Ranap_Jkn_10'] + $dtstokopname['Sisastok_Poned_Jkn_10'] + $dtstokopname['Sisastok_Pustu_Jkn_10'] + $dtstokopname['Sisastok_Pusling_Jkn_10'] + $dtstokopname['Sisastok_Poli_Jkn_10'] + $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$total_sisastok_jkn_11 = $dtstokopname['Sisastok_Gudang_Jkn_11'] + $dtstokopname['Sisastok_Depot_Jkn_11'] + $dtstokopname['Sisastok_Igd_Jkn_11'] + $dtstokopname['Sisastok_Ranap_Jkn_11'] + $dtstokopname['Sisastok_Poned_Jkn_11'] + $dtstokopname['Sisastok_Pustu_Jkn_11'] + $dtstokopname['Sisastok_Pusling_Jkn_11'] + $dtstokopname['Sisastok_Poli_Jkn_11'] + $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$total_sisastok_jkn_12 = $dtstokopname['Sisastok_Gudang_Jkn_12'] + $dtstokopname['Sisastok_Depot_Jkn_12'] + $dtstokopname['Sisastok_Igd_Jkn_12'] + $dtstokopname['Sisastok_Ranap_Jkn_12'] + $dtstokopname['Sisastok_Poned_Jkn_12'] + $dtstokopname['Sisastok_Pustu_Jkn_12'] + $dtstokopname['Sisastok_Pusling_Jkn_12'] + $dtstokopname['Sisastok_Poli_Jkn_12'] + $dtstokopname['Sisastok_Lainnya_Jkn_12'];
							
							
							// tahap 4, pengeluaran
							// jika januari rumusnya stok awal (des 2020) + penerimaan (jan 2021) - sisa stok (jan 2021)
							$bln_pengeluaran_apbd_01 = $dtstokopname['StokAwalApbd'] + $dtstokopname['PenerimaanApbd_01'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$bln_pengeluaran_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							$bln_pengeluaran_apbd['1'] = $bln_pengeluaran_apbd_01;
							$bln_pengeluaran_jkn['1'] = $bln_pengeluaran_jkn_01;
							
							// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
							$bln_pengeluaran_apbd_02 = $total_sisastok_apbd_01 + $dtstokopname['PenerimaanApbd_02'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$bln_pengeluaran_jkn_02 = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$bln_pengeluaran_apbd['2'] = $bln_pengeluaran_apbd_02;
							$bln_pengeluaran_jkn['2'] = $bln_pengeluaran_jkn_02;
							
							$bln_pengeluaran_apbd_03 = $total_sisastok_apbd_02 + $dtstokopname['PenerimaanApbd_03'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$bln_pengeluaran_jkn_03 = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$bln_pengeluaran_apbd['3'] = $bln_pengeluaran_apbd_03;
							$bln_pengeluaran_jkn['3'] = $bln_pengeluaran_jkn_03;
							
							$bln_pengeluaran_apbd_04 = $total_sisastok_apbd_03 + $dtstokopname['PenerimaanApbd_04'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$bln_pengeluaran_jkn_04 = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$bln_pengeluaran_apbd['4'] = $bln_pengeluaran_apbd_04;
							$bln_pengeluaran_jkn['4'] = $bln_pengeluaran_jkn_04;
							
							$bln_pengeluaran_apbd_05 = $total_sisastok_apbd_04 + $dtstokopname['PenerimaanApbd_05'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$bln_pengeluaran_jkn_05 = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$bln_pengeluaran_apbd['5'] = $bln_pengeluaran_apbd_05;
							$bln_pengeluaran_jkn['5'] = $bln_pengeluaran_jkn_05;
							
							$bln_pengeluaran_apbd_06 = $total_sisastok_apbd_05 + $dtstokopname['PenerimaanApbd_06'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$bln_pengeluaran_jkn_06 = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							$bln_pengeluaran_apbd['6'] = $bln_pengeluaran_apbd_06;
							$bln_pengeluaran_jkn['6'] = $bln_pengeluaran_jkn_06;
							
							$bln_pengeluaran_apbd_07 = $total_sisastok_apbd_06 + $dtstokopname['PenerimaanApbd_07'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$bln_pengeluaran_jkn_07 = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$bln_pengeluaran_apbd['7'] = $bln_pengeluaran_apbd_07;
							$bln_pengeluaran_jkn['7'] = $bln_pengeluaran_jkn_07;
							
							$bln_pengeluaran_apbd_08 = $total_sisastok_apbd_07 + $dtstokopname['PenerimaanApbd_08'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$bln_pengeluaran_jkn_08 = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$bln_pengeluaran_apbd['8'] = $bln_pengeluaran_apbd_08;
							$bln_pengeluaran_jkn['8'] = $bln_pengeluaran_jkn_08;
							
							$bln_pengeluaran_apbd_09 = $total_sisastok_apbd_08 + $dtstokopname['PenerimaanApbd_09'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$bln_pengeluaran_jkn_09 = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$bln_pengeluaran_apbd['9'] = $bln_pengeluaran_apbd_09;
							$bln_pengeluaran_jkn['9'] = $bln_pengeluaran_jkn_09;
							
							$bln_pengeluaran_apbd_10 = $total_sisastok_apbd_09 + $dtstokopname['PenerimaanApbd_10'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$bln_pengeluaran_jkn_10 = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$bln_pengeluaran_apbd['10'] = $bln_pengeluaran_apbd_10;
							$bln_pengeluaran_jkn['10'] = $bln_pengeluaran_jkn_10;
							
							$bln_pengeluaran_apbd_11 = $total_sisastok_apbd_10 + $dtstokopname['PenerimaanApbd_11'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$bln_pengeluaran_jkn_11 = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$bln_pengeluaran_apbd['11'] = $bln_pengeluaran_apbd_11;
							$bln_pengeluaran_jkn['11'] = $bln_pengeluaran_jkn_11;
							
							$bln_pengeluaran_apbd_12 = $total_sisastok_apbd_11 + $dtstokopname['PenerimaanApbd_12'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$bln_pengeluaran_jkn_12 = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
							$bln_pengeluaran_apbd['12'] = $bln_pengeluaran_apbd_12;
							$bln_pengeluaran_jkn['12'] = $bln_pengeluaran_jkn_12;
							
							if($triwulan == "1"){
								$pengeluaran_apbd = $bln_pengeluaran_apbd['1'] + $bln_pengeluaran_apbd['2'] + $bln_pengeluaran_apbd['3'];
								$pengeluaran_jkn = $bln_pengeluaran_jkn['1'] + $bln_pengeluaran_jkn['2'] + $bln_pengeluaran_jkn['3'];
							}elseif($triwulan == "2"){
								$pengeluaran_apbd = $bln_pengeluaran_apbd['4'] + $bln_pengeluaran_apbd['5'] + $bln_pengeluaran_apbd['6'];
								$pengeluaran_jkn = $bln_pengeluaran_jkn['4'] + $bln_pengeluaran_jkn['5'] + $bln_pengeluaran_jkn['6'];
							}elseif($triwulan == "3"){
								$pengeluaran_apbd = $bln_pengeluaran_apbd['7'] + $bln_pengeluaran_apbd['8'] + $bln_pengeluaran_apbd['9'];
								$pengeluaran_jkn = $bln_pengeluaran_jkn['7'] + $bln_pengeluaran_jkn['8'] + $bln_pengeluaran_jkn['9'];
							}elseif($triwulan == "4"){
								$pengeluaran_apbd = $bln_pengeluaran_apbd['10'] + $bln_pengeluaran_apbd['11'] + $bln_pengeluaran_apbd['12'];
								$pengeluaran_jkn = $bln_pengeluaran_jkn['10'] + $bln_pengeluaran_jkn['11'] + $bln_pengeluaran_jkn['12'];
							}
							
							// tahap 5, 
							// sisa stok gudang
							$blngudang_apbd['1'] = $dtstokopname['Sisastok_Gudang_Apbd_01'];							
							$blngudang_apbd['2'] = $dtstokopname['Sisastok_Gudang_Apbd_02'];
							$blngudang_apbd['3'] = $dtstokopname['Sisastok_Gudang_Apbd_03'];
							$blngudang_apbd['4'] = $dtstokopname['Sisastok_Gudang_Apbd_04'];
							$blngudang_apbd['5'] = $dtstokopname['Sisastok_Gudang_Apbd_05'];
							$blngudang_apbd['6'] = $dtstokopname['Sisastok_Gudang_Apbd_06'];
							$blngudang_apbd['7'] = $dtstokopname['Sisastok_Gudang_Apbd_07'];
							$blngudang_apbd['8'] = $dtstokopname['Sisastok_Gudang_Apbd_08'];
							$blngudang_apbd['9'] = $dtstokopname['Sisastok_Gudang_Apbd_09'];
							$blngudang_apbd['10'] = $dtstokopname['Sisastok_Gudang_Apbd_10'];
							$blngudang_apbd['11'] = $dtstokopname['Sisastok_Gudang_Apbd_11'];
							$blngudang_apbd['12'] = $dtstokopname['Sisastok_Gudang_Apbd_12'];							
							$blngudang_jkn['1'] = $dtstokopname['Sisastok_Gudang_Jkn_01'];
							$blngudang_jkn['2'] = $dtstokopname['Sisastok_Gudang_Jkn_02'];							
							$blngudang_jkn['3'] = $dtstokopname['Sisastok_Gudang_Jkn_03'];
							$blngudang_jkn['4'] = $dtstokopname['Sisastok_Gudang_Jkn_04'];							
							$blngudang_jkn['5'] = $dtstokopname['Sisastok_Gudang_Jkn_05'];							
							$blngudang_jkn['6'] = $dtstokopname['Sisastok_Gudang_Jkn_06'];							
							$blngudang_jkn['7'] = $dtstokopname['Sisastok_Gudang_Jkn_07'];							
							$blngudang_jkn['8'] = $dtstokopname['Sisastok_Gudang_Jkn_08'];							
							$blngudang_jkn['9'] = $dtstokopname['Sisastok_Gudang_Jkn_09'];							
							$blngudang_jkn['10'] = $dtstokopname['Sisastok_Gudang_Jkn_10'];							
							$blngudang_jkn['11'] = $dtstokopname['Sisastok_Gudang_Jkn_11'];							
							$blngudang_jkn['12'] = $dtstokopname['Sisastok_Gudang_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_gudang_apbd = $blngudang_apbd['1'] + $blngudang_apbd['2'] + $blngudang_apbd['3'];
								$sisastok_gudang_jkn = $blngudang_jkn['1'] + $blngudang_jkn['2'] + $blngudang_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_gudang_apbd = $blngudang_apbd['4'] + $blngudang_apbd['5'] + $blngudang_apbd['6'];
								$sisastok_gudang_jkn = $blngudang_jkn['4'] + $blngudang_jkn['5'] + $blngudang_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_gudang_apbd = $blngudang_apbd['7'] + $blngudang_apbd['8'] + $blngudang_apbd['9'];
								$sisastok_gudang_jkn = $blngudang_jkn['7'] + $blngudang_jkn['8'] + $blngudang_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_gudang_apbd = $blngudang_apbd['10'] + $blngudang_apbd['11'] + $blngudang_apbd['12'];
								$sisastok_gudang_jkn = $blngudang_jkn['10'] + $blngudang_jkn['11'] + $blngudang_jkn['12'];
							}
							
							// sisa stok depot
							$blndepot_apbd['1'] = $dtstokopname['Sisastok_Depot_Apbd_01'];
							$blndepot_apbd['2'] = $dtstokopname['Sisastok_Depot_Apbd_02'];
							$blndepot_apbd['3'] = $dtstokopname['Sisastok_Depot_Apbd_03'];
							$blndepot_apbd['4'] = $dtstokopname['Sisastok_Depot_Apbd_04'];
							$blndepot_apbd['5'] = $dtstokopname['Sisastok_Depot_Apbd_05'];
							$blndepot_apbd['6'] = $dtstokopname['Sisastok_Depot_Apbd_06'];
							$blndepot_apbd['7'] = $dtstokopname['Sisastok_Depot_Apbd_07'];
							$blndepot_apbd['8'] = $dtstokopname['Sisastok_Depot_Apbd_08'];
							$blndepot_apbd['9'] = $dtstokopname['Sisastok_Depot_Apbd_09'];
							$blndepot_apbd['10'] = $dtstokopname['Sisastok_Depot_Apbd_10'];
							$blndepot_apbd['11'] = $dtstokopname['Sisastok_Depot_Apbd_11'];
							$blndepot_apbd['12'] = $dtstokopname['Sisastok_Depot_Apbd_12'];
							$blndepot_jkn['1'] = $dtstokopname['Sisastok_Depot_Jkn_01'];
							$blndepot_jkn['2'] = $dtstokopname['Sisastok_Depot_Jkn_02'];
							$blndepot_jkn['3'] = $dtstokopname['Sisastok_Depot_Jkn_03'];
							$blndepot_jkn['4'] = $dtstokopname['Sisastok_Depot_Jkn_04'];
							$blndepot_jkn['5'] = $dtstokopname['Sisastok_Depot_Jkn_05'];
							$blndepot_jkn['6'] = $dtstokopname['Sisastok_Depot_Jkn_06'];
							$blndepot_jkn['7'] = $dtstokopname['Sisastok_Depot_Jkn_07'];
							$blndepot_jkn['8'] = $dtstokopname['Sisastok_Depot_Jkn_08'];
							$blndepot_jkn['9'] = $dtstokopname['Sisastok_Depot_Jkn_09'];
							$blndepot_jkn['10'] = $dtstokopname['Sisastok_Depot_Jkn_10'];
							$blndepot_jkn['11'] = $dtstokopname['Sisastok_Depot_Jkn_11'];
							$blndepot_jkn['12'] = $dtstokopname['Sisastok_Depot_Jkn_12'];
							
							if($triwulan == "1"){
								$sisastok_depot_apbd = $blndepot_apbd['1'] + $blndepot_apbd['2'] + $blndepot_apbd['3'];
								$sisastok_depot_jkn = $blndepot_jkn['1'] + $blndepot_jkn['2'] + $blndepot_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_depot_apbd = $blndepot_apbd['4'] + $blndepot_apbd['5'] + $blndepot_apbd['6'];
								$sisastok_depot_jkn = $blndepot_jkn['4'] + $blndepot_jkn['5'] + $blndepot_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_depot_apbd = $blndepot_apbd['7'] + $blndepot_apbd['8'] + $blndepot_apbd['9'];
								$sisastok_depot_jkn = $blndepot_jkn['7'] + $blndepot_jkn['8'] + $blndepot_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_depot_apbd = $blndepot_apbd['10'] + $blndepot_apbd['11'] + $blndepot_apbd['12'];
								$sisastok_depot_jkn = $blndepot_jkn['10'] + $blndepot_jkn['11'] + $blndepot_jkn['12'];
							}

							// sisa stok igd
							$blnigd_apbd['1'] = $dtstokopname['Sisastok_Igd_Apbd_01'];
							$blnigd_apbd['2'] = $dtstokopname['Sisastok_Igd_Apbd_02'];
							$blnigd_apbd['3'] = $dtstokopname['Sisastok_Igd_Apbd_03'];
							$blnigd_apbd['4'] = $dtstokopname['Sisastok_Igd_Apbd_04'];
							$blnigd_apbd['5'] = $dtstokopname['Sisastok_Igd_Apbd_05'];
							$blnigd_apbd['6'] = $dtstokopname['Sisastok_Igd_Apbd_06'];
							$blnigd_apbd['7'] = $dtstokopname['Sisastok_Igd_Apbd_07'];
							$blnigd_apbd['8'] = $dtstokopname['Sisastok_Igd_Apbd_08'];
							$blnigd_apbd['9'] = $dtstokopname['Sisastok_Igd_Apbd_09'];
							$blnigd_apbd['10'] = $dtstokopname['Sisastok_Igd_Apbd_10'];
							$blnigd_apbd['11'] = $dtstokopname['Sisastok_Igd_Apbd_11'];
							$blnigd_apbd['12'] = $dtstokopname['Sisastok_Igd_Apbd_12'];
							$blnigd_jkn['1'] = $dtstokopname['Sisastok_Igd_Jkn_01'];
							$blnigd_jkn['2'] = $dtstokopname['Sisastok_Igd_Jkn_02'];
							$blnigd_jkn['3'] = $dtstokopname['Sisastok_Igd_Jkn_03'];
							$blnigd_jkn['4'] = $dtstokopname['Sisastok_Igd_Jkn_04'];
							$blnigd_jkn['5'] = $dtstokopname['Sisastok_Igd_Jkn_05'];
							$blnigd_jkn['6'] = $dtstokopname['Sisastok_Igd_Jkn_06'];
							$blnigd_jkn['7'] = $dtstokopname['Sisastok_Igd_Jkn_07'];
							$blnigd_jkn['8'] = $dtstokopname['Sisastok_Igd_Jkn_08'];
							$blnigd_jkn['9'] = $dtstokopname['Sisastok_Igd_Jkn_09'];
							$blnigd_jkn['10'] = $dtstokopname['Sisastok_Igd_Jkn_10'];
							$blnigd_jkn['11'] = $dtstokopname['Sisastok_Igd_Jkn_11'];
							$blnigd_jkn['12'] = $dtstokopname['Sisastok_Igd_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_igd_apbd = $blnigd_apbd['1'] + $blnigd_apbd['2'] + $blnigd_apbd['3'];
								$sisastok_igd_jkn = $blnigd_jkn['1'] + $blnigd_jkn['2'] + $blnigd_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_igd_apbd = $blnigd_apbd['4'] + $blnigd_apbd['5'] + $blnigd_apbd['6'];
								$sisastok_igd_jkn = $blnigd_jkn['4'] + $blnigd_jkn['5'] + $blnigd_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_igd_apbd = $blnigd_apbd['7'] + $blnigd_apbd['8'] + $blnigd_apbd['9'];
								$sisastok_igd_jkn = $blnigd_jkn['7'] + $blnigd_jkn['8'] + $blnigd_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_igd_apbd = $blnigd_apbd['10'] + $blnigd_apbd['11'] + $blnigd_apbd['12'];
								$sisastok_igd_jkn = $blnigd_jkn['10'] + $blnigd_jkn['11'] + $blnigd_jkn['12'];
							}
							
							// sisa stok ranap
							$blnranap_apbd['1'] = $dtstokopname['Sisastok_Ranap_Apbd_01'];
							$blnranap_apbd['2'] = $dtstokopname['Sisastok_Ranap_Apbd_02'];
							$blnranap_apbd['3'] = $dtstokopname['Sisastok_Ranap_Apbd_03'];
							$blnranap_apbd['4'] = $dtstokopname['Sisastok_Ranap_Apbd_04'];
							$blnranap_apbd['5'] = $dtstokopname['Sisastok_Ranap_Apbd_05'];
							$blnranap_apbd['6'] = $dtstokopname['Sisastok_Ranap_Apbd_06'];
							$blnranap_apbd['7'] = $dtstokopname['Sisastok_Ranap_Apbd_07'];
							$blnranap_apbd['8'] = $dtstokopname['Sisastok_Ranap_Apbd_08'];
							$blnranap_apbd['9'] = $dtstokopname['Sisastok_Ranap_Apbd_09'];
							$blnranap_apbd['10'] = $dtstokopname['Sisastok_Ranap_Apbd_10'];
							$blnranap_apbd['11'] = $dtstokopname['Sisastok_Ranap_Apbd_11'];
							$blnranap_apbd['12'] = $dtstokopname['Sisastok_Ranap_Apbd_12'];
							$blnranap_jkn['1'] = $dtstokopname['Sisastok_Ranap_Jkn_01'];
							$blnranap_jkn['2'] = $dtstokopname['Sisastok_Ranap_Jkn_02'];
							$blnranap_jkn['3'] = $dtstokopname[' Sisastok_Ranap_Jkn_03'];
							$blnranap_jkn['4'] = $dtstokopname['Sisastok_Ranap_Jkn_04'];
							$blnranap_jkn['5'] = $dtstokopname['Sisastok_Ranap_Jkn_05'];
							$blnranap_jkn['6'] = $dtstokopname['Sisastok_Ranap_Jkn_06'];
							$blnranap_jkn['7'] = $dtstokopname['Sisastok_Ranap_Jkn_07'];
							$blnranap_jkn['8'] = $dtstokopname['Sisastok_Ranap_Jkn_08'];
							$blnranap_jkn['9'] = $dtstokopname['Sisastok_Ranap_Jkn_09'];
							$blnranap_jkn['10'] = $dtstokopname['Sisastok_Ranap_Jkn_10'];
							$blnranap_jkn['11'] = $dtstokopname['Sisastok_Ranap_Jkn_11'];
							$blnranap_jkn['12'] = $dtstokopname['Sisastok_Ranap_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_ranap_apbd = $blnranap_apbd['1'] + $blnranap_apbd['2'] + $blnranap_apbd['3'];
								$sisastok_ranap_jkn = $blnranap_jkn['1'] + $blnranap_jkn['2'] + $blnranap_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_ranap_apbd = $blnranap_apbd['4'] + $blnranap_apbd['5'] + $blnranap_apbd['6'];
								$sisastok_ranap_jkn = $blnranap_jkn['4'] + $blnranap_jkn['5'] + $blnranap_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_ranap_apbd = $blnranap_apbd['7'] + $blnranap_apbd['8'] + $blnranap_apbd['9'];
								$sisastok_ranap_jkn = $blnranap_jkn['7'] + $blnranap_jkn['8'] + $blnranap_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_ranap_apbd = $blnranap_apbd['10'] + $blnranap_apbd['11'] + $blnranap_apbd['12'];
								$sisastok_ranap_jkn = $blnranap_jkn['10'] + $blnranap_jkn['11'] + $blnranap_jkn['12'];
							}
							
							// sisa stok poned
							$blnponed_apbd['1'] = $dtstokopname['Sisastok_Poned_Apbd_01'];
							$blnponed_apbd['2'] = $dtstokopname['Sisastok_Poned_Apbd_02'];
							$blnponed_apbd['3'] = $dtstokopname['Sisastok_Poned_Apbd_03'];
							$blnponed_apbd['4'] = $dtstokopname['Sisastok_Poned_Apbd_04'];
							$blnponed_apbd['5'] = $dtstokopname['Sisastok_Poned_Apbd_05'];
							$blnponed_apbd['6'] = $dtstokopname['Sisastok_Poned_Apbd_06'];
							$blnponed_apbd['7'] = $dtstokopname['Sisastok_Poned_Apbd_07'];
							$blnponed_apbd['8'] = $dtstokopname['Sisastok_Poned_Apbd_08'];
							$blnponed_apbd['9'] = $dtstokopname['Sisastok_Poned_Apbd_09'];
							$blnponed_apbd['10'] = $dtstokopname['Sisastok_Poned_Apbd_10'];
							$blnponed_apbd['11'] = $dtstokopname['Sisastok_Poned_Apbd_11'];
							$blnponed_apbd['12'] = $dtstokopname['Sisastok_Poned_Apbd_12'];
							$blnponed_jkn['1'] = $dtstokopname['Sisastok_Poned_Jkn_01'];
							$blnponed_jkn['2'] = $dtstokopname['Sisastok_Poned_Jkn_02'];
							$blnponed_jkn['3'] = $dtstokopname['Sisastok_Poned_Jkn_03'];
							$blnponed_jkn['4'] = $dtstokopname['Sisastok_Poned_Jkn_04'];
							$blnponed_jkn['5'] = $dtstokopname['Sisastok_Poned_Jkn_05'];
							$blnponed_jkn['6'] = $dtstokopname['Sisastok_Poned_Jkn_06'];
							$blnponed_jkn['7'] = $dtstokopname['Sisastok_Poned_Jkn_07'];
							$blnponed_jkn['8'] = $dtstokopname['Sisastok_Poned_Jkn_08'];
							$blnponed_jkn['9'] = $dtstokopname['Sisastok_Poned_Jkn_09'];
							$blnponed_jkn['10'] = $dtstokopname['Sisastok_Poned_Jkn_10'];
							$blnponed_jkn['11'] = $dtstokopname['Sisastok_Poned_Jkn_11'];
							$blnponed_jkn['12'] = $dtstokopname['Sisastok_Poned_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_poned_apbd = $blnponed_apbd['1'] + $blnponed_apbd['2'] + $blnponed_apbd['3'];
								$sisastok_poned_jkn = $blnponed_jkn['1'] + $blnponed_jkn['2'] + $blnponed_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_poned_apbd = $blnponed_apbd['4'] + $blnponed_apbd['5'] + $blnponed_apbd['6'];
								$sisastok_poned_jkn = $blnponed_jkn['4'] + $blnponed_jkn['5'] + $blnponed_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_poned_apbd = $blnponed_apbd['7'] + $blnponed_apbd['8'] + $blnponed_apbd['9'];
								$sisastok_poned_jkn = $blnponed_jkn['7'] + $blnponed_jkn['8'] + $blnponed_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_poned_apbd = $blnponed_apbd['10'] + $blnponed_apbd['11'] + $blnponed_apbd['12'];
								$sisastok_poned_jkn = $blnponed_jkn['10'] + $blnponed_jkn['11'] + $blnponed_jkn['12'];
							}
							
							// sisa stok pustu
							$blnpustu_apbd['1'] = $dtstokopname['Sisastok_Pustu_Apbd_01'];
							$blnpustu_apbd['2'] = $dtstokopname['Sisastok_Pustu_Apbd_02'];
							$blnpustu_apbd['3'] = $dtstokopname['Sisastok_Pustu_Apbd_03'];
							$blnpustu_apbd['4'] = $dtstokopname['Sisastok_Pustu_Apbd_04'];
							$blnpustu_apbd['5'] = $dtstokopname['Sisastok_Pustu_Apbd_05'];
							$blnpustu_apbd['6'] = $dtstokopname['Sisastok_Pustu_Apbd_06'];
							$blnpustu_apbd['7'] = $dtstokopname['Sisastok_Pustu_Apbd_07'];
							$blnpustu_apbd['8'] = $dtstokopname['Sisastok_Pustu_Apbd_08'];
							$blnpustu_apbd['9'] = $dtstokopname['Sisastok_Pustu_Apbd_09'];
							$blnpustu_apbd['10'] = $dtstokopname['Sisastok_Pustu_Apbd_10'];
							$blnpustu_apbd['11'] = $dtstokopname['Sisastok_Pustu_Apbd_11'];
							$blnpustu_apbd['12'] = $dtstokopname['Sisastok_Pustu_Apbd_12'];
							$blnpustu_jkn['1'] = $dtstokopname['Sisastok_Pustu_Jkn_01'];
							$blnpustu_jkn['2'] = $dtstokopname['Sisastok_Pustu_Jkn_02'];
							$blnpustu_jkn['3'] = $dtstokopname['Sisastok_Pustu_Jkn_03'];
							$blnpustu_jkn['4'] = $dtstokopname['Sisastok_Pustu_Jkn_04'];
							$blnpustu_jkn['5'] = $dtstokopname['Sisastok_Pustu_Jkn_05'];
							$blnpustu_jkn['6'] = $dtstokopname['Sisastok_Pustu_Jkn_06'];
							$blnpustu_jkn['7'] = $dtstokopname['Sisastok_Pustu_Jkn_07'];
							$blnpustu_jkn['8'] = $dtstokopname['Sisastok_Pustu_Jkn_08'];
							$blnpustu_jkn['9'] = $dtstokopname['Sisastok_Pustu_Jkn_09'];
							$blnpustu_jkn['10'] = $dtstokopname['Sisastok_Pustu_Jkn_10'];
							$blnpustu_jkn['11'] = $dtstokopname['Sisastok_Pustu_Jkn_11'];
							$blnpustu_jkn['12'] = $dtstokopname['Sisastok_Pustu_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_pustu_apbd = $blnpustu_apbd['1'] + $blnpustu_apbd['2'] + $blnpustu_apbd['3'];
								$sisastok_pustu_jkn = $blnpustu_jkn['1'] + $blnpustu_jkn['2'] + $blnpustu_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_pustu_apbd = $blnpustu_apbd['4'] + $blnpustu_apbd['5'] + $blnpustu_apbd['6'];
								$sisastok_pustu_jkn = $blnpustu_jkn['4'] + $blnpustu_jkn['5'] + $blnpustu_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_pustu_apbd = $blnpustu_apbd['7'] + $blnpustu_apbd['8'] + $blnpustu_apbd['9'];
								$sisastok_pustu_jkn = $blnpustu_jkn['7'] + $blnpustu_jkn['8'] + $blnpustu_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_pustu_apbd = $blnpustu_apbd['10'] + $blnpustu_apbd['11'] + $blnpustu_apbd['12'];
								$sisastok_pustu_jkn = $blnpustu_jkn['10'] + $blnpustu_jkn['11'] + $blnpustu_jkn['12'];
							}
							
							// sisa stok pusling
							$blnpusling_apbd['1'] = $dtstokopname['Sisastok_Pusling_Apbd_01'];
							$blnpusling_apbd['2'] = $dtstokopname['Sisastok_Pusling_Apbd_02'];
							$blnpusling_apbd['3'] = $dtstokopname['Sisastok_Pusling_Apbd_03'];
							$blnpusling_apbd['4'] = $dtstokopname['Sisastok_Pusling_Apbd_04'];
							$blnpusling_apbd['5'] = $dtstokopname['Sisastok_Pusling_Apbd_05'];
							$blnpusling_apbd['6'] = $dtstokopname['Sisastok_Pusling_Apbd_06'];
							$blnpusling_apbd['7'] = $dtstokopname['Sisastok_Pusling_Apbd_07'];
							$blnpusling_apbd['8'] = $dtstokopname['Sisastok_Pusling_Apbd_08'];
							$blnpusling_apbd['9'] = $dtstokopname['Sisastok_Pusling_Apbd_09'];
							$blnpusling_apbd['10'] = $dtstokopname['Sisastok_Pusling_Apbd_10'];
							$blnpusling_apbd['11'] = $dtstokopname['Sisastok_Pusling_Apbd_11'];
							$blnpusling_apbd['12'] = $dtstokopname['Sisastok_Pusling_Apbd_12'];
							$blnpusling_jkn['1'] = $dtstokopname['Sisastok_Pusling_Jkn_01'];
							$blnpusling_jkn['2'] = $dtstokopname['Sisastok_Pusling_Jkn_02'];
							$blnpusling_jkn['3'] = $dtstokopname['Sisastok_Pusling_Jkn_03'];
							$blnpusling_jkn['4'] = $dtstokopname['Sisastok_Pusling_Jkn_04'];
							$blnpusling_jkn['5'] = $dtstokopname['Sisastok_Pusling_Jkn_05'];
							$blnpusling_jkn['6'] = $dtstokopname['Sisastok_Pusling_Jkn_06'];
							$blnpusling_jkn['7'] = $dtstokopname['Sisastok_Pusling_Jkn_07'];
							$blnpusling_jkn['8'] = $dtstokopname['Sisastok_Pusling_Jkn_08'];
							$blnpusling_jkn['9'] = $dtstokopname['Sisastok_Pusling_Jkn_09'];
							$blnpusling_jkn['10'] = $dtstokopname['Sisastok_Pusling_Jkn_10'];
							$blnpusling_jkn['11'] = $dtstokopname['Sisastok_Pusling_Jkn_11'];
							$blnpusling_jkn['12'] = $dtstokopname['Sisastok_Pusling_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_pusling_apbd = $blnpusling_apbd['1'] + $blnpusling_apbd['2'] + $blnpusling_apbd['3'];
								$sisastok_pusling_jkn = $blnpusling_jkn['1'] + $blnpusling_jkn['2'] + $blnpusling_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_pusling_apbd = $blnpusling_apbd['4'] + $blnpusling_apbd['5'] + $blnpusling_apbd['6'];
								$sisastok_pusling_jkn = $blnpusling_jkn['4'] + $blnpusling_jkn['5'] + $blnpusling_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_pusling_apbd = $blnpusling_apbd['7'] + $blnpusling_apbd['8'] + $blnpusling_apbd['9'];
								$sisastok_pusling_jkn = $blnpusling_jkn['7'] + $blnpusling_jkn['8'] + $blnpusling_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_pusling_apbd = $blnpusling_apbd['10'] + $blnpusling_apbd['11'] + $blnpusling_apbd['12'];
								$sisastok_pusling_jkn = $blnpusling_jkn['10'] + $blnpusling_jkn['11'] + $blnpusling_jkn['12'];
							}
							
							// sisa stok poli
							$blnpoli_apbd['1'] = $dtstokopname['Sisastok_Poli_Apbd_01'];
							$blnpoli_apbd['2'] = $dtstokopname['Sisastok_Poli_Apbd_02'];
							$blnpoli_apbd['3'] = $dtstokopname['Sisastok_Poli_Apbd_03'];
							$blnpoli_apbd['4'] = $dtstokopname['Sisastok_Poli_Apbd_04'];
							$blnpoli_apbd['5'] = $dtstokopname['Sisastok_Poli_Apbd_05'];
							$blnpoli_apbd['6'] = $dtstokopname['Sisastok_Poli_Apbd_06'];
							$blnpoli_apbd['7'] = $dtstokopname['Sisastok_Poli_Apbd_07'];
							$blnpoli_apbd['8'] = $dtstokopname['Sisastok_Poli_Apbd_08'];
							$blnpoli_apbd['9'] = $dtstokopname['Sisastok_Poli_Apbd_09'];
							$blnpoli_apbd['10'] = $dtstokopname['Sisastok_Poli_Apbd_10'];
							$blnpoli_apbd['11'] = $dtstokopname['Sisastok_Poli_Apbd_11'];
							$blnpoli_apbd['12'] = $dtstokopname['Sisastok_Poli_Apbd_12'];
							$blnpoli_jkn['1'] = $dtstokopname['Sisastok_Poli_Jkn_01'];
							$blnpoli_jkn['2'] = $dtstokopname['Sisastok_Poli_Jkn_02'];
							$blnpoli_jkn['3'] = $dtstokopname['Sisastok_Poli_Jkn_03'];
							$blnpoli_jkn['4'] = $dtstokopname['Sisastok_Poli_Jkn_04'];
							$blnpoli_jkn['5'] = $dtstokopname['Sisastok_Poli_Jkn_05'];
							$blnpoli_jkn['6'] = $dtstokopname['Sisastok_Poli_Jkn_06'];
							$blnpoli_jkn['7'] = $dtstokopname['Sisastok_Poli_Jkn_07'];
							$blnpoli_jkn['8'] = $dtstokopname['Sisastok_Poli_Jkn_08'];
							$blnpoli_jkn['9'] = $dtstokopname['Sisastok_Poli_Jkn_09'];
							$blnpoli_jkn['10'] = $dtstokopname['Sisastok_Poli_Jkn_10'];
							$blnpoli_jkn['11'] = $dtstokopname['Sisastok_Poli_Jkn_11'];
							$blnpoli_jkn['12'] = $dtstokopname['Sisastok_Poli_Jkn_12'];
									
							if($triwulan == "1"){
								$sisastok_poli_apbd = $blnpoli_apbd['1'] + $blnpoli_apbd['2'] + $blnpoli_apbd['3'];
								$sisastok_poli_jkn = $blnpoli_jkn['1'] + $blnpoli_jkn['2'] + $blnpoli_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_poli_apbd = $blnpoli_apbd['4'] + $blnpoli_apbd['5'] + $blnpoli_apbd['6'];
								$sisastok_poli_jkn = $blnpoli_jkn['4'] + $blnpoli_jkn['5'] + $blnpoli_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_poli_apbd = $blnpoli_apbd['7'] + $blnpoli_apbd['8'] + $blnpoli_apbd['9'];
								$sisastok_poli_jkn = $blnpoli_jkn['7'] + $blnpoli_jkn['8'] + $blnpoli_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_poli_apbd = $blnpoli_apbd['10'] + $blnpoli_apbd['11'] + $blnpoli_apbd['12'];
								$sisastok_poli_jkn = $blnpoli_jkn['10'] + $blnpoli_jkn['11'] + $blnpoli_jkn['12'];
							}
							
							// sisa stok lainnya
							$blnlainnya_apbd['1'] = $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$blnlainnya_apbd['2'] = $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$blnlainnya_apbd['3'] = $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$blnlainnya_apbd['4'] = $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$blnlainnya_apbd['5'] = $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$blnlainnya_apbd['6'] = $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$blnlainnya_apbd['7'] = $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$blnlainnya_apbd['8'] = $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$blnlainnya_apbd['9'] = $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$blnlainnya_apbd['10'] = $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$blnlainnya_apbd['11'] = $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$blnlainnya_apbd['12'] = $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$blnlainnya_jkn['1'] = $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							$blnlainnya_jkn['2'] = $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$blnlainnya_jkn['3'] = $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$blnlainnya_jkn['4'] = $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$blnlainnya_jkn['5'] = $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$blnlainnya_jkn['6'] = $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							$blnlainnya_jkn['7'] = $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$blnlainnya_jkn['8'] = $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$blnlainnya_jkn['9'] = $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$blnlainnya_jkn['10'] = $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$blnlainnya_jkn['11'] = $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$blnlainnya_jkn['12'] = $dtstokopname['Sisastok_Lainnya_Jkn_12'];
																	
							if($triwulan == "1"){
								$sisastok_lainnya_apbd = $blnlainnya_apbd['1'] + $blnlainnya_apbd['2'] + $blnlainnya_apbd['3'];
								$sisastok_lainnya_jkn = $blnlainnya_jkn['1'] + $blnlainnya_jkn['2'] + $blnlainnya_jkn['3'];
							}elseif($triwulan == "2"){
								$sisastok_lainnya_apbd = $blnlainnya_apbd['4'] + $blnlainnya_apbd['5'] + $blnlainnya_apbd['6'];
								$sisastok_lainnya_jkn = $blnlainnya_jkn['4'] + $blnlainnya_jkn['5'] + $blnlainnya_jkn['6'];
							}elseif($triwulan == "3"){
								$sisastok_lainnya_apbd = $blnlainnya_apbd['7'] + $blnlainnya_apbd['8'] + $blnlainnya_apbd['9'];
								$sisastok_lainnya_jkn = $blnlainnya_jkn['7'] + $blnlainnya_jkn['8'] + $blnlainnya_jkn['9'];
							}elseif($triwulan == "4"){
								$sisastok_lainnya_apbd = $blnlainnya_apbd['10'] + $blnlainnya_apbd['11'] + $blnlainnya_apbd['12'];
								$sisastok_lainnya_jkn = $blnlainnya_jkn['10'] + $blnlainnya_jkn['11'] + $blnlainnya_jkn['12'];
							}
							
							// tahap 6, total sisa stok
							$sisa_stok_total_apbd = $sisastok_gudang_apbd + $sisastok_depot_apbd + $sisastok_igd_apbd + $sisastok_ranap_apbd + $sisastok_poned_apbd + $sisastok_pustu_apbd + $sisastok_pusling_apbd + $sisastok_poli_apbd + $sisastok_lainnya_apbd;
							$sisa_stok_total_jkn = $sisastok_gudang_jkn + $sisastok_depot_jkn + $sisastok_igd_jkn + $sisastok_ranap_jkn + $sisastok_poned_jkn + $sisastok_pustu_jkn + $sisastok_pusling_jkn + $sisastok_poli_jkn + $sisastok_lainnya_jkn;
						?>
						
							<tr style="border:1px solid #000;">
								<td align="center" class="kodecls"><?php echo $no;?></td>
								<td align="left"><?php echo strtoupper($data['NamaBarang']);?></td>
								<td align="center"><?php echo $data['Satuan'];?></td>
								<td align="right"><?php echo rupiah($harga_apbd);?></td>
								<td align="right"><?php echo rupiah($harga_jkn);?></td>
								<td align="right"><?php echo rupiah($stokawal_apbd);?></td>
								<td align="right"><?php echo rupiah($stokawal_jkn);?></td>
								<td align="right"><?php echo rupiah($penerimaan_apbd);?></td>
								<td align="right"><?php echo rupiah($penerimaan_jkn);?></td>
								<td align="right"><?php echo rupiah($persediaan_apbd);?></td>
								<td align="right"><?php echo rupiah($persediaan_jkn);?></td>
								<td align="right"><?php echo rupiah($pengeluaran_apbd);?></td>
								<td align="right"><?php echo rupiah($pengeluaran_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_gudang_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_gudang_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_depot_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_depot_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_igd_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_igd_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_ranap_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_ranap_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_poned_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_poned_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_pustu_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_pustu_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_pusling_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_pusling_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_poli_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_poli_jkn);?></td>
								<td align="right"><?php echo rupiah($sisastok_lainnya_apbd);?></td>
								<td align="right"><?php echo rupiah($sisastok_lainnya_jkn);?></td>
								<td align="right"><?php echo rupiah($sisa_stok_total_apbd);?></td>
								<td align="right"><?php echo rupiah($sisa_stok_total_jkn);?></td>
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
						echo "<li><a href='?page=lap_farmasi_stok_opname_triwulan&triwulan=$triwulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<!--<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<h5><b>Perhatikan</b></h5> 
					- Silahkan klik tombol Buat Faktur
				</p>
			</div>
		</div>
	</div>-->
	<?php
		}
	?>
</div>	
 
