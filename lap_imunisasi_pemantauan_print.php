<?php
session_start();
include "config/koneksi.php";
include "config/helper.php";
date_default_timezone_set('Asia/Jakarta');
?>
<html>
<head>
	<title>Laporan Registarsi Umum</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<style>
table {
    border-collapse: collapse;
}
.printheader{
	margin-top:30px;
	margin-left:px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
}
.btnprint{
	position:absolute;
	top:20px;
	right:20px;
}
@media print{
	.btnprint{
		display:none;
	}
}

</style>
</head>
<body onload="window.print()">
<a href="javascript:print()" class="btnprint btn btn-primary">Print</a>
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$tbpasienrj = 'tbpasienrj_'.$bulan;
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
?>
<!--tabel report-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpuskesmas'"));
	$kota = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota'"));
	?>
		<?php 
		if($_SESSION['kodepuskesmas'] == '-'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$_SESSION['kota'];?></b></h4>
			<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
			<p style="margin:5px;"><?php echo $_SESSION['alamat'];?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMANTAUAN IMUNISASI</b></h4>
		<p style="margin:1px;">Periode Laporan: <?php echo $bulan." ".$tahun;?></p>
		<br/>
</div>
<div class="table-responsive printbody">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px dashed #000;">
				<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
				<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Bayi</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama KK</th>
				<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">L/P</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
				<th colspan="10" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jenis Imunisasi Diberikan</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Ket</th>
			</tr>
			<tr style="border:1px dashed #000;">
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Bcg</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Hb0</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Dpt1</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Dpt2</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Dpt3</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio1</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio2</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio3</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio4</th>
				<th style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Campak</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<!--paging-->
			<?php
			$jumlah_perpage = 50;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$str = "SELECT * FROM `tbpoliimunisasi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE MONTH(a.TanggalPeriksa) = '$bulan' and YEAR(a.TanggalPeriksa) = '$tahun' and substring(a.NoPemeriksaan,1,11) = '$kdpuskesmas'";
			$str2 = $str."ORDER BY `TanggalPeriksa` Desc limit $mulai,$jumlah_perpage";
			// echo ($str);
			// die();
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$noregistrasi = $data['NoPemeriksaan'];
			$noindex = $data['NoIndex'];
			$anamnesa = $data['Anamnesa'];
			$kelamin = $data['JenisKelamin'];
			
			if(strlen($noindex) == 24){
				$noindex2 = substr($data['NoIndex'],14);
			}else{
				$noindex2 = $data['NoIndex'];
			}
			
			//tbkk
			$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
			$query_kk = mysqli_query($koneksi,$str_kk);
			$data_kk = mysqli_fetch_assoc($query_kk);
			
			//tbdiagnosapasien
			$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
			
			$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
			$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
			
			//cek umur kelamin
			if ($kelamin == 'L'){
				$umur_l = $data['UmurTahun']." thn";
				$umur_p = "-";
			}else{
				$umur_l = "-";
				$umur_p = $data['UmurTahun']." thn";
			}
			
			if($alamat != null){
				$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
			}else{
				$alamat = "-";
			}
			
			//cek rujukan
			$rujukan = $data['StatusPulang'];
			if ($rujukan == 3){
				$berobatjalan = '<span class="fa fa-check"></span>';
				$rujuklanjut = '-';
			}else if($rujukan == 4){
				$rujuklanjut = '<span class="fa fa-check"></span>';
				$berobatjalan = '-';
			}
			?>
				
			<?php
			
			//cek diagnosa pasien
			while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
				$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
			}
			if ($array_data[$no] != ''){
				$data_dgs = implode(",", $array_data[$no]);
			}else{
				$data_dgs ="";
			}
			

			// echo $data_dgs;
			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $noindex2;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $alamat;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $anamnesa;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--ket-->
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
</body>
</html>