<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
		
	$apotikstok_umum = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='LOKET OBAT' AND `Stok` > '0'"));
	$apotikstok_lansia = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI LANSIA' AND `Stok` > '0'"));
	$apotikstok_igd = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='IGD' AND `Stok` > '0'"));
	$apotikstok_ranap = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='RAWAT INAP' AND `Stok` > '0'"));
	$apotikstok_poned = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='PONED' AND `Stok` > '0'"));
	$apotikstok_pustu = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='PUSTU' AND `Stok` > '0'"));
	$apotikstok_pusling = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='PUSLING' AND `Stok` > '0'"));
	$poli_anak = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI ANAK' AND `Stok` > '0'"));
	$poli_gigi = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI GIGI' AND `Stok` > '0'"));
	$poli_jiwa = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI JIWA' AND `Stok` > '0'"));
	$poli_kia = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI KIA' AND `Stok` > '0'"));
	$poli_kusta = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI KUSTA' AND `Stok` > '0'"));
	$poli_lansia = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI LANSIA' AND `Stok` > '0'"));
	$poli_tb = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI TB' AND `Stok` > '0'"));
	$poli_umum = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='POLI UMUM' AND `Stok` > '0'"));
	$laboratorium = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM $tbapotikstok WHERE `StatusBarang`='LABORATORIUM' AND `Stok` > '0'"));
	
	// gudang vaksin
	// $gudang_vaksin = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM `tbgudangpkmvaksinstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Stok` > '0'"));
?>

<li class="nav-item active">
	<a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
		<i class="fas fa-home"></i>
		<p>Dashboard</p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="dashboard">
		<ul class="nav nav-collapse">
			<?php if($_SESSION['otoritas'] == "APOTEK"){ ?>
				<li><a href="?page=grafik_tracking_pegawai"><span class="sub-item">Kinerja Pegawai</span></a></li>
				<li><a href="?page=waktu_pelayanan"><span class="sub-item">Waktu Pelayanan</span></a></li>
				<li><a href="?page=dashboard_puskesmas"><span class="sub-item">Utama</span></a></li>
			<?php }else{ ?>
				<li><a href="?page=dashboard_bpjs"><span class="sub-item">BPJS</span></a></li>
				<li><a href="?page=grafik_tracking_pegawai"><span class="sub-item">Kinerja Pegawai</span></a></li>
				<li><a href="?page=dashboard_ranap"><span class="sub-item">Rawat Inap</span></a></li>
				<li><a href="?page=dashboard_rujukan"><span class="sub-item">Rujukan</span></a></li>
				<li><a href="?page=waktu_pelayanan"><span class="sub-item">Waktu Pelayanan</span></a></li>
				<!--<li><a href="?page=waktu_pelayanan_v1"><span class="sub-item">Waktu Pelayanan (BC)</span></a></li>-->
				<li><a href="?page=dashboard_puskesmas"><span class="sub-item">Utama</span></a></li>
				<li><a href="?page=dashboard_ilp"><span class="sub-item">ILP - Register</span></a></li>
				<li><a href="?page=dashboard_klaster"><span class="sub-item">ILP - Klaster</span></a></li>
			<?php } ?>
		</ul>
	</div>
</li>

<?php if($namapuskesmas == "UPTD FARMASI"){?>
<li class="nav-item">
	<a data-toggle="collapse" href="#forms">
		<i class="fa fa-cloud faicon" aria-hidden="true"></i><span class="menu-text">Bridging Elogistik</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="forms">	
		<ul class="nav nav-collapse">
			<li><a href="?page=elog_indikator_kirim"><span class="sub-item">Kirim Indikator</span></a></li>
			<li><a href="?page=elog_indikator_obat"><span class="sub-item">Lihat Indikator</span></a></li>
		</ul>
	</div>
</li>
<?php 
	}
?>

