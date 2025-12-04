<?php
	include "config/helper_pasienrj.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">RETUR BARANG</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="apotik_gudang_retur"/>
						<div class="col-xl-9">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nomer SBBK" required>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_gudang_retur" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<a href="?page=apotik_gudang_retur_tambah" class="btn btn-round btn-success">Entry Baru</a>
							<?php }?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">	
		<div class="col-lg-12">
			<div class="table-responsive" style="font-size:12px">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="5%">NO</th>
							<th width="10%">TANGGAL RETUR</th>
							<th width="15%">NOMOR FAKTUR</th>
							<th width="15%">STATUS PENGELUARAN</th>
							<th width="15%">PENERIMA</th>
							<th width="10%">GRAND TOTAL</th>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<th width="10%">#</th>
							<?php }?>
						</tr>
					</thead>
					<tbody font="8">
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}						
						
						// get						
						$key = $_GET['key'];				
						
						$str = "SELECT * FROM `tbgudangpkmretur` WHERE `KodePenerima` = '$kodepuskesmas' AND `NoFaktur` LIKE '%$key%'";	
						$str2 = $str." ORDER BY `IdRetur` DESC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						
						// jml item
						$jmlitem = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$data[NoFaktur]'"));
						$validasi_belum = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$data[NoFaktur]' AND `StatusValidasi`='Belum'"));
						
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalRetur']));?></td>
								<td align="left" class="nama"><?php echo $data['NoFaktur'];?></td>
								<td align="center"><?php echo $data['StatusPengeluaran'];?></td>
								<td align="center"><?php echo $data['Penerima'];?></td>
								<td align="right">
									<?php 
										$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
										FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
										WHERE a.NoFaktur LIKE '%$data[NoFaktur]%'";
										$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
										echo rupiah($dtgt['Jumlah']);
									?>
								</td>
								<?php  if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>			
								<td align="center">
									<a href="?page=apotik_gudang_retur_lihat&id=<?php echo $data['IdRetur'];?>" class="btn btn-xs btn-info">Lihat</a>
								</td>
								<?php } ?>
							</tr>
						<?php } ?>
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=apotik_gudang_stok&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
