<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Ispa (Bulanan)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_Ispa_Bulanan"/>
						<div class="col-xl-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>

						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
					
						<div class="col-xl-2 bulanformcari">
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
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<SELECT name="kasus" class="form-control">
								<option value="Semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</SELECT>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Ispa_Bulanan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Ispa_Bulanan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN ISPA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>
	
	<div class="atastabel font11">
		<div style="width:35%; margin-bottom:10px;">	
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
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px dashed #000;">
							<th rowspan="3">NO.</th>
							<th rowspan="3">KELURAHAN</th>
							<th rowspan="3">JML PDKK</th>
							<th rowspan="3" width="6%">JML PDKK BALITA (10% PDKK)</th>
							<th rowspan="3" width="6%">TARGET PENEMUAN PDKK PNEUMONIA</th>
							<th colspan="4">PNEUMONIA</th>
							<th colspan="4">PNEUMONIA BERAT</th>
							<th colspan="7">JML</th>
							<th rowspan="3">%</th>
							<th colspan="5">BATUK BUKAN PNEUMONIA</th>
							<th rowspan="3" width="6%">JML BALITA BATUK YANG DIHITUNG NAPAS ATAU LIHAT TDDK</th>
							<th colspan="6">JML KEMATIAN BALITA KRN PNEUMONIA</th>
							<th colspan="6">ISPA >5 TH</th>
							<th rowspan="3">DIRUJUK</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th colspan="2">1 TH</th><!--Pneumonia-->
							<th colspan="2">1-4 TH</th>
							<th colspan="2"> < 1 TH</th><!--Pneumonia Berat-->
							<th colspan="2">1-4 TH</th>
							<th colspan="2"> < 1 TH</th><!--Jumlah-->
							<th colspan="2">1-4 TH</th>
							<th colspan="2">SUBTOTAL</th>
							<th rowspan="2">TOTAL</th>
							<th colspan="2"> < 1 TH</th><!--Bukan Pneumonia-->
							<th colspan="2">1-4 TH</th>
							<th rowspan="2">TOTAL</th>
							<th colspan="2"> < 1 TH</th><!--Jml Kematian Balita Krn Penumonia-->
							<th colspan="2">1-4 TH</th>
							<th colspan="2">TOTAL</th>
							<th colspan="3">BKN PNEUMONIA</th>
							<th colspan="3">PNEUMONIA</th><!--ISPA >5 Thn-->
						
						</tr>
						<tr style="border:1px dashed #000;">
							<th>L</th><!--Pneumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Pneumonia Berat-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Jumlah-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Bukan Pneumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Jml Kematian Balita Krn Penumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Pneumonia-->
							<th>P</th>
							<th>T</th>
							<th>L</th><!--Bukan Pneumonia-->
							<th>P</th>
							<th>T</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
							<th>16</th>
							<th>17</th>
							<th>18</th>
							<th>19</th>
							<th>20</th>
							<th>21</th>
							<th>22</th>
							<th>23</th>
							<th>24</th>
							<th>25</th>
							<th>26</th>
							<th>27</th>
							<th>28</th>
							<th>29</th>
							<th>30</th>
							<th>31</th>
							<th>32</th>
							<th>33</th>
							<th>34</th>
							<th>35</th>
							<th>36</th>
							<th>37</th>
							<th>38</th>
							<th>39</th>
							<th>40</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// tbdiagnosaispa
						$kasus = $_GET['kasus'];
						if($kasus != 'Semua'){
							$qkasus = " AND Kunjungan = '$kasus' ";
						}else{
							$qkasus = " ";
						}
						
						$str_kelurahan = "SELECT * FROM `tbkelurahan` WHERE KodePuskesmas = '$kodepuskesmas' OR KodePuskesmas = '*'";
						$str2 = $str_kelurahan."ORDER BY Kelurahan";
						// echo $str2;
						
						$query_kelurahan = mysqli_query($koneksi,$str2);
						while($data_kelurahan = mysqli_fetch_assoc($query_kelurahan)){
							$no = $no + 1;
							$noregistrasi = $data_kelurahan['NoRegistrasi'];
							$umurtahun = $data_kelurahan['UmurTahun'];
							$kelurahan = $data_kelurahan['Kelurahan'];
						
							// pneumonia
							if ($kelurahan == 'Luar Wilayah'){
								$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan'"));
								$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan'"));
								$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan' A"));
								$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan'"));
							}else{
								$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
								$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
								$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
								$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
							}	
							
							$ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
							$ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
							$laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
							$ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
							$ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
						
							// pneumonia_berat
							$ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
							$ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
							$ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
							$ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
							$ispa_0_Laki_berat = $ispa_0_Laki_pneumonia_berat['Jumlah'];
							$ispa_1_4_Laki_berat =  $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
							$laki_pneumonia_berat = $ispa_0_Laki_berat + $ispa_1_4_Laki_berat;			
							$ispa_0_perempuan_berat = $ispa_0_Perempuan_pneumonia_berat['Jumlah'];
							$ispa_1_4_perempuan_berat =  $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
							$perempuan_pneumonia_berat = $ispa_0_perempuan_berat + $ispa_1_4_perempuan_berat;
						
							// sub total
							$jumlah_0_Laki = $ispa_1_4_Laki_pneumonia['Jumlah'];
							$jumlah_1_4_Laki = $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
							$sublaki = $jumlah_0_Laki + $jumlah_1_4_Laki;			
							$jumlah_0_perempuan = $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$jumlah_1_4_perempuan = $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
							$subperempuan = $jumlah_0_perempuan + $jumlah_1_4_perempuan;
						
							// total
							$total  = $sublaki + $subperempuan;
							
							// batuk bukan pneumonia
							$ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							$ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							$ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							$ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							$ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
							
							// nafas / RR, mengambil yang dihitung nafasnya (!='') berati diisi
							$jml_nafas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							
							
							// ispa > 5th bukan pneumonia
							$ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							$ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(TanggalRa.TanggalDiagnosaegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
							$ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
													
							// ispa > 5th pneumonia
							$ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
							$ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
							$ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
																				
						?>
						
							<tr style="border:1px dashed #000;">
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $data_kelurahan['Kelurahan'];?></td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="right"><?php echo $ispa_0_Laki_pneumonia['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_0_Perempuan_pneumonia['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_1_4_Laki_pneumonia['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_1_4_Perempuan_pneumonia['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_0_Laki_pneumonia_berat['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_0_Perempuan_pneumonia_berat['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_1_4_Laki_pneumonia_berat['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];?></td>
								<td align="right"><?php echo $laki_pneumonia;?></td>
								<td align="right"><?php echo $perempuan_pneumonia;?></td>
								<td align="right"><?php echo $laki_pneumonia_berat;?></td>
								<td align="right"><?php echo $perempuan_pneumonia_berat;?></td>
								<td align="right"><?php echo $sublaki;?></td>
								<td align="right"><?php echo $subperempuan;?></td>
								<td align="right"><?php echo $total;?></td>
								<td align="center">0.00</td>
								<td align="right"><?php echo $ispa_0_Laki_pneumonia_bukan['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_0_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_1_4_Laki_pneumonia_bukan['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td align="right"><?php echo $ttl_pneumonia_bukan?></td>
								<td align="center"><?php echo $nafas;?></td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="center">-</td>
								<td align="right"><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
								<td align="right"><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td align="right"><?php echo $ttl_5_pneumonia_bukan;?></td>
								<td align="right"><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
								<td align="right"><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
								<td align="right"><?php echo $ttl_5_pneumonia;?></td>
								<td align="center">-</td>
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
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<p>
					<b>Perhatikan :</b><br/>
					Pneumonia & Pneuminia Berat (J18)<br/>
					Batuk Bukan Pneumonia (J00, J06,J11, J20, J21, J30, J39, J44, J45, J46, J47)<br>
					Nafas TDDK diambil dari RR Poli Anak & MTBS, jika RR = 0 maka data tidak akan diambil<br>
					Perubahan klasifikasi kode ICD X silahkan konsultasi pemegang program di Puskesmas & Dinkes<br>
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