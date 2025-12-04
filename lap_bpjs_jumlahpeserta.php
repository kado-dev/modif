<?php
	include "otoritas.php";
	$kota = $_SESSION['kota'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tanggal = date('Y-m-d');
?>

<style>
.logobpjs{
	position:relative:
	top:0px;
	left:50px;
	width:200px;
	height:130px;
}
.printheader{
	margin-top:-30px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printheader h4{
	font-size:10px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:20px;
}
.bawahtabel{
	margin-top:auto;
	margin-bottom:10px;
	margin-left:auto;
	margin-right:auto;
	display:none;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan Jumlah Peserta BPJS</h1>
		</div>
	</div>
</div>

<!--cari pasien-->
<div class="row noprint">	
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Berdasar</h4>
			</div>
			<div class="space-10"></div>
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_bpjs_jumlahpeserta"/>
					<div class="col-sm-1" style ="width:125px">
						<SELECT name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</SELECT>
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_bpjs_jumlahpeserta" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<a href="?page=laporan_pendaftaran" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<?php
$tahun = $_GET['tahun'];
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kodepuskesmas."' ";
}
if($tahun != null){
?>

<!--data registrasi-->
<div class="table-responsive noprint">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:0.3px dashed #000;">
				<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">NO.</th>
				<th rowspan="2" style="text-align:center;width:80%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">STATUS JAMINAN</th>
				<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">JUMLAH</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<?php
			$tbpasien = 'tbpasien_'.$tahun;
			$dt_bbpjs_pbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoCM)AS Jumlah FROM `$tbpasien` WHERE substring(NoCM,1,11)='$kodepuskesmas' and YEAR(TanggalDaftar) = '$tahun' and `Asuransi` = 'BPJS PBI'"));
			$dt_bbpjs_nonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoCM)AS Jumlah FROM `$tbpasien` WHERE substring(NoCM,1,11)='$kodepuskesmas' and YEAR(TanggalDaftar) = '$tahun' and `Asuransi` = 'BPJS NON PBI'"));
			$total = $dt_bbpjs_pbi['Jumlah'] + $dt_bbpjs_nonpbi['Jumlah'];
			?>
			<tr style="border:0.3px dashed #000;">
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;">1</td>
				<td style="text-align:left; border:0.3px dashed #000; padding:3px;">BPJS PBI</td>
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $dt_bbpjs_pbi['Jumlah'];?></td>
			</tr>
			<tr style="border:0.3px dashed #000;">
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;">2</td>
				<td style="text-align:left; border:0.3px dashed #000; padding:3px;">BPJS NON PBI</td>
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $dt_bbpjs_nonpbi['Jumlah'];?></td>
			</tr>
			<tr style="border:0.3px dashed #000;">
				<td colspan="2" style="text-align:center; border:0.3px dashed #000; padding:3px;">TOTAL</td>
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $total;?></td>
			</tr>
		</tbody>
	</table>
</div>
<br>
<?php
}
?>

<!--tabel report-->
<div class="printheader">
	<div class="logobpjs"><img src="image/logo_bpjs_pusat.png" width="200px" height="130px" alt="logo_bpjs"/></div>
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpuskesmas'"));
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota'"));
	?>
	<h4 style="align:left; margin:5px; margin-top:-70px;" ><b>LAPORAN KUNJUNGAN (SAKIT/SEHAT) BPJS</b></h4>
	<h4 style="margin:5px"><b>BAGI PERSERTA BADAN USAHA / BADAN LAINNYA</b></h4>
	<br/>
</div>
<div class="atastabel">
	<table style="margin-left:30px;">
		<thead style="font-size:10px;">
			<tr>
				<td class="col-sm-2">PPK / DOKTER*</td>
				<td>:</td>
				<td class="col-sm-4"></td>
			</tr>
			<tr>
				<td class="col-sm-2">KABUPATEN / KOTA</td>
				<td>:</td>
				<td class="col-sm-4"></td>
			</tr>
			<tr>
				<td class="col-sm-2">PROVINSI</td>
				<td>:</td>
				<td class="col-sm-4"></td>
			</tr>
			<tr>
				<td class="col-sm-2">PELAYANAN BULAN</td>
				<td>:</td>
				<td class="col-sm-4"></td>
			</tr>
		</thead>
	</table>
</div>
<br/>
<div class="bawahtabel">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:0.3px dashed #000;">
				<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">NO.</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">STATUS KUNJUNGAN</th>
				<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">JUMLAH</th>
			</tr>
		</thead>
		<!--tbpasienrj-->
		<tbody style="font-size:10px;">
			<?php
			if ($sts_bpjs == 'semua'){
				$dt_sakit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE substring(NoRegistrasi,1,11)='$kodepuskesmas' and YEAR(TanggalRegistrasi) = '$tahun' AND StatusPasien = '1' AND (Asuransi = 'BPJS PBI' OR Asuransi = 'BPJS NON PBI') GROUP BY NoCM"));
				$dt_sehat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE substring(NoRegistrasi,1,11)='$kodepuskesmas' and YEAR(TanggalRegistrasi) = '$tahun' AND StatusPasien = '2' AND (Asuransi = 'BPJS PBI' OR Asuransi = 'BPJS NON PBI') GROUP BY NoCM"));
				$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE substring(NoRegistrasi,1,11)='$kodepuskesmas' and YEAR(TanggalRegistrasi) = '$tahun' AND (Asuransi = 'BPJS PBI' OR Asuransi = 'BPJS NON PBI') GROUP BY NoCM"));
			}else{
				$dt_sakit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE substring(NoRegistrasi,1,11)='$kodepuskesmas' and YEAR(TanggalRegistrasi) = '$tahun' AND StatusPasien = '1' AND Asuransi = '$sts_bpjs' GROUP BY NoCM"));
				$dt_sehat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE substring(NoRegistrasi,1,11)='$kodepuskesmas' and YEAR(TanggalRegistrasi) = '$tahun' AND StatusPasien = '2' AND Asuransi = '$sts_bpjs' GROUP BY NoCM"));
				$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE substring(NoRegistrasi,1,11)='$kodepuskesmas' and YEAR(TanggalRegistrasi) = '$tahun' AND Asuransi = '$sts_bpjs' GROUP BY NoCM"));
			}
			//$total = $dt_sakit + $dt_sehat;
			?>
			<tr style="border:0.3px dashed #000;">
				<td style="text-align:right;width:5%;border:0.3px dashed #000; padding:3px;">1</td>
				<td style="text-align:left;width:80%;border:0.3px dashed #000; padding:3px;">KUNJUNGAN SAKIT</td>
				<td style="text-align:right;width:15%;border:0.3px dashed #000; padding:3px;"><?php echo $dt_sakit;?></td>
			</tr>
			<tr style="border:0.3px dashed #000;">
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;">2</td>
				<td style="text-align:left; border:0.3px dashed #000; padding:3px;">KUNJUNGAN SEHAT</td>
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $dt_sehat;?></td>
			</tr>
			<tr style="border:0.3px dashed #000;">
				<td colspan="2" style="text-align:center; border:0.3px dashed #000; padding:3px;">TOTAL</td>
				<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $total;?></td>
			</tr>
		</tbody>
	</table>
</div>
