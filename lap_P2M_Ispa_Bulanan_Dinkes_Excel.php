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
	header("Content-Disposition: attachment; filename=Laporan_P2M_Ispa (".$bulan.'-'.$tahun.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN ISPA</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p></p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="3">No.</th>
					<th rowspan="3" colspan="2">Nama Puskesmas</th>
					<th colspan="4">Pneumonia</th>
					<th colspan="4">Pneumonia Berat</th>
					<th colspan="7">Jumlah</th>
					<th rowspan="3">%</th>
					<th colspan="5">Batuk Bukan Pneumonia</th>
					<th colspan="6">Jml Kematian Balita Krn Penumonia</th>
					<th colspan="6">ISPA >5 Thn</th>
					<th rowspan="3">Dirujuk</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th colspan="2">< 1 Thn</th><!--Pneumonia-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2">< 1 Thn</th><!--Pneumonia Berat-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2">< 1 Thn</th><!--Jumlah-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2">SubTotal</th>
					<th rowspan="2">Total</th>
					<th colspan="2">< 1 Thn</th><!--Bukan Pneumonia-->
					<th colspan="2">1-4 Thn</th>
					<th rowspan="2">Total</th>
					<th colspan="2">< 1 Thn</th><!--Jml Kematian Balita Krn Penumonia-->
					<th colspan="2">1-4 Thn</th>
					<th colspan="2">Total</th>
					<th colspan="3">Bkn Pneumonia</th>
					<th colspan="3">Pneumonia</th><!--ISPA >5 Thn-->
				</tr>
				<tr style="border:1px dashed #000;">
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
			<tbody style="font-size:10px;">
				<?php
				if($kodepuskesmas == 'semua'){
					$str = "SELECT * FROM `tbpuskesmas`";
				}else{
					$str = "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'";
				}
				$str2 = $str." ORDER BY `NamaPuskesmas` ASC";
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;						
					$kodepuskesmas2 = "AND SUBSTRING(a.NoRegistrasi,1,11)="."'$data[KodePuskesmas]'";						
					
					// pneumonia
					$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.9'"));
					$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.9'"));
					$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.9'"));
					$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.9'"));
					$ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
					$ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
					$laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
					$ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
					$ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
					$perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
					
					// pneumonia_berat
					$ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.0'"));
					$ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.0'"));
					$ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.0'"));
					$ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.0'"));
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
					
					// batuk bukan pneumonia
					$ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
					$ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
					$ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
					$ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
					$ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
					
					// ispa > 5th bukan pneumonia
					$ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
					$ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
					$ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
											
					// ispa > 5th pneumonia
					$ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND b.KodeDiagnosa like '%J18%'"));
					$ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND b.KodeDiagnosa like '%J18%'"));
					$ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
					
				?>
					<tr style="border:1px dashed #000;">
						<td><?php echo $no;?></td>
						<td colspan="2"><?php echo $data['NamaPuskesmas'];?></td>
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
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
						<td><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
						<td><?php echo $ttl_5_pneumonia_bukan;?></td>
						<td><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
						<td><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
						<td><?php echo $ttl_5_pneumonia;?></td>
						<td>-</td>
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