<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan P2M Jiwa (".$bulan.'-'.$tahun.").xls");
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
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KESEHATAN JIWA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p>
</div><br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="4">NO.</th>
					<th rowspan="4">KODE</th>
					<th rowspan="4">JENIS PENYAKIT</th>
					<th colspan="36">JUMLAH KASUS PER-GOLONGAN UMUR</th>
				</tr>
				<tr>
					<th colspan="4">1-4Th</th>
					<th colspan="4">5-9Th</th>
					<th colspan="4">10-14Th</th>
					<th colspan="4">15-19Th</th>
					<th colspan="4">20-44Th</th>
					<th colspan="4">45-54Th</th>
					<th colspan="4">55-59Th</th>
					<th colspan="4">60-69Th</th>
					<th colspan="4">>70</th>
				</tr>
				<tr>
					<th colspan="2">B</th><!--1-4Th -->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--5-9Hr-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--10-14Th-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--15-19Th-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--20-44Th-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--45-54Th-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--55-59Th-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--60-69Th-->
					<th colspan="2">L</th>
					<th colspan="2">B</th><!--70Th-->
					<th colspan="2">L</th>
				</tr>
				<tr>
					<th>L</th><!--1-4Th -->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--5-9Hr-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--10-14Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--15-19Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--20-44Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--45-54Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--55-59Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--60-69Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--70Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
				</tr>
			</thead>
			<tbody style="font-size:12px;">
				<?php
				$str = "SELECT * FROM `tbdiagnosajiwa`";
				$str2 = $str." order by `KodeDiagnosa`";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = $data['KodeDiagnosa'];
					$umur14L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur14P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur14L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur14P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur59L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur59P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur59L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur59P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur1014L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur1014P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur1014L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur1014P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur1519L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur1519P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur1519L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur1519P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur2044L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur2044P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur2044L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur2044P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur4554L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur4554P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur4554L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur4554P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur5559L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur5559P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur5559L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur5559P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur6069L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur6069P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur6069L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur6069P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$umur70L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur70P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur70L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$umur70P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
				?>
					<tr>
						<td align="center" width="3%"><?php echo $data['IdDiagnosa'];?></td>
						<td align="center" width="6%"><?php echo $data['KodeDiagnosa'];?></td>
						<td align="left" width="15%"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
						<td align="right"><?php echo $umur14L_B['Jml'];?></td>
						<td align="right"><?php echo $umur14P_B['Jml'];?></td>
						<td align="right"><?php echo $umur14L_L['Jml'];?></td>
						<td align="right"><?php echo $umur14P_L['Jml'];?></td>
						<td align="right"><?php echo $umur59L_B['Jml'];?></td>
						<td align="right"><?php echo $umur59P_B['Jml'];?></td>
						<td align="right"><?php echo $umur59L_L['Jml'];?></td>
						<td align="right"><?php echo $umur59P_L['Jml'];?></td>
						<td align="right"><?php echo $umur1014L_B['Jml'];?></td>
						<td align="right"><?php echo $umur1014P_B['Jml'];?></td>
						<td align="right"><?php echo $umur1014L_L['Jml'];?></td>
						<td align="right"><?php echo $umur1014P_L['Jml'];?></td>
						<td align="right"><?php echo $umur1519L_B['Jml'];?></td>
						<td align="right"><?php echo $umur1519P_B['Jml'];?></td>
						<td align="right"><?php echo $umur1519L_L['Jml'];?></td>
						<td align="right"><?php echo $umur1519P_L['Jml'];?></td>
						<td align="right"><?php echo $umur2044L_B['Jml'];?></td>
						<td align="right"><?php echo $umur2044P_B['Jml'];?></td>
						<td align="right"><?php echo $umur2044L_L['Jml'];?></td>
						<td align="right"><?php echo $umur2044P_L['Jml'];?></td>
						<td align="right"><?php echo $umur4554L_B['Jml'];?></td>
						<td align="right"><?php echo $umur4554P_B['Jml'];?></td>
						<td align="right"><?php echo $umur4554L_L['Jml'];?></td>
						<td align="right"><?php echo $umur4554P_L['Jml'];?></td>
						<td align="right"><?php echo $umur5559L_B['Jml'];?></td>
						<td align="right"><?php echo $umur5559P_B['Jml'];?></td>
						<td align="right"><?php echo $umur5559L_L['Jml'];?></td>
						<td align="right"><?php echo $umur5559P_L['Jml'];?></td>
						<td align="right"><?php echo $umur6069L_B['Jml'];?></td>
						<td align="right"><?php echo $umur6069P_B['Jml'];?></td>
						<td align="right"><?php echo $umur6069L_L['Jml'];?></td>
						<td align="right"><?php echo $umur6069P_L['Jml'];?></td>
						<td align="right"><?php echo $umur70L_B['Jml'];?></td>
						<td align="right"><?php echo $umur70P_B['Jml'];?></td>
						<td align="right"><?php echo $umur70L_L['Jml'];?></td>
						<td align="right"><?php echo $umur70P_L['Jml'];?></td>
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