<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN POLI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_poli"/>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-xl-3">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-xl-2">
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="asalpasien" class="form-control asuransi">
								<option value='semua'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` order by `AsalPasien` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asalpasien'] == $data['Id']){
											echo "<option value='$data[Id]' SELECTED>$data[AsalPasien]</option>";
										}else{
											echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kunjungan" class="form-control">
								<option value="semua" <?php if($_GET['kunjungan'] == 'semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kunjungan'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kunjungan'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_poli" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_poli_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>&kj=<?php echo $_GET['kunjungan'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$asalpasien = $_GET['asalpasien'];
	$statuskunjungan = $_GET['kunjungan'];
	if(isset($bulan) and isset($tahun)){		
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (POLI)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>

	<div class="atastabel">
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
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PELAYANAN</th>
						<?php
							$bln = $_GET['bulan'];
							$thn = $_GET['tahun'];
							$mulai = 1;
							$selesai = 31;
							for($d = $mulai;$d <= $selesai; $d++){	
						?>
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
						<?php
							}
						?>
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tgl1 = 0;
						$str = "SELECT `Pelayanan` FROM `tbpelayanankesehatan` WHERE `JenisPelayanan` = 'Kunjungan Sakit' ORDER BY Pelayanan";
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_array($query)){
							$no = $no + 1;
							$pelayanan = $data['Pelayanan'];
							
							if ($asalpasien == 'semua'){
								$aslpsn = " ";
							}else{
								$aslpsn = " AND `AsalPasien` = '$asalpasien'";
							}

							if ($statuskunjungan == 'semua'){
								$stskunjungan = " ";
							}else{
								$stskunjungan = " AND `StatusKunjungan` = '$statuskunjungan'";
							}
														
							if($pelayanan != ''){
							?>
								<tr style="border:1px solid #000;">
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Pelayanan'];?></td>	
									<?php
										$jml = 0;	
										for($d2= $mulai;$d2 <= $selesai; $d2++){	
										$tanggal = $thn."-".$bln."-".$d2;
										$strs = "SELECT COUNT(NoRegistrasi) AS jumlah 
										FROM `$tbpasienrj`
										WHERE date(`TanggalRegistrasi`) = '$tanggal' AND `PoliPertama` = '$pelayanan'".$aslpsn.$stskunjungan;
										// echo $strs;
										$count = mysqli_fetch_array(mysqli_query($koneksi,$strs));
										$jml = $jml + $count['jumlah'];
									?>	
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count['jumlah'];?></td>
									<?php }	?>
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml;?></td>
								</tr>
							<?php
							}
						}
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">Total</td>
							<?php
								$jmls = 0;
								for($d3= $mulai;$d3 <= $selesai; $d3++){	
								$tanggal = $thn."-".$bln."-".$d3;
								$strs2 = "SELECT COUNT(NoRegistrasi) as Jumlah FROM `$tbpasienrj` 
								WHERE date(`TanggalRegistrasi`) = '$tanggal'".$aslpsn.$stspsn.$stskunjungan;
								$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
								$jmls = $jmls + $countall['Jumlah'];
							?>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $countall['Jumlah'];?></td>
							<?php
								}
							?>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmls;?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	