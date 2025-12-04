<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
	$bulan = $_GET['bl'];
	$tahun = $_GET['th'];	
	$bulanini = date('m');
		
	if($bulan == "01"){
		$bulanlalu = "12";
		// $tahun = $tahun - 1;
		$tahun = $tahun;
	}else{
		$bulanlalu = $bulan - 1;
		$tahun = $tahun;
	}
	
	if(strlen($bulanlalu) == 1){
		$bulanlalu = '0'.$bulanlalu;
	}
	
	if(strlen($bulan) == 1){
		$bulan = '0'.$bulan;
	}
		
	$bln = $_POST['bulan'];		
	$thn = $_POST['tahun'];		
	$kodeobat = $_POST['kode']; 
	$nobatch = $_POST['batch']; 
	$jml = $_POST['isi']; 
	$keterangan = $_POST['ket'];
	$nofk = $_POST['nofk'];
	if(strlen($bln) == 1){
		$bln = '0'.$bln;
	}
		
	if($_GET['sts'] == 'simpan'){
		// update tbstokbulanandinas, jangan pakai nomer faktur hilangkan aja
		mysqli_query($koneksi,"UPDATE `tbstokbulanandinas` SET `Stok`='$jml', `Selisih` = (StokAwalSistem - $jml) WHERE `Bulan`='$bln' AND `Tahun`='$thn' AND `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'");
		
		// update tbgfkstok
		// if($bln == $bulanini){
			mysqli_query($koneksi, "UPDATE `tbgfkstok` SET `Stok`='$jml',`TanggalUpdateStok`=curdate() WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'"); 
		// }
	}else if($_GET['sts'] == 'simpan_stok_sistem'){
		// update tbstokbulanandinas, yang stok sistem
		mysqli_query($koneksi,"UPDATE `tbstokbulanandinas` SET `StokAwalSistem`='$jml', `Selisih` = (StokAwalSistem - $jml) WHERE `Bulan`='$bln' AND `Tahun`='$thn' AND `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'");
		
	}else if($_GET['sts'] == 'simpan_keterangan'){
		mysqli_query($koneksi,"UPDATE `tbstokbulanandinas` SET `Keterangan`='$keterangan' WHERE `Bulan`='$bln' AND `Tahun`='$thn' AND `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'");
	}else{
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namapuskesmas = $_SESSION['namapuskesmas'];
		$kota = $_SESSION['kota'];
		$alamat = $_SESSION['alamat'];
		$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_besar_opnam" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA STOK OPNAME</b></h3>
			<div class="table-responsive">
				<table class="table-judul" wiidth="100%">
					<thead>
						<tr>
							<th width="20%">Bulan</th>
							<th width="10%">Tahun</th>
							<th width="20%">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo nama_bulan($bulan);?></td>
							<td align="center"><?php echo $tahun;?></td>
							<td align="center"><a href="gudang_besar_opname_lihat_print.php?nf=<?php echo $nf?>&bl=<?php echo $_GET['bl']?>&th=<?php echo $_GET['th']?>&sa=<?php echo $_GET['sa']?>" class="btn-round btnsimpan">Print</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	
	<!--search-->
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="gudang_besar_opnam_lihat"/>
						<div class="col-sm-8">
							<input type="hidden" name="bl" class="form-control key" value="<?php echo $_GET['bl'];?>">
							<input type="hidden" name="th" class="form-control key" value="<?php echo $_GET['th'];?>">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang / Kode Barang / No.Batch">
						</div>
						<div class="col-sm-2">
							<select name="jmltersedia" class="form-control">
								<option value="Tersedia" <?php if($_GET['jmltersedia'] == 'Tersedia'){echo "SELECTED";}?>>Tersedia</option>
								<option value="Keseluruhan" <?php if($_GET['jmltersedia'] == 'Keseluruhan'){echo "SELECTED";}?>>Keseluruhan</option>
								<option value="Expire" <?php if($_GET['jmltersedia'] == 'Expire'){echo "SELECTED";}?>>Expire</option>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_besar_opnam_lihat&bl=<?php echo $bulan;?>&th=<?php echo $tahun;?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<?php
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="table-responsive">	
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">NO.</th>
					<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">KODE</th>
					<th rowspan="2" width="25%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">NAMA BARANG</th>
					<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">SATUAN</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">BATCH</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">TAHUN ANGGARAN</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">EXPIRE</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">HARGA SATUAN</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">STOK SISTEM</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">STOK FISIK</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">SELISIH</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				$jumlah_perpage = 100;							
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$key = $_GET['key'];
				$jmltersedia = $_GET['jmltersedia'];
				
				if($key !=''){
					$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%')";
				}else{
					$strcari = " ";
				}
				
				if($jmltersedia == 'Keseluruhan'){
					$stoks = "";
				}elseif($jmltersedia == 'Expire'){
					$stoks = " AND `StokAwalSistem` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN'";
				}else{
					$stoks = " AND `StokAwalSistem` > '0'";
				}
				
				// yang ada stoknya dan selain BLUD
				if($kota == "KABUPATEN BANDUNG"){
					$str = "SELECT * FROM `tbstokbulanandinas`WHERE Bulan='$bulan' AND Tahun='$tahun' ".$stoks.$strcari;
				}elseif($kota == "KABUPATEN BEKASI"){
					$str = "SELECT * FROM `tbstokbulanandinas`WHERE Bulan='$bulan' AND Tahun='$tahun' ".$stoks.$strcari;	
				}else{
					$str = "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD'".$stoks.$strcari;
				}	
				
				$str2 = $str." ORDER BY NamaBarang LIMIT $mulai,$jumlah_perpage";
				// echo $str2;
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					$namaprogram = $data['NamaProgram'];
					$nobatch = $data['NoBatch'];
					
					// tbgfkstok
					$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
					
					// stok sistem, bekasi ngambil dari tbstokawalmaster_gudang_besar, untuk bulan januari (awal) saja selanjutnya ambil dari sisa akhir perbulan
					if($bulan == '01' AND $tahun == '2020'){
						$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
						
						// pengeluaran
						$jml_keluar = 0;
						if ($kota = "KABUPATEN BEKASI"){
							$str_keluar = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) = '$bulan'";
						}else{
							$str_keluar = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
						}	
						
						$query_keluar = mysqli_query($koneksi, $str_keluar);
						while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
							$nofaktur = $dt_keluar['NoFaktur'];
							$jml_keluar = $dt_keluar['Jumlah'];			
							$stokkeluar[] = $jml_keluar;
							$ttl_keluar = array_sum($stokkeluar);
						}
						
						// karantina
						$jml_karantina = 0;
						$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalKarantina) = '$tahun' AND MONTH(b.TanggalKarantina) = '$bulan'";
						// echo $str_karantina;
						$query_karantina = mysqli_query($koneksi, $str_karantina);
						while($dt_karantina = mysqli_fetch_assoc($query_karantina)){
							$jml_karantina = $dt_karantina['Jumlah'];			
							$stokkarantina[] = $jml_karantina;
							$ttl_karantina = array_sum($stokkarantina);
						}
						$stoksistem = $dtstokawal['Stok'] - $jml_keluar - $jml_karantina;
							
					}else{
						// data stok awal ini narik dari dashboard.php --> ditarik dari tbgfkstok (stok) saat akhir bulan
						$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));	
						$stoksistem = $dtstokawal['StokAwalSistem'];
					}
											
					// sisaakhir tbstokbulanandinas, jangan pakai nomer faktur hilangkan aja
					$dtstokdinkes = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
					$selisih = $stoksistem - $dtstokdinkes['Stok'];
				?>
				
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px; display: none;" class="nofakturcls"><?php echo $nf;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['Satuan'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo str_replace(",", ", ", $nobatch);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px; display:none;" class="batchcls"><?php echo $nobatch;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['TahunAnggaran'];?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['Expire'];?></td>	
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['HargaBeli'];?></td>							
						<td style="text-align:right; border:1px solid #000; padding:3px; color:red;font-weight:bold" class="StokAwalSistem" data-isi="<?php echo $stoksistem;?>"><b><?php echo rupiah($stoksistem);?></b></td><!--stok sistem-->
						<td style="text-align:right; border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="sisaakhir">
							<?php 
								if($dtstokdinkes['Stok'] != 0){
									echo rupiah($dtstokdinkes['Stok']);
								}else{
									echo "-";												
								}
							?>
						</td><!--stok fisik-->
						<td style="text-align:right; border:1px solid #000; padding:3px;" class="selisih"><?php echo rupiah($selisih);?></td><!--selisih-->
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_besar_opnam_lihat&bl=$bulan&th=$tahun&key=$key&jmltersedia=$jmltersedia&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	}		
	?>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">

