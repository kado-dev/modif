<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
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
			<h1>Laporan Pelayanan Kesehatan Gigi & Mulut</h1>
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
					<input type="hidden" name="page" value="lap_gigi_harian"/>
					<?php
					if($_SESSION['kodepuskesmas'] == '-'){
					?>
						<div class="col-sm-3">
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
					<div class="col-sm-2" >
						<select name="bulan" class="form-control">
							<option value="01">Januari</option>
							<option value="02">Februari</option>
							<option value="03">Maret</option>
							<option value="04">April</option>
							<option value="05">Mei</option>
							<option value="06">Juni</option>
							<option value="07">Juli</option>
							<option value="08">Agustus</option>
							<option value="09">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">Desember</option>
						</select>
					</div>
					<div class="col-sm-1" style ="width:125px">
						<SELECT name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</SELECT>
					</div>
					<div class="col-sm-5">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_gigi_harian" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<a href="?page=laporan_pendaftaran" class="btn  btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

if($bulan != null AND $tahun != null){
?>

<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
	<?php 
	if($kodepuskesmas == 'semua'){
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
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN KESEHATAN GIGI & MULUT</b></span><br>
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

<div class="row font10">
	<div class="col-sm-12">
		<div class="table-responsive font10">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px dashed #000;">
						<th width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th width="18%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Kegiatan</th>
						<th width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Satuan</th>
					<?php
						$bln = $_GET['bulan'];
						$thn = $_GET['tahun'];
						$mulai = 1;
						$selesai = 31;
						for($d = $mulai;$d <= $selesai; $d++){	

					?>
						<th style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;"><?php echo $d;?></th>
					<?php
						}
					?>
						<th style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$kota = $_SESSION['kota'];
					$str = "SELECT * FROM `tbkegiatangigi` ORDER BY `KodeKelompok`, `KodeKegiatan`";
					$query = mysqli_query($koneksi,$str);
					
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						if($data['KodeKegiatan'] == '01'){
							echo "<tr style='border:1px dashed #000;'><td style='text-align:center; border:1px dashed #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='9' style='text-align:left; font-weight:bold; border:1px dashed #000; padding:3px;'>$data[Kelompok]</td></tr>";
						}
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['KodeKegiatan'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Kegiatan'];?></td>	
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Satuan'];?></td>	
							<?php
							$jml = 0;	
							for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								if ($data['Kegiatan'] == 'Jumlah Penduduk Wilayah Kerja Puskesmas'){
									// $strs = "SELECT COUNT(NoRegistrasi) as jumlah from `$tbpasienrj` where `TanggalRegistrasi` = '$tanggal'".$semua;
									$strs = "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.`TanggalRegistrasi` = '$tanggal' and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'";
								}else if($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi ke Puskesmas'){
									$strs = "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.`TanggalRegistrasi` = '$tanggal' and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'";
								}
								//echo $strs;
								$count = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml = $jml + $count['jumlah'];
								?>	
								<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $count['jumlah'];?></td>
								<?php
							}
							?>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jml;?></td>
						</tr>
					<?php
					}
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;">#</td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;">Total</td>
						<?php
							$jmls = 0;
							for($d3= $mulai;$d3 <= $selesai; $d3++){	
							$tanggal = $thn."-".$bln."-".$d3;
							$strs2 = "select COUNT(NoRegistrasi) as jumlah from `$tbpasienrj` where `TanggalRegistrasi` = '$tanggal'".$semua;
							$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
							$jmls = $jmls + $countall['jumlah'];
						?>	
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $countall['jumlah'];?></td>
						<?php
							}
						?>	
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $jmls;?></td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div><br/>
<?php
}
?>