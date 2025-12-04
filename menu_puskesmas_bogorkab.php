<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kota = $_SESSION['kota'];
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	
	$apotikstok_umum = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='LOKET OBAT' AND `Stok` > '0'"));
	$apotikstok_lansia = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI LANSIA' AND `Stok` > '0'"));
	$apotikstok_igd = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='IGD' AND `Stok` > '0'"));
	$apotikstok_ranap = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='RAWAT INAP' AND `Stok` > '0'"));
	$apotikstok_poned = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PONED' AND `Stok` > '0'"));
	$apotikstok_pustu = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PUSTU' AND `Stok` > '0'"));
	$apotikstok_pusling = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PUSLING' AND `Stok` > '0'"));
	$poli_anak = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI ANAK' AND `Stok` > '0'"));
	$poli_gigi = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI GIGI' AND `Stok` > '0'"));
	$poli_jiwa = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI JIWA' AND `Stok` > '0'"));
	$poli_kia = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI KIA' AND `Stok` > '0'"));
	$poli_kusta = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI KUSTA' AND `Stok` > '0'"));
	$poli_lansia = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI LANSIA' AND `Stok` > '0'"));
	$poli_tb = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI TB' AND `Stok` > '0'"));
	$poli_umum = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI UMUM' AND `Stok` > '0'"));
	$laboratorium = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM tbapotikstok WHERE KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='LABORATORIUM' AND `Stok` > '0'"));
	
	// gudang vaksin
	$gudang_vaksin = mysqli_num_rows(mysqli_query($koneksi,"SELECT KodeBarang FROM `tbgudangpkmvaksinstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Stok` > '0'"));
	
	
?>
<style>	
	.menu-text{
		margin-left: 10px;
		text-align: left;
	}
	.faicon{
		align: center;
		font-size: 20px;
		width: 20px;
		height: 20px;
		text-align: center;
	}	
</style>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-home faicon"></i><span class="menu-text">Dashboard</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=dashboard">Utama</a></li>
		<?php if($_SESSION['otoritas'] != "APOTEK"){ ?>
		<li><a href="?page=dashboard_bpjs">Bpjs</a></li>
		<?php } ?>
	</ul>
