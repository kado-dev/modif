<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
	$kota = $_SESSION['kota'];

	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
	
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
		<i class="icon-home"></i>
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
				<li><a href="?page=dashboard_rujukan"><span class="sub-item">Rujukan</span></a></li>
				<li><a href="?page=waktu_pelayanan"><span class="sub-item">Waktu Pelayanan</span></a></li>
				<li><a href="?page=dashboard_puskesmas"><span class="sub-item">Utama</span></a></li>
			<?php } ?>
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#sidebarLayouts">
		<img src="image/logo_bpjs_color.png" class="navbar-brand" width="25px"/>
		<span class="menu-text">BPJS Kesehatan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="sidebarLayouts">
		<ul class="nav nav-collapse">
			<li><a href="?page=bpjs_diagnosa"><span class="sub-item">Diagnosa</span></a></li>
			<li><a href="?page=bpjs_dokter"><span class="sub-item">Dokter</span></a></li>
			<li><a href="?page=bpjs_dokter_jadwal"><span class="sub-item">Dokter Jadwal (V2)</span></a></li>
			<li><a href="?page=bpjs_kesadaran"><span class="sub-item">Kesadaran</span></a></li>
			<li><a href="?page=bpjs_obat"><span class="sub-item">Obat</span></a></li>
			<li><a href="?page=bpjs_poli"><span class="sub-item">Poli</span></a></li>
			<li><a href="?page=bpjs_provider"><span class="sub-item">Provider</span></a></li>
			<li><a href="?page=bpjs_statuspulang"><span class="sub-item">Status Pulang</span></a></li>
			<li><a href="?page=bpjs_tindakan"><span class="sub-item">Tindakan</span></a></li>
			<li><a href="?page=bpjs_kelompok"><span class="sub-item">Kelompok</span></a></li>
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
			</li>
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#sidebar_satusehat">
		<img src="image/satusehat.png" class="navbar-brand" width="30px"/>
		<span class="menu-text">Satu Sehat</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="sidebar_satusehat">
		<ul class="nav nav-collapse">
			<li><a href="?page=dashboard_satusehat"><span class="sub-item">Dashboard</span></a></li>
			<li><a href="?page=satusehat_auth"><span class="sub-item">Auth (1)</span></a></li>
			<li><a href="?page=satusehat_practitioner"><span class="sub-item">Practitioner (2)</span></a></li>
			<li><a href="?page=satusehat_location"><span class="sub-item">Location (3)</span></a></li>	
			<li><a href="?page=satusehat_encounter_export" target="_blank"><span class="sub-item">Kirim Kunjungan</span></a></li>
			<li><a href="?page=satusehat_condition_export" target="_blank"><span class="sub-item">Kirim Diagnosa</span></a></li>
		</ul>
	</div>	
</li>

