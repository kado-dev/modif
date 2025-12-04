<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$tahun = $_GET['tahun'];
	// get data
	$bulanawal = $_GET['bulanawal'];		
	$bulanakhir = $_GET['bulanakhir'];		
	$tahunakhir = $_GET['tahunakhir'];					
	$sumberanggaran = $_GET['sumberanggaran'];				
	$namaprogram = $_GET['namaprogram'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Penerimaan_Realisasi_Barang (".$kota." ".$hariini.").xls");
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
.font22{
	font-size:22px;
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN REALISASI BARANG</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="12%">TGL.TERIMA</th>
					<th width="5%">NO.PEMBUKUAN</th>
					<th width="5%">KODE</th>
					<th width="18%">NAMA BARANG</th>
					<th width="5%">BATCH</th>
					<th width="12%">SUMBER</th>
					<th width="10%">PROGRAM</th>
					<th width="10%">HARGA</th>
					<th width="10%">JUMLAH TERIMA</th>
					<th width="10%">TOTAL TERIMA</th>
				</tr>
			</thead>
			<tbody>
				<?php	
				$no = 0;		
				if($key != ""){
					$namabarang = " AND c.`NamaBarang` like '%$key%'";
				}else{
					$namabarang = "";
				}
								
				$str = "SELECT b.TanggalPenerimaan, a.NomorPembukuan, a.KodeBarang, c.NamaBarang, a.NoBatch, a.SumberAnggaran, a.NamaProgram, a.Harga, a.Jumlah 
				FROM `tbgfkpenerimaandetail` a
				JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
				JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
				WHERE YEAR(b.TanggalPenerimaan) = '$tahun' AND MONTH(b.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir'
				AND a.`SumberAnggaran`='$sumberanggaran'".$programs.$namabarang;
				$str2 = $str." GROUP BY a.SubTotal, a.KodeBarang, a.NoBatch ORDER BY c.`NamaBarang`";
				// echo $str2;
				
				$query = mysqli_query($koneksi,$str2);						
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$nomorpembukuan = $data['NomorPembukuan'];
					$nobatch = str_replace(",", ", ", $data['NoBatch']);
					$sumber = $data['SumberAnggaran'];
					$total = $data['Harga'] * $data['Jumlah'];
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['TanggalPenerimaan'];?></td>
						<td align="center"><?php echo $data['NomorPembukuan'];?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td align="left"><?php echo $data['NamaBarang'];?></td>
						<td align="left"><?php echo $nobatch;?></td>
						<td align="center"><?php echo $sumber;?></td>
						<td align="center"><?php echo $data['NamaProgram'];?></td>
						<td align="right"><?php echo rupiah($data['Harga']);?></td>
						<td align="right"><?php echo rupiah($data['Jumlah']);?></td>	
						<td align="right"><b><?php echo rupiah($total);?></b></td>	
					</tr>
				<?php
				$jumlah = $jumlah + $total;
				$jumlahbarang = mysqli_num_rows(mysqli_query($koneksi, $str2));
				}	
				?>
					<tr>
						<td align="center" colspan="10"><b>TOTAL <?php echo $jumlahbarang;?> ITEM BARANG</b></td>
						<td align="right"><b><?php echo rupiah($jumlah);?></b></td>
					</tr>
			</tbody>
		</table><br/>
	</div>
</div>