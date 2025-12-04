<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$nama = $_GET['nama'];
	$statuspasien = $_GET['statuspasien'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Gagal_Bridging_PCare_BPJS (".$keydate1.' s/d '.$keydate2.").xls");
	if(isset($keydate1) and isset($keydate2)){
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DATA PASIEN GAGAL BRIDGING PCARE BPJS</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
</div>

<div class="atastabel font14">
	<div style="float:left; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kelurahan);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="8%">TANGGAL</th>
					<th width="8%">NO.INDEX</th>
					<th width="15%">NAMA PASIEN</th>
					<th width="5%">L/P</th>
					<th width="10%">PELAYANAN</th>
					<th width="10%">NO.JAMINAN</th>
					<th>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$keydate1 = $_GET['keydate1'];
				$keydate2 = $_GET['keydate2'];
				$bulanini = date('m');
				$tahunini = date('Y');
				$nama = $_GET['nama'];	
				$plhbulan = $_GET['plhbulan'];
				$statuspasien = $_GET['statuspasien'];

				if($nama != null){
					$nama_str = " AND NamaPasien like '%$nama%'";
				}else{
					$nama_str = "";
				}
				
				if ($statuspasien == 'semua'){
					$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(Asuransi,1,4) = 'BPJS' AND TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2' AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` = ''".$nama_str." GROUP BY noKartu, StatusPasien";	
				}else{
					$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(Asuransi,1,4) = 'BPJS' AND TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2' AND StatusPasien = '$statuspasien' AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` = ''".$nama_str." GROUP BY noKartu";
				}		
				$str2 = $str." ORDER BY TanggalRegistrasi, NamaPasien";
				// echo $str2;
				// die();
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];

					if(strlen($noindex) == 24){
						$noindex2 = substr($data['NoIndex'],14);
					}else{
						$noindex2 = $data['NoIndex'];
					}
				?>
					<tr>
						<td style="text-align:right;"><?php echo $no;?></td>
						<td style="text-align:center;" class="str"><?php echo $data['TanggalRegistrasi'];?></td>
						<td style="text-align:center;" class="str"><?php echo $noindex2;?></td>
						<td style="text-align:left;" class="namakk"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:center;"><?php echo $data['JenisKelamin'];?></td>					
						<td style="text-align:center;"><?php echo $data['PoliPertama'];?></td>
						<td style="text-align:center;" class="str"><?php echo $data['nokartu'];?></td>
						<td style="text-align:center;"><?php echo $data['KeteranganBridging'];?></td>
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