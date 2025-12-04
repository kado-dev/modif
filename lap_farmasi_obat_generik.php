<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">OBAT GENERIK</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_obat_generik"/>
						<div class="col-sm-2">
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	if(isset($bulan) and isset($tahun)){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMANTAUAN PENULISAN RESEP OBAT GENERIK</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
			<br/>
		</div>

		<div class="atastabel font11">
			<div style="float:left; width:65%; margin-bottom:10px;">
				<table style="font-size:10px; width:300px;">
					<tr>
						<td style="padding:2px 4px;">Kode Puskesmas</td>
						<td style="padding:2px 4px;">:</td>
						<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
					</tr>
					<tr>
						<td style="padding:2px 4px;">Puskesmas</td>
						<td style="padding:2px 4px;">:</td>
						<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
					</tr>
				</table><p/>
			</div>
			<div style="float:right; width:35%; margin-bottom:10px;">	
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

		<div class="row font10">
			<div class="col-sm-12">
				<div class="table-responsive font10">
					<table class="table-judul-laporan">
						<thead style="font-size:10px;">
							<tr style="border:1px solid #000;">
								<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Resep</th>
								<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemeriksa</th>
								<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Lembar Resep</th>
								<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">R/Obat</th>
								<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">% R/Obat Generik Terhadap Total R/</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Total R/</th>
								<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Total R/ Generik</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1</th>
								<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">2</th>
								<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">3</th>
								<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">4</th>
								<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">5</th>
								<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">6 = (5 / 4 * 100)</th>
							</tr>
						</thead>
						<tbody style="font-size:10px;">
							<?php
							// insert ke tbresep_bulan
							$strresep = "SELECT * FROM `$tbresep` WHERE SUBSTRING(NoResep,1,11)='$kodepuskesmas' AND YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`)='$bulan'";
							$queryresep = mysqli_query($koneksi,$strresep);
							mysqli_query($koneksi, "DELETE FROM `tbresep_bulan`");
							while($dataresep = mysqli_fetch_assoc($queryresep)){
								$strinsresep = "INSERT INTO `tbresep_bulan`(`TanggalResep`, `NoResep`, `NoIndex`, `NoCM`, `NamaPasien`, `UmurTahun`,`UmurBulan`,`Alamat`,`StatusBayar`,`Pelayanan`,`Status`,`StatusLoket`,`Pio`,`Diagnosa`,`NamaPegawai`) VALUES 
								('$dataresep[TanggalResep]','$dataresep[NoResep]','$dataresep[NoIndex]','$dataresep[NoCM]','$dataresep[NamaPasien]','$dataresep[UmurTahun]','$dataresep[UmurBulan]','$dataresep[Alamat]','$dataresep[StatusBayar]','$dataresep[Pelayanan]','$dataresep[Status]','$dataresep[StatusLoket]','$dataresep[Pio]','$dataresep[Diagnosa]','$dataresep[NamaPegawai]')";
								// echo $strinsresep;
								// die();
								mysqli_query($koneksi, $strinsresep);
							}
							
							$tgl1 = $tahun.'-'.$bulan.'-01';
							$tgl2 = date('Y-m-t', strtotime($tgl1));
							$begin = new DateTime( $tgl1 );
							$end   = new DateTime( $tgl2 );
							for($i = $begin; $i <= $end; $i->modify('+1 day')){
								$tgl = $i->format("Y-m-d");	

								// lembar resep
								$str_resep = "SELECT COUNT(NoResep) As Jml FROM `tbresep_bulan`
								WHERE date(TanggalResep) = '$tgl' AND SUBSTRING(NoResep,1,11)='$kodepuskesmas'";
								// echo $str_resep;
								$dt_resep = mysqli_fetch_assoc(mysqli_query($koneksi, $str_resep));		
							
								// menjumlahkan total r
								$str_r = "SELECT COUNT(b.NoResep) As Jml FROM `tbresep_bulan` a
								JOIN `$tbresepdetail` b ON a.NoResep = b.NoResep
								WHERE date(a.TanggalResep) = '$tgl' AND SUBSTRING(b.NoResep,1,11)='$kodepuskesmas'";
								$dt_r = mysqli_fetch_assoc(mysqli_query($koneksi, $str_r));
								
								// menjumlahkan total r/generik
								$str_rgenerik = "SELECT COUNT(b.NoResep) As Jml FROM `tbresep_bulan` a
								JOIN `$tbresepdetail` b ON a.NoResep = b.NoResep
								JOIN `tbgfkstok` c ON b.KodeBarang = c.KodeBarang
								WHERE date(a.TanggalResep) = '$tgl' AND SUBSTRING(b.NoResep,1,11)='$kodepuskesmas' AND c.JenisBarang = 'GENERIK'";
								$dt_rgenerik = mysqli_fetch_assoc(mysqli_query($koneksi, $str_rgenerik));
								
								// total								
								$total = $dt_rgenerik['Jml'] / $dt_r['Jml'] * 100; 
								
								
							?>
								<tr style="border:1px solid #000;">
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $i->format("d");?></td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;"></td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_resep['Jml'];?></td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_r['Jml'];?></td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_rgenerik['Jml'];?></td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $total;?></td>	
								</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
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
	}
	?>
</div>	