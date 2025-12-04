<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tanggal = date('Y-m-d');
	$kota = $_SESSION['kota'];
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
	display: none;
	
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
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
	display:none;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan Kunjungan Per-Puskesmas</h1>
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
						<input type="hidden" name="page" value="lap_loket_kunjungan_perpuskesmas"/>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kunjungan_perpuskesmas" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="?page=laporan_pendaftaran" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$tbpasienrj = 'tbpasienrj_'.$bulan;
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
if(isset($bulan) and isset($tahun)){
?>

<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
	<?php 
	if($kdpuskesmas == 'semua'){
	?>
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<?php
	}else{
	?>
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></span>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PER-PUSKESMAS</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['KodePuskesmas'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['NamaPuskesmas'];?></td>
			</tr>
		</table><p/>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan/Desa</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['Kelurahan'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['Kecamatan'];?></td>
			</tr>
		</table>
	</div>	
</div>

<!--tabel view-->
<div class="row font10">
	<div class="col-sm-12">
		<div class="table-responsive font10">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr>
						<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
						<th rowspan="2" style="text-align:center;width:75%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Puskesmas</th>
						<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php

					$no = 0;
					
					$query = mysqli_query($koneksi, "SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as KodePuskesmas, COUNT(`NoRegistrasi`) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'  and SUBSTRING(NoRegistrasi, 1, 11) <> 'P3273141201' GROUP BY KodePuskesmas order by jml DESC");		
					while($data = mysqli_fetch_assoc($query)){
						$str_pkm = "SELECT NamaPuskesmas from tbpuskesmas where KodePuskesmas = '$data[KodePuskesmas]'";
						$puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pkm)); 
						$no = $no + 1;
						if($puskesmas['NamaPuskesmas'] != ''){
					?>
							<tr style="border:1px dashed #000;">
								<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['KodePuskesmas'];?></td>
								<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $puskesmas['NamaPuskesmas'];?></td>
								<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['jml'];?></td>
							</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
	}
?>