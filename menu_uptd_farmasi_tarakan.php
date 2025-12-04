<?php 
	$kota = $_SESSION['kota'];
	$username = $_SESSION['username'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<li class="nav-item active">
   <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
		<i class="icon-home"></i>
		<p>Dashboard</p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="dashboard">
        <ul class="nav nav-collapse">
            <li><a href="?page=dashboard"><span class="sub-item">Utama</span></a></li>
        </ul>
    </div>    
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#elogistik">
		<i class="fa fa-cloud faicon" aria-hidden="true"></i><span class="menu-text">Logistik</span>
		<span class="caret"></span>
	</a>
    <div class="collapse" id="elogistik">
        <ul class="nav nav-collapse">
            <li><a href="?page=lap_gfk_ketersediaan_barang_bekasikab_group"><span class="sub-item">Obat</span></a></li>
            <li><a href="?page=lap_gfk_ketersediaan_vaksin_bogorkab_group"><span class="sub-item">Vaksin</span></a></li>
        </ul>
    </div>
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#elogkemkes">
		<i class="icon-grid"></i><span class="menu-text">E-Log Kemkes</span>
		<span class="caret"></span>
	</a>
    <div class="collapse" id="elogkemkes">
        <ul class="nav nav-collapse">
            <li>
                <a data-toggle="collapse" href="#indikatorobat">
					<span class="sub-item">Indikator Obat</span>
					<span class="caret"></span>
				</a>
                <div class="collapse" id="indikatorobat">
					<ul class="nav nav-collapse">
                        <li><a href="?page=elog_indikator_kirim">Kirim Indikator</a></li>
                        <li><a href="?page=elog_indikator_obat">Lihat Indikator</a></li>
                    </ul>
                </div>    
            </li>
            <li>
                <a data-toggle="collapse" href="#ketersediaanobat">
					<span class="sub-item">Indikator Obat</span>
					<span class="caret"></span>
				</a>
                <div class="collapse" id="ketersediaanobat">
					<ul class="nav nav-collapse">
                        <li><a href="?page=elog_ketersediaan_kirim">Kirim Ketersediaan</a></li>
                        <li><a href="?page=elog_ketersediaan_obat">Lihat Ketersediaan</a></li>
                    </ul>
                </div>    
            </li>
        </ul>
     </div>
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#gudangbesar">
		<i class="icon-grid"></i><span class="menu-text">Gudang Besar</span>
		<span class="caret"></span>
	</a>
    <div class="collapse" id="gudangbesar">
        <ul class="nav nav-collapse">
            <li>
                <?php
                    $stok_gb = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD' AND `Stok` > '0'"));
                ?>
                <a href="?page=gudang_besar_stok">
                    <span class="sub-menu-text"><span class="sub-item">Stok Barang</span> 
                        <span class="badge" style="background:red;"><?php echo $stok_gb;?></span>
                    </span>
                </a>
            </li>
            <li><a href="?page=gudang_besar_penerimaan"><span class="sub-item">Penerimaan Barang</span></a></li>
            <li><a href="?page=gudang_besar_pengeluaran"><span class="sub-item">Pengeluaran Barang</span></a></li>
            <li><a href="?page=gudang_besar_retur"><span class="sub-item">Retur/Hibah Pkm</span></a></li>
            <li><a href="?page=gudang_besar_opnam"><span class="sub-item">Stok Opname</span></a></li>	
        </ul>
    </div> 
</li>
<li class="nav-item">
	 <a data-toggle="collapse" href="#gudangvaksin">
		<i class="icon-grid"></i><span class="menu-text">Gudang Vaksin</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="gudangvaksin">
        <ul class="nav nav-collapse">
            <li><a href="?page=gudang_vaksin_stok"><span class="sub-item">Stok Barang</span></a></li>
            <li><a href="?page=gudang_vaksin_penerimaan"><span class="sub-item">Penerimaan Barang</span></a></li>
            <li><a href="?page=gudang_vaksin_pengeluaran"><span class="sub-item">Pengeluaran Barang</span></a></li>
            <li><a href="?page=lap_gfk_kartustok_vaksin"><span class="sub-item">Kartu Stok</span></a></li>
            <li> <a href="?page=gudang_vaksin_opnam"><span class="sub-item">Stok Opname</span></a></li>
            <li><a href="?page=lap_farmasi_vaksin_permohonan"><span class="sub-item">Usulan Vaksin</span></a></li>
            <li><a href="?page=uptd_gudang_sisa_aset_vaksin_bekasikab"><span class="sub-item">Lap.Ketersediaan</span></a></li>
            <li><a href="?page=lap_farmasi_vaksin_distribusi"><span class="sub-item">Lap.Distribusi</span></a></li>
            <li><a href="?page=lap_farmasi_vaksin_distribusi_unit"><span class="sub-item">Lap.Distribusi Unit</span></a></li>
            <li><a href="?page=uptd_gudang_vaksin_sisa_aset_triwulan_bogorkab"><span class="sub-item">Lap.SO (Triwulan)</span></a></li>
        </ul>
    </div>
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#gudangkarantina">
		<i class="icon-grid"></i><span class="menu-text">Gudang Karantina</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="gudangkarantina">
        <ul class="nav nav-collapse">
            <li><a href="?page=gudang_karantina_stok"><span class="sub-item">Data Barang <span class="badge" style="background:red;"></span></span></a></li>
            <li><a href="?page=gudang_karantina"><span class="sub-item">Karantina Barang</span></a></li>
        </ul>
    </div>    
</li>
<li class="nav-item">
	<a data-toggle="collapse" href="#laporan">
		<i class="icon-grid"></i><span class="menu-text">Lap.Gudang</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="laporan">
        <ul class="nav nav-collapse">
            <li><a href="?page=lap_gfk_kartustok"><span class="sub-item">Kartu Stok (Batch)</span></a></li>
            <li><a href="?page=lap_gfk_kartustok_group_bogorkab"><span class="sub-item">Kartu Stok (Group)</span></a></li>
            <li><a href="?page=lap_gfk_ketersediaan_barang_bogorkab"><span class="sub-item">Ketersediaan Brg</span></a></li>
            <li><a href="?page=lap_gfk_distribusi_unit_sumberanggaran_bogorkab"><span class="sub-item">Distribusi Unit Detail</span></a></li>
            <li><a href="?page=lap_gfk_distribusi_barang_bogorkab"><span class="sub-item">Distribusi Item Brg</span></a></li>
            <li><a href="?page=lap_gfk_keuangan_distribusi_barang"><span class="sub-item">Distribusi Keuangan</span></a></li>
            <li><a href="?page=lap_gfk_penerimaan_barang_bogorkab"><span class="sub-item">Penerimaan Brg</span></a></li>	
            <li><a href="?page=uptd_gudang_sisa_aset_triwulan_bogorkab"><span class="sub-item">SO Triwulan</span></a></li>
            <li><a href="?page=lap_farmasi_psikotropika_bogorkab_dinkes"><span class="sub-item">Napza</span></a></li>
            <li><a href="?page=lap_farmasi_rko_bogorkab_dinkes"><span class="sub-item">RKO</span></a></li>
        </ul>
    </div>
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#master">
		<i class="icon-grid"></i><span class="menu-text">Master</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="master">
        <ul class="nav nav-collapse">
            <li><a href="?page=master_obat_fornas"><span class="sub-item">Data Fornas</span></a></li>
            <li><a href="?page=master_obat_jkn"><span class="sub-item">Data JKN</span></a></li>
            <li><a href="?page=master_obat"><span class="sub-item">Data LPLPO</span></a></li>
            <li><a href="?page=master_obat_indikator"><span class="sub-item">Data Obat Indikator</span></a></li>
            <li><a href="?page=master_obat_program"><span class="sub-item">Data Program</span></a></li>
            <li><a href="?page=master_vaksin"><span class="sub-item">Data Vaksin</span></a></li>
            <li><a href="?page=master_pegawai"><span class="sub-item">Data Pegawai</span></a></li>
            <li><a href="?page=master_puskesmas"><span class="sub-item">Data Puskesmas</span></a></li>
            <li><a href="?page=master_pemberi_lplpo"><span class="sub-item">Data Pemberi</span></a></li>
            <li><a href="?page=master_penerima_lplpo"><span class="sub-item">Data Penerima</span></a></li>
            <li><a href="?page=master_supplier"><span class="sub-item">Data Supplier</span></a></li>
            <li><a href="?page=master_rumahsakit"><span class="sub-item">Data Rumah Sakit</span></a></li>
        </ul>
    </div>    
</li>

<?php
	if (in_array("PROGRAMMER", $otoritas)){
?>
<li class="nav-item">
	<a data-toggle="collapse" href="#informasi">
		<i class="icon-grid"></i><span class="menu-text">Informasi</span>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="informasi">
        <ul class="nav nav-collapse">
		    <li><a href="?page=adm_update_simpus"><span class="sub-item">Update Aplikasi</span></a></li>
	    </ul>
    </div>    
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



		