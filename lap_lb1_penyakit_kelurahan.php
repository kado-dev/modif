<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>

<style>
.printheader{
	margin-top:-30px;
	margin-left:-15px;
	margin-right:-15px;
	text-align:center;
	display: none;
	
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
	display:none;
	margin-top:-40px;
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
<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan LB1-Penyakit (Desa/Kelurahan)</h1>
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
						<input type="hidden" name="page" value="lap_lb1_penyakit_kelurahan"/>
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
							<select name="kelurahan" class="form-control" required>
								<option value='semua'>Pilih Desa/Kelurahan</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` where `Kota`='$kota' order by `Kelurahan`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[Kelurahan]'>$data3[Kelurahan]</option>";
								}
								?>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_lb1_penyakit_kelurahan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="?page=laporan" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
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
$kelurahan = $_GET['kelurahan'];
$tbpasienrj = 'tbpasienrj_'.$bulan;
$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
if($_SESSION['kodepuskesmas'] == '-'){
	if($kelurahan == 'semua'){
		$semua = " YEAR(a.TanggalRegistrasi) = '$tahun' ";
	}else{
		$semua = " YEAR(a.TanggalRegistrasi) = '$tahun' AND AND c.Kelurahan='".$kelurahan."'";
	}
}else{
	if($kelurahan == 'semua'){
		$semua = " YEAR(a.TanggalRegistrasi) = '$tahun' AND substring(a.NoRegistrasi,1,11) = '".$kodepuskesmas."'";
	}else{
		$semua = " YEAR(a.TanggalRegistrasi) = '$tahun' AND substring(a.NoRegistrasi,1,11) = '".$kodepuskesmas."' AND c.Kelurahan='".$kelurahan."' ";
	}
}
if(isset($bulan) and isset($tahun)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- PENYAKIT</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $tgl1." s/d ".$tgl2;?></p>
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
					<tr style="border:1px dashed #000;">
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
						<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Penyakit</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">0-7Hr</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">8-30Hr</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;"><1Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">1-4Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">5-9Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">10-14Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">15-19Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">20-44Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">45-54Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">55-59Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">60-69Th</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">>=70Th</th>
						<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jml</th>
					</tr>
					<tr style="border:1px dashed #000;">
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--0-7Hr-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--8-30Hr-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--<1Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--5-9Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--10-14Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--15-19Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--20-44Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--45-54Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--55-59Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--60-69Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--70Th-->
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Baru</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Lama</th>
							<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Total</th>
						</tr>
				</thead>
				<!--tbpasienrj-->
				<tbody style="font-size:10px;">
					<!--paging-->
					<?php
					$jumlah_perpage = 100;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$str = "select * from `tbdiagnosa`";
					$str2 = $str."order by `KodeDiagnosa` ASC limit $mulai,$jumlah_perpage";
					// echo var_dump($str);
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;

					$umur17hrL = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur17hrP = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur1830hrL = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur1830hrP = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur12blnL = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur12blnP = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur14L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur14P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur59L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur59P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur1014L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur1014P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur1519L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur1519P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur2044L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur2044P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur4554L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur4554P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur5559L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur5559P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur6069L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur6069P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur70100L = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur70100P = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$jumlah_baru = $umur17hrL + $umur17hrP + $umur1830hrL + $umur1830hrP + $umur12blnL + $umur12blnP + $umur14L + $umur14P + $umur59L + $umur59P + $umur1014L + $umur1014P + $umur1519L + $umur1519P + $umur2044L + $umur2044P + $umur4554L + $umur4554P + $umur5559L + $umur5559P + $umur6069L + $umur6069P + $umur70100L + $umur70100P;
					$jumlah_lama = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE".$semua."AND b.KodeDiagnosa = '$data[KodeDiagnosaBPJS]' AND b.Kasus = 'Lama'"));
					$total = $jumlah_baru + $jumlah_lama;
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur17hrL;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur17hrP;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1830hrL;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1830hrP;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur12blnL;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur12blnP;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur14L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur14P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur59L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur59P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1014L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1014P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1519L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1519P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2044L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2044P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5559L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5559P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6069L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6069P;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur70100L;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur70100P;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $jumlah_baru;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $jumlah_lama;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $total;?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div><br/>

<hr class="noprint"><!--css-->
<ul class="pagination noprint">
	<?php
		$tgl1 = $_GET['keydate1'];
		$tgl2 = $_GET['keydate2'];
		$kelurahan = $_GET['kelurahan'];
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
					echo "<li><a href='?page=lap_lb1_penyakit_kelurahan&kelurahan=$kelurahan&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
<?php
}
?>