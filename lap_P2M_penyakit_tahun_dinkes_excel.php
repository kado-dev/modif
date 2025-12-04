<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	
	// get data
	$tahun = $_GET['tahun'];
	$kodebpjs = $_GET['kodebpjs'];
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Tracking_Tahun_Diagnosa (".$kodebpjs.' '.$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING DIAGNOSA (TAHUN)</b></h4>
	<p style="margin:1px;">PERIODE LAPORAN : <?php echo $tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th width="3%" rowspan="2">NO.</th>
					<th width="20%" rowspan="2">NAMA PUSKESMAS</th>
					<th colspan="12">JUMLAH DIAGNOSA <?php echo $_GET['kodebpjs'];?></th>
					<th width="10%" rowspan="2">TOTAL</th>
				</tr>
				<tr width="5%" style="border:1px solid #000;">
					<?php
					for($bln = 1; $bln <= 12;$bln++){
						echo "<th>".nama_bulan_singkat($bln)."</th>";
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
				$str = "SELECT * FROM `tbpuskesmas` WHERE NamaPuskesmas != 'DINAS KESEHATAN' AND NamaPuskesmas != 'UPTD FARMASI'";
				$str2 = $str." ORDER BY `NamaPuskesmas`";
				// echo $str2;
		
				$query = mysqli_query($koneksi, $str2);					
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kdpuskesmas = $data['KodePuskesmas'];
					$namapuskesmas = $data['NamaPuskesmas'];	
					$dt_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_01` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_02` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_03` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_04` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_05` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_06` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_07` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_08` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_09` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_10` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_l1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_11` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dt_l2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_12` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
					$dtttl = $dt_l['Jml'] + $dt_2['Jml'] + $dt_3['Jml'] + $dt_4['Jml'] + $dt_5['Jml'] + $dt_6['Jml'] + $dt_7['Jml'] + $dt_8['Jml'] + $dt_9['Jml'] + $dt_l0['Jml'] + $dt_l1['Jml'] + $dt_12['Jml'];
					
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_2['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_3['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_4['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_5['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_6['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_7['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_8['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_9['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l0['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l1['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l2['Jml']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtttl);?></td>	
					</tr>
				<?php
					$ttl_l = $ttl_l + $dt_l['Jml'];
					$ttl_2 = $ttl_2 + $dt_2['Jml'];
					$ttl_3 = $ttl_3 + $dt_3['Jml'];
					$ttl_4 = $ttl_4 + $dt_4['Jml'];
					$ttl_5 = $ttl_5 + $dt_5['Jml'];
					$ttl_6 = $ttl_6 + $dt_6['Jml'];
					$ttl_7 = $ttl_7 + $dt_7['Jml'];
					$ttl_8 = $ttl_8 + $dt_8['Jml'];
					$ttl_9 = $ttl_9 + $dt_9['Jml'];
					$ttl_10 = $ttl_l0 + $dt_l0['Jml'];
					$ttl_11 = $ttl_l1 + $dt_l1['Jml'];
					$ttl_12 = $ttl_l2 + $dt_l2['Jml'];
					$ttl = $ttl + $dtttl;
				}
				
				
				?>
				
				<tr style="border:1px solid #000;">
					<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
					<td style="text-align:center; border:1px solid #000; padding:3px;">Total</td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_2);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_3);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_4);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_5);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_6);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_7);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_8);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_9);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l0);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l1);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l2);?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl);?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>