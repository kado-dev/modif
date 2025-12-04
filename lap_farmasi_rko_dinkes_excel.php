<?php
	session_start();
	include_once('config/koneksi.php');	
	include_once('config/helper_pasienrj.php');
	include_once('config/helper.php');
	$hariini = date('d-m-Y');
	// get data
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPuskesmas` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'"));
	$namapuskesmas = $dtpuskesmas['NamaPuskesmas'];
			
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=RKO_Puskesmas (".$namapuskesmas." ".$sumberanggaran." ".$tahun.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "DINAS PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>RKO PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">SUMBER ANGGARAN : <?php echo $sumberanggaran;?></p>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan : <?php echo $tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">Kode</th>
					<th rowspan="2">Nama Barang</th>
					<th rowspan="2">Satuan</th>
					<th>Sisa Stok per 31 Desember <?php echo $tahun1?></th>
					<th>Pemakaian Rata2 Per Bulan Tahun <?php echo $tahun1?></th>
					<th>Jumlah Kebutuhan Tahun <?php echo $tahun?></th>
					<th>Rencana Kebutuhan Tahun <?php echo $tahun?></th>
					<th>Rencana Pengadaan Tahun <?php echo $tahun?></th>
					<th>Realisasi Pengadaan Tahun <?php echo $tahun1?></th>
					<th>Keterangan</th>
				</tr>
				<tr>
					<th>(a)</th>
					<th style="text-align:center;width:0.4%;vertical-align:middle; border:1px sollid #000; padding:3px;">(b)</th>
					<th>(c) = (b) x 18</th>
					<th>(d) = (c) - (a)</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php					
					if($sumberanggaran == 'APBD KAB/KOTA'){
						// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang`";
					}elseif($sumberanggaran == 'APBN'){
						// $str = "SELECT * FROM `tbgudangpkmstok`
						// WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
						$str = "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
						$str2 = $str." ORDER BY NamaBarang";
					}elseif($sumberanggaran == 'BLUD' OR $sumberanggaran == 'JKN'){
						// ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
						$str = "SELECT * FROM `tbgudangpkmstok`
						WHERE `KodePuskesmas`='$kodepuskesmas' AND (`SumberAnggaran` = 'BLUD' OR `SumberAnggaran` = 'JKN') GROUP BY NamaBarang";
						$str2 = $str." ORDER BY NamaBarang ASC";
					}						
					// echo $str2;
												
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if ($sumberanggaran != 'APBN'){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='11'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}
						}
						$no = $no + 1;								
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						$kdpuskesmas = $_GET['kodepuskesmas'];
						
						// tahap 1, stok awal
						
						if($kodepuskesmas == "semua"){
							$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`StokAwal`) AS StokAwal, SUM(`PemakaianRata`) AS PemakaianRata, SUM(`RencanaPengadaan`) AS RencanaPengadaan, SUM(`RealisasiPengadaan`) AS RealisasiPengadaan  FROM `tbrkobandungkab` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun'"));
							$stokawal = $dtrko['StokAwal'];
							$pemakaianrata = $dtrko['PemakaianRata'];
							$rencanapengadaan = $dtrko['RencanaPengadaan'];
							$realisasipengadaan = $dtrko['RealisasiPengadaan'];
						}else{
							$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal`,`PemakaianRata`,`RencanaPengadaan`,`RealisasiPengadaan` FROM `tbrkobandungkab` WHERE `KodePuskesmas`='$kdpuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$tahun'"));
							$stokawal = $dtrko['StokAwal'];
							$pemakaianrata = $dtrko['PemakaianRata'];
							$rencanapengadaan = $dtrko['RencanaPengadaan'];
							$realisasipengadaan = $dtrko['RealisasiPengadaan'];
						}	
						$jumlah_kebutuhan = $dtrko['PemakaianRata'] * 18;
						$rencana_kebutuhan = $jumlah_kebutuhan - $dtrko['StokAwal'];
					?>
						<tr>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodebarangs"><?php echo $kodebarang;?></td>
							<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $namabarang;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;"><?php echo rupiah($dtrko['StokAwal']);?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;"><?php echo rupiah($dtrko['PemakaianRata']);?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo rupiah($jumlah_kebutuhan);?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo rupiah($rencana_kebutuhan);?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;"><?php echo rupiah($dtrko['RencanaPengadaan']);?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px; background-color:#dbf7ff;"><?php echo rupiah($dtrko['RealisasiPengadaan']);?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;">-</td>
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