<li class="nav-item">
	<a data-toggle="collapse" href="#sidebarLayouts">
		<img src="image/logo_bpjs_color.png" class="navbar-brand" width="28px"/>
		<span class="menu-text">BPJS Kesehatan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="sidebarLayouts">
		<ul class="nav nav-collapse">
			<li><a href="?page=bpjs_cek_koneksi"><span class="sub-item">Cek Koneksi</span></a></li>
			<li><a href="?page=bpjs_diagnosa"><span class="sub-item">Diagnosa</span></a></li>
			<li><a href="?page=bpjs_dokter"><span class="sub-item">Dokter</span></a></li>
			<li><a href="?page=bpjs_dokter_jadwal"><span class="sub-item">Dokter Jadwal (V2)</span></a></li>
			<li><a href="?page=bpjs_kesadaran"><span class="sub-item">Kesadaran</span></a></li>
			<li><a href="?page=bpjs_obat"><span class="sub-item">Obat</span></a></li>
			<li><a href="?page=bpjs_poli"><span class="sub-item">Poli</span></a></li>
			<li><a href="?page=bpjs_provider"><span class="sub-item">Provider</span></a></li>
			<li><a href="?page=bpjs_statuspulang"><span class="sub-item">Status Pulang</span></a></li>
			<li><a href="?page=bpjs_tindakan"><span class="sub-item">Tindakan</span></a></li>
			<li><a href="?page=bpjs_alergi_makanan"><span class="sub-item">Alergi Makan</span></a></li>
			<li><a href="?page=bpjs_alergi_udara"><span class="sub-item">Alergi Udara</span></a></li>
			<li><a href="?page=bpjs_alergi_obat"><span class="sub-item">Alergi Obat</span></a></li>
			<li><a href="?page=bpjs_prognosa"><span class="sub-item">Prognosa</span></a></li>
			<!-- <li><a href="?page=bpjs_kelompok"><span class="sub-item">Kelompok</span></a></li>
			<li><a href="?page=bpjs_kegiatan"><span class="sub-item">Kegiatan</span></a></li>
			<li>
				<a data-toggle="collapse" href="#subnav1">
					<span class="sub-item">Kegiatan Kelompok</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="subnav1">
					<ul class="nav nav-collapse subnav">
						<li>
							<a href="?page=bpjs_kegiatan_kelompok">
								<span class="sub-item">Input Kegiatan</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="sub-item">Prolanis</span>
							</a>
						</li>
					</ul>
				</div>
			</li> -->
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#sidebar_satusehat">
		<img src="image/satusehat.png" class="navbar-brand" width="28px"/>
		<span class="menu-text">Satu Sehat</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="sidebar_satusehat">
		<ul class="nav nav-collapse">
			<li><a href="?page=dashboard_satusehat"><span class="sub-item">Dashboard</span></a></li>
			<li><a href="?page=satusehat_auth"><span class="sub-item">Auth (1)</span></a></li>
			<li><a href="?page=satusehat_practitioner"><span class="sub-item">Practitioner (2)</span></a></li>
			<li><a href="?page=satusehat_location"><span class="sub-item">Location (3)</span></a></li>	
			<li><a href="?page=satusehat_encounter_export"><span class="sub-item">Kirim Kunjungan</span></a></li>
			<li><a href="?page=satusehat_condition_export"><span class="sub-item">Kirim Diagnosa</span></a></li>
		</ul>
	</div>	
</li>

<!-- <li class="nav-item">
	<a data-toggle="collapse" href="#spm">
		<i class="icon-speedometer"></i><span class="menu-text">e-SPM</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="spm">		
		<ul class="nav nav-collapse">
			<li><a href="?page=lap_spm_indikator"><span class="menu-text">Dashboard</span></a></li>
			<li><a href="?page=lap_spm_indikator_laporan"><span class="menu-text">Laporan</span></a></li>
		</ul>
	</div>
</li> -->
<li class="nav-item">
	<a data-toggle="collapse" href="#rekmed">
		<i class="icon-grid"></i><span class="menu-text">Rekam Medis</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="rekmed">		
		<ul class="nav nav-collapse">
			<li><a href="?page=rekam_medis_klpcm"><span class="sub-item">Analisa KLPCM</span></a></li>
			<li><a href="?page=rekam_medis_pasien"><span class="sub-item">Retensi</span></a></li>
			<li><a href="?page=rm_bankdata"><span class="sub-item">Bank Dt & Pindah KK </span></a></li>
			<li><a href="?page=rekam_medis_eksportdata"><span class="sub-item">Export Data</span></a></li>
			<!--<li><a href="?page=pasien_belum_entry"><span class="sub-item">Data Belum Entry</span></a></li>
			<li><a href="?page=poli_antri_bridging_bulan"><span class="sub-item">Data Gagal Bridging</span></a></li>-->
			
		</ul>
	</div>
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#kasir">
		<i class="icon-wallet"></i><span class="menu-text">Kasir</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="kasir">	
		<ul class="nav nav-collapse">
			<li><a href="?page=dashboard_puskesmas_kasir"><span class="sub-item">Dashboard</span></a></li>
			<li><a href="?page=kasir_pembayaran"><span class="sub-item">Pembayaran</span></a></li>
			<li><a href="?page=kasir_laporan"><span class="sub-item">Laporan</span></a></li>
		</ul>
	</div>
</li>
<li class="nav-item">
	<a href="?page=registrasi_form">
		<i class="icon-people"></i><span class="menu-text">Pendaftaran</span>
	</a>
</li>
<li class="nav-item">
	<a href="?page=nurse_station">
		<i class="icon-user-follow"></i><span class="menu-text">Nurse Station</span>
	</a>