$(".sisaakhir").dblclick(function(){
	var isi = $(this).text();
	if(isi == "-"){
		isi = "";
	}
	
	var isi = $(this).text();
	var lokasi = $(this).parent();
	var StokAwalSistem = $(this).parent().find(".StokAwalSistem").data('isi');
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();
		
		var selisih = parseInt(StokAwalSistem) - parseInt(isi);
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		var batch = $(this).parent().parent().find(".batchcls").text();
		var nofk = $(this).parent().parent().find(".nofakturcls").text();
		$.post( "gudang_besar_opnam_lihat.php?sts=simpan", {nofk:nofk,isi:isi,kode:kode,batch:batch,tahun:tahun,bulan:bulan}).done(function(data){
			alert("Data berhasil diupdate...");
			// alert(data);
		});
		$(this).parent().html(isi);
		lokasi.find(".selisih").html(selisih);
	});
});
<?php
	// hanya admin yang bisa edit stok sistem
	if (in_array("APOTEKER", $otoritas) || in_array("PROGRAMMER", $otoritas)){
?>
$(".StokAwalSistem").dblclick(function(){
	var isi = $(this).text();
	if(isi == "-"){
		isi = "";
	}
	
	var isi = $(this).text();
	var lokasi = $(this).parent();
	var StokAwalSistem = $(this).parent().find(".StokAwalSistem").data('isi');
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();
		
		var selisih = parseInt(StokAwalSistem) - parseInt(isi);
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		var batch = $(this).parent().parent().find(".batchcls").text();
		var nofk = $(this).parent().parent().find(".nofakturcls").text();
		$.post( "gudang_besar_opnam_lihat.php?sts=simpan_stok_sistem", {nofk:nofk,isi:isi,kode:kode,batch:batch,tahun:tahun,bulan:bulan}).done(function(data){
			alert("Data berhasil diupdate...");
			// alert(data);
		});
		$(this).parent().html(isi);
		lokasi.find(".selisih").html(selisih);
	});
});
<?php
	}
?>

$(".keterangan").dblclick(function(){
	var ket = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+ket+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var ket = $(this).val();
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		var batch = $(this).parent().parent().find(".batchcls").text();
		$.post( "gudang_besar_opnam_lihat.php?sts=simpan_keterangan", {ket:ket,kode:kode,batch:batch,tahun:tahun,bulan:bulan});
		$(this).parent().html(ket);
	});
	
});

</script>
