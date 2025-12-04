<?php
	include "otoritas.php";
	include "config/helper_report.php";	
	include "config/helper_pasienrj.php";
?>

<style type="text/css">
td {
    padding: 5px;
}
.rotate {
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  width: 1.5em;
}
.rotate div {
    -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
    -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
	-webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
    filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
	margin-left: -5em;
	margin-right: -5em;
	margin-top: -6em;
}
.kolom2{
	-moz-transform: rotate(-90.0deg);  /* FF3.5+ */
    -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
	-webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
    filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
	margin-left: -5em;
	margin-right: -5em;
	margin-top: -4em;
}
</style>
<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css">

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>REGISTER KIA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_registrasi_kia_bulungankab"/>
						<div class="col-sm-2">
							<SELECT name="bulan" class="form-control">
								<option value='semua'>Semua</option>
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
							</SELECT>
						</div>
						<div class="col-sm-1 " style ="width:125px">
							<SELECT name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</SELECT>
						</div>
						<div class="col-sm-2">
							<select type="text" name="kelurahan" class="form-control cari">
								<option value='semua'>Semua</option>
								<?php
								$qkel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas`='$kodepuskesmas' ORDER BY `Kelurahan`");
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
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_kia_bulungankab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_registrasi_kia_bulungankab_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kelurahan = $_GET['kelurahan'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER POLI KIA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
		<br/>
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
			<table>
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

	<div class="noprint">
		<div class="table-responsive noprint">
			<table class="table-judul-laporan-min" style="width:1800px">
				<thead style="font-size:10px;">
					<tr style="border:1px solid #000;">
						<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th colspan="5" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Register</th>
						<th colspan="16" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemeriksaan</th>
						<th rowspan="4" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Konseling</div></th>
						<th rowspan="4" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Status Imunisasi TT</div></th>
						<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
						<th colspan="8" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Laboratorium</th>
						<th rowspan="4" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Riwayat SC</div></th>
					</tr>
					<tr style="border:1px solid #000;">
						<th rowspan="3" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl</th><!--Register-->
						<th rowspan="3" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
						<th rowspan="3" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Ibu</th>
						<th rowspan="3" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Usia Kehamilan</div></th>
						<th rowspan="3" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Trimester</div></th>
						<th colspan="11" style="text-align:center; border:1px solid #000; padding:3px;">Ibu</th><!--Pemeriksaan-->
						<th colspan="5" style="text-align:center; border:1px solid #000; padding:3px;">Bayi</th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Injeksi TT</div></th><!--Pelayanan-->
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Catat Buku KIA</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Fe (tab/btl)</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>K1 HB (gr/dl)</div></th><!--Laboratorium-->
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Protein Urin (+/-)</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Gula Darah (+/-)</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>K4 HB (gr/dl)</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Sifilis (+/-)</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>HBsAg (+/-)</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>Golongan Darah</div></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><div>HIV</div></th>
					</tr>
					<tr style="border:1px solid #000;">
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">Kunjungan</th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">G/P/A</th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">Hpht</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:30px 0px 40px 0px;">Anamnesis</th><!--Ibu-->
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">BB</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">TB</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">TD</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">TFU</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">Lila</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">S.Gizi</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">R.Patella</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">DJJ</p></th><!--Bayi-->
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">THD</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">TBJ</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">Jml.Janin</p></th>
						<th rowspan="2" class="rotate" style="text-align:center; border:1px solid #000; padding:3px;"><p class="kolom2">Presentasi</p></th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$jumlah_perpage = 20;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}				
					
					$tbpasien = 'tbpasien_'.$tahun;
					$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
					$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
					
					if ($bulan == 'semua'){
						if($kelurahan == 'semua'){
							$str = "SELECT * FROM `$tbpolikia` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND YEAR(TanggalPeriksa) = '$tahun'";
							$str2 = $str."ORDER BY `NamaPasien`, TanggalPeriksa DESC limit $mulai,$jumlah_perpage";
						}else{
							// $str = "SELECT * FROM `$tbpolikia` a 
							// JOIN `$tbkk` b ON a.NoIndex = b.NoIndex 
							// WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND b.Kelurahan = '$kelurahan' AND YEAR(TanggalPeriksa) = '$tahun'";
							// $str2 = $str."ORDER BY a.`NamaPasien`, a.TanggalPeriksa DESC limit $mulai,$jumlah_perpage";
						}
					}else{
						if($kelurahan == 'semua'){
							$str = "SELECT * FROM `$tbpolikia` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa)='$bulan'";
							$str2 = $str."ORDER BY `NamaPasien`, TanggalPeriksa DESC limit $mulai,$jumlah_perpage";
						}else{
							$str = "SELECT * FROM `$tbpolikia` a 
							JOIN `$tbkk` b ON a.NoIndex = b.NoIndex 
							WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND b.Kelurahan = '$kelurahan' AND YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa)='$bulan'";
							$str2 = $str."ORDER BY a.`NamaPasien`, a.TanggalPeriksa DESC limit $mulai,$jumlah_perpage";
						}
					}
					
					// echo ($str2);
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$nocmtmp = '';
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noregistrasi = $data['NoRegistrasi'];
						$noindex = $data['NoIndex'];
					
						// tbpasienperpegawai
						$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
						$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
						if($dt_pegawai['NamaPegawai1']!=''){
							$pemeriksa = $dt_pegawai['NamaPegawai1'];
						}else{
							$pemeriksa = $dt_pegawai['NamaPegawai2'];
						}
						
						// tbpasienrj
						$str_rj = "SELECT JenisKelamin,UmurTahun,UmurBulan,PoliPertama,StatusPulang
						FROM `$tbpasienrj` 
						WHERE `NoRegistrasi` = '$noregistrasi'";
						$query_rj = mysqli_query($koneksi,$str_rj);
						$data_rj = mysqli_fetch_assoc($query_rj);
						$kelamin = $data_rj['JenisKelamin'];
						
						// tbkk
						$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
						// echo $str_kk;
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						
						// tbdiagnosapasien
						$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
						$query_diagnosapsn = mysqli_query($koneksi, $str_diagnosapsn);
						
						// cek umur kelamin
						if ($kelamin == 'L'){
							$umur_l = $data_rj['UmurTahun']."th ".$data_rj['UmurBulan']."Bl";
							$umur_p = "-";
						}else{
							$umur_l = "-";
							$umur_p = $data_rj['UmurTahun']."th ".$data_rj['UmurBulan']."Bl";
						}
					
						if($alamat != null){
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
						}else{
							$alamat = "-";
						}
						
						//cek rujukan
						$rujukan = $data_rj['StatusPulang'];
						if ($rujukan == 3){
							$berobatjalan = '<span class="fa fa-check"></span>';
							$rujuklanjut = '-';
						}else if($rujukan == 4){
							$rujuklanjut = '<span class="fa fa-check"></span>';
							$berobatjalan = '-';
						}
									
						//cek diagnosa pasien				
						while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
							$array_data[$data['NoRegistrasi']][] = $data_diagnosapsn['KodeDiagnosa'];
						}
						if ($array_data[$data['NoRegistrasi']] != ''){
							$data_dgs = implode(",", $array_data[$data['NoRegistrasi']]);
						}else{
							$data_dgs ="";
						}
						// echo $data_dgs;
						
				
						if(strlen($data['NoRM']) == 20){
							$normpasien = substr($data['NoRM'],14,7); // ambil 6 digit dari belakang
						}else if(strlen($data['NoRM']) == 19){
							$normpasien = substr($data['NoRM'],13,9); // ambil 6 digit dari belakang
						}else if(strlen($data['NoRM']) == 17){
							$normpasien = substr($data['NoRM'],11,6); // ambil 6 digit dari belakang
						}else if(strlen($data['NoRM']) == 7){
							$normpasien = substr($data['NoRM'],1,6);
						}					
						
						//get jml norm
						$rowspan_rm = mysqli_num_rows(mysqli_query($koneksi,$str." AND NoCM = '".$data['NoCM']."'"));
						
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
							<?php
							if($nocmtmp != $data['NoCM']){
							?>
							<td rowspan="<?php echo $rowspan_rm;?>" style="vertical-align:middle;text-align:center; border:1px solid #000; padding:3px;"><?php echo $normpasien;?></td>
							<td rowspan="<?php echo $rowspan_rm;?>" style="vertical-align:middle;text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<?php
							}
							?>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UsiaKehamilan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Trimester'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['KunjunganKehamilan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
							if ($data['Gravida'] == ''){
								$gravida = "-";
							}else{
								$gravida = $data['Gravida']."/".$data['Partus']."/".$data['Abortus'];
							}
							echo $gravida;
							?>
							</td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Hpht'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Anamnesa'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['BeratBadan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Sistole']."/".$data['Diastole'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Tfu'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Lila'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['StatusGizi'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['RefleksPatella'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Djj'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KepThd'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Tbj'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JumlahJanin'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Presentasi'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['InjeksiTT'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['CatatBukuKia'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['FeTab'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['K1Hb'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['ProteinUrin'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['GulaDarah'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['K4Hb'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Sifilis'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Hbsag'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['GolonganDarah'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Hiv'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['RiwayatSc'];?></td>
						</tr>
					<?php
						$nocmtmp = $data['NoCM'];
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
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
						echo "<li><a href='?page=lap_registrasi_kia_bulungankab&bulan=$bulan&tahun=$tahun&kelurahan=$kelurahan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>		
<?php
}
?>
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
	if($(".opsiform").val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>