<?php
	session_start();
	include "otoritas.php";
	include "config/helper_pasienrj.php";?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>CARA BAYAR</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_sp2tp_carabayar"/>
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_sp2tp_carabayar" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_sp2tp_carabayar_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN SP2TP - CARA BAYAR</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive" width="100%">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="3" width="5%">TGL</th>
							<th colspan="4" width="10%">JUMLAH</th>
							<th rowspan="3" width="10%">TOTAL</th>	
							<th colspan="4" width="10%">UMUM</th>
							<th colspan="4" width="10%">BPJS NON PBI</th>
							<th colspan="4" width="10%">BPJS PBI</th>
							<th colspan="4" width="10%">KIR UMUM</th>
							<th colspan="4" width="10%">KIR LEGALISIR</th>
							<th colspan="4" width="10%">KIR HAJI PLUS</th>
							<th colspan="4" width="10%">PROGRAM</th>
						</tr>
						<tr>
							
							<th colspan="2">B</th><!--jumlah-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--umum-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--bpjs non pbi-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--bpjs pbi-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--kir umum-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--kir legalisir-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--kir haji plus-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--program-->
							<th colspan="2">L</th>
						</tr>
						<tr>
							<th>L</th><!--jumlah-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--umum-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--bpjs non pbi-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--bpjs pbi-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--kir umum-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--kir legalisir-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--kir haji plus-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--program-->
							<th>P</th>
							<th>L</th>
							<th>P</th>							
														
						</tr>
					</thead>
					<tbody>
						<?php
						// tahap 1, bikin tabel replika
						$str_replika = "SELECT * FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan'";
						$queryreplika = mysqli_query($koneksi, $str_replika);
						mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan`");
						while($datarp = mysqli_fetch_assoc($queryreplika)){
							if($datarp[TarifTindakan] == ''){ $tariftindakan = '0'; }else{ $tariftindakan = $datarp[TarifTindakan]; }
							if($datarp[TotalTarif] == ''){ $totaltarif = '0'; }else{ $totaltarif = $datarp[TotalTarif]; }

							$str_replika = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,
							`NoRM`,`NamaPasien`,`JenisKelamin`,`UmurTahun`,`UmurBulan`,
							`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,
							`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`StatusBuku`,`JamKembaliRM`,
							`TarifKarcis`,`TarifKir`,`TarifTindakan`,`TotalTarif`,`StatusPelayanan`,
							`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`NoKunjunganBpjs`,
							`NoUrutBpjs`,`kdprovider`,`nokartu`,`kdpoli`,`Kir`,
							`StatusBayar`,`NoAntrianPoli`,`StatusAntrianPoli`,`KeteranganBridging`,`Pekerjaan`) VALUES 
							('$datarp[TanggalRegistrasi]','$datarp[NoRegistrasi]','$datarp[NoIndex]','$datarp[NoCM]',
							'$datarp[NoRM]','$datarp[NamaPasien]','$datarp[JenisKelamin]','$datarp[UmurTahun]','$datarp[UmurBulan]',
							'$datarp[UmurHari]','$datarp[JenisKunjungan]','$datarp[AsalPasien]','$datarp[StatusPasien]','$datarp[PoliPertama]',
							'$datarp[Asuransi]','$datarp[StatusKunjungan]','$datarp[WaktuKunjungan]','$datarp[StatusBuku]','$datarp[JamKembaliRM]',
							'$datarp[TarifKarcis]','$datarp[TarifKir]','$tariftindakan','$totaltarif','$datarp[StatusPelayanan]',
							'$datarp[StatusPulang]','$datarp[NamaPegawaiSimpan]','$datarp[NamaPegawaiEdit]','$datarp[NoKunjunganBpjs]',
							'$datarp[NoUrutBpjs]','$datarp[kdprovider]','$datarp[nokartu]','$datarp[kdpoli]','$datarp[Kir]',
							'$datarp[StatusBayar]','$datarp[NoAntrianPoli]','$datarp[StatusAntrianPoli]','$datarp[KeteranganBridging]','$datarp[Pekerjaan]')";
							// echo $str_replika;
							// die();
							mysqli_query($koneksi, $str_replika);
						}
						
						// tahap 2, pangil tabel replika
						$tgl1 = $tahun.'-'.$bulan.'-01';
						$tgl2 = date('Y-m-t', strtotime($tgl1));
						$begin = new DateTime( $tgl1 );
						$end   = new DateTime( $tgl2 );
						for($i = $begin; $i <= $end; $i->modify('+1 day')){
							$tgl = $i->format("Y-m-d");			
							$jmlpsn_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'L'"));
							$jmlpsn_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'P'"));
							$jmlpsn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl'"));
							
							// umum
							$umum_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'UMUM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$umum_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'UMUM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$umum_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'UMUM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$umum_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'UMUM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// bpjs non pbi
							$bpjsnonpbi_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS NON PBI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$bpjsnonpbi_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS NON PBI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$bpjsnonpbi_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS NON PBI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$bpjsnonpbi_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS NON PBI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// bpjs non pbi
							$bpjspbi_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS PBI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$bpjspbi_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS PBI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$bpjspbi_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS PBI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$bpjspbi_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'BPJS PBI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// kir_umum
							$kir_umum_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND (`Kir` like '%Umum%' OR `Kir` like '%Haji Biasa%' OR `Kir` like '%Penyaji Makanan%') AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$kir_umum_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND (`Kir` like '%Umum%' OR `Kir` like '%Haji Biasa%' OR `Kir` like '%Penyaji Makanan%') AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$kir_umum_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND (`Kir` like '%Umum%' OR `Kir` like '%Haji Biasa%' OR `Kir` like '%Penyaji Makanan%') AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$kir_umum_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND (`Kir` like '%Umum%' OR `Kir` like '%Haji Biasa%' OR `Kir` like '%Penyaji Makanan%') AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// kir_legalisir
							$kir_legalisir_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Legalisir%' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$kir_legalisir_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Legalisir%' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$kir_legalisir_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Legalisir%' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$kir_legalisir_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Legalisir%' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// kir_hajiplus
							$kir_hajiplus_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Haji Plus%' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$kir_hajiplus_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Haji Plus%' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$kir_hajiplus_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Haji Plus%' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$kir_hajiplus_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Kir` like '%Haji Plus%' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// program
							$program_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'PROGRAM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$program_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'PROGRAM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$program_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'PROGRAM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$program_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Asuransi` = 'PROGRAM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// jumlah
							$jumlah_b_l = $umum_b_l['Jumlah'] + $bpjsnonpbi_b_l['Jumlah'] + $bpjspbi_b_l['Jumlah'] + $kir_umum_b_l['Jumlah'] + $kir_legalisir_b_l['Jumlah'] + $kir_hajiplus_b_l['Jumlah'] + $program_b_l['Jumlah'];
							$jumlah_b_p = $umum_b_p['Jumlah'] + $bpjsnonpbi_b_p['Jumlah'] + $bpjspbi_b_p['Jumlah'] + $kir_umum_b_p['Jumlah'] + $kir_legalisir_b_p['Jumlah'] + $kir_hajiplus_b_p['Jumlah'] + $program_b_p['Jumlah'];
							$jumlah_l_l = $umum_l_l['Jumlah'] + $bpjsnonpbi_l_l['Jumlah'] + $bpjspbi_l_l['Jumlah'] + $kir_umum_l_l['Jumlah'] + $kir_legalisir_l_l['Jumlah'] + $kir_hajiplus_l_l['Jumlah'] + $program_l_l['Jumlah'];
							$jumlah_l_p = $umum_l_p['Jumlah'] + $bpjsnonpbi_l_p['Jumlah'] + $bpjspbi_l_p['Jumlah'] + $kir_umum_l_p['Jumlah'] + $kir_legalisir_l_p['Jumlah'] + $kir_hajiplus_l_p['Jumlah'] + $program_l_p['Jumlah'];
							$total = $jumlah_b_l + $jumlah_b_p + $jumlah_l_l + $jumlah_l_p;
							
							// total		
							$totaljml_umum_b_l[] = $umum_b_l['Jumlah']; // umum
							$totaljml_umum_b_p[] = $umum_b_p['Jumlah'];
							$totaljml_umum_l_l[] = $umum_l_l['Jumlah'];
							$totaljml_umum_l_p[] = $umum_l_p['Jumlah'];
							$totaljml_bpjsnonpbi_b_l[] = $bpjsnonpbi_b_l['Jumlah']; // bpjs non pbi
							$totaljml_bpjsnonpbi_b_p[] = $bpjsnonpbi_b_p['Jumlah'];
							$totaljml_bpjsnonpbi_l_l[] = $bpjsnonpbi_l_l['Jumlah'];
							$totaljml_bpjsnonpbi_l_p[] = $bpjsnonpbi_l_p['Jumlah'];
							$totaljml_bpjspbi_b_l[] = $bpjspbi_b_l['Jumlah']; // bpjs pbi
							$totaljml_bpjspbi_b_p[] = $bpjspbi_b_p['Jumlah'];
							$totaljml_bpjspbi_l_l[] = $bpjspbi_l_l['Jumlah'];
							$totaljml_bpjspbi_l_p[] = $bpjspbi_l_p['Jumlah'];
							$totaljml_kir_umum_b_l[] = $kir_umum_b_l['Jumlah']; // kir_umum
							$totaljml_kir_umum_b_p[] = $kir_umum_b_p['Jumlah'];
							$totaljml_kir_umum_l_l[] = $kir_umum_l_l['Jumlah'];
							$totaljml_kir_umum_l_p[] = $kir_umum_l_p['Jumlah'];
							$totaljml_kir_legalisir_b_l[] = $kir_legalisir_b_l['Jumlah']; // kir_legalisir
							$totaljml_kir_legalisir_b_p[] = $kir_legalisir_b_p['Jumlah'];
							$totaljml_kir_legalisir_l_l[] = $kir_legalisir_l_l['Jumlah'];
							$totaljml_kir_legalisir_l_p[] = $kir_legalisir_l_p['Jumlah'];
							$totaljml_kir_hajiplus_b_l[] = $kir_hajiplus_b_l['Jumlah']; // kir_hajiplus
							$totaljml_kir_hajiplus_b_p[] = $kir_hajiplus_b_p['Jumlah'];
							$totaljml_kir_hajiplus_l_l[] = $kir_hajiplus_l_l['Jumlah'];
							$totaljml_kir_hajiplus_l_p[] = $kir_hajiplus_l_p['Jumlah'];
							$totaljml_program_b_l[] = $program_b_l['Jumlah']; // program
							$totaljml_program_b_p[] = $program_b_p['Jumlah'];
							$totaljml_program_l_l[] = $program_l_l['Jumlah'];
							$totaljml_program_l_p[] = $program_l_p['Jumlah'];
							$totaljml_jumlah_b_l[] = $jumlah_b_l; // jumlah
							$totaljml_jumlah_b_p[] = $jumlah_b_p;
							$totaljml_jumlah_l_l[] = $jumlah_l_l;
							$totaljml_jumlah_l_p[] = $jumlah_l_p;
							$totaljml[] = $jumlah_b_l + $jumlah_b_p + $jumlah_l_l + $jumlah_l_p;
						?>
							<tr>
								<td align="center"><?php echo $i->format("d");?></td>	
								<td align="right"><?php echo $jumlah_b_l;?></td><!--jumlah-->
								<td align="right"><?php echo $jumlah_b_p;?></td>	
								<td align="right"><?php echo $jumlah_l_l;?></td>	
								<td align="right"><?php echo $jumlah_l_p;?></td>
								<td align="right"><?php echo $total;?></td><!--total-->
								<td align="right"><?php echo $umum_b_l['Jumlah'];?></td><!--umum-->
								<td align="right"><?php echo $umum_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $umum_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $umum_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $bpjsnonpbi_b_l['Jumlah'];?></td><!--bpjs non pbi-->
								<td align="right"><?php echo $bpjsnonpbi_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $bpjsnonpbi_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $bpjsnonpbi_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $bpjspbi_b_l['Jumlah'];?></td><!--bpjs pbi-->
								<td align="right"><?php echo $bpjspbi_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $bpjspbi_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $bpjspbi_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $kir_umum_b_l['Jumlah'];?></td><!--kir_umum-->
								<td align="right"><?php echo $kir_umum_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $kir_umum_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $kir_umum_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $kir_legalisir_b_l['Jumlah'];?></td><!--kir_legalisir-->
								<td align="right"><?php echo $kir_legalisir_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $kir_legalisir_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $kir_legalisir_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $kir_hajiplus_b_l['Jumlah'];?></td><!--kir_hajiplus-->
								<td align="right"><?php echo $kir_hajiplus_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $kir_hajiplus_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $kir_hajiplus_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $program_b_l['Jumlah'];?></td><!--program-->
								<td align="right"><?php echo $program_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $program_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $program_l_p['Jumlah'];?></td>
							</tr>
						<?php
						}
						?>
						<tr>
							<td align="center"></td>							
							<td align="right"><?php echo array_sum($totaljml_umum_b_l);?></td><!--umum-->
							<td align="right"><?php echo array_sum($totaljml_umum_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_umum_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_umum_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_b_l);?></td><!--bpjs non pbi-->
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_b_l);?></td><!--bpjs pbi-->
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_kir_umum_b_l);?></td><!--kir_umum-->
							<td align="right"><?php echo array_sum($totaljml_kir_umum_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_kir_umum_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_kir_umum_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_kir_legalisir_b_l);?></td><!--kir_legalisir-->
							<td align="right"><?php echo array_sum($totaljml_kir_legalisir_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_kir_legalisir_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_kir_legalisir_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_kir_hajiplus_b_l);?></td><!--kir_hajiplus-->
							<td align="right"><?php echo array_sum($totaljml_kir_hajiplus_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_kir_hajiplus_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_kir_hajiplus_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_program_b_l);?></td><!--program-->
							<td align="right"><?php echo array_sum($totaljml_program_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_program_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_program_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_jumlah_b_l);?></td><!--jumlah-->
							<td align="right"><?php echo array_sum($totaljml_jumlah_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_jumlah_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_jumlah_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml);?></td><!--total-->
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