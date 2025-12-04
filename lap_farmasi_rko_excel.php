<?php
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = date('m');
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;
	// $namaprogram = $_GET['namaprogram'];
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=RKO Puskesmas (".$namapuskesmas." ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN RKO PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
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
			<tbody style="font-size:10px;">
				<?php
					// gudang obat puskesmas
					// $str = "SELECT * FROM `tbgudangpkmstok`a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
					// WHERE b.`SumberAnggaran` <> 'BLUD' AND a.`KodePuskesmas`='$kodepuskesmas' GROUP BY b.NamaBarang";
					// $str2 = $str." order by b.NamaBarang";
					
					$str = "SELECT * FROM `ref_obat_lplpo`";
					$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang`";
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='11'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
					
						// Sisa Stok 1 Tahun Sebelumnya
						$sisa_stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_sisastok` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
						
						// pemakaian rata2 1 Tahun Sebelumnya
						$pemakaian_rata = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_pemakaianrata` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
						$jumlah_kebutuhan = $pemakaian_rata * 18;
						$rencana_kebutuhan = $jumlah_kebutuhan - $sisa_stok;
						
						$rencana_pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_rencana` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun'"))['Jumlah'];
						$rencana_realisasi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_realisasi` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
					?>
						<tr>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodebarangs"><?php echo $kodebarang;?></td>
							<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $namabarang;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="sisastok"><?php echo $sisa_stok;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="pemakaianrata"><?php echo $pemakaian_rata;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $jumlah_kebutuhan;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $rencana_kebutuhan;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="rencanapengadaan"><?php echo $rencana_pengadaan;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="rencanarealisasi"><?php echo $rencana_realisasi;?></td>
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