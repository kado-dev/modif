<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DIARE (BULANAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Diare_Bulanan_Dinkes"/>
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
							<a href="?page=lap_P2M_Diare_Bulanan_Dinkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Diare_Bulanan_Dinkes_Excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['kodepuskesmas'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepkm = $_GET['kodepuskesmas'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px dashed #000;">
							<th rowspan="4">No.</th>
							<th rowspan="4" width="15%">Nama Puskesmas</th>
							<th colspan="22">Sarana Kesehatan</th>
							<th colspan="19">Kader</th>
							<th colspan="7">Total Sarana Kesehatan & Kader</th>
							<th colspan="3">Derajat Dehidrasi</th>
							<th colspan="2">Pemeriksaan Lab</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th colspan="4"><1 Thn</th><!--sarana kesehatan-->
							<th colspan="4">1-4 Thn</th>
							<th colspan="4">>5 Thn</th>
							<th colspan="4">Jumlah</th>
							<th rowspan="2" colspan="3">Jml Penderita Diberi</th>
							<th rowspan="2" colspan="3">Jml Pemakaian</th>
							<th colspan="4"><1 Thn</th><!--kader-->
							<th colspan="4">1-4 Thn</th>
							<th colspan="4">>5 Thn</th>
							<th colspan="4">Jumlah</th>
							<th rowspan="2" colspan="3">Jml Pemakaian</th><!--total sarana kesehatan & kader-->
							<th rowspan="2" colspan="2">P</th>
							<th rowspan="2" colspan="2">M</th>
							<th rowspan="2" colspan="3">Pemakaian</th>
							<th rowspan="3" width="4%">Tanpa Dehidrasi</th><!--derajat dehidrasi-->
							<th rowspan="3" width="3%">Sedang</th>
							<th rowspan="3" width="3%">Berat</th>
							<th rowspan="3" width="4%">Jumlah Spesimen</th><!--Pemeriksaan Lab-->
							<th rowspan="3">POS</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th colspan="2">P</th><!--sarana kesehatan-->
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th><!--kader-->
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th>L</th><!--Penderita-Laki-<1thn--><!--sarana kesehatan-->
							<th>P</th><!--Penderita-Perempuan_<1thn-->
							<th>L</th><!--Meninggal-Laki-<1thn-->
							<th>P</th><!--Meninggal-Perempuan<1thn-->
							<th>L</th><!--Penderita-Laki-1-4thn-->
							<th>P</th><!--Penderita-Laki-1-4thn-->
							<th>L</th><!--Meninggal-Laki-1-4thn-->
							<th>P</th><!--Meninggal-Perempuan-1-4thn-->
							<th>L</th><!--Penderita-Laki->5thn-->
							<th>P</th><!--Penderita-Perempuan->5thn-->
							<th>L</th><!--Meninggal-Laki->5thn-->
							<th>P</th><!--Meninggal-Perempuan>5thn-->
							<th>L</th><!--Penderita-Laki-Jumlah-->
							<th>P</th><!--Penderita-Perempuan-Jumlah-->
							<th>L</th><!--Meninggal-Laki-Jumlah-->
							<th>P</th><!--Meninggal-Perempuan-Jumlah-->
							<th>Orl</th>
							<th>Znc</th>
							<th>Rl</th>
							<th>Orl</th>
							<th>Znc</th>
							<th>Rl</th>
							<th>L</th><!--Penderita-Laki-<1thn--><!--kader-->
							<th>P</th><!--Penderita-Perempuan_<1thn-->
							<th>L</th><!--Meninggal-Laki-<1thn-->
							<th>P</th><!--Meninggal-Perempuan<1thn-->
							<th>L</th><!--Penderita-Laki-1-4thn-->
							<th>P</th><!--Penderita-Laki-1-4thn-->
							<th>L</th><!--Meninggal-Laki-1-4thn-->
							<th>P</th><!--Meninggal-Perempuan-1-4thn-->
							<th>L</th><!--Penderita-Laki->5thn-->
							<th>P</th><!--Penderita-Perempuan->5thn-->
							<th>L</th><!--Meninggal-Laki->5thn-->
							<th>P</th><!--Meninggal-Perempuan>5thn-->
							<th>L</th><!--Penderita-Laki-Jumlah-->
							<th>P</th><!--Penderita-Perempuan-Jumlah-->
							<th>L</th><!--Meninggal-Laki-Jumlah-->
							<th>P</th><!--Meninggal-Perempuan-Jumlah-->
							<th>Orl</th>
							<th>Znc</th>
							<th>Rl</th>
							<th>L</th><!--Penderita-Laki-<1thn--><!--total sarana kesehatan & kader-->
							<th>P</th><!--Penderita-Perempuan_<1thn-->
							<th>L</th><!--Meninggal-Laki-<1thn-->
							<th>P</th><!--Meninggal-Perempuan<1thn-->
							<th>Orl</th>
							<th>Znc</th>
							<th>Rl</th>
						</tr>
					</thead>
					<tbody style="font-size:10px">
						<?php
						$jumlah_perpage = 10;					
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// insert ke tbdiagnosapasien_bulan
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'";
						$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
						mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
						while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
							$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
							('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
							mysqli_query($koneksi, $strdiagnosa);
						}
											
						if($kodepkm == 'semua'){
							$str = "SELECT * FROM `tbpuskesmas`";
						}else{
							$str = "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepkm'";
						}
						$str2 = $str." ORDER BY `NamaPuskesmas` ASC limit $mulai,$jumlah_perpage";
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}		
									
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodepuskesmas2 = "AND SUBSTRING(a.NoRegistrasi,1,11)="."'$data[KodePuskesmas]'";
						
							// Sarana Kesehatan
							$data_diare_0_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
							$data_diare_0_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
							$data_diare_1_4_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
							$data_diare_1_4_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
							$data_diare_5_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
							$data_diare_5_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
							$jumlah_Sarana_Laki = $data_diare_0_Laki['Jumlah'] + $data_diare_1_4_Laki['Jumlah'] + $data_diare_5_Laki['Jumlah'];
							$jumlah_Sarana_Perempuan = $data_diare_0_Perempuan['Jumlah'] + $data_diare_1_4_Perempuan['Jumlah'] + $data_diare_5_Perempuan['Jumlah'];
							
							// jumlah penderita diberi
							$str_pemberian = "SELECT `TindakanPengobatan` FROM `tbdiagnosadiare` WHERE `Kelurahan` = '$kelurahan'";
							$query_pemberian = mysqli_query($koneksi,$str_pemberian);
							
							while($data_pemberian = mysqli_fetch_array($query_pemberian)){
								$array_data[$dtkelurahan['Kelurahan']][] = $data_pemberian['TindakanPengobatan'];
							}

							$data_pmb = implode(",",$array_data[$dtkelurahan['Kelurahan']]);
							$acv = array_count_values(explode(",",$data_pmb));	
								$jmloralit = $acv['Oralit'];
								$jmlzinc = $acv['Zinc'];
								$jmlinfus = $acv['Infus'];
							//echo $data_pmb."<br/>";
							
							// jumlah pemakaian sarana kesehatan
							$data_oralit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.NamaBarang like '%oralit%'"));
							$data_zink = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.NamaBarang like '%zink%'"));
							$data_rl = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.NamaBarang like '%ringer laktat%'"));
							if ($data_oralit != ''){
								$oralit = $data_oralit['JumlahObat'];
							}else{
								$oralit = 0;
							}
							
							if ($data_zink != ''){
								$zink = $data_zink['JumlahObat'];
							}else{
								$zink = 0;
							}
							
							if ($data_rl != ''){
								$ringer_laktat = $data_rl['JumlahObat'];
							}else{
								$ringer_laktat = 0;
							}						
							
							// Sarana Kader
							$data_diare_0_Laki_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_0_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_1_4_Laki_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_1_4_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_5_Laki_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_5_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$jumlah_sarana_Laki_Kader =  mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$jumlah_sarana_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
						
							// Total Sarana Kesehatan dan Kader
							$total_p_l = $jumlah_Sarana_Laki + $jumlah_sarana_Laki_Kader['Jumlah'];
							$total_p_p = $jumlah_Sarana_Perempuan + $jumlah_sarana_Perempuan_Kader['Jumlah'];
							
							// jumlah pemakaian kader
							$data_oralit_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%oralit%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
							$data_zink_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%zink%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
							$data_rl_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%ringer laktat%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
							if ($data_oralit_kdr != ''){
								$oralit_kdr = $data_oralit_kdr['JumlahObat'];
							}else{
								$oralit_kdr = 0;
							}
							
							if ($data_zink_kdr != ''){
								$zink_kdr = $data_zink_kdr['JumlahObat'];
							}else{
								$zink_kdr = 0;
							}
							
							if ($data_rl_kdr != ''){
								$ringer_laktat_kdr = $data_rl_kdr['JumlahObat'];
							}else{
								$ringer_laktat_kdr = 0;
							}

							// jumlah pemakaian sarana kesehatan dan kader
							$jml_oralit = $oralit + $oralit_kdr;
							$jml_zinc = $zink + $zink_kdr;
							$jml_ringer_laktat = $ringer_laktat + $ringer_laktat_kdr;
							
							// derajat dehidrasi
							$data_dehidrasi_ringan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Tanpa Dehidrasi' AND Kelurahan = '$kelurahan'"));
							$data_dehidrasi_sedang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Sedang' AND Kelurahan = '$kelurahan'"));
							$data_dehidrasi_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Berat' AND Kelurahan = '$kelurahan'"));
							?>
						
							<tr style="border:1px dashed #000;">
								<td style="border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
								<td style="border:1px dashed #000; padding:3px;"><?php echo $data['NamaPuskesmas'];?></td>
								<!--sarana kesehatan-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_0_Laki['Jumlah'];?></td><!--sarana kesehatan-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_0_Perempuan['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_1_4_Laki['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_1_4_Perempuan['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_5_Laki['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_5_Perempuan['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $jumlah_Sarana_Laki;?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $jumlah_Sarana_Perempuan;?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<!--jumlahpenderita-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($jmloralit,0);?></td><!--Oralit-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($jmlzinc,0);?></td><!--Zinc-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($jmlinfus,0);?></td><!--RL-->
								<!--jumlahpemakaian-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($oralit,0);?></td><!--Oralit--><!--jumlah pemakaian-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($zink,0);?></td><!--Zink-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($ringer_laktat,0);?></td><!--RL-->
								<!--kader-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_0_Laki_Kader['Jumlah'];?></td><!--kader-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_0_Perempuan_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_1_4_Laki_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_1_4_Perempuan_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_5_Laki_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_diare_5_Perempuan_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $jumlah_sarana_Laki_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $jumlah_sarana_Perempuan_Kader['Jumlah'];?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<!--jumlahpemakaian-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($oralit_kdr,0);?></td><!--Oralit-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($zink_kdr,0);?></td><!--Zinc-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($ringer_laktat_kdr,0);?></td><!--RL-->
								<!--total sarana dan kader-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $total_p_l;?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $total_p_p?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td>
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($jml_oralit,0);?></td><!--Oralit-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($jml_zinc,0);?></td><!--Zinc-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo round($jml_ringer_laktat,0);?></td><!--RL-->
								<!--derajat dehidrasi-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_dehidrasi_ringan['Jumlah'];?></td><!--Tanpa Dehidrasi--><!--derajat dehidrasi-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_dehidrasi_sedang['Jumlah'];?></td><!--Ringan/Sedang-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_dehidrasi_berat['Jumlah'];?></td><!--Dehidrasi Berat-->
								<!--lab-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td><!--Jumlah Spesimen--><!--pemeriksaan lab-->
								<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo '-';?></td><!--POS-->
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br/>
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
						echo "<li><a href='?page=lap_P2M_Diare_Bulanan_Dinkes&bulan=$bulan&tahun=$tahun&kodepuskesmas=$kodepkm&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>

	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b> A03.0, A06.0, A09<br>
				Kelurahan dambil berdasar kasus/kejadian.</p>
			</div>
		</div>
	</div>
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