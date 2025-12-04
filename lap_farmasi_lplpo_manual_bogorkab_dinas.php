<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
// include "otoritas.php";
$kodepuskesmas = $_GET['kodepuskesmas'];
$namapuskesmas = $_GET['namapuskesmas'];
$kota = $_SESSION['kota'];
$alamat = $_SESSION['alamat'];
$tanggal = date('Y-m-d');
$tblplpomanual_bogorkab = 'tblplpomanual_bogorkab_'.str_replace(' ', '', $namapuskesmas);
$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LPLPO</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_lplpo_manual_bogorkab_dinas"/>
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
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<input type="text" name="namapuskesmas" class="form-control puskesmas" placeholder="Nama Puskesmas" value="<?php echo $_GET['namapuskesmas'];?>" required>
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_lplpo_manual_bogorkab_dinas" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>-->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	
	if($bulan == 1){
		$blnsebelumnya= '12';
		$thnsebelumnya = $tahun - 1;
	}else{
		$blnsebelumnya = $bulan - 1;
		if(strlen($blnsebelumnya) == 1){
			$blnsebelumnya = '0'.$blnsebelumnya;
		}
		$thnsebelumnya = $tahun;
	}

	if($kodepuskesmas != ''){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN & LEMBAR PERMINTAAN OBAT (LPLPO)</b></span><br/>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>
	
	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table>
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Nama Puskesmas </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
				</tr>
			</table>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Pelaporan Bulan</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;">
						<?php
							$bulandepan = $bulan + 1;
							echo nama_bulan($bulan);
						?>
					</td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Permintaan Bulan</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;">
					<?php 
						$bulandepan = $bulan + 1;
						echo nama_bulan($bulandepan);?>
					</td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="row">
		<form action="lap_farmasi_lplpo_manual_simpan_bogorkab.php" method="post">
			<input type="hidden" name="bulan" value="<?php echo $_GET['bulan'];?>"/>
			<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>"/>
			<!--<input type="submit" class="btn btn-info pull-right" style="margin-bottom: 7px" value="Simpan">-->
			<div class="col-sm-12">
				<div class="table-responsive"><!-- text-nowrap-->
					<table class="table-judul-laporan-min" style="width: 1300px;">
						<thead>
							<tr>
								<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">NO.</th>
								<th width="5%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000; display: none;">KODE</th>
								<th width="20%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">NAMA BARANG</th>
								<th width="7%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">SATUAN</th>
								<th colspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">STOK AWAL</th>
								<th colspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">PENERIMAAN</th>
								<th colspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">PERSEDIAAN</th>
								<th colspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">PENGELUARAN</th>
								<th colspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">SISA AKHIR</th>
								<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">PERMINTAAN</th>
								<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">PEMBERIAN</th>
								<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; solid:1px dashed #000;">KET.</th>
							</tr>
							<tr>
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">APBD</th><!--stok awal-->
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">JKN</th>
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">APBD</th><!--penerimaan-->
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">JKN</th>
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">APBD</th><!--persediaan-->
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">JKN</th>
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">APBD</th><!--pemakaian-->
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">JKN</th>
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">APBD</th><!--sisa akhir-->
								<th style="text-align:center; vertical-align:middle; solid:1px dashed #000;">JKN</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// ini buat insert pertama kali saja
							$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `$tblplpomanual_bogorkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
							if ($cek == 0){			
								$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
								while($data = mysqli_fetch_assoc($query1)){
									//get stok gudangpkm
									$str1 = "INSERT INTO `$tblplpomanual_bogorkab`(`KodePuskesmas`,`KodeBarang`,`Tahun`,`Bulan`,`StokAwal`,`Penerimaan`,`Persediaan`,`Pemakaian`,`SisaAkhir`,`StokOptimum`,`Permintaan`,`Pemberian`,`Keterangan`) 
									VALUES ('$kodepuskesmas','$data[KodeBarang]','$tahun','$bulan','0','0','0','0','0','0','0','0','0')";
									mysqli_query($koneksi, $str1);
								}
							}
							
							$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbstokbulananpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
							if ($cek == 0){			
								$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
								while($data = mysqli_fetch_assoc($query1)){
									//get stok gudangpkm
									$str1 = "INSERT INTO `tbstokbulananpuskesmas`(`Bulan`,`Tahun`,`KodeBarang`,`NoBatch`,`StokLalu`,`Stok`,`Selisih`,`Keterangan`,`KodePuskesmas`) 
									VALUES ('$bulan','$tahun','$data[KodeBarang]','0','0','0','0','0','$kodepuskesmas')";
									mysqli_query($koneksi, $str1);
								}
							}
								
							$jumlah_perpage = 50;							
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
								if($namaprogram != $data['NamaProgram']){
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='22'>$data[NamaProgram]</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								$no = $no + 1;								
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								
								// tahap1, stok awal ambil dari stok akhir bulan sebelumnya jika 0 ambil hasil import bulan ini
								$strsopkm = "SELECT * FROM `$tbstokopnam` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
								$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
																
								if($bulan == "01" AND $tahun == "2021"){
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
										
									if($bulan == "02"){
										$stokawal_apbd = $total_sisastok_apbd_01;
										$stokawal_jkn = $total_sisastok_jkn_01;
									}elseif($bulan == "03"){
										$stokawal_apbd = $total_sisastok_apbd_02;
										$stokawal_jkn = $total_sisastok_jkn_02;
									}elseif($bulan == "04"){
										$stokawal_apbd = $total_sisastok_apbd_03;
										$stokawal_jkn = $total_sisastok_jkn_03;
									}elseif($bulan == "05"){
										$stokawal_apbd = $total_sisastok_apbd_04;
										$stokawal_jkn = $total_sisastok_jkn_04;
									}elseif($bulan == "06"){
										$stokawal_apbd = $total_sisastok_apbd_05;
										$stokawal_jkn = $total_sisastok_jkn_05;
									}elseif($bulan == "07"){
										$stokawal_apbd = $total_sisastok_apbd_06;
										$stokawal_jkn = $total_sisastok_jkn_06;
									}elseif($bulan == "08"){
										$stokawal_apbd = $total_sisastok_apbd_07;
										$stokawal_jkn = $total_sisastok_jkn_07;
									}elseif($bulan == "09"){
										$stokawal_apbd = $total_sisastok_apbd_08;
										$stokawal_jkn = $total_sisastok_jkn_08;
									}elseif($bulan == "10"){
										$stokawal_apbd = $total_sisastok_apbd_09;
										$stokawal_jkn = $total_sisastok_jkn_09;
									}elseif($bulan == "11"){
										$stokawal_apbd = $total_sisastok_apbd_10;
										$stokawal_jkn = $total_sisastok_jkn_10;
									}elseif($bulan == "12"){
										$stokawal_apbd = $total_sisastok_apbd_11;
										$stokawal_jkn = $total_sisastok_jkn_11;
									}	
								}	
								
								// tahap 2, penerimaan
								if($data['NamaProgram'] != "VAKSIN"){
									$penerimaanapbd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='$bulan' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								}else{
									$penerimaanapbd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='$bulan' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								}	
								$penerimaanjkn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT (PenerimaanJkn_01 + PenerimaanJkn_02 + PenerimaanJkn_03 + PenerimaanJkn_04 + PenerimaanJkn_05 + PenerimaanJkn_06 + PenerimaanJkn_07 + PenerimaanJkn_08 + PenerimaanJkn_09 + PenerimaanJkn_10 + PenerimaanJkn_11 + PenerimaanJkn_12) AS Jumlah FROM `tbstokopnam_puskesmas_bogorkab` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
								$penerimaan_apbd = $penerimaanapbd['Jumlah'];
								$penerimaan_jkn = $penerimaanjkn['Jumlah'];
								
								// persediaan
								$persediaan_apbd = $stokawal_apbd + $penerimaan_apbd;
								$persediaan_jkn = $stokawal_jkn + $penerimaan_jkn;
								
								// jika januari rumusnya stok awal (des 2020) + penerimaan (jan 2021) - sisa stok (jan 2021)
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
								}
								
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
														
								
								if($bulan == "01"){
									$pengeluaran_apbd = $dtstokopname['StokAwalApbd'] + $bln_penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
									$pengeluaran_jkn = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
								}elseif($bulan == "02"){
									$pengeluaran_apbd = $total_sisastok_apbd_01 + $bln_penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
									$pengeluaran_jkn = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
								}elseif($bulan == "03"){
									$pengeluaran_apbd = $total_sisastok_apbd_02 + $bln_penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
									$pengeluaran_jkn = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
								}elseif($bulan == "04"){
									$pengeluaran_apbd = $total_sisastok_apbd_03 + $bln_penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
									$pengeluaran_jkn = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
								}elseif($bulan == "05"){								
									$pengeluaran_apbd = $total_sisastok_apbd_04 + $bln_penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
									$pengeluaran_jkn = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
								}elseif($bulan == "06"){							
									$pengeluaran_apbd = $total_sisastok_apbd_05 + $bln_penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
									$pengeluaran_jkn = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
								}elseif($bulan == "07"){								
									$pengeluaran_apbd = $total_sisastok_apbd_06 + $bln_penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
									$pengeluaran_jkn = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
								}elseif($bulan == "08"){								
									$pengeluaran_apbd = $total_sisastok_apbd_07 + $bln_penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
									$pengeluaran_jkn = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
								}elseif($bulan == "09"){								
									$pengeluaran_apbd = $total_sisastok_apbd_08 + $bln_penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
									$pengeluaran_jkn = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
								}elseif($bulan == "10"){								
									$pengeluaran_apbd = $total_sisastok_apbd_09 + $bln_penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
									$pengeluaran_jkn = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
								}elseif($bulan == "11"){							
									$pengeluaran_apbd = $total_sisastok_apbd_10 + $bln_penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
									$pengeluaran_jkn = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
								}elseif($bulan == "12"){								
									$pengeluaran_apbd = $total_sisastok_apbd_11 + $bln_penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
									$pengeluaran_jkn = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
								}	
								
								// sisa
								$sisa_apbd = $persediaan_apbd - $pengeluaran_apbd;
								$sisa_jkn = $persediaan_jkn - $pengeluaran_jkn;
												
								// permintaan
								if($lplpomanual['Permintaan'] != ''){
									$permintaans = $lplpomanual['Permintaan'];
								}else{
									$permintaans = 0;
								}		
							?>
								<tr style="solid:1px dashed #000;">
									<td><?php echo $no;?></td>
									<td style="display: none;" class="namabarangcls"><?php echo $data['KodeBarang'];?></td>
									<td style="display: none;" class="batchcls"><?php echo $data['NoBatch'];?></td>
									<td class="namabarangcls"><?php echo strtoupper($data['NamaBarang']);?></td>
									<td><?php echo $data['Satuan'];?></td>
									<!--Stok Awal-->
									<td><!--background-color:#dbf7ff;-->
										<input type="hidden" name="kodebarang[]" value="<?php echo $data['KodeBarang'];?>"/>
										<input type="hidden" name="penerimaan[<?php echo $data['KodeBarang'];?>]" value="<?php echo $penerimaancls;?>"/>
										<input type="number" name="stokawal[<?php echo $data['KodeBarang'];?>]" style="width:60px" value="<?php echo $stokawal_apbd;?>" readonly />
									</td>
									<td>
										<input type="number" name="stokawaljkn[<?php echo $data['KodeBarang'];?>]" style="width:60px" value="<?php echo $stokawal_jkn;?>" readonly />
									</td>
									<!--Penerimaan-->
									<td class="penerimaancls">
										<input type="number" name="penerimaan[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right;" value="<?php echo rupiah($penerimaan_apbd);?>" readonly />
									</td>
									<td class="penerimaancls">
										<input type="number" name="penerimaanjkn[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo rupiah($penerimaan_jkn);?>" readonly />
									</td>
									<!--Persediaan-->
									<td class="persediaancls">
										<input type="number" name="psersediaan[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo rupiah($persediaan_apbd);?>" readonly />
									</td>
									<td class="persediaancls">
										<input type="number" name="psersediaanjkn[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo rupiah($persediaan_jkn);?>" readonly />
									</td>
									<!--Pemakaian-->
									<td class="pemakaiancls">
										<input type="number" name="pemakaian[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo $pengeluaran_apbd;?>" readonly />
									</td>
									<td class="pemakaiancls">
										<input type="number" name="pemakaianjkn[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo $pengeluaran_jkn;?>" readonly />
									</td>
									<!--SisaStok-->
									<td class="sisacls">
										<input type="number" name="sisa[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo rupiah($sisa_apbd);?>" readonly />
									</td>
									<td class="sisacls">
										<input type="number" name="sisajkn[<?php echo $data['KodeBarang'];?>]" style="width:70px; text-align: right" value="<?php echo rupiah($sisa_jkn);?>" readonly />
									</td>
									<td style="text-align:right; background-color:#dbf7ff;" class="permintaancls">
										<input type="number" name="permintaan[<?php echo $data['KodeBarang'];?>]" style="width:80px; text-align: right" value="<?php echo $permintaans;?>"/>
									</td>
									<td style="text-align:center; solid:1px dashed #000;"></td>
									<td style="text-align:center; solid:1px dashed #000;"></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div><br/>
				<!--<input type="submit" class="btnsimpan" style="padding: 10px" value="SIMPAN">-->
			</div>
		</form>	
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
						echo "<li><a href='?page=lap_farmasi_lplpo_manual_bogorkab_dinas&bulan=$bulan&tahun=$tahun&sumberanggaran=$sumberanggaran&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}else{
			echo "Silahkan ketik ulang nama puskesmas...";
		} 
	?>
	<!--<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					Stok Optimum = Sisa Akhir * 1.6%
				</p>
			</div>
		</div>
	</div>-->
</div>	
