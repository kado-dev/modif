<?php
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	
	$jmltersedia = $_GET['jmltersedia'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Stok_Obat_Gudang_Besar (".$kota." - ".$hariini.").xls");
	if(isset($jmltersedia) and isset($key)){
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK OBAT GUDANG BESAR</b></h4>
	<br/>
</div>

<?php
	if($jmltersedia == 'Tersedia'){
		$stoks = " `Stok` > '0' AND";
	}else{
		$stoks = "";
	}

	if($key !=''){
		$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%')";
	}else{
		$strcari = " `SumberAnggaran` != 'BLUD'";
	}

	$str = "SELECT * FROM `tbgfkstok` WHERE".$stoks.$strcari;
	$str2 = $str." ORDER BY NamaBarang";
	// echo $str2;
	// die();
?>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">No.</th>
					<th width="5%">Kode</th>
					<th width="20%">Nama Barang</th>
					<th width="5%">Satuan</th>
					<th width="8%">Batch</th>
					<th width="7%">Expire</th>
					<th width="6%">Min.Stok</th>
					<th width="8%">Sumber</th>
					<th width="5%">Tahun</th>
					<th width="8%">Program</th>
					<th width="5%">Harga</th>
					<th width="8%">Stok</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;										
					$Expire = $data['Expire'];
					$kodeobat = $data['KodeBarang'];
					$nobatch = $data['NoBatch'];

					// mencari jumlah hari sebelum expire
					$wl = explode("-",$Expire);
					$waktu_expire = mktime(0,0,0,$wl[1],$wl[2],$wl[0]);
					$now = mktime(0,0,0,date("m"),date("d"),date("Y"));
					$selisih = $waktu_expire - $now;
					$day = floor($selisih/86400);
					
					if($data['Stok'] <= $data['MinimalStok']){
						$warna = 'lightblue';
					}else{	
						if($day < 180){	
							if($day > 0){
								$warna = 'yellow';
							}else{
								$warna = 'pink';
							}
						}else{
							$warna = 'white';
						}
					}
					
					if($kota == "KABUPATEN BOGOR"){
						if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
							$sumber = "PKD"; 
						}else{
							$sumber = $data['SumberAnggaran']; 
						}	
					}elseif($kota == "KABUPATEN BANDUNG"){
						if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
							$sumber = "APBD"; 
						}else{
							$sumber = $data['SumberAnggaran']; 
						}
					}elseif($kota == "KABUPATEN BEKASI"){
						if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
							$sumber = "APBD"; 
						}else{
							$sumber = $data['SumberAnggaran']; 
						}	
					}

					if($data['NamaProgram'] == "BAHAN HABIS PAKAI" || $data['NamaProgram'] == "BAHAN MEDIS HABIS PAKAI"){
						$namaprogram = "BMHP";
					}else{
						$namaprogram = $data['NamaProgram'];
					}	
				?>
				<tr style="background:<?php echo $warna;?>;">
					<td align="right"><?php echo $no;?></td>
					<td align="center"><?php echo $data['KodeBarang'];?></td>
					<td class="nama">
						<?php 
							echo $data['NamaBarang']."<br/>";									
							if($data['NamaTambahan'] != "-"){
						?>
							<span style='font-style: italic'><?php echo $data['NamaTambahan'];?></span>
						<?php } ?>
					</td>
					<td align="center"><?php echo $data['Satuan'];?></td>
					<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
					<td align="center"><?php echo $data['Expire'];?></td>
					<td align="right"><?php echo $data['MinimalStok'];?></td>
					<td align="center"><?php echo $sumber;?></td>
					<td align="center"><?php echo $data['TahunAnggaran'];?></td>
					<td align="center"><?php echo $namaprogram;?></td>
					<td align="right"><?php echo number_format("$data[HargaBeli]",2,",",".");?></td>
					<td align="right" style="color:red;font-weight:bold">
						<?php 
							// 1. stok awal, ini ngambil sisa stok yang bulan des 2019
							$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodeobat ' AND `NoBatch`='$nobatch'";
							$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
							if ($dt_stokawal_dtl['Stok'] != null){
								$stokawal = $dt_stokawal_dtl['Stok'];
							}else{
								$stokawal = '0';
							}	
																
							// 2. penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
							if($kota == "KABUPATEN BEKASI"){
								$str_penerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodeobat ' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPenerimaan) > '2019'";
							}else{
								$str_penerimaan = "SELECT NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'";
								
							}	
							// echo $str_penerimaan;
							
							$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
							if ($dt_penerimaan_dtl['Jumlah'] != null){
								$penerimaan = $dt_penerimaan_dtl['Jumlah'];
							}else{
								$penerimaan = '0';
							}
							
							// 3. pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
							if ($kota == "KABUPATEN BEKASI"){
								$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodeobat' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'";
							}else{
								$str_pengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodeobat' AND `NoBatch` = '$nobatch'";
							}	
							// echo $str_pengeluaran;
							
							$dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
							if ($dt_pengeluaran_dtl['Jumlah'] != null){
								$pengeluaran = $dt_pengeluaran_dtl['Jumlah'];
							}else{
								$pengeluaran = '0';
							}
		
							// 4. sisastok, jika penerimaan 0, ngambil dari stok awal
							if($penerimaan == 0){
								$sisastok = $stokawal - $pengeluaran;
							}else{
								$sisastok = $stokawal + $penerimaan - $pengeluaran;
							}
							
							// 5. Jika stok tidak sama dengan sisastok (kartu stok), maka update
							if($data['Stok'] != $sisastok){
								mysqli_query($koneksi, "UPDATE `tbgfkstok` SET `Stok`= '$sisastok' WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'");
							}
								
							echo $sisastok."<br/>";	
						?>
					</td>		
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>