<?php
	session_start();
	include "otoritas.php";
	include "config/helper_pasienrj.php";?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>POLI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_sp2tp_poli"/>
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
							<a href="?page=lap_sp2tp_poli" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_sp2tp_poli_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN POLI</b></span><br>
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
							<th colspan="4" width="10%">ANAK</th>
							<th colspan="4" width="10%">GIGI</th>
							<th colspan="4" width="10%">GIZI</th>
							<th colspan="4" width="10%">IMUNISASI</th>
							<th colspan="4" width="10%">KB</th>
							<th colspan="4" width="10%">KIA</th>
							<th colspan="4" width="10%">LAB</th>
							<th colspan="4" width="10%">UMUM</th>
							<th colspan="4" width="10%">TINDAKAN</th>
							<th colspan="4" width="5%">TOTAL</th>
							<th rowspan="3" width="5%">JML</th>
													
						</tr>
						<tr>
							<th colspan="2">B</th><!--anak-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--gigi-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--gizi-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--imunisasi-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--kb-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--kia-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--lab-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--umum-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--tindakan-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--total-->
							<th colspan="2">L</th>
						</tr>
						<tr>
							<th>L</th><!--anak-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--gigi-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--gizi-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--imunisasi-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--kb-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--kia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--lab-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--umum-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--tindakan-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--total-->
							<th>P</th>
							<th>L</th>
							<th>P</th>							
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
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

						$tgl1 = $tahun.'-'.$bulan.'-01';
						$tgl2 = date('Y-m-t', strtotime($tgl1));
						$begin = new DateTime( $tgl1 );
						$end   = new DateTime( $tgl2 );
						for($i = $begin; $i <= $end; $i->modify('+1 day')){
							$tgl = $i->format("Y-m-d");			
							// $jmlpsn_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'L'"));
							// $jmlpsn_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'P'"));
							// $jmlpsn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl'"));
							
							// anak
							$anak_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI ANAK' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$anak_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI ANAK' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$anak_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI ANAK' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$anak_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI ANAK' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// // gigi
							$gigi_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIGI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$gigi_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIGI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$gigi_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIGI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$gigi_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIGI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// gizi
							$gizi_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIZI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$gizi_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIZI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$gizi_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIZI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$gizi_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIZI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
					
							// imunisasi
							$imunisasi_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI IMUNISASI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$imunisasi_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI IMUNISASI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$imunisasi_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI IMUNISASI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$imunisasi_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI IMUNISASI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// kb
							$kb_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KB' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$kb_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KB' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$kb_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KB' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$kb_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KB' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// kia
							$kia_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KIA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$kia_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KIA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$kia_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KIA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$kia_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KIA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// lab
							$lab_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI LABORATORIUM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$lab_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI LABORATORIUM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$lab_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI LABORATORIUM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$lab_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI LABORATORIUM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// umum
							$umum_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UMUM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$umum_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UMUM' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$umum_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UMUM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$umum_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UMUM' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// tindakan
							$tindakan_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI TINDAKAN' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$tindakan_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI TINDAKAN' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$tindakan_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI TINDAKAN' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$tindakan_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI TINDAKAN' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// jumlah
							$jumlah_b_l = $anak_b_l['Jumlah'] + $gigi_b_l['Jumlah'] + $gizi_b_l['Jumlah'] + $imunisasi_b_l['Jumlah'] + $kb_b_l['Jumlah'] + $kia_b_l['Jumlah'] + $lab_b_l['Jumlah'] + $umum_b_l['Jumlah'] + $tindakan_b_l['Jumlah'];
							$jumlah_b_p = $anak_b_p['Jumlah'] + $gigi_b_p['Jumlah'] + $gizi_b_p['Jumlah'] + $imunisasi_b_p['Jumlah'] + $kb_b_p['Jumlah'] + $kia_b_p['Jumlah'] + $lab_b_p['Jumlah'] + $umum_b_p['Jumlah'] + $tindakan_b_p['Jumlah'];
							$jumlah_l_l = $anak_l_l['Jumlah'] + $gigi_l_l['Jumlah'] + $gizi_l_l['Jumlah'] + $imunisasi_l_l['Jumlah'] + $kb_l_l['Jumlah'] + $kia_l_l['Jumlah'] + $lab_l_l['Jumlah'] + $umum_l_l['Jumlah'] + $tindakan_l_l['Jumlah'];
							$jumlah_l_p = $anak_l_p['Jumlah'] + $gigi_l_p['Jumlah'] + $gizi_l_p['Jumlah'] + $imunisasi_l_p['Jumlah'] + $kb_l_p['Jumlah'] + $kia_l_p['Jumlah'] + $lab_l_p['Jumlah'] + $umum_l_p['Jumlah'] + $tindakan_l_p['Jumlah'];
							$total = $jumlah_b_l + $jumlah_b_p + $jumlah_l_l + $jumlah_l_p;
							
							// total		
							// $totaljml_anak_b_l[] = $anak_b_l['Jumlah']; // anak
							// $totaljml_anak_b_p[] = $anak_b_p['Jumlah'];
							// $totaljml_anak_l_l[] = $anak_l_l['Jumlah'];
							// $totaljml_anak_l_p[] = $anak_l_p['Jumlah'];
							// $totaljml_gigi_b_l[] = $gigi_b_l['Jumlah']; // gigi
							// $totaljml_gigi_b_p[] = $gigi_b_p['Jumlah'];
							// $totaljml_gigi_l_l[] = $gigi_l_l['Jumlah'];
							// $totaljml_gigi_l_p[] = $gigi_l_p['Jumlah'];
							// $totaljml_gizi_b_l[] = $gizi_b_l['Jumlah']; // gizi
							// $totaljml_gizi_b_p[] = $gizi_b_p['Jumlah'];
							// $totaljml_gizi_l_l[] = $gizi_l_l['Jumlah'];
							// $totaljml_gizi_l_p[] = $gizi_l_p['Jumlah'];
							// $totaljml_imunisasi_b_l[] = $imunisasi_b_l['Jumlah']; // imunisasi
							// $totaljml_imunisasi_b_p[] = $imunisasi_b_p['Jumlah'];
							// $totaljml_imunisasi_l_l[] = $imunisasi_l_l['Jumlah'];
							// $totaljml_imunisasi_l_p[] = $imunisasi_l_p['Jumlah'];
							// $totaljml_kb_b_l[] = $kb_b_l['Jumlah']; // kb
							// $totaljml_kb_b_p[] = $kb_b_p['Jumlah'];
							// $totaljml_kb_l_l[] = $kb_l_l['Jumlah'];
							// $totaljml_kb_l_p[] = $kb_l_p['Jumlah'];
							// $totaljml_kia_b_l[] = $kia_b_l['Jumlah']; // kia
							// $totaljml_kia_b_p[] = $kia_b_p['Jumlah'];
							// $totaljml_kia_l_l[] = $kia_l_l['Jumlah'];
							// $totaljml_kia_l_p[] = $kia_l_p['Jumlah'];
							// $totaljml_lab_b_l[] = $lab_b_l['Jumlah']; // lab
							// $totaljml_lab_b_p[] = $lab_b_p['Jumlah'];
							// $totaljml_lab_l_l[] = $lab_l_l['Jumlah'];
							// $totaljml_lab_l_p[] = $lab_l_p['Jumlah'];
							// $totaljml_umum_b_l[] = $umum_b_l['Jumlah']; // umum
							// $totaljml_umum_b_p[] = $umum_b_p['Jumlah'];
							// $totaljml_umum_l_l[] = $umum_l_l['Jumlah'];
							// $totaljml_umum_l_p[] = $umum_l_p['Jumlah'];
							// $totaljml_tindakan_b_l[] = $tindakan_b_l['Jumlah']; // tindakan
							// $totaljml_tindakan_b_p[] = $tindakan_b_p['Jumlah'];
							// $totaljml_tindakan_l_l[] = $tindakan_l_l['Jumlah'];
							// $totaljml_tindakan_l_p[] = $tindakan_l_p['Jumlah'];
							// $totaljml_jumlah_b_l[] = $jumlah_b_l; // jumlah
							// $totaljml_jumlah_b_p[] = $jumlah_b_p;
							// $totaljml_jumlah_l_l[] = $jumlah_l_l;
							// $totaljml_jumlah_l_p[] = $jumlah_l_p;
							// $totaljml[] = $jumlah_b_l + $jumlah_b_p + $jumlah_l_l + $jumlah_l_p;
						?>
							<tr>
								<td align="center"><?php echo $i->format("d");?></td>	
								<td align="right"><?php echo $anak_b_l['Jumlah'];?></td><!--anak-->
								<td align="right"><?php echo $anak_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $anak_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $anak_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $gigi_b_l['Jumlah'];?></td><!--gigi-->
								<td align="right"><?php echo $gigi_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $gigi_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $gigi_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $gizi_b_l['Jumlah'];?></td><!--gizi-->
								<td align="right"><?php echo $gizi_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $gizi_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $gizi_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $imunisasi_b_l['Jumlah'];?></td><!--imunisasi-->
								<td align="right"><?php echo $imunisasi_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $imunisasi_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $imunisasi_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $kb_b_l['Jumlah'];?></td><!--kb-->
								<td align="right"><?php echo $kb_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $kb_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $kb_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $kia_b_l['Jumlah'];?></td><!--kia-->
								<td align="right"><?php echo $kia_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $kia_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $kia_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $lab_b_l['Jumlah'];?></td><!--lab-->
								<td align="right"><?php echo $lab_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $lab_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $lab_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $umum_b_l['Jumlah'];?></td><!--umum-->
								<td align="right"><?php echo $umum_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $umum_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $umum_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $tindakan_b_l['Jumlah'];?></td><!--tindakan-->
								<td align="right"><?php echo $tindakan_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $tindakan_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $tindakan_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $jumlah_b_l;?></td><!--total-->
								<td align="right"><?php echo $jumlah_b_p;?></td>	
								<td align="right"><?php echo $jumlah_l_l;?></td>	
								<td align="right"><?php echo $jumlah_l_p;?></td>
								<td align="right"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
						<!-- <tr>
							<td align="center"></td>							
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_b_l);?></td>
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjsnonpbi_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_b_l);?></td>
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_bpjspbi_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_program_b_l);?></td>
							<td align="right"><?php echo array_sum($totaljml_program_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_program_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_program_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_umum_b_l);?></td>
							<td align="right"><?php echo array_sum($totaljml_umum_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_umum_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_umum_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_jumlah_b_l);?></td>
							<td align="right"><?php echo array_sum($totaljml_jumlah_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_jumlah_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_jumlah_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml);?></td>
						</tr> -->
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