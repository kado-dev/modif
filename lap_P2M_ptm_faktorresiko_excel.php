<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan PTM (Faktor Resiko) (".$hariini.").xls");
	if(isset($tahun)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PTM (FAKTOR RESIKO)</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p></p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="3" width="3%">NO.</th>
					<th rowspan="3" width="15%">PENYAKIT TIDAK MENULAR</th>
					<th colspan="14" width="60%">JENIS KELAMIN DAN UMUR (TH)</th>
					<th rowspan="3" width="5%">TOTAL</th>
				</tr>
				<tr>
					<th colspan="7" width="50%">LAKI (L)</th>
					<th colspan="7" width="50%">PEREMPUAN (P)</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th width="3%"><18</th><!--15-->
					<th width="3%">18-44</th><!--15-19-->
					<th width="3%">45-54</th><!--45-54-->
					<th width="3%">55-59</th><!--55-59-->
					<th width="3%">60-69</th><!--60-69-->
					<th width="3%">>70</th><!--70-->
					<th width="3%">JML</th>
					<th width="3%"><18</th><!--15-->
					<th width="3%">18-44</th><!--15-19-->
					<th width="3%">45-54</th><!--45-54-->
					<th width="3%">55-59</th><!--55-59-->
					<th width="3%">60-69</th><!--60-69-->
					<th width="3%">>70</th><!--70-->
					<th width="3%">JML</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$str = "SELECT * FROM `tbdiagnosaptmfaktorresiko`";
				$str2 = $str." ORDER BY `IdFaktor`";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$jml = 0;
					if($data['Kelompok'] == 'Merokok'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Merokok%'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Merokok%'"));
					}elseif($data['Kelompok'] == 'Aktivitas Fisik'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Aktifitas Fisik%'"));
					}elseif($data['Kelompok'] == 'Makan Sayur'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Makan Sayur & Buah%'"));
					}elseif($data['Kelompok'] == 'Minum Alkohol'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `PemeriksaanPenunjang` like '%Minum Alkohol%'"));
					}elseif($data['Kelompok'] == 'Berat Badan'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `StatusImt` = 'L'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `StatusImt` = 'L'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `StatusImt` = 'L'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `StatusImt` = 'L'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `StatusImt` = 'L'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `StatusImt` = 'L'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `StatusImt` = 'L'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `StatusImt` = 'L'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `StatusImt` = 'L'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `StatusImt` = 'L'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `StatusImt` = 'L'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `StatusImt` = 'L'"));
					}elseif($data['Kelompok'] == 'Obesitas'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `Imt` > '27'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `Imt` > '27'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `Imt` > '27'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `Imt` > '27'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `Imt` > '27'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `Imt` > '27'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `Imt` > '27'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `Imt` > '27'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `Imt` > '27'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `Imt` > '27'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `Imt` > '27'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `Imt` > '27'"));
					}elseif($data['Kelompok'] == 'Obesitas Sentral'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `LingkarPerut` >= '90'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `LingkarPerut` >= '90'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `LingkarPerut` >= '90'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `LingkarPerut` >= '90'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `LingkarPerut` >= '90'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `LingkarPerut` >= '90'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `LingkarPerut` >= '80'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `LingkarPerut` >= '80'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `LingkarPerut` >= '80'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `LingkarPerut` >= '80'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `LingkarPerut` >= '80'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `LingkarPerut` >= '80'"));
					}elseif($data['Kelompok'] == 'Gula Darah'){
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `GdsLab` > '200'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `GdsLab` > '200'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `GdsLab` > '200'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `GdsLab` > '200'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `GdsLab` > '200'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `GdsLab` > '200'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `GdsLab` > '200'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `GdsLab` > '200'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `GdsLab` > '200'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `GdsLab` > '200'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `GdsLab` > '200'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `GdsLab` > '200'"));
					}elseif($data['Kelompok'] == 'Kolesterol'){		
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `KolesLab` >= '190'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `KolesLab` >= '190'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `KolesLab` >= '190'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `KolesLab` >= '190'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `KolesLab` >= '190'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `KolesLab` >= '190'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `KolesLab` >= '190'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `KolesLab` >= '190'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `KolesLab` >= '190'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `KolesLab` >= '190'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `KolesLab` >= '190'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `KolesLab` >= '190'"));
					}elseif($data['Kelompok'] == 'Trigliserida'){
						// laki
						$umur_1_17_L = '0';
						$umur_18_44_L = '0';
						$umur_45_54_L = '0';
						$umur_55_59_L = '0';
						$umur_60_69_L = '0';
						$umur_70L = '0';
						// perempuan
						$umur_1_17_P = '0';
						$umur_18_44_P = '0';
						$umur_45_54_P = '0';
						$umur_55_59_P = '0';
						$umur_60_69_P = '0';
						$umur_70P = '0';
					}elseif($data['Kelompok'] == 'Hipertensi'){	
						// laki
						$umur_1_17_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '17' AND `Sistole` >= '140'"));
						$umur_18_44_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '18' AND '44' AND `Sistole` >= '140'"));
						$umur_45_54_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `Sistole` >= '140'"));
						$umur_55_59_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '59' AND `Sistole` >= '140'"));
						$umur_60_69_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '60' AND '69' AND `Sistole` >= '140'"));
						$umur_70L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='L' AND `UmurTahun` Between '70' AND '100' AND `Sistole` >= '140'"));
						// perempuan
						$umur_1_17_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '17' AND `Sistole` >= '140'"));
						$umur_18_44_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '18' AND '44' AND `Sistole` >= '140'"));
						$umur_45_54_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `Sistole` >= '140'"));
						$umur_55_59_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '59' AND `Sistole` >= '140'"));
						$umur_60_69_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '60' AND '69' AND `Sistole` >= '140'"));
						$umur_70P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan)AS Jml FROM `tbpolilansia` WHERE MONTH(TanggalPeriksa)='$bulan' and YEAR(TanggalPeriksa)='$tahun' and SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' and `JenisKelamin`='P' AND `UmurTahun` Between '70' AND '100' AND `Sistole` >= '140'"));
					}	
					// jumlah
					$jumlah_L = $umur_1_17_L['Jml'] + $umur_18_44_L['Jml'] + $umur_45_54_L['Jml'] + $umur_55_59_L['Jml'] + $umur_60_69_L['Jml'] + $umur_70L['Jml'];
					$jumlah_P = $umur_1_17_P['Jml'] + $umur_18_44_P['Jml'] + $umur_45_54_P['Jml'] + $umur_55_59_P['Jml'] + $umur_60_69_P['Jml'] + $umur_70P['Jml'];
					// total
					$total = $jumlah_L + $jumlah_P;	
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="left"><?php echo $data['FaktorResiko'];?></td>
						<td align="right"><?php echo $umur_1_17_L['Jml'];?></td><!--laki-->
						<td align="right"><?php echo $umur_18_44_L['Jml'];?></td>
						<td align="right"><?php echo $umur_45_54_L['Jml'];?></td>
						<td align="right"><?php echo $umur_55_59_L['Jml'];?></td>
						<td align="right"><?php echo $umur_60_69_L['Jml'];?></td>
						<td align="right"><?php echo $umur_70L['Jml'];?></td>
						<td align="right"><?php echo $jumlah_L;?></td>
						<td align="right"><?php echo $umur_1_17_P['Jml'];?></td><!--perempuan-->
						<td align="right"><?php echo $umur_18_44_P['Jml'];?></td>
						<td align="right"><?php echo $umur_45_54_P['Jml'];?></td>
						<td align="right"><?php echo $umur_55_59_P['Jml'];?></td>
						<td align="right"><?php echo $umur_60_69_P['Jml'];?></td>
						<td align="right"><?php echo $umur_70P['Jml'];?></td>
						<td align="right"><?php echo $jumlah_P;?></td>
						<td align="right"><?php echo $total;?></td>
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