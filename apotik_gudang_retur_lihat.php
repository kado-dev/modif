<?php
	session_start();
	include "config/helper_report.php";
	$id = $_GET['id'];
	$dataretur = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmretur` WHERE `IdRetur`='$id'"));
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-lg-12">
			<a href="index.php?page=apotik_gudang_retur" class="backform" style="margin-top: 0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA RETUR</b><small> Gudang Obat Puskesmas</small></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr class="head-table-gudang-besar-penerimaan">
							<th width="10%">Tgl.Pengeluaran</th>
							<th width="10%">No.Faktur</th>
							<th width="10%">Status Pengeluaran</th>
							<th width="10%">Penerima</th>
							<th width="5%">Aksi</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td align="center"><?php echo $dataretur['TanggalRetur'];?></td>
								<td align="center"><?php echo $dataretur['NoFaktur'];?></td>
								<td align="center"><?php echo $dataretur['StatusPengeluaran'];?></td>
								<td align="center"><?php echo $dataretur['Penerima'];?></td>
								<td align="center">
									<a href="javascript:print()" class="btn btn-info btn-white">Print</a>
								</td>					
							</tr>
					</tbody>
				</table>
			</div>	
		</div>
	</div><br/>

	<div class="row search-page noprint" id="search-page-1">	
		<div class="col-xs-12">
			<div class="formbg">
				<div class = "row">
					<form action="?page=apotik_gudang_retur_lihat_proses" method="post">	
						<table class="table-judul" width="100%">
							<tr>
								<td width="50%">
									<input type="text" name="namabarang" class="form-control nama_barang_gudang_puskesmas_retur" placeholder="Ketikan Nama Barang">
									<input type="hidden" name="kodebarang" class="form-control kodebarang" readonly>
									<input type="hidden" name="satuan" class="form-control satuan" readonly>
									<input type="hidden" name="sumberanggaran" class="form-control sumberanggaran" readonly>
									<input type="hidden" name="tahunanggaran" class="form-control tahunanggaran" readonly>
								</td>
								<td width="10%">
									<input type="text" name="nobatch" class="form-control kodebarang" placeholder="kodebrg" readonly>
								</td>
								<td width="10%">
									<input type="text" name="nobatch" class="form-control nobatch" placeholder="batch" readonly>
								</td>
								<td width="10%">
									<input type="text" name="expire" class="form-control expire" placeholder="expire" readonly>
								</td>
								<td width="10%">
									<input type="number" name="stok" class="form-control stok" placeholder="stok" readonly>
								</td>
								<td width="7%">
									<input type="number" name="jumlah" class="form-control jumlah" maxlength="10" placeholder="jml">
								</td>
							</tr>
							<tr>
								<td colspan="6">
									<textarea name="keterangan" class="form-control" placeholder="Jelaskan Keterangan Retur" required></textarea><br/>
									<input type="submit" value="SIMPAN" class="btnsimpan">
									<input type="hidden" class="form-control" name="id" value="<?php echo $dataretur['IdRetur']?>">
									<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $dataretur['NoFaktur']?>">
									<input type="hidden" class="form-control" name="penerima" value="<?php echo $dataretur['Penerima']?>">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-lg-12">
			<div class="table-responsive" style="font-size:12px">
				<table class="table-judul">
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode</th>
							<th width="30%">Nama Barang</th>
							<th>Satuan</th>
							<th>Batch</th>
							<th>Harga</th>
							<th>Jml</th>
							<th width="20%">Keterangan</th>
							<th width="6%">Opsi</th>
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
						
						$kategori = $_GET['kategori'];		
						$key = $_GET['key'];	
						
						if($kategori !='' && $key !=''){
							$strcari = " WHERE `NoFaktur` = '$dataretur[NoFaktur]' AND".$kategori." LIKE '%$key%'";
						}else{
							$strcari = " WHERE `NoFaktur` = '$dataretur[NoFaktur]'";
						}
						
						$str = "SELECT * FROM `tbgudangpkmreturdetail`".$strcari;
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						// die();
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
						
							// tbgudangpkmstok, where kodebarang aja batch gak usah karena kode barang sudah mewakili nama barang
							$dtgudangpkmstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang'"));
						
					?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['KodeBarang'];?></td>
								<td class="nama"><?php echo strtoupper($dtgudangpkmstok['NamaBarang']);?></td>
								<td align="center"><?php echo $dtgudangpkmstok['Satuan'];?></td>
								<td><?php echo $data['NoBatch'];?></td>
								<td align="right"><?php echo rupiah($dtgudangpkmstok['HargaSatuan']);?></td>
								<td align="right" style="font-weight: bold; color: red;"><?php echo rupiah($data['Jumlah']);?></td>
								<td align="center"><?php echo $data['KeteranganRetur'];?></td>
								<td align="center">
									<!--<a href="?page=apotik_gudang_besar_pengeluaran_edit&no=<?php echo $data['NoFaktur'];?>&kd=<?php echo $data['KodeBarang'];?>" class="btn btn-xs btn-info">Edit</a>-->
									<a href="?page=apotik_gudang_retur_lihat_hapus&id=<?php echo $data['IdRetur'];?>&no=<?php echo $data['NoFaktur'];?>&kd=<?php echo $data['KodeBarang'];?>&nb=<?php echo $data['NoBatch'];?>" class="btn btn-xs btn-danger btn-white">Hapus</a>
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
						echo "<li><a href='?page=apotik_gudang_retur_lihat&id=$id&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 
</div>	

<!--tabel report-->
<?php
$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmretur` WHERE `NoFaktur` = '$id'"));
?>
<div class="printheader">
	<span class="font14" style="margin:5px; font-weight:bold;">PEMERINTAH <?php echo $kota;?></span><br>
	<span class="font14" style="margin:5px; font-weight:bold;">DINAS KESEHATAN</span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span><br>
	<hr style="margin:3px; border:1.5px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px; font-weight:bold;">BERITA ACARA PENGEMBALIAN BARANG</span><br>
	<span class="font11" style="margin:1px;">No Faktur: <?php echo $_GET['id'];?></span><br>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Tanggal Retur</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $pengeluaran['TanggalRetur'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
			</tr>
		</table>
	</div>
</div>

<div class="printbody font10">
	<table><!--table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
		<thead style="font-size:12,5px;">
			<tr style="border:1px solid #000;">
				<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
				<th rowspan="2" style="text-align:center;width:30%;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
				<th rowspan="2" style="text-align:center;width:8%;vertical-align:middle; border:1px solid #000; padding:3px;">SATUAN</th>
				<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">EXPIRE</th>
				<th rowspan="2" style="text-align:center;width:8%;vertical-align:middle; border:1px solid #000; padding:3px;">BATCH</th>
				<th colspan="3" style="text-align:center;width:20%;border:1px solid #000; padding:3px;">PEMBERIAN</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">JML</th>
				<th style="text-align:center;width:8%; border:1px solid #000; padding:3px;">HARGA SAT.</th>
				<th style="text-align:center;width:10%; border:1px solid #000; padding:3px;">TOTAL HARGA</th>
			</tr>
		</thead>
		
		<tbody style="font-size:12,5px;">
			<?php
			$str2_print = "SELECT * FROM `tbgudangpkmreturdetail` WHERE `NoFaktur` = '$id'";
			$query_print = mysqli_query($koneksi,$str2_print);			
			
			$total = 0;
			$no = 0;
			while($data = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;
				$kodebarang = $data['KodeBarang'];
								
				// tbgudangpkmstok, where kodebarang aja batch gak usah karena kode barang sudah mewakili nama barang
				$dtgudangpkmstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang'"));
				$jumlah = $dtgudangpkmstok['HargaSatuan'] * $data['Jumlah'];
				$total = $jumlah + $total;
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no.".";?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $dtgudangpkmstok['NamaBarang'];?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dtgudangpkmstok['Satuan'];?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo tgl_singkat($dtgudangpkmstok['Expire']);?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data['NoBatch'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($data['Jumlah']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dtgudangpkmstok['HargaSatuan']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dtgudangpkmstok['HargaSatuan'] * $data['Jumlah']);?></td>
				</tr>
			<?php
			}
			?>
				<tr style="border:1px solid #000; padding:3px;">
					<td colspan="7" style="text-align:center; padding:3px; font-weight:bold; font-size:14px;">Total Keseluruhan (Rp)</td>
					<td style="text-align:right; padding:3px; font-weight:bold; font-size:14px;"><?php echo rupiah($total);?></td>
				</tr>
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
	
