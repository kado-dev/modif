<?php
	// $idnf = $_GET['idnf'];
	$nopembukuan = $_GET['nf'];
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$key = $_GET['key'];
	
	// tbstok
	$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));

	// sort by
	if($_GET['sort'] == 'ASC'){
		$sorts = 'DESC';
	}else{
		$sorts = 'ASC';
	}
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=lap_gfk_kartustok_vaksin&key=<?php echo $key;?>" class="backform" style="margin-top: 0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DETAIL KARTU STOK VAKSIN</b></h3>
			<div class="formbg">
				<table width="100%">
					<tr>
						<td width="10%">Kode Barang</td>
						<td width="2%">:</td>
						<td width="88%"><?php echo $kodebarang;?></td>
					</tr>
					<tr>
						<td>Nama Barang</td>
						<td>:</td>
						<td><b><?php echo $dtbrg['NamaBarang'];?></b></td>
					</tr>
					<tr>
						<td>No.Batch</td>
						<td>:</td>
						<td><b><?php echo $nobatch;?></b></td>
					</tr>
					<tr>
						<td>Expire</td>
						<td>:</td>
						<td><?php echo $dtbrg['Expire'];?></td>
					</tr>
					<tr>
						<td>Sumber</td>
						<td>:</td>
						<td><?php echo $dtbrg['SumberAnggaran'];?></td>
					</tr>
					<tr>
						<td>Program</td>
						<td>:</td>
						<td><?php echo $dtbrg['NamaProgram'];?></td>
					</tr>
				</table>	
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table-judul-laporan-dark" width="100%">
			<thead>
				<tr>
					<th width="4%">NO.</th>
					<th width="10%">TANGGAL</th>
					<th width="20%"><a href="?page=lap_gfk_kartustok_vaksin_lihat&nf=<?php echo $nopembukuan;?>&kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&orderby=NoFaktur&sort=<?php echo $sorts;?>">NO.FAKTUR <?php echo iconsort("NoFaktur",$sorts);?></th>
					<th width="30%">KETERANGAN</th>
					<th>STOK AWAL</th>
					<th>PENERIMAAN</th>
					<th>PENGELUARAN</th>
					<th>SISA STOK</th>
				</tr>
			</thead>
			<tbody>
				<?php	
				$no = 0;				
				// stok awal, ini ngambil sisa stok yang bulan des 2019
				$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_vaksin` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
				$query_stokawal = mysqli_query($koneksi, $str_stokawal);
				while($dt_stokawal = mysqli_fetch_assoc($query_stokawal)){
					$no = $no + 1;
					$faktur_terima = $dt_stokawal['NomorPembukuan'];
					$jml_stokawal = $dt_stokawal['Stok'];
					$tanggal_stokawal = $dt_stokawal['Bulan']." ".$dt_stokawal['Tahun'];
					$semua_jml_terima = 0;
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $tanggal_stokawal;?></td>
						<td align="center">-</td>
						<td align="left"><?php echo "SO BULAN ".$tanggal_stokawal;?></td>
						<td align="right"><?php echo number_format($jml_stokawal, 0, ".", ".");?></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
					</tr>	
				<?php
					}
											
				// penerimaan
				$str_terima = "SELECT * FROM `tbgfk_vaksin_penerimaandetail` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$nopembukuan'";
				$query_terima = mysqli_query($koneksi, $str_terima);
				while($dt_terima = mysqli_fetch_assoc($query_terima)){
					$no = $no + 1;
					$faktur_terima = $dt_terima['NomorPembukuan'];
					$jml_terima = $dt_terima['Jumlah'];
					$stokterima[] = $jml_terima;
					$ttl_terima = array_sum($stokterima);
					
					// detail penerimaan
					$dt_penerimaan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan`='$faktur_terima'"));
					$tanggal_keluar  = $dt_penerimaan['TanggalPenerimaan'];
					$keterangan_terima = $dt_penerimaan['KodeSupplier'];
					
					// ref_pabrik
					$dtpabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dt_penerimaan[KodeSupplier]'"));
					$semua_jml_terima = $semua_jml_terima + $jml_terima;
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $tanggal_keluar;?></td>
						<td align="center"><?php echo $faktur_terima;?></td>
						<td align="left"><?php echo $dtpabrik['nama_prod_obat'];?></td>
						<td align="center"></td>
						<td align="right"><?php echo number_format($jml_terima, 0, ".", ".");?></td>
						<td align="center"></td>
						<td align="right"><?php echo number_format($semua_jml_terima, 0, ".", ".");?></td>
					</tr>	
					
				<?php
					}
					
				// detail pengeluaran
				$no = 0;
				
				if($_GET['orderby'] == '' or $_GET['sort'] == ''){
					$orderbys = "ORDER BY `NoFaktur` ASC";
				}else{
					$orderbys = "ORDER BY ".$_GET['orderby']." ".$_GET['sort'];
				}		
				
				$str_keluar = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail`WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nopembukuan'";
				$str_keluar2 = $str_keluar." ".$orderbys;
				// echo $str_keluar2;
				$sisa_stoks = $semua_jml_terima + $jml_stokawal;			
				$query_keluar = mysqli_query($koneksi, $str_keluar2);
				while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
					$no = $no + 1;
					$nofaktur = $dt_keluar['NoFaktur'];
					$jml_keluar = $dt_keluar['Jumlah'];			
					$stokkeluar[] = $jml_keluar;
					$ttl_keluar = array_sum($stokkeluar);
					$sisa_stoks = $sisa_stoks - $jml_keluar;
					
					// pengeluaran
					$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nofaktur'"));
					$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];
					$faktur_keluar  = $dt_distribusi['NoFaktur'];
					$keterangan_keluar = $dt_distribusi['Penerima'];
					
					// pengeluaran gudang besar, ini untuk kabupaten bandung karena dulu gudang vaksin masih menyatu dengan gudang besar
					$dtgudangbesar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur'"));
					$tanggal_keluar  = $dtgudangbesar['TanggalPengeluaran'];
					$keterangan_keluar = $dtgudangbesar['Penerima'];
					
					if ($faktur_keluar != ''){
						$faktur_keluar  = $dt_distribusi['NoFaktur'];
						$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];
						$keterangan_keluar = $dt_distribusi['Penerima'];
					}else{
						$faktur_keluar = $dt_keluar['NoFaktur'];
						$tanggal_keluar  = $dtgudangbesar['TanggalPengeluaran'];
						$keterangan_keluar = $dtgudangbesar['Penerima'];
					}		
				?>	
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $tanggal_keluar;?></td>
						<td align="center"><?php echo $faktur_keluar;?></td>
						<td align="left"><?php echo $keterangan_keluar;?></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="right"><?php echo number_format($jml_keluar, 0, ".", ".");?></td>
						<td align="right"><?php echo number_format($sisa_stoks, 0, ".", ".");?></td>
					</tr>
				<?php
					}
					
				// karantina
				$no = 0;
				$str_karantina = "SELECT SUM(a.`Jumlah`) AS Jumlah , b.TanggalKarantina, b.NoFaktur, b.StatusKarantina FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'";
				$query_karantina = mysqli_query($koneksi, $str_karantina);
				while($dt_karantina = mysqli_fetch_assoc($query_karantina)){
					$no = $no + 1;
					$tanggal_karantina = $dt_karantina['TanggalKarantina'];	
					$faktur_karantina = $dt_karantina['NoFaktur'];	
					$keterangan_karantina = "GUDANG KARANTINA - ".strtoupper($dt_karantina['StatusKarantina']);	
					$jml_karantina = $dt_karantina['Jumlah'];	
					$stokkarantina[] = $jml_karantina;
					$ttl_karantina = array_sum($stokkarantina);
					$sisa_stoks = $sisa_stoks - $jml_karantina;
					
					if($dt_karantina['Jumlah'] != 0){
				?>	
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $tanggal_karantina;?></td>
						<td align="center"><?php echo $faktur_karantina;?></td>
						<td align="left"><?php echo $keterangan_karantina;?></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="right"><?php echo number_format($jml_karantina, 0, ".", ".");?></td>
						<td align="right"><?php echo number_format($sisa_stoks, 0, ".", ".");?></td>
					</tr>
				<?php
					}
					}
				
					$sisastok = $jml_stokawal + $ttl_terima - $ttl_keluar - $ttl_karantina;
				?>
			</tbody>
		</table>
		<table class="table table-judul-form"  width="100%">
			<tbody>
				<tr style="background: #fff4b7; font-weight: bold;">
					<td colspan="6">JUMLAH PENGELUARAN</td>
					<td align="right"><?php echo number_format($ttl_keluar + $ttl_karantina, 0, ".", ".");?></td>
				</tr>
				<tr style="background: #ffce8e; font-weight: bold;">
					<td colspan="6">SISA STOK</td>
					<td align="right"><?php  echo number_format($sisastok, 0, ".", ".");?></td>
				</tr>
			</tbody>
		</table><hr/>
		<div class="row">
			<div class="col-sm-6">
				<a href="lap_gfk_kartustok_vaksin_lihat_print.php?nf=<?php echo $nopembukuan;?>&kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>&orderby=<?php echo $_GET['orderby'];?>&sort=<?php echo $_GET['sort'];?>" class="btnsimpan">PRINT</a>
			</div>
			<div class="col-sm-6">
				<a href="lap_gfk_kartustok_vaksin_lihat_excel.php?nf=<?php echo $nopembukuan;?>&kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>&orderby=<?php echo $_GET['orderby'];?>&sort=<?php echo $_GET['sort'];?>" class="btnsimpan" style="background: #5abdd6;">EXCEL</a>
			</div>
		</div>
	</div>
</div>
<?php
function iconsort($nmkolom,$sorttype){
	$sorticon = "<i class='fa fa-sort'></i>";
	$downs = "<i class='fa fa-sort-down'></i>";
	$ups = "<i class='fa fa-sort-up'></i>";
	if(isset($_GET["sort"])){
		if($nmkolom == $_GET['orderby']){
			if($sorttype == 'ASC'){
				$h = $downs;
			}else{
				$h = $ups;
			}
		}else{
			$h = $sorticon;
		}
	}else{
		$h = $sorticon;
	}
	return $h;
}
?>


