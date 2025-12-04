<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Bulanan_Lansia_Per-Wilayah (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
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

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN LANSIA (PER-WILAYAH)</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p><br/>
</div><br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="4">No.</th>
					<th rowspan="4">Kel/Desa</th>
					<th rowspan="4">Jml Posy andu</th>
					<th rowspan="4">Jml Panti Wre dha</th>
					<th colspan="7">Sasaran</th>
					<th colspan="13">Jumlah yg dibina / mendapat ply.kesehatan</th>
					<th rowspan ="2" colspan="4">Usia > 60Th yg diskrining kesehatan</th>
					<th colspan="3">Kegiatan Sehari-hari</th>
					<th colspan="32">Jumlah lansia dengan kelainan</th>
					<th rowspan ="3" colspan="2">Jumlah lansia dengan kelainan</th>
					<th colspan="2">Pengobatan</th>
					<th colspan="3">Konseling</th>
					<th rowspan="4">Penyuluhan</th>
					<th rowspan="4">Pem berdayaan Lansia</th>
					<th rowspan="4">Jml Pnt Wredha dbn</th>
					<th rowspan="4">Jml Knj.Rmh</th>
					<th rowspan="4">Strata Posbindu</th>
					<th rowspan="4">Strata Puskesmas</th>
					<th rowspan="4">Ket.</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th colspan="6">Kelompok Umur</th><!--Sasaran Lansia-->
					<th rowspan="3">Jml</th>
					<th colspan="4">45-59</th><!--Kunjungan Lansia-->
					<th colspan="4">60-69</th>
					<th colspan="4">70</th>
					<th rowspan="3">Jml</th>					
					<th colspan="3" rowspan="2">Keman dirian</th>
					<th colspan="2" rowspan="2">Ggn Me</th>
					<th colspan="6">IMT</th>
					<th colspan="6">Tekanan Darah</th>
					<th colspan="2" rowspan="2">HB Krg</th>
					<th colspan="2" rowspan="2">Koles terol</th>
					<th colspan="2" rowspan="2">DM</th>
					<th colspan="2" rowspan="2">Asam Urat</th>
					<th colspan="2" rowspan="2">Ggn Ginjal</th>
					<th colspan="2" rowspan="2">Ggn Kogn itif</th>
					<th colspan="2" rowspan="2">Ggn Pengli hatan</th>
					<th colspan="2" rowspan="2">Ggn Pende ngaran</th>
					<th colspan="2" rowspan="2">Lain lain</th>
					<th rowspan="3">Diobati</th><!--Pengobatan-->
					<th rowspan="3">Dirujuk</th>
					<th rowspan="3">B</th><!--Konseling-->
					<th rowspan="3">L</th>
					<th rowspan="3">S</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th colspan="2">45-59</th><!--Sasaran Lansia-->
					<th colspan="2">60-69</th>
					<th colspan="2">>70</th>
					<th colspan="2">L</th><!--Kunjungan Lansia-->
					<th colspan="2">P</th>
					<th colspan="2">L</th>
					<th colspan="2">P</th>
					<th colspan="2">L</th>
					<th colspan="2">P</th>
					<th colspan="2">L</th><!--Skrining-->							
					<th colspan="2">P</th>	
					<th colspan="2">L</th><!--IMT-->
					<th colspan="2">N</th>
					<th colspan="2">K</th>
					<th colspan="2">T</th><!--Tekanan Darah-->
					<th colspan="2">N</th>
					<th colspan="2">R</th>
				</tr>
				<tr style="border:1px solid #000;">
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
					<th>B</th><!--Skrining-->
					<th>L</th>
					<th>B</th>
					<th>L</th>
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
				<tr style="border:1px solid #000;">
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
			<tbody style="font-size:8px;">
				<?php
				// insert ke tbpasienrj_bulan
				$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";					
				$querypasienrj = mysqli_query($koneksi,$strpasienrj);
				mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan`");
				while($dt_pasienrj = mysqli_fetch_assoc($querypasienrj)){
					$strpasienrjs = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
					`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
					`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
					`nokartu`,`kdpoli`,`Kir`) VALUES 
					('$dt_pasienrj[TanggalRegistrasi]','$dt_pasienrj[NoRegistrasi]','$dt_pasienrj[NoIndex]','$dt_pasienrj[NoCM]',
					'$dt_pasienrj[NoRM]','$dt_pasienrj[NamaPasien]','$dt_pasienrj[JenisKelamin]','$dt_pasienrj[UmurTahun]','$dt_pasienrj[UmurBulan]',
					'$dt_pasienrj[UmurHari]','$dt_pasienrj[JenisKunjungan]','$dt_pasienrj[AsalPasien]','$dt_pasienrj[StatusPasien]','$dt_pasienrj[PoliPertama]',
					'$dt_pasienrj[Asuransi]','$dt_pasienrj[StatusKunjungan]','$dt_pasienrj[WaktuKunjungan]','$dt_pasienrj[TarifKarcis]','$dt_pasienrj[TarifKir]',
					'$dt_pasienrj[TotalTarif]','$dt_pasienrj[StatusPelayanan]','$dt_pasienrj[StatusPulang]','$dt_pasienrj[NamaPegawaiSimpan]','$dt_pasienrj[NamaPegawaiEdit]',
					'$dt_pasienrj[TanggalEdit]','$dt_pasienrj[NoKunjunganBpjs]','$dt_pasienrj[NoUrutBpjs]','$dt_pasienrj[kdprovider]','$dt_pasienrj[nokartu]',
					'$dt_pasienrj[kdpoli]','$dt_pasienrj[Kir]')";
					mysqli_query($koneksi, $strpasienrjs);
				}
				
				$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
				$query = mysqli_query($koneksi,$str_kel);
				while($data_kel = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kelurahan = $data_kel['Kelurahan'];
					
					// kunjungan, jika pasien lansia berobat dalam gedung. Kodenya AsalPasien='10' berati Puskesmas.
					$sasaran4559_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='BARU' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan='$kelurahan';"));
					$sasaran4559_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='LAMA' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan='$kelurahan';"));
					$sasaran4559_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='BARU' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan='$kelurahan';"));
					$sasaran4559_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='LAMA' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '45' AND '59' AND b.Kelurahan='$kelurahan';"));
					$sasaran6069_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='BARU' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan='$kelurahan';"));
					$sasaran6069_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='LAMA' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan='$kelurahan';"));
					$sasaran6069_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='BARU' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan='$kelurahan';"));
					$sasaran6069_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='LAMA' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '60' AND '69' AND b.Kelurahan='$kelurahan';"));
					$sasaran70_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='BARU' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan='$kelurahan';"));
					$sasaran70_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='L' AND a.StatusKunjungan='LAMA' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan='$kelurahan';"));
					$sasaran70_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='BARU' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan='$kelurahan';"));
					$sasaran70_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM `tbpasienrj_bulan` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.JenisKelamin='P' AND a.StatusKunjungan='LAMA' AND a.AsalPasien='10' AND a.UmurTahun BETWEEN '70' AND '100' AND b.Kelurahan='$kelurahan';"));
					$jml_kunjungan = $sasaran4559_L_B['Jml'] + $sasaran4559_L_L['Jml']  + $sasaran4559_P_B['Jml']  + $sasaran4559_P_L['Jml']  + $sasaran6069_L_B['Jml'] 
					+ $sasaran6069_L_L['Jml']  + $sasaran6069_P_B['Jml']  + $sasaran6069_P_L['Jml']  + $sasaran70_L_B['Jml']  + $sasaran70_L_L['Jml']  + $sasaran70_P_B['Jml']  
					+ $sasaran70_P_L['Jml']  ;
					
					// skrining
					$skrining_L_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND b.StatusKunjungan='BARU' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
					$skrining_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND b.StatusKunjungan='LAMA' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
					$skrining_P_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND b.StatusKunjungan='BARU' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
					$skrining_P_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Skrining`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND b.StatusKunjungan='LAMA' AND a.Skrining='YA' AND c.Kelurahan='$kelurahan';"));
					
					// kemandirian
					$mandiri_a = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Kemandirian`)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Kemandirian='A' AND b.Kelurahan='$kelurahan';"));
					$mandiri_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Kemandirian`)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Kemandirian='B' AND b.Kelurahan='$kelurahan';"));
					$mandiri_c = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`Kemandirian`)AS Jml FROM `$tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Kemandirian='C' AND b.Kelurahan='$kelurahan';"));
					
					// gangguan mental
					$mental_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`GangguanEmosional`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.GangguanEmosional='YA' AND c.Kelurahan='$kelurahan';"));
					$mental_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`GangguanEmosional`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.GangguanEmosional='YA' AND c.Kelurahan='$kelurahan';"));
					
					// IMT
					$imt_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.StatusImt='L' AND c.Kelurahan='$kelurahan'"));
					$imt_L_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.StatusImt='L' AND c.Kelurahan='$kelurahan'"));
					$imt_N_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.StatusImt='N' AND c.Kelurahan='$kelurahan'"));
					$imt_N_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.StatusImt='N' AND c.Kelurahan='$kelurahan'"));
					$imt_K_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.StatusImt='K' AND c.Kelurahan='$kelurahan'"));
					$imt_K_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusImt`)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.StatusImt='K' AND c.Kelurahan='$kelurahan'"));
					
					// tekanan darah
					$td_L_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM $tbpolilansia a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='L' AND a.StatusTekanandarah='T' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
					$td_L_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM $tbpolilansia a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='P' AND a.StatusTekanandarah='T' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
					$td_N_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM $tbpolilansia a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='L' AND a.StatusTekanandarah='N' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
					$td_N_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM $tbpolilansia a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='P' AND a.StatusTekanandarah='N' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
					$td_K_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM $tbpolilansia a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='L' AND a.StatusTekanandarah='R' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
					$td_K_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`StatusTekananDarah`)AS Jml FROM $tbpolilansia a JOIN $tbdiagnosapasien b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.JenisKelamin='P' AND a.StatusTekanandarah='R' AND b.KodeDiagnosa='I10' AND c.Kelurahan='$kelurahan'"));
					
					// HB Kurang
					$hbkurang_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit = 'Hb Kurang' AND c.Kelurahan='$kelurahan';"));
					$hbkurang_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit = 'Hb Kurang' AND c.Kelurahan='$kelurahan';"));
					
					// Kolesterol
					$kolesterol_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit like '%Kolesterol%' AND c.Kelurahan='$kelurahan';"));
					$kolesterol_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit like '%Kolesterol%' AND c.Kelurahan='$kelurahan';"));
					
					// DM
					$dm_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN tbpasienrj_bulan b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='E11.0' OR `KodeDiagnosa`='E11.9') AND b.JenisKelamin='L' AND c.Kelurahan='$kelurahan'"));
					$dm_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN tbpasienrj_bulan b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='E11.0' OR `KodeDiagnosa`='E11.9') AND b.JenisKelamin='P' AND c.Kelurahan='$kelurahan'"));
					
					// Asam Urat
					$asamurat_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit = 'As.Urat Tinggi' AND c.Kelurahan='$kelurahan';"));
					$asamurat_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit = 'As.Urat Tinggi' AND c.Kelurahan='$kelurahan';"));
					
					// Ggn.Ginjal
					$ginjal_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit = 'Ggn.Ginjal' AND c.Kelurahan='$kelurahan';"));
					$ginjal_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit = 'Ggn.Ginjal' AND c.Kelurahan='$kelurahan';"));
					
					// Ggn.Kognitif
					$kognitif_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit like '%Kognitif%' AND c.Kelurahan='$kelurahan';"));
					$kognitif_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit like '%Kognitif%' AND c.Kelurahan='$kelurahan';"));
					
					// Ggn.Penglihatan
					$penglihatan_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN tbpasienrj_bulan b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H25.0' OR `KodeDiagnosa`='H25.9' OR `KodeDiagnosa`='H26.0' OR `KodeDiagnosa`='H40.0' OR `KodeDiagnosa`='H52.0' OR `KodeDiagnosa`='H52.1' OR `KodeDiagnosa`='H52.6' OR `KodeDiagnosa`='H54.0' OR `KodeDiagnosa`='H57.9') AND b.JenisKelamin='L' AND c.Kelurahan='$kelurahan'"));
					$penglihatan_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN tbpasienrj_bulan b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H25.0' OR `KodeDiagnosa`='H25.9' OR `KodeDiagnosa`='H26.0' OR `KodeDiagnosa`='H40.0' OR `KodeDiagnosa`='H52.0' OR `KodeDiagnosa`='H52.1' OR `KodeDiagnosa`='H52.6' OR `KodeDiagnosa`='H54.0' OR `KodeDiagnosa`='H57.9') AND b.JenisKelamin='P' AND c.Kelurahan='$kelurahan'"));
					
					// Ggn.Pendengaran
					$pendengaran_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN tbpasienrj_bulan b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H60.0' OR `KodeDiagnosa`='H65.0' OR `KodeDiagnosa`='H65.9' OR `KodeDiagnosa`='H66.0' OR `KodeDiagnosa`='H66.4' OR `KodeDiagnosa`='H70.0' OR `KodeDiagnosa`='H72.0') AND b.JenisKelamin='L' AND c.Kelurahan='$kelurahan'"));
					$pendengaran_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS Jml FROM `$tbdiagnosapasien` a JOIN tbpasienrj_bulan b ON a.NoRegistrasi = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' AND MONTH(a.TanggalDiagnosa)='$bulan' AND (`KodeDiagnosa`='H60.0' OR `KodeDiagnosa`='H65.0' OR `KodeDiagnosa`='H65.9' OR `KodeDiagnosa`='H66.0' OR `KodeDiagnosa`='H66.4' OR `KodeDiagnosa`='H70.0' OR `KodeDiagnosa`='H72.0') AND b.JenisKelamin='P' AND c.Kelurahan='$kelurahan'"));
					
					// Lainnya
					$lainnya_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.RiwayatPenyakit like '%Lain%' AND c.Kelurahan='$kelurahan';"));
					$lainnya_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.RiwayatPenyakit like '%Lain%' AND c.Kelurahan='$kelurahan';"));
					
					// Kelainan
					$kelainan_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='L' AND a.Kelainan = 'YA' AND c.Kelurahan='$kelurahan';"));
					$kelainan_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN tbpasienrj_bulan b ON a.NoPemeriksaan = b.NoRegistrasi JOIN $tbkk c ON a.NoIndex = c.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND b.JenisKelamin='P' AND a.Kelainan = 'YA' AND c.Kelurahan='$kelurahan';"));
					
					// Pengobatan
					$diobati = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Pengobatan = 'Diobati' AND b.Kelurahan='$kelurahan';"));
					$dirujuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Pengobatan = 'Dirujuk' AND b.Kelurahan='$kelurahan';"));
					
					// konseling
					$konseling_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Konseling = 'B' AND b.Kelurahan='$kelurahan';"));
					$konseling_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Konseling = 'L' AND b.Kelurahan='$kelurahan';"));
					$konseling_s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Konseling = 'S' AND b.Kelurahan='$kelurahan';"));
					
					// Penyuluhan
					$penyuluhan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Penyuluhan = 'YA' AND b.Kelurahan='$kelurahan';"));
					
					// Pemberdayaan
					$pemberdayaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Pemberdayaan = 'YA' AND b.Kelurahan='$kelurahan';"));
					
					// Panti
					$panti = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.Panti = 'YA' AND b.Kelurahan='$kelurahan';"));
					
					// Kunj.Rumah
					$kunjunganrumah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*)AS Jml FROM $tbpolilansia a JOIN $tbkk b ON a.NoIndex = b.NoIndex WHERE SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' AND YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND a.KunjunganRumah = 'YA' AND b.Kelurahan='$kelurahan';"));
					
					?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $kelurahan;?></td>
						<td><?php echo "-";?></td>
						<td><?php echo "-";?></td>
						<td><?php echo "-";?></td><!--Sasaran Lansia--><!--$sasaran4559_L;-->
						<td><?php echo "-";?></td><!--$sasaran4559_P;-->
						<td><?php echo "-";?></td><!--$sasaran6069_L;-->
						<td><?php echo "-";?></td><!--$sasaran6069_P;-->
						<td><?php echo "-";?></td><!--$sasaran70_L;-->
						<td><?php echo "-";?></td><!--$sasaran70_P;-->
						<td><?php echo "-";?></td><!--Jumlah Sasaran Lansia--><!--$jml_sasaran;-->
						<td><?php echo $sasaran4559_L_B['Jml'];?></td><!--Kunjungan-->
						<td><?php echo $sasaran4559_L_L['Jml'];?></td>
						<td><?php echo $sasaran4559_P_B['Jml'];?></td>
						<td><?php echo $sasaran4559_P_L['Jml'];?></td>
						<td><?php echo $sasaran6069_L_B['Jml'];?></td>
						<td><?php echo $sasaran6069_L_L['Jml'];?></td>
						<td><?php echo $sasaran6069_P_B['Jml'];?></td>
						<td><?php echo $sasaran6069_P_L['Jml'];?></td>
						<td><?php echo $sasaran70_L_B['Jml'];?></td>
						<td><?php echo $sasaran70_L_L['Jml'];?></td>
						<td><?php echo $sasaran70_P_B['Jml'];?></td>
						<td><?php echo $sasaran70_P_L['Jml'];?></td>
						<td><?php echo $jml_kunjungan;;?></td><!--Jumlah Kunjungan-->
						<td><?php echo $skrining_L_B['Jml'];?></td><!--Skrining-->
						<td><?php echo $skrining_L_L['Jml'];?></td>
						<td><?php echo $skrining_P_B['Jml'];?></td>
						<td><?php echo $skrining_P_L['Jml'];?></td>
						<td><?php echo $mandiri_a['Jml'];?></td>
						<td><?php echo $mandiri_b['Jml'];?></td>
						<td><?php echo $mandiri_c['Jml'];?></td>
						<td><?php echo $mental_l['Jml'];?></td>
						<td><?php echo $mental_p['Jml'];?></td>
						<td><?php echo $imt_L_L['Jml'];?></td>
						<td><?php echo $imt_L_P['Jml'];?></td>
						<td><?php echo $imt_N_L['Jml'];?></td>
						<td><?php echo $imt_N_P['Jml'];?></td>
						<td><?php echo $imt_K_L['Jml'];?></td>
						<td><?php echo $imt_K_P['Jml'];?></td>
						<td><?php echo $td_L_L['Jml'];?></td>
						<td><?php echo $td_L_P['Jml'];?></td>
						<td><?php echo $td_N_L['Jml'];?></td>
						<td><?php echo $td_N_P['Jml'];?></td>
						<td><?php echo $td_K_L['Jml'];?></td>
						<td><?php echo $td_K_P['Jml'];?></td>
						<td><?php echo $hbkurang_L['Jml'];?></td>
						<td><?php echo $hbkurang_P['Jml'];?></td>
						<td><?php echo $kolesterol_L['Jml'];?></td>
						<td><?php echo $kolesterol_P['Jml'];?></td>
						<td><?php echo $dm_L['Jml'];?></td>
						<td><?php echo $dm_P['Jml'];?></td>
						<td><?php echo $asamurat_L['Jml'];?></td>
						<td><?php echo $asamurat_P['Jml'];?></td>
						<td><?php echo $ginjal_L['Jml'];?></td>
						<td><?php echo $ginjal_P['Jml'];?></td>
						<td><?php echo $kognitif_L['Jml'];?></td>
						<td><?php echo $kognitif_P['Jml'];?></td>
						<td><?php echo $penglihatan_L['Jml'];?></td>
						<td><?php echo $penglihatan_P['Jml'];?></td>
						<td><?php echo $pendengaran_L['Jml'];?></td>
						<td><?php echo $pendengaran_P['Jml'];?></td>
						<td><?php echo $lainnya_L['Jml'];?></td>
						<td><?php echo $lainnya_P['Jml'];?></td>
						<td><?php echo $kelainan_L['Jml'];?></td>
						<td><?php echo $kelainan_P['Jml'];?></td>
						<td><?php echo $diobati['Jml'];?></td>
						<td><?php echo $dirujuk['Jml'];?></td>
						<td><?php echo $konseling_b['Jml'];?></td>
						<td><?php echo $konseling_l['Jml'];?></td>
						<td><?php echo $konseling_s['Jml'];?></td>
						<td><?php echo $penyuluhan['Jml'];?></td>
						<td><?php echo $pemberdayaan['Jml'];?></td>
						<td><?php echo $panti['Jml'];?></td>
						<td><?php echo $kunjunganrumah['Jml'];?></td>
						<td><?php echo "-";?></td>
						<td><?php echo "-";?></td>
						<td><?php echo "-";?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>