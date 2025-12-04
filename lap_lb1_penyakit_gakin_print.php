<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	date_default_timezone_set('Asia/Jakarta');
?>
<html>
<head>
	<title>Laporan LB1 - Penyakit (Gakin)</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
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
	font-size:16px;
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
</head>
<body onload="window.print()">
<a href="javascript:print()" class="btnprint btn btn-primary pull-right noprint">Print</a>
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$keydate1 = $_GET['keydate1'];
$keydate2 = $_GET['keydate2'];
$opsiform = $_GET['opsiform'];

if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
?>
<!--tabel report-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpuskesmas'"));
	$kota = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota'"));
	?>
	<?php 
	if($_SESSION['kodepuskesmas'] == '-'){
	?>
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$_SESSION['kota'];?></b></h4>
		<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
		<p style="margin:5px; font-size:12px;"><?php echo $_SESSION['alamat'];?></p>
	<?php
	}else{
	?>
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
		<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
		<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
		<p style="margin:5px; font-size:12px;"><?php echo $datapuskesmas['Alamat']?></p>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1 - PENYAKIT (GAKIN)</b></h4>
	<p style="margin:1px;">Periode Laporan: 
		<?php 
		if($opsiform == 'tanggal'){
			echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
		}else{
			echo nama_bulan($bulan)." ".$tahun;
		}
		?>
	</p>
	<br/>
</div>
<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table style="font-size:12px; width:300px;">
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
		<table style="font-size:12px; width:300px;">
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
		<table class="table table-condensed">
			<thead style="font-size:9.5px;">
				<tr>
					<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
					<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
					<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Penyakit</th>
					<th colspan="24" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah Kasus Baru Menurut Golongan Umur</th>
					<th rowspan="2"  colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kasus Baru</th>
					<th rowspan="2"  colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kasus Lama</th>
					<th rowspan="3" colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Total Kasus</th>
				</tr>
				<tr>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">0-7Hr</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">8-30Hr</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;"><1Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">1-4Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">5-9Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">10-14Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">15-19Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">20-44Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">45-54Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">55-59Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">60-69Th</th>
					<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">>=70Th</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--0-7Hr-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--8-30Hr-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--<1Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--1-4Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--5-9Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--10-14Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--15-19Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--20-24Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--45-54Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--55-59Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--60-69Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--70Th-->
					<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th rowspan="2" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--Kasus Baru-->
					<th rowspan="2" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th rowspan="2" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Jml</th>
					<th rowspan="2" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">L</th><!--Kasus Lama-->
					<th rowspan="2" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">P</th>
					<th rowspan="2" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Jml</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php	
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
					$tbpasienrj = 'tbpasienrj_'.$bulan;
					$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
				}else{
					$waktu1 = "TanggalRegistrasi >= '$keydate1'";
					$waktu2 = "TanggalRegistrasi <= '$keydate2'";
					$tbpasienrj_1 = 'tbpasienrj_'.date('m',strtotime($keydate1));
					$tbpasienrj_2 = 'tbpasienrj_'.date('m',strtotime($keydate2));
					$tbdiagnosapasien_1 = 'tbdiagnosapasien_'.date('m',strtotime($keydate1));
					$tbdiagnosapasien_2 = 'tbdiagnosapasien_'.date('m',strtotime($keydate2));
				}
				
				$str = "SELECT * FROM `tbdiagnosa`";
				$str2 = $str."order by `KodeDiagnosa` ASC";
				$query = mysqli_query($koneksi,$str2);
				
				$no = 0;
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kodedgs = $data['KodeDiagnosaBPJS'];
				
				if($opsiform == 'bulan'){
					$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
				
					// kasus lama
					$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$t_lama_l = $lama_l['Jml'];
					$t_lama_p = $lama_p['Jml'];
					$total_lama = $t_lama_l + $t_lama_p;
				}else{
					// umur17hr
					$umur17hrL_1= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur17hrL_2= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur17hrL['Jml']= $umur17hrL_1['Jml'] + $umur17hrL_2['Jml'];
					$umur17hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur17hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur17hrP['Jml']= $umur17hrP_1['Jml'] + $umur17hrP_2['Jml'];
					// umur1830hr
					$umur1830hrL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1830hrL['Jml']= $umur1830hrL_1['Jml'] + $umur1830hrL_2['Jml'];
					$umur1830hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1830hrP['Jml']= $umur1830hrP_1['Jml'] + $umur1830hrP_2['Jml'];	
					// umur12bln
					$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
					$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
					// umur12bln
					$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
					$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
					// umur14th
					$umur14L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur14L['Jml']= $umur14L_1['Jml'] + $umur14L_2['Jml'];
					$umur14P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur14P['Jml']= $umur14P_1['Jml'] + $umur14P_2['Jml'];
					// umur59th
					$umur59L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur59L['Jml']= $umur59L_1['Jml'] + $umur59L_2['Jml'];
					$umur59P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur59P['Jml']= $umur59P_1['Jml'] + $umur59P_2['Jml'];
					// umur1014th
					$umur1014L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1014L['Jml']= $umur1014L_1['Jml'] + $umur1014L_2['Jml'];
					$umur1014P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1014P['Jml']= $umur1014P_1['Jml'] + $umur1014P_2['Jml'];
					// umur1519th
					$umur1519L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1519L['Jml']= $umur1519L_1['Jml'] + $umur1519L_2['Jml'];
					$umur1519P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1519P['Jml']= $umur1519P_1['Jml'] + $umur1519P_2['Jml'];
					// umur2044th
					$umur2044L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur2044L['Jml']= $umur2044L_1['Jml'] + $umur2044L_2['Jml'];
					$umur2044P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur2044P['Jml']= $umur2044P_1['Jml'] + $umur2044P_2['Jml'];
					// umur4554th
					$umur4554L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur4554L['Jml']= $umur4554L_1['Jml'] + $umur4554L_2['Jml'];
					$umur4554P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur4554P['Jml']= $umur4554P_1['Jml'] + $umur4554P_2['Jml'];
					// umur5559th
					$umur5559L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur5559L['Jml']= $umur5559L_1['Jml'] + $umur5559L_2['Jml'];
					$umur5559P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur5559P['Jml']= $umur5559P_1['Jml'] + $umur5559P_2['Jml'];
					// umur6069th
					$umur6069L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur6069L['Jml']= $umur6069L_1['Jml'] + $umur6069L_2['Jml'];
					$umur6069P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur6069P['Jml']= $umur6069P_1['Jml'] + $umur6069P_2['Jml'];
					// umur70100th
					$umur70100L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur70100L['Jml']= $umur70100L_1['Jml'] + $umur70100L_2['Jml'];
					$umur70100P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur70100P['Jml']= $umur70100P_1['Jml'] + $umur70100P_2['Jml'];
					// kasus lama
					$lama_l1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$lama_l2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
						$lama_l['Jml'] = $lama_l1['Jml'] + $lama_l2['Jml'];
					$lama_p1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$lama_p2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
						$lama_p['Jml'] = $lama_p1['Jml'] + $lama_p2['Jml'];
					$t_lama_l = $lama_l['Jml'];
					$t_lama_p = $lama_p['Jml'];
					$total_lama = $t_lama_l + $t_lama_p;
				}	
					// kasus baru
					$baru_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
						+ $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
						+ $umur6069L['Jml'] + $umur70100L['Jml'];
					$baru_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
						+ $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
						+ $umur6069P['Jml'] + $umur70100P['Jml'];
					$total_baru = $baru_l+ $baru_p;
					$total = $total_baru + $total_lama;
					
				?>
					<tr style="border:1px dashed #000;">
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur70100L['Jml'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $umur70100P['Jml'];?></td>
						<!--kasus baru-->
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $baru_l;?></td>
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $baru_p;?></td>
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $total_baru;?></td>
						<!--kasus lama-->
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $lama_l['Jml'];?></td>
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $lama_p['Jml'];?></td>
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $total_lama;?></td>
						<!--total kasus baru + lama-->
						<td style="text-align:right;border:1px dashed #000; padding:3px;"><?php echo $total;?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>