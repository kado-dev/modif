<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
// include "otoritas.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$kota = $_SESSION['kota'];
$alamat = $_SESSION['alamat'];
$tanggal = date('Y-m-d');
$tblplpomanual_bandungkab = "tblplpomanual_bandungkab_".$kodepuskesmas;
?>

<style type="text/css">
	.bulanheader{
		border-right: 1px solid #ddd;
		text-align: center;
		padding-left:0px;
		padding-right:0px;
	}
	.bulanheader:last-child{
		border-right: 0px solid #ddd;
		padding-right:15px;
	}
	.bulanheader:first-child{
		padding-left:15px;
	}

	.bulanheader h4{
		padding: 8px;font-size: 14px;
	}
	.bulanheader p{
		padding: 8px;font-size: 17px;margin:0px;
	}
	.bulanheader p a{
		display: block;
	}
	.clrwhite{
		background:#fff;
	}
	.clr_terisi{
		background: #4bc440;
	}
	.clr_kosong{
		background: #ff8e8e;
	}

	.bulanheader:last-child > .clr_terisi, .bulanheader:last-child > .clr_kosong{
		border-radius: 0px 0px 10px 0px;
	}

	.bulanheader:first-child > .clr_terisi, .bulanheader:first-child > .clr_kosong{
		border-radius: 0px 0px 0px 10px;
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LPLPO MANUAL</b></h3>
			<div class="formbg">
				
				
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_lplpo_manual"/>
						<div class="col-xl-2 bulanformcari">
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
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="sumberanggaran" class="form-control">
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD</option>
								<option value="JKN" <?php if($_GET['sumberanggaran'] == 'JKN'){echo "SELECTED";}?>>JKN</option>
							</select>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-xl-2">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-xl-5">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_lplpo_manual&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&h=<?php echo $_GET['h'];?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_farmasi_lplpo_manual_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-round btn-success">Download Template</a>
						</div>
					</div>	
				</form>
			</div>
			<?php 
				if($_GET['tahun']){ 
			?>
			<div class = "row">
				<?php
					$bulan_arry = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
					foreach ($bulan_arry as $key => $val) {
						$cekvalue = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tblplpomanual_bandungkab` WHERE `Tahun`='$_GET[tahun]' AND `Bulan`='$key' AND Pemakaian != '0'"));
				?>	
					<div class='col-sm-1 bulanheader'>
						<h4 class="clrwhite">
							<a href="?page=lap_farmasi_lplpo_manual&bulan=<?php echo $key;?>&tahun=<?php echo date('Y');?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>">
							<?php echo $val;?>
							</a>
						</h4>
						<p class="btnuploads <?php echo ($cekvalue == 0) ? 'clr_kosong ' : 'clr_terisi';?>">
							
								<?php
									if($cekvalue['SisaAkhir'] == 0){
										echo '<i class="fas fa-times-circle"></i>';
									}else{
										echo '<i class="fas fa-check-circle"></i>';
									}
								?>
							
						</p>
					</div>
				<?php
					}
				?>
			</div></br>
			<?php } ?>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$sumberanggaran = $_GET['sumberanggaran'];
	
	if($bulan == '01'){
		$blnsebelumnya= '12';
		$thnsebelumnya = $tahun - 1;
	}else{
		$blnsebelumnya = $bulan - 1;
		if(strlen($blnsebelumnya) == 1){
			$blnsebelumnya = '0'.$blnsebelumnya;
		}
		$thnsebelumnya = $tahun;
	}

	if(isset($bulan) and isset($tahun)){
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
		<form action="lap_farmasi_lplpo_manual_simpan.php" method="post">
			<input type="hidden" name="bulan" value="<?php echo $_GET['bulan'];?>"/>
			<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>"/>
			<input type="hidden" name="sumberanggaran" value="<?php echo $_GET['sumberanggaran'];?>"/>
			<!--<input type="submit" class="btn btn-info pull-right" style="margin-bottom: 7px" value="Simpan">-->
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan" width="100%">
						<thead>
							<tr>
								<th width="3%">NO.</th>
								<th width="5%">KODE</th>
								<th width="20%">NAMA BARANG</th>
								<th width="7%">SATUAN</th>
								<th width="7%">STOK <br/>AWAL</th>
								<th width="7%">PENERIMAAN</th>
								<th width="7%">PERSEDIAAN</th>
								<th width="6%">PEMAKAIAN</th>
								<th width="6%">SISA <br/>AKHIR</th>
								<th width="6%">STOK <br/>OPTIMUM</th>
								<th width="6%">PERMINTAAN</th>
								<th width="8%">PEMBERIAN</th>
								<th width="7%">KETERANGAN</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// ini buat insert pertama kali saja
							if ($sumberanggaran == 'APBD KAB/KOTA'){
								$query1 = mysqli_query($koneksi, "SELECT * FROM `$ref_obat_lplpo`");
								$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `$tblplpomanual_bandungkab` WHERE `Tahun`='$tahun' AND `Bulan`='$bulan' AND `SumberAnggaran`='APBD KAB/KOTA'"));
								$sumberanggaran = 'APBD KAB/KOTA';
							}else{
								$query1 = mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok`WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN') GROUP BY NamaBarang");
								$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `$tblplpomanual_bandungkab` WHERE `Tahun`='$tahun' AND `Bulan`='$bulan' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN')"));
								$sumberanggaran = 'JKN';
							}	
							
							if ($cek == 0){	
								while($data = mysqli_fetch_assoc($query1)){
									//get stok gudangpkm
									$str1 = "INSERT INTO `$tblplpomanual_bandungkab`(`KodePuskesmas`,`KodeBarang`,`Tahun`,`Bulan`,`SumberAnggaran`,`StokAwal`,`Penerimaan`,`Persediaan`,`Pemakaian`,`SisaAkhir`,`StokOptimum`,`Permintaan`,`Pemberian`,`Keterangan`) 
									VALUES ('$kodepuskesmas','$data[KodeBarang]','$tahun','$bulan','$sumberanggaran','0','0','0','0','0','0','0','0','0')";
									// echo $str1;
									mysqli_query($koneksi, $str1);
								}
							}
							
							// ini buat apa?
							$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbstokbulananpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
							if ($cek == 0){			
								$query1 = mysqli_query($koneksi, "SELECT * FROM `$ref_obat_lplpo`");
								while($data = mysqli_fetch_assoc($query1)){
									//get stok gudangpkm
									$str1 = "INSERT INTO `tbstokbulananpuskesmas`(`Bulan`,`Tahun`,`KodeBarang`,`NoBatch`,`StokLalu`,`Stok`,`Selisih`,`Keterangan`,`KodePuskesmas`) 
									VALUES ('$bulan','$tahun','$data[KodeBarang]','0','0','0','0','0','$kodepuskesmas')";
									mysqli_query($koneksi, $str1);
								}
							}
								
							$jumlah_perpage = 150;							
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}				
							
							// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
							if ($sumberanggaran == 'APBD KAB/KOTA'){ 
								$str = "SELECT * FROM `$ref_obat_lplpo`";
								$str2 = $str." ORDER BY `IdLplpo`, `NamaBarang` LIMIT $mulai,$jumlah_perpage";//`IdLplpo`,
							}elseif($sumberanggaran == 'BLUD' OR $sumberanggaran == 'JKN'){ // ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
								$str = "SELECT * FROM `tbgudangpkmstok`WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN') GROUP BY NamaBarang";
								$str2 = $str." ORDER BY `IdLplpo`, `NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							}						
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi, $str2);
							while($data = mysqli_fetch_assoc($query)){
								if ($sumberanggaran != 'APBN'){
									if($namaprogram != $data['NamaProgram']){
										echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='13'>$data[NamaProgram]</td></tr>";
										$namaprogram = $data['NamaProgram'];
									}
								}
								$no = $no + 1;								
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$namaprogram = $data['NamaProgram'];
								
								// tbgfkstok
								$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SumberAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
								$dtgfkstokvaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SumberAnggaran` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang'"));
								if($dtgfkstok['SumberAnggaran'] != ""){
									$sumberanggaran = $dtgfkstok['SumberAnggaran'];
								}elseif($dtgfkstokvaksin['SumberAnggaran'] != ""){
									$sumberanggaran = $dtgfkstokvaksin['SumberAnggaran'];
								}else{
									$sumberanggaran = "-";		
								}	
								
								// tahap1, stok awal ambil dari stok akhir bulan sebelumnya jika 0 ambil hasil import bulan ini
								$saldoawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal` FROM `$tblplpomanual_bandungkab` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
								$sisaakhir_bulanlalu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SisaAkhir` FROM `$tblplpomanual_bandungkab` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$blnsebelumnya'"));
								if($saldoawal == '0' or $saldoawal == ''){
									$stokawal = $sisaakhir_bulanlalu['SisaAkhir'];
								}else{
									$stokawal = $saldoawal['StokAwal'];
								}
								
								// tahap2, penerimaan 
								// BAHAN LABORATORIUM jangan dijadikan vaksin (update 02 Maret 2023)
								if($namaprogram == 'IMUNISASI' OR $namaprogram == 'PROGRAM IMUNISASI'){
									$strterima = "SELECT SUM(Jumlah) AS Jumlah
									FROM `tbgfk_vaksin_pengeluarandetail` a
									JOIN tbgfk_vaksin_pengeluaran b on a.NoFaktur = b.NoFaktur
									WHERE MONTH(b.TanggalPengeluaran) = '$bulan' AND YEAR(b.TanggalPengeluaran) = '$tahun' AND b.KodePenerima='$kodepuskesmas'
									AND a.KodeBarang='$kodebarang'";
								}else{
									$strterima = "SELECT SUM(Jumlah) AS Jumlah
									FROM `tbgfkpengeluarandetail` a
									JOIN tbgfkpengeluaran b on a.NoFaktur = b.NoFaktur
									WHERE MONTH(b.TanggalPengeluaran) = '$bulan' AND YEAR(b.TanggalPengeluaran) = '$tahun' AND b.KodePenerima='$kodepuskesmas'
									AND a.KodeBarang='$kodebarang'";
								}
								// echo $strterima;
								
								$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strterima));
								if($penerimaan['Jumlah'] != ''){
									$terima = $penerimaan['Jumlah'];
								}else{
									$terima = 0;
								}
								
								// pengadaan jkn
								$pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
								FROM `tbgudangpkmpengadaandetail` a
								JOIN `tbgudangpkmpengadaan` b on a.NoFaktur = b.NoFaktur
								WHERE MONTH(b.TanggalPengadaan) = '$bulan' AND YEAR(b.TanggalPengadaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
								AND a.KodeBarang='$kodebarang'"));				
								
								if($pengadaan['Jumlah'] != ''){
									$adaan = $pengadaan['Jumlah'];
								}else{
									$adaan = 0;
								}
								
								if($sumberanggaran != 'JKN'){
									$penerimaancls = $terima;
								}else{
									$penerimaancls = $adaan;
								}
								
								// persediaan
								$persediaan = $stokawal + $penerimaancls;
								
								// pemakaian
								$lplpomanual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tblplpomanual_bandungkab` WHERE `Tahun`='$tahun' AND `Bulan`='$bulan' AND `KodeBarang`='$kodebarang'"));
								$pemakaian = $lplpomanual['Pemakaian'];
								
								// sisa
								$sisa = $persediaan - $pemakaian;
								$stokoptimum = $sisa * 1.6;
												
								// permintaan
								if($lplpomanual['Permintaan'] != ''){
									$permintaans = $lplpomanual['Permintaan'];
								}else{
									$permintaans = 0;
								}		
							?>
								<tr style="solid:1px dashed #000;">
									<td style="text-align:right; solid:1px dashed #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px; display: none;" class="batchcls"><?php echo $data['NoBatch'];?></td>
									<td style="text-align:left; solid:1px dashed #000; padding:3px;"><?php echo strtoupper($data['NamaBarang']);?></td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px;"><?php echo strtoupper($data['Satuan']);?></td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="stokawalcls">
										<input type="hidden" name="kodebarang[]" value="<?php echo $data['KodeBarang'];?>"/>
										<input type="hidden" name="penerimaan[<?php echo $data['KodeBarang'];?>]" value="<?php echo $penerimaancls;?>"/>
										<input type="number" name="stokawal[<?php echo $data['KodeBarang'];?>]" style="width:80px" value="<?php echo $stokawal;?>"/>
									</td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="penerimaancls"><?php echo $penerimaancls;?></td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="persediaancls"><?php echo $persediaan;?></td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="pemakaiancls">
										<input type="number" name="pemakaian[<?php echo $data['KodeBarang'];?>]" style="width:80px" value="<?php echo $pemakaian;?>"/>
									</td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="sisacls"><?php echo $sisa;?></td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="stokoptimumcls">
										<?php 
											if($stokoptimum != 0){
												echo $stokoptimum;
											}else{
												echo "-";												
											}
										?>
									</td>
									<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="permintaancls">
										<input type="number" name="permintaan[<?php echo $data['KodeBarang'];?>]" style="width:80px" value="<?php echo $permintaans;?>"/>
									</td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px;"></td>
									<td style="text-align:center; solid:1px dashed #000; padding:3px;">
									<?php 
										if($sumberanggaran == "APBD KAB/KOTA"){ echo "APBD"; }else{ echo $sumberanggaran; }
									?>
									</td>
								</tr>
							<?php
								// update $tblplpomanual_bandungkab
								// mysqli_query($koneksi,"UPDATE `$tblplpomanual_bandungkab` SET 
								// `StokAwal`='$stokawal',
								// `Penerimaan`='$penerimaancls',
								// `Persediaan`='$persediaan',
								// `Pemakaian`='$pemakaian',
								// `SisaAkhir`='$sisa',
								// `StokOptimum`='$stokoptimum'
								// WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan' AND `KodeBarang`='$kodebarang'"); 
							}
							?>
						</tbody>
					</table><br/>
					<input type="submit" class="btn btn-round btn-success btnsimpan" style="padding: 10px" value="SIMPAN">
				</div>
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
						echo "<li><a href='?page=lap_farmasi_lplpo_manual&bulan=$bulan&tahun=$tahun&sumberanggaran=$_GET[sumberanggaran]&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	
	?>
	
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					Stok Optimum = Sisa Akhir * 1.6%
				</p>
			</div>
		</div>
	</div>
</div>	

<div class="modal mdlupload" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<?php //if($_GET['tahun']){ ?>
			<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_farmasi_lplpo_manual_import.php">
			
				<input type="hidden" name="link" value="bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>">
				<input type="hidden" name="tahun" value="<?php echo $_GET['tahun'];?>">
				<input type="hidden" name="bulan" value="<?php echo $_GET['bulan'];?>">
				<input type="hidden" name="sumberanggaran" value="<?php echo $_GET['sumberanggaran'];?>">
				<input name="fileexcel" type="file" required="required"><br/>
				<br/>
				<input name="upload" type="submit" value="Upload Data" class="btn btn-round btn-danger">
						
			</form>
		<?php //} ?>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>

	$(".btnuploads").click(function(){
		$(".mdlupload").modal('show');
	});

</script>
