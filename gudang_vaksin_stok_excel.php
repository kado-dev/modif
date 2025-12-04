<?php
	include_once('config/koneksi.php');
	include "config/helper.php";
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');	
	$kategori = $_GET['kategori'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Stok Barang Gudang Vaksin (".$hariini.").xls");
	if(isset($kategori) and isset($key)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK BARANG GUDANG VAKSIN</b></h4>
	<br/><br/>
</div>

<?php	
	$key = $_GET['key'];				
	$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE `Stok` > '0' AND (`NamaBarang` like '%$key%' OR `NoBatch` like '%$key%')";
	$str2 = $str." order by NamaBarang  Asc";
?>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9.5px;">
				<tr>
					<th width="4%">No</th>
					<th width="6%">Kode</th>
					<th width="20%">Nama Barang</th>
					<th width="5%">Satuan</th>
					<th width="5%">Harga</th>
					<th width="8%">Batch</th>
					<th width="8%">Expire</th>
					<th width="5%">Min.Stok</th>
					<th width="5%">Stok</th>
					<th width="10%">Sumber</th>
					<th width="5%">Tahun</th>
					<th width="8%">Program</th>
					<th width="8%">Tgl.Update</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				$no = 0;
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;					
					$Expire = $data['Expire'];

				?>
					<tr>
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td class="nama"><?php echo $data['NamaBarang'];?></td>
						<td align="center"><?php echo $data['Satuan'];?></td>
						<td align="right"><?php echo rupiah($data['HargaBeli']);?></td>
						<td align="center"><?php echo $data['NoBatch'];?></td>
						<td align="center"><?php echo $data['Expire'];?></td>
						<td align="center"><?php echo $data['MinimalStok'];?></td>
						<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
						<td align="center"><?php echo $data['SumberAnggaran'];?></td>
						<td align="center"><?php echo $data['TahunAnggaran'];?></td>
						<td align="center"><?php echo $data['NamaProgram'];?></td>
						<td align="center">
						<?php
							if ($data['TanggalUpdateStok']=='0000-00-00'){
								echo "-";
							}else{
								echo $data['TanggalUpdateStok'];
							}			
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