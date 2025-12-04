<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>KETERSEDIAAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_ketersediaan"/>
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
						<div class="col-sm-1" style ="width:150px">
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
						<div class="col-sm-1" style ="width:125px">
							<select name="tahunawal" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahunawal'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-1" style ="width:50px">
							<p style="margin-top:5px;">s/d</p>
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
							<select name="tahunakhir" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahunakhir'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_farmasi_ketersediaan" class="btn btn-success btn-white">Refresh</a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php		
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];
		$tahunawal = $_GET['tahunawal'];		
		$tahunakhir = $_GET['tahunakhir'];		
		
		if(isset($bulanawal) and isset($tahunawal) and isset($bulanakhir) and isset($tahunakhir)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:2500px;">
					<thead>
						<tr>
							<th width="1%" rowspan="3">No.</th>
							<th width="2%" rowspan="3">Kode</th>
							<th width="5%" rowspan="3">Nama Barang</th>
							<th width="2%" rowspan="3">Satuan</th>
							<th width="2%" rowspan="3">Harga<br/>Satuan</th>
							<th width="2%" rowspan="3">Expire</th>
							<th width="2%" rowspan="3">No.Batch</th>
							<th colspan="2">Stok Awal</th>
							<th colspan="2">Penerimaan</th>
							<th colspan="2">Persediaan</th>
							<th colspan="24">Ketersediaan Bulan <?php echo date('d-m-Y');?></th>
							<th width="2%" rowspan="3">Pemakaian<br/>Rata-rata<br/>Per-Bulan</th>
							<th width="2%" rowspan="3">Tingkat<br/>Kecukupan</th>
							<th colspan="2">Total Distribusi</th>
							<th colspan="2">Total Pemakaian</th>
							<th colspan="2">Total Sisa Stok</th>
						</tr>
						<tr>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--StokAwal-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Penerimaan-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Persediaan-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th colspan="3">Gudang</th><!--Penerima Barang-->
							<th colspan="3">Depot</th>
							<th colspan="3">IGD</th>
							<th colspan="3">Ranap</th>
							<th colspan="3">Poned</th>
							<th colspan="3">Pustu</th>
							<th colspan="3">Pusling</th>
							<th colspan="3">Poli</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Total Distribusi-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Total Pemakaian-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Total Sisa Stok-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
						</tr>
						<tr>
							<th width="1%">D</th><!--Gudang-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Depot-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--IGD-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Ranap-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Poned-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Pustu-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Pusling-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Poli-->
							<th width="1%">P</th>
							<th width="1%">S</th>
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
						
						$key = $_GET['key'];
						$namaprg = $_GET['namaprg'];
						
						if($key !=''){
							$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
						}else{
							$strcari = " ";
						}
						
						if($namaprg == "Semua" OR $namaprg == ""){
							$namaprg = " ";
						}else{
							$namaprg = " AND `NamaProgram` = '$namaprg'";
						}	
						
						// syaratnya gudang, depot <> 0, jika salahsatunya ada isi maka obat tetap ditampilkan
						// syarat kedua obat digroup by (kode & batch) agar tidak terjadi duplikat dgn bulan berikutnya saat pencarian
						
						// $str = "SELECT * FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas'
						// AND (StokGudang_Sistem <> '0' OR StokDepot_Sistem <> '0' OR StokIgd_Sistem <> '0' OR StokRanap_Sistem <> '0' OR StokPoned_Sistem <> '0' 
						// OR StokPustu_Sistem <> '0' OR StokPoli_Sistem <> '0')".$strcari.$namaprg;
						// $str2 = $str." GROUP BY `KodeBarang`,`NoBatch` ORDER BY `IdProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
						
						$str = "SELECT * FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas'";
						
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='45'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}		
						
							$no = $no + 1;
							$IdBarangPkm = $data['IdStokBulan'];
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$satuan = $data['Satuan'];
							$nobatch = $data['NoBatch'];						
							$harga = $data['HargaSatuan'];
							$expire = $data['Expire'];
							
							// stok awal
							$stokgudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokGudang_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokdepot = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokDepot_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokigd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokIgd_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokRanap_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokponed = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPoned_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokpustu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPustu_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokpusling = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPusling_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$stokpoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokPoli_Sistem) AS Jml FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND (`Bulan` >= '$bulanawal' AND `Tahun` >= '$tahunawal' AND `Bulan` <= '$bulanakhir' AND `Tahun` <= '$tahunakhir')"));
							$strstokawal = $stokgudang['Jml'] + $stokdepot['Jml'] + $stokpoli['Jml'] + $stokigd['Jml'] + $stokranap['Jml'] + $stokponed['Jml'] + $stokpustu['Jml'] + $stokpusling['Jml'] + $stoklainnya['Jml'];
							$strstokawal_rupiah = $strstokawal * $harga;	
						
							// penerimaan
							$str_penerimaan = "SELECT SUM(Jumlah) AS Jml FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePenerima = '$kodepuskesmas' AND b.`KodeBarang`='$kodebarang' AND b.`NoBatch`='$nobatch' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) >= '$tahunawal' AND  MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) <= '$tahunakhir')";
							$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));	
							$penerimaan_rupiah = $penerimaan['Jml'] * $harga; 

							// persediaan
							$persediaan = $strstokawal + $penerimaan['Jml'];
							$persediaan_rupiah = $strstokawal_rupiah + $penerimaan_rupiah;
							
							// distribusi
							// gudang
							$distribusi_gudang = $persediaan;
							$pemakaian_gudang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$sisastok_gudang = $distribusi_gudang - $pemakaian_gudang['Jml'];
							
							// depot
							$distribusi_depot = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima`='LOKET OBAT' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_depot = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot`='LOKET OBAT' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_depot = $distribusi_depot['Jml'] - $pemakaian_depot['Jml'];
							
							// igd
							$distribusi_igd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima`='IGD' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_igd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot`='IGD' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_igd = $distribusi_igd['Jml'] - $pemakaian_igd['Jml'];
							
							// ranap
							$distribusi_ranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima`='RAWAT INAP' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_ranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot`='RAWAT INAP' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_ranap = $distribusi_ranap['Jml'] - $pemakaian_ranap['Jml'];
							
							// poned
							$distribusi_poned = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima`='PONED' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_poned = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot`='PONED' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_poned = $distribusi_poned['Jml'] - $pemakaian_poned['Jml'];
														
							// pustu
							$distribusi_pustu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima`='PUSTU' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_pustu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot`='PUSTU' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_pustu = $distribusi_pustu['Jml'] - $pemakaian_pustu['Jml'];
							
							// pusling
							$distribusi_pusling = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima`='PUSLING' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_pusling = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot`='PUSLING' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_pusling = $distribusi_pusling['Jml'] - $pemakaian_pusling['Jml'];
							
							// poli
							$distribusi_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah)AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND b.KodeBarang='$kodebarang' AND b.`NoBatch`='$nobatch' AND a.`Penerima` like '%POLI%' AND (MONTH(a.TanggalPengeluaran) >= '$bulanawal' AND YEAR(a.TanggalPengeluaran) = '$tahunawal' AND MONTH(a.TanggalPengeluaran) <= '$bulanakhir' AND YEAR(a.TanggalPengeluaran) = '$tahunakhir')"));
							$pemakaian_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat)AS Jml FROM `tbresepdetail` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND KodeBarang='$kodebarang' AND `NoBatch`='$nobatch' AND `Depot` like '%POLI%' AND (MONTH(TanggalResep) >= '$bulanawal' AND YEAR(TanggalResep) = '$tahunawal' AND MONTH(TanggalResep) <= '$bulanakhir' AND YEAR(TanggalResep) = '$tahunakhir')"));
							$sisastok_poli = $distribusi_poli['Jml'] - $pemakaian_poli['Jml'];							
							
							// total distribusi
							$ttl_distribusi = $distribusi_gudang + $distribusi_depot['Jml'] + $distribusi_poli['Jml'] + $distribusi_igd['Jml'] + $distribusi_ranap['Jml'] + $distribusi_poned['Jml'] + $distribusi_pustu['Jml'] + $distribusi_pusling['Jml'];
							$ttl_distribusi_rupiah = $ttl_distribusi * $harga;

							// total pemakaian
							$ttl_pemakaian = $pemakaian_gudang['Jml'] + $pemakaian_depot['Jml'] + $pemakaian_poli['Jml'] + $pemakaian_igd['Jml'] + $pemakaian_ranap['Jml'] + $pemakaian_poned['Jml'] + $pemakaian_pustu['Jml'] + $pemakaian_pusling['Jml'];
							$ttl_pemakaian_rupiah = $ttl_pemakaian * $harga;		

							// total sisa stok
							$ttl_sisastok = $sisastok_gudang + $sisastok_depot + $sisastok_poli + $sisastok_igd + $sisastok_ranap + $sisastok_poned + $sisastok_pustu + $sisastok_pusling;
							$ttl_sisastok_rupiah = $ttl_sisastok * $harga;
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>							
								<td align="center" class="kodecls"><?php echo $data['KodeBarang'];?></td>									
								<td align="left"><?php echo $namabarang;?></td>									
								<td align="center"><?php echo $satuan;?></td>
								<td align="right"><?php echo rupiah($harga);?></td>									
								<td align="center"><?php echo $expire;?></td>									
								<td align="center"><?php echo str_replace(",", ", ", $nobatch);?></td>								
								<td align="right"><?php echo rupiah($strstokawal);?></td>								
								<td align="right"><?php echo rupiah($strstokawal_rupiah);?></td>
								<td align="right"><!--Penerimaan-->
									<?php 
										if ($penerimaan['Jml'] != 0){
											echo rupiah($penerimaan['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>									
								<td align="right"><?php echo rupiah($penerimaan_rupiah);?></td>								
								<td align="right"><?php echo rupiah($persediaan);?></td><!--Persediaan-->									
								<td align="right"><?php echo rupiah($persediaan_rupiah);?></td></td>	
								<!--Gudang-->	
								<td align="right">
									<?php echo rupiah($persediaan);?>
								</td>								
								<td align="right">
									<?php 
										if ($pemakaian_gudang['Jml'] != 0){
											echo rupiah($pemakaian_gudang['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right">
									<?php echo $sisastok_gudang;?>
								</td>
								
								<!--Depot-->
								<td align="right">
									<?php 
										if ($distribusi_depot['Jml'] != 0){
											echo rupiah($distribusi_depot['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>									
								<td align="right">
									<?php 
										if ($pemakaian_depot['Jml'] != 0){
											echo rupiah($pemakaian_depot['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_depot;?></td>
								
								<!--IGD-->	
								<td align="right">
									<?php 
										if ($distribusi_igd['Jml'] != 0){
											echo rupiah($distribusi_igd['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>								
								<td align="right">
									<?php 
										if ($pemakaian_igd['Jml'] != 0){
											echo rupiah($pemakaian_igd['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_igd;?></td>
								
								<!--Ranap-->	
								<td align="right">
									<?php 
										if ($distribusi_ranap['Jml'] != 0){
											echo rupiah($distribusi_ranap['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>								
								<td align="right">
									<?php 
										if ($pemakaian_ranap['Jml'] != 0){
											echo rupiah($pemakaian_ranap['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_ranap;?></td>
								
								<!--Poned-->	
								<td align="right">
									<?php 
										if ($distribusi_poned['Jml'] != 0){
											echo rupiah($distribusi_poned['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>								
								<td align="right">
									<?php 
										if ($pemakaian_poned['Jml'] != 0){
											echo rupiah($pemakaian_poned['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_poned;?></td>
								
								<!--Pustu-->	
								<td align="right">
									<?php 
										if ($distribusi_pustu['Jml'] != 0){
											echo rupiah($distribusi_pustu['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>								
								<td align="right">
									<?php 
										if ($pemakaian_pustu['Jml'] != 0){
											echo rupiah($pemakaian_pustu['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_pustu;?></td>
								
								<!--Pusling-->	
								<td align="right">
									<?php 
										if ($distribusi_pusling['Jml'] != 0){
											echo rupiah($distribusi_pusling['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>									
								<td align="right">
									<?php 
										if ($pemakaian_pusling['Jml'] != 0){
											echo rupiah($pemakaian_pusling['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_pusling;?></td>
								
								<!--Poli-->
								<td align="right">
									<?php 
										if ($distribusi_poli['Jml'] != 0){
											echo rupiah($distribusi_poli['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>									
								<td align="right">
									<?php 
										if ($pemakaian_poli['Jml'] != 0){
											echo rupiah($pemakaian_poli['Jml']);
										}else{
											echo 0;
										}	
									?>
								</td>
								<td align="right"><?php echo $sisastok_poli;?></td>
								
								<!--Pemakaian Rata-rata-->	
								<td align="right">
								
								</td>
								
								<!--Tingkat kecukupan-->
								<td align="right">
								
								</td>	
								
								<!--Total Distribusi-->
								<td align="right"><?php echo rupiah($ttl_distribusi);?></td>	
								<td align="right"><?php echo rupiah($ttl_distribusi_rupiah);?></td>
								
								<!--Total Pemakaian-->	
								<td align="right"><?php echo rupiah($ttl_pemakaian);?></td>	
								<td align="right"><?php echo rupiah($ttl_pemakaian_rupiah);?></td>
								
								<!--Total Sisa Stok-->	
								<td align="right"><?php echo rupiah($ttl_sisastok);?></td>	
								<td align="right"><?php echo rupiah($ttl_sisastok_rupiah);?></td>
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
						$namaprgs = $_GET['namaprg'];
						echo "<li><a href='?page=lap_farmasi_ketersediaan&namaprg=$namaprgs&bulanawal=$bulanawal&tahunawal=$tahunawal&bulanakhir=$bulanakhir&tahunakhir=$tahunakhir&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
		}
	?>
	<!--<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Keterangan :</b><br/>
					- Silahkan download excel<br/>
					- Buka file excel, lalu isi kolom yang berwarna merah
				</p>
			</div>
		</div>
	</div>-->
</div>	

