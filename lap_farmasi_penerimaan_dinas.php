<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$namapuskesmas = $_GET['namapuskesmas'];
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PENERIMAAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_penerimaan_dinas"/>
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
						<div class="col-sm-6">
							<select name="namaprg" class="form-control">
								<option value='Semua'>Semua</option>
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
					</div>	
					<div class = "row" style="margin-top:10px;">
						<div class="col-sm-10">
							<input type="text" name="namapuskesmas" class="form-control puskesmas" placeholder="Nama Puskesmas" value="<?php echo $_GET['namapuskesmas'];?>" required>
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_penerimaan_dinas" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="lap_farmasi_penerimaan_dinas_print.php?namaprogram=<?php echo $_GET['namaprg'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-primary"><span class="fa fa-print"></span></a>
							<a href="lap_farmasi_penerimaan_dinas_excel.php?namaprg=<?php echo $_GET['namaprg'];?>&bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>-->
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
		$namaprg = $_GET['namaprg'];
		
		if($kodepuskesmas != ''){
		$array_bln = array('00','JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');	
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<?php if($bulanakhir > 6){ ?>
					<table class="table-judul-laporan-min" style="width:1800px;">
				<?php }else{ ?>
					<table class="table-judul-laporan-min" width="100%">
				<?php }?>
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<?php if($bulanakhir > 6){ ?>
								<th width="12%" rowspan="2">NAMA OBAT & BMHP</th>
							<?php }else{ ?>
								<th width="20%" rowspan="2">NAMA OBAT & BMHP</th>
							<?php }?>
							<th rowspan="2">SATUAN</th>
							<th rowspan="2">HARGA<br/>SATUAN</th>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th colspan='2'>".$array_bln[$b]."</th>";
								}
							?>
							<th colspan="2" width="10%">TOTAL</th>
							<th rowspan="2" width="10%">TOTAL<br/>PENERIMAAN</th>
							<th rowspan="2" width="10%">TOTAL<br/>HARGA</th>
						</tr>
						<tr>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th>"."APBD"."</th>";
									echo "<th>"."JKN"."</th>";
								}
							?>
							<th>APBD</th>
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
						
						if($namaprg == "Semua" || $namaprg == ""){
							$namaprg = "";
						}else{
							$namaprg = "WHERE NamaProgram = '$namaprg'";
						}
						
						// ref_obat_lplpo 					
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
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='35'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}	
						
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$satuan = $data['Satuan'];
							
							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli`,`Expire`,`NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY IdBarang DESC"));
							$harga = $dtgfk['HargaBeli'];
							if(empty($harga)){$harga = "0";}								
							
							// penerimaan
							if($data['NamaProgram'] != "VAKSIN"){
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
							
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>			
								<td class="namabarangcls" align="left"><?php echo strtoupper($namabarang);?></td>								
								<td align="center"><?php echo $satuan;?></td>
								<td align="right"><?php echo rupiah($harga);?></td>
								<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									$totalapbd[$no][] = $bln_penerimaan_apbd[$b]['Jumlah'];
									$totaljkn[$no][] = $bln_penerimaan_jkn[$b]['Jumlah'];
								?>		
								<td align="right">
									<?php 
										if($bln_penerimaan_apbd[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($bln_penerimaan_apbd[$b]['Jumlah']);
										}
									?>
								</td>
								<td align="right">
									<?php 
										if($bln_penerimaan_jkn[$b]['Jumlah'] == ""){
											echo "0";
										}else{
											echo rupiah($bln_penerimaan_jkn[$b]['Jumlah']);
										}
									?>
								</td>
								<?php
									}
									$total_apbd = array_sum($totalapbd[$no]);
									$total_jkn = array_sum($totaljkn[$no]);
									$total = $total_apbd + $total_jkn;
									$totalrupiah = $total * $harga;
								?>
								<td align="right"><?php echo rupiah($total_apbd);?></td>
								<td align="right"><?php echo rupiah($total_jkn);?></td>								
								<td align="right"><?php echo rupiah($total);?></td>		
								<td align="right"><?php echo rupiah($totalrupiah);?></td>			
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
						echo "<li><a href='?page=lap_farmasi_penerimaan_dinas&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&namaprg=$namaprg&h=$i'>$i</a></li>";
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
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Keterangan :</b><br/>
					- APBD (Penerimaan Dinkes)<br/>
					- JKN (Pengadaan di Puskesmas)
				</p>
			</div>
		</div>
	</div>
</div>	

