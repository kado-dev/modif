<?php
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$penerima = $_GET['penerima'];
	include "config/helper_report.php";	
	
	// untuk mengupdate grandtotal
	$str3= "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `NoFaktur`='$nf'";
	$query3 = mysqli_query($koneksi,$str3);	
	while($data3 = mysqli_fetch_assoc($query3)){
		$kdbrg = $data3['KodeBarang'];
		$batch = $data3['NoBatch'];
		// tbgfk_vaksin_stok
		$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
		$jumlah = $dt_gfkstok['HargaBeli'] * $data3['Jumlah'];
		$totallama = $jumlah + $totallama;
	}
?>

<style>
.tr, th{
	text-align: center;
}

.atastabel{
	display:none;
	margin-top:10px;
	font-size: 12px;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}
@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_vaksin_pengeluaran&kategori=Penerima&key=<?php echo $penerima;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA PENGELUARAN </b><small>Gudang Vaksin</small></h3>
			<div class="table-responsive">
				<?php
					$datapengeluaran=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nf'"));
					$datapenerimaan=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT KodePuskesmas FROM `tbgudangpkmpenerimaan` WHERE `NoFaktur`='$nf'"));
				?>
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="20%">No.Faktur</th>
							<th width="25%">Penerima</th>
							<th width="20%">Program</th>
							<th width="25%" colspan="3">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo $datapengeluaran['NoFaktur']?></td>
							<td align="center"><?php echo $datapengeluaran['Penerima']?></td>
							<td align="center"><?php echo $datapengeluaran['NamaProgram']?></td>
							<?php if($_SESSION['kota']=='KABUPATEN BANDUNG'){?>							
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">SBBK</a></td>
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bast2_bandungkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">VAR</a></td>
							<?php }elseif($_SESSION['kota']=='KABUPATEN BOGOR'){?>
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bogorkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">SBBK</a></td>	
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bast_bogorkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">BAST</a></td>
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bast2_bogorkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">VAR</a></td>
							<?php }elseif($_SESSION['kota']=='KABUPATEN BEKASI'){?>
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bekasikab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">SBBK</a></td>
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bast_bakasikab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">BAST</a></td>
								<td align="center"><a href="gudang_vaksin_pengeluaran_lihat_print_bast2_bandungkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">VAR</a></td>
							<?php } ?>	
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	
	<?php
		if($datapengeluaran['NamaProgram'] != 'PKD' AND $datapengeluaran['NamaProgram'] != 'BMHP'){
	?>
		<a href="?page=gudang_vaksin_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>&stsprogram=manual" class="btn btn-primary" style="margin-bottom:20px">Manual</a>
		<a href="?page=gudang_vaksin_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>&stsprogram=program" class="btn btn-primary" style="margin-bottom:20px">Program</a>
		<a href="?page=gudang_vaksin_pengeluaran_lihat_proses&nofaktur=<?php echo $datapengeluaran['NoFaktur'];?>&grand=<?php echo $totallama;?>&sts=1&penerima=<?php echo $penerima?>&id=<?php echo $id?>" class="btn btn-md btn-warning" style="margin-bottom:20px">Update Grandtotal</a>
	<?php
		}
	?>
	
	<!--barcode-->
	<?php
	if($_GET['stsprogram'] == ""){	
		if($datapengeluaran['NamaProgram'] == 'PKD' or $datapengeluaran['NamaProgram'] == 'BMHP'){
			$stsprogram = "manual";
		}else{	
			$stsprogram = "program";
		}		
	}else{
		$stsprogram = $_GET['stsprogram'];
	}	
	
	if($stsprogram == 'manual'){
	?>
	
	<!--<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 20px 50px 0px 50px;">
				<div class = "row">
					<table class="table table-striped table-condensed">
						<tr>
							<td class="col-sm-2">Scan Barcode</td>
							<td class="col-sm-10">
								<input type="text" name="barcode" class="form-control barcode" onmouseover="this.focus();" placeholder="Silahkan scan kode barcode" maxlength = "13">
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>-->	

	<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<div class="table-responsive">
						<form action="?page=gudang_vaksin_pengeluaran_lihat_proses" method="post">	
							<table class="table-judul" width="100%">
								<tr>
									<td class="col-sm-2">Nama Barang</td>
									<td class="col-sm-10">
										<input type="text" name="namabarang" class="form-control nama_barang_gudang_vaksin" placeholder="Ketikan Nama Barang" required>
										<input type="hidden" class="form-control namabaranghidden">
										<input type="hidden" class="form-control jumlahstokhidden">
									</td>
								</tr>
								<tr>
									<td>Kode Barang</td>
									<td>
										<input type="text" name="kodebarang" class="form-control kodebarang" readonly>
									</td>
								</tr>
								
								<tr>
									<td>Satuan</td>
									<td>
										<input type="text" name="satuan" class="form-control satuan" readonly>
									</td>
								</tr>
								<tr>
									<td>Batch</td>
									<td>
										<input type="text" name="nobatch" class="form-control nobatch" readonly>
									</td>
								</tr>
								<tr>
									<td>Expire</td>
									<td>
										<input type="text" name="expire" class="form-control expire" readonly>
									</td>
								</tr>
								<tr>
									<td>Harga Beli</td>
									<td>
										<input type="text" name="hargabeli" class="form-control hargabeli" readonly>
									</td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>
										<input type="text" name="stok" class="form-control stok" readonly>
									</td>
								</tr>
								<tr>
									<td>Jumlah</td>
									<td>
										<input type="number" name="jumlah" class="form-control jumlah" maxlength="10">
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Simpan" class="btn btn-md btn-success">
										<a href="?page=gudang_vaksin_pengeluaran_lihat_proses&nofaktur=<?php echo $datapengeluaran['NoFaktur'];?>&grand=<?php echo $totallama;?>&sts=1&penerima=<?php echo $penerima?>&id=<?php echo $id?>" class="btn btn-md btn-warning">Update Grandtotal</a>
										<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){?>
										<a href="?page=gudang_vaksin_pengeluaran_kirim_ulang&nf=<?php echo $datapengeluaran['NoFaktur'];?>&id=<?php echo $datapengeluaran['IdDistribusi'];?>" class="btn btn-md btn-danger">Kirim Ulang</a>
										<?php }	?>
									</td>
									<input type="hidden" class="form-control" name="iddistribusi" value="<?php echo $datapengeluaran['IdDistribusi']?>">
									<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
									<input type="hidden" class="form-control" name="tanggalpengeluaran" value="<?php echo $datapengeluaran['TanggalPengeluaran']?>">
									<input type="hidden" class="form-control" name="kodepenerima" value="<?php echo $datapengeluaran['KodePenerima']?>">
									<input type="hidden" class="form-control" name="statuspengeluaran" value="<?php echo $datapengeluaran['StatusPengeluaran']?>">
									<input type="hidden" class="form-control" name="totallama" value="<?php echo $totallama;?>">
									<input type="hidden" class="form-control" name="penerima" value="<?php echo $datapengeluaran['Penerima'];?>">
									<input type="hidden" class="form-control nofakturterima" name="nofakturterima">
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	}else if($stsprogram == 'program'){
		if($datapengeluaran['NamaProgram'] != 'PKD' AND $datapengeluaran['NamaProgram'] != 'BMHP'){
	?>
		<input type="hidden" class="form-control" name="iddistribusi" value="<?php echo $datapengeluaran['IdDistribusi']?>">
		<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
		<input type="hidden" class="form-control" name="tanggalpengeluaran" value="<?php echo $datapengeluaran['TanggalPengeluaran']?>">
		<input type="hidden" class="form-control" name="kodepenerima" value="<?php echo $datapengeluaran['KodePenerima']?>">
		<input type="hidden" class="form-control" name="statuspengeluaran" value="<?php echo $datapengeluaran['StatusPengeluaran']?>">
		<input type="hidden" class="form-control" name="totallama" value="<?php echo $totallama;?>">

		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th width="5%" rowspan="2">KODE</th>
					<th width="20%" rowspan="2">NAMA BARANG</th>
					<th width="6%" rowspan="2">SATUAN</th>
					<th width="8%" rowspan="2">BATCH</th>
					<th width="6%" rowspan="2">EXPIRE</th>
					<th width="6%" rowspan="2">HARGA SATUAN</th>
					<th width="6%" rowspan="2">STOK</th>
					<th width="5%" rowspan="2">JML</th>
					<th colspan="3">KONDISI</th>
					<th width="5%" rowspan="2">OPSI</th>
				</tr>
				<tr>
					<th width="6%">FREEZE</th>
					<th width="5%">VVM**</th>
					<th width="5%">VCCM**</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$str_vaksin_stok = mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE NamaProgram like '%IMUNISASI%' AND `Stok` > '0' ORDER BY NamaBarang");
					while($dt_vaksin_stok = mysqli_fetch_assoc($str_vaksin_stok)){
						$kodeobat = $dt_vaksin_stok['KodeBarang'];
						$nobatch = $dt_vaksin_stok['NoBatch'];
						
				?>					
						<tr>
							<td align="center" class="kodebarangcls"><?php echo $dt_vaksin_stok['KodeBarang'];?></td>
							<td class="nama" class="namabarangcls"><?php echo $dt_vaksin_stok['NamaBarang'];?></td>
							<td align="center"><?php echo $dt_vaksin_stok['Satuan'];?></td>
							<td align="center" class="nobatchcls"><?php echo $dt_vaksin_stok['NoBatch'];?></td>
							<td align="center" class="expirecls"><?php echo $dt_vaksin_stok['Expire'];?></td>
							<td align="right"><?php echo rupiah($dt_vaksin_stok['HargaBeli']);?></td>
							<!--sengaja dihidden untuk mengirim harga tanpa rupiah-->
							<td align="right" class="hargabelicls" style="display: none;"><?php echo $dt_vaksin_stok['HargaBeli'];?></td>
							<td align="right" class="namaprogramcls" style="display: none;"><?php echo $nmprogram;?></td>
							<td align="right" class="sisastokcls" style="color:red;font-weight:bold"><?php echo rupiah($dt_vaksin_stok['Stok']);?></td>
							<td align="right"><input type="text" class="form-control jumlahcls"></td>
							<td align="right">
								<select name="freeze" class="form-control freezecls">
									<option value="Y">Ya</option>
									<option value="T">Tidak</option>
								</select>
							</td>
							<td align="right">
								<select name="vvm" class="form-control vvmcls">
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</td>
							<td align="right">
								<select name="vccm" class="form-control vccmcls">
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</td>
							<td align="center">
								<input type="hidden" name="nofakturterima" class="form-control nofakturterimacls" value="<?php echo $dt_vaksin_stok['NoFakturTerima'];?>">
								<button class="btn btn-info btn-sm btn-round btnlistsimpan">Simpan</button>
							</td>
						</tr>
				<?php
					}
				?>
			</tbody>	
		</table>	
	<?php
		}
	}
	?>
