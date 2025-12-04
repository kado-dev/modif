<?php
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>GUDANG KARANTINA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_karantina_stok"/>
						<div class="col-sm-5">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang/Batch">
						</div>
						<div class="col-sm-7">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_karantina_stok" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print"></span></a>
							<a href="gudang_karantina_stok_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>

	<?php
		$jumlah_perpage = 50;
					
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$key = $_GET['key'];		
		$str = "SELECT * FROM `tbgfk_karantinadetail` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%')";
		$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;

		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}	
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<div class="table-responsive">
					<table class="table-judul">
						<thead>
							<tr>
								<th width="3%">NO.</th>
								<th width="5%">KODE</th>
								<th width="30%">NAMA BARANG</th>
								<th width="15%">NO.BATCH</th>
								<th width="10%">EXPIRE</th>
								<th width="10%">SUMBER</th>
								<th width="5%">TAHUN</th>
								<th width="7%">STOK</th>
								<th width="5%">#</th>
							</tr>
						</thead>
						<tbody font="8">
							<?php						
								$query = mysqli_query($koneksi, $str2);
								while($data = mysqli_fetch_assoc($query)){
									$no = $no + 1;
									$kodebarang = $data['KodeBarang'];
									$nobatch = $data['NoBatch'];
									$nofakturterima = $data['NoFakturTerima'];
									$statusgudang = $data['StatusGudang'];

									// tbgfkstok
									$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
							?>
							<tr style="background:<?php echo $warna;?>;">
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['KodeBarang'];?></td>
								<td align="left" class="nama">
									<?php echo "<b>".strtoupper($data['NamaBarang'])."</b>";?>
									<span class="badge badge-success" style='padding: 4px;'><?php echo "Prg. ".$dtgfkstok['NamaProgram'];?></span>
									<span class="badge badge-danger" style='padding: 4px;'><?php echo $data['StatusKarantina'];?></span><br/>
									<?php 
										echo "Tgl.Karantina : ".$data['TanggalKarantina'];
									?>
								</td>
								<td align="left"><?php echo $data['NoBatch'];?></td>
								<td align="center"><?php echo date('d-m-Y',strtotime($data['Expire']));?></td>
								<td align="center"><?php echo $dtgfkstok['SumberAnggaran'];?></td>
								<td align="center"><?php echo $dtgfkstok['TahunAnggaran'];?></td>
								<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
								<td align="center">
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-xs btn-info btn-white dropdown-toggle" aria-expanded="true">Opsi<span class="ace-icon fa fa-caret-down icon-on-right"></span></button>
										<ul class="dropdown-menu dropdown-info dropdown-menu-right">
											<li><a href="?page=gudang_karantina_pengembalian&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>&idkr=<?php echo $data['IdKarantinaDetail'];?>" onClick="return confirm('Data ingin dikembalikan...?')">Pengembalian</a></li>
											<li><a href="?page=gudang_karantina_pemusnahan&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>">Pemusnahan</a></li>
										</ul>
									</div>
								</td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_karantina_stok&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>

<!--tabel report-->
<div class="printheader">
	<span class="font14" style="margin:5px; font-weight:bold;">DINAS KESEHATAN <?php echo $kota;?></span><br>
	<span class="font14" style="margin:5px; font-weight:bold;"><?php echo $namapuskesmas;?></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span><br>
	<hr style="margin:3px; border:1.5px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px; font-weight:bold;">DATA KARANTINA</span><br>
	<span class="font12" style="margin:1px;">Tanggal Print: <?php echo date('d-m-Y');?></span><br/><br/>
</div>

<div class="printbody">
	<table class="judul-laporan" widht="100%">
		<thead>
			<tr>
				<th width="3%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
				<th width="5%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">TANGGAL KARANTINA</th>
				<th width="5%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">KODE</th>
				<th width="25%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
				<th width="15%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">BATCH</th>
				<th width="10%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">EXPIRE</th>
				<th width="15%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">SUMBER</th>
				<th width="5%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">TAHUN</th>
				<th width="7%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">STOK</th>
				<th width="5%" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;" class="noprint">#</th>
			</tr>
		</thead>
		<tbody font="8">
			<?php
				$no = 0;
				$str = "SELECT * FROM `tbgfk_karantinadetail` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%')";
				$str2 = $str." ORDER BY NamaBarang ASC";
				// echo $str2;
				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$nobatch = $data['NoBatch'];
					$nofakturterima = $data['NoFakturTerima'];
					$statusgudang = $data['StatusGudang'];

					// tbgfkstok
					$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
			?>
			<tr style="background:<?php echo $warna;?>;">
				<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $no;?></td>
				<td style="text-align:center; padding:3px;border:1px solid #000;">><?php echo $data['TanggalKarantina'];?></td>
				<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $data['KodeBarang'];?></td>
				<td style="text-align:left; padding:3px;border:1px solid #000;" class="nama">
					<?php echo strtoupper($data['NamaBarang']);?>
					<span class="badge badge-success" style='padding: 4px;'><?php echo "Prg. ".$dtgfkstok['NamaProgram'];?></span>
				</td>
				<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data['NoBatch'];?></td>
				<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo date('d-m-Y',strtotime($data['Expire']));?></td>
				<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dtgfkstok['SumberAnggaran'];?></td>
				<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dtgfkstok['TahunAnggaran'];?></td>
				<td style="text-align:right; padding:3px;border:1px solid #000;" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
				<td style="text-align:center; padding:3px;border:1px solid #000;" class="noprint">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn btn-xs btn-info btn-white dropdown-toggle" aria-expanded="true">Opsi<span class="ace-icon fa fa-caret-down icon-on-right"></span></button>
						<ul class="dropdown-menu dropdown-info dropdown-menu-right">
							<li><a href="?page=gudang_karantina_pengembalian&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>" onClick="return confirm('Data ingin dikembalikan...?')">Pengembalian</a></li>
							<li><a href="?page=gudang_besar_stok_detail&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>">Pemusnahan</a></li>										
						</ul>
					</div>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>	

<div class="bawahtabel">
	<table width="100%">
		<tr>
			<td width="10%"></td>
			<td style="text-align:center;">
			Kepala Puskesmas
			<br>
			<br>
			<br>
			(.....................................)
			</td>
			<td width="10%"></td>
			<td style="text-align:center;">
			Diterima Oleh
			<br>
			<br>
			<br>
			(.....................................)
			</td>
			<td width="10%"></td>
			<td style="text-align:center;">
			Diserahkan Oleh
			<br>
			<br>
			<br>
			(.....................................)
			</td>
		</tr>
	</table>
</div>
