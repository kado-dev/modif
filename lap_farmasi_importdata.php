<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kodeobat = $_POST['kode'];
	$tahun = '2021';
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);
	// echo $tbstokopnam;
?>
<style type="text/css">
	.alert{
		margin-bottom: 0px;
	}
	.progress{
		height: 14px;
	}
</style>
<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<div class="aleret"></div>
			<div class="progress" style="background: transparent;">
				<div class="progress-bar progress-bar-striped bg-success active" id="myBar" role="progressbar" style="width: 2%;display: none" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<h3 class="judul"><b>REKAP DATA</b></h3>
			<div class="formbg" style="padding:20px 20px 10px 20px;">
				<div class = "row">
					<input type="hidden" name="page" value="lap_farmasi_importdata"/>
					<div class="col-sm-12">
						<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_farmasi_importdata_import.php" id="formsx">
							<table width="100%" style="margin-bottom: 10px;">	
								<tr>
									<td width="15%">
										Import data (Excel): 
									</td>
									<td width="25%">
										<input name="fileexcel" type="file" class="filex" required="required"> 
									</td>
									<td width="20%">
										<input type="hidden" name="tahun" value="<?php echo $tahun;?>">
										<a href="?page=lap_farmasi_importdata" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
										<input name="upload" type="button" value="Upload Data" class="btn btn-sm btn-danger btnsimpans">
										<a href="lap_farmasi_importdata_excel.php" class="btn btn-sm btn-success">Download Template</a>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>	
			</div>
			<div class="formbg" style="padding:20px 20px 20px 20px;">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_importdata"/>
						<div class="col-sm-10">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Barang / Nama Program">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
	<style>
	table, tr, th {
		color: #7a7a7a!important;	
	}
	.pink {
		background: #ffe0e0!important;
		color: #7a7a7a!important;
	}
	.pinktua {
		background: #e3f9e8!important;
		color: #7a7a7a!important;
	}	
	.kuning {
		background: #fff2bf!important;
	}	
	.oranye {
		background: #f9e2ca!important;
	}
	</style>
	
	<?php		
		$tahunlalu = $tahun - 1;
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namaprogram = $_GET['namaprogram'];
		$key = $_GET['key'];
		
		if(isset($tahun)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:11000px">
					<thead>
						<tr>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">NO.</th>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">KODE</th>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;" width="3%">NAMA OBAT & BMHP</th>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">SATUAN</th>
							<th rowspan="2" style="background: #fff; color: #7a7a7a;" colspan="2">HARGA</th>
							<th rowspan="2" style="background: #fff; color: #7a7a7a;" colspan="2">STOK AWAL <br/>(DESEMBER <?php echo $tahunlalu;?>)</th>
							<th colspan="26" class="pink">PENERIMAAN</th>
							<th rowspan="4" class="pink">TOTAL </br>PENERIMAAN</th>
							<th rowspan="4" class="pinktua">TOTAL </br>PERSEDIAAN</th>
							<th colspan="26" class="kuning">PENGELUARAN</th>
							<th rowspan="4" class="kuning">TOTAL</br>PENGELUARAN</br>(TTL.PERSEDIAAN </br> - </br>TTL.SISA STOK) </th>
							<th colspan="260" class="oranye">SISA STOK</th>
						</tr>
						<tr>
							<th colspan="2" class="pink">01</th><!--Penerimaan-->
							<th colspan="2" class="pink">02</th>
							<th colspan="2" class="pink">03</th>
							<th colspan="2" class="pink">04</th>
							<th colspan="2" class="pink">05</th>
							<th colspan="2" class="pink">06</th>
							<th colspan="2" class="pink">07</th>
							<th colspan="2" class="pink">08</th>
							<th colspan="2" class="pink">09</th>
							<th colspan="2" class="pink">10</th>
							<th colspan="2" class="pink">11</th>
							<th colspan="2" class="pink">12</th>
							<th colspan="2" class="pink">TOTAL</th>
							<th colspan="2" class="kuning">01</th><!--Pemakaian-->
							<th colspan="2" class="kuning">02</th>
							<th colspan="2" class="kuning">03</th>
							<th colspan="2" class="kuning">04</th>
							<th colspan="2" class="kuning">05</th>
							<th colspan="2" class="kuning">06</th>
							<th colspan="2" class="kuning">07</th>
							<th colspan="2" class="kuning">08</th>
							<th colspan="2" class="kuning">09</th>
							<th colspan="2" class="kuning">10</th>
							<th colspan="2" class="kuning">11</th>
							<th colspan="2" class="kuning">12</th>
							<th colspan="2" class="kuning">TOTAL</th>
							<th colspan="20" class="oranye">01</th><!--Sisastok-->
							<th colspan="20" class="oranye">02</th>
							<th colspan="20" class="oranye">03</th>
							<th colspan="20" class="oranye">04</th>
							<th colspan="20" class="oranye">05</th>
							<th colspan="20" class="oranye">06</th>
							<th colspan="20" class="oranye">07</th>
							<th colspan="20" class="oranye">08</th>
							<th colspan="20" class="oranye">09</th>
							<th colspan="20" class="oranye">10</th>
							<th colspan="20" class="oranye">11</th>
							<th colspan="20" class="oranye">12</th>
							<th colspan="20" class="oranye">TOTAL RUPIAH</th>
						</tr>
						
						<tr>
							<th rowspan="2" style="background: #fff; color: #7a7a7a;">APBD</th><!--Harga-->
							<th rowspan="2" style="background: #fff; color: #7a7a7a;">JKN</th>
							<th rowspan="2" style="background: #fff; color: #7a7a7a;">APBD</th>
							<th rowspan="2" style="background: #fff; color: #7a7a7a;">JKN</th>
							<th rowspan="2" class="pink">APBD</th><!--Penerimaan-->
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="pink">APBD</th>
							<th rowspan="2" class="pink">JKN</th>
							<th rowspan="2" class="kuning">APBD</th><!--Pemakaian-->
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th rowspan="2" class="kuning">APBD</th>
							<th rowspan="2" class="kuning">JKN</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_01-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_02-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_03-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_04-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_05-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_06-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_07-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_08-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_09-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_10-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>							
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_11-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_12-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
							<th colspan="2" class="oranye">GUDANG</th><!--Sisastok_ttl-->
							<th colspan="2" class="oranye">DEPOT</th>
							<th colspan="2" class="oranye">IGD</th>
							<th colspan="2" class="oranye">RANAP</th>
							<th colspan="2" class="oranye">PONED</th>
							<th colspan="2" class="oranye">PUSTU</th>
							<th colspan="2" class="oranye">PUSLING</th>
							<th colspan="2" class="oranye">POLI</th>
							<th colspan="2" class="oranye">LAINNYA</th>
							<th colspan="2" class="oranye">TOTAL</th>
						</tr>
						<tr>
							<th class="oranye">APBD</th><!--Sisastok_01-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_02-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_03-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_04-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_05-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_06-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_07-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_08-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_09-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_10-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_11-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_12-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th><!--Sisastok_ttl-->
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
							<th class="oranye">APBD</th>
							<th class="oranye">JKN</th>
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
							<th class="pink">9</th>
							<th class="pink">10</th>
							<th class="pink">11</th>
							<th class="pink">12</th>
							<th class="pink">13</th>
							<th class="pink">14</th>
							<th class="pink">15</th>
							<th class="pink">16</th>
							<th class="pink">17</th>
							<th class="pink">18</th>
							<th class="pink">19</th>
							<th class="pink">20</th>
							<th class="pink">21</th>
							<th class="pink">22</th>
							<th class="pink">23</th>
							<th class="pink">24</th>
							<th class="pink">25</th>
							<th class="pink">26</th>
							<th class="pink">27</th>
							<th class="pink">28</th>
							<th class="pink">29</th>
							<th class="pink">30</th>
							<th class="pink">31</th>
							<th class="pink">32</th>
							<th class="pink">33</th>
							<th class="pink">33</th>
							<th class="pink">34</th>
							<th class="pinktua">35</th>
							<th class="kuning">36</th>
							<th class="kuning">37</th>
							<th class="kuning">38</th>
							<th class="kuning">39</th>
							<th class="kuning">40</th>
							<th class="kuning">41</th>
							<th class="kuning">42</th>
							<th class="kuning">43</th>
							<th class="kuning">44</th>
							<th class="kuning">45</th>
							<th class="kuning">46</th>
							<th class="kuning">47</th>
							<th class="kuning">48</th>
							<th class="kuning">49</th>
							<th class="kuning">50</th>
							<th class="kuning">51</th>
							<th class="kuning">52</th>
							<th class="kuning">53</th>
							<th class="kuning">54</th>
							<th class="kuning">55</th>
							<th class="kuning">56</th>
							<th class="kuning">57</th>
							<th class="kuning">58</th>
							<th class="kuning">59</th>
							<th class="kuning">60</th>
							<th class="kuning">61</th>
							<th class="kuning">62</th>
							<th class="oranye">63</th>
							<th class="oranye">64</th>
							<th class="oranye">65</th>
							<th class="oranye">66</th>
							<th class="oranye">67</th>
							<th class="oranye">68</th>
							<th class="oranye">69</th>
							<th class="oranye">70</th>
							<th class="oranye">71</th>
							<th class="oranye">72</th>
							<th class="oranye">73</th>
							<th class="oranye">74</th>
							<th class="oranye">75</th>
							<th class="oranye">76</th>
							<th class="oranye">77</th>
							<th class="oranye">78</th>
							<th class="oranye">79</th>
							<th class="oranye">80</th>
							<th class="oranye">81</th>
							<th class="oranye">82</th>
							<th class="oranye">83</th>
							<th class="oranye">84</th>
							<th class="oranye">85</th>
							<th class="oranye">86</th>
							<th class="oranye">87</th>
							<th class="oranye">88</th>
							<th class="oranye">89</th>
							<th class="oranye">90</th>
							<th class="oranye">91</th>
							<th class="oranye">92</th>
							<th class="oranye">93</th>
							<th class="oranye">94</th>
							<th class="oranye">95</th>
							<th class="oranye">96</th>
							<th class="oranye">97</th>
							<th class="oranye">98</th>
							<th class="oranye">99</th>
							<th class="oranye">100</th>
							<th class="oranye">101</th>
							<th class="oranye">102</th>
							<th class="oranye">103</th>
							<th class="oranye">104</th>
							<th class="oranye">105</th>
							<th class="oranye">106</th>
							<th class="oranye">107</th>
							<th class="oranye">108</th>
							<th class="oranye">109</th>
							<th class="oranye">110</th>
							<th class="oranye">111</th>
							<th class="oranye">112</th>
							<th class="oranye">113</th>
							<th class="oranye">114</th>
							<th class="oranye">115</th>
							<th class="oranye">116</th>
							<th class="oranye">117</th>
							<th class="oranye">118</th>
							<th class="oranye">119</th>
							<th class="oranye">120</th>
							<th class="oranye">121</th>
							<th class="oranye">122</th>
							<th class="oranye">123</th>
							<th class="oranye">124</th>
							<th class="oranye">125</th>
							<th class="oranye">126</th>
							<th class="oranye">127</th>
							<th class="oranye">128</th>
							<th class="oranye">129</th>
							<th class="oranye">130</th>
							<th class="oranye">131</th>
							<th class="oranye">132</th>
							<th class="oranye">133</th>
							<th class="oranye">134</th>
							<th class="oranye">135</th>
							<th class="oranye">136</th>
							<th class="oranye">137</th>
							<th class="oranye">138</th>
							<th class="oranye">139</th>
							<th class="oranye">140</th>
							<th class="oranye">141</th>
							<th class="oranye">142</th>
							<th class="oranye">143</th>
							<th class="oranye">144</th>
							<th class="oranye">145</th>
							<th class="oranye">146</th>
							<th class="oranye">147</th>
							<th class="oranye">148</th>
							<th class="oranye">149</th>
							<th class="oranye">150</th>
							<th class="oranye">151</th>
							<th class="oranye">152</th>
							<th class="oranye">153</th>
							<th class="oranye">154</th>
							<th class="oranye">155</th>
							<th class="oranye">156</th>
							<th class="oranye">157</th>
							<th class="oranye">158</th>
							<th class="oranye">159</th>
							<th class="oranye">160</th>
							<th class="oranye">161</th>
							<th class="oranye">162</th>
							<th class="oranye">163</th>
							<th class="oranye">164</th>
							<th class="oranye">165</th>
							<th class="oranye">166</th>
							<th class="oranye">167</th>
							<th class="oranye">168</th>
							<th class="oranye">169</th>
							<th class="oranye">170</th>
							<th class="oranye">171</th>
							<th class="oranye">172</th>
							<th class="oranye">173</th>
							<th class="oranye">174</th>
							<th class="oranye">175</th>
							<th class="oranye">176</th>
							<th class="oranye">177</th>
							<th class="oranye">178</th>
							<th class="oranye">179</th>
							<th class="oranye">180</th>
							<th class="oranye">181</th>
							<th class="oranye">182</th>
							<th class="oranye">183</th>
							<th class="oranye">184</th>
							<th class="oranye">185</th>
							<th class="oranye">186</th>
							<th class="oranye">187</th>
							<th class="oranye">188</th>
							<th class="oranye">189</th>
							<th class="oranye">190</th>
							<th class="oranye">191</th>
							<th class="oranye">192</th>
							<th class="oranye">193</th>
							<th class="oranye">194</th>
							<th class="oranye">195</th>
							<th class="oranye">196</th>
							<th class="oranye">197</th>
							<th class="oranye">198</th>
							<th class="oranye">199</th>
							<th class="oranye">200</th>
							<th class="oranye">201</th>
							<th class="oranye">202</th>
							<th class="oranye">203</th>
							<th class="oranye">204</th>
							<th class="oranye">205</th>
							<th class="oranye">206</th>
							<th class="oranye">207</th>
							<th class="oranye">208</th>
							<th class="oranye">209</th>
							<th class="oranye">210</th>
							<th class="oranye">211</th>
							<th class="oranye">212</th>
							<th class="oranye">213</th>
							<th class="oranye">214</th>
							<th class="oranye">215</th>
							<th class="oranye">216</th>
							<th class="oranye">217</th>
							<th class="oranye">218</th>
							<th class="oranye">219</th>
							<th class="oranye">220</th>
							<th class="oranye">221</th>
							<th class="oranye">222</th>
							<th class="oranye">223</th>
							<th class="oranye">224</th>
							<th class="oranye">225</th>
							<th class="oranye">226</th>
							<th class="oranye">227</th>
							<th class="oranye">228</th>
							<th class="oranye">229</th>
							<th class="oranye">230</th>
							<th class="oranye">231</th>
							<th class="oranye">232</th>
							<th class="oranye">233</th>
							<th class="oranye">234</th>
							<th class="oranye">235</th>
							<th class="oranye">236</th>
							<th class="oranye">237</th>
							<th class="oranye">238</th>
							<th class="oranye">239</th>
							<th class="oranye">240</th>
							<th class="oranye">241</th>
							<th class="oranye">242</th>
							<th class="oranye">243</th>
							<th class="oranye">244</th>
							<th class="oranye">245</th>
							<th class="oranye">246</th>
							<th class="oranye">247</th>
							<th class="oranye">248</th>
							<th class="oranye">249</th>
							<th class="oranye">250</th>
							<th class="oranye">251</th>
							<th class="oranye">252</th>
							<th class="oranye">253</th>
							<th class="oranye">254</th>
							<th class="oranye">255</th>
							<th class="oranye">256</th>
							<th class="oranye">257</th>
							<th class="oranye">258</th>
							<th class="oranye">259</th>
							<th class="oranye">260</th>
							<th class="oranye">261</th>
							<th class="oranye">262</th>
							<th class="oranye">263</th>
							<th class="oranye">264</th>
							<th class="oranye">265</th>
							<th class="oranye">266</th>
							<th class="oranye">267</th>
							<th class="oranye">268</th>
							<th class="oranye">269</th>
							<th class="oranye">270</th>
							<th class="oranye">271</th>
							<th class="oranye">272</th>
							<th class="oranye">273</th>
							<th class="oranye">274</th>
							<th class="oranye">275</th>
							<th class="oranye">276</th>
							<th class="oranye">277</th>
							<th class="oranye">278</th>
							<th class="oranye">279</th>
							<th class="oranye">280</th>
							<th class="oranye">281</th>
							<th class="oranye">282</th>
							<th class="oranye">283</th>
							<th class="oranye">284</th>
							<th class="oranye">285</th>
							<th class="oranye">286</th>
							<th class="oranye">287</th>
							<th class="oranye">288</th>
							<th class="oranye">289</th>
							<th class="oranye">290</th>
							<th class="oranye">291</th>
							<th class="oranye">292</th>
							<th class="oranye">293</th>
							<th class="oranye">294</th>
							<th class="oranye">295</th>
							<th class="oranye">296</th>
							<th class="oranye">297</th>
							<th class="oranye">298</th>
							<th class="oranye">299</th>							
							<th class="oranye">300</th>
							<th class="oranye">301</th>							
							<th class="oranye">302</th>
							<th class="oranye">303</th>							
							<th class="oranye">304</th>
							<th class="oranye">305</th>							
							<th class="oranye">306</th>
							<th class="oranye">307</th>							
							<th class="oranye">308</th>
							<th class="oranye">309</th>							
							<th class="oranye">310</th>
							<th class="oranye">311</th>							
							<th class="oranye">312</th>
							<th class="oranye">313</th>							
							<th class="oranye">314</th>
							<th class="oranye">315</th>							
							<th class="oranye">316</th>
							<th class="oranye">317</th>							
							<th class="oranye">318</th>
							<th class="oranye">319</th>
							<th class="oranye">320</th>
							<th class="oranye">321</th>
							<th class="oranye">322</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// ini buat insert pertama kali saja
						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `$tbstokopnam` WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
						if ($cek == 0){			
							$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
							while($data = mysqli_fetch_assoc($query1)){
								$str1 = "INSERT INTO `$tbstokopnam`(`Tahun`,`KodePuskesmas`,`KodeBarang`)
								VALUES ('$tahun','$kodepuskesmas','$data[KodeBarang]')";
								// echo $str1;
								// die();
								mysqli_query($koneksi, $str1);
							}
						}
							
						$jumlah_perpage = 20;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
							
						$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` LIKE '%$key%' OR `KodeBarang` LIKE '%$key%' OR `NamaProgram` LIKE '%$key%')";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='323'>$data[NamaProgram]</td></tr>";
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
							if($data['NamaProgram'] != "VAKSIN"){
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
							}else{
							$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
							}
							
							$total_penerimaan_apbd = $penerimaan_apbd_01['Jumlah'] + $penerimaan_apbd_02['Jumlah'] + $penerimaan_apbd_03['Jumlah'] + $penerimaan_apbd_04['Jumlah'] + $penerimaan_apbd_05['Jumlah'] + $penerimaan_apbd_06['Jumlah'] + $penerimaan_apbd_07['Jumlah'] + $penerimaan_apbd_08['Jumlah'] + $penerimaan_apbd_09['Jumlah'] + $penerimaan_apbd_10['Jumlah'] + $penerimaan_apbd_11['Jumlah'] + $penerimaan_apbd_12['Jumlah'];
							$total_penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'] + $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'] + $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'] + $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
							$total_penerimaan = $total_penerimaan_apbd + $total_penerimaan_jkn;
							
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
							$pemakaian_apbd_01 = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
							$pemakaian_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
							
							// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
							$pemakaian_apbd_02 = $total_sisastok_apbd_01 + $penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
							$pemakaian_jkn_02 = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
							$pemakaian_apbd_03 = $total_sisastok_apbd_02 + $penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
							$pemakaian_jkn_03 = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
							$pemakaian_apbd_04 = $total_sisastok_apbd_03 + $penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
							$pemakaian_jkn_04 = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
							$pemakaian_apbd_05 = $total_sisastok_apbd_04 + $penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
							$pemakaian_jkn_05 = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
							$pemakaian_apbd_06 = $total_sisastok_apbd_05 + $penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
							$pemakaian_jkn_06 = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
							echo $total_sisastok_jkn_05." + <br/>";
							echo $dtstokopname['PenerimaanJkn_06']."<br/>";
							$pemakaian_apbd_07 = $total_sisastok_apbd_06 + $penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
							$pemakaian_jkn_07 = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
							$pemakaian_apbd_08 = $total_sisastok_apbd_07 + $penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
							$pemakaian_jkn_08 = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
							$pemakaian_apbd_09 = $total_sisastok_apbd_08 + $penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
							$pemakaian_jkn_09 = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
							$pemakaian_apbd_10 = $total_sisastok_apbd_09 + $penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
							$pemakaian_jkn_10 = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
							$pemakaian_apbd_11 = $total_sisastok_apbd_10 + $penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
							$pemakaian_jkn_11 = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
							$pemakaian_apbd_12 = $total_sisastok_apbd_11 + $penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
							$pemakaian_jkn_12 = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
							
							// echo "Pemakaian : ".$total_sisastok_apbd_11;
									
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
											echo "";
										}
									?>
								</td>					
								<td align="right">
									<?php 
										if($dtstokopname['StokAwalJkn'] != 0){
											echo rupiah($dtstokopname['StokAwalJkn']);
										}else{
											echo "";
										}
									?>
								</td>	
								
								<!--Penerimaan-->		
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_01['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_01['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_01'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_01']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_02['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_02['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_02'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_02']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_03['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_03['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_03'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_03']);
										}else{
											echo "";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_04['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_04['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_04'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_04']);
										}else{
											echo "";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_05['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_05['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_05'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_05']);
										}else{
											echo "";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_06['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_06['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_06'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_06']);
										}else{
											echo "";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_07['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_07['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_07'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_07']);
										}else{
											echo "";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_08['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_08['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_08'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_08']);
										}else{
											echo "";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_09['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_09['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_09'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_09']);
										}else{
											echo "";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_10['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_10['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_10'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_10']);
										}else{
											echo "";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_11['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_11['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_11'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_11']);
										}else{
											echo "";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($penerimaan_apbd_12['Jumlah'] != 0){
											echo rupiah($penerimaan_apbd_12['Jumlah']);
										}else{
											echo "";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_12'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_12']);
										}else{
											echo "";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($total_penerimaan_apbd != 0){
											echo rupiah($total_penerimaan_apbd);
										}else{
											echo "";
										}
									?>
								</td>									
								<td align="right" class="pink">
									<?php 
										if($total_penerimaan_jkn != 0){
											echo rupiah($total_penerimaan_jkn);
										}else{
											echo "";
										}
									?>
								</td>									
								<td align="right" class="pink">
									<?php 
										if($total_penerimaan != 0){
											echo rupiah($total_penerimaan);
										}else{
											echo "";
										}
									?>
								</td>
								
								<!--Persediaan-->
								<td align="right" class="pinktua">
									<?php 
										$persediaan = $total_penerimaan + $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
										if($persediaan != 0){
											echo rupiah($persediaan);
										}else{
											echo "";
										}
									?>
								</td>
								
								<!--Pemakaian-->
								<td align="right" class="kuning"><?php if($pemakaian_apbd_01 != 0){ echo rupiah($pemakaian_apbd_01); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_01 != 0){ echo rupiah($pemakaian_jkn_01); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_02 != 0){ echo rupiah($pemakaian_apbd_02); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_02 != 0){ echo rupiah($pemakaian_jkn_02); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_03 != 0){ echo rupiah($pemakaian_apbd_03); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_03 != 0){ echo rupiah($pemakaian_jkn_03); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_04 != 0){ echo rupiah($pemakaian_apbd_04); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_04 != 0){ echo rupiah($pemakaian_jkn_04); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_05 != 0){ echo rupiah($pemakaian_apbd_05); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_05 != 0){ echo rupiah($pemakaian_jkn_05); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_06 != 0){ echo rupiah($pemakaian_apbd_06); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_06 != 0){ echo rupiah($pemakaian_jkn_06); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_07 != 0){ echo rupiah($pemakaian_apbd_07); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_07 != 0){ echo rupiah($pemakaian_jkn_07); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_08 != 0){ echo rupiah($pemakaian_apbd_08); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_08 != 0){ echo rupiah($pemakaian_jkn_08); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_09 != 0){ echo rupiah($pemakaian_apbd_09); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_09 != 0){ echo rupiah($pemakaian_jkn_09); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_10 != 0){ echo rupiah($pemakaian_apbd_10); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_10 != 0){ echo rupiah($pemakaian_jkn_10); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_11 != 0){ echo rupiah($pemakaian_apbd_11); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_11 != 0){ echo rupiah($pemakaian_jkn_11); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_apbd_12 != 0){ echo rupiah($pemakaian_apbd_12); }else{ echo ""; }?></td>
								<td align="right" class="kuning"><?php if($pemakaian_jkn_12 != 0){ echo rupiah($pemakaian_jkn_12); }else{ echo ""; }?></td>
								<td align="right" class="kuning">
								<?php
									// total pemakaian apbd	
									$pemakaian_apbd = $pemakaian_apbd_01 + $pemakaian_apbd_02 + $pemakaian_apbd_03 + $pemakaian_apbd_04 + $pemakaian_apbd_05 + $pemakaian_apbd_06 + $pemakaian_apbd_07 + $pemakaian_apbd_08 + $pemakaian_apbd_09 + $pemakaian_apbd_10 + $pemakaian_apbd_11 + $pemakaian_apbd_12;
									if($pemakaian_apbd != 0){
										echo rupiah($pemakaian_apbd);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="kuning">
								<?php
									// total pemakaian jkn	
									$pemakaian_jkn = $pemakaian_jkn_01 + $pemakaian_jkn_02 + $pemakaian_jkn_03 + $pemakaian_jkn_04 + $pemakaian_jkn_05 + $pemakaian_jkn_06 + $pemakaian_jkn_07 + $pemakaian_jkn_08 + $pemakaian_jkn_09 + $pemakaian_jkn_10 + $pemakaian_jkn_11 + $pemakaian_jkn_12;
									if($pemakaian_jkn != 0){
										echo rupiah($pemakaian_jkn);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="kuning">
								<?php
									// total pemakaian
									$totalpemakaian = $pemakaian_apbd + $pemakaian_jkn;
									if($totalpemakaian != 0){
										echo rupiah($totalpemakaian);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 01-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_01']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($total_sisastok_apbd_01 != 0){
											echo rupiah($total_sisastok_apbd_01);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($total_sisastok_jkn_01 != 0){
											echo rupiah($total_sisastok_jkn_01);
										}else{
											echo "";
										}
									?>
								</td>
								
								<!--Sisa Stok 02-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_02']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_02 != 0){
										echo rupiah($total_sisastok_apbd_02);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_02 != 0){
										echo rupiah($total_sisastok_jkn_02);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 03-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_03']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_03 != 0){
										echo rupiah($total_sisastok_apbd_03);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_03 != 0){
										echo rupiah($total_sisastok_jkn_03);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 04-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_04']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_04 != 0){
										echo rupiah($total_sisastok_apbd_04);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_04 != 0){
										echo rupiah($total_sisastok_jkn_04);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 05-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_05']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_05 != 0){
										echo rupiah($total_sisastok_apbd_05);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_05 != 0){
										echo rupiah($total_sisastok_jkn_05);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 06-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_06']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_06 != 0){
										echo rupiah($total_sisastok_apbd_06);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_06 != 0){
										echo rupiah($total_sisastok_jkn_06);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 07-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_07']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_07 != 0){
										echo rupiah($total_sisastok_apbd_07);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php
									if($total_sisastok_jkn_07 != 0){
										echo rupiah($total_sisastok_jkn_07);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 08-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_08']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_08 != 0){
										echo rupiah($total_sisastok_apbd_08);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_08 != 0){
										echo rupiah($total_sisastok_jkn_08);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 09-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_09']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_09 != 0){
										echo rupiah($total_sisastok_apbd_09);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_09 != 0){
										echo rupiah($total_sisastok_jkn_09);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 10-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_10']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_10 != 0){
										echo rupiah($total_sisastok_apbd_10);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_10 != 0){
										echo rupiah($total_sisastok_jkn_10);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 11-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_11']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_11 != 0){
										echo rupiah($total_sisastok_apbd_11);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_11 != 0){
										echo rupiah($total_sisastok_jkn_11);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok 12-->
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Gudang_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Gudang_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Depot_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Depot_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Igd_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Igd_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Ranap_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Ranap_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poned_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poned_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pustu_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pustu_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Pusling_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Pusling_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Poli_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Poli_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Apbd_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
									<?php 
										if($dtstokopname['Sisastok_Lainnya_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Sisastok_Lainnya_Jkn_12']);
										}else{
											echo "";
										}
									?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_apbd_12 != 0){
										echo rupiah($total_sisastok_apbd_12);
									}else{
										echo "";
									}
								?>
								</td>
								<td align="right" class="oranye">
								<?php 
									if($total_sisastok_jkn_12 != 0){
										echo rupiah($total_sisastok_jkn_12);
									}else{
										echo "";
									}
								?>
								</td>
								
								<!--Sisa Stok Total (Rumus) gak narik dari database, cukup ambil dari bulan terakhir aja (desember)-->
								<?php
									// apbd
									$gudang_apbd_jumlah = $dtstokopname['Sisastok_Gudang_Apbd_12'];
									$depot_apbd_jumlah = $dtstokopname['Sisastok_Depot_Apbd_12'];
									$igd_apbd_jumlah = $dtstokopname['Sisastok_Igd_Apbd_12'];
									$ranap_apbd_jumlah = $dtstokopname['Sisastok_Ranap_Apbd_12'];
									$poned_apbd_jumlah = $dtstokopname['Sisastok_Poned_Apbd_12'];
									$pustu_apbd_jumlah = $dtstokopname['Sisastok_Pustu_Apbd_12'];
									$pusling_apbd_jumlah = $dtstokopname['Sisastok_Pusling_Apbd_12'];
									$poli_apbd_jumlah = $dtstokopname['Sisastok_Poli_Apbd_12'];
									$lainnya_apbd_jumlah = $dtstokopname['Sisastok_Lainnya_Apbd_12'];
									$gudang_apbd_total = $gudang_apbd_jumlah * $harga_apbd;
									$depot_apbd_total = $depot_apbd_jumlah * $harga_apbd;
									$igd_apbd_total = $igd_apbd_jumlah * $harga_apbd;
									$ranap_apbd_total = $ranap_apbd_jumlah * $harga_apbd;
									$poned_apbd_total = $poned_apbd_jumlah * $harga_apbd;
									$pustu_apbd_total = $pustu_apbd_jumlah * $harga_apbd;
									$pusling_apbd_total = $pusling_apbd_jumlah * $harga_apbd;
									$poli_apbd_total = $poli_apbd_jumlah * $harga_apbd;
									$lainnya_apbd_total = $lainnya_apbd_jumlah * $harga_apbd;
									$sisa_stok_apbd_total = $gudang_apbd_total + $depot_apbd_total + $igd_apbd_total + $ranap_apbd_total + $poned_apbd_total + $pustu_apbd_total + $pusling_apbd_total + $poli_apbd_total + $lainnya_apbd_total;
									// jkn
									$gudang_jkn_jumlah = $dtstokopname['Sisastok_Gudang_Jkn_12'];
									$depot_jkn_jumlah = $dtstokopname['Sisastok_Depot_Jkn_12'];;
									$igd_jkn_jumlah = $dtstokopname['Sisastok_Igd_Jkn_12'];;
									$ranap_jkn_jumlah = $dtstokopname['Sisastok_Ranap_Jkn_12'];;
									$poned_jkn_jumlah = $dtstokopname['Sisastok_Poned_Jkn_12'];;
									$pustu_jkn_jumlah = $dtstokopname['Sisastok_Pustu_Jkn_12'];;
									$pusling_jkn_jumlah = $dtstokopname['Sisastok_Pusling_Jkn_12'];;
									$poli_jkn_jumlah = $dtstokopname['Sisastok_Poli_Jkn_12'];;
									$lainnya_jkn_jumlah = $dtstokopname['Sisastok_Lainnya_Jkn_12'];;
									$gudang_jkn_total = $gudang_jkn_jumlah * $harga_jkn;
									$depot_jkn_total = $depot_jkn_jumlah * $harga_jkn;
									$igd_jkn_total = $igd_jkn_jumlah * $harga_jkn;
									$ranap_jkn_total = $ranap_jkn_jumlah * $harga_jkn;
									$poned_jkn_total = $poned_jkn_jumlah * $harga_jkn;
									$pustu_jkn_total = $pustu_jkn_jumlah * $harga_jkn;
									$pusling_jkn_total = $pusling_jkn_jumlah * $harga_jkn;
									$poli_jkn_total = $poli_jkn_jumlah * $harga_jkn;
									$lainnya_jkn_total = $lainnya_jkn_jumlah * $harga_jkn;
									$sisa_stok_jkn_total = $gudang_jkn_total + $depot_jkn_total + $igd_jkn_total + $ranap_jkn_total + $poned_jkn_total + $pustu_jkn_total + $pusling_jkn_total + $poli_jkn_total + $lainnya_jkn_total;
									
								?>
								<td align="right" class="oranye"><?php if($gudang_apbd_total != 0){echo rupiah($gudang_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($gudang_jkn_total != 0){echo rupiah($gudang_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($depot_apbd_total != 0){echo rupiah($depot_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($depot_jkn_total != 0){echo rupiah($depot_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($igd_apbd_total != 0){echo rupiah($igd_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($igd_jkn_total != 0){echo rupiah($igd_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($ranap_apbd_total != 0){echo rupiah($ranap_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($ranap_jkn_total != 0){echo rupiah($ranap_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($poned_apbd_total != 0){echo rupiah($poned_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($poned_jkn_total != 0){echo rupiah($poned_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($pustu_apbd_total != 0){echo rupiah($pustu_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($pustu_jkn_total != 0){echo rupiah($pustu_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($pusling_apbd_total != 0){echo rupiah($pusling_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($pusling_jkn_total != 0){echo rupiah($pusling_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($poli_apbd_total != 0){echo rupiah($poli_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($poli_jkn_total != 0){echo rupiah($poli_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($lainnya_apbd_total != 0){echo rupiah($lainnya_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($lainnya_jkn_total != 0){echo rupiah($lainnya_jkn_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($sisa_stok_apbd_total != 0){echo rupiah($sisa_stok_apbd_total);}else{ echo "";}?></td>
								<td align="right" class="oranye"><?php if($sisa_stok_jkn_total != 0){echo rupiah($sisa_stok_jkn_total);}else{ echo "";}?></td>
							</tr>
						<?php	
						}	
						?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
	<ul class="pagination">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_importdata&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
		}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Langkah Pengisian :</b><br/>
					- Download Template (format excel)<br/>
					- <b>Penerimaan (APBD)</b>, narik otomatis dari Pengeluaran Dinkes<br/>
					- <b>Penerimaan (JKN)</b>, silahkan isi penerimaan bulan (Jan s/d Des)<br/>
					- <b>Sisa Stok</b>, silahkan isi sisa stok bulan (Jan s/d Des) <br/>
					<span style="margin-left:10px;">berdasarkan (Gudang, Depot, IGD, Ranap, Poned, Pustu, Pusling, Poli, Lainnya)</span><br/>
					- <b>Pemakaian</b>, terhitung secara otomatis<br/>
				</p>
			</div>
		</div>
	</div>
</div>	

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	$('body').on("click",".btnsimpans", function(event) {
    $('html,body').scrollTop(0);
    $(".aleret").html("");
    
      var urlaction = $("#formsx").attr('action');
      var datak = $("#formsx").serializeArray();
      var fd = new FormData();
      $('.filex').each(function(index,val){
	      const x_x = val.files[0];
	      var attr_name = $(this).attr('name');
	      if(typeof x_x !== 'undefined'){
	        fd.append(attr_name,x_x,x_x.name);        
	      }
	    });
      $.each(datak,function(key,input){
        fd.append(input.name,input.value);
      });
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              percentComplete = parseInt(percentComplete * 100);
              console.log(percentComplete);
              var elem = document.getElementById("myBar");
              elem.style.display = "block";
              elem.style.width =percentComplete+"%";
              if (percentComplete === 100) {
                elem.style.width ="100%";
              }
            }
          }, false);
          return xhr;
        },
        type:"POST", 
        url:urlaction,
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        success: function(data){
          var elem = document.getElementById("myBar");
          elem.style.display = "none";
         // var obj = JSON.parse(data);
          if(data == 'sukses'){
            $(".aleret").html("<div class='alert alert-success'>File berhasil import, Silahkan refresh halaman ini</div>");        
          }else{
            $(".aleret").html("<div class='alert alert-danger'>File gagal di import</div>");
          }
        }
      });
   
});
</script>
