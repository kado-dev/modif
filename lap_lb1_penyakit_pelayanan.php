<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LB1-PENYAKIT (PER-PELAYANAN)</b></h3>
			<div class="formbg">	
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_lb1_penyakit_pelayanan"/>
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
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="pelayanan" class="form-control">
							<option value='Semua'>Semua</option>
							<?php
							$kota = $_SESSION['kota'];
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								if($_GET['pelayanan'] == $data3['Pelayanan']){
									echo "<option value='$data3[Pelayanan]' SELECTED>$data3[Pelayanan]</option>";
								}else{
									echo "<option value='$data3[Pelayanan]'>$data3[Pelayanan]</option>";
								}
								// echo "<option value='$data3[Pelayanan]'>$data3[Pelayanan]</option>";
							}
							?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_lb1_penyakit_pelayanan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_lb1_penyakit_pelayanan_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&pelayanan=<?php echo $_GET['pelayanan'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>

	<?php
	$opsiform = $_GET['opsiform'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$pelayanan = $_GET['pelayanan'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- BERDASARKAN PELAYANAN <?php echo $pelayanan;?></b></span><br>
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

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Penyakit</th>
							<th colspan="7" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Kunjungan Kasus</th>
							<th colspan="18" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Kasus Baru & Lama Menurut olongan Umur</th>
							<th rowspan="2"  colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">Baru</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">Lama</th>
							<th colspan="3" style="text-align:center;border:1px solid #000; padding:3px;">Total</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">0-7Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">8-30Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;"><1Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">5-14Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">15-44Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-54Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">55-64Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>65</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Baru-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Lama-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Total-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Jml</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--0-7Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--8-30Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--<1Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--5-14Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--15-44Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--45-54Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--55-64Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!-- >65Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Total-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Jml</th>
						</tr>
					</thead>
					<tbody style="font-size:9.5px;">
						<?php
							$jumlah_perpage = 25;
							if($opsiform == 'bulan'){
								$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
								$semua = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND";
								
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
								// $tbpasienrj_1 = 'tbpasienrj_'.date('m',strtotime($keydate1));
								// $tbpasienrj_2 = 'tbpasienrj_'.date('m',strtotime($keydate2));
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
							
							if($pelayanan == 'POLI GIGI'){
								$str = "SELECT * FROM `tbdiagnosa` WHERE `KelompokDiagnosa` = 'Penyakit Sistem Pencernaan'";
							}else{
								$str = "SELECT * FROM `tbdiagnosa`";
							}
							$str2 = $str."order by `KodeDiagnosa` ASC limit $mulai,$jumlah_perpage";
										
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}		

							if($pelayanan == 'Semua'){
								$ply = "";
							}else{
								$ply = " AND a.PoliPertama = '$pelayanan'";
							}	
											
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$kodedgs = '%'.$data['KodeDiagnosaBPJS']."%";
								// kasus
								$baru_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'".$ply));
								$baru_P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'".$ply));
								$lama_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'".$ply));
								$lama_P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'".$ply));
								
								// total kasus
								$total_baru_l = $baru_L['Jml'] + $lama_L['Jml'];
								$total_baru_p = $baru_P['Jml'] + $lama_P['Jml'];
								$total_kasus = $total_baru_l + $total_baru_p;
								
								// umur17hr
								$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'".$ply));
								$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'".$ply));
								$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'".$ply));
								$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'".$ply));
								$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$ply));
								$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$ply));
								$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'".$ply));
								$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'".$ply));
								$umur514L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '14' AND a.JenisKelamin = 'L'".$ply));
								$umur514P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '14' AND a.JenisKelamin = 'P'".$ply));
								$umur1544L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '44' AND a.JenisKelamin = 'L'".$ply));
								$umur1544P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '44' AND a.JenisKelamin = 'P'".$ply));
								$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'".$ply));
								$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'".$ply));
								$umur5564L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'L'".$ply));
								$umur5564P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'P'".$ply));
								$umur65100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '65' AND '100' AND a.JenisKelamin = 'L'".$ply));
								$umur65100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '65' AND '100' AND a.JenisKelamin = 'P'".$ply));
								
								// total
								$t_lama_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur514L['Jml'] + $umur1544L['Jml'] + $umur4554L['Jml'] + $umur5564L['Jml'] + $umur65100L['Jml'];
								$t_lama_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur514P['Jml'] + $umur1544P['Jml'] + $umur4554P['Jml'] + $umur5564P['Jml'] + $umur65100P['Jml'];
								$total = $t_lama_l + $t_lama_p;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $baru_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $baru_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $lama_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $lama_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_baru_l;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_baru_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kasus;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur514L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur514P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1544L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1544P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5564L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5564P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65100L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65100P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $t_lama_l;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $t_lama_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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
						echo "<li><a href='?page=lap_lb1_penyakit_pelayanan&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&pelayanan=$pelayanan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	