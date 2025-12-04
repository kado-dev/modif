<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
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
	display: none;
	
}
.printheader h4{
	font-size:18px;
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

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LB1-PELAYANAN GIGI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gigi_bulanan_tarakan"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tahun" <?php if($_GET['opsiform'] == 'tahun'){echo "SELECTED";}?>>Tahun</option>
								<!--<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>-->
							</select>	
						</div>
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gigi_bulanan_tarakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_gigi_bulanan_tarakan_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$opsiform = $_GET['opsiform'];
		
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- PELAYANAN GIGI</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'bulan'){
				echo nama_bulan($bulan)." ".$tahun;
			}else{
				echo $tahun;
			}
			?>
		</span><br/>
	</div>

	<div class="row ">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th rowspan="3">NO.</th>
							<th rowspan="3">KODE<br/>ICD X</th>
							<th rowspan="3" width="20%">NAMA DIAGNOSA</th>
							<th colspan="24">JUMLAH KASUS BARU MENURUT GOLONGAN UMUR</th>
							<th rowspan="2" colspan="3">KASUS BARU</th>
							<th rowspan="2" colspan="3">KASUS LAMA</th>
							<th rowspan="3">TOTAL<br/>KASUS</th>
						</tr>
						<tr>
							<th colspan="2">0-7Hr</th>
							<th colspan="2">8-30Hr</th>
							<th colspan="2"><1Th</th>
							<th colspan="2">1-4Th</th>
							<th colspan="2">5-9Th</th>
							<th colspan="2">10-14Th</th>
							<th colspan="2">15-19Th</th>
							<th colspan="2">20-44Th</th>
							<th colspan="2">45-54Th</th>
							<th colspan="2">55-59Th</th>
							<th colspan="2">60-69Th</th>
							<th colspan="2">>=70Th</th>
						</tr>
						<tr>
							<th>L</th><!--0-7Hr-->
							<th>P</th>
							<th>L</th><!--8-30Hr-->
							<th>P</th>
							<th>L</th><!--<1Th-->
							<th>P</th>
							<th>L</th><!--1-4Th-->
							<th>P</th>
							<th>L</th><!--5-9Th-->
							<th>P</th>
							<th>L</th><!--10-14Th-->
							<th>P</th>
							<th>L</th><!--15-19Th-->
							<th>P</th>
							<th>L</th><!--20-24Th-->
							<th>P</th>
							<th>L</th><!--45-54Th-->
							<th>P</th>
							<th>L</th><!--55-59Th-->
							<th>P</th>
							<th>L</th><!--60-69Th-->
							<th>P</th>
							<th>L</th><!--70Th-->
							<th>P</th>
							<th rowspan="2">L</th><!--Kasus Baru-->
							<th rowspan="2">P</th>
							<th rowspan="2">JML</th>
							<th rowspan="2">L</th><!--Kasus Lama-->
							<th rowspan="2">P</th>
							<th rowspan="2">JML</th>
						</tr>
					</thead>
					<tbody style="font-size: 14px;">
						<?php
						if($opsiform == 'bulan'){
							$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";	
							
							// insert ke tbdiagnosapasien_bulan
							$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND MONTH(`TanggalDiagnosa`)='$bulan'";
							$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
							mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
							while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
								$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
								('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
								mysqli_query($koneksi, $strdiagnosa);
							}
						}else{
							$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);	
							$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";	
						}						
						
						$str = "SELECT * FROM `tbdiagnosagigi`";
						$str2 = $str."order by `KodeDiagnosa` ASC";
																					
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = '%'.$data['KodeDiagnosa']."%";
							
							if($opsiform == 'bulan'){
								$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								// echo "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'";
								$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
														
								// kasus lama
								$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '0' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
								$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '0' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
								$t_lama_l = $lama_l['Jml'];
								$t_lama_p = $lama_p['Jml'];
								$total_lama = $t_lama_l + $t_lama_p;
							}else{
								// umur17hr
								$umur17hrL_1= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur17hrL_2= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur17hrL['Jml']= $umur17hrL_1['Jml'] + $umur17hrL_2['Jml'];
								$umur17hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur17hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur17hrP['Jml']= $umur17hrP_1['Jml'] + $umur17hrP_2['Jml'];
								// umur1830hr
								$umur1830hrL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur1830hrL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur1830hrL['Jml']= $umur1830hrL_1['Jml'] + $umur1830hrL_2['Jml'];
								$umur1830hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur1830hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur1830hrP['Jml']= $umur1830hrP_1['Jml'] + $umur1830hrP_2['Jml'];	
								// umur12bln
								$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
								$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
								// umur12bln
								$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
								$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
								// umur14th
								$umur14L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur14L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur14L['Jml']= $umur14L_1['Jml'] + $umur14L_2['Jml'];
								$umur14P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur14P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur14P['Jml']= $umur14P_1['Jml'] + $umur14P_2['Jml'];
								// umur59th
								$umur59L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur59L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur59L['Jml']= $umur59L_1['Jml'] + $umur59L_2['Jml'];
								$umur59P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur59P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur59P['Jml']= $umur59P_1['Jml'] + $umur59P_2['Jml'];
								// umur1014th
								$umur1014L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur1014L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur1014L['Jml']= $umur1014L_1['Jml'] + $umur1014L_2['Jml'];
								$umur1014P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur1014P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur1014P['Jml']= $umur1014P_1['Jml'] + $umur1014P_2['Jml'];
								// umur1519th
								$umur1519L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur1519L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur1519L['Jml']= $umur1519L_1['Jml'] + $umur1519L_2['Jml'];
								$umur1519P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur1519P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur1519P['Jml']= $umur1519P_1['Jml'] + $umur1519P_2['Jml'];
								// umur2044th
								$umur2044L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur2044L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur2044L['Jml']= $umur2044L_1['Jml'] + $umur2044L_2['Jml'];
								$umur2044P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur2044P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur2044P['Jml']= $umur2044P_1['Jml'] + $umur2044P_2['Jml'];
								// umur4554th
								$umur4554L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur4554L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur4554L['Jml']= $umur4554L_1['Jml'] + $umur4554L_2['Jml'];
								$umur4554P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur4554P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur4554P['Jml']= $umur4554P_1['Jml'] + $umur4554P_2['Jml'];
								// umur5559th
								$umur5559L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur5559L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur5559L['Jml']= $umur5559L_1['Jml'] + $umur5559L_2['Jml'];
								$umur5559P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur5559P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur5559P['Jml']= $umur5559P_1['Jml'] + $umur5559P_2['Jml'];
								// umur6069th
								$umur6069L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur6069L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur6069L['Jml']= $umur6069L_1['Jml'] + $umur6069L_2['Jml'];
								$umur6069P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur6069P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur6069P['Jml']= $umur6069P_1['Jml'] + $umur6069P_2['Jml'];
								// umur70100th
								$umur70100L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
								$umur70100L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
									$umur70100L['Jml']= $umur70100L_1['Jml'] + $umur70100L_2['Jml'];
								$umur70100P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
								$umur70100P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
									$umur70100P['Jml']= $umur70100P_1['Jml'] + $umur70100P_2['Jml'];
								// kasus lama
								$lama_l1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
								$lama_l2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
									$lama_l['Jml'] = $lama_l1['Jml'] + $lama_l2['Jml'];
								$lama_p1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
								$lama_p2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
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
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['Diagnosa']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100P['Jml'];?></td>
								<!--kasus baru-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_baru;?></td>
								<!--kasus lama-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $lama_l['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $lama_p['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_lama;?></td>
								<!--total kasus baru + lama-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php
	}
	?>
</div>