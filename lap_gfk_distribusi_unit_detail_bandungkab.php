<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DISTRIBUSI UNIT DETAIL</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_distribusi_unit_detail_bandungkab"/>
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
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="namaprg" class="form-control">
								<option value='Semua'>Semua</option>
								<?php
								$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['namaprg'] == $data3['nama_program']){
										echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
									}else{
										echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
							<input type="text" name ="penerima" class="form-control" placeholder="Ketik Nama Penerima" value="<?php echo $_GET['penerima']?>">
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_distribusi_unit_detail_bandungkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></a>-->
							<a href="lap_gfk_distribusi_unit_detail_bandungkab_excel.php?&penerima=<?php echo $_GET['penerima'];?>&namaprg=<?php echo $_GET['namaprg'];?>&tahun=<?php echo $_GET['tahun'];?>&bulan1=<?php echo $_GET['bulan1'];?>&bulan2=<?php echo $_GET['bulan2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$no = 0;
	$bulan1 = $_GET['bulan1'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$namaprg = $_GET['namaprg'];
	$penerima = $_GET['penerima'];
	if (isset($penerima)){
	?>

		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI UNIT (NAMA PROGRAM)</b></span><br>
			<br/>
		</div>
			
		<div class="table-responsive noprint">
			<table class="table-judul">
				<tbody>
					<?php
					if($namaprg == "Semua" || $namaprg == ""){
						$program = "";
					}else{
						$program = "AND a.`NamaProgram`='$namaprg'";
					}
					/* buat menghitung total dalam periode yang dipilih*/
					$strttl = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
					FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' AND b.Penerima like '%$penerima%' ".$program;
					// echo $strttl;
					$dtttl = mysqli_fetch_assoc(mysqli_query($koneksi, $strttl));
					?>
					<tr>
						<td style="text-align:center;width:75%;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL KESELURUHAN</td>
						<td style="text-align:center;width:25%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($dtttl['Jumlah']);?></td>
					</tr>
				</tbody>
			</table><br/>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="5%">TGL.PENGELUARAN</th>
						<th width="25%">NAMA BARANG</th>
						<th width="10%">NAMA PROGRAM</th>
						<th width="10%">HARGA SATUAN</th>
						<th width="10%">JUMLAH</th>
						<th width="10%">SUB TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$jumlah_perpage = 100;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($namaprg == "Semua" || $namaprg == ""){
							$program = "";
						}else{
							$program = "AND b.`NamaProgram`='$namaprg'";
						}
						
						$str = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur=b.NoFaktur 
						WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' 
						AND a.Penerima LIKE '%$penerima%'".$program;
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
								$harga = rupiah($dtgt['Jumlah']);
								echo "<tr style='font-weight: bold; background: #adabab;'>
										<td colspan='9'>$dt_brg[NoFaktur], $dt_brg[Penerima], Rp.$harga</td>
									 </tr>";
								$nomorfaktur = $dt_brg['NoFaktur'];
								$no = 0;
							}
							$no = $no + 1;								
							
							// tbgfkstok
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
							$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
					?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $dt_brg['TanggalPengeluaran'];?></td>
							<td><?php echo $dtgfkstok['NamaBarang'];?></td>
							<td><?php echo $dt_brg['NamaProgram'];?></td>
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
							echo "<li><a href='?page=lap_gfk_distribusi_unit_detail_bandungkab&bulan1=$bulan1&bulan2=$bulan2&tahun=$tahun&namaprg=$namaprg&penerima=$penerima&h=$i'>$i</a></li>";
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
						<th width="3%">No1.</th>
						<th width="5%">Tgl.Pengeluaran</th>
						<th width="25%">Nama Barang</th>
						<th width="10%">Nama Program</th>
						<th width="10%">Harga Satuan</th>
						<th width="10%">Jumlah</th>
						<th width="10%">Sub Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;
						if($namaprg == "Semua" || $namaprg == ""){
							$program = "";
						}else{
							$program = "AND b.`NamaProgram`='$namaprg'";
						}
						
						$str = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur=b.NoFaktur 
						WHERE YEAR(a.TanggalPengeluaran) = '$tahun' AND MONTH(a.TanggalPengeluaran) BETWEEN '$bulan1' AND '$bulan2' 
						AND a.Penerima LIKE '%$penerima%'".$program;
						
						$query = mysqli_query($koneksi,$str);
						while ($dt_brg = mysqli_fetch_assoc($query)){
							if($nomorfaktur != $dt_brg['NoFaktur']){
								$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
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
							
							// tbgfkstok
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$dt_brg[KodeBarang]'"));
							$subtotal = $dt_brg['Harga'] * $dt_brg['Jumlah'];
					?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $dt_brg['TanggalPengeluaran'];?></td>
							<td style="text-align:left;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dtgfkstok['NamaBarang'];?></td>
							<td><?php echo $dt_brg['NamaProgram'];?></td>
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