<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Tracking Diagnosa 2 (".$bulan.'-'.$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING DIAGNOSA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p>
</div><br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="5%">NO.</th>
					<th width="10%">KODE</th>
					<th width="60%">DIADNOSA</th>
					<th width="15%">JENIS PENYAKIT</th>
					<th width="10%">JUMLAH KASUS</th>
				</tr>
			</thead>
			<tbody style="font-size:12px;">
				<?php
				$no = 0;
				
				// insert ke $tbdiagnosapasien
				if($bulan == "Semua"){
					$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'";
				}else{
					$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND MONTH(`TanggalDiagnosa`)='$bulan'";
				}	
				$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
				mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
				while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
					$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
					('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
					mysqli_query($koneksi, $strdiagnosa);
				}
				
				$str = "SELECT * FROM `tbdiagnosasebengkok`";
				$str2 = $str." order by `JenisPenyakit`,`KodeDiagnosa`";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodedgs = $data['KodeDiagnosa'];
					if($bulan == "Semua"){
						$jumlah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%'"));
					}else{
						$jumlah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND b.KodeDiagnosa like '%$kodedgs%'"));
					}	
					// tbdiagnosabpjs
					$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kodedgs'"));
					?>
					<tr>
						<td align="center" width="3%"><?php echo $no;?></td>
						<td align="center" width="6%"><?php echo $data['KodeDiagnosa'];?></td>
						<td align="left" width="15%"><?php echo strtoupper($dtdiagnosa['Diagnosa']);?></td>
						<td align="center" width="15%"><?php echo strtoupper($data['JenisPenyakit']);?></td>
						<td align="right"><?php echo $jumlah['Jml'];?></td>
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