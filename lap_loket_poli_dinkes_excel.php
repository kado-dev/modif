<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	// get data
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepkm = $_GET['kodepkm'];
	$tbpasienrj = "tbpasienrj_".$kodepkm;
	// $asalpasien = $_GET['asalpasien'];
	// $statuspasien = $_GET['statuspasien'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kunjungan_Poli (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>KUNJUNGAN PASIEN (POLI)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?><br/>
</div><br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
					<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PELAYANAN</th>
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
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tgl1 = 0;
				$str = "SELECT `Pelayanan` FROM `tbpelayanankesehatan` WHERE `Kota` = '$kota' AND `JenisPelayanan` = 'Kunjungan Sakit' ORDER BY Pelayanan";
				$query = mysqli_query($koneksi,$str);
				while($data = mysqli_fetch_array($query)){
					$no = $no + 1;
					$pelayanan = $data['Pelayanan'];
					
					if($pelayanan != ''){
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Pelayanan'];?></td>	
							<?php
								$jml = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT COUNT(NoRegistrasi) AS jumlah 
								FROM `$tbpasienrj`
								WHERE date(`TanggalRegistrasi`) = '$tanggal' AND `PoliPertama` = '$pelayanan'";
								// echo $strs;
								$count = mysqli_fetch_array(mysqli_query($koneksi,$strs));
								$jml = $jml + $count['jumlah'];
							?>	
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count['jumlah'];?></td>
							<?php }	?>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml;?></td>
						</tr>
					<?php
					}
				}
				?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
					<td style="text-align:right; border:1px solid #000; padding:3px;">Total</td>
					<?php
						$jmls = 0;
						for($d3= $mulai;$d3 <= $selesai; $d3++){	
						$tanggal = $thn."-".$bln."-".$d3;
						$strs2 = "SELECT COUNT(NoRegistrasi) as Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tanggal'";
						$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
						$jmls = $jmls + $countall['Jumlah'];
					?>	
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $countall['Jumlah'];?></td>
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