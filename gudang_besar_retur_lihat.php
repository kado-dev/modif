<?php
	$nf = $_GET['nf'];
	$idretur = $_GET['idretur'];
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_retur" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA RETUR </b><small>Puskesmas</small></h3>
			<div class="table-responsive">
				<?php
					$dataretur=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmretur` WHERE `NoFaktur`='$nf'"));
				?>
				<table class="table-judul">
					<thead>
						<tr>
							<th width="20%">No.Faktur</th>
							<th width="30%">Penerima</th>
							<th width="20%">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo $dataretur['NoFaktur']?></td>
							<td align="center"><?php echo $dataretur['Penerima']?></td>
							<td align="center"><a href="gudang_besar_retur_lihat_print.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">Print</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
</div>

<?php
	$jmlbrg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmreturdetail` WHERE `NoFaktur`='$nf'"));
?>	
<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b><?php echo $jmlbrg." ITEM BARANG,";?> GRAND TOTAL Rp. <span id="grandtotalid"></span></b></h3>
			<table class="table-judul-laporan">
				<thead>
					<tr>
						<th width="4%">No.</th>
						<th width="7%">Kode</th>
						<th width="25%">Nama Barang</th>
						<th width="6%">Satuan</th>
						<th width="8%">Batch</th>
						<th width="8%">Expire</th>
						<th width="6%">Harga Sat.</th>
						<th width="5%">Jml</th>
						<th width="8%">Total</th>
						<th width="5%">Aksi</th>
						<!--<th width="5%">Opsi</th>-->
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
					
					$str = "SELECT * FROM `tbgudangpkmreturdetail` WHERE `NoFaktur` = '$nf'";
					$str2 = $str." LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					$grandtotal  = 0;
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];
						
						// tbgfkstok
						$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
						$totals = $dtgfkstok['HargaSatuan'] * $data['Jumlah'];
						$grandtotal = $grandtotal + $totals;
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeBarang'];?></td>
							<td class="nama"><?php echo $dtgfkstok['NamaBarang'];?></td>
							<td align="center"><?php echo $dtgfkstok['Satuan'];?></td>
							<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
							<td align="center"><?php echo $dtgfkstok['Expire'];?></td>
							<td align="right"><?php echo rupiah($dtgfkstok['HargaSatuan']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($totals);?></td>
							<td align="center">
								<?php
									$cekdata = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmreturdetail` WHERE `NoFaktur`='$nf' AND `StatusApprove`='Y' AND `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'"));
									if($cekdata == 0){
								?>
								<a href="?page=gudang_besar_retur_lihat_approve&nf=<?php echo $nf;?>&kd=<?php echo $data['KodeBarang'];?>&bt=<?php echo $data['NoBatch'];?>&jml=<?php echo $data['Jumlah'];?>" class="btn btn-sm btn-success">Approve</a>
								<?php
									}
								?>
							</td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>

		</div>
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
						echo "<li><a href='?page=gudang_besar_retur_lihat&nf=$nf&idretur=$idretur&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 
</div>
<script type="text/javascript">
	document.getElementById("grandtotalid").innerHTML = '<?php echo rupiah($grandtotal)?>';
</script>