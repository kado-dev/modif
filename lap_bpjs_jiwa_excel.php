<?php
	include "config/helper_pasienrj.php";
	include_once('config/koneksi.php');
	session_start();
	$hariini = date('d-m-Y');
	
	// get
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$sts_bpjs = $_GET['sts_bpjs'];
	$kodeppk = $_SESSION['kodeppk'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Bpjs_Jiwa (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BPJS JIWA</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kelurahan);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="6%">TANGGAL</th>
					<th rowspan="2" width="6%">NO.INDEX</th>
					<th rowspan="2" width="6%">NO.RM</th>
					<th rowspan="2" width="10%">NAMA PESERTA</th>
					<th rowspan="2" width="15%">ALAMAT</th>
					<th rowspan="2" width="3%">L/P</th>
					<th rowspan="2" width="5%">UMUR (TH)</th>
					<th rowspan="2" width="8%">POLI</th>
					<th colspan="2" width="15%">CARA BAYAR/JAMINAN/ASURANSI</th>
					<th rowspan="2" width="5%">KUNJUNGAN</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>JAMINAN</th>
					<th>NO.JAMINAN</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($sts_bpjs == 'semua'){
					$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(Asuransi,1,4) = 'BPJS' AND YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' AND `NoUrutBpjs` != ''";
				}else{
					$str = "SELECT * FROM `$tbpasienrj` WHERE Asuransi = '$sts_bpjs' AND YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' AND `NoUrutBpjs` != ''";
				}
				$str2 = $str." GROUP BY noKartu, StatusPasien ORDER BY Tanggalregistrasi, NamaPasien";
				// echo $str2;				
										
				$no = 0;
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$norm = $data['NoRM'];
					$asuransi = $data['Asuransi'];
					$noasuransi = $data['nokartu'];
									
					if(substr($asuransi,0,4) == 'BPJS'){
						$noasuransi = $data['nokartu'];
					}else{
						$noasuransi = "0";
					}
					
					// tbkk
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
					if($dtkk['Alamat'] != ""){
						$alamat = $dtkk['Alamat'].", RT.".$dtkk['RT']." Kel.".$dtkk['Kelurahan'];
					}else{
						$alamat = "-";
					}	
				
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalRegistrasi'];?></td>
						<td><?php echo substr($noindex,-5);?></td>
						<td><?php echo substr($norm,-6);?></td>
						<td><?php echo $data['NamaPasien'];?></td>
						<td><?php echo strtoupper($alamat);?></td>
						<td><?php echo $data['JenisKelamin'];?></td>
						<td><?php echo $data['UmurTahun'];?></td>
						<td><?php echo $data['PoliPertama'];?></td>
						<td><?php echo $data['Asuransi'];?></td>
						<td><?php echo $noasuransi;?></td>
						<td><?php echo strtoupper($data['StatusKunjungan']);?></td>	
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