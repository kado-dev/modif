<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	$bulan = date('m');
	$tahun = date('Y');
	$key = $_GET['key'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_Diagnosa_Keperawatan (".nama_bulan($bulan)." ".$tahun.").xls");
	if(isset($bulan)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>DIAGNOSA KEPERAWATAN</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr style="border:1px solid #000;">
				<th width="5%">NO.</th>
				<th width="5%">KODE</th>
				<th width="90%">DIAGNOSA</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no = 0;
				$key = $_GET['key'];
				$strdiagnosa = "SELECT * FROM `tbdiagnosakeperawatan` WHERE `NamaDiagnosa` like '%$key%' ORDER BY `KodeDiagnosa` ";
				// echo $strdiagnosa;
				$query = mysqli_query($koneksi, $strdiagnosa);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
			?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
						<td class="nama"><?php echo $data['NamaDiagnosa'];?></td>
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