<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK OPNAME</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stok_opname_triwulan"/>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
								</div>
							</div>
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
						<div class="col-sm-3">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Kode / Nama Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_stok_opname_triwulan" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_stok_opname_triwulan_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&namaprg=<?php echo $_GET['namaprg'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
	<?php
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namapuskesmas = $_SESSION['namapuskesmas'];
		$keydate1 = $_GET['keydate1'];
		$keydate2 = $_GET['keydate2'];	
		$bulanawal = date('m', strtotime($_GET['keydate1']));
		$bulanakhir = date('m', strtotime($_GET['keydate2']));	
		$tahun = date('Y', strtotime($keydate2));
		$tahunlalu = $tahun - 1;
		$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
		if(isset($keydate1)){
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:1500px;">
					<thead>
						<tr>
							<th width="3%" rowspan="3">NO.</th>
							<th width="5%" rowspan="3">KODE</th>
							<th width="17%" rowspan="3">NAMA BARANG</th>
							<th width="5%" rowspan="3">SATUAN</th>
							<th width="5%" colspan="2">HARGA<br/>SATUAN</th>
							<th colspan="2">STOK AWAL <br/></th>
							<th colspan="2">PENERIMAAN</th>
							<th colspan="2">PERSEDIAAN</th>
							<th colspan="2">PENGELUARAN</th>
							<th colspan="20">SISA STOK</th>
							<th colspan="2">TOTAL RUPIAH</th>
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
							<th rowspan="2">APBD</th><!--TotalRupiah-->
							<th rowspan="2">JKN</th>
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
						$key = $_GET['key'];
						
						if($namaprg == "Semua" OR $namaprg == ""){
							$namaprg = " ";
						}else{
							$namaprg = " `NamaProgram` = '$namaprg' AND";
						}
						
						if($key != ''){
							$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
						}else{
							$strcari = " `NamaBarang` != ''";
						}

						$str = "SELECT * FROM `ref_obat_lplpo` WHERE".$namaprg.$strcari;
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
								echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='35'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];		

							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY IdBarang DESC"));
							$harga_apbd = $dtgfk['HargaBeli'];
							if(empty($harga_apbd)){$harga_apbd = "0";}	
							
							// tahap 1, stok awal
							$strsopkm = "SELECT * FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
							$harga_jkn = $dtstokopname['HargaJkn'];
							
							if($bulanawal == "01" AND $tahun == "2021"){
								// jika tahun 2021, datanya ambil dari import data
								$stokawal_apbd = $dtstokopname['StokAwalApbd'];
								$stokawal_jkn = $dtstokopname['StokAwalJkn'];
							}else{
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
									
								if($bulanawal == "02"){
									$stokawal_apbd = $total_sisastok_apbd_01;
									$stokawal_jkn = $total_sisastok_jkn_01;
								}elseif($bulanawal == "03"){
									$stokawal_apbd = $total_sisastok_apbd_02;
									$stokawal_jkn = $total_sisastok_jkn_02;
								}elseif($bulanawal == "04"){
									$stokawal_apbd = $total_sisastok_apbd_03;
									$stokawal_jkn = $total_sisastok_jkn_03;
								}elseif($bulanawal == "05"){
									$stokawal_apbd = $total_sisastok_apbd_04;
									$stokawal_jkn = $total_sisastok_jkn_04;
								}elseif($bulanawal == "06"){
									$stokawal_apbd = $total_sisastok_apbd_05;
									$stokawal_jkn = $total_sisastok_jkn_05;
								}elseif($bulanawal == "07"){
									$stokawal_apbd = $total_sisastok_apbd_06;
									$stokawal_jkn = $total_sisastok_jkn_06;
								}elseif($bulanawal == "08"){
									$stokawal_apbd = $total_sisastok_apbd_07;
									$stokawal_jkn = $total_sisastok_jkn_07;
								}elseif($bulanawal == "09"){
									$stokawal_apbd = $total_sisastok_apbd_08;
									$stokawal_jkn = $total_sisastok_jkn_08;
								}elseif($bulanawal == "10"){
									$stokawal_apbd = $total_sisastok_apbd_09;
									$stokawal_jkn = $total_sisastok_jkn_09;
								}elseif($bulanawal == "11"){
									$stokawal_apbd = $total_sisastok_apbd_10;
									$stokawal_jkn = $total_sisastok_jkn_10;
								}elseif($bulanawal == "12"){
									$stokawal_apbd = $total_sisastok_apbd_11;
									$stokawal_jkn = $total_sisastok_jkn_11;
								}	
							}

							// tahap 2, penerimaan
							if($data['NamaProgram'] != "VAKSIN"){
							$bln_penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							// array
							$bln_penerimaan_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
						
							}else{
							$bln_penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							// array
							$bln_penerimaan_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$bln_penerimaan_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							}
							// penerimaan jkn
							$bln_penerimaan_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_01 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_02 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_03 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_04 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_05 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_06 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_07 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_08 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_09 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_10 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_11 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_12 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `Tahun`='$tahun'"));	
							
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
							$bln_pengeluaran_apbd['1'] = $dtstokopname['StokAwalApbd'] + $bln_penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$bln_pengeluaran_jkn['1'] = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
													
							// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
							$bln_pengeluaran_apbd['2'] = $total_sisastok_apbd_01 + $bln_penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$bln_pengeluaran_jkn['2'] = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							
							$bln_pengeluaran_apbd['3'] = $total_sisastok_apbd_02 + $bln_penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$bln_pengeluaran_jkn['3'] = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
														
							$bln_pengeluaran_apbd['4'] = $total_sisastok_apbd_03 + $bln_penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$bln_pengeluaran_jkn['4'] = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
														
							$bln_pengeluaran_apbd['5'] = $total_sisastok_apbd_04 + $bln_penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$bln_pengeluaran_jkn['5'] = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
													
							$bln_pengeluaran_apbd['6'] = $total_sisastok_apbd_05 + $bln_penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$bln_pengeluaran_jkn['6'] = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
														
							$bln_pengeluaran_apbd['7'] = $total_sisastok_apbd_06 + $bln_penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$bln_pengeluaran_jkn['7'] = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
														
							$bln_pengeluaran_apbd['8'] = $total_sisastok_apbd_07 + $bln_penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$bln_pengeluaran_jkn['8'] = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
														
							$bln_pengeluaran_apbd['9'] = $total_sisastok_apbd_08 + $bln_penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$bln_pengeluaran_jkn['9'] = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
														
							$bln_pengeluaran_apbd['10'] = $total_sisastok_apbd_09 + $bln_penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$bln_pengeluaran_jkn['10'] = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
													
							$bln_pengeluaran_apbd['11'] = $total_sisastok_apbd_10 + $bln_penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$bln_pengeluaran_jkn['11'] = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
														
							$bln_pengeluaran_apbd['12'] = $total_sisastok_apbd_11 + $bln_penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$bln_pengeluaran_jkn['12'] = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
														
							// tahap 5, 
							// sisa stok gudang
							$blngudang_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blngudang_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Gudang_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
						
							// sisa stok depot
							$blndepot_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blndepot_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Depot_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							
							// sisa stok igd
							$blnigd_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnigd_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Igd_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
																
							// sisa stok ranap
							$blnranap_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnranap_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Ranap_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
																						
							// sisa stok poned
							$blnponed_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnponed_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poned_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
																							
							// sisa stok pustu
							$blnpustu_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpustu_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pustu_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
																							
							// sisa stok pusling
							$blnpusling_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpusling_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Pusling_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
																						
							// sisa stok poli
							$blnpoli_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnpoli_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Poli_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
																						
							// sisa stok lainnya
							$blnlainnya_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Apbd_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_01) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_02) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_03) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_04) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_05) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_06) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_07) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_08) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_09) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_10) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_11) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
							$blnlainnya_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Sisastok_Lainnya_Jkn_12) AS Jumlah FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
										
						?>
						
							<tr style="border:1px solid #000;">
								<td align="center" class="kodecls"><?php echo $no;?></td>
								<td align="center"><?php echo $kodebarang;?></td>
								<td align="left"><?php echo strtoupper($data['NamaBarang']);?></td>
								<td align="center"><?php echo $data['Satuan'];?></td>
								<td align="right"><?php echo rupiah($harga_apbd);?></td>
								<td align="right"><?php echo rupiah($harga_jkn);?></td>
								<td align="right"><?php echo rupiah($stokawal_apbd);?></td>
								<td align="right"><?php echo rupiah($stokawal_jkn);?></td>
								<td align="right">
									<?php 
										// penerimaan apbd
										for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
											$total_penerimaan_apbd[$no][] = $bln_penerimaan_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_penerimaan_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// penerimaan jkn
										for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
											$total_penerimaan_jkn[$no][] = $bln_penerimaan_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_penerimaan_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										$persediaan_apbd = $stokawal_apbd + array_sum($total_penerimaan_apbd[$no]);
										echo rupiah($persediaan_apbd);
									?>
								</td>
								<td align="right">
									<?php 
										$persediaan_jkn = $stokawal_jkn + array_sum($total_penerimaan_jkn[$no]);
										echo rupiah($persediaan_jkn);
									?>
								</td>
								<td align="right">
									<?php
										// pengeluaran apbd
										for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
											$total_pemakaian_apbd[$no][] = $bln_pengeluaran_apbd[$b];
										}
										echo rupiah(array_sum($total_pemakaian_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php
										// pengeluaran jkn
										for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
											$total_pemakaian_jkn[$no][] = $bln_pengeluaran_jkn[$b];
										}
										echo rupiah(array_sum($total_pemakaian_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok gudang apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_gudang_apbd[$no][] = $blngudang_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_gudang_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok gudang jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_gudang_jkn[$no][] = $blngudang_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_gudang_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok depot apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_depot_apbd[$no][] = $blndepot_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_depot_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok depot jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_depot_jkn[$no][] = $blndepot_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_depot_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok igd apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_igd_apbd[$no][] = $blnigd_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_igd_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok igd jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_igd_jkn[$no][] = $blnigd_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_igd_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok ranap apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_ranap_apbd[$no][] = $blnranap_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_ranap_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok ranap jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_ranap_jkn[$no][] = $blnranap_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_ranap_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok poned apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_poned_apbd[$no][] = $blnponed_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_poned_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok poned jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_poned_jkn[$no][] = $blnponed_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_poned_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok pustu apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_pustu_apbd[$no][] = $blnpustu_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_pustu_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok pustu jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_pustu_jkn[$no][] = $blnpustu_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_pustu_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok pusling apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_pusling_apbd[$no][] = $blnpusling_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_pusling_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok pusling jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_pusling_jkn[$no][] = $blnpusling_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_pusling_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok poli apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_poli_apbd[$no][] = $blnpoli_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_poli_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok poli jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_poli_jkn[$no][] = $blnpoli_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_poli_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok lainnya apbd
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_lainnya_apbd[$no][] = $blnlainnya_apbd[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_lainnya_apbd[$no]));
									?>
								</td>
								<td align="right">
									<?php 
										// sisastok lainnya jkn
										for($b = intval($bulanakhir);$b <= intval($bulanakhir); $b++){
											$total_lainnya_jkn[$no][] = $blnlainnya_jkn[$b]['Jumlah'];
										}
										echo rupiah(array_sum($total_lainnya_jkn[$no]));
									?>
								</td>
								<td align="right">
									<?php
										// total sisa stok apbd
										$sisa_stok_total_apbd = array_sum($total_gudang_apbd[$no]) + array_sum($total_depot_apbd[$no]) + array_sum($total_igd_apbd[$no]) + array_sum($total_ranap_apbd[$no]) + array_sum($total_poned_apbd[$no]) + array_sum($total_pustu_apbd[$no]) + array_sum($total_pusling_apbd[$no]) + array_sum($total_poli_apbd[$no]) + array_sum($total_lainnya_apbd[$no]);
										echo rupiah($sisa_stok_total_apbd);
									?>
								</td>
								<td align="right">
									<?php
										// total sisa stok jkn
										$sisa_stok_total_jkn = array_sum($total_gudang_jkn[$no]) + array_sum($total_depot_jkn[$no]) + array_sum($total_igd_jkn[$no]) + array_sum($total_ranap_jkn[$no]) + array_sum($total_poned_jkn[$no]) + array_sum($total_pustu_jkn[$no]) + array_sum($total_pusling_jkn[$no]) + array_sum($total_poli_jkn[$no]) + array_sum($total_lainnya_jkn[$no]);
										echo rupiah($sisa_stok_total_jkn);
									?>
								</td>
								<td align="right">
									<?php
										$total_rupiah_apbd = $sisa_stok_total_apbd * $harga_apbd;
										echo rupiah($total_rupiah_apbd);
									?>
								</td>
								<td align="right">
									<?php
										$total_rupiah_jkn = $sisa_stok_total_jkn * $harga_jkn;
										echo rupiah($total_rupiah_jkn);
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
						echo "<li><a href='?page=lap_farmasi_stok_opname_triwulan&keydate1=$keydate1&keydate2=$keydate2&namaprg=$_GET[namaprg]&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<h5><b>Perhatikan</b></h5> 
					- Sisa Stok : Diambil dari bulan yang terakhir dipilih
				</p>
			</div>
		</div>
	</div>
	<?php
		}
	?>
</div>	
 
