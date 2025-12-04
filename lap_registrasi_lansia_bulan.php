<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LANSIA BULANAN LANSIA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia_bulan"/>
						<div class="col-xl-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>

						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
					
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia_bulan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_lansia_bulan_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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

	<div class="table-responsive noprint">
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th rowspan="3" width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
					<th rowspan="3" width="35%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">KEGIATAN</th>
					<th colspan="24"  width="60%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">KELOMPOK UMUR</th>
				</tr>
				<tr>
					<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-59TH</th>
					<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">60-69TH</th>
					<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>70TH</th>
					<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">TOTAL</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--45-59Th-->
					<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
					<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--60-69Th-->
					<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
					<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--70th-->
					<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
					<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Total-->
					<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
				</tr>
			</thead>				
			<tbody>
				<?php					
				if($opsiform == 'bulan'){
					$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				}else{
					$waktu1 = "TanggalRegistrasi >= '$keydate1'";
					$waktu2 = "TanggalRegistrasi <= '$keydate2'";
				}
									
				$str = "SELECT * FROM `tbkegiatanlblansia` order by `NoUrut`";
				$query = mysqli_query($koneksi,$str);
				while($data = mysqli_fetch_assoc($query)){
					$kodekegiatan = $data['KodeKegiatan'];
					$kegiatan = $data['Kegiatan'];
				
					if($data['KodeKelompok'] == '8' || $data['KodeKelompok'] == '9' || $data['KodeKelompok'] == '10' || $data['KodeKelompok'] == '11' || $data['KodeKelompok'] == '12' || $data['KodeKelompok'] == '13' || $data['KodeKelompok'] == '14'){
						echo "<tr style='border:1px solid #000;'><td style='text-align:right; border:1px solid #000; padding:3px;'>$data[KodeKelompok]</td>
							<td colspan='9' style='text-align:left; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
					}
				?>
						
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kodekegiatan;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kegiatan;?></td>
						<?php
							$umur4559_L= 0;
							$umur4559_P= 0;
							$umur6069_L= 0;
							$umur6069_P= 0;
							$umur70_L= 0;
							$umur70_P= 0;
							if($opsiform == 'bulan'){
								if($kegiatan == 'Jumlah semua lansia yg ada diwilayah posbindu / kelompok (s)'){
									
								}elseif($kegiatan == 'Jumlah Lansia yang terdaftar & dibina'){
									
								}elseif($kegiatan == 'Jumlah Lansia yang mempunyai KMS'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'Jumlah Lansia yang datang / diperiksa'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '45' AND '59' AND JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '45' AND '59' AND JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P'"));
								}elseif($kegiatan == 'Jumlah Lansia yang normal / sehat'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'Jumlah Lansia yang dirujuk ke Rumah Sakit'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. Kategori A'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. Kategori B'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'C. Kategori C'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. Emosional Ada'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. Emosional Tidak ada'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. IMT Lebih'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. IMT Normal'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'C. IMT Kurang'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. TD Tinggi'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. TD Normal'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'C. TD Rendah'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}
								$total_L = $umur4559_L + $umur6069_L + $umur70_L;
								$total_P = $umur4559_P + $umur6069_P + $umur70_P;
							}else{
								
							}
						?>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4559_L;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4559_P;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069_L;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069_P;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70_L;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70_P;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_L;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_P;?></td>
					</tr>	
				<?php
				}
				?>	
			</tbody>
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
</script>