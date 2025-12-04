<?php
	error_reporting(0);
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	// get data
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Penyakit_Terbanyak (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	// if(isset($bulanawal) and isset($tahunakhir)){
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
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>PENYAKIT TERBANYAK</b></span><br>
	<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
	</span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width='5%'>No.</td>
					<th width='10%'>Kode ICD X</td>
					<th>Nama Diagnosa</td>
					<th width='10%'>Jumlah</td>
				</tr>
			</thead>
			<tbody>
				<?php
					if($_GET['bulan'] == 'semua'){
						$str_penyakit = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as Jumlah FROM `$tbdiagnosapasien` 
						WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND `KodeDiagnosa` <> 'Z00.0' GROUP BY KodeDiagnosa
						ORDER BY Jumlah DESC LIMIT 0,10";
					}else{
						$str_penyakit = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as Jumlah FROM `$tbdiagnosapasien` 
						WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND MONTH(`TanggalDiagnosa`)='$bulan' AND `KodeDiagnosa` <> 'Z00.0' GROUP BY KodeDiagnosa 
						ORDER BY Jumlah DESC LIMIT 0,10";	
					}
					// echo $str_penyakit;
					
					$query_penyakit = mysqli_query($koneksi,$str_penyakit);
					while($dtpenyakit = mysqli_fetch_assoc($query_penyakit)){
						$no = $no +1;
						$kodediagnosa = $dtpenyakit['KodeDiagnosa'];
						$tbpenyakit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Diagnosa, KodeDiagnosa
						FROM `tbdiagnosabpjs`
						WHERE `KodeDiagnosa`='$kodediagnosa'"));
						?>
						<tr>
							<td style="text-align:right;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $dtpenyakit['KodeDiagnosa'];?></td>
							<td><?php echo $tbpenyakit['Diagnosa'];?></td>
							<td style="text-align:right;"><?php echo $dtpenyakit['Jumlah'];?></td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table><br/>
	</div>
</div>