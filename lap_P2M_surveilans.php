<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>SURVEILANS (STP)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_surveilans"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>	
						<div class="col-xl-2">
							<select type="text" name="kelurahan" class="form-control cari">
								<option value='semua'>Semua</option>
								<?php
								$qkel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE (`KodePuskesmas`='$kodepuskesmas' OR `KodePuskesmas`='*')  ORDER BY `Kelurahan`");
								while($dtkel = mysqli_fetch_assoc($qkel)){
									if($dtkel['Kelurahan'] == $_GET['kelurahan']){
									echo "<option value='$dtkel[Kelurahan]' SELECTED>$dtkel[Kelurahan]</option>";
									}else{
									echo "<option value='$dtkel[Kelurahan]'>$dtkel[Kelurahan]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_surveilans" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_surveilans_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&kelurahan=<?php echo $_GET['kelurahan'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kelurahan = $_GET['kelurahan'];

	if(isset($keydate1) and isset($keydate2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN SURVEILANS TERPADU PENYAKIT (KASUS BARU & LAMA)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));?></span><br/>
	</div><br/>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">KODE</th>
							<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">JENIS PENYAKIT</th>
							<th colspan="24" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">GOL.UMUR</th>
							<th rowspan="2" colspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL</th>
							<th rowspan="3" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL KUNJ.</th>
						</tr>
						<tr>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">0-7HR</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">8-30HR</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;"><1TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-4TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">5-9TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">10-14TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">15-19TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">20-44TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-54TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">55-59TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">60-69TH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>=70TH</th>
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
					<tbody style="font-size:12px;">
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

						// insert ke tbpasienrj_bulan_surveilans
						// $strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE DATE(`TanggalRegistrasi`) BETWEEN '$keydate1' AND '$keydate2'";
						// $querypasienrj = mysqli_query($koneksi,$strpasienrj);
						// mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan_surveilans`");
						// while($dt_pasienrj = mysqli_fetch_assoc($querypasienrj)){
						// 	$strpasienrjs = "INSERT INTO `tbpasienrj_bulan_surveilans`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
						// 	`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
						// 	`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
						// 	`nokartu`,`kdpoli`,`Kir`,`StatusBayar`) VALUES 
						// 	('$dt_pasienrj[TanggalRegistrasi]','$dt_pasienrj[NoRegistrasi]','$dt_pasienrj[NoIndex]','$dt_pasienrj[NoCM]',
						// 	'$dt_pasienrj[NoRM]','$dt_pasienrj[NamaPasien]','$dt_pasienrj[JenisKelamin]','$dt_pasienrj[UmurTahun]','$dt_pasienrj[UmurBulan]',
						// 	'$dt_pasienrj[UmurHari]','$dt_pasienrj[JenisKunjungan]','$dt_pasienrj[AsalPasien]','$dt_pasienrj[StatusPasien]','$dt_pasienrj[PoliPertama]',
						// 	'$dt_pasienrj[Asuransi]','$dt_pasienrj[StatusKunjungan]','$dt_pasienrj[WaktuKunjungan]','$dt_pasienrj[TarifKarcis]','$dt_pasienrj[TarifKir]',
						// 	'$dt_pasienrj[TotalTarif]','$dt_pasienrj[StatusPelayanan]','$dt_pasienrj[StatusPulang]','$dt_pasienrj[NamaPegawaiSimpan]','$dt_pasienrj[NamaPegawaiEdit]',
						// 	'$dt_pasienrj[TanggalEdit]','$dt_pasienrj[NoKunjunganBpjs]','$dt_pasienrj[NoUrutBpjs]','$dt_pasienrj[kdprovider]','$dt_pasienrj[nokartu]',
						// 	'$dt_pasienrj[kdpoli]','$dt_pasienrj[Kir]','$dt_pasienrj[StatusBayar]')";
						// 	// echo $strpasienrjs;
						// 	mysqli_query($koneksi, $strpasienrjs);
						// }
						
						if($kelurahan != 'semua'){
							$kelurahans = " JOIN `$tbkk` b ON a.NoIndex = b.NoIndex";
							$kelurahan_key = " AND b.`Kelurahan`='$kelurahan'";
						}else{
							$kelurahans = "";
							$kelurahan_key = "";
						}
						
						$waktu = " DATE(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'";
						
						$str = "SELECT * FROM `tbdiagnosasurveilans`";
						$str2 = $str." ORDER BY `No`";
											
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodedgs = $data['KodeDiagnosa'];
						
						$umur17hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '1' AND '7' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '1' AND '7' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '30' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '30' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun = '0' AND UmurBulan Between '2' AND '12' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun = '0' AND UmurBulan Between '2' AND '12' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L'".$kelurahan_key));
						// echo "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L'".$kelurahan_key;
						$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P'".$kelurahan_key));
						$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L'".$kelurahan_key));
						$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P'".$kelurahan_key));
						$jumlah_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml'] +
									$umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] +  $umur5559L['Jml'] +
									$umur6069L['Jml'] + $umur70100L['Jml'];
						$jumlah_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] +$umur59P['Jml'] + 
									$umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + 
									$umur6069P['Jml'] +  $umur70100P['Jml'];
						$total = $jumlah_l + $jumlah_p;
						
						
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100P['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jumlah_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jumlah_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td colspan="2" style="text-align:center; border:1px solid #000; padding:3px;"> JUMLAH<?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL_total;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP_total;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100L_total?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100P_total?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_l_total;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_p_total;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_total;?></td>
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
					<?php echo "KEPALA PUSKESMAS".$namapuskesmas;?>
					<br><br><br><br>
					<u><?php echo $kapus;?></u><br>
					<?php echo "NIP.".$kapusnip;?>
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