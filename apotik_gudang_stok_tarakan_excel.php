<?php
	session_start();
	$namapuskesmas = $_SESSION['namapuskesmas'];
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	$hariini = date('d-m-Y');
	$key = $_GET['key'];
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Stok_Gudang_Obat_Puskesmas (".$hariini.").xls");
	if(isset($key)){
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota." DINAS KESEHATAN";?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK GUDANG OBAT PUSKESMAS</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead >
			<tr>
				<th width="4%">NO.</th>
				<th width="5%">KODE</th>
				<th width="25%">NAMA BARANG</th>
				<th width="8%">SATUAN</th>
				<th width="10%">BATCH</th>
				<th width="8%">EXPIRE</th>
				<th width="8%">STOK</th>
				<th width="10%">SUMBER</th>
				<th width="5%">TAHUN</th>
			</tr>
		</thead>
		<tbody>
			<?php		
			if($key != ''){
				$cari = " AND `NamaBarang` like '%$key%'";
			}else{
				$cari = "";
			}		
						
			$str = "SELECT * FROM `$tbgudangpkmstok` WHERE `Stok` > '0'".$cari;			
			$str2 = $str." ORDER BY NamaBarang";
						
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kdbrg = $data['KodeBarang'];
				
				// tbgfkstok`
				$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg'"));

			?>
				
				<tr>
					<?php 
						// if($data['StatusPenerimaan'] == 'Mandiri'){
							// echo $data['TahunAnggaran'];
						// }else{
							// echo $dtgfkstok['TahunAnggaran'];
						// }
					?>
					<td align="right"><?php echo $no;?></td>
					<td align="center"><?php echo $data['KodeBarang'];?></td>
					<td align="left" class="nama"><?php echo strtoupper($data['NamaBarang']);?></td>
					<td align="center"><?php echo strtoupper($data['Satuan']);?></td>
					<td align="center"><?php echo $data['NoBatch'];?></td>
					<td align="center"><?php echo $data['Expire'];?></td>
					<td align="right"><?php echo number_format($data['Stok']);?></td>
					<td align="center"><?php echo $data['SumberAnggaran'];?></td>
					<td align="center"><?php echo $data['TahunAnggaran'];?></td>
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