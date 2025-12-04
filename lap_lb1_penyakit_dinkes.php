<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LB1-PENYAKIT</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_lb1_penyakit_dinkes"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="Semua" <?php if($_GET['bulan'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
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
									for($tahun = 2022 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="puskesmas" class="form-control">
								<option value='Semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['puskesmas'] == $data3['KodePuskesmas']){
										echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
									}else{
										echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_lb1_penyakit_dinkes" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_lb1_penyakit_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['puskesmas'];?>" class="btn btn-round btn-info">Excel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$pkm = $_GET['puskesmas'];
	// if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- PENYAKIT</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Penyakit</th>
							<th colspan="24" style="text-align:center;width:40%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Kasus Baru Menurut Golongan Umur</th>
							<th rowspan="2"  colspan="3" style="text-align:center;width:8%;vertical-align:middle; border:1px solid #000; padding:3px;">Kasus Baru</th>
							<th rowspan="2"  colspan="3" style="text-align:center;width:8%;vertical-align:middle; border:1px solid #000; padding:3px;">Kasus Lama</th>
							<th rowspan="3" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Total Kasus</th>
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
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Kasus Baru-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Jml</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Kasus Lama-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Jml</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
						if($pkm == "Semua"){
							$puskesmas = "";
							$puskesmas2 = "";
						}else{
							$puskesmas = " AND SUBSTRING(NoRegistrasi,1,11)='$_GET[puskesmas]'";
							$puskesmas2 = " AND SUBSTRING(NoRegistrasi,1,11)='$_GET[puskesmas]'";
						}
						
						$waktu = "YEAR(TanggalDiagnosa) = '$tahun'";
						$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						
						// insert ke tbdiagnosapasien_bulan
						if($bulan == "Semua"){
							// $strdiagnosabl = "SELECT * FROM (
							// SELECT * FROM `tbdiagnosapasien_01` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_02` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_03` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_04` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_05` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_06` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_07` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_08` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_09` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_10` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_11` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas UNION ALL
							// SELECT * FROM `tbdiagnosapasien_12` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas
							// ) `tbdiagnosapasien_bulan`";

							for($i = 1; $i<=12; $i++){
								if(strlen($i) == 2){
									$nn = $i;
								}else{
									$nn = "0".$i;
								}
								$tbdiagnosapsn = 'tbdiagnosapasien_'.$nn;
								$strarr[] = "SELECT * FROM `$tbdiagnosapsn` WHERE YEAR(`TanggalDiagnosa`)='$tahun' $puskesmas";
							}		
							$strdiagnosabl = "SELECT * FROM (".implode(" union all ",$strarr).") t_unions";

						}else{
							if($pkm == "Semua"){
								$strdiagnosabl = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'";
							}else{
								$strdiagnosabl = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas;
							}
						}
						// echo $strdiagnosabl;
						
						mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
						$querydiagnosabl = mysqli_query($koneksi, $strdiagnosabl);
						while($datalb = mysqli_fetch_assoc($querydiagnosabl)){
							$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`) VALUES 
							('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]','$datalb[UmurTahun]','$datalb[UmurBulan]','$datalb[UmurHari]','$datalb[JenisKelamin]')";
							mysqli_query($koneksi, $strdiagnosa);
						}
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `tbdiagnosa`";
						$str2 = $str."order by `KodeDiagnosa` ASC LIMIT $mulai,$jumlah_perpage";
																	
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
					
										
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = $data['KodeDiagnosaBPJS'];
							$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '1' AND '7' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '1' AND '7' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '30' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '30' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun = '0' AND UmurBulan Between '2' AND '12' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun = '0' AND UmurBulan Between '2' AND '12' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
												
							// kasus lama
							$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '0' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa = '$kodedgs' AND UmurTahun Between '0' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$t_lama_l = $lama_l['Jml'];
							$t_lama_p = $lama_p['Jml'];
							$total_lama = $t_lama_l + $t_lama_p;
						
							// kasus baru
							$baru_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
								+ $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
								+ $umur6069L['Jml'] + $umur70100L['Jml'];
							$baru_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
								+ $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
								+ $umur6069P['Jml'] + $umur70100P['Jml'];
							$total_baru = $baru_l+ $baru_p;
							$total = $total_baru + $total_lama;
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
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
								<!--kasus baru-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_baru;?></td>
								<!--kasus lama-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $lama_l['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $lama_p['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_lama;?></td>
								<!--total kasus baru + lama-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>

	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$puskesmas = $_GET['puskesmas'];
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
						echo "<li><a href='?page=lap_lb1_penyakit_dinkes&bulan=$bulan&tahun=$tahun&puskesmas=$puskesmas&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
<?php
// }
?>
</div>