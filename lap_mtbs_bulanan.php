<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>
<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LAPORAN PELAYANAN KESEHATAN MTBS</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_mtbs_bulanan"/>
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
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-3">
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
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=_bulanan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	if($_SESSION['kodepuskesmas'] == '-'){
		$kdpuskesmas = $_GET['kodepuskesmas'];
		
	}else{
		$kdpuskesmas = "$kodepuskesmas";
	}

	if($bulan != null AND $tahun != null){
	?>

	<!--data registrasi-->
	<div class="table-responsive " style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN KESEHATAN MTBS</b></span><br>
			<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p>
			<br/>
		</div>

		<div class="atastabel">
			<div style="float:left; width:35%; margin-bottom:10px;">	
				<table style="font-size:12px; width:300px;">
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

		<!--tabel view-->
		<div class="row ">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table-judul-laporan">
						<thead>
							<tr>
								<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle;border:1px solid #000; padding:3px;">No.</th>
								<th rowspan="2" style="text-align:center;width:80%;vertical-align:middle;border:1px solid #000; padding:3px;">Kegiatan</th>
								<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle;border:1px solid #000; padding:3px;">Jumlah</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
								$str = "SELECT * FROM `tbkegiatanmtbs` ORDER BY `KodeKegiatan` ";
								$query = mysqli_query($koneksi,$str);
								while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
							?>
								<tr style="border:1px solid #000;">
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeKegiatan'];?></td>
									<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Kegiatan'];?></td>
									<?php
										$jml = 0;
										if($data['Kegiatan'] == 'Jumlah Balita Sakit yang Datang ke Puskesmas'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi)='$bulan' and YEAR(TanggalRegistrasi)='$tahun' and SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' and PoliPertama='POLI MTBS'"));
										}elseif($data['Kegiatan'] == 'Balita yang Mendapatkan Pelayanan MTBS'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Pelayanan MTBS Dalam Wilayah'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a left join `$tbkk` b on a.NoIndex=b.NoIndex WHERE MONTH(a.TanggalRegistrasi)='$bulan' and YEAR(a.TanggalRegistrasi)='$tahun' and SUBSTRING(a.NoRegistrasi,1,11)='$kdpuskesmas' and PoliPertama='POLI MTBS' and b.Wilayah='DALAM'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Pelayanan MTBS Luar Wilayah'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a left join `$tbkk` b on a.NoIndex=b.NoIndex WHERE MONTH(a.TanggalRegistrasi)='$bulan' and YEAR(a.TanggalRegistrasi)='$tahun' and SUBSTRING(a.NoRegistrasi,1,11)='$kdpuskesmas' and PoliPertama='POLI MTBS' and b.Wilayah='LUAR'"));
										// pneumonia
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Pneumonia Berat/Penyakit Sangat Berat'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiPneumonia`='Pneumonia Berat'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Pneumonia'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiPneumonia`='Pneumonia'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Batuk Bukan Pneumonia'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiPneumonia`='Batuk bukan pneumonia'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Dehidrasi Berat'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDiare`='Dehidrasi Berat'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Dehidrasi Sedang atau Ringan'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDiare`='Dehidrasi Sedang atau Ringan'"));
										// diare
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Diare Tanpa Dehidrasi'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDiare`='Diare Tanpa Dehidrasi'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Diare Persisten Berat'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDiare`='Diare Persisten Berat'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Diare Persisten'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDiare`='Diare Persisten'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Disentri'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDiare`='Disentri'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Berat Dengan Demam'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDemam`='Penyakit Berat Dengan Demam'"));
										// malaria
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Malaria'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDemam`='Penyakit Malaria'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Demam Mungkin Bukan Malaria'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDemam`='Demam Mungkin Bukan Malaria'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Demam Bukan Malaria'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDemam`='Demam Bukan Malaria'"));
										// campak
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Campak Dengan Komplikasi Berat'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiCampak`='Penyakit Campak Dengan Komplikasi Berat'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Campak Dengan Komplikasi Pada Mata/Mulut'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiCampak`='Penyakit Campak Komplikasi Pada Mata/Mulut'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Campak'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiCampak`='Penyakit Campak'"));
										// dbd
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Demam Berdarah Denguage (DBD)'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDBD`='Penyakit Demam Berdarah Dengue (DBD)'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Demam Mungkin DBD'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDBD`='Penyakit Demam Mungkin DBD'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Penyakit Demam Mungkin Bukan DBD'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiDBD`='Penyakit Demam Mungkin Bukan DBD'"));
										// telinga
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Mastoiditis'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiTelinga`='Mastoiditis'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Infeksi Telinga Akut'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiTelinga`='Infeksi Telinga Akut'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Infeksi Telinga Kronis'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiTelinga`='Infeksi Telinga Kronis'"));
										}elseif($data['Kegiatan'] == 'Tidak Ada Infeksi Telinga'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiTelinga`='Tidak ada Infeksi Telinga'"));
										// Gizi
										}elseif($data['Kegiatan'] == 'Jumlah Balita Gizi Buruk dengan Komplikasi'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiGizi`='Gizi Buruk Dengan Komplikasi'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Gizi Buruk tanpa Komplikasi'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiGizi`='Gizi Buruk Tanpa Komplikasi'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita dengan Gizi Kurang'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiGizi`='Gizi Kurang'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita dengan Gizi Baik'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiGizi`='Gizi Baik'"));
										// anemia
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Anemia Berat'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiGizi`='Anemia Berat'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit dengan Anemia'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiAnemia`='Anemia'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Tidak Anemia'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiAnemia`='Tidak Anemia'"));
										// hiv
										}elseif($data['Kegiatan'] == 'Jumlah Balita Infeksi HIV Terkonfirmasi'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiAnemia`='Infeksi HIV Terkonfirmasi'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Diduga Terinveksi HIV'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiAnemia`='Diduga Terinfeksi HIV'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita terpajan HIV'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiAnemia`='Terpajan HIV'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Kemungkinan Bukan Infeksi HIV'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiAnemia`='Kemungkinan Bukan Inveksi HIV'"));
										// rujukan
										}elseif($data['Kegiatan'] == 'Jumlah Rujukan Pada Balita degan Pelayanan MTBS ke Dokter Puskesmas'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiImunisasi`='Balita Sakit Dengan Pelayanan Mtbs'"));
										}elseif($data['Kegiatan'] == 'Jumlah Rujukan Pada Balita dengan Pelayanan MTBS ke RS'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiImunisasi`='Balita Sakit Dengan Pelayanan Mtbs ke RS'"));
										// imunisasi
										}elseif($data['Kegiatan'] == 'Jumlah Balita Dengan Pelayanan MTBS Seharusnya di Imunisasi'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiImunisasi`='Pelayanan Mtbs Seharusnya di Imunisasi'"));
										}elseif($data['Kegiatan'] == 'Jumlah Balita Sakit yang Patuh di Imunisasi'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiImunisasi`='Patuh Untuk di Imunisasi'"));
										// kunjungan ulang
										}elseif($data['Kegiatan'] == 'Datang Tepat untuk Kunjungan Ulang'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiRujuk`='Datang Tepat Untuk Kunjungan Ulang'"));
										}elseif($data['Kegiatan'] == 'Tidak Tepat datang untuk Kunjungan Ulang'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiRujuk`='Tidak Tepat Datang Untuk Kunjungan Ulang'"));
										}elseif($data['Kegiatan'] == 'Tidak Datang untuk Kunjungan Ulang'){
											$jml = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolimtbs` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kdpuskesmas' and `KlasifikasiRujuk`='Tidak Datang Untuk Kunjungan Ulang'"));
										}
									?>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml['Jml'];?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	