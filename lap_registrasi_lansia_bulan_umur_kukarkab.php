<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LANSIA PER-KELOMPOK UMUR</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia_bulan_umur_kukarkab"/>
						<div class="col-xl-2">
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia_bulan_umur_kukarkab" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
<?php
$bulan = $_GET['bulan'];
$bulanlalu = $_GET['bulan'] - 1;
if(strlen($bulanlalu) == 2){
	$blnlalu = $bulanlalu;
}else{
	$blnlalu = "0".$bulanlalu;
}
$tahun = $_GET['tahun'];
$tbpasienrj_lalu = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
if(isset($bulan) and isset($tahun)){
?>

<div class="printheader">
	<span class="font14" style="margin:1px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
	<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KESEHATAN LANJUT USIA PER-KELOMPOK UMUR</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
	<br/>
</div>

<div class="col-lg-12">
	<div class="table-responsive">
		<span style="font11">A. LAKI-LAKI</span>
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th rowspan="4">No.</th>
					<th rowspan="4" width="5%";>Kel/Desa</th>
					<th colspan="4" width="10%";>Sasaran</th>
					<th colspan="12">Kunjungan Perkelompok Umur (BARU)</th>
					<th colspan="12">Kunjungan Perkelompok Umur (LAMA)</th>
					<th colspan="3">Konseling</th>
					<th colspan="2">Total</th>
					<th rowspan="3" width="2%";>Jumlah Penyuluhan Posyandu</th>
				</tr>
				<tr>
					<th rowspan="2">45-59</th><!--Sasaran-->
					<th rowspan="2">60-69</th>
					<th rowspan="2">>70</th>
					<th rowspan="2">Jml</th>
					<th colspan="4">45-59</th><!--Kunjungan Perkelompok Umur (Baru)-->
					<th colspan="4">60-69</th>
					<th colspan="4">>70</th>
					<th colspan="4">45-59</th><!--Kunjungan Perkelompok Umur (Lama)-->
					<th colspan="4">60-69</th>
					<th colspan="4">>70</th>
					<th rowspan="2">B</th><!--Konseling-->
					<th rowspan="2">L</th>
					<th rowspan="2">S</th>
					<th rowspan="2">Diobati</th><!--Total-->
					<th rowspan="2">Rujuk</th>
				</tr>
				<tr>
					<th>Lalu</th><!--45-59 Kunjungan Baru-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--60-69 Kunjungan Baru-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--diatas 70 Kunjungan Baru-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--45-59 Kunjungan Lama-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--60-69 Kunjungan Lama-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--diatas 70 Kunjungan Lama-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
				</tr>
				<tr>
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
				</tr>
			</thead>
			<tbody>
				<?php
				$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
				$query = mysqli_query($koneksi,$str_kel);
				
				while($data_kel = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kelurahan = $data_kel['Kelurahan'];
					
					// Kunjungan Lalu Baru (45-59)
					$lalu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj_lalu` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					$ini_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					$lalu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj_lalu` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					$ini_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					$lalu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj_lalu` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					$ini_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					
					// menghitung absolute
					if ($bulan == '01'){ 
						$absolute_45_59_baru = "0";
						$absolute_60_69_baru = "0";
						$absolute_70_baru = "0";
					}elseif($bulan == '02'){
						$absolute_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
					}elseif($bulan == '03'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'];
					}elseif($bulan == '04'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'];
					}elseif($bulan == '05'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru;
					}elseif($bulan == '06'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'];
					}elseif($bulan == '07'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'];
					}elseif($bulan == '08'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'];
					}elseif($bulan == '09'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + $agu_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + $agu_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'];
					}elseif($bulan == '10'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + 
						$apr_45_59_baru['Jml'] + $mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + 
						$agu_45_59_baru['Jml'] + $sep_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + 
						$apr_60_69_baru['Jml'] + $mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + 
						$agu_60_69_baru['Jml'] + $sep_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'] + $sep_70_baru['Jml'];
					}elseif($bulan == '11'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$okt_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + 
						$apr_45_59_baru['Jml'] + $mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + 
						$agu_45_59_baru['Jml'] + $sep_45_59_baru['Jml'] + $okt_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$okt_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + 
						$apr_60_69_baru['Jml'] + $mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + 
						$agu_60_69_baru['Jml'] + $sep_60_69_baru['Jml'] + $okt_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$okt_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'] + $sep_70_baru['Jml'] +
						$okt_70_baru['Jml'];
					}elseif($bulan == '12'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$okt_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$nov_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_11` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + 
						$apr_45_59_baru['Jml'] + $mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + 
						$agu_45_59_baru['Jml'] + $sep_45_59_baru['Jml'] + $okt_45_59_baru['Jml'] + $nov_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$okt_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$nov_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_11` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + 
						$apr_60_69_baru['Jml'] + $mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + 
						$agu_60_69_baru['Jml'] + $sep_60_69_baru['Jml'] + $okt_60_69_baru['Jml'] + $nov_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$sep_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$okt_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$nov_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_11` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'L' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'] + $sep_70_baru['Jml'] +
						$okt_70_baru['Jml'] + $nov_70_baru['Jml'];
					}
					
					// konseling
					$kons_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Konseling = 'B' AND b.Kelurahan='$kelurahan'"));
					$kons_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Konseling = 'L' AND b.Kelurahan='$kelurahan'"));
					$kons_s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Konseling = 'S' AND b.Kelurahan='$kelurahan'"));
					// pengobatan
					$diobati = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Pengobatan = 'Diobati' AND b.Kelurahan='$kelurahan'"));
					$dirujuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Pengobatan = 'Dirujuk' AND b.Kelurahan='$kelurahan'"));
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
						<td>-</td><!--Sasaran-->
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td><?php echo $lalu_45_59_baru['Jml'];?></td><!--Kunjungan Baru-->
						<td><?php echo $ini_45_59_baru['Jml'];?></td>
						<td><?php echo $absolute_45_59_baru;?></td>
						<td>-</td>
						<td><?php echo $lalu_60_69_baru['Jml'];?></td>
						<td><?php echo $ini_60_69_baru['Jml'];?></td>
						<td><?php echo $absolute_60_69_baru;?></td>
						<td>-</td>
						<td><?php echo $lalu_70_baru['Jml'];?></td>
						<td><?php echo $ini_70_baru['Jml'];?></td>
						<td><?php echo $absolute_70_baru;?></td>
						<td>-</td>
						<td>-</td><!--Kunjungan Lama-->
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td><?php echo $kons_b['Jml'];?></td><!--Konseling-->
						<td><?php echo $kons_l['Jml'];?></td>
						<td><?php echo $kons_s['Jml'];?></td>
						<td><?php echo $diobati['Jml'];?></td><!--Pengobatan-->
						<td><?php echo $dirujuk['Jml'];?></td>
						<td>-</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table><br/>
		
		<span style="font11">B. PEREMPUAN</span>
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th rowspan="4">No.</th>
					<th rowspan="4" width="5%";>Kel/Desa</th>
					<th colspan="4" width="10%";>Sasaran</th>
					<th colspan="12">Kunjungan Perkelompok Umur (BARU)</th>
					<th colspan="12">Kunjungan Perkelompok Umur (LAMA)</th>
					<th colspan="3">Konseling</th>
					<th colspan="2">Total</th>
					<th rowspan="3" width="2%";>Jumlah Penyuluhan Posyandu</th>
				</tr>
				<tr>
					<th rowspan="2">45-59</th><!--Sasaran-->
					<th rowspan="2">60-69</th>
					<th rowspan="2">>70</th>
					<th rowspan="2">Jml</th>
					<th colspan="4">45-59</th><!--Kunjungan Perkelompok Umur (Baru)-->
					<th colspan="4">60-69</th>
					<th colspan="4">>70</th>
					<th colspan="4">45-59</th><!--Kunjungan Perkelompok Umur (Lama)-->
					<th colspan="4">60-69</th>
					<th colspan="4">>70</th>
					<th rowspan="2">B</th><!--Konseling-->
					<th rowspan="2">L</th>
					<th rowspan="2">S</th>
					<th rowspan="2">Diobati</th><!--Total-->
					<th rowspan="2">Rujuk</th>
				</tr>
				<tr>
					<th>Lalu</th><!--45-59 Kunjungan Baru-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--60-69 Kunjungan Baru-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--diatas 70 Kunjungan Baru-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--45-59 Kunjungan Lama-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--60-69 Kunjungan Lama-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
					<th>Lalu</th><!--diatas 70 Kunjungan Lama-->
					<th>Ini</th>
					<th>Abs</th>
					<th>%</th>
				</tr>
				<tr>
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
				</tr>
			</thead>
			<tbody>
				<?php
				$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
				$query = mysqli_query($koneksi,$str_kel);
				
				while($data_kel = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kelurahan = $data_kel['Kelurahan'];
					
					// Kunjungan Lalu Baru (45-59)
					$lalu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj_lalu` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					$ini_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					$lalu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj_lalu` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					$ini_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					$lalu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj_lalu` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					$ini_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					
					// menghitung absolute
					if ($bulan == '01'){ 
						$absolute_45_59_baru = "0";
						$absolute_60_69_baru = "0";
						$absolute_70_baru = "0";
					}elseif($bulan == '02'){
						$absolute_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
					}elseif($bulan == '03'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'];
					}elseif($bulan == '04'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'];
					}elseif($bulan == '05'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru;
					}elseif($bulan == '06'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'];
					}elseif($bulan == '07'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'];
					}elseif($bulan == '08'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'];
					}elseif($bulan == '09'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + $apr_45_59_baru['Jml'] + 
						$mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + $agu_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + $apr_60_69_baru['Jml'] +
						$mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + $agu_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'];
					}elseif($bulan == '10'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + 
						$apr_45_59_baru['Jml'] + $mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + 
						$agu_45_59_baru['Jml'] + $sep_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + 
						$apr_60_69_baru['Jml'] + $mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + 
						$agu_60_69_baru['Jml'] + $sep_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'] + $sep_70_baru['Jml'];
					}elseif($bulan == '11'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$okt_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + 
						$apr_45_59_baru['Jml'] + $mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + 
						$agu_45_59_baru['Jml'] + $sep_45_59_baru['Jml'] + $okt_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$okt_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + 
						$apr_60_69_baru['Jml'] + $mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + 
						$agu_60_69_baru['Jml'] + $sep_60_69_baru['Jml'] + $okt_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$okt_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'] + $sep_70_baru['Jml'] +
						$okt_70_baru['Jml'];
					}elseif($bulan == '12'){
						$jan_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$okt_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$nov_45_59_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_11` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '45' AND '59' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_45_59_baru = $jan_45_59_baru['Jml'] + $feb_45_59_baru['Jml'] + $mar_45_59_baru['Jml'] + 
						$apr_45_59_baru['Jml'] + $mei_45_59_baru['Jml'] + $juni_45_59_baru['Jml'] + $jul_45_59_baru['Jml'] + 
						$agu_45_59_baru['Jml'] + $sep_45_59_baru['Jml'] + $okt_45_59_baru['Jml'] + $nov_45_59_baru['Jml'];
						// 60-69
						$jan_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$okt_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$nov_60_69_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_11` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun BETWEEN '60' AND '69' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_60_69_baru = $jan_60_69_baru['Jml'] + $feb_60_69_baru['Jml'] + $mar_60_69_baru['Jml'] + 
						$apr_60_69_baru['Jml'] + $mei_60_69_baru['Jml'] + $juni_60_69_baru['Jml'] + $jul_60_69_baru['Jml'] + 
						$agu_60_69_baru['Jml'] + $sep_60_69_baru['Jml'] + $okt_60_69_baru['Jml'] + $nov_60_69_baru['Jml'];
						// 70
						$jan_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_01` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$feb_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_02` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mar_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_03` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$apr_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_04` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$mei_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_05` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jun_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_06` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$jul_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_07` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$agu_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_08` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$sep_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_09` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$okt_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_10` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$nov_70_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `tbpasienrj_11` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND a.UmurTahun >= '70' AND a.PoliPertama = 'POLI LANSIA' AND a.StatusKunjungan = 'Baru' AND a.JenisKelamin = 'P' AND b.Kelurahan = '$kelurahan'"));
						$absolute_70_baru = $jan_70_baru['Jml'] + $feb_70_baru['Jml'] + $mar_70_baru['Jml'] + $apr_70_baru['Jml'] +
						$mei_70_baru['Jml'] + $juni_70_baru['Jml'] + $jul_70_baru['Jml'] + $agu_70_baru['Jml'] + $sep_70_baru['Jml'] +
						$okt_70_baru['Jml'] + $nov_70_baru['Jml'];
					}
					
					// konseling
					$kons_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Konseling = 'B' AND b.Kelurahan='$kelurahan'"));
					$kons_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Konseling = 'L' AND b.Kelurahan='$kelurahan'"));
					$kons_s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Konseling = 'S' AND b.Kelurahan='$kelurahan'"));
					// pengobatan
					$diobati = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Pengobatan = 'Diobati' AND b.Kelurahan='$kelurahan'"));
					$dirujuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Pengobatan = 'Dirujuk' AND b.Kelurahan='$kelurahan'"));
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
						<td>-</td><!--Sasaran-->
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td><?php echo $lalu_45_59_baru['Jml'];?></td><!--Kunjungan Baru-->
						<td><?php echo $ini_45_59_baru['Jml'];?></td>
						<td><?php echo $absolute_45_59_baru;?></td>
						<td>-</td>
						<td><?php echo $lalu_60_69_baru['Jml'];?></td>
						<td><?php echo $ini_60_69_baru['Jml'];?></td>
						<td><?php echo $absolute_60_69_baru;?></td>
						<td>-</td>
						<td><?php echo $lalu_70_baru['Jml'];?></td>
						<td><?php echo $ini_70_baru['Jml'];?></td>
						<td><?php echo $absolute_70_baru;?></td>
						<td>-</td>
						<td>-</td><!--Kunjungan Lama-->
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td><?php echo $kons_b['Jml'];?></td><!--Konseling-->
						<td><?php echo $kons_l['Jml'];?></td>
						<td><?php echo $kons_s['Jml'];?></td>
						<td><?php echo $diobati['Jml'];?></td><!--Pengobatan-->
						<td><?php echo $dirujuk['Jml'];?></td>
						<td>-</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="bawahtabel">
	<table width="100%">
		<tr>
			<td width="5%"></td>
			<td style="text-align:center;">
				MENGETAHUI<br>
				<?php 
					$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
					echo "KEPALA UPT ".$datapuskesmas['NamaPuskesmas'];
				?>
				<br><br><br><br>
				<u><?php echo $datapuskesmas['KepalaPuskesmas'];?></u><br>
				<?php echo "NIP.".$datapuskesmas['Nip'];?>
			</td>
			<td width="10%"></td>
			<td style="text-align:center;">
				<?php echo $kota.", ___ ".strtoupper(nama_bulan($bulan))." ".$tahun;?><br>
				PELAKSANA PROGRAM
				<br><br><br><br>
				(..........................................................)
			</td>
		</tr>
	</table>
</div>
<?php
}
?>
