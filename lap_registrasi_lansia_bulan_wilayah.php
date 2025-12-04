<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LANSIA PER-WILAYAH</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia_bulan_wilayah"/>
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
							<a href="?page=lap_registrasi_lansia_bulan_wilayah" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_lansia_bulan_wilayah_Excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="4">NO.</th>
							<th rowspan="4">KEL/DESA</th>
							<th rowspan="4">JML POSYANDU</th>
							<th rowspan="4">JML PANTI WREDHA</th>
							<th colspan="7">SASARAN</th>
							<th colspan="13">JUMLAH YANG DIBINA/MENDAPAT PLY.KESEHATAN</th>
							<th rowspan ="2" colspan="4" style="text-align:center; width:2%; vertical-align:middle; border:1px solid #000; padding:3px; color: #ff3a3a;">USIA > 60 TH YANG DISKRINING KESEHATAN</th>
							<th colspan="3">KEGIATAN SEHARI-HARI</th>
							<th colspan="32">JUMLAH LANSIA DENGAN KELAINAN</th>
							<th rowspan ="3" colspan="2">JUMLAH LANSIA DENGAN KELAINAN</th>
							<th colspan="2">PENGOBATAN</th>
							<th colspan="3">KONSELING</th>
							<th rowspan="4">PENYULUHAN</th>
							<th rowspan="4">PEMBERDAYAAN LANSIA</th>
							<th rowspan="4">JML PANTI WREDHA DIBINA</th>
							<th rowspan="4">JML KNJ RMH</th>
							<th rowspan="4">STRATA POSBINDU</th>
							<th rowspan="4">STRATA PUSKESMAS</th>
							<th rowspan="4">KET.</th>
						</tr>
						<tr>
							<th colspan="6">KELOMPOK UMUR</th><!--Sasaran Lansia-->
							<th rowspan="3">JML</th>
							<th colspan="4">45-59</th><!--Kunjungan Lansia-->
							<th colspan="4">60-69</th>
							<th colspan="4">>70</th>
							<th rowspan="3">JML</th>					
							<th colspan="3" rowspan="2">KEMANDIRIAN</th>
							<th colspan="2" rowspan="2">GGN ME</th>
							<th colspan="6">IMT</th>
							<th colspan="6">TEKANAN DARAH</th>
							<th colspan="2" rowspan="2">HB KRG</th>
							<th colspan="2" rowspan="2">KOLESTEROL</th>
							<th colspan="2" rowspan="2">DM</th>
							<th colspan="2" rowspan="2">ASAM URAT</th>
							<th colspan="2" rowspan="2">GGN GINJAL</th>
							<th colspan="2" rowspan="2">GGN KOGNITIF</th>
							<th colspan="2" rowspan="2">GGN PENGLIHATAN</th>
							<th colspan="2" rowspan="2">GGN PENDENGARAN</th>
							<th colspan="2" rowspan="2">LAIN LAIN</th>
							<th rowspan="3">DIOBATI</th><!--Pengobatan-->
							<th rowspan="3">DIRUJUK</th>
							<th rowspan="3">B</th><!--Konseling-->
							<th rowspan="3">L</th>
							<th rowspan="3">S</th>
						</tr>
						<tr>
							<th colspan="2">45-59</th><!--Sasaran Lansia-->
							<th colspan="2">60-69</th>
							<th colspan="2">>70</th>
							<th colspan="2">L</th><!--Kunjungan Lansia-->
							<th colspan="2">P</th>
							<th colspan="2">L</th>
							<th colspan="2">P</th>
							<th colspan="2">L</th>
							<th colspan="2">P</th>
							<th colspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px; color: #ff3a3a;">L</th><!--Skrining-->							
							<th colspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px; color: #ff3a3a;">P</th>	
							<th colspan="2">L</th><!--IMT-->
							<th colspan="2">N</th>
							<th colspan="2">K</th>
							<th colspan="2">T</th><!--Tekanan Darah-->
							<th colspan="2">N</th>
							<th colspan="2">R</th>
						</tr>
						<tr>
							<th>L</th><!--Sasaran Lansia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>B</th><!--Kunjungan Lansia-->
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th style="text-align:center;width:1%; border:1px solid #000; padding:3px; color: #ff3a3a;">B</th><!--Skrining-->
							<th style="text-align:center;width:1%; border:1px solid #000; padding:3px; color: #ff3a3a;">L</th>
							<th style="text-align:center;width:1%; border:1px solid #000; padding:3px; color: #ff3a3a;">B</th>
							<th style="text-align:center;width:1%; border:1px solid #000; padding:3px; color: #ff3a3a;">L</th>
							<th>A</th><!--Kemandirian-->
							<th>B</th>
							<th>C</th>
							<th>L</th><!--Ggn.Me-->
							<th>P</th>
							<th>L</th><!--IMT-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Tekanan Darah-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--HbKurang-->
							<th>P</th>
							<th>L</th><!--Kolesterol-->
							<th>P</th>
							<th>L</th><!--DM-->
							<th>P</th>
							<th>L</th><!--Asam Urat-->
							<th>P</th>
							<th>L</th><!--Ggn Ginjal-->
							<th>P</th>
							<th>L</th><!--Ggn.Kognitif-->
							<th>P</th>
							<th>L</th><!--Ggn.Penglihatan-->
							<th>P</th>
							<th>L</th><!--Ggn.Pendengaran-->
							<th>P</th>
							<th>L</th><!--Lain-lain-->
							<th>P</th>
							<th>L</th><!--Jumlah-->
							<th>P</th>
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
							<th>35</th>
							<th>36</th>
							<th>37</th>
							<th>38</th>
							<th>39</th>
							<th>40</th>
							<th>41</th>
							<th>42</th>
							<th>43</th>
							<th>44</th>
							<th>45</th>
							<th>46</th>
							<th>47</th>
							<th>48</th>
							<th>49</th>
							<th>50</th>
							<th>51</th>
							<th>52</th>
							<th>53</th>
							<th>54</th>
							<th>55</th>
							<th>56</th>
							<th>57</th>
							<th>58</th>
							<th>59</th>
							<th>60</th>
							<th>61</th>
							<th>62</th>
							<th>63</th>
							<th>64</th>
							<th>65</th>
							<th>66</th>
							<th>67</th>
							<th>68</th>
							<th>69</th>
							<th>70</th>
							<th>71</th>
							<th>72</th>
							<th>73</th>
							<th>74</th>
							<th>75</th>
							<th>76</th>
							<th>77</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// insert ke tbpasienrj_bulan
						// $strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan'";					
						// $querypasienrj = mysqli_query($koneksi,$strpasienrj);
						// mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan`");
						// while($dt_pasienrj = mysqli_fetch_assoc($querypasienrj)){
						// 	$strpasienrjs = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
						// 	`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
						// 	`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
						// 	`nokartu`,`kdpoli`,`Kir`) VALUES 
						// 	('$dt_pasienrj[TanggalRegistrasi]','$dt_pasienrj[NoRegistrasi]','$dt_pasienrj[NoIndex]','$dt_pasienrj[NoCM]',
						// 	'$dt_pasienrj[NoRM]','$dt_pasienrj[NamaPasien]','$dt_pasienrj[JenisKelamin]','$dt_pasienrj[UmurTahun]','$dt_pasienrj[UmurBulan]',
						// 	'$dt_pasienrj[UmurHari]','$dt_pasienrj[JenisKunjungan]','$dt_pasienrj[AsalPasien]','$dt_pasienrj[StatusPasien]','$dt_pasienrj[PoliPertama]',
						// 	'$dt_pasienrj[Asuransi]','$dt_pasienrj[StatusKunjungan]','$dt_pasienrj[WaktuKunjungan]','$dt_pasienrj[TarifKarcis]','$dt_pasienrj[TarifKir]',
						// 	'$dt_pasienrj[TotalTarif]','$dt_pasienrj[StatusPelayanan]','$dt_pasienrj[StatusPulang]','$dt_pasienrj[NamaPegawaiSimpan]','$dt_pasienrj[NamaPegawaiEdit]',
						// 	'$dt_pasienrj[TanggalEdit]','$dt_pasienrj[NoKunjunganBpjs]','$dt_pasienrj[NoUrutBpjs]','$dt_pasienrj[kdprovider]','$dt_pasienrj[nokartu]',
						// 	'$dt_pasienrj[kdpoli]','$dt_pasienrj[Kir]')";
						// 	mysqli_query($koneksi, $strpasienrjs);
						// }
												
						$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
						$query = mysqli_query($koneksi,$str_kel);
						while($data_kel = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data_kel['Kelurahan'];
							
							// sasaran
							// $sasaran4559_L = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM $tbpasienrj a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.Noregistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan='$kelurahan'"));
							// $sasaran4559_P = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM $tbpasienrj a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.Noregistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan='$kelurahan'"));
							// $sasaran6069_L = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM $tbpasienrj a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.Noregistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan='$kelurahan'"));
							// $sasaran6069_P = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM $tbpasienrj a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.Noregistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan='$kelurahan'"));
							// $sasaran70_L = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM $tbpasienrj a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.Noregistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan='$kelurahan'"));
							// $sasaran70_P = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM $tbpasienrj a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.Noregistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan='$kelurahan'"));
							// $jml_sasaran = $sasaran4559_L + $sasaran4559_P + $sasaran6069_L + $sasaran6069_P + $sasaran70_L +$sasaran70_P;
							
							// kunjungan, jika pasien lansia berobat dalam gedung. Kodenya AsalPasien='10' berati Puskesmas
							$sasaran4559_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='BARU' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran4559_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='LAMA' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran4559_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='BARU' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran4559_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='LAMA' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran6069_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='BARU' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran6069_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='LAMA' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran6069_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='BARU' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran6069_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='LAMA' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran70_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='BARU' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran70_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='LAMA' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran70_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='BARU' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan like '%$kelurahan%';"));
							$sasaran70_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='LAMA' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan like '%$kelurahan%';"));
							$jml_kunjungan = $sasaran4559_L_B['Jml'] + $sasaran4559_L_L['Jml']  + $sasaran4559_P_B['Jml']  + $sasaran4559_P_L['Jml']  + $sasaran6069_L_B['Jml'] 
							+ $sasaran6069_L_L['Jml']  + $sasaran6069_P_B['Jml']  + $sasaran6069_P_L['Jml']  + $sasaran70_L_B['Jml']  + $sasaran70_L_L['Jml']  + $sasaran70_P_B['Jml']  
							+ $sasaran70_P_L['Jml']  ;
							
							// skrining
							$skrining_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND b.StatusKunjungan='BARU' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
							$skrining_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND b.StatusKunjungan='LAMA' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
							$skrining_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND b.StatusKunjungan='BARU' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
							$skrining_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND b.StatusKunjungan='LAMA' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
							
							// kemandirian
							$mandiri_a = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Kemandirian`)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Kemandirian='A' AND b.Kelurahan='$kelurahan';"));
							$mandiri_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Kemandirian`)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Kemandirian='B' AND b.Kelurahan='$kelurahan';"));
							$mandiri_c = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Kemandirian`)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Kemandirian='C' AND b.Kelurahan='$kelurahan';"));
							
							// gangguan mental
							$mental_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`GangguanEmosional`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.GangguanEmosional='YA' AND c.Kelurahan='$kelurahan';"));
							$mental_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`GangguanEmosional`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.GangguanEmosional='YA' AND c.Kelurahan='$kelurahan';"));
							
							// IMT
							$imt_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.StatusImt='L' AND c.Kelurahan='$kelurahan'"));
							$imt_L_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.StatusImt='L' AND c.Kelurahan='$kelurahan'"));
							$imt_N_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.StatusImt='N' AND c.Kelurahan='$kelurahan'"));
							$imt_N_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.StatusImt='N' AND c.Kelurahan='$kelurahan'"));
							$imt_K_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.StatusImt='K' AND c.Kelurahan='$kelurahan'"));
							$imt_K_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.StatusImt='K' AND c.Kelurahan='$kelurahan'"));
							
							// tekanan darah
							$td_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM `$tbpolilansia` a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='L' AND a.StatusTekanandarah='T' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
							$td_L_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM `$tbpolilansia` a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='P' AND a.StatusTekanandarah='T' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
							$td_N_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM `$tbpolilansia` a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='L' AND a.StatusTekanandarah='N' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
							$td_N_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM `$tbpolilansia` a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='P' AND a.StatusTekanandarah='N' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
							$td_K_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM `$tbpolilansia` a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='L' AND a.StatusTekanandarah='R' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
							$td_K_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM `$tbpolilansia` a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='P' AND a.StatusTekanandarah='R' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
							
							// HB Kurang
							$hbkurang_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit = 'Hb Kurang' AND c.Kelurahan='$kelurahan';"));
							$hbkurang_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit = 'Hb Kurang' AND c.Kelurahan='$kelurahan';"));
							
							// Kolesterol
							$kolesterol_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit like '%Kolesterol%' AND c.Kelurahan='$kelurahan';"));
							$kolesterol_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit like '%Kolesterol%' AND c.Kelurahan='$kelurahan';"));
							
							// DM
							$dm_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='E11.0' OR `KodeDiagnosa`='E11.9') AND b.JenisKelamin='L' AND c.Kelurahan='$kelurahan'"));
							$dm_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='E11.0' OR `KodeDiagnosa`='E11.9') AND b.JenisKelamin='P' AND c.Kelurahan='$kelurahan'"));
							
							// Asam Urat
							$asamurat_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit = 'As.Urat Tinggi' AND c.Kelurahan='$kelurahan';"));
							$asamurat_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit = 'As.Urat Tinggi' AND c.Kelurahan='$kelurahan';"));
							
							// Ggn.Ginjal
							$ginjal_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit = 'Ggn.Ginjal' AND c.Kelurahan='$kelurahan';"));
							$ginjal_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit = 'Ggn.Ginjal' AND c.Kelurahan='$kelurahan';"));
							
							// Ggn.Kognitif
							$kognitif_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit like '%Kognitif%' AND c.Kelurahan='$kelurahan';"));
							$kognitif_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit like '%Kognitif%' AND c.Kelurahan='$kelurahan';"));
							
							// Ggn.Penglihatan
							$penglihatan_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H25.0' OR `KodeDiagnosa`='H25.9' OR `KodeDiagnosa`='H26.0' OR `KodeDiagnosa`='H40.0' OR `KodeDiagnosa`='H52.0' OR `KodeDiagnosa`='H52.1' OR `KodeDiagnosa`='H52.6' OR `KodeDiagnosa`='H54.0' OR `KodeDiagnosa`='H57.9') AND b.JenisKelamin='L' AND c.Kelurahan='$kelurahan'"));
							$penglihatan_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H25.0' OR `KodeDiagnosa`='H25.9' OR `KodeDiagnosa`='H26.0' OR `KodeDiagnosa`='H40.0' OR `KodeDiagnosa`='H52.0' OR `KodeDiagnosa`='H52.1' OR `KodeDiagnosa`='H52.6' OR `KodeDiagnosa`='H54.0' OR `KodeDiagnosa`='H57.9') AND b.JenisKelamin='P' AND c.Kelurahan='$kelurahan'"));
							
							// Ggn.Pendengaran
							$pendengaran_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H60.0' OR `KodeDiagnosa`='H65.0' OR `KodeDiagnosa`='H65.9' OR `KodeDiagnosa`='H66.0' OR `KodeDiagnosa`='H66.4' OR `KodeDiagnosa`='H70.0' OR `KodeDiagnosa`='H72.0') AND b.JenisKelamin='L' AND c.Kelurahan='$kelurahan'"));
							$pendengaran_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H60.0' OR `KodeDiagnosa`='H65.0' OR `KodeDiagnosa`='H65.9' OR `KodeDiagnosa`='H66.0' OR `KodeDiagnosa`='H66.4' OR `KodeDiagnosa`='H70.0' OR `KodeDiagnosa`='H72.0') AND b.JenisKelamin='P' AND c.Kelurahan='$kelurahan'"));
							
							// Lainnya
							$lainnya_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit like '%Lain%' AND c.Kelurahan='$kelurahan';"));
							$lainnya_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit like '%Lain%' AND c.Kelurahan='$kelurahan';"));
							
							// Kelainan
							$kelainan_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.Kelainan = 'YA' AND c.Kelurahan='$kelurahan';"));
							$kelainan_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.Kelainan = 'YA' AND c.Kelurahan='$kelurahan';"));
							
							// Pengobatan
							$diobati = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Pengobatan = 'Diobati' AND b.Kelurahan='$kelurahan';"));
							$dirujuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Pengobatan = 'Dirujuk' AND b.Kelurahan='$kelurahan';"));
							
							// konseling
							$konseling_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Konseling = 'B' AND b.Kelurahan='$kelurahan';"));
							$konseling_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Konseling = 'L' AND b.Kelurahan='$kelurahan';"));
							$konseling_s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Konseling = 'S' AND b.Kelurahan='$kelurahan';"));
							
							// Penyuluhan
							$penyuluhan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Penyuluhan = 'YA' AND b.Kelurahan='$kelurahan';"));
							
							// Pemberdayaan
							$pemberdayaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Pemberdayaan = 'YA' AND b.Kelurahan='$kelurahan';"));
							
							// Panti
							$panti = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Panti = 'YA' AND b.Kelurahan='$kelurahan';"));
							
							// Kunj.Rumah
							$kunjunganrumah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `$tbpolilansia` a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.KunjunganRumah = 'YA' AND b.Kelurahan='$kelurahan';"));
							
							?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--Sasaran Lansia--><!--$sasaran4559_L;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--$sasaran4559_P;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--$sasaran6069_L;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--$sasaran6069_P;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--$sasaran70_L;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--$sasaran70_P;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td><!--Jumlah Sasaran Lansia--><!--$jml_sasaran;-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran4559_L_B['Jml'];?></td><!--Kunjungan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran4559_L_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran4559_P_B['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran4559_P_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran6069_L_B['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran6069_L_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran6069_P_B['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran6069_P_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran70_L_B['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran70_L_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran70_P_B['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sasaran70_P_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_kunjungan;?></td><!--Jumlah Kunjungan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $skrining_L_B['Jml'];?></td><!--Skrining-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $skrining_L_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $skrining_P_B['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $skrining_P_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $mandiri_a['Jml'];?></td><!--kemandirian-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $mandiri_b['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $mandiri_c['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $mental_l['Jml'];?></td><!--Gangguan Mental-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $mental_p['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $imt_L_L['Jml'];?></td><!--imt-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $imt_L_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $imt_N_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $imt_N_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $imt_K_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $imt_K_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $td_L_L['Jml'];?></td><!--tekanan darah-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $td_L_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $td_N_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $td_N_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $td_K_L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $td_K_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $hbkurang_L['Jml'];?></td><!--hb krg-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $hbkurang_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kolesterol_L['Jml'];?></td><!--kolesterol-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kolesterol_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dm_L['Jml'];?></td><!--dm-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dm_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $asamurat_L['Jml'];?></td><!--asam urat-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $asamurat_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $ginjal_L['Jml'];?></td><!--gangguan ginjal-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $ginjal_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kognitif_L['Jml'];?></td><!--kognitif-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kognitif_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $penglihatan_L['Jml'];?></td><!--penglihatan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $penglihatan_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $pendengaran_L['Jml'];?></td><!--pendengaran-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $pendengaran_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $lainnya_L['Jml'];?></td><!--lainnya-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $lainnya_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kelainan_L['Jml'];?></td><!--kelainan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kelainan_P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $diobati['Jml'];?></td><!--diobati-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dirujuk['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $konseling_b['Jml'];?></td><!--konseling-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $konseling_l['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $konseling_s['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $penyuluhan['Jml'];?></td><!--penyuluhan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $pemberdayaan['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $panti['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjunganrumah['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo "-";?></td>
							</tr>
						<?php
						$total4559_L_B = $total4559_L_B + $sasaran4559_L_B['Jml'];
						$total4559_L_L = $total4559_L_L + $sasaran4559_L_L['Jml'];
						$total4559_P_B = $total4559_P_B + $sasaran4559_P_B['Jml'];
						$total4559_P_L = $total4559_P_L + $sasaran4559_P_L['Jml'];
						$total6069_L_B = $total6069_L_B + $sasaran6069_L_B['Jml'];
						$total6069_L_L = $total6069_L_L + $sasaran6069_L_L['Jml'];
						$total6069_P_B = $total6069_P_B + $sasaran6069_P_B['Jml'];
						$total6069_P_L = $total6069_P_L + $sasaran6069_P_L['Jml'];
						$total70_L_B = $total70_L_B + $sasaran70_L_B['Jml'];
						$total70_L_L = $total70_L_L + $sasaran70_L_L['Jml'];
						$total70_P_B = $total70_P_B + $sasaran70_P_B['Jml'];
						$total70_P_L = $total70_P_L + $sasaran70_P_L['Jml'];
						$totaljml_kunjungan = $totaljml_kunjungan + $jml_kunjungan;
						// skrining
						$total_skrining_L_B = $total_skrining_L_B + $skrining_L_B['Jml'];
						$total_skrining_L_L = $total_skrining_L_L + $skrining_L_L['Jml'];
						$total_skrining_P_B = $total_skrining_P_B + $skrining_P_B['Jml'];
						$total_skrining_P_L = $total_skrining_P_L + $skrining_P_L['Jml'];
						// kemandirian
						$total_mandiri_a = $total_mandiri_a + $mandiri_a['Jml'];
						$total_mandiri_b = $total_mandiri_b + $mandiri_b['Jml'];
						$total_mandiri_c = $total_mandiri_c + $mandiri_c['Jml'];
						// hangguan mental
						$total_mental_l = $total_mental_l + $mental_l['Jml'];
						$total_mental_p = $total_mental_p + $mental_p['Jml'];
						// imt
						$total_imt_L_L = $total_imt_L_L + $imt_L_L['Jml'];
						$total_imt_L_P = $total_imt_L_P + $imt_L_P['Jml'];
						$total_imt_N_L = $total_imt_N_L + $imt_N_L['Jml'];
						$total_imt_N_P = $total_imt_N_P + $imt_N_P['Jml'];
						$total_imt_K_L = $total_imt_K_L + $imt_K_L['Jml'];
						$total_imt_K_P = $total_imt_K_P + $imt_K_P['Jml'];								
						// tekanan darah		
						$total_td_L_L = $total_td_L_L + $td_L_L['Jml'];
						$total_td_L_P = $total_td_L_P + $td_L_P['Jml'];
						$total_td_N_L = $total_td_N_L + $td_N_L['Jml'];
						$total_td_N_P = $total_td_N_P + $td_N_P['Jml'];
						$total_td_K_L = $total_td_K_L + $td_K_L['Jml'];
						$total_td_K_P = $total_td_K_P + $td_K_P['Jml'];
						// hb krg
						$total_hbkurang_L = $total_hbkurang_L + $hbkurang_L['Jml'];
						$total_hbkurang_P = $total_hbkurang_P + $hbkurang_P['Jml'];
						// kolesterol
						$total_kolesterol_L = $total_kolesterol_L + $kolesterol_L['Jml'];
						$total_kolesterol_P = $total_kolesterol_P + $kolesterol_P['Jml'];	
						// dm		
						$total_dm_L = $total_dm_L + $dm_L['Jml'];
						$total_dm_P = $total_dm_P + $dm_P['Jml'];
						// asam urat
						$total_asamurat_L = $total_asamurat_L + $asamurat_L['Jml'];
						$total_asamurat_P = $total_asamurat_P + $asamurat_P['Jml'];	
						// gangguan ginjal	
						$total_ginjal_L = $total_ginjal_L + $ginjal_L['Jml'];
						$total_ginjal_P = $total_ginjal_P + $ginjal_P['Jml'];	
						// kognitif		
						$total_kognitif_L = $total_kognitif_L + $kognitif_L['Jml'];
						$total_kognitif_P = $total_kognitif_P + $kognitif_P['Jml'];
						// penglihatan	
						$total_penglihatan_L = $total_penglihatan_L + $penglihatan_L['Jml'];
						$total_penglihatan_P = $total_penglihatan_P + $penglihatan_P['Jml'];	
						// pendengaran	
						$total_pendengaran_L = $total_pendengaran_L + $pendengaran_L['Jml'];
						$total_pendengaran_P = $total_pendengaran_P + $pendengaran_P['Jml'];	
						// lainnya		
						$total_lainnya_L = $total_lainnya_L + $lainnya_L['Jml'];
						$total_lainnya_P = $total_lainnya_P + $lainnya_P['Jml'];
						// kelainan
						$total_kelainan_L = $total_kelainan_L + $kelainan_L['Jml'];
						$total_kelainan_P = $total_kelainan_P + $kelainan_P['Jml'];
						// diobati
						$total_diobati = $total_diobati + $diobati['Jml'];
						$total_dirujuk = $total_dirujuk + $dirujuk['Jml'];		
						// konseling	
						$total_konseling_b = $total_konseling_b + $konseling_b['Jml'];
						$total_konseling_l = $total_konseling_l + $konseling_l['Jml'];
						$total_konseling_s = $total_konseling_s + $konseling_s['Jml'];
						// penyuluhan	
						$total_penyuluhan = $total_penyuluhan + $penyuluhan['Jml'];
						$total_pemberdayaan = $total_pemberdayaan + $pemberdayaan['Jml'];
						$total_panti = $total_panti + $panti['Jml'];
						$total_kunjunganrumah = $total_kunjunganrumah + $kunjunganrumah['Jml'];
						}
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="4">TOTAL</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total4559_L_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total4559_L_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total4559_P_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total4559_P_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total6069_L_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total6069_L_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total6069_P_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total6069_P_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total70_L_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total70_L_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total70_P_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total70_P_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $totaljml_kunjungan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_skrining_L_B;?></td><!--skrining-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_skrining_L_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_skrining_P_B;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_skrining_P_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mandiri_a;?></td><!--kemandirian-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mandiri_b;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mandiri_c;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_l;?></td><!--Gangguan Mental-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td><!--imt-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_mental_p;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_td_L_L;?></td><!--tekanan darah-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_td_L_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_td_N_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_td_N_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_td_K_L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_td_K_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_hbkurang_L;?></td><!--hb krg-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_hbkurang_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kolesterol_L;?></td><!--kolesterol-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kolesterol_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_dm_L;?></td><!--dm-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_dm_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_asamurat_L;?></td><!--asam urat-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_asamurat_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_ginjal_L;?></td><!--gangguan ginjal-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_ginjal_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kognitif_L;?></td><!--kognitif-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kognitif_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_penglihatan_L;?></td><!--penglihatan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_penglihatan_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_pendengaran_L;?></td><!--pendengaran-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_pendengaran_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_lainnya_L;?></td><!--lainnya-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_lainnya_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kelainan_L;?></td><!--kelainan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kelainan_P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_diobati;?></td><!--diobati-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_dirujuk;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_konseling_b;?></td><!--konseling-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_konseling_l;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_konseling_s;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_penyuluhan;?></td><!--penyuluhan-->
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_pemberdayaan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_panti;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total_kunjunganrumah;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Kategori Kode Penyakit :</b><br>
					- Diabet Miletus, Kode Diagnosa (E11.0 & E11.9)<br/>
					- Tekanan Darah, Parameter Status Tekanan darah & Kode Diagnosa (I10)<br/>
					- Gangguan Pendengaran, Kode Diagnosa (H60, H65, H65.9, H66, H66.4, H70, H72)<br/>
					- Gangguan Penglihatan, Kode Diagnosa (H25, H25.9, H26, H40, H52, H52.1, H52.6, H54, H57.9)
				</p><br/>
				<table style="font-size:14px; width:100%">
					<?php
						$pralansia = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND `UmurTahun` BETWEEN '45' AND '59'"));
						$lansia = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND `UmurTahun` BETWEEN '60' AND '100'"));
					?>
					<td colspan="2"><b>Data Kunjungan Lansia ke Puskesmas</b></td>
					<tr>
						<td width="10%">Pra Lansia</td>
						<td width="90%"><?php echo ": ".$pralansia?></td>
					</tr>
					<tr>
						<td>Lansia</td>
						<td><?php echo ": ".$lansia?></td>
					</tr>		
				</table>
			</div>
		</div>
	</div><br/>
	
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
</div>	
