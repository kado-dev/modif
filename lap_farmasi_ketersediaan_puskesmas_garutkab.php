<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<h3 class="judul"><b>KETERSEDIAAN BARANG</b></h3>
	<div class="formbg">
		<div class="row">
			<form method="get">
				<input type="hidden" name="page" value="lap_farmasi_ketersediaan_puskesmas_garutkab"/>
				<input type="hidden" name="status" value="<?php echo $_GET['status'];?>"/>
				<div class="col-sm-2">
					<div class="tampilformdate">
						<div class="input-group tampilformdate">
							<span class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</span>
							<input type="text" name="tgl1" class="form-control datepicker2" value="<?php echo $_GET['tgl1'];?>" placeholder = "Tanggal Awal">
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="tampilformdate">
						<div class="input-group tampilformdate">
							<span class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</span>
							<input type="text" name="tgl2" class="form-control datepicker2" value="<?php echo $_GET['tgl2'];?>" placeholder = "Tanggal Akhir">
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Pasien">
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
					<a href="?page=lap_farmasi_ketersediaan_puskesmas_garutkab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
					<!--<a href="apotik_pelayanan_resep_excel.php?tgl1=<?php echo $_GET['tgl1'];?>&tgl2=<?php echo $_GET['tgl2'];?>&key=<?php echo $_GET['key'];?>&statusdilayani=<?php echo $_GET['statusdilayani'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
					<a href="?page=apotik_resep" class="btn btn-sm btn-success">Resep Manual</a> data-toggle="modal" data-target="#modalresep"
					<a href="?page=apotik_pelayanan_resep_manual_tambah" class="btn btn-sm btn-success">Entry Resep</a>-->
				</div>
			</form>	
		</div>
	</div>

	<?php
	$tahun = 2021;
	$key = $_GET['key'];
	?>	
	<div class="table-responsive">
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th width="3%" align="center" rowspan="2">NO.</th>
					<th width="5%" align="center" rowspan="2">KODE</th>
					<th width="27%" align="center" rowspan="2">NAMA BARANG</th>
					<th width="10%" align="center" colspan="3">STOK AWAL</th>
					<th width="10%" align="center" colspan="3">PENERIMAAN</th>
					<th width="10%" align="center" colspan="3">PENGELUARAN</th>
					<th width="10%" align="center" colspan="3">SISA STOK</th>
				</tr>
				<tr>
					<th width="3%" align="center">BLUD</th><!--stokawal-->
					<th width="5%" align="center">DINAS</th>
					<th width="5%" align="center">TOTAL</th>
					<th width="3%" align="center">BLUD</th><!--penerimaan-->
					<th width="5%" align="center">DINAS</th>
					<th width="5%" align="center">TOTAL</th>
					<th width="3%" align="center">BLUD</th><!--pengeluaran-->
					<th width="5%" align="center">DINAS</th>
					<th width="5%" align="center">TOTAL</th>
					<th width="3%" align="center">BLUD</th><!--sisastok-->
					<th width="5%" align="center">DINAS</th>
					<th width="5%" align="center">TOTAL</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$jumlah_perpage = 50;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$no = 0;				
			$str = "SELECT * FROM `tbgudangpkmstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `Nobatch` like '%$key%')";	
			$str2 = $str." ORDER BY `KodeBarang` ASC LIMIT $mulai,$jumlah_perpage";	
			// echo $str2;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi, $str2);	
			while($dtobat=mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kodebarang = $dtobat['KodeBarang'];
				$namabarang = $dtobat['NamaBarang'];
				$nobatch = $dtobat['NoBatch'];
				$stok = $dtobat['Stok'];
				$harga = $dtobat['HargaSatuan'];
				
				// tahap1, tbstokawalmaster_gudang_puskesmas
				// blud
				$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Apbd`,`Jkn` FROM `tbstokawalmaster_gudang_puskesmas` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
				$stokawal_jkn = $dtstokawal['Jkn'];
				if(empty($stokawal_jkn)){$stokawal_jkn = "0";}
				
				// dinas
				$stokawal_apbd = $dtstokawal['Apbd'];
				if(empty($stokawal_apbd)){$stokawal_apbd = "0";}
				
				$stokawal_total = $stokawal_jkn + $stokawal_apbd;
				
				// tahap2, penerimaan
				$strpenerimaan = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgudangpkmpenerimaandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
				$penerimaans = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								
				// tahap3, pengeluaran 
				$strpengeluaran = "SELECT SUM(Jumlah)AS Jumlah FROM `tbgudangpkmpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
				$pegeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
				
				// tahap4, sisastok
				$sisastok = ($stokawal_dinas + $penerimaans['Jumlah']) - $pegeluaran['Jumlah'];
				$saldo = $sisastok * $harga;	
				
			?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="center"><?php echo $kodebarang;?></td>
					<td align="left"><?php 	echo $namabarang;?></td>
					<td align="right"><?php echo rupiah($stokawal_jkn);?></td>
					<td align="right"><?php echo rupiah($stokawal_apbd);?></td>
					<td align="right"><?php echo rupiah($stokawal_total);?></td>
					<td align="right"><?php echo rupiah($penerimaans['Jumlah']);?></td>
					<td align="right"><?php echo "";?></td>
					<td align="right"><?php echo "";?></td>
					<td align="right"><?php echo rupiah($pegeluaran['Jumlah']);?></td>
					<td align="right"><?php echo "";?></td>
					<td align="right"><?php echo "";?></td>
					<td align="right"><?php echo rupiah($sisastok);?></td>
					<td align="right"><?php echo "";?></td>
					<td align="right"><?php echo "";?></td>
					<!--<<td align="center; vertical-align:middle; padding:5px;"><a href="?page=lap_farmasi_ketersediaan_puskesmas_garutkab_lihat&nf=<?php echo $nomorpembukuan;?>&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $key;?>" class="btn btn-sm btn-info btn-white">Lihat</a></td>-->
				</tr>
			<?php
				$totalstokawal = $totalstokawal + $stokawal;
				$totalpenerimaan = $totalpenerimaan + $penerimaan;
				$totalpengeluaran = $totalpengeluaran + $pegeluaran_apbd;
				$totalsisastok = $totalsisastok + $sisastok;
			}
			?>		
				<tr>
					<td align="center" colspan="3">TOTAL</td>
					<td align="right"><?php echo rupiah($totalstokawal);?></td>
					<td align="right"><?php echo rupiah($totalpenerimaan);?></td>
					<td align="right"><?php echo rupiah($totalpengeluaran);?></td>
					<td align="right"><?php echo rupiah($totalsisastok);?></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="right"></td>
				</tr>
			</tbody>
		</table>
	</div>
	<ul class="pagination">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_ketersediaan_puskesmas_garutkab&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	



