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
	header("Content-Disposition: attachment; filename=Laporan_P2M_Diare (".$bulan.'-'.$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DIARE</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p></p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="4">No.</th>
					<th rowspan="4" width="8%">Nama Puskesmas</th>
					<th colspan="22">Sarana Kesehatan</th>
					<th colspan="19">Kader</th>
					<th colspan="7">Total Sarana Kesehatan & Kader</th>
					<th colspan="3">Derajat Dehidrasi</th>
					<th colspan="2">Pemeriksaan Lab</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th colspan="4"><1 Thn</th><!--sarana kesehatan-->
					<th colspan="4">1-4 Thn</th>
					<th colspan="4">>5 Thn</th>
					<th colspan="4">Jumlah</th>
					<th rowspan="2" colspan="3">Jml Penderita Diberi</th>
					<th rowspan="2" colspan="3">Jml Pemakaian</th>
					<th colspan="4"><1 Thn</th><!--kader-->
					<th colspan="4">1-4 Thn</th>
					<th colspan="4">>5 Thn</th>
					<th colspan="4">Jumlah</th>
					<th rowspan="2" colspan="3">Jml Pemakaian</th><!--total sarana kesehatan & kader-->
					<th rowspan="2" colspan="2">P</th>
					<th rowspan="2" colspan="2">M</th>
					<th rowspan="2" colspan="3">Pemakaian</th>
					<th rowspan="3">Tanpa Dehidrasi</th><!--derajat dehidrasi-->
					<th rowspan="3">Sedang</th>
					<th rowspan="3">Berat</th>
					<th rowspan="3">Jml Spesimen</th><!--Pemeriksaan Lab-->
					<th rowspan="3">POS</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th colspan="2">P</th><!--sarana kesehatan-->
					<th colspan="2">M</th>
					<th colspan="2">P</th>
					<th colspan="2">M</th>
					<th colspan="2">P</th>
					<th colspan="2">M</th>
					<th colspan="2">P</th>
					<th colspan="2">M</th>
					<th colspan="2">P</th><!--kader-->
					<th colspan="2">M</th>
					<th colspan="2">P</th>
					<th colspan="2">M</th>
					<th colspan="2">P</th>
					<th colspan="2">M</th>
					<th colspan="2">P</th>
					<th colspan="2">M</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th>L</th><!--Penderita-Laki-<1thn--><!--sarana kesehatan-->
					<th>P</th><!--Penderita-Perempuan_<1thn-->
					<th>L</th><!--Meninggal-Laki-<1thn-->
					<th>P</th><!--Meninggal-Perempuan<1thn-->
					<th>L</th><!--Penderita-Laki-1-4thn-->
					<th>P</th><!--Penderita-Laki-1-4thn-->
					<th>L</th><!--Meninggal-Laki-1-4thn-->
					<th>P</th><!--Meninggal-Perempuan-1-4thn-->
					<th>L</th><!--Penderita-Laki->5thn-->
					<th>P</th><!--Penderita-Perempuan->5thn-->
					<th>L</th><!--Meninggal-Laki->5thn-->
					<th>P</th><!--Meninggal-Perempuan>5thn-->
					<th>L</th><!--Penderita-Laki-Jumlah-->
					<th>P</th><!--Penderita-Perempuan-Jumlah-->
					<th>L</th><!--Meninggal-Laki-Jumlah-->
					<th>P</th><!--Meninggal-Perempuan-Jumlah-->
					<th>Orl</th>
					<th>Znc</th>
					<th>Rl</th>
					<th>Orl</th>
					<th>Znc</th>
					<th>Rl</th>
					<th>L</th><!--Penderita-Laki-<1thn--><!--kader-->
					<th>P</th><!--Penderita-Perempuan_<1thn-->
					<th>L</th><!--Meninggal-Laki-<1thn-->
					<th>P</th><!--Meninggal-Perempuan<1thn-->
					<th>L</th><!--Penderita-Laki-1-4thn-->
					<th>P</th><!--Penderita-Laki-1-4thn-->
					<th>L</th><!--Meninggal-Laki-1-4thn-->
					<th>P</th><!--Meninggal-Perempuan-1-4thn-->
					<th>L</th><!--Penderita-Laki->5thn-->
					<th>P</th><!--Penderita-Perempuan->5thn-->
					<th>L</th><!--Meninggal-Laki->5thn-->
					<th>P</th><!--Meninggal-Perempuan>5thn-->
					<th>L</th><!--Penderita-Laki-Jumlah-->
					<th>P</th><!--Penderita-Perempuan-Jumlah-->
					<th>L</th><!--Meninggal-Laki-Jumlah-->
					<th>P</th><!--Meninggal-Perempuan-Jumlah-->
					<th>Orl</th>
					<th>Znc</th>
					<th>Rl</th>
					<th>L</th><!--Penderita-Laki-<1thn--><!--total sarana kesehatan & kader-->
					<th>P</th><!--Penderita-Perempuan_<1thn-->
					<th>L</th><!--Meninggal-Laki-<1thn-->
					<th>P</th><!--Meninggal-Perempuan<1thn-->
					<th>Orl</th>
					<th>Znc</th>
					<th>Rl</th>
				</tr>
			</thead>
			<tbody style="font-size:9px;">
				<?php
				// insert ke tbdiagnosapasien_bulan
				$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'";
				$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
				mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
				while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
					$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
					('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
					mysqli_query($koneksi, $strdiagnosa);
				}
									
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
				
					// Sarana Kesehatan
					$data_diare_0_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
					$data_diare_0_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
					$data_diare_1_4_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
					$data_diare_1_4_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
					$data_diare_5_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
					$data_diare_5_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj`a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'A03.0' OR b.KodeDiagnosa = 'A06.0' OR b.KodeDiagnosa = 'A09')"));
					$jumlah_Sarana_Laki = $data_diare_0_Laki['Jumlah'] + $data_diare_1_4_Laki['Jumlah'] + $data_diare_5_Laki['Jumlah'];
					$jumlah_Sarana_Perempuan = $data_diare_0_Perempuan['Jumlah'] + $data_diare_1_4_Perempuan['Jumlah'] + $data_diare_5_Perempuan['Jumlah'];
					
					// jumlah penderita diberi
					$str_pemberian = "SELECT `TindakanPengobatan` FROM `tbdiagnosadiare` WHERE `Kelurahan` = '$kelurahan'";
					$query_pemberian = mysqli_query($koneksi,$str_pemberian);
					
					while($data_pemberian = mysqli_fetch_array($query_pemberian)){
						$array_data[$dtkelurahan['Kelurahan']][] = $data_pemberian['TindakanPengobatan'];
					}

					$data_pmb = implode(",",$array_data[$dtkelurahan['Kelurahan']]);
					$acv = array_count_values(explode(",",$data_pmb));	
						$jmloralit = $acv['Oralit'];
						$jmlzinc = $acv['Zinc'];
						$jmlinfus = $acv['Infus'];
					//echo $data_pmb."<br/>";
					
					// jumlah pemakaian sarana kesehatan
					$data_oralit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.NamaBarang like '%oralit%'"));
					$data_zink = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.NamaBarang like '%zink%'"));
					$data_rl = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.NamaBarang like '%ringer laktat%'"));
					if ($data_oralit != ''){
						$oralit = $data_oralit['JumlahObat'];
					}else{
						$oralit = 0;
					}
					
					if ($data_zink != ''){
						$zink = $data_zink['JumlahObat'];
					}else{
						$zink = 0;
					}
					
					if ($data_rl != ''){
						$ringer_laktat = $data_rl['JumlahObat'];
					}else{
						$ringer_laktat = 0;
					}						
					
					// Sarana Kader
					$data_diare_0_Laki_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$data_diare_0_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$data_diare_1_4_Laki_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$data_diare_1_4_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$data_diare_5_Laki_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$data_diare_5_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$jumlah_sarana_Laki_Kader =  mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
					$jumlah_sarana_Perempuan_Kader = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
				
					// Total Sarana Kesehatan dan Kader
					$total_p_l = $jumlah_Sarana_Laki + $jumlah_sarana_Laki_Kader['Jumlah'];
					$total_p_p = $jumlah_Sarana_Perempuan + $jumlah_sarana_Perempuan_Kader['Jumlah'];
					
					// jumlah pemakaian kader
					$data_oralit_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%oralit%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
					$data_zink_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%zink%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
					$data_rl_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%ringer laktat%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
					if ($data_oralit_kdr != ''){
						$oralit_kdr = $data_oralit_kdr['JumlahObat'];
					}else{
						$oralit_kdr = 0;
					}
					
					if ($data_zink_kdr != ''){
						$zink_kdr = $data_zink_kdr['JumlahObat'];
					}else{
						$zink_kdr = 0;
					}
					
					if ($data_rl_kdr != ''){
						$ringer_laktat_kdr = $data_rl_kdr['JumlahObat'];
					}else{
						$ringer_laktat_kdr = 0;
					}

					// jumlah pemakaian sarana kesehatan dan kader
					$jml_oralit = $oralit + $oralit_kdr;
					$jml_zinc = $zink + $zink_kdr;
					$jml_ringer_laktat = $ringer_laktat + $ringer_laktat_kdr;
					
					// derajat dehidrasi
					$data_dehidrasi_ringan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Tanpa Dehidrasi' AND Kelurahan = '$kelurahan'"));
					$data_dehidrasi_sedang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Sedang' AND Kelurahan = '$kelurahan'"));
					$data_dehidrasi_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Berat' AND Kelurahan = '$kelurahan'"));
					?>
				
					<tr style="border:1px dashed #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data['NamaPuskesmas'];?></td>
						<!--sarana kesehatan-->
						<td><?php echo $data_diare_0_Laki['Jumlah'];?></td><!--sarana kesehatan-->
						<td><?php echo $data_diare_0_Perempuan['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo $data_diare_1_4_Laki['Jumlah'];?></td>
						<td><?php echo $data_diare_1_4_Perempuan['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo $data_diare_5_Laki['Jumlah'];?></td>
						<td><?php echo $data_diare_5_Perempuan['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo $jumlah_Sarana_Laki;?></td>
						<td><?php echo $jumlah_Sarana_Perempuan;?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<!--jumlahpenderita-->
						<td><?php echo round($jmloralit,0);?></td><!--Oralit-->
						<td><?php echo round($jmlzinc,0);?></td><!--Zinc-->
						<td><?php echo round($jmlinfus,0);?></td><!--RL-->
						<!--jumlahpemakaian-->
						<td><?php echo round($oralit,0);?></td><!--Oralit--><!--jumlah pemakaian-->
						<td><?php echo round($zink,0);?></td><!--Zink-->
						<td><?php echo round($ringer_laktat,0);?></td><!--RL-->
						<!--kader-->
						<td><?php echo $data_diare_0_Laki_Kader['Jumlah'];?></td><!--kader-->
						<td><?php echo $data_diare_0_Perempuan_Kader['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo $data_diare_1_4_Laki_Kader['Jumlah'];?></td>
						<td><?php echo $data_diare_1_4_Perempuan_Kader['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo $data_diare_5_Laki_Kader['Jumlah'];?></td>
						<td><?php echo $data_diare_5_Perempuan_Kader['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo $jumlah_sarana_Laki_Kader['Jumlah'];?></td>
						<td><?php echo $jumlah_sarana_Perempuan_Kader['Jumlah'];?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<!--jumlahpemakaian-->
						<td><?php echo round($oralit_kdr,0);?></td><!--Oralit-->
						<td><?php echo round($zink_kdr,0);?></td><!--Zinc-->
						<td><?php echo round($ringer_laktat_kdr,0);?></td><!--RL-->
						<!--total sarana dan kader-->
						<td><?php echo $total_p_l;?></td>
						<td><?php echo $total_p_p?></td>
						<td><?php echo '-';?></td>
						<td><?php echo '-';?></td>
						<td><?php echo round($jml_oralit,0);?></td><!--Oralit-->
						<td><?php echo round($jml_zinc,0);?></td><!--Zinc-->
						<td><?php echo round($jml_ringer_laktat,0);?></td><!--RL-->
						<!--derajat dehidrasi-->
						<td><?php echo $data_dehidrasi_ringan['Jumlah'];?></td><!--Tanpa Dehidrasi--><!--derajat dehidrasi-->
						<td><?php echo $data_dehidrasi_sedang['Jumlah'];?></td><!--Ringan/Sedang-->
						<td><?php echo $data_dehidrasi_berat['Jumlah'];?></td><!--Dehidrasi Berat-->
						<!--lab-->
						<td><?php echo '-';?></td><!--Jumlah Spesimen--><!--pemeriksaan lab-->
						<td><?php echo '-';?></td><!--POS-->
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