<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>SURVEILANS (STP)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_surveilans_dinkes"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" value="<?php echo $_GET['keydate1'];?>" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> 
								<input type="text" name="keydate2" value="<?php echo $_GET['keydate2'];?>" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
									echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
								}else{
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
							}
							?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_surveilans_dinkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$kodepkm = $_GET['kodepuskesmas'];

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Penyakit</th>
							<th colspan="24" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Golongan Umur</th>
							<th rowspan="2" colspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
							<th rowspan="3" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Total Kunj</th>
						</tr>
						<tr>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">0-7Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">8-30Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;"><1Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">5-9Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">10-14Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">15-19Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">20-44Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-54Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">55-59Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">60-69Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>=70Th</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--0-7Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--8-30Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--<1Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--5-9Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--10-14Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--15-19Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--20-24Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--45-54Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--55-59Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--60-69Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--70Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Jml-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th><!--Jml-->
						</tr>
					</thead>
					
					<tbody style="font-size:10px;">
						<?php	
						$umur17hrL_total = 0;
						$umur17hrP_total = 0;
						$umur1830hrL_total = 0;
						$umur1830hrP_total = 0;
						$umur12blnL_total = 0;
						$umur12blnP_total = 0;
						$umur14L_total = 0;
						$umur14P_total = 0;
						$umur59L_total = 0;
						$umur59P_total = 0;
						$umur1014L_total = 0;
						$umur1014P_total = 0;
						$umur1519L_total = 0;
						$umur1519P_total = 0;
						$umur2044L_total = 0;
						$umur2044P_total = 0;
						$umur4554L_total = 0;
						$umur4554P_total = 0;
						$umur5559L_total = 0;
						$umur5559P_total = 0;
						$umur6069L_total = 0;
						$umur6069P_total = 0;
						$umur70100L_total = 0;
						$umur70100P_total = 0;
						$total_l_total = 0;
						$total_p_total = 0;
						$total_total = 0;
						
						if($opsiform == 'bulan'){
							$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
							$tbpasienrj = 'tbpasienrj_'.$bulan;
							$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						}else{
							$waktu1 = "TanggalRegistrasi >= '$keydate1'";
							$waktu2 = "TanggalRegistrasi <= '$keydate2'";
							$tbpasienrj_1 = 'tbpasienrj_'.date('m',strtotime($keydate1));
							$tbpasienrj_2 = 'tbpasienrj_'.date('m',strtotime($keydate2));
							$tbdiagnosapasien_1 = 'tbdiagnosapasien_'.date('m',strtotime($keydate1));
							$tbdiagnosapasien_2 = 'tbdiagnosapasien_'.date('m',strtotime($keydate2));
						}
												
						if($kodepkm == 'semua'){
							$kodepuskesmas = "";
						}else{
							$kodepuskesmas = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas'";
						}							
						
						$str = "SELECT * FROM `tbdiagnosasurveilans`";
						$str2 = $str."order by `No`";
																	
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodedgs = $data['KodeDiagnosa'];
						
						if($opsiform == 'bulan'){
							$umur17hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj`a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L'".$kelurahan_key));
							$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P'".$kelurahan_key));
							$jumlah_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml'] +
										$umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] +  $umur5559L['Jml'] +
										$umur6069L['Jml'] + $umur70100L['Jml'];
							$jumlah_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] +$umur59P['Jml'] + 
										$umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + 
										$umur6069P['Jml'] +  $umur70100P['Jml'];
							$total = $jumlah_l + $jumlah_p;
						}else{
							$umur17hrL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'"));
							$umur17hrL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'"));
								$umur17hrL['Jml'] = $umur17hrL_1['Jml'] + $umur17hrL_2['Jml'];
							$umur17hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'"));
							$umur17hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'"));
								$umur17hrP['Jml'] = $umur17hrP_1['Jml'] + $umur17hrP_2['Jml'];
							$umur1830hrL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'"));
							$umur1830hrL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'"));
								$umur1830hrL['Jml'] = $umur1830hrL_1['Jml'] + $umur1830hrL_2['Jml'];
							$umur1830hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'"));
							$umur1830hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'"));
								$umur1830hrP['Jml'] = $umur1830hrP_1['Jml'] + $umur1830hrP_2['Jml'];
							$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'"));
							$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'"));
								$umur12blnL['Jml'] = $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
							$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'"));
							$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'"));
								$umur12blnP['Jml'] = $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
							$umur14L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'"));
							$umur14L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'"));
								$umur14L['Jml'] = $umur14L_1['Jml'] + $umur14L_2['Jml'];
							$umur14P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'"));
							$umur14P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'"));
								$umur14P['Jml'] = $umur14P_1['Jml'] + $umur14P_2['Jml'];
							$umur59L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L'"));
							$umur59L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L'"));
								$umur59L['Jml'] = $umur59L_1['Jml'] + $umur59L_2['Jml'];
							$umur59P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1`a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P'"));
							$umur59P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2`a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P'"));
								$umur59P['Jml'] = $umur59P_1['Jml'] + $umur59P_2['Jml'];
							$umur1014L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L'"));
							$umur1014L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L'"));
								$umur1014L['Jml'] = $umur1014L_1['Jml'] + $umur1014L_2['Jml'];
							$umur1014P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P'"));
							$umur1014P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P'"));
								$umur1014P['Jml'] = $umur1014P_1['Jml'] + $umur1014P_2['Jml'];
							$umur1519L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L'"));
							$umur1519L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L'"));
								$umur1519L['Jml'] = $umur1519L_1['Jml'] + $umur1519L_2['Jml'];
							$umur1519P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P'"));
							$umur1519P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P'"));
								$umur1519P['Jml'] = $umur1519P_1['Jml'] + $umur1519P_2['Jml'];
							$umur2044L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L'"));
							$umur2044L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L'"));
								$umur2044L['Jml'] = $umur2044L_1['Jml'] + $umur2044L_2['Jml'];
							$umur2044P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P'"));
							$umur2044P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P'"));
								$umur2044P['Jml'] = $umur2044P_1['Jml'] + $umur2044P_2['Jml'];
							$umur4554L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'"));
							$umur4554L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'"));
								$umur4554L['Jml'] = $umur4554L_1['Jml'] + $umur4554L_2['Jml'];
							$umur4554P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'"));
							$umur4554P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'"));
								$umur4554P['Jml'] = $umur4554P_1['Jml'] + $umur4554P_2['Jml'];
							$umur5559L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L'"));
							$umur5559L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L'"));
								$umur5559L['Jml'] = $umur5559L_1['Jml'] + $umur5559L_2['Jml'];
							$umur5559P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P'"));
							$umur5559P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P'"));
								$umur5559P['Jml'] = $umur5559P_1['Jml'] + $umur5559P_2['Jml'];
							$umur6069L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L'"));
							$umur6069L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L'"));
								$umur6069L['Jml'] = $umur6069L_1['Jml'] + $umur6069L_2['Jml'];
							$umur6069P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P'"));
							$umur6069P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P'"));
								$umur6069P['Jml'] = $umur6069P_1['Jml'] + $umur6069P_2['Jml'];
							$umur70100L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L'"));
							$umur70100L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L'"));
								$umur70100L['Jml'] = $umur70100L_1['Jml'] + $umur70100L_2['Jml'];
							$umur70100P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a JOIN `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P'"));
							$umur70100P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a JOIN `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P'"));
								$umur70100P['Jml'] = $umur70100P_1['Jml'] + $umur70100P_2['Jml'];
							
							// jumlah
							$jumlah_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml'] + $umur1014L['Jml'] +
										$umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml'] + $umur6069L['Jml'] + $umur70100L['Jml'];
							$jumlah_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml'] + $umur1014P['Jml'] +
										$umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + $umur6069P['Jml'] + $umur70100P['Jml'];
							$total = $jumlah_l + $jumlah_p;
						}
						
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
								<td align="left"><?php echo $data['NamaDiagnosa'];?></td>
								<td align="right"><?php echo rupiah($umur17hrL['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur17hrP['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur1830hrL['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur1830hrP['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur12blnL['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur12blnP['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur14L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur14P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur59L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur59P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur1014L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur1014P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur1519L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur1519P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur2044L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur2044P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur4554L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur4554P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur5559L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur5559P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur6069L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur6069P['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur70100L['Jml']);?></td>
								<td align="right"><?php echo rupiah($umur70100P['Jml']);?></td>
								<td align="right"><?php echo rupiah($jumlah_l);?></td>
								<td align="right"><?php echo rupiah($jumlah_p);?></td>
								<td align="right"><b><?php echo rupiah($total);?></b></td>
							</tr>
						<?php
						$umur17hrL_total = $umur17hrL_total + $umur17hrL['Jml'];
						$umur17hrP_total = $umur17hrP_total + $umur17hrP['Jml'];
						$umur1830hrL_total = $umur1830hrL_total + $umur1830hrL['Jml'];
						$umur1830hrP_total = $umur1830hrP_total + $umur1830hrP['Jml'];
						$umur12blnL_total = $umur12blnL_total + $umur12blnL['Jml'];
						$umur12blnP_total = $umur12blnP_total + $umur12blnP['Jml'];
						$umur14L_total = $umur14L_total + $umur14L['Jml'];
						$umur14P_total = $umur14P_total + $umur14P['Jml'];
						$umur59L_total = $umur59L_total + $umur59L['Jml'];
						$umur59P_total = $umur59P_total + $umur59P['Jml'];
						$umur1014L_total = $umur1014L_total + $umur1014L['Jml'];
						$umur1014P_total = $umur1014P_total + $umur1014P['Jml'];
						$umur1519L_total = $umur1519L_total + $umur1519L['Jml'];
						$umur1519P_total = $umur1519P_total + $umur1519P['Jml'];
						$umur2044L_total = $umur2044L_total + $umur2044L['Jml'];
						$umur2044P_total = $umur2044P_total + $umur2044P['Jml'];
						$umur4554L_total = $umur4554L_total + $umur4554L['Jml'];
						$umur4554P_total = $umur4554P_total + $umur4554P['Jml'];
						$umur5559L_total = $umur5559L_total + $umur5559L['Jml'];
						$umur5559P_total = $umur5559P_total + $umur5559P['Jml'];
						$umur6069L_total = $umur6069L_total + $umur6069L['Jml'];
						$umur6069P_total = $umur6069P_total + $umur6069P['Jml'];
						$umur70100L_total = $umur70100L_total + $umur70100L['Jml'];
						$umur70100P_total = $umur70100P_total + $umur70100P['Jml'];
						$total_l_total = $total_l_total + $jumlah_l;
						$total_p_total = $total_p_total + $jumlah_p;
						$total_total = $total_total + $total;
						}
						?>
							<tr style="border:1px solid #000;">
								<td><?php echo $no;?></td>
								<td colspan="2"> Jumlah<?php echo $data['KodeDiagnosa'];?></td>
								<td align="right"><?php echo rupiah($umur17hrL_total)?></td>
								<td align="right"><?php echo rupiah($umur17hrP_total)?></td>
								<td align="right"><?php echo rupiah($umur1830hrL_total)?></td>
								<td align="right"><?php echo rupiah($umur1830hrP_total)?></td>
								<td align="right"><?php echo rupiah($umur12blnL_total)?></td>
								<td align="right"><?php echo rupiah($umur12blnP_total)?></td>
								<td align="right"><?php echo rupiah($umur14L_total)?></td>
								<td align="right"><?php echo rupiah($umur14P_total)?></td>
								<td align="right"><?php echo rupiah($umur59L_total)?></td>
								<td align="right"><?php echo rupiah($umur59P_total)?></td>
								<td align="right"><?php echo rupiah($umur1014L_total)?></td>
								<td align="right"><?php echo rupiah($umur1014P_total)?></td>
								<td align="right"><?php echo rupiah($umur1519L_total)?></td>
								<td align="right"><?php echo rupiah($umur1519P_total)?></td>
								<td align="right"><?php echo rupiah($umur2044L_total)?></td>
								<td align="right"><?php echo rupiah($umur2044P_total)?></td>
								<td align="right"><?php echo rupiah($umur4554L_total)?></td>
								<td align="right"><?php echo rupiah($umur4554P_total)?></td>
								<td align="right"><?php echo rupiah($umur5559L_total)?></td>
								<td align="right"><?php echo rupiah($umur5559P_total)?></td>
								<td align="right"><?php echo rupiah($umur6069L_total)?></td>
								<td align="right"><?php echo rupiah($umur6069P_total)?></td>
								<td align="right"><?php echo rupiah($umur70100L_total)?></td>
								<td align="right"><?php echo rupiah($umur70100P_total)?></td>
								<td align="right"><?php echo rupiah($total_l_total)?></td>
								<td align="right"><?php echo rupiah($total_p_total)?></td>
								<td align="right"><?php echo rupiah($total_total)?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td style="text-align:center;">
					MENGETAHUI<br>
					<?php echo "KEPALA UPT ".$datapuskesmas['NamaPuskesmas'];?>
					<br><br><br><br>
					<u><?php echo $datapuskesmas['KepalaPuskesmas'];?></u><br>
					<?php echo "NIP.".$datapuskesmas['Nip'];?>
				</td>
				<td width="10%"></td>
				<td style="text-align:center;">
					<?php echo $kota.", ___ ".strtoupper(nama_bulan($bulan))." ".$tahun;?><br>
					PELAKSANA PROGRAM
					<br><br><br><br>
					(..........................................................)
				</td>
			</tr>
		</table>
	</div>
	<?php
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
$(document).ready(function(){
	if($('.opsiform').val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>