<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	// filterdata
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Bulanan_P2M_ISPA (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN PROGRAM PENGENDALIAN ISPA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $bulan." ".$tahun;?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="4" width="2%">No.</th>
					<th rowspan="4" width="10%">Kelurahan</th>
					<th rowspan="4" width="3%">Jml Pdkk</th>
					<th rowspan="4" width="3%">Jml Pdkk Balita (10% pddk)</th>
					<th rowspan="4" width="3%">Target Pene muan Pddk Pneu monia</th>
					<th colspan="4">Pneumonia</th>
					<th colspan="4">Pneumonia Berat</th>
					<th colspan="7">Jumlah</th>
					<th rowspan="4">%</th>
					<th colspan="5">Batuk Bukan Pneumonia</th>
					<th colspan="6">Jml Kematian Balita Krn Penumonia</th>
					<th colspan="6">ISPA >5 Thn</th>
					<th rowspan="4">Dirujuk</th>
				</tr>
				<tr>
					<th colspan="2"><1 Thn</th><!--Pneumonia-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2"><1 Thn</th><!--Pneumonia Berat-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2"><1 Thn</th><!--Jumlah-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2">SubTotal</th>
					<th rowspan="2">Total</th>
					<th colspan="2"><1 Thn</th><!--Bukan Pneumonia-->
					<th colspan="2">1-4 Thn</th>
					<th rowspan="2">Total</th>
					<th colspan="2"><1 Thn</th><!--Jml Kematian Balita Krn Penumonia-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2">Total</th>
					<th colspan="3">Bkn Pneumonia</th>
					<th colspan="3">Pneumonia</th><!--ISPA >5 Thn-->
				</tr>
				<tr style="border:1px solid #000;">
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
			</thead>
			<tbody>
				<?php
				// tbdiagnosaispa
				if($kasus != 'semua'){
					$qkasus = " AND c.Kasus = '$kasus' ";
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
				
					// pneumonia < 5th
					$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.8')".$qkasus));
					$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.8')".$qkasus));
					$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.8')".$qkasus));
					$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.8')".$qkasus));
					$ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
					$ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
					$laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
					$ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
					$ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
					$perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
					
					// pneumonia_berat < 5th
					$ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
					$ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
					$ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
					$ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
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
					
					// batuk bukan pneumonia < 5th
					$ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa = 'J00' OR c.KodeDiagnosa = 'J11.0' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa = 'J06.0' OR c.KodeDiagnosa = 'J04.0' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
					$ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa = 'J00' OR c.KodeDiagnosa = 'J11.0' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa = 'J06.0' OR c.KodeDiagnosa = 'J04.0' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
					$ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa = 'J00' OR c.KodeDiagnosa = 'J11.0' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa = 'J06.0' OR c.KodeDiagnosa = 'J04.0' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
					$ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa = 'J00' OR c.KodeDiagnosa = 'J11.0' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa = 'J06.0' OR c.KodeDiagnosa = 'J04.0' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
					$ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
					
					// ispa > 5th bukan pneumonia
					$ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa = 'J00' OR c.KodeDiagnosa = 'J11.0' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa = 'J06.0' OR c.KodeDiagnosa = 'J04.0' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
					$ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa = 'J00' OR c.KodeDiagnosa = 'J11.0' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa = 'J06.0' OR c.KodeDiagnosa = 'J04.0' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
					$ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
											
					// ispa > 5th pneumonia
					$ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J18.9')".$qkasus));
					$ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J18.9')".$qkasus));
					$ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
				?>
				
					<tr style="border:1px solid #000;">
						<td style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $data_kelurahan['Kelurahan'];?></td>
						<td style="border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td><?php echo $ispa_0_Laki_pneumonia['Jumlah'];?></td>
						<td><?php echo $ispa_0_Perempuan_pneumonia['Jumlah'];?></td>
						<td><?php echo $ispa_1_4_Laki_pneumonia['Jumlah'];?></td>
						<td><?php echo $ispa_1_4_Perempuan_pneumonia['Jumlah'];?></td>
						<td><?php echo $ispa_0_Laki_pneumonia_berat['Jumlah'];?></td>
						<td><?php echo $ispa_0_Perempuan_pneumonia_berat['Jumlah'];?></td>
						<td><?php echo $ispa_1_4_Laki_pneumonia_berat['Jumlah'];?></td>
						<td><?php echo $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];?></td>
						<td><?php echo $laki_pneumonia;?></td>
						<td><?php echo $perempuan_pneumonia;?></td>
						<td><?php echo $laki_pneumonia_berat;?></td>
						<td><?php echo $perempuan_pneumonia_berat;?></td>
						<td><?php echo $sublaki;?></td>
						<td><?php echo $subperempuan;?></td>
						<td><?php echo $total;?></td>
						<td>0</td>
						<td><?php echo $ispa_0_Laki_pneumonia_bukan['Jumlah'];?></td>
						<td><?php echo $ispa_0_Perempuan_pneumonia_bukan['Jumlah'];?></td>
						<td><?php echo $ispa_1_4_Laki_pneumonia_bukan['Jumlah'];?></td>
						<td><?php echo $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];?></td>
						<td><?php echo $ttl_pneumonia_bukan?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
						<td><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
						<td><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
						<td><?php echo $ttl_5_pneumonia_bukan;?></td>
						<td><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
						<td><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
						<td><?php echo $ttl_5_pneumonia;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
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