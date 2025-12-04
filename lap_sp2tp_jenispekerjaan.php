<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>JENIS PEKERJAAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_sp2tp_jenispekerjaan"/>
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
						<div class="col-sm-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_sp2tp_jenispekerjaan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_sp2tp_jenispekerjaan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN SP2TP - JENIS PEKERJAAN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3">TGL</th>
							<th colspan="4">BELUM BEKERJA</th>
							<th colspan="4">IRT</th>
							<th colspan="4">MAHASISWA</th>
							<th colspan="4">NELAYAN</th>
							<th colspan="4">PEGAWAI SWASTA</th>
							<th colspan="4">PELAJAR</th>
							<th colspan="4">PENSIUN</th>
							<th colspan="4">PETANI</th>
							<th colspan="4">BURUH</th>
							<th colspan="4">TKI</th>
							<th colspan="4">SWASTA</th>
							<th colspan="4">PNS</th>
							<th colspan="4">POLRI</th>	
							<th colspan="4">TNI</th>
							<th rowspan="3">TOTAL</th>
													
						</tr>
						<tr>							
							<th colspan="2">B</th><!--belum bekerja-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--irt-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--mahasiswa-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--nelayan-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--pegawai swasta-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--pelajar-->
							<th colspan="2">L</th>	
							<th colspan="2">B</th><!--pensiun-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--petani-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--buruh-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--tki-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--swasta-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--pns-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--polri-->
							<th colspan="2">L</th>	
							<th colspan="2">B</th><!--tni-->
							<th colspan="2">L</th>
						</tr>
						<tr>
							<th>L</th><!--belum bekerja-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--irt-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--mahasiswa-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--nelayan-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--pegawai swasta-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--pelajar-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--pensiun-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--petani-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--buruh-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--tki-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--swasta-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--pns-->
							<th>P</th>
							<th>L</th>
							<th>P</th>	
							<th>L</th><!--polri-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--tni-->
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
							
							// belum bekerja
							$blmkerja_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BELUM BEKERJA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$blmkerja_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BELUM BEKERJA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$blmkerja_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BELUM BEKERJA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$blmkerja_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BELUM BEKERJA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
						
							// irt
							$irt_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'IRT' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$irt_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'IRT' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$irt_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'IRT' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$irt_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'IRT' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// mahasiswa
							$mahasiswa_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'MAHASISWA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$mahasiswa_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'MAHASISWA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$mahasiswa_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'MAHASISWA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$mahasiswa_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'MAHASISWA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// nelayan
							$nelayan_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'NELAYAN' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$nelayan_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'NELAYAN' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$nelayan_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'NELAYAN' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$nelayan_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'NELAYAN' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// pegawai swasta
							$ps_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PEGAWAI SWASTA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$ps_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PEGAWAI SWASTA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$ps_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PEGAWAI SWASTA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$ps_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PEGAWAI SWASTA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// pelajar
							$pelajar_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PELAJAR' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$pelajar_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PELAJAR' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$pelajar_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PELAJAR' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$pelajar_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PELAJAR' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// pensiun
							$pensiun_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PENSIUN' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$pensiun_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PENSIUN' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$pensiun_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PENSIUN' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$pensiun_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PENSIUN' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
														
							// petani
							$petani_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PETANI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$petani_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PETANI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$petani_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PETANI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$petani_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PETANI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// buruh
							$buruh_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BURUH' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$buruh_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BURUH' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$buruh_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BURUH' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$buruh_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'BURUH' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// tki
							$tki_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TKI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$tki_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TKI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$tki_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TKI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$tki_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TKI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// swasta
							$wiraswasta_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'WIRASWASTA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$wiraswasta_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'WIRASWASTA' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$wiraswasta_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'WIRASWASTA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$wiraswasta_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'WIRASWASTA' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// pns
							$pns_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PNS' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$pns_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PNS' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$pns_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PNS' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$pns_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'PNS' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
													
							// polri
							$polri_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'POLRI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$polri_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'POLRI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$polri_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'POLRI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$polri_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'POLRI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							// tni
							$tni_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TNI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'L'"));
							$tni_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TNI' AND `StatusKunjungan`='Baru' AND `JenisKelamin` = 'P'"));
							$tni_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TNI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'L'"));
							$tni_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbpasienrj_bulan` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `Pekerjaan` = 'TNI' AND `StatusKunjungan`='Lama' AND `JenisKelamin` = 'P'"));
							
							$total = $blmkerja_b_l['Jumlah'] + $blmkerja_b_p['Jumlah'] + $blmkerja_l_l['Jumlah'] + $blmkerja_l_p['Jumlah'] +
								$irt_b_l['Jumlah'] + $irt_b_p['Jumlah'] + $irt_l_l['Jumlah'] + $irt_l_p['Jumlah'] +
								$mahasiswa_b_l['Jumlah'] + $mahasiswa_b_p['Jumlah'] + $mahasiswa_l_l['Jumlah'] + $mahasiswa_l_p['Jumlah'] +
								$nelayan_b_l['Jumlah'] + $nelayan_b_p['Jumlah'] + $nelayan_l_l['Jumlah'] + $nelayan_l_p['Jumlah'] +
								$ps_b_l['Jumlah'] + $ps_b_p['Jumlah'] + $ps_l_l['Jumlah'] + $ps_l_p['Jumlah'] +
								$pelajar_b_l['Jumlah'] + $pelajar_b_p['Jumlah'] + $pelajar_l_l['Jumlah'] + $pelajar_l_p['Jumlah'] +
								$pensiun_b_l['Jumlah'] + $pensiun_b_p['Jumlah'] + $pensiun_l_l['Jumlah'] + $pensiun_l_p['Jumlah'] +
								$petani_b_l['Jumlah'] + $petani_b_p['Jumlah'] + $petani_l_l['Jumlah'] + $petani_l_p['Jumlah']	 +
								$buruh_b_l['Jumlah'] + $buruh_b_p['Jumlah']	+ $buruh_l_l['Jumlah'] + $buruh_l_p['Jumlah'] +
								$tki_b_l['Jumlah'] + $tki_b_p['Jumlah'] + $tki_l_l['Jumlah'] + $tki_l_p['Jumlah'] +
								$wiraswasta_b_l['Jumlah'] + $wiraswasta_b_p['Jumlah'] + $wiraswasta_l_l['Jumlah'] + $wiraswasta_l_p['Jumlah'] +	
								$pns_b_l['Jumlah'] + $pns_b_p['Jumlah'] + $pns_l_l['Jumlah'] + $pns_l_p['Jumlah'] +
								$polri_b_l['Jumlah'] + $polri_b_p['Jumlah'] + $polri_l_l['Jumlah'] + $polri_l_p['Jumlah'] +
								$tni_b_l['Jumlah'] + $tni_b_p['Jumlah']	+ $tni_l_l['Jumlah'] + $tni_l_p['Jumlah'];
							
							// total		
							$totaljml_blmkerja_b_l[] = $blmkerja_b_l['Jumlah']; // blm bekerja
							$totaljml_blmkerja_b_p[] = $blmkerja_b_p['Jumlah'];
							$totaljml_blmkerja_l_l[] = $blmkerja_l_l['Jumlah'];
							$totaljml_blmkerja_l_p[] = $blmkerja_l_p['Jumlah'];
							$totaljml_irt_b_l[] = $irt_b_l['Jumlah']; // irt
							$totaljml_irt_b_p[] = $irt_b_p['Jumlah'];
							$totaljml_irt_l_l[] = $irt_l_l['Jumlah'];
							$totaljml_irt_l_p[] = $irt_l_p['Jumlah'];
							$totaljml_mahasiswa_b_l[] = $mahasiswa_b_l['Jumlah']; // mahasiswa
							$totaljml_mahasiswa_b_p[] = $mahasiswa_b_p['Jumlah'];
							$totaljml_mahasiswa_l_l[] = $mahasiswa_l_l['Jumlah'];
							$totaljml_mahasiswa_l_p[] = $mahasiswa_l_p['Jumlah'];
							$totaljml_nelayan_b_l[] = $nelayan_b_l['Jumlah']; // nelayan
							$totaljml_nelayan_b_p[] = $nelayan_b_p['Jumlah'];
							$totaljml_nelayan_l_l[] = $nelayan_l_l['Jumlah'];
							$totaljml_nelayan_l_p[] = $nelayan_l_p['Jumlah'];
							$totaljml_ps_b_l[] = $ps_b_l['Jumlah']; // pegawai swasta
							$totaljml_ps_b_p[] = $ps_b_p['Jumlah'];
							$totaljml_ps_l_l[] = $ps_l_l['Jumlah'];
							$totaljml_ps_l_p[] = $ps_l_p['Jumlah'];
							$totaljml_pelajar_b_l[] = $pelajar_b_l['Jumlah']; // pelajar
							$totaljml_pelajar_b_p[] = $pelajar_b_p['Jumlah'];
							$totaljml_pelajar_l_l[] = $pelajar_l_l['Jumlah'];
							$totaljml_pelajar_l_p[] = $pelajar_l_p['Jumlah'];
							$totaljml_pensiun_b_l[] = $pensiun_b_l['Jumlah']; // pensiun
							$totaljml_pensiun_b_p[] = $pensiun_b_p['Jumlah'];
							$totaljml_pensiun_l_l[] = $pensiun_l_l['Jumlah'];
							$totaljml_pensiun_l_p[] = $pensiun_l_p['Jumlah'];
							$totaljml_petani_b_l[] = $petani_b_l['Jumlah']; // petani
							$totaljml_petani_b_p[] = $petani_b_p['Jumlah'];
							$totaljml_petani_l_l[] = $petani_l_l['Jumlah'];
							$totaljml_petani_l_p[] = $petani_l_p['Jumlah'];
							$totaljml_buruh_b_l[] = $buruh_b_l['Jumlah']; // buruh
							$totaljml_buruh_b_p[] = $buruh_b_p['Jumlah'];
							$totaljml_buruh_l_l[] = $buruh_l_l['Jumlah'];
							$totaljml_buruh_l_p[] = $buruh_l_p['Jumlah'];
							$totaljml_tki_b_l[] = $tki_b_l['Jumlah']; // tki
							$totaljml_tki_b_p[] = $tki_b_p['Jumlah'];
							$totaljml_tki_l_l[] = $tki_l_l['Jumlah'];
							$totaljml_tki_l_p[] = $tki_l_p['Jumlah'];
							$totaljml_wiraswasta_b_l[] = $wiraswasta_b_l['Jumlah']; // wiraswasta
							$totaljml_wiraswasta_b_p[] = $wiraswasta_b_p['Jumlah'];
							$totaljml_wiraswasta_l_l[] = $wiraswasta_l_l['Jumlah'];
							$totaljml_wiraswasta_l_p[] = $wiraswasta_l_p['Jumlah'];
							$totaljml_pns_b_l[] = $pns_b_l['Jumlah']; // pns
							$totaljml_pns_b_p[] = $pns_b_p['Jumlah'];
							$totaljml_pns_l_l[] = $pns_l_l['Jumlah'];
							$totaljml_pns_l_p[] = $pns_l_p['Jumlah'];
							$totaljml_polri_b_l[] = $polri_b_l['Jumlah']; // polri
							$totaljml_polri_b_p[] = $polri_b_p['Jumlah'];
							$totaljml_polri_l_l[] = $polri_l_l['Jumlah'];
							$totaljml_polri_l_p[] = $polri_l_p['Jumlah'];	
							$totaljml_tni_b_l[] = $tni_b_l['Jumlah']; // tni
							$totaljml_tni_b_p[] = $tni_b_p['Jumlah'];
							$totaljml_tni_l_l[] = $tni_l_l['Jumlah'];
							$totaljml_tni_l_p[] = $tni_l_p['Jumlah'];
							$totaljml_psn[] = $total;
						?>
							<tr>
								<td align="center"><?php echo $i->format("d");?></td>								
								<td align="right"><?php echo $blmkerja_b_l['Jumlah'];?></td><!--belum bekerja-->
								<td align="right"><?php echo $blmkerja_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $blmkerja_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $blmkerja_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $irt_b_l['Jumlah'];?></td><!--irt-->
								<td align="right"><?php echo $irt_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $irt_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $irt_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $mahasiswa_b_l['Jumlah'];?></td><!--mahasiswa-->
								<td align="right"><?php echo $mahasiswa_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $mahasiswa_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $mahasiswa_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $nelayan_b_l['Jumlah'];?></td><!--nelayan-->
								<td align="right"><?php echo $nelayan_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $nelayan_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $nelayan_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $ps_b_l['Jumlah'];?></td><!--pegawai swasta-->
								<td align="right"><?php echo $ps_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $ps_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $ps_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $pelajar_b_l['Jumlah'];?></td><!--pelajar-->
								<td align="right"><?php echo $pelajar_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $pelajar_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $pelajar_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $pensiun_b_l['Jumlah'];?></td><!--pensiun-->
								<td align="right"><?php echo $pensiun_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $pensiun_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $pensiun_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $petani_b_l['Jumlah'];?></td><!--petani-->
								<td align="right"><?php echo $petani_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $petani_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $petani_l_p['Jumlah'];?></td>	
								<td align="right"><?php echo $buruh_b_l['Jumlah'];?></td><!--buruh-->
								<td align="right"><?php echo $buruh_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $buruh_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $buruh_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $tki_b_l['Jumlah'];?></td><!--tki-->
								<td align="right"><?php echo $tki_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $tki_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $tki_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $wiraswasta_b_l['Jumlah'];?></td><!--wiraswasta-->
								<td align="right"><?php echo $wiraswasta_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $wiraswasta_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $wiraswasta_l_p['Jumlah'];?></td>	
								<td align="right"><?php echo $pns_b_l['Jumlah'];?></td><!--pns-->
								<td align="right"><?php echo $pns_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $pns_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $pns_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $polri_b_l['Jumlah'];?></td><!--polri-->
								<td align="right"><?php echo $polri_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $polri_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $polri_l_p['Jumlah'];?></td>	
								<td align="right"><?php echo $tni_b_l['Jumlah'];?></td><!--tni-->
								<td align="right"><?php echo $tni_b_p['Jumlah'];?></td>	
								<td align="right"><?php echo $tni_l_l['Jumlah'];?></td>	
								<td align="right"><?php echo $tni_l_p['Jumlah'];?></td>	
								<td align="right"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
						<tr>
							<td align="center"></td>							
							<td align="right"><?php echo array_sum($totaljml_blmkerja_b_l);?></td><!--belum bekerja-->
							<td align="right"><?php echo array_sum($totaljml_blmkerja_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_blmkerja_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_blmkerja_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_irt_b_l);?></td><!--irt-->
							<td align="right"><?php echo array_sum($totaljml_irt_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_irt_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_irt_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_mahasiswa_b_l);?></td><!--mahasiswa-->
							<td align="right"><?php echo array_sum($totaljml_mahasiswa_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_mahasiswa_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_mahasiswa_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_nelayan_b_l);?></td><!--nelayan-->
							<td align="right"><?php echo array_sum($totaljml_nelayan_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_nelayan_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_nelayan_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_ps_b_l);?></td><!--pegawai swasta-->
							<td align="right"><?php echo array_sum($totaljml_ps_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_ps_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_ps_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_pelajar_b_l);?></td><!--pelajar-->
							<td align="right"><?php echo array_sum($totaljml_pelajar_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_pelajar_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_pelajar_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_pensiun_b_l);?></td><!--pensiun-->
							<td align="right"><?php echo array_sum($totaljml_pensiun_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_pensiun_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_pensiun_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_petani_b_l);?></td><!--petani-->
							<td align="right"><?php echo array_sum($totaljml_petani_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_petani_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_petani_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_buruh_b_l);?></td><!--buruh-->
							<td align="right"><?php echo array_sum($totaljml_buruh_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_buruh_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_buruh_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_tki_b_l);?></td><!--tki-->
							<td align="right"><?php echo array_sum($totaljml_tki_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_tki_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_tki_l_p);?></td>		
							<td align="right"><?php echo array_sum($totaljml_wiraswasta_b_l);?></td><!--wiraswasta-->
							<td align="right"><?php echo array_sum($totaljml_wiraswasta_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_wiraswasta_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_wiraswasta_l_p);?></td>							
							<td align="right"><?php echo array_sum($totaljml_pns_b_l);?></td><!--pns-->
							<td align="right"><?php echo array_sum($totaljml_pns_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_pns_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_pns_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_polri_b_l);?></td><!--polri-->
							<td align="right"><?php echo array_sum($totaljml_polri_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_polri_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_polri_l_p);?></td>
							<td align="right"><?php echo array_sum($totaljml_tni_b_l);?></td><!--tni-->
							<td align="right"><?php echo array_sum($totaljml_tni_b_p);?></td>					
							<td align="right"><?php echo array_sum($totaljml_tni_l_l);?></td>					
							<td align="right"><?php echo array_sum($totaljml_tni_l_p);?></td>	
							<td align="right"><?php echo array_sum($totaljml_psn);?></td>
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