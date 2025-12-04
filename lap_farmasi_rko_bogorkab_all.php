<?php
include "config/koneksi.php";
session_start();
$kodepuskesmas = $_GET['kodepuskesmas'];
$namapuskesmas = $_GET['namapuskesmas'];
$kodeobat = $_POST['kode']; 
$jumlahisi = $_POST['isi']; 
// $tahun = $_POST['tahun'];
// $tahun1 = $tahun - 2;
$tanggal = date('d-m-Y');
if ($namapuskesmas == 'semua'){
	$tbstokopnam = 'tbstokopnam_puskesmas_all_group';
	$tbrko = 'tbrko_puskesmas_all_group';
}else{
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
	$tbrko = "tbrko_puskesmas_".str_replace(' ', '', $namapuskesmas);
}	
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul">RENCANA KEBUTUHAN OBAT</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_rko_bogorkab_all"/>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									// for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									for($tahun = 2023 ; $tahun <= 2025; $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="namaprogram" class="form-control">
								<option value='Semua'>Semua</option>
								<?php
								$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['namaprogram'] == $data3['nama_program']){
										echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
									}else{
										echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-sm-3">
							<input type="text" name="namapuskesmas" class="form-control puskesmas" placeholder="Nama Puskesmas" value="<?php echo $_GET['namapuskesmas'];?>" required>
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_rko_bogorkab_all" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$namaprogram = $_GET['namaprogram'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 2;	
	if($tahun != ''){
	?>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="font-size:12px;">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<th width="22%" rowspan="2">NAMA BARANG</th>
							<th width="5%" rowspan="2">SATUAN</th>
							<th width="5%" rowspan="2">HARGA SATUAN</th>
							<th width="5%" rowspan="2">STOK AWAL <?php echo "(DESEMBER ".$tahun1.")"?></th>
							<th width="5%" rowspan="2"><?php echo "PENERIMAAN ".$tahun1?></th>
							<th width="5%" rowspan="2">TOTAL PERSEDIAAN</th>
							<th width="5%" rowspan="2"><?php echo "PENGELUARAN ".$tahun1?></th>
							<th width="5%" rowspan="2">SISA STOK</th>
							<th width="5%" rowspan="2">JUMLAH BULAN PENGELUARAN</th>
							<th width="5%" rowspan="2">PEMAKAIAN RATA2 PER-BULAN</th>
							<th width="5%" rowspan="2">JUMLAH KEBUTUHAN</th>
							<th width="5%" colspan="2">RENCANA KEBUTUHAN <br/> OBAT</th>
							<th width="5%" colspan="2">TOTAL RUPIAH RKO</th>
							<th width="5%" rowspan="2">RENCANA PEMBELIAN</th>
							<th width="5%" rowspan="2">TOTAL RUPIAH PEMBELIAN</th>
						</tr>
						<tr>
							<th>APBD</th><!--Rencana Kebutuhan Obat-->
							<th>JKN</th>
							<th>APBD</th><!--Total Rupiah-->
							<th>JKN</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$jumlah_perpage = 50;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}	
						
						if($namaprogram == "Semua" || $namaprogram == ""){
							$program = "";
						}else{
							$program = "AND `NamaProgram`='$namaprogram'";
						}
							
						// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
						$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%') ".$program;
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
								if($data['NamaProgram'] == "PKD"){
									$prg = "OBAT (PKD)";	
								}else{
									$prg = $data['NamaProgram'];
								}	
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='19'>$prg</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$nobatch = $data['NoBatch'];
							
							// $tbstokopnam
							if ($namapuskesmas == 'semua'){
								// 101 puskesmas
								$strsopkm = "SELECT `Tahun`,`KodeBarang`,
								SUM(StokAwalApbd) AS StokAwalApbd,
								SUM(StokAwalJkn) AS StokAwalJkn,
								SUM(PenerimaanJkn_01) AS PenerimaanJkn_01,
								SUM(PenerimaanJkn_02) AS PenerimaanJkn_02,
								SUM(PenerimaanJkn_03) AS PenerimaanJkn_03,
								SUM(PenerimaanJkn_04) AS PenerimaanJkn_04,
								SUM(PenerimaanJkn_05) AS PenerimaanJkn_05,
								SUM(PenerimaanJkn_06) AS PenerimaanJkn_06,
								SUM(PenerimaanJkn_07) AS PenerimaanJkn_07,
								SUM(PenerimaanJkn_08) AS PenerimaanJkn_08,
								SUM(PenerimaanJkn_09) AS PenerimaanJkn_09,
								SUM(PenerimaanJkn_10) AS PenerimaanJkn_10,
								SUM(PenerimaanJkn_11) AS PenerimaanJkn_11,
								SUM(PenerimaanJkn_12) AS PenerimaanJkn_12,
								SUM(Sisastok_Gudang_Apbd_01) AS Sisastok_Gudang_Apbd_01,
								SUM(Sisastok_Depot_Apbd_01) AS Sisastok_Depot_Apbd_01,
								SUM(Sisastok_Igd_Apbd_01) AS Sisastok_Igd_Apbd_01,
								SUM(Sisastok_Ranap_Apbd_01) AS Sisastok_Ranap_Apbd_01,
								SUM(Sisastok_Poned_Apbd_01) AS Sisastok_Poned_Apbd_01,
								SUM(Sisastok_Pustu_Apbd_01) AS Sisastok_Pustu_Apbd_01,
								SUM(Sisastok_Pusling_Apbd_01) AS Sisastok_Pusling_Apbd_01,
								SUM(Sisastok_Poli_Apbd_01) AS Sisastok_Poli_Apbd_01,
								SUM(Sisastok_Lainnya_Apbd_01) AS Sisastok_Lainnya_Apbd_01,
								SUM(Sisastok_Gudang_Jkn_01) AS Sisastok_Gudang_Jkn_01,
								SUM(Sisastok_Depot_Jkn_01) AS Sisastok_Depot_Jkn_01,
								SUM(Sisastok_Igd_Jkn_01) AS Sisastok_Igd_Jkn_01,
								SUM(Sisastok_Ranap_Jkn_01) AS Sisastok_Ranap_Jkn_01,
								SUM(Sisastok_Poned_Jkn_01) AS Sisastok_Poned_Jkn_01,
								SUM(Sisastok_Pustu_Jkn_01) AS Sisastok_Pustu_Jkn_01,
								SUM(Sisastok_Pusling_Jkn_01) AS Sisastok_Pusling_Jkn_01,
								SUM(Sisastok_Poli_Jkn_01) AS Sisastok_Poli_Jkn_01,
								SUM(Sisastok_Lainnya_Jkn_01) AS Sisastok_Lainnya_Jkn_01,
								SUM(Sisastok_Gudang_Apbd_02) AS Sisastok_Gudang_Apbd_02,
								SUM(Sisastok_Depot_Apbd_02) AS Sisastok_Depot_Apbd_02,
								SUM(Sisastok_Igd_Apbd_02) AS Sisastok_Igd_Apbd_02,
								SUM(Sisastok_Ranap_Apbd_02) AS Sisastok_Ranap_Apbd_02,
								SUM(Sisastok_Poned_Apbd_02) AS Sisastok_Poned_Apbd_02,
								SUM(Sisastok_Pustu_Apbd_02) AS Sisastok_Pustu_Apbd_02,
								SUM(Sisastok_Pusling_Apbd_02) AS Sisastok_Pusling_Apbd_02,
								SUM(Sisastok_Poli_Apbd_02) AS Sisastok_Poli_Apbd_02,
								SUM(Sisastok_Lainnya_Apbd_02) AS Sisastok_Lainnya_Apbd_02,
								SUM(Sisastok_Gudang_Jkn_02) AS Sisastok_Gudang_Jkn_02,
								SUM(Sisastok_Depot_Jkn_02) AS Sisastok_Depot_Jkn_02,
								SUM(Sisastok_Igd_Jkn_02) AS Sisastok_Igd_Jkn_02,
								SUM(Sisastok_Ranap_Jkn_02) AS Sisastok_Ranap_Jkn_02,
								SUM(Sisastok_Poned_Jkn_02) AS Sisastok_Poned_Jkn_02,
								SUM(Sisastok_Pustu_Jkn_02) AS Sisastok_Pustu_Jkn_02,
								SUM(Sisastok_Pusling_Jkn_02) AS Sisastok_Pusling_Jkn_02,
								SUM(Sisastok_Poli_Jkn_02) AS Sisastok_Poli_Jkn_02,
								SUM(Sisastok_Lainnya_Jkn_02) AS Sisastok_Lainnya_Jkn_02,
								SUM(Sisastok_Gudang_Apbd_03) AS Sisastok_Gudang_Apbd_03,
								SUM(Sisastok_Depot_Apbd_03) AS Sisastok_Depot_Apbd_03,
								SUM(Sisastok_Igd_Apbd_03) AS Sisastok_Igd_Apbd_03,
								SUM(Sisastok_Ranap_Apbd_03) AS Sisastok_Ranap_Apbd_03,
								SUM(Sisastok_Poned_Apbd_03) AS Sisastok_Poned_Apbd_03,
								SUM(Sisastok_Pustu_Apbd_03) AS Sisastok_Pustu_Apbd_03,
								SUM(Sisastok_Pusling_Apbd_03) AS Sisastok_Pusling_Apbd_03,
								SUM(Sisastok_Poli_Apbd_03) AS Sisastok_Poli_Apbd_03,
								SUM(Sisastok_Lainnya_Apbd_03) AS Sisastok_Lainnya_Apbd_03,
								SUM(Sisastok_Gudang_Jkn_03) AS Sisastok_Gudang_Jkn_03,
								SUM(Sisastok_Depot_Jkn_03) AS Sisastok_Depot_Jkn_03,
								SUM(Sisastok_Igd_Jkn_03) AS Sisastok_Igd_Jkn_03,
								SUM(Sisastok_Ranap_Jkn_03) AS Sisastok_Ranap_Jkn_03,
								SUM(Sisastok_Poned_Jkn_03) AS Sisastok_Poned_Jkn_03,
								SUM(Sisastok_Pustu_Jkn_03) AS Sisastok_Pustu_Jkn_03,
								SUM(Sisastok_Pusling_Jkn_03) AS Sisastok_Pusling_Jkn_03,
								SUM(Sisastok_Poli_Jkn_03) AS Sisastok_Poli_Jkn_03,
								SUM(Sisastok_Lainnya_Jkn_03) AS Sisastok_Lainnya_Jkn_03,
								SUM(Sisastok_Gudang_Apbd_04) AS Sisastok_Gudang_Apbd_04,
								SUM(Sisastok_Depot_Apbd_04) AS Sisastok_Depot_Apbd_04,
								SUM(Sisastok_Igd_Apbd_04) AS Sisastok_Igd_Apbd_04,
								SUM(Sisastok_Ranap_Apbd_04) AS Sisastok_Ranap_Apbd_04,
								SUM(Sisastok_Poned_Apbd_04) AS Sisastok_Poned_Apbd_04,
								SUM(Sisastok_Pustu_Apbd_04) AS Sisastok_Pustu_Apbd_04,
								SUM(Sisastok_Pusling_Apbd_04) AS Sisastok_Pusling_Apbd_04,
								SUM(Sisastok_Poli_Apbd_04) AS Sisastok_Poli_Apbd_04,
								SUM(Sisastok_Lainnya_Apbd_04) AS Sisastok_Lainnya_Apbd_04,
								SUM(Sisastok_Gudang_Jkn_04) AS Sisastok_Gudang_Jkn_04,
								SUM(Sisastok_Depot_Jkn_04) AS Sisastok_Depot_Jkn_04,
								SUM(Sisastok_Igd_Jkn_04) AS Sisastok_Igd_Jkn_04,
								SUM(Sisastok_Ranap_Jkn_04) AS Sisastok_Ranap_Jkn_04,
								SUM(Sisastok_Poned_Jkn_04) AS Sisastok_Poned_Jkn_04,
								SUM(Sisastok_Pustu_Jkn_04) AS Sisastok_Pustu_Jkn_04,
								SUM(Sisastok_Pusling_Jkn_04) AS Sisastok_Pusling_Jkn_04,
								SUM(Sisastok_Poli_Jkn_04) AS Sisastok_Poli_Jkn_04,
								SUM(Sisastok_Lainnya_Jkn_04) AS Sisastok_Lainnya_Jkn_04,
								SUM(Sisastok_Gudang_Apbd_05) AS Sisastok_Gudang_Apbd_05,
								SUM(Sisastok_Depot_Apbd_05) AS Sisastok_Depot_Apbd_05,
								SUM(Sisastok_Igd_Apbd_05) AS Sisastok_Igd_Apbd_05,
								SUM(Sisastok_Ranap_Apbd_05) AS Sisastok_Ranap_Apbd_05,
								SUM(Sisastok_Poned_Apbd_05) AS Sisastok_Poned_Apbd_05,
								SUM(Sisastok_Pustu_Apbd_05) AS Sisastok_Pustu_Apbd_05,
								SUM(Sisastok_Pusling_Apbd_05) AS Sisastok_Pusling_Apbd_05,
								SUM(Sisastok_Poli_Apbd_05) AS Sisastok_Poli_Apbd_05,
								SUM(Sisastok_Lainnya_Apbd_05) AS Sisastok_Lainnya_Apbd_05,
								SUM(Sisastok_Gudang_Jkn_05) AS Sisastok_Gudang_Jkn_05,
								SUM(Sisastok_Depot_Jkn_05) AS Sisastok_Depot_Jkn_05,
								SUM(Sisastok_Igd_Jkn_05) AS Sisastok_Igd_Jkn_05,
								SUM(Sisastok_Ranap_Jkn_05) AS Sisastok_Ranap_Jkn_05,
								SUM(Sisastok_Poned_Jkn_05) AS Sisastok_Poned_Jkn_05,
								SUM(Sisastok_Pustu_Jkn_05) AS Sisastok_Pustu_Jkn_05,
								SUM(Sisastok_Pusling_Jkn_05) AS Sisastok_Pusling_Jkn_05,
								SUM(Sisastok_Poli_Jkn_05) AS Sisastok_Poli_Jkn_05,
								SUM(Sisastok_Lainnya_Jkn_05) AS Sisastok_Lainnya_Jkn_05,
								SUM(Sisastok_Gudang_Apbd_06) AS Sisastok_Gudang_Apbd_06,
								SUM(Sisastok_Depot_Apbd_06) AS Sisastok_Depot_Apbd_06,
								SUM(Sisastok_Igd_Apbd_06) AS Sisastok_Igd_Apbd_06,
								SUM(Sisastok_Ranap_Apbd_06) AS Sisastok_Ranap_Apbd_06,
								SUM(Sisastok_Poned_Apbd_06) AS Sisastok_Poned_Apbd_06,
								SUM(Sisastok_Pustu_Apbd_06) AS Sisastok_Pustu_Apbd_06,
								SUM(Sisastok_Pusling_Apbd_06) AS Sisastok_Pusling_Apbd_06,
								SUM(Sisastok_Poli_Apbd_06) AS Sisastok_Poli_Apbd_06,
								SUM(Sisastok_Lainnya_Apbd_06) AS Sisastok_Lainnya_Apbd_06,
								SUM(Sisastok_Gudang_Jkn_06) AS Sisastok_Gudang_Jkn_06,
								SUM(Sisastok_Depot_Jkn_06) AS Sisastok_Depot_Jkn_06,
								SUM(Sisastok_Igd_Jkn_06) AS Sisastok_Igd_Jkn_06,
								SUM(Sisastok_Ranap_Jkn_06) AS Sisastok_Ranap_Jkn_06,
								SUM(Sisastok_Poned_Jkn_06) AS Sisastok_Poned_Jkn_06,
								SUM(Sisastok_Pustu_Jkn_06) AS Sisastok_Pustu_Jkn_06,
								SUM(Sisastok_Pusling_Jkn_06) AS Sisastok_Pusling_Jkn_06,
								SUM(Sisastok_Poli_Jkn_06) AS Sisastok_Poli_Jkn_06,
								SUM(Sisastok_Lainnya_Jkn_06) AS Sisastok_Lainnya_Jkn_06,
								SUM(Sisastok_Gudang_Apbd_07) AS Sisastok_Gudang_Apbd_07,
								SUM(Sisastok_Depot_Apbd_07) AS Sisastok_Depot_Apbd_07,
								SUM(Sisastok_Igd_Apbd_07) AS Sisastok_Igd_Apbd_07,
								SUM(Sisastok_Ranap_Apbd_07) AS Sisastok_Ranap_Apbd_07,
								SUM(Sisastok_Poned_Apbd_07) AS Sisastok_Poned_Apbd_07,
								SUM(Sisastok_Pustu_Apbd_07) AS Sisastok_Pustu_Apbd_07,
								SUM(Sisastok_Pusling_Apbd_07) AS Sisastok_Pusling_Apbd_07,
								SUM(Sisastok_Poli_Apbd_07) AS Sisastok_Poli_Apbd_07,
								SUM(Sisastok_Lainnya_Apbd_07) AS Sisastok_Lainnya_Apbd_07,
								SUM(Sisastok_Gudang_Jkn_07) AS Sisastok_Gudang_Jkn_07,
								SUM(Sisastok_Depot_Jkn_07) AS Sisastok_Depot_Jkn_07,
								SUM(Sisastok_Igd_Jkn_07) AS Sisastok_Igd_Jkn_07,
								SUM(Sisastok_Ranap_Jkn_07) AS Sisastok_Ranap_Jkn_07,
								SUM(Sisastok_Poned_Jkn_07) AS Sisastok_Poned_Jkn_07,
								SUM(Sisastok_Pustu_Jkn_07) AS Sisastok_Pustu_Jkn_07,
								SUM(Sisastok_Pusling_Jkn_07) AS Sisastok_Pusling_Jkn_07,
								SUM(Sisastok_Poli_Jkn_07) AS Sisastok_Poli_Jkn_07,
								SUM(Sisastok_Lainnya_Jkn_07) AS Sisastok_Lainnya_Jkn_07,
								SUM(Sisastok_Gudang_Apbd_08) AS Sisastok_Gudang_Apbd_08,
								SUM(Sisastok_Depot_Apbd_08) AS Sisastok_Depot_Apbd_08,
								SUM(Sisastok_Igd_Apbd_08) AS Sisastok_Igd_Apbd_08,
								SUM(Sisastok_Ranap_Apbd_08) AS Sisastok_Ranap_Apbd_08,
								SUM(Sisastok_Poned_Apbd_08) AS Sisastok_Poned_Apbd_08,
								SUM(Sisastok_Pustu_Apbd_08) AS Sisastok_Pustu_Apbd_08,
								SUM(Sisastok_Pusling_Apbd_08) AS Sisastok_Pusling_Apbd_08,
								SUM(Sisastok_Poli_Apbd_08) AS Sisastok_Poli_Apbd_08,
								SUM(Sisastok_Lainnya_Apbd_08) AS Sisastok_Lainnya_Apbd_08,
								SUM(Sisastok_Gudang_Jkn_08) AS Sisastok_Gudang_Jkn_08,
								SUM(Sisastok_Depot_Jkn_08) AS Sisastok_Depot_Jkn_08,
								SUM(Sisastok_Igd_Jkn_08) AS Sisastok_Igd_Jkn_08,
								SUM(Sisastok_Ranap_Jkn_08) AS Sisastok_Ranap_Jkn_08,
								SUM(Sisastok_Poned_Jkn_08) AS Sisastok_Poned_Jkn_08,
								SUM(Sisastok_Pustu_Jkn_08) AS Sisastok_Pustu_Jkn_08,
								SUM(Sisastok_Pusling_Jkn_08) AS Sisastok_Pusling_Jkn_08,
								SUM(Sisastok_Poli_Jkn_08) AS Sisastok_Poli_Jkn_08,
								SUM(Sisastok_Lainnya_Jkn_08) AS Sisastok_Lainnya_Jkn_08,
								SUM(Sisastok_Gudang_Apbd_09) AS Sisastok_Gudang_Apbd_09,
								SUM(Sisastok_Depot_Apbd_09) AS Sisastok_Depot_Apbd_09,
								SUM(Sisastok_Igd_Apbd_09) AS Sisastok_Igd_Apbd_09,
								SUM(Sisastok_Ranap_Apbd_09) AS Sisastok_Ranap_Apbd_09,
								SUM(Sisastok_Poned_Apbd_09) AS Sisastok_Poned_Apbd_09,
								SUM(Sisastok_Pustu_Apbd_09) AS Sisastok_Pustu_Apbd_09,
								SUM(Sisastok_Pusling_Apbd_09) AS Sisastok_Pusling_Apbd_09,
								SUM(Sisastok_Poli_Apbd_09) AS Sisastok_Poli_Apbd_09,
								SUM(Sisastok_Lainnya_Apbd_09) AS Sisastok_Lainnya_Apbd_09,
								SUM(Sisastok_Gudang_Jkn_09) AS Sisastok_Gudang_Jkn_09,
								SUM(Sisastok_Depot_Jkn_09) AS Sisastok_Depot_Jkn_09,
								SUM(Sisastok_Igd_Jkn_09) AS Sisastok_Igd_Jkn_09,
								SUM(Sisastok_Ranap_Jkn_09) AS Sisastok_Ranap_Jkn_09,
								SUM(Sisastok_Poned_Jkn_09) AS Sisastok_Poned_Jkn_09,
								SUM(Sisastok_Pustu_Jkn_09) AS Sisastok_Pustu_Jkn_09,
								SUM(Sisastok_Pusling_Jkn_09) AS Sisastok_Pusling_Jkn_09,
								SUM(Sisastok_Poli_Jkn_09) AS Sisastok_Poli_Jkn_09,
								SUM(Sisastok_Lainnya_Jkn_09) AS Sisastok_Lainnya_Jkn_09,
								SUM(Sisastok_Gudang_Apbd_10) AS Sisastok_Gudang_Apbd_10,
								SUM(Sisastok_Depot_Apbd_10) AS Sisastok_Depot_Apbd_10,
								SUM(Sisastok_Igd_Apbd_10) AS Sisastok_Igd_Apbd_10,
								SUM(Sisastok_Ranap_Apbd_10) AS Sisastok_Ranap_Apbd_10,
								SUM(Sisastok_Poned_Apbd_10) AS Sisastok_Poned_Apbd_10,
								SUM(Sisastok_Pustu_Apbd_10) AS Sisastok_Pustu_Apbd_10,
								SUM(Sisastok_Pusling_Apbd_10) AS Sisastok_Pusling_Apbd_10,
								SUM(Sisastok_Poli_Apbd_10) AS Sisastok_Poli_Apbd_10,
								SUM(Sisastok_Lainnya_Apbd_10) AS Sisastok_Lainnya_Apbd_10,
								SUM(Sisastok_Gudang_Jkn_10) AS Sisastok_Gudang_Jkn_10,
								SUM(Sisastok_Depot_Jkn_10) AS Sisastok_Depot_Jkn_10,
								SUM(Sisastok_Igd_Jkn_10) AS Sisastok_Igd_Jkn_10,
								SUM(Sisastok_Ranap_Jkn_10) AS Sisastok_Ranap_Jkn_10,
								SUM(Sisastok_Poned_Jkn_10) AS Sisastok_Poned_Jkn_10,
								SUM(Sisastok_Pustu_Jkn_10) AS Sisastok_Pustu_Jkn_10,
								SUM(Sisastok_Pusling_Jkn_10) AS Sisastok_Pusling_Jkn_10,
								SUM(Sisastok_Poli_Jkn_10) AS Sisastok_Poli_Jkn_10,
								SUM(Sisastok_Lainnya_Jkn_10) AS Sisastok_Lainnya_Jkn_10,
								SUM(Sisastok_Gudang_Apbd_11) AS Sisastok_Gudang_Apbd_11,
								SUM(Sisastok_Depot_Apbd_11) AS Sisastok_Depot_Apbd_11,
								SUM(Sisastok_Igd_Apbd_11) AS Sisastok_Igd_Apbd_11,
								SUM(Sisastok_Ranap_Apbd_11) AS Sisastok_Ranap_Apbd_11,
								SUM(Sisastok_Poned_Apbd_11) AS Sisastok_Poned_Apbd_11,
								SUM(Sisastok_Pustu_Apbd_11) AS Sisastok_Pustu_Apbd_11,
								SUM(Sisastok_Pusling_Apbd_11) AS Sisastok_Pusling_Apbd_11,
								SUM(Sisastok_Poli_Apbd_11) AS Sisastok_Poli_Apbd_11,
								SUM(Sisastok_Lainnya_Apbd_11) AS Sisastok_Lainnya_Apbd_11,
								SUM(Sisastok_Gudang_Jkn_11) AS Sisastok_Gudang_Jkn_11,
								SUM(Sisastok_Depot_Jkn_11) AS Sisastok_Depot_Jkn_11,
								SUM(Sisastok_Igd_Jkn_11) AS Sisastok_Igd_Jkn_11,
								SUM(Sisastok_Ranap_Jkn_11) AS Sisastok_Ranap_Jkn_11,
								SUM(Sisastok_Poned_Jkn_11) AS Sisastok_Poned_Jkn_11,
								SUM(Sisastok_Pustu_Jkn_11) AS Sisastok_Pustu_Jkn_11,
								SUM(Sisastok_Pusling_Jkn_11) AS Sisastok_Pusling_Jkn_11,
								SUM(Sisastok_Poli_Jkn_11) AS Sisastok_Poli_Jkn_11,
								SUM(Sisastok_Lainnya_Jkn_11) AS Sisastok_Lainnya_Jkn_11,
								SUM(Sisastok_Gudang_Apbd_12) AS Sisastok_Gudang_Apbd_12,
								SUM(Sisastok_Depot_Apbd_12) AS Sisastok_Depot_Apbd_12,
								SUM(Sisastok_Igd_Apbd_12) AS Sisastok_Igd_Apbd_12,
								SUM(Sisastok_Ranap_Apbd_12) AS Sisastok_Ranap_Apbd_12,
								SUM(Sisastok_Poned_Apbd_12) AS Sisastok_Poned_Apbd_12,
								SUM(Sisastok_Pustu_Apbd_12) AS Sisastok_Pustu_Apbd_12,
								SUM(Sisastok_Pusling_Apbd_12) AS Sisastok_Pusling_Apbd_12,
								SUM(Sisastok_Poli_Apbd_12) AS Sisastok_Poli_Apbd_12,
								SUM(Sisastok_Lainnya_Apbd_12) AS Sisastok_Lainnya_Apbd_12,
								SUM(Sisastok_Gudang_Jkn_12) AS Sisastok_Gudang_Jkn_12,
								SUM(Sisastok_Depot_Jkn_12) AS Sisastok_Depot_Jkn_12,
								SUM(Sisastok_Igd_Jkn_12) AS Sisastok_Igd_Jkn_12,
								SUM(Sisastok_Ranap_Jkn_12) AS Sisastok_Ranap_Jkn_12,
								SUM(Sisastok_Poned_Jkn_12) AS Sisastok_Poned_Jkn_12,
								SUM(Sisastok_Pustu_Jkn_12) AS Sisastok_Pustu_Jkn_12,
								SUM(Sisastok_Pusling_Jkn_12) AS Sisastok_Pusling_Jkn_12,
								SUM(Sisastok_Poli_Jkn_12) AS Sisastok_Poli_Jkn_12,
								SUM(Sisastok_Lainnya_Jkn_12) AS Sisastok_Lainnya_Jkn_12
								FROM `tbstokopnam_puskesmas_all_group` 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
								// echo $strsopkm;
								$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
								$harga_jkn = $dtstokopname['HargaJkn'];
								
								// rko
								$strrkopkm = "SELECT `Tahun`,`KodeBarang`,
								SUM(RencanaPembelian) AS RencanaPembelian
								FROM `tbrko_puskesmas_all_group` 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
								$dtrkopkm = mysqli_fetch_assoc(mysqli_query($koneksi, $strrkopkm));
								
								
							}else{
								// perpuskesmas
								$strsopkm = "SELECT * FROM `$tbstokopnam` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun1'";
								$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
								$harga_jkn = $dtstokopname['HargaJkn'];
								
								// rko
								$strrkopkm = "SELECT `Tahun`,`KodeBarang`, `RencanaPembelian`
								FROM `$tbrko` 
								WHERE `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
								$dtrkopkm = mysqli_fetch_assoc(mysqli_query($koneksi, $strrkopkm));
							}	
							
							// hargabeli
							$hargabeli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY `IdBarang` DESC"));
							
							// tahap 1, stok awal
							$strsopkm = "SELECT * FROM `$tbstokopnam` WHERE `Tahun`='$tahun1' AND `KodeBarang`='$kodebarang'";
							// echo $strsopkm;
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
							$stokawal = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
							
							// tahap 2, penerimaan
							if($data['NamaProgram'] != "VAKSIN"){
								$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							}else{
								$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
								$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							}
							
							$total_penerimaan_apbd = $penerimaan_apbd_01['Jumlah'] + $penerimaan_apbd_02['Jumlah'] + $penerimaan_apbd_03['Jumlah'] + $penerimaan_apbd_04['Jumlah'] + $penerimaan_apbd_05['Jumlah'] + $penerimaan_apbd_06['Jumlah'] + $penerimaan_apbd_07['Jumlah'] + $penerimaan_apbd_08['Jumlah'] + $penerimaan_apbd_09['Jumlah'] + $penerimaan_apbd_10['Jumlah'] + $penerimaan_apbd_11['Jumlah'] + $penerimaan_apbd_12['Jumlah'];
							$total_penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'] + $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'] + $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'] + $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
							$total_penerimaan = $total_penerimaan_apbd + $total_penerimaan_jkn;
							
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
							$pemakaian_apbd_01 = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$pemakaian_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							
							// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
							$pemakaian_apbd_02 = $total_sisastok_apbd_01 + $penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$pemakaian_jkn_02 = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$pemakaian_apbd_03 = $total_sisastok_apbd_02 + $penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$pemakaian_jkn_03 = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$pemakaian_apbd_04 = $total_sisastok_apbd_03 + $penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$pemakaian_jkn_04 = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$pemakaian_apbd_05 = $total_sisastok_apbd_04 + $penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$pemakaian_jkn_05 = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$pemakaian_apbd_06 = $total_sisastok_apbd_05 + $penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$pemakaian_jkn_06 = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							$pemakaian_apbd_07 = $total_sisastok_apbd_06 + $penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$pemakaian_jkn_07 = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$pemakaian_apbd_08 = $total_sisastok_apbd_07 + $penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$pemakaian_jkn_08 = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$pemakaian_apbd_09 = $total_sisastok_apbd_08 + $penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$pemakaian_jkn_09 = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$pemakaian_apbd_10 = $total_sisastok_apbd_09 + $penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$pemakaian_jkn_10 = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$pemakaian_apbd_11 = $total_sisastok_apbd_10 + $penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$pemakaian_jkn_11 = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$pemakaian_apbd_12 = $total_sisastok_apbd_11 + $penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$pemakaian_jkn_12 = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
							
							// total pemakaian apbd	
							$pemakaian_apbd = $pemakaian_apbd_01 + $pemakaian_apbd_02 + $pemakaian_apbd_03 + $pemakaian_apbd_04 + $pemakaian_apbd_05 + $pemakaian_apbd_06 + $pemakaian_apbd_07 + $pemakaian_apbd_08 + $pemakaian_apbd_09 + $pemakaian_apbd_10 + $pemakaian_apbd_11 + $pemakaian_apbd_12;
							$pemakaian_jkn = $pemakaian_jkn_01 + $pemakaian_jkn_02 + $pemakaian_jkn_03 + $pemakaian_jkn_04 + $pemakaian_jkn_05 + $pemakaian_jkn_06 + $pemakaian_jkn_07 + $pemakaian_jkn_08 + $pemakaian_jkn_09 + $pemakaian_jkn_10 + $pemakaian_jkn_11 + $pemakaian_jkn_12;
							$jumlahkeluar = $pemakaian_apbd + $pemakaian_jkn;
							
							// persediaan
							$persediaan = $total_penerimaan + $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
							
							// sisa stok
							$sisastok = $persediaan - $jumlahkeluar;
							
							// bulan pemakaian							
							$bulanpemakaian_01 = $total_sisastok_apbd_01 + $total_sisastok_jkn_01;
							$bulanpemakaian_02 = $total_sisastok_apbd_02 + $total_sisastok_jkn_02;
							$bulanpemakaian_03 = $total_sisastok_apbd_03 + $total_sisastok_jkn_03;
							$bulanpemakaian_04 = $total_sisastok_apbd_04 + $total_sisastok_jkn_04;
							$bulanpemakaian_05 = $total_sisastok_apbd_05 + $total_sisastok_jkn_05;
							$bulanpemakaian_06 = $total_sisastok_apbd_06 + $total_sisastok_jkn_06;
							$bulanpemakaian_07 = $total_sisastok_apbd_07 + $total_sisastok_jkn_07;
							$bulanpemakaian_08 = $total_sisastok_apbd_08 + $total_sisastok_jkn_08;
							$bulanpemakaian_09 = $total_sisastok_apbd_09 + $total_sisastok_jkn_09;
							$bulanpemakaian_10 = $total_sisastok_apbd_10 + $total_sisastok_jkn_10;
							$bulanpemakaian_11 = $total_sisastok_apbd_11 + $total_sisastok_jkn_11;
							$bulanpemakaian_12 = $total_sisastok_apbd_12 + $total_sisastok_jkn_12;
							if($bulanpemakaian_01 > 0){ $bulanpemakaian_01 = 1; }else{ $bulanpemakaian_01 = 0; }
							if($bulanpemakaian_02 > 0){ $bulanpemakaian_02 = 1; }else{ $bulanpemakaian_02 = 0; }
							if($bulanpemakaian_03 > 0){ $bulanpemakaian_03 = 1; }else{ $bulanpemakaian_03 = 0; }
							if($bulanpemakaian_04 > 0){ $bulanpemakaian_04 = 1; }else{ $bulanpemakaian_04 = 0; }
							if($bulanpemakaian_05 > 0){ $bulanpemakaian_05 = 1; }else{ $bulanpemakaian_05 = 0; }
							if($bulanpemakaian_06 > 0){ $bulanpemakaian_06 = 1; }else{ $bulanpemakaian_06 = 0; }
							if($bulanpemakaian_07 > 0){ $bulanpemakaian_07 = 1; }else{ $bulanpemakaian_07 = 0; }
							if($bulanpemakaian_08 > 0){ $bulanpemakaian_08 = 1; }else{ $bulanpemakaian_08 = 0; }
							if($bulanpemakaian_09 > 0){ $bulanpemakaian_09 = 1; }else{ $bulanpemakaian_09 = 0; }
							if($bulanpemakaian_10 > 0){ $bulanpemakaian_10 = 1; }else{ $bulanpemakaian_10 = 0; }
							if($bulanpemakaian_11 > 0){ $bulanpemakaian_11 = 1; }else{ $bulanpemakaian_11 = 0; }
							if($bulanpemakaian_12 > 0){ $bulanpemakaian_12 = 1; }else{ $bulanpemakaian_12 = 0; }
							$bulanpemakaian = $bulanpemakaian_01 + $bulanpemakaian_02 + $bulanpemakaian_03 + $bulanpemakaian_04 + $bulanpemakaian_05 + $bulanpemakaian_06 + $bulanpemakaian_07 + $bulanpemakaian_08 + $bulanpemakaian_09 + $bulanpemakaian_10 + $bulanpemakaian_11 + $bulanpemakaian_12;
							// echo $bulanpemakaian;
							
							// pemakaian rata-rata
							$pemakaianrata = $jumlahkeluar / $bulanpemakaian;
							
							// jumlah kebutuhan
							$jumlahkebutuhan = $pemakaianrata * 18 - $sisastok;
							
							// rencana kebutuhan
							if($jumlahkebutuhan == 0){
								$rencanakebutuhan_apbd = $sisastok;
								$rencanakebutuhan_jkn = $sisastok;
							}else{	
								$rencanakebutuhan_apbd = $jumlahkebutuhan * 30 / 100;
								$rencanakebutuhan_jkn = $jumlahkebutuhan * 70 / 100;
							}
							
							// total rupiah rko
							$totalrupiahrko_apbd = $rencanakebutuhan_apbd * $hargabeli['HargaBeli'];
							$totalrupiahrko_jkn = $rencanakebutuhan_jkn * $hargabeli['HargaBeli'];
							
							?>
							<tr>
								<td style="text-align:right;"><?php echo $no;?></td>
								<td style="text-align:left;" class="namabarangcls"><?php echo strtoupper($namabarang);?></td>
								<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right;"><?php echo rupiah($hargabeli['HargaBeli']);?></td>
								<td style="text-align:right;"><?php echo rupiah($stokawal);?></td><!--Stokawal-->
								<td style="text-align:right;"><?php echo rupiah($total_penerimaan);?></td><!--Penerimaan-->
								<td style="text-align:right;">
								<?php 
									// persediaan
									$persediaan = $total_penerimaan + $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
									if($persediaan != 0){
										echo rupiah($persediaan);
									}else{
										echo "";
									}
								?>
								</td>
								<td style="text-align:right;"><?php echo rupiah($jumlahkeluar);?></td><!--Pemakaian-->
								<td style="text-align:right;"><?php echo rupiah($sisastok);?></td><!--Sisa Stok-->
								<td style="text-align:right;"><?php echo $bulanpemakaian;?></td><!--Jumlah Bulan Pemakaian-->
								<td style="text-align:right;"><?php echo rupiah(ceil($pemakaianrata));?></td><!--Pemakaian Rata2 PerBulan-->
								<td style="text-align:right;"><?php echo rupiah(ceil($jumlahkebutuhan));?></td><!--Jumlah Kebutuhan-->
								<td style="text-align:right;"><?php echo rupiah(ceil($rencanakebutuhan_apbd));?></td><!--Rencana Kebutuhan Obat-->
								<td style="text-align:right;"><?php echo rupiah(ceil($rencanakebutuhan_jkn));?></td>
								<td style="text-align:right;"><?php echo rupiah($totalrupiahrko_apbd);?></td><!--Total Rupiah RKO-->
								<td style="text-align:right;"><?php echo rupiah($totalrupiahrko_jkn);?></td>
								<td style="text-align:center;"><!--Rencana Pembelian-->
								<?php 
									$strrko = "SELECT * FROM `$tbrko` WHERE `Tahun`='$tahun' AND `KodeBarang`='$data[KodeBarang]'";
									$datarko = mysqli_fetch_assoc(mysqli_query($koneksi, $strrko));
									echo $datarko['RencanaPembelian'];
								?>
								</td>
								<td style="text-align:center;"><!--Total Rupiah Pembelian-->
									<?php
										 $totalrupiah = $datarko['RencanaPembelian'] * $hargabeli['HargaBeli'];
										 echo rupiah($totalrupiah);
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
						echo "<li><a href='?page=lap_farmasi_rko_bogorkab_all&tahun=$tahun&namaprogram=$_GET[namaprogram]&namapuskesmas=$namapuskesmas&kodepuskesmas=$kodepuskesmas&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<br/>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b><br>
				- Nama Barang, group tampilkan 1 barang saja<br/>
				- Harga Satuan, harga terakhir yang ada di Sistem<br/>
				- Stok Akhir, misal rko 2021 stok awal adalah stok akhir desember 2019<br/>
				- Penerimaan, misal rko 2021 maka penerimaan selama 2019<br/>
				- Persediaan, stok awal ditambah penerimaan<br/>
				- Pemakaian, misal rko 2021 maka pemakaian selama 2019<br/>
				- Sisa Stok, persediaan dikurang pemakaian<br/>
				- Bulan Pemakaian, jumlah bulan yang ada pemakaian<br/>
				- Pemakaian Rata-rata, pemakaian dibagi jumlah bulan pemakaian<br/>
				- Jumlah Kebutuhan, pemakaian rata-rata dikali 18 bulan dikurangi sisa stok<br/>
				- Rencana Kebutuhan, jumlah kebutuhan dikurang sisa stok<br/>
				- Total Rupiah RKO, rencana kebutuhan dikali harga satuan<br/>
				- Rencana Pembelian dan Total Rupiah Pembelian, diisi manual<br/>
				</p>
			</div>
		</div>
	</div>
	<?php 
		} 
	?>
</div>	
