<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tanggal = date('Y-m-d');
	$kota = $_SESSION['kota'];
?>
<style>
.printheader{
	margin-top:-30px;
	margin-left:-5px;
	margin-right:-5px;
	text-align:center;
	display:none;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:-5px;
	margin-right:-5px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
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
	.teks_merah{
		color:red !important;
	}
}
</style>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan Imunisasi (Per Kelurahan/Desa)</h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Berdasar</h4>
			</div>
			<div class="space-10"></div>
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_imunisasi_perkelurahan"/>
					<div class="col-sm-2 bulanformcari">
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
					<div class="col-sm-1 bulanformcari" style ="width:125px">
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
						<a href="?page=lap_loket_registrasi_kunjungan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<a href="?page=laporan_pendaftaran" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
if(isset($bulan) and isset($tahun)){
?>

<!--data registrasi-->
<div class="row noprint">
	<div class="col-sm-12">
		<div class="table-responsive noprint">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px dashed #000;">
						<th width="1%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Kelurahan / Desa</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">HBO</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">BCG</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">DPT HBHIB1</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">DPT HBHIB2</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">DPT HBHIB3</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 1</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 2</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 3</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 4</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">IPV</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">CAMPAK RUBELA</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">BOSTER DPT HB-HIB</th>
						<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">BOSTER CAMPAK RUBELA</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
						<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
					</tr>
				
				</thead>
				<!--tbpasienrj-->
				<tbody style="font-size:10px;">
					<!--paging-->
					<?php
					$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$_SESSION[kodepuskesmas]'";
					$query = mysqli_query($koneksi,$str_puskesmas);
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$hbo_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%HBO%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$hbo_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%HBO%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$bcg_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BCG%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$bcg_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BCG%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$dpt1_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 1%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$dpt1_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 1%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$dpt2_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 2%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$dpt2_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 2%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$dpt3_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 3%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$dpt3_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 3%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio1_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 1%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio1_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 1%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio2_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 2%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio2_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 2%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio3_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 3%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio3_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 3%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio4_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 4%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$polio4_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 4%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$ipv_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%IPV%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$ipv_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%IPV%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$campak_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%CAMPAK RUBELLA%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$campak_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%CAMPAK RUBELLA%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$bosterhib_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER DPT HB HiB%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$bosterhib_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER DPT HB HiB%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$bosterrubela_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER CAMPAK RUBELLA%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					$bosterrubela_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER CAMPAK RUBELLA%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Kelurahan'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $hbo_l;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $hbo_p;?></td>	
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bcg_l;?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bcg_p;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt1_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt1_p;?></td>	
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt2_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt2_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt3_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt3_p;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio1_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio1_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio2_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio2_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio3_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio3_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio4_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio4_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $ipv_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $ipv_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $campak_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $campak_p;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterhib_l;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterhib_p;?></td>				
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterrubela_l;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterrubela_p;?></td>
							
							
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<br>
<hr class="noprint">
<?php
}
?>

<!--tabel report-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$_SESSION[kodepuskesmas]'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
	<br/>
		<?php 
		if($kdpuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota1;?></b></h4>
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
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN IMUNISASI (PER KELURAHAN/DESA)</b></h4>

		<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p>
		
		<br/>
</div>

<div class="table-responsive printbody">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px dashed #000;">
				<th width="1%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
				<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Kelurahan / Desa</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">HBO</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">BCG</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">DPT HBHIB1</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">DPT HBHIB2</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">DPT HBHIB3</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 1</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 2</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 3</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">POLIO 4</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">IPV</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">CAMPAK RUBELA</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">BOSTER DPT HB-HIB</th>
				<th  colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">BOSTER CAMPAK RUBELA</th>
			</tr>
			<tr style="border:1px dashed #000;">
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">L</th>
				<th style="text-align:center;border:1px dashed #000; padding:3px;width:2%;">P</th>
			</tr>
		
		</thead>
		<!--tbpasienrj-->
		<tbody style="font-size:10px;">
			<!--paging-->
			<?php
			$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$_SESSION[kodepuskesmas]'";
			$query = mysqli_query($koneksi,$str_puskesmas);
			$no = 0;
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$hbo_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%HBO%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$hbo_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%HBO%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$bcg_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BCG%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$bcg_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BCG%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$dpt1_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 1%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$dpt1_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 1%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$dpt2_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 2%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$dpt2_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 2%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$dpt3_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 3%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$dpt3_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%DPT HB HiB 3%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio1_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 1%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio1_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 1%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio2_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 2%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio2_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 2%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio3_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 3%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio3_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 3%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio4_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 4%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$polio4_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%Polio 4%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$ipv_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%IPV%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$ipv_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%IPV%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$campak_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%CAMPAK RUBELLA%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$campak_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%CAMPAK RUBELLA%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$bosterhib_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER DPT HB HiB%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$bosterhib_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER DPT HB HiB%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$bosterrubela_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER CAMPAK RUBELLA%' AND a.JenisKelamin = 'L' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			$bosterrubela_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbpoliimunisasi a join tbkk b on a.NoIndex = b.NoIndex where a.ImunisasiSekarang LIKE '%BOOSTER CAMPAK RUBELLA%' AND a.JenisKelamin = 'P' AND MONTH(a.TanggalPeriksa) = '$bulan' AND YEAR(a.TanggalPeriksa) = '$tahun' AND b.Kelurahan = '$data[Kelurahan]'"));
			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Kelurahan'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $hbo_l;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $hbo_p;?></td>	
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bcg_l;?></td>		
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bcg_p;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt1_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt1_p;?></td>	
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt2_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt2_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt3_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $dpt3_p;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio1_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio1_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio2_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio2_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio3_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio3_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio4_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $polio4_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $ipv_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $ipv_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $campak_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $campak_p;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterhib_l;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterhib_p;?></td>				
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterrubela_l;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $bosterrubela_p;?></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
