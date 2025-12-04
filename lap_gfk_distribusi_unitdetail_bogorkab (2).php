<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI UNIT</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_distribusi_unit_bogorkab"/>
						<div class="col-md-2">
							<select name="bulan1" class="form-control">
								<option value="01" <?php if($_GET['bulan1'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan1'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan1'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan1'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan1'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan1'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan1'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan1'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan1'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan1'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan1'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan1'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-md-2">
							<select name="bulan2" class="form-control">
								<option value="01" <?php if($_GET['bulan2'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan2'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan2'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan2'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan2'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan2'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan2'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan2'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan2'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan2'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan2'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan2'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-md-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="namaprogram" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['namaprogram'] == $data3['nama_program']){
										echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
									}else{
										echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
									}
								}
								?>
							</select>
						</div>						
						<div class="col-md-2">
							<input type="text" name ="penerima" class="form-control" placeholder="Ketik Nama Penerima / Program">
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_distribusi_unit_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_distribusi_unit_bogorkab_excel.php?&bulan1=<?php echo $_GET['bulan1'];?>&bulan2=<?php echo $_GET['bulan2'];?>&tahun=<?php echo $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&penerima=<?php echo $_GET['penerima'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$no = 0;
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$namaprogram = $_GET['namaprogram'];
	$penerima = $_GET['penerima'];

	if($penerima == 'semua'){
		$penerima1 = '';
	}else{
		$penerima1 = " AND `Penerima` like '%$_GET[penerima]%'";
	}
	
	if($namaprogram == "semua"){
		$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran) = '$tahun' AND MONTH(TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2'".$penerima1;
		$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
				FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
				WHERE YEAR(b.TanggalPengeluaran) ='$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2'".$penerima1;
	}else{
		$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran) = '$tahun' AND MONTH(TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND `NamaProgram`='$namaprogram'".$penerima1;
		$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
				FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
				WHERE YEAR(b.TanggalPengeluaran) ='$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND a.`NamaProgram`='$namaprogram'".$penerima1;
	}

	if (isset($penerima)){
	?>

	<div class="row noprint">
		<div class="col-lg-12">
			<?php $dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));?>
			<h3 class="judul"><b><?php echo "GRAND TOTAL Rp.".rupiah($dtgt['Jumlah']);?></b></h3>
			<div class="table-responsive">
				<table class="table-judul" id="datatabless">
					<thead>
						<tr>
							<th width="4%">No.</th>
							<th width="8%">Tanggal</th>
							<th width="5%">Jam</th>
							<th width="10%">No.Faktur</th>
							<th width="15%">Penerima</th>
							<th width="15%">Program</th>
							<th width="15%">Keterangan</th>
							<th width="10%">Grand Total (Rp.)</th>
							<th width="5%">Aksi</th>
						</tr>
					</thead>
					<tbody >
						<?php
							$str2 = $str." ORDER BY IdDistribusi DESC";
							$query = mysqli_query($koneksi,$str2);
							while ($dt_brg = mysqli_fetch_assoc($query)){
								$no = $no + 1;
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
								<td align="center"><?php echo $dt_brg['JamPengeluaran'];?></td>
								<td align="center"><?php echo $dt_brg['NoFaktur'];?></td>
								<td align="left"><?php echo $dt_brg['Penerima'];?></td>
								<td align="left"><?php echo $dt_brg['NamaProgram'];?></td>
								<td align="center"><?php echo $dt_brg['Keterangan'];?></td>
								<td align="right"><b><?php echo rupiah($dt_brg['GrandTotal']);?></b></td>
								<td align="center">
									<a href="#" data-urls="lap_gfk_distribusi_unit_bogorkab_modal.php" data-ids="<?php echo $dt_brg['NoFaktur']?>" class="btn btn-xs btn-info btn-white btndetailsmodal" style="cursor:pointer;">Lihat</a>
								</td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table><br/>
			</div>
		</div>
		<div class="hasilmodal"></div>
	</div>
	<!--tabel report-->
	<div class="row printheader">
		<?php
		$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
		$kota1 = $datapuskesmas['Kota'];
		$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
		?>
		<?php 
		if($kdpuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
			<p style="margin:5px;"><?php echo $alamat;?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI BARANG KE PUSKESMAS</b></h4>
		<p style="margin:1px;">Periode Laporan: <?php echo "Bulan ".$bulan1." tahun ".$tahun1." s/d Bulan ".$bulan2." tahun ".$tahun2;?></p>
		<br/>
	</div>

	<div class="row atastabel">
		<div class="col-lg-12">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td>Kode Puskesmas</td>
					<td>:</td>
					<td><?php echo$datapuskesmas['KodePuskesmas'];?></td>
				</tr>
				<tr>
					<td>Puskesmas</td>
					<td>:</td>
					<td><?php echo$datapuskesmas['NamaPuskesmas'];?></td>
				</tr>
				<tr>
					<td>Kecamatan</td>
					<td>:</td>
					<td><?php echo$datapuskesmas['Kecamatan'];?></td>
				</tr>
			</table><p/>
		</div>
	</div>

	<div class="row printbody">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Barcode</th>
							<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="2" style="text-align:center;width:35%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
							<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
							<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Batch</th>
							<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
							<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Harga</th>
							<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$str = "select tbgfkpengeluaran.tanggalPengeluaran,tbgfkpengeluaran.NoFaktur,tbgfkpengeluarandetail.KodeBarang,SUM(tbgfkpengeluarandetail.Jumlah)AS Jumlah from tbgfkpengeluaran join tbgfkpengeluarandetail on tbgfkpengeluaran.Nofaktur = tbgfkpengeluarandetail.Nofaktur
									where MONTH(tbgfkpengeluaran.TanggalPengeluaran) BETWEEN '$bulan1' and '$bulan2' and YEAR(tbgfkpengeluaran.TanggalPengeluaran) BETWEEN '$tahun1' and '$tahun2' and tbgfkpengeluaran.KodePenerima='$kodepuskesmas' group by tbgfkpengeluarandetail.KodeBarang";
							$query = mysqli_query($koneksi,$str);
							$no = 0;
							while ($dt_brg = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$str_gfk = "select Barcode,NamaBarang,Satuan,NoBatch,Expire,HargaBeli from tbgfkstok where KodeBarang = '$dt_brg[KodeBarang]'";
								$dt_gfk = mysqli_fetch_assoc(mysqli_query($koneksi,$str_gfk));
								$harga = $dt_gfk['HargaBeli'];
								$jumlah = $dt_brg['Jumlah'];
								$total = $harga * $jumlah;
						?>
						<tr>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_gfk['Barcode'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_brg['KodeBarang'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_gfk['NamaBarang'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_gfk['Satuan'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_gfk['NoBatch'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_gfk['Expire'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_gfk['HargaBeli']);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_brg['Jumlah']);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total);?></td>
						</tr>
						<?php
							}
						?>
						<tr style="text-align:right; border:1px solid #000; padding:3px;">
							<td colspan="9" style="text-align:center; border:1px solid #000; padding:3px;">TOTAL</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_grandttl['Jumlah'])?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php
	}
	?>
</div>



<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	

	$('.btndetailsmodal').click(function(){
			var geturl = $(this).data('urls');
			var ids = $(this).data('ids');
			// alert(noregistrasi);
			$.post(geturl, {id:ids})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modaldetails').modal('show');
			});
		});
</script>