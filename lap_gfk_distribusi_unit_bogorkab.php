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
						<div class="col-sm-3">
							<div class="input-group">
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
								<span class="input-group-addon">Program</span>
							</div>						
						</div>						
						<div class="col-sm-2">
							<input type="text" name ="penerima" class="form-control" value="<?php echo $_GET['penerima'];?>" placeholder="Ketik Nama Penerima">
						</div>
						<div class="col-sm-2">
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
				<table class="table-judul">
					<thead>
						<tr>
							<th width="4%">No.</th>
							<th width="8%">Tanggal</th>
							<th width="5%">Jam</th>
							<th width="15%">No.Faktur</th>
							<th width="15%">Penerima</th>
							<th width="15%">Program</th>
							<th width="10%">Keterangan</th>
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
								<td align="left"><?php echo $dt_brg['NoFaktur'];?></td>
								<td align="left"><?php echo $dt_brg['Penerima'];?></td>
								<td align="left"><?php echo $dt_brg['NamaProgram'];?></td>
								<td align="left"><?php echo $dt_brg['Keterangan'];?></td>
								<td align="right">
								<b> 
									<?php 
										$strgt = "SELECT SUM(Jumlah * Harga) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$dt_brg[NoFaktur]'";
										$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
										echo rupiah($dtgt['Jumlah']);
									?>
								</b>
								</td>
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