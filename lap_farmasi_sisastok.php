<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>SISA STOK</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_sisastok"/>
						<div class="col-sm-3">	
							<div class="input-group">
								<select name="triwulan" class="form-control" required>
									<option value="">--Pilih--</option>
									<option value="TRIWULAN 1" <?php if($_GET['triwulan'] == 'TRIWULAN 1'){echo "SELECTED";}?>>TRIWULAN 1</option>
									<option value="TRIWULAN 2" <?php if($_GET['triwulan'] == 'TRIWULAN 2'){echo "SELECTED";}?>>TRIWULAN 2</option>
									<option value="TRIWULAN 3" <?php if($_GET['triwulan'] == 'TRIWULAN 3'){echo "SELECTED";}?>>TRIWULAN 3</option>
									<option value="TRIWULAN 4" <?php if($_GET['triwulan'] == 'TRIWULAN 4'){echo "SELECTED";}?>>TRIWULAN 4</option>
								</select>
								<span class="input-group-addon">Pilih</span>
							</div>
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
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_farmasi_sisastok" class="btn btn-success btn-white">Refresh</a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$triwulan = $_GET['triwulan'];
		$kodepuskesmas = $_GET['kodepuskesmas'];
		$tahun = date('Y');
			
		$str = "SELECT * FROM `ref_obat_lplpo`";
		$str2 = $str." ORDER BY KodeBarang LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr>
							<th width="2%" rowspan="2">No.</th>
							<th width="5%" rowspan="2">Kode</th>
							<th width="20%" rowspan="2">Nama Obat & BMHP</th>
							<th width="5%" rowspan="2">Satuan</th>
							<th width="5%" rowspan="2">Harga Satuan</th>
							<th width="20%" colspan="4"><?php echo $triwulan;?></th>
							<th width="40%" colspan="7">JUMLAH STOK</th>
							<th width="5%" rowspan="2">Total <br/>Sisa Stok</th>
							<th width="15%" rowspan="2">Total Rupiah</th>
							
						</tr>
						<tr>
							<th width="5%">Stok Awal </th>
							<th width="5%">Penerimaan</th>
							<th width="5%">Total Persediaan</th>
							<th width="5%">Pengeluaran</th>
							<th width="5%">Stok Gudang</th>
							<th width="5%">Stok Depot</th>
							<th width="5%">Stok Poli</th>
							<th width="5%">Stok Pustu</th>
							<th width="5%">Stok Poned</th>
							<th width="5%">Stok Ranap</th>
							<th width="5%">Stok IGD</th>
						</tr>	
					</thead>
					<tbody style="font-size: 10px;">
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						
						//tbgfkstok
						$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM tbgfkstok WHERE `KodeBarang`='$kodebarang'"));		
						
						if($kodepuskesmas == "semua"){
							$semuapkm_stokawal = "";
						}else{
							$semuapkm_stokawal = " AND `KodePuskesmas`='$kodepuskesmas'";
						}
						
						if($triwulan == "TRIWULAN 1"){
							//stok awal
							$jan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='01' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$feb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='02' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$mar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='03' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokawal = $jan['Stok'] + $feb['Stok'] + $mar['Stok'];
							
							//penerimaan
							$jan_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='01' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$feb_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='02' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$mar_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='03' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$penerimaan = $jan_terima['Jumlah'] + $feb_terima['Jumlah'] + $mar_terima['Jumlah'];
							
							//persediaan
							$persediaan = $stokawal + $penerimaan;
							
							//pengeluaran			
							$jan_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='01' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$feb_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='02' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$mar_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='03' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$pengeluaran = $jan_keluar['Jumlah'] + $feb_keluar['Jumlah'] + $mar_keluar['Jumlah'];

							// stokgudang
							$jan_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='01' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$feb_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='02' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$mar_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='03' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokgudang = $jan_stokgudang['Stok'] + $feb_stokgudang['Stok'] + $mar_stokgudang['Stok'];
							
						}elseif($triwulan == "TRIWULAN 2"){
							//stok awal
							$apr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='04' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$mei = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='05' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$jun = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='06' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokawal = $apr['Stok'] + $mei['Stok'] + $jun['Stok'];
							
							//penerimaan
							$apr_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='04' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$mei_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='05' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$jun_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='06' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$penerimaan = $apr_terima['Jumlah'] + $mei_terima['Jumlah'] + $jun_terima['Jumlah'];
							
							//persediaan
							$persediaan = $stokawal + $penerimaan;
							
							//pengeluaran			
							$apr_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='04' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$mei_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='05' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$jun_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='06' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$pengeluaran = $apr_keluar['Jumlah'] + $mei_keluar['Jumlah'] + $jun_keluar['Jumlah'];
							
							// stokgudang
							$apr_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='04' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$mei_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='05' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$jun_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='06' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokgudang = $apr_stokgudang['Stok'] + $mei_stokgudang['Stok'] + $jun_stokgudang['Stok'];
							
						}elseif($triwulan == "TRIWULAN 3"){
							//stok awal
							$jul = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='07' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$ags = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='08' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$sep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='09' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokawal = $jul['Stok'] + $ags['Stok'] + $sep['Stok'];
							
							//penerimaan
							$jul_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='07' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$ags_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='08' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$sep_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='09' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$penerimaan = $jul_terima['Jumlah'] + $ags_terima['Jumlah'] + $sep_terima['Jumlah'];
							
							//persediaan
							$persediaan = $stokawal + $penerimaan;
							
							//pengeluaran
							$jul_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='07' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$ags_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='08' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$sep_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='09' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$pengeluaran = $jul_keluar['Jumlah'] + $ags_keluar['Jumlah'] + $sep_keluar['Jumlah'];
							
							// stokgudang
							$jul_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='07' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$ags_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='08' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$sep_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='09' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokgudang = $jul_stokgudang['Stok'] + $ags_stokgudang['Stok'] + $sep_stokgudang['Stok'];
							
						}elseif($triwulan == "TRIWULAN 4"){
							//stok awal
							$okt = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='10' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$nov = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='11' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$des = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='12' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokawal = $okt['Stok'] + $nov['Stok'] + $des['Stok'];
							
							//penerimaan
							$okt_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='10' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$nov_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='11' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$des_terima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Jumlah) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur  WHERE MONTH(a.`TanggalPengeluaran`)='12' AND YEAR(a.`TanggalPengeluaran`)='$tahun' AND b.`KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$penerimaan = $okt_terima['Jumlah'] + $nov_terima['Jumlah'] + $des_terima['Jumlah'];
							
							//persediaan
							$persediaan = $stokawal + $penerimaan;
							
							//pengeluaran			
							$okt_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='10' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$nov_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='11' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$des_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.jumlahobat) AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep WHERE MONTH(a.`TanggalResep`)='12' AND YEAR(a.`TanggalResep`)='$tahun' AND b.`KodeBarang`='$kodebarang'"));
							$pengeluaran = $okt_keluar['Jumlah'] + $nov_keluar['Jumlah'] + $des_keluar['Jumlah'];
							
							// stokgudang
							$okt_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='10' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$nov_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='11' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$des_stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Stok FROM `tbstokopnam_puskesmas_gudang` WHERE `Bulan`='12' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
							$stokgudang = $okt_stokgudang['Stok'] + $nov_stokgudang['Stok'] + $des_stokgudang['Stok'];
						}	
						
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>							
							<td align="center"><?php echo $data['KodeBarang'];?></td>									
							<td align="left"><?php echo $data['NamaBarang'];?></td>									
							<td align="center"><?php echo $data['Satuan'];?></td>	
							<td align="right"><?php echo rupiah($dtgfk['HargaBeli']);?></td>						
							<td align="right"><?php echo rupiah($stokawal);?></td>						
							<td align="right"><?php echo rupiah($penerimaan);?></td>			
							<td align="right"><?php echo rupiah($persediaan);?></td>						
							<td align="right"><?php echo rupiah($pengeluaran);?></td>
							<td align="right"><?php echo rupiah($stokgudang);?></td>							
							<td align="right"></td>							
							<td align="right"></td>							
							<td align="right"></td>							
							<td align="right"></td>							
							<td align="right"></td>							
							<td align="right"></td>							
							<td align="right"></td>							
							<td align="right"></td>							
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div><hr/>
	
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
						echo "<li><a href='?page=lap_farmasi_sisastok&triwulan=$triwulan&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	