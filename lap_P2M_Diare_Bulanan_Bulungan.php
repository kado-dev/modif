<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DIARE (BULANAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Diare_Bulanan_Bulungan"/>
						<div class="col-sm-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>

						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:125px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
					
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
						<div class="col-sm-1 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<SELECT name="kasus" class="form-control">
								<option value="Semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</SELECT>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Diare_Bulanan_Bulungan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$tbdiagnosapasien = "tbdiagnosapasien_".$bulan;
	$tbpasienrj = "tbpasienrj_".$bulan;

	if(isset($bulan) and isset($tahun)){
	?>

	<!--data registrasi-->
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN DIARE (KELURAHAN)</b></span><br>
		<?php if($opsiform == 'bulan'){?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<?php }else{ ?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y',strtotime($keydate1))." s/d ".date('d-m-Y',strtotime($keydate2));?></span>
		<?php }?>
		<br/>
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

	<div class="row font9">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead style="font-size:8.5px;">
						<tr style="border:1px solid #000;">
							<th rowspan="4" width="1%" style="text-align:center; vertical-align:middle;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="4" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan</th>
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Penduduk</th>
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Perkiraan Diare Seluruh Penderita</th>
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Target Seluruh Penderita</th>
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Balita</th>
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Perkiraan Diare Seluruh Penderita</th>
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Target Seluruh Penderita</th>
							<th colspan="44" width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000;padding:3px;">Kelompok Umur</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="10" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">0 -< 6 Bulan</th>
							<th colspan="10" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">6 -< 12 Bulan</th>
							<th colspan="10" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">12 -< 60 Bulan</th>
							<th colspan="10" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">> 5 Tahun</th>
							<th colspan="10" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						</tr>
						<tr style="border:1px solid #000;">
							<!--0 -< 6 Bulan-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">M</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penderita di beri</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian</th>
							<!--6 -< 12 Bulan-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">M</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penderita di beri</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian</th>
							<!--12 -< 60 Bulan-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">M</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penderita di beri</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian</th>
							<!-- diatas 60 Bulan-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">M</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penderita di beri</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian</th>
							<!--jumlah-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">M</th>
						</tr>
						<tr style="border:1px solid #000;">
							<!--0 -< 6 Bulan-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Penderita di beri-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Jumlah Pemakaian-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<!--6 -< 12 Bulan-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Penderita di beri-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Jumlah Pemakaian-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<!--12 -< 60 Bulan-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Penderita di beri-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Jumlah Pemakaian-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<!-- diatas 60 Bulan-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Penderita di beri-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Oralit</th><!--Jumlah Pemakaian-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Zinc Syr</th>
							<!--jumlah-->
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle;border:1px solid #000; padding:3px;">L</th>
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
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">48</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">49</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">50</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">51</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">52</th>
						</tr>
					</thead>
					<tbody style="font-size:8.5px;">
						<?php
						if($opsiform == 'bulan'){
							$waktu = "YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND ";
							$tbdiagnosadiare = 'tbdiagnosadiare';
						}else{
							$waktu = "a.TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2' AND ";
							$tbdiagnosadiare = 'tbdiagnosadiare';
						}
						
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
							
							// umur 0-6 bulan
							$umur06_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '1' AND '5' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur06_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '1' AND '5' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur06_l_ttl = $umur06_l_ttl + $umur06_l['Jml'];
							$umur06_p_ttl = $umur06_p_ttl + $umur06_p['Jml'];
							
							// diberi, cek dulu dari tbdiagnosadiare jika kosong baca resepdetail
							$oralit_diberi_0_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '1' AND '5'"));
							$zinc_diberi_0_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '1' AND '5'"));
							$zincsyr_diberi_0_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '1' AND '5'"));
							$oralit_diberi_0_6_ttl = $oralit_diberi_0_6_ttl + $oralit_diberi_0_6['Jml'];
							$zinc_diberi_0_6_ttl = $zinc_diberi_0_6_ttl + $zinc_diberi_0_6['Jml'];
							$zincsyr_diberi_0_6_ttl = $zincsyr_diberi_0_6_ttl + $zincsyr_diberi_0_6['Jml'];
							
							// jumlah diberi
							$oralit_jml_diberi_0_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Oralit) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '1' AND '5'"));
							if($oralit_jml_diberi_0_6['Jml'] == ''){
								$oralit_jml_diberi_0_6s = 0;
							}else{
								$oralit_jml_diberi_0_6s = $oralit_jml_diberi_0_6['Jml']; 
							}	
							
							$zinc_jml_diberi_0_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Zinc) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '1' AND '5'"));
							if($zinc_jml_diberi_0_6['Jml'] == ''){
								$zinc_jml_diberi_0_6s = 0;
							}else{
								$zinc_jml_diberi_0_6s = $zinc_jml_diberi_0_6['Jml']; 
							}	
							
							$zincsyr_jml_diberi_0_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(ZincSyr) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '1' AND '5'"));
							if($zincsyr_jml_diberi_0_6['Jml'] == ''){
								$zincsyr_jml_diberi_0_6s = 0;
							}else{
								$zincsyr_jml_diberi_0_6s = $zincsyr_jml_diberi_0_6['Jml']; 
							}
														
							$oralit_jml_diberi_0_6_ttl = $oralit_jml_diberi_0_6_ttl + $oralit_jml_diberi_0_6['Jml'];
							$zinc_jml_diberi_0_6_ttl = $zinc_jml_diberi_0_6_ttl + $zinc_jml_diberi_0_6['Jml'];
							$zincsyr_jml_diberi_0_6_ttl = $zincsyr_jml_diberi_0_6_ttl + $zincsyr_jml_diberi_0_6['Jml'];
														
							// umur 6-12 bulan
							$umur612_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '6' AND '12' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur612_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun = '0' AND a.UmurBulan BETWEEN '6' AND '12' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur612_l_ttl = $umur612_l_ttl + $umur612_l['Jml'];
							$umur612_p_ttl = $umur612_p_ttl + $umur612_p['Jml'];
							
							// diberi, cek dulu dari tbdiagnosadiare jika kosong baca resepdetail
							$oralit_diberi_6_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '6' AND '12'"));
							$zinc_diberi_6_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '6' AND '12'"));
							$zincsyr_diberi_6_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '6' AND '12'"));
							$oralit_diberi_6_12_ttl = $oralit_diberi_6_12_ttl + $oralit_diberi_6_12['Jml'];
							$zinc_diberi_6_12_ttl = $zinc_diberi_6_12_ttl + $zinc_diberi_6_12['Jml'];
							$zincsyr_diberi_6_12_ttl = $zincsyr_diberi_6_12_ttl + $zincsyr_diberi_6_12['Jml'];
							
							// jumlah diberi
							$oralit_jml_diberi_6_12= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Oralit) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '6' AND '12'"));
							if($oralit_jml_diberi_6_12['Jml'] == ''){
								$oralit_jml_diberi_6_12s = 0;
							}else{
								$oralit_jml_diberi_6_12s = $oralit_jml_diberi_6_12['Jml']; 
							}	
							
							$zinc_jml_diberi_6_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Zinc) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '6' AND '12'"));
							if($zinc_jml_diberi_6_12['Jml'] == ''){
								$zinc_jml_diberi_6_12s = 0;
							}else{
								$zinc_jml_diberi_6_12s = $zinc_jml_diberi_6_12['Jml']; 
							}	
							
							$zincsyr_jml_diberi_6_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(ZincSyr) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` = '0' AND UmurBulan BETWEEN '6' AND '12'"));
							if($zincsyr_jml_diberi_6_12['Jml'] == ''){
								$zincsyr_jml_diberi_6_12s = 0;
							}else{
								$zincsyr_jml_diberi_6_12s = $zincsyr_jml_diberi_6_12['Jml']; 
							}	
							
							$oralit_jml_diberi_6_12_ttl = $oralit_jml_diberi_6_12_ttl + $oralit_jml_diberi_6_12['Jml'];
							$zinc_jml_diberi_6_12_ttl = $zinc_jml_diberi_6_12_ttl + $zinc_jml_diberi_6_12['Jml'];
							$zincsyr_jml_diberi_6_12_ttl = $zincsyr_jml_diberi_6_12_ttl + $zincsyr_jml_diberi_6_12['Jml'];
							
							// umur 12-60 bulan
							$umur1260_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '1' AND '4' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur1260_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '1' AND '4' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur1260_l_ttl = $umur1260_l_ttl + $umur1260_l['Jml'];
							$umur1260_p_ttl = $umur1260_p_ttl + $umur1260_p['Jml'];
							
							// diberi, cek dulu dari tbdiagnosadiare jika kosong baca resepdetail
							$oralit_diberi_12_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '1' AND '4'"));
							$zinc_diberi_12_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '1' AND '4'"));
							$zincsyr_diberi_12_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '1' AND '4'"));
							$oralit_diberi_12_60_ttl = $oralit_diberi_12_60_ttl + $oralit_diberi_12_60['Jml'];
							$zinc_diberi_12_60_ttl = $zinc_diberi_12_60_ttl + $zinc_diberi_12_60['Jml'];
							$zincsyr_diberi_12_60_ttl = $zincsyr_diberi_12_60_ttl + $zincsyr_diberi_12_60['Jml'];
							
							// jumlah diberi
							$oralit_jml_diberi_12_60= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Oralit) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '1' AND '4'"));
							if($oralit_jml_diberi_12_60['Jml'] == ''){
								$oralit_jml_diberi_12_60s = 0;
							}else{
								$oralit_jml_diberi_12_60s = $oralit_jml_diberi_12_60['Jml']; 
							}	
							
							$zinc_jml_diberi_12_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Zinc) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '1' AND '4'"));
							if($zinc_jml_diberi_12_60['Jml'] == ''){
								$zinc_jml_diberi_12_60s = 0;
							}else{
								$zinc_jml_diberi_12_60s = $zinc_jml_diberi_12_60['Jml']; 
							}	
							
							$zincsyr_jml_diberi_12_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(ZincSyr) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '1' AND '4'"));
							if($zincsyr_jml_diberi_12_60['Jml'] == ''){
								$zincsyr_jml_diberi_12_60s = 0;
							}else{
								$zincsyr_jml_diberi_12_60s = $zincsyr_jml_diberi_12_60['Jml']; 
							}
							
							$oralit_jml_diberi_12_60_ttl = $oralit_jml_diberi_12_60_ttl + $oralit_jml_diberi_12_60['Jml'];
							$zinc_jml_diberi_12_60_ttl = $zinc_jml_diberi_12_60_ttl + $zinc_jml_diberi_12_60['Jml'];
							$zincsyr_jml_diberi_12_60_ttl = $zincsyr_jml_diberi_12_60_ttl + $zincsyr_jml_diberi_12_60['Jml'];
							
							// umur > 5 Tahun
							$umur60_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '5' AND '100' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur60_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex LEFT JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.UmurTahun BETWEEN '5' AND '100' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan' AND (c.`KodeDiagnosa`='A03.0' OR c.`KodeDiagnosa`='A06.0' OR c.`KodeDiagnosa`='A09')"));
							$umur60_l_ttl = $umur60_l_ttl + $umur60_l['Jml'];
							$umur60_p_ttl = $umur60_p_ttl + $umur60_p['Jml'];
							
							// diberi, cek dulu dari tbdiagnosadiare jika kosong baca resepdetail
							$oralit_diberi_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Oralit` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '5' AND '100'"));
							$zinc_diberi_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Zinc` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '5' AND '100'"));
							$zincsyr_diberi_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `ZincSyr` != '' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '5' AND '100'"));
							$oralit_diberi_60_ttl = $oralit_diberi_60_ttl + $oralit_diberi_60['Jml'];
							$zinc_diberi_60_ttl = $zinc_diberi_60_ttl + $zinc_diberi_60['Jml'];
							$zincsyr_diberi_60_ttl = $zincsyr_diberi_60_ttl + $zincsyr_diberi_60['Jml'];
							
							// jumlah diberi
							$oralit_jml_diberi_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Oralit) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '5' AND '100'"));
							if($oralit_jml_diberi_60['Jml'] == ''){
								$oralit_jml_diberi_60s = 0;
							}else{
								$oralit_jml_diberi_60s = $oralit_jml_diberi_60['Jml']; 
							}							
														
							$zinc_jml_diberi_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Zinc) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '5' AND '100'"));
							if($zinc_jml_diberi_60['Jml'] == ''){
								$zinc_jml_diberi_60s = 0;
							}else{
								$zinc_jml_diberi_60s = $zinc_jml_diberi_60['Jml']; 
							}	
							
							$zincsyr_jml_diberi_60 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(ZincSyr) AS Jml FROM `tbdiagnosadiare` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Kelurahan` = '$kelurahan' AND `UmurTahun` BETWEEN '5' AND '100'"));
							if($zincsyr_jml_diberi_60['Jml'] == ''){
								$zincsyr_jml_diberi_60s = 0;
							}else{
								$zincsyr_jml_diberi_60s = $zincsyr_jml_diberi_60['Jml']; 
							}
							
							$oralit_jml_diberi_60_ttl = $oralit_jml_diberi_60_ttl + $oralit_jml_diberi_60s['Jml'];
							$zinc_jml_diberi_60_ttl = $zinc_jml_diberi_60_ttl + $zinc_jml_diberi_60['Jml'];
							$zincsyr_jml_diberi_60_ttl = $zincsyr_jml_diberi_60_ttl + $zincsyr_jml_diberi_60['Jml'];
							
							$jml_p_l = $umur06_l['Jml'] + $umur612_l['Jml'] + $umur612_l['Jml'] + $umur60_l['Jml'];
							$jml_p_p = $umur06_p['Jml'] + $umur612_p['Jml'] + $umur612_p['Jml'] + $umur60_p['Jml'];
							$jml_p_l_ttl = $jml_p_l_ttl + $jml_p_l;
							$jml_p_p_ttl = $jml_p_p_ttl + $jml_p_p;
						?>
							<tr style="border:1px solid #000;">
								<td align="right" style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $dtkelurahan['Kelurahan'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur06_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur06_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_0_6['Jml'];?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_0_6['Jml'];?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_0_6['Jml'];?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_0_6s;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_0_6s;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_0_6s;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur612_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur612_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_6_12['Jml'];?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_6_12['Jml'];?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_6_12['Jml'];?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_6_12s;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_6_12s;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_6_12s;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1260_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1260_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_12_60['Jml'];?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_12_60['Jml'];?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_12_60['Jml'];?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_12_60s;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_12_60s;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_12_60s;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur60_l['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur60_p['Jml'];?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_60['Jml'];?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_60['Jml'];?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_60['Jml'];?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_60s;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_60s;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_60s;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $jml_p_l;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $jml_p_p;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
							</tr>
						<?php
						}
						?>
							<tr style="border:1px solid #000;">
								<td colspan="2" align="center" style="border:1px solid #000; padding:3px;">Total</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur06_l_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur06_p_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_0_6_ttl;?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_0_6_ttl;?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_0_6_ttl;?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_0_6_ttl;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_0_6_ttl;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_0_6_ttl;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur612_l_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur612_p_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_6_12_ttl;?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_6_12_ttl;?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_6_12_ttl;?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_6_12_ttl;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_6_12_ttl;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_6_12_ttl;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1260_l_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur1260_p_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_12_60_ttl;?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_12_60_ttl;?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_12_60_ttl;?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_12_60_ttl;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_12_60_ttl;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_12_60_ttl;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur60_l_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $umur60_p_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td><!--meninggal-->
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_diberi_60_ttl;?></td><!--oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_diberi_60_ttl;?></td><!--zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_diberi_60_ttl;?></td><!--zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $oralit_jml_diberi_60_ttl;?></td><!--jml_oralit-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zinc_jml_diberi_60_ttl;?></td><!--jml_zinc-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $zincsyr_jml_diberi_60_ttl;?></td><!--jml_zincsyr-->
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $jml_p_l_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $jml_p_p_ttl;?></td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
								<td align="center" style="border:1px solid #000; padding:3px;">0</td>
							</tr>
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
				<p>
					<b>Perhatikan :</b><br/>
					Klasifikasi Diare, kode ICD X (A03.0, A06.0, A09)
				</p>
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