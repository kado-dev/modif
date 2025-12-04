<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	$hariini = date('d-m-Y');
    $nf = $_GET['nf'];
	$unit = $_GET['unit'];
	$bulan = $_GET['bl'];
    $tahun = $_GET['th'];
    $sumberanggaran = $_GET['sa'];
    $namapuskesmas = $_SESSION['namapuskesmas'];
    $kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Harga Distribusi (".$bulan.").xls");
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
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN HARGA DISTRIBUSI</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table id="" class="table-judul-form" border="1">
        <thead>
			<tr>
				<th width="4%" rowspan="2">No.</th>
				<th width="5%" rowspan="2">Kode</th>
				<th width="20%" rowspan="2">Nama Barang</th>
				<th width="10%" rowspan="2">Satuan</th>
				<th width="30%" rowspan="2">Harga (Distribusi)</th>
				<th width="10%" rowspan="2">Keterangan</th>
			</tr>
		</thead>								
        <tbody>
			<?php
				$no = 0;
				$key = $_GET['key'];
				if($key != ''){
					$keys = " WHERE NamaBarang like '%$key%'";				
				}else{
					$keys = "";
				}		
										
				$str = "SELECT b.KodeBarang, c.NamaBarang, c.Satuan, c.NamaProgram, c.IdLplpo FROM `tbgfkpengeluaran` a 
				JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur 
				JOIN `ref_obat_lplpo` c ON b.KodeBarang = c.KodeBarang WHERE MONTH(a.TanggalPengeluaran)='$bulan' AND YEAR(a.TanggalPengeluaran)='$tahun'";
				$str2 = $str." GROUP BY b.KodeBarang ORDER BY c.IdLplpo, c.NamaBarang ASC";//  LIMIT $mulai,$jumlah_perpage
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprogram != $data['NamaProgram']){
						echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='6'>$data[NamaProgram]</td></tr>";
						$namaprogram = $data['NamaProgram'];
					}	
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					
					// tbgfkstok
					$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE KodeBarang='$kodebarang' AND HargaBeli <> 0"));
			?>
				<tr>
					<td align="right"><?php echo $no;?></td>
					<td align="center"><?php echo $data['KodeBarang'];?></td>
					<td align="left" class="nama"><?php echo $data['NamaBarang'];?></td>		
					<td align="center"><?php echo $data['Satuan'];?></td>	
					<td align="right">
						<?php
							echo rupiah($dtgfkstok['HargaBeli']);
						?>
					</td>
					<td align="right"><?php echo $bulan;?></td>
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