</li>
<?php if($_SESSION['otoritas'] != "APOTEK"){ ?>	
<li>
	<a href="?page=dashboard_covid">
		<i class="fa fa-bar-chart faicon"></i><span class="menu-text">Info Covid-19</span>
	</a>
	<b class="arrow"></b>
</li>
<li>
	<a href="?page=waktu_pelayanan">
		<i class="fa fa-bar-chart faicon"></i><span class="menu-text">Waktu Pelayanan</span>
	</a>
	<b class="arrow"></b>
</li>
<?php
	}
	if (in_array("APOTEK", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>
<li>
	<a href="?page=puskesmas_gemacermat">
		<i class="fa fa-image faicon"></i><span class="menu-text">Gema Cermat</span>
	</a>
</li>
<?php 
	}
	if (in_array("LOKET", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)|| in_array("PENGUNJUNG", $otoritas)){
?>
<li>
	<a href="?page=grafik_tracking_pegawai">
		<i class="fa fa-bar-chart faicon"></i><span class="menu-text">Kinerja Pegawai</span>
	</a>
</li>
<li>
	<a href="?page=registrasi_form">
		<i class="fa fa-desktop faicon"></i><span class="menu-text">Registrasi</span>
	</a>
</li>
<?php 
	}
	if (in_array("LOKET", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-address-card faicon"></i><span class="menu-text">Rekam Medis</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=rekam_medis">Data Register</a></li>
		<li><a href="?page=pasien_belum_entry">Data Belum Entry</a></li>
		<li><a href="?page=poli_antri_bridging_bulan">Data Gagal Bridging</a></li>
		<li><a href="?page=rekam_medis_pasien">Data RM</a></li>
		<li><a href="?page=lap_loket_data_kk">Bank Nomor Pasien</a></li>
	</ul>
</li>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-calculator faicon"></i><span class="menu-text">Kasir</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=dashboard_puskesmas_kasir">Dashboard</a></li>
		<li><a href="?page=kasir_pembayaran">Pembayaran</a></li>
		<li><a href="?page=kasir_laporan">Laporan</a></li>
	</ul>
</li>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-object-group faicon"></i><span class="menu-text">Rujukan</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=dashboard_rujukan">Dashboard</a></li>
		<li><a href="?page=lap_loket_rujukan_register">Laporan</a></li>
	</ul>
</li>
<?php
	}
	if (in_array("POLI GIGI", $otoritas) || in_array("POLI KB", $otoritas) || in_array("POLI KIA", $otoritas) ||
	in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
	in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI UMUM", $otoritas) ||	in_array("OPERATOR", $otoritas) ||
	in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) ||
	in_array("PENGUNJUNG", $otoritas)){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-user-md (alias) faicon"></i><span class="menu-text">Pemeriksaan</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<?php
			$strpoli = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='Kunjungan Sakit' order by Pelayanan");
			while($menu = mysqli_fetch_assoc($strpoli)){
		?>
		<li>
			<?php
				$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				$dt_antri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbpasienrj` WHERE TanggalRegistrasi = curdate() and substring(NoRegistrasi,1,11)='$kodepuskesmas' and PoliPertama = '$menu[Pelayanan]' and StatusPelayanan='Antri'")); 
				$dt_rujuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRujukan)AS Jml FROM `tbrujukinternal` WHERE TanggalRujukan = curdate() and substring(NoRujukan,1,11)='$kodepuskesmas' and PoliRujukan = '$menu[Pelayanan]' and StatusPemeriksaan='Rujuk'")); 
				$jml_data = $dt_antri['Jml'] + $dt_rujuk['Jml'];
			?>
			<a href="?page=poli&pelayanan=<?php echo $menu['Pelayanan'];?>">
				<span class="sub-menu-text"><?php echo $menu['Pelayanan'];?>
					<?php if ($jml_data != 0){?><span class="badge badge-danger"><?php echo $jml_data;}?></span>
				</span>
			</a>
		</li>
		<?php
			}
		?>
	</ul>
</li>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-plus-square faicon"></i><span class="menu-text">Aset</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=aset_stok">Stok Barang</a></li>
		<li><a href="?page=aset_pengadaan">Pengadaan</a></li>
		<li><a href="?page=aset_pengeluaran">Pengeluaran</a></li>
	</ul>
</li>
<?php
	}
	if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("PENGUNJUNG", $otoritas)){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-plus-square faicon"></i><span class="menu-text">Gudang Dinkes</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=lap_gfk_ketersediaan_barang_bogorkab_group_view_puskesmas">Ketersediaan Obat</a></li>
		<li><a href="?page=lap_gfk_ketersediaan_barang_bogorkab_group_view_puskesmas_vaksin">Ketersediaan Vaksin</a></li>
	</ul>
</li>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-plus-square faicon" aria-hidden="true"></i><span class="menu-text">Farmasi</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<b class="arrow"></b>
	<ul class="submenu">
		<li>
			<a href="#" class="dropdown-toggle">Gudang Vaksin<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_gfk_kartustok_vaksin_puskesmas">Kartu Stok<span class="badge" style="background:red;"></span></a></li>
				<li><a href="?page=apotik_vaksin_gudang_stok">Stok Barang<span class="badge" style="background:red;"><?php echo $gudang_vaksin;?></span></a></li>
				<li><a href="?page=apotik_vaksin_gudang_penerimaan">Penerimaan Barang<span class="badge" style="background:red;"></span></a></li>
				<li><a href="?page=apotik_vaksin_gudang_pengeluaran">Pengeluaran Barang<span class="badge" style="background:red;"></span></a></li>
				<li><a href="?page=uptd_gudang_sisa_aset_vaksin_bogorkab_puskesmas">Lap.Ketersediaan</span></a></li>
				<li><a href="?page=uptd_gudang_vaksin_sisa_aset_triwulan_bogorkab_puskesmas">Lap.Stok Opname</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">Gudang Obat<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_gfk_kartustok_gudang_puskesmas">Kartu Stok<span class="badge" style="background:red;"></span></a></li>
				<li>
					<?php $go_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(KodeBarang)AS Jml FROM `$tbgudangpkmstok` WHERE `Stok` > '0'"));?>
					<a href="?page=apotik_gudang_stok">Stok Barang<span class="badge" style="background:red;"><?php echo $go_puskesmas['Jml'];?></span></a>
					<b class="arrow"></b>
				</li>
				<!--<li><a href="?page=lap_farmasi_stok_opname">Cek Fisik<span class="badge badge-success">New</span></a><b class="arrow"></b></li>-->
				<?php if($kota == "KABUPATEN BANDUNG"){ ?>
				<li>
					<a href="?page=lap_gfk_ketersediaan_barang">Ketersediaan Dinkes</a>
					<b class="arrow"></b>
				</li>
				<?php } ?>
				<li>
					<?php if($kota == "KABUPATEN BANDUNG" || $kota == "KABUPATEN BOGOR" || $kota == "KABUPATEN BEKASI"){ ?>
					<a href="?page=apotik_gudang_penerimaan">Penerimaan Dinas</a>
					<?php }elseif($kota == "KOTA BANDUNG" || $kota == "KABUPATEN KUTAI KARTANEGARA" || $kota == "KABUPATEN BULUNGAN"){ ?>
					<a href="?page=apotik_gudang_penerimaan_mandiri">Penerimaan Dinas</a>
					<?php } ?>
					<b class="arrow"></b>
				</li>
				<li>
					<?php if($kota == "KABUPATEN BOGOR"){ ?>
						<a href="?page=apotik_gudang_pengadaan">Penerimaan Non Dinas</a><b class="arrow"></b>
					<?php }else{ ?>
						<a href="?page=apotik_gudang_pengadaan">Pengadaan Barang</a><b class="arrow"></b>
					<?php } ?>
				</li>
				<li>
					<a href="?page=apotik_gudang_pengeluaran">Pengeluaran Barang</a>
					<b class="arrow"></b>
				</li>
				<li><a href="?page=apotik_gudang_retur">Retur/Hibah Barang</a><b class="arrow"></b></li>
				<?php
				 if($kota == "KABUPATEN BULUNGAN"){
				?>
				<li>
					<?php
						$pdepot = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoFaktur FROM `tbgudangpkmpengeluaran` WHERE `KodePuskesmas` = '$kodepuskesmas' AND `StatusPermintaan`='N' GROUP BY NoFaktur"));
					?>
					<a href="?page=apotik_permintaan_depot">
					Permintaan Depot <span class="badge" style="background:red;"><?php echo $pdepot;?></span>
					</a>
					<b class="arrow"></b>
				</li>
				<?php
					}
				?>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">Depot Obat<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li>
					<a href="?page=apotik_stok&status=LOKET OBAT">Depot Obat<span class="badge" style="background:red;"><?php echo $apotikstok_umum;?></span></a>
					<b class="arrow"></b>
				</li>
				<?php if($kota == "KABUPATEN BULUNGAN"){?>
				<li>
					<a href="?page=apotik_stok&status=Poli Lansia">Depot Lansia<span class="badge" style="background:red;"><?php echo $apotikstok_lansia;?></span></a>
					<b class="arrow"></b>
				</li>
				<?php } ?>
				<li>
					<a href="?page=apotik_stok&status=IGD">IGD/R.Tindakan<span class="badge" style="background:red;"><?php echo $apotikstok_igd;?></span></a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=apotik_stok&status=RAWAT INAP">Rawat Inap<span class="badge" style="background:red;"><?php echo $apotikstok_ranap;?></span></a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=apotik_stok&status=PONED">Poned<span class="badge" style="background:red;"><?php echo $apotikstok_poned;?></span></a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=apotik_stok&status=PUSTU">Pustu<span class="badge" style="background:red;"><?php echo $apotikstok_pustu;?></span></a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=apotik_stok&status=PUSLING">Pusling<span class="badge" style="background:red;"><?php echo $apotikstok_pusling;?></span></a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI ANAK">Poli Anak<span class="badge" style="background:red;"><?php echo $poli_anak;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI GIGI">Poli Gigi<span class="badge" style="background:red;"><?php echo $poli_gigi;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI JIWA">Poli Jiwa<span class="badge" style="background:red;"><?php echo $poli_jiwa;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI KIA">Poli Kia<span class="badge" style="background:red;"><?php echo $poli_kia;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI KUSTA">Poli Kusta<span class="badge" style="background:red;"><?php echo $poli_kusta;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI LANSIA">Poli Lansia<span class="badge" style="background:red;"><?php echo $poli_lansia;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI TB">Poli TB<span class="badge" style="background:red;"><?php echo $poli_tb;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=POLI UMUM">Poli Umum<span class="badge" style="background:red;"><?php echo $poli_umum;?></span></a>
				</li>
				<li>
					<a href="?page=apotik_stok&status=LABORATORIUM">Laboratorium<span class="badge" style="background:red;"><?php echo $laboratorium;?></span></a>
				</li>
			</ul>
		</li>
	</ul>
</li>
<?php 
}
	if($kota == "KABUPATEN BOGOR"){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-file-excel-o faicon" aria-hidden="true"></i><span class="menu-text">Laporan</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<b class="arrow"></b>
	<ul class="submenu">
		<li><a href="?page=lap_farmasi_dkh">DKH JKN</a></li>
		<li><a href="?page=lap_farmasi_importdata">Rekap Data</a><b class="arrow"></b></li>
		<!--<li>
			<a href="?page=lap_farmasi_stokawal_puskesmas">Stok Awal
			</a>
			<b class="arrow"></b>
		</li>-->
		<li><a href="?page=lap_farmasi_ketersediaan_puskesmas">Ketersediaan</a><b class="arrow"></b></li>
		<li><a href="?page=lap_farmasi_penerimaan_puskesmas">Penerimaan</a><b class="arrow"></b></li>
		<li><a href="?page=lap_farmasi_pemakaian_puskesmas">Pemakaian</a><b class="arrow"></b></li>
		<!--<li><a href="?page=lap_farmasi_distribusi_puskesmas">Distribusi</a><b class="arrow"></b></li>-->
		<li><a href="?page=lap_farmasi_stok_opname_triwulan">Stok Opname</a><b class="arrow"></b></li>
		<!--<li>
			<a href="#">Tingkat Kecukupan</a>
			<b class="arrow"></b>
		</li>-->
		<!--<li>
			<a href="#">RKO Epidemiologi</a>
			<b class="arrow"></b>
		</li>-->
		<li><a href="?page=lap_farmasi_rko_bogorkab">RKO (APBD & JKN)</a><b class="arrow"></b></li>
		<li><a href="#"><b>Bulanan Rutin</b></a><b class="arrow"></b></li>
		<li><a href="?page=lap_farmasi_lplpo_manual_bogorkab">LPLPO</a><b class="arrow"></b></li>
		<li><a href="?page=lap_farmasi_pordetail">POR</a><b class="arrow"></b></li>
		<li><a href="?page=lap_farmasi_psikotropika_bogorkab">Narkotik Psikotropik</a><b class="arrow"></b></li>
		<li><a href="?page=lap_farmasi_indikatorobat">40 Indikator</a><b class="arrow"></b></li>
		<!--<li>
			<a href="?page=lap_farmasi_kunjungan_resep">Narpza</a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="#">Gema Cermat</a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="#">% Resep Terhadap Fornas</a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="#">% Obat Terhadap Fornas</a>
			<b class="arrow"></b>
		</li>	
		<li>
			<a href="?page=lap_farmasi_kunjungan_resep">POR</a>
			<b class="arrow"></b>
		</li>-->
	</ul>
</li>
<?php
	}
	if(in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-area-chart faicon"></i><span class="menu-text">Grafik</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<b class="arrow"></b>
	<ul class="submenu">
		<li>
			<a href="?page=grafik_kunjungan_ukp">Kunj. UKP & UKM</span></a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="?page=grafik_kunjungan_pasien_hari_puskesmas">Kunj. Per-Hari</span></a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="?page=grafik_kunjungan_pasien_tahun_puskesmas">Kunj. Per-Bulan</span></a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="?page=grafik_kunjungan_baru_lama">Kunj. Baru & Lama</span></a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="?page=grafik_kunjungan_carabayar_tahun">Kunj. Cara Bayar</span></a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="?page=grafik_penyakit_terbanyak">Penyakit Terbanyak</span></a>
			<b class="arrow"></b>
		</li>
	</ul>
</li>
<?php
	}
	if($kota != "KABUPATEN BOGOR"){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-file-excel-o faicon" aria-hidden="true"></i><span class="menu-text">Laporan</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<?php
			if (in_array("LOKET", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
		?>
		<li>
			<a href="#" class="dropdown-toggle">Antrian<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_antrian_bulan" target="_blank">Antrian</a></li>
				<li><a href="?page=lap_antrian_daftar_online" target="_blank">Pend.Online</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">Pendaftaran<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_loket_registrasi_kunjungan_garutkab" target="_blank">Kunj.Harian</a></li>
				<li><a href="?page=lap_loket_kunjungan_bulan" target="_blank">Kunj.Bulan</a></li>
				<li><a href="?page=lap_loket_kunjungan_kelurahan_tahun" target="_blank">Kunj.Tahun</a></li>
				<li><a href="?page=lap_loket_lb4" target="_blank">Kunj.LB4</a></li>
				<li><a href="?page=lap_loket_kunjungan_kelurahan" target="_blank">Kunj.Bulan (Wlyh)</a></li>
				<li><a href="?page=lap_loket_kunjungan_kelompok_umur" target="_blank">Kelompok Umur</a></li>
				<li><a href="?page=lap_loket_rekapitulasi_kunjungan" target="_blank">Cara Bayar (Br/Lm)</a></li>
				<?php if ($kota == "KABUPATEN BANDUNG"){ ?>
					<li><a href="?page=lap_loket_carabayar_kelurahan" target="_blank">Cara Bayar (Wly)</a></li>
				<?php }else{ ?>
					<li><a href="?page=lap_loket_carabayar_kelurahan_bandung" target="_blank">Cara Bayar (Wlyh)</a></li>
				<?php } ?>
				<li><a href="?page=lap_loket_carabayar" target="_blank">Cara Bayar</a></li>
				<li><a href="?page=lap_loket_carabayar_detail" target="_blank">Cara Bayar Detail</a></li>
				<li><a href="?page=lap_loket_poli" target="_blank">Poli</a></li>
				<li><a href="?page=lap_loket_poli_bulan" target="_blank">Poli (Bulan)</a></li>		
				<li><a href="?page=lap_loket_rup" target="_blank">RUP</a></li>
				<li><a href="?page=lap_bpjs_jiwa" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/> Per-Jiwa</a></li>
				<li><a href="?page=lap_bpjs_kunjungan" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/> Per-Kunjungan</a></li>
				<li><a href="?page=lap_bpjs_sakitsehat" target="_blank"><img src="image/logo_bpjs_bulet.png" width="15px" height="15px" alt="logo_bpjs"/> Sakit/Sehat</a></li>
			</ul>
		</li>
		<?php
			}
		?>
		<li>
			<a href="#" class="dropdown-toggle">Pemeriksaan<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_registrasi_anak" target="_blank">Anak Register</a></li>
				<li><a href="?page=lap_registrasi_gigi" target="_blank">Gigi Register</a></li>
				<li><a href="?page=lap_gigi_carabayar" target="_blank">Gigi Cara Bayar</a></li>
				<li><a href="?page=lap_gigi_bulanan" target="_blank">Gigi Bulanan (LB)</a></li>
				<li><a href="?page=lap_gigi_harian" target="_blank">Gigi Harian (LB)</a></li>
				<?php if ($kota == "KABUPATEN BANDUNG" || $kota == "KOTA BANDUNG" || $kota == "KABUPATEN BULUNGAN"){?>
				<li><a href="?page=lap_registrasi_gizi" target="_blank">Gizi Register</a></li>
				<?php }elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){ ?>
				<li><a href="?page=lap_registrasi_gizi_kukarkab" target="_blank">Gizi Register</a></li>
				<?php } ?>
				<li><a href="?page=lap_registrasi_gizi_kia_kukarkab" target="_blank">Gizi (KIA) Register</a></li>
				<?php if ($kota == "KABUPATEN BULUNGAN"){?>
				<li><a href="?page=lap_registrasi_imunisasi_bulungankab" target="_blank">Imunisasi Register</a></li>
				<?php }else{ ?>
				<li><a href="?page=lap_registrasi_imunisasi" target="_blank">Imunisasi Register</a></li>
				<?php } ?>
				<li><a href="?page=lap_imunisasi_catin" target="_blank">Imunisasi Catin</a></li>
				<li><a href="?page=lap_imunisasi_bumil" target="_blank">Imunisasi Bumil</a></li>
				<li><a href="?page=lap_imunisasi_sertifikat" target="_blank">Imunisasi Sertifikat</a></li>
				<li><a href="?page=lap_imunisasi_pemantauan" target="_blank">Imunisasi Kontrol</a></li>
				<li><a href="?page=lap_imunisasi_perkelurahan" target="_blank">Imunisasi Wilayah</a></li>
				<li><a href="?page=lap_registrasi_kb" target="_blank">KB Register</a></li>
				<?php if ($kota == "KABUPATEN BULUNGAN"){?>
				<li><a href="?page=lap_registrasi_kia_kukarkab" target="_blank">KIA Register</a></li>
				<?php }elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){ ?>
				<li><a href="?page=lap_registrasi_kia_kukarkab" target="_blank">KIA Register</a></li>
				<?php }else{ ?>
				<li><a href="?page=lap_registrasi_kia" target="_blank">KIA Register</a></li>
				<?php } ?>
				<li><a href="?page=lap_kia_anc" target="_blank">KIA ANC</a></li>
				<li><a href="?page=lap_registrasi_laboratorium" target="_blank">Lab Register</a></li>
				<li><a href="?page=lap_registrasi_laboratorium_bulan" target="_blank">Lab Bulanan</a></li>
				<?php if ($kota == "KABUPATEN BANDUNG" || $kota == "KOTA BANDUNG" || $kota == "KABUPATEN BULUNGAN"){?>
				<li><a href="?page=lap_registrasi_lansia" target="_blank">Lansia Register</a></li>
				<?php }elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){ ?>
				<li><a href="?page=lap_registrasi_lansia_kukarkab" target="_blank">Lansia Register</a></li>
				<?php } ?>
				<li><a href="?page=lap_registrasi_lansia_bulan" target="_blank">Lansia Bulanan</a></li>
				<li><a href="?page=lap_registrasi_lansia_bulan_wilayah" target="_blank">Lansia Wilayah</a></li>
				<li><a href="?page=lap_registrasi_lansia_bulan_umur_kukarkab" target="_blank">Lansia Klp.Umur</a></li>
				<li><a href="?page=lap_registrasi_lansia_bulan_kemandirian_kukarkab" target="_blank">Lansia Kemandirian</a></li>
				<li><a href="?page=lap_registrasi_lansia_bulan_intelegensia" target="_blank">Lansia Intelegensia</a></li>
				<li><a href="?page=lap_registrasi_lansia_bulan_kohort" target="_blank">Lansia Kohort</a></li>
				<li><a href="?page=lap_registrasi_mtbs" target="_blank">MTBS Register</a></li>
				<li><a href="?page=lap_mtbs_bulanan" target="_blank">MTBS Bulan F1</a></li>
				<li><a href="?page=lap_mtbs_bulanan_kukarkab" target="_blank">MTBS Bulan F2</a></li>
				<?php if ($kota == "KABUPATEN BANDUNG" || $kota == "KOTA BANDUNG" || $kota == "KABUPATEN BULUNGAN"){?>
				<li><a href="?page=lap_registrasi_umum" target="_blank">Umum Register</a></li>
				<?php }elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){ ?>
				<li><a href="?page=lap_registrasi_umum_kukarkab" target="_blank">Umum Register</a></li>
				<?php } ?>
			</ul>
		</li>	
		<li>
			<a href="#" class="dropdown-toggle">Farmasi<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<!--<li>
					<a href="?page=lap_farmasi_penerimaan_puskesmas_kukar">Penerimaan Tahun</a><b class="arrow"></b>
					<b class="arrow"></b>
				</li>-->
				<li>
					<a href="?page=lap_farmasi_kunjungan_resep">Kunjungan Resep</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_ketersediaan">Ketersediaan
					</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_apotik_stok_awal">Stok Awal (LO)</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_apotik_pemakaian_obat_harian">Pemakaian Obat</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_apotik_resep_cara_bayar">Cara Bayar</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_pio_hari">Pio Harian</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_rawatjalan_pio">Kefarmasian</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_pemakaianobat_terbanyak">Obat Terbanyak</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_psikotropika">Psikotropika</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_obat_generik">Obat Generik</a>
					<b class="arrow"></b>
				</li>
				<!--<li>
					<?php //if ($kota == "KABUPATEN BANDUNG"){?>
					<a href="?page=lap_farmasi_lplpo">LPLPO</a>
					<?php // } else {?>
					<a href="?page=lap_farmasi_lplpo_provinsi">LPLPO</a>
					<?php //} ?>
					<b class="arrow"></b>
				</li>-->
				<li><a href="?page=lap_farmasi_lplpo_manual">LPLPO</a><b class="arrow"></b></li>
				<li>
					<a href="?page=lap_farmasi_rko_bandungkab">RKO</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_persediaan">Persediaan Barang</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_gudangpuskesmas_stok_awal">Stok Awal</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=lap_farmasi_pordetail">POR</a>
					<b class="arrow"></b>
				</li>
				<li>
					<a href="?page=farmasi"><i class="fa fa-ok green"></i>Visual Kunj.Resep</a>
					<b class="arrow"></b>
				</li>
			</ul>	
		</li>
		<li>
			<a href="#" class="dropdown-toggle">Program<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_lb1_penyakit" target="_blank">LB1-Penyakit</a></li>
				<li><a href="?page=lap_lb1_penyakit_pelayanan" target="_blank">LB1-Pelayanan</a></li>
				<li><a href="?page=lap_lb1_penyakit_gakin" target="_blank">LB1-Gakin</a></li>
				<li><a href="?page=lap_lb1_penyakit_kasus" target="_blank">LB1-Kasus</a></li>
				<!--<li><a href="?page=lap_lb1_penyakit_kelurahan">LB1 Penyakit</a></li>-->
				<li><a href="?page=lap_P2M_wabah" target="_blank">Wabah-W2</a></li>
				<li><a href="?page=lap_P2M_DBD_Harian" target="_blank">DBD Register</a></li>
				<?php
				if($kota == "KABUPATEN BANDUNG" || $kota == "KOTA BANDUNG"){
				?>
					<li><a href="?page=lap_P2M_Diare_Harian" target="_blank">Diare Register</a></li>
					<li><a href="?page=lap_P2M_Diare_Bulanan" target="_blank">Diare Bulanan</a></li>
				<?php
				}elseif($kota == "KABUPATEN BULUNGAN"){
				?>
					<li><a href="?page=lap_P2M_Diare_Harian" target="_blank">Diare Register</a></li>
					<li><a href="?page=lap_P2M_Diare_Bulanan_Bulungan" target="_blank">Diare Bulanan</a></li>
				<?php
				}elseif($kota == "KABUPATEN KUTAI KARTANEGARA"){
				?>
					<li><a href="?page=lap_P2M_Diare_Harian_Kukarkab" target="_blank">Diare Register</a></li>
					<li><a href="?page=lap_P2M_Diare_Bulanan_Kukarkab" target="_blank">Diare Bulanan</a></li>
				<?php
				}
				?>
				
				<?php if($kota == "KABUPATEN KUTAI KARTANEGARA"){?>
				<li><a href="?page=lap_P2M_Ispa_Harian_Kukarkab" target="_blank">Ispa Register</a></li>
				<li><a href="?page=lap_P2M_Ispa_Bulanan_Kukarkab" target="_blank">Ispa Bulanan</a></li>
				<?php }else{ ?>
				<li><a href="?page=lap_P2M_Ispa_Harian" target="_blank">Ispa Register</a></li>
				<li><a href="?page=lap_P2M_Ispa_Bulanan" target="_blank">Ispa Bulanan</a></li>
				<?php } ?>
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
				<li><a href="?page=lap_P2M_jiwa" target="_blank">Kesehatan Jiwa</a></li>
				<li><a href="?page=lap_P2M_leptospirosis" target="_blank">Leptospirosis</a></li>
				<li><a href="?page=lap_P2M_disabilitas" target="_blank">Disabilitas</a></li>
				<li><a href="?page=lap_P2M_disabilitas_alamat" target="_blank">Disabilitas Detail</a></li>
				<li><a href="?page=lap_P2M_surveilans" target="_blank">Surveilans-STP</a></li>
				<?php if($kota == "KABUPATEN BULUNGAN"){?>
				<li><a href="?page=lap_P2M_penyakit_terbanyak_bulungankab" target="_blank">Penyakit Terbanyak</a></li>
				<?php } else { ?>
				<li><a href="?page=lap_P2M_penyakit_terbanyak" target="_blank">Penyakit Terbanyak</a></li>
				<?php }?>
				<li><a href="?page=lap_P2M_penyakit_terbanyak_kunjungan" target="_blank">Penyakit Kunjungan</a></li>
				<li><a href="?page=lap_P2M_penyakit_terbanyak_jaminan" target="_blank">Penyakit Jaminan</a></li>
				<li><a href="?page=lap_P2M_penyakit_terbanyak_rujukan" target="_blank">Penyakit Rujukan</a></li>
				<li><a href="?page=lap_P2M_penyakit_terbanyak_pemulkes" target="_blank">Pemulkes</a></li>
				<li><a href="?page=lap_P2M_penyakit" target="_blank">Tracking Diagnosa</a></li>
				<li><a href="?page=lap_P2M_tindakan" target="_blank">Tindakan Pasien</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">Yankes<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_loket_kecelakaan_lalulintas" target="_blank">Kecelakaan Lu.Lintas</a></li>
				<li><a href="?page=lap_P2M_penyakit_terbanyak" target="_blank">Penyakit Terbanyak</a></li>
				<li><a href="?page=lap_loket_carabayar_rujukan" target="_blank">Rwt.Jalan & Rujukan</a></li>
				<li><a href="?page=lap_loket_rawatinap" target="_blank">Rwt.Inap & Rujukan</a></li>
				
			</ul>
		</li>	
		<li>
			<a href="#" class="dropdown-toggle">Kepegawaian<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_loket_tracking_pegawai" target="_blank">Kinerja Pegawai</a></li>
				<li><a href="?page=lap_loket_kegiatan_harian" target="_blank">Kegiatan Harian</a></li>
				<li><a href="?page=lap_loket_tracking_pegawai_rujukan" target="_blank">Rujukan Per-Pegawai</a></li>
			</ul>
		</li>
	</ul>
</li>
<?php 
	}
	if (in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas ) || in_array("PENGUNJUNG", $otoritas )){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-cog faicon"></i><span class="menu-text">Master Data</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<?php if($kota == "KABUPATEN BULUNGAN"){ ?>
		<li><a href="?page=master_antrian_pasien_bulungan">Antrian Pasien</a></li>
		<?php } ?>
		<li><a href="?page=master_antrian_pasien">Antrian Pasien</a></li>
		<li><a href="?page=master_daftaronline">Daftar Online</a></li>
		<li><a href="?page=master_asuransi">Asuransi</a></li>
		<!--<li><a href="?page=master_puskesmas_data_dasar">Data Dasar</a></li>-->
		<li><a href="?page=master_aset">Data Aset</a></li>
		<li><a href="?page=master_obat_fornas">Data Fornas</a></li>
		<li><a href="?page=master_obat_jkn">Data JKN</a></li>
		<li><a href="?page=master_obat">Data LPLPO</a></li>
		<li><a href="?page=master_diagnosa">Diagnosa</a></li>
		<li><a href="?page=master_diagnosa_nonspesialis">Diagnosa NonSpesialis</a></li>
		<li><a href="?page=master_kartupasien">Kartu Pasien</a></li>
		<li><a href="?page=master_nomerrm">Nomor Rekam Medis</a></li>
		<li><a href="?page=master_pegawai_garutkab">Pegawai</a></li>
		<li><a href="?page=master_pegawai_bpjs">Pegawai HFIS</a></li>
		<li><a href="?page=master_pendidikan">Pendidikan</a></li>
		<li><a href="?page=master_pekerjaan">Pekerjaan</a></li>
		<li><a href="?page=master_puskesmas">Puskesmas</a></li>
		<li><a href="?page=master_pcare">PCare</a></li>
		<li><a href="?page=master_pcare_peserta">PCare Peserta</a></li>
		<?php if(in_array("PROGRAMMER", $otoritas)){ ?>
		<li><a href="?page=master_slide_banner">Slide Banner</a></li>
		<?php } ?>
		<li><a href="?page=master_tindakan">Tindakan</a></li>
	</ul>
</li>
<?php
	}
	if($kota != "KABUPATEN BOGOR"){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-low-vision faicon"></i><span class="menu-text">Informasi</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<?php if (in_array("PROGRAMMER", $otoritas)){ ?>
		<li><a href="?page=adm_antrian">Antrian</a></li>
		<li><a href="?page=adm_pendampingan">Jadwal ke Puskesmas</a></li>
		<?php } ?>
		<li><a href="?page=adm_konsultasi">Konsultasi</a></li>
		<li><a href="?page=kuisioner">Kuisioner</a></li>
		<li><a href="?page=adm_update_simpus">Update Simpus</a></li>
	</ul>
</li>
<?php 
	} 
	if (in_array("PROGRAMMER", $otoritas)){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-cloud faicon" aria-hidden="true"></i><span class="menu-text">Integrasi Data</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li>
			<a href="#" class="dropdown-toggle">E-Logistic Kemkes<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=elog_indikator_kirim">Kirim Indikator</a></li>
				<li><a href="?page=elog_indikator_obat">Lihat Indikator</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">E-SKM<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=lap_skm_responden">Rekap Responden</a></li>
				<li><a href="?page=lap_skm_layanan">Rekap Layanan</a></li>
			</ul>
		</li>
	</ul>
</li>
<?php 
	}
	if ($kota == "KABUPATEN KUTAI KARTANEGARA" || $kota == "KABUPATEN BANDUNG"){
?>
<li>
	<a href="?page=backup"> <i class="fa fa-database faicon"></i><span class="menu-text">Backup Data</span> </a>
</li>
<?php } ?>
<li class="logmobile">
	<a href="?page=update_profile"><i class="fa fa-user"></i> Data User</a>
</li>
<li class="logmobile">
	<a href="logout.php">
		<i class="fa fa-power-off"></i> Log Out</span>
	</a>
</li>