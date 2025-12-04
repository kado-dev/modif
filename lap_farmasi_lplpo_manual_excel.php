<?php
	error_reporting(0);
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$tblplpomanual_bandungkab = "tblplpomanual_bandungkab_".$kodepuskesmas;
	
	if($bulan == 1){
		$blnsebelumnya= '12';
		$thnsebelumnya = $tahun - 1;
	}else{
		$blnsebelumnya = $bulan - 1;
		if(strlen($blnsebelumnya) == 1){
			$blnsebelumnya = '0'.$blnsebelumnya;
		}
		$thnsebelumnya = $tahun;
	}
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=LPLPO (".$namapuskesmas." ".$sumberanggaran." ".$bulan."-".$tahun.").xls");
	if(isset($tahun)){
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
</style>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN DAN LEMBAR PERMINTAAN OBAT (LPLPO) <?php echo $sumberanggarans?></b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Pelaporan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;">
					<?php
						$bulandepan = $bulan + 1;
						echo nama_bulan($bulan);
					?>
				</td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Permintaan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;">
				<?php 
					$bulandepan = $bulan + 1;
					echo nama_bulan($bulandepan);?>
				</td>
			</tr>
		</table>
	</div>	
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="5%">KODE</th>
					<th width="20%">NAMA BARANG</th>
					<th width="7%">SATUAN</th>
					<th width="7%">STOK <br/>AWAL</th>
					<th width="7%">PENERIMAAN</th>
					<th width="7%">PERSEDIAAN</th>
					<th width="6%">PEMAKAIAN</th>
					<th width="6%">SISA <br/>AKHIR</th>
					<th width="6%">STOK <br/>OPTIMUM</th>
					<th width="6%">PERMINTAAN</th>
					<th width="10%">PEMBERIAN</th>
					<th width="5%">KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($sumberanggaran == 'APBD KAB/KOTA'){ // ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
					$str = "SELECT * FROM `ref_obat_lplpo`";
					$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang`";
				}elseif($sumberanggaran == 'BLUD' OR $sumberanggaran == 'JKN'){ // ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
					$str = "SELECT * FROM `tbgudangpkmstok`
					WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN') GROUP BY NamaBarang";
					$str2 = $str." ORDER BY NamaBarang ASC";
				}						
				// echo $str2;
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if ($sumberanggaran != 'APBN'){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='13'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
					}
					$no = $no + 1;								
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					$namaprogram = $data['NamaProgram'];
					
					// tahap1, stok awal ambil dari stok akhir bulan sebelumnya jika 0 ambil hasil import bulan ini
					$saldoawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal` FROM `$tblplpomanual_bandungkab` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
					$sisaakhir_bulanlalu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SisaAkhir` FROM `$tblplpomanual_bandungkab` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$blnsebelumnya'"));
					if($saldoawal == '0' or $saldoawal == ''){
						$stokawal = $sisaakhir_bulanlalu['SisaAkhir'];
					}else{
						$stokawal = $saldoawal['StokAwal'];
					}
					
					// tahap2, penerimaan 
					if($namaprogram == 'IMUNISASI' OR $namaprogram == 'PROGRAM IMUNISASI' OR $namaprogram == 'BAHAN LABORATORIUM'){
						$strterima = "SELECT SUM(Jumlah) AS Jumlah
						FROM `tbgfk_vaksin_pengeluarandetail` a
						JOIN tbgfk_vaksin_pengeluaran b on a.NoFaktur = b.NoFaktur
						WHERE MONTH(b.TanggalPengeluaran) = '$bulan' AND YEAR(b.TanggalPengeluaran) = '$tahun' AND b.KodePenerima='$kodepuskesmas'
						AND a.KodeBarang='$kodebarang'";
					}else{
						$strterima = "SELECT SUM(Jumlah) AS Jumlah
						FROM `tbgfkpengeluarandetail` a
						JOIN tbgfkpengeluaran b on a.NoFaktur = b.NoFaktur
						WHERE MONTH(b.TanggalPengeluaran) = '$bulan' AND YEAR(b.TanggalPengeluaran) = '$tahun' AND b.KodePenerima='$kodepuskesmas'
						AND a.KodeBarang='$kodebarang'";
					}
					// echo $strterima;
					$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strterima));
					if($penerimaan['Jumlah'] != ''){
						$terima = $penerimaan['Jumlah'];
					}else{
						$terima = 0;
					}
					
					// pengadaan jkn
					$pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
					FROM `tbgudangpkmpengadaandetail` a
					JOIN `tbgudangpkmpengadaan` b on a.NoFaktur = b.NoFaktur
					WHERE MONTH(b.TanggalPengadaan) = '$bulan' AND YEAR(b.TanggalPengadaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
					AND a.KodeBarang='$kodebarang'"));				
					
					if($pengadaan['Jumlah'] != ''){
						$adaan = $pengadaan['Jumlah'];
					}else{
						$adaan = 0;
					}
					
					if($sumberanggaran != 'JKN'){
						$penerimaancls = $terima;
					}else{
						$penerimaancls = $adaan;
					}
					
					// persediaan
					$persediaan = $stokawal + $penerimaancls;
					
					// pemakaian
					$lplpomanual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tblplpomanual_bandungkab` WHERE `Tahun`='$tahun' AND `Bulan`='$bulan' AND `KodeBarang`='$kodebarang'"));
					$pemakaian = $lplpomanual['Pemakaian'];
					
					// sisa
					$sisa = $persediaan - $pemakaian;
					$stokoptimum = $sisa * 1.6;
									
					// permintaan
					if($lplpomanual['Permintaan'] != ''){
						$permintaans = $lplpomanual['Permintaan'];
					}else{
						$permintaans = 0;
					}		
				?>
					<tr style="solid:1px dashed #000;">
						<td style="text-align:right; solid:1px dashed #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; solid:1px dashed #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;"><?php echo $stokawal;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="penerimaancls"><?php echo $penerimaancls;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="persediaancls"><?php echo $persediaan;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="pemakaiancls"><?php echo $pemakaian;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="sisacls"><?php echo $sisa;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="stokoptimumcls">
							<?php 
								if($stokoptimum != 0){
									echo $stokoptimum;
								}else{
									echo "-";												
								}
							?>
						</td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="permintaancls"><?php echo $permintaans;?></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;"></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;"><?php if($sumberanggaran == "APBD KAB/KOTA"){ echo "APBD"; }else{ echo $sumberanggaran; }?></td>
					</tr>
				<?php
					// update $tblplpomanual_bandungkab
					// mysqli_query($koneksi,"UPDATE `$tblplpomanual_bandungkab` SET 
					// `StokAwal`='$stokawal',
					// `Penerimaan`='$penerimaancls',
					// `Persediaan`='$persediaan',
					// `Pemakaian`='$pemakaian',
					// `SisaAkhir`='$sisa',
					// `StokOptimum`='$stokoptimum'
					// WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan' AND `KodeBarang`='$kodebarang'"); 
				}
				?>
			</tbody>
		</table>
	</div>
</div><br/>
<div class="bawahtabel">
	<table width="100%">
		<tr>
			<td></td>
			<td></td>
			<td style="text-align:center;">
				Kepala Puskesmas
				<br>
				<br>
				<br>
				(..............................)
			</td>
			<td></td>
			<td colspan="3" style="text-align:center;">
				Diterima Oleh
				<br>
				<br>
				<br>
				(..............................)
			</td>
			<td></td>
			<td colspan="3" style="text-align:center;">
				Diserahkan Oleh
				<br>
				<br>
				<br>
				(..............................)
			</td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>
<?php
}
?>