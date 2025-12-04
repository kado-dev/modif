<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>Laporan Layanan</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_skm_layanan"/>
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
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_skm_layanan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN LAYANAN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
				</tr>
			</table>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2">Layanan</th>
							<th colspan="9">Kode Unsur Pelayanan</th>
							<th rowspan="2">Responden</th>
							<th rowspan="2">Nilai unsur<br>( AVG(Nilai U) )</th>
							<th rowspan="2">Nilai IKM<br>( Nilai Unsur * 25 / 1000 )</th>
							<th rowspan="2">Nilai Mutu</th>
						</tr>
						<tr>
							<th>U1</th>
							<th>U2</th>
							<th>U3</th>
							<th>U4</th>
							<th>U5</th>
							<th>U6</th>
							<th>U7</th>
							<th>U8</th>
							<th>U9</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
					
							$jwb1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no1' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no2' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb3 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no3' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb4 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no4' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb5 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no5' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb6 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no6' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb7 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no7' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb8 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no8' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$jwb9 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(jawaban) as jawaban from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND pertanyaan = 'no9' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jawaban'];
							$responden = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(nocm) as jml from tbantrian_kuisioner where MONTH(`waktu`) = '$bulan' AND YEAR(`waktu`) = '$tahun' AND substring(nocm,1,11) = '$kodepuskesmas'"))['jml'];
						
							$nilaiunsur = round(($jwb1 + $jwb2 + $jwb3 + $jwb4 + $jwb5 + $jwb6 + $jwb7 + $jwb8 + $jwb9)/9);
							$nilaiikm = ($nilaiunsur * 25)/1000;
							
							if($nilaiikm > 88.31){
								$nilaimutu = 'A';
							}else if($nilaiikm > 76.61){
								$nilaimutu = 'B';
							}else if($nilaiikm > 65){
								$nilaimutu = 'C';
							}else if($nilaiikm > 25){
								$nilaimutu = 'D';
							}else{
								$nilaimutu = 'E';
							}
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:left; border:1px solid #000; padding:3px;">Puskesmas</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb1;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb2;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb3;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb4;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb5;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb6;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb7;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb8;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jwb9;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $responden;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $nilaiunsur;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $nilaiikm;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $nilaimutu;?></td>
							</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	
