<?php
	include "config/helper_report.php";
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$namapuskesmas = $_GET['namapuskesmas'];
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">NARKOTIK PSIKOTROPIK</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_psikotropika_bogorkab_all"/>
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
						<div class="col-sm-2">
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
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_psikotropika_bogorkab_all" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="javascript:print()" class="btn btn-success btn-white">Print</a>
							<a href="lap_farmasi_psikotropika_bogorkab_all_excel.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>-->
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
	if($kodepuskesmas != ''){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN NARKOTIK PSIKOTROPIK</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
			<br/>
		</div>

		<div class="atastabel font11">
			<div style="float:left; width:35%; margin-bottom:10px;">	
				<table>
					<tr>
						<td style="padding:2px 4px;">Kelurahan/Desa</td>
						<td style="padding:2px 4px;">:</td>
						<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
					</tr>
					<tr>
						<td style="padding:2px 4px;">Kecamatan</td>
						<td style="padding:2px 4px;">:</td>
						<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
					</tr>
				</table>
			</div>	
		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table-judul-laporan">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA OBAT</th>
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SATUAN</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">STOK AWAL</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PENERIMAAN</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PERSEDIAAN</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PENGELUARAN</th>
							<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SISA STOK</th>
						</tr>
					</thead>
					<tbody>
					<?php
						// tbgfkstok
						$strnarkotika = "SELECT * FROM `tbgfkstok` WHERE `GolonganFungsi` = 'NARKOTIKA' GROUP BY KodeBarang ORDER BY NamaBarang";
						$query_psk = mysqli_query($koneksi, $strnarkotika);
						while($dt_psk = mysqli_fetch_assoc($query_psk)){
							$no = $no + 1;
							$kodebarang = $dt_psk['KodeBarang'];
							$namabarang = $dt_psk['NamaBarang'];
							$satuan = $dt_psk['Satuan'];
							
							// tahap 1, stok awal
							$strsopkm = "SELECT * FROM `$tbstokopnam` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
							
							if($bulanawal == "01" AND $tahun == "2021"){
								// jika tahun 2021, datanya ambil dari import data
								$stokawal = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
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
									$stokawal = $total_sisastok_apbd_01 + $total_sisastok_jkn_01;
								}elseif($bulanawal == "03"){
									$stokawal = $total_sisastok_apbd_02 + $total_sisastok_jkn_02;
								}elseif($bulanawal == "04"){
									$stokawal = $total_sisastok_apbd_03 + $total_sisastok_jkn_03;
								}elseif($bulanawal == "05"){
									$stokawal = $total_sisastok_apbd_04 + $total_sisastok_jkn_04;
								}elseif($bulanawal == "06"){
									$stokawal = $total_sisastok_apbd_05 + $total_sisastok_jkn_05;
								}elseif($bulanawal == "07"){
									$stokawal = $total_sisastok_apbd_06 + $total_sisastok_jkn_06;
								}elseif($bulanawal == "08"){
									$stokawal = $total_sisastok_apbd_07 + $total_sisastok_jkn_07;
								}elseif($bulanawal == "09"){
									$stokawal = $total_sisastok_apbd_08 + $total_sisastok_jkn_08;
								}elseif($bulanawal == "10"){
									$stokawal = $total_sisastok_apbd_09 + $total_sisastok_jkn_09;
								}elseif($bulanawal == "11"){
									$stokawal = $total_sisastok_apbd_10 + $total_sisastok_jkn_10;
								}elseif($bulanawal == "12"){
									$stokawal = $total_sisastok_apbd_11 + $total_sisastok_jkn_11;
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
							$bln_penerimaan_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_01 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_02 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_03 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_04 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_05 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_06 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_07 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_08 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_09 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_10 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_11 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$bln_penerimaan_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_12 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));	
							
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
																		
							// tahap 3, pengeluaran 
							// jika januari rumusnya stok awal (des 2020) + penerimaan (jan 2021) - sisa stok (jan 2021)
							$bln_pengeluaran_apbd_01 = $dtstokopname['StokAwalApbd'] + $bln_penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$bln_pengeluaran_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							$bln_pengeluaran['1'] = $bln_pengeluaran_apbd_01 + $bln_pengeluaran_jkn_01;
							
							// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
							$bln_pengeluaran_apbd_02 = $total_sisastok_apbd_01 + $bln_penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$bln_pengeluaran_jkn_02 = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$bln_pengeluaran['2'] = $bln_pengeluaran_apbd_02 + $bln_pengeluaran_jkn_02;
							
							$bln_pengeluaran_apbd_03 = $total_sisastok_apbd_02 +  $bln_penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$bln_pengeluaran_jkn_03 = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$bln_pengeluaran['3'] = $bln_pengeluaran_apbd_03 + $bln_pengeluaran_jkn_03;
							
							$bln_pengeluaran_apbd_04 = $total_sisastok_apbd_03 + $bln_penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$bln_pengeluaran_jkn_04 = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$bln_pengeluaran['4'] = $bln_pengeluaran_apbd_04 + $bln_pengeluaran_jkn_04;
							
							$bln_pengeluaran_apbd_05 = $total_sisastok_apbd_04 + $bln_penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$bln_pengeluaran_jkn_05 = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$bln_pengeluaran['5'] = $bln_pengeluaran_apbd_05 + $bln_pengeluaran_jkn_05;
							
							$bln_pengeluaran_apbd_06 = $total_sisastok_apbd_05 + $bln_penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$bln_pengeluaran_jkn_06 = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							$bln_pengeluaran['6'] = $bln_pengeluaran_apbd_06 + $bln_pengeluaran_jkn_06;
							
							$bln_pengeluaran_apbd_07 = $total_sisastok_apbd_06 + $bln_penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$bln_pengeluaran_jkn_07 = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$bln_pengeluaran['7'] = $bln_pengeluaran_apbd_07 + $bln_pengeluaran_jkn_07;
							
							$bln_pengeluaran_apbd_08 = $total_sisastok_apbd_07 + $bln_penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$bln_pengeluaran_jkn_08 = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$bln_pengeluaran['8'] = $bln_pengeluaran_apbd_08 + $bln_pengeluaran_jkn_08;
							
							$bln_pengeluaran_apbd_09 = $total_sisastok_apbd_08 + $bln_penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$bln_pengeluaran_jkn_09 = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$bln_pengeluaran['9'] = $bln_pengeluaran_apbd_09 + $bln_pengeluaran_jkn_09;
							
							$bln_pengeluaran_apbd_10 = $total_sisastok_apbd_09 + $bln_penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$bln_pengeluaran_jkn_10 = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$bln_pengeluaran['10'] = $bln_pengeluaran_apbd_10 + $bln_pengeluaran_jkn_10;
							
							$bln_pengeluaran_apbd_11 = $total_sisastok_apbd_10 + $bln_penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$bln_pengeluaran_jkn_11 = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$bln_pengeluaran['11'] = $bln_pengeluaran_apbd_11 + $bln_pengeluaran_jkn_11;
							
							$bln_pengeluaran_apbd_12 = $total_sisastok_apbd_11 + $bln_penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$bln_pengeluaran_jkn_12 = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
							$bln_pengeluaran['12'] = $bln_pengeluaran_apbd_12 + $bln_pengeluaran_jkn_12;
							
							// sisa stok gudang
							$blngudang['1'] = $dtstokopname['Sisastok_Gudang_Apbd_01'] + $dtstokopname['Sisastok_Gudang_Jkn_01'];
							$blngudang['2'] = $dtstokopname['Sisastok_Gudang_Apbd_02'] + $dtstokopname['Sisastok_Gudang_Jkn_02'];
							$blngudang['3'] = $dtstokopname['Sisastok_Gudang_Apbd_03'] + $dtstokopname['Sisastok_Gudang_Jkn_03'];
							$blngudang['4'] = $dtstokopname['Sisastok_Gudang_Apbd_04'] + $dtstokopname['Sisastok_Gudang_Jkn_04'];
							$blngudang['5'] = $dtstokopname['Sisastok_Gudang_Apbd_05'] + $dtstokopname['Sisastok_Gudang_Jkn_05'];
							$blngudang['6'] = $dtstokopname['Sisastok_Gudang_Apbd_06'] + $dtstokopname['Sisastok_Gudang_Jkn_06'];
							$blngudang['7'] = $dtstokopname['Sisastok_Gudang_Apbd_07'] + $dtstokopname['Sisastok_Gudang_Jkn_07'];
							$blngudang['8'] = $dtstokopname['Sisastok_Gudang_Apbd_08'] + $dtstokopname['Sisastok_Gudang_Jkn_08'];
							$blngudang['9'] = $dtstokopname['Sisastok_Gudang_Apbd_09'] + $dtstokopname['Sisastok_Gudang_Jkn_09'];
							$blngudang['10'] = $dtstokopname['Sisastok_Gudang_Apbd_10'] + $dtstokopname['Sisastok_Gudang_Jkn_10'];
							$blngudang['11'] = $dtstokopname['Sisastok_Gudang_Apbd_11'] + $dtstokopname['Sisastok_Gudang_Jkn_11'];
							$blngudang['12'] = $dtstokopname['Sisastok_Gudang_Apbd_12'] + $dtstokopname['Sisastok_Gudang_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalgudang[$no][] = $blngudang[$b];
							}
							
							// sisa stok depot
							$blndepot['1'] = $dtstokopname['Sisastok_Depot_Apbd_01'] + $dtstokopname['Sisastok_Depot_Jkn_01'];
							$blndepot['2'] = $dtstokopname['Sisastok_Depot_Apbd_02'] + $dtstokopname['Sisastok_Depot_Jkn_02'];
							$blndepot['3'] = $dtstokopname['Sisastok_Depot_Apbd_03'] + $dtstokopname['Sisastok_Depot_Jkn_03'];
							$blndepot['4'] = $dtstokopname['Sisastok_Depot_Apbd_04'] + $dtstokopname['Sisastok_Depot_Jkn_04'];
							$blndepot['5'] = $dtstokopname['Sisastok_Depot_Apbd_05'] + $dtstokopname['Sisastok_Depot_Jkn_05'];
							$blndepot['6'] = $dtstokopname['Sisastok_Depot_Apbd_06'] + $dtstokopname['Sisastok_Depot_Jkn_06'];
							$blndepot['7'] = $dtstokopname['Sisastok_Depot_Apbd_07'] + $dtstokopname['Sisastok_Depot_Jkn_07'];
							$blndepot['8'] = $dtstokopname['Sisastok_Depot_Apbd_08'] + $dtstokopname['Sisastok_Depot_Jkn_08'];
							$blndepot['9'] = $dtstokopname['Sisastok_Depot_Apbd_09'] + $dtstokopname['Sisastok_Depot_Jkn_09'];
							$blndepot['10'] = $dtstokopname['Sisastok_Depot_Apbd_10'] + $dtstokopname['Sisastok_Depot_Jkn_10'];
							$blndepot['11'] = $dtstokopname['Sisastok_Depot_Apbd_11'] + $dtstokopname['Sisastok_Depot_Jkn_11'];
							$blndepot['12'] = $dtstokopname['Sisastok_Depot_Apbd_12'] + $dtstokopname['Sisastok_Depot_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totaldepot[$no][] = $blndepot[$b];
							}
							
							// sisa stok igd
							$blnigd['1'] = $dtstokopname['Sisastok_Igd_Apbd_01'] + $dtstokopname['Sisastok_Igd_Jkn_01'];
							$blnigd['2'] = $dtstokopname['Sisastok_Igd_Apbd_02'] + $dtstokopname['Sisastok_Igd_Jkn_02'];
							$blnigd['3'] = $dtstokopname['Sisastok_Igd_Apbd_03'] + $dtstokopname['Sisastok_Igd_Jkn_03'];
							$blnigd['4'] = $dtstokopname['Sisastok_Igd_Apbd_04'] + $dtstokopname['Sisastok_Igd_Jkn_04'];
							$blnigd['5'] = $dtstokopname['Sisastok_Igd_Apbd_05'] + $dtstokopname['Sisastok_Igd_Jkn_05'];
							$blnigd['6'] = $dtstokopname['Sisastok_Igd_Apbd_06'] + $dtstokopname['Sisastok_Igd_Jkn_06'];
							$blnigd['7'] = $dtstokopname['Sisastok_Igd_Apbd_07'] + $dtstokopname['Sisastok_Igd_Jkn_07'];
							$blnigd['8'] = $dtstokopname['Sisastok_Igd_Apbd_08'] + $dtstokopname['Sisastok_Igd_Jkn_08'];
							$blnigd['9'] = $dtstokopname['Sisastok_Igd_Apbd_09'] + $dtstokopname['Sisastok_Igd_Jkn_09'];
							$blnigd['10'] = $dtstokopname['Sisastok_Igd_Apbd_10'] + $dtstokopname['Sisastok_Igd_Jkn_10'];
							$blnigd['11'] = $dtstokopname['Sisastok_Igd_Apbd_11'] + $dtstokopname['Sisastok_Igd_Jkn_11'];
							$blnigd['12'] = $dtstokopname['Sisastok_Igd_Apbd_12'] + $dtstokopname['Sisastok_Igd_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totaligd[$no][] = $blnigd[$b];
							}
							
							// sisa stok ranap
							$blnranap['1'] = $dtstokopname['Sisastok_Ranap_Apbd_01'] + $dtstokopname['Sisastok_Ranap_Jkn_01'];
							$blnranap['2'] = $dtstokopname['Sisastok_Ranap_Apbd_02'] + $dtstokopname['Sisastok_Ranap_Jkn_02'];
							$blnranap['3'] = $dtstokopname['Sisastok_Ranap_Apbd_03'] + $dtstokopname[' Sisastok_Ranap_Jkn_03'];
							$blnranap['4'] = $dtstokopname['Sisastok_Ranap_Apbd_04'] + $dtstokopname['Sisastok_Ranap_Jkn_04'];
							$blnranap['5'] = $dtstokopname['Sisastok_Ranap_Apbd_05'] + $dtstokopname['Sisastok_Ranap_Jkn_05'];
							$blnranap['6'] = $dtstokopname['Sisastok_Ranap_Apbd_06'] + $dtstokopname['Sisastok_Ranap_Jkn_06'];
							$blnranap['7'] = $dtstokopname['Sisastok_Ranap_Apbd_07'] + $dtstokopname['Sisastok_Ranap_Jkn_07'];
							$blnranap['8'] = $dtstokopname['Sisastok_Ranap_Apbd_08'] + $dtstokopname['Sisastok_Ranap_Jkn_08'];
							$blnranap['9'] = $dtstokopname['Sisastok_Ranap_Apbd_09'] + $dtstokopname['Sisastok_Ranap_Jkn_09'];
							$blnranap['10'] = $dtstokopname['Sisastok_Ranap_Apbd_10'] + $dtstokopname['Sisastok_Ranap_Jkn_10'];
							$blnranap['11'] = $dtstokopname['Sisastok_Ranap_Apbd_11'] + $dtstokopname['Sisastok_Ranap_Jkn_11'];
							$blnranap['12'] = $dtstokopname['Sisastok_Ranap_Apbd_12'] + $dtstokopname['Sisastok_Ranap_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalranap[$no][] = $blnranap[$b];
							}
							
							// sisa stok poned
							$blnponed['1'] = $dtstokopname['Sisastok_Poned_Apbd_01'] + $dtstokopname['Sisastok_Poned_Jkn_01'];
							$blnponed['2'] = $dtstokopname['Sisastok_Poned_Apbd_02'] + $dtstokopname['Sisastok_Poned_Jkn_02'];
							$blnponed['3'] = $dtstokopname['Sisastok_Poned_Apbd_03'] + $dtstokopname['Sisastok_Poned_Jkn_03'];
							$blnponed['4'] = $dtstokopname['Sisastok_Poned_Apbd_04'] + $dtstokopname['Sisastok_Poned_Jkn_04'];
							$blnponed['5'] = $dtstokopname['Sisastok_Poned_Apbd_05'] + $dtstokopname['Sisastok_Poned_Jkn_05'];
							$blnponed['6'] = $dtstokopname['Sisastok_Poned_Apbd_06'] + $dtstokopname['Sisastok_Poned_Jkn_06'];
							$blnponed['7'] = $dtstokopname['Sisastok_Poned_Apbd_07'] + $dtstokopname['Sisastok_Poned_Jkn_07'];
							$blnponed['8'] = $dtstokopname['Sisastok_Poned_Apbd_08'] + $dtstokopname['Sisastok_Poned_Jkn_08'];
							$blnponed['9'] = $dtstokopname['Sisastok_Poned_Apbd_09'] + $dtstokopname['Sisastok_Poned_Jkn_09'];
							$blnponed['10'] = $dtstokopname['Sisastok_Poned_Apbd_10'] + $dtstokopname['Sisastok_Poned_Jkn_10'];
							$blnponed['11'] = $dtstokopname['Sisastok_Poned_Apbd_11'] + $dtstokopname['Sisastok_Poned_Jkn_11'];
							$blnponed['12'] = $dtstokopname['Sisastok_Poned_Apbd_12'] + $dtstokopname['Sisastok_Poned_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalponed[$no][] = $blnponed[$b];
							}
							
							// sisa stok pustu
							$blnpustu['1'] = $dtstokopname['Sisastok_Pustu_Apbd_01'] + $dtstokopname['Sisastok_Pustu_Jkn_01'];
							$blnpustu['2'] = $dtstokopname['Sisastok_Pustu_Apbd_02'] + $dtstokopname['Sisastok_Pustu_Jkn_02'];
							$blnpustu['3'] = $dtstokopname['Sisastok_Pustu_Apbd_03'] + $dtstokopname['Sisastok_Pustu_Jkn_03'];
							$blnpustu['4'] = $dtstokopname['Sisastok_Pustu_Apbd_04'] + $dtstokopname['Sisastok_Pustu_Jkn_04'];
							$blnpustu['5'] = $dtstokopname['Sisastok_Pustu_Apbd_05'] + $dtstokopname['Sisastok_Pustu_Jkn_05'];
							$blnpustu['6'] = $dtstokopname['Sisastok_Pustu_Apbd_06'] + $dtstokopname['Sisastok_Pustu_Jkn_06'];
							$blnpustu['7'] = $dtstokopname['Sisastok_Pustu_Apbd_07'] + $dtstokopname['Sisastok_Pustu_Jkn_07'];
							$blnpustu['8'] = $dtstokopname['Sisastok_Pustu_Apbd_08'] + $dtstokopname['Sisastok_Pustu_Jkn_08'];
							$blnpustu['9'] = $dtstokopname['Sisastok_Pustu_Apbd_09'] + $dtstokopname['Sisastok_Pustu_Jkn_09'];
							$blnpustu['10'] = $dtstokopname['Sisastok_Pustu_Apbd_10'] + $dtstokopname['Sisastok_Pustu_Jkn_10'];
							$blnpustu['11'] = $dtstokopname['Sisastok_Pustu_Apbd_11'] + $dtstokopname['Sisastok_Pustu_Jkn_11'];
							$blnpustu['12'] = $dtstokopname['Sisastok_Pustu_Apbd_12'] + $dtstokopname['Sisastok_Pustu_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalpustu[$no][] = $blnpustu[$b];
							}
							
							// sisa stok pusling
							$blnpusling['1'] = $dtstokopname['Sisastok_Pusling_Apbd_01'] + $dtstokopname['Sisastok_Pusling_Jkn_01'];
							$blnpusling['2'] = $dtstokopname['Sisastok_Pusling_Apbd_02'] + $dtstokopname['Sisastok_Pusling_Jkn_02'];
							$blnpusling['3'] = $dtstokopname['Sisastok_Pusling_Apbd_03'] + $dtstokopname['Sisastok_Pusling_Jkn_03'];
							$blnpusling['4'] = $dtstokopname['Sisastok_Pusling_Apbd_04'] + $dtstokopname['Sisastok_Pusling_Jkn_04'];
							$blnpusling['5'] = $dtstokopname['Sisastok_Pusling_Apbd_05'] + $dtstokopname['Sisastok_Pusling_Jkn_05'];
							$blnpusling['6'] = $dtstokopname['Sisastok_Pusling_Apbd_06'] + $dtstokopname['Sisastok_Pusling_Jkn_06'];
							$blnpusling['7'] = $dtstokopname['Sisastok_Pusling_Apbd_07'] + $dtstokopname['Sisastok_Pusling_Jkn_07'];
							$blnpusling['8'] = $dtstokopname['Sisastok_Pusling_Apbd_08'] + $dtstokopname['Sisastok_Pusling_Jkn_08'];
							$blnpusling['9'] = $dtstokopname['Sisastok_Pusling_Apbd_09'] + $dtstokopname['Sisastok_Pusling_Jkn_09'];
							$blnpusling['10'] = $dtstokopname['Sisastok_Pusling_Apbd_10'] + $dtstokopname['Sisastok_Pusling_Jkn_10'];
							$blnpusling['11'] = $dtstokopname['Sisastok_Pusling_Apbd_11'] + $dtstokopname['Sisastok_Pusling_Jkn_11'];
							$blnpusling['12'] = $dtstokopname['Sisastok_Pusling_Apbd_12'] + $dtstokopname['Sisastok_Pusling_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalpusling[$no][] = $blnpusling[$b];
							}
							
							// sisa stok poli
							$blnpoli['1'] = $dtstokopname['Sisastok_Poli_Apbd_01'] + $dtstokopname['Sisastok_Poli_Jkn_01'];
							$blnpoli['2'] = $dtstokopname['Sisastok_Poli_Apbd_02'] + $dtstokopname['Sisastok_Poli_Jkn_02'];
							$blnpoli['3'] = $dtstokopname['Sisastok_Poli_Apbd_03'] + $dtstokopname['Sisastok_Poli_Jkn_03'];
							$blnpoli['4'] = $dtstokopname['Sisastok_Poli_Apbd_04'] + $dtstokopname['Sisastok_Poli_Jkn_04'];
							$blnpoli['5'] = $dtstokopname['Sisastok_Poli_Apbd_05'] + $dtstokopname['Sisastok_Poli_Jkn_05'];
							$blnpoli['6'] = $dtstokopname['Sisastok_Poli_Apbd_06'] + $dtstokopname['Sisastok_Poli_Jkn_06'];
							$blnpoli['7'] = $dtstokopname['Sisastok_Poli_Apbd_07'] + $dtstokopname['Sisastok_Poli_Jkn_07'];
							$blnpoli['8'] = $dtstokopname['Sisastok_Poli_Apbd_08'] + $dtstokopname['Sisastok_Poli_Jkn_08'];
							$blnpoli['9'] = $dtstokopname['Sisastok_Poli_Apbd_09'] + $dtstokopname['Sisastok_Poli_Jkn_09'];
							$blnpoli['10'] = $dtstokopname['Sisastok_Poli_Apbd_10'] + $dtstokopname['Sisastok_Poli_Jkn_10'];
							$blnpoli['11'] = $dtstokopname['Sisastok_Poli_Apbd_11'] + $dtstokopname['Sisastok_Poli_Jkn_11'];
							$blnpoli['12'] = $dtstokopname['Sisastok_Poli_Apbd_12'] + $dtstokopname['Sisastok_Poli_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totalpoli[$no][] = $blnpoli[$b];
							}
							
							// sisa stok lainnya
							$blnlainnya['1'] = $dtstokopname['Sisastok_Lainnya_Apbd_01'] + $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							$blnlainnya['2'] = $dtstokopname['Sisastok_Lainnya_Apbd_02'] + $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$blnlainnya['3'] = $dtstokopname['Sisastok_Lainnya_Apbd_03'] + $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$blnlainnya['4'] = $dtstokopname['Sisastok_Lainnya_Apbd_04'] + $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$blnlainnya['5'] = $dtstokopname['Sisastok_Lainnya_Apbd_05'] + $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$blnlainnya['6'] = $dtstokopname['Sisastok_Lainnya_Apbd_06'] + $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							$blnlainnya['7'] = $dtstokopname['Sisastok_Lainnya_Apbd_07'] + $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$blnlainnya['8'] = $dtstokopname['Sisastok_Lainnya_Apbd_08'] + $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$blnlainnya['9'] = $dtstokopname['Sisastok_Lainnya_Apbd_09'] + $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$blnlainnya['10'] = $dtstokopname['Sisastok_Lainnya_Apbd_10'] + $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$blnlainnya['11'] = $dtstokopname['Sisastok_Lainnya_Apbd_11'] + $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$blnlainnya['12'] = $dtstokopname['Sisastok_Lainnya_Apbd_12'] + $dtstokopname['Sisastok_Lainnya_Jkn_12'];
									
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$totallainnya[$no][] = $blnlainnya[$b];
							}
							
						?>
						<tr>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($namabarang);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $satuan;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $stokawal;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">
								<?php 
									// penerimaan
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total_penerimaan[$no][] = $bln_penerimaan_apbd[$b]['Jumlah'] + $bln_penerimaan_jkn[$b]['Jumlah'];
									}
									echo rupiah(array_sum($total_penerimaan[$no]));
								?>
							</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">
								<?php 
									$jml_persediaan = $stokawal + array_sum($total_penerimaan[$no]);
									echo $jml_persediaan;
								?>
							</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">
								<?php
									// pengeluaran
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total_pemakaian[$no][] = $bln_pengeluaran[$b];
									}
									echo rupiah(array_sum($total_pemakaian[$no]));
								?>
							</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">
								<?php 
									echo $sisastok = $jml_persediaan - array_sum($total_pemakaian[$no]);
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

		<div class="row bawahtabel font10">
			<table class="table table-condensed">
				<tr>
					<td style="text-align:center;" width="50%">
					Mengetahui :<br>
					KEPALA PUSKESMAS <?php echo $namapuskesmas;?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
					
					
					<td style="text-align:center;" width="50%">
					Yang Melaporkan :<br>
					APOTEKER UPT YANKES <?php echo strtoupper($kecamatan);?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
		}else{
			echo "Silahkan ketik ulang nama puskesmas...";
		} 
	?>
</div>	
