<?php
	session_start();
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$nf = $_GET['nf'];
	$datapengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmvaksinpengeluaran` WHERE `NoFaktur`='$nf'"));
?>
<style>
	.autocomplete-suggestions { width:1000px !important}
</style>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-lg-12">
			<a href="index.php?page=apotik_vaksin_gudang_pengeluaran" class="backform" style="margin-top: 0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA PENGELUARAN VAKSIN</b></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="20%">TANGGAL PENGELUARAN</th>
							<th width="15%">NO.FAKTUR</th>
							<th width="50%">PENERIMA</th>
							<th width="15%">#</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center"><?php echo $datapengeluaran['TanggalPengeluaran'];?></td>
							<td align="center"><?php echo $datapengeluaran['NoFaktur'];?></td>
							<td align="center"><?php echo strtoupper($datapengeluaran['Penerima']);?></td>
							<td align="center">
								<a href="javascript:print()" class="btn btn-round btn-info">PRINT</a>
							</td>					
						</tr>
					</tbody>
				</table>
			</div>	
		</div>
	</div><br/>
	
	<div class="formbg">
		<div class = "row">
			<div class="col-xs-12">
				<form action="?page=apotik_vaksin_gudang_pengeluaran_lihat_proses" method="post">	
					<table class="table-judul" width="100%">
						<tr>
							<td width="60%">
								<input type="text" name="namabarang" class="form-control nama_barang_gudang_vaksin_puskesmas_pengeluaran" placeholder="Ketikan Nama Barang" id="textToDisplay" onClick="showMessage()">
								<input type="hidden" name="kodebarang" class="form-control kodebarang" readonly>
								<input type="hidden" name="satuan" class="form-control satuan" readonly>
								<input type="hidden" name="sumberanggaran" class="form-control sumberanggaran" readonly>
								<input type="hidden" name="tahunanggaran" class="form-control tahunanggaran" readonly>
								<input type="hidden" name="idbrggudangpkm" class="form-control idbrggudangpkm" readonly>
								<input type="hidden" name="hargasatuan" class="form-control hargasatuan" readonly>
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
							<td colspan="3"><input type="submit" value="SIMPAN" class="btn btn-round btn-success pull-right"></td>
							<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
							<input type="hidden" class="form-control" name="penerima" value="<?php echo $datapengeluaran['Penerima']?>">
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<form action="?page=apotik_gudang_pengeluaran_lihat_edit_proses" method="post" enctype="multipart/form-data" role="form">	
					<table class="table-judul-laporan">
						<thead>
							<tr>
								<th width="3%">NO.</th>
								<th width="7%">KODE</th>
								<th width="30%">NAMA BARANG</th>	
								<th width="10%">EXPIRE</th>
								<th width="10%">BATCH</th>
								<th width="10%">HARGA SATUAN</th>
								<th width="10%">JML</th>
								<th width="15%">#</th>
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
								$strcari = " WHERE NoFaktur = '$nf' AND".$kategori." Like '%$key%'";
							}else{
								$strcari = " WHERE NoFaktur = '$nf'";
							}
							
							$str = "SELECT * FROM `tbgudangpkmvaksinpengeluarandetail`".$strcari;
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
							
							// tbgudangpkmvaksinstok, where kodebarang aja batch gak usah karena kode barang sudah mewakili nama barang
							$dtgudangpkmstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmvaksinstok` WHERE `KodeBarang`='$kodebarang'"));
							
						?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td align="center"><?php echo $data['KodeBarang'];?></td>
									<td class="nama"><?php echo strtoupper($dtgudangpkmstok['NamaBarang']);?></td>
									
									<td align="left"><?php echo $dtgudangpkmstok['Expire'];?></td>
									<td align="left"><?php echo $dtgudangpkmstok['NoBatch'];?></td>
									<td align="right"><?php echo rupiah($dtgudangpkmstok['HargaSatuan']);?></td>
									<td align="right" style="font-weight: bold; color: red;"><?php echo $data['Jumlah'];?></td>
									<td align="center">
										<a onClick="return confirm('Data ingin dihapus...?')" href="?page=apotik_vaksin_gudang_pengeluaran_lihat_hapus&no=<?php echo $data['NoFaktur'];?>&idbrg=<?php echo $data['Id'];?>&idbrgpkm=<?php echo $data['IdBarangGdgPkm'];?>" class="btn btn-xs btn-danger">BATAL</a>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</form>	
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
						echo "<li><a href='?page=apotik_gudang_pengeluaran_lihat&id=$nf&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 
