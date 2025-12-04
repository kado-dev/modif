<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kdprovider = $_SESSION['kodeppk'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>

<style>
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-top:0px;
	margin-left:-15px;
	margin-right:-15px;

}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	// display:none;
	margin-top:0px;
	margin-left:-15px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
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
			<h1>Pengadaan Barang BLUD <small>Gudang UPTD</small></h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Data</h4>
			</div>
			<div class="space-10"></div>
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_uptd_pengadaan_barang"/>
					<div class="col-sm-2">
						<select name="tahun" class="form-control">
							<?php
							for($tahun = 2015 ; $tahun <= date('Y'); $tahun++){}
							?>
							<!--<option value="<?php echo $tahun;?>"<?php if($_GET['tahun'] == 'echo $tahun;'){echo "SELECTED";}?>><?php echo $tahun;?></option>-->
							<option value="2015"<?php if($_GET['tahun'] == '2015'){echo "SELECTED";}?>>2015</option>
							<option value="2016"<?php if($_GET['tahun'] == '2016'){echo "SELECTED";}?>>2016</option>
							<option value="2017"<?php if($_GET['tahun'] == '2017'){echo "SELECTED";}?>>2017</option>
						</select>
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_uptd_pengadaan_barang" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<a href="?page=dashboard" class="btn  btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
$tahun = $_GET['tahun'];
if (isset($tahun)){
?>

<!--data registrasi-->
<div class="row printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
	?>
	<?php 
	if($kdpuskesmas == 'semua'){
	?>
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
		<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
		<p style="margin:5px;"><?php echo $alamat;?></p>
	<?php
	}else{
	?>
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
		<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
		<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
		<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PENGADAN BARANG BLUD</b></h4>
	<br/>
</div>

<div class="row atastabel">
	<div class="col-lg-12">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td>Kode Puskesmas</td>
				<td>:</td>
				<td><?php echo$datapuskesmas['KodePuskesmas'];?></td>
			</tr>
			<tr>
				<td>Puskesmas</td>
				<td>:</td>
				<td><?php echo$datapuskesmas['NamaPuskesmas'];?></td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td><?php echo$datapuskesmas['Kecamatan'];?></td>
			</tr>
		</table><p/>
	</div>
</div>

<!--tabel view-->
<div class="row printbody">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-striped table-condensed">
				<thead style="font-size:9.5px;">
					<tr>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.Faktur</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Januari</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Februari</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Maret</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">April</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Mei</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Juni</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Juli</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Agustus</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">September</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Oktober</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">November</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Desember</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
					</tr>
				</thead>
				
				<tbody style="font-size:10px;">
					<?php
					$tahun = $_GET['tahun'];
					$no = 0;
										
					$pengadaan_uptd = "select * from tbgudanguptdpengadaan where YEAR(TanggalPengadaan)='$tahun' and KodePuskesmas = '$kodepuskesmas' order by TanggalPengadaan";
					// echo $pengadaan_uptd;
					// die();
					
					$query_pkm=mysqli_query($koneksi,$pengadaan_uptd);
					while($dt_pengadaan = mysqli_fetch_assoc($query_pkm)){
						$no= $no + 1;
						$nofaktur = $dt_pengadaan['NoFaktur'];
						$jan = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='01' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$feb = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='02' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$mar = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='03' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$apr = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='04' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$mei = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='05' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$jun = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='06' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$jul = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='07' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$agu = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='08' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$sep = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='09' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$okt = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='10' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$nov = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='11' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$des = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='12' and YEAR(TanggalPengadaan)='$tahun' and NoFaktur = '$nofaktur' and KodePuskesmas = '$kodepuskesmas'"));
						$jml = $jan['Jumlah'] + $feb['Jumlah'] + $mar['Jumlah'] + $apr['Jumlah'] + $mei['Jumlah'] + $jun['Jumlah'] + 
								$jul['Jumlah'] + $agus['Jumlah'] + $sep['Jumlah'] + $okt['Jumlah'] + $nov['Jumlah'] + $des['Jumlah'];
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $nofaktur;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jan['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($feb['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($mar['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($apr['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($mei['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jun['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jul['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($agu['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($sep['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($okt['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($nov['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($des['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml);?></td>
						</tr>
					<?php
						}
					?>
					
					<?php
						$tahun = $_GET['tahun'];
												
						$total_jan = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='01' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_feb = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='02' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_mar = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='03' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_apr = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='04' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_mei = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='05' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_jun = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='06' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_jul = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='07' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_agu = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='08' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_sep = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='09' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_okt = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='10' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_nov = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='11' and YEAR(TanggalPengadaan)='$tahun'"));
						$total_des = mysqli_fetch_assoc(mysqli_query($koneksi,"select SUM(GrandTotal)AS Jumlah from tbgudanguptdpengadaan where MONTH(TanggalPengadaan)='12' and YEAR(TanggalPengadaan)='$tahun'"));
						$jml_seluruh = $total_jan['Jumlah'] + $total_feb['Jumlah'] + $total_mar['Jumlah'] + $total_apr['Jumlah'] + $total_mei['Jumlah'] + $total_jun['Jumlah'] + 
								$total_jul['Jumlah'] + $total_agus['Jumlah'] + $total_sep['Jumlah'] + $total_okt['Jumlah'] + $total_nov['Jumlah'] + $total_des['Jumlah'];
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:left; border:1px dashed #000; padding:3px;">#</td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;">Total</td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_jan['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_feb['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_mar['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_apr['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_mei['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_jun['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_jul['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_agu['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_sep['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_okt['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_nov['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($total_des['Jumlah']);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_seluruh);?></td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div><br/>

<?php
}
?>



