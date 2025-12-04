<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTIBUSI VAKSIN UNIT</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_vaksin_distribusi"/>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
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
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control nama_barang_vaksin_group" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang (Automatic)" required>
							<input type="hidden" class="form-control kodevaksin" name="kodebarang" value="<?php echo $_GET['kodebarang'];?>">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_vaksin_distribusi" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-success"><span class="fa fa-print"></a>
							<a href="lap_farmasi_vaksin_distribusi_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&key=<?php echo $_GET['key'];?>&kd=<?php echo $_GET['kodebarang'];?>&bt=<?php echo $_GET['nobatch'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$key = $_GET['key'];	
	$kodebarang = $_GET['kodebarang'];	
	$nobatch = $_GET['nobatch'];	
	$namabarang = $_GET['namabarang'];	
	$nomorpembukuan = $_GET['nofakturterima'];	

	if($bulan != null AND $tahun != null){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>DISTRIBUSI VAKSIN</b></span><br>
		<span class="font11" style="margin:1px;"><?php echo "Periode Laporan : ".nama_bulan($bulan)." ".$tahun;?></span>
	</div><br/>
	
	<?php
		// tahap1, digroup dulu berdasarkan batch
		$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` a 
		JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
		WHERE YEAR(b.TanggalPengeluaran)='$tahun' AND MONTH(b.TanggalPengeluaran)='$bulan' AND a.`KodeBarang`='$kodebarang'";								
		$str2 = $str." GROUP BY a.`NoBatch` ORDER BY a.`NoBatch`";
		// echo $str2;
		
		$cekdata = mysqli_num_rows(mysqli_query($koneksi, $str));
		if($cekdata == 0){
			echo "<script>";
			echo "alert('Data tidak ditemukan...');";
			echo "document.location.href='index.php?page=lap_farmasi_vaksin_distribusi';";
			echo "</script>";
		}	
	?>	
	
	<div>
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">NAMA SARANA</th>
					<th rowspan="2">
						<?php 
							echo "SALDO AWAL <br/>";
							echo strtoupper(nama_bulan($bulan))." ".$tahun;
						?>	
					</th>
					<th colspan="31">JUMLAH DISTRIBUSI</th>
					<th rowspan="2">JUMLAH</th>
				</tr>
				<tr>
					<?php
						$bln = $_GET['bulan'];
						$thn = $_GET['tahun'];
					
						$mulai = 1;
						$selesai = 31;
						for($d = $mulai;$d <= $selesai; $d++){	

					?>
					<th><?php echo $d;?></th>
					<?php
						}
					?>
				</tr>
			</thead>
			<tbody>
				<!--ini row untuk jumlah penerimaan semua barang (saldoawal)-->
				<tr style="border:1px solid #000;">
					<td align="right">1</td>
					<td align="left">TOTAL TERIMA</td>
					<td align="right">
						<?php
						// penerimaan
						$str_penerimaan = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_penerimaandetail` a 
						JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE `KodeBarang`='$kodebarang'";
						$dt_penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));						
							
						// pemakaian
						$str_pemakaian = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
						JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
						WHERE a.`KodeBarang`='$kodebarang' AND MONTH(b.`TanggalPengeluaran`) < $bulan AND YEAR(b.`TanggalPengeluaran`) <= $tahun";
						$dt_pemakaian = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pemakaian));						
						
						// persediaan
						$persediaan =  $dt_penerimaan['Jumlah'] -  $dt_pemakaian['Jumlah'];
						echo rupiah($persediaan);
						?>
					</td>
					<td align="left" colspan="31"></td>
					<td align="right"><?php echo rupiah($persediaan);?></td>
				</tr>
				
				<?php	
				// tahap 2, looping kueri yang perbatch diatas	
				$nomorbatch = "";				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($nomorbatch != $data['NoBatch']){
						// cek jumlah penerimaan
						$str_penerimaan2 = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_penerimaandetail` a 
						JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]'";
						$dt_penerimaan2 = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan2));
						$jumlahterima = $dt_penerimaan2['Jumlah'];
						
						// cek jumlah pengeluaran bulan sebelumnya
						if ($bulan == '01'){
							$bulanlalu = '12';
							$tahuns = $tahun - 1;
							$bulanini = $bulan;
							$tahunini = $tahun;
						}else{
							$bulanlalu = $bulan - 1;  // sengaja dimundurin sebulan agar saat pertamakali ngambil penerimaan awal
							$tahuns = $tahun;
							$bulanini = $bulan;
							$tahunini = $tahun;
						}	
						
						// cek pengeluaran bulan lalu
						$str_pengeluaran_bulanlalu = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
						JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
						WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND YEAR(b.TanggalPengeluaran)='$tahuns' 
						AND MONTH(b.TanggalPengeluaran)<='$bulanlalu'";
						$dt_pengeluaran2_bulanlalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_bulanlalu));
						$jumlahkeluar_bulanlalu = $dt_pengeluaran2_bulanlalu['Jumlah'];
						if($jumlahkeluar_bulanlalu != ""){
							$jumlahkeluar_bulanlalu = $jumlahkeluar_bulanlalu;
						}else{
							$jumlahkeluar_bulanlalu = 0;
						}
						
						// cek pengeluaran bulan ini
						$str_pengeluaran_bulanini = "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
						JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
						WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND YEAR(b.TanggalPengeluaran)='$tahunini' 
						AND MONTH(b.TanggalPengeluaran)='$bulanini'";
						$dt_pengeluaran2_bulanini = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_bulanini));
						$jumlahkeluar_bulanini = $dt_pengeluaran2_bulanini['Jumlah'];
						if($jumlahkeluar_bulanini != ""){
							$jumlahkeluar_bulanini = $jumlahkeluar_bulanini;
						}else{
							$jumlahkeluar_bulanini = 0;
						}	
						
						// tahap3, cek sisa stok bulan ini atau bulan lalu
						$bulansekarang = date('m');
						if($bulanini <> $bulansekarang){
							// bulan lalu
							$sisa = $jumlahterima - $jumlahkeluar_bulanlalu;
							$sisa2 = rupiah($sisa);
							// echo "Terima : ".$jumlahterima."<br/> Keluar : ".$jumlahkeluar_bulanlalu."<br/>";
						}else{
							$sisa = $jumlahterima - $jumlahkeluar_bulanini;	
							$sisa2 = rupiah($sisa);
						}	
						$sisastok = $sisa - $jumlahkeluar_bulanini;
						
						// tahap4, kelompok barang berdasarkan batch
						echo 
						"<tr style='border:1px dashed #000;font-weight: bold;'>
							<td colspan='2'>Batch : $data[NoBatch]</td>
							<td align='right'>$sisa2</td>
							<td colspan='32'></td>
						</tr>";
						$nomorbatch = $data['NoBatch'];
					}
										
					// if($_GET['bulan'] == date('m', strtotime($data['TanggalPengeluaran']))){
				
					// tahap 5, looping berdasarkan batch	
					$strbatch = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` a 
					JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran)='$tahun' AND MONTH(b.TanggalPengeluaran)='$bulan' AND a.`KodeBarang`='$kodebarang'
					AND a.`NoBatch`='$data[NoBatch]' GROUP BY b.Penerima ORDER BY b.Penerima";	
					// echo $strbatch;					
					$querybatch = mysqli_query($koneksi,$strbatch);
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
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(a.Jumlah) as Jumlah 
								FROM `tbgfk_vaksin_pengeluarandetail` a 
								JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang` = '$databatch[KodeBarang]' AND a.`NoBatch` = '$databatch[NoBatch]' AND date(b.TanggalPengeluaran) = '$tanggal' and 
								b.`KodePenerima`='$databatch[KodePenerima]'"; // and a.`NoFaktur`='$databatch[NoFaktur]'
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
							<td align="center" style="background: #a5a5a5;" colspan="34">TOTAL PENGELUARAN</td>
							<td align="right" style="background: #a5a5a5;"><?php echo rupiah($jumlahkeluar_bulanini);?></td>
						</tr>
						<tr>
							<td align="center" style="background: #a5a5a5;" colspan="34">SISA STOK</td>
							<td align="right" style="background: #a5a5a5;"><?php echo rupiah($sisastok);?></td>
						</tr>
				<?php		
					// }
				}
				?>
				<tr style="border:1px solid #000; font-weight: bold;">
					<td align="center" colspan="3">TOTAL PENGELUARAN KESELURUHAN</td>
					<?php
						$jmls = 0;
						for($d3= $mulai;$d3 <= $selesai; $d3++){	
						$tanggal = $thn."-".$bln."-".$d3;
						$strs3 = "SELECT SUM(Jumlah) as Jumlah 
						FROM `tbgfk_vaksin_pengeluarandetail` a
						JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang` = '$kodebarang' AND date(b.TanggalPengeluaran) = '$tanggal'";
						// echo $strs3;
						$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs3));		
						$jmls = $jmls + $countall['Jumlah'];
					?>	
					<td align="center"><?php echo $countall['Jumlah'];?></td>
					<?php
						}
					?>
					<td align="right"><?php echo rupiah($jmls);?></td>
				</tr>
				<tr style="border:1px solid #000; font-weight: bold;">
					<td align="center" colspan="3">SISA AKHIR</td>
					<td align="center" colspan="31"></td>
					<td align="right">
						<?php 
							// sisa akhir		
							$sisaakhir = $persediaan - $jmls;
							echo rupiah($sisaakhir);
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
	}
	?>
</div>	