<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');	
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$pelayanankes = $_GET['pel'];
	$kunjungans = $_GET['kunj'];
	$keydate = $_GET['keydate'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Rup_Jkn (".$hariini.").xls");
	if(isset($keydate)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN RUP JKN</b></h4>
	<p  style="margin:5px;">Periode Laporan: Periode Laporan: <?php echo date('d-m-y', strtotime($keydate))?></p>
	<br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9px;">
				<tr style="border:1px solid #000;">
					<th width="2%">No.</th>
					<th width="5%">No.RM</th>
					<th width="10%">Nama Pasien</th>
					<th width="7%">Noka.Peserta</th>
					<th width="4%">Sex</th>
					<th width="4%">Umur</th>
					<th width="6%">Diagnosa</th>
					<th width="6%">Status Peserta</th>
					<th width="6%">Kunjungan</th>
					<th width="7%">Poli</th>
					<th width="4%">Rujuk</th>
					<th width="5%">Wilayah</th>
				</tr>
			</thead>
			<tbody style="font-size:9px;">
				<?php
				if($pelayanankes == 'Semua'){
					$pelayanan = '';
					
				}else{
					$pelayanan = " AND `PoliPertama`='$pelayanankes'";
				}
									
				if($kunjungans == 'Semua'){
					$skunjungan = '';
				}else{
					$skunjungan = " AND `StatusKunjungan`='$kunjungans'";
				}
				
				// tbpasienrj_bulan
				$str = "SELECT * FROM `$tbpasienrj`
				WHERE `TanggalRegistrasi` = '$keydate' AND SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND
				SUBSTRING(Asuransi,1,4) = 'BPJS'".$pelayanan.$skunjungan;
				$str2 = $str." ORDER BY `TanggalRegistrasi` DESC";
				// echo $str2;
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoRegistrasi'];
					$nocm = $data['NoCM'];
					$noindex = $data['NoIndex'];
					
					// tbpasien
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM`='$nocm'"));
					$normpasien = substr($dt_pasien['NoRM'],-6);							
										
					// umur
					$umur_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurBulan` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `NoRegistrasi`='$noregistrasi'"));
					$umur1_4 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '1' AND '4' AND `NoRegistrasi`='$noregistrasi'"));
					$umur5_14 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '5' AND '14' AND `NoRegistrasi`='$noregistrasi'"));
					$umur15_44 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '15' AND '44' AND `NoRegistrasi`='$noregistrasi'"));
					$umur45_54 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '45' AND '54' AND `NoRegistrasi`='$noregistrasi'"));
					$umur55_64 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '55' AND '64' AND `NoRegistrasi`='$noregistrasi'"));
					$umur55_65 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` > '64' AND `NoRegistrasi`='$noregistrasi'"));
					
					// ttv
					if($data['PoliPertama'] == 'POLI UMUM'){
						$bln = substr($noregistrasi,14,2);
						$tbpoliumum = 'tbpoliumum_'.$bln;
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoliumum` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI ANAK'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolianak` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI GIGI'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoligigi` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI KB'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikb` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI KIA'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikia` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI IMUNISASI'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoliimunisasi` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI LANSIA'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI MTBS'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI MTBM'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolimtbm` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI TB'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolitb` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}else if($data['PoliPertama'] == 'POLI UGD'){
						$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan`='$noregistrasi'"));
					}
					
					// rujukan
					$rujuk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusPulang` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi'"));
					if($rujuk['StatusPulang'] == '3'){
						$statusrujuk = 'T';
					}else{
						$statusrujuk = 'Y';
					}	

					// wilayah
					$wilayah = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Wilayah` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
					if($wilayah['Wilayah'] == 'Dalam'){
						$statuswilayah = 'Dalam';
					}else{
						$statuswilayah = 'Luar';
					}							
					
				?>
				<tr style="border:1px solid #000;">
					<td><?php echo $no;?></td>
					<td><?php echo $normpasien;?></td>
					<td><?php echo $data['NamaPasien'];?></td>
					<td><?php echo $data['nokartu'];?></td>
					<td><?php echo $data['JenisKelamin'];?></td>
					<td><?php echo $data['UmurTahun']." Th, ".$data['UmurBulan']." Bl";?></td>
					<td><?php if($dt_poli['Diagnosa'] != ''){echo $dt_poli['Diagnosa'];}else{echo '-';}?></td><!--diagnosa-->
					<td><?php echo $data['Asuransi'];?></td><!--jaminan / asuransi-->
					<td><?php echo $data['StatusKunjungan'];?></td><!--kunjungan-->
					<td><?php echo $data['PoliPertama'];?></td><!--poli-->
					<td><?php echo $statusrujuk;?></td><!--rujukan-->
					<td><?php echo $statuswilayah?></td><!--wilayah-->
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