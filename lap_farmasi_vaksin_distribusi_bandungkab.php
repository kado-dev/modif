<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DISTIBUSI VAKSIN UNIT</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_vaksin_distribusi_bandungkab"/>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-5">
							<input type="text" name="key" class="form-control nama_barang_vaksin_group" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang (Automatic)" required>
							<input type="hidden" class="form-control kodevaksin" name="kodebarang" value="<?php echo $_GET['kodebarang'];?>">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_vaksin_distribusi_bandungkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></a>
							<a href="lap_farmasi_vaksin_distribusi_bandungkab_excel.php?tahun=<?php echo $_GET['tahun'];?>&key=<?php echo $_GET['key'];?>&kd=<?php echo $_GET['kodebarang'];?>&bt=<?php echo $_GET['nobatch'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	$key = $_GET['key'];	
	$kodebarang = $_GET['kodebarang'];	
	$nobatch = $_GET['nobatch'];	
	$namabarang = $_GET['namabarang'];	
	$nomorpembukuan = $_GET['nofakturterima'];	

	if($tahun != null){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>DISTRIBUSI VAKSIN</b></span><br>
		<span class="font11" style="margin:1px;"><?php echo $key;?></span>
		<span class="font11" style="margin:1px;"><?php echo "Periode Laporan : ".$tahun;?></span>
	</div><br/>
	
	<?php
		// tahap1, digroup dulu berdasarkan batch
		$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` a 
		JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
		WHERE YEAR(b.TanggalPengeluaran)='$tahun' AND a.`KodeBarang`='$kodebarang'";								
		$str2 = $str." GROUP BY a.`NoBatch` ORDER BY a.`NoBatch`";	
		// echo $str2;
		
		$cekdata = mysqli_num_rows(mysqli_query($koneksi, $str));
		if($cekdata == 0){
			echo "<script>";
			echo "alert('Data tidak ditemukan...');";
			echo "document.location.href='index.php?page=lap_farmasi_vaksin_distribusi_bandungkab';";
			echo "</script>";
		}	
	?>	
	
	<div>
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th rowspan="2">NO.</th>
					<th rowspan="2">NAMA PENERIMA</th>
					<th rowspan="2">
						<?php 
							echo "PENERIMAAN <br/>";
							echo $tahun;
						?>	
					</th>
					<th colspan="12">JUMLAH DISTRIBUSI (BULAN)</th>
					<th rowspan="2">JUMLAH</th>
				</tr>
				<tr>
					<?php
						$thn = $_GET['tahun'];
						$mulai = 1;
						$selesai = 12;
						for($d = $mulai;$d <= $selesai; $d++){	

					?>
					<th><?php echo $d;?></th>
					<?php
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php	
				// tahap 2, looping kueri yang perbatch diatas	
				$nomorbatch = "";				
				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					if($nomorbatch != $data['NoBatch']){
						// cek jumlah penerimaan
						$str_penerimaan = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_penerimaandetail` a 
						JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'";
						$dt_penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
						$jumlahterima = $dt_penerimaan['Jumlah'];

						// cek pengeluaran bulan ini
						$str_pengeluaran_bulanini = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
						JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
						WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND YEAR(b.TanggalPengeluaran)='$tahun'";
						$dt_pengeluaran2_bulanini = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_bulanini));
						$jumlahkeluar_bulanini = $dt_pengeluaran2_bulanini['Jumlah'];
						if($jumlahkeluar_bulanini != ""){
							$jumlahkeluar_bulanini = $jumlahkeluar_bulanini;
						}else{
							$jumlahkeluar_bulanini = 0;
						}	
						
						// tahap3, cek sisa stok
						$sisa = $jumlahterima - $jumlahkeluar_bulanini;	
						$sisa2 = rupiah($sisa);
						$sisastok = $sisa;
						
						// tahap4, kelompok barang berdasarkan batch
						echo 
						"<tr style='border:1px dashed #000;font-weight: bold;'>
							<td colspan='2'>Batch : $data[NoBatch]</td>
							<td align='right'>$jumlahterima</td>
							<td colspan='13'></td>
						</tr>";
						$nomorbatch = $data['NoBatch'];
					}
										
					// if($_GET['bulan'] == date('m', strtotime($data['TanggalPengeluaran']))){
				
					// tahap 5, looping berdasarkan batch
					$strbatch = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` a 
					JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran)='$tahun' AND a.`KodeBarang`='$kodebarang'
					AND a.`NoBatch`='$data[NoBatch]' GROUP BY b.Penerima ORDER BY b.Penerima";
					// echo $strbatch;

					$querybatch = mysqli_query($koneksi, $strbatch);
					while($databatch = mysqli_fetch_assoc($querybatch)){
						$no = $no + 1;
					?>	
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="left"><?php echo $databatch['Penerima'];?></td>
							<td align="left"></td>
							<?php
								// gak usah where berdasar nofaktur akan kegroup berdasarkan kodebarang dan nobatch
								$jml2 = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
								// $tanggal = $thn."-".$bln."-".$d2;
								$tanggal = $d2;
								$strs = "SELECT SUM(a.Jumlah) as Jumlah 
								FROM `tbgfk_vaksin_pengeluarandetail` a 
								JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang` = '$databatch[KodeBarang]' AND a.`NoBatch` = '$databatch[NoBatch]' AND month(b.TanggalPengeluaran) = '$tanggal' and 
								b.`KodePenerima`='$databatch[KodePenerima]'";
								// echo $strs;
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['Jumlah'];
							?>	
							
							<td align="right">
							<?php
								if($jml['Jumlah'] != ''){
									echo rupiah($jml['Jumlah']);
								}	
							?>
							</td>
							<?php
								}
							?>
							<td align="right"><?php echo rupiah($jml2);?></td>
						</tr>
					<?php } ?>		
						<tr>
							<td align="center" style="background: #a5a5a5;" colspan="15">TOTAL PENGELUARAN</td>
							<td align="right" style="background: #a5a5a5;"><?php echo rupiah($jumlahkeluar_bulanini);?></td>
						</tr>
						<tr>
							<td align="center" style="background: #a5a5a5;" colspan="15">SISA STOK</td>
							<td align="right" style="background: #a5a5a5;"><?php echo rupiah($sisastok);?></td>
						</tr>
				<?php		
					// }
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
	}
	?>
</div>	