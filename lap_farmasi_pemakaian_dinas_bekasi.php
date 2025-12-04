<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_pemakaian_dinas_bekasi"/>
						<div class="col-sm-2">
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
						<div class="col-sm-2">
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="namaprg" class="form-control" required>
								<option value='semua'>Semua</option>
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
						</div>
						<div class="col-sm-2">
							<input type="text" name="namabarang" class="form-control" placeholder="Nama Barang" value="<?php echo $_GET['namabarang'];?>">
						</div>	
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_pemakaian_dinas_bekasi" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="lap_farmasi_pemakaian_dinas_bekasi_excel.php?namaprg=<?php echo $_GET['namaprg'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>-->
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
	
	<?php
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];		
		$tahun = $_GET['tahun'];
		$tahunlalu = $tahun - 1;
		$namaprg = $_GET['namaprg'];
		$namabarang = $_GET['namabarang'];
		
		if($namaprg != ''){
		$array_bln = array('00','JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<?php if($bulanakhir > 6){ ?>
					<table class="table-judul-laporan-min" style="width:1300px;">
				<?php }else{ ?>
					<table class="table-judul-laporan-min" width="100%">
				<?php }?>
					<thead>
						<tr>
							<th rowspan="3" width="3%">NO.</th>
							<th rowspan="3" width="7%">KODE</th>
							<th rowspan="3" width="20%">NAMA OBAT & BMHP</th>
							<th rowspan="3">SATUAN</th>
							<th rowspan="2" width="5%">STOK<br/>AWAL</th>
							<th rowspan="2" width="5%">PENERIMAAN</th>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th>".$array_bln[$b]."</th>";
								}
							?>							
							<th rowspan="2" width="5%">TOTAL<br/>PEMAKAIAN</th>
							<th rowspan="2" width="5%">TOTAL<br/>BULAN</th>
							<th rowspan="2" width="5%">PEMAKAIAN<br/>RATA-RATA</th>
							<th rowspan="2" width="5%">SALDO<br/>AKHIR</th>
							<th rowspan="2" width="5%">MOS</th>
						</tr>
						<tr>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									// echo "<th>"."APBD"."</th>";
									// echo "<th>"."JKN"."</th>";
								}
							?>
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
							
							if($namaprg == "semua" || $namaprg == ""){
								$namaprg = "";
							}else{
								$namaprg = "WHERE NamaProgram = '$namaprg'";
							}

							if($namabarang == ""){
								$namabarang = "";
							}else{
								$namabarang = "AND NamaBarang like '%$namabarang%'";
							}
													
							$str = "SELECT * FROM `ref_obat_lplpo`".$namaprg.$namabarang;
							$str2 = $str." GROUP BY `KodeBarang` ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi, $str2);
							while($data = mysqli_fetch_assoc($query)){
								if($namaprogram != $data['NamaProgram']){
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='23'>$data[NamaProgram]</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								
								$no = $no + 1;
								$IdBarangPkm = $data['IdStokBulan'];
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$satuan = $data['Satuan'];
								$hargabeli = $data['HargaBeli'];
								$sumberanggaran = $data['SumberAnggaran'];
								$nofakturterima = $data['NoFakturTerima'];
								
								// tahap1, stok awal								
								if($tahun == '2020'){
									$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `HargaBeli`='$hargabeli' AND `SumberAnggaran`='$sumberanggaran' AND `Tahun`='$tahunlalu'";
								}else{
									$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang'";
								}	
								// echo "Hasil : ".$str_stokawal;
								$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
								if ($dt_stokawal_dtl['Stok'] != null){
									$stokawal = $dt_stokawal_dtl['Stok'];
								}else{
									$stokawal = '0';
								}

								// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
								if(substr($namabarang,0,6) == "VAKSIN" || substr($namabarang,0,7) == "PELARUT"){
									$str_terima_lalu = "SELECT a.KodeBarang, SUM(Jumlah)AS Jumlah 
									FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE a.`KodeBarang`='$kodebarang' AND (YEAR(b.TanggalPenerimaan) < '$tahun')";
								}else{
									$str_terima_lalu = "SELECT a.KodeBarang, SUM(Jumlah)AS Jumlah 
									FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE a.`KodeBarang`='$kodebarang' AND (YEAR(b.TanggalPenerimaan) < '$tahun')";
								}
								// echo $str_terima_lalu;
								$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
								if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
									$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
								}else{
									$penerimaan_lalu = '0';
								}

								// tahap2.2 cek pengeluaran sebelumnya
								if(substr($namabarang,0,6) == "VAKSIN" || substr($namabarang,0,7) == "PELARUT"){
									$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
									JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran) < '$tahun'";	
								}else{
									$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
									JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran) < '$tahun'";	
								}
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}	
								
								// tahap2.3 cek pengeluaran sebelumnya
								$str_pengeluaran_lalu_2019 = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran) = '2019'";	
								// echo $str_pengeluaran_lalu_2019;
								$dt_pengeluaran_lalu_2019 = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu_2019));									
								if ($dt_pengeluaran_lalu_2019['Jumlah'] != null){
									$pengeluaran_lalu_2019 = $dt_pengeluaran_lalu_2019['Jumlah'];
								}else{
									$pengeluaran_lalu_2019 = '0';
								}	
								
								$pengeluaran_lalu_jumlah = $pengeluaran_lalu - $pengeluaran_lalu_2019;
								if ($pengeluaran_lalu_jumlah < 0){
									$pengeluaran_lalu_jumlah1 = 0;
								}else{
									$pengeluaran_lalu_jumlah1 = $pengeluaran_lalu_jumlah;
								}

								// tahap 2.4 cek karantina lalu
								$str_karantina_lalu = "SELECT SUM(`Jumlah`) AS Jumlah , TanggalKarantina, StatusKarantina 
								FROM `tbgfk_karantinadetail` 
								WHERE `KodeBarang`='$kodebarang' AND YEAR(TanggalKarantina) < '$tahun'";
								// echo $str_karantina_lalu;
								$dt_karantina_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina_lalu));
								$karantina_lalu = $dt_karantina_lalu['Jumlah'];

								$tanggalawal = date('Y', strtotime($_GET['tanggal_awal']));
								if($kota == "KABUPATEN BEKASI" AND $tanggalawal == "2021" AND $kodebarang == 'DRG00078'){
									$stokawal_total = $stokawal;
								}else{
									$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu_jumlah1 - $karantina_lalu;
								}

								// penerimaan
								$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah) AS Jumlah, `Harga` FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
								WHERE a.`KodeBarang`='$kodebarang' AND (YEAR(b.TanggalPenerimaan) = '$tahun')";
								// echo $strpenerimaan;
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
									$penerimaan = $dtpenerimaan['Jumlah'];
								}else{
									$penerimaan = '0';
								}	

								// pemakaian / distribusi
								$bln_pengeluaran_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '01' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['1'] = $bln_pengeluaran_01['Jumlah'];
								$bln_karantina_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '01' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['1'] = $bln_karantina_01['Jumlah'];
								
								$bln_pengeluaran_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '02' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['2'] = $bln_pengeluaran_02['Jumlah'];
								$bln_karantina_02= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '02' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['2'] = $bln_karantina_02['Jumlah'];
								
								$bln_pengeluaran_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '03' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['3'] = $bln_pengeluaran_03['Jumlah'];
								$bln_karantina_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '03' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['3'] = $bln_karantina_03['Jumlah'];
								
								$bln_pengeluaran_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '04' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['4'] = $bln_pengeluaran_04['Jumlah'];
								$bln_karantina_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '04' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['4'] = $bln_karantina_04['Jumlah'];
								
								$bln_pengeluaran_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '05' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['5'] = $bln_pengeluaran_05['Jumlah'];
								$bln_karantina_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '05' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['5'] = $bln_karantina_05['Jumlah'];
								
								$bln_pengeluaran_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '06' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['6'] = $bln_pengeluaran_06['Jumlah'];
								$bln_karantina_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '06' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['6'] = $bln_karantina_06['Jumlah'];
								
								$bln_pengeluaran_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '07' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['7'] = $bln_pengeluaran_07['Jumlah'];
								$bln_karantina_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '07' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['7'] = $bln_karantina_07['Jumlah'];
								
								$bln_pengeluaran_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '08' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['8'] = $bln_pengeluaran_08['Jumlah'];
								$bln_karantina_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '08' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['8'] = $bln_karantina_08['Jumlah'];
								
								$bln_pengeluaran_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '09' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['9'] = $bln_pengeluaran_09['Jumlah'];
								$bln_karantina_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '09' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['9'] = $bln_karantina_09['Jumlah'];
								
								$bln_pengeluaran_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '10' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['10'] = $bln_pengeluaran_10['Jumlah'];
								$bln_karantina_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '10' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['10'] = $bln_karantina_10['Jumlah'];
								
								$bln_pengeluaran_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '11' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['11'] = $bln_pengeluaran_11['Jumlah'];
								$bln_karantina_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '11' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['11'] = $bln_karantina_11['Jumlah'];
								
								$bln_pengeluaran_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`) = '12' AND b.`KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_apbd['12'] = $bln_pengeluaran_12['Jumlah'];
								$bln_karantina_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.`Jumlah`) AS Jumlah FROM tbgfk_karantinadetail WHERE YEAR(`TanggalKarantina`)='$tahun' AND MONTH(`TanggalKarantina`) = '12' AND `KodeBarang`='$kodebarang'"));
								$bln_pengeluaran_karantina['12'] = $bln_karantina_12['Jumlah'];

								
						?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td align="center"><?php echo $data['KodeBarang'];?></td>											
									<td class="namabarangcls" align="left">
										<?php 
											echo strtoupper($data['NamaBarang'])."<br/>";
											// echo "<b>Keterangan :</b><br/>";
											// echo "Stok Master = ".$stokawal."<br/>";
											// echo "Penerimaan Lalu = ".$penerimaan_lalu."<br/>";
											// echo "Penerimaan = ".$penerimaan."<br/>";
											// echo "Pengeluaran Lalu = ".$pengeluaran_lalu_jumlah."<br/>";
											// echo "Pengeluaran = ".$pengeluarans."<br/>";
											// echo "Karantina Lalu = ".$karantina_lalu."<br/>";
											// echo "Karantina = ".$karantina."<br/>";
											// echo "Saldo Awal = ".$stokawal_total;
										?>
									</td>									
									<td align="center"><?php echo $satuan;?></td>
									<td align="center"><?php echo rupiah($stokawal_total);?></td>
									<td align="center"><?php echo rupiah($penerimaan);?></td>
									<?php
									$totbulan = 0;
									$rata_rata = 0;
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$totalapbd[$no][] = $bln_pengeluaran_apbd[$b];
										$totalkarantina[$no][] = $bln_pengeluaran_karantina[$b];

										if($bln_pengeluaran_apbd[$b] != 0 || $bln_pengeluaran_karantina[$b] != 0){
											$totbulan++;
										}
									?>	
									<td align="right">
										<?php 
											if($bln_pengeluaran_apbd[$b] == ""){
												echo "0";
											}else{
												echo rupiah($bln_pengeluaran_apbd[$b]);
											}
										?>
									</td>								
									<?php
										}
										
										$total_apbd = array_sum($totalapbd[$no]);
										$total_karantina = array_sum($totalkarantina[$no]);
										$total = $total_apbd + $total_karantina;
										$rata_rata = $total / $totbulan;
										if(is_nan($rata_rata) == 1){
											$rata_rata = 0;
										}else{
											$rata_rata = $rata_rata;
										}
									?>			
									<td align="right"><?php echo rupiah($total);?></td>	
									<td align="right"><?php echo $totbulan;?></td>
									<td align="right"><?php echo number_format($rata_rata,2);?></td>
									<td align="right">
										<?php 
											$saldoakhir = $stokawal_total + $penerimaan - $total;											
											echo rupiah($saldoakhir);
										?>
									</td>
									<td align="right">
										<?php 
											$mos = $saldoakhir / $rata_rata;
											if(is_nan($mos) == 1){
												$mos = 0;
											}else{
												$mos = $mos;
											}
											echo number_format($mos,0)." Bulan";
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
	</div><hr/>
	<ul class="pagination">
		<?php
			$namaprg = $_GET['namaprg'];
			$namabarang = $_GET['namabarang'];
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
						echo "<li><a href='?page=lap_farmasi_pemakaian_dinas_bekasi&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&namaprg=$namaprg&namabarang=$namabarang&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}else{
			echo "Silahkan ketik nama barang...";
		} 
	?>
</div>