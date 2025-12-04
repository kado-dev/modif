<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>RUP BULANAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_rup_bulungakab_bulan"/>
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
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup_bulungakab_bulan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI UMUM PUSKESMAS (RUP)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
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

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive font10">
				<table class="table-judul-laporan-min">
					<thead style="font-size:9px;">
						<tr style="border:1px solid #000;">
							<th rowspan="4" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Tgl</th>
							<th colspan="12" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Golongan Umur</th>
							<th colspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Kelamin</th>
							<th rowspan="4" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Jml Pasien</th>
							<th colspan="16" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Cara Bayar / Jaminan</th>
							<th colspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Kelamin</th>
							<th rowspan="4" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Jml Pasien</th>
							<th colspan="12" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan Kesehatan</th>
							<th colspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Kelamin</th>
							<th rowspan="4" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:3px;">Jml Pasien</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">0-7Hr</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">8-28Hr</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">1-11Bl</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">5-14Th</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">15-44Th</th>
							<th rowspan="3" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th rowspan="3" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Bayar</th>
							<th colspan="8" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Bpjs</th>
							<th colspan="6" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Gratis</th>
							<th rowspan="3" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th rowspan="3" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Umum</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Anak</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Gigi</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">KIR</th>
							<th colspan="2" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Imunisasi</th>
							<th colspan="1" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">KIA</th>
							<th colspan="1" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">KB</th>
							<th rowspan="3" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th rowspan="3" style="text-align:center;width:1.5%;vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--0-7Hr-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--8-28Hr-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-11Bl-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--5-14Th-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-44Th-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Bayar-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Mandiri</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Pns</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Pbin</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Pbid</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Sekolah</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Kader</th>
							<th colspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Lainnya</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Poli Umum-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Poli Anak-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Poli Gigi-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Poli Kir-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Poli Imunisasi-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th><!--Poli KIA-->
							<th rowspan="2" style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th><!--Poli KB-->
						</tr>
						<tr>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Mandiri-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Pns-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Pbin-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Pbid-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Anak Sekolah-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Kader-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Lainnya-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
						</tr>
					</thead>
					<tbody style="font-size:9px;">
						<?php
						// insert ke tbpasienrj_bulan_rup
						$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";					
						$querypasienrj = mysqli_query($koneksi,$strpasienrj);
						mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan_rup_rup`");
						while($dt_pasienrj = mysqli_fetch_assoc($querypasienrj)){
							$strpasienrjs = "INSERT INTO `tbpasienrj_bulan_rup`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
							`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
							`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
							`nokartu`,`kdpoli`,`Kir`) VALUES 
							('$dt_pasienrj[TanggalRegistrasi]','$dt_pasienrj[NoRegistrasi]','$dt_pasienrj[NoIndex]','$dt_pasienrj[NoCM]',
							'$dt_pasienrj[NamaPasien]','$dt_pasienrj[JenisKelamin]','$dt_pasienrj[UmurTahun]','$dt_pasienrj[UmurBulan]',
							'$dt_pasienrj[UmurHari]','$dt_pasienrj[JenisKunjungan]','$dt_pasienrj[AsalPasien]','$dt_pasienrj[StatusPasien]','$dt_pasienrj[PoliPertama]',
							'$dt_pasienrj[Asuransi]','$dt_pasienrj[StatusKunjungan]','$dt_pasienrj[WaktuKunjungan]','$dt_pasienrj[TarifKarcis]','$dt_pasienrj[TarifKir]',
							'$dt_pasienrj[TotalTarif]','$dt_pasienrj[StatusPelayanan]','$dt_pasienrj[StatusPulang]','$dt_pasienrj[NamaPegawaiSimpan]','$dt_pasienrj[NamaPegawaiEdit]',
							'$dt_pasienrj[TanggalEdit]','$dt_pasienrj[NoKunjunganBpjs]','$dt_pasienrj[NoUrutBpjs]','$dt_pasienrj[kdprovider]','$dt_pasienrj[nokartu]',
							'$dt_pasienrj[kdpoli]','$dt_pasienrj[Kir]')";
							mysqli_query($koneksi, $strpasienrjs);
						}
						
						// echo $tgl1;
						$tgl1 = $tahun.'-'.$bulan.'-01';
						$tgl2 = date('Y-m-t', strtotime($tgl1));
						$begin = new DateTime( $tgl1 );
						$end   = new DateTime( $tgl2 );
						for($i = $begin; $i <= $end; $i->modify('+1 day')){
							$tgl = $i->format("Y-m-d");
							
							// golongan umur
							$jml07Hr_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '0' AND '7' AND `JenisKelamin` = 'L'"));
							$jml07Hr_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '0' AND '7' AND `JenisKelamin` = 'P'"));
							$jml08_28Hr_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '8' AND '28' AND `JenisKelamin` = 'L'"));
							$jml08_28Hr_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '8' AND '28' AND `JenisKelamin` = 'P'"));
							$jml01_11Bl_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '12' AND `JenisKelamin` = 'L'"));
							$jml01_11Bl_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '12' AND `JenisKelamin` = 'P'"));
							$jml1_4Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` BETWEEN '1' AND '4' AND `JenisKelamin` = 'L'"));
							$jml1_4Th_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` BETWEEN '1' AND '4' AND `JenisKelamin` = 'P'"));
							$jml5_14Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` BETWEEN '5' AND '14' AND `JenisKelamin` = 'L'"));
							$jml5_14Th_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` BETWEEN '5' AND '14' AND `JenisKelamin` = 'P'"));
							$jml15_44Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` BETWEEN '15' AND '44' AND `JenisKelamin` = 'L'"));
							$jml15_44Th_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `UmurTahun` BETWEEN '15' AND '44' AND `JenisKelamin` = 'P'"));
							// ttl golongan umur
							$jmlpsn_L = $jml07Hr_L['Jumlah'] + $jml08_28Hr_L['Jumlah'] + $jml01_11Bl_L['Jumlah'] + $jml1_4Th_L['Jumlah'] + $jml5_14Th_L['Jumlah'] + $jml15_44Th_L['Jumlah'];
							$jmlpsn_P = $jml07Hr_P['Jumlah'] + $jml08_28Hr_P['Jumlah'] + $jml01_11Bl_P['Jumlah'] + $jml1_4Th_P['Jumlah'] + $jml5_14Th_P['Jumlah'] + $jml15_44Th_P['Jumlah'];
							$jmlpsn = $jmlpsn_L + $jmlpsn_P;
							
							// cara bayar	
							$umum_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi= 'UMUM' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));	
							$umum_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi= 'UMUM' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));										
							$bpjs_mandiri_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS MANDIRI' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$bpjs_mandiri_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS MANDIRI' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$bpjs_pns_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS PNS/POLRI/TNI' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$bpjs_pns_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS PNS/POLRI/TNI' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$bpjs_pbip_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS PBIP' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$bpjs_pbip_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS PBIP' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$bpjs_pbid_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS PBID' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$bpjs_pbid_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'BPJS PBID' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$gratis_sekolah_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'SISWA' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$gratis_sekolah_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'SISWA' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$gratis_kader_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'KADER' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$gratis_kader_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'KADER' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$gratis_lainnya_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'LAINNYA' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$gratis_lainnya_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and TanggalRegistrasi= '$tgl' and Asuransi = 'LAINNYA' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							// ttl cara bayar
							$jmlpsn_carabayar_L = $umum_L['Jumlah'] + $bpjs_mandiri_L['Jumlah'] + $bpjs_pns_L['Jumlah'] + $bpjs_pbip_L['Jumlah'] + $bpjs_pbid_L['Jumlah'] + $gratis_sekolah_L['Jumlah'] + $gratis_kader_L['Jumlah'] + $gratis_lainnya_L['Jumlah'];
							$jmlpsn_carabayar_P = $umum_P['Jumlah'] + $bpjs_mandiri_P['Jumlah'] + $bpjs_pns_P['Jumlah'] + $bpjs_pbip_P['Jumlah'] + $bpjs_pbid_P['Jumlah'] + $gratis_sekolah_P['Jumlah'] + $gratis_kader_P['Jumlah'] + $gratis_lainnya_P['Jumlah'];
							$jmlpsn_carabayar = $jmlpsn_carabayar_L + $jmlpsn_carabayar_P;
							
							// pelayanan kesehatan
							$p_umum_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI UMUM' AND `JenisKelamin` = 'L'"));
							$p_umum_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI UMUM' AND `JenisKelamin` = 'P'"));
							$p_anak_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI GIZI' AND `JenisKelamin` = 'L'"));
							$p_anak_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI GIZI' AND `JenisKelamin` = 'P'"));
							// $p_anak_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRujukan) AS Jumlah FROM `tbrujukinternal` a JOIN `tbpasienrj_bulan_rup` b ON a.NoRujukan = b.NoRegistrasi WHERE SUBSTRING(a.NoRujukan,1,11)='$kodepuskesmas' AND a.`TanggalRujukan` = '$tgl' AND a.`PoliRujukan` = 'POLI ANAK' AND b.`JenisKelamin` = 'L'"));
							// $p_anak_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRujukan) AS Jumlah FROM `tbrujukinternal` a JOIN `tbpasienrj_bulan_rup` b ON a.NoRujukan = b.NoRegistrasi WHERE SUBSTRING(a.NoRujukan,1,11)='$kodepuskesmas' AND a.`TanggalRujukan` = '$tgl' AND a.`PoliRujukan` = 'POLI ANAK' AND b.`JenisKelamin` = 'P'"));
							$p_gigi_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI GIGI' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$p_gigi_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI GIGI' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$p_kir_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI SKD' AND `JenisKelamin` = 'L' AND UmurTahun <= '44'"));
							$p_kir_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI SKD' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$p_imunisasi_L = '0';//mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRujukan) AS Jumlah FROM `tbrujukinternal` a JOIN `tbpasienrj_bulan_rup` b ON a.NoRujukan = b.NoRegistrasi WHERE SUBSTRING(a.NoRujukan,1,11)='$kodepuskesmas' AND a.`TanggalRujukan` = '$tgl' AND a.`PoliRujukan` = 'POLI IMUNISASI' AND b.`JenisKelamin` = 'L'"));
							$p_imunisasi_P = '0';//mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRujukan) AS Jumlah FROM `tbrujukinternal` a JOIN `tbpasienrj_bulan_rup` b ON a.NoRujukan = b.NoRegistrasi WHERE SUBSTRING(a.NoRujukan,1,11)='$kodepuskesmas' AND a.`TanggalRujukan` = '$tgl' AND a.`PoliRujukan` = 'POLI IMUNISASI' AND b.`JenisKelamin` = 'P'"));
							$p_kia_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI KIA' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							$p_kb_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan_rup` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi` = '$tgl' AND `PoliPertama` = 'POLI KB' AND `JenisKelamin` = 'P' AND UmurTahun <= '44'"));
							// ttl pelayanan kesehatan
							$jmlpsn_pelkes_L = $p_umum_L['Jumlah'] + $p_anak_L['Jumlah'] + $p_gigi_L['Jumlah'] + $p_kir_L['Jumlah'] + $p_imunisasi_L['Jumlah'];
							$jmlpsn_pelkes_P = $p_umum_P['Jumlah'] + $p_anak_P['Jumlah'] + $p_gigi_P['Jumlah'] + $p_kir_P['Jumlah'] + $p_imunisasi_P['Jumlah'] + $p_kia_P['Jumlah'] + $p_kb_P['Jumlah'];
							$jmlpsn_pelkes = $jmlpsn_pelkes_L + $jmlpsn_pelkes_P;
							
							
							// total umur	
							$totaljml_07Hr_L[] = $jml07Hr_L['Jumlah'];
							$totaljml_07Hr_P[] = $jml07Hr_P['Jumlah'];
							$totaljml_08_28Hr_L[] = $jml08_28Hr_L['Jumlah'];
							$totaljml_08_28Hr_P[] = $jml08_28Hr_P['Jumlah'];
							$totaljml_01_11Bl_L[] = $jml01_11Bl_L['Jumlah'];
							$totaljml_01_11Bl_P[] = $jml01_11Bl_P['Jumlah'];
							$totaljml_l_4Th_L[] = $jml1_4Th_L['Jumlah'];
							$totaljml_l_4Th_P[] = $jml1_4Th_P['Jumlah'];
							$totaljml_5_14Th_L[] = $jml5_14Th_L['Jumlah'];
							$totaljml_5_14Th_P[] = $jml5_14Th_P['Jumlah'];
							$totaljml_15_44Th_L[] = $jml15_44Th_L['Jumlah'];
							$totaljml_15_44Th_P[] = $jml15_44Th_P['Jumlah'];
							$totaljml_psn_L[] = $jmlpsn_L;
							$totaljml_psn_P[] = $jmlpsn_P;
							$totaljml_psn[] = $jmlpsn;
							// total cara bayar
							$totaljml_umum_L[] = $umum_L['Jumlah'];
							$totaljml_umum_P[] = $umum_P['Jumlah'];
							$totaljml_bpjs_mandiri_L[] = $bpjs_mandiri_L['Jumlah'];
							$totaljml_bpjs_mandiri_P[] = $bpjs_mandiri_P['Jumlah'];
							$totaljml_bpjs_pns_L[] = $bpjs_pns_L['Jumlah'];
							$totaljml_bpjs_pns_P[] = $bpjs_pns_P['Jumlah'];
							$totaljml_bpjs_pbip_L[] = $bpjs_pbip_L['Jumlah'];
							$totaljml_bpjs_pbip_P[] = $bpjs_pbip_P['Jumlah'];
							$totaljml_bpjs_pbid_L[] = $bpjs_pbid_L['Jumlah'];
							$totaljml_bpjs_pbid_P[] = $bpjs_pbid_P['Jumlah'];
							$totaljml_gratis_sekolah_L[] = $gratis_sekolah_L['Jumlah'];
							$totaljml_gratis_sekolah_P[] = $gratis_sekolah_P['Jumlah'];
							$totaljml_gratis_kader_L[] = $gratis_kader_L['Jumlah'];
							$totaljml_gratis_kader_P[] = $gratis_kader_P['Jumlah'];
							$totaljml_gratis_lainnya_L[] = $gratis_lainnya_L['Jumlah'];
							$totaljml_gratis_lainnya_P[] = $gratis_lainnya_P['Jumlah'];
							$totaljml_carabayar_L[] = $jmlpsn_carabayar_L['Jumlah'];
							$totaljml_carabayar_P[] = $jmlpsn_carabayar_P['Jumlah'];
							$totaljml_carabayar[] = $jmlpsn_carabayar;
							// total pelayanan kesehatan
							$totaljml_p_umum_L[] = $p_umum_L['Jumlah'];
							$totaljml_p_umum_P[] = $p_umum_P['Jumlah'];
							$totaljml_p_anak_L[] = $p_anak_L['Jumlah'];
							$totaljml_p_anak_P[] = $p_anak_P['Jumlah'];
							$totaljml_p_gigi_L[] = $p_gigi_L['Jumlah'];
							$totaljml_p_gigi_P[] = $p_gigi_P['Jumlah'];
							$totaljml_p_kir_L[] = $p_kir_L['Jumlah'];
							$totaljml_p_kir_P[] = $p_kir_P['Jumlah'];
							$totaljml_p_imunisasi_L[] = $p_imunisasi_L['Jumlah'];
							$totaljml_p_imunisasi_P[] = $p_imunisasi_P['Jumlah'];
							$totaljml_p_kia_P[] = $p_kia_P['Jumlah'];
							$totaljml_p_kb_P[] = $p_kb_P['Jumlah'];	
							$totaljml_pelkes_L[] = $jmlpsn_pelkes_L['Jumlah'];
							$totaljml_pelkes_P[] = $jmlpsn_pelkes_P['Jumlah'];
							$totaljml_pelkes[] = $jmlpsn_pelkes;						
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $i->format("d");?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml07Hr_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml07Hr_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml08_28Hr_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml08_28Hr_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml01_11Bl_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml01_11Bl_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml1_4Th_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml1_4Th_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml5_14Th_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml5_14Th_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml15_44Th_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml15_44Th_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_L;?></td><!--Jumlah-->	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_P;?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn;?></td>
								<!--Cara Bayar-->
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umum_L['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umum_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_mandiri_L['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_mandiri_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pns_L['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pns_P['Jumlah'];?></td>							
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbip_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbip_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbid_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbid_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_sekolah_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_sekolah_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_kader_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_kader_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_lainnya_L['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_lainnya_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_carabayar_L;?></td><!--Jumlah-->
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_carabayar_P;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_carabayar;?></td>
								<!--Pelayanan Kesehatan-->
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_umum_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_umum_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_anak_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_anak_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_gigi_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_gigi_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_kir_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_kir_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_imunisasi_L['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_imunisasi_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_kia_P['Jumlah'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $p_kb_P['Jumlah'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_pelkes_L;?></td><!--Jumlah-->
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_pelkes_P;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jmlpsn_pelkes;?></td>
							</tr>
						<?php
						}
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_07Hr_L);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_07Hr_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_08_28Hr_L);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_08_28Hr_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_01_11Bl_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_01_11Bl_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_l_4Th_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_l_4Th_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_5_14Th_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_5_14Th_P);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_15_44Th_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_15_44Th_P);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_psn_L);?></td><!--Jumlah-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_psn_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_psn);?></td>	
							<!--Cara Bayar-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_umum_L);?></td>				
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_umum_P);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_mandiri_L);?></td>				
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_mandiri_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_pns_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_pns_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_pbip_L);?></td>				
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_pbip_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_pbid_L);?></td>				
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_bpjs_pbid_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_gratis_sekolah_L);?></td>				
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_gratis_sekolah_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_gratis_kader_L);?></td>					
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_gratis_kader_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_gratis_lainnya_L);?></td>				
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_gratis_lainnya_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_carabayar_L);?></td><!--Jumlah-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_carabayar_P);?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_carabayar);?></td>							
							<!--Pelayanan Kesehatan-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_umum_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_umum_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_anak_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_anak_P);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_gigi_L);?></td>						
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_gigi_P);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_kir_L);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_kir_P);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_imunisasi_L);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_imunisasi_P);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_kia_P);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_p_kb_P);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_pelkes_L);?></td><!--Jumlah-->							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_pelkes_P);?></td>							
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo array_sum($totaljml_pelkes);?></td>							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<?php
	}
	?>
</div>	