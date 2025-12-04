<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$tahun = $_GET['tahun'];
	$key = $_GET['key'];
	$kodebarang = $_GET['kd'];	
	$nobatch = $_GET['bt'];	
	$tahunini = date('Y');
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Distribusi_Vaksin (".$tahun.").xls");
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
	<span class="font11" style="margin:1px;"><?php echo $key;?></span><br>
		<span class="font11" style="margin:1px;"><?php echo "Periode Laporan : ".$tahun;?></span>
	<br/>
</div><br/>

<?php
	// tahap1, digroup dulu berdasarkan batach
	$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` a 
	JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur
	WHERE YEAR(b.TanggalPengeluaran)='$tahun' AND a.`KodeBarang`='$kodebarang'";								
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
</div>
<?php
}
?>