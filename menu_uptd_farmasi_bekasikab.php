<?php 
	$kota = $_SESSION['kota'];
	$username = $_SESSION['username'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>
<style>
	.menu-text{
		margin-left: 5px;
	}
	.sub-menu-text{
		font-size: 13px;
	}	
	.faicon{
		align: center;
		font-size: 20px;
		width: 20px;
		height: 20px;
		text-align: center;
	}		
</style>
<?php if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){ ?>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-desktop faicon"></i>
		<span class="menu-text">Dashboard</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=dashboard">Utama</a></li>
	</ul>
</li>
<?php } ?>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-desktop faicon"></i>
		<span class="menu-text">Logistik</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li>
			<?php if($kota == 'KABUPATEN BANDUNG'){ ?>
			<a href="?page=lap_gfk_ketersediaan_barang_bandungkab_group">
			<?php }elseif($kota == 'KABUPATEN BOGOR'){ ?>
			<a href="?page=lap_gfk_ketersediaan_barang_bogorkab_group">
			<?php }elseif($kota == 'KABUPATEN BEKASI'){ ?>
			<a href="?page=lap_gfk_ketersediaan_barang_bekasikab_group">	
			<?php } ?>Obat</a>
			
			<?php if($kota == 'KABUPATEN BANDUNG'){ ?>
			<a href="#">
			<?php }elseif($kota == 'KABUPATEN BOGOR'){ ?>
			<a href="?page=lap_gfk_ketersediaan_vaksin_bogorkab_group">
			<?php }elseif($kota == 'KABUPATEN BEKASI'){ ?>
			<a href="#">	
			<?php } ?>Vaksin</a>
		</li>
	</ul>
</li>
<?php
	if($kota == 'KABUPATEN BANDUNG' || $kota == 'KABUPATEN BOGOR'){
		if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){
?>	
<li class="">
	<a href="?page=flash_news">
		<i class="fa fa-image faicon"></i>
		<span class="menu-text">Berita Update</span>
	</a>
</li>
<?php 
		}
	}
	if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){
?>	
<li class="">
	<a href="#" class="dropdown-toggle">
	<i class="fa fa-cloud faicon" aria-hidden="true"></i>
		<span class="menu-text">E-Logistic Kemkes</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<!--<li>
			<a href="#" class="dropdown-toggle"><i class="glyphicon glyphicon-ok blue"></i>BPJS<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
		</li>-->
		<!--<li>
			<a href="#" class="dropdown-toggle"><i class="glyphicon glyphicon-ok blue"></i>Disdukcapil<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
		</li>-->
		<li>
			<a href="#" class="dropdown-toggle">Indikator Obat<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=elog_indikator_kirim">Kirim Indikator</a></li>
				<li><a href="?page=elog_indikator_obat">Lihat Indikator</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">Ketersediaan Obat<b class="arrow fa fa-angle-down"></b></a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li><a href="?page=elog_ketersediaan_kirim">Kirim Ketersediaan</a></li>
				<li><a href="?page=elog_ketersediaan_obat">Lihat Ketersediaan</a></li>
			</ul>
		</li>
	</ul>
</li>
<li class="">
	<a href="#" class="dropdown-toggle">
	<i class="fa fa-cloud faicon" aria-hidden="true"></i>
		<span class="menu-text">E-Logistic Prov</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li>
			<?php if($kota=="KABUPATEN BOGOR"){?>	
				<a href="?page=elog_provinsi_ketersediaan_obat"><span class="sub-menu-text">Ketersediaan Obat</span></a>
			<?php }elseif($kota=="KABUPATEN BEKASI"){ ?>
				<a href="?page=elog_provinsi_ketersediaan_obat_bekasikab"><span class="sub-menu-text">Ketersediaan Obat</span></a>
			<?php } ?>
		</li>
	</ul>
</li>
<?php 
	}
	if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){	
?>
<li class="">
	<a href="?page=gudang_besar_gemacermat">
		<i class="fa fa-image faicon"></i>
		<span class="menu-text">Gema Cermat </span>
	</a>
	<b class="arrow"></b>
</li>
<?php
	} 
?>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-plus-circle faicon" aria-hidden="true"></i>
		<span class="menu-text">Gudang Besar</span>
		<span class="arrow fa fa-angle-down"></span>
	</a>
	<ul class="submenu">
		<li>
			<?php
				$stok_gb = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD' AND `Stok` > '0'"));
			?>
			<a href="?page=gudang_besar_stok">
				<span class="sub-menu-text">Stok Barang 
					<span class="badge" style="background:red;"><?php echo $stok_gb;?></span>
				</span>
			</a>
		</li>
		<?php if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){ ?>
		<li>
			<a href="?page=gudang_besar_penerimaan">Penerimaan Barang</a>
		</li>
		<?php 
			}
		if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){ ?>
		<li><a href="?page=gudang_besar_pengeluaran">Pengeluaran Barang</a></li>
		<!--<li><a href="?page=gudang_besar_mutasi">Mutasi Barang</a></li>-->
		<li><a href="?page=gudang_besar_retur">Retur/Hibah Pkm</a></li>
		<?php if($kota == "KABUPATEN BANDUNG"){?>
		<li><a href="?page=gudang_besar_opnam">Stok Opname</a></li>
		<?php }else{ ?>		
		<li><a href="?page=gudang_besar_opnam">Stok Opname</a></li>		
		<?php 
			}
		} 
		?>
	</ul>