<?php 
	if (in_array("LOKET", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>
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
	}
	if (in_array("POLI ANAK", $otoritas) || in_array("POLI GIGI", $otoritas) || in_array("POLI GIZI", $otoritas) ||
	in_array("POLI IMUNISASI", $otoritas) || in_array("POLI ISOLASI", $otoritas) || in_array("POLI KB", $otoritas) ||
	in_array("POLI KIA", $otoritas) || in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
	in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI TB", $otoritas) ||
	in_array("POLI UMUM", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>
<li class="nav-item">
	<a data-toggle="collapse" href="#periksa">
		<i class="icon-user-following"></i><span class="menu-text">Pemeriksaan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="periksa">
		<ul class="nav nav-collapse">
			<?php
				$strpoli = mysqli_query($koneksi, "SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='Kunjungan Sakit' AND `Pelayanan`!='PENDAFATARAN' order by Pelayanan");
				while($menu = mysqli_fetch_assoc($strpoli)){
			?>
			<li>
				<?php
					$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
					$str_antri = "SELECT COUNT(*) AS Jml FROM `$tbpasienrj` 
								WHERE (StatusPelayanan = 'Antri' OR StatusPelayanan = 'Proses') AND date(TanggalRegistrasi) = curdate() 
								AND `AsalPasien`='10' AND (PoliPertama='$menu[Pelayanan]')";
					$dt_antri = mysqli_fetch_assoc(mysqli_query($koneksi, $str_antri)); 
					$jml_data = $dt_antri['Jml'];
				?>
				<a href="?page=poli&pelayanan=<?php echo $menu['Pelayanan'];?>">
					<span class="sub-item"><?php echo str_replace('POLI', '', $menu['Pelayanan']);?>
						<?php if ($jml_data != 0){?><span class="badge badge-danger"><?php echo $jml_data;}?></span>
					</span>
				</a>
			</li>
			<?php
				}
			?>
		</ul>
	</div>
</li>
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

				$dt_resep = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoResep` FROM `$tbresep` WHERE SUBSTRING(NoResep,1,11) = '$kodepuskesmas' AND date(TanggalResep) = curdate() AND Status='Belum'"));
				?>
				<a href="?page=apotik_pelayanan_resep&statusloket=LOKET OBAT"><span class="sub-item">Pelayanan Resep</span>
				<?php if ($dt_resep != 0){?><span class="badge badge-danger"><?php echo $dt_resep;}?></span></a>
			</li>
			<li>
				<a data-toggle="collapse" href="#g_pkm_obat">
					<span class="sub-item">Gdg.Pkm (Obat)</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="g_pkm_obat">
					<ul class="nav nav-collapse subnav">
						<li><a href="?page=lap_gfk_kartustok_gudang_puskesmas"><span class="sub-item">Kartu Stok</span><span class="badge" style="background:red;"></span></a></li>
						<li>
							<?php 
								$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
								$go_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(KodeBarang)AS Jml FROM `$tbgudangpkmstok` WHERE `Stok` > '0'"));?>
							<a href="?page=apotik_gudang_stok"><span class="sub-item">Stok Barang</span><span class="badge" style="background:red;"><?php echo $go_puskesmas['Jml'];?></span></a>
							</b>
						</li>
						<!--<li><a href="?page=lap_farmasi_stok_opname">Cek Fisik<span class="badge badge-success">New</span></a></b></li>-->
						<li><a href="?page=lap_gfk_ketersediaan_barang"><span class="sub-item">Ketersediaan Dinkes</span></a></li>
						<li><a href="?page=apotik_gudang_penerimaan_mandiri"><span class="sub-item">Penerimaan Dinas</span></a></li>
						<li><a href="?page=apotik_gudang_pengadaan"><span class="sub-item">Pengadaan Barang</span></a></li>
						<li><a href="?page=apotik_gudang_pengeluaran"><span class="sub-item">Pengeluaran Barang</span></a></li>
						<li><a href="?page=apotik_gudang_retur"><span class="sub-item">Retur/Hibah Barang</span></a></li>
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
						<li><a href="?page=apotik_stok&status=LOKET OBAT"><span class="sub-item">Depot Obat</span><span class="badge" style="background:red;"><?php  echo $apotikstok_umum;?></span></a></li>
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
</li>
<?php } ?>

<?php if(date("H") > 9){?>
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
				<a data-toggle="collapse" href="#lap_pendaftaran">
					<span class="sub-item">Pendaftaran</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_pendaftaran">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_loket_registrasi_kunjungan" target="_blank">Kunj.Harian</a></li>
						<li><a href="?page=lap_loket_kunjungan_bulan" target="_blank">Kunj.Bulan</a></li>
						<li><a href="?page=lap_loket_kunjungan_kelurahan_tahun" target="_blank">Kunj.Tahun</a></li>
						<li><a href="?page=lap_loket_kunjungan_kelurahan" target="_blank">Kunj.Bulan (Wlyh)</a></li>
						<li><a href="?page=lap_loket_kunjungan_anakremaja" target="_blank">Anak & Remaja</a></li>
						<li><a href="?page=lap_loket_kunjungan_kelompok_umur" target="_blank">Kelompok Umur</a></li>
						<li><a href="?page=lap_loket_rekapitulasi_kunjungan" target="_blank">Cara Bayar (Br/Lm)</a></li>
						<li><a href="?page=lap_loket_carabayar_kelurahan" target="_blank">Cara Bayar (Wly)</a></li>
						<li><a href="?page=lap_loket_carabayar" target="_blank">Cara Bayar</a></li>
						<li><a href="?page=lap_loket_carabayar_detail" target="_blank">Cara Bayar Detail</a></li>
						<li><a href="?page=lap_loket_data_kk" target="_blank">KK (Index)</a></li>
						<li><a href="?page=lap_loket_poli" target="_blank">Poli</a></li>
						<li><a href="?page=lap_loket_poli_bulan" target="_blank">Poli (Bulan)</a></li>		
						<li><a href="?page=lap_loket_rup" target="_blank">RUP</a></li>
						<li><a href="?page=lap_loket_rujukan" target="_blank">Rujukan</a></li>
						<li><a href="?page=lap_loket_rujukan_register">Rujukan Register</a></li>
						<li><a href="?page=lap_loket_keluarga_miskin" target="_blank">Keluarga Miskin</a></li>
						<li><a href="?page=lap_bpjs_sakitsehat" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/>Sakit/Sehat</a></li>
						<li><a href="?page=lap_bpjs_sakitsehat_detail" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/>Sakit/Sehat Detail</a></li>
						<li><a href="?page=poli_antri_bridging_bulan_pendaftaran" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/>Gagal Bridging</a></li>
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
						<li><a href="?page=lap_registrasi_anak_tarakan" target="_blank">Anak Register</a></li>
						<li><a href="?page=lap_registrasi_gigi" target="_blank">Gigi Register</a></li>
						<li><a href="?page=lap_gigi_carabayar" target="_blank">Gigi Cara Bayar</a></li>
						<li><a href="?page=lap_gigi_bulanan_tarakan_rup" target="_blank">Gigi Bulanan (RUP)</a></li>
						<li><a href="?page=lap_gigi_bulanan_tarakan" target="_blank">Gigi Bulanan (LB)</a></li>
						<li><a href="?page=lap_registrasi_gizi_tarakan" target="_blank">Gizi Register</a></li>
						<li><a href="?page=lap_registrasi_imunisasi" target="_blank">Imunisasi Register</a></li>
						<li><a href="?page=lap_registrasi_isolasi" target="_blank">Isolasi Register</a></li>
						<li><a href="?page=lap_registrasi_kb" target="_blank">KB Register</a></li>
						<li><a href="?page=lap_registrasi_kia_tarakan" target="_blank">KIA Register</a></li>
						<li><a href="?page=lap_registrasi_laboratorium" target="_blank">Lab Register</a></li>
						<li><a href="?page=lap_registrasi_lansia_tarakan" target="_blank">Lansia Register</a></li>
						<li><a href="?page=lap_registrasi_lansia_bulan" target="_blank">Lansia Bulanan</a></li>
						<li><a href="?page=lap_registrasi_mtbs" target="_blank">MTBS Register</a></li>
						<li><a href="?page=lap_mtbs_bulanan_kukarkab" target="_blank">MTBS (LB)</a></li>
						<li><a href="?page=lap_registrasi_umum" target="_blank">Umum Register</a></li>
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
						<li><a href="?page=lap_farmasi_kunjungan_resep">Kunjungan Resep</a></li>
						<li><a href="?page=lap_farmasi_ketersediaan_puskesmas_bandungkab">Ketersediaan</a></li>
						<li><a href="?page=lap_farmasi_penerimaan_puskesmas">Penerimaan</a></li>
						<li><a href="?page=lap_farmasi_apotik_pemakaian_obat_harian">Pemakaian</a></li>
						<li><a href="?page=lap_farmasi_apotik_resep_cara_bayar">Cara Bayar</a></li>
						<li><a href="?page=lap_farmasi_pio_hari">Pio Harian</a></li>
						<li><a href="?page=lap_farmasi_rawatjalan_pio">Kefarmasian</a></li>
						<li><a href="?page=lap_farmasi_pemakaianobat_terbanyak">Obat Terbanyak</a></li>
						<li><a href="?page=lap_farmasi_psikotropika">Psikotropika</a></li>
						<li><a href="?page=lap_farmasi_lplpo_manual">LPLPO</a></b></li>
						<li><a href="?page=lap_farmasi_rko_bandungkab">RKO</a></li>
						<li><a href="?page=lap_farmasi_pordetail">POR</a></li>
						<li><a href="?page=lap_farmasi_persediaan">Persediaan Barang</a></li>
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
						<li><a href="?page=lap_lb1_penyakit_tarakan" target="_blank">LB1-Penyakit</a></li>
						<li><a href="?page=lap_P2M_cacingan" target="_blank">Cacingan Register</a></li>
						<li><a href="?page=lap_P2M_DBD_Harian" target="_blank">DBD Register</a></li>
						<li><a href="?page=lap_P2M_Diare_Harian" target="_blank">Diare Register</a></li>
						<li><a href="?page=lap_P2M_Diare_Bulanan" target="_blank">Diare Bulanan</a></li>
						<li><a href="?page=lap_P2M_Ispa_Harian" target="_blank">Ispa Register</a></li>
						<li><a href="?page=lap_P2M_Ispa_Bulanan" target="_blank">Ispa Bulanan</a></li>
						<li><a href="?page=lap_P2M_Tifoid_Harian" target="_blank">Tifoid Register</a></li>
						<li><a href="?page=lap_P2M_campak" target="_blank">Campak-C1</a></li>
						<li><a href="?page=lap_P2M_ptm" target="_blank">PTM Register</a></li>
						<li><a href="?page=lap_P2M_ptm_kasus" target="_blank">PTM Kasus</a></li>
						<li><a href="?page=lap_P2M_ptm_faktorresiko" target="_blank">PTM Faktor Resiko</a></li>
						<li><a href="?page=lap_P2M_ptm_spm" target="_blank">PTM (SPM Skrining)</a></li>
						<li><a href="?page=lap_P2M_ptm_spm_diabet" target="_blank">PTM (SPM Diabet)</a></li>
						<li><a href="?page=lap_P2M_ptm_spm_hipertensi" target="_blank">PTM (SPM Hipertensi)</a></li>
						<li><a href="?page=lap_P2M_ili" target="_blank">ILI Register</a></li>
						<li><a href="?page=lap_P2M_indera" target="_blank">Indera & Fungsional</a></li>
						<li><a href="?page=lap_P2M_jiwa_register" target="_blank">Kes. Jiwa Register</a></li>
						<li><a href="?page=lap_P2M_jiwa" target="_blank">Kes. Jiwa</a></li>
						<li><a href="?page=lap_P2M_remaja" target="_blank">Kes. Remaja</a></li>
						<li><a href="?page=lap_P2M_leptospirosis" target="_blank">Leptospirosis</a></li>
						<li><a href="?page=lap_P2M_surveilans" target="_blank">Surveilans-STP</a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak" target="_blank">Penyakit Terbanyak</a></li>
						<li><a href="?page=lap_P2M_penyakit" target="_blank">Tracking Diagnosa</a></li>
						<li><a href="?page=lap_P2M_sebengkok" target="_blank">Tracking Diagnosa 2</a></li>
						<li><a href="?page=lap_P2M_tindakan" target="_blank">Tindakan Pasien</a></li>
						<li><a href="?page=lap_P2M_wabah" target="_blank">Wabah-W2</a></li>
					</ul>
				</div>
			</li>
			<li>
				<a data-toggle="collapse" href="#lap_sp2tp">
					<span class="sub-item">SP2TP</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="lap_sp2tp">
					<ul class="nav nav-collapse">
						<li><a href="?page=lap_sp2tp_carabayar" target="_blank">RUP Bayar</a></li>
						<li><a href="?page=lap_sp2tp_jenispekerjaan" target="_blank">RUP Kerja</a></li>
						<li><a href="?page=lap_sp2tp_poli" target="_blank">RUP Poli</a></li>
						<li><a href="?page=lap_loket_kunjungan_kelompok_umur" target="_blank">RUP Umur</a></li>
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
						<li><a href="?page=lap_loket_kecelakaan_lalulintas" target="_blank">Kecelakaan Lu.Lintas</a></li>
						<li><a href="?page=lap_P2M_penyakit_terbanyak" target="_blank">Penyakit Terbanyak</a></li>
						<li><a href="?page=lap_loket_carabayar_rujukan" target="_blank">Rwt.Jalan & Rujukan</a></li>
						<li><a href="?page=lap_loket_rawatinap" target="_blank">Rwt.Inap & Rujukan</a></li>
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
						<li><a href="?page=lap_loket_tracking_pegawai" target="_blank">Kinerja Pegawai</a></li>
						<li><a href="?page=lap_loket_kegiatan_harian" target="_blank">Kegiatan Harian</a></li>
						<li><a href="?page=lap_loket_tracking_pegawai_rujukan" target="_blank">Rujukan Per-Pegawai</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</li>
<?php } ?>

<?php 
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
			<li><a href="?page=master_aset"><span class="sub-item">Data Aset</span></a></li>
			<li><a href="?page=master_obat_fornas"><span class="sub-item">Data Fornas</span></a></li>
			<li><a href="?page=master_obat_jkn"><span class="sub-item">Data JKN</span></a></li>
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
			<?php if(in_array("PROGRAMMER", $otoritas)){ ?>
			<li><a href="?page=master_slide_banner"><span class="sub-item">Slide Banner</span></a></li>
			<?php } ?>
			<li><a href="?page=master_tindakan"><span class="sub-item">Tindakan</span></a></li>
			<li><a href="?page=import_data"><span class="sub-item">Import Data</span></a></li>
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
			<?php } ?>
			<li><a href="?page=adm_konsultasi"><span class="sub-item">Konsultasi</span></a></li>
			<li><a href="?page=adm_update_simpus"><span class="sub-item">Update Simpus</span></a></li>
		</ul>
	</div>
</li>
<?php 
	// }
?>
<li class="nav-item">
	<a href="?page=backup"><i class="icon-drawer"></i><span class="menu-text">Backup Data</span></a>
</li>
<li class="logmobile">
	<a href="?page=update_profile"><i class="icon-user"></i> Data User</a>
</li>
<li class="logmobile">
	<a href="logout.php">
		<i class="icon-close"></i> Log Out</span>
	</a>
</li>