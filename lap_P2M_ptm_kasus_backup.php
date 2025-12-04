<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:-15px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
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
	margin-left:-10px;
	margin-right:-10px;
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
.font12{
	font-size:12px;
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
			<h1>Laporan PTM (Kasus)</h1>
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
						<input type="hidden" name="page" value="lap_P2M_ptm_kasus"/>
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
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-2">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
							
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-sm-7">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_ptm_kasus" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
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
$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
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
		<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
	<?php
	}else{
	?>
		<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo $datadinas['NamaDinkes'];?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $datapuskesmas['Alamat']?></span>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PTM (KASUS)</b></span><br>
	<p style="margin-top:-5px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-top:-50px;">
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
	<div style="float:right; width:35%; margin-top:-50px;">	
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
<div class="row printbody">
	<div class="col-lg-12">
		<div class="table-responsive">
			<span>Jumlah Kasus Baru</span>
			<table class="table table-striped table-condensed">
				<thead style="font-size:9.5px;">
					<tr>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
						<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jenis Penyakit</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">18-24</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">25-34</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">35-44</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">45-54</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">55-64</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">65-74</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">>75</th>
						<th colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Total</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--18-24-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--25-34-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--35-44-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--45-54-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--55-64-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--65-74-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--lebih dari 75-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--Jumlah-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th><!--Total-->
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$str = "SELECT * FROM `tbdiagnosaptmkode`";
					$str2 = $str." order by `KodeKelompok`,`IdDiagnosa`";
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = $data['KodeDiagnosa'];
					$umur1824L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '18' AND '24' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur1824P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '18' AND '24' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur2534L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '25' AND '34' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur2534P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '25' AND '34' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur3544L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '35' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur3544P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '35' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur5564L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur5564P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj`a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur6574L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '65' AND '74' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur6574P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '65' AND '74' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur75L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '75' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur75P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '75' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$jumlah_l = $umur1824L['Jml']+$umur2534L['Jml']+$umur3544L['Jml']+$umur4554L['Jml']+$umur5564L['Jml']+$umur6574L['Jml']+$umur75L['Jml'];
					$jumlah_p = $umur1824P['Jml']+$umur2534P['Jml']+$umur3544P['Jml']+$umur4554P['Jml']+$umur5564P['Jml']+$umur6574P['Jml']+$umur75P['Jml'];
					$total = $jumlah_l + $jumlah_p;
					
					if($data['IdDiagnosa'] == '01'){
						echo "<tr style='border:1px dashed #000;'><td style='text-align:center; border:1px dashed #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='25' style='text-align:left; font-weight:bold; border:1px dashed #000; padding:3px;'>$data[Kelompok]</td></tr>";
					}
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['IdDiagnosa'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1824L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1824P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2534L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2534P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur3544L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur3544P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5564L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5564P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6574L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6574P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur75L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur75P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jumlah_l;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jumlah_p;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $total;?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			
			<span>Jumlah Kasus Lama</span>
			<table class="table table-striped table-condensed">
				<thead style="font-size:9.5px;">
					<tr>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
						<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jenis Penyakit</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">18-24</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">25-34</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">35-44</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">45-54</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">55-64</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">65-74</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">>75</th>
						<th colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Total</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--18-24-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--25-34-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--35-44-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--45-54-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--55-64-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--65-74-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--lebih dari 75-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--Jumlah-->
						<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th><!--Total-->
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$str = "SELECT * FROM `tbdiagnosaptmkode`";
					$str2 = $str." order by `KodeKelompok`,`IdDiagnosa`";
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = $data['KodeDiagnosa'];
					$umur1824L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '18' AND '24' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur1824P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '18' AND '24' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$umur2534L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '25' AND '34' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur2534P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '25' AND '34' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$umur3544L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '35' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur3544P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '35' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$umur5564L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur5564P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj`a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$umur6574L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '65' AND '74' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur6574P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '65' AND '74' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$umur75L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '75' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur75P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '75' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					$jumlah_l = $umur1824L['Jml']+$umur2534L['Jml']+$umur3544L['Jml']+$umur4554L['Jml']+$umur5564L['Jml']+$umur6574L['Jml']+$umur75L['Jml'];
					$jumlah_p = $umur1824P['Jml']+$umur2534P['Jml']+$umur3544P['Jml']+$umur4554P['Jml']+$umur5564P['Jml']+$umur6574P['Jml']+$umur75P['Jml'];
					$total = $jumlah_l + $jumlah_p;
					
					if($data['IdDiagnosa'] == '01'){
						echo "<tr style='border:1px dashed #000;'><td style='text-align:center; border:1px dashed #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='25' style='text-align:left; font-weight:bold; border:1px dashed #000; padding:3px;'>$data[Kelompok]</td></tr>";
					}
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['IdDiagnosa'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1824L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1824P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2534L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2534P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur3544L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur3544P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5564L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5564P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6574L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6574P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur75L['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur75P['Jml'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jumlah_l;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jumlah_p;?></td>
							<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $total;?></td>
						</tr>
					<?php
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