</div>	

<!--tabel report-->
<div class="printheader">
	<span class="font14" style="margin:5px; font-weight:bold;">DINAS KESEHATAN <?php echo $kota;?></span><br>
	<span class="font14" style="margin:5px; font-weight:bold;"><?php echo "PUSKESMAS ".$namapuskesmas;?></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span><br>
	<hr style="margin:3px; border:1.5px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px; font-weight:bold;">SURAT BUKTI BARANG KELUAR (SBBK)</span><br>
	<span class="font12" style="margin:15px 5px 5px 5px; font-weight:bold;">GUDANG VAKSIN PUSKESMAS</span><br>
	<span class="font12" style="margin:1px;">No Faktur: <?php echo $nf;?></span><br>
</div>

<?php  
$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
$tgllaporan = $tgl[1] - 1;
$tglpermintaan = $tgl[1];
?>
<div class="atastabel">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
			</tr>			
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Penerima </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datapengeluaran['Penerima'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Tgl.Pengeluaran </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo date('d-m-Y', strtotime($datapengeluaran['TanggalPengeluaran']))." ".$datapengeluaran['JamPengeluaran'];?></td>
			</tr>
		</table>
	</div>	
</div>

<div class="printbody">
	<table><!--table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
		<thead>
			<tr style="border:1px solid #000;">
				<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th rowspan="2" style="text-align:center;width:38%;vertical-align:middle; border:1px solid #000; padding:3px;">Obat & Perbekalan Kesehatan</th>
				<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
				<th rowspan="2" style="text-align:center;width:8%;vertical-align:middle; border:1px solid #000; padding:3px;">NoBatch</th>
				<th rowspan="2" style="text-align:center;width:18%;vertical-align:middle; border:1px solid #000; padding:3px;">Anggaran</th>
				<th colspan="4" style="text-align:center;border:1px solid #000; padding:3px;">Pemberian</th>
			</tr>
			<tr style="border:1px solid #000;">
				<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">Qty</th>
				<th style="text-align:center;width:6%; border:1px solid #000; padding:3px;">Satuan</th>
				<th style="text-align:center;width:6%; border:1px solid #000; padding:3px;">Harga</th>
				<th style="text-align:center;width:12%; border:1px solid #000; padding:3px;">Total (Rp)</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			$str2_print = "SELECT * FROM `tbgudangpkmvaksinpengeluarandetail` WHERE `NoFaktur`='$nf'";
			$query_print = mysqli_query($koneksi,$str2_print);			
			
			$total = 0;
			$no = 0;
			while($data = mysqli_fetch_assoc($query_print)){
				$no = $no + 1;
				$kodebarang = $data['KodeBarang'];
								
				// tbgudangpkmvaksinstok, where kodebarang aja batch gak usah karena kode barang sudah mewakili nama barang
				$dtgudangpkmstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmvaksinstok` WHERE `KodeBarang`='$kodebarang'"));
				$jumlah = $dtgudangpkmstok['HargaSatuan'] * $data['Jumlah'];
				$total = $jumlah + $total;
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo $no.".";?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $dtgudangpkmstok['NamaBarang'];?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo tgl_singkat($dtgudangpkmstok['Expire']);?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data['NoBatch'];?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dtgudangpkmstok['SumberAnggaran']." ".$dtgudangpkmstok['TahunAnggaran'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($data['Jumlah']);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $dtgudangpkmstok['Satuan'];?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dtgudangpkmstok['HargaSatuan']);?></td>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dtgudangpkmstok['HargaSatuan'] * $data['Jumlah']);?></td>
				</tr>
			<?php
			}
			?>
				<tr style="border:1px solid #000; padding:3px;">
					<td colspan="8" style="text-align:center; padding:3px; font-weight:bold; font-size:14px;">Total Keseluruhan (Rp)</td>
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
	




	
