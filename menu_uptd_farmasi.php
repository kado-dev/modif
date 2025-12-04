<?php 
	$kota = $_SESSION['kota'];
	$username = $_SESSION['username'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<?php if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){ ?>
<li class="nav-item active">
	<a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
		<i class="icon-home"></i>
		<p>Dashboard</p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="dashboard">
		<ul class="nav nav-collapse">
			<li>
				<a href="?page=dashboard">Utama</a>
				<!--Lplpo-->
				<?php if($kota == "KABUPATEN BANDUNG"){?>
				<a href="?page=dashboard_lplpo_bandungkab">LPLPO</a>
				<a href="?page=dashboard_rko_bandungkab">RKO</a>
				<?php }?>
				
				<!--Lplpo-->
				<?php if($kota == "KABUPATEN BOGOR"){?>
				<a href="?page=dashboard_lplpo_bogorkab">LPLPO</a>
				<a href="?page=dashboard_rko_bogorkab">RKO</a>
				<a href="?page=dashboard_rekapdata_bogorkab">REKAP DATA</a>
				<?php }?>
			</li>
		</ul>
	</div>
</li>
<?php } ?>
<li class="nav-item">
	<a data-toggle="collapse" href="#ketersediaan" class="collapsed" aria-expanded="false">
		<i class="icon-speedometer"></i>
		<span class="menu-text">Ketersediaan</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="ketersediaan">
		<ul class="nav nav-collapse">
			<li>
				<a href="?page=lap_gfk_ketersediaan_barang_bandungkab_group">Obat</a>
				<a href="?page=lap_gfk_ketersediaan_vaksin_bandungkab_group">Vaksin</a>
			</li>
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a href="?page=flash_news">
		<i class="icon-speech"></i><span class="menu-text">Berita Update</span>
	</a>
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#elogkemenkes" class="collapsed" aria-expanded="false">
		<i class="icon-drawer"></i>
		<span class="menu-text">E-Logistic Kemkes</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="elogkemenkes">
		<ul class="nav nav-collapse">
			<li>
				<a data-toggle="collapse" href="#indikator">
					<span class="sub-item">Indikator</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="indikator">
					<ul class="submenu">
						<li><a href="?page=elog_indikator_kirim">Kirim Indikator</a></li>
						<li><a href="?page=elog_indikator_obat">Lihat Indikator</a></li>
					</ul>
				</div>				
			</li>
			<li>
				<a data-toggle="collapse" href="#ketersediaan">
					<span class="sub-item">Ketersediaan</span>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="ketersediaan">
					<ul class="submenu">
						<li><a href="?page=elog_ketersediaan_kirim">Kirim Ketersediaan</a></li>
						<li><a href="?page=elog_ketersediaan_obat">Lihat Ketersediaan</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</li>

