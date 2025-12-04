<?php
	error_reporting(0);
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$tahun = $_GET['tahun'];
	// get data
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$polipertama = $_GET['polipertama'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Penyakit_Terbanyak (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	// if(isset($bulanawal) and isset($tahunakhir)){
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
.font22{
	font-size:22px;
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
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>PENYAKIT TERBANYAK</b></span><br>
	<!--<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?>
	</span>-->
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="5%">NO.</th>
					<th width="10%">KODE</th>
					<th width="30%">NAMA PENYAKIT</th>
					<th width="10%">L</th>
					<th width="10%">P</th>
					<th width="10%">JUMLAH</th>
				</tr>
			</thead>
			<tbody style="font-size:12px;">
				<?php
				if(isset($_GET['limit'])){
					$jumlah_perpage = $_GET['limit'];
				}else{
					$jumlah_perpage = 10;
				}
				
				$mulai=0;
				$kasus = $_GET['kasus'];
				
				if($opsiform == 'bulan'){
					if($_GET['bulan'] == 'semua'){
						$str = "SELECT a.KodeDiagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
							FROM `$tbdiagnosapasien` a 
							LEFT JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE YEAR(a.TanggalDiagnosa) = '$tahun' AND a.KodeDiagnosa <> 'Z00.0'"."
							GROUP BY KodeDiagnosa 
							ORDER BY Jumlah DESC
							LIMIT $mulai,$jumlah_perpage";	
					}else{
						$str = "SELECT a.KodeDiagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
							FROM `$tbdiagnosapasien` a 
							LEFT JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE YEAR(a.TanggalDiagnosa) = '$tahun' AND MONTH(a.TanggalDiagnosa) = '$bulan' AND a.KodeDiagnosa <> 'Z00.0'"."
							GROUP BY KodeDiagnosa 
							ORDER BY Jumlah DESC
							LIMIT $mulai,$jumlah_perpage";			
					}
				}else{
					$waktu = "date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'";
					$str = "SELECT KodeDiagnosa, Kasus, COUNT(KodeDiagnosa) AS Jumlah 
							FROM `$tbdiagnosapasien` 
							WHERE ".$waktu." AND KodeDiagnosa <> 'Z00.0'
							GROUP BY KodeDiagnosa 
							ORDER BY Jumlah DESC
							LIMIT $mulai,$jumlah_perpage";
				}						
				// echo $str;
				
				$query = mysqli_query($koneksi,$str);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodediagnosa = $data['KodeDiagnosa'];
					
					// diagnosa
					$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kodediagnosa'"));
					
					if($opsiform == 'bulan'){
						if($_GET['bulan'] == 'semua'){
							$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
									FROM `$tbdiagnosapasien` a 
									LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
									WHERE YEAR(a.TanggalDiagnosa)='$tahun'
									and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'L'")); 
							$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
									FROM `$tbdiagnosapasien` a 
									LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
									WHERE YEAR(a.TanggalDiagnosa)='$tahun'
									and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'P'"));
						}else{	
							$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
									FROM `$tbdiagnosapasien` a 
									LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
									WHERE YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
									and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'L'")); 
							$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
									FROM `$tbdiagnosapasien` a 
									LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
									WHERE YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
									and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'P'"));
						}
					}else{
						$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
								FROM `$tbdiagnosapasien` 
								WHERE date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'
								and KodeDiagnosa = '$kodediagnosa' and JenisKelamin = 'L'")); 
						$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jumlah 
								FROM `$tbdiagnosapasien`
								WHERE date(`TanggalDiagnosa`) BETWEEN '$keydate1' AND '$keydate2'
								and KodeDiagnosa = '$kodediagnosa' and JenisKelamin = 'P'"));
					}
					$total = $jml_laki['Jumlah'] + $jml_perempuan['Jumlah'];
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
						<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $dtdiagnosa['Diagnosa'];?></td>
						<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jml_laki['Jumlah'];?></td>
						<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jml_perempuan['Jumlah'];?></td>
						<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table><br/>
	</div>
</div>