</div>

<?php
	$jmlbrg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `IdDistribusi`='$id' AND `NoFaktur`='$nf'"));
?>	
<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b><?php echo $jmlbrg." ITEM BARANG,";?> GRAND TOTAL Rp. <?php echo rupiah($totallama);?></b></h3>
			<table class="table-judul-laporan" width="100%">
				<thead>
					<tr>
						<th width="4%" rowspan="2">NO</th>
						<th width="5%" rowspan="2">KODE</th>
						<th width="20%" rowspan="2">NAMA BARANG</th>
						<th width="6%" rowspan="2">SATUAN</th>
						<th width="8%" rowspan="2">BATCH</th>
						<th width="8%" rowspan="2">EXPIRE</th>
						<th width="8%" rowspan="2">SUMBER</th>
						<th width="5%" rowspan="2">TAHUN</th>
						<th width="6%" rowspan="2">HARGA<br/>SATUAN</th>
						<th width="5%" rowspan="2">JML</th>
						<th width="8%" rowspan="2">TOTAL</th>
						<th colspan="3">KONDISI</th>
						<th width="5%" rowspan="2">OPSI</th>
					</tr>
					<tr>
						<th width="6%">FREEZE</th>
						<th width="5%">VVM**</th>
						<th width="5%">VCCM**</th>
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
					
					$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` ".$strcari;
					$str2 = $str." LIMIT $mulai,$jumlah_perpage";
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
						$batch = $data['NoBatch'];
						
						// tbgfk_vaksin_stok, wajib pakai batch karena keterkaitan harga
						$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
						$totals = $dt_gfkstok['HargaBeli'] * $data['Jumlah'];
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeBarang'];?></td>
							<td class="nama"><?php echo $dt_gfkstok['NamaBarang'];?></td>
							<td align="center"><?php echo $dt_gfkstok['Satuan'];?></td>
							<td align="center"><?php echo $data['NoBatch'];?></td>
							<td align="center"><?php echo $dt_gfkstok['Expire'];?></td>
							<td align="center"><?php echo $dt_gfkstok['SumberAnggaran'];?></td>
							<td align="center"><?php echo $dt_gfkstok['TahunAnggaran'];?></td>
							<td align="right"><?php echo rupiah($dt_gfkstok['HargaBeli']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($totals);?></td>
							<td align="center"><?php echo $data['Freeze'];?></td>
							<td align="center"><?php echo $data['Vvm'];?></td>
							<td align="center"><?php echo $data['Vccm'];?></td>
							<td align="center">
								<?php 
									// cek apakah sudah diapprove atau belum, saat penerimaan detail gudang obat puskesmas
									$str_cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StatusValidasi` FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur` = '$data[NoFaktur]' AND `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'"));
									if ($str_cek['StatusValidasi'] == 'Belum' || $str_cek['StatusValidasi'] == ''){ 
								?>
								<a href="?page=gudang_vaksin_pengeluaran_lihat_hapus&id=<?php echo $data['Id'];?>&idds=<?php echo $data['IdDistribusi'];?>&nf=<?php echo $data['NoFaktur'];?>&nfterima=<?php echo $data['NoFakturTerima'];?>&kd=<?php echo $data['KodeBarang'];?>&bt=<?php echo $data['NoBatch'];?>&jml=<?php echo $data['Jumlah'];?>&grand=<?php echo $totallama;?>&ttl=<?php echo $totals;?>&penerima=<?php echo $penerima;?>" class="btn btn-sm btn-round btn-danger btnhapus">Hapus</a>
								<?php } ?>
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
						echo "<li><a href='?page=gudang_vaksin_pengeluaran_lihat&id=$id&nf=$nf&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 
	
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Keterangan : </b><br/>
				- Jika puskesmas sudah Appove pemerimaan, mana tombol hapus tidak akan ditampilkan</p>	
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(".btnlistsimpan").click(function(){
		var kodebarang = $(this).parent().parent().find(".kodebarangcls").text();
		var nobatch = $(this).parent().parent().find(".nobatchcls").text();
		var jumlah = $(this).parent().parent().find(".jumlahcls").val();
		var sisastok = $(this).parent().parent().find(".sisastokcls").text();
		var expire = $(this).parent().parent().find(".expirecls").text();
		var hargabeli = $(this).parent().parent().find(".hargabelicls").text();
		var namaprogram = $(this).parent().parent().find(".namaprogramcls").text();
		var iddistribusi = $("input[name='iddistribusi']").val();
		var nofaktur = $("input[name='nofaktur']").val();
		var kodepenerima = $("input[name='kodepenerima']").val();
		var statuspengeluaran = $("input[name='statuspengeluaran']").val();
		var totallama = $("input[name='totallama']").val();
		var freeze = $(this).parent().parent().find(".freezecls").val();
		var vvm = $(this).parent().parent().find(".vvmcls").val();
		var vccm = $(this).parent().parent().find(".vccmcls").val();
		var nofakturterima = $(this).parent().find(".nofakturterimacls").val();
		// alert(jumlah +" - "+kodebarang+"  - "+nobatch);
		$.post( "?page=gudang_vaksin_pengeluaran_lihat_proses", {nobatch: nobatch,kodepenerima: kodepenerima, statuspengeluaran: statuspengeluaran, kodebarang: kodebarang, expire: expire, jumlah: jumlah, sisastok: sisastok, hargabeli: hargabeli, totallama: totallama,nofaktur: nofaktur, iddistribusi: iddistribusi, freeze: freeze, vvm: vvm, vccm: vccm, nofakturterima: nofakturterima})
		  .done(function( data ) {
			$(".alertss").html(data);
			//location.reload();
		  });
	});
</script>

<div class="alertss"></div>