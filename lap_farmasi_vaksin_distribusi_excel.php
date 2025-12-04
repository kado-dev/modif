<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$key = $_GET['key'];
	$kodebarang = $_GET['kd'];	
	$nobatch = $_GET['bt'];	
	$tahunini = date('Y');
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Distribusi_Vaksin (".nama_bulan($bulan)." ".$tahun.").xls");
	if(isset($tahunini)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
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

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI VAKSIN</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
	<br/>
</div><br/>

<?php
	// tahap1, digroup dulu berdasarkan batach
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
		// echo "kosong";
		// die();
	}	
?>	

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2">No.</th>
					<th rowspan="2">Nama Sarana</th>
					<th rowspan="2">
						<?php 
							echo "Saldo Awal <br/>";
							echo nama_bulan($bulan)." ".$tahun;
						?>	
					</th>
					<th colspan="31">Jumlah Distribusi</th>
					<th rowspan="2">Jumlah</th>
				</tr>
				<tr style="border:1px solid #000;">
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
					<td style="text-align:right; border:1px solid #000; padding:3px;">1</td>
					<td style="text-align:left; border:1px solid #000; padding:3px;">Total Terima</td>
					<td style="text-align:right; border:1px solid #000; padding:3px;">
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
					<td style="text-align:left; border:1px solid #000; padding:3px;" colspan="31"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($persediaan);?></td>
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
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $databatch['Penerima'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"></td>
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
							
							<td style="text-align:right; border:1px solid #000; padding:3px;">
							<?php
								if($jml['Jumlah'] != ''){
									echo rupiah($jml['Jumlah']);
								}	
							?>
							</td>
							<?php
								}
							?>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml2);?></td>
						</tr>
					<?php } ?>		
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px; background: #a5a5a5;" colspan="34">TOTAL PENGELUARAN</td>
							<td style="text-align:right; border:1px solid #000; padding:3px; background: #a5a5a5;"><?php echo rupiah($jumlahkeluar_bulanini);?></td>
						</tr>
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px; background: #a5a5a5;" colspan="34">SISA STOK</td>
							<td style="text-align:right; border:1px solid #000; padding:3px; background: #a5a5a5;"><?php echo rupiah($sisastok);?></td>
						</tr>
				<?php		
					// }
				}
				?>
				<tr style="border:1px solid #000; font-weight: bold;">
					<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="3">TOTAL PENGELUARAN KESELURUHAN</td>
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
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $countall['Jumlah'];?></td>
					<?php
						}
					?>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jmls);?></td>
				</tr>
				<tr style="border:1px solid #000; font-weight: bold;">
					<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="3">SISA AKHIR</td>
					<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="31"></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;">
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
</div>
<?php
}
?>