</li>
<?php
	if (in_array("POLI ANAK", $otoritas) || in_array("POLI GIGI", $otoritas) || in_array("POLI GIZI", $otoritas) ||
	in_array("POLI IMUNISASI", $otoritas) || in_array("POLI ISOLASI", $otoritas) || in_array("POLI KB", $otoritas) ||
	in_array("POLI KIA", $otoritas) || in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
	in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI TB", $otoritas) ||
	in_array("POLI UMUM", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>

<li class="nav-item">
	<a href="?page=poli">
		<i class="icon-user-follow"></i><span class="menu-text">Pemeriksaan</span>
	</a>
</li>

<!-- <li class="nav-item">
	<a data-toggle="collapse" href="#jaringan">
		<i class="icon-user-following"></i><span class="menu-text">Jaringan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="jaringan">		
		<ul class="nav nav-collapse">
			<li>
				<ul class="nav nav-collapse">
					<?php
						// $strpoli_ukm = mysqli_query($koneksi, "SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='Kunjungan Luar Gedung' order by Pelayanan");
						// while($menu_ukm = mysqli_fetch_assoc($strpoli_ukm)){
					?>
					<li>
						<a href="?page=jejaring&pelayanan=<?php //echo $menu_ukm['Pelayanan'];?>&status=Antri">
							<span class="sub-item"><?php //echo $menu_ukm['Pelayanan'];?></span>
						</a>
					</li>
					<?php
						//}
					?>
				</ul>
			</li>
		</ul>
	</div>	
</li> -->

<?php
	}
	if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>
<li class="nav-item">
	<a data-toggle="collapse" href="#farmasi">
		<i class="icon-layers" aria-hidden="true"></i><span class="menu-text">Farmasi</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="farmasi">
		<ul class="nav nav-collapse">
			<li>
				<?php 
				// $str_resep = "SELECT `NoResep` FROM `$tbresep` WHERE date(TanggalResep) = curdate() AND `OpsiResep`='diberikan resep' AND `Status`='Belum' ";
				
				$aslpsn = $_SESSION['layanan_dipilih'];
				$str_resep = "SELECT a.*, b.AsalPasien FROM `$tbresep` a
				JOIN $tbpasienrj b ON a.IdPasienrj = b.IdPasienrj
				WHERE  date(a.`TanggalResep`) = curdate() AND b.`AsalPasien`='$aslpsn' AND (a.OpsiResep = 'diberikan resep' OR a.OpsiResep = '') AND a.`Status`='Belum'";
				$str2 = $str_resep." ".$orderbys;
				// echo $str2;
				$dt_resep = mysqli_num_rows(mysqli_query($koneksi, $str_resep));
				?>
				<a href="?page=apotik_pelayanan_resep&statusloket=LOKET OBAT"><span class="sub-item">Pelayanan Resep</span>
				<?php if ($dt_resep >= 1){?><span class="badge badge-danger"><?php echo $dt_resep;}?></span></a>
			</li>
			<li>
				<a data-toggle="collapse" href="#g_dinkes">
					<span class="sub-item">Gdg.Dinkes</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="g_dinkes">
					<ul class="nav nav-collapse subnav">
						<li><a href="?page=lap_gfk_ketersediaan_barang_bandungkab_view_puskesmas"><span class="sub-item">Ketersediaan</span></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a data-toggle="collapse" href="#g_pkm_vaksin">
					<span class="sub-item">Gdg.Pkm (Vaksin) </span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="g_pkm_vaksin">
					<ul class="nav nav-collapse subnav">
						<li><a href="?page=lap_gfk_kartustok_vaksin_puskesmas"><span class="sub-item">Kartu Stok</span><span class="badge" style="background:red;"></span></a></li>
						<li><a href="?page=apotik_vaksin_gudang_stok"><span class="sub-item">Stok</span><span class="badge" style="background:red;"><?php echo $gudang_vaksin;?></span></a></li>
						<li><a href="?page=apotik_vaksin_gudang_penerimaan"><span class="sub-item">Penerimaan</span><span class="badge" style="background:red;"></span></a></li>
						<li><a href="?page=apotik_vaksin_gudang_pengeluaran"><span class="sub-item">Pengeluaran</span><span class="badge" style="background:red;"></span></a></li>
						<li><a href="?page=uptd_gudang_sisa_aset_vaksin_bogorkab_puskesmas"><span class="sub-item">Lap.Ketersediaan</span></span></a></li>
						<li><a href="?page=uptd_gudang_vaksin_sisa_aset_triwulan_bogorkab_puskesmas"><span class="sub-item">Lap.Stok Opname</span></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a data-toggle="collapse" href="#g_pkm_obat">
					<span class="sub-item">Gdg.Pkm (Obat)</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="g_pkm_obat">
					<ul class="nav nav-collapse subnav">
						<!-- <li><a href="?page=lap_gfk_kartustok_gudang_puskesmas"><span class="sub-item">Kartu Stok</span><span class="badge" style="background:red;"></span></a></li> -->
						<li>
							<?php $go_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(KodeBarang)AS Jml FROM `$tbgudangpkmstok` WHERE `Stok` > '0' "));?>
							<a href="?page=apotik_gudang_stok"><span class="sub-item">Stok</span><span class="badge" style="background:red;"><?php echo $go_puskesmas['Jml'];?></span></a>
						</li>
						<li><a href="?page=apotik_gudang_penerimaan"><span class="sub-item">Penerimaan Dinas</span></a></li>
						<li><a href="?page=apotik_gudang_pengadaan"><span class="sub-item">Pengadaan</span></a></li>
						<li><a href="?page=apotik_gudang_pengeluaran"><span class="sub-item">Pengeluaran</span></a></li>
						<li><a href="?page=apotik_gudang_retur"><span class="sub-item">Retur/Hibah</span></a></li>
					</ul>
				</div>	
			</li>
			<li>
				<a data-toggle="collapse" href="#depotobat">
					<span class="sub-item">Depot Obat</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="depotobat">
					<ul class="nav nav-collapse subnav">
						<li><a href="?page=apotik_stok&status=LOKET OBAT"><span class="sub-item">Depot Obat</span><span class="badge" style="background:red;"><?php echo $apotikstok_umum;?></span></a></li>
						<li><a href="?page=apotik_stok&status=IGD"><span class="sub-item">IGD/R.Tindakan</span><span class="badge" style="background:red;"><?php echo $apotikstok_igd;?></span></a></li>
						<li><a href="?page=apotik_stok&status=RAWAT INAP"><span class="sub-item">Rawat Inap</span><span class="badge" style="background:red;"><?php echo $apotikstok_ranap;?></span></a></li>
						<li><a href="?page=apotik_stok&status=PONED"><span class="sub-item">Poned</span><span class="badge" style="background:red;"><?php echo $apotikstok_poned;?></span></a></li>
						<li><a href="?page=apotik_stok&status=PUSTU"><span class="sub-item">Pustu</span><span class="badge" style="background:red;"><?php echo $apotikstok_pustu;?></span></a></li>
						<li><a href="?page=apotik_stok&status=PUSLING"><span class="sub-item">Pusling</span><span class="badge" style="background:red;"><?php echo $apotikstok_pusling;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI ANAK"><span class="sub-item">Poli Anak</span><span class="badge" style="background:red;"><?php echo $poli_anak;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI GIGI"><span class="sub-item">Poli Gigi</span><span class="badge" style="background:red;"><?php echo $poli_gigi;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI JIWA"><span class="sub-item">Poli Jiwa</span><span class="badge" style="background:red;"><?php echo $poli_jiwa;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI KIA"><span class="sub-item">Poli Kia</span><span class="badge" style="background:red;"><?php echo $poli_kia;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI KUSTA"><span class="sub-item">Poli Kusta</span><span class="badge" style="background:red;"><?php echo $poli_kusta;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI LANSIA"><span class="sub-item">Poli Lansia</span><span class="badge" style="background:red;"><?php echo $poli_lansia;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI TB"><span class="sub-item">Poli TB</span><span class="badge" style="background:red;"><?php echo $poli_tb;?></span></a></li>
						<li><a href="?page=apotik_stok&status=POLI UMUM"><span class="sub-item">Poli Umum</span><span class="badge" style="background:red;"><?php echo $poli_umum;?></span></a></li>
						<li><a href="?page=apotik_stok&status=LABORATORIUM"><span class="sub-item">Laboratorium</span><span class="badge" style="background:red;"><?php echo $laboratorium;?></span></a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>	
</li>
<?php 
	}
	if(in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
?>
<li class="nav-item">
	<a data-toggle="collapse" href="#grafik">
		<i class="icon-chart"></i><span class="menu-text">Grafik</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="grafik">
		<ul class="nav nav-collapse">
			<li><a href="?page=grafik_kunjungan_ukp"><span class="sub-item">Kunj. UKP & UKM</span></a></li>
			<li><a href="?page=grafik_kunjungan_pasien_hari_puskesmas"><span class="sub-item">Kunj. Per-Hari</span></a></li>
			<li><a href="?page=grafik_kunjungan_pasien_tahun_puskesmas"><span class="sub-item">Kunj. Per-Bulan</span></a></li>
			<li><a href="?page=grafik_kunjungan_baru_lama"><span class="sub-item">Kunj. Baru & Lama</span></a></li>
			<li><a href="?page=grafik_kunjungan_carabayar_tahun"><span class="sub-item">Kunj. Cara Bayar</span></a></li>
			<li><a href="?page=grafik_penyakit_terbanyak"><span class="sub-item">Penyakit Terbanyak</span></a></li>
		</ul>
	</div>
</li>
<?php } ?>

