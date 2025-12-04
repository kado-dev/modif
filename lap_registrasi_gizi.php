<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<!--judul menu-->
<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Register Poli Gizi</h1>
		</div>
	</div>
</div>

<!--cari pasien-->
<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER GIZI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_gizi"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_gizi" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_gizi_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-info"><span class="fa fa-file-excel"></span></a>
							<a href="lap_registrasi_gizi_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
						</div>
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
<div class="table-responsive">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px dashed #000;">
				<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
				<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tanggal</th>
				<?php
					if($kota == 'TANJUNG SELOR'){
				?>
				<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.RM</th>
				<?php
					}else{
				?>
				<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
				<?php
					}
				?>
				<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Bayi/Balita</th>
				<th colspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
				<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tgl.Lahir</th>
				<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Ortu</th>
				<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">BB</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">TB</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">NTOB</th>
				<th colspan="3" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Status Gizi</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">ASI</th>
				<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
			</tr>
			<tr style="border:1px dashed #000;">
				<th style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/U</th><!--Status Gizi-->
				<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/TB</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">TB/U</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<?php
			// insert ke tbpasienperpegawai_bulan
			$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
			$strpasienperpegawai = "SELECT * FROM `$tbpasienperpegawai` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
			$querypasienperpegawai = mysqli_query($koneksi, $strpasienperpegawai);
			mysqli_query($koneksi, "DELETE FROM `tbpasienperpegawai_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
			while($datapspg = mysqli_fetch_assoc($querypasienperpegawai)){
				$strpasienperpegawaibulan = "INSERT INTO `tbpasienperpegawai_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`,`NamaPegawai4`,`NamaPegawai5`,`Lab`,`Farmasi`) VALUES 
				('$datapspg[TanggalRegistrasi]','$datapspg[NoRegistrasi]','$datapspg[Pendaftaran]','$datapspg[NamaPegawai1]','$datapspg[NamaPegawai2]','$datapspg[NamaPegawai3]','$datapspg[NamaPegawai4]','$datapspg[NamaPegawai5]','$datapspg[Lab]','$datapspg[Farmasi]')";
				mysqli_query($koneksi, $strpasienperpegawaibulan);
			}
			
			// insert ke tbpasienrj_bulan
			$tbpasienrj = 'tbpasienrj_'.$bulan;
			$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
			$querypasienrj = mysqli_query($koneksi, $strpasienrj);
			mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
			while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
				$strpasienrjbulan = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
				`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
				`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
				`nokartu`,`kdpoli`,`Kir`) VALUES 
				('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NamaPasien]',
				'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
				'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$datapsrj[StatusKunjungan]','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
				'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
				,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
				'$datapsrj[Kir]')";
				mysqli_query($koneksi, $strpasienrjbulan);
			}
			
			$jumlah_perpage = 20;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}	
			
			if ($opsiform == 'bulan'){
				$str = "SELECT *
				FROM `tbpoligizi` a 
				JOIN `tbpasienrj_bulan` b ON a.NoPemeriksaan = b.NoRegistrasi
				WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND MONTH(a.TanggalPeriksa) = '$bulan' and YEAR(a.TanggalPeriksa) = '$tahun'";
			}else{
				$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate1));
				$tbpasienrj2 = 'tbpasienrj_'.date('m', strtotime($keydate2));
				$str = "SELECT * FROM(
				SELECT a.TanggalPeriksa as TanggalPeriksa,a.NoIndex as NoIndex,a.NoCM as NoCM,b.NoRegistrasi as NoRegistrasi,b.NamaPasien as NamaPasien,b.UmurBulan as UmurBulan,b.UmurTahun as UmurTahun,b.JenisKelamin as JenisKelamin,a.BeratBadan as BeratBadan,a.TinggiBadan as TinggiBadan,a.Ntob as Ntob,a.Bbu as Bbu,a.Bbtb as Bbtb,a.Tbu as Tbu,a.Asi as Asi
				FROM `tbpoligizi` a 
				JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi
				WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND a.TanggalPeriksa BETWEEN  '$keydate1' and '$keydate2'
				UNION
				SELECT a.TanggalPeriksa as TanggalPeriksa,a.NoIndex as NoIndex,a.NoCM as NoCM,b.NoRegistrasi as NoRegistrasi,b.NamaPasien as NamaPasien,b.UmurBulan as UmurBulan,b.UmurTahun as UmurTahun,b.JenisKelamin as JenisKelamin,a.BeratBadan as BeratBadan,a.TinggiBadan as TinggiBadan,a.Ntob as Ntob,a.Bbu as Bbu,a.Bbtb as Bbtb,a.Tbu as Tbu,a.Asi as Asi
				FROM `tbpoligizi` a 
				JOIN `$tbpasienrj2` b ON a.NoPemeriksaan = b.NoRegistrasi
				WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND a.TanggalPeriksa BETWEEN  '$keydate1' and '$keydate2'
				) a ";
			}
			$str2 = $str." ORDER BY a.`TanggalPeriksa` Desc limit $mulai,$jumlah_perpage";
			// echo ($str2);
			// die();
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$noregistrasi = $data['NoRegistrasi'];
				$noindex = $data['NoIndex'];
				$nocm = $data['NoCM'];
				$norm = $data['NoRM'];
				$anamnesa = $data['Anamnesa'];
				$kelamin = $data['JenisKelamin'];
				
				// tbpasienperpegawai
				$dt_pasien_prpg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1`,`NamaPegawai2`
				FROM `tbpasienperpegawai_bulan`
				WHERE `NoRegistrasi` = '$noregistrasi'"));
				if($dt_pasien_prpg['NamaPegawai1']!=''){
					$pemeriksa = $dt_pasien_prpg['NamaPegawai1'];
				}else{
					$pemeriksa = $dt_pasien_prpg['NamaPegawai2'];
				}
				
				// pasien
				if (strlen($noindex) == 24){
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex` FROM `tbpasien` WHERE `NoIndex` = '$noindex'"));
					$noindex2 = $dt_pasien['NoIndex'];
				}else{
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex` FROM `tbpasien` WHERE `NoAsuransi` = '$noindex'"));
					if ($dt_pasien['NoIndex'] != ''){
						$noindex2 = $dt_pasien['NoIndex'];
					}else{
						$noindex2 = $noindex;
					}
				}
				
				// tanggal lahir
				// $tbpasien = "tbpasien_".substr($nocm,12,4);
				$tbpasien = 'tbpasien_'.substr($noindex,14,4);
				$tbpasien2 = 'tbpasien_'.substr($noindex,14,4);
				$str_tlahir = "SELECT * FROM(
				SELECT TanggalLahir
				FROM `$tbpasien` 
				WHERE `NoCM`='$nocm'
				UNION
				SELECT TanggalLahir
				FROM `$tbpasien2` 
				WHERE `NoCM`='$nocm'
				) a ";
				$query_tlahir = mysqli_query($koneksi,$str_tlahir);
				$data_tlahir = mysqli_fetch_assoc($query_tlahir);
				// echo $str_tlahir;
				
				// tbkk
				$str_kk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex2'";
				$query_kk = mysqli_query($koneksi,$str_kk);
				$data_kk = mysqli_fetch_assoc($query_kk);
				$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
							
				//cek umur kelamin
				if ($kelamin == 'L'){
					$umur_l = $data['UmurBulan']."B, ".$data['UmurTahun']."T";
					$umur_p = "-";
				}else{
					$umur_l = "-";
					$umur_p = $data['UmurBulan']."B, ".$data['UmurTahun']."T";
				}
				
			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
					<?php
						if($kota == 'TANJUNG SELOR'){
					?>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($norm,6);?></td>
					<?php
						}else{
					?>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($noindex2,14);?></td>
					<?php
						}
					?>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_p;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_tlahir['TanggalLahir'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['NamaKK'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['BeratBadan'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Ntob'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Bbu'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Bbtb'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Tbu'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Asi'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $pemeriksa;?></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<br>
<ul class="pagination">
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
					echo "<li><a href='?page=lap_registrasi_gizi&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
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
// $(".btnprosess").click(function() {
	// $.post( "lap_registrasi_gizi_print.php")
		// .done(function( data ) {
		// $( ".lapregistrasihtml" ).html( data );
	// });
// });
</script>

