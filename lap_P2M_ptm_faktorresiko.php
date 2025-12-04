<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>
<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PTM (FAKTOR RESIKO)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_ptm_faktorresiko"/>
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
						<div class="col-sm-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_ptm_faktorresiko" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_ptm_faktorresiko_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>


	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:2px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>REKAPITULASI FAKTOR RESIKO PTM</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	</div><br/>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">NO.</th>
							<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">PENYAKIT TIDAK MENULAR</th>
							<th colspan="14" width="60%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">JENIS KELAMIN DAN UMUR (TH)</th>
							<th rowspan="3" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">TOTAL</th>
						</tr>
						<tr>
							<th colspan="7" width="50%" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">LAKI (L)</th>
							<th colspan="7" width="50%" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">PEREMPUAN (P)</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;"><18</th><!--15-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">18-44</th><!--15-19-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">45-54</th><!--45-54-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">55-59</th><!--55-59-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">60-69</th><!--60-69-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">>70</th><!--70-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">JML</th>
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;"><18</th><!--15-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">18-44</th><!--15-19-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">45-54</th><!--45-54-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">55-59</th><!--55-59-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">60-69</th><!--60-69-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">>70</th><!--70-->
							<th width="3%" style="text-align:center; border:1px solid #000; padding:2px;">JML</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbdiagnosaptmfaktorresiko`";
						$str2 = $str." ORDER BY `IdFaktor`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$jml = 0;
							if($data['Kelompok'] == 'Merokok'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Merokok%'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Merokok%'"));
							}elseif($data['Kelompok'] == 'Aktivitas Fisik'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
							}elseif($data['Kelompok'] == 'Makan Sayur'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
							}elseif($data['Kelompok'] == 'Minum Alkohol'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
							}elseif($data['Kelompok'] == 'Berat Badan'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `StatusImt` = 'L'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `StatusImt` = 'L'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `StatusImt` = 'L'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `StatusImt` = 'L'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `StatusImt` = 'L'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `StatusImt` = 'L'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `StatusImt` = 'L'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `StatusImt` = 'L'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `StatusImt` = 'L'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `StatusImt` = 'L'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `StatusImt` = 'L'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `StatusImt` = 'L'"));
							}elseif($data['Kelompok'] == 'Obesitas'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `Imt` > '27'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `Imt` > '27'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `Imt` > '27'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `Imt` > '27'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `Imt` > '27'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `Imt` > '27'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `Imt` > '27'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `Imt` > '27'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `Imt` > '27'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `Imt` > '27'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `Imt` > '27'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `Imt` > '27'"));
							}elseif($data['Kelompok'] == 'Obesitas Sentral'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `LingkarPerut` >= '90'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `LingkarPerut` >= '90'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `LingkarPerut` >= '90'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `LingkarPerut` >= '90'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `LingkarPerut` >= '90'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `LingkarPerut` >= '90'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `LingkarPerut` >= '80'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `LingkarPerut` >= '80'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `LingkarPerut` >= '80'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `LingkarPerut` >= '80'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `LingkarPerut` >= '80'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `LingkarPerut` >= '80'"));
							}elseif($data['Kelompok'] == 'Gula Darah'){
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `GdsLab` > '200'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `GdsLab` > '200'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `GdsLab` > '200'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `GdsLab` > '200'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `GdsLab` > '200'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `GdsLab` > '200'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `GdsLab` > '200'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `GdsLab` > '200'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `GdsLab` > '200'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `GdsLab` > '200'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `GdsLab` > '200'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `GdsLab` > '200'"));
							}elseif($data['Kelompok'] == 'Kolesterol'){		
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `KolesLab` >= '190'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `KolesLab` >= '190'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `KolesLab` >= '190'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `KolesLab` >= '190'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `KolesLab` >= '190'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `KolesLab` >= '190'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `KolesLab` >= '190'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `KolesLab` >= '190'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `KolesLab` >= '190'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `KolesLab` >= '190'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `KolesLab` >= '190'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `KolesLab` >= '190'"));
							}elseif($data['Kelompok'] == 'Trigliserida'){
								// laki
								$umur_1_17_L = '0';
								$umur_18_44_L = '0';
								$umur_45_54_L = '0';
								$umur_55_59_L = '0';
								$umur_60_69_L = '0';
								$umur_70L = '0';
								// perempuan
								$umur_1_17_P = '0';
								$umur_18_44_P = '0';
								$umur_45_54_P = '0';
								$umur_55_59_P = '0';
								$umur_60_69_P = '0';
								$umur_70P = '0';
							}elseif($data['Kelompok'] == 'Hipertensi'){	
								// laki
								$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `Sistole` >= '140'"));
								$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `Sistole` >= '140'"));
								$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `Sistole` >= '140'"));
								$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `Sistole` >= '140'"));
								$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `Sistole` >= '140'"));
								$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `Sistole` >= '140'"));
								// perempuan
								$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `Sistole` >= '140'"));
								$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `Sistole` >= '140'"));
								$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `Sistole` >= '140'"));
								$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `Sistole` >= '140'"));
								$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `Sistole` >= '140'"));
								$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `Sistole` >= '140'"));
							}	
							// jumlah
							$jumlah_L = $umur_1_17_L['Jml'] + $umur_18_44_L['Jml'] + $umur_45_54_L['Jml'] + $umur_55_59_L['Jml'] + $umur_60_69_L['Jml'] + $umur_70L['Jml'];
							$jumlah_P = $umur_1_17_P['Jml'] + $umur_18_44_P['Jml'] + $umur_45_54_P['Jml'] + $umur_55_59_P['Jml'] + $umur_60_69_P['Jml'] + $umur_70P['Jml'];
							// total
							$total = $jumlah_L + $jumlah_P;	
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $data['FaktorResiko'];?></td>
								<td align="right"><?php echo $umur_1_17_L['Jml'];?></td><!--laki-->
								<td align="right"><?php echo $umur_18_44_L['Jml'];?></td>
								<td align="right"><?php echo $umur_45_54_L['Jml'];?></td>
								<td align="right"><?php echo $umur_55_59_L['Jml'];?></td>
								<td align="right"><?php echo $umur_60_69_L['Jml'];?></td>
								<td align="right"><?php echo $umur_70L['Jml'];?></td>
								<td align="right"><?php echo $jumlah_L;?></td>
								<td align="right"><?php echo $umur_1_17_P['Jml'];?></td><!--perempuan-->
								<td align="right"><?php echo $umur_18_44_P['Jml'];?></td>
								<td align="right"><?php echo $umur_45_54_P['Jml'];?></td>
								<td align="right"><?php echo $umur_55_59_P['Jml'];?></td>
								<td align="right"><?php echo $umur_60_69_P['Jml'];?></td>
								<td align="right"><?php echo $umur_70P['Jml'];?></td>
								<td align="right"><?php echo $jumlah_P;?></td>
								<td align="right"><?php echo $total;?></td>
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

<div class="row noprint">
	<div class="col-sm-12">
		<div class="alert alert-block alert-success fade in">
			<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
			<p>
				<b>Perhatikan :</b><br/>
				1. Merokok, data dari pemerksaan pelayanan Lansia pada pemeriksaan penunjang<br/>
				2. Kurang Aktifitas Fisik, data dari pemerksaan pelayanan Lansia pada pemeriksaan penunjang<br/>
				3. Kurang Konsumsi Sayur dan Buah, data dari pemerksaan pelayanan Lansia pada pemeriksaan penunjang<br/>
				4. Konsumsi Minuman Beralkohol, data dari pemerksaan pelayanan Lansia pada pemeriksaan penunjang<br/>
				5. BB Lebih (IMT = 25-27kg/m2), data dari pemerksaan pelayanan Lansia pada StatusImt = L (Lebih) <br/>
				6. Obesitas (IMT > 27kg/m2), data dari pemerksaan pelayanan Lansia pada Imt > 27<br/>
				7. Obesitas Sentral (LP > 90cm (L); LP > 80cm (P)), data dari pemerksaan pelayanan Lansia pada LingkarPerut >= '90'<br/>
				8. Gula Darah Sewaktu (>200mg/dL), data dari pemerksaan pelayanan Lansia pada hasil GdsLab > 200<br/>
				9. Kolesterol Total (>190mg/dL), data dari pemerksaan pelayanan Lansia pada hasil KolesLab >= 190<br/>
				10. Trigliserida (>150 mg/dL), data dari pemerksaan pelayanan Lansia pada hasil Trigliserida >=150<br/>
				11. Hipertensi (>140/90 mmHg), data dari pemerksaan pelayanan Lansia pada pemeriksaan Sistole >= 140<br/>
			</p>
		</div>
	</div>
</div>