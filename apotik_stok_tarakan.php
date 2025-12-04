<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];	
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$otoritas = explode(',',$_SESSION['otoritas']);
	$status = $_GET['status'];
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul">
				<?php 
					if(substr($status,0,4)=="POLI"){
						echo "DEPOT ".$status;
					}else{
						echo $status;
					}	
				?>
			</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form" method="get">
						<input type="hidden" name="page" value="apotik_stok_tarakan"/>
						<input type="hidden" name="status" value="<?php echo $_GET['status'];?>"/>
						<div class="col-sm-2">
							<select name="jmltersedia" class="form-control">
								<option value="Tersedia" <?php if($_GET['jmltersedia'] == 'Tersedia'){echo "SELECTED";}?>>Tersedia</option>
								<option value="Keseluruhan" <?php if($_GET['jmltersedia'] == 'Keseluruhan'){echo "SELECTED";}?>>Keseluruhan</option>
								<option value="Expire" <?php if($_GET['jmltersedia'] == 'Expire'){echo "SELECTED";}?>>Expire</option>
							</select>
						</div>
						<div class="col-sm-4">
							<input type="text" name="key" class="form-control cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang">
						</div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-sm btn-warning btnsubmit"><span class="fa fa-search"></button>
							<a href="?page=apotik_stok_tarakan&status=<?php echo $_GET['status'];?>" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="apotik_stok_tarakan_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="?page=apotik_pelayanan_resep&statusloket=<?php echo $_GET['status']?>" class="btn btn-sm btn-primary">Pelayanan Resep</a>
							<!--<a onclick="return confirm('Anda yakin ingin mengimport data')" href="apotik_stok_tarakan_import.php?status=<?php echo $_GET['status']?>" class="btn btn-sm btn-info">Import</a>-->
							<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){?>
							<a onclick="return confirm('Anda yakin ingin mengeksport data')" href="apotik_stok_tarakan_eksport.php?status=<?php echo $_GET['status']?>" class="btn btn-sm btn-danger">Eksport ke Stok Awal</a>
							<?php } ?>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="6%">KODE</th>
							<th width="20%">NAMA BARANG</th>
							<th width="8%">SATUAN</th>
							<th width="10%">BATCH</th>
							<th width="8%">EXPIRE</th>
							<th width="10%">SUMBER</th>
							<th width="6%">HARGA</th>
							<th width="6%">STOK</th>
							<?php if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){?>
							<th width="10%">#</th>
							<?php }?>
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
					
					$jmltersedia = $_GET['jmltersedia'];
					$status = $_GET['status'];		
					$key = $_GET['key'];

					if($jmltersedia == 'Keseluruhan'){
						$stoks = "";
					}elseif($jmltersedia == 'Expire'){
						$stoks = " AND `Stok` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
					}else{
						$stoks = " AND `Stok` > '0'";
					}						
										
					if($key != ''){
						$strcari = " AND (NamaBarang Like '%$key%' OR `KodeBarang` Like '%$key%' OR `NoBatch` Like '%$key%')";
					}else{
						$strcari = " ";
					}	
					
					// tbapotikstok, group aja berdarkankode barang dan ed (23 November 2022 tarakan)
					$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
					$str = "SELECT * FROM `$tbapotikstok` WHERE `StatusBarang` = '$status'".$strcari.$stoks;
					$str2 = $str." GROUP BY `KodeBarang`, `Expire` ORDER BY NamaBarang LIMIT $mulai,$jumlah_perpage";	
					// echo $str2;	

					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}			
						
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdbrg = $data['KodeBarang'];
						$nobatch = $data['NoBatch'];
						
						// tbgfkkstok, wajib dipisah berdasarkan nobatch (sumber anggaran bisa beda)
						$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));
						
						// tbgfk_vaksin 
						$dtgfkstok_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));
						
						// tbgudangpkmstok
						$dtgudangpkmstok =  mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));	
												
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeBarang'];?></td>
							<td align="left"class="nama">
								<?php
									if($data['NamaBarang'] != "" || $data['NamaBarang'] != "--PILIH--"){
										echo strtoupper($data['NamaBarang']);
									}elseif($dtgfkstok['NamaBarang'] != ""){
										echo strtoupper($dtgfkstok['NamaBarang']);
									}else{
										echo strtoupper($dtgfkstok_vaksin['NamaBarang']);
									}
								?>
							</td>
							<td align="center"><?php echo strtoupper($data['Satuan']);?></td>
							<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch'])?></td>
							<td align="center"><?php echo $data['Expire'];?></td>
							<td align="center">
								<?php 
									if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
										$sumber = "APBD";
									}else{
										$sumber = $data['SumberAnggaran'];
									}										
									echo $sumber." - ".$data['TahunAnggaran'];
								?>
							</td>
							<td align="right"><?php echo rupiah($data['HargaSatuan']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
							<?php
								if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
							?>
							<td align="center">
								<a href="?page=apotik_stok_tarakan_editstok&kd=<?php echo $data['KodeBarang'];?>&pkm=<?php echo $data['KodePuskesmas'];?>&sts=<?php echo $data['StatusBarang'];?>&batch=<?php echo $data['NoBatch'];?>" class="btn btn-xs btn-info">CEK STOK</a>
							</td>
							<?php
								}
							?>											
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
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
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=apotik_stok_tarakan&status=$status&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	
	<div class="alert alert-block alert-success fade in noprint">
		<p><span style="font-weight:bold">Perhatian :</span><br/>
		Jika klik tombol Habis maka stok akan dianggap kosong (nol),<br/>
		namun data item obat tetap disimpan tidak dihapus dari database.</p>	
	</div>
</div>


	