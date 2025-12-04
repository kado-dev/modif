<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTRASI UMUM PUSKESMAS (RUP)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_rup"/>
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
									for($tahun = 2022 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_rup_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI UMUM PUSKESMAS (RUP)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
	</div><br/>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="3">TGL</th>
							<th rowspan="3">JML PASIEN</th>
							<th colspan="2">GENDER</th>
							<th colspan="24">GOLONGAN UMUR</th>
							<th colspan="8">PELAYANAN KESEHATAN</th>
							<th colspan="5">CARA BAYAR</th>
							<!-- <th colspan="6">WILAYAH</th> -->
						</tr>
						<tr style="border:1px solid #000;">
							<th rowspan="2">L</th>
							<th rowspan="2">P</th>
							<th colspan="2">0-7HR</th>
							<th colspan="2">8-30HR</th>
							<th colspan="2">1Bl-12BL</th>
							<th colspan="2">1-4TH</th>
							<th colspan="2">5-9TH</th>
							<th colspan="2">10-14TH</th>
							<th colspan="2">15-19TH</th>
							<th colspan="2">20-44TH</th>
							<th colspan="2">45-54TH</th>
							<th colspan="2">55-59TH</th>
							<th colspan="2">60-69TH</th>
							<th colspan="2">>70TH</th>
							<th rowspan="2">GIGI</th>
							<th rowspan="2">UGD</th>
							<th rowspan="2">KB</th>
							<th rowspan="2">KIA</th>
							<th rowspan="2">LANSIA</th>
							<th rowspan="2">MTBS</th>
							<th rowspan="2">TB</th>
							<th rowspan="2">UMUM</th>
							<th rowspan="2">BPJS <br/> NON PBI</th>
							<th rowspan="2">BPJS PBI</th>
							<th rowspan="2">GRATIS</th>
							<th rowspan="2">SKTM</th>
							<th rowspan="2">UMUM</th>
							<!-- <th colspan="3">DALAM</th>
							<th colspan="3">LUAR</th> -->
						</tr>
						<tr style="border:1px solid #000;">
							<th>B</th><!--0-7Hr-->
							<th>L</th>
							<th>B</th><!--8-30Hr-->
							<th>L</th>
							<th>B</th><!--1Bl-12Bl-->
							<th>L</th>
							<th>B</th><!--1-4Th-->
							<th>L</th>
							<th>B</th><!--5-9Th-->
							<th>L</th>
							<th>B</th><!--10-14Th-->
							<th>L</th>
							<th>B</th><!--15-19Th-->
							<th>L</th>
							<th>B</th><!--20-44Th-->
							<th>L</th>
							<th>B</th><!--45-54Th-->
							<th>L</th>
							<th>B</th><!--55-59Th-->
							<th>L</th>
							<th>B</th><!--60-69Th-->
							<th>L</th>
							<th>B</th><!--70Th-->
							<th>L</th>
							<!--<th>B</th>dalam wilayah
							<th>L</th>
							<th>JML</th>
							<th>B</th>luar wilayah
							<th>L</th>
							<th>JML</th>-->
						</tr>
					</thead>
					<tbody>
						<?php
						$tgl1 = $tahun.'-'.$bulan.'-01';
						$tgl2 = date('Y-m-t', strtotime($tgl1));
						$begin = new DateTime( $tgl1 );
						$end   = new DateTime( $tgl2 );
						for($i = $begin; $i <= $end; $i->modify('+1 day')){
							$tgl = $i->format("Y-m-d");						
							$jmlpsn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl'"));
							$jmlpsn_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'L'"));
							$jmlpsn_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'P'"));
							// golongan umur
							$jml07Hr_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '0' AND '7' AND `StatusKunjungan`='Baru'"));
							$jml07Hr_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '0' AND '7' AND `StatusKunjungan`='Lama'"));
							$jml0830Hr_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '8' AND '30' AND `StatusKunjungan`='Baru'"));
							$jml0830Hr_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '8' AND '30' AND `StatusKunjungan`='Lama'"));
							$jml0112Bl_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '12' AND `StatusKunjungan`='Baru'"));
							$jml0112Bl_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '12' AND `StatusKunjungan`='Lama'"));
							$jml14Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '1' AND '4' AND `StatusKunjungan`='Baru'"));
							$jml14Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '1' AND '4' AND `StatusKunjungan`='Lama'"));
							$jml59Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '5' AND '9' AND `StatusKunjungan`='Baru'"));
							$jml59Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '5' AND '9' AND `StatusKunjungan`='Lama'"));
							$jml1014Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '10' AND '14' AND `StatusKunjungan`='Baru'"));
							$jml1014Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '10' AND '14' AND `StatusKunjungan`='Lama'"));
							$jml1519Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '15' AND '19' AND `StatusKunjungan`='Baru'"));
							$jml1519Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '15' AND '19' AND `StatusKunjungan`='Lama'"));
							$jml2044Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '20' AND '44' AND `StatusKunjungan`='Baru'"));
							$jml2044Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '20' AND '44' AND `StatusKunjungan`='Lama'"));
							$jml4554Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '45' AND '54' AND `StatusKunjungan`='Baru'"));
							$jml4554Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '45' AND '54' AND `StatusKunjungan`='Lama'"));
							$jml5559Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '55' AND '59' AND `StatusKunjungan`='Baru'"));
							$jml5559Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '55' AND '59' AND `StatusKunjungan`='Lama'"));
							$jml6069Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '60' AND '69' AND `StatusKunjungan`='Baru'"));
							$jml6069Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '60' AND '69' AND `StatusKunjungan`='Lama'"));
							$jml70Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '70' AND '100' AND `StatusKunjungan`='Baru'"));
							$jml70Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '70' AND '100' AND `StatusKunjungan`='Lama'"));
							// pelayanan kesehatan
							$p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIGI'"));
							$p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KB'"));
							$p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KIA'"));
							$p_lansia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI LANSIA'"));
							$p_mtbs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI MTBS'"));
							$p_tb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI TB DOTS'"));
							$p_ugd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UGD'"));
							$p_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UMUM'"));
							// cara bayar		
							$bpjs_nonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
									WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'BPJS NON PBI'"));
							$bpjs_pbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
									WHERE date(TanggalRegistrasi)= '$tgl' and (Asuransi like '%BPJS PBI%' OR Asuransi like '%BPJS%')"));
							$gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
									WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'GRATIS'"));
							$sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
									WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'SKTM'"));
							$umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
									WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'UMUM'"));
							// wilayah
							// $dalam_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.IdPasienrj,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Baru' and b.Wilayah = 'DALAM'"));
							// $dalam_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.IdPasienrj,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Lama' and b.Wilayah = 'DALAM'"));
							// $jml_dalam = $dalam_b['Jumlah'] + $dalam_l['Jumlah'];
							// $luar_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.IdPasienrj,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Baru' and b.Wilayah = 'LUAR'"));
							// $luar_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.IdPasienrj,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Lama' and b.Wilayah = 'LUAR'"));
							// $jml_luar = $luar_b['Jumlah'] + $luar_l['Jumlah'];
							// total					
							$totaljml_psn[] = $jmlpsn['Jumlah'];
							$totaljml_psn_L[] = $jmlpsn_L['Jumlah'];
							$totaljml_psn_P[] = $jmlpsn_P['Jumlah'];
							$totaljml_07Hr_B[] = $jml07Hr_B['Jumlah'];
							$totaljml_07Hr_L[] = $jml07Hr_L['Jumlah'];
							$totaljml_0830Hr_B[] = $jml0830Hr_B['Jumlah'];
							$totaljml_0830Hr_L[] = $jml0830Hr_L['Jumlah'];
							$totaljml_0112Bl_B[] = $jml0112Bl_B['Jumlah'];
							$totaljml_0112Bl_L[] = $jml0112Bl_L['Jumlah'];
							$totaljml_l14Th_B[] = $jml14Th_B['Jumlah'];
							$totaljml_l14Th_L[] = $jml14Th_L['Jumlah'];
							$totaljml_059Th_B[] = $jml59Th_B['Jumlah'];
							$totaljml_059Th_L[] = $jml59Th_L['Jumlah'];
							$totaljml_1014Th_B[] = $jml1014Th_B['Jumlah'];
							$totaljml_1014Th_L[] = $jml1014Th_L['Jumlah'];
							$totaljml_1519Th_B[] = $jml1519Th_B['Jumlah'];
							$totaljml_1519Th_L[] = $jml1519Th_L['Jumlah'];
							$totaljml_2044Th_B[] = $jml2044Th_B['Jumlah'];
							$totaljml_2044Th_L[] = $jml2044Th_L['Jumlah'];
							$totaljml_4554Th_B[] = $jml4554Th_B['Jumlah'];
							$totaljml_4554Th_L[] = $jml4554Th_L['Jumlah'];
							$totaljml_5559Th_B[] = $jml5559Th_B['Jumlah'];
							$totaljml_5559Th_L[] = $jml5559Th_L['Jumlah'];
							$totaljml_6069Th_B[] = $jml6069Th_B['Jumlah'];
							$totaljml_6069Th_L[] = $jml6069Th_L['Jumlah'];
							$totaljml_70Th_B[] = $jml70Th_B['Jumlah'];
							$totaljml_70Th_L[] = $jml70Th_L['Jumlah'];
							$totaljml_p_gigi[] = $p_gigi['Jumlah'];
							$totaljml_p_kb[] = $p_kb['Jumlah'];
							$totaljml_p_kia[] = $p_kia['Jumlah'];
							$totaljml_p_lansia[] = $p_lansia['Jumlah'];
							$totaljml_p_mtbs[] = $p_mtbs['Jumlah'];
							$totaljml_p_tb[] = $p_tb['Jumlah'];
							$totaljml_p_ugd[] = $p_ugd['Jumlah'];
							$totaljml_p_umum[] = $p_umum['Jumlah'];
							$totaljml_bpjs_nonpbi[] = $bpjs_nonpbi['Jumlah'];
							$totaljml_bpjs_pbi[] = $bpjs_pbi['Jumlah'];
							$totaljml_gratis[] = $gratis['Jumlah'];
							$totaljml_sktm[] = $sktm['Jumlah'];
							$totaljml_umum[] = $umum['Jumlah'];
							// $totaljml_dalam_b[] = $dalam_b['Jumlah'];
							// $totaljml_dalam_l[] = $dalam_l['Jumlah'];
							// $totaljml_jml_dalam[] = $jml_dalam;
							// $totaljml_luar_b[] = $luar_b['Jumlah'];
							// $totaljml_luar_l[] = $luar_l['Jumlah'];
							// $totaljml_jml_luar[] = $jml_luar;
						?>
							<tr style="border:1px solid #000;">
								<td><?php echo $i->format("d");?></td>	
								<td><?php echo $jmlpsn['Jumlah'];?></td>	
								<td><?php echo $jmlpsn_L['Jumlah'];?></td>	
								<td><?php echo $jmlpsn_P['Jumlah'];?></td>	
								<td><?php echo $jml07Hr_B['Jumlah'];?></td>	
								<td><?php echo $jml07Hr_L['Jumlah'];?></td>	
								<td><?php echo $jml0830Hr_B['Jumlah'];?></td>	
								<td><?php echo $jml0830Hr_L['Jumlah'];?></td>	
								<td><?php echo $jml0112Bl_B['Jumlah'];?></td>	
								<td><?php echo $jml0112Bl_L['Jumlah'];?></td>	
								<td><?php echo $jml14Th_B['Jumlah'];?></td>	
								<td><?php echo $jml14Th_L['Jumlah'];?></td>	
								<td><?php echo $jml59Th_B['Jumlah'];?></td>	
								<td><?php echo $jml59Th_L['Jumlah'];?></td>	
								<td><?php echo $jml1014Th_B['Jumlah'];?></td>	
								<td><?php echo $jml1014Th_L['Jumlah'];?></td>	
								<td><?php echo $jml1519Th_B['Jumlah'];?></td>	
								<td><?php echo $jml1519Th_L['Jumlah'];?></td>	
								<td><?php echo $jml2044Th_B['Jumlah'];?></td>	
								<td><?php echo $jml2044Th_L['Jumlah'];?></td>	
								<td><?php echo $jml4554Th_B['Jumlah'];?></td>	
								<td><?php echo $jml4554Th_L['Jumlah'];?></td>	
								<td><?php echo $jml5559Th_B['Jumlah'];?></td>	
								<td><?php echo $jml5559Th_L['Jumlah'];?></td>	
								<td><?php echo $jml6069Th_B['Jumlah'];?></td>	
								<td><?php echo $jml6069Th_L['Jumlah'];?></td>	
								<td><?php echo $jml70Th_B['Jumlah'];?></td>	
								<td><?php echo $jml70Th_L['Jumlah'];?></td>	
								<td><?php echo $p_gigi['Jumlah'];?></td>	
								<td><?php echo $p_ugd['Jumlah'];?></td>	
								<td><?php echo $p_kb['Jumlah'];?></td>	
								<td><?php echo $p_kia['Jumlah'];?></td>	
								<td><?php echo $p_lansia['Jumlah'];?></td>	
								<td><?php echo $p_mtbs['Jumlah'];?></td>	
								<td><?php echo $p_tb['Jumlah'];?></td>
								<td><?php echo $p_umum['Jumlah'];?></td>	
								<td><?php echo $bpjs_nonpbi['Jumlah'];?></td>	
								<td><?php echo $bpjs_pbi['Jumlah'];?></td>	
								<td><?php echo $gratis['Jumlah'];?></td>
								<td><?php echo $sktm['Jumlah'];?></td>
								<td><?php echo $umum['Jumlah'];?></td>	
								<!-- <td><?php echo $dalam_b['Jumlah'];?></td>	
								<td><?php echo $dalam_l['Jumlah'];?></td>	
								<td><?php echo $jml_dalam;?></td>	
								<td><?php echo $luar_b['Jumlah'];?></td>	
								<td><?php echo $luar_l['Jumlah'];?></td>	
								<td><?php echo $jml_luar;?></td>	 -->
							</tr>
						<?php
						}
						?>
						<tr style="border:1px solid #000;">
							<td></td>	
							<td><?php echo array_sum($totaljml_psn);?></td>	
							<td><?php echo array_sum($totaljml_psn_L);?></td>	
							<td><?php echo array_sum($totaljml_psn_P);?></td>	
							<td><?php echo array_sum($totaljml_07Hr_B);?></td>	
							<td><?php echo array_sum($totaljml_07Hr_L);?></td>	
							<td><?php echo array_sum($totaljml_0830Hr_B);?></td>
							<td><?php echo array_sum($totaljml_0830Hr_L);?></td>						
							<td><?php echo array_sum($totaljml_0112Bl_B);?></td>						
							<td><?php echo array_sum($totaljml_0112Bl_L);?></td>						
							<td><?php echo array_sum($totaljml_l14Th_B);?></td>						
							<td><?php echo array_sum($totaljml_l14Th_L);?></td>						
							<td><?php echo array_sum($totaljml_059Th_B);?></td>						
							<td><?php echo array_sum($totaljml_059Th_L);?></td>						
							<td><?php echo array_sum($totaljml_1014Th_B);?></td>						
							<td><?php echo array_sum($totaljml_1014Th_L);?></td>						
							<td><?php echo array_sum($totaljml_1519Th_B);?></td>						
							<td><?php echo array_sum($totaljml_1519Th_L);?></td>						
							<td><?php echo array_sum($totaljml_2044Th_B);?></td>						
							<td><?php echo array_sum($totaljml_2044Th_L);?></td>						
							<td><?php echo array_sum($totaljml_4554Th_B);?></td>						
							<td><?php echo array_sum($totaljml_4554Th_L);?></td>						
							<td><?php echo array_sum($totaljml_5559Th_B);?></td>						
							<td><?php echo array_sum($totaljml_5559Th_L);?></td>						
							<td><?php echo array_sum($totaljml_6069Th_B);?></td>						
							<td><?php echo array_sum($totaljml_6069Th_L);?></td>						
							<td><?php echo array_sum($totaljml_70Th_B);?></td>						
							<td><?php echo array_sum($totaljml_70Th_L);?></td>						
							<td><?php echo array_sum($totaljml_p_gigi);?></td>						
							<td><?php echo array_sum($totaljml_p_kb);?></td>						
							<td><?php echo array_sum($totaljml_p_kia);?></td>						
							<td><?php echo array_sum($totaljml_p_lansia);?></td>						
							<td><?php echo array_sum($totaljml_p_mtbs);?></td>	
							<td><?php echo array_sum($totaljml_p_tb);?></td>
							<td><?php echo array_sum($totaljml_p_ugd);?></td>					
							<td><?php echo array_sum($totaljml_p_umum);?></td>						
							<td><?php echo array_sum($totaljml_bpjs_nonpbi);?></td>						
							<td><?php echo array_sum($totaljml_bpjs_pbi);?></td>						
							<td><?php echo array_sum($totaljml_gratis);?></td>
							<td><?php echo array_sum($totaljml_sktm);?></td>				
							<td><?php echo array_sum($totaljml_umum);?></td>						
							<!-- <td><?php echo array_sum($totaljml_dalam_b);?></td>						
							<td><?php echo array_sum($totaljml_dalam_l);?></td>						
							<td><?php echo array_sum($totaljml_jml_dalam);?></td>						
							<td><?php echo array_sum($totaljml_luar_b);?></td>						
							<td><?php echo array_sum($totaljml_luar_l);?></td>						
							<td><?php echo array_sum($totaljml_jml_luar);?></td>						 -->
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