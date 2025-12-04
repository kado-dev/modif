<?php
include "config/koneksi.php";
$kodepuskesmas = $_GET['kp'];
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
	display: none;
}
.printheader h4{
	font-size:16px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:16px;
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
	display:none;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan RKO Puskesmas</h1>
		</div>
	</div>
</div>
<?php
$tahun = date('Y');
$tahun1 = $tahun - 1;

if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
?>
<div class="row printheader">
	<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN RENCANA KEBUTUHAN OBAT (RKO)</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo $tahun?></span><br/>
</div>
<div class="row font10">
	<div class="col-sm-12">
		<table class="table table-condensed">
			<thead style="font-size:10px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="2" style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;">No</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
					<th rowspan="2" style="text-align:center;width:3.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Barang</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Satuan</th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Sisa Stok per 31 Desember <?php echo $tahun1?></th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Pemakaian Rata2 Per Bulan Tahun <?php echo $tahun1?></th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah Kebutuhan Tahun <?php echo $tahun?></th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Rencana Kebutuhan Tahun <?php echo $tahun?></th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Rencana Pengadaan Tahun <?php echo $tahun?></th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Realisasi Pengadaan Tahun <?php echo $tahun1?></th>
					<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Keterangan</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;">(a)</th>
					<th style="text-align:center;width:0.4%;vertical-align:middle; border:1px dashed #000; padding:3px;">(b)</th>
					<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;">(c) = (b) x 18</th>
					<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;">(d) = (c) - (a)</th>
					<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;"></th>
					<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;"></th>
					<th style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;"></th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
			<?php
				// gudang obat puskesmas
				$str = "SELECT * FROM `tbgudangpkmstok`a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
				WHERE b.`SumberAnggaran` <> 'BLUD' AND b.KelasTherapy <> 'VAKSIN' AND a.`KodePuskesmas`='$kodepuskesmas' 
				GROUP BY b.NamaBarang";
				$str2 = $str." order by b.NamaBarang";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kodebarang = $data['KodeBarang'];
				$namabarang = $data['NamaBarang'];
				
				// Sisa Stok 1 Tahun Sebelumnya
				$sisa_stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_sisastok` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
				// echo "SELECT Jumlah FROM `tbrko_pkm_sisastok` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'";
				// pemakaian rata2 1 Tahun Sebelumnya
				$pemakaian_rata = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_pemakaianrata` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
				$jumlah_kebutuhan = $pemakaian_rata * 18;
				$rencana_kebutuhan = $jumlah_kebutuhan - $sisa_stok;
				
				$rencana_pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_rencana` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun'"))['Jumlah'];
				$rencana_realisasi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_realisasi` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
				?>
				<tr>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;" class="kodebarangs"><?php echo $kodebarang;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $namabarang;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Satuan'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="sisastok"><?php echo $sisa_stok;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="pemakaianrata"><?php echo $pemakaian_rata;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jumlah_kebutuhan;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $rencana_kebutuhan;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="rencanapengadaan"><?php echo $rencana_pengadaan;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="rencanarealisasi"><?php echo $rencana_realisasi;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;">-</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<div class="row noprint">
	<div class="col-lg-12">
		<div class="alert alert-block alert-info fade in">
			<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
			<p><b>Perhatikan :</b> Jika nama barang tidak tampil, silahkan ceklist penerimaan barang pada menu Gudang Obat Puskesmas.</p>
		</div>
	</div>
</div>