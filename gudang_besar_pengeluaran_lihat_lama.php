<?php
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$penerima = $_GET['penerima'];
	include "config/helper_report.php";	
	
	// untuk mengupdate grandtotal
	$str3= "SELECT * FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nf'";
	$query3 = mysqli_query($koneksi,$str3);	
	while($data3 = mysqli_fetch_assoc($query3)){
		$kdbrg = $data3['KodeBarang'];
		$batch = $data3['NoBatch'];
		// tbgfkstok
		$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
		$jumlah = $dt_gfkstok['HargaBeli'] * $data3['Jumlah'];
		$totallama = $jumlah + $totallama;
	}
		
	// data pengeluaran
	$datapengeluaran=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nf'"));
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
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA PENGELUARAN </b><small>Gudang Besar</small></h3>
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="20%">No.Faktur</th>
							<th width="25%">Penerima</th>
							<th width="15%">Program</th>
							<th width="25%">Pengentry</th>
							<th width="20%" colspan="2">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo $datapengeluaran['NoFaktur']?></td>
							<td align="center"><?php echo $datapengeluaran['Penerima']?></td>
							<td align="center"><?php echo $datapengeluaran['NamaProgram']?></td>
							<td align="center"><?php echo $datapengeluaran['NamaPegawaiSimpan']?></td>
							<?php if($_SESSION['kota']=='KABUPATEN BANDUNG' || $_SESSION['kota']=='KABUPATEN BEKASI'){?>
							<td align="center"><a href="gudang_besar_pengeluaran_lihat_print.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">Print</a></td>
							<?php }elseif($_SESSION['kota']=='KABUPATEN BOGOR' || $_SESSION['kota']=='KOTA TARAKAN'){?>
							<td align="center"><a href="gudang_besar_pengeluaran_lihat_print_bogorkab.php?id=<?php echo $id?>&nf=<?php echo $nf?>" class="btnsimpan">Print</a></td>
							<td align="center"><a href="gudang_besar_pengeluaran_lihat_excel.php?id=<?php echo $id;?>&nf=<?php echo $nf;?>&penerima=<?php echo $penerima;?>" class="btnsimpan">Excel</a></td>
							<?php }?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>	
	
	<?php
		if($datapengeluaran['NamaProgram'] != 'PKD' AND $datapengeluaran['NamaProgram'] != 'BMHP'){
	?>
		<a href="?page=gudang_besar_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>&stsprogram=manual" class="btn btn-primary" style="margin-bottom:20px">Manual</a>
		<a href="?page=gudang_besar_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>&stsprogram=program" class="btn btn-primary" style="margin-bottom:20px">Program</a>
		<a href="?page=gudang_besar_pengeluaran_lihat_proses&nofaktur=<?php echo $datapengeluaran['NoFaktur'];?>&grand=<?php echo $totallama;?>&sts=1&penerima=<?php echo $penerima?>&id=<?php echo $id?>" class="btn btn-md btn-warning" style="margin-bottom:20px">Update Grandtotal</a>
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
				<form action="?page=gudang_besar_pengeluaran_lihat_proses" method="post">	
					<div class="form-group row">
						<div class="col-sm-2">Nama Barang</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-10">
									<input type="text" class="form-control nama_barang_gudang_besar" placeholder="Ketikan Nama Barang" required>
									<input type="hidden" name="namabarang" class="form-control namabaranghidden">
									<input type="hidden" class="form-control jumlahstokhidden">
								</div>
								<div class="col-sm-2">
									<input type="text" name="kodebarang" class="form-control kodebarang" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Program</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-6">
									<input type="text" name="program" class="form-control program" readonly>
								</div>
								<div class="col-sm-1">
									Satuan
								</div>
								<div class="col-sm-5">
									<input type="text" name="satuan" class="form-control satuan" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Batch</div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-6">
									<input type="text" name="nobatch" class="form-control nobatch" readonly>
								</div>
								<div class="col-sm-1">
									Expire
								</div>
								<div class="col-sm-5">
									<input type="text" name="expire" class="form-control expire" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Harga Satuan</div>
						<div class="col-sm-10">	
							<div class="row">
								<div class="col-sm-6">
									<input type="text" name="hargabeli" class="form-control hargabeli" readonly>
								</div>
								<div class="col-sm-1">
									Stok
								</div>
								<div class="col-sm-5">
									<input type="text" name="stok" class="form-control stok" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">Jumlah</div>
						<div class="col-sm-10">
							<input type="number" name="jumlah" class="form-control jumlah" maxlength="10">
						</div>
					</div><br/>
					<div class="text-center">
						<div class="row">
							<div class="col-sm-4">
								<input type="submit" value="Simpan" class="btnsimpan">
							</div>
							<div class="col-sm-4">						
								<a href="?page=gudang_besar_pengeluaran_lihat_proses&nofaktur=<?php echo $datapengeluaran['NoFaktur'];?>&grand=<?php echo $totallama;?>&sts=1&penerima=<?php echo $penerima?>&id=<?php echo $id?>" class="btninfo">Update Grandtotal</a>
							</div>
							<div class="col-sm-4">	
							<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){?>
							<a href="?page=gudang_besar_pengeluaran_kirim_ulang&nf=<?php echo $datapengeluaran['NoFaktur'];?>&id=<?php echo $datapengeluaran['IdDistribusi'];?>" class="btndanger">Kirim Ulang</a>
							<?php }	?>
							</div>
						</div>
					</div>
					<input type="hidden" class="form-control" name="iddistribusi" value="<?php echo $datapengeluaran['IdDistribusi']?>">
					<input type="hidden" class="form-control" name="nofaktur" value="<?php echo $datapengeluaran['NoFaktur']?>">
					<input type="hidden" class="form-control" name="tanggalpengeluaran" value="<?php echo $datapengeluaran['TanggalPengeluaran']?>">
					<input type="hidden" class="form-control" name="kodepenerima" value="<?php echo $datapengeluaran['KodePenerima']?>">
					<input type="hidden" class="form-control" name="statuspengeluaran" value="<?php echo $datapengeluaran['StatusPengeluaran']?>">
					<input type="hidden" class="form-control" name="totallama" value="<?php echo $totallama;?>">
					<input type="hidden" class="form-control" name="penerima" value="<?php echo $datapengeluaran['Penerima'];?>">							
				</form>
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
			<table class="table-judul-laporan">
				<thead>
					<tr>
						<th width="7%">Kode</th>
						<th width="25%">Nama Barang</th>
						<th width="6%">Satuan</th>
						<th width="8%">Batch</th>
						<th width="8%">Expire</th>
						<th width="8%">Harga</th>
						<th width="6%">Stok</th>
						<th width="5%">Jml</th>
						<th width="5%">Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$nmprogram = $datapengeluaran['NamaProgram'];
						$strquery = mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE NamaProgram = '$nmprogram' AND `Stok` > 0  AND `Expire` > curdate() ORDER BY NamaBarang, NoBatch");
						while($dtobat = mysqli_fetch_assoc($strquery)){
							$kodeobat = $dtobat['KodeBarang'];
							$namaobat = $dtobat['NamaBarang'];
							$nobatch = $dtobat['NoBatch'];
							$stok = $dtobat['Stok'];
							$harga = $dtobat['HargaBeli'];
				
							// tahap1, stok awal, ini ngambil sisa stok yang bulan des 2019
							$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat ' AND `NoBatch`='$nobatch'";
							$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
							if ($dt_stokawal_dtl['Stok'] != null){
								$stokawal = $dt_stokawal_dtl['Stok'];
							}else{
								$stokawal = '0';
							}	

							// tahap2, penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
							if($kota == "KABUPATEN BEKASI"){
								$str_penerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodeobat ' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan) > '2019'";
							}else{
								$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$dtobat[NoFakturTerima]'";
							}	
							
							$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
							if ($dt_penerimaan_dtl['Jumlah'] != null){
								$penerimaan = $dt_penerimaan_dtl['Jumlah'];
							}else{
								$penerimaan = '0';
							}		
							
							// tahap3, pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
							if ($kota == "KABUPATEN BEKASI"){
								$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodeobat' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'";
							}else{
								$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch` = '$nobatch'";
							}	
							
							$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
							if ($dt_pengeluaran_dtl['Jumlah'] != null){
								$pengeluaran = $dt_pengeluaran_dtl['Jumlah'];
							}else{
								$pengeluaran = '0';
							}
							
							// tahap4, sisastok, jika penerimaan 0, ngambil dari stok awal
							if($penerimaan == 0){
								$sisastok = $stokawal - $pengeluaran;
							}else{
								$sisastok = $stokawal + $penerimaan - $pengeluaran;
							}	
							$saldo = $sisastok * $harga;
					?>					
							<tr>
								<td align="center" class="kodebarangcls"><?php echo $dtobat['KodeBarang'];?></td>
								<td class="nama" class="namabarangcls"><?php echo $dtobat['NamaBarang'];?></td>
								<td align="center"><?php echo $dtobat['Satuan'];?></td>
								<td align="center" class="nobatchcls"><?php echo $dtobat['NoBatch'];?></td>
								<td align="center" class="expirecls"><?php echo $dtobat['Expire'];?></td>
								<td align="right"><?php echo rupiah($dtobat['HargaBeli']);?></td>
								<!--sengaja dihidden untuk mengirim harga tanpa rupiah-->
								<td align="right" class="hargabelicls" style="display: none;"><?php echo $dtobat['HargaBeli'];?></td>
								<td align="right" class="namaprogramcls" style="display: none;"><?php echo $nmprogram;?></td>
								<td align="right" ><?php echo rupiah($sisastok);?></td>
								<td align="right" style="color:red;font-weight:bold"><input type="text" class="form-control jumlahcls"></td>
								<td align="center">
									<button class="btn btn-info btn-sm btnlistsimpan">Simpan</button>
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
	$jmlbrg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluarandetail` WHERE `IdDistribusi`='$id' AND `NoFaktur`='$nf'"));
?>	
<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b><?php echo $jmlbrg." ITEM BARANG,";?> GRAND TOTAL Rp. <?php echo rupiah($totallama);?></b></h3>
			<table class="table-judul-laporan">
				<thead>
					<tr>
						<th width="4%">No.</th>
						<th width="7%">Kode</th>
						<th width="22%">Nama Barang</th>
						<th width="6%">Satuan</th>
						<th width="8%">Batch</th>
						<th width="8%">Expire</th>
						<th width="10%">Sumber</th>
						<th width="5%">Tahun</th>
						<th width="6%">Harga Sat.</th>
						<th width="5%">Jml</th>
						<th width="10%">Total</th>
						<th width="5%">Approve</th>
						<th width="5%">Opsi</th>
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
					
					$str = "SELECT * FROM `tbgfkpengeluarandetail` ".$strcari;
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
						$idbrg = $data['Id'];
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];
						
						// tbgfkstok
						$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' and `NoBatch`='$batch'"));
						$totals = $dt_gfkstok['HargaBeli'] * $data['Jumlah'];
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeBarang'];?></td>
							<td class="nama"><?php echo $dt_gfkstok['NamaBarang'];?></td>
							<td align="center"><?php echo $dt_gfkstok['Satuan'];?></td>
							<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
							<td align="center"><?php echo $dt_gfkstok['Expire'];?></td>
							<td align="center"><?php echo $dt_gfkstok['SumberAnggaran'];?></td>
							<td align="center"><?php echo $dt_gfkstok['TahunAnggaran'];?></td>
							<td align="right"><?php echo rupiah($dt_gfkstok['HargaBeli']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($totals);?></td>
							<td align="center"><?php echo $data['StatusValidasi'];?></td>
							<td align="center">
								<?php  if ($data['StatusValidasi'] == 'Belum'){  ?>
								<a href="?page=gudang_besar_pengeluaran_lihat_hapus&id=<?php echo $data['Id'];?>&idds=<?php echo $data['IdDistribusi'];?>&nf=<?php echo $data['NoFaktur'];?>&kd=<?php echo $data['KodeBarang'];?>&bt=<?php echo $data['NoBatch'];?>&jml=<?php echo $data['Jumlah'];?>&grand=<?php echo $totallama;?>&ttl=<?php echo $totals;?>&penerima=<?php echo $penerima;?>" class="btn btn-xs btn-danger btnhapus">Hapus</a>
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
						echo "<li><a href='?page=gudang_besar_pengeluaran_lihat&id=$id&nf=$nf&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 

</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(".btnlistsimpan").click(function(){
		var kodebarang = $(this).parent().parent().find(".kodebarangcls").text();
		var nobatch = $(this).parent().parent().find(".nobatchcls").text();
		var jumlah = $(this).parent().parent().find(".jumlahcls").val();
		var expire = $(this).parent().parent().find(".expirecls").text();
		var hargabeli = $(this).parent().parent().find(".hargabelicls").text();
		var namaprogram = $(this).parent().parent().find(".namaprogramcls").text();
		var iddistribusi = $("input[name='iddistribusi']").val();
		var nofaktur = $("input[name='nofaktur']").val();
		var kodepenerima = $("input[name='kodepenerima']").val();
		var statuspengeluaran = $("input[name='statuspengeluaran']").val();
		var totallama = $("input[name='totallama']").val();
		if(jumlah == ''){
			alert('Jumlah harus diisi!');
		}else{
		$.post( "?page=gudang_besar_pengeluaran_lihat_proses", {nobatch: nobatch,kodepenerima: kodepenerima, statuspengeluaran: statuspengeluaran, kodebarang: kodebarang, expire: expire, jumlah: jumlah, hargabeli: hargabeli,totallama: totallama,nofaktur: nofaktur, iddistribusi: iddistribusi, namaprogram: namaprogram })
		  .done(function( data ) {
			$(".alertss").html(data);
			//location.reload();
		  });
		}  
	});
</script>

<div class="alertss"></div>