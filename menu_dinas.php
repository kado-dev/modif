<li class="nav-item active">
	<a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
		<i class="fas fa-home"></i>
		<p>Dashboard</p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="dashboard">	
		<ul class="nav nav-collapse">
			<li><a href="?page=dashboard"><span class="sub-item">Utama</span></a></li>
		</ul>
	</div>
</li>

<!--<li class="">
	<a href="?page=dashboard_dinkes_kasir">
		<i class="fa fa-calculator faicon"></i><span class="menu-text">Retribusi</span>
	</a>
	<b class="arrow"></b>
</li>-->

<!--<li class="">
	<a href="?page=master_pegawai">
		<i class="fa fa-users faicon"></i><span class="menu-text">Kepegawaian</span>
	</a>
	<b class="arrow"></b>
</li>-->

<!--<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-area-chart faicon"></i><span class="menu-text">Grafik</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<b class="arrow"></b>
	<ul class="submenu">
		<li class="">
			<a href="?page=grafik_kunjungan_ukp"><i class="menu-icon glyphicon glyphicon-ok blue"></i>UKP & UKM</span></a>
			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="?page=grafik_kunjungan_baru_lama"><i class="menu-icon glyphicon glyphicon-ok blue"></i>Kunj.Baru & Lama</span></a>
			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="?page=grafik_kunjungan_carabayar_tahun"><i class="menu-icon glyphicon glyphicon-ok blue"></i>Jaminan/Cara Bayar</span></a>
			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="?page=grafik_penyakit_terbanyak_dinkes"><i class="menu-icon glyphicon glyphicon-ok blue"></i>Penyakit Terbanyak</span></a>
			<b class="arrow"></b>
		</li>
	</ul>
</li>-->

<?php if($_SESSION['otoritas'] == 'PROGRAMMER' || $_SESSION['otoritas'] == 'ADMINISTRATOR'){ ?>
	<li class="nav-item">
	<a data-toggle="collapse" href="#kunjungan">
		<i class="icon-grid"></i><span class="menu-text">Kunjungan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="kunjungan">
		<ul class="nav nav-collapse">
			<li><a href="?page=lap_kunjungan_dinkes">Kunjungan</a></li>
			<!--<li><a href="?page=lap_loket_kunjungan_kelurahan">Desa/Kel</a></li>
			<li><a href="?page=lap_loket_kunjungan_kelurahan_tahun">Desa/Kel (Tahun)</a></li>-->
			<li><a href="?page=lap_loket_kunjungan_puskesmas_tahun">Kunjungan (Tahun)</a></li>
			<li><a href="?page=lap_loket_poli_dinkes">Poli</a></li>
			<li><a href="?page=lap_loket_carabayar_dinkes">Cara Bayar</a></li>
			<li><a href="?page=lap_retribusi_dinkes">Retribusi</a></li>
			<!--<li><a href="?page=lap_loket_kunjungan_jeniskelamin">Jenis Kelamin (Tahun)</a></li>
			<li><a href="?page=lap_loket_rekapitulasi_kunjungan">Baru/Lama (Tahun)</a></li>
			<li><a href="?page=lap_loket_poli">Poli</a></li>
			<li><a href="?page=lap_loket_carabayar">Cara Bayar</a></li>
			<li><a href="?page=lap_loket_indeksalamat">Indeks Alamat</a></li>
			<li><a href="?page=lap_loket_rujukan">Rujukan Pasien</a></li>-->
		</ul>
	</div>	
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#p2p">
		<i class="icon-grid"></i><span class="menu-text">P2P</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="p2p">
		<ul class="nav nav-collapse">
		<li><a href="?page=lap_lb1_penyakit_dinkes">LB-1 (Penyakit)</a></li>
		<li><a href="?page=lap_P2M_cikungunya_dinkes">Cikungunya</a></li>
		<li><a href="?page=lap_P2M_dbd_dinkes">Dbd</a></li>
		<li><a href="?page=lap_P2M_diare_dinkes">Diare</a></li>
		<li><a href="?page=lap_P2M_hipertensi_dinkes">Hipertensi & DM</a></li>
		<li><a href="?page=lap_P2M_ispa_dinkes">Ispa</a></li>
		<li><a href="?page=lap_P2M_jiwa_dinkes">Jiwa</a></li>
		<li><a href="?page=lap_P2M_mump_dinkes">Mump/Gondongan</a></li>
		<li><a href="?page=lap_P2M_varicella_dinkes">Varicella/Cacar</a></li>
		<li><a href="?page=lap_P2M_penyakit_terbanyak_dinkes">Penyakit Terbanyak</a></li>
		<li><a href="?page=lap_P2M_penyakit_dinas_bulan">Tracking Diagnosa</a></li>
		<!--<li><a href="?page=lap_P2M_wabah">Wabah (W2)</a></li>
		<li><a href="?page=lap_P2M_campak">Campak (C1)</a></li>
		<li><a href="?page=lap_P2M_Diare_Bulanan_Dinkes">Diare</a></li>
		<li><a href="?page=lap_P2M_Ispa_Bulanan_Dinkes">Ispa</a></li>
		<li><a href="?page=lap_P2M_leptospirosis_dinkes">Leptospirosis</a></li>
		
		<li><a href="?page=lap_P2M_ptm_kasus_dinkes">Penyakit Tidak Menular</a></li>
		<li><a href="?page=lap_P2M_surveilans_dinkes">Surveilans (STP)</a></li>
		<li><a href="?page=lap_P2M_penyakit_dinkes">Trc.Diagnosa (Regis)</a></li>
		<li><a href="?page=lap_P2M_penyakit_tahun_dinkes">Trc.Diagnosa (Tahun)</a></li>-->
		</ul>
	</div>
</li>

<!--<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-file-excel-o faicon" aria-hidden="true"></i><span class="menu-text">LB</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=lap_lb1_penyakit_dinkes">LB1-Penyakit</a></li>
		<li><a href="?page=lap_lb1_penyakit_kelurahan">LB1-(Desa/Kelurahan)</a></li>
		<li><a href="?page=#">LPLPO</a></li>
	</ul>
</li>-->
<?php } ?>

<!--<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-cog faicon"></i><span class="menu-text">Master Data</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li>
			<a href="?page=master_diagnosa">Diagnosa</a>
		</li>
		<li>
			<a href="?page=master_tindakan">Tindakan</a>
		</li>
		<li>
			<a href="?page=master_puskesmas">Puskesmas</a>
		</li>
		<li>
			<a href="?page=master_pegawai">Pegawai</a>
		</li>
		<li>
			<a href="?page=master_asuransi">Asuransi</a>
		</li>
		<li>
			<a href="?page=master_pendidikan">Pendidikan</a>
		</li>
		<li>
			<a href="?page=master_pekerjaan">Pekerjaan</a>
		</li>
	</ul>
</li>-->
<!--<li class="">
	<a href="?page=flash_news">
		<i class="fa fa-image faicon"></i><span class="menu-text">Flash News</span>
	</a>
	<b class="arrow"></b>
</li>-->