<li class="nav-item">
	<a href="sielok/index.php">
		<i class="icon-grid"></i><span class="menu-text">Info Ketersediaan</span>
	</a>
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#gudangbesar" class="collapsed" aria-expanded="false">
		<i class="icon-social-dropbox"></i>
		<span class="menu-text">Gudang Besar</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="gudangbesar">
		<ul class="nav nav-collapse">
			<li>
				<?php
					$stok_gb = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD' AND `Stok` > '0'"));
				?>
				<a href="?page=gudang_besar_stok">
					<span class="sub-menu-text">Stok Barang 
						<span class="badge" style="background:red; color:white; font-weight:bold;"><?php echo $stok_gb;?></span>
					</span>
				</a>
			</li>
			<li><a href="?page=gudang_besar_penerimaan">Penerimaan Barang</a></li>
			<li><a href="?page=gudang_besar_pengeluaran">Pengeluaran Barang</a></li>
			<li><a href="?page=gudang_besar_retur">Retur/Hibah Pkm</a></li>
			<li><a href="?page=gudang_besar_opnam">Stok Opname</a></li>
		</ul>
	</div>	
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#gudangvaksin" class="collapsed" aria-expanded="false">
		<i class="icon-social-dropbox"></i>
		<span class="menu-text">Gudang Vaksin</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="gudangvaksin">
		<ul class="nav nav-collapse">
			<li><a href="?page=gudang_vaksin_stok"><span class="sub-menu-text">Stok Barang</span></a></li>
			<li><a href="?page=gudang_vaksin_penerimaan">Penerimaan Barang</a></li>
			<li><a href="?page=gudang_vaksin_pengeluaran">Pengeluaran Barang</a></li>
			<li><a href="?page=lap_gfk_kartustok_vaksin">Kartu Stok</span></a></li>
			<li> <a href="?page=gudang_vaksin_opnam">Stok Opname</span></a></li>
			<li><a href="?page=uptd_gudang_sisa_aset_vaksin_bogorkab">Lap.Ketersediaan</span></a></li>
			<li><a href="?page=lap_farmasi_vaksin_distribusi_bandungkab">Lap.Distribusi</span></a></li>
			<li><a href="?page=lap_farmasi_vaksin_distribusi_unit">Lap.Distribusi Unit</span></a></li>
			<li><a href="?page=uptd_gudang_vaksin_sisa_aset_triwulan_bogorkab"><span class="sub-menu-text">Lap.SO (Triwulan)</span></a></li>
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#gudangkarantina" class="collapsed" aria-expanded="false">
		<i class="icon-social-dropbox"></i>
		<span class="menu-text">Gudang Karantina</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="gudangkarantina">
		<ul class="nav nav-collapse">
			<li><a href="?page=gudang_karantina_stok"><span class="sub-menu-text">Data Karantina <span class="badge" style="background:red;"></span></span></a></li>
			<li><a href="?page=gudang_pemusnahan_stok"><span class="sub-menu-text">Data Pemusnahan <span class="badge" style="background:red;"></span></span></a></li>
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#laporan" class="collapsed" aria-expanded="false">
		<i class="icon-layers"></i>
		<span class="menu-text">Lap.Gudang</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="laporan">
		<ul class="nav nav-collapse">
			<li><a href="?page=lap_gfk_kartustok"><span class="sub-menu-text">Kartu Stok (Batch)</span></a></li>
			<li><a href="?page=lap_gfk_kartustok_group"><span class="sub-menu-text">Kartu Stok (Group)</span></a></li>
			<li><a href="?page=lap_gfk_ketersediaan_barang_bandungkab"><span class="sub-menu-text">Ketersediaan</span></a></li>
			<li><a href="?page=lap_gfk_mutasisediaan"<span class="sub-menu-text">Mutasi Sediaan</span></a></li>
			<li><a href="?page=lap_gfk_distribusi_barang_harian"><span class="sub-menu-text">Distibusi Harian</span></a></li>
			<li><a href="?page=lap_gfk_distribusi_unit_detail_bandungkab"><span class="sub-menu-text">Distribusi Unit Detail</span>
			<li><a href="?page=lap_gfk_keuangan_distribusi_barang"><span class="sub-menu-text">Distribusi (Keuangan)</span></a></li>
			<li><a href="?page=lap_gfk_psikotropika"><span class="sub-menu-text">Psikotropika</span></a></li>
			<li><a href="?page=lap_farmasi_rko_dinkes"><span class="sub-menu-text">RKO Puskesmas</span></a></li>
			<li><a href="?page=lap_farmasi_lplpo_puskesmas"><span class="sub-menu-text">LPLPO Puskesmas</span></a></li>
		</ul>
	</div>	
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#master" class="collapsed" aria-expanded="false">
		<i class="icon-settings"></i>
		<span class="menu-text">Master</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="master">
		<ul class="nav nav-collapse">
			<li><a href="?page=master_obat_fornas">Data Fornas</a></li>
			<li><a href="?page=master_obat_jkn">Data JKN</a></li>
			<li><a href="?page=master_obat">Data LPLPO</a></li>
			<li><a href="?page=master_obat_indikator">Data Obat Indikator</a></li>
			<li><a href="?page=master_obat_program">Data Program</a></li>
			<li><a href="?page=master_vaksin">Data Vaksin</a></li>
			<li><a href="?page=master_pegawai">Data Pegawai</a></li>
			<li><a href="?page=master_puskesmas">Data Puskesmas</a></li>
			<li><a href="?page=master_pemberi_lplpo">Data Pemberi (SBBK)</a></li>
			<li><a href="?page=master_penerima_lplpo">Data Penerima (SBBK)</a></li>
			<li><a href="?page=master_supplier">Data Supplier</a></li>
			<li><a href="?page=master_rumahsakit">Data Rumah Sakit</a></li>
		</ul>
	</div>	
</li>

<li class="logmobile">
	<a href="logout.php">
		<i class="fa fa-power-off faicon"></i>
		<span class="menu-text"> Log Out</span>
	</a>
</li>