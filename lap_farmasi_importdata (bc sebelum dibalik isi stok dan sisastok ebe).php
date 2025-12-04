<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeobat = $_POST['kode'];
	$tahun = date('Y');
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
					<div class="col-sm-9">
						<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_farmasi_importdata_import.php" id="formsx">
							<table width="100%" style="margin-bottom: 10px;">	
								<tr>
									<td width="15%">
										Upload data (Excel): 
									</td>
									<td width="25%">
										<input name="fileexcel" type="file" class="filex" required="required"> 
									</td>
									<td width="20%">
										<input type="hidden" name="tahun" value="<?php echo $tahun;?>">
										<input name="upload" type="button" value="Import Data" class="btn btn-danger btn-white btnsimpans">
										<a href="?page=lap_farmasi_importdata" class="btn btn-primary btn-white"><span class="fa fa-refresh"></span></a>
										<a href="lap_farmasi_importdata_excel.php" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
									</td>
								</tr>
							</table>
						</form>
					</div>
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
	.kuning {
		background: #fff2bf!important;
	}	
	.oranye {
		background: #f9e2ca!important;
	}
	</style>
	
	<?php		
		$tahun = date('Y');
		$tahunlalu = $tahun - 1;
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namaprogram = $_GET['namaprogram'];
		
		if(isset($tahun)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:12000px">
					<thead>
						<tr>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">No.</th>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">Kode</th>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">Nama Obat & BMHP</th>
							<th rowspan="4" style="background: #fff; color: #7a7a7a;">Satuan</th>
							<th rowspan="2" style="background: #fff; color: #7a7a7a;" colspan="2">Stok Awal <br/>(Januari <?php echo $tahunlalu;?>)</th>
							<th colspan="26" class="pink">Penerimaan</th>
							<th rowspan="4" class="pink">Total </br>Penerimaan</th>
							<th colspan="234" class="kuning">Pemakaian</th>
							<th rowspan="4" class="kuning">Total </br>Pemakaian</th>
							<th colspan="24" class="oranye">Sisastok</th>
							<th rowspan="4" class="oranye">Total </br>Sisa Stok</th>
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
							<th colspan="2" class="pink">Ttl</th>
							<th colspan="18" class="kuning">01</th><!--Pemakaian-->
							<th colspan="18" class="kuning">02</th>
							<th colspan="18" class="kuning">03</th>
							<th colspan="18" class="kuning">04</th>
							<th colspan="18" class="kuning">05</th>
							<th colspan="18" class="kuning">06</th>
							<th colspan="18" class="kuning">07</th>
							<th colspan="18" class="kuning">08</th>
							<th colspan="18" class="kuning">09</th>
							<th colspan="18" class="kuning">10</th>
							<th colspan="18" class="kuning">11</th>
							<th colspan="18" class="kuning">12</th>
							<th colspan="18" class="kuning">Ttl</th>
							<th colspan="2" class="oranye">01</th><!--Sisastok-->
							<th colspan="2" class="oranye">02</th>
							<th colspan="2" class="oranye">03</th>
							<th colspan="2" class="oranye">04</th>
							<th colspan="2" class="oranye">05</th>
							<th colspan="2" class="oranye">06</th>
							<th colspan="2" class="oranye">07</th>
							<th colspan="2" class="oranye">08</th>
							<th colspan="2" class="oranye">09</th>
							<th colspan="2" class="oranye">10</th>
							<th colspan="2" class="oranye">11</th>
							<th colspan="2" class="oranye">12</th>
						</tr>
						
						<tr>
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
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_01-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_02-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_03-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_04-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_05-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_06-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_07-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_08-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_09-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_10-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>							
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_11-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_12-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th colspan="2" class="kuning">Gudang</th><!--Pemakaian_ttl-->
							<th colspan="2" class="kuning">Depot</th>
							<th colspan="2" class="kuning">Igd</th>
							<th colspan="2" class="kuning">Ranap</th>
							<th colspan="2" class="kuning">Poned</th>
							<th colspan="2" class="kuning">Pustu</th>
							<th colspan="2" class="kuning">Pusling</th>
							<th colspan="2" class="kuning">Poli</th>
							<th colspan="2" class="kuning">Lainnya</th>
							<th rowspan="2" class="oranye">APBD</th><!--Sisastok-->
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
							<th rowspan="2" class="oranye">APBD</th>
							<th rowspan="2" class="oranye">JKN</th>
						</tr>
						<tr>
							<th class="kuning">APBD</th><!--Pemakaian_01-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_02-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_03-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_04-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_05-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_06-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_07-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_08-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_09-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_10-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_11-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_12-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th><!--Pemakaian_ttl-->
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
							<th class="kuning">APBD</th>
							<th class="kuning">JKN</th>
						</tr>
						<tr>
							<th style="background: #fff; color: #7a7a7a;">1</th>
							<th style="background: #fff; color: #7a7a7a;">2</th>
							<th style="background: #fff; color: #7a7a7a;">3</th>
							<th style="background: #fff; color: #7a7a7a;">4</th>
							<th style="background: #fff; color: #7a7a7a;">5</th>
							<th style="background: #fff; color: #7a7a7a;">6</th>
							<th class="pink">7</th>
							<th class="pink">8</th>
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
							<th class="kuning">34</th>
							<th class="kuning">35</th>
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
							<th class="kuning">63</th>
							<th class="kuning">64</th>
							<th class="kuning">65</th>
							<th class="kuning">66</th>
							<th class="kuning">67</th>
							<th class="kuning">68</th>
							<th class="kuning">69</th>
							<th class="kuning">70</th>
							<th class="kuning">71</th>
							<th class="kuning">72</th>
							<th class="kuning">73</th>
							<th class="kuning">74</th>
							<th class="kuning">75</th>
							<th class="kuning">76</th>
							<th class="kuning">77</th>
							<th class="kuning">78</th>
							<th class="kuning">79</th>
							<th class="kuning">80</th>
							<th class="kuning">81</th>
							<th class="kuning">82</th>
							<th class="kuning">83</th>
							<th class="kuning">84</th>
							<th class="kuning">85</th>
							<th class="kuning">86</th>
							<th class="kuning">87</th>
							<th class="kuning">88</th>
							<th class="kuning">89</th>
							<th class="kuning">90</th>
							<th class="kuning">91</th>
							<th class="kuning">92</th>
							<th class="kuning">93</th>
							<th class="kuning">94</th>
							<th class="kuning">95</th>
							<th class="kuning">96</th>
							<th class="kuning">97</th>
							<th class="kuning">98</th>
							<th class="kuning">99</th>
							<th class="kuning">100</th>
							<th class="kuning">101</th>
							<th class="kuning">102</th>
							<th class="kuning">103</th>
							<th class="kuning">104</th>
							<th class="kuning">105</th>
							<th class="kuning">106</th>
							<th class="kuning">107</th>
							<th class="kuning">108</th>
							<th class="kuning">109</th>
							<th class="kuning">110</th>
							<th class="kuning">111</th>
							<th class="kuning">112</th>
							<th class="kuning">113</th>
							<th class="kuning">114</th>
							<th class="kuning">115</th>
							<th class="kuning">116</th>
							<th class="kuning">117</th>
							<th class="kuning">118</th>
							<th class="kuning">119</th>
							<th class="kuning">120</th>
							<th class="kuning">121</th>
							<th class="kuning">122</th>
							<th class="kuning">123</th>
							<th class="kuning">124</th>
							<th class="kuning">125</th>
							<th class="kuning">126</th>
							<th class="kuning">127</th>
							<th class="kuning">128</th>
							<th class="kuning">129</th>
							<th class="kuning">130</th>
							<th class="kuning">131</th>
							<th class="kuning">132</th>
							<th class="kuning">133</th>
							<th class="kuning">134</th>
							<th class="kuning">135</th>
							<th class="kuning">136</th>
							<th class="kuning">137</th>
							<th class="kuning">138</th>
							<th class="kuning">139</th>
							<th class="kuning">140</th>
							<th class="kuning">141</th>
							<th class="kuning">142</th>
							<th class="kuning">143</th>
							<th class="kuning">144</th>
							<th class="kuning">145</th>
							<th class="kuning">146</th>
							<th class="kuning">147</th>
							<th class="kuning">148</th>
							<th class="kuning">149</th>
							<th class="kuning">150</th>
							<th class="kuning">151</th>
							<th class="kuning">152</th>
							<th class="kuning">153</th>
							<th class="kuning">154</th>
							<th class="kuning">155</th>
							<th class="kuning">156</th>
							<th class="kuning">157</th>
							<th class="kuning">158</th>
							<th class="kuning">159</th>
							<th class="kuning">160</th>
							<th class="kuning">161</th>
							<th class="kuning">162</th>
							<th class="kuning">163</th>
							<th class="kuning">164</th>
							<th class="kuning">165</th>
							<th class="kuning">166</th>
							<th class="kuning">167</th>
							<th class="kuning">168</th>
							<th class="kuning">169</th>
							<th class="kuning">170</th>
							<th class="kuning">171</th>
							<th class="kuning">172</th>
							<th class="kuning">173</th>
							<th class="kuning">174</th>
							<th class="kuning">175</th>
							<th class="kuning">176</th>
							<th class="kuning">177</th>
							<th class="kuning">178</th>
							<th class="kuning">179</th>
							<th class="kuning">180</th>
							<th class="kuning">181</th>
							<th class="kuning">182</th>
							<th class="kuning">183</th>
							<th class="kuning">184</th>
							<th class="kuning">185</th>
							<th class="kuning">186</th>
							<th class="kuning">187</th>
							<th class="kuning">188</th>
							<th class="kuning">189</th>
							<th class="kuning">190</th>
							<th class="kuning">191</th>
							<th class="kuning">192</th>
							<th class="kuning">193</th>
							<th class="kuning">194</th>
							<th class="kuning">195</th>
							<th class="kuning">196</th>
							<th class="kuning">197</th>
							<th class="kuning">198</th>
							<th class="kuning">199</th>
							<th class="kuning">200</th>
							<th class="kuning">201</th>
							<th class="kuning">202</th>
							<th class="kuning">203</th>
							<th class="kuning">204</th>
							<th class="kuning">205</th>
							<th class="kuning">206</th>
							<th class="kuning">207</th>
							<th class="kuning">208</th>
							<th class="kuning">209</th>
							<th class="kuning">210</th>
							<th class="kuning">211</th>
							<th class="kuning">212</th>
							<th class="kuning">213</th>
							<th class="kuning">214</th>
							<th class="kuning">215</th>
							<th class="kuning">216</th>
							<th class="kuning">217</th>
							<th class="kuning">218</th>
							<th class="kuning">219</th>
							<th class="kuning">220</th>
							<th class="kuning">221</th>
							<th class="kuning">222</th>
							<th class="kuning">223</th>
							<th class="kuning">224</th>
							<th class="kuning">225</th>
							<th class="kuning">226</th>
							<th class="kuning">227</th>
							<th class="kuning">228</th>
							<th class="kuning">229</th>
							<th class="kuning">230</th>
							<th class="kuning">231</th>
							<th class="kuning">232</th>
							<th class="kuning">233</th>
							<th class="kuning">234</th>
							<th class="kuning">235</th>
							<th class="kuning">236</th>
							<th class="kuning">237</th>
							<th class="kuning">238</th>
							<th class="kuning">239</th>
							<th class="kuning">240</th>
							<th class="kuning">241</th>
							<th class="kuning">242</th>
							<th class="kuning">243</th>
							<th class="kuning">244</th>
							<th class="kuning">245</th>
							<th class="kuning">246</th>
							<th class="kuning">247</th>
							<th class="kuning">248</th>
							<th class="kuning">249</th>
							<th class="kuning">250</th>
							<th class="kuning">251</th>
							<th class="kuning">252</th>
							<th class="kuning">253</th>
							<th class="kuning">254</th>
							<th class="kuning">255</th>
							<th class="kuning">256</th>
							<th class="kuning">257</th>
							<th class="kuning">258</th>
							<th class="kuning">259</th>
							<th class="kuning">260</th>
							<th class="kuning">261</th>
							<th class="kuning">262</th>
							<th class="kuning">263</th>
							<th class="kuning">264</th>
							<th class="kuning">265</th>
							<th class="kuning">266</th>
							<th class="kuning">267</th>
							<th class="kuning">268</th>
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
						</tr>
					</thead>
					<tbody>
						<?php
						// ini buat insert pertama kali saja
						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbstokopnam_puskesmas_bogorkab` WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
						if ($cek == 0){			
							$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
							while($data = mysqli_fetch_assoc($query1)){
								$str1 = "INSERT INTO `tbstokopnam_puskesmas_bogorkab`(`Tahun`,`KodePuskesmas`,`KodeBarang`)
								VALUES ('$tahun','$kodepuskesmas','$data[KodeBarang]')";
								// echo $str1;
								// die();
								mysqli_query($koneksi, $str1);
							}
						}
							
						$jumlah_perpage = 10;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
							
						$str = "SELECT * FROM `ref_obat_lplpo`";
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
								echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='293'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}		
						
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							
							// tbstokopnam_puskesmas_bogorkab
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_bogorkab` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							
							// penerimaan
							$total_penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'] + $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'] + $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'] + $dtstokopname['PenerimaanApbd_10'] + $dtstokopname['PenerimaanApbd_11'] + $dtstokopname['PenerimaanApbd_12'];
							$total_penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'] + $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'] + $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'] + $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
							$total_penerimaan = $total_penerimaan_apbd + $total_penerimaan_jkn;
							
							// pemakaian
							$total_gudang_apbd = $dtstokopname['Pemakaian_Gudang_Apbd_01'] + $dtstokopname['Pemakaian_Gudang_Apbd_02'] + $dtstokopname['Pemakaian_Gudang_Apbd_03'] + $dtstokopname['Pemakaian_Gudang_Apbd_04'] + $dtstokopname['Pemakaian_Gudang_Apbd_05'] + $dtstokopname['Pemakaian_Gudang_Apbd_06'] + $dtstokopname['Pemakaian_Gudang_Apbd_07'] + $dtstokopname['Pemakaian_Gudang_Apbd_08'] + $dtstokopname['Pemakaian_Gudang_Apbd_09'] + $dtstokopname['Pemakaian_Gudang_Apbd_10'] + $dtstokopname['Pemakaian_Gudang_Apbd_11'] + $dtstokopname['Pemakaian_Gudang_Apbd_12'];
							$total_gudang_jkn = $dtstokopname['Pemakaian_Gudang_Jkn_01'] + $dtstokopname['Pemakaian_Gudang_Jkn_02'] + $dtstokopname['Pemakaian_Gudang_Jkn_03'] + $dtstokopname['Pemakaian_Gudang_Jkn_04'] + $dtstokopname['Pemakaian_Gudang_Jkn_05'] + $dtstokopname['Pemakaian_Gudang_Jkn_06'] + $dtstokopname['Pemakaian_Gudang_Jkn_07'] + $dtstokopname['Pemakaian_Gudang_Jkn_08'] + $dtstokopname['Pemakaian_Gudang_Jkn_09'] + $dtstokopname['Pemakaian_Gudang_Jkn_10'] + $dtstokopname['Pemakaian_Gudang_Jkn_11'] + $dtstokopname['Pemakaian_Gudang_Jkn_12'];
							$total_depot_apbd = $dtstokopname['Pemakaian_Depot_Apbd_01'] + $dtstokopname['Pemakaian_Depot_Apbd_02'] + $dtstokopname['Pemakaian_Depot_Apbd_03'] + $dtstokopname['Pemakaian_Depot_Apbd_04'] + $dtstokopname['Pemakaian_Depot_Apbd_05'] + $dtstokopname['Pemakaian_Depot_Apbd_06'] + $dtstokopname['Pemakaian_Depot_Apbd_07'] + $dtstokopname['Pemakaian_Depot_Apbd_08'] + $dtstokopname['Pemakaian_Depot_Apbd_09'] + $dtstokopname['Pemakaian_Depot_Apbd_10'] + $dtstokopname['Pemakaian_Depot_Apbd_11'] + $dtstokopname['Pemakaian_Depot_Apbd_12'];
							$total_depot_jkn = $dtstokopname['Pemakaian_Depot_Jkn_01'] + $dtstokopname['Pemakaian_Depot_Jkn_02'] + $dtstokopname['Pemakaian_Depot_Jkn_03'] + $dtstokopname['Pemakaian_Depot_Jkn_04'] + $dtstokopname['Pemakaian_Depot_Jkn_05'] + $dtstokopname['Pemakaian_Depot_Jkn_06'] + $dtstokopname['Pemakaian_Depot_Jkn_07'] + $dtstokopname['Pemakaian_Depot_Jkn_08'] + $dtstokopname['Pemakaian_Depot_Jkn_09'] + $dtstokopname['Pemakaian_Depot_Jkn_10'] + $dtstokopname['Pemakaian_Depot_Jkn_11'] + $dtstokopname['Pemakaian_Depot_Jkn_12'];
							$total_igd_apbd = $dtstokopname['Pemakaian_Igd_Apbd_01'] + $dtstokopname['Pemakaian_Igd__Apbd_02'] + $dtstokopname['Pemakaian_Igd_Apbd_03'] + $dtstokopname['Pemakaian_Igd_Apbd_04'] + $dtstokopname['Pemakaian_Igd_Apbd_05'] + $dtstokopname['Pemakaian_Igd_Apbd_06'] + $dtstokopname['Pemakaian_Igd_Apbd_07'] + $dtstokopname['Pemakaian_Igd_Apbd_08'] + $dtstokopname['Pemakaian_Igd_Apbd_09'] + $dtstokopname['Pemakaian_Igd_Apbd_10'] + $dtstokopname['Pemakaian_Igd_Apbd_11'] + $dtstokopname['Pemakaian_Igd_Apbd_12'];
							$total_igd_jkn = $dtstokopname['Pemakaian_Igd_Jkn_01'] + $dtstokopname['Pemakaian_Igd__Jkn_02'] + $dtstokopname['Pemakaian_Igd_Jkn_03'] + $dtstokopname['Pemakaian_Igd_Jkn_04'] + $dtstokopname['Pemakaian_Igd_Jkn_05'] + $dtstokopname['Pemakaian_Igd_Jkn_06'] + $dtstokopname['Pemakaian_Igd_Jkn_07'] + $dtstokopname['Pemakaian_Igd_Jkn_08'] + $dtstokopname['Pemakaian_Igd_Jkn_09'] + $dtstokopname['Pemakaian_Igd_Jkn_10'] + $dtstokopname['Pemakaian_Igd_Jkn_11'] + $dtstokopname['Pemakaian_Igd_Jkn_12'];
							$total_ranap_apbd = $dtstokopname['Pemakaian_Ranap_Apbd_01'] + $dtstokopname['Pemakaian_Ranap_Apbd_02'] + $dtstokopname['Pemakaian_Ranap_Apbd_03'] + $dtstokopname['Pemakaian_Ranap_Apbd_04'] + $dtstokopname['Pemakaian_Ranap_Apbd_05'] + $dtstokopname['Pemakaian_Ranap_Apbd_06'] + $dtstokopname['Pemakaian_Ranap_Apbd_07'] + $dtstokopname['Pemakaian_Ranap_Apbd_08'] + $dtstokopname['Pemakaian_Ranap_Apbd_09'] + $dtstokopname['Pemakaian_Ranap_Apbd_10'] + $dtstokopname['Pemakaian_Ranap_Apbd_11'] + $dtstokopname['Pemakaian_Ranap_Apbd_12'];
							$total_ranap_jkn = $dtstokopname['Pemakaian_Ranap_Jkn_01'] + $dtstokopname['Pemakaian_Ranap_Jkn_02'] + $dtstokopname['Pemakaian_Ranap_Jkn_03'] + $dtstokopname['Pemakaian_Ranap_Jkn_04'] + $dtstokopname['Pemakaian_Ranap_Jkn_05'] + $dtstokopname['Pemakaian_Ranap_Jkn_06'] + $dtstokopname['Pemakaian_Ranap_Jkn_07'] + $dtstokopname['Pemakaian_Ranap_Jkn_08'] + $dtstokopname['Pemakaian_Ranap_Jkn_09'] + $dtstokopname['Pemakaian_Ranap_Jkn_10'] + $dtstokopname['Pemakaian_Ranap_Jkn_11'] + $dtstokopname['Pemakaian_Ranap_Jkn_12'];
							$total_poned_apbd = $dtstokopname['Pemakaian_Poned_Apbd_01'] + $dtstokopname['Pemakaian_Poned_Apbd_02'] + $dtstokopname['Pemakaian_Poned_Apbd_03'] + $dtstokopname['Pemakaian_Poned_Apbd_04'] + $dtstokopname['Pemakaian_Poned_Apbd_05'] + $dtstokopname['Pemakaian_Poned_Apbd_06'] + $dtstokopname['Pemakaian_Poned_Apbd_07'] + $dtstokopname['Pemakaian_Poned_Apbd_08'] + $dtstokopname['Pemakaian_Poned_Apbd_09'] + $dtstokopname['Pemakaian_Poned_Apbd_10'] + $dtstokopname['Pemakaian_Poned_Apbd_11'] + $dtstokopname['Pemakaian_Poned_Apbd_12'];
							$total_poned_jkn = $dtstokopname['Pemakaian_Poned_Jkn_01'] + $dtstokopname['Pemakaian_Poned_Jkn_02'] + $dtstokopname['Pemakaian_Poned_Jkn_03'] + $dtstokopname['Pemakaian_Poned_Jkn_04'] + $dtstokopname['Pemakaian_Poned_Jkn_05'] + $dtstokopname['Pemakaian_Poned_Jkn_06'] + $dtstokopname['Pemakaian_Poned_Jkn_07'] + $dtstokopname['Pemakaian_Poned_Jkn_08'] + $dtstokopname['Pemakaian_Poned_Jkn_09'] + $dtstokopname['Pemakaian_Poned_Jkn_10'] + $dtstokopname['Pemakaian_Poned_Jkn_11'] + $dtstokopname['Pemakaian_Poned_Jkn_12'];
							$total_pustu_apbd = $dtstokopname['Pemakaian_Pustu_Apbd_01'] + $dtstokopname['Pemakaian_Pustu_Apbd_02'] + $dtstokopname['Pemakaian_Pustu_Apbd_03'] + $dtstokopname['Pemakaian_Pustu_Apbd_04'] + $dtstokopname['Pemakaian_Pustu_Apbd_05'] + $dtstokopname['Pemakaian_Pustu_Apbd_06'] + $dtstokopname['Pemakaian_Pustu_Apbd_07'] + $dtstokopname['Pemakaian_Pustu_Apbd_08'] + $dtstokopname['Pemakaian_Pustu_Apbd_09'] + $dtstokopname['Pemakaian_Pustu_Apbd_10'] + $dtstokopname['Pemakaian_Pustu_Apbd_11'] + $dtstokopname['Pemakaian_Pustu_Apbd_12'];
							$total_pustu_jkn = $dtstokopname['Pemakaian_Pustu_Jkn_01'] + $dtstokopname['Pemakaian_Pustu_Jkn_02'] + $dtstokopname['Pemakaian_Pustu_Jkn_03'] + $dtstokopname['Pemakaian_Pustu_Jkn_04'] + $dtstokopname['Pemakaian_Pustu_Jkn_05'] + $dtstokopname['Pemakaian_Pustu_Jkn_06'] + $dtstokopname['Pemakaian_Pustu_Jkn_07'] + $dtstokopname['Pemakaian_Pustu_Jkn_08'] + $dtstokopname['Pemakaian_Pustu_Jkn_09'] + $dtstokopname['Pemakaian_Pustu_Jkn_10'] + $dtstokopname['Pemakaian_Pustu_Jkn_11'] + $dtstokopname['Pemakaian_Pustu_Jkn_12'];
							$total_pusling_apbd = $dtstokopname['Pemakaian_Pusling_Apbd_01'] + $dtstokopname['Pemakaian_Pusling_Apbd_02'] + $dtstokopname['Pemakaian_Pusling_Apbd_03'] + $dtstokopname['Pemakaian_Pusling_Apbd_04'] + $dtstokopname['Pemakaian_Pusling_Apbd_05'] + $dtstokopname['Pemakaian_Pusling_Apbd_06'] + $dtstokopname['Pemakaian_Pusling_Apbd_07'] + $dtstokopname['Pemakaian_Pusling_Apbd_08'] + $dtstokopname['Pemakaian_Pusling_Apbd_09'] + $dtstokopname['Pemakaian_Pusling_Apbd_10'] + $dtstokopname['Pemakaian_Pusling_Apbd_11'] + $dtstokopname['Pemakaian_Pusling_Apbd_12'];
							$total_pusling_jkn = $dtstokopname['Pemakaian_Pusling_Jkn_01'] + $dtstokopname['Pemakaian_Pusling_Jkn_02'] + $dtstokopname['Pemakaian_Pusling_Jkn_03'] + $dtstokopname['Pemakaian_Pusling_Jkn_04'] + $dtstokopname['Pemakaian_Pusling_Jkn_05'] + $dtstokopname['Pemakaian_Pusling_Jkn_06'] + $dtstokopname['Pemakaian_Pusling_Jkn_07'] + $dtstokopname['Pemakaian_Pusling_Jkn_08'] + $dtstokopname['Pemakaian_Pusling_Jkn_09'] + $dtstokopname['Pemakaian_Pusling_Jkn_10'] + $dtstokopname['Pemakaian_Pusling_Jkn_11'] + $dtstokopname['Pemakaian_Pusling_Jkn_12'];
							$total_poli_apbd = $dtstokopname['Pemakaian_Poli_Apbd_01'] + $dtstokopname['Pemakaian_Poli_Apbd_02'] + $dtstokopname['Pemakaian_Poli_Apbd_03'] + $dtstokopname['Pemakaian_Poli_Apbd_04'] + $dtstokopname['Pemakaian_Poli_Apbd_05'] + $dtstokopname['Pemakaian_Poli_Apbd_06'] + $dtstokopname['Pemakaian_Poli_Apbd_07'] + $dtstokopname['Pemakaian_Poli_Apbd_08'] + $dtstokopname['Pemakaian_Poli_Apbd_09'] + $dtstokopname['Pemakaian_Poli_Apbd_10'] + $dtstokopname['Pemakaian_Poli_Apbd_11'] + $dtstokopname['Pemakaian_Poli_Apbd_12'];
							$total_poli_jkn = $dtstokopname['Pemakaian_Poli_Jkn_01'] + $dtstokopname['Pemakaian_Poli_Jkn_02'] + $dtstokopname['Pemakaian_Poli_Jkn_03'] + $dtstokopname['Pemakaian_Poli_Jkn_04'] + $dtstokopname['Pemakaian_Poli_Jkn_05'] + $dtstokopname['Pemakaian_Poli_Jkn_06'] + $dtstokopname['Pemakaian_Poli_Jkn_07'] + $dtstokopname['Pemakaian_Poli_Jkn_08'] + $dtstokopname['Pemakaian_Poli_Jkn_09'] + $dtstokopname['Pemakaian_Poli_Jkn_10'] + $dtstokopname['Pemakaian_Poli_Jkn_11'] + $dtstokopname['Pemakaian_Poli_Jkn_12'];
							$total_lainnya_apbd = $dtstokopname['Pemakaian_Lainnya_Apbd_01'] + $dtstokopname['Pemakaian_Lainnya_Apbd_02'] + $dtstokopname['Pemakaian_Lainnya_Apbd_03'] + $dtstokopname['Pemakaian_Lainnya_Apbd_04'] + $dtstokopname['Pemakaian_Lainnya_Apbd_05'] + $dtstokopname['Pemakaian_Lainnya_Apbd_06'] + $dtstokopname['Pemakaian_Lainnya_Apbd_07'] + $dtstokopname['Pemakaian_Lainnya_Apbd_08'] + $dtstokopname['Pemakaian_Lainnya_Apbd_09'] + $dtstokopname['Pemakaian_Lainnya_Apbd_10'] + $dtstokopname['Pemakaian_Lainnya_Apbd_11'] + $dtstokopname['Pemakaian_Lainnya_Apbd_12'];
							$total_lainnya_jkn = $dtstokopname['Pemakaian_Lainnya_Jkn_01'] + $dtstokopname['Pemakaian_Lainnya_Jkn_02'] + $dtstokopname['Pemakaian_Lainnya_Jkn_03'] + $dtstokopname['Pemakaian_Lainnya_Jkn_04'] + $dtstokopname['Pemakaian_Lainnya_Jkn_05'] + $dtstokopname['Pemakaian_Lainnya_Jkn_06'] + $dtstokopname['Pemakaian_Lainnya_Jkn_07'] + $dtstokopname['Pemakaian_Lainnya_Jkn_08'] + $dtstokopname['Pemakaian_Lainnya_Jkn_09'] + $dtstokopname['Pemakaian_Lainnya_Jkn_10'] + $dtstokopname['Pemakaian_Lainnya_Jkn_11'] + $dtstokopname['Pemakaian_Lainnya_Jkn_12'];
							$total_pemakaian = $total_gudang_apbd + $total_gudang_jkn + $total_depot_apbd + $total_depot_jkn + $total_igd_apbd + $total_igd_jkn + $total_ranap_apbd + $total_ranap_jkn + $total_poned_apbd + $total_poned_jkn + $total_pustu_apbd + $total_pustu_jkn + $total_pusling_apbd + $total_pusling_jkn + $total_poli_apbd + $total_poli_jkn + $total_lainnya_apbd + $total_lainnya_jkn;
							
							// pemakaian bulan
							$total_pemakaian_apbd_01 = $dtstokopname['Pemakaian_Gudang_Apbd_01'] + $dtstokopname['Pemakaian_Depot_Apbd_01'] + $dtstokopname['Pemakaian_Igd_Apbd_01'] + $dtstokopname['Pemakaian_Ranap_Apbd_01'] + $dtstokopname['Pemakaian_Poned_Apbd_01'] + $dtstokopname['Pemakaian_Pustu_Apbd_01'] + $dtstokopname['Pemakaian_Pusling_Apbd_01'] + $dtstokopname['Pemakaian_Poli_Apbd_01'] + $dtstokopname['Pemakaian_Lainnya_Apbd_01'];
							$total_pemakaian_apbd_02 = $dtstokopname['Pemakaian_Gudang_Apbd_02'] + $dtstokopname['Pemakaian_Depot_Apbd_02'] + $dtstokopname['Pemakaian_Igd_Apbd_02'] + $dtstokopname['Pemakaian_Ranap_Apbd_02'] + $dtstokopname['Pemakaian_Poned_Apbd_02'] + $dtstokopname['Pemakaian_Pustu_Apbd_02'] + $dtstokopname['Pemakaian_Pusling_Apbd_02'] + $dtstokopname['Pemakaian_Poli_Apbd_02'] + $dtstokopname['Pemakaian_Lainnya_Apbd_02'];
							$total_pemakaian_apbd_03 = $dtstokopname['Pemakaian_Gudang_Apbd_03'] + $dtstokopname['Pemakaian_Depot_Apbd_03'] + $dtstokopname['Pemakaian_Igd_Apbd_03'] + $dtstokopname['Pemakaian_Ranap_Apbd_03'] + $dtstokopname['Pemakaian_Poned_Apbd_03'] + $dtstokopname['Pemakaian_Pustu_Apbd_03'] + $dtstokopname['Pemakaian_Pusling_Apbd_03'] + $dtstokopname['Pemakaian_Poli_Apbd_03'] + $dtstokopname['Pemakaian_Lainnya_Apbd_03'];
							$total_pemakaian_apbd_04 = $dtstokopname['Pemakaian_Gudang_Apbd_04'] + $dtstokopname['Pemakaian_Depot_Apbd_04'] + $dtstokopname['Pemakaian_Igd_Apbd_04'] + $dtstokopname['Pemakaian_Ranap_Apbd_04'] + $dtstokopname['Pemakaian_Poned_Apbd_04'] + $dtstokopname['Pemakaian_Pustu_Apbd_04'] + $dtstokopname['Pemakaian_Pusling_Apbd_04'] + $dtstokopname['Pemakaian_Poli_Apbd_04'] + $dtstokopname['Pemakaian_Lainnya_Apbd_04'];
							$total_pemakaian_apbd_05 = $dtstokopname['Pemakaian_Gudang_Apbd_05'] + $dtstokopname['Pemakaian_Depot_Apbd_05'] + $dtstokopname['Pemakaian_Igd_Apbd_05'] + $dtstokopname['Pemakaian_Ranap_Apbd_05'] + $dtstokopname['Pemakaian_Poned_Apbd_05'] + $dtstokopname['Pemakaian_Pustu_Apbd_05'] + $dtstokopname['Pemakaian_Pusling_Apbd_05'] + $dtstokopname['Pemakaian_Poli_Apbd_05'] + $dtstokopname['Pemakaian_Lainnya_Apbd_05'];
							$total_pemakaian_apbd_06 = $dtstokopname['Pemakaian_Gudang_Apbd_06'] + $dtstokopname['Pemakaian_Depot_Apbd_06'] + $dtstokopname['Pemakaian_Igd_Apbd_06'] + $dtstokopname['Pemakaian_Ranap_Apbd_06'] + $dtstokopname['Pemakaian_Poned_Apbd_06'] + $dtstokopname['Pemakaian_Pustu_Apbd_06'] + $dtstokopname['Pemakaian_Pusling_Apbd_06'] + $dtstokopname['Pemakaian_Poli_Apbd_06'] + $dtstokopname['Pemakaian_Lainnya_Apbd_06'];
							$total_pemakaian_apbd_07 = $dtstokopname['Pemakaian_Gudang_Apbd_07'] + $dtstokopname['Pemakaian_Depot_Apbd_07'] + $dtstokopname['Pemakaian_Igd_Apbd_07'] + $dtstokopname['Pemakaian_Ranap_Apbd_07'] + $dtstokopname['Pemakaian_Poned_Apbd_07'] + $dtstokopname['Pemakaian_Pustu_Apbd_07'] + $dtstokopname['Pemakaian_Pusling_Apbd_07'] + $dtstokopname['Pemakaian_Poli_Apbd_07'] + $dtstokopname['Pemakaian_Lainnya_Apbd_07'];
							$total_pemakaian_apbd_08 = $dtstokopname['Pemakaian_Gudang_Apbd_08'] + $dtstokopname['Pemakaian_Depot_Apbd_08'] + $dtstokopname['Pemakaian_Igd_Apbd_08'] + $dtstokopname['Pemakaian_Ranap_Apbd_08'] + $dtstokopname['Pemakaian_Poned_Apbd_08'] + $dtstokopname['Pemakaian_Pustu_Apbd_08'] + $dtstokopname['Pemakaian_Pusling_Apbd_08'] + $dtstokopname['Pemakaian_Poli_Apbd_08'] + $dtstokopname['Pemakaian_Lainnya_Apbd_08'];
							$total_pemakaian_apbd_09 = $dtstokopname['Pemakaian_Gudang_Apbd_09'] + $dtstokopname['Pemakaian_Depot_Apbd_09'] + $dtstokopname['Pemakaian_Igd_Apbd_09'] + $dtstokopname['Pemakaian_Ranap_Apbd_09'] + $dtstokopname['Pemakaian_Poned_Apbd_09'] + $dtstokopname['Pemakaian_Pustu_Apbd_09'] + $dtstokopname['Pemakaian_Pusling_Apbd_09'] + $dtstokopname['Pemakaian_Poli_Apbd_09'] + $dtstokopname['Pemakaian_Lainnya_Apbd_09'];
							$total_pemakaian_apbd_10 = $dtstokopname['Pemakaian_Gudang_Apbd_10'] + $dtstokopname['Pemakaian_Depot_Apbd_10'] + $dtstokopname['Pemakaian_Igd_Apbd_10'] + $dtstokopname['Pemakaian_Ranap_Apbd_10'] + $dtstokopname['Pemakaian_Poned_Apbd_10'] + $dtstokopname['Pemakaian_Pustu_Apbd_10'] + $dtstokopname['Pemakaian_Pusling_Apbd_10'] + $dtstokopname['Pemakaian_Poli_Apbd_10'] + $dtstokopname['Pemakaian_Lainnya_Apbd_10'];
							$total_pemakaian_apbd_11 = $dtstokopname['Pemakaian_Gudang_Apbd_11'] + $dtstokopname['Pemakaian_Depot_Apbd_11'] + $dtstokopname['Pemakaian_Igd_Apbd_11'] + $dtstokopname['Pemakaian_Ranap_Apbd_11'] + $dtstokopname['Pemakaian_Poned_Apbd_11'] + $dtstokopname['Pemakaian_Pustu_Apbd_11'] + $dtstokopname['Pemakaian_Pusling_Apbd_11'] + $dtstokopname['Pemakaian_Poli_Apbd_11'] + $dtstokopname['Pemakaian_Lainnya_Apbd_11'];
							$total_pemakaian_apbd_12 = $dtstokopname['Pemakaian_Gudang_Apbd_12'] + $dtstokopname['Pemakaian_Depot_Apbd_12'] + $dtstokopname['Pemakaian_Igd_Apbd_12'] + $dtstokopname['Pemakaian_Ranap_Apbd_12'] + $dtstokopname['Pemakaian_Poned_Apbd_12'] + $dtstokopname['Pemakaian_Pustu_Apbd_12'] + $dtstokopname['Pemakaian_Pusling_Apbd_12'] + $dtstokopname['Pemakaian_Poli_Apbd_12'] + $dtstokopname['Pemakaian_Lainnya_Apbd_12'];
							
							$total_pemakaian_jkn_01 = $dtstokopname['Pemakaian_Gudang_Jkn_01'] + $dtstokopname['Pemakaian_Depot_Jkn_01'] + $dtstokopname['Pemakaian_Igd_Jkn_01'] + $dtstokopname['Pemakaian_Ranap_Jkn_01'] + $dtstokopname['Pemakaian_Poned_Jkn_01'] + $dtstokopname['Pemakaian_Pustu_Jkn_01'] + $dtstokopname['Pemakaian_Pusling_Jkn_01'] + $dtstokopname['Pemakaian_Poli_Jkn_01'] + $dtstokopname['Pemakaian_Lainnya_Jkn_01'];
							$total_pemakaian_jkn_02 = $dtstokopname['Pemakaian_Gudang_Jkn_02'] + $dtstokopname['Pemakaian_Depot_Jkn_02'] + $dtstokopname['Pemakaian_Igd_Jkn_02'] + $dtstokopname['Pemakaian_Ranap_Jkn_02'] + $dtstokopname['Pemakaian_Poned_Jkn_02'] + $dtstokopname['Pemakaian_Pustu_Jkn_02'] + $dtstokopname['Pemakaian_Pusling_Jkn_02'] + $dtstokopname['Pemakaian_Poli_Jkn_02'] + $dtstokopname['Pemakaian_Lainnya_Jkn_02'];
							$total_pemakaian_jkn_03 = $dtstokopname['Pemakaian_Gudang_Jkn_03'] + $dtstokopname['Pemakaian_Depot_Jkn_03'] + $dtstokopname['Pemakaian_Igd_Jkn_03'] + $dtstokopname['Pemakaian_Ranap_Jkn_03'] + $dtstokopname['Pemakaian_Poned_Jkn_03'] + $dtstokopname['Pemakaian_Pustu_Jkn_03'] + $dtstokopname['Pemakaian_Pusling_Jkn_03'] + $dtstokopname['Pemakaian_Poli_Jkn_03'] + $dtstokopname['Pemakaian_Lainnya_Jkn_03'];
							$total_pemakaian_jkn_04 = $dtstokopname['Pemakaian_Gudang_Jkn_04'] + $dtstokopname['Pemakaian_Depot_Jkn_04'] + $dtstokopname['Pemakaian_Igd_Jkn_04'] + $dtstokopname['Pemakaian_Ranap_Jkn_04'] + $dtstokopname['Pemakaian_Poned_Jkn_04'] + $dtstokopname['Pemakaian_Pustu_Jkn_04'] + $dtstokopname['Pemakaian_Pusling_Jkn_04'] + $dtstokopname['Pemakaian_Poli_Jkn_04'] + $dtstokopname['Pemakaian_Lainnya_Jkn_04'];
							$total_pemakaian_jkn_05 = $dtstokopname['Pemakaian_Gudang_Jkn_05'] + $dtstokopname['Pemakaian_Depot_Jkn_05'] + $dtstokopname['Pemakaian_Igd_Jkn_05'] + $dtstokopname['Pemakaian_Ranap_Jkn_05'] + $dtstokopname['Pemakaian_Poned_Jkn_05'] + $dtstokopname['Pemakaian_Pustu_Jkn_05'] + $dtstokopname['Pemakaian_Pusling_Jkn_05'] + $dtstokopname['Pemakaian_Poli_Jkn_05'] + $dtstokopname['Pemakaian_Lainnya_Jkn_05'];
							$total_pemakaian_jkn_06 = $dtstokopname['Pemakaian_Gudang_Jkn_06'] + $dtstokopname['Pemakaian_Depot_Jkn_06'] + $dtstokopname['Pemakaian_Igd_Jkn_06'] + $dtstokopname['Pemakaian_Ranap_Jkn_06'] + $dtstokopname['Pemakaian_Poned_Jkn_06'] + $dtstokopname['Pemakaian_Pustu_Jkn_06'] + $dtstokopname['Pemakaian_Pusling_Jkn_06'] + $dtstokopname['Pemakaian_Poli_Jkn_06'] + $dtstokopname['Pemakaian_Lainnya_Jkn_06'];
							$total_pemakaian_jkn_07 = $dtstokopname['Pemakaian_Gudang_Jkn_07'] + $dtstokopname['Pemakaian_Depot_Jkn_07'] + $dtstokopname['Pemakaian_Igd_Jkn_07'] + $dtstokopname['Pemakaian_Ranap_Jkn_07'] + $dtstokopname['Pemakaian_Poned_Jkn_07'] + $dtstokopname['Pemakaian_Pustu_Jkn_07'] + $dtstokopname['Pemakaian_Pusling_Jkn_07'] + $dtstokopname['Pemakaian_Poli_Jkn_07'] + $dtstokopname['Pemakaian_Lainnya_Jkn_07'];
							$total_pemakaian_jkn_08 = $dtstokopname['Pemakaian_Gudang_Jkn_08'] + $dtstokopname['Pemakaian_Depot_Jkn_08'] + $dtstokopname['Pemakaian_Igd_Jkn_08'] + $dtstokopname['Pemakaian_Ranap_Jkn_08'] + $dtstokopname['Pemakaian_Poned_Jkn_08'] + $dtstokopname['Pemakaian_Pustu_Jkn_08'] + $dtstokopname['Pemakaian_Pusling_Jkn_08'] + $dtstokopname['Pemakaian_Poli_Jkn_08'] + $dtstokopname['Pemakaian_Lainnya_Jkn_08'];
							$total_pemakaian_jkn_09 = $dtstokopname['Pemakaian_Gudang_Jkn_09'] + $dtstokopname['Pemakaian_Depot_Jkn_09'] + $dtstokopname['Pemakaian_Igd_Jkn_09'] + $dtstokopname['Pemakaian_Ranap_Jkn_09'] + $dtstokopname['Pemakaian_Poned_Jkn_09'] + $dtstokopname['Pemakaian_Pustu_Jkn_09'] + $dtstokopname['Pemakaian_Pusling_Jkn_09'] + $dtstokopname['Pemakaian_Poli_Jkn_09'] + $dtstokopname['Pemakaian_Lainnya_Jkn_09'];
							$total_pemakaian_jkn_10 = $dtstokopname['Pemakaian_Gudang_Jkn_10'] + $dtstokopname['Pemakaian_Depot_Jkn_10'] + $dtstokopname['Pemakaian_Igd_Jkn_10'] + $dtstokopname['Pemakaian_Ranap_Jkn_10'] + $dtstokopname['Pemakaian_Poned_Jkn_10'] + $dtstokopname['Pemakaian_Pustu_Jkn_10'] + $dtstokopname['Pemakaian_Pusling_Jkn_10'] + $dtstokopname['Pemakaian_Poli_Jkn_10'] + $dtstokopname['Pemakaian_Lainnya_Jkn_10'];
							$total_pemakaian_jkn_11 = $dtstokopname['Pemakaian_Gudang_Jkn_11'] + $dtstokopname['Pemakaian_Depot_Jkn_11'] + $dtstokopname['Pemakaian_Igd_Jkn_11'] + $dtstokopname['Pemakaian_Ranap_Jkn_11'] + $dtstokopname['Pemakaian_Poned_Jkn_11'] + $dtstokopname['Pemakaian_Pustu_Jkn_11'] + $dtstokopname['Pemakaian_Pusling_Jkn_11'] + $dtstokopname['Pemakaian_Poli_Jkn_11'] + $dtstokopname['Pemakaian_Lainnya_Jkn_11'];
							$total_pemakaian_jkn_12 = $dtstokopname['Pemakaian_Gudang_Jkn_12'] + $dtstokopname['Pemakaian_Depot_Jkn_12'] + $dtstokopname['Pemakaian_Igd_Jkn_12'] + $dtstokopname['Pemakaian_Ranap_Jkn_12'] + $dtstokopname['Pemakaian_Poned_Jkn_12'] + $dtstokopname['Pemakaian_Pustu_Jkn_12'] + $dtstokopname['Pemakaian_Pusling_Jkn_12'] + $dtstokopname['Pemakaian_Poli_Jkn_12'] + $dtstokopname['Pemakaian_Lainnya_Jkn_12'];
														
							// sisa stok apbd
							$sisastok_apbd_01 = $dtstokopname['PenerimaanApbd_01'] - $total_pemakaian_apbd_01;
							$sisastok_apbd_02 = $dtstokopname['PenerimaanApbd_02'] - $total_pemakaian_apbd_02;
							$sisastok_apbd_03 = $dtstokopname['PenerimaanApbd_03'] - $total_pemakaian_apbd_03;
							$sisastok_apbd_04 = $dtstokopname['PenerimaanApbd_04'] - $total_pemakaian_apbd_04;
							$sisastok_apbd_05 = $dtstokopname['PenerimaanApbd_05'] - $total_pemakaian_apbd_05;
							$sisastok_apbd_06 = $dtstokopname['PenerimaanApbd_06'] - $total_pemakaian_apbd_06;
							$sisastok_apbd_07 = $dtstokopname['PenerimaanApbd_07'] - $total_pemakaian_apbd_07;
							$sisastok_apbd_08 = $dtstokopname['PenerimaanApbd_08'] - $total_pemakaian_apbd_08;
							$sisastok_apbd_09 = $dtstokopname['PenerimaanApbd_09'] - $total_pemakaian_apbd_09;
							$sisastok_apbd_10 = $dtstokopname['PenerimaanApbd_10'] - $total_pemakaian_apbd_10;
							$sisastok_apbd_11 = $dtstokopname['PenerimaanApbd_11'] - $total_pemakaian_apbd_11;
							$sisastok_apbd_12 = $dtstokopname['PenerimaanApbd_12'] - $total_pemakaian_apbd_12;
							$sisastok_total_apbd = $sisastok_apbd_01 + $sisastok_apbd_02 + $sisastok_apbd_03 + $sisastok_apbd_04 + $sisastok_apbd_05 + $sisastok_apbd_06 + $sisastok_apbd_07 + $sisastok_apbd_08 + $sisastok_apbd_09 + $sisastok_apbd_10 + $sisastok_apbd_11 + $sisastok_apbd_12;
							
							// sisa stok jkn
							$sisastok_jkn_01 = $dtstokopname['PenerimaanJkn_01'] - $total_pemakaian_jkn_01;
							$sisastok_jkn_02 = $dtstokopname['PenerimaanJkn_02'] - $total_pemakaian_jkn_02;
							$sisastok_jkn_03 = $dtstokopname['PenerimaanJkn_03'] - $total_pemakaian_jkn_03;
							$sisastok_jkn_04 = $dtstokopname['PenerimaanJkn_04'] - $total_pemakaian_jkn_04;
							$sisastok_jkn_05 = $dtstokopname['PenerimaanJkn_05'] - $total_pemakaian_jkn_05;
							$sisastok_jkn_06 = $dtstokopname['PenerimaanJkn_06'] - $total_pemakaian_jkn_06;
							$sisastok_jkn_07 = $dtstokopname['PenerimaanJkn_07'] - $total_pemakaian_jkn_07;
							$sisastok_jkn_08 = $dtstokopname['PenerimaanJkn_08'] - $total_pemakaian_jkn_08;
							$sisastok_jkn_09 = $dtstokopname['PenerimaanJkn_09'] - $total_pemakaian_jkn_09;
							$sisastok_jkn_10 = $dtstokopname['PenerimaanJkn_10'] - $total_pemakaian_jkn_10;
							$sisastok_jkn_11 = $dtstokopname['PenerimaanJkn_11'] - $total_pemakaian_jkn_11;
							$sisastok_jkn_12 = $dtstokopname['PenerimaanJkn_12'] - $total_pemakaian_jkn_12;
							$sisastok_total_jkn = $sisastok_jkn_01 + $sisastok_jkn_02 + $sisastok_jkn_03 + $sisastok_jkn_04 + $sisastok_jkn_05 + $sisastok_jkn_06 + $sisastok_jkn_07 + $sisastok_jkn_08 + $sisastok_jkn_09 + $sisastok_jkn_10 + $sisastok_jkn_11 + $sisastok_jkn_12;
							
							// total sisa stok
							$sisastok_total = $sisastok_total_apbd + $sisastok_total_jkn;
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>							
								<td class="kodebarangcls" align="center"><?php echo $data['KodeBarang'];?></td>									
								<td class="namabarangcls" align="left"><?php echo $data['NamaBarang'];?></td>									
								<td align="center"><?php echo $data['Satuan'];?></td>						
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
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_01'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_01'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_02'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_02'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_03'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_03'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_03']);
										}else{
											echo "-";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_04'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_04'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_04']);
										}else{
											echo "-";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_05'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_05'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_05']);
										}else{
											echo "-";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_06'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_06'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_06']);
										}else{
											echo "-";
										}
									?>	
								</td>						
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_07'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_07'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_07']);
										}else{
											echo "-";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_08'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_08'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_08']);
										}else{
											echo "-";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_09'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_09'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_09']);
										}else{
											echo "-";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_10'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_10'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_10']);
										}else{
											echo "-";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_11'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_11'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_11']);
										}else{
											echo "-";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanApbd_12'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>	
								<td align="right" class="pink">
									<?php 
										if($dtstokopname['PenerimaanJkn_12'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_12']);
										}else{
											echo "-";
										}
									?>	
								</td>	
								<td align="right" class="pink">
									<?php echo rupiah($total_penerimaan_apbd);?>
								</td>									
								<td align="right" class="pink">
									<?php echo rupiah($total_penerimaan_jkn);?>
								</td>									
								<td align="right" class="pink">
									<?php echo rupiah($total_penerimaan);?>
								</td>
								
								<!--Pemakaian_01-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_01']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_01'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_01']);
										}else{
											echo "-";
										}
									?>
								</td>
								
								<!--Pemakaian_02-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_02']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_02'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_02']);
										}else{
											echo "-";
										}
									?>
								</td>
								
								<!--Pemakaian_03-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_03']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_03'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_03']);
										}else{
											echo "-";
										}
									?>
								</td>	
								
								<!--Pemakaian_04-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_04']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_04'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_04']);
										}else{
											echo "-";
										}
									?>
								</td>						

								<!--Pemakaian_05-->	
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_05']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_05'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_05']);
										}else{
											echo "-";
										}
									?>
								</td>

								<!--Pemakaian_06-->	
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_06']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_06'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_06']);
										}else{
											echo "-";
										}
									?>
								</td>							

								<!--Pemakaian_07-->	
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_07']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_07'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_07']);
										}else{
											echo "-";
										}
									?>
								</td>							
								
								<!--Pemakaian_08-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_08']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_08'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_08']);
										}else{
											echo "-";
										}
									?>
								</td>
								
								<!--Pemakaian_09-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_09']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_09'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_09']);
										}else{
											echo "-";
										}
									?>
								</td>	
								
								<!--Pemakaian_10-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_10']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_10'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_10']);
										}else{
											echo "-";
										}
									?>
								</td>	
								
								<!--Pemakaian_11-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_11']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_11'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_11']);
										}else{
											echo "-";
										}
									?>
								</td>
								
								<!--Pemakaian_12-->
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Gudang_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Gudang_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Depot_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Depot_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Igd_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Igd_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Ranap_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Ranap_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poned_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poned_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pustu_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pustu_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Pusling_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Pusling_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Poli_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Poli_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Apbd_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Apbd_12']);
										}else{
											echo "-";
										}
									?>
								</td>						
								<td align="right" class="kuning">
									<?php 
										if($dtstokopname['Pemakaian_Lainnya_Jkn_12'] != 0){
											echo rupiah($dtstokopname['Pemakaian_Lainnya_Jkn_12']);
										}else{
											echo "-";
										}
									?>
								</td>							
								
								<!--Pemakaian_ttl-->
								<td align="right" class="kuning">
									<?php echo rupiah($total_gudang_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_gudang_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_depot_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_depot_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_igd_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_igd_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_ranap_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_ranap_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_poned_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_poned_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_pustu_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_pustu_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_pusling_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_pusling_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_poli_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_poli_jkn);?>
								</td>
								<td align="right" class="kuning">
									<?php echo rupiah($total_lainnya_apbd);?>
								</td>						
								<td align="right" class="kuning">
									<?php echo rupiah($total_lainnya_jkn);?>
								</td>

								<!--Pemakaian_ttl_semua-->								
								<td align="right" class="kuning">
									<?php echo rupiah($total_pemakaian);?>
								</td>
								
								<!--SisaStok-->		
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_01);?>
								</td>
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_01);?>
								</td>						
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_02);?>
								</td>
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_02);?>
								</td>			
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_03);?>
								</td>		
									<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_03);?>
								</td>		
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_04);?>
								</td>			
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_04);?>
								</td>		
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_05);?>
								</td>
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_05);?>
								</td>		
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_06);?>
								</td>
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_06);?>
								</td>		
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_07);?>
								</td>					
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_07);?>
								</td>	
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_08);?>
								</td>						
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_08);?>
								</td>	
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_09);?>
								</td>
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_09);?>
								</td>	
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_10);?>
								</td>				
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_10);?>
								</td>	
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_11);?>
								</td>
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_11);?>
								</td>	
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_apbd_12);?>
								</td>	
								<td align="right" class="oranye">
									<?php echo rupiah($sisastok_jkn_12);?>
								</td>	
								<td align="right" class="oranye">
									<?php  echo rupiah($sisastok_total);?>
								</td>								
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
					<b>Keterangan :</b><br/>
					- <b>Penerimaan</b>, silahkan isi penerimaan bulan (Jan s/d Des)<br/>
					- <b>Pemakaian</b>, silahkan isi pemakaian bulan (Jan s/d Des) <br/>
					<span style="margin-left:10px;">berdasarkan (Depot, Poli, Poned, Ranap, Pustu, Pusling, Lainnya)</span>
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
