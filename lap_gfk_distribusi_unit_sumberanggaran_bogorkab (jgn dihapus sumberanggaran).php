<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI UNIT DETAIL</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_distribusi_unit_sumberanggaran_bogorkab"/>
						<div class="col-sm-2">
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
						<div class="col-sm-2">
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="sumberanggaran" class="form-control">
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
								<option value="APBD PROV" <?php if($_GET['sumberanggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
								<option value="APBN" <?php if($_GET['sumberanggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
								<option value="DAK KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'DAK KAB/KOTA'){echo "SELECTED";}?>>DAK KAB/KOTA</option>
								<option value="LAINNYA" <?php if($_GET['sumberanggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" name ="penerima" class="form-control" placeholder="Ketik Nama Penerima" value="<?php echo $_GET['penerima']?>">
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_distribusi_unit_sumberanggaran_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_distribusi_unit_sumberanggaran_bogorkab_excel.php?&penerima=<?php echo $_GET['penerima'];?>&sumber=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
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
	$sumberanggaran = $_GET['sumberanggaran'];
	$penerima = $_GET['penerima'];
	if (isset($penerima)){
	?>

	<div class="row noprint">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th width="5%">Tgl.Pengeluaran</th>
							<th width="25%">Nama Barang</th>
							<th width="10%">Sumber Anggaran</th>
							<th width="10%">Harga Satuan</th>
							<th width="10%">Jumlah</th>
							<th width="10%">Sub Total</th>
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
							
							$str = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur=b.NoFaktur 
							WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND
							b.SumberAnggaran = '$sumberanggaran' AND a.Penerima LIKE '%$penerima%'";
							$str2 = $str."  LIMIT $mulai,$jumlah_perpage";
							// echo $str2;	
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while ($dt_brg = mysqli_fetch_assoc($query)){
								if($nomorfaktur != $dt_brg['NoFaktur']){
									$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
									FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
									WHERE a.NoFaktur = '$dt_brg[NoFaktur]'";
									$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
									echo "<tr style='border:1px solid #000; font-weight: bold; background: #adabab;'><td colspan='9'>$dt_brg[NoFaktur], $dt_brg[Penerima], Rp.$dtgt[Jumlah]</td></tr>";
									$nomorfaktur = $dt_brg['NoFaktur'];
									$no = 0;
								}
								$no = $no + 1;								
								
								// tbgfkstok
								$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
								$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
								<td align="left"><?php echo $dtgfkstok['NamaBarang'];?></td>
								<td align="center"><?php echo $dt_brg['SumberAnggaran'];?></td>
								<td align="right"><?php echo rupiah($dt_brg['Harga']);?></td>
								<td align="right"><?php echo $dt_brg['Jumlah'];?></td>
								<td align="right"><?php echo rupiah($subtotal);?></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table><br/>
			</div>
		</div>
		<div class="hasilmodal"></div>
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
							echo "<li><a href='?page=lap_gfk_distribusi_unit_sumberanggaran_bogorkab&bulan1=$bulan1&bulan2=$bulan2&tahun=$tahun&sumberanggaran=$sumberanggaran&penerima=$penerima&h=$i'>$i</a></li>";
						}
					}
				}
			?>	
		</ul>
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