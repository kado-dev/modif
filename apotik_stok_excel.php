<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	$hariini = date('d-m-Y');
	$key = $_GET['key'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Stok_Depot_Obat_Puskesmas (".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK DEPOT OBAT PUSKESMAS</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr>
				<th width="3%">NO.</th>
				<th width="6%">KODE</th>
				<th width="20%">NAMA BARANG</th>
				<th width="8%">SATUAN</th>
				<th width="10%">BATCH</th>
				<th width="8%">EXPIRE</th>
				<th width="10%">SUMBER</th>
				<th width="6%">HARGA</th>
				<th width="6%">STOK</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$status = $_GET['status'];
		$jmltersedia = $_GET['jmltersedia'];	
		$key = $_GET['key'];

		if($jmltersedia == 'Keseluruhan'){
			$stoks = "";
		}elseif($jmltersedia == 'Expire'){
			$stoks = "`Stok` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
		}else{
			$stoks = "`Stok` > '0' AND";
		}					
							
		if($key != ''){
			$strcari = " AND (NamaBarang Like '%$key%' OR `KodeBarang` Like '%$key%' OR `NoBatch` Like '%$key%')";
		}else{
			$strcari = " ";
			// $strcari = " AND `Stok` > '0'";
		}	
		
		if($kota == "KOTA TARAKAN"){	
			$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
			$str = "SELECT * FROM `$tbapotikstok` WHERE ".$stoks." StatusBarang = '$status'".$strcari;
			$str2 = $str." ORDER BY SumberAnggaran, NamaBarang";
		}else{
			$str = "SELECT * FROM `tbapotikstok` WHERE `KodePuskesmas` = '$kodepuskesmas' AND ".$stoks." StatusBarang = '$status'".$strcari;
			$str2 = $str." ORDER BY SumberAnggaran, NamaBarang";
		}	
		// echo $str2;	

		$no = 0;
		$query = mysqli_query($koneksi,$str2);
		while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$kdbrg = $data['KodeBarang'];
			$nobatch = $data['NoBatch'];
			
			// tbgfkkstok, wajib dipisah berdasarkan nobatch (sumber anggaran bisa beda)
			$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));
			
			// tbgfk_vaksin 
			$dtgfkstok_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));
			
			// tbgudangpkmstok
			$dtgudangpkmstok =  mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$nobatch'"));	
									
		?>
			<tr>
				<td align="right"><?php echo $no;?></td>
				<td align="center"><?php echo $data['KodeBarang'];?></td>
				<td align="left"class="nama">
					<?php
						if($data['NamaBarang'] != "" || $data['NamaBarang'] != "--PILIH--"){
							echo strtoupper($data['NamaBarang']);
						}elseif($dtgfkstok['NamaBarang'] != ""){
							echo strtoupper($dtgfkstok['NamaBarang']);
						}else{
							echo strtoupper($dtgfkstok_vaksin['NamaBarang']);
						}
					?>
				</td>
				<td align="center"><?php echo strtoupper($data['Satuan']);?></td>
				<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch'])?></td>
				<td align="center"><?php echo $data['Expire'];?></td>
				<td align="center">
					<?php 
						if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
							$sumber = "APBD";
						}else{
							$sumber = $data['SumberAnggaran'];
						}										
						echo $sumber." - ".$data['TahunAnggaran'];
					?>
				</td>
				<td align="right"><?php echo rupiah($data['HargaSatuan']);?></td>
				<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
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