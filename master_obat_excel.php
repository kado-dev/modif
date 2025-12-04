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
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$namaprg = $_GET['namaprg'];
	$key = $_GET['key'];
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Master_LPLPO (".$namapuskesmas.").xls");
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
	<h4 style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>MASTER OBAT</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr>
					<th width="5%">No</th>
					<th width="10%">Kode</th>
					<th width="50%">Nama Barang</th>
					<th width="15%">Satuan</th>
					<th width="20%">Keterangan</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
					$no = 0;
										
					if($namaprg == ""){
						$program = "";				
					}else{
						$program = " AND `NamaProgram` = '$namaprg'";
					}
					
					$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` like '%$key%'".$program;
					$str2 = $str." ORDER BY IdLplpo, NamaBarang ASC";
					// echo $str2;
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='4'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}	
						$no = $no + 1;
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td align="left" class="nama"><?php echo $data['NamaBarang'];?></td>		
						<td align="center" class="nama"><?php echo $data['Satuan'];?></td>		
						<td align="center" class="nama"></td>		
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