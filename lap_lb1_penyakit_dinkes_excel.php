<?php
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');	
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$puskesmas = $_GET['kd'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_LB1_Penyakit_Dinkes (".$bulan." ".$tahun.").xls");
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- PENYAKIT</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="3">No.</th>
					<th rowspan="3">Kode</th>
					<th rowspan="3">Nama Penyakit</th>
					<th colspan="24">Jumlah Kasus Baru Menurut Golongan Umur</th>
					<th rowspan="2" colspan="3">Kasus Baru</th>
					<th rowspan="2" colspan="3">Kasus Lama</th>
					<th rowspan="3">Total Kasus</th>
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
				<tr style="border:1px solid #000;">
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
					<th>L</th><!--Kasus Baru-->
					<th>P</th>
					<th>Jml</th>
					<th>L</th><!--Kasus Lama-->
					<th>P</th>
					<th>Jml</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($puskesmas == "Semua"){
					$puskesmas = "";
					$puskesmas2 = "";
					$tbpasienrj = 'tbpasienrj';
				}else{
					$puskesmas = " AND SUBSTRING(NoRegistrasi,1,11)='$puskesmas'";
					$puskesmas2 = " AND SUBSTRING(NoRegistrasi,1,11)='$_GET[kd]'";
					$tbpasienrj = 'tbpasienrj_'.$_GET['kd'];
				}
				
				$waktu = "YEAR(TanggalDiagnosa) = '$tahun'";
				$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
								
				// insert ke tbdiagnosapasien_bulan
				if($bulan == "Semua"){
					if($puskesmas == "Semua"){
						$strdiagnosabln = "SELECT * FROM(
							SELECT * FROM `tbdiagnosapasien_01` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_02` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_03` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_04` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_05` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_06` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_07` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_08` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_09` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_10` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_11` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
							UNION
							SELECT * FROM `tbdiagnosapasien_12` WHERE YEAR(`TanggalDiagnosa`)='$tahun'
						) tbalias";
						echo $strdiagnosabln;
					}else{
						$strdiagnosabln = "SELECT * FROM(
							SELECT * FROM `tbdiagnosapasien_01` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_02` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_03` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_04` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_05` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_06` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_07` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_08` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_09` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_10` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_11` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
							UNION
							SELECT * FROM `tbdiagnosapasien_12` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas."
						) tbalias";
					}
				}else{
					if($puskesmas == "Semua"){
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'";
					}else{
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'".$puskesmas;
					}
				}
				// echo $strdiagnosabln;
				// die();
				
				mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
				$querydiagnosabln = mysqli_query($koneksi, $strdiagnosabln);
				while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
					$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`) VALUES 
					('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]','$datalb[UmurTahun]','$datalb[UmurBulan]','$datalb[UmurHari]','$datalb[JenisKelamin]')";
					mysqli_query($koneksi, $strdiagnosa);
				}
				
				$mulai=0;
				$str = "SELECT * FROM `tbdiagnosa`";
				$str2 = $str."order by `KodeDiagnosa` ASC";			
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = '%'.$data['KodeDiagnosaBPJS']."%";
					$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '1' AND '7' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '1' AND '7' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '30' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '30' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun = '0' AND UmurBulan Between '2' AND '12' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun = '0' AND UmurBulan Between '2' AND '12' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2."AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
					$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
					$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
										
					// kasus lama
					$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '0' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
					$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_bulan` WHERE $waktu".$puskesmas2." AND KodeDiagnosa like '$kodedgs' AND UmurTahun Between '0' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
					$t_lama_l = $lama_l['Jml'];
					$t_lama_p = $lama_p['Jml'];
					$total_lama = $t_lama_l + $t_lama_p;
				
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
						<td><?php echo $no;?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo $umur17hrL['Jml'];?></td>
						<td><?php echo $umur17hrP['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrP['Jml'];?></td>
						<td><?php echo $umur12blnL['Jml'];?></td>
						<td><?php echo $umur12blnP['Jml'];?></td>
						<td><?php echo $umur14L['Jml'];?></td>
						<td><?php echo $umur14P['Jml'];?></td>
						<td><?php echo $umur59L['Jml'];?></td>
						<td><?php echo $umur59P['Jml'];?></td>
						<td><?php echo $umur1014L['Jml'];?></td>
						<td><?php echo $umur1014P['Jml'];?></td>
						<td><?php echo $umur1519L['Jml'];?></td>
						<td><?php echo $umur1519P['Jml'];?></td>
						<td><?php echo $umur2044L['Jml'];?></td>
						<td><?php echo $umur2044P['Jml'];?></td>
						<td><?php echo $umur4554L['Jml'];?></td>
						<td><?php echo $umur4554P['Jml'];?></td>
						<td><?php echo $umur5559L['Jml'];?></td>
						<td><?php echo $umur5559P['Jml'];?></td>
						<td><?php echo $umur6069L['Jml'];?></td>
						<td><?php echo $umur6069P['Jml'];?></td>
						<td><?php echo $umur70100L['Jml'];?></td>
						<td><?php echo $umur70100P['Jml'];?></td>
						<!--kasus baru-->
						<td><?php echo $baru_l;?></td>
						<td><?php echo $baru_p;?></td>
						<td><?php echo $total_baru;?></td>
						<!--kasus lama-->
						<td><?php echo $lama_l['Jml'];?></td>
						<td><?php echo $lama_p['Jml'];?></td>
						<td><?php echo $total_lama;?></td>
						<!--total kasus baru + lama-->
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