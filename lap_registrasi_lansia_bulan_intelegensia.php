<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LANSIA INTELEGENSIA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia_bulan_intelegensia"/>
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
							<a href="?page=lap_registrasi_lansia_bulan_intelegensia" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>	
	</div>
	<?php
	$bulan = $_GET['bulan'];	
	$tahun = $_GET['tahun'];
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:1px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN INTELEGENSIA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
		<br/>
	</div><br/>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2" width="10%">Puskesmas</th>
							<th colspan="6">Kunjungan Perkelompok Umur (BARU & LAMA)</th>
							<th rowspan="2">Total</th>
							<th rowspan="2">Total Sasaran</th>
							<th rowspan="2">Jumlah Diperiksa</th>
							<th rowspan="2">% Diperiksa</th>
							<th colspan="3">Penilaian</th>
							<th colspan="4">Faktor Resiko</th>
							<th colspan="4">Emosional</th>
							<th colspan="3">Kegiatan</th>
							<th colspan="2">Jumlah</th>
						</tr>
						<tr>
							<th>L</th><!--45-59 Kunjungan Baru-->
							<th>P</th>
							<th>L</th><!--60-69 Kunjungan Baru-->
							<th>P</th>
							<th>L</th><!--diatas 70 Kunjungan Baru-->
							<th>P</th>
							<th>ADL</th><!--penilaian-->
							<th>BALC</th>
							<th>CONG</th>
							<th>N</th><!--faktor resiko-->
							<th>R</th>
							<th>S</th>
							<th>B</th>
							<th>N</th><!--emosional-->
							<th>R</th>
							<th>S</th>
							<th>B</th>
							<th>BL</th><!--keiatan-->
							<th>BE</th>
							<th>BR</th>
							<th>Datang Pkm</th><!--jumlah-->
							<th>Dirujuk</th>
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
						</tr>
					</thead>
					<tbody>
						<?php
						// Kunjungan umur
						$umur_45_59_lk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun BETWEEN '45' AND '59' AND PoliPertama = 'POLI LANSIA' AND JenisKelamin = 'L'"));
						$umur_45_59_pr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun BETWEEN '45' AND '59' AND PoliPertama = 'POLI LANSIA' AND JenisKelamin = 'P'"));
						$umur_60_69_lk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun BETWEEN '60' AND '69' AND PoliPertama = 'POLI LANSIA' AND JenisKelamin = 'L'"));
						$umur_60_69_pr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun BETWEEN '60' AND '69' AND PoliPertama = 'POLI LANSIA' AND JenisKelamin = 'P'"));
						$umur_70_lk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun > '69' AND PoliPertama = 'POLI LANSIA' AND JenisKelamin = 'L'"));
						$umur_70_pr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun > '69' AND PoliPertama = 'POLI LANSIA' AND JenisKelamin = 'P'"));
						$total_umur = $umur_45_59_lk['Jml'] + $umur_45_59_pr['Jml'] + $umur_60_69_lk['Jml'] + $umur_60_69_pr['Jml'] + $umur_70_lk['Jml'] + $umur_70_pr['Jml'];
						$diperiksa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas'"));
						$datang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND (`StatusPulang`='3' OR `StatusPulang`='5') AND `PoliPertama`='POLI LANSIA'"));
						$dirujuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `StatusPulang`='4' AND `PoliPertama`='POLI LANSIA'"));
						
						// penilaian
						$penilaian_a = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `Kemandirian` = 'A'"));
						$penilaian_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `Kemandirian` = 'B'"));
						$penilaian_c = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `Kemandirian` = 'C'"));
						
						// faktor resiko
						$faktor_n = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `FaktorResiko` = 'N'"));
						$faktor_r = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `FaktorResiko` = 'R'"));
						$faktor_s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `FaktorResiko` = 'S'"));
						$faktor_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `FaktorResiko` = 'B'"));
						
						// emosional
						$emosional_n = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `GangguanEmosional` = 'N'"));
						$emosional_r = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `GangguanEmosional` = 'R'"));
						$emosional_s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `GangguanEmosional` = 'S'"));
						$emosional_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) AS Jml FROM `$tbpolilansia` WHERE YEAR(TanggalPeriksa)='$tahun' AND MONTH(TanggalPeriksa)='$bulan' AND SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND `GangguanEmosional` = 'B'"));
						
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
							<td><?php echo $umur_45_59_lk['Jml'];?></td>
							<td><?php echo $umur_45_59_pr['Jml'];?></td>
							<td><?php echo $umur_60_69_lk['Jml'];?></td>
							<td><?php echo $umur_60_69_pr['Jml'];?></td>
							<td><?php echo $umur_70_lk['Jml'];?></td>
							<td><?php echo $umur_70_pr['Jml'];?></td>
							<td><?php echo $total_umur;?></td><!--total-->
							<td>-</td><!--total sasaran-->
							<td><?php echo $diperiksa['Jml'];?></td><!--jumlah diperiksa-->
							<td>-</td><!--% diperiksa-->
							<td><?php echo $penilaian_a['Jml'];?></td><!--penilaian-->
							<td><?php echo $penilaian_b['Jml'];?></td>
							<td><?php echo $penilaian_c['Jml'];?></td>
							<td><?php echo $faktor_n['Jml'];?></td><!--faktor resiko-->
							<td><?php echo $faktor_r['Jml'];?></td>
							<td><?php echo $faktor_s['Jml'];?></td>
							<td><?php echo $faktor_b['Jml'];?></td>
							<td><?php echo $emosional_n['Jml'];?></td><!--emosional-->
							<td><?php echo $emosional_r['Jml'];?></td>
							<td><?php echo $emosional_s['Jml'];?></td>
							<td><?php echo $emosional_b['Jml'];?></td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td><?php echo $datang['Jml']?></td><!--datang-->
							<td><?php echo $dirujuk['Jml']?></td><!--dirujuk-->
						</tr>
					</tbody>
				</table>
			</div>
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
	</div><br/>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					- Nomer 2 s/d 7, Kunjungan perkelompok umur diambil dari tabel Registrasi Pasien<br/>
					- Nomer 10, Jumlah Diperiksa diambil dari tabel Poli Lansia<br/>
					- Nomer 26 & 27, Jumlah Datang & Dirujuk diambil dari tabel Registrasi Pasien
				</p>
			</div>
		</div>
	</div>

</div>	
