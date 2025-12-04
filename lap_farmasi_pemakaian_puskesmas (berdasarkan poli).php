<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
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
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PEMAKAIAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_pemakaian_puskesmas"/>
						<div class="col-sm-2" style="width:150px">
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
						<div class="col-sm-2" style="width:150px">
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
								<span class="input-group-addon">Program</span>
							</div>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_pemakaian_puskesmas" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_pemakaian_puskesmas_excel.php?namaprg=<?php echo $_GET['namaprg'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
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
		$array_bln = array('00','JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive text-nowrap">
				<!--<table class="table-judul-laporan-min table-fixed">-->
				<table class="table-judul-laporan-min" style="width:1800px;">
					<thead>
						<tr>
							<th rowspan="3" width="3%">NO.</th>
							<th rowspan="3" width="22%">NAMA OBAT & BMHP</th>
							<th rowspan="3">SATUAN</th>
							<th rowspan="3">HARGA<br/>SATUAN</th>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th colspan='18'>".$array_bln[$b]."</th>";
								}
							?>
							<th rowspan="3">PEMAKAIAN<br/>RATA-RATA</th>
							<th rowspan="3">TOTAL PEMAKAIAN</th>
						</tr>
						<tr>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th colspan='2'>"."GUDANG"."</th>";
									echo "<th colspan='2'>"."DEPOT"."</th>";
									echo "<th colspan='2'>"."IGD"."</th>";
									echo "<th colspan='2'>"."RANAP"."</th>";
									echo "<th colspan='2'>"."PONED"."</th>";
									echo "<th colspan='2'>"."PUSTU"."</th>";
									echo "<th colspan='2'>"."PUSLING"."</th>";
									echo "<th colspan='2'>"."POLI"."</th>";
									echo "<th colspan='2'>"."LAINNYA"."</th>";
								}
							?>
						</tr>
						<tr>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
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
													
							$str = "SELECT * FROM `ref_obat_lplpo`".$namaprg;
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
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='115'>$data[NamaProgram]</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								
								$no = $no + 1;
								$IdBarangPkm = $data['IdStokBulan'];
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$satuan = $data['Satuan'];
								
								// tbgfkstok
								$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli`,`Expire`,`NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'  ORDER BY IdBarang DESC"));
								$harga = $dtgfk['HargaBeli'];
								if(empty($harga)){$harga = "0";}
								
								// pemakaian
								// gudang apbd
								$gudang_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// gudang jkn
								$gudang_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$gudang_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Gudang_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// depot apbd
								$depot_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// depot jkn
								$depot_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$depot_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Depot_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// igd apbd
								$igd_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// igd jkn
								$igd_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$igd_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Igd_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// ranap apbd
								$ranap_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// ranap jkn
								$ranap_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$ranap_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Ranap_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// poned apbd
								$poned_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// poned jkn
								$poned_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poned_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poned_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// pustu apbd
								$pustu_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// pustu jkn
								$pustu_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pustu_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pustu_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// pusling apbd
								$pusling_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// pusling jkn
								$pusling_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$pusling_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Pusling_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// poli apbd
								$poli_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// poli jkn
								$poli_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$poli_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Poli_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// lainnya apbd
								$lainnya_bln_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Apbd_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								// lainnya jkn
								$lainnya_bln_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_01` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_02` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_03` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_04` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_05` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_06` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_07` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_08` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_09` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_10` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_11` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								$lainnya_bln_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pemakaian_Lainnya_Jkn_12` AS Jumlah FROM tbstokopnam_puskesmas_detail WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'"));
								//$total = $total_resep + $total_gudang;
						?>
								<tr>
									<td align="center"><?php echo $no;?></td>										
									<td class="namabarangcls" align="left"><?php echo strtoupper($data['NamaBarang']);?></td>									
									<td align="center"><?php echo $satuan;?></td>
									<td align="right"><?php echo rupiah($harga);?></td>
									<?php
									for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
										$total_gudang_apbd[$no][] = $gudang_bln_apbd[$b]['Jumlah'];
										$total_gudang_jkn[$no][] = $gudang_bln_jkn[$b]['Jumlah'];
										$total_depot_apbd[$no][] = $depot_bln_apbd[$b]['Jumlah'];
										$total_depot_jkn[$no][] = $depot_bln_jkn[$b]['Jumlah'];
										$total_igd_apbd[$no][] = $igd_bln_apbd[$b]['Jumlah'];
										$total_igd_jkn[$no][] = $igd_bln_jkn[$b]['Jumlah'];
										$total_ranap_apbd[$no][] = $ranap_bln_apbd[$b]['Jumlah'];
										$total_ranap_jkn[$no][] = $ranap_bln_jkn[$b]['Jumlah'];
										$total_poned_apbd[$no][] = $poned_bln_apbd[$b]['Jumlah'];
										$total_poned_jkn[$no][] = $poned_bln_jkn[$b]['Jumlah'];
										$total_pustu_apbd[$no][] = $pustu_bln_apbd[$b]['Jumlah'];
										$total_pustu_jkn[$no][] = $pustu_bln_jkn[$b]['Jumlah'];
										$total_pusling_apbd[$no][] = $pusling_bln_apbd[$b]['Jumlah'];
										$total_pusling_jkn[$no][] = $pusling_bln_jkn[$b]['Jumlah'];
										$total_poli_apbd[$no][] = $poli_bln_apbd[$b]['Jumlah'];
										$total_poli_jkn[$no][] = $poli_bln_jkn[$b]['Jumlah'];
										$total_lainnya_apbd[$no][] = $lainnya_bln_apbd[$b]['Jumlah'];
										$total_lainnya_jkn[$no][] = $lainnya_bln_jkn[$b]['Jumlah'];
									?>	
									<td align="right">
									<?php 
										// gudang apbd
										if($gudang_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($gudang_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// gudang jkn
										if($gudang_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($gudang_bln_jkn[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// depot apbd
										if($depot_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($depot_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// depot jkn
										if($depot_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($depot_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// igd apbd
										if($igd_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($igd_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// igd jkn
										if($igd_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($igd_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// ranap apbd
										if($ranap_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($ranap_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// ranap jkn
										if($ranap_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($ranap_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// poned apbd
										if($poned_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($poned_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// poned jkn
										if($poned_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($poned_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// pustu apbd
										if($pustu_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($pustu_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// pustu jkn
										if($pustu_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($pustu_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// pusling apbd
										if($pusling_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($pusling_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// pusling jkn
										if($pusling_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($pusling_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// poli apbd
										if($poli_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($poli_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// poli jkn
										if($poli_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($poli_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>
									<td align="right">
									<?php 
										// lainnya apbd
										if($lainnya_bln_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($lainnya_bln_apbd[$b]['Jumlah']);
										}
									?>
									</td>
									<td align="right">
									<?php 
										// lainnya jkn
										if($lainnya_bln_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($lainnya_bln_jkn[$b]['Jumlah']);
										}
									?>	
									</td>	
									<?php
										}
										$ttl_gudang_apbd = array_sum($total_gudang_apbd[$no]);
										$ttl_gudang_jkn = array_sum($total_gudang_jkn[$no]);
										$ttl_depot_apbd = array_sum($total_depot_apbd[$no]);
										$ttl_depot_jkn = array_sum($total_depot_jkn[$no]);
										$ttl_igd_apbd = array_sum($total_igd_apbd[$no]);
										$ttl_igd_jkn = array_sum($total_igd_jkn[$no]);
										$ttl_ranap_apbd = array_sum($total_ranap_apbd[$no]);
										$ttl_ranap_jkn = array_sum($total_ranap_jkn[$no]);
										$ttl_poned_apbd = array_sum($total_poned_apbd[$no]);
										$ttl_poned_jkn = array_sum($total_poned_jkn[$no]);
										$ttl_pustu_apbd = array_sum($total_pustu_apbd[$no]);
										$ttl_pustu_jkn = array_sum($total_pustu_jkn[$no]);
										$ttl_pusling_apbd = array_sum($total_pusling_apbd[$no]);
										$ttl_pusling_jkn = array_sum($total_pusling_jkn[$no]);
										$ttl_poli_apbd = array_sum($total_poli_apbd[$no]);
										$ttl_poli_jkn = array_sum($total_poli_jkn[$no]);
										$ttl_lainnya_apbd = array_sum($total_lainnya_apbd[$no]);
										$ttl_lainnya_jkn = array_sum($total_lainnya_jkn[$no]);
										$ttl_pemakaian = $ttl_gudang_apbd + $ttl_gudang_jkn + $ttl_depot_apbd + $ttl_depot_jkn + $ttl_igd_apbd + $ttl_igd_jkn
										+ $ttl_ranap_apbd + $ttl_ranap_jkn + $ttl_poned_apbd + $ttl_poned_jkn + $ttl_pustu_apbd + $ttl_pustu_jkn + $ttl_pusling_apbd
										+ $ttl_pusling_jkn + $ttl_poli_apbd + $ttl_poli_jkn + $ttl_lainnya_apbd + $ttl_lainnya_jkn;
										$ttl_pemakaian_rata = $ttl_pemakaian / $bulanakhir;
									?>			
									<!--Pemakaian Rata2-->
									<td align="right"><?php echo $ttl_pemakaian_rata;?></td>
									<td align="right"><?php echo $ttl_pemakaian;?></td>	
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
						echo "<li><a href='?page=lap_farmasi_pemakaian_puskesmas&namaprg=$namaprg&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php } ?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					Laporan pemakaian ini diambil dari menu Import Data
				</p>
			</div>
		</div>
	</div>
</div>