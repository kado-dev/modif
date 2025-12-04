<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$sumberanggaran = $_GET['sumberanggaran'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Persediaan_Barang (".$hariini.").xls");
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
	<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN BARANG <?php echo $sumberanggarans?></b></span><br>
	<?php if($opsiform == 'bulan'){ ?>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></span>
	<?php }else{ ?>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></span>
	<?php } ?>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<?php
				$datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
			?>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datakecamatan['KodePuskesmas'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datakecamatan['NamaPuskesmas'];?></td>
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
				<td style="padding:2px 4px;">-
				<?php 
					// $bulandepan = $bulan + 1;
					// echo nama_bulan($bulandepan);
				?>
				</td>
			</tr>
		</table>
	</div>	
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9.5px;">
				<tr>
					<th width="3%">No.</th>
					<th width="5%">Kode</th>
					<th width="22%">Nama Barang</th>
					<th width="7%">Merk/Type</th>
					<th width="12%">Tahun Pengadaan/Pembelian</th>
					<th width="7%">Stok Awal</th>
					<th width="7%">Pengadaan</th>
					<th width="7%">Pemakaian</th>
					<th width="7%">Sisa Stok</th>
					<th width="5%">Satuan</th>
					<th width="7%">Harga Satuan</th>
					<th width="7%">Total Nilai Perolehan</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
			$jumlah_perpage = 100;
						
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			if($sumberanggaran == 'APBD'){
				$sumber = " AND b.SumberAnggaran like '%APBD%'";
			}else if ($sumberanggaran == 'APBN'){
				$sumber = " AND b.SumberAnggaran like '%APBN%'";
			}else if ($sumberanggaran == 'BLUD'){
				$sumber = " AND b.SumberAnggaran = 'BLUD'";
			}else{
				$sumber = "";
			}
			
			$str = "SELECT * FROM `tbgudangpkmstok` a
			JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
			WHERE a.`KodePuskesmas`='$kodepuskesmas'".$sumber;
			$str2 = $str." ORDER BY b.`NamaBarang` limit $mulai,$jumlah_perpage";
		    // echo $str2;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kodebarang = $data['KodeBarang'];
				
				// stok awal gudang obat puskesmas
				$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Stok FROM `tbstokbulananpuskesmas` WHERE KodePuskesmas='$kodepuskesmas' AND KodeBarang='$kodebarang' AND `Tahun`='$tahun'"));
				if($dtstokawal['Stok'] != ''){
					$ttlstokawal = $dtstokawal['Stok'];
				}else{
					$ttlstokawal = 0;
				}
				
				// tbgudangpkmpengadaandetail
				$dtpengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS JUMLAH FROM `tbgudangpkmpengadaandetail` WHERE `KodeBarang` = '$kodebarang' AND SUBSTRING(NoFaktur,1,11)='$kodepuskesmas'"));
				
				// tbgudangpkmpenerimaandetail
				// $dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgudangpkmpenerimaandetail` WHERE `KodeBarang` = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas'"));
				$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
				FROM `tbgfkpengeluarandetail` a 
				JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
				WHERE a.`KodeBarang` = '$kodebarang' AND b.`KodePenerima`='$kodepuskesmas'"));
				
				if ($sumberanggaran != 'BLUD'){
					$penerimaan = $dtpenerimaan['Jumlah'];
				}else{
					$penerimaan = $dtpengadaan['Jumlah'];
				}
				
				// pemakaian
				$dtpemakaian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbpemakaianobatpuskesmas` WHERE `KodeBarang` = '$kodebarang' AND `KodePuskesmas` = '$kodepuskesmas'"));
				if ($dtpemakaian['Jumlah'] != '' || $dtpemakaian['Jumlah'] != null){
					$pemakaian = $dtpemakaian['Jumlah'];
				}else{
					$pemakaian = '0';
				}
			
				// sisastok
				$sisastok = $ttlstokawal + $penerimaan - $dtpemakaian['Jumlah'];
				
				// nilaiperolehan
				$nilaiperolehan = $sisastok * $data['HargaBeli'];
			?>
				<tr style="border:1px dashed #000;">
					<td><?php echo $no;?></td>
					<td><?php echo $data['KodeBarang'];?></td>
					<td><?php echo $data['NamaBarang']." - ".$data['NoBatch'];?></td>
					<td><?php echo $data['KelasTherapy'];?></td>
					<td><?php echo $data['SumberAnggaran']." - ".$data['TahunAnggaran'];?></td>
					<td><?php echo rupiah($ttlstokawal);?></td>
					<td><a href="#" class="btnmodalpegawai"><?php echo rupiah($penerimaan);?></a></td>
					<td><?php echo rupiah($pemakaian);?></td>
					<td><?php echo rupiah($sisastok);?></td>
					<td><?php echo $data['Satuan'];?></td>
					<td><?php echo rupiah($data['HargaBeli']);?></td>
					<td><?php echo rupiah($nilaiperolehan);?></td>
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