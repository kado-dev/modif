<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$asalpasien = $_GET['asalpasien'];
	$statuspasien = $_GET['statuspasien'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_CaraBayar (".$hariini.").xls");
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
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
					<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">CARA BAYAR</th>
				<?php
					$bln = $_GET['bulan'];
					$thn = $_GET['tahun'];
					$mulai = 1;
					$selesai = 31;
					for($d = $mulai;$d <= $selesai; $d++){	

				?>
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
				<?php
					}
				?>
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$str = "SELECT * FROM `tbasuransi` ORDER BY `Asuransi` ASC";
					$query = mysqli_query($koneksi,$str);
					
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$asuransi = $data['Asuransi'];

						if ($asalpasien == 'semua'){
							$asalpasien1 = "";
						}else{
							$asalpasien1 = " AND `AsalPasien`='$asalpasien'";
						}
						
						if ($statuspasien == 'semua'){
							$statuspasien1 = "";
						}else{
							$statuspasien1 = " AND `StatusPasien`='$statuspasien'";
						}							
								
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>	
							<?php
							$jml = 0;	
							for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT COUNT(NoRegistrasi) as Jml from `$tbpasienrj` where date(`TanggalRegistrasi`) = '$tanggal' AND `Asuransi` = '$asuransi'".$asalpasien1.$statuspasien1;
								$count = mysqli_fetch_assoc(mysqli_query($koneksi, $strs));

								// dari daftar online (status asuransi hanya BPJS tidak dibedankan PBI atau NON PBI)
								$strs_2 = "SELECT COUNT(NoRegistrasi) as Jml from `$tbpasienrj` where date(`TanggalRegistrasi`) = '$tanggal' AND `Asuransi` = 'BPJS'".$asalpasien1.$statuspasien1;
								$count_2 = mysqli_fetch_assoc(mysqli_query($koneksi, $strs_2));

								if($data['Asuransi'] == 'BPJS PBI'){
									$jml_hari = $count['Jml'] + $count_2['Jml'];
									$jml = $jml + $count['Jml'] + $count_2['Jml'];
								}else{
									$jml_hari = $count['Jml'];
									$jml = $jml + $count['Jml'];
								}

								
							?>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_hari;?></td>
							<?php
								}
							?>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml;?></td>
						</tr>
					<?php
					}
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;">TOTAL</td>
						<?php
							$jmls = 0;
							for($d3= $mulai;$d3 <= $selesai; $d3++){	
							$tanggal = $thn."-".$bln."-".$d3;
							$strs2 = "SELECT COUNT(NoRegistrasi) as jumlah FROM `$tbpasienrj` where date(`TanggalRegistrasi`) = '$tanggal'".$asalpasien1.$statuspasien1;
							$countall = mysqli_fetch_assoc(mysqli_query($koneksi, $strs2));
							$jmls = $jmls + $countall['jumlah'];
						?>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $countall['jumlah'];?></td>
						<?php
							}
						?>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmls;?></td>
						</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>