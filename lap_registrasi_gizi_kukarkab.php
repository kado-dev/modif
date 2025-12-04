<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Register Poli Gizi</h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_registrasi_gizi_kukarkab"/>
					<div class="col-sm-2">
						<select name="opsiform" class="form-control opsiform">
							<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
							<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
						</select>	
					</div>
					<div class="col-sm-3 tanggalformcari" style="display:none">
						<div class="tampilformdate">
							<input type="text" name="keydate" class="form-control datepicker2" value="<?php echo $_GET['keydate'];?>" placeholder = "Tanggal Awal">
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
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_registrasi_gizi_kukarkab.php" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<?php if($_GET['opsiform'] == 'tanggal'){?>
						<a href="lap_registrasi_gizi_kukarkab_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-primary"><span class="fa fa-print"></span></a>
						<?php }?>
						<a href="lap_registrasi_gizi_kukarkab_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-info">Excel</a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>	
<?php
$bulan = $_GET['bulan'];
$keydate = $_GET['keydate'];
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
				<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.RM</th>
				<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Anak</th>
				<th colspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
				<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tgl.Lahir</th>
				<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Ortu</th>
				<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
				<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tindakan</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">BB</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">TB</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Temp</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">NTOB</th>
				<th colspan="3" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Status Gizi</th>
				<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">ASI</th>
				<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
			</tr>
			<tr style="border:1px dashed #000;">
				<th style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/U</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/TB</th>
				<th style="text-align:center; border:1px dashed #000; padding:3px;">TB/U</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<?php
			if ($opsiform == 'bulan'){
				$tbpasienperpegawai = 'tbpasienperpegawai_'.$bulan;
				$tbpasienrj = 'tbpasienrj_'.$bulan;
				$tahun = $_GET['tahun'];
			}else{
				$tbpasienperpegawai = 'tbpasienperpegawai_'.date('m', strtotime($keydate));
				$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate));
				$tahun = date('Y', strtotime($keydate));
			}
			
			// insert ke tbpasienperpegawai_bulan
			$strpasienperpegawai = "SELECT * FROM `$tbpasienperpegawai` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
			$querypasienperpegawai = mysqli_query($koneksi, $strpasienperpegawai);
			mysqli_query($koneksi, "DELETE FROM `tbpasienperpegawai_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
			while($datapspg = mysqli_fetch_assoc($querypasienperpegawai)){
				$strpasienperpegawaibulan = "INSERT INTO `tbpasienperpegawai_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`,`NamaPegawai4`,`NamaPegawai5`,`Lab`,`Farmasi`) VALUES 
				('$datapspg[TanggalRegistrasi]','$datapspg[NoRegistrasi]','$datapspg[Pendaftaran]','$datapspg[NamaPegawai1]','$datapspg[NamaPegawai2]','$datapspg[NamaPegawai3]','$datapspg[NamaPegawai4]','$datapspg[NamaPegawai5]','$datapspg[Lab]','$datapspg[Farmasi]')";
				mysqli_query($koneksi, $strpasienperpegawaibulan);
			}
			
			// insert ke tbpasienrj_bulan
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
				FROM `tbpoligizi` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND MONTH(TanggalPeriksa) = '$bulan' AND
				YEAR(TanggalPeriksa) = '$tahun'";
			}else{
				$str = "SELECT * FROM `tbpoligizi` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND TanggalPeriksa = '$keydate'";
			}
			$str2 = $str." ORDER BY `TanggalPeriksa` DESC limit $mulai,$jumlah_perpage";
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
				$noregistrasi = $data['NoPemeriksaan'];
				$noindex = $data['NoIndex'];
				$nocm = $data['NoCM'];
				$anamnesa = $data['Anamnesa'];
				$tindakan = $data['TindakanGizi'];
				
				// tbpasienrj
				$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `UmurTahun`,`UmurBulan`,`NoRM`
				FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
				if($dt_pasienrj['UmurTahun'] != '0'){
					$umur = $dt_pasienrj['UmurTahun']."Th";
				}else{
					$umur = $dt_pasienrj['UmurBulan']."Bl";
				}
				
				if ($dt_pasienrj['JenisKelamin'] == 'L'){
					$umur_l = $umur;
					$umur_p = "-";
				}else{
					$umur_l = "-";
					$umur_p = $umur;
				}
				
				// tbpasien, tanggal lahir
				$tbpasien = 'tbpasien_'.substr($noindex,14,4);
				$str_tlahir = "SELECT * FROM `$tbpasien` WHERE `NoCM`='$nocm'";
				$query_tlahir = mysqli_query($koneksi,$str_tlahir);
				$data_tlahir = mysqli_fetch_assoc($query_tlahir);
								
				// tbkk
				$str_kk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
				$query_kk = mysqli_query($koneksi,$str_kk);
				$data_kk = mysqli_fetch_assoc($query_kk);
				$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
				$telepon = $data_kk['Telepon'];
				
				// tbpasienperpegawai
				$dt_pasien_prpg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1`,`NamaPegawai2`
				FROM `tbpasienperpegawai_bulan` WHERE `NoRegistrasi` = '$noregistrasi'"));				
				if($dt_pasien_prpg['NamaPegawai1']!=''){
					$pemeriksa = $dt_pasien_prpg['NamaPegawai1'];
				}else{
					$pemeriksa = $dt_pasien_prpg['NamaPegawai2'];
				}
				
			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($dt_pasienrj['NoRM'],-6);?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_p;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_tlahir['TanggalLahir'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['NamaKK'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", Telp.".$data_kk['Telepon'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $tindakan;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['BeratBadan'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['SuhuTubuh'];?></td>
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
					echo "<li><a href='?page=lap_registrasi_gizi_kukarkab&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
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
	// $.post( "lap_registrasi_gizi_kukarkab_print.php")
		// .done(function( data ) {
		// $( ".lapregistrasihtml" ).html( data );
	// });
// });
</script>

