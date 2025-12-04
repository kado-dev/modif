<?php
	include_once('config/koneksi.php');
	session_start();
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
	header("Content-Disposition: attachment; filename=Laporan_P2M_PTM_Kasus_(Dinkes) (".$hariini.").xls");
	if(isset($tahun)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>REKAPITULASI KASUS BARU - LAMA DAN KEMATIAN (PTM)</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p></p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9.5px;">
				<tr>
					<th>No.</th>
					<th>Kode</th>
					<th>Penyakit Tidak Menular</th>
					<th>Total</th>
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
					$jan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_01` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$feb= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_02` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$mar = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_03` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$apr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_04` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$mei = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_05` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$jun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_06` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$jul = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_07` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$agu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_08` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$sep = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_09` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$okt = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_10` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$nov = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_11` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$des = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_12` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
					$total = $jan['Jml'] + $feb['Jml'] + $mar['Jml'] + $apr['Jml'] + $mei['Jml'] + $jun['Jml'] + $jul['Jml'] +
							$agu['Jml'] + $sep['Jml'] + $okt['Jml'] + $nov['Jml'] + $des['Jml'] + $jul['Jml'];
					if($data['IdDiagnosa'] == '01'){
						echo "<td>$data[Kelompok]</td></tr>";
					}
				?>
					<tr>
						<td><?php echo $data['IdDiagnosa'];?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo rupiah($total);?></td>
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