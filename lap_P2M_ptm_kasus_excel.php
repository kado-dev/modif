<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Ptm_Kasus (".$namapuskesmas." ".$bulan." - ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:-15px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
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
	margin-left:-10px;
	margin-right:-10px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
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
.font12{
	font-size:12px;
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
	<h4 style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>REKAPITULASI KASUS BARU - LAMA DAN KEMATIAN (PTM)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kelurahan);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<span>Jumlah Kasus Baru</span>
		<table class="table table-condensed" border="1">
			<thead style="font-size:9px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="3">No.</th>
					<th rowspan="3">Kode</th>
					<th rowspan="3">Penyakit Tidak Menular</th>
					<th colspan="16">Jenis Kelamin dan Umur (Th)</th>
					<th rowspan="3">Total</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th colspan="8">Laki-laki (L)</th>
					<th colspan="8">Perempuan (P)</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th><15</th><!--15-->
					<th>15-19</th><!--15-19-->
					<th>20-44</th><!--20-44-->
					<th>45-54</th><!--45-54-->
					<th>55-59</th><!--55-59-->
					<th>60-69</th><!--60-69-->
					<th>>70</th><!--70-->
					<th>Jumlah</th>
					<th><15</th><!--15-->
					<th>15-19</th><!--15-19-->
					<th>20-44</th><!--20-44-->
					<th>45-54</th><!--45-54-->
					<th>55-59</th><!--55-59-->
					<th>60-69</th><!--60-69-->
					<th>>70</th><!--70-->
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// insert ke tbpasienrj_bulan
				$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
				$querypasienrj = mysqli_query($koneksi, $strpasienrj);
				mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
				while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
					$strpasienrjbulan = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
					`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
					`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
					`nokartu`,`kdpoli`,`Kir`) VALUES 
					('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NoRM]','$datapsrj[NamaPasien]',
					'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
					'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$datapsrj[StatusKunjungan]','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
					'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
					,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
					'$datapsrj[Kir]')";
					mysqli_query($koneksi, $strpasienrjbulan);
				}
				
				// insert ke tbdiagnosapasien_bulan
				$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalDiagnosa`)='$tahun'";
				$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
				mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
				while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
					$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
					('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
					mysqli_query($koneksi, $strdiagnosa);
				}	
					
				$str = "SELECT * FROM `tbdiagnosaptmkode`";
				$str2 = $str." ORDER BY `KodeKelompok`,`IdDiagnosa`";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = $data['KodeDiagnosa'];
					$umur15L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$umur70L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
					$jmlL = $umur15L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml'] + $umur6069L['Jml'] + $umur70L['Jml'];
					$umur15P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$umur70P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun > '70' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
					$jmlP = $umur15P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + $umur6069P['Jml'] + $umur70P['Jml'];
					$total = $jmlL + $jmlP;
					if($data['IdDiagnosa'] == '01'){
						echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='19' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
					}
				?>
				
					<tr>
						<td><?php echo $data['IdDiagnosa'];?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo $umur15L['Jml'];?></td>
						<td><?php echo $umur1519L['Jml'];?></td>
						<td><?php echo $umur2044L['Jml'];?></td>
						<td><?php echo $umur4554L['Jml'];?></td>
						<td><?php echo $umur5559L['Jml'];?></td>
						<td><?php echo $umur6069L['Jml'];?></td>
						<td><?php echo $umur70L['Jml'];?></td>
						<td><?php echo $jmlL;?></td>
						<td><?php echo $umur15P['Jml'];?></td>
						<td><?php echo $umur1519P['Jml'];?></td>
						<td><?php echo $umur2044P['Jml'];?></td>
						<td><?php echo $umur4554P['Jml'];?></td>
						<td><?php echo $umur5559P['Jml'];?></td>
						<td><?php echo $umur6069P['Jml'];?></td>
						<td><?php echo $umur70P['Jml'];?></td>
						<td><?php echo $jmlP;?></td>
						<td><?php echo $total;?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<br><br>
		<span>Jumlah Kasus Lama</span>
		<table class="table table-condensed" border="1">
			<thead style="font-size:9px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="3">No.</th>
					<th rowspan="3">Kode</th>
					<th rowspan="3">Penyakit Tidak Menular</th>
					<th colspan="16">Jenis Kelamin dan Umur (Th)</th>
					<th rowspan="3">Total</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th colspan="8">Laki-laki (L)</th>
					<th colspan="8">Perempuan (P)</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th><15</th><!--15-->
					<th>15-19</th><!--15-19-->
					<th>20-44</th><!--20-44-->
					<th>45-54</th><!--45-54-->
					<th>55-59</th><!--55-59-->
					<th>60-69</th><!--60-69-->
					<th>>70</th><!--70-->
					<th>Jumlah</th>
					<th><15</th><!--15-->
					<th>15-19</th><!--15-19-->
					<th>20-44</th><!--20-44-->
					<th>45-54</th><!--45-54-->
					<th>55-59</th><!--55-59-->
					<th>60-69</th><!--60-69-->
					<th>>70</th><!--70-->
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody style="font-size:9px;">
				<?php
				$str = "SELECT * FROM `tbdiagnosaptmkode`";
				$str2 = $str." order by `KodeKelompok`,`IdDiagnosa`";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kodedgs = $data['KodeDiagnosa'];
				$umur15L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$umur70L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
				$jmlL = $umur15L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml'] + $umur6069L['Jml'] + $umur70L['Jml'];
				$umur15P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$umur70P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun > '70' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
				$jmlP = $umur15P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + $umur6069P['Jml'] + $umur70P['Jml'];
				$total = $jmlL + $jmlP;
				if($data['IdDiagnosa'] == '01'){
					echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='19' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
				}
				?>
					<tr style="border:1px dashed #000;">
						<td><?php echo $data['IdDiagnosa'];?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo $umur15L['Jml'];?></td>
						<td><?php echo $umur1519L['Jml'];?></td>
						<td><?php echo $umur2044L['Jml'];?></td>
						<td><?php echo $umur4554L['Jml'];?></td>
						<td><?php echo $umur5559L['Jml'];?></td>
						<td><?php echo $umur6069L['Jml'];?></td>
						<td><?php echo $umur70L['Jml'];?></td>
						<td><?php echo $jmlL;?></td>
						<td><?php echo $umur15P['Jml'];?></td>
						<td><?php echo $umur1519P['Jml'];?></td>
						<td><?php echo $umur2044P['Jml'];?></td>
						<td><?php echo $umur4554P['Jml'];?></td>
						<td><?php echo $umur5559P['Jml'];?></td>
						<td><?php echo $umur6069P['Jml'];?></td>
						<td><?php echo $umur70P['Jml'];?></td>
						<td><?php echo $jmlP;?></td>
						<td><?php echo $total;?></td>
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