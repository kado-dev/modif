<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$bulan = date('m', strtotime($_GET['keydate1']));
	$tahun = date('Y', strtotime($_GET['keydate1']));
	$sts_bpjs = $_GET['sts_bpjs'];
	$statuspasien = $_GET['statuspasien'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Tracking_Diagnosa (".$bulan.'-'.$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BPJS KUNJUNGAN (SAKIT & SEHAT)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></p>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="6%">TANGGAL</th>
					<th width="6%">NO.INDEX</th>
					<th width="15%">NAMA PASIEN</th>
					<th width="17%">ALAMAT</th>
					<th width="5%">UMUR (TH)</th>
					<th width="7%">DIAGNOSA</th>
					<th width="7%">PELAYANAN</th>
					<th width="10%">ASURANSI</th>
					<th width="10%">NOMOR KARTU</th>
					<th width="6%">KUNJUNGAN</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($sts_bpjs == 'semua'){
					if ($statuspasien == 'semua'){
						$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(Asuransi,1,4) = 'BPJS' AND date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2' AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' GROUP BY noKartu, StatusPasien";
					}else{
						$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(Asuransi,1,4) = 'BPJS' AND date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2' AND StatusPasien = '$statuspasien' AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' GROUP BY noKartu";
					}
				}else{
					if ($statuspasien == 'semua'){
						$str = "SELECT * FROM `$tbpasienrj` WHERE `Asuransi` = '$sts_bpjs' AND date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2' AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' GROUP BY noKartu, StatusPasien";
					}else{
						$str = "SELECT * FROM `$tbpasienrj` WHERE `Asuransi` = '$sts_bpjs' AND date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2' AND StatusPasien = '$statuspasien' AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' GROUP BY noKartu";
					}
				}	
				$str2 = $str." ORDER BY date(TanggalRegistrasi), NamaPasien";
				// echo $str2;
				
				$no = 0;				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$noregistrasi = $data['NoRegistrasi'];
					$asuransi = $data['Asuransi'];
					$nokartu = $data['nokartu'];
					
					// tbpoli
					$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi, $str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
											
					// cek rujukan
					$rujukan = $data['StatusPulang'];
					if($rujukan == "4"){
						$rujuklanjut = 'Ya';
					}else{
						$rujuklanjut = 'Tidak';
					}
					
					// tbkk
					$tbkk = "tbkk_".str_replace(' ', '', $namapuskesmas);
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
					if($dtkk['Alamat'] != ""){
						$alamat = $dtkk['Alamat'].", RT.".$dtkk['RT']." Kel.".$dtkk['Kelurahan'];
					}else{
						$alamat = "-";
					}	
							
					?>
						<tr style="border:0.3px solid #000;">
							<td style="text-align:right;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $data['TanggalRegistrasi'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex,-10);?></td>
							<td style="text-align:left;"><?php echo strtoupper($data['NamaPasien']);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat);?></td>
							<td style="text-align:center;"><?php echo $data['UmurTahun'];?></td>
							<td style="text-align:left;"><?php echo strtoupper($data_dgs);?></td>
							<td style="text-align:center;"><?php echo $data['PoliPertama'];?></td>
							<td style="text-align:center;"><?php echo $data['Asuransi'];?></td>
							<td style="text-align:center;"><?php echo $data['nokartu'];?></td>
							<td style="text-align:center;"><?php echo strtoupper($data['StatusKunjungan']);?></td>
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