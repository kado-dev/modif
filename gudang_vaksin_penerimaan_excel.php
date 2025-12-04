<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$kategori = $_GET['kategori'];
	$key = $_GET['key'];
	$tahunini = date('Y');
	$hariini = date('d-m-Y');
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Penerimaan_Barang_Gudang_Vaksin (".$tahunini.").xls");
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN BARANG (GUDANG VAKSIN)</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $hariini;?></span>
	<br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">No</th>
					<th width="8%">Tanggal</th>
					<th width="8%">No.Pembukuan</th>
					<th width="20%">Supplier</th>
					<th width="15%">Anggaran</th>
					<th width="15%">No.Kontrak</th>
					<th width="10%">Grand Total</th>
				</tr>
			</thead>
			<tbody font="8">
				<?php							
				$str = "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan` like '%$key%'";	
				$str2 = $str." ORDER BY IdPenerimaan DESC";
				// echo $str2;

				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$idpabrik = $data['KodeSupplier'];
					
					// ref_pabrik
					$dt_pabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$idpabrik'"));
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['TanggalPenerimaan'];?></td>
						<td align="center"><?php echo $data['NomorPembukuan'];?></td>
						<td align="left"><?php echo $dt_pabrik['nama_prod_obat'];?></td>
						<td align="center"><?php echo $data['SumberAnggaran'];?> <?php echo $data['TahunAnggaran'];?></td>
						<td align="left"><?php echo $data['NomorKontrak'];?></td>
						<td align="right">
							<?php 
								$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`NomorPembukuan` LIKE '%$data[NomorPembukuan]%'";
								// echo $strgt;
								$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
								echo number_format($dtgt['Jumlah'],2,",","."); 
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