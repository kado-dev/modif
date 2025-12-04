<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LAPORAN CAKUPAN ANTENATAL (ANC)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_kia_anc"/>
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
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_registrasi_kunjungan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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
	if(isset($bulan) and isset($tahun)){
	?>

	<!--data registrasi-->
	<div class="noprint">
		<div class="table-responsive noprint">
			<table class="table-judul-laporan">
				<thead style="font-size:10px;">
					<tr style="border:1px solid #000;">
						<th width="1%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th width="10%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan / Desa</th>
						<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Penduduk</th>
						<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Ibu Hamil</th>
						<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Bumil Resti</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Mempunyai Buku KIA</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">K1</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">K4</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T1</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T2</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T3</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T4</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T5</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T2+</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Fe 1</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Fe 3</th>
						<th  colspan="4" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Deteksi Resiko</th>
						<th  colspan="4" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Rujukan Kasus Risiko Tinggi</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">ANC Didampingi</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
						<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Nakes</th>
						<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Masya.</th>
						<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Maternal</th>
						<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Neonatal</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
						<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
					</tr>
				
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' ORDER BY Kelurahan";
					$query = mysqli_query($koneksi,$str_puskesmas);
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kelurahan = $data['Kelurahan'];
					
					$JmlBumil = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex  WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.`PoliPertama` = 'POLI KIA' AND b.Kelurahan = '$kelurahan'"));
					//$BumilResti = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpolikia` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND `PoliPertama` = 'POLI KIA'"));
					$BukuKia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT  COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.`CatatBukuKia` = 'YA' AND b.Kelurahan = '$kelurahan'"));
					$k1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND (a.KunjunganKehamilan = 'K1 Akses' OR a.KunjunganKehamilan = 'K1 Murni') AND b.Kelurahan = '$kelurahan'"));
					$k4 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND (a.KunjunganKehamilan = 'K4' OR a.KunjunganKehamilan = 'K4 Akses') AND b.Kelurahan = '$kelurahan'"));
					$T1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT1' AND b.Kelurahan = '$kelurahan'"));
					$T2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT2' AND b.Kelurahan = '$kelurahan'"));
					$T3 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT3' AND b.Kelurahan = '$kelurahan'"));
					$T4 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT4' AND b.Kelurahan = '$kelurahan'"));
					$T5 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT5' AND b.Kelurahan = '$kelurahan'"));
					$T2plus = $T2['Jml'] + $T3['Jml'] + $T4['Jml'] + $T5['Jml'];
					$F1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.FE = 'FE 1' AND b.Kelurahan = '$kelurahan'"));
					$F3 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.FE = 'FE 3' AND b.Kelurahan = '$kelurahan'"));
					$Nakes = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.DeteksiResiko = 'Tenaga Kesehatan' AND b.Kelurahan = '$kelurahan'"));
					$Masyarakat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.DeteksiResiko = 'Masyarakat' AND b.Kelurahan = '$kelurahan'"));
					
					
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Kelurahan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">Sasaran</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $JmlBumil;?></td>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $BumilResti;?></td>		
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $BukuKia['Jml'];?></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $k1['Jml'];?></td>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $k4['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T1['Jml'];?></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T2['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T3['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T4['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T5['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T2plus;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $F1['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $F3['Jml'];?></td>				
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $Nakes['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $Masyarakat['Jml'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<hr class="noprint">
</div>
<?php
}
?>

<!--tabel report-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$_SESSION[kodepuskesmas]'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
	<br/>
		<?php 
		if($kdpuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota1;?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
			<p style="margin:5px;"><?php echo $alamat;?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN CAKUPAN ANTENATAL (ANC)</b></h4>

		<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p>
		
		<br/>
</div>

<div class="table-responsive printbody">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px solid #000;">
				<th width="1%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th width="10%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan / Desa</th>
				<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Penduduk</th>
				<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Ibu Hamil</th>
				<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Bumil Resti</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Mempunyai Buku KIA</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">K1</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">K4</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T1</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T2</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T3</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T4</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T5</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">T2+</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Fe 1</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Fe 3</th>
				<th  colspan="4" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Deteksi Resiko</th>
				<th  colspan="4" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Rujukan Kasus Risiko Tinggi</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">ANC Didampingi</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
				<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Nakes</th>
				<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Masya.</th>
				<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Maternal</th>
				<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Neonatal</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">Abs</th>
				<th style="text-align:center;border:1px solid #000; padding:3px;width:2%;">%</th>
			</tr>
		
		</thead>
		<tbody style="font-size:10px;">
			<?php
			$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' ORDER BY Kelurahan";
			$query = mysqli_query($koneksi,$str_puskesmas);
			$no = 0;
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$kelurahan = $data['Kelurahan'];
			
			$JmlBumil = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex  WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.`PoliPertama` = 'POLI KIA' AND b.Kelurahan = '$kelurahan'"));
			//$BumilResti = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpolikia` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND `PoliPertama` = 'POLI KIA'"));
			$BukuKia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT  COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.`CatatBukuKia` = 'YA' AND b.Kelurahan = '$kelurahan'"));
			$k1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND (a.KunjunganKehamilan = 'K1 Akses' OR a.KunjunganKehamilan = 'K1 Murni') AND b.Kelurahan = '$kelurahan'"));
			$k4 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND (a.KunjunganKehamilan = 'K4' OR a.KunjunganKehamilan = 'K4 Akses') AND b.Kelurahan = '$kelurahan'"));
			$T1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT1' AND b.Kelurahan = '$kelurahan'"));
			$T2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT2' AND b.Kelurahan = '$kelurahan'"));
			$T3 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT3' AND b.Kelurahan = '$kelurahan'"));
			$T4 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT4' AND b.Kelurahan = '$kelurahan'"));
			$T5 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.TT = 'TT5' AND b.Kelurahan = '$kelurahan'"));
			$T2plus = $T2['Jml'] + $T3['Jml'] + $T4['Jml'] + $T5['Jml'];
			$F1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.FE = 'FE 1' AND b.Kelurahan = '$kelurahan'"));
			$F3 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.FE = 'FE 3' AND b.Kelurahan = '$kelurahan'"));
			$Nakes = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.DeteksiResiko = 'Tenaga Kesehatan' AND b.Kelurahan = '$kelurahan'"));
			$Masyarakat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoPemeriksaan) AS Jml FROM `tbpolikia` a JOIN `$tbkk` b  ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.DeteksiResiko = 'Masyarakat' AND b.Kelurahan = '$kelurahan'"));
			
			
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Kelurahan'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;">Sasaran</td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $JmlBumil;?></td>	
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $BumilResti;?></td>		
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $BukuKia['Jml'];?></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $k1['Jml'];?></td>	
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $k4['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T1['Jml'];?></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T2['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T3['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T4['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T5['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $T2plus;?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $F1['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $F3['Jml'];?></td>				
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $Nakes['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $Masyarakat['Jml'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