<?php //if(date("H") > 10){?>
<li class="nav-item">
	<a data-toggle="collapse" href="#laporan">
		<i class="icon-calendar"></i><span class="menu-text">Laporan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="laporan">	
		<ul class="nav nav-collapse">
			<?php
				if (in_array("LOKET", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
			?>
			<li>
				<a data-toggle="collapse" href="#antrian">
					<span class="sub-item">Antrian</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="antrian">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_antrian_bulan" target="_blank"><span class="sub-item">Antrian</span></a></li>
						<li><a href="?page=lap_antrian_daftar_online" target="_blank"><span class="sub-item">Pend.Online</span></a></li>
						<li><a href="?page=lap_antrian_daftar_online_register" target="_blank"><span class="sub-item">Pend.Online Register</span></a></li>
						<li><a href="?page=lap_antrian_daftar_online_offline" target="_blank"><span class="sub-item">Pend.Online - Offline</span></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a data-toggle="collapse" href="#lap_pendaftaran">
					<span class="sub-item">Pendaftaran</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_pendaftaran">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_loket_registrasi_kunjungan" target="_blank"><span class="sub-item">Kunj.Harian</span></a></li>
						<li><a href="?page=lap_loket_kunjungan_bulan" target="_blank"><span class="sub-item">Kunj.Bulan</span></a></li>
						<li><a href="?page=lap_loket_kunjungan_kelurahan_tahun" target="_blank"><span class="sub-item">Kunj.Tahun</span></a></li>
						<li><a href="?page=lap_loket_kunjungan_kelurahan" target="_blank"><span class="sub-item">Kunj.Bulan (Wlyh)</span></a></li>
						<li><a href="?page=lap_loket_kunjungan_anakremaja" target="_blank"><span class="sub-item">Anak & Remaja</span></a></li>
						<li><a href="?page=lap_loket_kunjungan_kelompok_umur" target="_blank"><span class="sub-item">Kelompok Umur</span></a></li>
						<li><a href="?page=lap_loket_rekapitulasi_kunjungan" target="_blank"><span class="sub-item">Cara Bayar (Br/Lm)</span></a></li>
						<li><a href="?page=lap_loket_carabayar_kelurahan" target="_blank"><span class="sub-item">Cara Bayar (Wly)</span></a></li>
						<li><a href="?page=lap_loket_carabayar" target="_blank"><span class="sub-item">Cara Bayar</span></a></li>
						<li><a href="?page=lap_loket_carabayar_detail" target="_blank"><span class="sub-item">Cara Bayar Detail</span></a></li>
						<li><a href="?page=lap_loket_data_kk" target="_blank"><span class="sub-item">KK (Index)</span></a></li>
						<li><a href="?page=lap_loket_poli" target="_blank"><span class="sub-item">Poli</span></a></li>
						<li><a href="?page=lap_loket_poli_bulan" target="_blank"><span class="sub-item">Poli (Bulan)</span></a></li>				
						<li><a href="?page=lap_loket_rup" target="_blank"><span class="sub-item">RUP</span></a></li>
						<li><a href="?page=lap_loket_rujukan" target="_blank"><span class="sub-item">Rujukan</span></a></li>
						<li><a href="?page=lap_loket_rujukan_register"><span class="sub-item">Rujukan Register</span></a></li>
						<li><a href="?page=lap_loket_keluarga_miskin" target="_blank"><span class="sub-item">Keluarga Miskin</span></a></li>
						<li><a href="?page=lap_bpjs_sakitsehat" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/><span class="sub-item">Sakit/Sehat</span></a></li>
						<li><a href="?page=lap_bpjs_sakitsehat_detail" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/><span class="sub-item">Sakit/Sehat Detail</span></a></li>
						<li><a href="?page=poli_antri_bridging_bulan_pendaftaran" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/><span class="sub-item">Gagal Bridging</span></a></li>
					</ul>
				</div>
			</li>
			<?php
				}
			?>
			<li>
				<a data-toggle="collapse" href="#lap_pemeriksaan">
					<span class="sub-item">Pemeriksaan</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_pemeriksaan">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_registrasi_askep" target="_blank"><span class="sub-item">Asuhan Keperawatan</span></a></li>
						<li><a href="?page=lap_registrasi_anak" target="_blank"><span class="sub-item">Anak Register</span></a></li>
						<li><a href="?page=lap_registrasi_gigi" target="_blank"><span class="sub-item">Gigi Register</span></a></li>
						<li><a href="?page=lap_gigi_carabayar" target="_blank"><span class="sub-item">Gigi Cara Bayar</span></a></li>
						<li><a href="?page=lap_gigi_bulanan" target="_blank"><span class="sub-item">Gigi Bulanan (LB)</span></a></li>
						<li><a href="?page=lap_gigi_harian" target="_blank"><span class="sub-item">Gigi Harian (LB)</span></a></li>
						<li><a href="?page=lap_registrasi_gizi_kia_kukarkab" target="_blank"><span class="sub-item">Gizi (KIA) Register</span></a></li>
						<li><a href="?page=lap_registrasi_imunisasi" target="_blank"><span class="sub-item">Imunisasi Register</span></a></li>
						<li><a href="?page=lap_imunisasi_catin" target="_blank"><span class="sub-item">Imunisasi Catin</span></a></li>
						<li><a href="?page=lap_imunisasi_bumil" target="_blank"><span class="sub-item">Imunisasi Bumil</span></a></li>
						<li><a href="?page=lap_imunisasi_sertifikat" target="_blank"><span class="sub-item">Imunisasi Sertifikat</span></a></li>
						<li><a href="?page=lap_imunisasi_pemantauan" target="_blank"><span class="sub-item">Imunisasi Kontrol</span></a></li>
						<li><a href="?page=lap_imunisasi_perkelurahan" target="_blank"><span class="sub-item">Imunisasi Wilayah</span></a></li>
						<li><a href="?page=lap_registrasi_kb" target="_blank"><span class="sub-item">KB Register</span></a></li>
						<li><a href="?page=lap_registrasi_kia" target="_blank"><span class="sub-item">KIA Register</span></a></li>
						<li><a href="?page=lap_kia_anc" target="_blank"><span class="sub-item">KIA ANC</span></a></li>
						<li><a href="?page=lap_registrasi_laboratorium" target="_blank"><span class="sub-item">Lab Register</span></a></li>
						<li><a href="?page=lap_registrasi_laboratorium_bulan" target="_blank"><span class="sub-item">Lab Bulanan</span></a></li>
						<li><a href="?page=lap_registrasi_lansia" target="_blank"><span class="sub-item">Lansia Register</span></a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan" target="_blank"><span class="sub-item">Lansia Bulanan</span></a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan_wilayah" target="_blank"><span class="sub-item">Lansia Wilayah</span></a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan_umur_kukarkab" target="_blank"><span class="sub-item">Lansia Klp.Umur</span></a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan_kemandirian_kukarkab" target="_blank"><span class="sub-item">Lansia Kemandirian</span></a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan_intelegensia" target="_blank"><span class="sub-item">Lansia Intelegensia</span></a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan_kohort" target="_blank"><span class="sub-item">Lansia Kohort</span></a></li>
						<li><a href="?page=lap_registrasi_mtbs" target="_blank"><span class="sub-item">MTBS Register</span></a></li>
						<li><a href="?page=lap_mtbs_bulanan" target="_blank"><span class="sub-item">MTBS Bulan F1</span></a></li>
						<li><a href="?page=lap_mtbs_bulanan_kukarkab" target="_blank"><span class="sub-item">MTBS Bulan F2</span></a></li>
						<li><a href="?page=lap_registrasi_prolanis" target="_blank"><span class="sub-item">Prolanis Register</span></a></li>
						<li><a href="?page=lap_registrasi_screening" target="_blank"><span class="sub-item">Screening Register</span></a></li>
						<li><a href="?page=lap_registrasi_umum" target="_blank"><span class="sub-item">Umum Register</span></a></li>
						<li><a href="?page=lap_registrasi_ugd" target="_blank"><span class="sub-item">Ugd Register</span></a></li>
					</ul>
				</div>
			</li>	
			<li>
				<a data-toggle="collapse" href="#lap_farmasi">
					<span class="sub-item">Farmasi</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_farmasi">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_farmasi_kunjungan_resep"><span class="sub-item">Kunjungan Resep</span></a></li>
						<li><a href="?page=lap_farmasi_ketersediaan_puskesmas_bandungkab"><span class="sub-item">Ketersediaan</span></a></li>
						<li><a href="?page=lap_farmasi_penerimaan_puskesmas"><span class="sub-item">Penerimaan</span></a></li>
						<li><a href="?page=lap_farmasi_apotik_pemakaian_obat_harian"><span class="sub-item">Pemakaian</span></a></li>
						<li><a href="?page=lap_farmasi_apotik_resep_cara_bayar"><span class="sub-item">Cara Bayar</span></a></li>
						<li><a href="?page=lap_farmasi_pio_hari"><span class="sub-item">Pio Harian</span></a></li>
						<li><a href="?page=lap_farmasi_rawatjalan_pio"><span class="sub-item">Kefarmasian</span></a></li>
						<li><a href="?page=lap_farmasi_pemakaianobat_terbanyak"><span class="sub-item">Obat Terbanyak</span></a></li>
						<li><a href="?page=lap_farmasi_psikotropika"><span class="sub-item">Psikotropika</span></a></li>
						<li><a href="?page=lap_farmasi_lplpo_manual"><span class="sub-item">LPLPO</span></a></li>
						<li><a href="?page=lap_farmasi_rko_bandungkab"><span class="sub-item">RKO</span></a></li>
						<li><a href="?page=lap_farmasi_pordetail"><span class="sub-item">POR</span></a></li>
						<li><a href="?page=lap_farmasi_persediaan"><span class="sub-item">Persediaan Barang</span></a></li>
					</ul>	
				</div>	
			</li>
			<li>
				<a data-toggle="collapse" href="#lap_program">
					<span class="sub-item">Program</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_program">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_lb1_penyakit_bandungkab" target="_blank"><span class="sub-item">LB1-Penyakit</span></a></li>
						<li><a href="?page=lap_P2M_wabah" target="_blank"><span class="sub-item">Wabah-W2</span></a></li>
						<li><a href="?page=lap_P2M_DBD_Harian" target="_blank"><span class="sub-item">DBD Register</span></a></li>
						<li><a href="?page=lap_P2M_Diare_Harian" target="_blank"><span class="sub-item">Diare Register</span></a></li>
						<li><a href="?page=lap_P2M_Diare_Bulanan" target="_blank"><span class="sub-item">Diare Bulanan</span></a></li>
						<li><a href="?page=lap_P2M_Hipertensi_Harian" target="_blank"><span class="sub-item">Hipertensi Register</span></a></li>
						<li><a href="?page=lap_P2M_Ispa_Harian" target="_blank"><span class="sub-item">Ispa Register</span></a></li>
						<li><a href="?page=lap_P2M_Ispa_Bulanan" target="_blank"><span class="sub-item">Ispa Bulanan</span></a></li>
						<li><a href="?page=lap_P2M_Tifoid_Harian" target="_blank"><span class="sub-item">Tifoid Register</span></a></li>
						<li><a href="?page=lap_P2M_campak" target="_blank"><span class="sub-item">Campak-C1</span></a></li>
						<li><a href="?page=lap_P2M_ptm" target="_blank"><span class="sub-item">PTM Register</span></a></li>
						<li><a href="?page=lap_P2M_ptm_kasus" target="_blank"><span class="sub-item">PTM Kasus</span></a></li>
						<li><a href="?page=lap_P2M_ptm_faktorresiko" target="_blank"><span class="sub-item">PTM Faktor Resiko</span></a></li>
						<li><a href="?page=lap_P2M_ptm_spm" target="_blank"><span class="sub-item">PTM (SPM Skrining)</span></a></li>
						<li><a href="?page=lap_P2M_ptm_spm_diabet" target="_blank"><span class="sub-item">PTM (SPM Diabet)</span></a></li>
						<li><a href="?page=lap_P2M_ptm_spm_hipertensi" target="_blank"><span class="sub-item">PTM (SPM Hipertensi)</span></a></li>
						<li><a href="?page=lap_P2M_ili" target="_blank"><span class="sub-item">ILI Register</span></a></li>
						<li><a href="?page=lap_P2M_indera" target="_blank"><span class="sub-item">Indera & Fungsional</span></a></li>
						<li><a href="?page=lap_P2M_Katarak_Harian" target="_blank"><span class="sub-item">Katarak Register</span></a></li>
						<li><a href="?page=lap_P2M_jiwa" target="_blank"><span class="sub-item">Kesehatan Jiwa</span></a></li>
						<li><a href="?page=lap_P2M_leptospirosis" target="_blank"><span class="sub-item">Leptospirosis</span></a></li>
						<li><a href="?page=lap_P2M_disabilitas" target="_blank"><span class="sub-item">Disabilitas</span></a></li>
						<li><a href="?page=lap_P2M_disabilitas_alamat" target="_blank"><span class="sub-item">Disabilitas Detail</span></a></li>
						<li><a href="?page=lap_P2M_surveilans" target="_blank"><span class="sub-item">Surveilans-STP</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak" target="_blank"><span class="sub-item">Penyakit Terbanyak</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak_kunjungan" target="_blank"><span class="sub-item">Penyakit Kunjungan</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak_jaminan" target="_blank"><span class="sub-item">Penyakit Jaminan</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak_rujukan" target="_blank"><span class="sub-item">Penyakit Rujukan</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_kronis_bnba" target="_blank"><span class="sub-item">Penyakit Kronis</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak_pemulkes" target="_blank"><span class="sub-item">Pemulkes</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_bulan" target="_blank"><span class="sub-item">Tracking Diagnosa</span></a></li>
						<li><a href="?page=lap_P2M_tindakan" target="_blank"><span class="sub-item">Tindakan Pasien</span></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a data-toggle="collapse" href="#lap_yankes">
					<span class="sub-item">Yankes</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_yankes">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_loket_kecelakaan_lalulintas" target="_blank"><span class="sub-item">Kecelakaan Lu.Lintas</span></a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak" target="_blank"><span class="sub-item">Penyakit Terbanyak</span></a></li>
						<li><a href="?page=lap_loket_carabayar_rujukan" target="_blank"><span class="sub-item">Rwt.Jalan & Rujukan</span></a></li>
						<li><a href="?page=lap_loket_rawatinap" target="_blank"><span class="sub-item">Rwt.Inap & Rujukan</span></a></li>
					</ul>
				</div>
			</li>	
			<li>
				<a data-toggle="collapse" href="#lap_kepegawaian">
					<span class="sub-item">Kepegawaian</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_kepegawaian">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_loket_tracking_pegawai" target="_blank"><span class="sub-item">Kinerja Pegawai</span></a></li>
						<li><a href="?page=lap_loket_kegiatan_harian" target="_blank"><span class="sub-item">Kegiatan Harian</span></a></li>
						<li><a href="?page=lap_loket_tracking_pegawai_rujukan" target="_blank"><span class="sub-item">Rujukan Per-Pegawai</span></a></li>
					</ul>
				</div>	
			</li>
		</ul>
	</div>	
</li>
<?php //} ?>

<?php 
	// }
	if (in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas )){
?>
<li class="nav-item">
<a data-toggle="collapse" href="#masterdata">
		<i class="icon-settings"></i><span class="menu-text">Master Data</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="masterdata">	
		<ul class="nav nav-collapse">
			<li><a href="?page=master_antrian_pasien"><span class="sub-item">Antrian Pasien</span></a></li>
			<li><a href="?page=master_daftaronline"><span class="sub-item">Daftar Online</span></a></li>
			<li><a href="?page=master_asuransi"><span class="sub-item">Asuransi</span></a></li>
			<!-- <li><a href="?page=master_obat_fornas"><span class="sub-item">Data Fornas</span></a></li> -->
			<!-- <li><a href="?page=master_obat_jkn"><span class="sub-item">Data JKN</span></a></li> -->
			<li><a href="?page=master_obat"><span class="sub-item">Data LPLPO</span></a></li>
			<li><a href="?page=master_diagnosa"><span class="sub-item">Diagnosa</span></a></li>
			<li><a href="?page=master_diagnosa_keperawatan"><span class="sub-item">Diagnosa Keperawatan</span></a></li>
			<li><a href="?page=master_diagnosa_nonspesialis"><span class="sub-item">Diagnosa NonSpesialis</span></a></li>
			<li><a href="?page=master_kartupasien"><span class="sub-item">Kartu Pasien</span></a></li>
			<li><a href="?page=master_nomerrm"><span class="sub-item">Nomor Rekam Medis</span></a></li>
			<li><a href="?page=master_pegawai"><span class="sub-item">Pegawai</span></a></li>
			<li><a href="?page=master_pegawai_bpjs"><span class="sub-item">Pegawai HFIS</span></a></li>
			<li><a href="?page=master_pendidikan"><span class="sub-item">Pendidikan</span></a></li>
			<li><a href="?page=master_pekerjaan"><span class="sub-item">Pekerjaan</span></a></li>
			<li><a href="?page=master_puskesmas"><span class="sub-item">Puskesmas</span></a></li>
			<li><a href="?page=master_pcare"><span class="sub-item">PCare</span></a></li>
			<li><a href="?page=master_pcare_peserta"><span class="sub-item">PCare Peserta</span></a></li>
			<li><a href="?page=master_posyandu"><span class="sub-item">Posyandu</span></a></li>
			<li><a href="?page=master_skrining_ilp"><span class="sub-item">Skrining ILP</span></a></li>
			<?php if(in_array("PROGRAMMER", $otoritas)){ ?>
			<li><a href="?page=master_slide_banner"><span class="sub-item">Slide Banner</span></a></li>
			<li><a href="?page=update_carabayar"><span class="sub-item">Update Cara Bayar</span></a></li>
			<?php } ?>
			
			<li><a href="?page=master_tindakan"><span class="sub-item">Tindakan</span></a></li>
		</ul>
	</div>
</li>
<?php
	}
