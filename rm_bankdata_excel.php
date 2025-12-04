<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper_report.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	$tahun = $_GET['tahun'];
	$orderby = $_GET['orderby'];
	$key = $_GET['key'];
	$hariini = date('d-m-Y');
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_bank_data_pasien (".$hariini.").xls");
	// if(isset($tahun)){
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
.str{
	mso-number-format:\@; 
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>BANK DATA PASIEN</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tahun;?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th width="3%">NO.</th>
					<th width="7%">TGL.DAFTAR</th>
					<th width="7%">NO.INDEX</th>
					<th width="7%">NO.RM</th>
					<th width="10%">NIK</th>
					<th width="10%">NO.BPJS</th>
					<th width="15%">NAMA PASIEN</th>
					<th width="7%">TGL.LAHIR</th>
					<th width="15%">NAMA KK</th>
					<th width="25%">ALAMAT</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($tahun == "semua"){
					$thn = " ";	
				}else{
					$thn = " AND YEAR(TanggalDaftar)= '$tahun'";
				}
				
				$str = "SELECT * FROM `$tbpasien` 
				WHERE (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoAsuransi` like '%$key%')".$thn;
				$str2 = $str." ORDER BY ".$orderby." DESC";
				// echo $str2;
				
				$no = 0;
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
				
					// tbkk
					$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$noindex'";
					$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
					
					// ec_cities
					$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
					
					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
					
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalDaftar'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoIndex'],-10);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoRM'],-6);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="str"><?php echo $data['Nik'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="str"><?php echo $data['NoAsuransi'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalLahir'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $datakk['NamaKK'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat);?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
// }
?>