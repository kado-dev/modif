<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LB1-PENYAKIT (KASUS)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_lb1_penyakit_kasus"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<!--<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>-->
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
						<div class="col-sm-2">
							<select name="kasus" class="form-control">
								<option value="Semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>	
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_lb1_penyakit_kasus" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_lb1_penyakit_kasus_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-sm btn-info">Excel</a>
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
	$kasus = $_GET['kasus'];
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- PENYAKIT (KASUS <?php echo strtoupper($kasus);?>)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span><br/>
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
	</div>

	<div class="row ">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Penyakit</th>
							<th colspan="24" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Kasus <?php echo $kasus;?> Menurut Golongan Umur</th>
							<th rowspan="2"  colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kasus <?php echo $kasus;?></th>
						</tr>
						<tr style="border:1px solid #000;">
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
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Kasus-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Jml</th>
						</tr>
					</thead>
					<tbody style="font-size:9.5px;">
						<?php
						$jumlah_perpage = 25;
						if($opsiform == 'bulan'){
							$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
							$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
							$semua = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' ";
							
							// insert ke tbdiagnosapasien_bulan
							$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalDiagnosa`)='$tahun'";
							$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
							mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
							while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
								$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
								('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
								mysqli_query($koneksi, $strdiagnosa);
							}
						}else{
							$waktu1 = "TanggalRegistrasi >= '$keydate1'";
							$waktu2 = "TanggalRegistrasi <= '$keydate2'";
							$tbpasienrj_1 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
							$tbpasienrj_2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
							$tbdiagnosapasien_1 = 'tbdiagnosapasien_'.date('m',strtotime($keydate1));
							$tbdiagnosapasien_2 = 'tbdiagnosapasien_'.date('m',strtotime($keydate2));							
						}
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `tbdiagnosa`";
						$str2 = $str."order by `KodeDiagnosa` ASC limit $mulai,$jumlah_perpage";
											
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}				
								
						if ($kasus == "Semua"){
							$kasus = " ";
						}else{
							$kasus = " AND b.Kasus = '$kasus'";
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = '%'.$data['KodeDiagnosaBPJS']."%";
							
							if($opsiform == 'bulan'){
								$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'".$kasus));
								$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'".$kasus));
								$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'".$kasus));
								$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'".$kasus));
								$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$kasus));
								$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$kasus));
								$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'".$kasus));
								$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'".$kasus));
								$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L'".$kasus));
								$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P'".$kasus));
								$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L'".$kasus));
								$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P'".$kasus));
								$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L'".$kasus));
								$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P'".$kasus));
								$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L'".$kasus));
								$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P'".$kasus));
								$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'".$kasus));
								$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'".$kasus));
								$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L'".$kasus));
								$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P'".$kasus));
								$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L'".$kasus));
								$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P'".$kasus));
								$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L'".$kasus));
								$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P'".$kasus));
							}else{
								// umur17hr
								$umur17hrL_1= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'".$kasus));
								$umur17hrL_2= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'".$kasus));
									$umur17hrL['Jml']= $umur17hrL_1['Jml'] + $umur17hrL_2['Jml'];
								$umur17hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'".$kasus));
								$umur17hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'".$kasus));
									$umur17hrP['Jml']= $umur17hrP_1['Jml'] + $umur17hrP_2['Jml'];
								// umur1830hr
								$umur1830hrL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'".$kasus));
								$umur1830hrL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'".$kasus));
									$umur1830hrL['Jml']= $umur1830hrL_1['Jml'] + $umur1830hrL_2['Jml'];
								$umur1830hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'".$kasus));
								$umur1830hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'".$kasus));
									$umur1830hrP['Jml']= $umur1830hrP_1['Jml'] + $umur1830hrP_2['Jml'];	
								// umur12bln
								$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$kasus));
								$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$kasus));
									$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
								$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$kasus));
								$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$kasus));
									$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
								// umur12bln
								$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$kasus));
								$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$kasus));
									$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
								$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$kasus));
								$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$kasus));
									$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
								// umur14th
								$umur14L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'".$kasus));
								$umur14L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'".$kasus));
									$umur14L['Jml']= $umur14L_1['Jml'] + $umur14L_2['Jml'];
								$umur14P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'".$kasus));
								$umur14P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'".$kasus));
									$umur14P['Jml']= $umur14P_1['Jml'] + $umur14P_2['Jml'];
								// umur59th
								$umur59L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L'".$kasus));
								$umur59L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L'".$kasus));
									$umur59L['Jml']= $umur59L_1['Jml'] + $umur59L_2['Jml'];
								$umur59P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P'".$kasus));
								$umur59P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P'".$kasus));
									$umur59P['Jml']= $umur59P_1['Jml'] + $umur59P_2['Jml'];
								// umur1014th
								$umur1014L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L'".$kasus));
								$umur1014L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L'".$kasus));
									$umur1014L['Jml']= $umur1014L_1['Jml'] + $umur1014L_2['Jml'];
								$umur1014P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P'".$kasus));
								$umur1014P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P'".$kasus));
									$umur1014P['Jml']= $umur1014P_1['Jml'] + $umur1014P_2['Jml'];
								// umur1519th
								$umur1519L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L'".$kasus));
								$umur1519L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L'".$kasus));
									$umur1519L['Jml']= $umur1519L_1['Jml'] + $umur1519L_2['Jml'];
								$umur1519P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P'".$kasus));
								$umur1519P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P'".$kasus));
									$umur1519P['Jml']= $umur1519P_1['Jml'] + $umur1519P_2['Jml'];
								// umur2044th
								$umur2044L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L'".$kasus));
								$umur2044L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L'".$kasus));
									$umur2044L['Jml']= $umur2044L_1['Jml'] + $umur2044L_2['Jml'];
								$umur2044P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P'".$kasus));
								$umur2044P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P'".$kasus));
									$umur2044P['Jml']= $umur2044P_1['Jml'] + $umur2044P_2['Jml'];
								// umur4554th
								$umur4554L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'".$kasus));
								$umur4554L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'".$kasus));
									$umur4554L['Jml']= $umur4554L_1['Jml'] + $umur4554L_2['Jml'];
								$umur4554P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'".$kasus));
								$umur4554P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'".$kasus));
									$umur4554P['Jml']= $umur4554P_1['Jml'] + $umur4554P_2['Jml'];
								// umur5559th
								$umur5559L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L'".$kasus));
								$umur5559L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L'".$kasus));
									$umur5559L['Jml']= $umur5559L_1['Jml'] + $umur5559L_2['Jml'];
								$umur5559P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P'".$kasus));
								$umur5559P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P'".$kasus));
									$umur5559P['Jml']= $umur5559P_1['Jml'] + $umur5559P_2['Jml'];
								// umur6069th
								$umur6069L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L'".$kasus));
								$umur6069L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L'".$kasus));
									$umur6069L['Jml']= $umur6069L_1['Jml'] + $umur6069L_2['Jml'];
								$umur6069P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P'".$kasus));
								$umur6069P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P'".$kasus));
									$umur6069P['Jml']= $umur6069P_1['Jml'] + $umur6069P_2['Jml'];
								// umur70100th
								$umur70100L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L'".$kasus));
								$umur70100L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L'".$kasus));
									$umur70100L['Jml']= $umur70100L_1['Jml'] + $umur70100L_2['Jml'];
								$umur70100P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P'".$kasus));
								$umur70100P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P'".$kasus));
									$umur70100P['Jml']= $umur70100P_1['Jml'] + $umur70100P_2['Jml'];
							}	
							
							// kasus
							$baru_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
								+ $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
								+ $umur6069L['Jml'] + $umur70100L['Jml'];
							$baru_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
								+ $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
								+ $umur6069P['Jml'] + $umur70100P['Jml'];
							$total_baru = $baru_l+ $baru_p;
							
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
								<!--total kasus-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_baru;?></td>
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
						echo "<li><a href='?page=lap_lb1_penyakit_kasus&keydate1=$keydate1&keydate2=$keydate2&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
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