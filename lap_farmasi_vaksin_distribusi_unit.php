<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DISTRIBUSI VAKSIN UNIT DETAIL</b></h3>
			<form role="form">
				<div class="formbg">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_vaksin_distribusi_unit"/>
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
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="statuspengeluaran" class="form-control" required>
								<option value="SEMUA" <?php if($_GET['statuspengeluaran'] == 'SEMUA'){echo "SELECTED";}?>>SEMUA</option>
								<option value="PUSKESMAS" <?php if($_GET['statuspengeluaran'] == 'PUSKESMAS'){echo "SELECTED";}?>>PUSKESMAS</option>
								<option value="RUMAH SAKIT" <?php if($_GET['statuspengeluaran'] == 'RUMAH SAKIT'){echo "SELECTED";}?>>RUMAH SAKIT</option>
								<option value="LAINNYA" <?php if($_GET['statuspengeluaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
							</select>
						</div>
						<div class="col-md-4">
							<input type="text" name ="penerima" class="form-control" placeholder="Ketik manual (Puskesmas / RS)" value="<?php echo $_GET['penerima']?>">
						</div><br/>
					</div>	
					<div class="row" style="padding-top: 10px;">
						<div class="col-md-7">
							<input type="text" name="namabarang" class="form-control nama_barang_vaksin_group" placeholder="Ketik Nama Barang (Automatic)" value="<?php echo $_GET['namabarang']?>">
						</div>
						<div class="col-md-2">
							<input type="text" name="kodebarang" class="form-control kodevaksin" value="<?php echo $_GET['kodebarang']?>" readonly>
						</div>
						<div class="col-md-2">
							<input type="text" name="nobatch" class="form-control nobatch" value="<?php echo $_GET['nobatch']?>" readonly>
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_vaksin_distribusi_unit" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-success"><span class="fa fa-print"></a>
							<a href="lap_farmasi_vaksin_distribusi_unit_excel.php?&bulan1=<?php echo $_GET['bulan1'];?>&bulan2=<?php echo $_GET['bulan2'];?>&tahun=<?php echo $_GET['tahun'];?>&statuspengeluaran=<?php echo $_GET['statuspengeluaran'];?>&penerima=<?php echo $_GET['penerima'];?>&kodebarang=<?php echo $_GET['kodebarang'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</div>
			</form>	
		</div>
	</div>
	<?php
	$no = 0;
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$statuspengeluaran = $_GET['statuspengeluaran'];
	$penerima = $_GET['penerima'];
	$namabarang = $_GET['namabarang'];
	$kodebarang = $_GET['kodebarang'];
	$nobatch = $_GET['nobatch'];
	if (isset($penerima)){
	?>

		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI VAKSIN (PER-UNIT)</b></span><br>
			<br/>
		</div>
			
		<div class="table-responsive noprint">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Pengeluaran</th>
						<th width="52%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Program</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga Satuan</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sub Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$jumlah_perpage = 200;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($statuspengeluaran == "SEMUA"){
							$status = " ";
						}else{
							$status = "AND a.`StatusPengeluaran`='$statuspengeluaran'";
						}
												
						$str = "SELECT * FROM tbgfk_vaksin_pengeluaran a JOIN tbgfk_vaksin_pengeluarandetail b ON a.NoFaktur=b.NoFaktur 
						WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' 
						AND a.Penerima LIKE '%$penerima%' AND b.KodeBarang = '$kodebarang' AND b.NoBatch = '$nobatch' ".$status;
						$str2 = $str."  ORDER BY a.NoFaktur LIMIT $mulai,$jumlah_perpage";
						echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while ($dt_brg = mysqli_fetch_assoc($query)){
							if($nomorfaktur != $dt_brg['NoFaktur']){
								$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfk_vaksin_pengeluarandetail a JOIN tbgfk_vaksin_pengeluaran b ON a.NoFaktur = b.NoFaktur
								WHERE a.NoFaktur = '$dt_brg[NoFaktur]'";
								$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
								$harga = rupiah($dtgt['Jumlah']);
								echo "<tr style='border:1px solid #000; font-weight: bold; background: #adabab;'>
										<td colspan='9'>$dt_brg[NoFaktur], $dt_brg[Penerima], Rp.$harga</td>
									 </tr>";
								$nomorfaktur = $dt_brg['NoFaktur'];
								$no = 0;
							}
							$no = $no + 1;								
							
							// tbgfk_vaksin_stok
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`NoBatch` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
							$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
					?>
						<tr>
							<td style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
							<td style="text-align:left;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['NamaBarang'].", Batch : ".$dt_brg['NoBatch'];?></td>
							<td style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_brg['NamaProgram'];?></td>
							<td style="text-align:right;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_brg['Harga']);?></td>
							<td style="text-align:right;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_brg['Jumlah'];?></td>
							<td style="text-align:right;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($subtotal);?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table><br/>
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
							echo "<li><a href='?page=lap_farmasi_vaksin_distribusi_unit&bulan1=$bulan1&bulan2=$bulan2&tahun=$tahun&statuspengeluaran=$statuspengeluaran&penerima=$penerima&namabarang=$namabarang&kodebarang=$kodebarang&h=$i'>$i</a></li>";
						}
					}
				}
			?>	
		</ul>
		
		<!--untuk print-->
		<div class="table-responsive printbody">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No1.</th>
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Pengeluaran</th>
						<th width="52%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Program</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga Satuan</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sub Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;		
						$str = "SELECT * FROM tbgfk_vaksin_pengeluaran a JOIN tbgfk_vaksin_pengeluarandetail b ON a.NoFaktur=b.NoFaktur 
						WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' 
						AND a.Penerima LIKE '%$penerima%' AND b.KodeBarang = '$kodebarang' ".$status;
						$str2 = $str;
						
						$query = mysqli_query($koneksi,$str);
						while ($dt_brg = mysqli_fetch_assoc($query)){
							if($nomorfaktur != $dt_brg['NoFaktur']){
								$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfk_vaksin_pengeluarandetail a JOIN tbgfk_vaksin_pengeluaran b ON a.NoFaktur = b.NoFaktur
								WHERE a.NoFaktur = '$dt_brg[NoFaktur]'";
								$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
								$harga = rupiah($dtgt['Jumlah']);
								echo "<tr style='border:1px solid #000; font-weight: bold; background: #adabab;'>
										<td colspan='7'>$dt_brg[NoFaktur], $dt_brg[Penerima], Rp.$harga</td>
									 </tr>";
								$nomorfaktur = $dt_brg['NoFaktur'];
								$no = 0;
							}
							$no = $no + 1;								
							
							// tbgfk_vaksin_stok
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
							$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
					?>
						<tr>
							<td style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_brg['TanggalPengeluaran'];?></td>
							<td style="text-align:left; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['NamaBarang'].", Batch : ".$dt_brg['NoBatch'];?></td>
							<td style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_brg['NamaProgram'];?></td>
							<td style="text-align:right; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_brg['Harga']);?></td>
							<td style="text-align:right; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_brg['Jumlah'];?></td>
							<td style="text-align:right; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($subtotal);?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table><br/>
		</div>
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