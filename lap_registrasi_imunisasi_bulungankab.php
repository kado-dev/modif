<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Register Poli Imunisasi</h1>
		</div>
	</div>
</div>

<!--cari pasien-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_registrasi_imunisasi_bulungankab"/>
					<div class="col-sm-2">
						<select name="opsiform" class="form-control opsiform">
							<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
							<!--<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>-->
						</select>	
					</div>
					<div class="col-sm-3 tanggalformcari" style="display:none">
						<div class="tampilformdate">
							<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</select>
					</div>
					<?php
					if($_SESSION['kodepuskesmas'] == '-'){
					?>
						<div class="col-sm-2">
							<SELECT name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$kota = $_SESSION['kota'];
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
							}
							?>
							</SELECT>
						</div>
					<?php
					}
					?>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_registrasi_imunisasi_bulungankab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="lap_registrasi_imunisasi_bulungankab_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" target="_blank" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
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

if(isset($bulan) and isset($tahun)){
?>
<!--data registrasi-->
<div class="noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed">
			<thead style="font-size:10px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
					<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.RM</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Anak</th>
					<th colspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Usia</th>
					<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tgl.Lahir</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Orang Tua</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Jaminan</th>
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Bbu</th>
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Hbo</th>
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Bcg</th>
					<th colspan="3" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Dpt/Hb/Hib</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ipv</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Cmp</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Pentaboster</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Cmp Bost</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Keterangan</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
					<th style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center; border:1px dashed #000; padding:3px;">1</th>
					<th style="text-align:center; border:1px dashed #000; padding:3px;">2</th>
					<th style="text-align:center; border:1px dashed #000; padding:3px;">3</th>
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
				
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalPeriksa) = '$tahun'";
					$tbpasienrj = 'tbpasienrj_'.$bulan;
					$tbpasien = 'tbpasien_'.$tahun;
					$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
					$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
					
					$str = "SELECT * 
					FROM `tbpoliimunisasi` a
					JOIN `$tbpasien` b ON a.NoCM = b.NoCM
					JOIN `$tbpasienrj` c on a.NoPemeriksaan = c.NoRegistrasi
					JOIN $tbpasienperpegawai d on a.NoPemeriksaan = d.NoRegistrasi 
					WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str."ORDER BY `TanggalPeriksa` Desc limit $mulai,$jumlah_perpage";
				}else{
					$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
					$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate1));
					$tbpasienrj2 = 'tbpasienrj_'.date('m', strtotime($keydate2));
					$tbpasienperpegawai='tbpasienperpegawai_'.date('m', strtotime($keydate1));
					$tbpasienperpegawai2='tbpasienperpegawai_'.date('m', strtotime($keydate2));
					$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($keydate1));
					$tbdiagnosapasien2 = 'tbdiagnosapasien_'.date('m', strtotime($keydate2));
					
					$str = "SELECT * FROM(
							SELECT a.TanggalPeriksa as TanggalPeriksa ,b.NamaPasien as NamaPasien, a.Anamnesa as Anamnesa, a.ImunisasiSekarang as ImunisasiSekarang, a.NoPemeriksaan as NoPemeriksaan, a.NoIndex as NoIndex, b.UmurTahun as UmurTahun, b.UmurBulan as UmurBulan, b.JenisKelamin as JenisKelamin, b.StatusPulang as StatusPulang, c.NamaPegawai1 as NamaPegawai1, c.NamaPegawai2 as NamaPegawai2
							FROM `tbpoliimunisasi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai c on a.NoPemeriksaan = c.NoRegistrasi
							WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'
							UNION 
							SELECT a.TanggalPeriksa as TanggalPeriksa ,b.NamaPasien as NamaPasien, a.Anamnesa as Anamnesa, a.ImunisasiSekarang as ImunisasiSekarang, a.NoPemeriksaan as NoPemeriksaan, a.NoIndex as NoIndex, b.UmurTahun as UmurTahun, b.UmurBulan as UmurBulan, b.JenisKelamin as JenisKelamin, b.StatusPulang as StatusPulang, c.NamaPegawai1 as NamaPegawai1, c.NamaPegawai2 as NamaPegawai2
							FROM `tbpoliimunisasi` a join `$tbpasienrj2` b on a.NoPemeriksaan = b.NoRegistrasi join $tbpasienperpegawai2 c on a.NoPemeriksaan = c.NoRegistrasi
							WHERE ".$waktu." and substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'
							) a ";
					$str2 = $str."ORDER BY `NoPemeriksaan`  Desc limit $mulai,$jumlah_perpage";
				}
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$query = mysqli_query($koneksi,$str2);				
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$anamnesa = $data['Anamnesa'];
					$kelamin = $data['JenisKelamin'];
					
					// tbpasienperpegawai
					if($data['NamaPegawai1']!=''){
						$pemeriksa = $data['NamaPegawai1'];
					}else{
						$pemeriksa = $data['NamaPegawai2'];
					}
					
					// pasien
					if (strlen($noindex) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoIndex` = '$noindex'"));
						$noindex2 = $dt_pasien['NoIndex'];
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$noindex'"));
						if ($dt_pasien['NoIndex'] != ''){
							$noindex2 = $dt_pasien['NoIndex'];
						}else{
							$noindex2 = $noindex;
						}
					}
					
					// tbkk
					$str_kk = "SELECT `NamaKK`,`Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
					
					// tbdiagnosapasien
					if($opsiform == 'bulan'){
						$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					}else{
						$str_diagnosapsn = "SELECT * from(
											SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'
											UNION
											SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien2` WHERE `NoRegistrasi` = '$noregistrasi'
											)a";
					}
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					//cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data['UmurTahun']." Th, ".$data['UmurBulan']." Bl";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data['UmurTahun']." Th, ".$data['UmurBulan']." Bl";
					}
					
					//cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
				
					//cek diagnosa pasien
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
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
					
					// Riwayat Imunisasi
					$str_imun = mysqli_query($koneksi,"SELECT RiwayatImunisasi
					FROM tbpoliimunisasi
					WHERE `NoCM` = '$data[NoCM]'");
					while( $dtimun = mysqli_fetch_assoc($str_imun)){
						$dtaimunisasi[$no][] = $dtimun['RiwayatImunisasi'];
					}
					$dtimunisasi_gabung = implode(",",$dtaimunisasi[$no]);
					$dtimunisasi = explode(",",$dtimunisasi_gabung);
				?>
					<tr style="border:1px dashed #000;">
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $normpasien;?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_p;?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['TanggalLahir'];?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $alamat;?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['NamaKK'];?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Bbu'];?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('HBO',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('BCG',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('DPT HB HiB 1',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('DPT HB HiB 2',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('DPT HB HiB 3',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php if(in_array('IPV',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php if(in_array('CAMPAK',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php if(in_array('PENTABIO',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php if(in_array('CAMPAK BOSTER',$dtimunisasi)){echo '<span class="fa fa-check"></span>';}?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;">-</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<br>
<hr class="noprint"><!--css-->
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
					echo "<li><a href='?page=lap_registrasi_imunisasi_bulungankab&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
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


