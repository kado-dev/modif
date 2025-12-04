<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
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
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_opnam_bandungkab" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
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
							<td align="center"><a href="gudang_besar_opname_lihat_print.php?nf=<?php echo $nf?>&bl=<?php echo $_GET['bl']?>&th=<?php echo $_GET['th']?>&sa=<?php echo $_GET['sa']?>" class="btnsimpan">Print</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	
	<!--search-->
	<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 15px;">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stok_opname_lihat_gudang"/>
						<div class="col-sm-10">
							<input type="hidden" name="bl" class="form-control key" value="<?php echo $_GET['bl'];?>">
							<input type="hidden" name="th" class="form-control key" value="<?php echo $_GET['th'];?>">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kode / Batch Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_stok_opname_lihat_gudang&nf=<?php echo $nf;?>&bl=<?php echo $bulan;?>&th=<?php echo $tahun;?>&namaprg=<?php echo $namaprg;?>" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						</div>
					</form>	
				</div>			
			</div>
		</div>
	</div>
	
	<?php
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="table-responsive">	
		<form action="gudang_besar_opnam_bandungkab_simpan.php" method="post">
			<input type="hidden" name="bulan" value="<?php echo $_GET['bl'];?>"/>
			<input type="hidden" name="tahun" value="<?php echo $_GET['th'];?>"/>
			<input type="hidden" name="halaman" value="<?php echo $_GET['h'];?>"/>
			<table class="table-judul-laporan" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Kode</th>
						<th rowspan="2" width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Nama Barang</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Batch</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Expire</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Tahun Anggaran</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Harga<br/>Satuan</th>
						<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Gudang Besar</th>
						<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Gudang Pelayanan</th>
						
					</tr>
					<tr>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Sistem</th><!--Gudang Besar-->
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Fisik</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Selisih</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Sistem</th><!--Gudang Pelayanan-->
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Fisik</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Selisih</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					$jumlah_perpage = 20;							
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$key = $_GET['key'];
					$namaprg = $_GET['namaprg'];
					
					if($key !=''){
						$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
					}else{
						$strcari = " ";
					}
									
					// yang ada stoknya dan selain BLUD
					$str = "SELECT * FROM `tbstokbulanandinas_bandungkab` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun'
					AND (StokGudangBesar_Sistem <> '0' OR StokGudangPelayanan_Sistem <> '0')".$strcari;			
					$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
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
						$nobatch = $data['NoBatch'];

						$kodeunik = $kodebarang."-".$nobatch;

						$namabarang = $data['NamaBarang'];
						$namaprogram = $data['NamaProgram'];						
						$tahunanggaran = $data['TahunAnggaran'];
						$expire = $data['Expire'];
						$hargasatuan = $data['HargaBeli'];
						$stokgudangbesarsistem = $data['StokGudangBesar_Sistem'];
						$stokgudangbesarfisik = $data['StokGudangBesar_Fisik'];
						$selisihgudangbesar = $data['SelisihGudangBesar'];
						$stokgudangpelayanansistem = $data['StokGudangPelayanan_Sistem'];						
						$stokgudangpelayananfisik = $data['StokGudangPelayanan_Fisik'];						
						$selisihgudangpelayanan = $data['SelisihGudangPelayanan'];
						
					?>
					
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px; display: none;" class="nofakturcls"><?php echo $nf;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;" class="kodecls">
								<?php echo $data['KodeBarang'];?>
								<input type="hidden" name="kodeunik[]" value="<?php echo $kodeunik;?>"/>
								<input type="hidden" name="kodebarang[<?php echo $kodeunik;?>]" value="<?php echo $data['KodeBarang'];?>"/>
								<input type="hidden" name="nobatch[<?php echo $kodeunik;?>]" value="<?php echo $data['NoBatch'];?>"/>
							</td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo str_replace(",", ", ", $nobatch);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px; display:none;" class="batchcls"><?php echo $nobatch;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date("d-m-Y", strtotime($expire));;?></td>	
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tahunanggaran;?></td>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $hargasatuan;?></td>	
							<!--Gudang Besar-->
							<td style="text-align:right; border:1px solid #000; padding:3px; font-weight:bold" data-isi="<?php echo $stokgudangbesarsistem;?>">
								<b><?php echo rupiah($stokgudangbesarsistem);?></b>
								<input type="hidden" name="stoksistem_gudangbesar[<?php echo $kodeunik;?>]" value="<?php echo $stokgudangbesarsistem;?>"/>
							</td>
							<td style="text-align:right; border:1px solid #000; padding:3px; background-color:#dbf7ff;">
								<input type="number" name="stokfisik_gudangbesar[<?php echo $kodeunik;?>]" style="width:100%; text-align: right;" value="<?php echo $stokgudangbesarfisik;?>"/>
							</td>
							<td align="right">
								<?php 
									if($selisihgudangbesar > 0){
								?>
									<label style="color:red; font-weight: bold"><?php echo rupiah($selisihgudangbesar);?></label>
								<?php		
									}else{
										echo rupiah($selisihgudangbesar);
									}	
								?>
							</td>							
							<!--Gudang Pelayanan-->
							<td style="text-align:right; border:1px solid #000; padding:3px; font-weight:bold" data-isi="<?php echo $stokgudangpelayanansistem;?>">
								<b><?php echo rupiah($stokgudangpelayanansistem);?></b>
								<input type="hidden" name="stoksistem_gudangpelayanan[<?php echo $kodeunik;?>]" value="<?php echo $stokgudangpelayanansistem;?>"/>
							</td>
							<td style="text-align:right; border:1px solid #000; padding:3px; background-color:#dbf7ff;">
								<input type="number" name="stokfisik_gudangpelayanan[<?php echo $kodeunik;?>]" style="width:100%; text-align: right;" value="<?php echo $stokgudangpelayananfisik;?>"/>
							</td>
							<td align="right">
								<?php 
									if($selisihgudangpelayanan > 0){
								?>	
									<label style="color:red; font-weight: bold"><?php echo rupiah($selisihgudangpelayanan);?></label>
								<?php		
									}else{
										echo rupiah($selisihgudangpelayanan);
									}	
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table><br/>
			<input type="submit" class="btnsimpan" style="padding: 10px" value="Simpan">
		</form>
	</div>
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
						echo "<li><a href='?page=gudang_besar_opnam_bandungkab_lihat&bl=$bulan&th=$tahun&h=$i'>$i</a></li>";
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
