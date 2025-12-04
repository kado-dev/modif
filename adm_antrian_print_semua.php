<?php
	session_start();
	include "config/koneksi.php";
	// include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	$opsiform = $_GET['opsiform'];
	$idantriian = $_GET['id'];
?>

<html lang="en">
<head>
	<title>Data Aplikasi Antrian</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_umum&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=adm_antrian'">
	<div class="printheader">
		<p class="font11" style="margin: 15px 5px 5px 5px;"><b>LAPORAN DATA ANTRIAN PASIEN (ISAP SIMPUS)</b><br/>Tanggal : <?php echo $tanggal;?></p>
		<hr style="margin:3px; border:1px solid #000">
	</div><br/>
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px solid #000;">
						<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PUSKESMAS</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TEKNISI</th>
						<th width="30%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SPESIFIKASI HARDWARE</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PELATIHAN</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$str = "SELECT * FROM `tbadm_antrian`";
					$str2 = $str." ORDER BY Puskesmas";
					// echo $str2;
					// die();
										
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
					?>
						<tr>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td align="left" style="border:1px solid #000; padding:3px;"><?php echo $data['Puskesmas'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['TeknisiPasang'];?></td>
							<td align="left" style="border:1px solid #000; padding:3px;"><?php echo $data['SpesifikasiHardware'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['Pelatihan'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>