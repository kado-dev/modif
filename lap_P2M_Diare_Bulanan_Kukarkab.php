<?php
	include "otoritas.php";
	include "config/helper_report.php";	
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DIARE (BULANAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Diare_Bulanan_Kukarkab"/>
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kasus" class="form-control">
								<option value="semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Diare_Bulanan_Kukarkab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_Diare_Bulanan_Kukarkab_Excel.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate = $_GET['keydate'];
	$kasus = $_GET['kasus'];
	$opsiform = $_GET['opsiform'];
	$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
	$tbdiagnosapasien = "tbdiagnosapasien_".$bulan;
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN DIARE (KELURAHAN)</b></span><br>
		<?php if($opsiform == 'bulan'){?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<?php }else{ ?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y',strtotime($keydate1))." s/d ".date('d-m-Y',strtotime($keydate2));?></span>
		<?php }?>
		<br/>
		<br/>
	</div>

	<div class="atastabel font10">
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
	
	<div class="row font9">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="4" width="1%" style="text-align:center; vertical-align:middle;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="4" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan</th>
							<th colspan="28" width="55%" style="text-align:center; vertical-align:middle; border:1px solid #000;padding:3px;">Fasilitas Pelayanan Kesehatan</th>
							<th colspan="17" width="30%" style="text-align:center; vertical-align:middle; border:1px solid #000;padding:3px;">Kader</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">0-<6Bl</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>6Bl-<1Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1-<5Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">5-<10Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">10-<15Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">15-<20Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>20Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							<th colspan="5" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penderita Diare -<5Th Diberi</th>
							<th colspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penderita Diare >-5Th Diberi</th>
							<th colspan="5" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">0-6Bl</th><!--Kader-->
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>-6Bl-<1Th</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1-<5Th</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">5-<10Th</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">10-<15Th</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">15-<20Th</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>20Th</th>
							<th colspan="2" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							<th colspan="2" width="2%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian Oralit</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!--0 -< 6Bl-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!-- >- 6Bl -< 1Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!--1 -< 5Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!--5 -< 10Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!--10 -< 15Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!--15 -< 20Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!-- > 60 Bulan-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th><!-- > Jumlah-->
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Penderita Diare -< 5Th Diberi-->
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">RL</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Penderita Diare >- 5Th Diberi-->
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">RL</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Jumlah Pemakaian-->
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">RL</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--0 -< 6Bl-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!-- >- 6Bl -< 1Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--1 -< 5Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--5 -< 10Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!--10 -< 15Th-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!--15 -< 20Th-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!-- > 60 Bulan-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!--Jumlah-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">0-<6Bl</th><!--Penderita Diare-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">>6-<1Th</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">1-4Th</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">0-<6Bl</th><!--Jumlah Pemakaian-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">>6-<1Th</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">1-4Th</th>
							<!--Kader-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--0 - 6Bl-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!-- >- 6Bl -< 1Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--1 -< 5Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--5 -< 10Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!--10 -< 15Th-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!--15 -< 20Th-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!-- > 60 Bulan-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th><!--Jumlah-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">2</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">3</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">4</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">5</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">6</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">7</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">8</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">9</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">10</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">11</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">12</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">13</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">14</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">15</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">16</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">17</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">18</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">19</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">20</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">21</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">22</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">23</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">24</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">25</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">26</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">27</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">28</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">29</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">30</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">31</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">32</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">33</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">34</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">35</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">36</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">37</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">38</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">39</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">40</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">41</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">42</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">43</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">44</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">45</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">46</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">47</th>
						</tr>
					</thead>
					<tbody style="font-size:9px;">
						<?php
						$waktu = "YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND ";
						$tbdiagnosadiare = 'tbdiagnosadiare';
						
						// tbdiagnosadiare
						$kasus = $_GET['kasus'];
						if($kasus != 'Semua'){
							$qkasus = " AND Kunjungan = '$kasus' ";
						}else{
							$qkasus = " ";
						}
						
						$str_kelurahan = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR `KodePuskesmas` = '*' ORDER BY Kelurahan";									
						$query_kelurahan = mysqli_query($koneksi,$str_kelurahan);
						while($dtkelurahan = mysqli_fetch_assoc($query_kelurahan)){
							$no = $no + 1;
							$kelurahan = $dtkelurahan['Kelurahan'];
							
							$umur06_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '0' AND '5' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur06_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '0' AND '5' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur06_p_l_ttl = $umur06_p_l_ttl + $umur06_p_l['Jml'];
							$umur06_p_p_ttl = $umur06_p_p_ttl + $umur06_p_p['Jml'];
							
							$umur612_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '6' AND '11' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur612_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '6' AND '11' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur612_p_l_ttl = $umur612_p_l_ttl + $umur612_p_l['Jml'];
							$umur612_p_p_ttl = $umur612_p_p_ttl + $umur612_p_p['Jml'];
							
							$umur15_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '1' AND '4' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur15_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '1' AND '4' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur15_p_l_ttl = $umur15_p_l_ttl + $umur15_p_l['Jml'];
							$umur15_p_p_ttl = $umur15_p_p_ttl + $umur15_p_p['Jml'];
							
							$umur510_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '5' AND '9' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur510_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '5' AND '9' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur510_p_l_ttl = $umur510_p_l_ttl + $umur510_p_l['Jml'];
							$umur510_p_p_ttl = $umur510_p_p_ttl + $umur510_p_p['Jml'];
							
							$umur1015_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '10' AND '14' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur1015_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '10' AND '14' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur1015_p_l_ttl = $umur1015_p_l_ttl + $umur1015_p_l['Jml'];
							$umur1015_p_p_ttl = $umur1015_p_p_ttl + $umur1015_p_p['Jml'];
							
							$umur1520_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '15' AND '19' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur1520_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '15' AND '19' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur1520_p_l_ttl = $umur1520_p_l_ttl + $umur1520_p_l['Jml'];
							$umur1520_p_p_ttl = $umur1520_p_p_ttl + $umur1520_p_p['Jml'];
							
							$umur20_p_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun >= '20' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur20_p_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun >= '20' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur20_p_l_ttl = $umur20_p_l_ttl + $umur20_p_l['Jml'];
							$umur20_p_p_ttl = $umur20_p_p_ttl + $umur20_p_p['Jml'];
							
							$jml_p_l = $umur06_p_l['Jml'] + $umur612_p_l['Jml'] + $umur15_p_l['Jml'] + $umur510_p_l['Jml'] + $umur1015_p_l['Jml'] + $umur1520_p_l['Jml'] + $umur20_p_l['Jml'];
							$jml_p_p = $umur06_p_p['Jml'] + $umur612_p_p['Jml'] + $umur15_p_p['Jml'] + $umur510_p_p['Jml'] + $umur1015_p_p['Jml'] + $umur1520_p_p['Jml'] + $umur20_p_p['Jml'];
							$jml_p_l_ttl = $jml_p_l_ttl + $jml_p_l;
							$jml_p_p_ttl = $jml_p_p_ttl + $jml_p_p;
						?>
							<tr style="border:1px solid #000;">
								<td align="right" style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $dtkelurahan['Kelurahan'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur06_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur06_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur612_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur612_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur15_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur15_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur510_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur510_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1015_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1015_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1520_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1520_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur20_p_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur20_p_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $jml_p_l;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $jml_p_p;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
								<td align="center" style="border:1px solid #000; padding:3px;"></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b><br/>
				- Silahkan pilih periode Bulan / Tanggal lalu klik menu cari<br/>
				- Klasifikasi Diare Kode ICD X (A09)</p>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>