</li>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-plus-circle faicon" aria-hidden="true"></i>
		<span class="menu-text">Gudang Vaksin</span>
		<span class="arrow fa fa-angle-down"></span>
	</a>
	<ul class="submenu">
		<li>
			<a href="?page=gudang_vaksin_stok"><span class="sub-menu-text">Stok Barang</span></a>
		</li>
		<?php if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){ ?>
		<li>
			<a href="?page=gudang_vaksin_penerimaan">Penerimaan Barang</a>
		</li>
		<li>
			<a href="?page=gudang_vaksin_pengeluaran">Pengeluaran Barang</a>
		</li>
		<li>
			<a href="?page=lap_gfk_kartustok_vaksin">Kartu Stok</span></a>
		</li>
		<?php if($kota == 'KABUPATEN BEKASI'){ ?>
			<li> <a href="?page=gudang_vaksin_opnam">Stok Opname</span></a> </li>
		<li><a href="?page=lap_farmasi_vaksin_permohonan">Usulan Vaksin</span></a></li>
		<?php } ?>
		<?php if($kota == 'KABUPATEN BANDUNG'){ ?>
		<li> <a href="?page=gudang_vaksin_opnam">Stok Opname</span></a> </li>
		<li><a href="?page=uptd_gudang_sisa_aset_vaksin_bandungkab">Lap.Ketersediaan</span></a></li>
		<?php }elseif($kota == 'KABUPATEN BOGOR'){ ?>
		<li><a href="?page=uptd_gudang_sisa_aset_vaksin_bogorkab">Lap.Ketersediaan</span></a></li>
		<?php }elseif($kota == 'KABUPATEN BEKASI'){ ?>
		<li><a href="?page=uptd_gudang_sisa_aset_vaksin_bekasikab">Lap.Ketersediaan</span></a></li>
		<?php } ?>
		<li>
			<a href="?page=lap_farmasi_vaksin_distribusi">Lap.Distribusi</span></a>
		</li>
		<li>
			<a href="?page=lap_farmasi_vaksin_distribusi_unit">Lap.Distribusi Unit</span></a>
		</li>
		<li>
			<a href="?page=uptd_gudang_vaksin_sisa_aset_triwulan_bogorkab"><span class="sub-menu-text">Lap.SO (Triwulan)</span></a>
		</li>
		<?php } ?>
	</ul>
</li>
<?php
	if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){
?>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-plus-circle faicon" aria-hidden="true"></i>
		<span class="menu-text">Gudang Karantina</span>
		<span class="arrow fa fa-angle-down"></span>
	</a>
	<ul class="submenu">
		<li><a href="?page=gudang_karantina_stok"><span class="sub-menu-text">Data Karantina <span class="badge" style="background:red;"></span></span></a></li>
		<li><a href="?page=gudang_pemusnahan_stok"><span class="sub-menu-text">Data Pemusnahan <span class="badge" style="background:red;"></span></span></a></li>
	</ul>
</li>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-file-text faicon" aria-hidden="true"></i>
		<span class="menu-text">Laporan</span>
		<span class="arrow fa fa-angle-down"></span>
	</a>
	<ul class="submenu">
		<li><a href="?page=lap_gfk_kartustok"><span class="sub-menu-text">Kartu Stok (Batch)</span></a></li>
		<li><a href="?page=uptd_gudang_sisa_aset_bekasikab"><span class="sub-menu-text">Ketersediaan</span></a></li>
		<li><a href="?page=lap_farmasi_pemakaian_dinas_bekasi"><span class="sub-menu-text">Pekamaian Rata</span></a></li>
		<li><a href="?page=uptd_gudang_sisa_aset_keuangan_bekasikab"><span class="sub-menu-text">Keuangan</span></a></li>
	</ul>
</li>

<?php 
	}
	if($username != "KADIS" AND $username != "SEKDIS" AND $username != "KABID" AND $username != "DINAS KESEHATAN" AND $username != "IMUNISASI"){
?>
<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-cog faicon" aria-hidden="true"></i>
		<span class="menu-text">Master</span>
		<span class="arrow fa fa-angle-down"></span>
	</a>
	<ul class="submenu">
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
</li>
<?php } ?>
<?php
	if (in_array("PROGRAMMER", $otoritas)){
?>
<li>
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-low-vision faicon"></i><span class="menu-text">Informasi</span>
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<ul class="submenu">
		<li><a href="?page=adm_update_simpus">Update Aplikasi</a></li>
	</ul>
</li>
<?php 
	}
?>
<li class="logmobile">
	<a href="logout.php">
		<i class="fa fa-power-off faicon"></i>
		<span class="menu-text"> Log Out</span>
	</a>
</li>



		