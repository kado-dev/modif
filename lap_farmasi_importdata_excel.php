<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');	
	$tahun = '2021';
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
	

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=REKAP DATA ".$namapuskesmas." (".$tahun.").xls");
	// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	// $objWriter->save('php://output');
	// if(isset($tahun)){
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
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>IMPORT DATA OBAT DAN PERBEKALAN KESEHATAN</b></span><br>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td colspan="2">Kode Puskesmas </td>
				<td> : <?php echo $kodepuskesmas?></td>
			</tr>
			<tr>
				<td colspan="2">Nama Puskesmas </td>
				<td> : <?php echo $namapuskesmas?></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="4" style="background: #fff; color: #7a7a7a;">NO.</th>
					<th rowspan="4" style="background: #fff; color: #7a7a7a;">KODE</th>
					<th rowspan="4" style="background: #fff; color: #7a7a7a;">NAMA OBAT & BMHP</th>
					<th rowspan="4" style="background: #fff; color: #7a7a7a;">SATUAN</th>
					<th rowspan="2" style="background: #fff; color: #7a7a7a;" colspan="2">HARGA</th>
					<th rowspan="2" style="background: #fff; color: #7a7a7a;" colspan="2">STOK AWAL <br/>(JANUARI <?php echo $tahunlalu;?>)</th>
					<th colspan="12" style="background: #ffe0e0; color: #7a7a7a;">PENERIMAAN</th>
					<th colspan="216" style="background: #f9e2ca; color: #7a7a7a;">SISA STOK</th>
				</tr>
				<tr>
					<th style="background: #ffe0e0; color: #7a7a7a;">01</th><!--Penerimaan-->
					<th style="background: #ffe0e0; color: #7a7a7a;">02</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">03</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">04</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">05</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">06</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">07</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">08</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">09</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">10</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">11</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">12</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">01</th><!--Sisastok-->
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">02</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">03</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">04</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">05</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">06</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">07</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">08</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">09</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">10</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">11</th>
					<th colspan="18" style="background: #f9e2ca; color: #7a7a7a;">12</th>
				</tr>
				
				<tr>
					<th rowspan="2" style="background: #fff; color: #7a7a7a;">APBD</th><!--Harga-->
					<th rowspan="2" style="background: #fff; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #fff; color: #7a7a7a;">APBD</th>
					<th rowspan="2" style="background: #fff; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th><!--Penerimaan-->
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th rowspan="2" style="background: #ffe0e0; color: #7a7a7a;">JKN</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_01-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_02-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_03-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_04-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_05-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_06-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_07-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_08-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_09-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_10-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>							
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_11-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">GUDANG</th><!--Sisastok_12-->
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">DEPOT</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">IGD</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">RANAP</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PONED</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSTU</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">PUSLING</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">POLI</th>
					<th colspan="2" style="background: #f9e2ca; color: #7a7a7a;">LAINNYA</th>
				</tr>
				<tr>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_01-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_02-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_03-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_04-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_05-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_06-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_07-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_08-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_09-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_10-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_11-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th><!--Pemakaian_12-->
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">APBD</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">JKN</th>
				</tr>
				<tr>
					<th style="background: #fff; color: #7a7a7a;">1</th>
					<th style="background: #fff; color: #7a7a7a;">2</th>
					<th style="background: #fff; color: #7a7a7a;">3</th>
					<th style="background: #fff; color: #7a7a7a;">4</th>
					<th style="background: #fff; color: #7a7a7a;">5</th>
					<th style="background: #fff; color: #7a7a7a;">6</th>
					<th style="background: #fff; color: #7a7a7a;">7</th>
					<th style="background: #fff; color: #7a7a7a;">8</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">9</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">10</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">11</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">12</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">13</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">14</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">15</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">16</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">17</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">18</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">19</th>
					<th style="background: #ffe0e0; color: #7a7a7a;">20</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">63</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">64</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">65</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">66</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">67</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">68</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">69</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">70</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">71</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">72</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">73</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">74</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">75</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">76</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">77</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">78</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">79</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">80</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">81</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">82</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">83</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">84</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">85</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">86</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">87</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">88</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">89</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">90</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">91</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">92</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">93</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">94</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">95</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">96</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">97</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">98</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">99</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">100</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">101</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">102</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">103</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">104</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">105</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">106</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">107</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">108</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">109</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">110</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">111</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">112</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">113</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">114</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">115</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">116</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">117</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">118</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">119</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">120</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">121</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">122</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">123</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">124</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">125</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">126</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">127</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">128</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">129</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">130</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">131</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">132</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">133</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">134</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">135</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">136</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">137</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">138</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">139</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">140</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">141</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">142</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">143</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">144</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">145</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">146</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">147</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">148</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">149</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">150</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">151</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">152</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">153</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">154</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">155</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">156</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">157</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">158</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">159</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">160</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">161</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">162</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">163</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">164</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">165</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">166</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">167</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">168</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">169</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">170</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">171</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">172</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">173</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">174</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">175</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">176</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">177</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">178</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">179</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">180</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">181</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">182</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">183</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">184</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">185</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">186</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">187</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">188</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">189</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">190</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">191</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">192</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">193</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">194</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">195</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">196</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">197</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">198</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">199</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">200</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">201</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">202</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">203</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">204</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">205</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">206</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">207</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">208</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">209</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">210</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">211</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">212</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">213</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">214</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">215</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">216</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">217</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">218</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">219</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">220</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">221</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">222</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">223</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">224</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">225</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">226</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">227</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">228</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">229</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">230</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">231</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">232</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">233</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">234</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">235</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">236</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">237</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">238</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">239</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">240</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">241</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">242</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">243</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">244</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">245</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">246</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">247</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">248</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">249</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">250</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">251</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">252</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">253</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">254</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">255</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">256</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">257</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">258</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">259</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">260</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">261</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">262</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">263</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">264</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">265</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">266</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">267</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">268</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">269</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">270</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">271</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">272</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">273</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">274</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">275</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">276</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">277</th>
					<th style="background: #f9e2ca; color: #7a7a7a;">278</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$str = "SELECT * FROM `ref_obat_lplpo`";
				$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
										
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprogram != $data['NamaProgram']){
						echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='236'>$data[NamaProgram]</td></tr>";
						$namaprogram = $data['NamaProgram'];
					}		
				
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					
					// tbgfkstok
					$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'  ORDER BY IdBarang DESC"));
					$harga_apbd = $dtgfk['HargaBeli'];
					if(empty($harga_apbd)){$harga_apbd = "0";}	
					
					// $tbstokopnam
					$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbstokopnam` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun'"));
					$harga_jkn = $dtstokopname['HargaJkn'];
					
					// penerimaan, narik dari pengeluaran dinas
					$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					
					// total sisastok
					$total_sisastok_apbd_01 = $dtstokopname['Sisastok_Gudang_Apbd_01'] + $dtstokopname['Sisastok_Depot_Apbd_01'] + $dtstokopname['Sisastok_Igd_Apbd_01'] + $dtstokopname['Sisastok_Ranap_Apbd_01'] + $dtstokopname['Sisastok_Poned_Apbd_01'] + $dtstokopname['Sisastok_Pustu_Apbd_01'] + $dtstokopname['Sisastok_Pusling_Apbd_01'] + $dtstokopname['Sisastok_Poli_Apbd_01'] + $dtstokopname['Sisastok_Lainnya_Apbd_01'];
					$total_sisastok_apbd_02 = $dtstokopname['Sisastok_Gudang_Apbd_02'] + $dtstokopname['Sisastok_Depot_Apbd_02'] + $dtstokopname['Sisastok_Igd_Apbd_02'] + $dtstokopname['Sisastok_Ranap_Apbd_02'] + $dtstokopname['Sisastok_Poned_Apbd_02'] + $dtstokopname['Sisastok_Pustu_Apbd_02'] + $dtstokopname['Sisastok_Pusling_Apbd_02'] + $dtstokopname['Sisastok_Poli_Apbd_02'] + $dtstokopname['Sisastok_Lainnya_Apbd_02'];
					$total_sisastok_apbd_03 = $dtstokopname['Sisastok_Gudang_Apbd_03'] + $dtstokopname['Sisastok_Depot_Apbd_03'] + $dtstokopname['Sisastok_Igd_Apbd_03'] + $dtstokopname['Sisastok_Ranap_Apbd_03'] + $dtstokopname['Sisastok_Poned_Apbd_03'] + $dtstokopname['Sisastok_Pustu_Apbd_03'] + $dtstokopname['Sisastok_Pusling_Apbd_03'] + $dtstokopname['Sisastok_Poli_Apbd_03'] + $dtstokopname['Sisastok_Lainnya_Apbd_03'];
					$total_sisastok_apbd_04 = $dtstokopname['Sisastok_Gudang_Apbd_04'] + $dtstokopname['Sisastok_Depot_Apbd_04'] + $dtstokopname['Sisastok_Igd_Apbd_04'] + $dtstokopname['Sisastok_Ranap_Apbd_04'] + $dtstokopname['Sisastok_Poned_Apbd_04'] + $dtstokopname['Sisastok_Pustu_Apbd_04'] + $dtstokopname['Sisastok_Pusling_Apbd_04'] + $dtstokopname['Sisastok_Poli_Apbd_04'] + $dtstokopname['Sisastok_Lainnya_Apbd_04'];
					$total_sisastok_apbd_05 = $dtstokopname['Sisastok_Gudang_Apbd_05'] + $dtstokopname['Sisastok_Depot_Apbd_05'] + $dtstokopname['Sisastok_Igd_Apbd_05'] + $dtstokopname['Sisastok_Ranap_Apbd_05'] + $dtstokopname['Sisastok_Poned_Apbd_05'] + $dtstokopname['Sisastok_Pustu_Apbd_05'] + $dtstokopname['Sisastok_Pusling_Apbd_05'] + $dtstokopname['Sisastok_Poli_Apbd_05'] + $dtstokopname['Sisastok_Lainnya_Apbd_05'];
					$total_sisastok_apbd_06 = $dtstokopname['Sisastok_Gudang_Apbd_06'] + $dtstokopname['Sisastok_Depot_Apbd_06'] + $dtstokopname['Sisastok_Igd_Apbd_06'] + $dtstokopname['Sisastok_Ranap_Apbd_06'] + $dtstokopname['Sisastok_Poned_Apbd_06'] + $dtstokopname['Sisastok_Pustu_Apbd_06'] + $dtstokopname['Sisastok_Pusling_Apbd_06'] + $dtstokopname['Sisastok_Poli_Apbd_06'] + $dtstokopname['Sisastok_Lainnya_Apbd_06'];
					$total_sisastok_apbd_07 = $dtstokopname['Sisastok_Gudang_Apbd_07'] + $dtstokopname['Sisastok_Depot_Apbd_07'] + $dtstokopname['Sisastok_Igd_Apbd_07'] + $dtstokopname['Sisastok_Ranap_Apbd_07'] + $dtstokopname['Sisastok_Poned_Apbd_07'] + $dtstokopname['Sisastok_Pustu_Apbd_07'] + $dtstokopname['Sisastok_Pusling_Apbd_07'] + $dtstokopname['Sisastok_Poli_Apbd_07'] + $dtstokopname['Sisastok_Lainnya_Apbd_07'];
					$total_sisastok_apbd_08 = $dtstokopname['Sisastok_Gudang_Apbd_08'] + $dtstokopname['Sisastok_Depot_Apbd_08'] + $dtstokopname['Sisastok_Igd_Apbd_08'] + $dtstokopname['Sisastok_Ranap_Apbd_08'] + $dtstokopname['Sisastok_Poned_Apbd_08'] + $dtstokopname['Sisastok_Pustu_Apbd_08'] + $dtstokopname['Sisastok_Pusling_Apbd_08'] + $dtstokopname['Sisastok_Poli_Apbd_08'] + $dtstokopname['Sisastok_Lainnya_Apbd_08'];
					$total_sisastok_apbd_09 = $dtstokopname['Sisastok_Gudang_Apbd_09'] + $dtstokopname['Sisastok_Depot_Apbd_09'] + $dtstokopname['Sisastok_Igd_Apbd_09'] + $dtstokopname['Sisastok_Ranap_Apbd_09'] + $dtstokopname['Sisastok_Poned_Apbd_09'] + $dtstokopname['Sisastok_Pustu_Apbd_09'] + $dtstokopname['Sisastok_Pusling_Apbd_09'] + $dtstokopname['Sisastok_Poli_Apbd_09'] + $dtstokopname['Sisastok_Lainnya_Apbd_09'];
					$total_sisastok_apbd_10 = $dtstokopname['Sisastok_Gudang_Apbd_10'] + $dtstokopname['Sisastok_Depot_Apbd_10'] + $dtstokopname['Sisastok_Igd_Apbd_10'] + $dtstokopname['Sisastok_Ranap_Apbd_10'] + $dtstokopname['Sisastok_Poned_Apbd_10'] + $dtstokopname['Sisastok_Pustu_Apbd_10'] + $dtstokopname['Sisastok_Pusling_Apbd_10'] + $dtstokopname['Sisastok_Poli_Apbd_10'] + $dtstokopname['Sisastok_Lainnya_Apbd_10'];
					$total_sisastok_apbd_11 = $dtstokopname['Sisastok_Gudang_Apbd_11'] + $dtstokopname['Sisastok_Depot_Apbd_11'] + $dtstokopname['Sisastok_Igd_Apbd_11'] + $dtstokopname['Sisastok_Ranap_Apbd_11'] + $dtstokopname['Sisastok_Poned_Apbd_11'] + $dtstokopname['Sisastok_Pustu_Apbd_11'] + $dtstokopname['Sisastok_Pusling_Apbd_11'] + $dtstokopname['Sisastok_Poli_Apbd_11'] + $dtstokopname['Sisastok_Lainnya_Apbd_11'];
					$total_sisastok_apbd_12 = $dtstokopname['Sisastok_Gudang_Apbd_12'] + $dtstokopname['Sisastok_Depot_Apbd_12'] + $dtstokopname['Sisastok_Igd_Apbd_12'] + $dtstokopname['Sisastok_Ranap_Apbd_12'] + $dtstokopname['Sisastok_Poned_Apbd_12'] + $dtstokopname['Sisastok_Pustu_Apbd_12'] + $dtstokopname['Sisastok_Pusling_Apbd_12'] + $dtstokopname['Sisastok_Poli_Apbd_12'] + $dtstokopname['Sisastok_Lainnya_Apbd_12'];
					$total_sisastok_jkn_01 = $dtstokopname['Sisastok_Gudang_Jkn_01'] + $dtstokopname['Sisastok_Depot_Jkn_01'] + $dtstokopname['Sisastok_Igd_Jkn_01'] + $dtstokopname['Sisastok_Ranap_Jkn_01'] + $dtstokopname['Sisastok_Poned_Jkn_01'] + $dtstokopname['Sisastok_Pustu_Jkn_01'] + $dtstokopname['Sisastok_Pusling_Jkn_01'] + $dtstokopname['Sisastok_Poli_Jkn_01'] + $dtstokopname['Sisastok_Lainnya_Jkn_01'];
					$total_sisastok_jkn_02 = $dtstokopname['Sisastok_Gudang_Jkn_02'] + $dtstokopname['Sisastok_Depot_Jkn_02'] + $dtstokopname['Sisastok_Igd_Jkn_02'] + $dtstokopname['Sisastok_Ranap_Jkn_02'] + $dtstokopname['Sisastok_Poned_Jkn_02'] + $dtstokopname['Sisastok_Pustu_Jkn_02'] + $dtstokopname['Sisastok_Pusling_Jkn_02'] + $dtstokopname['Sisastok_Poli_Jkn_02'] + $dtstokopname['Sisastok_Lainnya_Jkn_02'];
					$total_sisastok_jkn_03 = $dtstokopname['Sisastok_Gudang_Jkn_03'] + $dtstokopname['Sisastok_Depot_Jkn_03'] + $dtstokopname['Sisastok_Igd_Jkn_03'] + $dtstokopname['Sisastok_Ranap_Jkn_03'] + $dtstokopname['Sisastok_Poned_Jkn_03'] + $dtstokopname['Sisastok_Pustu_Jkn_03'] + $dtstokopname['Sisastok_Pusling_Jkn_03'] + $dtstokopname['Sisastok_Poli_Jkn_03'] + $dtstokopname['Sisastok_Lainnya_Jkn_03'];
					$total_sisastok_jkn_04 = $dtstokopname['Sisastok_Gudang_Jkn_04'] + $dtstokopname['Sisastok_Depot_Jkn_04'] + $dtstokopname['Sisastok_Igd_Jkn_04'] + $dtstokopname['Sisastok_Ranap_Jkn_04'] + $dtstokopname['Sisastok_Poned_Jkn_04'] + $dtstokopname['Sisastok_Pustu_Jkn_04'] + $dtstokopname['Sisastok_Pusling_Jkn_04'] + $dtstokopname['Sisastok_Poli_Jkn_04'] + $dtstokopname['Sisastok_Lainnya_Jkn_04'];
					$total_sisastok_jkn_05 = $dtstokopname['Sisastok_Gudang_Jkn_05'] + $dtstokopname['Sisastok_Depot_Jkn_05'] + $dtstokopname['Sisastok_Igd_Jkn_05'] + $dtstokopname['Sisastok_Ranap_Jkn_05'] + $dtstokopname['Sisastok_Poned_Jkn_05'] + $dtstokopname['Sisastok_Pustu_Jkn_05'] + $dtstokopname['Sisastok_Pusling_Jkn_05'] + $dtstokopname['Sisastok_Poli_Jkn_05'] + $dtstokopname['Sisastok_Lainnya_Jkn_05'];
					$total_sisastok_jkn_06 = $dtstokopname['Sisastok_Gudang_Jkn_06'] + $dtstokopname['Sisastok_Depot_Jkn_06'] + $dtstokopname['Sisastok_Igd_Jkn_06'] + $dtstokopname['Sisastok_Ranap_Jkn_06'] + $dtstokopname['Sisastok_Poned_Jkn_06'] + $dtstokopname['Sisastok_Pustu_Jkn_06'] + $dtstokopname['Sisastok_Pusling_Jkn_06'] + $dtstokopname['Sisastok_Poli_Jkn_06'] + $dtstokopname['Sisastok_Lainnya_Jkn_06'];
					$total_sisastok_jkn_07 = $dtstokopname['Sisastok_Gudang_Jkn_07'] + $dtstokopname['Sisastok_Depot_Jkn_07'] + $dtstokopname['Sisastok_Igd_Jkn_07'] + $dtstokopname['Sisastok_Ranap_Jkn_07'] + $dtstokopname['Sisastok_Poned_Jkn_07'] + $dtstokopname['Sisastok_Pustu_Jkn_07'] + $dtstokopname['Sisastok_Pusling_Jkn_07'] + $dtstokopname['Sisastok_Poli_Jkn_07'] + $dtstokopname['Sisastok_Lainnya_Jkn_07'];
					$total_sisastok_jkn_08 = $dtstokopname['Sisastok_Gudang_Jkn_08'] + $dtstokopname['Sisastok_Depot_Jkn_08'] + $dtstokopname['Sisastok_Igd_Jkn_08'] + $dtstokopname['Sisastok_Ranap_Jkn_08'] + $dtstokopname['Sisastok_Poned_Jkn_08'] + $dtstokopname['Sisastok_Pustu_Jkn_08'] + $dtstokopname['Sisastok_Pusling_Jkn_08'] + $dtstokopname['Sisastok_Poli_Jkn_08'] + $dtstokopname['Sisastok_Lainnya_Jkn_08'];
					$total_sisastok_jkn_09 = $dtstokopname['Sisastok_Gudang_Jkn_09'] + $dtstokopname['Sisastok_Depot_Jkn_09'] + $dtstokopname['Sisastok_Igd_Jkn_09'] + $dtstokopname['Sisastok_Ranap_Jkn_09'] + $dtstokopname['Sisastok_Poned_Jkn_09'] + $dtstokopname['Sisastok_Pustu_Jkn_09'] + $dtstokopname['Sisastok_Pusling_Jkn_09'] + $dtstokopname['Sisastok_Poli_Jkn_09'] + $dtstokopname['Sisastok_Lainnya_Jkn_09'];
					$total_sisastok_jkn_10 = $dtstokopname['Sisastok_Gudang_Jkn_10'] + $dtstokopname['Sisastok_Depot_Jkn_10'] + $dtstokopname['Sisastok_Igd_Jkn_10'] + $dtstokopname['Sisastok_Ranap_Jkn_10'] + $dtstokopname['Sisastok_Poned_Jkn_10'] + $dtstokopname['Sisastok_Pustu_Jkn_10'] + $dtstokopname['Sisastok_Pusling_Jkn_10'] + $dtstokopname['Sisastok_Poli_Jkn_10'] + $dtstokopname['Sisastok_Lainnya_Jkn_10'];
					$total_sisastok_jkn_11 = $dtstokopname['Sisastok_Gudang_Jkn_11'] + $dtstokopname['Sisastok_Depot_Jkn_11'] + $dtstokopname['Sisastok_Igd_Jkn_11'] + $dtstokopname['Sisastok_Ranap_Jkn_11'] + $dtstokopname['Sisastok_Poned_Jkn_11'] + $dtstokopname['Sisastok_Pustu_Jkn_11'] + $dtstokopname['Sisastok_Pusling_Jkn_11'] + $dtstokopname['Sisastok_Poli_Jkn_11'] + $dtstokopname['Sisastok_Lainnya_Jkn_11'];
					$total_sisastok_jkn_12 = $dtstokopname['Sisastok_Gudang_Jkn_12'] + $dtstokopname['Sisastok_Depot_Jkn_12'] + $dtstokopname['Sisastok_Igd_Jkn_12'] + $dtstokopname['Sisastok_Ranap_Jkn_12'] + $dtstokopname['Sisastok_Poned_Jkn_12'] + $dtstokopname['Sisastok_Pustu_Jkn_12'] + $dtstokopname['Sisastok_Pusling_Jkn_12'] + $dtstokopname['Sisastok_Poli_Jkn_12'] + $dtstokopname['Sisastok_Lainnya_Jkn_12'];
					
					// pemakaian
					// jika januari rumusnya stok awal (des 2020) + penerimaan (jan 2021) - sisa stok (jan 2021)
					$pemakaian_apbd_01 = $dtstokopname['StokAwalApbd'] + $dtstokopname['PenerimaanApbd_01'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
					$pemakaian_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
					
					// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
					$pemakaian_apbd_02 = $total_sisastok_apbd_01 + $dtstokopname['PenerimaanApbd_02'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
					$pemakaian_jkn_02 = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
					$pemakaian_apbd_03 = $total_sisastok_apbd_02 + $dtstokopname['PenerimaanApbd_03'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
					$pemakaian_jkn_03 = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
					$pemakaian_apbd_04 = $total_sisastok_apbd_03 + $dtstokopname['PenerimaanApbd_04'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
					$pemakaian_jkn_04 = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
					$pemakaian_apbd_05 = $total_sisastok_apbd_04 + $dtstokopname['PenerimaanApbd_05'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
					$pemakaian_jkn_05 = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
					$pemakaian_apbd_06 = $total_sisastok_apbd_05 + $dtstokopname['PenerimaanApbd_06'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
					$pemakaian_jkn_06 = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
					$pemakaian_apbd_07 = $total_sisastok_apbd_06 + $dtstokopname['PenerimaanApbd_07'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
					$pemakaian_jkn_07 = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
					$pemakaian_apbd_08 = $total_sisastok_apbd_07 + $dtstokopname['PenerimaanApbd_08'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
					$pemakaian_jkn_08 = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
					$pemakaian_apbd_09 = $total_sisastok_apbd_08 + $dtstokopname['PenerimaanApbd_09'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
					$pemakaian_jkn_09 = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
					$pemakaian_apbd_10 = $total_sisastok_apbd_09 + $dtstokopname['PenerimaanApbd_10'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
					$pemakaian_jkn_10 = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
					$pemakaian_apbd_11 = $total_sisastok_apbd_10 + $dtstokopname['PenerimaanApbd_11'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
					$pemakaian_jkn_11 = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
					$pemakaian_apbd_12 = $total_sisastok_apbd_11 + $dtstokopname['PenerimaanApbd_12'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
					$pemakaian_jkn_12 = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
					
					
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>							
						<td class="kodebarangcls" align="center"><?php echo $data['KodeBarang'];?></td>									
						<td class="namabarangcls" align="left"><?php echo $data['NamaBarang'];?></td>									
						<td align="center"><?php echo $data['Satuan'];?></td>		
						<td align="right"><?php echo rupiah($harga_apbd);?></td>						
						<td align="right"><?php echo rupiah($harga_jkn);?></td>								
						<td align="right"><!--Stokawal-->
							<?php 
								if($dtstokopname['StokAwalApbd'] != 0){
									echo rupiah($dtstokopname['StokAwalApbd']);
								}else{
									echo "-";
								}
							?>
						</td>					
						<td align="right">
							<?php 
								if($dtstokopname['StokAwalJkn'] != 0){
									echo rupiah($dtstokopname['StokAwalJkn']);
								}else{
									echo "-";
								}
							?>
						</td>	
						
						<!--Penerimaan-->		
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_01'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_01']);
								}else{
									echo "";
								}
							?>
						</td>							
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_02'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_02']);
								}else{
									echo "";
								}
							?>
						</td>					
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_03'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_03']);
								}else{
									echo "";
								}
							?>	
						</td>						
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_04'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_04']);
								}else{
									echo "";
								}
							?>	
						</td>						
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_05'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_05']);
								}else{
									echo "";
								}
							?>	
						</td>						
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_06'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_06']);
								}else{
									echo "";
								}
							?>	
						</td>	
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_07'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_07']);
								}else{
									echo "";
								}
							?>	
						</td>	
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_08'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_08']);
								}else{
									echo "";
								}
							?>	
						</td>	
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_09'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_09']);
								}else{
									echo "";
								}
							?>	
						</td>	
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_10'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_10']);
								}else{
									echo "";
								}
							?>	
						</td>		
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_11'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_11']);
								}else{
									echo "";
								}
							?>	
						</td>
						<td align="right" style="background: #ffe0e0; color: #7a7a7a;">
							<?php 
								if($dtstokopname['PenerimaanJkn_12'] != 0){
									echo rupiah($dtstokopname['PenerimaanJkn_12']);
								}else{
									echo "";
								}
							?>	
						</td>
						
						<!--Sisa Stok 01-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_01'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_01']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 02-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_02'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_02']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 03-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_03'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_03']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 04-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_04'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_04']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 05-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_05'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_05']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 06-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_06'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_06']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 07-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_07'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_07']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 08-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_08'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_08']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 09-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_09'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_09']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 10-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_10'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_10']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 11-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_11'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_11']);
								}else{
									echo "-";
								}
							?>
						</td>
						
						<!--Sisa Stok 12-->
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Gudang_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Depot_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Depot_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Igd_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Igd_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Ranap_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poned_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poned_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pustu_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Pusling_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Poli_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Poli_Jkn_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Apbd_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_12']);
								}else{
									echo "-";
								}
							?>
						</td>
						<td align="right" style="background: #f9e2ca; color: #7a7a7a;">
							<?php 
								if($dtstokopname['Sisastok_Lainnya_Jkn_12'] != 0){
									echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_12']);
								}else{
									echo "-";
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
// }
?>