?>
<li class="nav-item">
	<a data-toggle="collapse" href="#informasi">
		<i class="icon-paper-clip"></i><span class="menu-text">Informasi</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="informasi">	
		<ul class="nav nav-collapse">
			<?php if (in_array("PROGRAMMER", $otoritas)){ ?>
			<li><a href="?page=adm_pendampingan"><span class="sub-item">Jadwal ke Puskesmas</span></a></li>
			<!-- <li><a href="?page=adm_invoice"><span class="sub-item">Invoice</span></a></li> -->
			<li><a href="?page=import_data"><span class="sub-item">Import Data</span></a></li>
			<?php } ?>
			<li><a href="?page=adm_konsultasi"><span class="sub-item">Konsultasi</span></a></li>
			<li><a href="?page=adm_update_simpus"><span class="sub-item">Update Simpus</span></a></li>
			<li><a href="?page=adm_spj_simpus_tambah"><span class="sub-item">Data Umum Pekerjaan Bridging Simpus</span></a></li>
		</ul>
	</div>
</li>
<li class="nav-item">
	<a href="?page=backup"><i class="icon-drawer"></i><span class="menu-text">Backup Data</span></a>
</li>
<li class="logmobile">
	<a href="?page=update_profile"><i class="fa fa-user"></i> Data User</a>
</li>
<li class="logmobile">
	<a href="logout.php">
		<i class="fa fa-power-off"></i> Log Out</span>
	</a>
</li>