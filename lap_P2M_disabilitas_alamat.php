<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PENYANDANG DISABILITAS (DETAIL)</b></h3>
			<div class="formbg">
				<form role="form">	
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_disabilitas_alamat"/>
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
						<div class="col-xl-2" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_disabilitas_alamat" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PESERTA DISABILITAS</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
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
			<table style="font-size:10px; width:300px;">
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
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th width="7%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
							<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.Reg</th>
							<th width="6%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
							<th width="10%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th width="2%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">L/P</th>
							<th width="4%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TanggalLahir</th>
							<th width="12%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
							<th width="10%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kelompok Disabilitas</th>
							<th width="10%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Puskesmas</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$str = "SELECT * FROM `tbpasiendisabilitas` WHERE MONTH(TanggalPeriksa)='$bulan' AND YEAR(TanggalPeriksa)='$tahun'";
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noregistrasi = $data['NoRegistrasi'];
							$noregistrasi1 = substr($data['NoRegistrasi'],0,11);
							$noindex = $data['NoIndex'];
							$nocm = $data['NoCM'];
							$tanggalperiksa = $data['TanggalPeriksa'];
							
							if(strlen($nocm) == 13){
								$tbpasienrj = 'tbpasienrj_'.substr($tanggalperiksa,5,2);
								$str_pasien = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
								$noindex1 = $data['NoIndex'];
							}else{
								$tbpasien = 'tbpasien_'.substr($nocm,12,4);
								$str_pasien = "SELECT * FROM `$tbpasien` WHERE `NoIndex` = '$noindex'";
								$noindex1 = substr($data['NoIndex'],14);
							}
							
							// tbpasien
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pasien));
							$namapasien = $dt_pasien['NamaPasien'];
							$kelamin = $dt_pasien['JenisKelamin'];
							$tanggallahir = $dt_pasien['TanggalLahir'];
																		
							// tbkk
							$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
							$alamat = $dt_kk['Alamat'];
												
							if($alamat != null){
								$alamat = $dt_kk['Alamat'].", RT.".$dt_kk['RT'].", RW.".$dt_kk['RW'];
							}else{
								$alamat = "-";
							}
							
							// tbpuskesmas
							$dt_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$noregistrasi1'"));
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoRegistrasi'],19);?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $noindex1;?>
								</td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapasien;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kelamin;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										if ($tanggallahir == null){
											echo $tanggallahir = '<span style="color:red; text-align:center;">-</span>';
										}else{
											echo $tanggallahir;
										}
									?>
								</td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">
									<?php 
										if ($alamat == '-'){
											echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
										}else{
											echo $alamat;
										}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KelompokDisabilitas'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_puskesmas['NamaPuskesmas'];?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	