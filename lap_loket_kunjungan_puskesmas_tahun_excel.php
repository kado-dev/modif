<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kunjungan_Pasien_Perpuskesmas (".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN PERTAHUN</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo "Tahun ".$tahun;?></p><br/>
</div>
<br/>

<?php
	$kategori = $_GET['kategori'];		
	$key = $_GET['key'];				
	
	if($kategori !='' && $key !=''){
		if($kategori == 'Expire'){
			$strcari = " and datediff(Expire,current_date()) < '180'";
		}else{
			$strcari = " and ".$kategori." Like '%$key%'";
		}
	}else{
		$strcari = " ";
	}
		
	$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' AND `SumberAnggaran` != 'BLUD'".$strcari;
	$str2 = $str." order by NamaBarang";
?>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th width="3%" rowspan="3">No.</th>
					<th width="10%" rowspan="3">Puskesmas</th>
					<th colspan="24">Jumlah Kunjungan</th>
					<th width="8%" rowspan="3">Total</th>
				</tr>
				<tr style="border:1px solid #000;">
					<?php
					for($bln = 1; $bln <= 12;$bln++){
						echo "<th colspan='2' style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".$bln."</th>";
					}
					?>
				</tr>
				<tr style="border:1px solid #000;">
					<?php
					for($bln = 1; $bln <= 12;$bln++){
					?>	
					<th width="3%">L</th>
					<th width="3%">P</th>
					<?php
					}
					?>
				</tr>
			</thead>
			<tbody style="font-size:12px;">
				<?php
				$no = 0;
				$str = "SELECT * FROM `tbpuskesmas` WHERE `Kota` = '$kota'";
				$str2 = $str." ORDER BY NamaPuskesmas";
				// echo $str2;
				
				$query = mysqli_query($koneksi, $str2);					
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kdpuskesmas = $data['KodePuskesmas'];
					$namapuskesmas = $data['NamaPuskesmas'];						
					$tbpasienrj = "tbpasienrj_".$kdpuskesmas;
					$dtrj1_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `JenisKelamin`='L'"));
					$dtrj1_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `JenisKelamin`='P'"));
					$dtrj2_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `JenisKelamin`='L'"));
					$dtrj2_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `JenisKelamin`='P'"));
					$dtrj3_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `JenisKelamin`='L'"));
					$dtrj3_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `JenisKelamin`='P'"));
					$dtrj4_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `JenisKelamin`='L'"));
					$dtrj4_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `JenisKelamin`='P'"));
					$dtrj5_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `JenisKelamin`='L'"));
					$dtrj5_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `JenisKelamin`='P'"));
					$dtrj6_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `JenisKelamin`='L'"));
					$dtrj6_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `JenisKelamin`='P'"));
					$dtrj7_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `JenisKelamin`='L'"));
					$dtrj7_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `JenisKelamin`='P'"));
					$dtrj8_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `JenisKelamin`='L'"));
					$dtrj8_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `JenisKelamin`='P'"));
					$dtrj9_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `JenisKelamin`='L'"));
					$dtrj9_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `JenisKelamin`='P'"));
					$dtrj10_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `JenisKelamin`='L'"));
					$dtrj10_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `JenisKelamin`='P'"));
					$dtrj11_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `JenisKelamin`='L'"));
					$dtrj11_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `JenisKelamin`='P'"));
					$dtrj12_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `JenisKelamin`='L'"));
					$dtrj12_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `JenisKelamin`='P'"));
					$dtttl_l = $dtrj1_l['Jml'] + $dtrj2_l['Jml'] + $dtrj3_l['Jml'] + $dtrj4_l['Jml'] + $dtrj5_l['Jml'] + $dtrj6_l['Jml'] + $dtrj7_l['Jml'] + $dtrj8_l['Jml'] + $dtrj9_l['Jml'] + $dtrj10_l['Jml'] + $dtrj11_l['Jml'] + $dtrj12_l['Jml'];
					$dtttl_p = $dtrj1_p['Jml'] + $dtrj2_p['Jml'] + $dtrj3_p['Jml'] + $dtrj4_p['Jml'] + $dtrj5_p['Jml'] + $dtrj6_p['Jml'] + $dtrj7_p['Jml'] + $dtrj8_p['Jml'] + $dtrj9_p['Jml'] + $dtrj10_p['Jml'] + $dtrj11_p['Jml'] + $dtrj12_p['Jml'];
					$dtttl = $dtttl_l + $dtttl_p;
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
						<td><?php echo rupiah($dtrj1_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj1_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj2_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj2_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj3_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj3_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj4_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj4_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj5_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj5_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj6_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj6_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj7_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj7_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj8_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj8_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj9_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj9_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj10_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj10_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj11_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj11_p['Jml']);?></td>
						<td><?php echo rupiah($dtrj12_l['Jml']);?></td>
						<td><?php echo rupiah($dtrj12_p['Jml']);?></td>
						<td><?php echo rupiah($dtttl);?></td>		
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