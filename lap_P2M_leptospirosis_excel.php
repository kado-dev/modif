<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];		
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Leptospirosis (".$bulan.'-'.$tahun.").xls");
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
	<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:1px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN LEPTOSPIROSIS</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:100%; margin-top:0px;">
		<table style="font-size:12px; width:300px;">
			<tr>
				<td>Kode Puskesmas</td>
				<td>:</td>
				<td><?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td>Puskesmas</td>
				<td>:</td>
				<td><?php echo $namapuskesmas;?></td>
			</tr>
			<tr>
				<td>Kelurahan/Desa</td>
				<td>:</td>
				<td><?php echo strtoupper($kelurahan);?></td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td><?php echo strtoupper($kecamatan);?></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9.5px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="4">No.</th>
					<th rowspan="4">Kode</th>
					<th rowspan="4">Jenis Penyakit</th>
					<th colspan="24">Jumlah Kasus Per-Golongan Umur</th>
				</tr>
				<tr style="border:1px dashed #000">
					<th colspan="4">15-19Th</th>
					<th colspan="4">20-44Th</th>
					<th colspan="4">45-54Th</th>
					<th colspan="4">55-59Th</th>
					<th colspan="4">60-69Th</th>
					<th colspan="4">>70</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th colspan="2">B</th><!--15-19Hr-->
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
				<tr style="border:1px dashed #000;">
					<th>L</th><!--15-19Hr-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--20-44Th-->
					<th>P</th>
					<th>L</th>
					<th>P</th>
					<th>L</th><!--45-54Thh-->
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
			<tbody style="font-size:10px;">
				<?php
				// insert ke tbdiagnosapasien_bulan
				$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalDiagnosa`)='$tahun'";
				$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
				mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
				while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
					$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
					('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
					mysqli_query($koneksi, $strdiagnosa);
				}
				
				$str = "SELECT * FROM `tbdiagnosalestospirosis`";
				$str2 = $str." order by `KodeDiagnosa`";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = $data['KodeDiagnosa'];
					// 15-19Th
					$umur1519L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur1519P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur1519L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur1519P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					// 20-44Th
					$umur2044L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur2044P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur2044L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur2044P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					// 45-54Th
					$umur4554L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur4554P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur4554L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur4554P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					// 55-59Th
					$umur5559L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur5559P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur5559L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur5559P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					// 60-69Th
					$umur6069L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur6069P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur6069L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur6069P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
					// 70Th
					$umur70L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur70P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur70L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
					$umur70P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				?>	
					<tr style="border:1px dashed #000;">
						<td><?php echo $data['IdDiagnosa'];?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo $umur1519L_B['Jml'];?></td>
						<td><?php echo $umur1519P_B['Jml'];?></td>
						<td><?php echo $umur1519L_L['Jml'];?></td>
						<td><?php echo $umur1519P_L['Jml'];?></td>
						<td><?php echo $umur2044L_B['Jml'];?></td>
						<td><?php echo $umur2044P_B['Jml'];?></td>
						<td><?php echo $umur2044L_L['Jml'];?></td>
						<td><?php echo $umur2044P_L['Jml'];?></td>
						<td><?php echo $umur4554L_B['Jml'];?></td>
						<td><?php echo $umur4554P_B['Jml'];?></td>
						<td><?php echo $umur4554L_L['Jml'];?></td>
						<td><?php echo $umur4554P_L['Jml'];?></td>
						<td><?php echo $umur5559L_B['Jml'];?></td>
						<td><?php echo $umur5559P_B['Jml'];?></td>
						<td><?php echo $umur5559L_L['Jml'];?></td>
						<td><?php echo $umur5559P_L['Jml'];?></td>
						<td><?php echo $umur6069L_B['Jml'];?></td>
						<td><?php echo $umur6069P_B['Jml'];?></td>
						<td><?php echo $umur6069L_L['Jml'];?></td>
						<td><?php echo $umur6069P_L['Jml'];?></td>
						<td><?php echo $umur70L_B['Jml'];?></td>
						<td><?php echo $umur70P_B['Jml'];?></td>
						<td><?php echo $umur70L_L['Jml'];?></td>
						<td><?php echo $umur70P_L['Jml'];?></td>
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